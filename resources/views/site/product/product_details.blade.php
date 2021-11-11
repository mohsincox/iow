@extends('layouts.default_layout')


@section('stylesheet')

@endsection
@section('content')
    <!--product details start-->
    <div class="product_details mt-60 mb-60">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="product-details-tab">
                        <div id="img-1" class="zoomWrapper single-zoom" style="url()">
                            <!-- <a href="#">
                                <img id="zoom1" src="assets/img/product/productbig5.jpg" data-zoom-image="assets/img/product/productbig5.jpg" alt="big-1">
                            </a> -->
                            <img id="zoom1" src="{{ asset($product->original_image) }}" alt="big-1">
                        </div>
                        {{--<div class="single-zoom-thumb">--}}
                            {{--<ul class="s-tab-zoom owl-carousel single-product-active" id="gallery_01">--}}
                                {{--<li>--}}
                                    {{--<img src="{{ asset($product->thumbnail_image) }}" alt="zo-th-1" class="product-image"/>--}}
                                {{--</li>--}}
                                {{--@foreach(explode(",", $product->image) As $key)--}}
                                    {{--<li>--}}
                                        {{--<img src="{{ asset($key) }}" alt="zo-th-1" class="product-image"/>--}}
                                    {{--</li>--}}
                                {{--@endforeach--}}
                            {{--</ul>--}}
                        {{--</div>--}}
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="product_d_right">
                        {{--<form action="#">--}}

                            <h1>{{ $product->name }}</h1>

                            <div class="price_box">
                                <span class="current_price">{{ (isset($product->selling_price)) ? 'TK '.$product->selling_price : "TK ".$product->price }}</span>
                                <span class="old_price">{{ (isset($product->selling_price)) ? 'TK '.$product->price : "" }}</span>

                            </div>
                            <hr>
                            <div class="product_variant">
                                <?php $flv=0 ?>
                                @foreach($product_attributes As $key => $val)
                                    @if($val->name == "Flavor")
                                        @if($flv == 0)
                                            <h3>Available Flavors</h3>
                                        @endif
                                        <span>@if($flv !=0), @endif{{ $val->value }}</span>
                                        <?php $flv++; ?>
                                    @endif
                                @endforeach
                            </div>
                            <div class="product_variant">
                                <?php $vlm=0 ?>
                                @foreach($product_attributes As $k => $val)
                                    @if($val->name == "Volume")
                                        @if($flv == 0)
                                            <h3>Size</h3>
                                        @endif
                                        <span>@if($vlm !=0), @endif{{ $val->value }}</span>
                                        <?php $vlm++; ?>
                                    @endif
                                @endforeach
                            </div>
                            <div class="product_variant quantity">
                                <input type="hidden" class="single-price" value="{{ (isset($product->selling_price)) ? $product->selling_price : $product->price }}">
                                <label>quantity</label>
                                <div class="d-flex ml-4">
                                    <a class="btn btn-dark add-to-cart-modal-minus">-</a>
                                    <input min="1" value="1" id="number" type="number">
                                    <a class="btn btn-info ml-2 add-to-cart-modal-plus">+</a>
                                </div>
                            </div>
                            <div class="product_variant quantity">
                                <label for="message-text"
                                       class="col-form-label">Total Price: </label>
                                <P class="form-control cart-popup-total-price font-weight-bold text-bold" disabled type="text">{{ (isset($product->selling_price)) ? $product->selling_price.' TK' : $product->price.' TK' }}</P>
                            </div>
                            <style>
                                .btn-product-details{
                                    min-width: 120px !important;
                                    margin-left: 10px;
                                    font-size: 15px !important;
                                    transition: .3s;
                                    width: 100%;
                                    text-align: center;
                                    padding: 0 12px !important;
                                }

                                @media only screen and (max-width: 767px){
                                    .product_variant.quantity {
                                        align-items: center;
                                        margin-bottom: 20px;
                                        flex-direction: column;
                                    }

                                    .product_variant.quantity button, .product_variant.quantity a{
                                        width: 100%;
                                        margin-bottom: 10px;
                                    }
                                }

                                @media only screen and (min-width: 768px )and (max-width: 991px){
                                    .product_variant.quantity {
                                        flex-wrap: wrap;
                                        width: 100%;
                                    }
                                    .product_variant.quantity button, .product_variant.quantity a{
                                        margin-bottom: 10px;
                                        text-align: center;
                                    }
                                }
                                .btn-product-details:hover{
                                    color: #fff;
                                    background: #8C0087 !important;
                                }
                            </style>
                            <div class="product_variant quantity ">
                                <button class="button shopping_cart_link btn-product-details" id="{{ $product->id }}" type="submit" style="text-transform: uppercase">add to cart</button>
                                <a href="{{ route('products') }}" class="button btn-product-details" style="background: var(--dark-pink)">Continue Shopping</a>
                                <a href="{{ route('cart') }}" class="button btn-product-details" style="background: var(--dark-pink)">View Cart</a>
                            </div>
                        {{--</form>--}}

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--product details end-->

    <div class="product_d_info mb-60">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="product_d_inner">
                        <div class="product_info_button">
                            <ul class="nav" role="tablist">
                                <li >
                                    <a class="active" data-toggle="tab" href="#info" role="tab" aria-controls="info" aria-selected="false">Description</a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="info" role="tabpanel" >
                                <div class="product_info_content">
                                    <p>{{ $product->description }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('default/assets/js/sweetalert2.js') }}"></script>

    <script>

        $(document).ready(function () {
            // image zoom
            $('.main-product-img').okzoom({
                width: 200,
                height: 200,
                round: true,
                background: "#fff",
                backgroundRepeat: "repeat",
                shadow: "0 0 5px #000",
                border: "1px solid black"
            });

            // change product image
            $('.product-image').on('click', function(){
                var $this = $(this);
                var src = $this.attr('src');
                $('.main-product-img').attr('src', src);
                $(".product-image").each(function() {
                    if($(this).attr('src') == src){
                        $(this).addClass('active-product-img');
                    }else{
                        $(this).removeClass('active-product-img');
                    }
                });
            });

        })
    </script>

    <script>
      const publicPath = "{{ URL::to('/') }}";

      $(document).ready(function() {

        $(document).on('click', '.shopping_cart_link', function () {
          const productID = $(this).attr("id");
          const quantity = $('#number').val()
            // console.log(quantity)

          $.ajax({
            url: "{{ url('/add-to-cart') }}/"+productID+"?quantity="+quantity,
            method: "get",
            dataType: "json",
            success: function (data) {
              // console.log(data)
              if (data != undefined) {
                //if error
                if (data.error) {
                  if(data.error === "Failed") {
                    Swal.fire({
                      position: 'center',
                      icon: 'warning',
                      title:"Sorry",
                      text: 'Something went wrong!',
                      showConfirmButton: false,
                      timer: 1500,
                      toast: false,
                    })
                  }else{
                    Swal.fire({
                      position: 'center',
                      icon: 'warning',
                      title:"Sorry",
                      text: 'We are not taking any order at this time. Please come back with in 10 AM to 07 PM!',
                      showConfirmButton: false,
                      timer: 5000,
                      toast: false,
                    })
                  }
                } else {
                  // display toast message
                  Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Ice cream added success!',
                    showConfirmButton: false,
                    timer: 1500,
                    toast: true,

                  })
                  // change cart item number in top menu
                  if ($('.cart_quantity').length > 0) {
                    $('.cart_quantity').html(data.totalItem);
                  }
                  // format minicart design
                  if ($('.mini_cart_scrool').length > 0) {
                    let output = '';
                    $.each(data.content, function (i, e) {
                      output += '<div class="cart_item">\n';
                      output += '                                    <div class="cart_img">\n';
                      output += '                                        <a href="#"><img src="' + publicPath + '/' + e.options.image + '" alt=""></a>\n';
                      output += '                                    </div>\n';
                      output += '                                    <div class="cart_info">\n';
                      output += '                                        <a href="#">' + e.name + '</a>\n';
                      output += '                                        <p>Qty: ' + e.qty + ' X <span> Tk' + e.price + ' </span></p>\n';
                      output += '                                    </div>\n';
                      output += '                                    <div class="cart_remove">\n';
                      output += '                                        <a href="{{ URL::to('remove-cart-item') }}/' + e.rowId + '"><i class="ion-android-close"></i></a>\n';
                      output += '                                    </div>\n';
                      output += '                                </div>';
                    });
                    output += '<div class="mini_cart_table">\n' +
                      '                                    <div class="cart_total mt-10">\n' +
                      '                                        <span>Total:</span>\n' +
                      '                                        <span class="price">TK ' + data.total + '</span>\n' +
                      '                                    </div>\n' +
                      '                                </div>';
                    output += '<div class="mini_cart_footer">\n' +
                      '                                    <div class="cart_button">\n' +
                      '                                        <a href="{{ route('cart') }}">View cart</a>\n' +
                      '                                    </div>\n' +
                      {{--'                                    <div class="cart_button">\n' +--}}
                      {{--'                                        <a href="{{ route("checkout") }}">Checkout</a>\n' +--}}
                      {{--'                                    </div>\n' +--}}
                      '\n' +
                      '                                </div>';
                    $('.mini_cart_scrool').html(output);
                  }
                }
              }
            }
          })
        })

        // clicking on modal plus btn
        $(document).on('click', '.add-to-cart-modal-plus', function () {
          const price = parseFloat($('.single-price').val())
          const qu = (Number($('#number').val())+1);
          const newPrice = (price * qu)
          $('#number').val(qu)
          $('.cart-popup-total-price').text(newPrice+" TK")
        })
        // clicking on modal minus btn
        $(document).on('click', '.add-to-cart-modal-minus', function () {
          const price = parseFloat($('.single-price').val())
          const qu = (Number($('#number').val())-1);
          if(qu > 0) {
            const newPrice = (price * qu)
            $('#number').val(qu)
            $('.cart-popup-total-price').text(newPrice + " TK")
          }
        })
        // on change
        $(document).on('change', '#number', function () {
          const price = parseFloat($('.single-price').val())
          const qu = Number($('#number').val());
          const newPrice = (price * qu)
          $('.cart-popup-total-price').text(newPrice+" TK")
        })
        // on key press
        $(document).on('keyup', '#number', function () {
          const price = parseFloat($('.single-price').val())
          const qu = Number($('#number').val());
          const newPrice = (price * qu)
          $('.cart-popup-total-price').text(newPrice+" TK")
        })
      })
    </script>

@endsection