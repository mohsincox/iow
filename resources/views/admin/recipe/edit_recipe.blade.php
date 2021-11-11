@extends('layouts.admin_layout')
@section('title')
    Igloo - Create New Recipe
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
                <h1 class="dt-page__title">Edit Recipe</h1>
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
                            <div class="dt-card__heading">
                                <h3 class="dt-card__title">Write your recipe</h3>
                            </div>
                            <!-- /card heading -->

                        </div>
                        <!-- /card header -->

                        <!-- Card Body -->
                        <div class="dt-card__body">
                        @if(session()->has('status'))
                            {!! session()->get('status') !!}
                        @endif
                        <!-- Form -->
                            <form action="{{route('admin.edit-recipe',$recipe->slug)}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <!-- Form Group -->
                                <div class="form-group">
                                    <label>Select Type</label>
                                    <div class="input-group">
                                        <select name="blog_type" required class="form-control @error('blog_type') is-invalid @enderror">
                                            <option value="" selected>Select a Type</option>
                                            <option value="recipe" @if($recipe->blog_type == "recipe") selected @endif>Recipe</option>
                                            <option value="article" @if($recipe->blog_type == "article") selected @endif>Article</option>
                                        </select>
                                        @error('blog_type')
                                        <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="email-1">Recipe Title</label>
                                    <input class="form-control" name="title" id="email-1" aria-describedby="emailHelp1" type="text" value="{{ $recipe->title }}" required>
                                </div>
                                <div class="form-group mt-3">
                                    <label for="password-1"> Short Description</label>
                                    <textarea class="form-control" id="summernote1" name="short_des" type="text" placeholder="Write your recipe here....">{{ $recipe->short_des }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="email-1">Recipe Image</label>
                                    <input class="form-control" name="image" id="file-field" aria-describedby="emailHelp1" type="file" value="{{$recipe->image}}">
                                </div>
                                <div class="text-left mt-4">
                                        <span class="avatar avatar-xl">
                                            <img src="{{ asset($recipe->image)}}" id="image_upload_preview" alt="..."
                                                 class="avatar-img " style=" width: 30%;">
                                            <span class="avatar-input-icon rounded-circle"></span>
                                        </span>
                                </div>
                                <!-- /form group -->

                                <!-- Form Group -->
                                <div class="form-group">
                                    <label for="password-1">Description</label>
                                    <textarea class="form-control" id="summernote" name="des" type="text" placeholder="Write your recipe here...." required>{{ $recipe->des }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>Select status</label>
                                        <div class="input-group">
                                            <select name="status" required class="form-control @error('category') is-invalid @enderror">
                                                <option value="" selected>Select a Status</option>
                                                <option value="Publish" @if($recipe->status == "Publish") selected @endif>Publish</option>
                                                <option value="Unpublish" @if($recipe->status == "Unpublish") selected @endif>Unpublish</option>
                                            </select>
                                        </div>
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
        $(document).ready(function() {
            $('#summernote1').summernote();
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