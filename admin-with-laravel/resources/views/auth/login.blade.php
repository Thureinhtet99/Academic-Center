@extends('auth.layouts.master')

@section('content')
    <div class="col-md-6 d-flex align-items-center">
        <div class="col-8 offset-2">
            <div class="col-12 d-flex align-items-center my-2 text-primary">
                <img src="{{ asset('images/Academic-crop.jpg') }}" width="100%" alt="" class="object-cover">
            </div>
            <div class="col-12 text-center">
                <h4 class="fw-bolder my-0">Log in to your account</h4>
                <p class="text-muted my-0">
                    <small>Welcome back! Select method to log in : </small>
                </p>
            </div>
            <div class="col-12 my-5">
                <p class="text-muted text-center">
                    __________ or continue with email __________
                </p>
            </div>

            <form action="{{ route('login') }}" method="post">
                @csrf
                <div class="border rounded d-flex align-items-center mt-4">
                    <i class="fa-regular fa-envelope mx-3 text-muted"></i>
                    <input type="email" name="email" placeholder="Email"
                        class="login-page-user-input-email p-2 border-0">
                </div>
                @error('email')
                    <div class="col">
                        <span class="text-danger small">
                            <small>
                                {{ $message }}
                            </small>
                        </span>
                    </div>
                @enderror
                <div class="border rounded d-flex align-items-center mt-3">
                    <i class="fa-solid fa-lock mx-3 text-muted"></i>
                    <input type="password" name="password" id="loginPwd" placeholder="Password"
                        class="login-page-user-input p-2 border-0">
                    <span class="m-0">
                        <button type="button" class="btn btn-sm" id="eyeBtn">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                    </span>
                </div>
                @error('password')
                    <div class="col">
                        <span class="text-danger small">
                            <small>
                                {{ $message }}
                            </small>
                        </span>
                    </div>
                @enderror
                <div class="col-4 mt-3 offset-4">
                    <button type="submit" class="btn btn-primary fs-6 w-100 text-center my-4">Login</button>
                </div>
            </form>

            <div class="row mb-3">
                <div class="col text-center">
                    <span class="p-0">
                        <small>Don't have an account?</small>
                    </span>
                    <a href="{{ route('auth.registerPage') }}" class="text-decoration-none already-have-acc">
                        <small>
                            Create an account
                        </small>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
