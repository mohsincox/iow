<?php

namespace App\Http\Controllers;

use App\BestSelling;
use App\Category;
use App\Mail\ForgotPassword;
use App\Product;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Str;
class PublicFunction {

  #find array keys
  public static function findKey($array, $keySearch) {
    foreach ($array as $key => $item) {
      if ($key == $keySearch) {
        return true;
      } elseif (is_array($item) && self::findKey($item, $keySearch)) {
        return true;
      }
    }
    return false;
  }

  /*
   * get all role
   * */
  public static function get_all_role(){
    $role = Role::all();
    return $role;
  }

  /*
   * get all permission of each user
   * */
  public static function get_all_permission(){
    $permission = Permission::select('id', 'name')->get();
    return $permission;
  }

  /*
   * get all permission of each user
   * */
  public static function get_role_to_permission($role_id){
    $permission = DB::table('role_has_permissions')
      ->join('permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
      ->where('role_has_permissions.role_id', '=', $role_id)
      ->select('role_has_permissions.permission_id', 'permissions.name')
      ->get();
    return $permission;
  }

  /*
   * get all permission of each user
   * */
  public static function get_users_to_permission_name($user_id){
    $permission = DB::table('role_has_permissions')
      ->join('permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
      ->join('model_has_roles', 'model_has_roles.role_id', '=', 'role_has_permissions.role_id')
      ->where('model_has_roles.model_id', '=', $user_id)
      ->select('permissions.name')
      ->pluck('permissions.name');
    return $permission;
  }

  /*
   * check user has permission or not
   * */
  public static function checkPermission($userPermissions, $permission_name){

    $permissions = json_decode(json_encode($userPermissions), true);
    foreach ($permission_name As $key => $value){
      $val = array_search($value, $permissions);
      if($val > -1 ){
        return true;
      }
    }
    return false;
  }

  /*
   * get details of each user
   * */
  public static function get_user_details($id){
    $role = DB::table('roles')
      ->join('model_has_roles', 'model_has_roles.role_id', '=', 'roles.id')
      ->join('users', 'users.id', '=', 'model_has_roles.model_id')
      ->where('users.id', '=', $id)
      ->where('users.deleted_at', '=', null)
      ->select('users.id','users.name','users.email','users.phone','users.status', 'roles.id As role_id', 'roles.name As role_name')
      ->get()->toArray();
    $count = 0;
    foreach ($role As $key){
      ++$count;
    }
    if($count > 0){
      $role = $role[0];
    }
    return $role;
  }

  /*
   * get all attributes
   * */
  public static function get_attributes(){
    $attributes = DB::table('attributes')
      ->select('id', 'name')
      ->get();
    return $attributes;
  }

  /*
   * get all attributes with value
   * */
  public static function get_all_attribute_value(){
    $attributes = DB::table('attribute_meta')
      ->select('id', 'value', 'attribute_id')
      ->get();
    return $attributes;
  }

  /*
   * get all value of each attributes
   * */
  public static function get_attributes_value($id){
    $attributes_value = DB::table('attribute_meta')
      ->where('attribute_id', '=', $id)
      ->select('id', 'value')
      ->get();
    return $attributes_value;
  }

  /*
   * get category details of each subCategory
   * */
  public static function get_category_to_subcategory($id){
    $category = DB::table('categories')
      ->join('sub_categories', 'sub_categories.category_id', '=', 'categories.id')
      ->where('sub_categories.id', '=', $id)
      ->where('sub_categories.deleted_at', '=', null)
      ->where('categories.deleted_at', '=', null)
      ->select('categories.id', 'categories.name')
      ->get();
    if(count($category) > 0){
      $category = $category[0];
    }
    return $category;
  }

  /*
   * get flavour details of each subCategory
   * */
  public static function get_all_flavour(){
    $category = DB::table('attribute_meta')
      ->join('attributes', 'attributes.id', '=', 'attribute_meta.attribute_id')
      ->whereNull('attributes.deleted_at')
      ->whereNull('attribute_meta.deleted_at')
      ->where('attributes.name', '=', "Flavor")
      ->select('attribute_meta.value As name', 'attribute_meta.id As id', 'attribute_meta.slug')
      ->get();
    $duel = DB::table('attribute_meta')
      ->join('attributes', 'attributes.id', '=', 'attribute_meta.attribute_id')
      ->whereNull('attributes.deleted_at')
      ->whereNull('attribute_meta.deleted_at')
      ->where('attributes.name', '=', "Duel Flavor")
      ->select('attribute_meta.value As name', 'attribute_meta.id As id', 'attribute_meta.slug As slug')
      ->get();
    $category['Dual Flavor']=$duel->toArray();
    return $category;
  }

  /*
   * update quantity of each
   * */
  public static function product_quantity_reduce($id, $quantity){
    $product = Product::where('id', '=', $id)->whereNull('deleted_at')->pluck('quantity');
    if(count($product) > 0){
      $product = $product[0];
    }
    $new_product_quantity = $product - $quantity;
    Product::where('id', '=', $id)->update(['quantity' => $new_product_quantity]);
    return "success";
  }

  /*
   * add best selling
   * */
  public static function best_selling_product($user_id, $order_id, $id, $quantity){
    $best = new BestSelling();
    $best->customer_id = $user_id;
    $best->order_id = $order_id;
    $best->product_id = $id;
    $best->number_of_product_sale = $quantity;
    if($best->save()){
      return "success";
    }
  }


  /*
   * category with subcategory
   * */
  public static function category_with_subcategory(){
    $categorySubCategory = DB::table('categories')
      ->join('sub_categories', 'sub_categories.category_id', '=', 'categories.id')
      ->select('categories.id As category_id', 'categories.name As category_name', 'categories.slug',
        'sub_categories.id As sub_category_id', 'sub_categories.name As sub_category_name', 'sub_categories.slug As sub_category_slug')
      ->whereNull('categories.deleted_at')
      ->whereNull('sub_categories.deleted_at')
      ->get();
    $cat_subCat = [];
    foreach ($categorySubCategory As $key => $value){
      if(!self::findKey($cat_subCat, $value->category_name)){
        $cat_subCat[$value->category_name][]= [
          'id' => $value->sub_category_id,
          'name' => $value->sub_category_name,
          'slug' => $value->sub_category_slug
        ];
      }else{
        $cat_subCat[$value->category_name][]= [
          'id' => $value->sub_category_id,
          'name' => $value->sub_category_name,
          'slug' => $value->sub_category_slug
        ];
      }
    }
//            Log::alert($cat_subCat);
    return $cat_subCat;
  }
}

