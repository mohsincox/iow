@inject('PublicFunction', 'App\Http\Controllers\PublicFunction')
@extends('layouts.admin_layout')
@section('title')
    Igloo - Add Gallery
@endsection

@section('stylesheet')
    <link rel="stylesheet" href="{{ asset('admin/assets/css/multiselect.css') }}">


    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/4.0.0/css/jasny-bootstrap.min.css">
    <link href="{{ asset('default/assets/fromcdn/jasny-bootstrap.min.js') }}" />

@endsection


@section('content')
    <div class="dt-content-wrapper">

        <!-- Site Content -->
        <!-- Site Content -->
        <div class="dt-content">

            <!-- Page Header -->
            <div class="dt-page__header">
                <h1 class="dt-page__title">Add Gallery</h1>
            </div>
            <!-- /page header -->

            <!-- Grid -->
            <div class="row">
                <!-- Grid Item -->
                <div class="col-12">

                    <!-- Card -->
                    <div class="dt-card">

                        <!-- Card Header -->
                        <div class="dt-card__header">

                        </div>
                        <!-- /card header -->



                        <!-- Card Body -->
                        <div class="dt-card__body">
                            @if($PublicFunction::checkPermission($userPermission, ["view_gallery"]))
                                <div class="text-right">
                                    <a href="{{route('admin.view-gallery')}}" class="btn btn-primary"><i class="icon icon-breadcrumbs"> </i>view Gallery</a>
                                </div>
                            @endif
                            <div class="form-group form-row">
                                <div class="col-12">
                                    @if(session()->has('status'))
                                        {!! session()->get('status') !!}
                                    @endif
                                </div>
                            </div>

                            <!-- Form -->
                            <form method="post" action="{{route('admin.add-gallery')}}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-row form-parent-row">
                                    <div class="col-12 mb-6">
                                        <label>Title</label>
                                        <input type="text"  placeholder="Title"
                                               aria-label="Title" name="title" required value="{{old('title')}}" class="form-control @error('title') is-invalid @enderror ">
                                        @error('title')
                                        <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="fileinput fileinput-new input-group mb-6" data-provides="fileinput">
                                    <span class="input-group-append">
                                        <span class="input-group-text fileinput-exists" data-dismiss="fileinput">Remove</span>
                                        <span class="input-group-text btn-file">
                                          <span class="fileinput-new">Select photo</span>
                                          <span class="fileinput-exists">Change</span>
                                          <input type="file" name="image[]" multiple>
                                        </span>
                                    </span>
                                    <div class="form-control" data-trigger="fileinput">
                                        <span class="fileinput-filename"></span>
                                    </div>
                                </div>


                                <div class="form-group form-row">
                                    <div class="col-sm-12 col-md-2 offset-md-10 col-lg-2 offset-lg-10 pull-right">
                                        <div class="input-group">
                                            <input type="submit" name="submit" class="btn btn-primary" style="border: blanchedalmond;width: 100%;padding: 10px;border-radius: 5px;">
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <!-- /form -->

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

@endsection
