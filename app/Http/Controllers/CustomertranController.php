<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\Customertran;
use Auth;

class CustomertranController extends Controller
{
    public function accepted()
    {

    	$customer_id=Auth::guard('customer')->user()->id;
    	//$accepted_bids=Customertran::where('customer_id',$customer_id)->where('status',0)->where('status',0)->get();
    	$accepted_bids=Customertran::where('customer_id',$customer_id)->get();

    	return view('customer/accepted',compact('accepted_bids'));
    }

    public function workdone($id)
    {

    	$upadte_status=Customertran::findOrFail($id);


    	$upadte_status->update([

    	    'status'=>1,
    	]);

    	return back();
    }
}
