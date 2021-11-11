@inject('PublicFunction', 'App\Http\Controllers\PublicFunction')
@extends('layouts.admin_layout')
@section('title')
    Igloo - view Slider
@endsection
@section('stylesheet')
@endsection

@section('content')
    <div class="dt-content-wrapper">

        <!-- Site Content -->
        <div class="dt-content">

            <!-- Page Header -->
            <div class="dt-page__header">
                <h1 class="dt-page__title">View Slider</h1>
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
                            @if($PublicFunction::checkPermission($userPermission, ["add_slider"]))
                                <div class="text-right mb-1">
                                    <a href="{{ route('admin.create-slider') }}" class="btn btn-primary"><i class="icon icon-plus"></i>Add Slider</a>
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
                                        <th width="10%">#ID</th>
                                        <th>Title</th>
                                        <th width="20%" >Image</th>
                                        <th>Description</th>
                                        <th>Button Color</th>
                                        @if($PublicFunction::checkPermission($userPermission, ["update_slider", "delete_slider"]))
                                            <th width="20%">Option</th>
                                        @endif
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $id = 0; ?>
                                    @foreach($sliders As $key => $value)
                                        <tr class="gradeX">
                                            <td>{{ ++$id }}</td>
                                            <td>{{ $value->title }}</td>
                                            <td><img src="{{ asset( $value->image) }}" alt="" style="width: 30%"></td>
                                            <td>{{ $value->des }}</td>
{{--                                            <td>{{ $value->overly_color }}</td>--}}
                                            <td>{{ $value->btn_name }}</td>
                                            @if($PublicFunction::checkPermission($userPermission, ["update_slider", "delete_slider"]))
                                                <td>
                                                    @if($PublicFunction::checkPermission($userPermission, ["update_slider"]))
                                                        <a href="{{ route('admin.edit-slider', $value->id) }}" class="btn btn-info btn-sm"><i class="icon icon-editors"></i></a>
                                                    @endif
                                                    @if($PublicFunction::checkPermission($userPermission, ["delete_slider"]))
                                                        <span class="btn btn-danger btn-delete btn-sm" data-id="{{ $value->id }}"><i class="icon icon-remove"></i></span>
                                                    @endif
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach

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
                    url: "{{ route('admin.delete-slider') }}",
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