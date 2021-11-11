@extends('layouts.default_layout')

@section('content')
    <div class="customer_login mt-60">
        <div class="container">
            <div class="row">
                <!--login area start-->
                <div class="offset-lg-1 col-lg-10 col-md-12">
                    <div class="account_form">
                        <div class="account">
                            <div class="social_account">
                                <span class="h5 mb-4">Login through</span>
                                <div class="facebook">
                                    <a href="{{ route('facebook-login') }}"><i class="fa fa-facebook mr-3"></i> Facebbok</a>
                                </div>
                                <div class="gmail">
                                    <a href="{{ route('google-login') }}"><i class="fa fa-envelope mr-3" aria-hidden="true"></i> Gmail</a>
                                </div>
                            </div>
                            <div class="custom_account">
                                <h2>Login</h2>
                                @if(session()->has('status'))
                                    {!! session()->get('status') !!}
                                @endif
                                <form method="post" action="{{route('signin')}}" id="login">
                                    @csrf
                                    <div class="form-group">
                                        <label for="email">Email or Phone *</label>
                                        <input type="text" name="emailOrPhone" class="form-control @error('emailOrPhone') is-invalid @enderror" id="email" value="{{old('emailOrPhone')}}" placeholder="Enter your email" required>
                                        @error('emailOrPhone')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" value="{{old('password')}}" placeholder="********" required>
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-primary">Login</button>
                                </form>
                                <p>Don't have an account? <a href="{{ route('signup') }}" class="dark_pink">Register</a></p>
                                <a href="{{ route('forgot-password') }}" class="dark_pink fotgot-password">Forgot Password</a>
                            </div>
                        </div>

                    </div>
                </div>
                <!--login area end-->
            </div>
        </div>
    </div>
@endsection

@section('script')

    @endsection