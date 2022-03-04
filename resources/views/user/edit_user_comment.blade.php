@extends('layouts.app')

@section('content')
	

@if($errors->all())
<div class="text-danger mb-2" align="center">
  
  @foreach($errors->all() as $error)
  <li>{{$error}}</li>
  @endforeach

</div>
@endif




<form class="w-75 mx-auto" method="post" action="{{ route('userCommentUpdate') }}">

	@csrf

  <div class="form-group">
    <label for="exampleFormControlTextarea1">Write your comment here</label>
    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="comment">{{$comment->comment_content}}</textarea>
  </div>

  <input type="hidden" name="comment_id" value="{{$comment->id}}">
  <input type="hidden" name="post_id" value="{{$comment->post_id}}">

  <input type="submit" name="" value="Update" class="btn btn-sm btn-warning">

</form>

@endsection