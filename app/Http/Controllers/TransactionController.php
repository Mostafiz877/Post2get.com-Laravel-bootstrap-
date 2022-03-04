<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bid;
use App\Usertran;
use App\Customertran;
use App\Post;
use Carbon\Carbon;
use App\Transaction;
use Auth;
use App\Customer;
use Session;


class TransactionController extends Controller
{
	public function bidAccept(Request $request)
	{
		$bid_id=$request->bid_id;
		$bid_information=Bid::findOrFail($bid_id);
		$post_id=$bid_information->post_id;


			if(Auth::check())
			{

		    $user = auth()->user();
		    $auth_user_id=$user->id;
		    $user_id=Post::find($post_id)->user_id;

		    if($auth_user_id==$user_id){


	        
	        $customer_id=$bid_information->customer_id;


	    Post::find($post_id)->update([

	        'status'=>1,

	    ]);


				Transaction::insert([
			        
				     'user_id'=>$user_id,
				     'customer_id'=>$customer_id,
				     'bid_id'=>$bid_id,
				     'post_id'=>$post_id,
				     //'created_at'=> Carbon::now('Asia/Dhaka')
				     'created_at'=> Carbon::now(),
				]);

		    return  back()->with('status','Bid accepted Successfully');

			}else
			{
				return redirect()->route('root');
			}

			}else
			{
				return redirect()->route('root');
			}

	}

	public function history()
	{
		if(Auth::check())
		{
			
	    $user = auth()->user();
	    $user_id=$user->id;

	    //$accepted_bids=Usertran::where('user_id',$user_id)->where('status',0)->get();
	    $accepted_bids=Transaction::where('user_id',$user_id)->where('user_delete',0)->orderBy('created_at', 'desc')->get();

	    return view('user/history',compact('accepted_bids'));

		}else
		{
			return redirect()->route('root');
		}


	}



	public function accepted()
	{
		
		if (Auth::guard('customer')->user())
		{


		$customer_id=Auth::guard('customer')->user()->id;

		Transaction::where('customer_id',$customer_id)->where('seen_or_unseen',0)->update([

		    'seen_or_unseen'=>true,
		]);

		$accepted_bids=Transaction::where('customer_id',$customer_id)->where('customer_delete',0)->orderBy('created_at', 'desc')->get();
		return view('customer/accepted',compact('accepted_bids'));
	    }
	    else
	    {
	    	return redirect()->route('root');
	    }

	}

	public function workdone($id)
	{

		$upadte_status=Transaction::findOrFail($id);


		$upadte_status->update([

		    'status'=>1,
		]);

		return back();
	}

	public function delete_history(Request $request)
	{
		if(Auth::check())
		{


			Transaction::find($request->transaction_id)->update([

			    'user_delete'=>true,
			]);

			return back()->with('status',"Deleted Successfully");

			
			// $history_delete = Transaction::findOrFail($request->transaction_id);

			// if($history_delete->customer_delete==1)
			// {
			// 	$history_delete->delete();
			// 	return back()->with('status',"Deleted Successfully");

			// }else
			// {

			//     Transaction::find($request->transaction_id)->update([

			//         'user_delete'=>true,
			//     ]);

			//     return back()->with('status',"Deleted Successfully");

			// }



			
		}
		else
		{
			return redirect()->route('root');
		}
	}


	public function delete_customer_history(Request $request)
	{
		$user_or_customer_status=Session::get('user_or_customer_status');

		if (Auth::guard('customer')->user() && ($user_or_customer_status==2))
		{
			//$history_delete = Transaction::findOrFail($request->transaction_id);


			Transaction::find($request->transaction_id)->update([

			    'customer_delete'=>true,
			]);

			return back()->with('status',"Deleted Successfully");


			// if($history_delete->user_delete==1)
			// {
			// 	$history_delete->delete();
			// 	return back()->with('status',"Deleted Successfully");

			// }else
			// {

			//     Transaction::find($request->transaction_id)->update([

			//         'customer_delete'=>true,
			//     ]);

			//     return back()->with('status',"Deleted Successfully");

			// }



			
		}
		else
		{
			return redirect()->route('root');
		}

	}


}
