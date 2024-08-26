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
    <link href="https://fonts.googleapis.com/css2?family=Arimo:wght@400;500;600;700&display=swap" rel="stylesheet">

    {{-- BootStrap --}}
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

    {{-- FontAwesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- Datatables --}}
    <link href="https://cdn.datatables.net/v/bs5/jq-3.7.0/dt-1.13.8/r-2.5.0/datatables.min.css" rel="stylesheet">

</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-2 col-md-3 col-sm-4 col-12 bg-white px-0 d-flex flex-column justify-content-between navigate-panel"
                id="navigatePanel">
                <div class="row">

                    {{-- Logo --}}
                    <div class="col-12 d-flex justify-content-center align-items-center my-2">
                        <a href="{{ route('dashboard.index') }}">
                            <img src="{{ asset('images/Academic-crop.jpg') }}" width="100%" alt=""
                                class="object-fit-cover ">
                        </a>
                    </div>
                    {{-- End Logo --}}

                    <div class="d-flex flex-column justify-content-between navigations" id="navigations">
                        {{-- Navigations --}}
                        <div class="row ">
                            <div class="col-12 ">
                                <button type="button" class="p-0">
                                    <small class="ms-2">{{ __('messages.navigations') }}</small>
                                </button>
                            </div>
                            <div class="col-12">
                                <a href="{{ route('dashboard.index') }}">
                                    <button class="fw-medium px-0 w-100 text-start text-capitalize">
                                        <i class="fa-solid fa-chart-pie ms-3 me-2"></i>
                                        <span>{{ __('messages.dashboard') }}</span>
                                    </button>
                                </a>
                            </div>
                            <div class="col-12">
                                <a href="{{ route('category.index') }}">
                                    <button class="fw-medium px-0 w-100 text-start text-capitalize">
                                        <i class="fa-solid fa-list-check ms-3 me-2"></i>
                                        <span>{{ __('messages.category') }}</span>
                                    </button>
                                </a>
                            </div>
                            <div class="col-12">
                                <a href="{{ route('author.index') }}">
                                    <button class="fw-medium px-0 w-100 text-start text-capitalize">
                                        <i class="fa-solid fa-feather-pointed ms-3 me-2"></i>
                                        <span>{{ __('messages.author') }}</span>
                                    </button>
                                </a>
                            </div>
                            <div class="col-12">
                                <a href="{{ route('course.index') }}">
                                    <button class="fw-medium px-0 w-100 text-start text-capitalize">
                                        <i class="fa-solid fa-chalkboard-user ms-3 me-1"></i>
                                        <span>{{ __('messages.course') }}</span>
                                    </button>
                                </a>
                            </div>
                            <div class="col-12">
                                <a href="{{ route('trend-course.index') }}">
                                    <button class="fw-medium px-0 w-100 text-start text-capitalize">
                                        <i class="fa-solid fa-arrow-trend-up  ms-3 me-1"></i>
                                        <span>{{ __('messages.trend course') }}</span>
                                    </button>
                                </a>
                            </div>
                            <div class="col-12">
                                <a href="{{ route('lesson.index') }}">
                                    <button class="fw-medium px-0 w-100 text-start text-capitalize">
                                        <i class="fa-solid fa-book-open ms-3 me-2"></i>
                                        <span>{{ __('messages.lesson') }}</span>
                                    </button>
                                </a>
                            </div>
                            <div class="col-12">
                                <a href="{{ route('blog.index') }}">
                                    <button class="fw-medium px-0 w-100 text-start text-capitalize">
                                        <i class="fa-solid fa-blog ms-3 me-2"></i>
                                        <span>{{ __('messages.blog') }}</span>
                                    </button>
                                </a>
                            </div>
                            <div class="col-12">
                                <a href="{{ route('testimonial.index') }}">
                                    <button class="fw-medium px-0 w-100 text-start text-capitalize">
                                        <i class="fa-solid fa-star ms-3 me-2"></i>
                                        <span>{{ __('messages.review') }}</span>
                                    </button>
                                </a>
                            </div>
                            <div class="col-12">
                                <a href="{{ route('carousel.index') }}">
                                    <button class="fw-medium px-0 w-100 text-start text-capitalize">
                                        <i class="fa-regular fa-images ms-3 me-2"></i>
                                        <span>{{ __('messages.carousel') }}</span>
                                    </button>
                                </a>
                            </div>

                        </div>
                        {{-- End Navigations --}}

                        {{-- Account Management --}}
                        <div class="row">
                            <div class="col-12 ">
                                <button type="button" class="p-0">
                                    <small class="ms-2 text-capitalize">{{ __('messages.accManagement') }}</small>
                                </button>
                            </div>
                            <div class="col-12">
                                <a href="{{ route('users.index') }}">
                                    <button class="fw-medium px-0 w-100 text-start text-capitalize">
                                        <i class="fa-solid fa-users ms-3 me-1 "></i>
                                        {{ __('messages.user') }}
                                    </button>
                                </a>
                            </div>
                        </div>
                        {{-- End Account Management --}}

                        {{-- Language  --}}
                        <div class="row px-2 border-top">
                            <div class="col">
                                <div class="btn-group dropend">
                                    <button type="button" class="btn btn-secondary px-2 text-black text-capitalize"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        {{ __('messages.language') }}
                                        <i class="fa-solid fa-earth-asia"></i>
                                    </button>
                                    <ul class="dropdown-menu p-0">
                                        <li>
                                            <a href="{{ route('setLocalize', 'en') }}"
                                                class="dropdown-item text-decoration-none text-black text-capitalize small">
                                                <img src="{{ asset('images/english-flag.png') }}" width="20%"
                                                    class="me-1" alt="">
                                                {{ __('messages.eng') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('setLocalize', 'my') }}"
                                                class="dropdown-item text-decoration-none text-black text-capitalize small">
                                                <img src="{{ asset('images/myanmar-flag.png') }}" width="20%"
                                                    class="me-1" alt="">
                                                {{ __('messages.mya') }}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        {{-- End Language --}}
                    </div>
                </div>
            </div>

            <div class="col-lg-10 col-md-9 col-sm-8 col-12 p-0 main-container" id="mainContainer">
                <nav class="navbar navbar-expand-lg bg-white shadow-sm py-1">
                    <div class="container-fluid">
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <div class="dropdown ms-auto">
                                <button class="btn border shadow-sm py-1 px-4" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="row">
                                        <div class="col d-flex justify-content-center align-items-center p-0">
                                            @if (auth()->user()->profile_photo_path == null)
                                                @if (auth()->user()->gender == 'male')
                                                    <img src="{{ asset('images/default_user.png') }}" alt=""
                                                        class="userImg rounded-circle">
                                                @else
                                                    <img src="{{ asset('images/default_female.jpg') }}"
                                                        alt="" class="userImg rounded-circle">
                                                @endif
                                            @else
                                                <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}"
                                                    alt="" class="userImg rounded-circle">
                                            @endif
                                        </div>
                                        <div class="col d-flex align-items-center">
                                            <small class="fs-6 fw-bold text-capitalize text-start">
                                                {{ auth()->user()->name }}
                                            </small>
                                        </div>
                                    </div>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end px-0 mx-0" id="mainBtnDropMenu">
                                    <li>
                                        <a class="dropdown-item py-0 text-capitalize"
                                            href="{{ route('profile.read', auth()->user()->id) }}">
                                            <small>{{ __('messages.profile') }}</small>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item py-0" href="">
                                            <small>{{ __('messages.setting') }}</small>
                                        </a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <form action="{{ route('logout') }}" method="post">
                                            @csrf
                                            <a href=""
                                                class="dropdown-item py-0 text-decoration-none text-black">
                                                <button type="submit" class="btn p-0">
                                                    <small>{{ __('messages.logout') }}</small>
                                                </button>
                                            </a>
                                        </form>
                                    </li>
                                </ul>
                            </div>

                        </div>
                    </div>
                </nav>

                <div class="text-black" id=subContainer>

                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    {{-- Datatable --}}
    <script src="https://cdn.datatables.net/v/bs5/jq-3.7.0/dt-1.13.8/r-2.5.0/datatables.min.js"></script>

    {{-- Bootstrap Js --}}
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

    {{-- JS --}}
    <script src="{{ asset('js/master.js') }}"></script>

    {{-- Jquery --}}
    <script src="{{ asset('js/jquery.min.js') }}"></script>

    @yield('scriptSource')

</body>

</html>
