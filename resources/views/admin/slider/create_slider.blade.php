@inject('PublicFunction', 'App\Http\Controllers\PublicFunction')
@extends('layouts.admin_layout')
@section('title')
    Igloo - Create Slider
@endsection
@section('stylesheet')
    <link href="{{ asset('default/assets/fromcdn/bootstrap.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.css" rel="stylesheet">

@endsection

@section('content')
    <div class="dt-content-wrapper">

        <!-- Site Content -->
        <div class="dt-content">

            <!-- Page Header -->
            <div class="dt-page__header">
                <h3 class="dt-page__title">Create New Slide</h3>
            </div>
            <!-- /page header -->

            <!-- Grid -->
            <div class="row">

                <!-- Grid Item -->
                <div class="col-md-12 col-xl-12 col-sm-12">

                    <!-- Card -->
                    <div class="dt-card">

                        <!-- Card Header -->
                        <div class="dt-card__header">

                            <!-- Card Heading -->
                            <!-- /card heading -->

                        </div>
                        <!-- /card header -->

                        <!-- Card Body -->
                        <div class="dt-card__body">
                            @if($PublicFunction::checkPermission($userPermission, ["view_slider"]))
                                <div class="text-right">
                                    <a href="{{ route('admin.view-slider') }}" class="btn btn-primary"><i class="icon icon-breadcrumbs"></i>View Slider</a>
                                </div>
                            @endif
                            @if(session()->has('status'))
                                {!! session()->get('status') !!}
                            @endif
                        <!-- Form -->
                            <form action="{{route('admin.create-slider')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <!-- Form Group -->
                                <div class="form-group">
                                    <label>Slider Title</label>
                                    <input class="form-control" name="title" id="email-1" aria-describedby="emailHelp1" type="text" placeholder="Slide Title" >
                                </div>
                                <div class="form-group fileinput">
                                    <div class="custom-file">
                                        <label class="custom-file-label" for="email-1">Slide Image</label>
                                        <input  name="image" class="custom-file-input" id="file-field" type="file" required >
                                    </div>
                                </div>

                                <div class="text-left mt-4">
                                        <span class="avatar avatar-xl">
                                            <img src="#" id="image_upload_preview" alt=""
                                                 class="avatar-img " style=" width: 30%;">
                                            <span class="avatar-input-icon rounded-circle"></span>
                                        </span>
                                </div>
                                <!-- /form group -->
                                {{--<div class="form-group">--}}
                                    {{--<label for="email-1">Slide Overly color</label>--}}
                                    {{--<input class="form-control" name="overly_color" id="email-1" aria-describedby="emailHelp1" type="color" placeholder="Slide button link"  style="width: 200px;">--}}
                                {{--</div>--}}
                                <!-- Form Group -->
                                <div class="form-group mt-3">
                                    <label for="password-1">Description</label>
                                    <textarea class="form-control" id="summernote" name="des" type="text" placeholder="Write your recipe here...." ></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="email-1">Slide Button Name</label>
                                    <input class="form-control" name="btn_name" id="email-1" aria-describedby="emailHelp1" type="text" placeholder="Slide button name" >
                                </div>
                                <div class="form-group">
                                    <label for="email-1">Slide Button Link</label>
                                    <input class="form-control" name="btn_link" id="email-1" aria-describedby="emailHelp1" type="text" placeholder="Slide button link" >
                                </div>

                                <!-- Form Group -->
                                <div class="form-group mb-0">
                                    <button class="btn btn-primary text-uppercase" type="submit">Submit</button>
                                </div>
                                <!-- /form group -->


                            </form>
                            <!-- /form -->

                        </div>
                        <!-- /card body -->

                    </div>
                    <!-- /card -->

                </div>
                <!-- /grid item -->

            </div>
        </div>
        <!-- /site content -->

        <!-- Footer -->
        <footer class="dt-footer">
            Copyright Company Name © 2019
        </footer>
        <!-- /footer -->

    </div>
@endsection
@section('script')
    <script src="{{ asset('default/assets/fromcdn/jquery.js') }}"></script>
    <script src="{{ asset('default/assets/fromcdn/bootstrap.js') }}"></script>
    <script src="{{ asset('default/assets/fromcdn/summernote.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#summernote').summernote();
        });
    </script>
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#image_upload_preview').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
            console.log('dina');

        }

        $("#file-field").change(function () {
            console.log('clienton')
            readURL(this);
        });
    </script>
@endsection