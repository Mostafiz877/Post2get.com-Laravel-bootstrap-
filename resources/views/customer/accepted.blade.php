@extends('layouts.customer_app')

@section('content')


@if(session('status'))

    <div aria-live="polite" aria-atomic="true" class="d-flex justify-content-center align-items-center" style="margin:0px">

      <!-- Then put toasts within -->
      <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="2000" style="border:none;-webkit-box-shadow: none;-moz-box-shadow: none;-o-box-shadow: none;box-shadow: none;">

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


@forelse($accepted_bids as $accepted_bid)


<div class="mb-4 shadow-sm" style="font-size:80%;">

  <a href="{{ url('customer/post/view/')}}/{{$accepted_bid->post_id}}" style="text-decoration: none;color:#000">
  <div class="card-header">
    <ul class="nav nav-tabs card-header-tabs pb-2">
      <li class="nav-item mr-4">Category: <b>{{App\Category::find(App\Post::find($accepted_bid->post_id)->category_id)->category_name}}</b></li>
      <li class="nav-item mr-4">Amount: <b>{{App\Post::find($accepted_bid->post_id)->post_amount}}</b></li>
      <li class="nav-item mr-2" style="font-size:80%;">{{App\Post::find($accepted_bid->post_id)->created_at->diffForHumans()}}</li>
      <li class="nav-item " style="font-size:80%;"><b>

        @php
          echo ($accepted_bid->status==0)? "Work not Complete":"Work Completed";
        @endphp
        </b></li>

      
    </ul>
  </div>

</a>


  <div class="card-body">
    <table class="table table-sm">
      <tbody>
        <tr>
          <td colspan="2"  class="text-justify"><b>{{ str_limit(App\Post::find($accepted_bid->post_id)->content, $limit = 100, $end = '...') }}</b></td>
        </tr>
        <tr>
          <td>Order By:</td>
          <td>{{ App\User::find($accepted_bid->user_id)->name}}</td>
        </tr>

        <tr>
          <td>Address:</td>
          <td>{{ App\Useradd::find($accepted_bid->user_id)->current_location}}</td>
        </tr>
        <tr>
          <td >C. Number:</td>
          <td>{{ App\Useradd::find($accepted_bid->user_id)->phone}}</td>
        </tr>

        <tr>
          <th>Fixed at:</th>
          <td>{{App\Bid::find($accepted_bid->bid_id)->bid_amount}} taka</td>
        </tr>
      </tbody>
    </table>
    @if ($accepted_bid->status==0)
    <span style="font-size:80%;">If you complete this work click here</span>
    <a href="{{ route('workdone',$accepted_bid->id) }}" class="btn btn-sm btn-warning mr-1">Done</a>

    @elseif($accepted_bid->status==1)

    <form action="{{route('delete_customer_history')}}" method="post" accept-charset="utf-8" class="d-inline">
      @csrf
      <input type="hidden" name="transaction_id" value="{{$accepted_bid->id}}">
      <input type="submit" name="deletebutton" value="Delete" onclick="return confirm('Are you sure to delete this item?');" class="btn btn-sm btn-link">
    </form>

    @endif

    
  </div>



</div>

@empty

<h3 class="shadow-sm p-2" align="center">
 Nothing to show
</h3>

@endforelse





@endsection