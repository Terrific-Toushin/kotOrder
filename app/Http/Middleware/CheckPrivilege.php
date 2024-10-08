<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class CheckPrivilege
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $privileges)
    {
        $privileges = explode("|",$privileges);
        if($request->session()->exists('loginUserPrivileges')){
            $currentUser = $request->session()->get('loginUserPrivileges');
            $currentUser = str_replace(['[', ']','"'], '', $currentUser);
            $userPrivileges = explode(",",$currentUser);
            if(!empty(Auth::user()->PropertyID)){
                $dbDateGet = DB::connection('sqlsrv')->table('tbldate')->where('PropertyID','=',Auth::user()->PropertyID)->first();
            }else{
                $dbDateGet = DB::connection('sqlsrv')->table('tbldate')->first();
            }

            $dbDateOnly = mb_substr($dbDateGet->SDATE, 0, 10);
            $dbDate = date("d-m-Y", strtotime($dbDateOnly));
            session()->put('dbDate',$dbDate);
//            dump($currentUser);
//            dump($userPrivileges);
//            dump(in_array("*",$userPrivileges));
//            die();
            if(in_array("*",$userPrivileges)){
                return $next($request);

            }else if(!empty($userPrivileges)){
                foreach($userPrivileges as $pre){
                    $pre = trim($pre);
                    if(in_array($pre,$privileges)){
                        return $next($request);
                    }
                }
            }
        }
        return redirect('/login');
//        return $next($request);
    }
}
