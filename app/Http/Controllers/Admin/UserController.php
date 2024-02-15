<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Models\User;
use App\Models\Role;
use App\Helpers\Comman;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.users.index');
    }

    public function getData(Request $request) {
        $users = User::orderBy('id', 'desc');

        return Datatables::of($users)
            ->addColumn('name', function ($user) {
                return '<a target="_blank" href="'.route('admin.users.show', base64_encode($user->id)).'">' . $user->name . '</a><span class="text-muted">' . $user->email . '</span>';
            })
            ->editColumn('status', function ($user) {
                $status = '';
                if ($user->status == 0) {
                    $status = '<span class="text-danger">Inactive</span>';
                } elseif ($user->status == 1) {
                    $status = '<span class="text-success">Active</span>';
                }
                return $status;
            })
            ->addColumn('actions', function ($user) {
                return '
                    <span>
                        <a href="'.route('admin.users.edit', base64_encode($user->id)).'" class="btn btn-sm btn-clean btn-icon mr-2" title="Edit details">
                            <span class="svg-icon svg-icon-md">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24"/>
                                        <path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) "/>
                                        <rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1"/>
                                    </g>
                                </svg>
                            </span>
                        </a>
                        <a data-remote="'. route('admin.users.destroy', base64_encode($user->id)) .'" class="btn btn-sm btn-clean btn-icon btn-delete" title="Delete">
                            <span class="svg-icon svg-icon-md">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24"/>
                                        <path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero"/>
                                        <path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"/>
                                    </g>
                                </svg>
                            </span>
                        </a>
                    </span>
                ';
            })
            ->rawColumns(['name', 'status', 'actions'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = new User();

        return view('admin.users.create',compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ];

        $messages = [
            'name.required' => 'Name is required.',
            'email.required' => 'Email Address is required.',
            'email.email' => 'Invalid email address.',
            'email.unique' => 'This email address already exists with another account.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 6 characters.'
        ];

        if ($request->hasFile('avatar')) {
            $rules = array_merge($rules, [
                'avatar' => 'image|mimes:jpeg,png,jpg|max:2048',
            ]);

            $messages = array_merge($messages, [
                'avatar.image' => 'Avatar must be an image.',
                'avatar.mimes' => 'Avatar must be a file of type: jpg, jpeg, png.',
                'avatar.max' => 'Avatar may not be greater than 2 MB.',
            ]);
        }

        $this->validate($request, $rules, $messages);

        $status = ($request->status) ? 1 : 0;
        
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'status' => $status,
        ];

        if ($request->hasFile('avatar')) {

            $directory = 'public/'.config('constants.USER_DIR');
            $thumbs_sizes = config('constants.USER_THUMBS_SIZE');

            $uploaded_file = $request->file('avatar');
            $imagename_without_extension = time();

            $picture_name = Comman::file_upload($uploaded_file, $imagename_without_extension, $directory, $thumbs_sizes);

            $data = array_merge($data, [
                'avatar' => $picture_name,
            ]);
        }

        $user = User::create($data);

        $role = Role::findByName('customer');

        $user->assignRole($role->id);

        if (!$user) {
          return redirect()->route('admin.users.create')->with('error', 'Something went wrong!');
        }

        return redirect()->route('admin.users.index')->with('success', 'User added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id = base64_decode($id);

        $user = User::findOrFail($id);

        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = base64_decode($id);

        $user = User::findOrFail($id);

        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $id = base64_decode($id);

        $user = User::findOrFail($id);

        $rules = [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'nullable|min:6'
        ];

        $messages = [
            'name.required' => 'Name is required.',
            'email.required' => 'Email Address is required.',
            'email.email' => 'Invalid email address.',
            'email.unique' => 'This email address already exists with another account.',
            'password.min' => 'Password must be at least 6 characters.'
        ];

        if ($request->hasFile('avatar')) {
            $rules = array_merge($rules, [
                'avatar' => 'image|mimes:jpeg,png,jpg|max:2048',
            ]);

            $messages = array_merge($messages, [
                'avatar.image' => 'Avatar must be an image.',
                'avatar.mimes' => 'Avatar must be a file of type: jpg, jpeg, png.',
                'avatar.max' => 'Avatar may not be greater than 2 MB.',
            ]);
        }

        $this->validate($request, $rules, $messages);

        $status = ($request->status) ? 1 : 0;

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'status' => $status,
        ];

        if ($request->password != '') {
            $data = array_merge($data, [
                'password' => $request->password,
            ]);
        }

        if ($request->hasFile('avatar')) {

            $directory = 'public/'.config('constants.USER_DIR');
            $thumbs_sizes = config('constants.USER_THUMBS_SIZE');

            // Remove old file
            if ($user->avatar != null) {
                Comman::file_remove($user->avatar, $directory, $thumbs_sizes);
            }

            $uploaded_file = $request->file('avatar');
            $imagename_without_extension = time();

            $picture_name = Comman::file_upload($uploaded_file, $imagename_without_extension, $directory, $thumbs_sizes);

            $data = array_merge($data, [
                'avatar' => $picture_name,
            ]);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'User updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id = base64_decode($id);

        $user = User::findOrFail($id);

        if($user->delete()) {
            return response()->json([
                'success' => true,
                'message' => 'Record has been deleted successfully.'
            ], 200);
        }
    }
}
