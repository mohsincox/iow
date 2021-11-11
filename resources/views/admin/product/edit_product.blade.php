@extends('layouts.admin_layout')
@section('title')
    Igloo - Edit Product
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
                <h1 class="dt-page__title">Edit Product</h1>
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
                            <form method="post" action="{{route('admin.edit-product', $product->id)}}" enctype="multipart/form-data">
                            @csrf
                                <div class="form-row form-parent-row">
                                    <div class="col-sm-4 col-md-6 mb-6">
                                        <label>Name</label>
                                        <input type="text"  placeholder="Name"
                                           aria-label="Name" name="name" required value="{{ $product->name }}" class="form-control @error('name') is-invalid @enderror ">
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>

                                    <div class="col-sm-4 col-md-6 mb-6">
                                        <label>SKU</label>
                                        <input type="text"  placeholder="SKU"
                                               aria-label="SKU" name="sku"  value="{{ $product->sku }}" class="form-control @error('sku') is-invalid @enderror ">
                                        @error('sku')
                                        <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>

                                    <div class="col-sm-4 col-md-6 mb-6">
                                        <label>Quantity</label>
                                        <input type="number"  placeholder="Quantity"
                                               aria-label="Quantity" name="quantity" required value="{{ $product->quantity }}" min="0" class="form-control @error('quantity') is-invalid @enderror ">
                                        @error('quantity')
                                        <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>

                                    <div class="col-sm-4 col-md-6 mb-6">
                                        <label>Category</label>
                                        <select name="sub_category_id" required class="form-control @error('category_id') is-invalid @enderror">
                                            <option value="">Select a category</option>
                                            @foreach((array)$cat_subCat As $key => $value)
                                                <optgroup label="{{ $key }}">
                                                    @foreach($value As $k => $val)
                                                        <option value="{{ $val['id'] }}"
                                                        @if($val['id'] == $product->sub_category_id)
                                                            selected
                                                        @endif
                                                        >{{ $val['name'] }}</option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                        <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>

                                    <div class="col-sm-4 col-md-6 mb-6">
                                        <label>Regular Price</label>
                                        <input type="number"  placeholder="Price"
                                               aria-label="Price" name="regular_price" required value="{{  $product->price }}"  min="0" class="form-control @error('price') is-invalid @enderror ">
                                        @error('price')
                                        <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>

                                    <div class="col-sm-4 col-md-6 mb-6">
                                        <label>Discount</label>
                                        <input type="number"  placeholder="Discount"
                                               aria-label="Discount" name="discount" min="0" value="{{ $product->discount }}" class="form-control @error('discount') is-invalid @enderror ">
                                        @error('discount')
                                        <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>

                                    <div class="col-12 mb-6">
                                        <label>Description</label>
                                        <textarea name="description" rows="5" class="form-control @error('description') is-invalid @enderror">{{ $product->description }}</textarea>
                                        @error('description')
                                        <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>

                                    <div id="entity_parent" class="col-12">
                                        @if(count($product_has_attribute) < 1)
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
                                        @else
                                            @foreach($product_has_attribute As $key => $value)
                                                @if($key == 0)
                                                    <div class="row">
                                                        <div class="col-md-5">
                                                            <label>Attribute</label>
                                                            <select name="attribute[]" id="attribute" class="form-control ">
                                                                <option value="">Select a attribute</option>
                                                                @foreach($attributes As $key => $val)
                                                                    <option value=" {{$val->id }}"
                                                                        @if($val->id == $value->attribute_id)
                                                                            selected
                                                                        @endif
                                                                    >{{ $val->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-5 attributes_value">
                                                            <label>Value</label>
                                                            <select name="attribute_value[]" id="attribute_value" class="form-control">
                                                                <option value="">Select a value</option>
                                                                @foreach($attribute_value As $key => $val)
                                                                    @if($val->attribute_id == $value->attribute_id)
                                                                        <option value=" {{$val->id }}"
                                                                            @if($val->id == $value->attribute_value_id)
                                                                                selected
                                                                            @endif
                                                                        >{{ $val->value }}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <div class="plus-icon">
                                                                <i class="add-btn form-search icon icon-circle-add-o plus-icon text-primary"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="row remove_from_parent">
                                                        <div class="col-md-5">
                                                            <label>Attribute</label>
                                                            <select name="attribute[]" id="attribute" class="form-control ">
                                                                <option value="">Select a attribute</option>
                                                                @foreach($attributes As $key => $val)
                                                                    <option value=" {{$val->id }}"
                                                                            @if($val->id == $value->attribute_id)
                                                                            selected
                                                                            @endif
                                                                    >{{ $val->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-5 attributes_value">
                                                            <label>Value</label>
                                                            <select name="attribute_value[]" id="attribute_value" class="form-control">
                                                                <option value="">Select a value</option>
                                                                @foreach($attribute_value As $key => $val)
                                                                    @if($val->attribute_id == $value->attribute_id)
                                                                        <option value=" {{$val->id }}"
                                                                                @if($val->id == $value->attribute_value_id)
                                                                                selected
                                                                                @endif
                                                                        >{{ $val->value }}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <div class="plus-icon">
                                                                <i class="remove-entity form-search icon plus-icon icon-circle-remove-o text-danger"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-12 mb-6">
                                        <p>Thumbnail Image</p>
                                        <img src="{{ asset($product->thumbnail_image) }}" class="img-thumbnail image-preview"  alt="Profile photo" accept="image/*" style="max-height: 200px!important; max-width: 300px!important;">
                                    </div>
                                </div>
                                <div class="fileinput fileinput-new input-group mb-6" data-provides="fileinput">
                                    <span class="input-group-append">
                                        <span class="input-group-text fileinput-exists" data-dismiss="fileinput">Remove</span>
                                        <span class="input-group-text btn-file">
                                          <span class="fileinput-new">Select new thumbnail image</span>
                                          <span class="fileinput-exists">Change</span>
                                          <input type="file" name="thumbnail_image" class="custom-file-input">
                                        </span>
                                    </span>
                                    <div class="form-control" data-trigger="fileinput">
                                        <span class="fileinput-filename"></span>
                                    </div>
                                </div>


                                <div class="form-row mb-6">
                                    @foreach($image As $key => $url)
                                        <div class="col-md-3 text-center image-area">
                                            <img src="{{ asset($url->image) }}" height="175px" width="75%" alt="imag" class="mb-2">
                                            <span class="btn btn-outline-danger btn-sm remove-product-image mb-6" data-id="{{ $product->id }}" data-image="{{ $url->image }}">Remove</span>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="fileinput fileinput-new input-group mb-6" data-provides="fileinput">
                                    <span class="input-group-append">
                                        <span class="input-group-text fileinput-exists" data-dismiss="fileinput">Remove</span>
                                        <span class="input-group-text btn-file">
                                          <span class="fileinput-new">New Image</span>
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
                                            <input type="submit" name="submit" style="border: blanchedalmond;width: 100%;padding: 10px;border-radius: 5px;" class="btn btn-primary">
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

        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

        $(document).on('click', '.remove-product-image', function () {
          var $this = $(this);
          var product_id = $this.data('id');
          var image = $this.data('image');
          console.log(image)
          $.ajax({
            url: "{{ route('admin.delete-product-image') }}",
            method: "post",
            dataType: "html",
            data: { image: image, product_id: product_id },
            success: function (data) {
              // console.log(data)
              if (data === "success"){
                $this.closest('.image-area').css('background-color', 'red').fadeOut();
              }
            }
          });
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

        $(document).on("click", '.add-btn', function () {
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
            '                                                                <i class="remove-entity form-search icon plus-icon icon-circle-remove-o text-danger"></i>\n' +
            '                                                            </div>\n' +
            '                                                        </div>\n' +
            '                                                    </div>')

        })

        $(document).on('click', '.remove-entity', function () {
          $(this).closest('.row').remove();
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