<?php

namespace App\Http\Controllers;

use App\Coupon;
use App\Product;
use App\Setting;
use Cart;
use DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function add_to_cart(Request $request, $product_id){
        $carbonDate = new Carbon(Carbon::now());

            // Get item details from db
            Cart::setGlobalTax(0);
            $product = Product::where('id', '=', $product_id)
                ->whereNull('deleted_at')
                ->get();
//        return $product[0];


            if ($product->isNotEmpty()) {
                // get product attributes
                $product_attributes = DB::table('attribute_link')
                    ->join('attribute_meta', 'attribute_meta.id', '=', 'attribute_link.attribute_meta_id')
                    ->join('attributes', 'attributes.id', '=', 'attribute_meta.attribute_id')
                    ->select('attributes.id As attribute_id', 'attributes.name', 'attribute_meta.id As attribute_value_id', 'attribute_meta.value')
                    ->where('attribute_link.product_id', '=', $product[0]->id)
                    ->orderBy('attribute_meta.id', 'asc')
                    ->get();
                $options = array(
                    'image' => $product[0]->thumbnail_image,
                    'regularPrice' => $product[0]->price,
                    'pDiscount' => $product[0]->discount,
                    );
                if ($product_attributes->isNotEmpty()) {
                    foreach ($product_attributes as $value) {
                        $options[$value->name] = $value->value;
                    }
                }

                $product_to_add = array(
                    'id' => $product[0]->id,
                    'name' => $product[0]->name,
                    'qty' => (isset($request->quantity)) ? $request->quantity : 1,
                    'price' => ($product[0]->selling_price > 0) ? $product[0]->selling_price : $product[0]->price,
                    'weight' => 0,
                    'options' => $options
                );
                if ( $request->quantity >= 1){
                    Cart::add($product_to_add);
                }else{
                    return redirect()->back();
                }
                return response()->json(['totalItem' => Cart::count(), 'content' => Cart::content(), 'total' => Cart::total()]);
            }

            return response()->json(['error' => "Failed"]);
    }

    public function remove_cart_item($rowId){
        if (!empty($rowId)){
            Cart::remove($rowId);
        }
        return redirect()->back();
    }

    public function update_cart(Request $request){
        if ($request->isMethod('post')){
            $qty = intval($request->post('qty'));
            $rowId = $request->post('rowId');
            if ($qty > 0){
                Cart::update($rowId, $qty);
            }
        }
        return redirect()->back();
    }

    public function apply_discount(Request $request){
//        return Cart::content();
        if ($request->isMethod('post')){
            $coupon_code = $request->post('coupon-code');
            // get coupon details
            $coupon_details = Coupon::where('code', '=', $coupon_code)
                ->where('expire_date', '>', Carbon::now())
                ->whereNull('deleted_at')->get();
//            return $coupon_details;

            if ($coupon_details->isNotEmpty()){
                // storing coupon details in session
                Session::put('coupon_code', $coupon_details[0]->code);
                Session::put('discount', $coupon_details[0]->discount);
                Session::put('discount_type', 'Coupon Discount');
                // set discount to cart total
//                Cart::setGlobalDiscount($coupon_details[0]->discount);
                $msg = '<div class="alert alert-success mt-2">
                                            <div>Congratulations! You got '.$coupon_details[0]->discount.'% discount applied.</div>
                                        </div>';
            }else{
//                Session::flash('coupon_status', "You have entered an invalid coupon code.");
                $msg = '<div class="alert alert-danger mt-2">
                        <div>You have entered an invalid coupon code.</div>
                    </div>';
            }
            return redirect()->route('cart')->with(['coupon_status'=> $msg]);

        }
    }
}
