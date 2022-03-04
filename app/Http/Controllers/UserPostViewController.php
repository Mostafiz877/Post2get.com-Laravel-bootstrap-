<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Post;
use App\Comment;
use App\Bid;
use Session;
use Carbon\Carbon;
class UserPostViewController extends Controller
{


    public function userCommentUpdate( Request $request)
    {

        $request->validate([

        'comment'=>'required',
        
        ]);

        Comment::find($request->comment_id)->update([

            'comment_content'=>$request->comment,
        ]);

         return redirect()->route('viewSingleUserPost',$request->post_id)->with('status','Comment Updated');


     }

    public function editUserComment($comment_id)
    {
        $user_or_customer_status=Session::get('user_or_customer_status');
        $comment=Comment::findOrFail($comment_id);
        
        


        if (Auth::check()){

            $user = auth()->user();
            $user_id=$user->id;

           if($user_or_customer_status==1 && ($comment->commenter_id==$user_id))
           {
               return view('user/edit_user_comment',compact('comment'));
           }
           else
           {
               return redirect()->route('home');
           }

        }
        else
        {

        }
           return redirect()->route('login');
    }




    public function deleteUserComment($id)
    {


        $user_or_customer_status=Session::get('user_or_customer_status');
        $comment_delete = Comment::findOrFail($id);
        $user = auth()->user();
        $user_id=$user->id;


        if (Auth::check()){

          if($user_or_customer_status==1 && ($comment_delete->commenter_id==$user_id))
          {
            $comment_delete->delete();

            return back()->with('status','Comment Deleted');
          }else
          {
            return redirect()->route('home');
          }

        }else
        {
          return redirect()->route('login');
        }
        


    }



    public function userComment(Request $request)
    {



         $user_or_customer_status=Session::get('user_or_customer_status');
         $user = auth()->user();
         $user_id=$user->id;
         

         $request->validate([
         'comment_content'=>'required|max:255',
         ]);


         Comment::insert([

             'commenter_id'=>$user_id,
             'post_id'=>$request->post_id,
             'user_or_customer'=>$user_or_customer_status,
             'comment_content'=>$request->comment_content,
             //'created_at'=> Carbon::now('Asia/Dhaka')
             'created_at'=> Carbon::now(),
        ]);

         return back()->with('status','Comment Added');
    }



    public function viewSingleUserPost($post_id)
    {

    	
    	// $user_or_customer_status=Session::get('user_or_customer_status');

    	if(Auth::check()){

           $user = auth()->user();
    	   $user_id=$user->id;
    	   $single_post=Post::findOrFail($post_id);

           if($single_post->user_id==$user_id){

    	   $comments=Post::find($post_id);

    	   $bids=Bid::where('post_id',$post_id)->orderBy('created_at', 'desc')->get();
    	   
    	   $comments->setRelation('comments',$comments->customer_comments()->orderBy('created_at', 'desc')->paginate(10));
    	   
    	   return view('user/user_view_post',compact('single_post','comments','user_id','bids'));

           }else
           {
              return redirect()->route('root');
           }

    	}else
    	{
    	    return redirect()->route('root');

    	}
    	return view('user/user_view_post');
    }

}
