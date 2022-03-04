<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Carbon\Carbon;
use App\Category;
use App\Customer;
use App\Comment;
use App\Bid;
use App\Useradd;

use Auth;
use Session;

class PostController extends Controller
{

    public function commentEditUpdate(Request $request)
    {


        $request->validate([

        'comment'=>'required',
        
        ]);

        Comment::find($request->comment_id)->update([

            'comment_content'=>$request->comment,
        ]);

         return redirect()->route('viewpost',$request->post_id)->with('status','Comment Updated');
    }




    public function commentEdit($comment_id)
    {

     $user_or_customer_status=Session::get('user_or_customer_status');
     $comment=Comment::findOrFail($comment_id);
     
    


     if (Auth::guard('customer')->user()){

        $customer_id=Auth::guard('customer')->user()->id;

        if($user_or_customer_status==2 && ($comment->commenter_id==$customer_id))
        {
            return view('customer/edit_customer_comment',compact('comment'));
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

    public function commentDelete($id)
    {
      $user_or_customer_status=Session::get('user_or_customer_status');


      if (Auth::guard('customer')->user()){

        $comment_delete = Comment::findOrFail($id);
        $customer_id=Auth::guard('customer')->user()->id;

        if($user_or_customer_status==2 && ($comment_delete->commenter_id==$customer_id))
        {
          $comment_delete->delete();
          return back()->with('status','Comment Deleted');
        }else
        {
          return redirect()->route('root');
        }

      }else
      {
        return redirect()->route('root');
      }
      
      }




    public function customerviewpost($post_id)
    {
       // orderBy('created_at', 'desc')->paginate(2);
        
      //$flight = App\Flight::where('number', 'FR 900')->first();
      //
      //
      // //CabRes::where('m__Id', 46)
      // ->where('t_Id', 2)
      // ->whereIn('Cab', $cabIds)
      // ->get();
        

        //return $post->setRelation('comments',$post->customer_comments()->orderBy('created_at', 'desc')->paginate(2));


        $user_or_customer_status=Session::get('user_or_customer_status');

        if (Auth::guard('customer')->user() && ($user_or_customer_status==2)){


           $customer=Auth::guard('customer')->user()->id;
           $single_post=Post::findOrFail($post_id);
           $comments=Post::find($post_id);

           $bids=Bid::where('post_id',$post_id)->orderBy('created_at', 'desc')->get();
           $bid_check=Bid::where('post_id',$post_id)->where('customer_id',$customer)->first();
           
           $comments->setRelation('comments',$comments->customer_comments()->orderBy('created_at', 'desc')->paginate(10));
           
           return view('customer/customer_view_post',compact('single_post','comments','customer','bids','bid_check'));

        }else
        {
            return redirect()->route('root');

        }


    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        $user_id=$user->id;

        $user_address=Useradd::where('user_id',$user_id)->first();

        if(($user_address->phone==null)||(($user_address->current_location==null)))
        {
            return back()->with('status','Please set your phone and current location in profile at first');
        }
        else
        {
            $request->validate([

            'category_id'=>'required',
            'content'=>'required',
            'post_amount'=>'required',
            
            ]);

            // return $request->all();
            
            $user = auth()->user();

             Post::insert([
                 'category_id'=>$request->category_id,
                 'user_id'=>$user->id,
                 'content'=>$request->content,
                 'post_amount'=>$request->post_amount,
                 //'created_at'=> Carbon::now('Asia/Dhaka')
                 'created_at'=> Carbon::now(),
            ]);

            return back()->with('status','Post created Successfully');

        }




    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($post_id)
    {
        
        if(Auth::check()){

        $post_informations=Post::findOrFail($post_id);
        $user = auth()->user();
        $user_id=$user->id;

                if(($user_id==$post_informations->user_id)){

                 $post_informations->user_id;
                 $categories=Category::all();
                 return view('user/editPost',compact('categories','post_informations'));
                 }
                 else
                 {
                    return redirect()->route('root');
                 }

         }
         else
         {
            return redirect()->route('root');
         }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([

        'category_id'=>'required',
        'content'=>'required',
        'post_amount'=>'required',
        
        ]);

        Post::find($request->post_id)->update([

            'category_id'=>$request->category_id,
            'content'=>$request->content,
            'post_amount'=>$request->post_amount,

        ]);

        return back()->with('status','Post Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Post::where('id',$request->post_id)->delete();
        return back()->with('status','Post deleted Successfully');
    }

    public function s()
    {
        echo "string";
    }
}
