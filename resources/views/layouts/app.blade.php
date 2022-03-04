{{-- @auth
  @php

  haeder("Location:http://127.0.0.1:8000/home")
    // redirect()->route('/home');
  @endphp
@endauth --}}

<!doctype html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  
  <link rel="stylesheet" href="{{asset('user/css/bootstrap.min.css')}}">
  <script src="{{asset('user/js/jquery-slim.min.js')}}"></script>
  <script src="{{asset('user/js/popper.min.js')}}"></script>
  <script src="{{asset('user/js/bootstrap.min.js')}}"></script>

{{--     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> --}}

    <link rel="stylesheet" href="{{asset('user/css/style.css')}}">
  <title>Hello, world!</title>
  
</head>
<body style="background-color:#f0f0f0">





  



    <!-- start of navbar -->
  @auth

    <div class="shadow-sm mb-2 bg-white" style="font-size: 80%">

      <ul class="nav nav-tabs justify-content-center p-1">
        <li class="nav-item">
          <a class="nav-link" href="{{ route('home') }}">Home</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="{{ route('profile') }}">Profile</a>
        </li>
        
        <li class="nav-item">
          @php
            $user_id=auth()->user()->id;
            $count=App\Message::where('receiver_id',$user_id)->where('receiver_status',1)->where('seen_or_unseen',0)->count();
          @endphp
          <a class="nav-link" href="{{ route('message') }}" tabindex="-1" aria-disabled="true">Message @if($count>0) <sup style="color:black;"><b>new</b></sup>@endif</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"></a>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="{{ route('history') }}">History</a>
            <!-- <div class="dropdown-divider"></div> -->
            <a class="dropdown-item" href="{{ route('logout') }}"
               onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>

          </div>
        </li>

      </ul>

    </div>

    @endauth


    <!-- end of navbar -->

    <div class=" shadow p-4 bg-white mb-2 rounded body_width mx-auto" style="font-size: 80%">


        <main class="py-4">
             @yield('content')
        </main>
    

        <br>
        <br>

        
        <br>
        <br>



      </div>



      <!-- Optional JavaScript -->
      <!-- jQuery first, then Popper.js, then Bootstrap JS -->



      <h6 align="center" class="text-muted" style="font-size: 80%"> &copy A RUETians Production</h6>

    </body>
    </html>



</body>
</html>
