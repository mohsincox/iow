@inject('PublicFunction', 'App\Http\Controllers\PublicFunction')
@extends('layouts.admin_layout')
@section('title')
    Igloo - View User
@endsection
@section('content')
    <div class="dt-content-wrapper">

        <!-- Site Content -->
        <div class="dt-content">

            <!-- Page Header -->
            <div class="dt-page__header">
                <h1 class="dt-page__title">Data Table</h1>
            </div>
            <!-- /page header -->

            <!-- Grid -->
            <div class="row">

                <!-- Grid Item -->
                <div class="col-xl-12">
                    <!-- Card -->
                    <div class="dt-card">

                        <!-- Card Body -->
                        <div class="dt-card__body">
                            @if($PublicFunction::checkPermission($userPermission, ["add_user"]))
                                <div class="text-right mb-1">
                                    <a href="{{ route('admin.add-user') }}" class="btn btn-primary"><i class="icon icon-plus"></i>Add User</a>
                                </div>
                            @endif
                            @if(session()->has('status'))
                                {!! session()->get('status') !!}
                            @endif

                            <!-- Tables -->
                            <div class="table-responsive">

                                <table id="data-table" class="table table-striped table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>#ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Role</th>
                                        <th>Created At</th>
                                        @if($PublicFunction::checkPermission($userPermission, ["update_user", "delete_user"]))
                                            <th>Option</th>
                                        @endif
                                    </tr>
                                    </thead>
                                </table>

                            </div>
                            <!-- /tables -->

                        </div>
                        <!-- /card body -->

                    </div>
                    <!-- /card -->

                </div>
                <!-- /grid item -->

            </div>
            <!-- /grid -->

        </div>
        <!-- /site content -->

        <!-- Footer -->
        <footer class="dt-footer">
            Copyright Igloo  © 2019
        </footer>
        <!-- /footer -->

    </div>
@endsection

@section('script')
    <script src="{{asset('admin/node_modules/datatables.net/js/jquery.dataTables.js')}}"></script>
    <script src="{{asset('admin/node_modules/datatables.net-bs4/js/dataTables.bootstrap4.js')}}"></script>
    
    
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>

    <script>
        $(document).ready( function () {
            $('#data-table').dataTable({
                "responsive": true,
                "processing": true,
                "serverSide": true,
                "ajax":{
                    "url": "{{ route('admin.ajax.fetch.user') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data":{ _token: "{{csrf_token()}}"}
                },
              order: [[ 0, "desc" ]],
                dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
                "columns": [
                    { "data": 'id'},
                    { "data": 'name'},
                    { "data": 'email'},
                    { "data": 'phone'},
                    { "data": 'role_name'},
                    { "data": 'created_at'},
                    { "data": 'option'},
                ],
                'columnDefs':[
                    {
                        'targets': 6,
                        'render': function(data, type, row, meta){
                            const newData = row;
                            var btnEdit = '';
                            if(type === 'display') {
                                const route = "{{ url('/dashboard/edit-user/')}}/" + newData.id;
                                // console.log(route)
                                const token = "{{csrf_token()}}";

                                btnEdit = '<a href="'+route+'" class="btn btn-info btn-sm">\n' +
                                    '                                                       <i class="icon icon-editors"></i></a>';
                                btnEdit += '<span class="btn btn-danger btn-delete btn-sm" data-id="'+newData.id+'">\n' +
                                    '                                                        <i class="icon icon-remove"></i>\n' +
                                    '                                                    </span>';

                                // console.log(mm)
                            }
                            return btnEdit;
                        },
                        "orderable": false,
                    }
                ],
              buttons: [
                { extend: 'excel',
                  title: 'User_list',
                  className: 'btn-sm',
                  exportOptions: {
                    columns: [0,1,2,3,4,5],
                    format   : {
                      body : (data, row, col, node) => {
                        return data
                      }
                    }
                  },
                  pageSize: 'LEGAL'
                },
                { extend: 'pdf',
                  title: 'User_list',
                  className: 'btn-sm',
                  exportOptions: {
                    columns: [0,1,2,3,4,5],
                    format   : {
                      body : (data, row, col, node) => {
                        return data
                      }
                    }
                  },
                  pageSize: 'LEGAL'
                },
                { extend: 'csv',
                  title: 'User_list',
                  className: 'btn-sm',
                  exportOptions: {
                    columns: [0,1,2,3,4,5],
                    format   : {
                      body : (data, row, col, node) => {
                        return data
                      }
                    }
                  },
                  pageSize: 'LEGAL'
                },
                { extend: 'print',
                  className: 'btn-sm',
                  exportOptions: {
                    columns: [0,1,2,3,4,5],
                    format   : {
                      body : (data, row, col, node) => {
                        return data
                      }
                    }
                  }
                }
              ]
            });
            $(document).on('click', '.btn-delete', function () {
                var $this = $(this);
                var pid = $this.data('id');
                // console.log(pid)
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('admin.delete-user') }}",
                    method: "post",
                    dataType: "html",
                    data: {id: pid},
                    success: function (data) {
                        // console.log(data)
                        if (data === "success"){
                            $this.closest('tr').css('background-color', 'red').fadeOut();
                        }
                    }
                });
            });

        } );
    </script>
@endsection