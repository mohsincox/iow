@extends('layouts.default_layout')

@section('content')
    <!--blog body area start-->
    <div class="blog_details mt-60">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <!--blog grid area start-->
                    <div class="blog_wrapper">
                        <article class="single_blog single_blog_details">
                            <figure>
                                <div class="post_header text-center pt-4">
                                    <h3 class="post_title">{{ $recipe_details->title }}</h3>
                                    <div class="blog_meta">
                                    </div>
                                </div>
                                <div class=" text-center mb-3">
                                    <img src="{{ asset($recipe_details->image) }}" alt="">
                                </div>
                                <p class="blog_content">
                                    <div class="post_content">
                                        {!! $recipe_details->des !!}
                                    </div>
                                </p>
                            </figure>
                        </article>
                    </div>
                    <!--blog grid area start-->
                </div>
            </div>
        </div>
    </div>
    <!--blog section area end-->
@endsection

@section('script')

@endsection