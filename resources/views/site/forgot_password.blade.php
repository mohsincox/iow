@extends('layouts.default_layout')

@section('content')
    <div class="customer_login mt-60">
        <div class="container">
            <div class="row">
                <!--register area start-->
                <div class="offset-lg-3 col-lg-6 offset-md-2 col-md-8">
                    <div class="account_form">
                        <h2>Reset Password</h2>
                        <form method="post" action="{{ route('forgot-password') }}" id="reset-password">
                            <div class="form-group">
                                <label for="email">Email*</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" value="{{old('email')}} placeholder="Enter your email" required>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                        <p>Back to <a href="{{ route('signin') }}" class="dark_pink">Login</a></p>
                    </div>
                </div>
                <!--register area start-->
            </div>
        </div>
    </div>

@endsection

@section('script')

@endsection