@extends('admin.layouts.app')
@section('title', 'User Details')

@section('content')

<!--begin::Subheader-->
<div class="subheader py-2 py-lg-6  subheader-solid " id="kt_subheader">
    <div class=" container-fluid  d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <!--begin::Info-->
        <div class="d-flex align-items-center flex-wrap mr-1">
            <!--begin::Page Heading-->
            <div class="d-flex align-items-baseline flex-wrap mr-5">
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}" class="text-muted">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.users.index') }}" class="text-muted">Users</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">User Details</a>
                    </li>
                </ul>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page Heading-->

        </div>
        <!--end::Info-->
        <div class="d-flex align-items-center">
            <a class="btn btn-clean font-weight-bold btn-sm" href="{{ url()->previous() }}">
                <i class="ki ki-long-arrow-back icon-sm"></i>Back
            </a>
        </div>
    </div>
</div>
<!--end::Subheader-->

<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container ">
        <div class="row">
            <div class="col-md-12">
                <!--begin::Card-->
                <div class="card card-custom gutter-b example example-compact">
                    <!--begin::Form-->
                    <form id="users__form" class="kt-form" action="#" method="POST" enctype="multipart/form-data">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name">Name *</label>
                                        <input type="text" id="name" name="name" placeholder="Enter name" 
                                            class="form-control"
                                            disabled
                                            value="{{ $user->name }}"/>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="email">Email Address *</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="la la-at"></i></span></div>
                                            <input type="text" id="email" name="email" placeholder="Enter email address"
                                            class="form-control"
                                            disabled
                                            value="{{ $user->email }}"/>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label for="avatar">Avatar</label>

                                        <div class="custom-file">
                                            <input type="file" name="avatar" class="custom-file-input" disabled>
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    @php
                                        $file_path = config('constants.USER_DIR').$user->avatar;
                                        if($user->avatar != null && $user->avatar != '' && Storage::exists('public/'.$file_path)) {
                                            $avatar_url = Storage::url($file_path);
                                        } else {
                                            $avatar_url = 'https://via.placeholder.com/87x87?text=Avatar';
                                        }
                                    @endphp

                                    <img id="avatar_preview" src="{{ $avatar_url }}" alt="" height="87" width="87" style="margin-left: 5px; border-radius: 4px;">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <span class="switch switch-icon">
                                        <label>
                                            <input type="checkbox" name="status" disabled
                                                {{ (isset($user) && $user->status == 1)?'checked':'' }}
                                                >
                                            <span></span>
                                        </label>
                                        </span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Card-->
            </div>
        </div>
    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->

@endsection