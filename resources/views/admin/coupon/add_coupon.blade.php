@inject('PublicFunction', 'App\Http\Controllers\PublicFunction')
@extends('layouts.admin_layout')
@section('title')
    Igloo - Add Coupon
@endsection

<link rel="stylesheet" href="{{ asset('default/assets/fromcdn/tempusdominus-bootstrap-4.min.css') }}" />

@section('content')
    <div class="dt-content-wrapper">

        <!-- Site Content -->
        <!-- Site Content -->
        <div class="dt-content">

            <!-- Page Header -->
            <div class="dt-page__header">
                <h1 class="dt-page__title">Add Coupon</h1>
            </div>
            <!-- /page header -->

            <!-- Grid -->
            <div class="row">
                <!-- Grid Item -->
                <div class="col-12">

                    <!-- Card -->
                    <div class="dt-card">

                        <!-- Card Header -->
                        <div class="dt-card__header">

                        </div>
                        <!-- /card header -->



                        <!-- Card Body -->
                        <div class="dt-card__body">
                            @if($PublicFunction::checkPermission($userPermission, ["view_coupon"]))
                                <div class="text-right">
                                    <a href="{{ route('admin.view-coupon') }}" class="btn btn-primary"><i class="icon icon-breadcrumbs"></i> View Coupon</a>
                                </div>
                            @endif
                            <div class="form-group form-row">
                                <label class="col-md-2 col-sm-3 col-form-label text-sm-right"></label>
                                <div class="col-md-12 col-sm-12">
                                    @if(session()->has('status'))
                                        {!! session()->get('status') !!}
                                    @endif
                                </div>
                            </div>

                            <!-- Form -->
                            <form method="post" action="{{route('admin.add-coupon')}}">
                            @csrf
                            <!-- Form Row -->
                                <div class="form-row">
                                    <div class="col-sm-12 mb-3">
                                        <label for="couponCode">Coupon Code</label>
                                        <div class="input-group">
                                            <input type="text" name="code" id="couponCode" required value="{{old('code')}}" class="form-control text-uppercase @error('code') is-invalid @enderror " maxlength="30">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-primary" type="button" onclick="generateCoupon()">Generate</button>
                                            </div>
                                        </div>
                                        @error('code')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                {{--<div class="form-row">--}}
                                    {{--<div class="col-sm-12 mb-3">--}}
                                        {{--<label>Discount Type</label>--}}
                                        {{--<div class="input-group">--}}
                                            {{--<select name="discount_type" class="form-control" required>--}}
                                                {{--<option value="">-- Choose discount type --</option>--}}
                                                {{--<option value="Fixed">Fixed</option>--}}
                                                {{--<option value="Percentage">Percentage</option>--}}
                                            {{--</select>--}}
                                        {{--</div>--}}
                                        {{--@error('discount-type')--}}
                                        {{--<span class="invalid-feedback" role="alert">--}}
                                                {{--<strong>{{ $message }}</strong>--}}
                                            {{--</span>--}}
                                        {{--@enderror--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                <div class="form-row">
                                    <div class="col-sm-12 mb-3">
                                        <label for="discount">Discount</label>
                                        <div class="input-group">
                                            <input type="text" name="discount" id="discount" required value="{{old('discount')}}" class="form-control @error('discount') is-invalid @enderror ">
                                        </div>
                                        @error('discount')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label for="date-time-picker-6">End Time</label>
                                    <div class="input-group date" id="date-time-picker-6"
                                         data-target-input="nearest">
                                        <input type="text" name="expire_date" placeholder="End Time" class="form-control datetimepicker-input"
                                               data-target="#date-time-picker-6" />
                                        <div class="input-group-append" data-target="#date-time-picker-6"
                                             data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="icon icon-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-sm-12 mb-3">
                                        <label for="is_public">Make this coupon hidden?</label>
                                        <div class="input-group">
                                            <input type="checkbox" name="is_public" id="is_public" value="0" class="@error('is_public') is-invalid @enderror" style="height: 25px; width: 25px;">
                                        </div>
                                        @error('is_public')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="form-group form-row">
                                    <div class="col-sm-12 col-md-2 offset-md-10 col-lg-2 offset-lg-10 pull-right">
                                        <div class="input-group">
                                            <input type="submit" name="submit" class="btn btn-primary" placeholder="Save" style="border: blanchedalmond;width: 100%;padding: 10px;border-radius: 5px;">
                                        </div>
                                    </div>
                                </div>
                                <!-- /form row -->




                            </form>
                            <!-- /form -->

                        </div>
                        <!-- /card body -->

                    </div>
                    <!-- /card -->

                </div>
                <!-- /grid item -->

            </div>
            <!-- /grid -->

        </div>
        <!-- /site content -->

        <!-- Footer -->
        <footer class="dt-footer">
            Copyright Igloo  © 2019
        </footer>
        <!-- /footer -->

    </div>
@endsection

@section('script')
    <!-- Date-time Pickers -->
    <script src="{{ asset('admin/node_modules/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('admin/node_modules/moment/min/locales.min.js') }}"></script>
    <script src="{{  asset('admin/node_modules/tempusdominus-bootstrap-4/build/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script>
        function generateCoupon() {
          $('#couponCode').val(Math.random().toString(36).substr(2, 6));
        }
        $(document).ready(function() {
          $('#date-time-picker-6').datetimepicker({
            locale: 'en',
            icons: calIcons
          });
        });
    </script>
@endsection