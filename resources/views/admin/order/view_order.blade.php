@inject('PublicFunction', 'App\Http\Controllers\PublicFunction')
@extends('layouts.admin_layout')
@section('title')
    Igloo - View Order
@endsection

@section('stylesheet')
    <link rel="stylesheet" href="{{ asset('default/assets/fromcdn/dataTables.checkboxes.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('default/assets/fromcdn/daterangepicker.css') }}" />
@endsection
@section('content')
    <div class="dt-content-wrapper">

        <!-- Site Content -->
        <div class="dt-content">

            <!-- Page Header -->
            <div class="dt-page__header">
                <h1 class="dt-page__title">Orders</h1>
            </div>
            <!-- /page header -->

            <!-- Grid -->
            <div class="row">

                <div class="col-xl-12 mb-4">
                    <div class="form-row">
                        <div class="col-sm-8 mb-3">
                            <label for="discount">Pick a date range</label>
                            <div class="input-group">
                                <input type="text" name="daterange" class="form-control datetimepicker-input" value="01/01/2018 - 01/15/2018" />
                            </div>
                        </div>
                        <div class="col-sm-4 mb-3">
                            <div class="input-group mt-6">
                                <button type="submit" class="btn btn-primary btn-search">Search</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Grid Item -->
                <div class="col-xl-12">
                    <!-- Card -->
                    <div class="dt-card">

                        <!-- Card Body -->
                        <div class="dt-card__body">
                            @if(session()->has('status'))
                                {!! session()->get('status') !!}
                            @endif

                        <!-- Tables -->
                            <div class="table pb-10">

                                <table id="data-table" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>#ID</th>
                                            <th>Customer Name</th>
                                            <th>Contact No</th>
                                            <th>Address</th>
                                            <th>Amount</th>
                                            <th>Coupon Code</th>
                                            <th>Discount</th>
                                            <th>Payment Type</th>
                                            <th>Payment Status</th>
                                            <th>Order Date</th>
                                            <th width="10%">Status</th>
                                            <th>Option</th>
                                        </tr>
                                    </thead>
                                </table>

                                @if($PublicFunction::checkPermission($userPermission, ["update_order"]))
                                    <div class="float-right m-1">
                                        <form action="{{ route('admin.order.change-multi-status') }}" method="POST" class="d-flex">
                                            @csrf
                                            <div id="multiError" class="m-3"></div>
                                            <select name="multiStatus" class="p-1 m-3 form-control" style="width: 120px">
                                                <option value="" selected>Select one</option>
                                                <option value="Pending">Pending</option>
                                                <option value="Processing">Processing</option>
                                                <option value="Delivered">Delivered</option>
                                                <option value="Completed">Completed</option>
                                                <option value="Cancelled">Cancelled</option>
                                                <option value="No Answer">No Answer</option>
                                            </select>
                                            <button type="button" style="width: 170px" class="btn btn-primary form-control m-3 multiBtn">Change multi status</button>
                                        </form>
                                    </div>
                                @endif

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

    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script src="https://gyrocode.github.io/jquery-datatables-checkboxes/1.2.9/js/dataTables.checkboxes.min.js"></script>

    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>


    <script>
        var tbl;
        $(document).ready( function () {
          $(document).on('change', 'select[name="status"]', function () {
            var val = $(this).val();
            if(val !== ""){
              $(this).closest('form').submit();
            }
          })

          $('input[name="daterange"]').daterangepicker({
            ranges: {
              'Today': [moment(), moment()],
              'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
              'Last 7 Days': [moment().subtract(6, 'days'), moment()],
              'Last 30 Days': [moment().subtract(29, 'days'), moment()],
              'This Month': [moment().startOf('month'), moment().endOf('month')],
              'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            alwaysShowCalendars: true,
            opens: "center",
            startDate: moment().startOf('hour').add(-15, 'day'),
            endDate: moment().endOf('hour').add(-1, 'day'),
            locale: {
              format: 'YYYY/MM/DD'
            }
          }, function(start, end, label) {
            // console.log("A new date selection was made: " + start.format('YYYY-MM-DD H:mm:ss') + ' to ' + end.format('YYYY-MM-DD H:mm:ss'));
          });



          // makeing server side data table
          tbl = $('#data-table').DataTable({
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "lengthMenu": [ 30, 50, 100 ],
            order: [[ 0, "desc" ]],
            "ajax":{
              "url": "{{ route('admin.order.data') }}",
              "dataType": "json",
              "type": "POST",
              "data":{ _token: "{{csrf_token()}}"}
            },

            'columnDefs': [
                {
                  'targets': 0,
                  'render': function(data, type, row, meta){
                    if(type === 'display'){
                        // selecting option
                      data = '<div class="checkbox" for="'+row.id+'"><input type="checkbox" id="'+row.id+'" name="tblRow[]" class="dt-checkboxes"><label></label></div>';
                    }
                    return data;
                  },
                  "orderable": false,
                  'checkboxes': {
                    'selectRow': true,
                    'selectAllRender': '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>'
                  }
                }, {
                  'targets': 11,
                  'render': function(data, type, row, meta){
                    const newData = row;
                    // console.log(row)
                    var mm = '';
                    if(type === 'display') {
                      const route = "{{ url('/dashboard/order/change-status')}}/" + newData.id;
                      // console.log(route)
                      const token = "{{csrf_token()}}";

                      mm = '<form action="' + route + '" method="GET">\n' +
                      '                                                        <input type="hidden" name="_token" value="'+token+'">\n' +
                      '                                                    <select name="status" class="p-1" style="width: 120px">\n' +
                      '                                                        <option value="" selected>Select one</option>\n'+
                      '                                                        <option value="Pending"' +
                        ( ( row.status == "Pending" ) ? 'selected' : '' )  + '>Pending</option>\n'+
                      '                                                        <option value="Processing" ' + ( (row.status === "Processing") ? "selected" : '' ) + '>Processing</option>\n' +
                      '                                                        <option value="Delivered" ' + ( (row.status === "Delivered") ? "selected" : '' ) + '>Delivered</option>\n' +
                      '                                                        <option value="Completed" ' + ( (row.status === "Completed") ? "selected" : '' ) + '>Completed</option>\n' +
                      '                                                        <option value="Cancelled" ' + ( (row.status === "Cancelled") ? "selected" : '' ) + '>Cancelled</option>\n' +
                      '                                                        <option value="No Answer" ' + ( (row.status === "No Answer") ? "selected" : '' ) + '>No Answer</option>\n' +
                        '                                                    </select>\n' +
                        '                                                    </form>'

                      // console.log(mm)
                    }
                    return mm;
                  },
                  "orderable": false,
                }, {
                  'targets': 12,
                  'render': function(data, type, row, meta){
                    const newData = row;
                    var mm = '';
                    if(type === 'display') {
                      const route = "{{ url('/dashboard/order-details')}}/" + newData.id;
                      // console.log(route)
                      const token = "{{csrf_token()}}";

                      mm = '<a href="'+route+'" class="btn btn-info btn-sm p-2">Details</a>'

                      // console.log(mm)
                    }
                    return mm;
                  },
                  "orderable": false,
                }
              ],

            "columns": [
              { "data": 'id'},
              { "data": 'id'},
              { "data": 'name'},
              { "data": 'phone'},
              { "data": 'address'},
              { "data": 'amount'},
              { "data": 'code'},
              { "data": 'discount'},
              { "data": 'payment_type'},
              { "data": 'payment_status'},
              { "data": 'order_date'},
              { "data": 'status'},
              { "data": 'option'},
            ],
            'select': 'multi',
            dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
            buttons: [
              { extend: 'excel',
                title: 'Order_Data',
                className: 'btn-sm',
                exportOptions: {
                  columns: [1,2,3,4,5,6,7,8,9,10,11],
                  format   : {
                    body : (data, row, col, node) => {
                      // if it is select
                      if (col == 10) {
                        return $(data).find("option:selected").text()
                      } else return data
                    }
                  }
                }
              },
              { extend: 'pdf',
                title: 'Order_Data',
                className: 'btn-sm',
                exportOptions: {
                  columns: [1,2,3,4,5,6,7,8,9,10,11],
                  format   : {
                    body : (data, row, col, node) => {
                      // if it is select
                      if (col == 10) {
                        return $(data).find("option:selected").text()
                      } else return data
                    }
                  }
                }
              },
              { extend: 'csv',
                title: 'Order_Data',
                className: 'btn-sm',
                exportOptions: {
                  columns: [1,2,3,4,5,6,7,8,9,10,11],
                  format   : {
                    body : (data, row, col, node) => {
                      // if it is select
                      if (col == 10) {
                        return $(data).find("option:selected").text()
                      } else return data
                    }
                  }
                }
              },
              { extend: 'print',
                className: 'btn-sm',
                exportOptions: {
                  columns: [1,2,3,4,5,6,7,8,9,10,11],
                  format   : {
                    body : (data, row, col, node) => {
                      // if it is select
                      if (col == 10) {
                        return $(data).find("option:selected").text()
                      } else return data
                    }
                  }
                }
              }
            ]

          });



          $('.btn-search').click(function () {
            tbl.destroy();
            const dateRange = $('input[name="daterange"]').val()
            console.log(dateRange)
            tbl = $('#data-table').DataTable({
              "responsive": true,
              "processing": true,
              "serverSide": true,
              "lengthMenu": [ 30, 50, 100 ],
              order: [[ 0, "desc" ]],
              "ajax":{
                "url": "{{ route('admin.order.data') }}",
                "dataType": "json",
                "type": "POST",
                "data":{ dateRange: dateRange, _token: "{{csrf_token()}}"}
              },
              'columnDefs': [
                {
                  'targets': 0,
                  'render': function(data, type, row, meta){
                    if(type === 'display'){
                      // selecting option
                      data = '<div class="checkbox" for="'+row.id+'"><input type="checkbox" id="'+row.id+'" name="tblRow[]" class="dt-checkboxes"><label></label></div>';
                    }
                    return data;
                  },
                  "orderable": false,
                  'checkboxes': {
                    'selectRow': true,
                    'selectAllRender': '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>'
                  }
                }, {
                  'targets': 11,
                  'render': function(data, type, row, meta){
                    const newData = row;
                    // console.log(row)
                    var mm = '';
                    if(type === 'display') {
                      const route = "{{ url('/dashboard/order/change-status')}}/" + newData.id;
                      // console.log(route)
                      const token = "{{csrf_token()}}";

                      mm = '<form action="' + route + '" method="GET">\n' +
                        '                                                        <input type="hidden" name="_token" value="'+token+'">\n' +
                        '                                                    <select name="status" class="p-1" style="width: 120px">\n' +
                        '                                                        <option value="" selected>Select one</option>\n'+
                        '                                                        <option value="Pending"' +
                        ( ( row.status == "Pending" ) ? 'selected' : '' )  + '>Pending</option>\n'+
                        '                                                        <option value="Processing" ' + ( (row.status === "Processing") ? "selected" : '' ) + '>Processing</option>\n' +
                        '                                                        <option value="Delivered" ' + ( (row.status === "Delivered") ? "selected" : '' ) + '>Delivered</option>\n' +
                        '                                                        <option value="Completed" ' + ( (row.status === "Completed") ? "selected" : '' ) + '>Completed</option>\n' +
                        '                                                        <option value="Cancelled" ' + ( (row.status === "Cancelled") ? "selected" : '' ) + '>Cancelled</option>\n' +
                        '                                                        <option value="No Answer" ' + ( (row.status === "No Answer") ? "selected" : '' ) + '>No Answer</option>\n' +
                        '                                                    </select>\n' +
                        '                                                    </form>'

                      // console.log(mm)
                    }
                    return mm;
                  },
                  "orderable": false,
                }, {
                  'targets': 12,
                  'render': function(data, type, row, meta){
                    const newData = row;
                    var mm = '';
                    if(type === 'display') {
                      const route = "{{ url('/dashboard/order-details')}}/" + newData.id;
                      // console.log(route)
                      const token = "{{csrf_token()}}";

                      mm = '<a href="'+route+'" class="btn btn-info btn-sm p-2">Details</a>'

                      // console.log(mm)
                    }
                    return mm;
                  },
                  "orderable": false,
                }
              ],

              "columns": [
                { "data": 'id'},
                { "data": 'id'},
                { "data": 'name'},
                { "data": 'phone'},
                { "data": 'address'},
                { "data": 'amount'},
                { "data": 'code'},
                { "data": 'discount'},
                { "data": 'payment_type'},
                { "data": 'payment_status'},
                { "data": 'order_date'},
                { "data": 'status'},
                { "data": 'option'},
              ],
              'select': 'multi',
              dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
              buttons: [
                { extend: 'excel',
                  title: 'Order_Data',
                  className: 'btn-sm',
                  exportOptions: {
                    columns: [1,2,3,4,5,6,7,8,9,10,11],
                    format   : {
                      body : (data, row, col, node) => {
                        // if it is select
                        if (col == 10) {
                          return $(data).find("option:selected").text()
                        } else return data
                      }
                    }
                  }
                },
                { extend: 'pdf',
                  title: 'Order_Data',
                  className: 'btn-sm',
                  exportOptions: {
                    columns: [1,2,3,4,5,6,7,8,9,10,11],
                    format   : {
                      body : (data, row, col, node) => {
                        // if it is select
                        if (col == 10) {
                          return $(data).find("option:selected").text()
                        } else return data
                      }
                    }
                  }
                },
                { extend: 'csv',
                  title: 'Order_Data',
                  className: 'btn-sm',
                  exportOptions: {
                    columns: [1,2,3,4,5,6,7,8,9,10,11],
                    format   : {
                      body : (data, row, col, node) => {
                        // if it is select
                        if (col == 10) {
                          return $(data).find("option:selected").text()
                        } else return data
                      }
                    }
                  },
                  orientation: 'landscape',
                  pageSize: 'LEGAL'
                },
                { extend: 'print',
                  className: 'btn-sm',
                  exportOptions: {
                    columns: [1,2,3,4,5,6,7,8,9,10,11],
                    format   : {
                      body : (data, row, col, node) => {
                        // if it is select
                        if (col == 10) {
                          return $(data).find("option:selected").text()
                        } else return data
                      }
                    }
                  }
                }
              ]});
          })


            // $(document).on( 'click', '#data-table tbody tr td:first-child', function (){
            // $(document).on( 'click', '#data-table tbody tr td div', function (){

          // table row selected
          //   $(document).on( 'change', '#data-table tbody tr td input[type="checkbox"]', function (){
          //       if($(this).prop('checked')) {
          //         $(this).closest('tr').attr('style', 'background-color: #acbad4;')
          //       }else{
          //         $(this).closest('tr').attr('style', 'background-color: none;')
          //       }
          //   })
            // // multiple order status dropdown change
            //   $(document).on('change', 'select[name="multiStatus"]', function () {
            //     var val = $(this).val();
            //     if(val !== ""){
            //       console.log($(this).closest('form').find('input'));
            //
            //     }
            //   })

            // multiple order status form submit
              $(document).on('click', '.multiBtn', function () {
                var selectedIds = tbl.columns().checkboxes.selected()[0];
                if(selectedIds.length > 0) {
                  var val = $('select[name="multiStatus"]').val();
                  if (val !== "") {
                    $(this).closest('form').append('<input type="hidden" value="' + selectedIds + '" name="order_ids">')
                    $(this).closest('form').submit();
                  } else {
                    $('#multiError').append('<div class="alert alert-warning alert-dismissible " role="alert">\n                                <strong>No Status Selected.</strong>.\n                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">\n                                <span aria-hidden="true">&times;</span>\n                              </button>\n                        </div>')
                  }
                }else{
                  $('#multiError').append('<div class="alert alert-warning alert-dismissible " role="alert">\n                                <strong>No Order Selected.</strong>.\n                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">\n                                <span aria-hidden="true">&times;</span>\n                              </button>\n                        </div>')
                }
              })
          });
          // function btnClicked() {
          //   var selectedIds = tbl.columns().checkboxes.selected()[0];
          // }
    </script>
@endsection