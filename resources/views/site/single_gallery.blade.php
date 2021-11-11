@extends('layouts.default_layout')

@section('content')
    <!-- image gallery start -->
    <div class="image_gallery mt-60 mb-60">
        @if($gallery != null)
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="title only-title">
                        <h1>Gallery</h1>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="text-center mt-3 mb-5 gallery_border_parent">
                        <h3 class="gallery_border">
                            {{ $gallery->title }}
                        </h3>
                    </div>
                    <div class="single_gallery">
                        <div class="fotorama" data-nav="thumbs" data-autoplay="true" data-click="true" data-transition="crossfade">
                            @foreach(explode(',', $gallery->image) As $link)
                                <a href="#"><img src="{{asset($link)}}"></a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
            <div class="container">
                <div class="row">
                    <span>No Gallery Found</span>
                </div>
            </div>
        @endif
    </div>
    <!-- image gallery end -->

@endsection

@section('script')

@endsection