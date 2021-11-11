@inject('PublicFunction', 'App\Http\Controllers\PublicFunction')
@extends('layouts.admin_layout')
@section('title')
    Igloo - View Purchase Discount
@endsection
@section('content')
    <div class="dt-content-wrapper">

        <!-- Site Content -->
        <div class="dt-content">

            <!-- Page Header -->
            <div class="dt-page__header">
                <h1 class="dt-page__title">Purchase Discounts</h1>
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
                            <div class="text-right">
                                @if($PublicFunction::checkPermission($userPermission, ["add_purchase_discount"]))
                                    <a href="{{ route('admin.add-purchase-discount') }}" class="btn btn-primary mb-1">
                                        <i class="icon icon-plus"></i>Add Purchase Discount</a>
                                @endif
                                @if(session()->has('status'))
                                    {!! session()->get('status') !!}
                                @endif
                            </div>
                        <!-- Tables -->
                            <div class="table">

                                <table id="data-table" class="table table-striped table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>#ID</th>
                                        <th>Offer Type</th>
                                        <th>Number of Purchase</th>
                                        <th>Purchase start date</th>
                                        <th>Purchase end date</th>
                                        <th>Discount</th>
                                        <th>Expire Date</th>
                                        @if($PublicFunction::checkPermission($userPermission, ["update_purchase_discount", "delete_purchase_discount"]))
                                            <th width="15%">Action</th>
                                        @endif
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $id = 0; ?>
                                    @foreach($purchaseDiscounts As $key => $value)
                                        <tr class="gradeX">
                                            <td>{{ ++$id }}</td>
                                            <td>{{ $value->offer_type}}</td>
                                            <td>{{ $value->number_of_purchase }}</td>
                                            <td>{{ isset($value->purchase_start_date) ? date('j M Y h:i:s A ', strtotime($value->purchase_start_date)) : "N/A" }}</td>
                                            <td>{{ isset($value->purchase_end_date) ? date('j M Y h:i:s A ', strtotime($value->purchase_end_date)) : "N/A" }}</td>
                                            <td>{{ $value->discount }}</td>
                                            <td>{{ date('j M Y h:i:s A ', strtotime($value->expire_date)) }}</td>
                                            @if($PublicFunction::checkPermission($userPermission, ["update_purchase_discount", "delete_purchase_discount"]))
                                                <td>
                                                    @if($PublicFunction::checkPermission($userPermission, ["update_purchase_discount"]))
                                                        <a href="{{ route('admin.edit-purchase-discount', $value->id) }}" class="btn btn-info btn-sm">
                                                            <i class="icon icon-editors"></i>
                                                        </a>
                                                    @endif
                                                    @if($PublicFunction::checkPermission($userPermission, ["delete_purchase_discount"]))
                                                        <span class="btn btn-danger btn-delete btn-sm" data-id="{{ $value->id }}">
                                                            <i class="icon icon-remove"></i>
                                                        </span>
                                                    @endif
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                    </tbody>
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

    <script>
      $(document).ready( function () {
        $('#data-table').dataTable();
        $(document).on('click', '.btn-delete', function () {
          var $this = $(this);
          var pid = $this.data('id');
          console.log(pid)
          $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });
          $.ajax({
            url: "{{ route('admin.delete-purchase-discount') }}",
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