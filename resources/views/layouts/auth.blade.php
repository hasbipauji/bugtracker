<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ env('APP_NAME') }} |  @yield('title')</title>

    <!-- css -->
    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/toastr/build/toastr.min.css') }}">

    @yield('css')

    <style>
        body {
            background-color: #ecf0f1;
        }

        .container {
            height: 100vh;
            width: 100vw;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .box {
            width: 400px;
            margin: 0 20px;
            background-color: #fff;
            box-shadow: 0 0.75rem 1.5rem rgb(18 38 63 / 3%);
            border-radius: 10px;
        }

        .box-header {
            display: flex;
            border-radius: 10px 10px 0 0;
            background: linear-gradient(112.14deg, rgb(58, 123, 213) 100%, rgb(0, 210, 255) 0%);
            justify-content: space-between;
        }

        .box-header .box-label {
            padding: 25px
        }
        
        .box-header p, .box-header h5 {
            padding: 0;
            margin: 0;
            color: #fff;
        }

        .box-header h5 {
            padding-top: 5px;
        }

        .box-header img {
            height: 100px;
        }

        .box-content {
            padding: 25px;
        }

        @media screen and (max-width: 540px) {
            .box-header img {
                display: none;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        @yield('content')
    </div>

    <!-- script -->
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('assets/libs/toastr/build/toastr.min.js') }}"></script>

    @yield('js')
</body>
</html>