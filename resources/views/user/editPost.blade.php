@extends('layouts.app')

@section('content')

@auth
<!-- start of form -->

   <div class="mt-4 p-4" align="center">


    @if(session('status'))
    <div class="alert alert-warning text-center alert-dismissible fade show" role="alert">
      {{session('status')}}

      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>

    @endif



    @if($errors->all())
    <div class="text-danger mb-4">
      
      @foreach($errors->all() as $error )
      <li>{{$error}}</li>
      @endforeach

    </div>
    @endif

     <form method="post" action="{{ route('updatePost') }}">

      @csrf
      

       <div class="form-group">
         <label for="exampleFormControlSelect1">Category</label>
         <select class="form-control form-control-sm input_width" id="exampleFormControlSelect1" name="category_id">
           <option value="">--Select One--</option>
           @foreach ($categories as $category)
             <option value="{{$category->id}}"

               @php
                 if($category->id==$post_informations->category_id)
                  echo "selected";
               @endphp>

               {{$category->category_name}}</option>
           @endforeach
           
         </select>
       </div>




       <div class="form-group mt-4">
         <label for="exampleFormControlTextarea1">Describe what you want</label>
         <textarea class="form-control form-control-sm input_width" id="exampleFormControlTextarea1" rows="3" name="content">{{$post_informations->content}}</textarea>
       </div>

       <div class="form-group">
         <label for="formGroupExampleInput">Set amount</label>
     <input type="number" class="form-control form-control-sm input_width_number" id="formGroupExampleInput" name="post_amount" value="{{$post_informations->post_amount}}">
       </div>

       <input type="hidden" name="post_id" value="{{$post_informations->id}}">

       <input  class="btn btn-sm btn-warning"type="submit" name="" value="Update">
     </form>
     
   </div>

   <!-- end of form -->


   
   @endauth

@endsection
