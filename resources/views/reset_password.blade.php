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
    <title>Igloo - Admin login</title>

    <!-- Site favicon -->
    <link rel="shortcut icon" href="{{asset('admin/assets/images/favicon.ico')}}" type="image/x-icon">
    <!-- /site favicon -->

    <!-- Font Icon Styles -->
    <link rel="stylesheet" href="{{asset('admin/node_modules/flag-icon-css/css/flag-icon.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/vendors/gaxon-icon/styles.css')}}">
    <!-- /font icon Styles -->

    <!-- Perfect Scrollbar stylesheet -->
    <link rel="stylesheet" href="{{asset('admin/node_modules/perfect-scrollbar/css/perfect-scrollbar.css')}}">
    <!-- /perfect scrollbar stylesheet -->

    <!-- Load Styles -->
    <link rel="stylesheet" href="{{asset('admin/assets/css/semidark-style-1.min.css')}}">
    <!-- /load styles -->

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

        <!-- Login Container -->
        <div class="dt-login--container">

            <!-- Login Content -->
            <div class="dt-login__content-wrapper">

                <!-- Login Background Section -->
                <div class="dt-login__bg-section">

                    <div class="dt-login__bg-content">
                        <!-- Login Title -->
                        <h1 class="dt-login__title">Reset Password</h1>
                        <!-- /login title -->

                        <p class="f-16">Login in and explore in-built website of Igloo .</p>
                    </div>


                    <!-- Brand logo -->
                    <div class="dt-login__logo">
                        <a class="dt-brand__logo-link" href="index.html">
                            <img class="dt-brand__logo-img" src="{{asset('admin/assets/images/logo.png')}}" alt="Drift">
                        </a>
                    </div>
                    <!-- /brand logo -->

                </div>
                <!-- /login background section -->

                <!-- Login Content Section -->
                <div class="dt-login__content">

                    <!-- Login Content Inner -->
                    <div class="dt-login__content-inner">
                    @if(session()->has('status'))
                        {!! session()->get('status') !!}
                    @endif
                    <!-- Form -->
                        <form action="{{route('reset-password', $token)}} " method="post">
                        @csrf
                        <!-- Form Group -->

                            <!-- Form Group -->
                            <div class="form-group">
                                <label class="sr-only" for="password-1">New Password</label>
                                <input type="password" name="new_password" class="form-control" id="password-1" placeholder="New Password">
                            </div>
                            <div class="form-group">
                                <label class="sr-only" for="password-1">Confirm  Password</label>
                                <input type="password" name="confirm_password" class="form-control" id="password-1" placeholder="Confirm Password">
                            </div>
                            <!-- /form group -->
                            <!-- Form Group -->
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary text-uppercase">Update</button>
                            </div>
                            <!-- /form group -->


                        </form>
                        <!-- /form -->

                    </div>


                </div>
                <!-- /login content section -->

            </div>
            <!-- /login content -->

        </div>
        <!-- /login container -->

    </div>
</div>
<!-- /root -->

<!-- Optional JavaScript -->
<script src="{{asset('admin/node_modules/jquery/dist/jquery.min.js')}}"></script>
<script src="{{asset('admin/node_modules/moment/moment.js')}}"></script>
<script src="{{asset('admin/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
<!-- Perfect Scrollbar jQuery -->
<script src="{{asset('admin/node_modules/perfect-scrollbar/dist/perfect-scrollbar.min.js')}}"></script>
<!-- /perfect scrollbar jQuery -->

<!-- masonry script -->
<script src="{{asset('admin/node_modules/masonry-layout/dist/masonry.pkgd.min.js')}}"></script>
<script src="{{asset('admin/node_modules/sweetalert2/dist/sweetalert2.js')}}"></script>
<script src="{{asset('admin/assets/js/functions.js')}}"></script>
<script src="{{asset('admin/assets/js/customizer.js')}}"></script>
<!-- Custom JavaScript -->
<script src="{{asset('admin/assets/js/script.js')}}"></script>

</body>
</html>