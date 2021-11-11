@extends('layouts.admin_layout')
@section('title')
    Igloo - Edit User
@endsection
@section('content')
    <div class="dt-content-wrapper">

        <!-- Site Content -->
        <!-- Site Content -->
        <div class="dt-content">

            <!-- Page Header -->
            <div class="dt-page__header">
                <h1 class="dt-page__title">Edit User</h1>
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
                            <form method="post" action="{{route('admin.edit-user', $user->id)}}">
                            @csrf
                            <!-- Form Row -->
                                <div class="form-group form-row">
                                    <label class="col-md-2 col-sm-3 col-form-label text-sm-right">User Name</label>
                                    <div class="col-md-10 col-sm-9">
                                        <div class="input-group">
                                            <input type="text"  placeholder="Name"
                                                   aria-label="Username" name="name" required value="{{$user->name }}" class="form-control @error('name') is-invalid @enderror ">
                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group form-row">
                                    <label class="col-md-2 col-sm-3 col-form-label text-sm-right">Phone Number</label>
                                    <div class="col-md-10 col-sm-9">
                                        <div class="input-group">
                                            <input type="number"  placeholder="Phone"
                                                   aria-label="Userphone" name="phone" required value="{{ $user->phone }}" class="form-control @error('phone') is-invalid @enderror">
                                            @error('phone')
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
                                            <input type="email"  placeholder="Email"
                                                   aria-label="Useremail" name="email" required value="{{ $user->email }}" class="form-control @error('email') is-invalid @enderror " >
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group form-row">
                                    <label class="col-md-2 col-sm-3 col-form-label text-sm-right">Password</label>
                                    <div class="col-md-10 col-sm-9">
                                        <div class="input-group">
                                            <input type="password"  placeholder="Password"
                                                   aria-label="Userpassword" name="password" value="{{old('password')}}" class="form-control @error('password') is-invalid @enderror ">
                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group form-row">
                                    <label class="col-md-2 col-sm-3 col-form-label text-sm-right">User Role</label>
                                    <div class="col-md-10 col-sm-9">
                                        <div class="input-group">
                                            <select name="role"  required  class="form-control @error('role') is-invalid @enderror">
                                                <option value="" >Select a role</option>
                                                @foreach($role As $key => $value)
                                                    <option value="{{ $value['id'] }}"
                                                        @if($user->role_id == $value['id'])
                                                            selected
                                                        @endif
                                                    >{{ $value['name'] }}</option>
                                                @endforeach
                                            </select>
                                            @error('role')
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
                                            <input type="submit" class="btn btn-primary" style="border: blanchedalmond;width: 100%;padding: 10px;border-radius: 5px;">
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