@extends('layouts.default_layout')


@section('stylesheet')
    <style>
        .not_found{
            height: 100%;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 60px;
            flex-direction: column;
        }

        .not_found img{
            width: 300px;
            opacity: .5;
        }

        .not_found h1{
            margin-top: 30px;
            text-align: center;
            background: -webkit-linear-gradient(#f6707b, #ab1d69);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-size: 30px;
            text-transform: uppercase;
        }
    </style>
@endsection
@section('content')
    <!--blog area start-->
    <div class="blog_page_section mt-60">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="title only-title">
                        <h1>New Blogs</h1>
                    </div>
                </div>
            </div>
            <div class="row">
                @if(!empty($recipes) && $recipes->count())
                    @foreach($recipes as $recipe)
                    <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mb-4">

                        <article class="single_blog">
                            <figure>
                                <div class="blog_thumb">
                                    <a href="{{ route('get-recipe-details',$recipe->slug) }}"><img src="{{asset($recipe->thumbnail_image)}}" alt=""></a>
                                </div>
                                <figcaption class="blog_content">
                                    <h3 class="post_title text-center mb-3"><a href="{{ route('get-recipe-details',$recipe->slug) }}">{{ $recipe->title }}</a></h3>
                                    <div class="post_title text-center">{!! $recipe->short_des !!} </div></figcaption>
                                <div class="blog_content_footer">
                                    <!-- <div class="like"><a href="#"><img src="./assets/img/icon/like.svg" alt="like"></a><span>10</span></div> -->
                                    <div class="read_more mb-3"><a href="{{ route('get-recipe-details',$recipe->slug) }}">Read More <span><i class="fa fa-long-arrow-right"></i></span></a></div>
                                </div>
                            </figure>
                        </article>
                    </div>
                    @endforeach
                @else
                    <div class="not_found text-center">
                        <img src="{{ asset('default/assets/img/service/not_foud.jpg') }}" alt="not found">
                        <h1>No Blog  found</h1>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <!--blog area end-->

    <!--blog pagination area start-->
    <div class="blog_pagination">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="pagination">
                        <ul>
                            {!! $recipes->links() !!}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--blog pagination area end-->
@endsection

@section('script')

@endsection