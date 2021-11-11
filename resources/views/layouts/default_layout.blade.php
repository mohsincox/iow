<!doctype html>
<html class="no-js" lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="author" content="Saros IT">
{!! SEO::generate() !!}
    

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('default/assets/img/favicon.ico') }}">
    <!-- CSS
    ========================= -->
    {{--font link--}}
    <link href="https://fonts.googleapis.com/css?family=Baloo|Rubik:300i,400,400i,500,500i,700,700i,900,900i&display=swap" rel="stylesheet">

    <meta name="google-site-verification" content="JF9aUJ3t9mc-_3zLo9wEL79KC5fGNuDYh_l9z9_TPb0" />

    <!-- Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('default/assets/css/plugins.css') }}">

    <!-- Main Style CSS -->
    <link rel="stylesheet" href="{{ asset('default/assets/css/style.css') }}">
    {{--<link rel="stylesheet" href="{{ asset('default/assets/css/animate.css') }}">--}}
    <script src="{{ asset('default/assets/js/jquery.js') }}" ></script>
    <!--<script src="{{asset('admin/node_modules/jquery/dist/jquery.min.js')}}" ></script>-->
    @yield('stylesheet')
    
    @if( request()->get('ref') =='botassistant' )
        <style>
            header, footer, .Offcanvas_menu, .sticky-header.sticky{
                display: none !important;
            }
        </style>
    @endif

</head>

<body>

@if( request()->get('ref') !== 'botassistant' )
<!-- Load Facebook SDK for JavaScript -->
<!--<div id="fb-root"></div>-->

<!-- Your customer chat code -->
<!--<div class="fb-customerchat"-->
<!--     attribution=setup_tool-->
<!--     page_id="168615096534500"-->
<!--     greeting_dialog_display="hide"-->
<!--     theme_color="#fa3c4c">-->
<!--</div>-->

<!--<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v5.0&appId=2438872156189582&autoLogAppEvents=1"></script>-->
@endif

<!--header area start-->
@if(Route::currentRouteName() != "checkout" || Route::currentRouteName() != "cart")
    <!--<div id="preloader_overlayer"></div>-->
    <div class="preloader_parent">
        <div class="preloader">
            <div class="preloader_inner">
                <img class="animate_logo" src="{{asset('default/assets/img/126.gif')}}" alt="">
            </div>
        </div>
    </div>
@endif
@include('layouts.default_header')

@yield('content')

@include('layouts.default_footer')


@yield('script')

<!--map js code here-->
{{--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAdWLY_Y6FL7QGW5vcO3zajUEsrKfQPNzI"></script>--}}
<script  src="https://www.google.com/jsapi"></script>



<!-- Plugins JS -->
<script src="{{ asset('default/assets/js/plugins.js') }}" ></script>
<script src="{{ asset('default/assets/js/lazysizes.min.js') }}" async="" ></script>
<!-- Main JS -->
<script src="{{ asset('default/assets/js/main.js') }}" ></script>


<!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-TLLJTNQ');</script>
    <!-- End Google Tag Manager -->

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TLLJTNQ"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

    <!-- Facebook Pixel Code -->
    <script>
      !function(f,b,e,v,n,t,s)
      {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
      n.callMethod.apply(n,arguments):n.queue.push(arguments)};
      if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
      n.queue=[];t=b.createElement(e);t.async=!0;
      t.src=v;s=b.getElementsByTagName(e)[0];
      s.parentNode.insertBefore(t,s)}(window, document,'script',
      'https://connect.facebook.net/en_US/fbevents.js');
      fbq('init', '3015348135207622');
      fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
      src="https://www.facebook.com/tr?id=3015348135207622&ev=PageView&noscript=1"
    /></noscript>
    <!-- End Facebook Pixel Code -->
<!--facebook chat js-->




</body>
</html>