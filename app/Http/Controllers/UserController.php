<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Category;
use App\User;
use App\Useradd;
use Auth;
use Carbon\Carbon;
use Image;
Use Bid;




class UserController extends Controller
{








    public function index()
    {

       if(!Session::has('user_or_customer_status'))
       {
        if(Auth::check())
        {
            session(['user_or_customer_status' =>1]);
        }
       }
       

       if (Auth::check()) {


        $user = auth()->user();
        $user_id=$user->id;
        $check_for_user_address=1; //1 means phone or location is not set


        if(!Useradd::where('user_id', '=',$user->id)->exists())
        {

          Useradd::insert([

              //left side table field name || right side form field name
              'user_id'=>$user->id,
          ]);

        }

        $user_address=Useradd::where('user_id',$user_id)->first();

        
        if(($user_address->phone==null)||(($user_address->current_location==null)))
        {
            $check_for_user_address=0;//0 means phone or location is not set yet
        }


        $categories=Category::all();

        $user_posts=User::find($user->id);

        $user_posts->setRelation('posts',$user_posts->posts()->paginate(5));
  

         return view('user/home',compact('categories','user_posts','check_for_user_address'));

       }else
       {
         return redirect()->route('root');
       }



    }

    public function message()
    {

      if (Auth::check()) {

        return view('user.message');

      }else
      {
        return redirect()->route('login');
      }

      

    }



    public function profile()
    {


        if (Auth::check()) {

            $user = auth()->user()->id;
            $user_information=User::find($user, ['name','email']);

            // if(!Useradd::where('user_id', '=',$user)->exists())
            // {

            //   Useradd::insert([

            //       //left side table field name || right side form field name
            //       'user_id'=>$user,
            //   ]);

            // }

            $user_address=Useradd::where('user_id', $user)->get();
            $single_user_address=$user_address->first();

            return view('user/profile',compact('user_information','single_user_address'));



        }else
        {
          return redirect()->route('root');
        }



    }

    public function edit_profile()
    {

        if(Auth::check())
        {
          $user = auth()->user()->id;
          $user_information=User::find($user, ['name']);
          $user_address=Useradd::where('user_id', $user)->get();

          $single_user_address=$user_address->first();

          return view('user.edit_profile',compact('user_information','single_user_address'));

        }else
        {
           return redirect()->route('login');
        }


    }


    public function profileUpdate(Request $request)
    {

      $user = auth()->user()->id; 

          if(Auth::check())
          {
             $user_address=Useradd::where('user_id', $user)->get();

             $single_user_address=$user_address->first();

              $phone_from_database=$single_user_address->phone;

             $phone_form_input=$request->phone;

             if($phone_from_database==$phone_form_input){


             $request->validate([

             'user_name'=>'required',
             'phone'=>'required|digits:11',
             'current_location'=>'required',
             'created_at'=>Carbon::now(),
             ]);

            }else
            {
              
             $request->validate([

             'user_name'=>'required',
             'phone'=>'required|digits:11|unique:useradds',
             'current_location'=>'required',
             'created_at'=>Carbon::now(),
             ]);

            }



             if (Useradd::where('user_id', '=',$user)->exists()) {


                 Useradd::where('user_id',$user)->update([

                     'phone'=>$request->phone,
                     'current_location'=>$request->current_location,

                 ]);
                


             }

             User::where('id',$user)->update([

                     'name'=>$request->user_name
             ]);


             // if($request->hasFile('image'))
             // {
             //     $photo_to_upload=$request->image;
             //     $filename=$user.".".$photo_to_upload->getclientoriginalextension();
                 
             //     Image::make($photo_to_upload)->save(base_path('public/uploads/user_photos/'.$filename));
             //     //Image::make($photo_to_upload)->resize(450,400)->save(base_path('public/uploads/user_photos/'.$filename));

             //     Useradd::where('user_id',$user)->update([

             //         'image'=>$filename,

             //     ]);
                 
             // }




             if($request->hasFile('image'))
             {

              $user_address=Useradd::where('user_id', $user)->get();

               
               $image_from_database=$user_address->first();




              if($image_from_database->image=='default.png')
              {

                    $photo_to_upload=$request->image;
                    $filename=$user.".".$photo_to_upload->getclientoriginalextension();
                    
                    Image::make($photo_to_upload)->save(base_path('public/uploads/user_photos/'.$filename));
                    //Image::make($photo_to_upload)->resize(450,400)->save(base_path('public/uploads/user_photos/'.$filename));

                    Useradd::where('user_id',$user)->update([

                        'image'=>$filename,

                    ]);

              }else
              {

                $delete_this_file=$image_from_database->image;
                unlink(base_path('public/uploads/user_photos/'.$delete_this_file));

                $photo_to_upload=$request->image;
                $filename=$user.".".$photo_to_upload->getclientoriginalextension();
                
                Image::make($photo_to_upload)->save(base_path('public/uploads/user_photos/'.$filename));
                //Image::make($photo_to_upload)->resize(450,400)->save(base_path('public/uploads/user_photos/'.$filename));

                Useradd::where('user_id',$user)->update([

                    'image'=>$filename,

                ]);


              }

             }





             return back()->with('status','Profile Updated');

          }else
          {
             return redirect()->route('login');
          }




    }



    public function hello()
    {

      p(500);
    }



}


