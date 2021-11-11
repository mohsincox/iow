<?php

namespace App\Http\Controllers;
use App\AddressBook;
use App\Mail\OrderNotification;
use App\Order;
use App\Payment;
use Cart;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Validator;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;


class OrderController extends Controller
{
  public function place_order(Request $request) {
    if ($request->isMethod("POST")){
      if(Cart::count() < 1){
        return redirect()->route('cart');
      }
      $data = $request->all();
//            return $request;
      $validator = Validator::make($data, [
        'billing_name' => 'required',
        'billing_country' => 'required',
        'billing_address' => 'required',
        'billing_city' => 'required',
      ]);
//            $validator->sometimes('billing_phone', 'required|min:11|unique:users', function ($input){
//                if (isset($input->billing_isPassword)){
//                    return $input->billing_phone == null;
//                }
//                return false;
//            });
//            $validator->sometimes('billing_email', 'required|email|unique:users', function ($input){
//                if (isset($input->billing_isPassword)){
//                    return $input->billing_email == null;
//                }
//                return false;
//            });

      if (!auth()->user()){
        $validator = Validator::make($data, [
          'billing_phone' => 'required|min:11,',
//                    'billing_phone' => 'required|min:11|unique:users,phone,',
//                    'billing_email' => 'required|email|unique:users,email,',
        ]);
      }
//            $validator->sometimes('billing_password', 'required', function ($input){
//                if (isset($input->billing_isPassword)){
//                    return $input->billing_password == null;
//                }
//                return false;
//            });
      $validator->sometimes('shipping_name', 'required', function ($input){
        if (isset($input->s_isShow)){
          return $input->s_name == null;
        }
        return false;
      });
      $validator->sometimes('shipping_phone', 'required', function ($input){
        if (isset($input->s_isShow)){
          return $input->s_phone == null;
        }
        return false;
      });
//            $validator->sometimes('shipping_email', 'required', function ($input){
//                if (isset($input->s_isShow)){
//                    return $input->s_email == null;
//                }
//                return false;
//            });
      $validator->sometimes('shipping_country', 'required', function ($input){
        if (isset($input->s_isShow)){
          return $input->s_country == null;
        }
        return false;
      });
      $validator->sometimes('shipping_address', 'required', function ($input){
        if (isset($input->s_isShow)){
          return $input->s_address == null;
        }
        return false;
      });
      $validator->sometimes('shipping_city', 'required', function ($input){
        if (isset($input->s_isShow)){
          return $input->s_city == null;
        }
        return false;
      });

      if ($validator->fails()) {
//                return $validator->messages();
        return redirect()->back()
          ->withErrors($validator)
          ->withInput();
      }
//            $user = Auth::user();
//            if(isset($data['billing_isPassword'])){
//                // create new user
//                $user = User::create([
//                    'name' => $data['billing_name'],
//                    'phone' => $data['billing_phone'],
//                    'email' => $data['billing_email'],
//                    'password' => Hash::make($data['billing_password'])
//                ]);
//                $role = Role::find(3);
//                $user->assignRole($role);
//                Auth::login($user);
//            }else{
//                if(Auth::user()) {
//                    // getting existing user
//                    $user = Auth::user();
//                }
//            }

//            if($user == null){
//                return redirect()->route('signin')->with('status1', "You have to login first.");
//            }

      //  deleting previous billing address
      if(Auth::user()) {
        AddressBook::where('customer_id', '=', Auth::user()->id)->where('address_name', '=', 'Billing address')->whereNull('deleted_at')->delete();
      }

      //  insertting new billing address
      $billing_address = new AddressBook();
      $billing_address->customer_id = (Auth::user()) ? Auth::user()->id : null;
      $billing_address->name = $data['billing_name'];
      $billing_address->phone = $data['billing_phone'];
//            $billing_address->email = $data['billing_email'];
      // $billing_address->company_name = $data['billing_company_name'];
      $billing_address->country = $data['billing_country'];
      $billing_address->address_name = 'Billing address';
      $billing_address->address = $data['billing_address'];
      $billing_address->appartment = $data['billing_appartment'];
      $billing_address->city = $data['billing_city'];
//            $billing_address->postal_code = $data['billing_postal_code'];

      $billing_address->save();

      $s_address = null;
      // new shipping address
      if($request->post('shipping_isShow')) {
        //  deleting previous shipping address
        if(Auth::user()) {
          AddressBook::where('customer_id', '=', Auth::user()->id)->where('address_name', '=', 'Shipping address')->whereNull('deleted_at')->delete();
        }
        $sh_address = new AddressBook();
        $sh_address->customer_id = (Auth::user()) ? Auth::user()->id : null;
        $sh_address->name = $data['shipping_name'];
        $sh_address->phone = $data['shipping_phone'];
//                $sh_address->email = $data['shipping_email'];
        // $sh_address->company_name = $data['shipping_company_name'];
        $sh_address->country = $data['shipping_country'];
        $sh_address->address_name = 'Shipping address';
        $sh_address->address = $data['shipping_address'];
        $sh_address->appartment = $data['shipping_appartment'];
        $sh_address->city = $data['shipping_city'];
//                $sh_address->postal_code = $data['shipping_postal_code'];
        $sh_address->save();

        $s_address = $sh_address;
      }else{
        // if no shipping address exist then insert billing address as shipping address
        $sh_address = new AddressBook();
        $sh_address->customer_id = (Auth::user()) ? Auth::user()->id : null;
        $sh_address->name = $data['billing_name'];
        $sh_address->phone = $data['billing_phone'];
//                $sh_address->email = $data['billing_email'];
        // $sh_address->company_name = $data['billing_company_name'];
        $sh_address->country = $data['billing_country'];
        $sh_address->address_name = 'Shipping address';
        $sh_address->address = $data['billing_address'];
        $sh_address->appartment = $data['billing_appartment'];
        $sh_address->city = $data['billing_city'];
//                $sh_address->postal_code = $data['billing_postal_code'];
        $sh_address->save();

        $s_address = $sh_address;
      }

      //  getting new shipping address fron db
//            $s_address = AddressBook::where('customer_id', '=', $user->id)->where('address_name', '=', 'Shipping address')->whereNull('deleted_at')->first();
//            return $s_address;
//            return Cart::content();

      //  insertting order
      $order = new Order();
      $order->customer_id = (Auth::user()) ? Auth::user()->id : null;
      $order->product_details = serialize(Cart::content());
//            $order->amount = filter_var(Cart::total(), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
      $order->amount = Session::get('total_price');
      $order->coupon_code = (Session::get('coupon_code')) ? Session::get('coupon_code') : null ;
      $order->discount = (Session::get('discount')) ? Session::get('discount') : null;
      $order->discount_type = (Session::get('discount_type')) ? Session::get('discount_type') : null ;
      $order->billing_address = $billing_address->id;
      $order->shipping_address = $s_address->id;
      $order->payment_type = $request->check_method;
      $order->order_note = $data['order_note'];
//            return $order;
      if($order->save()) {
        // managing inventory
        foreach (Cart::content() as $row) {
          PublicFunction::product_quantity_reduce($row->id, $row->qty);
          PublicFunction::best_selling_product((Auth::user()) ? Auth::user()->id : null, $order->id, $row->id, $row->qty);
        }

        $phoneNo = $billing_address->phone;
//                if (Auth::user()->phone != null){
//                    $phoneNo = Auth::user()->phone;
//                }else{
//                    $phoneNo = $billing_address->phone;
//                }
        /**
         * sending message
         */
        // if($phoneNo != null) {
        // $this->__send_sms($phoneNo, "Your order has been placed. Our CRM will call you to confirm the order. Thank you!");
        // }
        // Mail::to('raihan@sarosit.com')->send(new OrderNotification($order->id));

        try {
          if ($phoneNo != null) {
            $this->__send_sms($phoneNo, "Your order has been placed. Our CRM will call you to confirm the order. Thank you!");
          }

          Mail::to('igloo.pink.bd@gmail.com')->send(new OrderNotification($order->id));
        } catch (Exception $ex) {

        }
        // Destroying cart data
        Session::forget('coupon_code');
        Session::forget('total_amount');
        Session::forget('discount');
        Session::forget('discount_type');
        Session::forget('coupon_status');
        Cart::destroy();
        $payment = Payment::create([
          'order_id' => $order->id,
          'customer_id' => (Auth::user()) ? Auth::user()->id : null,
          'type' => $request->check_method,
          'amount' => $order->amount,
          'status' => 'Pending'
        ]);
        if($payment){
          Session::flash('message', $order->id);
          Session::put('payment_id', $payment->id);
          if($request->check_method == "COD"){
            $data = [
              'order_id' => $order->id,
              'payment_id' => $payment->id,
              'amount'=> null,
              'tran_id'=> null,
              'card_type'=> null,
            ];
            Session::forget('payment_id');
            return view('site.thank_you')->with('data', $data);
          }

          //SSLCOMMERZ api integration start
          $post_data = array();
          // $post_data['store_id'] = "saros5e086e68b8adf";
          // $post_data['store_passwd'] = "saros5e086e68b8adf@ssl";
          $post_data['store_id'] = "igloobdlive";
          $post_data['store_passwd'] = "5D7E2509EA6A660234";
          $post_data['total_amount'] = $order->amount;
          $post_data['currency'] = "BDT";
          $post_data['tran_id'] = "SSLCZ_TEST_".uniqid();
          $post_data['success_url'] = url('/thankyou');
          $post_data['fail_url'] = url('/cancel-payment');
          $post_data['cancel_url'] = url('/cancel-payment');
          # $post_data['multi_card_name'] = "mastercard,visacard,amexcard";   # DISABLE TO DISPLAY ALL AVAILABLE7

          # CUSTOMER INFORMATION7
          $post_data['cus_name'] = $billing_address->name;
//                    $post_data['cus_email'] =
          $post_data['cus_add1'] =  $billing_address->address;
          $post_data['cus_add2'] = "Dhaka";
          $post_data['cus_city'] = $billing_address->city;
          $post_data['cus_state'] =  $billing_address->city;
//                    $post_data['cus_postcode'] = $billing_address->postal_code ;
          $post_data['cus_country'] = $billing_address->country ;
          $post_data['cus_phone'] =  (Auth::user()) ? Auth::user()->phone : $billing_address->phone ;
          $post_data['cus_fax'] = "00000000000";


          # SHIPMENT INFORMATION7
          $post_data['ship_name'] = $s_address->name;
          $post_data['ship_add1 '] = $s_address->address;
          $post_data['ship_add2'] = "Dhaka";
          $post_data['ship_city'] = $s_address->city;
          $post_data['ship_state'] = "";
//                    $post_data['ship_postcode'] = $s_address->postal_code;
          $post_data['ship_country'] = $s_address->country;
          $post_data['shipping_method'] = "home";




          // calling ssl api

          // $direct_api_url = "https://sandbox.sslcommerz.com/gwprocess/v3/api.php";
          $direct_api_url = "https://securepay.sslcommerz.com/gwprocess/v4/api.php";

          $handle = curl_init();
          curl_setopt($handle, CURLOPT_URL, $direct_api_url );
          curl_setopt($handle, CURLOPT_TIMEOUT, 30);
          curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 30);
          curl_setopt($handle, CURLOPT_POST, 1 );
          curl_setopt($handle, CURLOPT_POSTFIELDS, $post_data);
          curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, FALSE); # KEEP IT FALSE IF YOU RUN FROM LOCAL PC


          $content = curl_exec($handle );

          $code = curl_getinfo($handle, CURLINFO_HTTP_CODE);

          if($code == 200 && !( curl_errno($handle))) {
            curl_close( $handle);
//                        return var_dump($content);
            $sslcommerzResponse = $content;
          } else {
            curl_close( $handle);

            $status = '<div class="alert alert-danger alert-dismissible " role="alert">
                                <strong>FAILED TO CONNECT WITH SSLCOMMERZ API</strong>.
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                        </div>';
            return redirect()->back()->with('status', $status);
          }

# PARSE THE JSON RESPONSE
          $sslcz = json_decode($sslcommerzResponse, true );

          if(isset($sslcz['GatewayPageURL']) && $sslcz['GatewayPageURL']!="" ) {
            # THERE ARE MANY WAYS TO REDIRECT - Javascript, Meta Tag or Php Header Redirect or Other
            # echo "<script>window.location.href = '". $sslcz['GatewayPageURL'] ."';</script>";
//                        echo "<meta http-equiv='refresh' content='0;url=".$sslcz['GatewayPageURL']."'>";
            # header("Location: ". $sslcz['GatewayPageURL']);
//                        exit;
            return redirect($sslcz['GatewayPageURL']);
          }

          $status = '<div class="alert alert-danger alert-dismissible " role="alert">
                            <strong>Something went wrong.</strong>.
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                    </div>';
          return redirect()->back()->with('status', $status);
        }

      }
      $status = '<div class="alert alert-danger alert-dismissible " role="alert">
                                <strong>Something went wrong</strong>.
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                        </div>';
      return redirect()->back()->with('status', $status);
    }
    return redirect()->route('index');
  }
  /** get order */
  public function get_order(Request $request){
//        if($request->isMethod('POST')){
//            $dateRange = $request->post("daterange");
//            $startDate = explode('-', $dateRange)[0];
//            $endDate = explode('-', $dateRange)[1];
//            $startDate = date('Y-m-d 00:00:01', strtotime($startDate));
//            $endDate = date('Y-m-d 23:59:59', strtotime($endDate));
////            $order = DB::table('orders')
////                ->join('address_books', 'address_books.id', '=', 'orders.billing_address')
////                ->join('users', 'users.id', '=', 'orders.customer_id')
////                ->select('orders.*', 'address_books.name', 'address_books.phone')
////                ->where('orders.created_at', '>', $startDate)
////                ->where('orders.created_at', '<', $endDate)
////                ->whereNull('users.deleted_at')
////                ->orderBy('orders.id', 'DESC')
////                ->get();
////            return $order;
//            $order = DB::table('orders')
//                ->join('address_books', 'address_books.id', '=', 'orders.billing_address')
//                ->join('users', 'users.id', '=', 'orders.customer_id')
//                ->select('orders.*', 'address_books.name', 'address_books.phone')
//                ->orderBy('orders.id', 'DESC')->get();
//            return response(['data'=> $order]);
////            return view('admin.order.view_order')->with('orders', $order);
//        }
//        $order = DB::table('orders')
//            ->join('address_books', 'address_books.id', '=', 'orders.billing_address')
//            ->join('users', 'users.id', '=', 'orders.customer_id')
//            ->select('orders.*', 'address_books.name', 'address_books.phone')
//            ->orderBy('orders.id', 'DESC')->get()->take(50);
////        return $order;
    return view('admin.order.view_order');
  }


  /** get order */
  public function get_order_history(Request $request){
//    $order = null;
//    if($request->isMethod('POST')){
//      $dateRange = $request->post("daterange");
//      $startDate = explode('-', $dateRange)[0];
//      $endDate = explode('-', $dateRange)[1];
//      $startDate = date('Y-m-d 00:00:01', strtotime($startDate));
//      $endDate = date('Y-m-d 23:59:59', strtotime($endDate));
//      $order = DB::table('orders')
//        ->join('address_books', 'address_books.id', '=', 'orders.billing_address')
//        ->leftJoin('users', 'users.id', '=', 'orders.customer_id')
////                ->select('orders.*', 'address_books.name', 'address_books.phone')
//        ->select('orders.*', 'address_books.name', 'address_books.phone', DB::raw("(SELECT address FROM `address_books` WHERE address_books.address_name = 'Shipping address' AND address_books.id = orders.shipping_address) as shipping_address"))
//        ->where('orders.created_at', '>', $startDate)
//        ->where('orders.created_at', '<', $endDate)
//        ->whereIn('orders.status', ['Cancelled', 'Completed'])
//        ->whereNull('users.deleted_at')
//        ->orderBy('orders.id', 'DESC')
//        ->get();
//      return view('admin.order.orders_history')->with('orders', $order);
//    }
//    $order = DB::table('orders')
//      ->join('address_books', 'address_books.id', '=', 'orders.billing_address')
//      ->leftJoin('users', 'users.id', '=', 'orders.customer_id')
////        ->select('orders.*', 'address_books.name', 'address_books.phone')
//      ->select('orders.*', 'address_books.name', 'address_books.phone', DB::raw("(SELECT address FROM `address_books` WHERE address_books.address_name = 'Shipping address' AND address_books.id = orders.shipping_address) as shipping_address"))
//      ->whereIn('orders.status', ['Cancelled', 'Completed'])
//      ->whereNull('users.deleted_at')
//      ->orderBy('orders.id', 'DESC')
//      ->get();
    return view('admin.order.orders_history')/*->with('orders', $order)*/;
  }
  /**
   * @param $order_id
   * @return $this|void
   */
  public function order_details($order_id){
    $order_details = DB::table('orders')
      ->join('address_books','address_books.id','=','orders.shipping_address')
      ->select('orders.*', 'address_books.address')
      ->where('orders.id', '=', $order_id)->get();
    if ($order_details->isNotEmpty()){
      $customer_details = User::where('id', '=', $order_details[0]->customer_id)->get();
      $payment_details = Payment::where('order_id', '=', $order_details[0]->id)->where('status', '!=', 'Canceled')->get();
      return view('admin.order.order_details')->with([
        'order_details'=> $order_details,
        'customer_details' => $customer_details,
        'payment_details' => $payment_details
      ]);
    }
    return abort(404);
  }
  /*
   * customer order details
   *
   * */
  public function customer_order_details($order_id){
    $order_details = DB::table('orders')
      ->join('address_books','address_books.id','=','orders.shipping_address')
      ->select('orders.*', 'address_books.address')
      ->where('orders.id', '=', $order_id)
      ->where('orders.customer_id', '=', auth()->id())
      ->get();
//        return $order_details;
    if ($order_details->isNotEmpty()){
      $customer_details = User::where('id', '=', $order_details[0]->customer_id)->get();
      $payment_details = Payment::where('order_id', '=', $order_details[0]->id)->where('status', '!=', 'Canceled')->get();
      return view('site.customer.order_details')->with([
        'order_details'=> $order_details,
        'customer_details' => $customer_details,
        'payment_details' => $payment_details
      ]);
    }
    return abort(404);
  }
  /*
   * change order status
   *
   * */
  public function change_order_status(Request $request, $order_id){
//        return $request;
    if($order_id != null || $order_id != "" || isset($request->status) ) {
      $order = Order::where('id', '=', $order_id)->get();
      if (count($order) > 0) {
        $order = $order[0];
        $status = $request->status;
        if(Order::where('id', '=', $order->id)->update(['status'=> $status])){
          $status = '<div class="alert alert-success alert-dismissible " role="alert">
                                <strong>Order status successfully changed.</strong>
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                        </div>';
          return redirect()->back()->with('status', $status);
        }
      }
    }
    $status = '<div class="alert alert-warning alert-dismissible " role="alert">
                    <strong>Something went wrong.</strong>
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                    </div>';
    return redirect()->back()->with('status', $status);
  }
  /**
   * @param Request $request
   * @return $this
   */
  public function change_order_multi_status(Request $request){
    $status = $request->post('multiStatus');
    $ids = $request->post('order_ids');
    if(Order::whereIn('id', explode(',', $ids))->update(['status'=> $status])){
      $status = '<div class="alert alert-success alert-dismissible " role="alert">
                        <strong>Order status successfully changed.</strong>
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                </div>';
      return redirect()->back()->with('status', $status);
    }
    $status = '<div class="alert alert-warning alert-dismissible " role="alert">
                    <strong>Something went wrong.</strong>
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                    </div>';
    return redirect()->back()->with('status', $status);
  }
  /*
   * admin can paid as mark-as-paid
   *
   * */
  public function mark_as_paid(Request $request){
    if($request->isMethod('POST')){
//            return $request;
      $validator = Validator::make($request->all(), [
        'order_id' => 'required',
        'payment_method' => 'required',
        'amount' => 'required',
      ]);
      if ($validator->fails()) {
        return redirect()->back()
          ->withErrors($validator)
          ->withInput();
      }
      $order = Order::where('id', '=', $request->post('order_id'))->get();
      if(count($order) > 0){
        $order = $order[0];
        $payment = Payment::create([
          'order_id' => $order->id,
          'customer_id' => $order->customer_id,
          'type' => $request->post('payment_method'),
          'amount' => $request->post('amount'),
          'status' => 'Paid'
        ]);
        $total_payment = Payment::where('order_id', '=', $order->id)->sum('amount');
        if($order->amount <= $total_payment){
          Order::where('id', '=', $order->id)->update([
            'payment_status' => 'Paid'
          ]);
        }
        $status = '<div class="alert alert-success alert-dismissible " role="alert">
                                <strong>Successfully payment added.</strong>
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                        </div>';
        return redirect()->back()->with('status', $status);
      }
    }
    $status = '<div class="alert alert-warning alert-dismissible " role="alert">
                                <strong>Something went wrong.</strong>
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                        </div>';
    return redirect()->back()->with('status', $status);
  }

  public function get_orders_data(Request $request)
  {
    // return "hello";
    $columns = array(
      0 => 'id',
      1 => 'name',
      2 => 'phone',
      3 => 'address',
      4 => 'amount',
      5 => 'code',
      6 => 'discount',
      7 => 'payment_type',
      8 => 'payment_status',
      9 => 'order_date',
      10 => 'status',
      11 => 'option',
    );


    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');
    $totalData = Order::whereIn('orders.status', array('Cancelled', 'Completed'))->count();
//    $totalFiltered = $totalData;

    $dateRange = $request->post('dateRange');

    if (isset($dateRange)) {
      $startDate = date('Y-m-d 00:00:01', strtotime(explode(" - ", $dateRange)[0]));
      $endDate = date('Y-m-d 23:59:59', strtotime(explode(" - ", $dateRange)[1]));
      if(empty($request->input('search.value'))) {
        $query = DB::table('orders')
          ->join('address_books', 'address_books.id', '=', 'orders.billing_address')
          ->leftJoin('users', 'users.id', '=', 'orders.customer_id')
          ->whereIn('orders.status', array('Pending', 'Delivered', 'Processing'))
          ->where('orders.created_at', '>=', $startDate)
          ->where('orders.created_at', '<=', $endDate)
          ->select('orders.*', 'address_books.name', 'address_books.phone', DB::raw("(SELECT address FROM `address_books` WHERE address_books.address_name = 'Shipping address' AND address_books.id = orders.shipping_address) as shipping_address"))
          ->offset($start)->limit($limit);

        if ($order != 'role'){
          $query->orderBy($order, $dir);
        }

        $order_data = $query->get();

        $totalFiltered = $query = DB::table('orders')
          ->join('address_books', 'address_books.id', '=', 'orders.billing_address')
          ->leftJoin('users', 'users.id', '=', 'orders.customer_id')
          ->whereIn('orders.status', array('Pending', 'Delivered', 'Processing'))
          ->where('orders.created_at', '>=', $startDate)
          ->where('orders.created_at', '<=', $endDate)
          ->select('orders.*', 'address_books.name', 'address_books.phone', DB::raw("(SELECT address FROM `address_books` WHERE address_books.address_name = 'Shipping address' AND address_books.id = orders.shipping_address) as shipping_address"))
          ->count();
      } else {
        $search = $request->input('search.value');

        $query = DB::table('orders')
          ->join('address_books', 'address_books.id', '=', 'orders.billing_address')
          ->leftJoin('users', 'users.id', '=', 'orders.customer_id')
          ->select('orders.*', 'address_books.name', 'address_books.phone', DB::raw("(SELECT address FROM `address_books` WHERE address_books.address_name = 'Shipping address' AND address_books.id = orders.shipping_address) as shipping_address"))
          ->whereIn('orders.status', array('Pending', 'Delivered', 'Processing'))
          ->where('orders.created_at', '>=', $startDate)
          ->where('orders.created_at', '<=', $endDate)
          ->where('orders.id', 'LIKE',"%{$search}%")
          ->orWhere('orders.payment_type', 'LIKE',"%{$search}%")
          ->orWhere('orders.payment_status', 'LIKE',"%{$search}%")
          ->orWhere('orders.status', 'LIKE',"%{$search}%")
          ->orWhere('address_books.phone', 'LIKE',"%{$search}%")
          ->orWhere('address_books.name', 'LIKE',"%{$search}%")
          ->offset($start)->limit($limit);
        if ($order != 'role'){
          $query->orderBy($order, $dir);
        }

        $order_data = $query->get();

        $totalFiltered = $query = DB::table('orders')
          ->join('address_books', 'address_books.id', '=', 'orders.billing_address')
          ->leftJoin('users', 'users.id', '=', 'orders.customer_id')
          ->select('orders.*', 'address_books.name', 'address_books.phone', DB::raw("(SELECT address FROM `address_books` WHERE address_books.address_name = 'Shipping address' AND address_books.id = orders.shipping_address) as shipping_address"))
          ->whereIn('orders.status', array('Pending', 'Delivered', 'Processing'))
          ->where('orders.created_at', '>=', $startDate)
          ->where('orders.created_at', '<=', $endDate)
          ->where('orders.id', 'LIKE',"%{$search}%")
          ->orWhere('orders.payment_type', 'LIKE',"%{$search}%")
          ->orWhere('orders.payment_status', 'LIKE',"%{$search}%")
          ->orWhere('orders.status', 'LIKE',"%{$search}%")
          ->orWhere('address_books.phone', 'LIKE',"%{$search}%")
          ->orWhere('address_books.name', 'LIKE',"%{$search}%")->count();
      }
    }else{
      if (empty($request->input('search.value'))) {
        $query = DB::table('orders')
          ->join('address_books', 'address_books.id', '=', 'orders.billing_address')
          ->leftJoin('users', 'users.id', '=', 'orders.customer_id')
          ->whereIn('orders.status', array('Pending', 'Delivered', 'Processing'))
          ->select('orders.*', 'address_books.name', 'address_books.phone', DB::raw("(SELECT address FROM `address_books` WHERE address_books.address_name = 'Shipping address' AND address_books.id = orders.shipping_address) as shipping_address"))
          ->offset($start)->limit($limit);

        if ($order != 'role'){
          $query->orderBy($order, $dir);
        }

        $order_data = $query->get();

        $totalFiltered = $query = DB::table('orders')
          ->join('address_books', 'address_books.id', '=', 'orders.billing_address')
          ->leftJoin('users', 'users.id', '=', 'orders.customer_id')
          ->whereIn('orders.status', array('Pending', 'Delivered', 'Processing'))
          ->select('orders.*', 'address_books.name', 'address_books.phone', DB::raw("(SELECT address FROM `address_books` WHERE address_books.address_name = 'Shipping address' AND address_books.id = orders.shipping_address) as shipping_address"))
          ->count();

      } else {
        $search = $request->input('search.value');

        $query = DB::table('orders')
          ->join('address_books', 'address_books.id', '=', 'orders.billing_address')
          ->leftJoin('users', 'users.id', '=', 'orders.customer_id')
          ->select('orders.*', 'address_books.name', 'address_books.phone', DB::raw("(SELECT address FROM `address_books` WHERE address_books.address_name = 'Shipping address' AND address_books.id = orders.shipping_address) as shipping_address"))
          ->whereIn('orders.status', array('Pending', 'Delivered', 'Processing'))
          ->where('orders.id', 'LIKE', "%{$search}%")
          ->orWhere('orders.payment_type', 'LIKE', "%{$search}%")
          ->orWhere('orders.payment_status', 'LIKE', "%{$search}%")
          ->orWhere('orders.status', 'LIKE', "%{$search}%")
          ->orWhere('address_books.phone', 'LIKE', "%{$search}%")
          ->orWhere('address_books.name', 'LIKE', "%{$search}%")
          ->offset($start)->limit($limit);
        if ($order != 'role'){
          $query->orderBy($order, $dir);
        }

        $order_data = $query->get();

        $totalFiltered = $query = DB::table('orders')
          ->join('address_books', 'address_books.id', '=', 'orders.billing_address')
          ->leftJoin('users', 'users.id', '=', 'orders.customer_id')
          ->select('orders.*', 'address_books.name', 'address_books.phone', DB::raw("(SELECT address FROM `address_books` WHERE address_books.address_name = 'Shipping address' AND address_books.id = orders.shipping_address) as shipping_address"))
          ->whereIn('orders.status', array('Pending', 'Delivered', 'Processing'))
          ->where('orders.id', 'LIKE', "%{$search}%")
          ->orWhere('orders.payment_type', 'LIKE', "%{$search}%")
          ->orWhere('orders.payment_status', 'LIKE', "%{$search}%")
          ->orWhere('orders.status', 'LIKE', "%{$search}%")
          ->orWhere('address_books.phone', 'LIKE', "%{$search}%")
          ->orWhere('address_books.name', 'LIKE', "%{$search}%")->count();
      }
    }

    $new_order = [];
    foreach ($order_data as $key => $value){
      $new['id'] = $value->id;
      $new['name'] = $value->name;
      $new['phone'] =  $value->phone;
      $new['address'] =  $value->shipping_address;
      $new['amount'] = $value->amount;
      $code = "N\A";
      $discount = "N\A";
      if($value->discount != null){
        if($value->coupon_code != null){
          $code = $value->coupon_code;
        }else{
          $code = $value->discount_type;
        }
        $discount = $value->discount;
      }
      $new['code'] = $code;
      $new['discount'] = $discount;
      $new['payment_type'] = $value->payment_type;
      $new['payment_status'] = $value->payment_status;
      $new['order_date'] = date('Y/m/d', strtotime($value->created_at));
      $new['status'] =$value->status;
      $new['option'] =$value->status;
//            $new_order[] = [ $value->id, $value->id, $value->name, $value->phone, $value->amount, $value->payment_type, $value->payment_status, $value->status, $value->status ];
      $new_order[] = $new;
    }

    // $totalData = count($order);
    return response([
      "draw"            => intval($request->input('draw')),
      "recordsTotal"    => intval($totalData),
      "recordsFiltered" => intval($totalFiltered),
      "data"            => $new_order
    ]);
  }


  /**
   * order history data
   * @param Request $request
   * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
   */
  public function get_orders_history_data(Request $request)
  {

    // return "hello";
    $columns = array(
      0 => 'id',
      1 => 'name',
      2 => 'phone',
      3 => 'address',
      4 => 'amount',
      5 => 'code',
      6 => 'discount',
      7 => 'payment_type',
      8 => 'payment_status',
      9 => 'order_date',
      10 => 'status',
      11 => 'option',
    );


    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');
    $totalData = Order::whereIn('orders.status', array('Cancelled', 'Completed'))->count();
//    $totalFiltered = $totalData;

    $dateRange = $request->post('dateRange');

    if (isset($dateRange)) {
      $startDate = date('Y-m-d 00:00:01', strtotime(explode(" - ", $dateRange)[0]));
      $endDate = date('Y-m-d 23:59:59', strtotime(explode(" - ", $dateRange)[1]));
      if(empty($request->input('search.value'))) {
        $query = DB::table('orders')
          ->join('address_books', 'address_books.id', '=', 'orders.billing_address')
          ->leftJoin('users', 'users.id', '=', 'orders.customer_id')
          ->whereIn('orders.status', array('Cancelled', 'Completed'))
          ->where('orders.created_at', '>=', $startDate)
          ->where('orders.created_at', '<=', $endDate)
          ->select('orders.*', 'address_books.name', 'address_books.phone', DB::raw("(SELECT address FROM `address_books` WHERE address_books.address_name = 'Shipping address' AND address_books.id = orders.shipping_address) as shipping_address"))
          ->offset($start)->limit($limit);

        if ($order != 'role'){
          $query->orderBy($order, $dir);
        }

        $order_data = $query->get();

        $totalFiltered = $query = DB::table('orders')
          ->join('address_books', 'address_books.id', '=', 'orders.billing_address')
          ->leftJoin('users', 'users.id', '=', 'orders.customer_id')
          ->whereIn('orders.status', array('Cancelled', 'Completed'))
          ->where('orders.created_at', '>=', $startDate)
          ->where('orders.created_at', '<=', $endDate)
          ->select('orders.*', 'address_books.name', 'address_books.phone', DB::raw("(SELECT address FROM `address_books` WHERE address_books.address_name = 'Shipping address' AND address_books.id = orders.shipping_address) as shipping_address"))
          ->count();
      } else {
        $search = $request->input('search.value');

        $query = DB::table('orders')
          ->join('address_books', 'address_books.id', '=', 'orders.billing_address')
          ->leftJoin('users', 'users.id', '=', 'orders.customer_id')
          ->select('orders.*', 'address_books.name', 'address_books.phone', DB::raw("(SELECT address FROM `address_books` WHERE address_books.address_name = 'Shipping address' AND address_books.id = orders.shipping_address) as shipping_address"))
          ->whereIn('orders.status', array('Cancelled', 'Completed'))
          ->where('orders.created_at', '>=', $startDate)
          ->where('orders.created_at', '<=', $endDate)
          ->where('orders.id', 'LIKE',"%{$search}%")
          ->orWhere('orders.payment_type', 'LIKE',"%{$search}%")
          ->orWhere('orders.payment_status', 'LIKE',"%{$search}%")
          ->orWhere('orders.status', 'LIKE',"%{$search}%")
          ->orWhere('address_books.phone', 'LIKE',"%{$search}%")
          ->orWhere('address_books.name', 'LIKE',"%{$search}%")
          ->offset($start)->limit($limit);
          if ($order != 'role'){
            $query->orderBy($order, $dir);
          }

          $order_data = $query->get();

          $totalFiltered = $query = DB::table('orders')
            ->join('address_books', 'address_books.id', '=', 'orders.billing_address')
            ->leftJoin('users', 'users.id', '=', 'orders.customer_id')
            ->select('orders.*', 'address_books.name', 'address_books.phone', DB::raw("(SELECT address FROM `address_books` WHERE address_books.address_name = 'Shipping address' AND address_books.id = orders.shipping_address) as shipping_address"))
            ->whereIn('orders.status', array('Cancelled', 'Completed'))
            ->where('orders.created_at', '>=', $startDate)
            ->where('orders.created_at', '<=', $endDate)
            ->where('orders.id', 'LIKE',"%{$search}%")
            ->orWhere('orders.payment_type', 'LIKE',"%{$search}%")
            ->orWhere('orders.payment_status', 'LIKE',"%{$search}%")
            ->orWhere('orders.status', 'LIKE',"%{$search}%")
            ->orWhere('address_books.phone', 'LIKE',"%{$search}%")
            ->orWhere('address_books.name', 'LIKE',"%{$search}%")->count();
      }
    }else{
      if (empty($request->input('search.value'))) {
        $query = DB::table('orders')
          ->join('address_books', 'address_books.id', '=', 'orders.billing_address')
          ->leftJoin('users', 'users.id', '=', 'orders.customer_id')
          ->whereIn('orders.status', array('Cancelled', 'Completed'))
          ->select('orders.*', 'address_books.name', 'address_books.phone', DB::raw("(SELECT address FROM `address_books` WHERE address_books.address_name = 'Shipping address' AND address_books.id = orders.shipping_address) as shipping_address"))
          ->offset($start)->limit($limit);

        if ($order != 'role'){
          $query->orderBy($order, $dir);
        }

        $order_data = $query->get();

        $totalFiltered = $query = DB::table('orders')
          ->join('address_books', 'address_books.id', '=', 'orders.billing_address')
          ->leftJoin('users', 'users.id', '=', 'orders.customer_id')
          ->whereIn('orders.status', array('Cancelled', 'Completed'))
          ->select('orders.*', 'address_books.name', 'address_books.phone', DB::raw("(SELECT address FROM `address_books` WHERE address_books.address_name = 'Shipping address' AND address_books.id = orders.shipping_address) as shipping_address"))
          ->count();

      } else {
        $search = $request->input('search.value');

        $query = DB::table('orders')
          ->join('address_books', 'address_books.id', '=', 'orders.billing_address')
          ->leftJoin('users', 'users.id', '=', 'orders.customer_id')
          ->select('orders.*', 'address_books.name', 'address_books.phone', DB::raw("(SELECT address FROM `address_books` WHERE address_books.address_name = 'Shipping address' AND address_books.id = orders.shipping_address) as shipping_address"))
          ->whereIn('orders.status', array('Cancelled', 'Completed'))
          ->where('orders.id', 'LIKE', "%{$search}%")
          ->orWhere('orders.payment_type', 'LIKE', "%{$search}%")
          ->orWhere('orders.payment_status', 'LIKE', "%{$search}%")
          ->orWhere('orders.status', 'LIKE', "%{$search}%")
          ->orWhere('address_books.phone', 'LIKE', "%{$search}%")
          ->orWhere('address_books.name', 'LIKE', "%{$search}%")
          ->offset($start)->limit($limit);
        if ($order != 'role'){
          $query->orderBy($order, $dir);
        }

        $order_data = $query->get();

        $totalFiltered = $query = DB::table('orders')
          ->join('address_books', 'address_books.id', '=', 'orders.billing_address')
          ->leftJoin('users', 'users.id', '=', 'orders.customer_id')
          ->select('orders.*', 'address_books.name', 'address_books.phone', DB::raw("(SELECT address FROM `address_books` WHERE address_books.address_name = 'Shipping address' AND address_books.id = orders.shipping_address) as shipping_address"))
          ->whereIn('orders.status', array('Cancelled', 'Completed'))
          ->where('orders.id', 'LIKE', "%{$search}%")
          ->orWhere('orders.payment_type', 'LIKE', "%{$search}%")
          ->orWhere('orders.payment_status', 'LIKE', "%{$search}%")
          ->orWhere('orders.status', 'LIKE', "%{$search}%")
          ->orWhere('address_books.phone', 'LIKE', "%{$search}%")
          ->orWhere('address_books.name', 'LIKE', "%{$search}%")->count();
      }
    }

    $new_order = [];
    foreach ($order_data as $key => $value){
      $new['id'] = $value->id;
      $new['name'] = $value->name;
      $new['phone'] =  $value->phone;
      $new['address'] =  $value->shipping_address;
      $new['amount'] = $value->amount;
      $code = "N\A";
      $discount = "N\A";
      if($value->discount != null){
        if($value->coupon_code != null){
          $code = $value->coupon_code;
        }else{
          $code = $value->discount_type;
        }
        $discount = $value->discount;
      }
      $new['code'] = $code;
      $new['discount'] = $discount;
      $new['payment_type'] = $value->payment_type;
      $new['payment_status'] = $value->payment_status;
      $new['order_date'] = date('Y/m/d', strtotime($value->created_at));
      $new['status'] =$value->status;
      $new['option'] =$value->status;
//            $new_order[] = [ $value->id, $value->id, $value->name, $value->phone, $value->amount, $value->payment_type, $value->payment_status, $value->status, $value->status ];
      $new_order[] = $new;
    }

    // $totalData = count($order);
    return response([
      "draw"            => intval($request->input('draw')),
      "recordsTotal"    => intval($totalData),
      "recordsFiltered" => intval($totalFiltered),
      "data"            => $new_order
    ]);
  }
}

