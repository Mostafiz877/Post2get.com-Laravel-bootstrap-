@extends('layouts.customer_app')


@section('content')

 

    <div class="">

      <h4 class="mb-4 shadow-sm p-2" align="center">Message List</h4>
      
      <br>
      <br>

    

   @forelse ($unique_message_list as $messages)

   @if($messages['status']==1)

   @php
    $count=App\Message::where('receiver_status',2)->where('receiver_id',$customer_id)->where('sender_status',1)->where('sender_id',$messages['id'])->where('seen_or_unseen',0)->count();
   @endphp

    @elseif($messages['status']==2)

    @php

     $count=App\Message::where('receiver_status',2)->where('receiver_id',$customer_id)->where('sender_status',2)->where('sender_id',$messages['id'])->where('seen_or_unseen',0)->count();

    @endphp

    @endif

    


   <a href="{{ route('view_individual_customer_message',[$messages['id'],$messages['status']]) }}" style="text-decoration: none;" class="mb-2 card shadow-sm @if($count>0) bg-info @endif w-75 mx-auto">

     <div class="car p-2 comment_width">

      <b class="text-primary mr-auto">

        @if($messages['status']==1)

        <b class="text-primary mr-auto"><span @if($count>0) style="color:white; @endif ">{{App\User::find($messages['id'])->name}}@if($count>0) ({{$count}}) @endif</span></b>

        @elseif($messages['status']==2)

           <b class="text-primary mr-auto"><span @if($count>0) style="color:white; @endif ">{{App\Customer::find($messages['id'])->name}}@if($count>0) ({{$count}}) @endif</span></b>


        @endif
        </b>
      <div class="text-muted">
      </div>

    </div>
   </a>


    @empty

   <h6 class="mb-4 p-2 text-muted" align="center">You have no message</h6>



  @endforelse


    </div>






@endsection


