<?php

namespace App\Http\Controllers;

use App\Coupon;
use App\PurchaseDiscount;
use Validator;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function view_coupon(){
        $coupon = Coupon::whereNull('deleted_at')->get();
        return view('admin.coupon.view_coupon')->with('coupon',$coupon);
    }

    public function add_coupon(Request $request){
        if($request->isMethod('POST')) {
            $data = $request->all();
//            return $data;
            $validator = Validator::make($data, [
                'code' => 'required',
//                'discount_type' => 'required',
                'discount' => 'required',
                'expire_date' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $coupon = new Coupon();
            $coupon->code = $data['code'];
            $coupon->discount_type = 'Percentage';
            $coupon->discount = (double) $data['discount'];
            $coupon->expire_date = date('Y-m-d H:i:s', strtotime($data['expire_date']));
            $coupon->status = 'Active';
            if ($request->post('is_public') === '0' ){
                $coupon->is_public = $data['is_public'];
            }else{
                $coupon->is_public = '1';
            }
            if ($coupon->save()) {
                $status = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                              Coupon successfully Added.
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
        }
        return view('admin.coupon.add_coupon');
    }

    public function edit_coupon(Request $request, $coupon_id){
        $coupon = Coupon::where('id', '=', $coupon_id)->first();
        if(isset($coupon)) {
            if ($request->isMethod('POST')) {
                $data = $request->all();
//                return $data;
                $validator = Validator::make($data, [
                    'expire_date' => 'required',
                ]);
                if ($validator->fails()) {
                    return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
                }
                $expire_date = date('Y-m-d H:i:s', strtotime($data['expire_date']));
                if ($request->post('is_public')=== '0'){
//                    dd( $request->post('is_public'));

                    if (Coupon::where('id', '=', $coupon->id)->whereNull('deleted_at')->update(['expire_date'=> $expire_date, 'is_public'=>'0'])) {
                        $status = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                  Coupon successfully Updated.
                                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                            </div>';
                        return redirect()->route('admin.view-coupon')->with('status', $status);
                    }
                }else{
                    if (Coupon::where('id', '=', $coupon->id)->whereNull('deleted_at')->update(['expire_date'=> $expire_date,'is_public'=>'1'])) {
                        $status = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                  Coupon successfully Updated.
                                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                            </div>';
                        return redirect()->route('admin.view-coupon')->with('status', $status);
                    }
                }
                $status = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                              Something went to wrong.
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                        </div>';
                return redirect()->back()->with('status', $status)->withInput();
            }
            return view('admin.coupon.edit_coupon',compact('coupon'));
        }
        $status = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                              Something went to wrong.
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                        </div>';
        return redirect()->back()->with('status', $status);
    }
    /*
    *
    * admin will delete product category
    * */
    public function delete_coupon_by_admin(Request $request){
        if($request->isMethod("POST")) {
            if(Coupon::where('id', '=', $request->post('id'))->where('deleted_at', '=', null)->delete()){
                return "success";
            }
        }
    }

    public function view_purchase_discount(){
        $coupon = PurchaseDiscount::whereNull('deleted_at')->get();
        return view('admin.purchase_discount.view_purchase_discount')->with('purchaseDiscounts',$coupon);
    }

    public function add_purchase_discount(Request $request){
        if($request->isMethod('POST')) {
            $data = $request->all();
            $validator = Validator::make($data, [
                'offer_type' => 'required',
                'number_of_purchase' => 'required',
                'discount' => 'required',
                'expire_date' => 'required',
            ]);
            $validator->sometimes('purchase_start_date', 'required', function ($input) {
                if ($input->offer_type == "specific_time_period"){
                    return $input->purchase_start_date == null;
                }
                return false;
            });
            $validator->sometimes('purchase_end_date', 'required', function ($input){
                if ($input->offer_type == "specific_time_period"){
                    return $input->purchase_end_date == null;
                }
                return false;
            });
            if ($validator->fails()) {
//                return $validator->messages();
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $coupon = new PurchaseDiscount();
            $coupon->offer_type = $data['offer_type'];
            $coupon->number_of_purchase = $data['number_of_purchase'];
            $coupon->discount = (double) $data['discount'];
            $coupon->expire_date = date('Y-m-d H:i:s', strtotime($data['expire_date']));
            $coupon->purchase_start_date = (isset($data['purchase_start_date']))? date('Y-m-d H:i:s', strtotime($data['purchase_start_date'])) : null ;
            $coupon->purchase_end_date = (isset($data['purchase_end_date']))? date('Y-m-d H:i:s', strtotime($data['purchase_end_date'])) : null;
            $coupon->discount_amount_type = 'percentage';
            if ($coupon->save()) {
                $status = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                              Offer successfully Added.
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
        }
        return view('admin.purchase_discount.add_purchase_discount');
    }

    public function edit_purchase_discount(Request $request, $discount_id){
        $purchaseDiscount = PurchaseDiscount::where('id', '=', $discount_id)->first();
        if(isset($purchaseDiscount)) {
            if ($request->isMethod('POST')) {
                $data = $request->all();
//                return $data;
                if($purchaseDiscount->offer_type == "specific_time_period") {
                    $validator = Validator::make($data, [
                        'purchase_start_date' => 'required',
                        'purchase_end_date' => 'required',
                        'expire_date' => 'required',
                    ]);
                }else{
                    $validator = Validator::make($data, [
                        'expire_date' => 'required',
                    ]);
                }
                if ($validator->fails()) {
                    return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
                }

                if($purchaseDiscount->offer_type == "specific_time_period") {
                    $update_date = [
                        'purchase_start_date'=>date('Y-m-d H:i:s', strtotime($data['purchase_start_date'])),
                        'purchase_end_date'=>date('Y-m-d H:i:s', strtotime($data['purchase_end_date'])),
                        'expire_date'=>date('Y-m-d H:i:s', strtotime($data['expire_date'])),
                    ];
                }else{
                    $update_date = [
                        'expire_date'=>date('Y-m-d H:i:s', strtotime($data['expire_date'])),
                    ];
                }


                if (PurchaseDiscount::where('id', '=', $purchaseDiscount->id)->whereNull('deleted_at')->update($update_date)) {
                    $status = '<div class="alert alert-success alert-dismissible fade show text-left" role="alert">
                              Offer successfully Updated.
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                        </div>';
                    return redirect()->route('admin.view-purchase-discount')->with('status', $status);
                }
                $status = '<div class="alert alert-warning alert-dismissible fade show text-left" role="alert">
                              Something went to wrong.
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                        </div>';
                return redirect()->back()->with('status', $status)->withInput();
            }
            return view('admin.purchase_discount.edit_purchase_discount', compact('purchaseDiscount'));
        }
        $status = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                              Something went to wrong.
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                        </div>';
        return redirect()->back()->with('status', $status);
    }
    /*
    *
    * admin will delete product category
    * */
    public function delete_purchase_discount(Request $request){
        if($request->isMethod("POST")) {
            if(PurchaseDiscount::where('id', '=', $request->post('id'))->where('deleted_at', '=', null)->delete()){
                return "success";
            }
        }
    }
}
