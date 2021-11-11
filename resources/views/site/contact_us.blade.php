@extends('layouts.default_layout')

@section('content')
    <!--contact area start-->
    <div class="contact_area mt-60">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="title only-title">
                        <h1>Get in Touch</h1>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="contact_message form">
                        <h3>Send us a message</h3>
                        @if(session()->has('status'))
                            {!! session()->get('status') !!}
                        @endif
                        <form action="{{ route('contact-us') }}" method="POST">
                            @csrf
                            <p>
                                <label> Your Name (required)</label>
                                <input name="name" placeholder="Name *" type="text" required>
                            </p>
                            <p>
                                <label>  Your Email (required)</label>
                                <input name="email" placeholder="Email *" type="email" required>
                            </p>
                            <p>
                                <label>  Subject</label>
                                <input name="subject" placeholder="Subject *" type="text" required>
                            </p>
                            <div class="contact_textarea">
                                <label>  Your Message</label>
                                <textarea placeholder="Message *" name="msg"  class="form-control2" required ></textarea>
                            </div>
                            <button type="submit"> Send</button>
                        </form>

                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="contact_message content">
                        <h3>Contact information</h3>
                        <div class="contact_us_info">
                            <div class="get-in-touch">
                                <div class="map-margin">
                                    <img src="{{asset('default/assets/img/icon/map.svg')}}" class="footer_map" alt="map">
                                </div>
                                <div>
                                    Monem Business District 111, Bir Uttam C.R. Dutta Road, Level 13 Karwanbazar, Dhaka-1205, Bangladesh
                                </div>
                            </div>
                            <div class="get-in-touch">
                                <div>
                                    <img src="{{asset('default/assets/img/icon/email.svg')}}" class="footer_map" alt="email">
                                </div>
                                <div>
                                    <a href="mailto:helloigloo@amlbd.com">helloigloo@amlbd.com</a>
                                </div>
                            </div>
                            <div class="get-in-touch">
                                <div>
                                    <img src="{{asset('default/assets/img/icon/call.svg')}}" class="footer_map" alt="call">
                                </div>
                                <div>
                                    <a href="tel:88-02-9632011-13">88-02-9632011-13</a> <a href="tel:88-9632304-10">88-9632304-10</a>
                                </div>
                            </div>
                            <div class="get-in-touch">
                                <div>
                                    <img src="{{asset('default/assets/img/icon/cutomer-support.svg')}}" class="footer_map" alt="customer support">
                                </div>
                                <div>
                                    <a href="tel:16556">16556</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--contact area end-->

    <!--contact map start-->
    <div class="contact_map mt-60">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="map-area">
                        <div id="googleMap">
                            <iframe style="width: 100%;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3651.9594781097617!2d90.39019801481527!3d23.748824384590108!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755b8bd0dde1f87%3A0x6d88e94033cb95c9!2sIgloo%20Ice%20Cream!5e0!3m2!1sen!2sbd!4v1577720259431!5m2!1sen!2sbd" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--contact map end-->

@endsection

@section('script')

@endsection