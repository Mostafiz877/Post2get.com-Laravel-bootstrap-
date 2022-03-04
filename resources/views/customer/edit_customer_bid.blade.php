@extends('layouts.customer_app')

@section('content')
	

@if($errors->all())
<div class="text-danger mb-2" align="center">
  
  @foreach($errors->all() as $error )
  <li>{{$error}}</li>
  @endforeach

</div>
@endif




<form class="w-75 mx-auto" method="post" action="{{ route('editBidUpdate') }}">

	@csrf

  <div class="form-group">
    <label for="exampleFormControlTextarea1"><b>Write Something impressive</b></label>
    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="bid_comment">{{$bid->bid_comment}}</textarea>
  </div>

  <div class="form-group">
    <label for="exampleFormControlTextarea1" >Bid Amount</label>
    <input  class="form-control w-50" type="number" name="bid_amount" value="{{$bid->bid_amount}}" placeholder="">
  </div>

  <input type="hidden" name="bid_id" value="{{$bid->id}}">
  <input type="hidden" name="post_id" value="{{$bid->post_id}}">

  <input type="submit" name="" value="Update" class="btn btn-sm btn-warning">

</form>

@endsection