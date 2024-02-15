@extends('admin.layouts.app')
@section('title', 'Users')

@push('styles')
    <style type="text/css">
      @media (min-width: 992px) {
        .header-fixed.subheader-fixed.subheader-enabled .wrapper {
            padding-top: 65px;
        }        
      }
    </style>
@endpush

@section('content')

<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
   <!--begin::Container-->
   <div class=" container ">

      <!--begin::Card-->
      <div class="card card-custom">
         <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
               <h3 class="card-label">
                    Users
                  <span class="d-block text-muted pt-2 font-size-sm"><span id="total_records_count"></span> Total</span>
               </h3>
            </div>
            <div class="card-toolbar">
               <!--begin::Dropdown-->
               <div class="dropdown dropdown-inline mr-2">
                    <div class="input-icon">
                      <input type="text" class="form-control" placeholder="Search..." id="kt_datatable_search_query" />
                        <span><i class="flaticon2-search-1 text-muted"></i></span>
                    </div>
                  <!--end::Dropdown Menu-->
               </div>
               <!--end::Dropdown-->

               <!--begin::Button-->
               <a href="{{ route('admin.users.create') }}" class="btn btn-primary font-weight-bolder">
                  <span class="svg-icon svg-icon-md">
                     <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
                     <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                           <rect x="0" y="0" width="24" height="24"/>
                           <circle fill="#000000" cx="9" cy="15" r="6"/>
                           <path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3"/>
                        </g>
                     </svg>
                     <!--end::Svg Icon-->
                  </span>
                  New Record
               </a>
               <!--end::Button-->

            </div>
         </div>
         <div class="card-body">

            <!--begin: Datatable-->
            <div class="datatable datatable-bordered datatable-head-custom" id="users__table"></div>
            <!--end: Datatable-->

         </div>
      </div>
      <!--end::Card-->
   </div>
   <!--end::Container-->
</div>
<!--end::Entry-->

@endsection

@push('footer_scripts')
<script type="text/javascript">

    $(function() {
      
      var datatable = $('#users__table').KTDatatable({
        // datasource definition
        data: {
            type: 'remote',
            source: {
                read: {
                    url: '{!! route('admin.users.data') !!}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
            },
            pageSize: 10,
            serverPaging: true,
            serverSorting: true,
        },

        // layout definition
        layout: {
            scroll: false,
            footer: false,
        },

        // column sorting
        sortable: false,

        pagination: true,

        search: {
            input: $('#kt_datatable_search_query'),
            key: 'generalSearch'
        },

        // columns definition
        columns: [ {
          field: 'name',
          title: 'Name'
        }, {
          field: 'email',
          title: 'Email Address'
        }, {
          field: 'status',
          title: 'Status'
        }, {
          field: 'actions',
          title: 'Actions',
          sortable: false,
          width: 125,
          overflow: 'visible',
          autoHide: false
        }]
      });
      
      datatable.on('datatable-on-layout-updated', function() {
        $("#total_records_count").text(datatable.getTotalRows());
      });

      $(document).on('click', '.btn-delete', function (e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var url = $(this).attr('data-remote');

            swal.fire({
                title: "Are you sure?",
                text: 'Are you sure you want to delete this record?',
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#ed5565',
                confirmButtonText: 'Yes, Delete Record',
            }).then(function (result) {
                if (result.value) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        dataType: 'json'
                    }).always(function (res) {
                        if(res.success) {
                            datatable.reload();
                            toastr.success(res.message, { timeout: 5000 });
                        } else {
                            swal.fire({
                              title: "Opps!",
                              text: 'Something went wrong, Please try again.',
                              type: "error",
                              showCancelButton: false
                            }).then(function (result) {
                                location.reload();
                            });
                        }
                    });
                }
            });
        });
    });
</script>
@endpush