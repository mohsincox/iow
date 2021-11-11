@extends('layouts.default_layout')


@section('stylesheet')
    <style>
        .is-invalid{
            border: 1px solid #ff0018 !important;
        }
        .invalid-feedback{
            display: block!important;
        }
    </style>
@endsection
@section('content')
    <!--Checkout page section-->
    <div class="Checkout_section mt-60">
        <div class="container">
            @if(session()->has('status'))
                {!! session()->get('status') !!}
            @endif
            @if(Cart::count() > 0)
                <div class="row">
                    <div class="col-12">
                        <div class="table_desc">
                            <div class="cart_page table-responsive">
                                <table>
                                    <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th class="product_name">Product</th>
                                        <th class="product-price">Price</th>
                                        <th class="product_quantity">Quantity</th>
                                        <th class="product_total">Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach(Cart::content() as $row)
                                        <tr>
                                            <td><a href="{{ route('product-details', $row->id) }}"><img src="{{ asset($row->options['image']) }}" width="35px" height="35px" alt=""></a></td>
                                            <td class="product_name"><a href="{{ route('product-details', $row->id) }}">{{ $row->name }}</a></td>
                                            <td class="product-price">Tk {{ $row->price }}</td>
                                            <td class="product_quantity">{{ $row->qty }}</td>
                                            <td class="product_total">Tk {{ $row->subtotal }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                    </div>
                    <div class="col-lg-6 col-md-6 mb-5">
                        <div class="coupon_code right">
                            <div class="coupon_inner">
                                <div class="cart_subtotal">
                                    <p>Subtotal</p>
                                    <p class="cart_amount">Tk {{ Cart::subtotal() }}</p>
                                </div>
                                <div class="cart_subtotal ">
                                    <p>Delivery charge</p>
                                    <p class="cart_amount">Tk {{ $deliveryCharge }}</p>
                                </div>
                                <div class="cart_subtotal">
                                    <p>TOTAL Discount</p>
                                    <p class="cart_amount">Tk {{ filter_var(Cart::subtotal(), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) - Session::get('total_price') + $deliveryCharge }}</p>
                                </div>
                                <div class="cart_subtotal">
                                    <p>TOTAL</p>
                                    <p class="cart_amount">Tk {{ Session::get('total_price') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            {{--@if(!Auth::user())--}}
            {{--<div class="row">--}}
                {{--<div class="col-12">--}}
                    {{--<div class="user-actions">--}}
                        {{--<h3>--}}
                            {{--<i class="fa fa-file-o" aria-hidden="true"></i>--}}
                            {{--Returning customer?--}}
                            {{--<a class="Returning" href="#" data-toggle="collapse" data-target="#checkout_login" aria-expanded="true">Click here to login</a>--}}

                        {{--</h3>--}}
                        {{--<div id="checkout_login" class="collapse" data-parent="#accordion">--}}
                            {{--<div class="checkout_info">--}}
                                {{--<p>If you have shopped with us before, please enter your details in the boxes below. If you are a new customer please proceed to the Billing & Shipping section.</p>--}}
                                {{--<form action="{{ route('checkout-login') }}" method="post">--}}
                                    {{--@csrf--}}
                                    {{--<div class="form_group">--}}
                                        {{--<label>Email Or Phone <span>*</span></label>--}}
                                        {{--<input type="text" name="emailOrPhone" placeholder="Enter your email">--}}
                                    {{--</div>--}}
                                    {{--<div class="form_group">--}}
                                        {{--<label>Password  <span>*</span></label>--}}
                                        {{--<input type="password" name="password" placeholder="*******">--}}
                                    {{--</div>--}}
                                    {{--<div class="form_group group_3 ">--}}
                                        {{--<button type="submit">Login</button>--}}
                                    {{--</div>--}}
                                    {{--<a href="{{ route('forgot-password') }}">Lost your password?</a>--}}
                                {{--</form>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                {{--</div>--}}
            {{--</div>--}}
            {{--@endif--}}
            <div class="checkout_form">
                <form action="{{ route('place.order') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <h3>Billing Details</h3>
                            <div class="row">
                                <div class="col-12 mb-20 mt-3">
                                    <label>Name<span>*</span></label>
                                    <input type="text" name="billing_name" placeholder="Enter your name" required value="{{ old('billing_name') }}" class="@error('billing_name') is-invalid @enderror ">
                                    @error('billing_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-lg-6 mb-20">
                                    <label>Phone<span>*</span></label>
                                    <input type="tel" name="billing_phone" placeholder="Enter your phone number" required value="{{ old('billing_phone') }}" class="@error('billing_phone') is-invalid @enderror ">
                                    @error('billing_phone')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>
                                {{--<div class="col-lg-6 mb-20">--}}
                                    {{--<label> Email <span>*</span></label>--}}
                                    {{--<input type="email" name="billing_email" placeholder="Enter your email" value="{{ old('billing_email') }}" class="@error('billing_email') is-invalid @enderror ">--}}
                                    {{--@error('billing_email')--}}
                                    {{--<span class="invalid-feedback" role="alert">--}}
                                            {{--<strong>{{ $message }}</strong>--}}
                                        {{--</span>--}}
                                    {{--@enderror--}}
                                {{--</div>--}}
                                <!--<div class="col-12 mb-20">-->
                                <!--    <label>Company Name</label>-->
                                <!--    <input type="text" name="billing_company_name" placeholder="Enter your company name" value="{{ old('billing_company_name') }}" class="@error('billing_company_name') is-invalid @enderror ">-->
                                <!--    @error('billing_company_name')-->
                                <!--    <span class="invalid-feedback" role="alert">-->
                                <!--            <strong>{{ $message }}</strong>-->
                                <!--        </span>-->
                                <!--    @enderror-->
                                <!--</div>-->
                                <div class="col-12 mb-20">
                                    <label for="country">Country <span>*</span></label>
                                    <select  name="billing_country" id="country" required class="niceselect_option @error('billing_country') is-invalid @enderror ">>
                                        <option value="Bangladesh" @if(old('billing_country') == "Bangladesh") selected @endif >Bangladesh</option>
                                        <option value="Algeria" @if(old('billing_country') == "Algeria") selected @endif >Algeria</option>
                                        <option value="Afghanistan" @if(old('billing_country') == "Afghanistan") selected @endif >Afghanistan</option>
                                        <option value="Ghana" @if(old('billing_country') == "Ghana") selected @endif >Ghana</option>
                                        <option value="Albania" @if(old('billing_country') == "Albania") selected @endif >Albania</option>
                                        <option value="Bahrain" @if(old('billing_country') == "Bahrain") selected @endif >Bahrain</option>
                                        <option value="Colombia" @if(old('billing_country') == "Colombia") selected @endif >Colombia</option>
                                        <option value="Dominican Republic" @if(old('billing_country') == "Dominican Republic") selected @endif >Dominican Republic</option>
                                    </select>
                                    @error('billing_country')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-12 mb-20">
                                    <label>Address  <span>*</span></label>
                                    <input placeholder="House number and street name" type="text" name="billing_address" required value="{{ old('billing_address') }}" class="@error('billing_address') is-invalid @enderror ">
                                    @error('billing_address')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-12 mb-20">
                                    <input placeholder="Apartment, suite, unit etc. (optional)" type="text" name="billing_appartment" value="{{ old('billing_appartment') }}" class="@error('billing_appartment') is-invalid @enderror ">
                                    @error('billing_appartment')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-12 mb-20">
                                    <label>Town / City <span>*</span></label>
                                    <input  type="text" name="billing_city" placeholder="Enter your city or town" required readonly value="Dhaka" class="@error('billing_city') is-invalid @enderror ">
                                    @error('billing_city')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                {{--<div class="col-12 mb-20">--}}
                                    {{--<label>Postal code <span></span></label>--}}
                                    {{--<input type="text" name="billing_postal_code" placeholder="Enter your postal code" value="{{ old('billing_postal_code') }}" class="@error('billing_postal_code') is-invalid @enderror ">--}}
                                    {{--@error('billing_postal_code')--}}
                                    {{--<span class="invalid-feedback" role="alert">--}}
                                            {{--<strong>{{ $message }}</strong>--}}
                                        {{--</span>--}}
                                    {{--@enderror--}}
                                {{--</div>--}}
                                 {{--@if(!Auth::user())--}}
                                    {{--<div class="col-12 mb-20">--}}
                                        {{--<input id="account" name="billing_isPassword" type="checkbox" @if(old('billing_isPassword')) checked @endif--}}
                                            {{--data-target="#collapseOne" data-toggle="collapse" />--}}
                                        {{--<label for="account" data-toggle="collapse" data-target="#collapseOne" aria-controls="collapseOne">Create an account?</label>--}}

                                        {{--<div id="collapseOne" class="collapse one" style="@error('billing_password') display: block @enderror" data-parent="#accordion">--}}
                                            {{--<div class="card-body1">--}}
                                                {{--<label>Password   <span>*</span></label>--}}
                                                {{--<input type="password" name="billing_password" placeholder="*******" value="{{ old('billing_password') }}" class="@error('billing_password') is-invalid @enderror ">--}}
                                                {{--@error('billing_password')--}}
                                                {{--<span class="invalid-feedback" role="alert">--}}
                                                    {{--<strong>{{ $message }}</strong>--}}
                                                {{--</span>--}}
                                                {{--@enderror--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--@endif--}}

                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="col-12 mb-20">
                                <input id="shipping_isShow" name="shipping_isShow" @if(old('shipping_isShow')) checked @endif
                                       type="checkbox" data-target="#collapsetwo" data-toggle="collapse"/>
                                <label class="righ_0" for="shipping_isShow" data-toggle="collapse" data-target="#collapsetwo" aria-controls="collapseOne"><h3>Ship to a different address</h3></label>

                                <div id="collapsetwo" class="collapse one" style="@if(old('shipping_isShow')) display: block @endif" data-parent="#accordion">
                                    <div class="row">
                                        <div class="col-12 mb-20 mt-3">
                                            <label>Name<span>*</span></label>
                                            <input type="text" name="shipping_name" placeholder="Enter your name" value="{{ old('shipping_name') }}" class="@error('shipping_name') is-invalid @enderror ">
                                            @error('shipping_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-lg-6 mb-20">
                                            <label>Phone<span>*</span></label>
                                            <input type="tel" name="shipping_phone" placeholder="Enter your phone number" value="{{ old('shipping_phone') }}" class="@error('shipping_phone') is-invalid @enderror ">
                                            @error('shipping_phone')
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror

                                        </div>
                                        {{--<div class="col-lg-6 mb-20">--}}
                                            {{--<label> Email <span>*</span></label>--}}
                                            {{--<input type="email" name="shipping_email" placeholder="Enter your email" value="{{ old('shipping_email') }}" class="@error('shipping_email') is-invalid @enderror ">--}}
                                            {{--@error('shipping_email')--}}
                                            {{--<span class="invalid-feedback" role="alert">--}}
                                                    {{--<strong>{{ $message }}</strong>--}}
                                                {{--</span>--}}
                                            {{--@enderror--}}
                                        {{--</div>--}}
                                        <!--<div class="col-12 mb-20">-->
                                        <!--    <label>Company Name</label>-->
                                        <!--    <input type="text" name="shipping_company_name" placeholder="Enter your company name" value="{{ old('shipping_company_name') }}" class="@error('shipping_company_name') is-invalid @enderror ">-->
                                        <!--    @error('shipping_company_name')-->
                                        <!--    <span class="invalid-feedback" role="alert">-->
                                        <!--        <strong>{{ $message }}</strong>-->
                                        <!--    </span>-->
                                        <!--    @enderror-->
                                        <!--</div>-->
                                        <div class="col-12 mb-20">
                                            <label for="country">Country <span>*</span></label>
                                            <select name="shipping_country" id="country" class="niceselect_option @error('shipping_country') is-invalid @enderror ">
                                                <option value="Bangladesh" @if(old('shipping_country') == "Bangladesh") selected @endif>Bangladesh</option>
                                                <option value="Algeria" @if(old('shipping_country') == "Algeria") selected @endif>Algeria</option>
                                                <option value="Afghanistan" @if(old('shipping_country') == "Afghanistan") selected @endif>Afghanistan</option>
                                                <option value="Ghana" @if(old('shipping_country') == "Ghana") selected @endif>Ghana</option>
                                                <option value="Albania" @if(old('shipping_country') == "Albania") selected @endif>Albania</option>
                                                <option value="Bahrain" @if(old('shipping_country') == "Bahrain") selected @endif>Bahrain</option>
                                                <option value="Colombia" @if(old('shipping_country') == "Colombia") selected @endif>Colombia</option>
                                                <option value="Dominican Republic" @if(old('shipping_country') == "Dominican Republic") selected @endif>Dominican Republic</option>
                                            </select>
                                            @error('shipping_country')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-12 mb-20">
                                            <label>Address  <span>*</span></label>
                                            <input placeholder="House number and street name" name="shipping_address" type="text" value="{{ old('shipping_address') }}" class="@error('shipping_address') is-invalid @enderror ">
                                            @error('shipping_address')
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-12 mb-20">
                                            <input placeholder="Apartment, suite, unit etc. (optional)" name="shipping_appartment" type="text" value="{{ old('shipping_appartment') }}" class="@error('shipping_appartment') is-invalid @enderror ">
                                            @error('shipping_appartment')
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-12 mb-20">
                                            <label>Town / City <span>*</span></label>
                                            <input  type="text" name="shipping_city" placeholder="Enter your city or town" value="Dhaka" readonly class="@error('shipping_city') is-invalid @enderror ">
                                            @error('shipping_city')
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        {{--<div class="col-12 mb-20">--}}
                                            {{--<label>Postal code <span></span></label>--}}
                                            {{--<input type="text" name="shipping_postal_code" placeholder="Enter your postal code" value="{{ old('shipping_postal_code') }}" class="@error('shipping_postal_code') is-invalid @enderror ">--}}
                                            {{--@error('shipping_postal_code')--}}
                                            {{--<span class="invalid-feedback" role="alert">--}}
                                                    {{--<strong>{{ $message }}</strong>--}}
                                                {{--</span>--}}
                                            {{--@enderror--}}
                                        {{--</div>--}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="order-notes">
                                    <label for="order_note">Order Notes</label>
                                    <textarea id="order_note" name="order_note" placeholder="Notes about your order, e.g. special notes for delivery."></textarea>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-12">
                            <h3>Select payment method</h3>
                            <div class="payment_method">
                                <div class="panel-default">
                                    <input id="payment" name="check_method" checked value="COD" selected type="radio" data-target="createp_account" />
                                    <label for="payment" data-toggle="collapse" data-target="#method" aria-controls="method">Cash on delivery</label>
                                </div>
                            </div>

                            <div class="panel-default">
                                <input id="payment_defult" name="check_method" type="radio" value="Online payment" data-target="createp_account" />
                                <label for="payment_defult" data-toggle="collapse" data-target="#collapsedefult" aria-controls="collapsedefult">Online payment<img src="assets/img/icon/papyel.png" class="ml-3" alt=""></label>
                            </div>
                            <div class="order_button">
                                <button  type="submit">Proceed now</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--Checkout page section end-->
@endsection

@section('script')
    <script src="{{ asset('default/assets/js/sweetalert2.js') }}"></script>

    <script>
      $(document).ready(function() {
        $(document).on('change', '#shipping_isShow', function () {
          const item = $(this).prop("checked")
          if (item === "specific_time_period") {
            $('.time_period').removeClass('d-none')
          } else {
            $('.time_period').addClass('d-none')
          }
         // console.log(item)
        })
      })

    </script>
    @if(session()->has('status1'))
        <script>
          Swal.fire({
            icon: 'error',
            title: 'Sorry',
            text: 'You have to login first',
            footer: '<a href="{{route('signin')}}" >Login</a>'
          })
        </script>
    @endif
@endsection