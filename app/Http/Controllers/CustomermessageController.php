<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Pagination\LengthAwarePaginator;
use Session;
use App\Message;
Use Carbon\Carbon;
use App\Customer;
use Auth;
use DB;


class CustomermessageController extends Controller
{
    public function customer_message()
    {

    		$message_list=array();
    		$customer_id=Auth::guard('customer')->user()->id;
    		$message=Message::where('sender_id',$customer_id)->where('sender_status',2)->orWhere('receiver_id',$customer_id)->where('receiver_status',2)->orderBy('created_at','DESC')->get();
    		// $message=Message::groupBy('sender_id','sender_status','receiver_id','receiver_status')->get();
    		$key=0;

    		foreach ($message as  $value) {

    			

    			if($value->sender_id==$customer_id && $value->sender_status==2)
    			{
    				// $message_list[$key]=$value->receiver_id;
                    $message_list[$key]=array('status'=>$value->receiver_status,'id'=>$value->receiver_id);
    			}
    			elseif($value->receiver_id==$customer_id && $value->receiver_status==2)
    			{
    	            // $message_list[$key]=$value->sender_id;
                    $message_list[$key]=array('status'=>$value->sender_status,'id'=>$value->sender_id);
    			}

    			$key++;

    		    	}



                        
                    function multi_unique($src){
                         $output = array_map("unserialize",
                         array_unique(array_map("serialize", $src)));
                       return $output;
                    }

                     
            $unique_message_list=multi_unique($message_list);

    	
            // return $unique_message_list=array_unique(array_column($message_list, 'id','status'));





    		return view('customer.customer_message',compact('unique_message_list','customer_id'));
    }


    public function view_individual_customer_message($id,$status,Request $request)
    {

      // here $id=sender id
    if(Auth::guard('customer')->user())
    {
         $customer_id=Auth::guard('customer')->user()->id;

        Message::where('receiver_status',2)->where('receiver_id',$customer_id)->where('sender_id',$id)->where('sender_status',$status)->update([

                 'seen_or_unseen'=>true,
             ]);


         if($status==1)
         {

         
         $messages=DB::select("SELECT * FROM messages WHERE ((sender_id='$customer_id' AND sender_status=2) or (receiver_id='$customer_id' AND receiver_status=2)) AND ((sender_id='$id' AND sender_status=1) or (receiver_id='$id' AND receiver_status=1)) order by created_at DESC");
            

         $messages = $this->arrayPaginator($messages, $request);

             return view('customer.view_individual_customer_message',compact('messages','status','id'));


         }elseif($status==2)
         {
         
         $messages=DB::select("SELECT * FROM messages WHERE (sender_id='$customer_id' or receiver_id='$customer_id') AND (sender_id='$id' or receiver_id='$id') AND sender_status=2 AND receiver_status=2 order by created_at DESC");

         $messages = $this->arrayPaginator($messages, $request);
         return view('customer.view_individual_customer_message',compact('messages','status','id'));

         }

    }else
    {
        return redirect()->route('root');
    }


    }


    public function arrayPaginator($array, $request)
    {
        $page = Input::get('page', 1);
        $perPage = 5;
        $offset = ($page * $perPage) - $perPage;

        return new LengthAwarePaginator(array_slice($array, $offset, $perPage, true), count($array), $perPage, $page,
            ['path' => $request->url(), 'query' => $request->query()]);
    }
}
