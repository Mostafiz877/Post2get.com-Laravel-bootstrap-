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

class MessageController extends Controller
{

    public function store(Request $request)
    {
        if(Auth::check() or Auth::guard('customer')->user())
        {
                if(Auth::check())
                {
                    $sender_id=auth()->user()->id;
                    $sender_status=$user_or_customer_status=Session::get('user_or_customer_status');
                    $receiver_id=$request->receiver_id;
                    $receiver_status=$request->receiver_status;
                }
                else if(Auth::guard('customer')->user())
                {

                     $sender_id=Auth::guard('customer')->user()->id;
                    $sender_status=$user_or_customer_status=Session::get('user_or_customer_status');
                    $receiver_id=$request->receiver_id;
                    $receiver_status=$request->receiver_status;
                }


                $request->validate([

                'message_content'=>'required',

                ]);

                 Message::insert([
                     'sender_id'=>$sender_id,
                     'sender_status'=>$sender_status,
                     'receiver_id'=>$receiver_id,
                     'receiver_status'=>$receiver_status,
                     'message_content'=>$request->message_content,

                     //'created_at'=> Carbon::now('Asia/Dhaka')
                     'created_at'=> Carbon::now(),
                ]);

                 // return back();
                 return back()->with('status','Message Sent');

        }else
        {
              return redirect()->route('root');
        }
    }



    public function showallmessageUser()
    {
        if (Auth::check()) {

                $message_list=array();
                $user_id=auth()->user()->id;
                $message=Message::where('sender_id',$user_id)->where('sender_status',1)->orWhere('receiver_id',$user_id)->where('receiver_status',1)->orderBy('created_at','DESC')->get();
                // $message=Message::groupBy('sender_id','sender_status','receiver_id','receiver_status')->get();
                $key=0;
                foreach ($message as  $value) {

                    if($value->sender_id==$user_id && $value->sender_status==1)
                    {
                        $message_list[$key]=$value->receiver_id;
                    }
                    elseif($value->receiver_id==$user_id && $value->receiver_status==1)
                    {
                        $message_list[$key]=$value->sender_id;
                    }

                    $key++;

                        }

                 $unique_message_list=array_unique($message_list);



                return view('user.message',compact('unique_message_list','user_id'));

        }else
        {
            return redirect()->route('root');
        }


    }


    public function view_individual_message($customer_id,Request $request)
    {


        if(Auth::check())
        {
                $user_id=auth()->user()->id;

                Message::where('receiver_status',1)->where('receiver_id',$user_id)->where('sender_id',$customer_id)->where('sender_status',2)->update([

                    'seen_or_unseen'=>true,
                ]);

                 // $messages= Message::where('sender_id',$customer_id)->where('sender_status',2)->orWhere('receiver_id',$customer_id)->where('receiver_status',2)->get();
                 $messages=DB::select("SELECT * FROM messages WHERE ((sender_id='$user_id' AND sender_status=1) or (receiver_id='$user_id' AND receiver_status=1)) AND ((sender_id='$customer_id' AND sender_status=2) or (receiver_id='$customer_id' AND receiver_status=2)) order by created_at DESC");



                 $messages = $this->arrayPaginator($messages, $request);

                 return view('user.view_individual_message',compact('messages','user_id','customer_id'));

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
