@inject('PublicFunction', 'App\Http\Controllers\PublicFunction')
@extends('layouts.admin_layout')
@section('title')
    Igloo - Add Product
@endsection

@section('stylesheet')
    <link rel="stylesheet" href="{{ asset('admin/assets/css/multiselect.css') }}">

    <link rel="stylesheet" href="{{ asset('default/assets/fromcdn/jasny-bootstrap.min.css') }}">
    <script src="{{ asset('default/assets/fromcdn/jasny-bootstrap.min.js') }}"></script>

@endsection


<style>
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    .plus-icon i{
        font-size: 45px;
    }
    .add-more label {
        margin-right: 20px;
        margin-left: 20px;
    }
    .plus-icon {
        margin-left: 20px;
        margin: 10px;
    }
    .file-input-product{
        display: flex;
        align-items: center;
    }
    .file-input-product input{
        width: 70%;
        margin-right: 10px;
    }
</style>
@section('content')
    <div class="dt-content-wrapper">

        <!-- Site Content -->
        <!-- Site Content -->
        <div class="dt-content">

            <!-- Page Header -->
            <div class="dt-page__header">
                <h1 class="dt-page__title">Add Product</h1>
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
                            @if($PublicFunction::checkPermission($userPermission, ["update_product", "view_product", "delete_product"]))
                                <div class="text-right">
                                    <a href="{{ route('admin.view-product') }}" class="btn btn-primary"><i class="icon icon-breadcrumbs"></i> View Product</a>
                                </div>
                            @endif
                            <div class="form-group form-row">
                                <div class="col-12">
                                    @if(session()->has('status'))
                                        {!! session()->get('status') !!}
                                    @endif
                                      <ul>
                                        @error('thumbnail_image')
                                          <li class="text-danger">
                                              <strong>The thumbnail image must be a file of type: jpeg, bmp, png, jpg, gif.</strong>
                                          </li>
                                        @enderror
                                        @error('image')
                                          <li class="text-danger">
                                              <strong>The image must be a file of type: jpeg, bmp, png, jpg, gif.</strong>
                                          </li>
                                        @enderror
                                      </ul>
                                </div>
                            </div>

                            <!-- Form -->
                            <form method="post" action="{{route('admin.add-product')}}" enctype="multipart/form-data">
                            @csrf

                                <div class="form-row form-parent-row">

                                    <div class="col-sm-4 col-md-6 mb-6">
                                        <label>Name</label>
                                        <input type="text"  placeholder="Name"
                                               aria-label="Name" name="name" required value="{{old('name')}}" class="form-control @error('name') is-invalid @enderror ">
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>

                                    <div class="col-sm-4 col-md-6 mb-6">
                                        <label>SKU</label>
                                        <input type="text"  placeholder="SKU"
                                               aria-label="SKU" name="sku" value="{{old('sku')}}" class="form-control @error('sku') is-invalid @enderror ">
                                        @error('sku')
                                        <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>

                                    <div class="col-sm-4 col-md-6 mb-6">
                                        <label>Quantity</label>
                                        <input type="number"  placeholder="Quantity"
                                               aria-label="Quantity" name="quantity" required value="{{old('quantity')}}" min="0" class="form-control @error('quantity') is-invalid @enderror ">
                                        @error('quantity')
                                        <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>

                                    <div class="col-sm-4 col-md-6 mb-6">
                                        <label>Category</label>
                                        <select name="sub_category_id" required class="form-control @error('sub_category_id') is-invalid @enderror">
                                            <option value="" selected>Select a category</option>
                                            @foreach((array)$cat_subCat As $key => $value)
                                                <optgroup label="{{ $key }}">
                                                    @foreach($value As $k => $val)
                                                        <option value="{{ $val['id'] }}" @if(old('sub_category_id') == $val['id']) selected @endif>{{ $val['name'] }}</option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                        </select>
                                        @error('sub_category_id')
                                        <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>

                                    {{--<div class="col-sm-4 col-md-6 mb-6">--}}
                                        {{--<label>Sub-Category</label>--}}
                                        {{--<select name="sub_category_id" required class="form-control @error('sub_category_id') is-invalid @enderror">--}}
                                            {{--<option value="" selected>Select a sub-category</option>--}}
                                            {{--@foreach($subcategory As $key => $value)--}}
                                                {{--<option value="{{ $value['id'] }}">{{ $value['name'] }}</option>--}}
                                            {{--@endforeach--}}
                                        {{--</select>--}}
                                        {{--@error('sub_category_id')--}}
                                        {{--<span class="invalid-feedback" role="alert">--}}
                                                    {{--<strong>{{ $message }}</strong>--}}
                                                {{--</span>--}}
                                        {{--@enderror--}}
                                    {{--</div>--}}

                                    <div class="col-sm-4 col-md-6 mb-6">
                                        <label>Regular Price</label>
                                        <input type="number" step="0.01"  placeholder="Price"
                                               aria-label="Price" name="regular_price" required value="{{old('regular_price')}}"  min="0" class="form-control @error('price') is-invalid @enderror ">
                                        @error('price')
                                        <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>

                                    <div class="col-sm-4 col-md-6 mb-6">
                                        <label>Discount</label>
                                        <input type="number" step="0.01" placeholder="Discount"
                                               aria-label="Discount" name="discount" min="0" value="{{old('discount')}}" class="form-control @error('discount') is-invalid @enderror ">
                                        @error('discount')
                                        <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>


                                    <div class="col-12 mb-6">
                                        <label>Description</label>
                                        <textarea name="description" required rows="5" class="form-control @error('description') is-invalid @enderror">{{old('description')}}</textarea>
                                        @error('description')
                                        <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>

                                    <div id="entity_parent" class="col-12">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <label>Attribute</label>
                                                <select name="attribute[]" id="attribute" class="form-control ">
                                                    <option value="">Select a attribute</option>
                                                    @foreach($attributes As $key => $value)
                                                        <option value=" {{$value->id }}">{{ $value->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-5 attributes_value">

                                            </div>

                                            <div class="col-md-2">
                                                <div class="plus-icon">
                                                    <i class="add-btn form-search icon icon-circle-add-o plus-icon text-primary"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{--<div class="col-md-6 col-sm-12 mb-6">--}}
                                        {{--<img  class="rounded-circle image-preview"  alt="Profile photo" accept="image/*">--}}
                                        {{--<div class="profile-thumb-edit">--}}
                                            {{--<i class="upload-button"></i>--}}
                                            {{--<input type="file" name="thumbnail_image">--}}
                                        {{--</div>--}}
                                    {{--</div>--}}


                                </div>

                                <div class="col-md-6 col-sm-12 mb-6">
                                    <img  class="img-thumbnail d-none image-preview" style="max-height: 200px!important; max-width: 300px!important;" alt="Profile photo" accept="image/*">
                                </div>
                                <div class="fileinput fileinput-new input-group mb-6" data-provides="fileinput">
                                    <span class="input-group-append">
                                        <span class="input-group-text fileinput-exists" data-dismiss="fileinput">Remove</span>
                                        <span class="input-group-text btn-file">
                                          <span class="fileinput-new">Select thumbnail image</span>
                                          <span class="fileinput-exists">Change</span>
                                          <input type="file" name="thumbnail_image" class="custom-file-input" required>
                                        </span>
                                    </span>
                                    <div class="form-control" data-trigger="fileinput">
                                        <span class="fileinput-filename"></span>
                                    </div>
                                  @error('thumbnail_image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                  @enderror
                                </div>


                                <div class="fileinput fileinput-new input-group mb-6" data-provides="fileinput">
                                    <span class="input-group-append">
                                        <span class="input-group-text fileinput-exists" data-dismiss="fileinput">Remove</span>
                                        <span class="input-group-text btn-file">
                                          <span class="fileinput-new">Select file</span>
                                          <span class="fileinput-exists">Change</span>
                                          <input type="file" name="image[]" multiple>
                                        </span>
                                    </span>
                                    <div class="form-control" data-trigger="fileinput">
                                        <span class="fileinput-filename"></span>
                                    </div>
                                </div>


                                <div class="form-group form-row">
                                    <div class="col-sm-12 col-md-2 offset-md-10 col-lg-2 offset-lg-10 pull-right">
                                        <div class="input-group">
                                            <input type="submit" name="submit" class="btn btn-primary" style="border: blanchedalmond;width: 100%;padding: 10px;border-radius: 5px;">
                                        </div>
                                    </div>
                                </div>
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


    <script>
        $(document).ready(function() {

          var readURL = function(input) {
            if (input.files && input.files[0]) {
              var reader = new FileReader();
              reader.onload = function (e) {
                $('.image-preview').attr('src', e.target.result);
                $('.image-preview').removeClass('d-none');
              }
              reader.readAsDataURL(input.files[0]);
            }else{
              $('.image-preview').addClass('d-none');
            }
          }

          $(".custom-file-input").on('change', function(){
            readURL(this);
            // $('#user_photo_upload').submit();
          });


          $('.add-image-btn').on("click", function () {
            $('.form-parent-row').append('<div class="col-md-6 col-sm-12 mb-6 image-parent">\n' +
                '                                        <div class="file-input-product">\n' +
                '                                            <input type="file" name="file[]" class="form-control">\n' +
                '                                            <span class="btn btn-outline-danger remove-image-btn">Remove</span>\n' +
                '                                        </div>\n' +
                '                                    </div>')
          })
          $(document).on('click', '.remove-image-btn', function () {
            $(this).parents('.image-parent').remove();
          });

          $(document).on('change', 'select[name="attribute[]"]', function () {
            const attributes_id = $(this).val();
            const $this = $(this);
            var output = "";
            if(attributes_id !== "") {
              $.ajax({
                url: "{{ route('ajax.get_attributes_value') }}",
                method: "POST",
                dataType: "json",
                data: {attributes_id: attributes_id},
                success: function (attributes_value) {
                  output += '<label>Value</label>';
                  if (attributes_value.length > 0) {
                    output += '<select name="attribute_value[]" id="attribute_value" class="form-control">';
                    output += '<option value="">Select a value</option>';
                    $.each(attributes_value, function (i, e) {
                      output += '<option value="' + e.id + '">' + e.value + '</option>';
                    })
                    output += '</select>';
                  } else { // if attributes has no value
                    output += '<select name="attribute_value[]" id="attribute_value" class="form-control">';
                    output += '<option value="">Select a value</option>';
                    output += '</select>';
                  }

                  $this.closest('.row').find('.attributes_value').html(output);
                }
              })
            }


          })

          $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });


          $('.add-btn').on("click", function () {
            $('#entity_parent').append('<div class="row remove_from_parent">\n' +
                '                                                        <div class="col-md-5">\n' +
                '                                                            <label>Attribute</label>\n' +
                '                                                            <select name="attribute[]" id="attribute" class="form-control ">\n' +
                '                                                                <option value="">Select a attribute</option>\n' +
                '                                                                @foreach($attributes As $key => $value)\n' +
                '                                                                    <option value=" {{$value->id }}">{{ $value->name }}</option>\n' +
                '                                                                @endforeach\n' +
                '                                                            </select>\n' +
                '                                                        </div>\n' +
                '                                                        <div class="col-md-5 attributes_value">\n' +
                '\n' +
                '                                                        </div>\n' +
                '\n' +
                '                                                        <div class="col-md-2">\n' +
                '                                                            <div class="plus-icon">\n' +
                '                                                                <i class=" remove-entity add-btn form-search icon plus-icon icon-circle-remove-o text-danger"></i>\n' +
                '                                                            </div>\n' +
                '                                                        </div>\n' +
                '                                                    </div>')

          })

          $(document).on('click', '.remove-entity', function () {
            $(this).parents('.remove_from_parent').remove();
          });


          $('select[multiple]').multiselect({
            columns  : 1,
            search   : true,
            selectAll: true,
            texts    : {
              search     : 'Search States'
            }
          });


        });
    </script>
@endsection
