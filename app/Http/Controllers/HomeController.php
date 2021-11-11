<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
use Cart;
use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function test(Request $request)
    {
        return $this->__send_sms('8801782399803', 'This is test from serverside.');
        return 'yo';
//        return $request;
        $columns = array(
            0 =>'id',
            1 =>'name',
            2=> 'phone',
            3=> 'amount',
            4=> 'payment_type',
            5=> 'payment_status',
            6=> 'status',
            7=> 'option',

//            0 =>'id',
//            1 =>'id',
//            2 =>'name',
//            3=> 'phone',
//            4=> 'amount',
//            5=> 'payment_type',
//            6=> 'payment_status',
//            7=> 'status',
//            8=> 'option',
        );


        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $totalData = Order::count();
        $totalFiltered = $totalData;


        if(empty($request->input('search.value')))
        {
            $order = DB::table('orders')
                ->join('address_books', 'address_books.id', '=', 'orders.billing_address')
                ->join('users', 'users.id', '=', 'orders.customer_id')
                ->select('orders.*', 'address_books.name', 'address_books.phone')
                ->offset($start)->limit($limit)->orderBy($order,$dir)->get();
        }
        else {
            $search = $request->input('search.value');


            $order = DB::table('orders')
                ->join('address_books', 'address_books.id', '=', 'orders.billing_address')
                ->join('users', 'users.id', '=', 'orders.customer_id')
                ->select('orders.*', 'address_books.name', 'address_books.phone')
                ->where('orders.id', 'LIKE',"%{$search}%")
                ->orWhere('orders.payment_type', 'LIKE',"%{$search}%")
                ->orWhere('orders.payment_status', 'LIKE',"%{$search}%")
                ->orWhere('address_books.phone', 'LIKE',"%{$search}%")
                ->orWhere('address_books.name', 'LIKE',"%{$search}%")
                ->offset($start)->limit($limit)->orderBy($order,$dir)->get();

            $totalFiltered = count($order);
        }

//        $order = DB::table('orders')
//            ->join('address_books', 'address_books.id', '=', 'orders.billing_address')
//            ->join('users', 'users.id', '=', 'orders.customer_id')
//            ->select('orders.*', 'address_books.name', 'address_books.phone')
//            ->orderBy('orders.id', 'DESC')->get();
        $new_order = [];
        foreach ($order as $key => $value){
            $new['id'] = $value->id;
            $new['name'] = $value->name;
            $new['phone'] =  $value->phone;
            $new['amount'] = $value->amount;
            $new['payment_type'] = $value->payment_type;
            $new['payment_status'] = $value->payment_status;
            $new['status'] =$value->status;
            $new['option'] =$value->status;
//            $new_order[] = [ $value->id, $value->id, $value->name, $value->phone, $value->amount, $value->payment_type, $value->payment_status, $value->status, $value->status ];
            $new_order[] = $new;
        }

//        $json_data = array(
//            "draw"            => intval($request->input('draw')),
//            "recordsTotal"    => intval($totalData),
//            "recordsFiltered" => intval($totalFiltered),
//            "data"            => $new_order
//        );

//        echo json_encode($json_data);
//        return $new_order;
        return response([
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $new_order
        ]);
    }
}
