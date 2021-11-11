@extends('layouts.default_layout')

@section('content')
    <!--Privacy Policy area start-->
        <div class="privacy_policy_main_area">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="title only-title">
                            <h1>Privacy Policy</h1>
                        </div>
                    </div>
                </div>
                @if(!empty($privacy) && $privacy->count())
                <div class="row">
                    <div class="col-12">
                        <div class="privacy_content section_2">
                            <p>
                                {!! $privacy->des !!}
                            </p>
                        </div>
                    </div>
                </div>
                    @else
                        <div class="not_found text-center">
                            <img src="{{ asset('default/assets/img/service/not_foud.jpg') }}" alt="not found">
                            {{--<h1>No Blog  found</h1>--}}
                        </div>
                @endif
            </div>
        </div>
    <!--Privacy Policy area end-->
@endsection

@section('script')

@endsection