@extends('admin.layouts.app')
@section('title', 'Edit User')

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
                        <a href="" class="text-muted">Edit User</a>
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
                    <form id="users__form" class="kt-form" action="{{ route('admin.users.update', base64_encode($user->id)) }}" method="POST" enctype="multipart/form-data">
                    	{{ method_field('PATCH') }}
                        @csrf
                        @include ('admin.users._form', ['formMode' => 'edit'])
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