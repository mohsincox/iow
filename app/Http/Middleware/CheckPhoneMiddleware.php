<?php

namespace App\Http\Middleware;

use Closure;
use  App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckPhoneMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::user()) {
            $customer = DB::table('model_has_roles')
                ->join('roles','roles.id','=','model_has_roles.role_id')
                ->where('model_has_roles.model_id','=',auth()->id())
                ->select('roles.name')
                ->first();
            if (isset($customer) && strtolower($customer->name)== 'customer'){
                if (User::where('id', '=', auth()->id())->whereNull('phone')->first()) {
                    return redirect('/');
                }
            }
        }
        return $next($request);
    }
}
