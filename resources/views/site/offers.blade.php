@extends('layouts.default_layout')


@section('stylesheet')

@endsection
@section('content')
    <!-- package area -->

    <section class="package_area mb-60 mt-60">
        <div class="container">
            @if(count($coupons) > 0)
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="title only-title mt-4">
                        <h1>Offers</h1>
                    </div>
                </div>
            </div>
            @endif
            <div class="offers">
                <div class="row">
                    @foreach($coupons as $coupon)
                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6  mb-4">
                        <span class="discount_link">
                            <figure class="card discount_card">
                                <h1>GET <span class="discount_card_color">{{ $coupon->discount }}%</span></h1>
                                <h3>Apply this coupon code while checkout </h3>
                                <h2>{{ $coupon->code }}</h2>
                                <h4>Till : {{ date('d M Y', strtotime($coupon->expire_date)) }} </h4>
                            </figure>
                        </span>
                    </div>
                    @endforeach
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="title only-title mt-4">
                            <h1>Packages</h1>
                        </div>
                    </div>
                    @foreach($packages as $package)
                    <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4 mb-4">
                        <figure class="card">
                            <div class="product_thumb">
                                <a class="primary_img packages_thumb_img card-img-top" href="{{ route('product-details',$package->slug) }}"><img src="{{ asset($package->thumbnail_image) }}" alt=""></a>
                            </div>
                            <figcaption class="product_content card-body mb-4">
                                <h3 class="product_name"><a href="{{ route('product-details',$package->slug) }}">{{ $package->name }}</a></h3>
                                <div class="price_box">
                                    <span class="old_price">{{ (isset($package->selling_price)) ? 'TK '.$package->price : "" }}</span>
                                    <span class="current_price">{{ (isset($package->selling_price)) ? 'TK '.$package->selling_price : 'TK '.$package->price }}</span>
                                </div>
                                <p class="mt-2 mb-3"><a href="{{ route('product-details',$package->slug) }}">{{ $package->description }}</a></p>
                            </figcaption>
                            <div class="add_to_cart">
                                <a class="shopping_cart_link mr-2" id="{{ $package->id }}" data-image="{{ $package->thumbnail_image }}" data-name="{{ $package->name }}" data-price="{{ (isset($package->selling_price)) ? $package->selling_price : $package->price }}" data-quantity="{{ $package->quantity }}">

                                    <!-- Generator: Adobe Illustrator 22.1.0, SVG Export Plug-In . SVG Version: 6.00 Build 0)  -->
                                    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                         viewBox="0 0 24 19.7" style="enable-background:new 0 0 24 19.7;" xml:space="preserve">
                                            <style type="text/css">
                                                .st0{fill:#FFFFFF;}
                                            </style>
                                        <g>
                                            <path class="st0" d="M24,2.7c0-0.5-0.3-1-0.8-1.1c-0.2-0.1-0.5-0.1-0.7-0.1c-0.8,0-1.7,0-2.5,0c-4.1,0-10.8,0-15,0
                                                c0-0.1-0.1-0.3-0.1-0.4c-0.2-0.6-0.5-0.9-1.1-1C3.6,0,3.5,0,3.3,0H0.4C0.2,0.1,0.1,0.2,0,0.4v0.2C0.1,0.9,0.3,1,0.6,1
                                                c0.7,0,1.4,0,2.2,0c0.5,0,1,0.4,1.1,0.8C4.4,3.6,5,5.4,5.5,7.2c0.4,1.5,0.9,2.9,1.3,4.4c0.1,0.5,0.3,1,0.5,1.5
                                                c0.5,0.9,1.3,1.4,2.4,1.4c3,0,6,0,9.1,0c0,0,0.1,0,0.1,0c0.3,0,0.5-0.2,0.5-0.5c0-0.3-0.2-0.5-0.5-0.5c-3.1,0-6.1,0-9.2,0
                                                c-0.8,0-1.6-0.7-1.7-1.5h0.2c3.5,0,7,0,10.5,0c0.1,0,0.3,0,0.4,0c0.6,0,1.1-0.3,1.4-0.8c0.2-0.3,0.3-0.6,0.5-0.9
                                                c1-2.1,1.9-4.2,2.9-6.4C23.9,3.5,24,3.1,24,2.7z"/>
                                            <path class="st0" d="M18.8,15c-1.3,0-2.3,1-2.3,2.3c0,1.3,1.1,2.3,2.3,2.3s2.3-1.1,2.3-2.3C21.2,16.1,20.1,15,18.8,15z M18.8,18.4
                                                c-0.5,0-1-0.5-1-1s0.5-1,1-1s1,0.5,1,1S19.4,18.4,18.8,18.4z"/>
                                            <g>
                                                <path class="st0" d="M9.3,15C8,15,7,16.1,7,17.3c0,1.3,1,2.3,2.3,2.3s2.3-1,2.3-2.3C11.7,16.1,10.6,15,9.3,15z M9.3,18.4
                                                    c-0.5,0-1-0.5-1-1s0.5-1,1-1c0.5,0,1,0.5,1,1S9.9,18.4,9.3,18.4z"/>
                                            </g>
                                        </g>
                                            </svg>
                                    <span>Add to cart</span></a>
                                <a  class="shopping_cart_link_details" href="{{ route('product-details',$package->slug) }}"><span>View Details</span></a>
                            </div>
                        </figure>
                    </div>
                    @endforeach
                    <div class="col-sm-12">
                        <div class="shop_toolbar t_bottom">
                            <div class="pagination">
                                <ul>
                                    {!! $packages->links() !!}
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="add-to-cart-modal" tabindex="-1" role="dialog"
             aria-labelledby="model-8"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">

                <!-- Modal Content -->
                <div class="modal-content">
                    <input type="hidden" class="cart-popup-single-price">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        {{--<h3 class="modal-title" id="model-8">Payment</h3>--}}
                        <button type="button" class="close add-to-cart-modal-close">&times;
                        </button>
                    </div>
                    <!-- /modal header -->

                    <!-- Modal Body -->
                    <form action="" method="">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-lg-6 d-inline-flex p-3">
                                    <div>
                                        <img src="" width="120px" height="120px" class="cart-popup-image" alt="">
                                    </div>
                                    <div>
                                        <p class="cart-popup-name h4"></p>
                                        <p class="cart-popup-price h6"></p>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-lg-6">
                                    <div class="form-group text-center">
                                        <label for="message-text"
                                               class="col-form-label">Quantity: </label>
                                        <div class="d-flex">
                                            <a class="btn btn-dark mr-2 add-to-cart-modal-minus">-</a>
                                            <input class="form-control cart-popup-input text-center" min="1" value="1" type="number">
                                            <a class="btn btn-info ml-2 add-to-cart-modal-plus">+</a>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="message-text"
                                               class="col-form-label">Total Price: </label>
                                        <P class="form-control cart-popup-total-price font-weight-bold text-bold" disabled type="text"></P>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /modal body -->

                        <!-- Modal Footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm cart-popup-shopping-btn" style="background: var(--dark-pink)">Continue Shopping</button>
                            <button type="button" class="btn btn-primary btn-sm cart-popup-checkout-btn" style="background: var(--dark-pink)">View Cart</button>
                        </div>
                    </form>
                    <!-- /modal footer -->

                </div>
            </div>
        </div>
    </section>

    <!-- end package area -->
@endsection

@section('script')
    <script src="{{ asset('default/assets/js/sweetalert2.js') }}"></script>

    <script>
      const publicPath = "{{ URL::to('/') }}";

      $(document).ready(function() {
      {{--// disabled add to cart button--}}
        {{--var current = new Date("{{ $timeNow }}");--}}
        {{--var am = "AM";--}}
        {{--if(current.getHours() >= 12){--}}
          {{--am = 'PM'--}}
        {{--}--}}
        {{--var startHoure = "{{ $startHoure }}";--}}
        {{--var startMin = "{{ $startMin }}";--}}

        {{--var endHoure = "{{ $endHoure }}";--}}
        {{--var endMin = "{{ $endMin }}";--}}
        {{--if(am === 'PM'){--}}
          {{--if(current.getHours() >= endHoure && current.getMinutes() > endMin && current.getSeconds() > 0){--}}
            {{--$('.shopping_cart_link').css("opacity", "0.5")--}}
            {{--$('.shopping_cart_link').prop( "disabled", true )--}}
          {{--}--}}
        {{--}else {--}}
          {{--if(current.getHours() < startHoure){--}}
            {{--$('.shopping_cart_link').css("opacity", "0.5")--}}
            {{--$('.shopping_cart_link').prop( "disabled", true )--}}
          {{--}--}}
        {{--}--}}
        //end of disabled add to cart



        $(document).on('click', '.cart-popup-checkout-btn', function () {
          const productID = $(this).attr("id");
          const productQuantity = $('.cart-popup-input').val();
          // console.log(productID)

          $.ajax({
            url: "{{ url('/add-to-cart') }}/"+productID+"?quantity="+productQuantity,
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
                    $('#add-to-cart-modal').modal('hide');
                    window.location.href = "{{ route('cart') }}"
                  }
                }
              }
            }
          })
        })

        // clicking on continue shopping button
        $(document).on('click', '.cart-popup-shopping-btn', function () {
          const productID = $(this).attr("id");
          const productQuantity = $('.cart-popup-input').val();

          $.ajax({
            url: "{{ url('/add-to-cart') }}/"+productID+"?quantity="+productQuantity,
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
                    $('#add-to-cart-modal').modal('hide');
                  }
                }
              }
            }
          })


            {{--$.ajax({--}}
            {{--url: "{{ url('/add-to-cart') }}/"+productID,--}}
            {{--method: "get",--}}
            {{--dataType: "json",--}}
            {{--success: function (data) {--}}
            {{--if (data != undefined) {--}}
            {{--//if error--}}
            {{--if (data.error) {--}}
            {{--if (data.error === "Failed") {--}}
            {{--Swal.fire({--}}
            {{--position: 'center',--}}
            {{--icon: 'warning',--}}
            {{--title:"Sorry",--}}
            {{--text: 'Something went wrong!',--}}
            {{--showConfirmButton: false,--}}
            {{--timer: 1500,--}}
            {{--toast: false,--}}
            {{--})--}}
            {{--} else {--}}
            {{--Swal.fire({--}}
            {{--position: 'center',--}}
            {{--icon: 'warning',--}}
            {{--title:"Sorry",--}}
            {{--text: 'We are not taking any order at this time. Please come back with in 10 AM to 07 PM!',--}}
            {{--showConfirmButton: false,--}}
            {{--timer: 5000,--}}
            {{--toast: false,--}}
            {{--})--}}
            {{--}--}}
            {{--} else {--}}
            {{--// display toast message--}}
            {{--Swal.fire({--}}
            {{--position: 'top-end',--}}
            {{--icon: 'success',--}}
            {{--title: 'Ice cream added success!',--}}
            {{--showConfirmButton: false,--}}
            {{--timer: 1500,--}}
            {{--toast: true,--}}

            {{--})--}}
            {{--// change cart item number in top menu--}}
            {{--if ($('.cart_quantity').length > 0) {--}}
            {{--$('.cart_quantity').html(data.totalItem);--}}
            {{--}--}}
            {{--// format minicart design--}}
            {{--if ($('.mini_cart_scrool').length > 0) {--}}
            {{--let output = '';--}}
            {{--$.each(data.content, function (i, e) {--}}
            {{--output += '<div class="cart_item">\n';--}}
            {{--output += '                                    <div class="cart_img">\n';--}}
            {{--output += '                                        <a href="#"><img src="' + publicPath + '/' + e.options.image + '" alt=""></a>\n';--}}
            {{--output += '                                    </div>\n';--}}
            {{--output += '                                    <div class="cart_info">\n';--}}
            {{--output += '                                        <a href="#">' + e.name + '</a>\n';--}}
            {{--output += '                                        <p>Qty: ' + e.qty + ' X <span> Tk' + e.price + ' </span></p>\n';--}}
            {{--output += '                                    </div>\n';--}}
            {{--output += '                                    <div class="cart_remove">\n';--}}
            {{--output += '                                        <a href="{{ URL::to('remove-cart-item') }}/' + e.rowId + '"><i class="ion-android-close"></i></a>\n';--}}
            {{--output += '                                    </div>\n';--}}
            {{--output += '                                </div>';--}}
            {{--});--}}
            {{--output += '<div class="mini_cart_table">\n' +--}}
            {{--'                                    <div class="cart_total mt-10">\n' +--}}
            {{--'                                        <span>Total:</span>\n' +--}}
            {{--'                                        <span class="price">TK ' + data.total + '</span>\n' +--}}
            {{--'                                    </div>\n' +--}}
            {{--'                                </div>';--}}
            {{--output += '<div class="mini_cart_footer">\n' +--}}
            {{--'                                    <div class="cart_button">\n' +--}}
            {{--'                                        <a href="{{ route('cart') }}">View cart</a>\n' +--}}
            {{--'                                    </div>\n' +--}}
            {{--'                                    <div class="cart_button">\n' +--}}
            {{--'                                        <a href="{{ route("checkout") }}">Checkout</a>\n' +--}}
            {{--'                                    </div>\n' +--}}
            {{--'\n' +--}}
            {{--'                                </div>';--}}
            {{--$('.mini_cart_scrool').html(output);--}}
            {{--}--}}
            {{--}--}}
            {{--}--}}
            {{--}--}}
            {{--})--}}
        })

        // clicking on add to cart
        $(document).on('click', '.shopping_cart_link', function () {
          const imagePath = "{{ asset('') }}";
          const productID = $(this).attr("id");
          const productName = $(this).data("name");
          const productPrice = $(this).data("price");
          const productQuantity = $(this).data("quantity");
          const productImage = $(this).data("image");

          $('#add-to-cart-modal').find('.cart-popup-image').attr("src", imagePath+productImage)
          $('#add-to-cart-modal').find('.cart-popup-name').text(productName)
          $('#add-to-cart-modal').find('.cart-popup-price').text("TK "+productPrice)
          $('#add-to-cart-modal').find('.cart-popup-single-price').attr("value", productPrice)
          $('#add-to-cart-modal').find('.cart-popup-input').attr("max", productQuantity)
          $('#add-to-cart-modal').find('.cart-popup-input').removeAttr("value")
          $('#add-to-cart-modal').find('.cart-popup-input').attr("value", 1)

          const price = parseFloat($('.cart-popup-single-price').val())
          const qu = Number($('.cart-popup-input').val());
          const newPrice = (price * qu)
          $('.cart-popup-total-price').text(newPrice+" TK")

          $('#add-to-cart-modal').find('.cart-popup-checkout-btn').attr("id", productID)
          $('#add-to-cart-modal').find('.cart-popup-shopping-btn').attr("id", productID)

          $('#add-to-cart-modal').modal('show');
        })
        // add to cart pop up close
        $(document).on('click', '.add-to-cart-modal-close', function () {
          $('#add-to-cart-modal').modal('hide');
        })
        // clicking on modal plus btn
        $(document).on('click', '.add-to-cart-modal-plus', function () {
          const price = parseFloat($('.cart-popup-single-price').val())
          const qu = (Number($('.cart-popup-input').val())+1);
          const newPrice = (price * qu)
          $('.cart-popup-input').val(qu)
          $('.cart-popup-total-price').text(newPrice+" TK")
        })
        // clicking on modal minus btn
        $(document).on('click', '.add-to-cart-modal-minus', function () {
          const price = parseFloat($('.cart-popup-single-price').val())
          const qu = (Number($('.cart-popup-input').val())-1);
          if(qu > 0) {
            const newPrice = (price * qu)
            $('.cart-popup-input').val(qu)
            $('.cart-popup-total-price').text(newPrice + " TK")
          }
        })
        // on change
        $(document).on('change', '.cart-popup-input', function () {
          const price = parseFloat($('.cart-popup-single-price').val())
          const qu = Number($('.cart-popup-input').val());
          const newPrice = (price * qu)
          $('.cart-popup-total-price').text(newPrice+" TK")
        })
        // on key press
        $(document).on('keyup', '.cart-popup-input', function () {
          const price = parseFloat($('.cart-popup-single-price').val())
          const qu = Number($('.cart-popup-input').val());
          const newPrice = (price * qu)
          $('.cart-popup-total-price').text(newPrice+" TK")
        })

      })
    </script>

@endsection