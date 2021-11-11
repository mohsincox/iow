@extends('layouts.default_layout')


@section('stylesheet')
    <style>
        .career_img{
            width: 100%;
            max-height: 450px;
        }
    </style>
    @endsection
@section('content')
    <!--career area start-->
    <div class="career_area mt-60">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="title">
                        <h1>Igloo Career</h1>
                        <p>Build Your Dreams with Us</p>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-lg-12 col-md-12 mb-60">
                    <img src="{{ asset('default/assets/img/blog/team_igloo.jpg') }}" class="career_img" alt="Igloo team">
                </div>
                @if($career->count() > 0)
                <div class="col-lgh-12 col-md-12 mb-4">
                        {!! $career[0]->des !!}
                </div>
                <div class="col-lg-12 col-md-12">
                    <div class="contact_message form mb-5">
                        @if(session()->has('status'))
                            {!! session()->get('status') !!}
                        @endif
                        <form  action="{{ route('submit-career') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <label> Your Name (required)</label>
                                    <input type="text" name="name" placeholder="Name *" >
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <label>  Your Email (required)</label>
                                    <input type="email" name="email" placeholder="Email *" >
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <label>  Subject</label>
                                    <input type="text" name="subject" placeholder="Subject *" >
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <label>  Upload CV</label>
                                    <input type="file" name="cv" placeholder="Upload CV *" >
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <div class="contact_textarea">
                                        <label>  Your Message</label>
                                        <textarea placeholder="Message *" name="message"  class="form-control2" ></textarea>
                                    </div>
                                    <button type="submit">Send</button>
                                </div>

                            </div>
                        </form>

                    </div>
                </div>
                @else
                    <div class="col-12 text-center">
                        <h3>Sorry We are not offering any job</h3>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <!--career area end-->

@endsection

@section('script')

@endsection