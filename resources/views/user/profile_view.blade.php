
@extends( ($user_or_customer_status==1) ? 'layouts.app' : 'layouts.customer_app')



@section('content')
<div class="card">
 <div align="center" class="mt-4">

  @if(session('status'))

      <div aria-live="polite" aria-atomic="true" class="d-flex justify-content-center align-items-center" style="margin:0px">

        <!-- Then put toasts within -->
        <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="7000" style="border:none;-webkit-box-shadow: none;-moz-box-shadow: none;-o-box-shadow: none;box-shadow: none;">

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


  <img class="shadow" src="{{asset('uploads/customer_photos')}}/{{$address->image}}" alt="" style="border:1px solid black;border-radius:50%" width="150px" height="150px">

   <div align="center" class="w-75">

     <table class="table table-sm mt-4" >
       <tbody>
         <tr>
           <th scope="row">Name:</th>
           <td>{{$information->name}}</td>
         </tr>

{{--          <tr>
           <th scope="row">Phone:</th>
           <td>{{$address->phone}}</td>
         </tr>

         <tr>
           <th scope="row">Eamil:</th>
           <td><b>{{$information->email}}</b></td>
         </tr> --}}


         <tr>
           <th scope="row">Current Location:</th>
           <td>{{$address->current_location}}</td>
         </tr>


         <tr>

           <td>

            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
              Message
            </button>

             <!-- Button trigger modal -->
             <!-- Modal -->
             <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
               <div class="modal-dialog modal-dialog-centered" role="document">
                 <div class="modal-content">
                   <div class="modal-body">
                    <form action="{{ route('messageSend') }}" method="post" accept-charset="utf-8">

                      @csrf

                      <div class="form-group">
                        <label for="exampleFormControlTextarea1">Write your message here</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="message_content"></textarea>
                        <input type="hidden" name="receiver_id" value="{{$information->id}}">
                        <input type="hidden" name="receiver_status" value="{{$status}}">
                      </div>

                      <button type="submit" class="btn btn-sm btn-primary" align="right">Send</button>

                    </form>
                   </div>
                 </div>
               </div>
             </div>
           </td>
         </tr>

       </tbody>
     </table>
   </div>
 </div>

</div>
@endsection
