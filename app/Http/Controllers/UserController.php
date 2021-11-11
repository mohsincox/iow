<?php

namespace App\Http\Controllers;

use App\Mail\ForgotPassword;
use App\Rules\Captcha;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Socialite;
use Spatie\Permission\Models\Role;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Str;


class UserController extends Controller{

    /*
     * register function
     * */
    public function sign_up(Request $request){
        if(Auth::user() == null) {
            if ($request->isMethod('POST')) {
                $input_array = [
                    'name' => $request->post('name'),
                    'email' => $request->post('email'),
                    'phone' => $request->post('phone'),
                    'password' => $request->post('password'),
                    'confirm_password' => $request->post('confirm_password')
                ];

                $validator = Validator::make($input_array, [
                    'name' => 'required',
                    'email' => 'required|email|unique:users',
                    'phone' => 'required|min:11|unique:users',
                    'password' => 'required|min:6',
                    'confirm_password' => 'required|same:password|min:6',
                ]);

                if ($validator->fails()) {
                    return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
                }
                try {
                    $user = User::create([
                        'name' => $input_array['name'],
                        'phone' => $input_array['phone'],
                        'email' => $input_array['email'],
                        'password' => Hash::make($input_array['password'])
                    ]);
                    $role = Role::find(3);
                    $user->assignRole($role);
                    Auth::login($user);
                    return redirect()->route('index');
                } catch (QueryException $e) {
                    $status = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                          Something Went wrong.
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                        </div>';
                    return redirect()->back()->with('status', $status)->withInput();
                }
            }
            return view('site.register');
        }
        return redirect()->route('index');
    }

    /*
     * customer login
     *
     * */
    public function customer_login(Request $request){
        if(Auth::user() == null) {
            if ($request->isMethod('post')) {
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
                        return redirect(route('index'));
                    } else {
                        Auth::logout();
                        $status = '<div class="alert alert-warning  fade show" role="alert">
                                    You can not login.
                        </div>';
                        return redirect()->back()->with('status', $status)->withInput();
                    }
                } else {
                    $status = '<div class="alert alert-danger  fade show" role="alert">
                                    Wrong email or password ! Please try again.
                        </div>';
                    return redirect()->back()->with('status', $status)->withInput();
                }
            }
            return view('site.login');
        }
        return redirect()->route('index');
    }

    /*
     * Admin login
     *
     * */
    public function admin_login(Request $request){
        if(Auth::user() == null) {
            if ($request->isMethod('post')) {
                $validator = Validator::make($request->all(), [
                    'email' => 'required',
                    'password' => 'required|min:6',
                    // 'g-recaptcha-response' => new Captcha()
                ]);
                if ($validator->fails()) {
                    return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
                }
                $data = $request->all();


                if (Auth::attempt(['email' => $data['email'], 'password' => $data['password'], 'status' => 'Active'])) {
                    $data = DB::table('model_has_roles')
                        ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                        ->select('roles.id as role_id', 'roles.name as role')
                        ->where('model_has_roles.model_id', Auth::user()->id)
                        ->get();

                    if ($data[0]->role_id == 2 || $data[0]->role_id == 1) {
                        return redirect()->route('admin.dashboard')->with('role', $data[0]);
                    } else {
                        Auth::logout();
                        $status = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            You can not login.
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                    </div>';
                        return redirect()->back()->with('status', $status)->withInput();
                    }
                } else {
                    $status = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                      Invalid User.
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                    </div>';
                    return redirect()->back()->with('status', $status)->withInput();
                }
            }
            return view('admin.admin_login');
        }
        return redirect()->route('index');
    }

    #logout
    public function logout(){
        Auth::logout();
        $status = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                      Logout successful.
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                    </div>';
        return redirect(route('index'))->with('status', $status);
    }


    /**
     * forgot_password method
     * check the user email and send reset link to the email
     * @param $email string
     */
    public function forgot_password(Request $request){

        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'email' => 'required',
            ]);
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            $data = $request->all();
            // getting Domain Name
            $url = URL::to('/');
            $length = strpos($url, '/', 8);
            $domainName = substr($url, 0, $length);

            $user = User::select('id')->where('email', $data['email'])->first();
            if ($user) {
                // make random string
                $token = Str::random(120);
                $result = DB::table("password_resets")
                    ->updateOrInsert(
                        ['email' => $data['email']],
                        [
                            'token' => $token,
                            'created_at' => \Carbon\Carbon::now()
                        ]
                    );

                if ($result) {
                  try{
                    Mail::to($data['email'])->send(new ForgotPassword($domainName."/reset-password/".$token));
                  } catch (Exception $ex) {

                  }
//                    return "hello";
                    $status = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                Please check your email.
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                    </div>';
                    return redirect()->back()->with('status', $status);
                }
                $status = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                        Some thing went wrong.
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                    </div>';
                return redirect()->back()->with('status', $status)->withInput();
            }
            $status = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                          Invalid User.
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                        </div>';
            return redirect()->back()->with('status', $status)->withInput();
        }else{
            return view('admin.forgot_password');
        }

        return view('admin.forgot_password');
    }

    public function reset_password(Request $request, $token){
        if($request->isMethod('POST')){
            $data = $request->all();
//            return $data;
            $validToken =  DB::table("password_resets")->select('email')->where('token', $token)
                ->pluck('email');
//            return $validToken;
            $validator = Validator::make($data,[
                'new_password' => 'required|min:6',
                'confirm_password' => 'required|same:new_password|min:6',
                ]);
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            if(!empty($validToken)){
                $result = User::where('email', '=', $validToken)
                    ->update(['password' => Hash::make($data['new_password'])]);

                if( $result ){
                    DB::table("password_resets")
                        ->updateOrInsert(
                            ['email' => $validToken],
                            ['token' => ""]
                        );
                    $role = DB::table('users')
                        ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
                        ->select('model_has_roles.role_id')
                        ->where('users.email', '=', $validToken)
                        ->get();

                    if($role[0]->role_id == 3){
                        // go to customer login page
                    }else{
                        return redirect()->route('admin.login');
                    }
                }else{
                    $status = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                          Something went to wrong
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                        </div>';
                    return redirect()->back()->with('status', $status)->withInput();
                }
            }
            $status = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                          No email found
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                        </div>';
            return redirect()->back()->with('status', $status)->withInput();
        }
        return view('reset_password')->with('token', $token);
    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToGoogleProvider() {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleGoogleProviderCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();
        $user = User::where('email', '=', $googleUser->email)
            ->where('provider', '=', 'Google')
            ->where('provider_id', '=', $googleUser->id)
            ->first();
        if($user == null){
            $newUser = new User();
            $newUser->name = $googleUser->name;
            $newUser->email = $googleUser->email;
            $newUser->provider = "Google";
            $newUser->provider_id = $googleUser->id;
            $newUser->status = "Active";
            if($newUser->save()){
                $role = Role::find(3);
                $newUser->assignRole($role);
                Auth::login($newUser);
            }
        }else{
            Auth::login($user);
        }
        return redirect(route('index'));
    }

    /**
     * Redirect the user to the Facebook authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToFacebookProvider() {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from Facebook.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleFacebookProviderCallback(Request $request) {
        if($request->has('error_code')){
            return redirect()->route('index');
        }
        $facebookUser = Socialite::driver('facebook')->stateless()->user();
        $user = User::where('email', '=', $facebookUser->email)
            ->where('provider', '=', 'Facebook')
            ->where('provider_id', '=', $facebookUser->id)
            ->first();
        if($user == null){
            $newUser = new User();
            $newUser->name = $facebookUser->name;
            $newUser->email = $facebookUser->email;
            $newUser->provider = "Facebook";
            $newUser->provider_id = $facebookUser->id;
            $newUser->status = "Active";
            if($newUser->save()){
                $role = Role::find(3);
                $newUser->assignRole($role);
                Auth::login($newUser);
            }
        }else{
            Auth::login($user);
        }
        return redirect(route('index'));
    }

    public function upload_user_photo(Request $request){
        if($request->isMethod("POST")){
//            return "hello";
            if ($request->hasFile('file_upload')) {
                // Validation for image
                $validator = Validator::make($request->all(), [
                    'file_upload' => 'mimes:jpeg,bmp,png,jpg,gif'
                ]);
              if ($validator->fails()) {
                return redirect()->back()
                  ->withErrors($validator);
              }
                $image = $request->file('file_upload');
                $name = time().'.'.$image->getClientOriginalExtension();
                $path = '/users_images/';
                $destinationPath = public_path($path);
                $image->move($destinationPath, $name);
            }
            $user_image = '';
            if(isset($name)){
                $user_image = $path.$name;
            }
            if($user_image != ''){
              $old_image = Auth::user()->image;
                if(User::whereNull('deleted_at')->where('id', '=', Auth::user()->id)->update(['image'=>$user_image])){
                  //              deleting image
                  $old_image_path = public_path($old_image);
                  if (file_exists($old_image_path)) {
                    @unlink($old_image_path);
                  }
                }
            }
            return redirect()->back();
        }
    }

    /*
     * customer can change password
     * */
    public function customer_change_password(Request $request)
    {
//        return $request;
        if ($request->isMethod("POST")) {
            $validator = Validator::make($request->all(), [
                'old_password' => 'required|min:6',
                'new_password' => 'required|min:6',
                'confirm_password' => 'required|min:6|same:new_password',
            ]);
            if ($validator->fails()) {
//                return $validator->messages();
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            $user = User::where('id', '=', Auth::id())->whereNull('provider')->get();
            if (count($user) > 0) {
                if (Auth::guard('web')->attempt(['id' => Auth::id(), 'password' => $request->post('old_password')])) {
                    $new_password = $request->post('new_password');
                    User::where('id', '=', Auth::id())->update(['password' => Hash::make($new_password)]);
                    $status = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                          Successfully password changed.
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                        </div>';
                    return redirect()->back()->with('status', $status);
                } else {
                    $status = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                          Something went to wrong.
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                        </div>';
                    return redirect()->back()->with('status', $status)->withInput();
                }
            }
            $status = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                          Sorry, You can not change your password.
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                        </div>';
            return redirect()->back()->with('status', $status);

        }
    }


    public function customer_edit_info(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'. auth()->id(),
            'phone_number' => 'required|unique:users,phone,'. auth()->id(),
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $data = $request->all();
        $update= [
            'name'=> $data['name'],
            'email'=> $data['email'],
            'phone'=> $data['phone_number']
        ];
        $cus_update = User::where('id', auth()->id())->update($update);
        if ($cus_update){
            $status = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                Profile Update Successfully
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                    </div>';
            return redirect()->back()->with('status', $status);
        }else{
            $status = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                Something went wrong !! Try again
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                    </div>';
            return redirect()->back()->with('status', $status);
        }

    }


  /**
   * @param Request $request
   * @return $this
   */
    public function customer_update_phone(Request $request){
        $validator = Validator::make($request->all(), [
            'phone' => 'required|min:11',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $data = $request->all();
        $update= [
            'phone'=> $data['phone'],
        ];
        $cus_update = User::where('id', auth()->id())->update($update);
        if ($cus_update){
            return "Success";
        }

    }

}
