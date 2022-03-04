@extends('layouts.customer_app')

@section('content')
<div class="card">
 <div align="center" class="mt-4">

  <img class="shadow" src="{{asset('uploads/customer_photos')}}/{{$single_customer_address->image}}" alt="" style="border:1px solid black;border-radius:50%" width="150px" height="150px">

   <div align="center" class="w-75">

     <table class="table table-sm mt-4" >
       <tbody>
         <tr>
           <th scope="row">Name:</th>
           <td>{{$customer_information->name}}</td>
         </tr>

         <tr>
           <th scope="row">Phone:</th>
           <td>{{$single_customer_address->phone}}</td>
         </tr>

         <tr>
           <th scope="row">Eamil:</th>
           <td><b>{{$customer_information->email}}</b></td>
         </tr>


         <tr>
           <th scope="row">Current Location:</th>
           <td>{{$single_customer_address->current_location}}</td>
         </tr>


         <tr>

           <td>
             <a href="{{ route('editCustomerProfile') }}" class="btn btn-sm btn-primary">Edit Profile</a>
           </td>
         </tr>

       </tbody>
     </table>
   </div>
 </div>

</div>
@endsection
