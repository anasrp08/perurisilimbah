<?php
namespace App\Helpers;
use DateTime; 
use Illuminate\Support\Str; 
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\File; 
use App\Helpers\AppHelper;
use Redirect;
use Validator;
use Response;
use DB;
use PDF;
class AuthHelper
{
     
    public static function getAuthUser(){
        $getUserid = auth()->user()->id;
        
        if (!Auth::check()) {
           
            return redirect()->route('login');
        }else{
            $getUserid = auth()->user()->id;
           
            return $getRoleUser=DB::table('users')->join('role_user', 'role_user.user_id', '=', 'users.id')
       ->where('users.id', $getUserid)
      
       ->get();
        }

    }
     
}