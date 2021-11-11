<?php

namespace App\Http\Controllers;

use App\BestSelling;
use App\Career;
use App\Category;
use App\Coupon;
use App\Mail\CareerMail;
use App\Order;
use App\Payment;
use App\Product;
use App\Mail\ContactMail;
use App\PrivacyPolicy;
use App\PurchaseDiscount;
use App\Recipe;
use App\Setting;
use App\Slider;
use App\TermsCondition;
use SEO;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Mockery\Exception;
use Validator;
use Auth;
use Cart;
use Illuminate\Support\Facades\Session;


class SiteController extends Controller
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
    /** index page */
    public function index(){
        SEO::setTitle('Home');
        SEO::setDescription('A world of great test!');
        $slider = Slider::whereNull('deleted_at')->get();
        $recipies = Recipe::where('status', 'Publish')->whereNull('deleted_at')->orderBy('id', 'DESC')->get();
        $category = Category::whereNull('deleted_at')->whereNotIn('name', ['Package'])
            ->get();
        $product = DB::table('products')
            ->leftJoin('product_has_images', 'product_has_images.product_id', '=', 'products.id')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->join('sub_categories', 'sub_categories.id', '=', 'products.sub_category_id')
            ->select('products.id', 'products.name', 'products.slug', 'products.thumbnail_image', 'products.quantity', 'products.sku', 'products.price', 'products.selling_price', 'sub_categories.name As sub_category_name', 'sub_categories.id As sub_category_id', 'categories.name As category_name', 'categories.id As category_id', DB::raw('group_concat(product_has_images.image) as image'))
            ->whereNull('products.deleted_at')
            ->whereNotIn('categories.name', ['Package'])
            ->where('products.quantity', '>', 0)
            ->groupBy('products.id')
            ->orderBy('products.id', 'ASC')
            ->get();
        $packages = DB::table('products')
            ->leftJoin('product_has_images', 'product_has_images.product_id', '=', 'products.id')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->join('sub_categories', 'sub_categories.id', '=', 'products.sub_category_id')
            ->select('products.id', 'products.name',  'products.slug', 'products.thumbnail_image', 'products.description', 'products.quantity', 'products.sku', 'products.price', 'products.selling_price', 'sub_categories.name As sub_category_name', 'sub_categories.id As sub_category_id', 'categories.name As category_name', 'categories.id As category_id', DB::raw('group_concat(product_has_images.image) as image'))
            ->whereNull('products.deleted_at')
            ->where('categories.name', '=', 'Package')
            ->where('products.quantity', '>', 0)
            ->groupBy('products.id')
            ->orderBy('products.id', 'DESC')
            ->get();
        $data = DB::table('galleries')
            ->leftJoin('gallery_title_has_image', 'gallery_title_has_image.title_id', '=', 'galleries.id')
            ->select('galleries.title', 'gallery_title_has_image.*')
            ->whereNull('gallery_title_has_image.deleted_at')
            ->whereNull('galleries.deleted_at')
            ->orderBy('id', 'DESC')
            ->get();
        $galleries=[];
        foreach ($data As $key => $value){
            if(!$this->findKey($galleries, $value->title_id)){
                $galleries[$value->title_id] = [
                    'title_id' => $value->title_id,
                    'title' => $value->title,
                    'image_id' => $value->id,
                    'image' => $value->image,
                ];
            }
        }

        // getting best selling product

        $bestSells = DB::table('best_sellings')
            ->leftJoin('products', 'products.id', '=', 'best_sellings.product_id')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->select('products.id', 'products.name', 'products.slug', 'products.quantity', 'products.thumbnail_image', 'products.price', 'products.selling_price', DB::raw('SUM(best_sellings.number_of_product_sale) AS sell'))
            ->where('products.quantity', '>', 0)
            ->where('categories.name', '!=', 'Package')
            ->groupBy('best_sellings.product_id')
            ->orderBy('sell', 'DESC')
            ->get()->take(10);
//        return $bestSells;


        return view('site.index',compact('recipies', 'product', 'category', 'slider', 'packages', 'galleries', 'bestSells'));
    }
    /** about us */
    public function get_about_us(){
      SEO::setTitle('About Us');
      SEO::setDescription('A world of great test!');
      return view('site.about_us');
    }
    /** Terms condition */
    public function get_terms_condition(){
      SEO::setTitle('Terms & Conditions');
//      SEO::setDescription('A world of great test!');
        $terms = TermsCondition::first();
        return view('site.terms_condition',compact('terms'));

    }
    /** Privacy_policy */
    public function get_privacy_policy(){
      SEO::setTitle('Privacy Policy');
//      SEO::setDescription('A world of great test!');
        $privacy = PrivacyPolicy::first();
        return view('site.privacy_policy',compact('privacy'));

    }
    /** Recipe Details */
    public function get_recipe_details($slug){
        $recipe_details = Recipe::where('slug', $slug)->get();
        if(count($recipe_details) > 0) {
            $recipe_details = $recipe_details[0];
        SEO::setTitle($recipe_details->title);
//      SEO::setDescription('A world of great test!');
            return view('site.recipe.recipe_details',compact('recipe_details'));
        }else {
            return redirect()->back();
        }
    }
    /** Recipe page*/
    public function igloo_recipe(){
      SEO::setTitle('Recipes');
//      SEO::setDescription('A world of great test!');
        $recipes = Recipe::whereNull('deleted_at')
            ->where('blog_type','recipe')
            ->paginate(6);
        return view('site.recipe.recipe',compact('recipes'));

    }
    /** Recipe page*/
    public function igloo_article(){
      SEO::setTitle('Articles');
//      SEO::setDescription('A world of great test!');
        $recipes = Recipe::whereNull('deleted_at')
            ->where('blog_type','article')
            ->paginate(6);
        return view('site.recipe.recipe',compact('recipes'));

    }
    /** Contact us */
    public function get_contact_us(Request $request){
      SEO::setTitle('Contact Us');
//      SEO::setDescription('A world of great test!');
        if ($request->isMethod('post')){
            $data = $request->all();
            $validator = Validator::make($data, [
                'name' => 'required',
                'email' => 'required',
                'subject' => 'required',
                'msg' => 'required',
            ]);
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            try{
                Mail::to( 'igloo.pink.bd@gmail.com')->send(new ContactMail($data['name'], $data['email'], $data['subject'], $data['msg']));

                $status = '<div class="alert alert-success alert-dismissible" role="alert">
                                <strong></strong>Mail Successfully Send.
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                        </div>';
                return redirect()->back()->with('status', $status);
            }catch(Exception $e){
                $status = '<div class="alert alert-danger alert-dismissible " role="alert">
                                <strong></strong>Mail not send.
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                        </div>';
                return redirect()->back()->with('status', $status);
            }
        }
        return view('site.contact_us');

    }
    /** Contact us */
    public function get_faq(){
      SEO::setTitle('FAQ');
//      SEO::setDescription('A world of great test!');
        return view('site.faq');
    }

    public function career(){
      SEO::setTitle('Career');
//      SEO::setDescription('A world of great test!');
        $career = Career::get();
        return view('site.career',compact('career'));
    }
    /** Customer  */
    public function customer_account(){
        $orders = Order::where('customer_id', '=', auth()->id())->orderBy('id', 'DESC')->get();
//        return $orders;
        return view('site.customer.customer_account', compact('orders'));
    }
    /** Products  */
    public function products(Request $request){
      SEO::setTitle('Products');
//      SEO::setDescription('A world of great test!');

        $product_id = null;
        $category = Category::whereNull('deleted_at')->get();

      if(isset($request->flavor) && $request->flavor == "dual"){
        $product_id = DB::table('attribute_link')
          ->join('attribute_meta', 'attribute_meta.id', '=', 'attribute_link.attribute_meta_id')
          ->join('attributes', 'attributes.id', '=', 'attribute_meta.attribute_id')
//            ->where('attributes.id', '=', $request->dualflavor)
          // make sure attribute dual flavor id is 3
          ->where('attributes.id', '=', 3)
          ->pluck('attribute_link.product_id');

        $products = DB::table('products')
          ->leftJoin('product_has_images', 'product_has_images.product_id', '=', 'products.id')
          ->join('categories', 'categories.id', '=', 'products.category_id')
          ->join('sub_categories', 'sub_categories.id', '=', 'products.sub_category_id')
          ->select('products.*', 'sub_categories.name As sub_category_name', 'sub_categories.id As sub_category_id', 'categories.name As category_name', 'categories.id As category_id', DB::raw('group_concat(product_has_images.image) as image'))
          ->whereNull('products.deleted_at')
          ->where('products.quantity', '>', 0)
          ->when($product_id, function ($query, $product_id) {
            return $query->whereIn('products.id', $product_id);
          })
//            ->where('categories.slug', '=', $request->mainCategory)
//            ->where('sub_categories.id', (isset($request->subCategory) ? '=' : '!='), (isset($request->subCategory) ? $request->subCategory : -1))
          ->where('products.name', (isset($request->title) ? 'Like' : '!='), (isset($request->title) ? '%'.$request->title.'%' : '@&$'))
          ->groupBy('products.id')
          ->orderBy('products.id', 'ASC')
          ->paginate(12)
          ->appends(request()->query());

        return view('site.product.products',compact('products','category', 'request'));

      }

        if(isset($request->flavor)){
          $product_id = DB::table('attribute_link')
            ->join('attribute_meta', 'attribute_meta.id', '=', 'attribute_link.attribute_meta_id')
            ->where('attribute_meta.slug', '=', $request->flavor)
            ->pluck('attribute_link.product_id');

        }

        // if it is all dual flavor


        $products = DB::table('products')
            ->leftJoin('product_has_images', 'product_has_images.product_id', '=', 'products.id')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->join('sub_categories', 'sub_categories.id', '=', 'products.sub_category_id')
            ->select('products.*', 'sub_categories.name As sub_category_name', 'sub_categories.id As sub_category_id', 'categories.name As category_name', 'categories.id As category_id', DB::raw('group_concat(product_has_images.image) as image'))
            ->whereNull('products.deleted_at')
            ->where('products.quantity', '>', 0)
            ->when($product_id, function ($query, $product_id) {
              return $query->whereIn('products.id', $product_id);
            })
            ->where('categories.slug', (isset($request->category) ? '=' : '!='), (isset($request->category) ? $request->category : null))
            ->where('sub_categories.slug', (isset($request->subCategory) ? '=' : '!='), (isset($request->subCategory) ? $request->subCategory : null))
            ->where('products.name', (isset($request->title) ? 'Like' : '!='), (isset($request->title) ? '%'.$request->title.'%' : '@&$'))
            ->groupBy('products.id')
            ->orderBy('products.id', 'ASC')
            ->paginate(12)
            ->appends(request()->query());

        return view('site.product.products',compact('products','category', 'request'));

    }

    public function product_details($product_id){
        $product = DB::table('products')
            ->leftJoin('product_has_images', 'product_has_images.product_id', '=', 'products.id')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->join('sub_categories', 'sub_categories.id', '=', 'products.sub_category_id')
            ->select('products.*', 'sub_categories.name As sub_category_name', 'sub_categories.id As sub_category_id', 'categories.name As category_name', 'categories.id As category_id', DB::raw('group_concat(product_has_images.image) as image'))
            ->whereNull('products.deleted_at')
            ->where('products.slug', '=', $product_id)
            ->groupBy('products.id')
            ->orderBy('products.id', 'desc')
            ->get();
        if ($product->isNotEmpty()) {
            $product = $product[0];
            $product_attributes = DB::table('attribute_link')
                ->join('attribute_meta', 'attribute_meta.id', '=', 'attribute_link.attribute_meta_id')
                ->join('attributes', 'attributes.id', '=', 'attribute_meta.attribute_id')
                ->select('attributes.id As attribute_id', 'attributes.name', 'attribute_meta.id As attribute_value_id', 'attribute_meta.value')
                ->where('attribute_link.product_id', '=', $product->id)
                ->orderBy('attribute_meta.id', 'asc')
                ->get();
          SEO::setTitle($product->name);
  //      SEO::setDescription('A world of great test!');
          return view('site.product.product_details', compact('product', 'product_attributes'));
        }else{
            return redirect()->route('products');
        }
//        return $product_attributes;
    }
    /** My cart  */
    public function my_cart(){
      SEO::setTitle('My Cart');
//      SEO::setDescription('A world of great test!');
        $purchaseDiscountOffer = [];
        if(auth()->user()) {
          $currentTime = date('Y-m-d H:i:s', strtotime(Carbon::now()));
          $purchasedProduct = Order::where('status', '=', 'Completed')->where('customer_id', '=', auth()->id())->get();
          // getting available offer of this time
          $offer = PurchaseDiscount::where('expire_date', '>', $currentTime)->get();
          foreach ($offer As $key => $value){
              // checking lifetime purchased offer
              if($value->offer_type == "lifetime"){
                  $quantity = $value->number_of_purchase;
                  $sellProductQuentity = $purchasedProduct->count();
                  if($quantity <= $sellProductQuentity){
                    $purchaseDiscountOffer[]=$value;
                  }
              }else{
                  // checking specific_time_period purchased offer
                  $purchase_start_date = strtotime($value->purchase_start_date);
                  $purchase_end_date = strtotime($value->purchase_end_date);
                  $number_of_purchase = $value->number_of_purchase;
                  $sellProductQuentity = 0;
                  foreach ($purchasedProduct as $key => $val){
                      $created_at = strtotime($val->created_at);
//                  return $purchase_start_date." < ".$created_at." && ".$created_at." < ".$purchase_end_date;
                      if($purchase_start_date < $created_at && $created_at < $purchase_end_date) {
                          $sellProductQuentity += 1;
                      }
                  }
                  if($number_of_purchase <= $sellProductQuentity){
                      $purchaseDiscountOffer[]=$value;
                  }
              }
          }
        }

        $finalPurchaseDiscount = 0;

        foreach ($purchaseDiscountOffer As $key => $val){
            if($finalPurchaseDiscount < $val->discount){
                $finalPurchaseDiscount = $val->discount;
//                Cart::setGlobalDiscount($val->discount);
//                $msg = '<div class="alert alert-success mt-2">
//                            <div>Congratulations! You got '.$val->discount.'% discount applied.</div>
//                        </div>';
//                Session::put('coupon_status', $msg);
            }
        }

//        if user has Purchase Discount
        if($finalPurchaseDiscount > 0 ) {
//            if user apply coupon for discount
            if (Session::get('discount_type') === "Coupon Discount") {
                $this->_set_highest_discount($finalPurchaseDiscount, Session::get('discount'));
            } else {
//                users has no coupon discount
                $this->_set_highest_discount($finalPurchaseDiscount);
            }
        }else {
            if (Session::get('discount_type') === "Coupon Discount") {
//                return "hi";
                $this->_set_highest_discount(0, Session::get('discount'));
            }
        }

        $this->_set_total_price_of_cart();

        return view('site.cart');
    }

    private function _set_total_price_of_cart(){
        $sessionDiscount = floatval(Session::get('discount'));
//        if session is null set -1
        if(!isset($sessionDiscount)){
            $sessionDiscount = -1;
        }
//        delivery charge from db
        $delivery = Setting::where('title', '=', 'Delivery charge')->first();


        $total = (isset($delivery)) ? $delivery->value : 0 ;

        foreach (Cart::content() as $key =>$value){
            $cartProductQuantity = floatval($value->qty);
//return $value;
            $cartProductPrice = floatval($value->price);
            $cartProductDiscount = floatval($value->options->pDiscount);
            $cartProductRegularPrice = floatval($value->options->regularPrice);
//           checking sessionDiscount is grater then cartProductDiscount
            if($sessionDiscount > $cartProductDiscount){

                $this->update_cart($value, $value->options->regularPrice);

                $reducePrice = ($cartProductRegularPrice * $sessionDiscount)/100;
                $price = $cartProductRegularPrice - $reducePrice;
//                return $cartProductRegularPrice." = ".$price;
            }else{
                $price = $cartProductPrice;
            }
            $total = floatval($total) + ( $price * $cartProductQuantity );
        }
//            dd($total);
        Session::put('total_price', $total);
    }
    /**
     * update cart data
     * @param $cartData
     * @param $price
     */
    public function update_cart($cartData, $price){
        /**
         * removing cart data
         */
        Cart::remove($cartData->rowId);

//        adding new cart data
        $product_to_add = array(
            'id' => $cartData->id,
            'name' => $cartData->name,
            'qty' => $cartData->qty,
            'price' => $price,
            'weight' => $cartData->weight,
            'options' => json_decode(json_encode($cartData->options),true),
            'discount' => $cartData->discount,
            'tax' => $cartData->tax,
            'subtotal' => ( floatval($cartData->qty) * floatval($price))
        );
        Cart::add($product_to_add);
    }
    /**
     * set the highest discount from two discount type (purchase discount and coupon discount)
     * @param int $purchase_discount
     * @param int $coupon_discount
     * @return void
     */
    private function _set_highest_discount($purchase_discount = 0, $coupon_discount = 0){
        if ($purchase_discount > $coupon_discount){
            Session::put('discount_type', 'Purchase Discount');
        }else{
            Session::put('discount_type', 'Coupon Discount');
        }
        Session::put('discount', max($purchase_discount, $coupon_discount));

        $msg = '<div class="alert alert-success mt-2">
                            <div>Congratulations! You got '.Session::get('discount').'% discount applied.</div>
                        </div>';
        Session::put('coupon_status', $msg);
//        return $msg;
    }

    /** Checkout  */
    public function checkout(){
      SEO::setTitle('Checkout');
//      SEO::setDescription('A world of great test!');


# REMOVE THIS LINE WHEN YOU WANT TO TAKE ONLINE ORDER
    // return redirect()->route('cart');
    
        // if cart is empty
        if(Cart::count() < 1){
            return redirect()->route('cart');
        }
        if((float) filter_var(Cart::subtotal(), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) >= 100){
            /**
             * if user direct come to checkout page
             */
            $purchaseDiscountOffer = [];
            if(auth()->user()) {
                $currentTime = date('Y-m-d H:i:s', strtotime(Carbon::now()));
                $purchasedProduct = Order::where('status', '=', 'Completed')->where('customer_id', '=', auth()->id())->get();
                // getting available offer of this time
                $offer = PurchaseDiscount::where('expire_date', '>', $currentTime)->get();
                foreach ($offer As $key => $value){
                    // checking lifetime purchased offer
                    if($value->offer_type == "lifetime"){
                        $quantity = $value->number_of_purchase;
                        $sellProductQuentity = $purchasedProduct->count();
                        if($quantity <= $sellProductQuentity){
                            $purchaseDiscountOffer[]=$value;
                        }
                    }else{
                        // checking specific_time_period purchased offer
                        $purchase_start_date = strtotime($value->purchase_start_date);
                        $purchase_end_date = strtotime($value->purchase_end_date);
                        $number_of_purchase = $value->number_of_purchase;
                        $sellProductQuentity = 0;
                        foreach ($purchasedProduct as $key => $val){
                            $created_at = strtotime($val->created_at);
                            if($purchase_start_date < $created_at && $created_at < $purchase_end_date) {
                                $sellProductQuentity += 1;
                            }
                        }
                        if($number_of_purchase <= $sellProductQuentity){
                            $purchaseDiscountOffer[]=$value;
                        }
                    }
                }
            }
            $finalPurchaseDiscount = 0;
            foreach ($purchaseDiscountOffer As $key => $val){
                if($finalPurchaseDiscount < $val->discount){
                    $finalPurchaseDiscount = $val->discount;
                }
            }
//        if user has Purchase Discount
            if($finalPurchaseDiscount > 0 ) {
//            if user apply coupon for discount
                if (Session::get('discount_type') === "Coupon Discount") {
                    $this->_set_highest_discount($finalPurchaseDiscount, Session::get('discount'));
                } else {
//                users has no coupon discount
                    $this->_set_highest_discount($finalPurchaseDiscount);
                }
            }else {
                if (Session::get('discount_type') === "Coupon Discount") {
                    $this->_set_highest_discount(Session::get('discount'));
                }
            }

            $this->_set_total_price_of_cart();

            return view('site.checkout');
        }


        return redirect()->route('cart');
    }

    public function checkout_login(Request $request){
        $validator = Validator::make($request->all(), [
            'emailOrPhone' => 'required',
            'password' => 'required|min:6',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $data = $request->all();
        $field_type = filter_var($data['emailOrPhone'], FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';


        if (Auth::attempt([$field_type => $data['emailOrPhone'], 'password' => $data['password'], 'status' => 'Active', 'provider' => null, 'provider_id' => null])) {
            $data = DB::table('model_has_roles')
                ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                ->select('roles.id as role_id', 'roles.name as role')
                ->where('model_has_roles.model_id', Auth::user()->id)
                ->get();
            if ($data[0]->role_id == 3) {
                return redirect(route('checkout'));
            } else {
                Auth::logout();
                $status = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                            You can not login.
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                </div>';
                return redirect()->back()->with('status', $status)->withInput();
            }
        } else {
            $status = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            Invalid User.
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                </div>';
            return redirect()->back()->with('status', $status)->withInput();
        }
    }
    /** my offers  */
    public function my_offers(){
        SEO::setTitle('Offers');
//      SEO::setDescription('A world of great test!');
        $packages = DB::table('products')
            ->leftJoin('product_has_images', 'product_has_images.product_id', '=', 'products.id')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->join('sub_categories', 'sub_categories.id', '=', 'products.sub_category_id')
            ->select('products.id', 'products.name', 'products.slug', 'products.thumbnail_image', 'products.description', 'products.quantity', 'products.sku', 'products.price', 'products.selling_price', 'sub_categories.name As sub_category_name', 'sub_categories.id As sub_category_id', 'categories.name As category_name', 'categories.id As category_id', DB::raw('group_concat(product_has_images.image) as image'))
            ->whereNull('products.deleted_at')
            ->where('products.quantity', '>', 0)
            ->where('categories.name', '=', 'Package')
            ->groupBy('products.id')
            ->orderBy('products.id', 'desc')
            ->paginate(8);
        $coupons = Coupon::whereNull('deleted_at')
            ->where('status','Active')
            ->where('is_public','1')
            ->where('expire_date','>',Carbon::now())
            ->get();
        return view('site.offers',compact('packages','coupons'));
    }
    /** igloo_order_process */
    public function igloo_order_process(){
        SEO::setTitle('Order Process');
//      SEO::setDescription('A world of great test!');
        return view('site.order_process');
    }
    /** igloo_order_process */
    public function thankyou(Request $request){
      SEO::setTitle('Thank You');
//      SEO::setDescription('A world of great test!');
            $payment_id = Session::get('payment_id');
            $order_id = Session::get('message');
            if(!isset($payment_id) || !isset($order_id)){
              return redirect()->route('index');
            }
//        $request = \GuzzleHttp\json_decode("{
//\"tran_id\": \"SSLCZ_TEST_5e0dce8521188\",
//\"val_id\": \"2001021646350V8JIvpzgaG5GqE\",
//\"amount\": \"720.00\",
//\"card_type\": \"BKASH-BKash\",
//\"store_amount\": \"702.00\",
//\"card_no\": null,
//\"bank_tran_id\": \"2001021646341T82a6bw5Yh5vkE\",
//\"status\": \"VALID\",
//\"tran_date\": \"2020-01-02 16:46:30\",
//\"currency\": \"BDT\",
//\"card_issuer\": \"BKash Mobile Banking\",
//\"card_brand\": \"MOBILEBANKING\",
//\"card_issuer_country\": \"Bangladesh\",
//\"card_issuer_country_code\": \"BD\",
//\"store_id\": \"saros5e086e68b8adf\",
//\"verify_sign\": \"418fc3f147349f201d41745a26471bd9\",
//\"verify_key\": \"amount,bank_tran_id,base_fair,card_brand,card_issuer,card_issuer_country,card_issuer_country_code,card_no,card_type,currency,currency_amount,currency_rate,currency_type,risk_level,risk_title,status,store_amount,store_id,tran_date,tran_id,val_id,value_a,value_b,value_c,value_d\",
//\"verify_sign_sha2\": \"8edeba21bd49880bf1ce8f276798c8e0d96a16233403e74320a2985656b6ed1f\",
//\"currency_type\": \"BDT\",
//\"currency_amount\": \"720.00\",
//\"currency_rate\": \"1.0000\",
//\"base_fair\": \"0.00\",
//\"value_a\": \"ref001\",
//\"value_b\": \"ref002\",
//\"value_c\": \"ref003\",
//\"value_d\": \"ref004\",
//\"risk_level\": \"0\",
//\"risk_title\": \"Safe\"
//}", true);
//        return $request;
        $data = [
            'order_id' => $order_id,
            'payment_id' => $payment_id,
            'amount'=> null,
            'card_type'=> null,
        ];
        if($request->amount && $request->tran_id && $request->card_type){
            Payment::where('id', '=', $payment_id)->where('amount', '<=', $request->amount)->update(['status'=>"Paid", 'paid_by' => $request->card_type, 'transaction_id' => $request->tran_id ]);
                $order = Order::where('id','=',$order_id)->get();
                if($order[0]->amount <= $request->amount ){
                    Order::where('id','=',$order_id)->update(['payment_status'=>'Paid']);
                }else{
                    Order::where('id','=',$order_id)->update(['payment_status'=>'Partial Paid']);
                }
            $data = [
                'order_id' => $order_id,
                'amount'=> $request->amount,
                'card_type'=> $request->card_type,
            ];
        }
        Session::forget('payment_id');
        return view('site.thank_you')->with('data', $data);
    }

    public function cancel_payment() {
        SEO::setTitle('Cancel Payment');
//      SEO::setDescription('A world of great test!');
        $payment_id = Session::get('payment_id');
        if(!isset($payment_id)){
          return redirect()->route('index');
        }
        Payment::where('id', '=', $payment_id)->update(['status'=>"Canceled"]);
        return view('site.cancel_payment');
    }

    /**
     * @param Request $request
     * @return string
     */
    public function submit_career(Request $request){
        if($request->isMethod("POST")){
//            return $request;
            $data = $request->all();
            $validator = Validator::make($data, [
                'name' => 'required',
                'email' => 'required',
                'subject' => 'required',
                'message' => 'required',
                'cv' => 'required',
            ]);
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
//            return $request;
//            $file_path = null;
            if ($request->file('cv') != null) {
                $image = $request->file('cv');
                $name = time().'.'.$image->getClientOriginalExtension();
                $path = '/career_file/';
                $destinationPath = public_path($path);
                $image->move($destinationPath, $name);
            }
            $cv_file = '/recipe_images/1577705150.jpg';
            if(isset($name)){
                $cv_file = $path.$name;
            }
            try{
                Mail::to('igloo.pink.bd@gmail.com')->send(new CareerMail($data, $cv_file));

                $status = '<div class="alert alert-success alert-dismissible" role="alert">
                                <strong></strong>Mail Successfully Send.
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                        </div>';
                return redirect()->back()->with('status', $status);
            }catch(Exception $e){
                $status = '<div class="alert alert-danger alert-dismissible " role="alert">
                                <strong></strong>Mail not send.
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                        </div>';
                return redirect()->back()->with('status', $status);
            }

        }
    }
}
