@extends('layouts.default_layout')

@section('content')

    <!-- my account start  -->
    <section class="main_content_area">
        <div class="container">
            <div class="account_dashboard">
                <div class="row">
                    <div class="col-sm-12 col-md-3 col-lg-3">
                        <!-- Nav tabs -->
                        <div class="dashboard_tab_button">
                            <ul role="tablist" class="nav flex-column dashboard-list">
                                <li><a href="#my-profile" data-toggle="tab" class="nav-link active">My Profile</a></li>
                                <li> <a href="#orders" data-toggle="tab" class="nav-link">Order History</a></li>
                                <li> <a href="#change-password-tab" data-toggle="tab" class="nav-link">Change Password</a></li>
                                <li><a href="{{route('logout')}}" class="nav-link">logout</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-9 col-lg-9">
                        <!-- Tab panes -->
                        <div class="tab-content dashboard_content">
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
                            <div class="tab-pane fade show active" id="my-profile">
                                <div class="row">
                                    <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                        <div class="profile mb-4">
                                            <div class="profile-thumb">
                                                <form action="{{ route('upload-user-photo') }}" method="POST" enctype="multipart/form-data" id="user_photo_upload">
                                                    @csrf
                                                    <img  class="rounded-circle image-preview" src="{{ Auth::user()->image != null ? asset(Auth::user()->image) :asset('default/assets/img/customer/avator.png') }}" alt="Profile photo" accept="image/*">
                                                    <div class="profile-thumb-edit">
                                                        <i class="fa fa-camera upload-button"></i>
                                                        <input type="file" name="file_upload" class="custom-file-input">
                                                    </div>
                                                </form>
                                            </div>
                                            <p class="text-center mt-3 font-weight-bold">{{ Auth::user()->name }}</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-8 col-lg-8 col-xl-8">
                                        <div class="personal-details">
                                            <div class="border-bottom personal-details-header">
                                                <span>Personal Details</span>
                                                <a href="#" class="float-right btn btn-primary mb-3 btn-user-acount" data-toggle="modal">Edit</a>
                                                <div class="modal fade" id="update-profile-modal" tabindex="-1" role="dialog" aria-labelledby="user-update-profile-modal" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered user-dashboard-modal" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header user_dashboard_modal_hearder">
                                                                <h3 class="modal-title text-center" id="user-update-profile-modal">Update profile</h3>
                                                                <button type="button" class="cancel" data-dismiss="modal" aria-label="Close">&times;</button>
                                                            </div>
                                                            <form action="{{ route('customer-edit-info') }}" method="post">
                                                                @csrf
                                                                <div class="modal-body">
                                                                    <div class="account_form">
                                                                        <div class="form-group">
                                                                            <label for="name">Name</label>
                                                                            <input type="text" name="name" class="form-control" id="name" placeholder="Enter your name" required value="{{ Auth::user()->name  }}">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="email">Email</label>
                                                                            <input type="email" name="email" class="form-control" id="email" placeholder="Enter your email" required value="{{Auth::user()->email }}">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="phone_number">Phone Number</label>
                                                                            <input type="tel" name="phone_number" class="form-control" id="phone_number" required placeholder="Enter your phone number" value="{{ Auth::user()->phone }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="personal-info mt-4 mb-2">
                                                <div class="row mb-3">
                                                    <div class="col-sm-3 col-md-3 text-right col-lg-3 col-xl-3">
                                                        <p>Name</p>
                                                    </div>
                                                    <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 font-weight-bold">
                                                        <p>{{ Auth::user()->name }}</p>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-sm-3 col-md-3 text-right col-lg-3 col-xl-3">
                                                        <p>Email</p>
                                                    </div>
                                                    <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 font-weight-bold">
                                                        <p>{{ Auth::user()->email }}</p>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-sm-3 col-md-3 text-right col-lg-3 col-xl-3">
                                                        <p>Phone number</p>
                                                    </div>
                                                    <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 font-weight-bold">
                                                        <p>{{ Auth::user()->phone }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="tab-pane fade order-history-table" id="orders">
                                <h3>Orders</h3>
                                <div class="table-responsive">
                                    <table class="table" id="data_table">
                                        <thead>
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Date</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($orders as $key=>$value)
                                                <tr class="gradeX">
                                                    <td><a href="{{ route('customer.order.details', $value->id) }}">{{ $value->id }}</a></td>
                                                    <td>{{ date('d-m-Y', strtotime($value->created_at)) }}</td>
                                                    <td>{{ $value->amount }}</td>
                                                    <td>{{ $value->status }}</td>
                                                    <td>
                                                        <a href="{{ route('customer.order.details', $value->id) }}" class="btn btn-primary btn-sm" style="color: #fff!important;">Details</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>


                            <div class="tab-pane" id="change-password-tab">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                        <div class="account_form">
                                            <h2>Change Password</h2>
                                            <div class="com-12 change-password-status"></div>
                                            <form  action="{{ route('customer-change-password') }}" method="post" id="change-password">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="old_password">Old Password*</label>
                                                    <input type="password" name="old_password" class="form-control" id="old_password" placeholder="********" value="{{old('old_password')}}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="new_password">New Password*</label>
                                                    <input type="password" name="new_password" class="form-control" id="new_password" placeholder="********" value="{{old('new_password')}}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="confirm_password">Confirm Password*</label>
                                                    <input type="password" name="confirm_password" class="form-control" id="confirm_password" placeholder="********" value="{{old('confirm_password')}}">
                                                </div>
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="account-details">
                                <h3>Account details </h3>
                                <div class="login">
                                    <div class="login_form_container">
                                        <div class="account_login_form">
                                            <form action="#">
                                                <p>Already have an account? <a href="#">Log in instead!</a></p>
                                                <div class="input-radio">
                                                    <span class="custom-radio"><input type="radio" value="1" name="id_gender"> Mr.</span>
                                                    <span class="custom-radio"><input type="radio" value="1" name="id_gender"> Mrs.</span>
                                                </div> <br>
                                                <label>First Name</label>
                                                <input type="text" name="first-name">
                                                <label>Last Name</label>
                                                <input type="text" name="last-name">
                                                <label>Email</label>
                                                <input type="text" name="email-name">
                                                <label>Password</label>
                                                <input type="password" name="user-password">
                                                <label>Birthdate</label>
                                                <input type="text" placeholder="MM/DD/YYYY" value="" name="birthday">
                                                <span class="example">
                                                  (E.g.: 05/31/1970)
                                                </span>
                                                <br>
                                                <span class="custom_checkbox">
                                                    <input type="checkbox" value="1" name="optin">
                                                    <label>Receive offers from our partners</label>
                                                </span>
                                                <br>
                                                <span class="custom_checkbox">
                                                    <input type="checkbox" value="1" name="newsletter">
                                                    <label>Sign up for our newsletter<br><em>You may unsubscribe at any moment. For that purpose, please find our contact info in the legal notice.</em></label>
                                                </span>
                                                <div class="save_button primary_btn default_button">
                                                    <button type="submit">Save</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- my account end   -->

@endsection

@section('script')
    <script src="{{asset('admin/node_modules/jquery/dist/jquery.min.js')}}"></script>
    <script>
      $(document).ready(function() {

        $('.btn-user-acount').click(function () {
          $('#update-profile-modal').modal()
        })

        $('#data_table').dataTable({
          "order": [[ 1, "DESC" ]],
          "ordering": false
        });

          var readURL = function(input) {
            if (input.files && input.files[0]) {
              var reader = new FileReader();
              reader.onload = function (e) {
                $('.image-preview').attr('src', e.target.result);
              }
              reader.readAsDataURL(input.files[0]);
            }
          }

          $(".custom-file-input").on('change', function(){
            readURL(this);
            $('#user_photo_upload').submit();
          });
          {{--$(".change-password-btn").click(function () {--}}
            {{--$("#")--}}
            {{--$.ajax({--}}
              {{--url: "{{ url('/add-to-cart') }}/"+productID+"?quantity="+quantity,--}}
              {{--method: "get",--}}
              {{--dataType: "json",--}}
              {{--success: function (data) {--}}
                {{--console.log("customer-change-password")--}}
              {{--}--}}
          {{--})--}}
        {{--})--}}
      })
    </script>

@endsection