@inject('PublicFunction', 'App\Http\Controllers\PublicFunction')
@extends('layouts.admin_layout')
@section('title')
    Order details - Igloo
@endsection

@section('stylesheet')
    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            #section-to-print, #section-to-print * {
                visibility: visible;
            }
            #section-to-print {
                position: absolute;
                left: 0;
                top: 0;
            }
            #section-to-print-logo {
                display: block!important;
            }
        }
    </style>

@endsection

@section('content')
    <div class="dt-content-wrapper">

        <!-- Site Content -->
        <div class="dt-content">
<?php //dd($customer_details[0]->name); ?>
            <!-- Page Header -->
            <div class="dt-page__header">
                <h1 class="dt-page__title">Order Details</h1>
            </div>

            <!-- /page header -->

            <!-- Grid -->
            <div class="row">
                <div class="col-12">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if(session()->has('status'))
                        {!! session()->get('status') !!}
                    @endif
                </div>
            </div>

            <div class="row mt-5" id="section-to-print">
                <div class="col-12 d-none mt-5" id="section-to-print-logo" style="font-size: 12px; line-height: 0.5;">
                    <img src="{{ asset('default\assets\img\logo\logo.png') }}" style="width: 100px; height: 100px;" alt="">
                    <div class="float-right">
                        <p>Monem Business District 111, Bir Uttam C.R. Dutta Road,</p>
                        <p> Level 13 Karwanbazar, Dhaka-1205, Bangladesh</p>
                        <p>helloigloo@amlbd.com</p>
                        <p>88-02-9632011-13 88-9632304-10</p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4">
                    <div class="card border border-primary">
                        <!-- Card Body -->
                        <div class="card-body">
                            <h2 class="card-title">Customer Details</h2>
                            @if(count($customer_details) > 0)
                                <div>Name: {{ $customer_details[0]->name }}</div>
                                <div>Email: {{ $customer_details[0]->email }}</div>
                                <div>Phone: {{ $customer_details[0]->phone }}</div>
                            @endif
                        </div>
                        <!-- /card body -->
                    </div>
                </div>
                <div class="col-sm-12 col-md-4">
                    <div class="card border border-primary">
                        <!-- Card Body -->
                        <div class="card-body">
                            <h2 class="card-title">Shipping Address</h2>
                            <div>{{ $order_details[0]->address }}</div>

                        </div>
                        <!-- /card body -->
                    </div>
                </div>
                <div class="col-sm-12 col-md-4">
                    <div class="card border border-primary">
                        <!-- Card Body -->
                        <div class="card-body">
                            <h2 class="card-title">Order Summary</h2>
                            <div><strong>Order No. #{{ $order_details[0]->id }}</strong></div>
                            <div>Order Date: {{ date('d-m-Y', strtotime($order_details[0]->created_at)) }}</div>
                            <div>Total Amount: Tk {{ $order_details[0]->amount }}</div>
                            <div>Status: {{ $order_details[0]->status }}</div>
                            @if($order_details[0]->discount != null)
                                <div>Coupon Type: {{ $order_details[0]->discount_type }}</div>
                                <div>Coupon Discount: {{ $order_details[0]->discount }}</div>
                                @if($order_details[0]->coupon_code != null)
                                    <div>Coupon Code: {{ $order_details[0]->coupon_code }}</div>
                                @endif
                            @endif
                        </div>
                        <!-- /card body -->
                    </div>
                </div>
                <!-- Grid Item -->
                <div class="col-12">

                    <!-- Entry Header -->

                    <!-- /entry header -->

                    <!-- Card -->
                    <div class="dt-card overflow-hidden">

                        <!-- Card Body -->
                        <div class="dt-card__body p-0">
                            <?php
                            $product_details = unserialize($order_details[0]->product_details);
                            $subtotal = 0;
                            $i = 1;
                            ?>
                            <!-- Tables -->
                            <div class="table-responsive">
                                <table class="table table-hover mb-0 border">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th class="text-uppercase" scope="col">Product Name</th>
                                            <th class="text-uppercase" scope="col">Quantity</th>
                                            <th class="text-uppercase" scope="col">Price</th>
                                            <th class="text-uppercase text-right" scope="col" >Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($product_details as $row)
                                        <?php $subtotal += $row->qty * $row->price; ?>
                                        <tr >
                                            <th scope="row">{{ $i++ }}</th>
                                            <td>{{ $row->name }} ( @foreach($row->options as $key => $value) @if($key != 'image') {{ $value }} @endif @endforeach )</td>
                                            <td>{{ $row->qty }}</td>
                                            <td>{{ $row->price }}</td>
                                            <td class="text-right">Tk {{ $row->qty * $row->price }}</td>
                                        </tr>
                                    @endforeach
                                        <tr class="text-right">
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td colspan="2" class="p-0">
                                                <table class="w-100 border-left border-top-0">
                                                    <tbody>
                                                        <tr>
                                                            <td class="text-right text-uppercase"><strong>Subtotal</strong></td>
                                                            <td>Tk {{ $subtotal }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-right text-uppercase"><strong>Discount ({{ $order_details[0]->discount }}%)</strong></td>
                                                            <td>Tk {{ ($order_details[0]->discount/100) * $subtotal }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-right text-uppercase"><strong>Delivery charge</strong></td>
                                                            <td class="text-right">Tk {{ $deliveryCharge }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-right text-uppercase"><strong>Total</strong></td>
                                                            <td><strong>Tk {{ $subtotal + $deliveryCharge - (($order_details[0]->discount/100) * $subtotal) }}</strong></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /tables -->

                        </div>
                        <!-- /card body -->

                    </div>
                    <!-- /card -->

                </div>
                <!-- /grid item -->
                <div class="col-12">

                    <!-- Entry Header -->

                    <!-- /entry header -->

                    <!-- Card -->
                    <h2 class="card-title">Payment Details</h2>
                    <div class="dt-card overflow-hidden">
                        <!-- Card Body -->
                        <div class="dt-card__body p-0">
                            <!-- Tables -->
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th class="text-uppercase" scope="col">Payment Date</th>
                                        <th class="text-uppercase" scope="col">Method</th>
                                        <th class="text-uppercase" scope="col">Amount</th>
                                        <th class="text-uppercase" scope="col">Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i = 1;?>
                                    @foreach($payment_details as $row)
                                        <tr>
                                            <th scope="row">{{ $i++ }}</th>
                                            <td>{{ $row->created_at }} </td>
                                            <td>{{ $row->type }}</td>
                                            <td>{{ $row->amount }}</td>
                                            <td>{{ $row->status }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /tables -->

                        </div>
                        <!-- /card body -->

                    </div>
                    <!-- /card -->

                </div>

            </div>
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-6 mt-3">
                @if($PublicFunction::checkPermission($userPermission, ["update_order"]))
                    <form action="{{ route('admin.order.change-status', $order_details[0]->id) }}" method="GET">
                        @csrf
                        <div class="d-inline-flex float-right">
                            <select name="status" id="" class="form-control mr-3 p-1" style="width: 120px">
                                <option value="" selected>Select one</option>
                                <option value="Pending" @if($order_details[0]->status == "Pending") selected @endif>Pending</option>
                                <option value="Processing" @if($order_details[0]->status == "Processing") selected @endif>Processing</option>
                                <option value="Delivered" @if($order_details[0]->status == "Delivered") selected @endif>Delivered</option>
                                <option value="Completed" @if($order_details[0]->status == "Completed") selected @endif>Completed</option>
                                <option value="Cancelled" @if($order_details[0]->status == "Cancelled") selected @endif>Cancelled</option>
                            </select>
                            <input class="btn btn-primary mr-3" type="submit" value="Update"/>
                        </div>
                    </form>
                @endif
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-6 mt-3">
                <div class="float-right">
                    @if($PublicFunction::checkPermission($userPermission, ["order_payment"]))
                        <button type="button" id="mark-as-paid-btn" class="btn btn-primary mr-3">Mark as paid</button>
                    {{--mark as paid modal--}}
                        <div class="modal fade" id="mark-as-paid-modal" tabindex="-1" role="dialog"
                         aria-labelledby="model-8"
                         aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">

                            <!-- Modal Content -->
                            <div class="modal-content">

                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h3 class="modal-title" id="model-8">Payment</h3>
                                    <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <!-- /modal header -->

                                <!-- Modal Body -->
                                    <form action="{{ route('admin.order.mark-as-paid') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="order_id" value="{{$order_details[0]->id}}">
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="recipient-name"
                                                       class="col-form-label">Payment Method:</label>
                                                <input class="form-control" required name="payment_method" type="text" placeholder="Payment Method">
                                            </div>
                                            <div class="form-group">
                                                <label for="message-text"
                                                       class="col-form-label">Amount:</label>
                                                <input class="form-control" required name="amount" type="number" min="0" placeholder="Amount">
                                            </div>
                                        </div>
                                        <!-- /modal body -->

                                        <!-- Modal Footer -->
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary btn-sm"
                                                    data-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                                        </div>
                                    </form>
                                <!-- /modal footer -->

                            </div>
                            <!-- /modal content -->
                        </div>
                    </div>
                    @endif
                    <button type="button" class="btn btn-primary btn-sm" onclick="window.print()">
                    <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                         viewBox="0 0 512 512" style="enable-background:new 0 0 512 512; width:25px; margin-right: 10px; fill: #ffffff;" xml:space="preserve">
                        <g>
                            <g>
                                <path d="M446.016,245.61h-18.253c-10.122,0-18.357,8.235-18.357,18.358v18.252c0,10.122,8.235,18.357,18.357,18.357h18.253
                                    c10.122,0,18.357-8.235,18.357-18.357v-18.252C464.373,253.845,456.137,245.61,446.016,245.61z M449.382,282.219
                                    c0,1.856-1.51,3.366-3.366,3.366h-18.253c-1.856,0-3.366-1.51-3.366-3.366v-18.252c0-1.856,1.51-3.367,3.366-3.367h18.253
                                    c1.856,0,3.366,1.511,3.366,3.367V282.219z"/>
                            </g>
                        </g>
                        <g>
                            <g>
                                <path d="M503.985,208.921c-5.195-5.233-12.118-8.13-19.49-8.156l-15.623-0.056l0.341-94.114
                c0.025-7.018-2.689-13.624-7.642-18.597c-4.953-4.974-11.547-7.715-18.567-7.719l-26.603-0.014v-49.7
                c0-10.415-8.472-18.887-18.887-18.887H113.568c-10.415,0-18.887,8.472-18.887,18.887V80.1l-25.177-0.014c-0.005,0-0.01,0-0.015,0
                c-14.406,0-26.168,11.717-26.221,26.127l-0.336,92.956l-14.526-0.052c-0.035,0-0.067,0-0.101,0
                c-15.174,0-27.549,12.319-27.603,27.505L0,420.529c-0.055,15.222,12.284,27.65,27.505,27.705l64.13,0.232l-12.31,34.338
                c-1.335,3.725-0.776,7.884,1.496,11.124c2.272,3.24,5.991,5.183,9.949,5.198l330.406,1.196c0.015,0,0.029,0,0.044,0
                c3.941,0,7.655-1.914,9.942-5.126c2.295-3.224,2.886-7.378,1.577-11.114l-12.061-34.425l62.916,0.227c0.035,0,0.067,0,0.102,0
                c15.174-0.001,27.549-12.319,27.603-27.505L512,228.47C512.026,221.097,509.18,214.154,503.985,208.921z M416.401,95.256h0.001
                l26.595,0.014c3.006,0.002,5.83,1.176,7.952,3.307c2.122,2.131,3.284,4.959,3.273,7.965l-0.341,94.113l-37.48-0.135V95.256z
                 M109.672,30.565c0-2.148,1.748-3.896,3.896-3.896h283.947c2.148,0,3.896,1.748,3.896,3.896v169.899l-291.739-1.055V30.565z
                 M58.26,106.267c0.022-6.172,5.059-11.19,11.23-11.19c0.002,0,0.005,0,0.007,0l25.185,0.014v104.265l-36.758-0.133L58.26,106.267z
                 M74.513,433.412l0.124-34.365c0.008-2.292,1.875-4.15,4.164-4.15c0.006,0,0.011,0,0.016,0l31.979,0.116l-6.476,18.066
                l-7.071,19.724l-0.247,0.69L74.513,433.412z M94.767,484.15l14.555-40.601c0.001-0.003,0.003-0.007,0.005-0.01l17.385-48.498
                l259.275,0.937l17.035,48.623c0.001,0.003,0.003,0.006,0.004,0.009l14.262,40.707L94.767,484.15z M437.348,434.724l-21.93-0.079
                l-2.938-8.386l-10.578-30.193l31.42,0.114c1.113,0.004,2.157,0.441,2.941,1.231s1.213,1.837,1.209,2.948L437.348,434.724z
                 M496.306,422.324c-0.025,6.94-5.679,12.568-12.613,12.568c-0.016,0-0.031,0-0.046,0l-31.309-0.113l0.124-34.366
                c0.019-5.117-1.957-9.934-5.562-13.565c-3.604-3.632-8.408-5.641-13.524-5.66l-41.654-0.151c-0.129-0.007-0.255-0.031-0.385-0.032
                l-269.866-0.976c-0.01,0-0.019,0-0.027,0c-0.125,0-0.245,0.023-0.369,0.029l-42.202-0.153c-0.024,0-0.047,0-0.071,0
                c-10.53,0-19.116,8.548-19.154,19.086l-0.124,34.366l-31.963-0.115c-6.956-0.025-12.594-5.705-12.568-12.659l0.702-193.909
                c0.025-6.94,5.679-12.568,12.613-12.568c0.016,0,0.031,0,0.046,0l22.014,0.08c0.001,0,434.07,1.57,434.072,1.57
                c6.956,0.025,12.594,5.705,12.568,12.659L496.306,422.324z"/>
                            </g>
                        </g>
                        <g>
                            <g>
                                <path d="M300.973,132.313H150.536c-4.14,0-7.495,3.355-7.495,7.495s3.355,7.495,7.495,7.495h150.436
                c4.14,0,7.495-3.355,7.495-7.495S305.113,132.313,300.973,132.313z"/>
                            </g>
                        </g>
                        <g>
                            <g>
                                <path d="M364.405,132.313h-21.979c-4.14,0-7.495,3.355-7.495,7.495s3.355,7.495,7.495,7.495h21.979
                c4.139,0.001,7.495-3.355,7.495-7.495S368.545,132.313,364.405,132.313z"/>
                            </g>
                        </g>
                        <g>
                            <g>
                                <path d="M172.926,76.111h-22.39c-4.14,0-7.495,3.355-7.495,7.495c0,4.139,3.355,7.495,7.495,7.495h22.39
                c4.14,0,7.495-3.355,7.495-7.495C180.421,79.466,177.066,76.111,172.926,76.111z"/>
                            </g>
                        </g>
                        <g>
                            <g>
                                <path d="M364.404,76.111h-150.9c-4.14,0-7.495,3.355-7.495,7.495c0,4.139,3.355,7.495,7.495,7.495h150.9
                c4.14,0,7.495-3.355,7.495-7.495C371.899,79.466,368.544,76.111,364.404,76.111z"/>
                            </g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
    </svg> <span>Print</span>
                </button>
                </div>
            </div>
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
    <script>
        $('#mark-as-paid-btn').click(function () {
          $('#mark-as-paid-modal').modal('show');
        })
    </script>
@endsection