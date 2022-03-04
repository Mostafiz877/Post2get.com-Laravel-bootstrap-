@extends('layouts.customer_app')

@section('content')



   <!-- start-of-post -->

   <div class="mb-4 mt-4">
   


@if(session('status'))

    <div aria-live="polite" aria-atomic="true" class="d-flex justify-content-center align-items-center" style="margin:0px">

      <!-- Then put toasts within -->
      <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="7000" style="border:none;-webkit-box-shadow: none;-moz-box-shadow: none;-o-box-shadow: none;box-shadow: none;">

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


        
        <div class="shadow-sm mt-4 post  p-2 bg-white rounded">
          <div>
            <a href="{{ url('customer/post/view/')}}/{{$single_post->id}}" style="text-decoration: none;color:#000">
            <div class="card-header">
              <ul class="nav nav-tabs card-header-tabs pb-2">
                <li class="nav-item mr-2">Category: <b>{{App\Category::find($single_post->category_id)->category_name}}</b></li>
                <li class="nav-item mr-2">Amount: <b>{{$single_post->post_amount}}</b></li>
                  <li class="nav-item" style="font-size:80%;">{{$single_post->created_at->diffForHumans()}}</li>

              </ul>
            </div>
             </a>
            <div class="card-body">
              <p class="text-justify">
                  {!! nl2br(e($single_post->content)) !!}
              </p>
              <span class="mr-1 ext-info"><b>{{App\Bid::where('post_id',$single_post->id)->count()}}</b> bids</span>
              <span class="text-warning mr-1">
                <b>
                  @php
                     echo ($single_post->status==0)? "Pending":"Accepted";
                  @endphp
                </b>
              </span>


            </div>
          </div>
        </div>
 

     
</div>
<br>


<hr class="bg-primary">
<br>



@if($errors->all())
<div class="text-danger mb-2" align="center">
  
  @foreach($errors->all() as $error )
  <li>{{$error}}</li>
  @endforeach

</div>
@endif

<br>

  <!-- end of post -->



  <!-- start of comment and bis  -->

  <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Comments</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Bids</a>
    </li>
  </ul>
  <br>
  <br>
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">



     <!--  start of comment section -->

     <div>  <!-- for comment -->

      @forelse ($comments->comments as $comment)
        
         <div class="p-2 comment_width shadow-sm mb-3">
   
           <a href="{{ url('/profile/view/') }}/{{$comment->user_or_customer}}/{{$comment->commenter_id}}" style="">
            <b class="profile_link">
              @if($comment->user_or_customer==1)

                 {{App\User::find($comment->commenter_id)->name}}

              @elseif($comment->user_or_customer==2)

              {{App\Customer::find($comment->commenter_id)->name}}

              @endif

              


            </b>
          </a>

          <span class="ml-3 text-muted" style="font-size:80%;">{{$comment->created_at->diffForHumans()}}</span>

          <div class="blockquote mt-2">
            <p class="h6 text-justify">

              {!! nl2br(e($comment->comment_content)) !!}

            </p>
          </div>


          @if(($comment->user_or_customer==2) &&  ($comment->commenter_id==$customer))

            <a href="{{ url('/customer/post/comment/edit') }}/{{$comment->id}}" class="mr-2">Edit</a>
            <a href="{{ url('/customer/post/comment/delete') }}/{{$comment->id}}" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>

            @endif

        </div>

      @endforeach




   {!! $comments->comments->render() !!}




    <form class="" method="post" action="{{ route('customerComment') }}">
      @csrf
      
      <div class="form-group comment_width">
        <label for="exampleFormControlTextarea1" ><b>Write your comment here</b></label>
        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="comment_content"></textarea>
      </div>

      <div class="form-group">
        <input  class="btn btn-sm btn-primary" type="submit" name="" value="Comment">
      </div>

      <input type="hidden" name="post_id" value="{{$single_post->id}}">

    </form>







  </div>


  <!--  end of comment section -->


</div>


<div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">


@foreach ($bids as $bid)
  
 <div class="shadow-sm mb-3 p-3">

<div class="mb-2">
   <a href="{{ url('/profile/view/') }}/2/{{$bid->customer_id}}" style="">
    <b class="profile_link">{{App\Customer::find($bid->customer_id)->name}}</b>
  </a>
  <span class="ml-3 text-muted" style="font-size:80%;">{{$bid->created_at->diffForHumans()}}</span>
</div>

  <div>
     <p class="text-justify">
       {!! nl2br(e($bid->bid_comment)) !!}
     </p>
  </div>
  
  <span class="">Taka: <b>{{$bid->bid_amount}}</b></span>
  {{-- <a href="" class="ml-2 btn btn-sm btn-primary">Accept</a> --}}
  <!-- <a href="" class="ml-2">Edit</a> -->

  @if(($bid->customer_id==$customer))
  
 <a href="{{ route('editBid',$bid->id) }}" class="ml-2" >Edit</a>
  <a href="{{ route('deleteBid',$bid->id) }}" class="ml-2" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
  

  @endif

</div>

@endforeach



@if ($bid_check===null)



<form class="" method="post" action="{{ route('createBid') }}">
  @csrf
  
  <div class="form-group comment_width">
    <label for="exampleFormControlTextarea1" ><b>Write Something impressive</b></label>
    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="bid_comment">{{old('bid_comment')}}</textarea>
  </div>


  <div class="form-group">
    <label for="exampleFormControlTextarea1" >Bid Amount</label>
    <input  class="form-control w-50" type="number" name="bid_amount" value="{{old('bid_amount')}}" placeholder="">
  </div>

  <input type="hidden" name="post_id" value="{{$single_post->id}}">

  <div class="form-group">
    <input  class="btn btn-sm btn-primary" type="submit"  value="Bid">
  </div>

</form>

@endif






</div>

</div>


<!-- end of comment and bids -->

@endsection