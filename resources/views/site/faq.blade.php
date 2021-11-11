@extends('layouts.default_layout')

@section('content')
    <!--Accordion area-->
    <div class="accordion_area mt-60">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div id="accordion" class="card__accordion">
                        <div class="card card_dipult">
                            <div class="card-header card_accor" id="headingOne">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    How to order?

                                    <i class="fa fa-plus"></i>
                                    <i class="fa fa-minus"></i>

                                </button>

                            </div>

                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                                <div class="card-body">
                                    <p> <strong>Step 1</strong> <br>

                                        Choose your favourite flavor of ice-creams from the wide range of igloo ice-creams. Then press the “ADD TO CART” button.
                                        <br>
                                        <strong>Step 2</strong><br>

                                        You can either choose to continue your ice-cream shopping or view your cart. To continue your shopping please click the “Continue Shopping” button or if you wish to view your selected items click the “View Cart” button.
                                        <br>
                                        <strong>Step 3</strong> <br>

                                        If you have a coupon code you can input the coupon code and press the “Apply Coupon” button to get a discount on your purchase.
                                        <br>
                                        <strong>Step 4</strong><br>

                                        If you are done shopping for ice-creams you can press the “Proceed To Checkout” button to continue to place your order.
                                        <br>
                                        <strong>Step 5</strong><br>

                                        Fill up your personal info and billing info. Once you are done, select your preferred payment method and select the “Proceed Now” button.
                                        <br>
                                        <strong>Step 6</strong><br>

                                        Once you have successfully placed your order you will get a confirmation text and once your order is confirmed you will get a call from us.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="card  card_dipult">
                            <div class="card-header card_accor" id="headingTwo">
                                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Payment methods?
                                    <i class="fa fa-plus"></i>
                                    <i class="fa fa-minus"></i>

                                </button>
                            </div>
                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                                <div class="card-body">
                                    <p>You can pay cash on delivery and you can also use online payment methods like card/bkash</p>
                                </div>
                            </div>
                        </div>
                        <div class="card  card_dipult">
                            <div class="card-header card_accor" id="headingThree">
                                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    What is the delivery cost?
                                    <i class="fa fa-plus"></i>
                                    <i class="fa fa-minus"></i>
                                </button>
                            </div>
                            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                                <div class="card-body">
                                    <p>No extra delivery charge within Dhaka Metropolitan City.</p>
                                </div>
                            </div>
                        </div>
                        <div class="card  card_dipult">
                            <div class="card-header card_accor" id="headingfour">
                                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseeight" aria-expanded="false" aria-controls="collapseeight">
                                    How will I be confirmed about my order?
                                    <i class="fa fa-plus"></i>
                                    <i class="fa fa-minus"></i>
                                </button>
                            </div>
                            <div id="collapseeight" class="collapse" aria-labelledby="headingfour" data-parent="#accordion">
                                <div class="card-body">
                                    <p>Once you have placed your order you would be notified by a text and once your order has been confirmed you will be called by our customer service to confirm the order.</p>
                                </div>
                            </div>
                        </div>
                        <div class="card  card_dipult">
                            <div class="card-header card_accor" id="headingfive">
                                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseseven" aria-expanded="false" aria-controls="collapseseven">
                                    Can I order outside of Dhaka City?
                                    <i class="fa fa-plus"></i>
                                    <i class="fa fa-minus"></i>
                                </button>
                            </div>
                            <div id="collapseseven" class="collapse" aria-labelledby="headingfive" data-parent="#accordion">
                                <div class="card-body">
                                    <p>Currently, our home delivery services are only within Dhaka Metropolitan City.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Accordion area end-->
    <!--faq area end-->
@endsection

@section('script')

@endsection