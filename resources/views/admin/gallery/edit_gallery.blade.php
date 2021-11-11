@extends('layouts.admin_layout')
@section('title')
Igloo - Edit Gallery
@endsection

@section('stylesheet')
<link rel="stylesheet" href="{{ asset('admin/assets/css/multiselect.css') }}">

<link href="{{ asset('default/assets/fromcdn/jasny-bootstrap.min.js') }}" />
<script src="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/4.0.0/js/jasny-bootstrap.min.js"></script>

@endsection
@section('content')

<div class="dt-content-wrapper">

    <!-- Site Content -->
    <!-- Site Content -->
    <div class="dt-content">

        <!-- Page Header -->
        <div class="dt-page__header">
            <h1 class="dt-page__title">Edit Gallery</h1>
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
                        <div class="form-group form-row">
                            <label class="col-md-2 col-sm-3 col-form-label text-sm-right"></label>
                            <div class="col-md-10 col-sm-9">
                                @if(session()->has('status'))
                                {!! session()->get('status') !!}
                                @endif
                            </div>
                        </div>

                        <!-- Form -->
                        <form method="post" action="{{route('admin.edit-gallery', $galleryTitle->id)}}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-row form-parent-row">
                                <div class="col-sm-4 col-md-6 mb-6">
                                    <label>Title</label>
                                    <input type="text"  placeholder="Title"
                                           aria-label="Title" name="title" required value="{{ $galleryTitle->title }}" class="form-control @error('title') is-invalid @enderror ">
                                    @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row mb-6">
                                @foreach($galleryTitelHasImage As $key => $url)
                                    <div class="col-md-3 text-center image-area">
                                        <img src="{{ asset($url->image) }}" height="175px" width="75%" alt="imag" class="mb-2">
                                        <span class="btn btn-outline-danger btn-sm remove-gallery-image mb-6" data-id="{{ $url->id }}" data-image="{{ $url->image }}">Remove</span>
                                    </div>
                                @endforeach
                            </div>
                            <div class="fileinput fileinput-new input-group mb-6" data-provides="fileinput">
                                    <span class="input-group-append">
                                        <span class="input-group-text fileinput-exists" data-dismiss="fileinput">Remove</span>
                                        <span class="input-group-text btn-file">
                                          <span class="fileinput-new">New Gallery Image</span>
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
                                        <input type="submit" name="submit" style="border: blanchedalmond;width: 100%;padding: 10px;border-radius: 5px;" class="btn btn-primary">
                                    </div>
                                </div>
                            </div>
                            <!-- /form row -->




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

<script>
   $(document).ready(function() {

     $.ajaxSetup({
       headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       }
     });

     $(document).on('click', '.remove-gallery-image', function () {
       var $this = $(this);
       var product_id = $this.data('id');
       var image = $this.data('image');
       // console.log(image)
       $.ajax({
         url: "{{ route('admin.delete-gallery-image') }}",
         method: "post",
         dataType: "html",
         data: { image: image, image_id: product_id },
         success: function (data) {
           // console.log(data)
           if (data === "success"){
             $this.closest('.image-area').css('background-color', 'red').fadeOut();
           }
         }
       });
     });

   });
</script>
@endsection