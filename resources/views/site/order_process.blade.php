@extends('layouts.default_layout')

@section('content')
    <!-- image gallery start -->
    <section class="order_process_area mt-60 mb-60">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <ul class="order-process-list">
                        <li class="line"></li>
                        <li class="item">
                            <div class="dots">
                                <div class="middle-dot"></div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 timeline-col left timeline-feature">
                                    <div class="inner">
                                        <div class="date-wrap">
                                            <h2 class="order-step">STEP - 1</h2>
                                        </div>

                                        <div class="photo">
                                            <img src="{{asset('default/assets/img/product/add-to-cart-500X350.jpg')}}" alt="timeline-image-01" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 timeline-col right timeline-info">
                                    <div class="inner">
                                        <div class="content-wrap">
                                            <div class="content-body">
                                                <h6 class="heading">Add to Cart</h6>
                                                <div class="text">
                                                    Choose your favorite flavor of ice-creams from the wide range of igloo ice-creams. Then press the “ADD TO CART” button.</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="item">
                            <div class="dots">
                                <div class="middle-dot"></div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 timeline-col left timeline-feature">
                                    <div class="inner">
                                        <div class="date-wrap">
                                            <h6 class="order-step"> STEP - 2 </h6>
                                        </div>

                                        <div class="photo">
                                            <img src="{{asset('default/assets/img/product/view-cart-500X350.jpg')}}" alt="timeline-image-01" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 timeline-col right timeline-info">
                                    <div class="inner">
                                        <div class="content-wrap">
                                            <div class="content-body">
                                                <h6 class="heading">View Cart</h6>

                                                <div class="text">
                                                    You can either choose to continue your ice-cream shopping or view your cart. To continue your shopping please click the “Continue Shopping” button or if you wish to view your selected items click “View Cart” button.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="item">
                            <div class="dots">
                                <div class="middle-dot"></div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 timeline-col left timeline-feature">
                                    <div class="inner">
                                        <div class="date-wrap">
                                            <h6 class="order-step"> STEP - 3 </h6>
                                        </div>

                                        <div class="photo">
                                            <img src="{{asset('default/assets/img/product/apply-coupon-500X350.jpg')}}" alt="timeline-image-01" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 timeline-col right timeline-info">
                                    <div class="inner">
                                        <div class="content-wrap">
                                            <div class="content-body">
                                                <h6 class="heading">Apply Coupon</h6>

                                                <div class="text">
                                                    If you have a coupon code you can input the coupon code and press “Apply Coupon” button to get a discount on your purchase.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="item">
                            <div class="dots">
                                <div class="middle-dot"></div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 timeline-col left timeline-feature">
                                    <div class="inner">
                                        <div class="date-wrap">
                                            <h6 class="order-step"> STEP - 4 </h6>
                                        </div>

                                        <div class="photo">
                                            <img src="{{asset('default/assets/img/product/process-to-check-500X350.jpg')}}" alt="timeline-image-01" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 timeline-col right timeline-info">
                                    <div class="inner">
                                        <div class="content-wrap">
                                            <div class="content-body">
                                                <h6 class="heading">Process Check Out</h6>

                                                <div class="text">
                                                    If you are done shopping for ice-creams you can press the “Proceed To Checkout” button to continue to place your order.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="item">
                            <div class="dots">
                                <div class="middle-dot"></div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 timeline-col left timeline-feature">
                                    <div class="inner">
                                        <div class="date-wrap">
                                            <h6 class="order-step"> STEP - 5 </h6>
                                        </div>

                                        <div class="photo">
                                            <img src="{{asset('default/assets/img/product/payment-process-500X350.jpg')}}" alt="timeline-image-01" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 timeline-col right timeline-info">
                                    <div class="inner">
                                        <div class="content-wrap">
                                            <div class="content-body">
                                                <h6 class="heading">Payment Process</h6>
                                                <div class="text">
                                                    Fill up your personal info and billing info. Once you are done, select your preferred payment method and select the “Proceed Now” button.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="item">
                            <div class="dots">
                                <div class="middle-dot"></div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 timeline-col left timeline-feature">
                                    <div class="inner">
                                        <div class="date-wrap">
                                            <h6 class="order-step"> STEP - 6 </h6>
                                        </div>

                                        <div class="photo">
                                            <img src="{{asset('default/assets/img/product/done-500X350.jpg')}}" alt="timeline-image-01" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 timeline-col right timeline-info">
                                    <div class="inner">
                                        <div class="content-wrap">
                                            <div class="content-body">
                                                <h6 class="heading">Successfully Done</h6>

                                                <div class="text">
                                                    Once you have successfully placed your order you will get a confirmation text and once your order is confirmed you will get a call from us.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!-- image gallery end -->

@endsection

@section('script')

@endsection