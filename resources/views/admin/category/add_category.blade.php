@inject('PublicFunction', 'App\Http\Controllers\PublicFunction')
@extends('layouts.admin_layout')
@section('title')
    Igloo - Add Category
@endsection
@section('content')
    <div class="dt-content-wrapper">

        <!-- Site Content -->
        <!-- Site Content -->
        <div class="dt-content">

            <!-- Page Header -->
            <div class="dt-page__header">
                <h1 class="dt-page__title">Add Category</h1>
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
                            <div class="text-right">
                                @if($PublicFunction::checkPermission($userPermission, ["view_category", "update_category", "delete_category"]))
                                    <a href="{{ route('admin.view-category') }}" class="btn btn-primary"><i class="icon icon-breadcrumbs"></i> View Category</a>
                                @endif
                                <div class="form-group form-row">
                                    <label class="col-md-2 col-sm-3 col-form-label text-sm-right"></label>
                                    <div class="col-md-10 col-sm-9">
                                        @if(session()->has('status'))
                                            {!! session()->get('status') !!}
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <!-- Form -->
                            <form method="post" action="{{route('admin.add-category')}}">
                            @csrf
                            <!-- Form Row -->
                                <div class="form-group form-row">
                                    <label class="col-md-2 col-sm-3 col-form-label text-sm-right">Category Name</label>
                                    <div class="col-md-10 col-sm-9">
                                        <div class="input-group">
                                            <input type="text"  placeholder="Category Name"
                                                   aria-label="Category Name" name="name" required value="{{old('name')}}" class="form-control @error('name') is-invalid @enderror ">
                                            @error('name')
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