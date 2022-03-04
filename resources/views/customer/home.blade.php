@extends('layouts.customer_app')

@section('content')
<!-- start of category-->

@if($check_for_customer_address==0)

 <marquee class="p-2 shadow-sm text-muted font-weight-bold mb-4" scrollamount="4">Please set phone number and cureent location at first to bid in profile</marquee>

@endif


<div class="mx-auto" role="group" aria-label="Basic example" align="center">
  @foreach ($categories  as $category)

  <a href="{{ url('/category/wise/post/') }}/{{$category->id}}" title="" class="btn btn-secondary mb-2 btn-sm">{{$category->category_name}}</a>

  @endforeach
  
</div>


<!-- end of category -->

<br>
<br>


<h5 class="text-muted mb-4 mt-1" align="center">Works Avaliable all category</h5>


<!-- start of post -->



<div>


    @forelse ($user_posts as $post)

    <div class="shadow-sm  mt-4 post  p-2 bg-white rounded" >
      <div>
        <a href="{{ url('customer/post/view/')}}/{{$post->id}}" style="text-decoration: none;color:#000">
        <div class="card-header">
          <ul class="nav nav-tabs card-header-tabs pb-2">
            <li class="nav-item mr-2">Category: <b>{{App\Category::find($post->category_id)->category_name}}</b></li>
            <li class="nav-item mr-2">Amount: <b>{{$post->post_amount}}</b></li>
              <li class="nav-item" style="font-size:80%;">{{$post->created_at->diffForHumans()}}</li>

          </ul>
        </div>

         </a> 

        <div class="card-body mt-2" style="border-left:2px solid #28fc03;">

          @php
          $information=$post->content;
          $length=strlen($information);
          $m1=substr($information,0,250);
          $m2=substr($information,250,$length);
          @endphp

          @if ($length>250)
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

          <br><span class="mr-1 ext-info"><b>{{App\Bid::where('post_id',$post->id)->count()}}</b> bids</span>
          <span class="text-warning mr-1">
            <b>
              @php
                 echo ($post->status==0)? "Pending":"Accepted";
              @endphp
            </b>
          </span>


        </div>
      </div>
    </div>

     @empty

    <h5  class="shadow bg-white rounded p-4" align="center">No post to show</h5>

    @endforelse

    <div class="post mt-5" >
      <hr>

        {{--      {{$user_posts->links('vendor.pagination.default')}} --}}

     {{$user_posts->links('')}}


    </div>

  

 


</div>

@endsection

