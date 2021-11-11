@extends('layouts.default_layout')


@section('stylesheet')

@endsection


@section('content')

    <div class="jumbotron text-center mb-0">
        <h3 class="display-3">Transaction failed.</h3>
        <p class="lead">Your order ID: <strong>{{ Session::get('message') }}</strong> has been placed successfully</p>
        <hr>
        <p>
            Having trouble? <a href="{{ route('contact-us') }}">Contact us</a>
        </p>
        <p class="lead">
            <a class="btn btn-primary btn-sm" href="{{ route('customer-account') }}" role="button">Check order history</a>
        </p>
    </div>
<div class="modal fade" id="after-order-modal" tabindex="-1" role="dialog"
         aria-labelledby="model-8"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">

            <!-- Modal Content -->
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    {{--<h3 class="modal-title" id="model-8">Payment</h3>--}}
                    <button type="button" class="close order-modal-close" data-dismiss="modal" aria-label="Close">&times;
                    </button>
                </div>
                <!-- /modal header -->

                <!-- Modal Body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group text-center">
                                <span style="color: #03a2e5; font-size: 24px">Open an account for more exciting offers.</span>
                                <a href="{{ route('signup') }}" class="btn btn-primary btn-sm p-2 m-3" style="background: var(--dark-pink)">Registrate here</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /modal body -->
                </form>
                <!-- /modal footer -->

            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
      $(document).ready(function() {
        $('#after-order-modal').modal('show')
      })
    </script>
@endsection