@inject('PublicFunction', 'App\Http\Controllers\PublicFunction')
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Drift - A fully responsive, HTML5 based admin template">
    <meta name="keywords" content="Responsive, HTML5, admin theme, business, professional, jQuery, web design, CSS3, sass">
    <!-- /meta tags -->
    <title> @yield('title')</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Site favicon -->
    <link rel="shortcut icon" href="{{ asset('admin/assets/images/favicon.ico') }}" type="image/x-icon">
    <!-- /site favicon -->

    <!-- Font Icon Styles -->
    <link rel="stylesheet" href="{{ asset('admin/node_modules/flag-icon-css/css/flag-icon.min.css') }}">
    <link rel="stylesheet" href="{{asset('admin/vendors/gaxon-icon/styles.css')}}">
    <!-- /font icon Styles -->

    <!-- Perfect Scrollbar stylesheet -->
    <link rel="stylesheet" href="{{asset('admin/node_modules/perfect-scrollbar/css/perfect-scrollbar.css')}}">
    <!-- /perfect scrollbar stylesheet -->

    <!-- Load Styles -->
    <link rel="stylesheet" href="{{asset('admin/node_modules/owl.carousel/dist/assets/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/node_modules/chartist/dist/chartist.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/assets/css/semidark-style-1.min.css')}}">
    <!-- /load styles -->
    <script src="{{asset('admin/node_modules/jquery/dist/jquery.min.js')}}"></script>

    @yield('stylesheet')
</head>
<body class="dt-sidebar--fixed dt-header--fixed">


<!-- Loader -->
<div class="dt-loader-container">
    <div class="dt-loader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"></circle>
        </svg>
    </div>
</div>
<!-- /loader -->

<!-- Root -->
<div class="dt-root">
    <div class="dt-root__inner">
        <!-- Header -->
        <header class="dt-header">

            <!-- Header container -->
            <div class="dt-header__container">

                <!-- Brand -->
                <div class="dt-brand">

                    <!-- Brand tool -->
                    <div class="dt-brand__tool" data-toggle="main-sidebar">
                        <div class="hamburger-inner"></div>
                    </div>
                    <!-- /brand tool -->

                    <!-- Brand logo -->
                    <span class="dt-brand__logo">
                         <a class="dt-brand__logo-link" href="{{ route('index') }}">
                            <img class=" d-none d-sm-inline-block" src="{{asset('admin/assets/images/admin.png')}}" alt="Drift">
                            <img class="dt-brand__logo-symbol d-sm-none" src="{{asset('admin/assets/images/admin.png')}}" alt="Drift">
                        </a>
                    </span>
                    <!-- /brand logo -->

                </div>
                <!-- /brand -->

                <!-- Header toolbar-->
                <div class="dt-header__toolbar">

                    <!-- Header Menu Wrapper -->
                    <div class="dt-nav-wrapper">



                        <!-- Header Menu -->


                        <!-- Header Menu -->
                        <ul class="dt-nav">
                            <li class="dt-nav__item dropdown">

                                <!-- Dropdown Link -->
                                <a href="#" class="dt-nav__link dropdown-toggle no-arrow dt-avatar-wrapper"
                                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img class="dt-avatar size-30" src="https://via.placeholder.com/150x150"
                                         alt="Domnic Harris">
                                    <span class="dt-avatar-info d-none d-sm-block">
                                            <span class="dt-avatar-name">{{ Auth::user()->name }}</span>
                                    </span>
                                </a>
                                <!-- /dropdown link -->

                                <!-- Dropdown Option -->
                                <div class="dropdown-menu dropdown-menu-right">
                                    <div class="dt-avatar-wrapper flex-nowrap p-6 mt-n2 bg-gradient-purple text-white rounded-top">
                                        <img class="dt-avatar" src="https://via.placeholder.com/150x150"
                                             alt="Domnic Harris">
                                        <span class="dt-avatar-info">
                                            <span class="dt-avatar-name">{{ Auth::user()->name }}</span>
                                            <span class="f-12">Administrator</span>
                                        </span>
                                    </div>
                                     <a class="dropdown-item" href="{{ route('admin.change-password') }}">
                                        <i class="icon icon-settings icon-fw mr-2 mr-sm-1"></i>Setting </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"> <i
                                                class="icon icon-editors icon-fw mr-2 mr-sm-1"></i>Logout
                                    </a>
                                </div>
                                <!-- /dropdown option -->

                            </li>
                        </ul>
                        <!-- /header menu -->
                    </div>
                    <!-- Header Menu Wrapper -->

                </div>
                <!-- /header toolbar -->

            </div>
            <!-- /header container -->

        </header>
        <!-- /header -->

        <!-- Site Main -->
        <main class="dt-main">
            <!-- Sidebar -->
            <aside id="main-sidebar" class="dt-sidebar">
                <div class="dt-sidebar__container">

                    <!-- Sidebar Navigation -->
                    <ul class="dt-side-nav">

                        <!-- Menu Header -->
                        <li class="dt-side-nav__item dt-side-nav__header">
                            <span class="dt-side-nav__text">Main</span>
                        </li>
                        <!-- /menu header -->

                        <!-- Menu Item -->
                        <li class="dt-side-nav__item">
                            <a href="{{ route('admin.dashboard') }}" class="dt-side-nav__link" title="Dashboard">
                                <i class="icon icon-dashboard icon-fw icon-lg"></i>
                                <span class="dt-side-nav__text">Dashboard</span>
                            </a>
                            <!-- /sub-menu -->

                        </li>
                        <!-- Menu Header -->
                        @if($PublicFunction::checkPermission($userPermission, ["view_order", "view_order_history", "order_payment"]))
                            <!-- Menu Header -->
                            <li class="dt-side-nav__item dt-side-nav__header">
                                <span class="dt-side-nav__text">Order</span>
                            </li>
                            <!-- /menu header -->
                            <!-- Menu Item -->
                            @if($PublicFunction::checkPermission($userPermission, ["view_order"]))
                                <li class="dt-side-nav__item">
                                    <a href="{{ route('admin.get-order') }}" class="dt-side-nav__link" title="Orders">
                                        <i class="icon icon-watchlist icon-fw icon-lg"></i>
                                        <span class="dt-side-nav__text">Orders</span>
                                    </a>
                                </li>
                            @endif
                            @if($PublicFunction::checkPermission($userPermission, ["view_order_history"]))
                                <li class="dt-side-nav__item">
                                    <a href="{{ route('admin.get-order-history') }}" class="dt-side-nav__link" title="Orders">
                                        <i class="icon icon-watchlist icon-fw icon-lg"></i>
                                        <span class="dt-side-nav__text">Orders History</span>
                                    </a>
                                </li>
                            @endif
                        @endif
                        @if($PublicFunction::checkPermission($userPermission, ["add_category", "update_category", "view_category", "delete_category", "add_sub_category", "update_sub_category", "view_sub_category", "delete_sub_category", "add_product", "update_product", "view_product", "delete_product", "add_coupon", "update_coupon", "view_coupon", "delete_coupon", "add_purchase_discount", "update_purchase_discount", "view_purchase_discount", "delete_purchase_discount"]))
                            <li class="dt-side-nav__item dt-side-nav__header">
                                <span class="dt-side-nav__text">Product</span>
                            </li>
                        @endif
                        <!-- /menu header -->

                        <!-- Menu Item -->
                        @if($PublicFunction::checkPermission($userPermission, ["add_category", "update_category", "view_category", "delete_category"]))
                            <li class="dt-side-nav__item">
                                <a href="javascript:void(0)" class="dt-side-nav__link dt-side-nav__arrow" title="Category">
                                    <i class="icon icon-tag-o icon-fw icon-lg"></i>
                                    <span class="dt-side-nav__text">Category</span>
                                </a>

                                <!-- Sub-menu -->
                                <ul class="dt-side-nav__sub-menu">
                                    @if($PublicFunction::checkPermission($userPermission, ["add_category"]))
                                        <li class="dt-side-nav__item">
                                            <a href="{{route('admin.add-category')}}" class="dt-side-nav__link" title="Add Category">
                                                <i class="icon icon-components icon-fw icon-lg"></i>
                                                <span class="dt-side-nav__text">Add Category</span>
                                            </a>
                                        </li>
                                    @endif
                                    @if($PublicFunction::checkPermission($userPermission, ["update_category", "view_category", "delete_category"]))
                                        <li class="dt-side-nav__item">
                                            <a href="{{route('admin.view-category')}}" class="dt-side-nav__link" title="View Category">
                                                <i class="icon icon-datatable icon-fw icon-lg"></i>
                                                <span class="dt-side-nav__text">View Category</span>
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                                <!-- /sub-menu -->

                            </li>
                        @endif

                        @if($PublicFunction::checkPermission($userPermission, ["add_sub_category", "update_sub_category", "view_sub_category", "delete_sub_category"]))
                            <li class="dt-side-nav__item">
                                <a href="javascript:void(0)" class="dt-side-nav__link dt-side-nav__arrow" title="Category">
                                    <i class="icon icon-tag-o icon-fw icon-lg"></i>
                                    <span class="dt-side-nav__text"> Sub Category</span>
                                </a>

                        <!-- Sub-menu -->
                                <ul class="dt-side-nav__sub-menu">
                                    @if($PublicFunction::checkPermission($userPermission, ["add_sub_category"]))
                                        <li class="dt-side-nav__item">
                                            <a href="{{route('admin.add-sub-category')}}" class="dt-side-nav__link" title="Add Sub Category">
                                                <i class="icon icon-components icon-fw icon-lg"></i>
                                                <span class="dt-side-nav__text">Add Sub Category</span>
                                            </a>
                                        </li>
                                    @endif
                                    @if($PublicFunction::checkPermission($userPermission, ["update_sub_category", "view_sub_category", "delete_sub_category"]))
                                        <li class="dt-side-nav__item">
                                            <a href="{{route('admin.view-sub-category')}}" class="dt-side-nav__link" title="View Sub Category">
                                                <i class="icon icon-datatable icon-fw icon-lg"></i>
                                                <span class="dt-side-nav__text">View Sub Category</span>
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                                <!-- /sub-menu -->
                            </li>
                        @endif

                        @if($PublicFunction::checkPermission($userPermission, ["add_product", "update_product", "view_product", "delete_product"]))
                            <li class="dt-side-nav__item">
                                <a href="javascript:void(0)" class="dt-side-nav__link dt-side-nav__arrow" title="Category">
                                    <i class="icon icon-menu2 icon-fw icon-lg"></i>
                                    <span class="dt-side-nav__text"> Products</span>
                                </a>
                                <!-- Sub-menu -->
                                <ul class="dt-side-nav__sub-menu">
                                    @if($PublicFunction::checkPermission($userPermission, ["add_product"]))
                                        <li class="dt-side-nav__item">
                                            <a href="{{ route('admin.add-product') }}" class="dt-side-nav__link" title="Add Product">
                                                <i class="icon icon-components icon-fw icon-lg"></i>
                                                <span class="dt-side-nav__text">Add Product</span>
                                            </a>
                                        </li>
                                    @endif
                                    @if($PublicFunction::checkPermission($userPermission, ["update_product", "view_product", "delete_product"]))
                                        <li class="dt-side-nav__item">
                                            <a href="{{ route('admin.view-product') }}" class="dt-side-nav__link" title="View Products">
                                                <i class="icon icon-datatable icon-fw icon-lg"></i>
                                                <span class="dt-side-nav__text">View Products</span>
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                                <!-- /sub-menu -->
                            </li>
                        @endif

                        <!-- Menu Item -->
                        @if($PublicFunction::checkPermission($userPermission, ["add_coupon", "update_coupon", "view_coupon", "delete_coupon", "add_purchase_discount", "update_purchase_discount", "view_purchase_discount", "delete_purchase_discount"]))
                            <li class="dt-side-nav__item">
                                <a href="javascript:void(0)" class="dt-side-nav__link dt-side-nav__arrow" title="Category">
                                    <i class="icon icon-tag-o icon-fw icon-lg"></i>
                                    <span class="dt-side-nav__text">Manage Offer</span>
                                </a>

                                <!-- Sub-menu -->
                                <ul class="dt-side-nav__sub-menu">
                                    @if($PublicFunction::checkPermission($userPermission, ["add_coupon", "update_coupon", "view_coupon", "delete_coupon"]))
                                        <li class="dt-side-nav__item">
                                            <a href="{{route('admin.view-coupon')}}" class="dt-side-nav__link" title="Add Category">
                                                <i class="icon icon-components icon-fw icon-lg"></i>
                                                <span class="dt-side-nav__text">Coupon</span>
                                            </a>
                                        </li>
                                    @endif

                                    @if($PublicFunction::checkPermission($userPermission, ["add_purchase_discount", "update_purchase_discount", "view_purchase_discount", "delete_purchase_discount"]))
                                        <li class="dt-side-nav__item">
                                            <a href="{{route('admin.view-purchase-discount')}}" class="dt-side-nav__link" title="View Category">
                                                <i class="icon icon-datatable icon-fw icon-lg"></i>
                                                <span class="dt-side-nav__text">Purchase discount</span>
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                                <!-- /sub-menu -->
                            </li>
                        @endif

                        <!-- /menu item -->
                        @if($PublicFunction::checkPermission($userPermission, ["add_slider", "update_slider", "view_slider", "delete_slider", "about_us", "contact_us", "privacy_&_policy", "terms_&_condition", "add_blog", "update_blog", "view_blog", "delete_blog", "add_gallery", "update_gallery", "view_gallery", "delete_gallery", "career"]))
                            <li class="dt-side-nav__item dt-side-nav__header">
                                <span class="dt-side-nav__text">CMS</span>
                            </li>
                        @endif
                        @if($PublicFunction::checkPermission($userPermission, ["add_slider", "update_slider", "view_slider", "delete_slider"]))
                        <!-- Menu Item -->
                            <li class="dt-side-nav__item">
                                <a href="javascript:void(0)" class="dt-side-nav__link dt-side-nav__arrow" title="Slider">
                                    <i class="icon icon-widgets icon-fw icon-lg"></i>
                                    <span class="dt-side-nav__text">Home Slider</span>
                                </a>
                                <!-- Sub-menu -->
                                <ul class="dt-side-nav__sub-menu">
                                    @if($PublicFunction::checkPermission($userPermission, ["add_slider"]))
                                        <li class="dt-side-nav__item">
                                            <a href="{{route('admin.create-slider')}}" class="dt-side-nav__link" title="Create New">
                                                <i class="icon icon-tables icon-fw icon-lg"></i>
                                                <span class="dt-side-nav__text">Create Slider</span>
                                            </a>
                                        </li>
                                    @endif
                                    @if($PublicFunction::checkPermission($userPermission, ["update_slider", "view_slider", "delete_slider"]))
                                        <li class="dt-side-nav__item">
                                            <a href="{{route('admin.view-slider')}}" class="dt-side-nav__link" title="View Recipe">
                                                <i class="icon icon-datatable icon-fw icon-lg"></i>
                                                <span class="dt-side-nav__text">View Slider</span>
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                                <!-- /sub-menu -->
                            </li>
                        @endif

                        @if($PublicFunction::checkPermission($userPermission, ["about_us", "contact_us", "privacy_&_policy", "terms_&_condition"]))
                            <li class="dt-side-nav__item">
                                <a href="javascript:void(0)" class="dt-side-nav__link dt-side-nav__arrow"
                                   title="Basic Components">
                                    <i class="icon icon-basic-components icon-fw icon-lg"></i>
                                    <span class="dt-side-nav__text">CMS</span>
                                </a>

                                <!-- Sub-menu -->
                                <ul class="dt-side-nav__sub-menu">
                                    @if($PublicFunction::checkPermission($userPermission, ["career"]))
                                        <li class="dt-side-nav__item">
                                            <a href="{{ route('admin.career') }}" class="dt-side-nav__link" title="career">
                                                <i class="icon icon-alert icon-fw icon-lg"></i>
                                                <span class="dt-side-nav__text">Career</span>
                                            </a>
                                        </li>
                                    @endif
                                    @if($PublicFunction::checkPermission($userPermission, ["contact_us"]))
                                        <li class="dt-side-nav__item">
                                            <a href="{{ route('admin.contact_us') }}" class="dt-side-nav__link" title="Contact Us">
                                                <i class="icon icon-badges icon-fw icon-lg"></i>
                                                <span class="dt-side-nav__text">Contact Us</span>
                                            </a>
                                        </li>
                                    @endif
                                    @if($PublicFunction::checkPermission($userPermission, ["privacy_&_policy"]))
                                        <li class="dt-side-nav__item">
                                            <a href="{{ route('admin.privacy_policy') }}" class="dt-side-nav__link" title="Privancy Policy">
                                                <i class="icon icon-breadcrumbs icon-fw icon-lg"></i>
                                                <span class="dt-side-nav__text">Privancy Policy</span>
                                            </a>
                                        </li>
                                    @endif
                                    @if($PublicFunction::checkPermission($userPermission, ["terms_&_condition"]))
                                        <li class="dt-side-nav__item">
                                            <a href="{{ route('admin.terms-condition') }}" class="dt-side-nav__link" title="Button">
                                                <i class="icon icon-button icon-fw icon-lg"></i>
                                                <span class="dt-side-nav__text">Terms & Condition</span>
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                                <!-- /sub-menu -->
                            </li>
                        @endif
                        @if($PublicFunction::checkPermission($userPermission, ["add_blog", "update_blog", "view_blog", "delete_blog"]))
                            <li class="dt-side-nav__item">
                                <a href="javascript:void(0)" class="dt-side-nav__link dt-side-nav__arrow" title="Blog">
                                    <i class="icon icon-tables icon-fw icon-lg"></i>
                                    <span class="dt-side-nav__text">Blog</span>
                                </a>

                                <!-- Sub-menu -->
                                <ul class="dt-side-nav__sub-menu">
                                    @if($PublicFunction::checkPermission($userPermission, ["add_blog"]))
                                        <li class="dt-side-nav__item">
                                            <a href="{{route('admin.create-recipe')}}" class="dt-side-nav__link" title="Create New">
                                                <i class="icon icon-tables icon-fw icon-lg"></i>
                                                <span class="dt-side-nav__text">Create New</span>
                                            </a>
                                        </li>
                                    @endif
                                    @if($PublicFunction::checkPermission($userPermission, ["update_blog", "view_blog", "delete_blog"]))
                                        <li class="dt-side-nav__item">
                                            <a href="{{route('admin.view-recipe')}}" class="dt-side-nav__link" title="View Blog">
                                                <i class="icon icon-datatable icon-fw icon-lg"></i>
                                                <span class="dt-side-nav__text">View Blog</span>
                                            </a>
                                        </li>
                                        @endif
                                </ul>
                                <!-- /sub-menu -->
                            </li>
                        @endif

                        @if($PublicFunction::checkPermission($userPermission, ["add_gallery", "update_gallery", "view_gallery", "delete_gallery"]))
                            <li class="dt-side-nav__item">
                                <a href="javascript:void(0)" class="dt-side-nav__link dt-side-nav__arrow" title="Recipe">
                                    <i class="icon icon-tables icon-fw icon-lg"></i>
                                    <span class="dt-side-nav__text">Gallery</span>
                                </a>
                                <!-- Sub-menu -->
                                <ul class="dt-side-nav__sub-menu">
                                    @if($PublicFunction::checkPermission($userPermission, ["add_gallery"]))
                                        <li class="dt-side-nav__item">
                                            <a href="{{route('admin.add-gallery')}}" class="dt-side-nav__link" title="Create New">
                                                <i class="icon icon-tables icon-fw icon-lg"></i>
                                                <span class="dt-side-nav__text">Add Gallery</span>
                                            </a>
                                        </li>
                                    @endif
                                    @if($PublicFunction::checkPermission($userPermission, ["update_gallery", "view_gallery", "delete_gallery"]))
                                        <li class="dt-side-nav__item">
                                            <a href="{{route('admin.view-gallery')}}" class="dt-side-nav__link" title="View Recipe">
                                                <i class="icon icon-datatable icon-fw icon-lg"></i>
                                                <span class="dt-side-nav__text">View Gallery</span>
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                                <!-- /sub-menu -->
                            </li>
                        @endif
                        <!-- /menu item -->
                        <!-- Menu Header -->
                        @if($PublicFunction::checkPermission($userPermission, ["add_user", "update_user", "view_user", "delete_user", "update_permission"]))
                            <li class="dt-side-nav__item dt-side-nav__header">
                                <span class="dt-side-nav__text">User Management</span>
                            </li>
                        @endif
                        <!-- /menu header -->
                        <!-- /menu header -->
                        @if($PublicFunction::checkPermission($userPermission, ["add_user", "update_user", "view_user", "delete_user"]))
                            <li class="dt-side-nav__item">
                                <a href="javascript:void(0)" class="dt-side-nav__link dt-side-nav__arrow" title="Widgets">
                                    <i class="icon icon-users icon-fw icon-lg"></i>
                                    <span class="dt-side-nav__text">Users</span>
                                </a>

                                <!-- Sub-menu -->
                                <ul class="dt-side-nav__sub-menu">
                                    @if($PublicFunction::checkPermission($userPermission, ["add_user"]))
                                        <li class="dt-side-nav__item">
                                            <a href="{{route('admin.add-user')}}" class="dt-side-nav__link" title="Add Users">
                                                <i class="icon icon-components icon-fw icon-lg"></i>
                                                <span class="dt-side-nav__text">Add Users</span>
                                            </a>
                                        </li>
                                    @endif

                                    @if($PublicFunction::checkPermission($userPermission, ["update_user", "view_user", "delete_user"]))
                                        <li class="dt-side-nav__item">
                                            <a href="{{route('admin.view-user')}}" class="dt-side-nav__link" title="View Users">
                                                <i class="icon icon-datatable icon-fw icon-lg"></i>
                                                <span class="dt-side-nav__text">View Users</span>
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                                <!-- /sub-menu -->
                            </li>
                        @endif

                        @if($PublicFunction::checkPermission($userPermission, ["update_permission"]))
                            <li class="dt-side-nav__item">
                                <a href="{{route('admin.permission')}}" class="dt-side-nav__link" title="Permission">
                                    <i class="icon icon-basic-components icon-fw icon-lg"></i>
                                    <span class="dt-side-nav__text">Permission Manage</span>
                                </a>
                                <!-- /sub-menu -->
                            </li>
                        @endif
                    <!-- Menu Header -->
                    </ul>
                    <!-- /sidebar navigation -->

                </div>
            </aside>
            <!-- /sidebar -->

            <!-- Site Content Wrapper -->
            @yield('content')
            <!-- /site content wrapper -->


        </main>
    </div>
</div>
<!-- /root -->

<!-- Optional JavaScript -->


<script src="{{asset('admin/node_modules/moment/moment.js')}}"></script>
<script src="{{asset('admin/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
<!-- PerfectScrollbar jQuery -->
<script src="{{asset('admin/node_modules/perfect-scrollbar/dist/perfect-scrollbar.min.js')}}"></script>
<!-- /perfect scrollbar jQuery -->

<!-- masonry script -->
<script src="{{asset('admin/node_modules/masonry-layout/dist/masonry.pkgd.min.js')}}"></script>
<script src="{{asset('admin/node_modules/sweetalert2/dist/sweetalert2.js')}}"></script>
<script src="{{asset('admin/assets/js/functions.js')}}"></script>
<script src="{{asset('admin/assets/js/customizer.js')}}"></script>
<!-- Custom JavaScript -->
<script src="{{asset('admin/node_modules/chartist/dist/chartist.min.js')}}"></script>
<script src="{{asset('admin/node_modules/owl.carousel/dist/owl.carousel.min.js')}}"></script>
<script src="{{asset('admin/assets/js/script.js')}}"></script>

<script>
  $(document).ready( function () {
    var current_path = window.location.href;
    var $current_menu = $('a[href="' + current_path + '"]');
    $current_menu.addClass('active').parents('.nav-item').find('> .nav-link').addClass('active');

    if ($current_menu.length > 0) {
      $('.dt-side-nav__item').removeClass('open');

      if ($current_menu.parents().hasClass('dt-side-nav__item')) {
        $current_menu.parents('.dt-side-nav__item').addClass('open selected');
      } else {
        $current_menu.parent().addClass('active').parents('.dt-side-nav__item').addClass('open selected');
      }
    }
  })
</script>

@yield('script')



</body>
</html>3