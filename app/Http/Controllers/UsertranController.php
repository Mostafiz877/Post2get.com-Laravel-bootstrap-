<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bid;
use App\Usertran;
use App\Customertran;
use App\Post;
use Carbon\Carbon;
use Auth;

class UsertranController extends Controller
{
    public function bidAccept($bid_id)
    {
    	$bid_information=Bid::findOrFail($bid_id);

    	$post_id=$bid_information->post_id;
        $user_id=Post::find($post_id)->user_id;
        $customer_id=$bid_information->customer_id;


        Post::find($post_id)->update([

            'status'=>1,

        ]);


    	 Usertran::insert([
            
    	     'user_id'=>$user_id,
    	     'bid_id'=>$bid_id,
    	     'post_id'=>$post_id,
    	     //'created_at'=> Carbon::now('Asia/Dhaka')
    	     'created_at'=> Carbon::now(),
    	]);


          Customertran::insert([


              'customer_id'=>$customer_id,
              'bid_id'=>$bid_id,
              'post_id'=>$post_id,
              'created_at'=> Carbon::now(),
         ]);








    }

    public function history()
    {
        $user = auth()->user();
        $user_id=$user->id;

        $accepted_bids=Usertran::where('user_id',$user_id)->where('status',0)->get();

        return view('user/history',compact('accepted_bids'));
    }
}
