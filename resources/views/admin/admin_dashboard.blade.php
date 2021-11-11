@extends('layouts.admin_layout')
@section('title')
    Igloo - Admin Dashboard
@endsection
@section('content')
<div class="dt-content-wrapper">

    <!-- Site Content -->
    <div class="dt-content">

        <!-- Page Header -->
        <div class="dt-page__header">
            <h1 class="dt-page__title">Dashboard - Listing</h1>
        </div>
        <!-- /page header -->

        <div class="row">
            <div class="col-md-12">

                <!-- Card -->
                <div class="dt-card">

                    <!-- Card Header -->
                    <div class="dt-card__header">

                        <!-- Card Heading -->
                        <div class="dt-card__heading">
                            <h3 class="dt-card__title">Sells of last 12 month</h3>
                        </div>
                        <!-- /card heading -->

                    </div>
                    <!-- /card header -->

                    <!-- Card Body -->
                    <div class="dt-card__body">

                        <canvas id="cjs-linechart"></canvas>

                    </div>
                    <!-- /card body -->

                </div>
                <!-- /card -->

            </div>
        </div>
        <!-- /grid -->
        <!-- Grid -->
        <div class="row">

            <!-- Grid Item -->
            <div class="col-xl-3 col-sm-6">
                <!-- Card -->
                <div class="dt-card">

                    <!-- Card Body -->
                    <div class="dt-card__body d-flex flex-sm-column">
                        <div class="mb-sm-7 mr-7 mr-sm-0">
                            <i class="icon icon-users dt-icon-bg bg-primary text-primary"></i>
                        </div>
                        <div class="flex-1">
                            <div class="d-flex align-items-center mb-2">
                                <span class="h2 mb-0 font-weight-500 mr-2">{{ $daily_sale }}.00Tk</span>
                                <span class="d-inline-flex text-success">
                      </span>
                            </div>
                            <div class="h5 mb-2">Todays Sale</div>
                        </div>
                    </div>
                    <!-- /card body -->

                </div>
                <!-- /card -->
            </div>
            <!-- /grid item -->

            <!-- Grid Item -->
            <div class="col-xl-3 col-sm-6">
                <!-- Card -->
                <div class="dt-card">

                    <!-- Card Body -->
                    <div class="dt-card__body d-flex flex-sm-column">
                        <div class="mb-sm-7 mr-7 mr-sm-0">
                            <i class="icon icon-company dt-icon-bg bg-success text-success"></i>
                        </div>
                        <div class="flex-1">
                            <div class="d-flex align-items-center mb-2">
                                <span class="h2 mb-0 font-weight-500 mr-2">{{ $daily_order }}</span>
                                <span class="d-inline-flex text-success">
                          </span>
                            </div>
                            <div class="h5 mb-2">Todays Order</div>
                        </div>
                    </div>
                    <!-- /card body -->

                </div>
                <!-- /card -->
            </div>
            <!-- /grid item -->

            <!-- Grid Item -->
            <div class="col-xl-3 col-sm-6">
                <!-- Card -->
                <div class="dt-card">

                    <!-- Card Body -->
                    <div class="dt-card__body d-flex flex-sm-column">
                        <div class="mb-sm-7 mr-7 mr-sm-0">
                            <i class="icon icon-customer dt-icon-bg bg-secondary text-secondary"></i>
                        </div>
                        <div class="flex-1">
                            <div class="d-flex align-items-center mb-2">
                                <span class="h2 mb-0 font-weight-500 mr-2">{{ $total_sale }} Tk</span>
                                <span class="d-inline-flex text-danger">
                          </span>
                            </div>
                            <div class="h5 mb-2">Total Sale</div>
                        </div>
                    </div>
                    <!-- /card body -->

                </div>
                <!-- /card -->
            </div>
            <!-- /grid item -->

            <!-- Grid Item -->
            <div class="col-xl-3 col-sm-6">
                <!-- Card -->
                <div class="dt-card">

                    <!-- Card Body -->
                    <div class="dt-card__body d-flex flex-sm-column">
                        <div class="mb-sm-7 mr-7 mr-sm-0">
                            <i class="icon icon-revenue-new dt-icon-bg bg-orange text-orange"></i>
                        </div>
                        <div class="flex-1">
                            <div class="d-flex align-items-center mb-2">
                                <span class="h2 mb-0 font-weight-500 mr-2">{{ $total_order }} </span>
                                <span class="d-inline-flex text-success">
                          </span>
                            </div>
                            <div class="h5 mb-2">Total Order</div>
                        </div>
                    </div>
                    <!-- /card body -->

                </div>
                <!-- /card -->
            </div>
            <!-- /grid item -->

            {{--<!-- Grid Item -->--}}
            {{--<div class="col-md-3 col-6">--}}

                {{--<!-- Card -->--}}
                {{--<div class="dt-card">--}}

                    {{--<!-- Card Body -->--}}
                    {{--<div class="dt-card__body p-xl-8 py-sm-8 py-6 px-4">--}}

                        {{--<span class="badge badge-secondary badge-top-right">Revenue</span>--}}

                        {{--<!-- Media -->--}}
                        {{--<div class="media">--}}

                            {{--<i class="icon icon-revenue-new icon-5x mr-xl-5 mr-3 align-self-center"></i>--}}

                            {{--<!-- Media Body -->--}}
                            {{--<div class="media-body">--}}
                                {{--<p class="mb-1 h1">$25,890</p>--}}
                                {{--<span class="d-block text-light-gray">This July</span>--}}
                            {{--</div>--}}
                            {{--<!-- /media body -->--}}

                        {{--</div>--}}
                        {{--<!-- /media -->--}}

                    {{--</div>--}}
                    {{--<!-- /card body -->--}}

                {{--</div>--}}
                {{--<!-- /card -->--}}

            {{--</div>--}}
            {{--<!-- /grid item -->--}}

            {{--<!-- Grid Item -->--}}
            {{--<div class="col-md-3 col-6">--}}

                {{--<!-- Card -->--}}
                {{--<div class="dt-card">--}}

                    {{--<!-- Card Body -->--}}
                    {{--<div class="dt-card__body p-xl-8 py-sm-8 py-6 px-4">--}}

                        {{--<span class="badge badge-secondary badge-top-right">Order</span>--}}

                        {{--<!-- Media -->--}}
                        {{--<div class="media">--}}

                            {{--<i class="icon icon-orders-new icon-5x mr-xl-5 mr-3 align-self-center"></i>--}}

                            {{--<!-- Media Body -->--}}
                            {{--<div class="media-body">--}}
                                {{--<p class="mb-1 h1">$2,569</p>--}}
                                {{--<span class="d-block text-light-gray">This July</span>--}}
                            {{--</div>--}}
                            {{--<!-- /media body -->--}}

                        {{--</div>--}}
                        {{--<!-- /media -->--}}

                    {{--</div>--}}
                    {{--<!-- /card body -->--}}

                {{--</div>--}}
                {{--<!-- /card -->--}}

            {{--</div>--}}
            {{--<!-- /grid item -->--}}

            {{--<!-- Grid Item -->--}}
            {{--<div class="col-md-6 col-12">--}}

                {{--<!-- Card -->--}}
                {{--<div class="dt-card">--}}

                    {{--<!-- Card Body -->--}}
                    {{--<div class="dt-card__body p-xl-8 py-sm-8 py-6 px-4">--}}

                        {{--<span class="badge badge-secondary badge-top-right">Invoices</span>--}}

                        {{--<!-- Media -->--}}
                        {{--<div class="media">--}}

                            {{--<i class="icon icon-invoice-new icon-5x mr-xl-5 mr-1 mr-sm-3 align-self-center"></i>--}}

                            {{--<!-- Media Body -->--}}
                            {{--<div class="media-body">--}}
                                {{--<ul class="invoice-list">--}}
                                    {{--<li class="invoice-list__item">--}}
                                        {{--<span class="invoice-list__number">23</span> <span--}}
                                                {{--class="invoice-list__label">Sent</span>--}}
                                    {{--</li>--}}
                                    {{--<li class="invoice-list__item">--}}
                                        {{--<span class="invoice-list__number">8</span> <span--}}
                                                {{--class="dot-shape bg-success"></span>--}}
                                        {{--<span class="invoice-list__label">Paid</span>--}}
                                        {{--<span class="custom-tooltip bg-success">$8015</span>--}}
                                    {{--</li>--}}
                                    {{--<li class="invoice-list__item">--}}
                                        {{--<span class="invoice-list__number">9</span> <span--}}
                                                {{--class="dot-shape bg-warning"></span>--}}
                                        {{--<span class="invoice-list__label">Due</span>--}}
                                        {{--<span class="custom-tooltip bg-warning">$1215</span>--}}
                                    {{--</li>--}}
                                    {{--<li class="invoice-list__item">--}}
                                        {{--<span class="invoice-list__number">6</span> <span--}}
                                                {{--class="dot-shape bg-danger"></span>--}}
                                        {{--<span class="invoice-list__label">Overdue</span>--}}
                                        {{--<span class="custom-tooltip bg-danger">$415</span>--}}
                                    {{--</li>--}}
                                {{--</ul>--}}
                            {{--</div>--}}
                            {{--<!-- /media body -->--}}

                        {{--</div>--}}
                        {{--<!-- /media -->--}}

                    {{--</div>--}}
                    {{--<!-- /card body -->--}}

                {{--</div>--}}
                {{--<!-- /card -->--}}

            {{--</div>--}}
            {{--<!-- /grid item -->--}}

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
    <script src="{{asset('admin/assets/js/custom/charts/dashboard-listing.js')}}"></script>
    <script src="{{ asset('admin/node_modules/chart.js/dist/Chart.min.js') }}"></script>
{{--    <script src="{{ asset('admin/assets/js/custom/charts/page-chartjs.js') }}"></script>--}}
    <script>
      $(document).ready(function () {
        var obj = JSON.parse('<?php echo json_encode($data)?>');
        var month = [];
        var monthVal = [];
        Object.keys(obj).map(function(key, val) {
          month.push(key);
          monthVal.push(obj[key]);
        });

        var defaultOptions = {
            responsive: true,
            legend: {
                display: true,
                position: 'bottom',
                labels: {
                    padding: 20
                }
            },
            onResize: function (chart, size) {
                if (chart.config.type == 'pie' || chart.config.type == 'doughnut' || chart.config.type == 'radar' || chart.config.type == 'polarArea') {

                    if (size.height < 190) {
                        chart.config.options.legend.display = false;
                    } else {
                        chart.config.options.legend.display = true;
                    }

                    chart.update();
                }
            },
            layout: {
                padding: 0
            }
        };
        // Line Chart
        var ctxLineChart = document.getElementById('cjs-linechart').getContext('2d');
        var optsLineChart = $.extend({}, defaultOptions);

        optsLineChart.tooltips = {
            mode: 'index',
            axis: 'y'
        };

        optsLineChart.legend = {
            display: false
        };

        optsLineChart.scales = {
            xAxes: [{
                display: true,
            }],
            yAxes: [{
                display: true,
                // ticks: {
                //     suggestedMin: 2000,
                //     suggestedMax: 11000,
                //     stepSize: 2000
                // }
            }]
        };

        new Chart(ctxLineChart, {
            type: 'line',
            data: {
                labels: month,
                datasets: [
                    {
                        data: monthVal,
                        label: 'Series A',
                        borderWidth: 2,
                        fill: false,
                        backgroundColor: 'rgba(148,159,177,0.2)',
                        borderColor: '#3367d6',
                        pointBackgroundColor: 'rgba(77,83,96,1)',
                        pointBorderColor: '#fff',
                        pointHoverBackgroundColor: '#fff',
                        pointHoverBorderColor: 'rgba(77,83,96,1)'
                    },

                ]
            },
            options: optsLineChart
        });
      })
    </script>
@endsection
