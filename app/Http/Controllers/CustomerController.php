<?php

namespace App\Http\Controllers;
use Auth;
use Session;
use App\Post;
use App\Category;
use App\Customer;
Use App\Customeradd;
Use App\Comment;
use Carbon\Carbon;
use Image;


use Illuminate\Http\Request;

class CustomerController extends Controller
{




  public function customerComment(Request $request)
  {
     $user_or_customer_status=Session::get('user_or_customer_status');
     $commenter_id=Auth::guard('customer')->user()->id;
     

     $request->validate([
     'comment_content'=>'required|max:255',
     ]);


     Comment::insert([

         'commenter_id'=>$commenter_id,
         'post_id'=>$request->post_id,
         'user_or_customer'=>$user_or_customer_status,
         'comment_content'=>$request->comment_content,
         //'created_at'=> Carbon::now('Asia/Dhaka')
         'created_at'=> Carbon::now(),
    ]);

     return back()->with('status','Comment Added');
  }


    public function categoryWisePost($category_id)
    {
      $user_or_customer_status=Session::get('user_or_customer_status');


      if (Auth::guard('customer')->user() &&($user_or_customer_status==2)){

      $categories=category::all();
      $posts = Post::where('category_id',$category_id)->where('status',0)->paginate(1);
      return view('customer.category_wise_post',compact('posts','categories'));

    }else
    {
      return redirect()->route('root');
    }
  }


    public function index()
    {
            $users[] = Auth::user();
            $users[] = Auth::guard()->user();
            $users[] = Auth::guard('customer')->user();

            if(!Session::has('user_or_customer_status'))
            {
             if(Auth::check())
             {
                 session(['user_or_customer_status' =>2]);
             }
            }

            if(Auth::guard('customer')->user())
            {

              $customer=Auth::guard('customer')->user()->id;
              $check_for_customer_address=1; //1 means phone or location is not set

                if(!Customeradd::where('customer_id', '=',$customer)->exists())
                {

                  Customeradd::insert([

                      //left side table field name || right side form field name
                      'customer_id'=>$customer,
                  ]);

                }

                $customer_address=Customeradd::where('customer_id',$customer)->first();

                if(($customer_address->phone==null)||(($customer_address->current_location==null)))
                {
                  $check_for_customer_address=0;//0 means phone or location is not set yet
                }
                
                $categories=category::all();
                $user_posts=Post::where('status',0)->orderBy('created_at', 'desc')->paginate(2);
                return view('customer.home',compact('user_posts','categories','check_for_customer_address'));
            }
            else
            {
                return redirect()->route('root');
            }
            

            //return $data = session()->all();

            //dd($users);
            /// $products=Post::paginate(10);
         

    }


    public function customerProfile()
    {

        if (Auth::guard('customer')->user()){

            
            $customer=Auth::guard('customer')->user()->id;
            $customer_information=Customer::find($customer, ['name','email']);

            // if(!Customeradd::where('customer_id', '=',$customer)->exists())
            // {

            //   Customeradd::insert([

            //       //left side table field name || right side form field name
            //       'customer_id'=>$customer,
            //   ]);

            // }

            $customer_address=Customeradd::where('customer_id', $customer)->get();
            $single_customer_address=$customer_address->first();

            return view('customer/customer_profile',compact('customer_information','single_customer_address'));



        }else
        {

          return redirect()->route('root');
        }
    }


    public function editCustomerProfile()
    {

        if(Auth::guard('customer')->user())
        {

          $customer=Auth::guard('customer')->user()->id;
          $customer_information=Customer::find($customer, ['name']);
          $customer_address=Customeradd::where('customer_id', $customer)->get();

          $single_customer_address=$customer_address->first();

          return view('customer.edit_customer_profile',compact('customer_information','single_customer_address'));

        }else
        {
           return redirect()->route('customerlogin');
        }

    }

    public function editCustomerProfileUpdate(Request $request)
    {

            $customer=Auth::guard('customer')->user()->id;

            if(Auth::guard('customer')->user())
            {
               $customer_address=Customeradd::where('customer_id', $customer)->get();

               $single_customer_address=$customer_address->first();

                $phone_from_database=$single_customer_address->phone;

               $phone_form_input=$request->phone;

               if($phone_from_database==$phone_form_input){


               $request->validate([

               'customer_name'=>'required',
               'phone'=>'required|digits:11',
               'current_location'=>'required',
               'created_at'=>Carbon::now(),
               ]);

              }else
              {
                
               $request->validate([

               'customer_name'=>'required',
               'phone'=>'required|digits:11|unique:customeradds',
               'current_location'=>'required',
               'created_at'=>Carbon::now(),
               ]);

              }



               if (Customeradd::where('customer_id', '=',$customer)->exists()) {


                   Customeradd::where('customer_id',$customer)->update([

                       'phone'=>$request->phone,
                       'current_location'=>$request->current_location,

                   ]);
                  


               }

               Customer::where('id',$customer)->update([

                       'name'=>$request->customer_name
               ]);


               if($request->hasFile('image'))
               {

                $customer_address=Customeradd::where('customer_id', $customer)->get();

                 
                 $image_from_database=$customer_address->first();




                if($image_from_database->image=='default.png')
                {

                      $photo_to_upload=$request->image;
                      $filename=$customer.".".$photo_to_upload->getclientoriginalextension();
                      
                      Image::make($photo_to_upload)->save(base_path('public/uploads/customer_photos/'.$filename));
                      //Image::make($photo_to_upload)->resize(450,400)->save(base_path('public/uploads/user_photos/'.$filename));

                      Customeradd::where('customer_id',$customer)->update([

                          'image'=>$filename,

                      ]);

                }else
                {

                  $delete_this_file=$image_from_database->image;
                  unlink(base_path('public/uploads/customer_photos/'.$delete_this_file));

                  $photo_to_upload=$request->image;
                  $filename=$customer.".".$photo_to_upload->getclientoriginalextension();
                  
                  Image::make($photo_to_upload)->save(base_path('public/uploads/customer_photos/'.$filename));
                  //Image::make($photo_to_upload)->resize(450,400)->save(base_path('public/uploads/user_photos/'.$filename));

                  Customeradd::where('customer_id',$customer)->update([

                      'image'=>$filename,

                  ]);


                }

               }





               return back()->with('status','Profile Updated');

            }else
            {
               return redirect()->route('customerlogin');
            }
    }
}
