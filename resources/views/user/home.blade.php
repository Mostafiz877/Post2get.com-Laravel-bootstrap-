@extends('layouts.app')

@section('content')

@auth
<!-- start of form -->
  @if($check_for_user_address==0)
  
   <marquee class="p-2 shadow-sm text-muted font-weight-bold" scrollamount="4">Please set phone number and cureent location at first to post in profile</marquee>

  @endif

   <div class="mt-1 shadow p-4 bg-white" align="center">

    @if(session('status'))

        <div aria-live="polite" aria-atomic="true" class="d-flex justify-content-center align-items-center" style="margin:0px">

          <!-- Then put toasts within -->
          <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="4000" style="border:none;-webkit-box-shadow: none;-moz-box-shadow: none;-o-box-shadow: none;box-shadow: none;">

            <div class="alert alert-warning" role="alert">
              <strong>{{session('status')}}</strong>
            </div>

          </div>
        </div>


        <script>

          $(document).ready(function()
          {
            $('.toast').toast('show');

          });
        </script>

     @endif


    @if($errors->all())
    <div class="text-danger mb-4">
      
      @foreach($errors->all() as $error )
      <li>{{$error}}</li>
      @endforeach

    </div>
    @endif

     <form method="post" action="{{ route('insertPost') }}">

      @csrf
      

       <div class="form-group">
         <label for="exampleFormControlSelect1">Category</label>
         <select class="form-control form-control-sm input_width" id="exampleFormControlSelect1" name="category_id">
           <option value="">--Select One--</option>
           @foreach ($categories as $category)
             <option value="{{$category->id}}">{{$category->category_name}}</option>
           @endforeach
           
         </select>
       </div>

       <div class="form-group mt-4">
         <label for="exampleFormControlTextarea1">Describe what you want</label>
         <textarea class="form-control form-control-sm input_width" id="exampleFormControlTextarea1" rows="3" name="content">{{old('content')}}</textarea>
       </div>

       <div class="form-group">
         <label for="formGroupExampleInput">Set amount</label>
         <input type="number" class="form-control form-control-sm input_width_number" id="formGroupExampleInput" name="post_amount" value="{{old('post_amount')}}">
       </div>

       <input  class="btn btn-sm btn-warning"type="submit" name="" value="Post">
     </form>
     
   </div>

   <!-- end of form -->


   <br>
   <br>
   <br>
   <br>



   <h4 class="text-muted mb-4 mt-4" align="center">Recent Post</h4>


   <!-- start of post -->

   

   <div>


    @forelse ($user_posts->posts as $post)

      <div class="shadow-sm mt-4 post  p-2 bg-white rounded" >
        <div>

            <a href="{{ route('viewSingleUserPost',$post->id) }}" style="text-decoration: none;color:#000">

          <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs pb-2">
              <li class="nav-item mr-2">Category: <b>{{App\Category::find($post->category_id)->category_name}}</b></li>
              <li class="nav-item mr-2">Amount: <b>{{$post->post_amount}}</b></li>
              <li class="nav-item " style="font-size:80%;">{{$post->created_at->diffForHumans()}}</li>
              
            </ul>
          </div>

              </a>
          <div class="card-body mt-1" style="border-left:2px solid #28fc03;">



            @php
            $information=$post->content;
            $length=strlen($information);
            $m1=substr($information,0,250);
            $m2=substr($information,250,$length);
            @endphp

            @if ($length>200)
            <span class="text-justify">{!! nl2br(e($m1)) !!}<span id="dots{{$post->id}}">.....</span><span id="more{{$post->id}}" style="display: none;">{!! nl2br(e($m2)) !!}</span></span>
            <button onclick="myFunction{{$post->id}}()" id="myBtn{{$post->id}}" style="display: inline" class="btn btn-sm btn-link">Read more</button>
            @else
            {!! nl2br(e($information)) !!}
            @endif

            <br>
            <script>
            function myFunction{{$post->id}}() {
              var dots = document.getElementById("dots{{$post->id}}");
              var moreText = document.getElementById("more{{$post->id}}");
              var btnText = document.getElementById("myBtn{{$post->id}}");

              if (dots{{$post->id}}.style.display === "none") {
                dots{{$post->id}}.style.display = "inline";
                btnText.innerHTML = "Read more"; 
                moreText.style.display = "none";
              } else {
                dots{{$post->id}}.style.display = "none";
                btnText.innerHTML = "Read less"; 
                moreText.style.display = "inline";
              }
            }
            </script>



            <br><span class="mr-1 ext-info"><b>{{App\Bid::where('post_id',$post->id)->count()}} Bid</b></span>
            <span class="text-warning mr-1">
              @php
                 echo ($post->status==0)? "Pending":"Accepted";
              @endphp
            </span>

            @if($post->status==0)
            <a href="{{ url('/edit/post') }}/{{$post->id}}" title="" class="mr-2">Edit</a>
            @endif




            @if($post->status==0)

            <a  class="" href="{{ url('/post/delete') }}/{{$post->id}}" title=""   data-toggle="modal" data-target="#exampleModalCenter{{$post->id}}">Delete</a>

            @endif


            @php

            $transaction=App\Transaction::where('post_id',$post->id)->first();

              if ($post->status==1)
              {
                if($transaction->status==1)
                {
                  @endphp

                  <a  class="" href="{{ url('/post/delete') }}/{{$post->id}}" title=""  data-toggle="modal" data-target="#exampleModalCenter{{$post->id}}">Delete</a>
                  
                  @php
                }
              }
            @endphp



            <!-- Modal -->
            <div class="modal fade" id="exampleModalCenter{{$post->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Are you sure to delete this post?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-footer">
                    <form action="{{ route('deletePost') }}" method="post" accept-charset="utf-8" class="d-inline">
                      @csrf
                      <input type="hidden" name="post_id" value="{{$post->id}}">
                      <input type="submit" name="" value="Delete" class="btn btn-sm btn-outline-danger">
                    </form>
                    <a href="{{ route('home') }}" title="" class="btn btn-sm btn-primary">No</a>
                  </div>
                </div>
              </div>
            </div>

           


          </div>
        </div>
      </div>

    @empty

    <h5  class="shadow-sm bg-white rounded p-2" align="center">You have no recent Post</h5>

    @endforelse

    <div class="post mt-5" >
      <hr>

      {!! $user_posts->posts->render() !!}

    </div>

    


     
   </div>
   @else

   <script>

    window.location.href = '{{route("root")}}';
    
   </script>
   @endauth

@endsection

