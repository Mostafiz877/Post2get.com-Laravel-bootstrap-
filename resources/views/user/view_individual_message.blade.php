@extends('layouts.app')


@section('content')

 
 <h4 align="center">{{App\Customer::find($customer_id)->name}}</h4>
    <div class="mt-4">

    <b>{{ $messages->links('vendor.pagination.message_pagination') }}</b>

   @foreach ($messages->reverse() as $message)

       <div class="">

        <b class="text-primary mr-auto">

          @if ($message->sender_id==$user_id && $message->sender_status==1)
           <a href="{{ url('/profile/view/') }}/{{$message->sender_status}}/{{$message->sender_id}}" title="">
             {{App\User::find($message->sender_id)->name}}
           </a>

          @elseif($message->sender_id==$customer_id && $message->sender_status==2)
          <a href="{{ url('/profile/view/') }}/{{$message->sender_status}}/{{$message->sender_id}}" title="">
            {{App\Customer::find($message->sender_id)->name}}
          </a>
          @endif
        </b>
        <br>
        <span class="text-justify" >{!! nl2br(e($message->message_content)) !!}</span>
        <p style="color:black;font-size: 80%" class="text-muted">{{\Carbon\Carbon::parse($message->created_at)->diffForHumans()}}</p>
        <hr>
      </div>





     @endforeach

     <br>

     <form action="{{ route('messageSend') }}" method="post" accept-charset="utf-8">

       @csrf

       <div class="form-group">
         <label for="exampleFormControlTextarea1"><b>Write your message here</b></label>
         <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="message_content"></textarea>
         <input type="hidden" name="receiver_id" value="{{$customer_id}}">
         <input type="hidden" name="receiver_status" value="2">
       </div>

       <button type="submit" class="btn btn-sm btn-primary" align="right">Send</button>

     </form>
     <br>

    </div>






@endsection


