<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="{{asset('user/css/bootstrap.min.css')}}">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <br>
        <br>
        <div class="mt-4 mb-auto" align="center">

            <div class="content shadow p-4">

            
               <h2 class="h3 font-weight-bold mb-4">Welcome to getHERE</h2>


                <div class="m-b-md">
                    <h4 class="h3 font-weight-bold mt-4 mb-4">User</h4>
                    @if (Route::has('login'))
                        <div class="links">
                                {{-- <a href="{{ url('/home') }}" class="btn btn-primary">Home</a> --}}
                                <a href="{{ route('login') }}" class="btn btn-primary text-white mr-2">Login</a>
                                <a href="{{ route('register') }}" class="btn btn-secondary text-white">Register</a>
                        </div>
                    @endif
                </div>

                <hr class="w-50">

                <div class=" m-b-md">
                    <h4 class="font-weight-bold">Service Provider</h4>
                </div>

                <div class="links">
                        <a href="{{url('customer/login')}}" class="btn btn-primary text-white mr-2">Login</a>
                    <a href="{{url('customer/register')}}" class="btn btn-secondary text-white mr-2">Register</a>
                </div>

                <br>
                <br>

                <h6 class="mt-4">
                    <a href="" title="" class="mr-2 font-weight-bold">About Us</a>
                    <a href="" title="" class="font-weight-bold">Contact</a>

                </h6>

                <br>
                <br>
                <br>
                <span align="center" class="font-weight-bold text-muted" style="font-size:80%"> &copy A RUETians Production</span>

            </div>
            <br>

        </div>

    </body>
</html>
