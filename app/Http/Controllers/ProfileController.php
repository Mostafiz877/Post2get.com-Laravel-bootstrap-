<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\Customeradd;
use Auth;
use App\User;
use App\Useradd;
use Session;

class ProfileController extends Controller
{
	public function viewProfile($status,$id)
	{
	    $user_or_customer_status=Session::get('user_or_customer_status');



		if($status==1 || $status==2)
		{
			if($status==1)
			{
				if(Auth::check())
				{

					$user_id = auth()->user()->id;

					if($user_id==$id)
					{
						return redirect()->route('profile');
					}

				}
				else
				{
			    $information=User::findOrFail($id);
				$address=Useradd::findOrFail($id);
				return view('user.profile_view',compact('information','address','status','user_or_customer_status'));
				}
			}
			else if($status==2)
			{
				if(Auth::guard('customer')->user())
				{
					$customer_id=Auth::guard('customer')->user()->id;

					if($customer_id==$id)
					{
						return redirect()->route('customerProfile');
					}else
					{
						    $information=Customer::findOrFail($id);
							$address=Customeradd::findOrFail($id);
							return view('user.profile_view',compact('information','address','status','user_or_customer_status'));
					}

				}

				else
				{
			    $information=Customer::findOrFail($id);
				$address=Customeradd::findOrFail($id);
				return view('user.profile_view',compact('information','address','status','user_or_customer_status'));

				}
				
			}
		}else
		{
			return redirect()->route('root');
	     }

	}
}
