<?php

namespace App\Http\Controllers;

use App\Setting;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    protected $userPermission;


    #find array keys
    public function findKey($array, $keySearch) {
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
     * category with subcategory
     * */
    public function category_with_subcategory(){
        $categorySubCategory = DB::table('categories')
            ->join('sub_categories', 'sub_categories.category_id', '=', 'categories.id')
            ->select('categories.id As category_id', 'categories.name As category_name', 'categories.slug',
              'sub_categories.id As sub_category_id', 'sub_categories.name As sub_category_name', 'sub_categories.slug As sub_category_slug')
            ->whereNull('categories.deleted_at')
            ->whereNull('sub_categories.deleted_at')
            ->get();
//        dd($categorySubCategory);
        $cat_subCat = [];
        foreach ($categorySubCategory As $key => $value){
            if(!$this->findKey($cat_subCat, $value->category_name)){
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
        return $cat_subCat;
    }


  public function get_all_flavour(){
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
    $new_array = [];
    foreach ($category as $key => $value){
      $new_array[($key+1)]=[
        'id' => $value->id,
        'name' => $value->name,
        'slug' => $value->slug,
      ];
    }
    $new_array['Dual Flavor']=$duel->toArray();
    return $new_array;
  }



    public function __construct() {
        $this->middleware(function ($request, $next) {
            if(Auth::user()) {
                $this->userPermission = PublicFunction::get_users_to_permission_name(Auth::user()->id);
                $userDetails = PublicFunction::get_user_details(Auth::user()->id);

//                dd($userDetails);
                View::share('userPermission', $this->userPermission);
                View::share('userDetails', $userDetails);
            }
            $cat_subCat = $this->category_with_subcategory();
            View::share('cat_subCat', $cat_subCat);
            $flavor = PublicFunction::get_all_flavour();
//            $flavor = $this->get_all_flavour();

            View::share('flavor', $flavor);
            View::share('timeNow', Carbon::now());

//            getting delivery charge
            $delivery = Setting::where('title', '=', 'Delivery charge')->first();
            View::share('deliveryCharge', $delivery->value);

//            getting start Time
            $startTime = Setting::where('title', '=', 'start')->first();
            $startHoure = date('H', strtotime("2020-01-01 ".$startTime->value));
            $startMin = date('i', strtotime("2020-01-01 ".$startTime->value));
            View::share('startHoure', $startHoure);
            View::share('startMin', $startMin);

//            getting end Time
            $lastTime = Setting::where('title', '=', 'end')->first();
            $endHoure = date('H', strtotime("2020-01-01 ".$lastTime->value));
            $endMin = date('i', strtotime("2020-01-01 ".$lastTime->value));
            View::share('endHoure', $endHoure);
            View::share('endMin', $endMin);
            return $next($request);
        });
    }

    /**
     * Send text message to mobile number.
     * @param $to
     * @param $msg
     * @return mixed
     */
    protected function __send_sms($to, $msg){
        try {
            $user = "igloo";
            $pass = "95a?4A92";
            $sid = "iglooEng";
            $url = "http://sms.sslwireless.com/pushapi/dynamic/server.php";
            $param = "user=$user&pass=$pass&sms[0][0]= $to &sms[0][1]=" . urlencode($msg) . "&sid=$sid";
            $crl = curl_init();
            curl_setopt($crl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($crl, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($crl, CURLOPT_URL, $url);
            curl_setopt($crl, CURLOPT_HEADER, 0);
            curl_setopt($crl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($crl, CURLOPT_POST, 1);
            curl_setopt($crl, CURLOPT_POSTFIELDS, $param);
            $response = curl_exec($crl);
            curl_close($crl);
            return $response;
        }catch (Exception $e){
            return 'Something went wrong.';
        }
    }

}
