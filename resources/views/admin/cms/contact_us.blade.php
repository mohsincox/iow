@extends('layouts.admin_layout')
@section('title')
    Igloo - Contact Us
@endsection
@section('content')
    <div class="dt-content-wrapper">
        <!-- Site Content -->
        <div class="dt-content">
            <!-- Page Header -->
            <div class="dt-page__header">
                <h1 class="dt-page__title">Contact US</h1>
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
                                <div class="col-md-10 col-sm-9">
                                    @if(session()->has('status'))
                                        {!! session()->get('status') !!}
                                    @endif
                                </div>
                            </div>

                            <!-- Form -->
                            <form method="post" action="{{route('admin.contact_us')}}">
                            @csrf
                            <!-- Form Row -->
                                <div class="form-group form-row">
                                    <label class="col-md-2 col-sm-3 col-form-label text-sm-right">Address</label>
                                    <div class="col-md-10 col-sm-9">
                                        <div class="input-group">
                                            <textarea type="text"  placeholder="Address Here..."
                                                      aria-label="Category Name" name="address" required  class="form-control @error('address') is-invalid @enderror ">{{ (isset($contact->address ) ? $contact->address  : null)}} </textarea>
                                            @error('address')
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group form-row">
                                    <label class="col-md-2 col-sm-3 col-form-label text-sm-right">Email</label>
                                    <div class="col-md-10 col-sm-9">
                                        <div class="input-group">
                                            <input type="email"  placeholder="Email..."
                                                      aria-label="Category Name" name="email" required value="{{ (isset($contact->email ) ? $contact->email  : null)}}" class="form-control @error('email') is-invalid @enderror ">
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group form-row">
                                    <label class="col-md-2 col-sm-3 col-form-label text-sm-right">Mobile No</label>
                                    <div class="col-md-10 col-sm-9">
                                        <div class="input-group">
                                            <input type="number"  placeholder="Mobile No"
                                                      aria-label="Category Name" name="mobile_no" required value="{{ (isset($contact->mobile_no ) ? $contact->mobile_no  : null)}}" class="form-control @error('mobile_no') is-invalid @enderror ">
                                            @error('mobile_no')
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group form-row">
                                    <label class="col-md-2 col-sm-3 col-form-label text-sm-right">Telephone No</label>
                                    <div class="col-md-10 col-sm-9">
                                        <div class="input-group">
                                            <input type="number"  placeholder="Telephone No"
                                                      aria-label="Category Name" name="telephone_no" required value="{{ (isset($contact->telephone_no ) ? $contact->telephone_no  : null)}}" class="form-control @error('telephone_no') is-invalid @enderror ">
                                            @error('telephone_no')
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group form-row">
                                    <div class="col-sm-12 col-md-2 offset-md-10 col-lg-2 offset-lg-10 pull-right">
                                        <div class="input-group">
                                            <input type="submit" name="submit" placeholder="Save" class="btn btn-primary" style="border: blanchedalmond;width: 100%;padding: 10px;border-radius: 5px;">
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