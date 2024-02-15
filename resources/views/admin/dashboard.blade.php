@extends('admin.layouts.app')
@section('title', 'Manage Categories')

@push('styles')
    <style type="text/css">

    </style>
@endpush

@section('content')

<div class="container-xl">
    <!-- Page title -->
    <div class="page-header d-print-none">
        <div class="row align-items-center">
            <div class="col">
                <!-- Page pre-title -->
                <h2 class="page-title">
                    Dashboard
                </h2>
            </div>
        </div>
    </div>
</div>
    
<div class="page-body">
  <div class="container-xl">
    <div class="row row-deck row-cards">
      
      <div class="col-lg-6">
        <div class="row row-cards">
          <div class="col-sm-4">
            <div class="card">
              <div class="card-body p-2 text-center">
                <div class="h1 m-0">43</div>
                <div class="text-muted mb-3">TOTAL Users</div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

@endsection

@push('footer_scripts')
<script type="text/javascript">

</script>
@endpush
