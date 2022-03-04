<?php

namespace App\Http\Controllers;

use Auth;
use Session;
use App\Post;
Use App\Customeradd;
Use App\Bid;
use Carbon\Carbon;
use Image;

use Illuminate\Http\Request;

class BidController extends Controller
{

	public function editBidUpdate(Request $request)
	{


		$request->validate([

		'bid_comment'=>'required',
		'bid_amount'=>'required|numeric',
		
		]);

		Bid::find($request->bid_id)->update([

		    'bid_comment'=>$request->bid_comment,
		    'bid_amount'=>$request->bid_amount,
		]);

		 return redirect()->route('viewpost',$request->post_id)->with('status','Bid Updated');

	}


	public function editBid($id)
	{

		$user_or_customer_status=Session::get('user_or_customer_status');
		$bid=Bid::findOrFail($id);
		
		


		if (Auth::guard('customer')->user()){

		   $customer_id=Auth::guard('customer')->user()->id;

		   if($user_or_customer_status==2 && ($bid->customer_id==$customer_id))
		   {
		       return view('customer/edit_customer_bid',compact('bid'));
		   }
		   else
		   {
		       return redirect()->route('root');
		   }

		}
		else
		{

		}
		   return redirect()->route('root');
	}

	public function createBid(Request $request)
	{
		$customer_id=Auth::guard('customer')->user()->id;

		$customer_address=Customeradd::where('customer_id',$customer_id)->first();

		if(($customer_address->phone==null)||(($customer_address->current_location==null)))
		{
		    return back()->with('status','Please set your phone and current location in profile before bid');
		}
		else
		{
			 $user_or_customer_status=Session::get('user_or_customer_status');
			 $commenter_id=Auth::guard('customer')->user()->id;
			 

			 $request->validate([

			 'bid_comment'=>'required|max:255',
			 'bid_amount'=>'required|numeric',

			 ]);


			 Bid::insert([

			     'customer_id'=>$commenter_id,
			     'post_id'=>$request->post_id,
			     'bid_amount'=>$request->bid_amount,
			     'bid_comment'=>$request->bid_comment,
			     //'created_at'=> Carbon::now('Asia/Dhaka')
			     'created_at'=> Carbon::now(),
			]);

			 return back()->with('status','Bid Added');

		}




	}

	public function deleteBid($id)
	{

		$user_or_customer_status=Session::get('user_or_customer_status');


		if (Auth::guard('customer')->user()){

		  $bid_delete = bid::findOrFail($id);
		  $customer_id=Auth::guard('customer')->user()->id;

		  if($user_or_customer_status==2 && ($bid_delete->customer_id==$customer_id))
		  {
		    $bid_delete->delete();
		    return back()->with('status','Bid  Deleted');
		  }else
		  {
		    return redirect()->route('root');
		  }

		}else
		{
		  return redirect()->route('root');
		}
		
	}
}
