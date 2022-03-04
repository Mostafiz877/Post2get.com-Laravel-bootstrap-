@extends('layouts.app')

@section('content')

   <div align="center" class="card p-4">

    @if($errors->all())
    <div class="text-danger mb-4">
      
      @foreach($errors->all() as $error )
      <li>{{$error}}</li>
      @endforeach

    </div>
    @endif

    @if(session('status'))
    <div class="alert alert-warning text-center alert-dismissible fade show" role="alert">
      {{session('status')}}

      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>

    @endif

  <form method="post" action="{{ route('editProfile') }}" enctype="multipart/form-data">
    @csrf
    

  <div class="form-group">
    <label for="exampleInputEmail1"><b>Name:</b></label>
    <input type="text" name="user_name" class="form-control form-control-sm input_width" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{$user_information->name}}">
  </div>

    <div class="form-group">
    <label for="exampleInputEmail1"><b>Phone:</b></label>
    <input type="text" class="form-control form-control-sm input_width" id="exampleInputEmail1" aria-describedby="emailHelp" name="phone" value="{{$single_user_address->phone}}">
  </div>

    <div class="form-group">
    <label for="exampleInputEmail1"><b>Current Location:</b></label>
    <input type="text" class="form-control form-control-sm  input_width" id="exampleInputEmail1" aria-describedby="emailHelp" name="current_location" value="{{$single_user_address->current_location}}">
  </div>


  <div class="form-group">
    <label for="exampleInputEmail1"><b>Image:<span class="text-muted"> (not required)</span></b></label>
    <input type="file" class="form-control form-control-sm  input_width" name="image">
  </div>


  <input type="submit" name=""  class="btn btn-sm btn-primary" value="Update">

</form>

</div>

@endsection
