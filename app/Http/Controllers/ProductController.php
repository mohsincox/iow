<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use App\Product_image;
use App\Sub_category;
use Illuminate\Support\Facades\DB;
//use Intervention\Image\ImageManagerStatic as Image;
use Symfony\Component\HttpFoundation\File\File;
use Image;
use Validator;
use Illuminate\Http\Request;

class ProductController extends Controller
{


    #find array keys
    function findKey($array, $keySearch) {
        foreach ($array as $key => $item) {
            if ($key == $keySearch) {
                return true;
            } elseif (is_array($item) && $this->findKey($item, $keySearch)) {
                return true;
            }
        }
        return false;
    }
    /*
     * admin will add product category
     * */
    public function add_category_by_admin(Request $request){
        if($request->isMethod("POST")){
            $data = $request->all();
            $validator = Validator::make($data, [
                'name' => 'required'
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            $exist_category = Category::where('name', '=', $data['name'])->get();
            if(count($exist_category) < 1 ) {
                $category = new Category();
                $category->name = $data['name'];
                if($category->save()){
                    $status = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>'. $data['name'] .'</strong>Category successfully Added.
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                        </div>';
                    return redirect()->back()->with('status', $status);
                }
                $status = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                                Something went to wrong.
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                        </div>';
                return redirect()->back()->with('status', $status)->withInput();
            }else{
                $status = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                                  <strong>'. $data['name'] .'!!!</strong>Already exist in Category.
                                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                </div>';
                return redirect()->back()->with('status', $status)->withInput();
            }
        }
        return view('admin.category.add_category');
    }
    /*
     * admin will view all product category
     * */
    public function view_category_by_admin(){
        $category = Category::where('deleted_at', '=', null)->get();
        return view('admin.category.view_category')->with('category', $category);
    }
    /*
     * admin will delete product category
     * */
    public function delete_category_by_admin(Request $request){
        if($request->isMethod("POST")) {
            if(Category::where('id', '=', $request->post('id'))->where('deleted_at', '=', null)->delete()){
                return "success";
            }
        }
    }
    /*
     * admin will delete product category
     * */
    public function edit_category_by_admin(Request $request, $category_id){
        $category = Category::where('id', '=', $category_id)->where('deleted_at', '=', null)->get();
        if(count($category) > 0){
            $category = $category[0];
            if($request->isMethod("POST")){
                $data = $request->all();
                $validator = Validator::make($data, [
                    'name' => 'required'
                ]);

                if ($validator->fails()) {
                    return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
                }
                $exist_category = Category::where('name', '=', $data['name'])->where('deleted_at', '=', null)->get();
                if(count($exist_category) < 1 ) {
                    $result = Category::where('id', '=', $category->id)->update(['name' => $data['name']]);
                    if ($result) {
                        $status = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>' . $data['name'] . '</strong>Category successfully updated.
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                        </div>';
                        return redirect()->route('admin.view-category')->with('status', $status);
                    } else {
                        $status = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                          Something Went wrong.
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                        </div>';
                        return redirect()->back()->with('status', $status)->withInput();
                    }
                }else{
                    $status = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <strong>'. $data['name'] .'!!!</strong>Already exist in Category.
                                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                            </div>';
                    return redirect()->back()->with('status', $status)->withInput();
                }
            }
            return view('admin.category.edit_category')->with('category', $category);
        }
        return redirect()->route('404');
    }
    /*
     * admin will add product sub category
     * */
    public function add_sub_category_by_admin(Request $request){
        $category = Category::where('deleted_at', '=', null)->get();
        if($request->isMethod("POST")){
            $data = $request->all();
            $validator = Validator::make($data, [
                'category_id' => 'required',
                'name' => 'required'
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            $exist_subcategory = Sub_category::where('name', '=', $data['name'])->where('category_id', '=', $data['category_id'])->get();
            if(count($exist_subcategory) < 1 ) {
                $subcategory = new Sub_category();
                $subcategory->name = $data['name'];
                $subcategory->category_id = $data['category_id'];
                if($subcategory->save()){
                    $status = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>'. $data['name'] .'</strong>Sub category successfully Added.
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                        </div>';
                    return redirect()->back()->with('status', $status);
                }
                $status = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                                Something went to wrong.
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                        </div>';
                return redirect()->back()->with('status', $status)->withInput();
            }else{
                $status = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                              <strong>'. $data['name'] .'!!!</strong>Already exist in Sub Category.
                                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                            </div>';
                return redirect()->back()->with('status', $status)->withInput();
            }
        }
        return view('admin.sub_category.add_sub_category')->with('category', $category);
    }
    /*
     * admin will view all products sub category
     * */
    public function view_sub_category_by_admin(){
        $subcategory = DB::table('categories')
            ->join('sub_categories', 'sub_categories.category_id', '=', 'categories.id')
            ->select('sub_categories.id', 'sub_categories.category_id', 'sub_categories.name', 'categories.name As category_name')
            ->where('sub_categories.deleted_at', '=', null)
            ->where('categories.deleted_at', '=', null)
            ->get();
        return view('admin.sub_category.view_sub_category')->with('subcategory', $subcategory);
    }
    /*
     * admin will delete products sub category
     * */
    public function delete_sub_category_by_admin(Request $request){
        if($request->isMethod("POST")) {
            $id = $request->post('id');
            if(Sub_category::where('id', '=', $id)->where('deleted_at', '=', null)->delete()){
                return "success";
            }
        }

    }
    /*
     * admin will update product sub category
     * */
    public function edit_sub_category_by_admin(Request $request, $sub_category_id){
//        return "he";
        $category = Category::where('deleted_at', '=', null)->get();
        $subcategory = Sub_category::where('id', '=', $sub_category_id)->where('deleted_at', '=', null)->get();
        if(count($subcategory) > 0){
            $subcategory = $subcategory[0];
            if($request->isMethod("POST")){
                $data = $request->all();
                $validator = Validator::make($data, [
                    'name' => 'required',
                    'category_id' => 'required'
                ]);

                if ($validator->fails()) {
                    return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
                }
                $exist_subcategory = Sub_category::where('name', '=', $data['name'])->where('category_id', '=', $data['category_id'])->get();
                if(count($exist_subcategory) < 1 ) {
                    $result = Sub_category::where('id', '=', $subcategory->id)->update(['name' => $data['name'], 'category_id' => $data['category_id']]);
                    if ($result) {
                        $status = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>' . $data['name'] . '</strong>Sub Category successfully updated.
                                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                            </div>';
                        return redirect()->route('admin.view-sub-category')->with('status', $status);
                    } else {
                        $status = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                              Something Went wrong.
                                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                            </div>';
                        return redirect()->back()->with('status', $status)->withInput();
                    }
                }else{
                    $status = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                              <strong>'. $data['name'] .'!!!</strong>Already exist in Sub Category.
                                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                            </div>';
                    return redirect()->back()->with('status', $status)->withInput();
                }
            }
            return view('admin.sub_category.edit_sub_category', compact('category', 'subcategory'));
        }
        return redirect()->route('404');
    }
    /*
     * admin will see all value of each attributes
     * */
    public function get_attributes_value(Request $request){
        if($request->isMethod("POST")) {
            $attributes_id = $request->post('attributes_id');
            $attributes_value = PublicFunction::get_attributes_value($attributes_id);
            return $attributes_value;
        }
    }
    /*
     * admin will update product sub category
     * */
    public function add_product_by_admin(Request $request){
        $categorySubCategory = DB::table('categories')
            ->join('sub_categories', 'sub_categories.category_id', '=', 'categories.id')
            ->select('categories.id As category_id', 'categories.name As category_name', 'sub_categories.id As sub_category_id', 'sub_categories.name As sub_category_name')
            ->whereNull('categories.deleted_at')
            ->whereNull('sub_categories.deleted_at')
            ->get();
        $cat_subCat = [];
        foreach ($categorySubCategory As $key => $value){
            if(!$this->findKey($cat_subCat, $value->category_name)){
                $cat_subCat[$value->category_name][]= [
                    'id' => $value->sub_category_id,
                    'name' => $value->sub_category_name
                ];
            }else{
                $cat_subCat[$value->category_name][]= [
                    'id' => $value->sub_category_id,
                    'name' => $value->sub_category_name
                ];
            }
        }
        $attributes = PublicFunction::get_attributes();
        if ($request->isMethod('POST')) {
            $data = $request->all();
            $validator = Validator::make($data, [
                'name' => 'required',
                'description' => 'required',
//                'sku' => 'required',
                'quantity' => 'required',
                'regular_price' => 'required',
//                'selling_price' => 'required',
                'sub_category_id' => 'required',
//                'attribute_value' => 'required'
            ]);
//
//            if ($validator->fails()) {
//                return redirect()->back()
//                    ->withErrors($validator)
//                    ->withInput();
//            }
            //  subCategory to Category
            $category = PublicFunction::get_category_to_subcategory($data['sub_category_id']);
            $validator2_has_error = true;
            if ($request->hasFile('thumbnail_image')) {
              $validator2 = Validator::make($request->all(), [
                'thumbnail_image' => 'mimes:jpeg,bmp,png,jpg,gif'
              ]);
              if (!$validator2->fails()) {
                $validator2_has_error = false;
                $image2 = $request->file('thumbnail_image');
                $name2 = time() . '.' . $image2->getClientOriginalExtension();

                // Resize the image for thumbnail
                  $image_resize = Image::make($image2);
                  $image_resize->resize(375, 250);

                // Upload original image
                $original_path = 'product_images/original/';
                $original_destinationPath = public_path($original_path);
                $image2->move($original_destinationPath, $name2);

                // Upload thumbnail
                $path2 = 'product_images/thumbnail/';
                $destinationPath2 = public_path($path2);
                $image_resize->save($destinationPath2 .$name2);

//                $image2->move($destinationPath2, $name2);
              }
            }

            $images = array();
          $validator1 = null;
            if ($request->hasFile('image')) {
              if ($files = $request->file('image')) {

  //                 multiple image type validation
                foreach ($files as $file) {
                  $i = 0;
                  $m = 0;
                  $image = ['image' => $file];
                  $validatorM = Validator::make($image, [
                    'image' => 'mimes:jpeg,bmp,png,jpg,gif'
                  ]);
                  if ($validatorM->fails()) {
                    if($m == 0){
                      $validator1 = $validatorM;
                    }else{
                      $validator1 = $validator1->messages()->merge($validatorM->messages());
                    }
                    $m++;
                  }else{
                    $i++;
                    $name = time() . $i . '.' . $file->getClientOriginalExtension();
                    $path = 'product_images/';
                    $destinationPath = public_path($path);
                    $file->move($destinationPath, $name);
                    $images[] = $path . $name;
                  }
                }
              }
            }
            $errors = null;
            if(isset($validator) && $validator->fails()) {
                if ($errors == null) {
                    $errors = $validator;
                } else {
                    $errors = $validator->messages()->merge($validator1->messages());
                }
            }
            if( $validator1 != null && $validator1->fails()) {
                if ($errors == null) {
                    $errors = $validator1;
                } else {
                    $errors = $errors->messages()->merge($validator1->messages());
                }
            }
            if($validator2_has_error) {
                if ($errors == null) {
                    $errors = $validator2;
                } else {
                    $errors = $errors->messages()->merge($validator2->messages());
                }
            }
            if($errors != null && $errors->fails()){
              return redirect()->back()
                ->withErrors($errors)
                ->withInput();
            }
//
//if($validator->fails() || (isset($validator1) && $validator1->fails() && $validator1 != null) || (isset($validator2) && $validator2->fails())){
//              $errors = $validator->messages()->merge($validator1->messages()->merge($validator2->messages()));
////              return $errors;
//              return redirect()->back()
//                ->withErrors($errors)
//                ->withInput();
//            }
//            return $request;
            $thumbnail_image = '';
            if (isset($name2)) {
                $original_image = $original_path . $name2;
                $thumbnail_image = $path2 . $name2;
            } else {
                $status = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                          Thumbnail image missing. 
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                        </div>';
                return redirect()->back()->with('status', $status)->withInput();
            }

            $product = new Product();
            $product->category_id = $category->id;
            $product->sub_category_id = $data['sub_category_id'];
            $product->name = $data['name'];
            if (!($data['discount'] == null || $data['discount'] == "")) {
                $product->discount = $data['discount'];
            }
            $product->price = $data['regular_price'];
            if (!($data['discount'] == null || $data['discount'] == "")) {
                $slling_product = $data['regular_price'] - (($data['regular_price'] * $data['discount'])/100);
                $product->selling_price = intval($slling_product);
            }
//            return intval($product->selling_price) ;
            $product->quantity = $data['quantity'];
            $product->sku = $data['sku'];
            $product->description = $data['description'];
            $product->thumbnail_image = $thumbnail_image;
            $product->original_image = $original_image;
            if($product->save()){
                // inserting attribute link
                if(isset($data['attribute_value'])) {
                    foreach ($data['attribute_value'] As $key => $value) {
                        DB::table('attribute_link')->insert(['attribute_meta_id' => $value, 'product_id' => $product->id]);
                    }
                }

                foreach ($images As $image){
                    $product_image = new Product_image();
                    $product_image->image = $image;
                    $product_image->product_id = $product->id;
                    $product_image->save();
                }
                $status = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                          Product successfully added. 
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                        </div>';
                return redirect()->back()->with('status', $status);
            }
            $status = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                          Something went wrong. 
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                        </div>';
            return redirect()->back()->with('status', $status)->withInput();
        }
        return view('admin.product.add_product', compact('cat_subCat', 'attributes'));
    }
    /*
     * admin will view all product
     * */
    public function view_product_by_admin(){
        $prduct = DB::table('products')
            ->leftJoin('product_has_images', 'product_has_images.product_id', '=', 'products.id')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->join('sub_categories', 'sub_categories.id', '=', 'products.sub_category_id')
            ->select('products.id', 'products.name', 'products.thumbnail_image', 'products.quantity', 'products.sku', 'products.price', 'products.discount', 'sub_categories.name As sub_category_name', 'categories.name As category_name', DB::raw('group_concat(product_has_images.image) as image'))
            ->whereNull('products.deleted_at')
            ->groupBy('products.id')
            ->orderBy('products.id', 'ASC')
            ->get();
        return view('admin.product.view_product')->with('product', $prduct);
    }
    /*
     * admin will edit product
     * */
    public function edit_product_by_admin(Request $request, $product_id){
        $categorySubCategory = DB::table('categories')
            ->join('sub_categories', 'sub_categories.category_id', '=', 'categories.id')
            ->select('categories.id As category_id', 'categories.name As category_name', 'sub_categories.id As sub_category_id', 'sub_categories.name As sub_category_name')
            ->get();
        $attributes = PublicFunction::get_attributes();
        $attribute_value = PublicFunction::get_all_attribute_value();

        $cat_subCat = [];
        foreach ($categorySubCategory As $key => $value){
            if(!$this->findKey($cat_subCat, $value->category_name)){
                $cat_subCat[$value->category_name][]= [
                    'id' => $value->sub_category_id,
                    'name' => $value->sub_category_name
                ];
            }else{
                $cat_subCat[$value->category_name][]= [
                    'id' => $value->sub_category_id,
                    'name' => $value->sub_category_name
                ];
            }
        }
        $product = DB::table('products')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->join('sub_categories', 'sub_categories.id', '=', 'products.sub_category_id')
            ->select('products.*', 'sub_categories.name As sub_category_name', 'categories.name As category_name')
            ->whereNull('products.deleted_at')
            ->where('products.id', '=', $product_id)
            ->groupBy('products.id')
            ->get();
        if(count($product) > 0) {
            $product = $product[0];
            $product_has_attribute = DB::table('attribute_link')
                ->join('attribute_meta', 'attribute_meta.id', '=', 'attribute_link.attribute_meta_id')
                ->join('attributes', 'attributes.id', '=', 'attribute_meta.attribute_id')
                ->select('attributes.id As attribute_id', 'attributes.name', 'attribute_meta.id As attribute_value_id', 'attribute_meta.value')
                ->where('attribute_link.product_id', '=', $product->id)
                ->orderBy('attribute_meta.id', 'asc')
                ->get();
            $image = Product_image::where('product_id', '=',$product->id)->select('image')->get();
        }
        if($request->isMethod('POST')){
            $data = $request->all();
            $validator = Validator::make($data, [
                'name' => 'required',
                'description' => 'required',
                'quantity' => 'required',
                'regular_price' => 'required',
//                'selling_price' => 'required',
                'sub_category_id' => 'required',
//                'attribute_value' => 'required'
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            $category = PublicFunction::get_category_to_subcategory($data['sub_category_id']);

            $images=array();

            if ($request->hasFile('image')) {
                if ($files = $request->file('image')) {
//                 multiple image type validation
                  foreach ($files as $file) {
                    $image = ['image' => $file];
                    $validator = Validator::make($image, [
                      'image' => 'mimes:jpeg,bmp,png,jpg,gif'
                    ]);
                    if ($validator->fails()) {
                      return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
                    }
                  }

                    $i = 0;
                    foreach ($files as $file) {
                        $i++;
                        $name = time() .$i. '.' . $file->getClientOriginalExtension();
                        $path = 'product_images/';
                        $destinationPath = public_path($path);
                        $file->move($destinationPath, $name);
                        $images[] = $path.$name;
                    }
                }
            }

            if ($request->hasFile('thumbnail_image')) {
              $validator = Validator::make($request->all(), [
                'thumbnail_image' => 'mimes:jpeg,bmp,png,jpg,gif'
              ]);
              if ($validator->fails()) {
                return redirect()->back()
                  ->withErrors($validator)
                  ->withInput();
              }

                $image2 = $request->file('thumbnail_image');
                $name2 = time().'.'.$image2->getClientOriginalExtension();

                // Resize the image for thumbnail
                $image_resize = Image::make($image2);
                $image_resize->resize(375, 250);

                // Upload original image
                $original_path = 'product_images/original/';
                $original_destinationPath = public_path($original_path);
                $image2->move($original_destinationPath, $name2);

                // Upload thumbnail
                $path2 = 'product_images/thumbnail/';
                $destinationPath2 = public_path($path2);
                $image_resize->save($destinationPath2 .$name2);

//                $path2 = 'product_images/';
//                $destinationPath2 = public_path($path2);
//                $image2->move($destinationPath2, $name2);

//                resize image
//                $image_resize = Image::make($image2->getRealPath());
//                $image_resize->resize(400, 400);
//                $image_resize->save($destinationPath2. $name2);
            }
            $thumbnail_image = '';
            $original_image = '';
            if(isset($name2)){
                $thumbnail_image  = $path2.$name2;
                $original_image = $original_path . $name2;
                $product_update = [
                    'category_id' => $category->id,
                    'sub_category_id' => $data['sub_category_id'],
                    'name' => $data['name'],
                    'discount' => $data['discount'],
                    'price' => $data['regular_price'],
                    'selling_price' => (!($data['discount'] == null || $data['discount'] == "")) ? intval($data['regular_price'] - (($data['regular_price'] * $data['discount'])/100)) : null,
                    'quantity' => $data['quantity'],
                    'sku' => $data['sku'],
                    'description' => $data['description'],
                    'thumbnail_image' => $thumbnail_image,
                    'original_image' => $original_image,
                ];
            }else{
                $product_update = [
                    'category_id' => $category->id,
                    'sub_category_id' => $data['sub_category_id'],
                    'name' => $data['name'],
                    'discount' => $data['discount'],
                    'price' => $data['regular_price'],
                    'selling_price' => (!($data['discount'] == null || $data['discount'] == "")) ? intval($data['regular_price'] - (($data['regular_price'] * $data['discount'])/100)) : null,
                    'quantity' => $data['quantity'],
                    'sku' => $data['sku'],
                    'description' => $data['description'],
                ];
            }
//            $product_update = array_filter($product_update);
//            return $product_update;
//            return $request;
            if(Product::where('id', '=', $product_id)->update($product_update)){
//              deleting old image
              $old_image_path = public_path($product->thumbnail_image);
              if (file_exists($old_image_path) && $thumbnail_image!= '') {
                @unlink($old_image_path);
              }


                if(isset($data['attribute_value'])) {
                    DB::table('attribute_link')->where('product_id', '=', $product->id)->delete();
                    foreach ($data['attribute_value'] As $key => $value) {
                        DB::table('attribute_link')->insert(['attribute_meta_id' => $value, 'product_id' => $product->id]);
                    }
                }
                foreach ($images As $image){
                    $product_image = new Product_image();
                    $product_image->image = $image;
                    $product_image->product_id = $product->id;
                    $product_image->save();
                }
                $status = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                          Product successfully Updated. 
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                        </div>';
                return redirect()->route('admin.view-product')->with('status', $status);
            }else{
                $status = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                          Something went to wrong. 
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                        </div>';
                return redirect()->back()->with('status', $status);
            }
        }
        return view('admin.product.edit_product', compact('product', 'cat_subCat', 'product_has_attribute', 'attributes', 'attribute_value', 'image'));
    }
    /*
     * admin will delete products
     * */
    public function delete_product_by_admin(Request $request){
        if($request->isMethod("POST")) {
            $id = $request->post('id');
            if(Product::where('id', '=', $id)->where('deleted_at', '=', null)->delete()){
                return "success";
            }
        }
    }
    /*
     * admin will delete products image
     * */
    public function delete_product_image_by_admin(Request $request){
        if($request->isMethod("POST")) {
            $image = $request->post('image');
            $product_id = $request->post('product_id');
            if(Product_image::where('product_id', '=', $product_id)->where('image', '=', $image)->delete()){
  //              deleting image
              $old_image_path = public_path($image);
              if (file_exists($old_image_path)) {
                @unlink($old_image_path);
              }
              return "success";
            }
        }
    }
}
