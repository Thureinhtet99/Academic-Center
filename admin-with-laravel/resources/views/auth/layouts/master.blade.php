<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="shortcut icon" href="{{ asset('images/Academic.jpg') }}" type="image/x-icon">
    <title>Academic Center</title>

    {{-- Css --}}
    <link rel="stylesheet" href="{{ asset('css/master.css') }}">

    {{-- Google Font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200;300;400;500;600;700&display=swap"
        rel="stylesheet">

    {{-- FontAwesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- BootStrap --}}
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

</head>

<body>
    <div class="container-fluid">
        <div class="row">

            @yield('content')

            <div class="col-md-6 p-0 d-flex align-items-end align-items-center">
                <div id="carouselExampleRide" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner float-end">
                        <div class="carousel-item active">
                            <img src="{{ asset('images/login-carousel-1.jpg') }}"
                                class="d-block w-100 carousel-auth-img " alt="">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('images/login-carousel-2.jpg') }}"
                                class="d-block w-100 carousel-auth-img " alt="">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('images/login-carousel-3.jpg') }}"
                                class="d-block w-100 carousel-auth-img " alt="">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleRide"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleRide"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Jquery --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    {{-- Bootstrap --}}
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>

    {{-- Master JS --}}
    <script src="{{ asset('js/master.js') }}"></script>

</body>

</html>
