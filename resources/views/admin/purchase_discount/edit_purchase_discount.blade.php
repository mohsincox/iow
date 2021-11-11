@extends('layouts.admin_layout')
@section('title')
    Igloo - Edit Purchase Discount
@endsection

<link rel="stylesheet" href="{{ asset('default/assets/fromcdn/tempusdominus-bootstrap-4.min.css') }}" />


@section('content')
    <div class="dt-content-wrapper">

        <!-- Site Content -->
        <!-- Site Content -->
        <div class="dt-content">

            <!-- Page Header -->
            <div class="dt-page__header">
                <h1 class="dt-page__title">Edit Purchase Discount</h1>
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
                            <div class="form-group form-row">
                                <label class="col-md-2 col-sm-3 col-form-label text-sm-right"></label>
                                <div class="col-md-12 col-sm-12">
                                    @if(session()->has('status'))
                                        {!! session()->get('status') !!}
                                    @endif
                                    @if(count($errors) > 0 )
                                        @foreach($errors->all() as $error)
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                <ul class="p-0 m-0" style="list-style: none;">
                                                    <li>{{$error}}</li>
                                                </ul>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>

                            <!-- Form -->
                            <form method="post" action="{{route('admin.edit-purchase-discount', $purchaseDiscount->id)}}">
                            @csrf
                            <!-- Form Row -->
                                <div class="form-row">
                                    <div class="col-sm-6 mb-3">
                                        <label>Offer Type</label>
                                        <select name="offer_type" id="offer_type" required readonly disabled class="form-control @error('offer_type') is-invalid @enderror">
                                            <option value="" selected>Select a offer type</option>
                                            <option value="lifetime"
                                                @if( $purchaseDiscount->offer_type === "lifetime")
                                                    selected
                                                @endif
                                            >Lifetime</option>
                                            <option value="specific_time_period"
                                                @if( $purchaseDiscount->offer_type == "specific_time_period")
                                                    selected
                                                @endif>Specific time period</option>
                                        </select>
                                        @error('offer_type')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6 mb-3">
                                        <label>Number of purchase</label>
                                        <input type="number" placeholder="Number of purchase"
                                               aria-label="Number of purchase" name="number_of_purchase" min="0" value="{{ $purchaseDiscount->number_of_purchase }}" readonly required class="form-control @error('number_of_purchase') is-invalid @enderror ">
                                        @error('number_of_purchase')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-row time_period
                        @if( $purchaseDiscount->offer_type != null && $purchaseDiscount->offer_type == "specific_time_period")
                        @else
                                    d-none
                        @endif">
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label for="purchase_start_date">Purchase start date</label>
                                            <div class="input-group date" id="purchase_start_date" data-target-input="nearest">
                                                <input type="text" name="purchase_start_date" data-target="#purchase_start_date" value="{{ date('m/d/Y h:i A', strtotime($purchaseDiscount->purchase_start_date)) }}"
                                                       class="form-control datetimepicker-input @error('purchase_start_date') is-invalid @enderror">
                                                <div class="input-group-append" data-target="#purchase_start_date" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="icon icon-calendar"></i></div>
                                                </div>
                                                @error('purchase_start_date')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label for="purchase_end_date">Purchase end date</label>
                                            <div class="input-group date" id="purchase_end_date" data-target-input="nearest">
                                                <input type="text" name="purchase_end_date" data-target="#purchase_end_date"value="{{ date('m/d/Y h:i A', strtotime($purchaseDiscount->purchase_end_date)) }}"
                                                       class="form-control datetimepicker-input @error('purchase_end_date') is-invalid @enderror">
                                                <div class="input-group-append" data-target="#purchase_end_date" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="icon icon-calendar"></i></div>
                                                </div>
                                                @error('purchase_end_date')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div></div>


                                {{--<div class="col-sm-12 mb-3">--}}
                                {{--<label>Discount amount type</label>--}}
                                {{--<input type="discount" step="0.01" placeholder="Discount"--}}
                                {{--aria-label="Discount" name="discount" min="0" value="{{old('discount')}}" class="form-control @error('discount') is-invalid @enderror ">--}}
                                {{--@error('discount')--}}
                                {{--<span class="invalid-feedback" role="alert">--}}
                                {{--<strong>{{ $message }}</strong>--}}
                                {{--</span>--}}
                                {{--@enderror--}}
                                {{--</div>--}}

                                <div class="form-row">
                                    <div class="col-sm-6 mb-3">
                                        <label>Discount (It takes a number as percentage)</label>
                                        <input type="number" step="0.01" placeholder="Discount"
                                               aria-label="Discount" name="discount" required min="0" value="{{ $purchaseDiscount->discount }}" readonly class="form-control @error('discount') is-invalid @enderror ">
                                        @error('discount')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6 mb-3">
                                        <div class="form-group">
                                            <label for="discount_expire_date"> Offers Expire Date</label>
                                            <div class="input-group date" id="discount_expire_date"
                                                 data-target-input="nearest">
                                                <input type="text" name="expire_date" required data-target="#discount_expire_date"  value="{{ date('m/d/Y h:i A', strtotime($purchaseDiscount->expire_date)) }}"class="form-control datetimepicker-input @error('expire_date') is-invalid @enderror ">

                                                <div class="input-group-append" data-target="#discount_expire_date"
                                                     data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="icon icon-calendar"></i></div>
                                                </div>
                                                @error('expire_date')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
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
      $(document).ready(function() {
        $(document).on('change', 'select[name="offer_type"]', function () {
          const item = $(this).val()
          if(item === "specific_time_period"){
            $('.time_period').removeClass('d-none')
          }else {
            $('.time_period').addClass('d-none')
          }
          // console.log("hello")
        })

        $('#discount_expire_date').datetimepicker({
          locale: 'en',
          icons: calIcons
        });
        $('#purchase_start_date').datetimepicker({
          locale: 'en',
          icons: calIcons
        });
        $('#purchase_end_date').datetimepicker({
          locale: 'en',
          icons: calIcons
        });

      })
    </script>
@endsection