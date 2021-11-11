@extends('layouts.admin_layout')
@section('title')
    Igloo - Manage Permission
@endsection
@section('content')
    <div class="dt-content-wrapper">

        <!-- Site Content -->
        <!-- Site Content -->
        <div class="dt-content">

            <!-- Page Header -->
            <div class="dt-page__header">
                <h1 class="dt-page__title">Update Permission</h1>
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
                            <form action="{{ route('admin.permission') }}" method="POST">
                                @csrf
                                <div class="form-group form-row">
                                    <label class="col-md-2 col-sm-3 col-form-label text-sm-right">User Role</label>
                                    <div class="col-md-10 col-sm-9">
                                        <div class="input-group">
                                            <select name="role"  class="form-control @error('role') is-invalid @enderror">
                                                <option value="" selected>Select a role</option>
                                                @foreach($role As $key => $value)
                                                    <option value="{{ $value['id'] }}">{{ $value['name'] }}</option>
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
                                    <label class="col-md-2 col-sm-3 col-form-label text-sm-right"></label>
                                    <div class="col-md-10 col-sm-9">
                                        <div class="row">
                                            <div id="permissions"></div>
                                            {{--@foreach($permission As $key => $value)--}}
                                                {{--<div class="custom-control custom-checkbox mb-3 col-md-4 col-lg-3 col-sm-6">--}}
                                                    {{--<input type="checkbox" name="permission[]" id="{{$value->id}}" class="custom-control-input" checked="">--}}
                                                    {{--<label class="custom-control-label" for="{{$value->id}}">{{ $value->name }}</label>--}}
                                                {{--</div>--}}
                                            {{--@endforeach--}}
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
                            </form>
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
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('select[name="role"]').on('change', function () {
                // role id
                const roleId = $(this).val();
                var output = "";
                var permissions = JSON.parse('{!! $permission !!}');
                if (roleId !== "") {
                    // get all permission based on role id
                    $.ajax({
                        url: "{{ route('ajax.get_permission_by_role') }}",
                        method: "POST",
                        dataType: "json",
                        data: {role_id: roleId},
                        success: function (currentPermissions) {
                            if (currentPermissions.length > 0){
                                $.each(permissions, function (i, e) {
                                    output += '<div class="d-inline mb-3 col-3">';
                                    if(hasPermission(currentPermissions, e.id)){
                                        output += '<label><input type="checkbox" name="permission[]" value="'+e.id+'" checked> '+e.name+'</label>';
                                    }else{
                                        output += '<label><input type="checkbox" name="permission[]" value="'+e.id+'"> '+e.name+'</label>' ;
                                    }
                                    output += '</div>';
                                })
                                $('#permissions').html(output);
                            }else { // output all the permission without checked
                                $.each(permissions, function (i, e) {
                                    output += '<div class="d-inline mb-3 col-3">';
                                    output += '<label><input type="checkbox" name="permission[]" value="'+e.id+'" > '+e.name+'</label>';
                                    output += '</div>';
                                })
                                $('#permissions').html(output);
                            }
                        }
                    })
                }
            })

            // checks if the user has permission
            function hasPermission(currentPermissions, permissionId){
                
                var ret = false;
                $.each(currentPermissions, function (i, e) {
                    if (Number(e.permission_id) === Number(permissionId)){
                        ret = true
                    }
                })
                return ret;
            }
        })
    </script>

@endsection