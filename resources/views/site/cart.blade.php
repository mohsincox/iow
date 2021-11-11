@extends('layouts.default_layout')


@section('stylesheet')

@endsection
@section('content')
<?php //echo Cart::content(); die(); ?>
    <!--shopping cart area start -->
    <div class="shopping_cart_area mt-60">
        @if(Cart::count() > 0)
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="table_desc">
                            <div class="cart_page table-responsive">
                                 <table>
                                    <thead>
                                    <tr>
                                        <th class="product_remove">Delete</th>
                                        <th class="" style="height: 0px!important; width: 10% !important;">Image</th>
                                        <th class="product_name">Product</th>
                                        <th class="product-price">Price</th>
                                        <th class="product_quantity" style="width: 300px !important;">Quantity</th>
                                        <th class="product_total">Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach(Cart::content() as $row)
                                        <tr>
                                            <td class="product_remove"><a href="{{ route('remove.item', $row->rowId) }}"><i class="fa fa-trash-o"></i></a></td>
                                            <td class="product_thumb" style="height: 100px!important; width: 10% !important;"><a href="{{ route('product-details', $row->id) }}"><img src="{{ asset($row->options['image']) }}" alt=""></a></td>
                                            <td class="product_name"><a href="{{ route('product-details', $row->id) }}">{{ $row->name }}</a></td>
                                            <td class="product-price">Tk {{ $row->price }}</td>
                                            <td class="product_quantity" style="width: 300px !important;">
                                                <form action="{{ route('update.cart')  }}" method="post">
                                                    @csrf
                                                    <label>Quantity</label>
                                                    <input type="hidden" name="rowId" value="{{ $row->rowId }}">
                                                    <a class="btn btn-dark" name="add-to-cart-modal-minus">-</a>
                                                    <input type="number" name="qty" min="1" value="{{ $row->qty }}">
                                                    <a class="btn btn-info" name="add-to-cart-modal-plus">+</a>
                                                    <button type="submit" class="d-none"><i class="fa fa-check" aria-hidden="true"></i></button>
                                                </form>


                                            </td>
                                            <td class="product_total">Tk {{ $row->subtotal }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!--coupon code area start-->
                <div class="coupon_area">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="coupon_code left">
                                <div class="coupon_inner">
                                    <p>Enter your coupon code if you have one.</p>
                                    <form action="{{ route('apply.discount') }}" method="post">
                                        @csrf
                                        <input type="text" name="coupon-code" placeholder="Coupon code" value="{{ old('coupon-code') }}">
                                        <button type="submit">Apply coupon</button>
                                    </form>
                                    @if(Session::get('coupon_status'))
                                        {!! Session::get('coupon_status') !!}
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
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
                                    <!--<div class="text-danger">-->
                                    <!--    We are not taking any order right now due to the emergency situation of country. We will be back soon!-->
                                    <!--</div>-->
                                    @if((Session::get('total_price') - $deliveryCharge) >= 100)
                                        <div class="checkout_btn">
                                            <a href="{{ route('checkout') }}">Proceed to Checkout</a>
                                        </div>
                                    @else
                                        <div class="badge-danger p-2">
                                            You can't order less than 100 taka
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--coupon code area end-->
            </div>
        @else
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="text-center mb-5 checkout_btn">
                            You don't have any item in your cart. Go to <a href="{{ route('products') }}" class="">Shop.</a>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{--@if(count($purchaseDiscountOffer) > 0)--}}
            {{--@foreach($purchaseDiscountOffer As $key => $val)--}}
                {{--<div>Offer Type: {{$val->offer_type}} => Discount: {{ $val->discount }}</div>--}}
            {{--@endforeach--}}
        {{--@endif--}}
    </div>
    <!--shopping cart area end -->
@endsection

@section('script')
    <script>
        $(document).ready(function () {
          $('input[name="qty"]').change(function (e) {
            $(this).parent('form').find('button').removeClass('d-none')
          })
          // clicking on modal plus btn
          $(document).on('click', 'a[name="add-to-cart-modal-plus"]', function () {
            var qu = (Number($(this).parent('form').find('input[name="qty"]').val())+1);
            $(this).parent('form').find('input[name="qty"]').val(qu)
            $(this).parent('form').find('button').removeClass('d-none')
          })
          // clicking on modal minus btn
          $(document).on('click', 'a[name="add-to-cart-modal-minus"]', function () {
            const qu = (Number($(this).parent('form').find('input[name="qty"]').val())-1);
            if(qu > 0) {
              $(this).parent('form').find('input[name="qty"]').val(qu)
              $(this).parent('form').find('button').removeClass('d-none')
            }
          })
        });
    </script>
@endsection