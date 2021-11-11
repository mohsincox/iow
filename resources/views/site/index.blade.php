@extends('layouts.default_layout')


@section('stylesheet')
    {{-- react start--}}
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('default/assets/css/animate.css') }}" rel="stylesheet">

    {{--react end--}}
@endsection
@section('content')

    <!--slider area start-->
    <section class="slider_section mb-70">
        <div class="slider_area owl-carousel">
            @foreach($slider as $slide)
            <div class="single_slider d-flex align-items-center" data-bgimg="{{asset($slide->image)}}">
                <div class="slider_overlay"></div>
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 col-md-6 offset-md-6 col-lg-6 offset-lg-7">
                            <div class="slider_content">
                                <h1>{{ (isset($slide->title))? $slide->title : "" }}</h1>
                                <h2 style="color: #f6ff08;">{!! (isset($slide->des))? $slide->des : "" !!}</h2>
                                @if($slide->btn_name)
                                <a class="button" href="{{ (isset($slide->btn_link))? $slide->btn_link : "" }}" style="background: #fff; color: #BD2AA7;">{{ (isset($slide->btn_name))? $slide->btn_name : "" }}</a>
                                    @else
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    <!--slider area end-->

    <!--buy one area start-->
    <div class="banner_area mb-46 wow fadeInUp">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="title">
                        <h1>Choose your flavors</h1>
                        <h3>Which Falvor are You Craving Today?</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="buy_one_carousel owl-carousel">
                        <a href="{{ route('products',['flavor' =>'chocolate']) }}">
                            <div class="single_buy_one">
                                <div class="buy_one_img card-img-top">
                                    <img data-src="{{asset('default/assets/img/product/choklet.jpg')}}" class="lazyload" alt="">
                                </div>
                                <div class="buy_one_content text-center">
                                    <h4 class="mb-0">Chocolate</h4>
                                </div>
                                <div class="buy_one_overlay"></div>
                            </div>
                        </a>
                        {{--<a href="{{ route('products',['flavor=2']) }}">--}}
                            {{--<div class="single_buy_one">--}}
                                {{--<div class="buy_one_img card-img-top">--}}
                                    {{--<img src="{{asset('default/assets/img/product/strowberry.jpg')}}" alt="">--}}
                                {{--</div>--}}
                                {{--<div class="buy_one_content text-center">--}}
                                    {{--<h4 class="mb-0">Strawberry</h4>--}}
                                {{--</div>--}}
                                {{--<div class="buy_one_overlay"></div>--}}
                            {{--</div>--}}
                        {{--</a>--}}
                        <a href="{{ route('products',['flavor' => 'vanilla']) }}">
                            <div class="single_buy_one">
                                <div class="buy_one_img card-img-top">
                                    <img data-src="{{asset('default/assets/img/product/valina.jpg')}}" class="lazyload" alt="">
                                </div>
                                <div class="buy_one_content text-center">
                                    <h4 class="mb-0">Vanilla</h4>
                                </div>
                                <div class="buy_one_overlay"></div>
                            </div>
                        </a>
                        <a href="{{ route('products',['flavor'=> 'mango']) }}">
                            <div class="single_buy_one">
                                <div class="buy_one_img card-img-top">
                                    <img data-src="{{asset('default/assets/img/product/mango.jpg')}}" class="lazyload" alt="">
                                </div>
                                <div class="buy_one_content text-center">
                                    <h4 class="mb-0">Mango</h4>
                                </div>
                                <div class="buy_one_overlay"></div>
                            </div>
                        </a>
                        {{--new add--}}
                        <a href="{{ route('products',['flavor' => 'ambrosia']) }}">
                            <div class="single_buy_one">
                                <div class="buy_one_img card-img-top">
                                    <img data-src="{{asset('default/assets/img/product/flavor/Ambrosia-Cream.jpg')}}" class="lazyload" alt="">
                                </div>
                                <div class="buy_one_content text-center">
                                    <h4 class="mb-0">Ambrosia</h4>
                                </div>
                                <div class="buy_one_overlay"></div>
                            </div>
                        </a>
                        <a href="{{ route('products',['flavor' => 'banana']) }}">
                            <div class="single_buy_one">
                                <div class="buy_one_img card-img-top">
                                    <img data-src="{{asset('default/assets/img/product/flavor/Banana-Ice-Cream.jpg')}}" class="lazyload" alt="">
                                </div>
                                <div class="buy_one_content text-center">
                                    <h4 class="mb-0">Banana</h4>
                                </div>
                                <div class="buy_one_overlay"></div>
                            </div>
                        </a>
                        <a href="{{ route('products',['flavor' => 'butter-scotch']) }}">
                            <div class="single_buy_one">
                                <div class="buy_one_img card-img-top">
                                    <img data-src="{{asset('default/assets/img/product/flavor/Butter-Scotch-Ice-Cream-2.jpg')}}" class="lazyload" alt="">
                                </div>
                                <div class="buy_one_content text-center">
                                    <h4 class="mb-0">Butter Scotch</h4>
                                </div>
                                <div class="buy_one_overlay"></div>
                            </div>
                        </a>
                        <a href="{{ route('products',['flavor' =>'coffee']) }}">
                            <div class="single_buy_one">
                                <div class="buy_one_img card-img-top">
                                    <img data-src="{{asset('default/assets/img/product/flavor/Coffee-Ice-Cream-2.jpg')}}" class="lazyload" alt="">
                                </div>
                                <div class="buy_one_content text-center">
                                    <h4 class="mb-0">Coffee</h4>
                                </div>
                                <div class="buy_one_overlay"></div>
                            </div>
                        </a>
                        {{--lll--}}
                        <a href="{{ route('products',['flavor'=>'deshi-dessert']) }}">
                            <div class="single_buy_one">
                                <div class="buy_one_img card-img-top">
                                    <img data-src="{{asset('default/assets/img/product/flavor/Deshi-Dessert-Ice-Cream.jpg')}}" class="lazyload" alt="">
                                </div>
                                <div class="buy_one_content text-center">
                                    <h4 class="mb-0">Deshi-Dessert</h4>
                                </div>
                                <div class="buy_one_overlay"></div>
                            </div>
                        </a>
                        <a href="{{ route('products',['flavor'=> 'dual']) }}">
                            <div class="single_buy_one">
                                <div class="buy_one_img card-img-top">
                                    <img data-src="{{asset('default/assets/img/product/flavor/Dual-Ice-Cream.jpg')}}" class="lazyload" alt="">
                                </div>
                                <div class="buy_one_content text-center">
                                    <h4 class="mb-0">Dual</h4>
                                </div>
                                <div class="buy_one_overlay"></div>
                            </div>
                        </a>
                        <a href="{{ route('products',['flavor' => 'lemon']) }}">
                            <div class="single_buy_one">
                                <div class="buy_one_img card-img-top">
                                    <img data-src="{{asset('default/assets/img/product/flavor/Lemon-Ice-Cream.jpg')}}" class="lazyload" alt="">
                                </div>
                                <div class="buy_one_content text-center">
                                    <h4 class="mb-0">Lemon</h4>
                                </div>
                                <div class="buy_one_overlay"></div>
                            </div>
                        </a>
                        <a href="{{ route('products',['flavor' => 'malai']) }}">
                            <div class="single_buy_one">
                                <div class="buy_one_img card-img-top">
                                    <img data-src="{{asset('default/assets/img/product/flavor/Malai-Ice-Cream.jpg')}}" class="lazyload" alt="">
                                </div>
                                <div class="buy_one_content text-center">
                                    <h4 class="mb-0">Malai</h4>
                                </div>
                                <div class="buy_one_overlay"></div>
                            </div>
                        </a>
                        <a href="{{ route('products',['flavor'=>'malted']) }}">
                            <div class="single_buy_one">
                                <div class="buy_one_img card-img-top">
                                    <img data-src="{{asset('default/assets/img/product/flavor/Malted-Ice-Cream.jpg')}}" class="lazyload" alt="">
                                </div>
                                <div class="buy_one_content text-center">
                                    <h4 class="mb-0">Malted</h4>
                                </div>
                                <div class="buy_one_overlay"></div>
                            </div>
                        </a>
                        <a href="{{ route('products',['flavor'=>'strawberry']) }}">
                            <div class="single_buy_one">
                                <div class="buy_one_img card-img-top">
                                    <img data-src="{{asset('default/assets/img/product/flavor/Strawberry-Ice-Cream.jpg')}}" class="lazyload" alt="">
                                </div>
                                <div class="buy_one_content text-center">
                                    <h4 class="mb-0">Strawberry</h4>
                                </div>
                                <div class="buy_one_overlay"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--buy one area end-->

    <!--product area start-->
    @if(count($product) > 0)
        <section class="product_area wow fadeInUp mb-46" id ="homeproductarea" data-product="{{ $product }}" data-category="{{ $category }}" data-path="{{asset('')}}">
        </section>
    @endif

    <!-- package area -->
@if(count($packages) > 0)
    <section class="package_area mb-46 wow fadeInUp">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="title only-title mt-4">
                        <h1>Packages</h1>
                    </div>
                </div>
            </div>
            <div class="packages owl-carousel">
                @foreach($packages as $package)
                <figure class="card">
                    <div class="product_thumb">
                        <a class="primary_img packages_thumb_img card-img-top" href="{{ route('product-details',$package->slug) }}" ><img src="{{ asset($package->thumbnail_image) }}" alt=""></a>
                    </div>
                    <figcaption class="product_content card-body mb-4">
                        <h3 class="product_name"><a href="{{ route('product-details',$package->slug) }}">{{ $package->name }}</a></h3>
                        <div class="price_box">
                            <span class="old_price">{{ (isset($package->selling_price)) ? 'TK '.$package->price : "" }}</span>
                            <span class="current_price">{{ (isset($package->selling_price)) ? 'TK '.$package->selling_price : 'TK '.$package->price }}</span>
                        </div>
                        <p class="mt-2 mb-3"><a class="block-with-multiline-text" href="{{ route('product-details',$package->slug) }}">{{ $package->description }}</a></p>
                    </figcaption>
                    <div class="add_to_cart">
                        <a class="shopping_cart_link mr-2" id="{{ $package->id }}"
                            data-image="{{ $package->thumbnail_image }}" data-name="{{ $package->name }}"
                            data-price="{{ (isset($package->selling_price)) ? $package->selling_price : $package->price }}"
                            data-quantity="{{ $package->quantity }}">

                            <!-- Generator: Adobe Illustrator 22.1.0, SVG Export Plug-In . SVG Version: 6.00 Build 0)  -->
                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                 viewBox="0 0 24 19.7" style="enable-background:new 0 0 24 19.7;" xml:space="preserve">
                                <style type="text/css">
                                    .st0{fill:#FFFFFF;}
                                </style>
                                <g>
                                    <path class="st0" d="M24,2.7c0-0.5-0.3-1-0.8-1.1c-0.2-0.1-0.5-0.1-0.7-0.1c-0.8,0-1.7,0-2.5,0c-4.1,0-10.8,0-15,0
                                        c0-0.1-0.1-0.3-0.1-0.4c-0.2-0.6-0.5-0.9-1.1-1C3.6,0,3.5,0,3.3,0H0.4C0.2,0.1,0.1,0.2,0,0.4v0.2C0.1,0.9,0.3,1,0.6,1
                                        c0.7,0,1.4,0,2.2,0c0.5,0,1,0.4,1.1,0.8C4.4,3.6,5,5.4,5.5,7.2c0.4,1.5,0.9,2.9,1.3,4.4c0.1,0.5,0.3,1,0.5,1.5
                                        c0.5,0.9,1.3,1.4,2.4,1.4c3,0,6,0,9.1,0c0,0,0.1,0,0.1,0c0.3,0,0.5-0.2,0.5-0.5c0-0.3-0.2-0.5-0.5-0.5c-3.1,0-6.1,0-9.2,0
                                        c-0.8,0-1.6-0.7-1.7-1.5h0.2c3.5,0,7,0,10.5,0c0.1,0,0.3,0,0.4,0c0.6,0,1.1-0.3,1.4-0.8c0.2-0.3,0.3-0.6,0.5-0.9
                                        c1-2.1,1.9-4.2,2.9-6.4C23.9,3.5,24,3.1,24,2.7z"/>
                                    <path class="st0" d="M18.8,15c-1.3,0-2.3,1-2.3,2.3c0,1.3,1.1,2.3,2.3,2.3s2.3-1.1,2.3-2.3C21.2,16.1,20.1,15,18.8,15z M18.8,18.4
                                            c-0.5,0-1-0.5-1-1s0.5-1,1-1s1,0.5,1,1S19.4,18.4,18.8,18.4z"/>
                                    <g>
                                        <path class="st0" d="M9.3,15C8,15,7,16.1,7,17.3c0,1.3,1,2.3,2.3,2.3s2.3-1,2.3-2.3C11.7,16.1,10.6,15,9.3,15z M9.3,18.4
                                            c-0.5,0-1-0.5-1-1s0.5-1,1-1c0.5,0,1,0.5,1,1S9.9,18.4,9.3,18.4z"/>
                                    </g>
                                </g>
                                </svg>
                            <span>Add to cart</span></a>
                        <a class="shopping_cart_link_details" href="{{ route('product-details',$package->slug) }}"><span>View Details</span></a>
                    </div>
                </figure>
                @endforeach

            </div>
        </div>
    </section>
@endif
    <!-- end package area -->

@if(count($bestSells) > 0)
    <section class="product_area mb-46 wow fadeInUp">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="title mt-4">
                        <h1>Find Ice-cream which people like the most</h1>
                        <h3>Top selling</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="product_bg top_sell top_sell_side_banner">
            <div class="container">
                <div class="product_carousel product_column5 owl-carousel">
                    @foreach($bestSells as $key => $val)
                        <article class="top_selling single_product">
                            <figure>
                                <div class="product_thumb">
                                    <a class="primary_img" href="{{ route('product-details', $val->slug) }}"><img data-src="{{ asset($val->thumbnail_image) }}" class="lazyload" alt=""></a>
                                </div>
                                <figcaption class="product_content mb-5">
                                    <h3 class="product_name"><a href="{{ route('product-details', $val->slug) }}">{{ $val->name }}</a></h3>
                                    <div class="price_box">
                                        <span class="old_price">{{ (isset($val->selling_price)) ? 'TK '.$val->price : "" }}</span>
                                        <span class="current_price">{{ (isset($val->selling_price)) ? 'TK '.$val->selling_price : 'TK '.$val->price }}</span>
                                    </div>
                                </figcaption>
                            </figure>
                            <div class="add_to_cart">
                                <a class="shopping_cart_link mr-2" id="{{$val->id}}" data-image="{{ $val->thumbnail_image }}" data-name="{{ $val->name }}" data-price="{{ (isset($val->selling_price)) ? $val->selling_price : $val->price }}" data-quantity="{{ $val->quantity }}">
                                    <!-- Generator: Adobe Illustrator 22.1.0, SVG Export Plug-In . SVG Version: 6.00 Build 0)  -->
                                    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                         viewBox="0 0 24 19.7" style="enable-background:new 0 0 24 19.7;" xml:space="preserve">
                                                <style type="text/css">
                                                    .st0{fill:#FFFFFF;}
                                                </style>
                                        <g>
                                            <path class="st0" d="M24,2.7c0-0.5-0.3-1-0.8-1.1c-0.2-0.1-0.5-0.1-0.7-0.1c-0.8,0-1.7,0-2.5,0c-4.1,0-10.8,0-15,0
                                                        c0-0.1-0.1-0.3-0.1-0.4c-0.2-0.6-0.5-0.9-1.1-1C3.6,0,3.5,0,3.3,0H0.4C0.2,0.1,0.1,0.2,0,0.4v0.2C0.1,0.9,0.3,1,0.6,1
                                                        c0.7,0,1.4,0,2.2,0c0.5,0,1,0.4,1.1,0.8C4.4,3.6,5,5.4,5.5,7.2c0.4,1.5,0.9,2.9,1.3,4.4c0.1,0.5,0.3,1,0.5,1.5
                                                        c0.5,0.9,1.3,1.4,2.4,1.4c3,0,6,0,9.1,0c0,0,0.1,0,0.1,0c0.3,0,0.5-0.2,0.5-0.5c0-0.3-0.2-0.5-0.5-0.5c-3.1,0-6.1,0-9.2,0
                                                        c-0.8,0-1.6-0.7-1.7-1.5h0.2c3.5,0,7,0,10.5,0c0.1,0,0.3,0,0.4,0c0.6,0,1.1-0.3,1.4-0.8c0.2-0.3,0.3-0.6,0.5-0.9
                                                        c1-2.1,1.9-4.2,2.9-6.4C23.9,3.5,24,3.1,24,2.7z"/>
                                            <path class="st0" d="M18.8,15c-1.3,0-2.3,1-2.3,2.3c0,1.3,1.1,2.3,2.3,2.3s2.3-1.1,2.3-2.3C21.2,16.1,20.1,15,18.8,15z M18.8,18.4
                                                            c-0.5,0-1-0.5-1-1s0.5-1,1-1s1,0.5,1,1S19.4,18.4,18.8,18.4z"/>
                                            <g>
                                                <path class="st0" d="M9.3,15C8,15,7,16.1,7,17.3c0,1.3,1,2.3,2.3,2.3s2.3-1,2.3-2.3C11.7,16.1,10.6,15,9.3,15z M9.3,18.4
                                                            c-0.5,0-1-0.5-1-1s0.5-1,1-1c0.5,0,1,0.5,1,1S9.9,18.4,9.3,18.4z"/>
                                            </g>
                                        </g>
                                                </svg>
                                    <span>Add to cart</span></a>
                                <a  class="shopping_cart_link_details" href="{{ route('product-details',$val->slug) }}"><span>View Details</span></a>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endif

@if(count($recipies) > 0)
    <section class="blog_section mb-46 wow fadeInUp">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="title only-title mt-4">
                        <h1>Recipes</h1>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="blog_carousel blog_column4 owl-carousel">
                        @foreach($recipies as $recipe)
                            <article class="single_blog">
                                <figure>
                                    <div class="blog_thumb">
                                        <a href="{{ route('get-recipe-details',$recipe->slug) }}" class="blog_thumb_img"><img data-src="{{asset($recipe->thumbnail_image)}}" class="lazyload" alt=""></a>
                                    </div>
                                    <figcaption class="blog_content">
                                        <h3 class="post_title text-center mb-3"><a href="{{ route('get-recipe-details',$recipe->slug) }}">{{ $recipe->title }}</a></h3>
                                        <div class="post_title text-center">{!! $recipe->short_des !!} </div></figcaption>
                                    <div class="blog_content_footer">
                                        <div class="read_more mb-3"><a href="{{ route('get-recipe-details',$recipe->slug) }}">Read More <span><i class="fa fa-long-arrow-right"></i></span></a></div>
                                    </div>
                                </figure>
                            </article>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--blog area end-->
@endif
    <!--gallery area start-->
@if(count($galleries) > 0 )
    <div class="gallery_area mb-46 wow fadeInUp">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="title only-title mt-4">
                        <h1>Gallery</h1>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="gallery owl-carousel">
                        @foreach($galleries As $key => $val)
                            <a href="{{ route('igloo-single-gallery', $val['title_id']) }}">
                                <div class="single_gallery gallery_category">
                                    <div class="gellery_img card-img-top">
                                        <img data-src="{{asset($val['image'])}}"  class="lazyload" alt="{{ $val['title'] }}">
                                    </div>
                                    <div class="gallery_content text-center">
                                        <h4 class="mb-0">{{ $val['title'] }}</h4>
                                    </div>
                                    <div class="gallery_overlay"></div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--gallery area end-->
@endif

    <!-- social media area -->
    {{--<section class="social-media-area wow fadeInUp">--}}
        {{--<div class="container">--}}
            {{--<div class="row">--}}
                {{--<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">--}}
                    {{--<div class="title only-title mt-4">--}}
                        {{--<h1>Social Media</h1>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<div class="row">--}}
                {{--<div class="col-sm-12 col-md-12 col-lg-4 col-xl-4">--}}
                    {{--<div class="social-media-plugin">--}}
                        {{--<img src="{{asset('default/assets/img/logo/facebook.png')}}" alt="facebook">--}}
                        {{--<div class="fb-page" data-href="https://www.facebook.com/AML.IGLOO/" data-tabs="timeline" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/AML.IGLOO/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/AML.IGLOO/">Igloo Ice Cream</a></blockquote></div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="col-sm-12 col-md-12 col-lg-4 col-xl-4 social-media-instagram">--}}
                    {{--<div class="social-media-plugin">--}}
                        {{--<img src="{{asset('default/assets/img/logo/instagram.png')}}" alt="instagram">--}}
                        {{--<blockquote class="instagram-media" data-instgrm-captioned data-instgrm-permalink="https://www.instagram.com/p/B7iM7kVlUY7/?utm_source=ig_embed&amp;utm_campaign=loading" data-instgrm-version="12" style=" background:#FFF; border:0; border-radius:3px; box-shadow:0 0 1px 0 rgba(0,0,0,0.5),0 1px 10px 0 rgba(0,0,0,0.15); margin: 1px; max-width:540px; min-width:326px; padding:0; width:99.375%; width:-webkit-calc(100% - 2px); width:calc(100% - 2px);"><div style="padding:16px;"> <a href="https://www.instagram.com/p/B7iM7kVlUY7/?utm_source=ig_embed&amp;utm_campaign=loading" style=" background:#FFFFFF; line-height:0; padding:0 0; text-align:center; text-decoration:none; width:100%;" target="_blank"> <div style=" display: flex; flex-direction: row; align-items: center;"> <div style="background-color: #F4F4F4; border-radius: 50%; flex-grow: 0; height: 40px; margin-right: 14px; width: 40px;"></div> <div style="display: flex; flex-direction: column; flex-grow: 1; justify-content: center;"> <div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; margin-bottom: 6px; width: 100px;"></div> <div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; width: 60px;"></div></div></div><div style="padding: 19% 0;"></div> <div style="display:block; height:50px; margin:0 auto 12px; width:50px;"><svg width="50px" height="50px" viewBox="0 0 60 60" version="1.1" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g transform="translate(-511.000000, -20.000000)" fill="#000000"><g><path d="M556.869,30.41 C554.814,30.41 553.148,32.076 553.148,34.131 C553.148,36.186 554.814,37.852 556.869,37.852 C558.924,37.852 560.59,36.186 560.59,34.131 C560.59,32.076 558.924,30.41 556.869,30.41 M541,60.657 C535.114,60.657 530.342,55.887 530.342,50 C530.342,44.114 535.114,39.342 541,39.342 C546.887,39.342 551.658,44.114 551.658,50 C551.658,55.887 546.887,60.657 541,60.657 M541,33.886 C532.1,33.886 524.886,41.1 524.886,50 C524.886,58.899 532.1,66.113 541,66.113 C549.9,66.113 557.115,58.899 557.115,50 C557.115,41.1 549.9,33.886 541,33.886 M565.378,62.101 C565.244,65.022 564.756,66.606 564.346,67.663 C563.803,69.06 563.154,70.057 562.106,71.106 C561.058,72.155 560.06,72.803 558.662,73.347 C557.607,73.757 556.021,74.244 553.102,74.378 C549.944,74.521 548.997,74.552 541,74.552 C533.003,74.552 532.056,74.521 528.898,74.378 C525.979,74.244 524.393,73.757 523.338,73.347 C521.94,72.803 520.942,72.155 519.894,71.106 C518.846,70.057 518.197,69.06 517.654,67.663 C517.244,66.606 516.755,65.022 516.623,62.101 C516.479,58.943 516.448,57.996 516.448,50 C516.448,42.003 516.479,41.056 516.623,37.899 C516.755,34.978 517.244,33.391 517.654,32.338 C518.197,30.938 518.846,29.942 519.894,28.894 C520.942,27.846 521.94,27.196 523.338,26.654 C524.393,26.244 525.979,25.756 528.898,25.623 C532.057,25.479 533.004,25.448 541,25.448 C548.997,25.448 549.943,25.479 553.102,25.623 C556.021,25.756 557.607,26.244 558.662,26.654 C560.06,27.196 561.058,27.846 562.106,28.894 C563.154,29.942 563.803,30.938 564.346,32.338 C564.756,33.391 565.244,34.978 565.378,37.899 C565.522,41.056 565.552,42.003 565.552,50 C565.552,57.996 565.522,58.943 565.378,62.101 M570.82,37.631 C570.674,34.438 570.167,32.258 569.425,30.349 C568.659,28.377 567.633,26.702 565.965,25.035 C564.297,23.368 562.623,22.342 560.652,21.575 C558.743,20.834 556.562,20.326 553.369,20.18 C550.169,20.033 549.148,20 541,20 C532.853,20 531.831,20.033 528.631,20.18 C525.438,20.326 523.257,20.834 521.349,21.575 C519.376,22.342 517.703,23.368 516.035,25.035 C514.368,26.702 513.342,28.377 512.574,30.349 C511.834,32.258 511.326,34.438 511.181,37.631 C511.035,40.831 511,41.851 511,50 C511,58.147 511.035,59.17 511.181,62.369 C511.326,65.562 511.834,67.743 512.574,69.651 C513.342,71.625 514.368,73.296 516.035,74.965 C517.703,76.634 519.376,77.658 521.349,78.425 C523.257,79.167 525.438,79.673 528.631,79.82 C531.831,79.965 532.853,80.001 541,80.001 C549.148,80.001 550.169,79.965 553.369,79.82 C556.562,79.673 558.743,79.167 560.652,78.425 C562.623,77.658 564.297,76.634 565.965,74.965 C567.633,73.296 568.659,71.625 569.425,69.651 C570.167,67.743 570.674,65.562 570.82,62.369 C570.966,59.17 571,58.147 571,50 C571,41.851 570.966,40.831 570.82,37.631"></path></g></g></g></svg></div><div style="padding-top: 8px;"> <div style=" color:#3897f0; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:550; line-height:18px;"> View this post on Instagram</div></div><div style="padding: 12.5% 0;"></div> <div style="display: flex; flex-direction: row; margin-bottom: 14px; align-items: center;"><div> <div style="background-color: #F4F4F4; border-radius: 50%; height: 12.5px; width: 12.5px; transform: translateX(0px) translateY(7px);"></div> <div style="background-color: #F4F4F4; height: 12.5px; transform: rotate(-45deg) translateX(3px) translateY(1px); width: 12.5px; flex-grow: 0; margin-right: 14px; margin-left: 2px;"></div> <div style="background-color: #F4F4F4; border-radius: 50%; height: 12.5px; width: 12.5px; transform: translateX(9px) translateY(-18px);"></div></div><div style="margin-left: 8px;"> <div style=" background-color: #F4F4F4; border-radius: 50%; flex-grow: 0; height: 20px; width: 20px;"></div> <div style=" width: 0; height: 0; border-top: 2px solid transparent; border-left: 6px solid #f4f4f4; border-bottom: 2px solid transparent; transform: translateX(16px) translateY(-4px) rotate(30deg)"></div></div><div style="margin-left: auto;"> <div style=" width: 0px; border-top: 8px solid #F4F4F4; border-right: 8px solid transparent; transform: translateY(16px);"></div> <div style=" background-color: #F4F4F4; flex-grow: 0; height: 12px; width: 16px; transform: translateY(-4px);"></div> <div style=" width: 0; height: 0; border-top: 8px solid #F4F4F4; border-left: 8px solid transparent; transform: translateY(-4px) translateX(8px);"></div></div></div></a> <p style=" margin:8px 0 0 0; padding:0 4px;"> <a href="https://www.instagram.com/p/B7iM7kVlUY7/?utm_source=ig_embed&amp;utm_campaign=loading" style=" color:#000; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:normal; line-height:17px; text-decoration:none; word-wrap:break-word;" target="_blank">লটারির মাধ্যমে বাছাই করা হয়েছে Igloo Insta Quiz-এ সৌভাগ্যবান বিজয়ীদেরকে। অভিনন্দন আপনাদেরকে। . পূর্বনির্ধারিত সিদ্ধান্ত অনুযায়ী- আলিয়া নুসরাত (প্রথম বিজয়ী) পাচ্ছেন ৫ লিটার ইগলু আইসক্রিম। টারা ব্লুমস (দ্বিতীয় বিজয়ী) পাচ্ছেন ৪ লিটার ইগলু আইসক্রিম। মুমতাহীনা আহমেদ (তৃতীয় বিজয়ী) পাবে ৩ লিটার ইগলু আইসক্রিম। আরমান (চতুর্থ বিজয়ী) পাচ্ছেন ২ লিটার ইগলু আইসক্রিম। রুবাইয়া ইসলাম (পঞ্চম বিজয়ী) পাচ্ছেন ১ লিটার ইগলু আইসক্রিম।</a></p> <p style=" color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; line-height:17px; margin-bottom:0; margin-top:8px; overflow:hidden; padding:8px 0 7px; text-align:center; text-overflow:ellipsis; white-space:nowrap;">A post shared by <a href="https://www.instagram.com/iglooicecream/?utm_source=ig_embed&amp;utm_campaign=loading" style=" color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:normal; line-height:17px;" target="_blank"> Igloo</a> (@iglooicecream) on <time style=" font-family:Arial,sans-serif; font-size:14px; line-height:17px;" datetime="2020-01-20T08:15:40+00:00">Jan 20, 2020 at 12:15am PST</time></p></div></blockquote> <script async src="//www.instagram.com/embed.js"></script>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="col-sm-12 col-md-12 col-lg-4 col-xl-4 social-media-youtube">--}}
                    {{--<div class="social-media-plugin">--}}
                        {{--<img src="{{asset('default/assets/img/logo/youtube.png')}}" alt="youtube">--}}
                        {{--<iframe id="youtube" width="300" height="345" src="" data-src="https://www.youtube.com/embed/Ka5KaWY8e1M">--}}
                        {{--</iframe>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</section>--}}

    <!--brand area start-->
    <div class="brand_area mb-46 wow fadeInUp">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="brand_container owl-carousel">
                        <div class="brand_items">
                            <div class="single_brand">
                                <a href="#"><img src="{{ asset('default/assets/img/brand/brand1.jpg') }}" alt=""></a>
                            </div>
                        </div>
                        <div class="brand_items">
                            <div class="single_brand">
                                <a href="#"><img src="{{ asset('default/assets/img/brand/brand2.jpg') }}" alt=""></a>
                            </div>
                        </div>
                        <div class="brand_items">
                            <div class="single_brand">
                                <a href="#"><img src="{{ asset('default/assets/img/brand/brand3.jpg') }}" alt=""></a>
                            </div>
                        </div>
                        <div class="brand_items">
                            <div class="single_brand">
                                <a href="#"><img src="{{ asset('default/assets/img/brand/brand4.jpg') }}" alt=""></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--brand area end-->


    <!-- add to cart modal start -->
    <div class="modal fade" id="add-to-cart-modal" tabindex="-1" role="dialog"
         aria-labelledby="model-8"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">

            <!-- Modal Content -->
            <div class="modal-content">
                <input type="hidden" class="cart-popup-single-price">

                <!-- Modal Header -->
                <div class="modal-header">
                    {{--<h3 class="modal-title" id="model-8">Payment</h3>--}}
                    <button type="button" class="close add-to-cart-modal-close">&times;
                    </button>
                </div>
                <!-- /modal header -->

                <!-- Modal Body -->
                <form action="" method="">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-lg-6 d-inline-flex p-3">
                                <div>
                                    <img src="" width="120px" height="120px" class="cart-popup-image" alt="">
                                </div>
                                <div>
                                    <p class="cart-popup-name h4"></p>
                                    <p class="cart-popup-price h6"></p>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-lg-6">
                                <div class="form-group text-center">
                                    <label for="message-text"
                                           class="col-form-label">Quantity: </label>
                                    <div class="d-flex">
                                        <a class="btn btn-dark mr-2 add-to-cart-modal-minus">-</a>
                                        <input class="form-control cart-popup-input text-center" min="1" value="1" type="number">
                                        <a class="btn btn-info ml-2 add-to-cart-modal-plus">+</a>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="message-text"
                                           class="col-form-label">Total Price: </label>
                                    <P class="form-control cart-popup-total-price font-weight-bold text-bold" disabled type="text"></P>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /modal body -->

                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm cart-popup-shopping-btn" style="background: var(--dark-pink)">Continue Shopping</button>
                        <button type="button" class="btn btn-primary btn-sm cart-popup-checkout-btn" style="background: var(--dark-pink)">View Cart</button>
                    </div>
                </form>
                <!-- /modal footer -->

            </div>
        </div>
    </div>



    <!-- if customer has no phone number -->
    <div class="modal fade" id="add-customre-phone" role="dialog"
         aria-labelledby="model-8"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">

            <!-- Modal Content -->
            <div class="modal-content">
                <input type="hidden" class="cart-popup-single-price">

                <!-- Modal Header -->
                <div class="modal-header">
                    {{--<h3 class="modal-title" id="model-8">Payment</h3>--}}
                    {{--<button type="button" class="close add-to-cart-modal-close">&times;--}}
                    {{--</button>--}}
                </div>
                <!-- /modal header -->

                <!-- Modal Body -->
                <form action="" method="">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="message-text"
                                           class="col-form-label">Enter your phone number: </label>
                                    <input type="number" name="phone_number" class="form-control phone_number">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /modal body -->

                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-sm add-customer-phone-btn" disabled style="background: var(--dark-pink)">Save</button>
                    </div>
                </form>
                <!-- /modal footer -->

            </div>
        </div>
    </div>

    <input type="hidden" id="userRole" value="{{ (isset($userDetails->role_name)) ? $userDetails->role_name : 'user' }}">
    <input type="hidden" id="authUser" value="{{ (Auth::user()) ? "hasUser" : "none" }}">

    <!-- add to cart modal emd -->
@endsection

@section('script')
    <script src="{{ asset('default/assets/js/sweetalert2.js') }}" defer></script  >
    {{--<script src="{{ asset('default/assets/js/WOW.js') }}"></script>--}}
    <script>
                {{--function youtube_init() {--}}
                {{--$('.social-media-instagram').append('<div class="social-media-plugin">\n' +--}}
                {{--'                        <img src="{{asset("default/assets/img/logo/instagram.png")}}" alt="instagram">\n' +--}}
                {{--'                        <blockquote class="instagram-media" data-instgrm-captioned data-instgrm-permalink="https://www.instagram.com/p/B7iM7kVlUY7/?utm_source=ig_embed&amp;utm_campaign=loading" data-instgrm-version="12" style=" background:#FFF; border:0; border-radius:3px; box-shadow:0 0 1px 0 rgba(0,0,0,0.5),0 1px 10px 0 rgba(0,0,0,0.15); margin: 1px; max-width:540px; min-width:326px; padding:0; width:99.375%; width:-webkit-calc(100% - 2px); width:calc(100% - 2px);"><div style="padding:16px;"> <a href="https://www.instagram.com/p/B7iM7kVlUY7/?utm_source=ig_embed&amp;utm_campaign=loading" style=" background:#FFFFFF; line-height:0; padding:0 0; text-align:center; text-decoration:none; width:100%;" target="_blank"> <div style=" display: flex; flex-direction: row; align-items: center;"> <div style="background-color: #F4F4F4; border-radius: 50%; flex-grow: 0; height: 40px; margin-right: 14px; width: 40px;"></div> <div style="display: flex; flex-direction: column; flex-grow: 1; justify-content: center;"> <div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; margin-bottom: 6px; width: 100px;"></div> <div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; width: 60px;"></div></div></div><div style="padding: 19% 0;"></div> <div style="display:block; height:50px; margin:0 auto 12px; width:50px;"><svg width="50px" height="50px" viewBox="0 0 60 60" version="1.1" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g transform="translate(-511.000000, -20.000000)" fill="#000000"><g><path d="M556.869,30.41 C554.814,30.41 553.148,32.076 553.148,34.131 C553.148,36.186 554.814,37.852 556.869,37.852 C558.924,37.852 560.59,36.186 560.59,34.131 C560.59,32.076 558.924,30.41 556.869,30.41 M541,60.657 C535.114,60.657 530.342,55.887 530.342,50 C530.342,44.114 535.114,39.342 541,39.342 C546.887,39.342 551.658,44.114 551.658,50 C551.658,55.887 546.887,60.657 541,60.657 M541,33.886 C532.1,33.886 524.886,41.1 524.886,50 C524.886,58.899 532.1,66.113 541,66.113 C549.9,66.113 557.115,58.899 557.115,50 C557.115,41.1 549.9,33.886 541,33.886 M565.378,62.101 C565.244,65.022 564.756,66.606 564.346,67.663 C563.803,69.06 563.154,70.057 562.106,71.106 C561.058,72.155 560.06,72.803 558.662,73.347 C557.607,73.757 556.021,74.244 553.102,74.378 C549.944,74.521 548.997,74.552 541,74.552 C533.003,74.552 532.056,74.521 528.898,74.378 C525.979,74.244 524.393,73.757 523.338,73.347 C521.94,72.803 520.942,72.155 519.894,71.106 C518.846,70.057 518.197,69.06 517.654,67.663 C517.244,66.606 516.755,65.022 516.623,62.101 C516.479,58.943 516.448,57.996 516.448,50 C516.448,42.003 516.479,41.056 516.623,37.899 C516.755,34.978 517.244,33.391 517.654,32.338 C518.197,30.938 518.846,29.942 519.894,28.894 C520.942,27.846 521.94,27.196 523.338,26.654 C524.393,26.244 525.979,25.756 528.898,25.623 C532.057,25.479 533.004,25.448 541,25.448 C548.997,25.448 549.943,25.479 553.102,25.623 C556.021,25.756 557.607,26.244 558.662,26.654 C560.06,27.196 561.058,27.846 562.106,28.894 C563.154,29.942 563.803,30.938 564.346,32.338 C564.756,33.391 565.244,34.978 565.378,37.899 C565.522,41.056 565.552,42.003 565.552,50 C565.552,57.996 565.522,58.943 565.378,62.101 M570.82,37.631 C570.674,34.438 570.167,32.258 569.425,30.349 C568.659,28.377 567.633,26.702 565.965,25.035 C564.297,23.368 562.623,22.342 560.652,21.575 C558.743,20.834 556.562,20.326 553.369,20.18 C550.169,20.033 549.148,20 541,20 C532.853,20 531.831,20.033 528.631,20.18 C525.438,20.326 523.257,20.834 521.349,21.575 C519.376,22.342 517.703,23.368 516.035,25.035 C514.368,26.702 513.342,28.377 512.574,30.349 C511.834,32.258 511.326,34.438 511.181,37.631 C511.035,40.831 511,41.851 511,50 C511,58.147 511.035,59.17 511.181,62.369 C511.326,65.562 511.834,67.743 512.574,69.651 C513.342,71.625 514.368,73.296 516.035,74.965 C517.703,76.634 519.376,77.658 521.349,78.425 C523.257,79.167 525.438,79.673 528.631,79.82 C531.831,79.965 532.853,80.001 541,80.001 C549.148,80.001 550.169,79.965 553.369,79.82 C556.562,79.673 558.743,79.167 560.652,78.425 C562.623,77.658 564.297,76.634 565.965,74.965 C567.633,73.296 568.659,71.625 569.425,69.651 C570.167,67.743 570.674,65.562 570.82,62.369 C570.966,59.17 571,58.147 571,50 C571,41.851 570.966,40.831 570.82,37.631"></path></g></g></g></svg></div><div style="padding-top: 8px;"> <div style=" color:#3897f0; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:550; line-height:18px;"> View this post on Instagram</div></div><div style="padding: 12.5% 0;"></div> <div style="display: flex; flex-direction: row; margin-bottom: 14px; align-items: center;"><div> <div style="background-color: #F4F4F4; border-radius: 50%; height: 12.5px; width: 12.5px; transform: translateX(0px) translateY(7px);"></div> <div style="background-color: #F4F4F4; height: 12.5px; transform: rotate(-45deg) translateX(3px) translateY(1px); width: 12.5px; flex-grow: 0; margin-right: 14px; margin-left: 2px;"></div> <div style="background-color: #F4F4F4; border-radius: 50%; height: 12.5px; width: 12.5px; transform: translateX(9px) translateY(-18px);"></div></div><div style="margin-left: 8px;"> <div style=" background-color: #F4F4F4; border-radius: 50%; flex-grow: 0; height: 20px; width: 20px;"></div> <div style=" width: 0; height: 0; border-top: 2px solid transparent; border-left: 6px solid #f4f4f4; border-bottom: 2px solid transparent; transform: translateX(16px) translateY(-4px) rotate(30deg)"></div></div><div style="margin-left: auto;"> <div style=" width: 0px; border-top: 8px solid #F4F4F4; border-right: 8px solid transparent; transform: translateY(16px);"></div> <div style=" background-color: #F4F4F4; flex-grow: 0; height: 12px; width: 16px; transform: translateY(-4px);"></div> <div style=" width: 0; height: 0; border-top: 8px solid #F4F4F4; border-left: 8px solid transparent; transform: translateY(-4px) translateX(8px);"></div></div></div></a> <p style=" margin:8px 0 0 0; padding:0 4px;"> <a href="https://www.instagram.com/p/B7iM7kVlUY7/?utm_source=ig_embed&amp;utm_campaign=loading" style=" color:#000; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:normal; line-height:17px; text-decoration:none; word-wrap:break-word;" target="_blank">লটারির মাধ্যমে বাছাই করা হয়েছে Igloo Insta Quiz-এ সৌভাগ্যবান বিজয়ীদেরকে। অভিনন্দন আপনাদেরকে। . পূর্বনির্ধারিত সিদ্ধান্ত অনুযায়ী- আলিয়া নুসরাত (প্রথম বিজয়ী) পাচ্ছেন ৫ লিটার ইগলু আইসক্রিম। টারা ব্লুমস (দ্বিতীয় বিজয়ী) পাচ্ছেন ৪ লিটার ইগলু আইসক্রিম। মুমতাহীনা আহমেদ (তৃতীয় বিজয়ী) পাবে ৩ লিটার ইগলু আইসক্রিম। আরমান (চতুর্থ বিজয়ী) পাচ্ছেন ২ লিটার ইগলু আইসক্রিম। রুবাইয়া ইসলাম (পঞ্চম বিজয়ী) পাচ্ছেন ১ লিটার ইগলু আইসক্রিম।</a></p> <p style=" color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; line-height:17px; margin-bottom:0; margin-top:8px; overflow:hidden; padding:8px 0 7px; text-align:center; text-overflow:ellipsis; white-space:nowrap;">A post shared by <a href="https://www.instagram.com/iglooicecream/?utm_source=ig_embed&amp;utm_campaign=loading" style=" color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:normal; line-height:17px;" target="_blank"> Igloo</a> (@iglooicecream) on <time style=" font-family:Arial,sans-serif; font-size:14px; line-height:17px;" datetime="2020-01-20T08:15:40+00:00">Jan 20, 2020 at 12:15am PST</time></p></div></blockquote> <script async src="//www.instagram.com/embed.js" />\n'+--}}
                {{--'                    </div>')--}}
                {{--$('.social-media-youtube').append('<div class="social-media-plugin">\n' +--}}
                {{--'                        <img src="{{asset("default/assets/img/logo/youtube.png")}}" alt="youtube">\n' +--}}
                {{--'                        <iframe id="youtube" width="300" height="345" src="" data-src="https://www.youtube.com/embed/Ka5KaWY8e1M">\n' +--}}
                {{--'                        </iframe>\n' +--}}
                {{--'                    </div>')--}}
                {{--var src_url = $('#youtube').data('src');--}}
                {{--$('#youtube').attr('src', src_url);--}}
                {{--}--}}
                {{--window.onload = youtube_init;--}}

      const publicPath = "{{ URL::to('/') }}";

      $(document).ready(function() {

        // checking customer has phone number or no


          if($('#authUser').val() === "hasUser"){
          // console.log($('#authUser').val())
              const user = {!! Auth::user() !!}
              console.log("Igloobd")
             if($('#userRole').val() === 'Customer' && user.phone === null){
                // opening add customer phone number modal
               $('#add-customre-phone').modal({
                 backdrop: false
               })
               $('#add-customre-phone').modal('show')
             }
          }

        $(document).on('keyup', '.phone_number', function () {
          const number = $(this).val()
          if(number.length >= 11){
            $('.add-customer-phone-btn').removeAttr('disabled')
          }else{
            $('.add-customer-phone-btn').attr('disabled', 'disabled');
          }
        })
        $('.add-customer-phone-btn').click(function () {
          const phone = $('.phone_number').val()
          if(phone.length >= 11) {
            $.ajaxSetup({
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
            });
              $.ajax({
                  url: "{{ route('update-phone') }}",
                  method: "post",
                  dataType: "html",
                  data: { phone: phone  },
                  success: function (data) {
                    if(data === "Success"){
                      $('#add-customre-phone').modal('hide')
                      Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title:"Congratulation!!! Phone number updated",
                        showConfirmButton: false,
                        timer: 1500,
                        toast: false,
                      })
                    }else{
                      Swal.fire({
                        position: 'center',
                        icon: 'warning',
                        title:"Something went wrong",
                        showConfirmButton: false,
                        timer: 1500,
                        toast: false,
                      })
                    }
                  }
              })
          }
        });





        // clicking on checkout button
        $(document).on('click', '.cart-popup-checkout-btn', function () {
          const productID = $(this).attr("id");
          const productQuantity = $('.cart-popup-input').val();

          $.ajax({
            url: "{{ url('/add-to-cart') }}/"+productID+"?quantity="+productQuantity,
            method: "get",
            dataType: "json",
            success: function (data) {
              // console.log(data)
              if (data != undefined) {
                //if error
                if (data.error) {
                  if(data.error === "Failed") {
                    Swal.fire({
                      position: 'center',
                      icon: 'warning',
                      title:"Sorry",
                      text: 'Something went wrong!',
                      showConfirmButton: false,
                      timer: 1500,
                      toast: false,
                    })
                  }else{
                    Swal.fire({
                      position: 'center',
                      icon: 'warning',
                      title:"Sorry",
                      text: 'We are not taking any order at this time. Please come back with in 10 AM to 07 PM!',
                      showConfirmButton: false,
                      timer: 5000,
                      toast: false,
                    })
                  }
                } else {
                  // display toast message
                  Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Ice cream added success!',
                    showConfirmButton: false,
                    timer: 1500,
                    toast: true,

                  })
                  // change cart item number in top menu
                  if ($('.cart_quantity').length > 0) {
                    $('.cart_quantity').html(data.totalItem);
                  }
                  // format minicart design
                  if ($('.mini_cart_scrool').length > 0) {
                    let output = '';
                    $.each(data.content, function (i, e) {
                      output += '<div class="cart_item">\n';
                      output += '                                    <div class="cart_img">\n';
                      output += '                                        <a href="#"><img src="' + publicPath + '/' + e.options.image + '" alt=""></a>\n';
                      output += '                                    </div>\n';
                      output += '                                    <div class="cart_info">\n';
                      output += '                                        <a href="#">' + e.name + '</a>\n';
                      output += '                                        <p>Qty: ' + e.qty + ' X <span> Tk' + e.price + ' </span></p>\n';
                      output += '                                    </div>\n';
                      output += '                                    <div class="cart_remove">\n';
                      output += '                                        <a href="{{ URL::to('remove-cart-item') }}/' + e.rowId + '"><i class="ion-android-close"></i></a>\n';
                      output += '                                    </div>\n';
                      output += '                                </div>';
                    });
                    output += '<div class="mini_cart_table">\n' +
                      '                                    <div class="cart_total mt-10">\n' +
                      '                                        <span>Total:</span>\n' +
                      '                                        <span class="price">TK ' + data.total + '</span>\n' +
                      '                                    </div>\n' +
                      '                                </div>';
                    output += '<div class="mini_cart_footer">\n' +
                      '                                    <div class="cart_button">\n' +
                      '                                        <a href="{{ route('cart') }}">View cart</a>\n' +
                      '                                    </div>\n' +
                            {{--'                                    <div class="cart_button">\n' +--}}
                                    {{--'                                        <a href="{{ route("checkout") }}">Checkout</a>\n' +--}}
                                    {{--'                                    </div>\n' +--}}
                              '\n' +
                      '                                </div>';
                    $('.mini_cart_scrool').html(output);
                    $('#add-to-cart-modal').modal('hide');
                    window.location.href = "{{ route('cart') }}"
                  }
                }
              }
            }
          })
        })

        // clicking on continue shopping button
        $(document).on('click', '.cart-popup-shopping-btn', function () {
          const productID = $(this).attr("id");
          const productQuantity = $('.cart-popup-input').val();

          $.ajax({
            url: "{{ url('/add-to-cart') }}/"+productID+"?quantity="+productQuantity,
            method: "get",
            dataType: "json",
            success: function (data) {
              // console.log(data)
              if (data != undefined) {
                //if error
                if (data.error) {
                  if(data.error === "Failed") {
                    Swal.fire({
                      position: 'center',
                      icon: 'warning',
                      title:"Sorry",
                      text: 'Something went wrong!',
                      showConfirmButton: false,
                      timer: 1500,
                      toast: false,
                    })
                  }else{
                    Swal.fire({
                      position: 'center',
                      icon: 'warning',
                      title:"Sorry",
                      text: 'We are not taking any order at this time. Please come back with in 10 AM to 07 PM!',
                      showConfirmButton: false,
                      timer: 5000,
                      toast: false,
                    })
                  }
                } else {
                  // display toast message
                  Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Ice cream added success!',
                    showConfirmButton: false,
                    timer: 1500,
                    toast: true,

                  })
                  // change cart item number in top menu
                  if ($('.cart_quantity').length > 0) {
                    $('.cart_quantity').html(data.totalItem);
                  }
                  // format minicart design
                  if ($('.mini_cart_scrool').length > 0) {
                    let output = '';
                    $.each(data.content, function (i, e) {
                      output += '<div class="cart_item">\n';
                      output += '                                    <div class="cart_img">\n';
                      output += '                                        <a href="#"><img src="' + publicPath + '/' + e.options.image + '" alt=""></a>\n';
                      output += '                                    </div>\n';
                      output += '                                    <div class="cart_info">\n';
                      output += '                                        <a href="#">' + e.name + '</a>\n';
                      output += '                                        <p>Qty: ' + e.qty + ' X <span> Tk' + e.price + ' </span></p>\n';
                      output += '                                    </div>\n';
                      output += '                                    <div class="cart_remove">\n';
                      output += '                                        <a href="{{ URL::to('remove-cart-item') }}/' + e.rowId + '"><i class="ion-android-close"></i></a>\n';
                      output += '                                    </div>\n';
                      output += '                                </div>';
                    });
                    output += '<div class="mini_cart_table">\n' +
                      '                                    <div class="cart_total mt-10">\n' +
                      '                                        <span>Total:</span>\n' +
                      '                                        <span class="price">TK ' + data.total + '</span>\n' +
                      '                                    </div>\n' +
                      '                                </div>';
                    output += '<div class="mini_cart_footer">\n' +
                      '                                    <div class="cart_button">\n' +
                      '                                        <a href="{{ route('cart') }}">View cart</a>\n' +
                      '                                    </div>\n' +
                      {{--'                                    <div class="cart_button">\n' +--}}
                      {{--'                                        <a href="{{ route("checkout") }}">Checkout</a>\n' +--}}
                      {{--'                                    </div>\n' +--}}
                      '\n' +
                      '                                </div>';
                    $('.mini_cart_scrool').html(output);
                    $('#add-to-cart-modal').modal('hide');
                  }
                }
              }
            }
          })
        })

        // clicking on add to cart
        $(document).on('click', '.shopping_cart_link', function () {
          const imagePath = "{{ asset('') }}";
          const productID = $(this).attr("id");
          const productName = $(this).data("name");
          const productPrice = $(this).data("price");
          const productQuantity = $(this).data("quantity");
          const productImage = $(this).data("image");

          $('#add-to-cart-modal').find('.cart-popup-image').attr("src", imagePath+productImage)
          $('#add-to-cart-modal').find('.cart-popup-name').text(productName)
          $('#add-to-cart-modal').find('.cart-popup-price').text("TK "+productPrice)
          $('#add-to-cart-modal').find('.cart-popup-single-price').attr("value", productPrice)
          $('#add-to-cart-modal').find('.cart-popup-input').attr("max", productQuantity)
          $('#add-to-cart-modal').find('.cart-popup-input').removeAttr("value")
          $('#add-to-cart-modal').find('.cart-popup-input').attr("value", 1)

          const price = parseFloat($('.cart-popup-single-price').val())
          const qu = parseFloat(Number($('.cart-popup-input').val()));
          const newPrice = parseFloat(price * qu)

          $('.cart-popup-total-price').text(newPrice+" TK")

          $('#add-to-cart-modal').find('.cart-popup-checkout-btn').attr("id", productID)
          $('#add-to-cart-modal').find('.cart-popup-shopping-btn').attr("id", productID)

          $('#add-to-cart-modal').modal('show');
        })
        // add to cart pop up close
        $(document).on('click', '.add-to-cart-modal-close', function () {
          $('#add-to-cart-modal').modal('hide');
        })
        // clicking on modal plus btn
        $(document).on('click', '.add-to-cart-modal-plus', function () {
          const price = parseFloat($('.cart-popup-single-price').val())
          const qu = (Number($('.cart-popup-input').val())+1);
          const newPrice = (price * qu)
          $('.cart-popup-input').val(qu)
          $('.cart-popup-total-price').text(newPrice+" TK")
        })
        // clicking on modal minus btn
        $(document).on('click', '.add-to-cart-modal-minus', function () {
          const price = parseFloat($('.cart-popup-single-price').val())
          const qu = (Number($('.cart-popup-input').val())-1);
          if(qu > 0) {
            const newPrice = (price * qu)
            $('.cart-popup-input').val(qu)
            $('.cart-popup-total-price').text(newPrice + " TK")
          }
        })
        // on change
        $(document).on('change', '.cart-popup-input', function () {
          const price = parseFloat($('.cart-popup-single-price').val())
          const qu = Number($('.cart-popup-input').val());
          const newPrice = (price * qu)
          $('.cart-popup-total-price').text(newPrice+" TK")
        })
        // on key press
        $(document).on('keyup', '.cart-popup-input', function () {
          const price = parseFloat($('.cart-popup-single-price').val())
          const qu = Number($('.cart-popup-input').val());
          const newPrice = (price * qu)
          $('.cart-popup-total-price').text(newPrice+" TK")
        })



    })
    </script>

@endsection
