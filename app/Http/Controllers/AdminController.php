<?php

namespace App\Http\Controllers;

use App\Order;
use App\Payment;
use Carbon\Carbon;
use function GuzzleHttp\Psr7\str;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use View;
use Spatie\Permission\Models\Role;
use Validator;
use Illuminate\Http\Request;
use App\User;

use App\Http\Controllers\PublicFunction;


class AdminController extends Controller
{
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


    #admin Dashboard
    public  function admin_dashboard(){
//        $time = '2019-12-30 12:12:14';
        $time = Carbon::now();
        $start_time = date('Y-m-d 00:00:00', strtotime($time));
        $end_time = date('Y-m-d 00:00:00', strtotime($start_time.'+1 day'));
        $daily_sale = DB::table('orders')
            ->whereBetween('created_at',[$start_time,$end_time])
            ->sum('amount');
        $daily_order = DB::table('orders')
            ->whereBetween('created_at',[$start_time,$end_time])
            ->count();
        $total_order = Order::count();
        $total_sale = Order::where('payment_status','Paid')->sum('amount');

        // last 12 month sales start
        $startDay = date('Y-m-01 00:00:00', strtotime(date('Y-m-01 00:00:00', strtotime($time."+-1 years"))."+1 months"));
        $endDay = date('Y-m-01 00:00:00', strtotime($time.'+1 months'));
//        return $startDay.'=============='.$endDay;

        $payment = Payment::where('status','Paid')->whereBetween('created_at', [$startDay,$endDay])->orderBy('created_at', 'ASC')->get();
//        return $payment;
        $data = [];
        foreach ($payment as $key=>$val){
            $month = date('M', strtotime($val->created_at));
            if(!array_key_exists($month, $data)){
                $data[$month] = $val->amount;
            }else{
                $data[$month] = ( $data[$month] + $val->amount );
            }
        }
//        return $data;

        // last 12 month sales end

        //monthly chart
        return view('admin.admin_dashboard',compact('total_sale','total_order','daily_sale','daily_order', 'data'));
    }


    /*
     * register function
     * */
    public function add_user_by_admin(Request $request){
        $all_role = PublicFunction::get_all_role();
//        return $all_role;
        if($request->isMethod('POST')){
            $data = $request->all();
//            return $data;
            $validator = Validator::make($data,[
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'phone' => 'required|min:11|unique:users',
                'password' => 'required|min:6',
                'role' => 'required'
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            try {
                $user = User::create([
                    'name' => $data['name'],
                    'phone' => $data['phone'],
                    'email' => $data['email'],
                    'password' => Hash::make($data['password'])
                ]);
                $role = Role::find($data['role']);
                $user->assignRole($role);
                $status = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                      User added successfully
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                    </div>';
                return redirect()->back()->with('status', $status);
            }catch (QueryException $e){
                $status = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                      Something Went wrong.
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                    </div>';
                return redirect()->back()->with('status', $status)->withInput();
            }
        }
        return view('admin.user.add_user')->with('role', $all_role);
    }


    # view admin can view another admin
    public function view_user_by_admin(){
//        $data = DB::table('users')
//            ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
//            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
//            ->where('users.deleted_at', '=', null)
//            ->select('users.id', 'users.name', 'users.phone', 'users.email', 'users.status', 'roles.id As role_id', 'roles.name As role_name', 'users.created_at')
//            ->get();
        return view('admin.user.view_user');
    }

    /**
     * ajax_fetch_users method - fetch all the users from database for server side
     * datatable view.
     * @param Request $request
     */
    public function ajax_fetch_users(Request $request)
    {
        // Code here
        // Columns for datatables
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'email',
            3 => 'phone',
            4 => 'role',
            5 => 'created_at',
            6 => 'option',
        );
        if ($request->isMethod('post')){
            $limit = $request->input('length');
            $start = $request->input('start');
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');
            $totalData = User::count();
            if (empty($request->input('search.value'))){
                $query = DB::table('users')
                    ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
                    ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                    ->where('users.deleted_at', '=', null)
                    ->select('users.id', 'users.name', 'users.phone', 'users.email', 'users.status', 'roles.id As role_id', 'roles.name As role_name', 'users.created_at')
                    ->offset($start)->limit($limit);
                if ($order != 'role'){
                    $query->orderBy($order, $dir);
                }

                $users = $query->get();

                $recordsFiltered = DB::table('users')
                    ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
                    ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                    ->where('users.deleted_at', '=', null)
                    ->select('users.id', 'users.name', 'users.phone', 'users.email', 'users.status', 'roles.id As role_id', 'roles.name As role_name', 'users.created_at')
                    ->count();
            }else{
                $search_value = $request->input('search.value');
                $users = DB::table('users')
                    ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
                    ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                    ->where('users.deleted_at', '=', null)
                    ->where('users.id', 'LIKE', "%$search_value%")
                    ->orWhere('users.name', 'LIKE', "%$search_value%")
                    ->orWhere('users.email', 'LIKE', "%$search_value%")
                    ->orWhere('users.phone', 'LIKE', "%$search_value%")
                    ->orWhere('roles.name', 'LIKE', "%$search_value%")
                    ->select('users.id', 'users.name', 'users.phone', 'users.email', 'users.status', 'roles.id As role_id', 'roles.name As role_name', 'users.created_at')
                    ->offset($start)->limit($limit)->orderBy($order, $dir)
                    ->get();

                $recordsFiltered = DB::table('users')
                    ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
                    ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                    ->where('users.deleted_at', '=', null)
                    ->where('users.id', 'LIKE', "%$search_value%")
                    ->orWhere('users.name', 'LIKE', "%$search_value%")
                    ->orWhere('users.email', 'LIKE', "%$search_value%")
                    ->orWhere('users.phone', 'LIKE', "%$search_value%")
                    ->orWhere('roles.name', 'LIKE', "%$search_value%")
                    ->count();
            }


            return response([
                "draw"            => intval($request->input('draw')),
                "recordsTotal"    => intval($totalData),
                "recordsFiltered" => intval($recordsFiltered),
                "data"            => $users
            ]);


        }
        return;
    }

    # view admin can delete user
    public function delete_user_by_admin(Request $request){
        if($request->isMethod("POST")) {
            if(User::where('id', '=', $request->post('id'))->where('deleted_at', '=', null)->delete()){
                return "success";
            }
        }
    }

    # view admin can edit user
    public function edit_user_by_admin(Request $request, $user_id){
        $user = PublicFunction::get_user_details($user_id);
        $role = PublicFunction::get_all_role();
        if ($request->isMethod("POST")) {
            $data = $request->all();
            if ($data['password'] == null) {
                $validator = Validator::make($data, [
                    'name' => 'required',
                    'email' => 'required|email|unique:users,email,' . $user->id,
                    'phone' => 'required|min:11|unique:users,phone,' . $user->id,
                    'role' => 'required'
                ]);
            } else {
                $validator = Validator::make($data, [
                    'name' => 'required',
                    'email' => 'required|email|unique:users,email,' . $user->id,
                    'phone' => 'required|min:11|unique:users,phone,' . $user->id,
                    'password' => 'required|min:6',
                    'role' => 'required'
                ]);
            }

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            $update_user_date = [
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'password' => $data['password']
            ];

            $update_user_date = array_filter($update_user_date);

            $result = User::where('id', '=', $user->id)->where('deleted_at', '=', null)
                ->update($update_user_date);
            if ($request) {
                DB::table('model_has_roles')
                    ->where('model_id', '=', $user->id)
                    ->update(['role_id' => $data['role']]);
                $status = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>' . $data['name'] . '</strong> successfully updated.
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                    </div>';
                return redirect()->route('admin.view-user')->with('status', $status);
            } else {
                $status = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                      Something Went wrong.
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                    </div>';
                return redirect()->back()->with('status', $status)->withInput();
            }
        }
        return view('admin.user.edit_user', compact('user', 'role'));
    }



    /*
     * admin will set permission to each role
     *
     * */

    protected function set_permission_by_admin(Request $request){
        $role = PublicFunction::get_all_role();
        $permission = PublicFunction::get_all_permission();
        if($request->isMethod("POST")){
//            return $request->all();
            $input_array = [
                'role_id' => $request->post('role'),
                'permission_id' => $request->post('permission'),
            ];

            $validator = Validator::make($input_array,[
                'role_id' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
//            return $input_array;
            try{
                $role_id = $input_array['role_id'];
                $permissions = $input_array['permission_id'];
                $role = Role::find($role_id);
                $role->syncPermissions($permissions);
                $status = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Permission</strong> successfully updated.
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                        </div>';
                return redirect()->back()->with('status', $status);

            }catch(QueryException $e){
                $status = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                          Something Went wrong.
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                        </div>';
                return redirect()->back()->with('status', $status)->withInput();
            }
        }
        return view('admin.permission.update_permission', compact('role', 'permission'));
    }


    public function get_permission_by_role(Request $request){
        if ($request->isMethod('post')){
            $role_id = $request->post('role_id');
            $permission = PublicFunction::get_role_to_permission($role_id);
            return $permission;
        }
    }
}
