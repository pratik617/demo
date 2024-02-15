<div class="card-body">
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<label for="name">Name *</label>
				<input type="text" id="name" name="name" placeholder="Enter name" 
                    class="form-control{{ $errors->has('name') ? ' is-invalid' : ''}}"
                    value="{{ old('name', $user->name) }}"/>
				{!! $errors->first('name', '<div class="invalid-feedback">:message</div>') !!}
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
						class="form-control{{ $errors->has('email') ? ' is-invalid' : ''}}"
						value="{{ old('email', $user->email) }}"/>
                    {!! $errors->first('email', '<div class="invalid-feedback">:message</div>') !!}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="password">Password @if($formMode === 'create')*@endif</label>
				<input type="password" id="password" name="password" placeholder="Enter password" 
                    class="form-control{{ $errors->has('password') ? ' is-invalid' : ''}}"
                    value=""/>
				{!! $errors->first('password', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
    </div>

	<div class="row">
		<div class="col-md-10">
			<div class="form-group">
				<label for="avatar">Avatar</label>

                <div class="custom-file">
                    <input type="file" name="avatar" class="custom-file-input{{ $errors->has('avatar') ? ' is-invalid' : ''}}">
                    <label class="custom-file-label" for="customFile">Choose file</label>
                    {!! $errors->first('avatar', '<div class="invalid-feedback">:message</div>') !!}
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
                        <input type="checkbox" name="status"
                            {{ ($formMode === 'create') ? 'checked' : ((isset($user) && $user->status == 1)?'checked':'') }}
                            >
                        <span></span>
                    </label>
                </span>
            </div>
        </div>
    </div>

</div>

<div class="card-footer">
    <button type="submit" class="btn btn-primary mr-2">{{ $formMode === 'edit' ? 'Update' : 'Create' }}</button>
    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
</div>

@push('footer_scripts')
<script type="text/javascript">

	
</script>
@endpush
