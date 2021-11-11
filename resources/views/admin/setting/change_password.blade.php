@extends('layouts.admin_layout')
@section('title')
    Igloo - Change password
@endsection
@section('content')
    <div class="dt-content-wrapper">

        <!-- Site Content -->
        <!-- Site Content -->
        <div class="dt-content">

            <!-- Page Header -->
            <div class="dt-page__header">
                <h1 class="dt-page__title">Change password</h1>
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
                            <form method="post" action="{{route('admin.change-password')}}">
                            @csrf
                            <!-- Form Row -->
                                <div class="form-group form-row">
                                    <label class="col-md-2 col-sm-3 col-form-label text-sm-right">Old Password</label>
                                    <div class="col-md-10 col-sm-9">
                                        <div class="input-group">
                                            <input type="password"  placeholder="Old Password"
                                                   aria-label="Userpassword" name="oldpassword" required value="{{old('oldpassword')}}" class="form-control @error('oldpassword') is-invalid @enderror ">
                                            @error('oldpassword')
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group form-row">
                                    <label class="col-md-2 col-sm-3 col-form-label text-sm-right">New Password</label>
                                    <div class="col-md-10 col-sm-9">
                                        <div class="input-group">
                                            <input type="password"  placeholder=" New Password"
                                                   aria-label="Userpassword" name="newpassword" required value="{{old('newpassword')}}" class="form-control @error('newpassword') is-invalid @enderror ">
                                            @error('newpassword')
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group form-row">
                                    <label class="col-md-2 col-sm-3 col-form-label text-sm-right">Confirm Password</label>
                                    <div class="col-md-10 col-sm-9">
                                        <div class="input-group">
                                            <input type="password"  placeholder="Confirm Password"
                                                   aria-label="Userpassword" name="confirm_password" required value="{{old('confirm_password')}}" class="form-control @error('confirm_password') is-invalid @enderror ">
                                            @error('confirm_password')
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
@endsection