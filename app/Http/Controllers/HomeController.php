<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }



    
    public function in()
    {


        echo "string";
        // if (Auth::user()){

        //        return view('home');

        //    }else{
        //        return view('welcome');
        //    }
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */




}
