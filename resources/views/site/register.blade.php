@extends('layouts.default_layout')

@section('content')
    <div class="customer_login mt-60">
        <div class="container">
            <div class="row">
                <!--register area start-->
                <div class="offset-lg-1 col-lg-10 col-md-12">
                    <div class="account_form">
                        <div class="account">
                            <div class="social_account">
                                <span class="h5 mb-4">Register through</span>
                                <div class="facebook">
                                    <a href="{{ route('facebook-login') }}"><i class="fa fa-facebook mr-3"></i> Facebbok</a>
                                </div>
                                <div class="gmail">
                                    <a href="{{ route('google-login') }}"><i class="fa fa-envelope mr-3" aria-hidden="true"></i> Gmail</a>
                                </div>
                            </div>
                            <div class="custom_account">
                                <h2>Register manually</h2>
                                @if(session()->has('status'))
                                    {!! session()->get('status') !!}
                                @endif
                                <form method="post" action="{{ route('signup') }}" id="register">
                                    @csrf
                                    <div class="form-group">
                                        <label for="name">Name*</label>
                                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{old('name')}}" placeholder="Enter your name">
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email*</label>
                                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" value="{{old('email')}}" placeholder="Enter your email">
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="phone_number">Phone Number*</label>
                                        <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror" id="phone_number" value="{{old('phone')}}" placeholder="Enter your phone">
                                        @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password*</label>
                                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" value="{{old('password')}}" placeholder="********">
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                   </div>
                                    <div class="form-group">
                                        <label for="confirm_password">Confirm Password*</label>
                                        <input type="password" name="confirm_password" class="form-control @error('confirm_password') is-invalid @enderror" id="confirm_password" value="{{old('confirm_password')}}" placeholder="********">
                                        @error('confirm_password')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-primary">Register</button>
                                </form>
                                <p>Do you have an account? <a href="{{ route('signin') }}" class="dark_pink">Login</a></p>
                            </div>
                        </div>
                    </div>
                </div>
                <!--register area start-->
            </div>
        </div>
    </div>
@endsection

@section('script')

@endsection