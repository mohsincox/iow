@extends('layouts.default_layout')

@section('content')
    <!-- image gallery start -->
    <div class="image_gallery mt-60 mb-60">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="title only-title">
                        <h1>Gallery</h1>
                    </div>
                </div>
            </div>
            @foreach($galleries As $key => $value)
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="text-center mt-3 mb-5 gallery_border_parent">
                            <h3 class="gallery_border">
                                {{ $value->title }}
                            </h3>
                        </div>
                        <div class="single_gallery">
                            <div class="fotorama" data-nav="thumbs" data-autoplay="true" data-click="true" data-transition="crossfade">
                                @foreach(explode(',', $value->image) As $link)
                                    <a href="#"><img src="{{asset($link)}}"></a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <!-- image gallery end -->

@endsection

@section('script')

@endsection