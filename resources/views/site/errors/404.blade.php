
@extends('layouts.default_layout')

@section('stylesheet')
    <style>
        .four_zero_four_found{
            height: 100%;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 60px;
            flex-direction: column;
        }

        .four_zero_four_found img{
            width: 300px;
            opacity: .5;
        }

        .four_zero_four_found h1{
            margin-top: 20px;
            text-align: center;
            background: -webkit-linear-gradient(#f6707b, #ab1d69);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-size: 150px;
            text-transform: uppercase;
        }

        .four_zero_four_found h4{
            font-size: 35px;
            margin-top: 0px;
            color: #be326d;
        }

        .four_zero_four_found p{
            font-size: 20px;
            margin-top: 15px;
            color: #be326d;
        }

        .four_zero_four_found a{
            background: #be326d;
            color: var(--white);
            padding: 10px 25px;
            border-radius: 3px;
            border: 2px solid #bc2a8d;
            transition: .2s;
            font-weight: 500;
            font-size: 16px;
        }

        .four_zero_four_found a:hover{
            background: transparent;
            color: #be326d;
        }

        @media only screen and (max-width: 767px) {

            .four_zero_four_found h1 {
                font-size: 100px;
            }

            .four_zero_four_found h4 {
                font-size: 20px;
            }
        }
    </style>
@endsection
@section('content')
    <div class="error_section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="four_zero_four_found text-center">
                        <img src="{{ asset('default/assets/img/service/not_foud.jpg') }}" alt="not found">
                        <h1>404</h1>
                        <h4>PAGE NOT FOUND</h4>
                        <p>Stay <span id="countdown" class="text-warning"> 5 </span> Seconds <br> <span>OR</span></p>
                        <a href="{{ route('index') }}">Go to Home</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        // setTimeout(function(){
        //     window.location.href = 'https://www.sarosit.com';
        // }, 5000);
        var seconds = 5;

        function countdown() {
            seconds = seconds - 1;
            if (seconds < 0) {
                // Chnage your redirection link here
                window.location = "{{URL::to('/')}}";
            } else {
                // Update remaining seconds
                document.getElementById("countdown").innerHTML = seconds;
                // Count down using javascript
                window.setTimeout("countdown()", 1000);
            }
        }

        // Run countdown function
        countdown();
    </script>
@endsection