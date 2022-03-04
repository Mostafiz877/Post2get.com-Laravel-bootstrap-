@extends('layouts.app')

@section('content')
<div class="card">
 <div align="center" class="mt-4">

  <img class="shadow" src="{{asset('uploads/user_photos')}}/{{$single_user_address->image}}" alt="" style="border:1px solid black;border-radius:50%" width="150px" height="150px">

   <div align="center" class="w-75">

     <table class="table table-sm mt-4" >
       <tbody>
         <tr>
           <th scope="row">Name:</th>
           <td>{{$user_information->name}}</td>
         </tr>

         <tr>
           <th scope="row">Phone:</th>
           <td>{{$single_user_address->phone}}</td>
         </tr>

         <tr>
           <th scope="row">Eamil:</th>
           <td><b>{{$user_information->email}}</b></td>
         </tr>


         <tr>
           <th scope="row">Current Location:</th>
           <td>{{$single_user_address->current_location}}</td>
         </tr>


         <tr>

           <td>
             <a href="{{ route('edit_profile') }}" class="btn btn-sm btn-primary">Edit Profile</a>
           </td>
         </tr>

       </tbody>
     </table>
   </div>
 </div>

</div>
@endsection
