<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="{{asset('user/css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{asset('user/css/style.css')}}">

  <script src="{{asset('user/js/jquery-slim.min.js')}}"></script>
  <script src="{{asset('user/js/popper.min.js')}}"></script>
  <script src="{{asset('user/js/bootstrap.min.js')}}"></script>


<title>Hello, world!</title>


</head>
<body style="background-color:#f0f0f0">

    @if (Auth::guard('customer')->user())
    <!-- start of navbar -->


    <div class="shadow-sm mb-2 bg-white" style="font-size: 80%">

      <ul class="nav nav-tabs justify-content-center p-1">
        <li class="nav-item">
          <a class="nav-link" href="{{ route('customer.home') }}">Home</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="{{ route('customerProfile') }}">Profile</a>
        </li>

        <li class="nav-item">
          @php
            $customer_id=Auth::guard('customer')->user()->id;
            $count=App\Transaction::where('customer_id',$customer_id)->where('seen_or_unseen',0)->count();
          @endphp
          <a class="nav-link" href="{{ route('customerBidAccepted') }}" tabindex="-1" aria-disabled="true">Accepted Bid @if($count>0) <sup style="color:black;"><b>new</b></sup>@endif</a>
        </li>

       <li class="nav-item">
        @php
          $customer_id=Auth::guard('customer')->user()->id;
          $count=App\Message::where('receiver_id',$customer_id)->where('receiver_status',2)->where('seen_or_unseen',0)->count();
        @endphp

        <a  class="nav-link" href="{{ route('customer_message') }}" title="" class="dropdown-item">Messages @if($count>0) <sup style="color:black;"><b>new</b></sup>@endif</a>
      </li>


        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"></a>
          <div class="dropdown-menu">

            <a  class="dropdown-item" href="{{ url('/customer/logout') }}"
                onclick="event.preventDefault();
                         document.getElementById('logout-form').submit();">
                Logout
            </a>

            <form id="logout-form" action="{{ url('/customer/logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>

          </div>
        </li>

      </ul>

    </div>


    <!-- end of navbar -->
@endif

  <div class="container shadow p-4 bg-white mb-2" style="font-size: 80%">


        <main class="py-4">
             @yield('content')
        </main>
  
      </div>



      <!-- Optional JavaScript -->
      <!-- jQuery first, then Popper.js, then Bootstrap JS -->

      <h6 align="center" class="text-muted" style="font-size: 80%"> &copy A RUETians Production</h6>


    </body>
    </html>
