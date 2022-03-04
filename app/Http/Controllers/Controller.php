<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Auth;
use Session;
use App\Customer;
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;



    public function root()
    {

        if(Auth::check()&& Session::get('user_or_customer_status')==1)
        {
            return redirect()->route('home');

        }else if( Auth::guard('customer')->user() && Session::get('user_or_customer_status')==2)
        {

            return redirect()->route('customer.home');
        }
        else
        {
            return view('welcome');
        }
        
    	        // if (!Auth::user()){

    	        //        

    	        //    }else{
    	            
    	        //        return redirect()->route('home');
    	        //    }



    }



    // public function logout()
    // {
    //     if(!Auth::check())
    //     {
    //          return redirect()->route('root');
    //     }
    // }
}
