<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSettingController extends Controller
{

    public function change_password(Request $request){
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'oldpassword' => 'required|min:6',
                'newpassword' => 'required|min:6',
                'confirm_password' => 'required|same:newpassword|min:6'

            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            $user = Auth::user();
            if ($user['password'] = $request->post('oldpassword')) {
                $user->password = Hash::make($request->post('confirm_password'));
                if ($user->save()){
                    $status = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                              Change Password Successfully.
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                        </div>';
                    return redirect()->back()->with('status', $status);
                }else{
                    $status = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                              Something went to wrong.
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                        </div>';
                    return redirect()->back()->with('status', $status)->withInput();
                }
            }
            else{
                $status = '<div class="alert alert-danger">Old Password  does not match</div>';
                return  redirect()->back()->with('status', $status);
            }

        }
        return view('admin.setting.change_password');
    }

    /** change profile */

}
