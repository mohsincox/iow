@inject('PublicFunction', 'App\Http\Controllers\PublicFunction')
@extends('layouts.admin_layout')
@section('title')
    Igloo - View Gallery
@endsection
@section('content')
    <div class="dt-content-wrapper">

        <!-- Site Content -->
        <div class="dt-content">

            <!-- Page Header -->
            <div class="dt-page__header">
                <h1 class="dt-page__title">Galleries</h1>
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
                            @if($PublicFunction::checkPermission($userPermission, ["add_gallery"]))
                                <div class="text-right">
                                    <a href="{{route('admin.add-gallery')}}" class="btn btn-primary"><i class="icon icon-plus"></i> Add Gallery</a>
                                </div>
                            @endif
                        @if(session()->has('status'))
                            {!! session()->get('status') !!}
                        @endif

                        <!-- Tables -->
                            <div class="table">

                                <table id="data-table" class="table table-striped table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>#ID</th>
                                        <th>Image</th>
                                        <th>Title</th>
                                        @if($PublicFunction::checkPermission($userPermission, ["update_gallery", "delete_gallery"]))
                                            <th>Option</th>
                                        @endif
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $id = 0; ?>
                                    @foreach($galleris As $key => $value)
                                        <tr class="gradeX">
                                            <td>{{ ++$id }}</td>
                                            <td><img src="{{ asset($value['image'] ) }}" width="60px" height="60px" alt="image"></td>
                                            <td>{{ $value['title'] }}</td>
                                            @if($PublicFunction::checkPermission($userPermission, ["update_gallery", "delete_gallery"]))
                                                <td>
                                                    @if($PublicFunction::checkPermission($userPermission, ["update_gallery"]))
                                                        <a href="{{ route('admin.edit-gallery', $value['title_id'] ) }}" class="btn btn-info btn-sm"><i class="icon icon-editors"></i></a>
                                                    @endif
                                                    @if($PublicFunction::checkPermission($userPermission, ["delete_gallery"]))
                                                        <span class="btn btn-danger btn-delete btn-sm" data-id="{{ $value['title_id'] }}"><i class="icon icon-remove"></i></span>
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
          // console.log(pid)
          $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });
          $.ajax({
            url: "{{ route('admin.delete-gallery') }}",
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