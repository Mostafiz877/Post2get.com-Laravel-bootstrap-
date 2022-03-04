@extends('layouts.app')


@section('content')

 

    <div class="mt-2">

 
<h4 class="mb-4 shadow-sm p-2" align="center">Message List</h4>
    

   @forelse ($unique_message_list as $message)


   @php
    $count=App\Message::where('receiver_status',1)->where('receiver_id',$user_id)->where('sender_status',2)->where('sender_id',$message)->where('seen_or_unseen',0)->count();
   @endphp


     <a href="{{ route('view_individual_message',$message) }}" style="text-decoration: none;" class="mb-2 card shadow-sm @if($count>0) bg-info @endif w-75 mx-auto">

       <div class="car p-2 comment_width">

        <b class="text-primary mr-auto"><span @if($count>0) style="color:white; @endif ">{{App\Customer::find($message)->name}}@if($count>0) ({{$count}}) @endif</span></b>

        {{-- <p style="color:black">5 minutes ago</p> --}}
      </div>
     </a>

     @empty

    <h6 class="mb-4  p-2 text-muted" align="center">You have no message</h6>

     @endforelse


    </div>






@endsection


