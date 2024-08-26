@extends('auth.layouts.master')

@section('content')
    <div class="col-md-6 d-flex align-items-center">
        <div class="col-8 offset-2">
            <div class="col-12 my-2">
                <img src="{{ asset('images/Academic-crop.jpg') }}" width="100%" alt="" class="object-cover">
            </div>
            <div class="col-12">
                <h5 class="fw-bold text-center">Sign up an account</h5>
            </div>

            <form action="{{ route('register') }}" method="post">
                @csrf
                <div class="border rounded d-flex align-items-center mt-4">
                    <i class="fa-regular fa-user mx-2 text-muted"></i>
                    <input type="text" name="name" placeholder="Username"
                        class="login-page-user-input-email p-2 border-0" value="{{ old('name') }}">
                </div>
                @error('name')
                    <div class="col">
                        <span class="text-danger small">
                            <small>
                                {{ $message }}
                            </small>
                        </span>
                    </div>
                @enderror
                <div class="border rounded d-flex align-items-center mt-4">
                    <i class="fa-regular fa-envelope mx-2 text-muted"></i>
                    <input type="email" name="email" placeholder="Email"
                        class="login-page-user-input-email p-2 border-0" value="{{ old('email') }}">
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
                <div class="row mt-4">
                    <div class="col-6">
                        <div class="border rounded d-flex align-items-center">
                            <i class="fa-solid fa-phone mx-2 text-muted"></i>
                            <input type="number" name="phone" placeholder="Phone"
                                class="login-page-user-input-email p-2 border-0">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="border rounded d-flex align-items-center">
                            <i class="fa-solid fa-venus-mars mx-2 text-muted"></i>
                            <select name="gender" id=""
                                class="form-select login-page-user-input-email p-2 border-0">
                                <option value="">Choose Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                        @error('gender')
                            <div class="col">
                                <span class="text-danger small">
                                    <small>
                                        {{ $message }}
                                    </small>
                                </span>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="border rounded d-flex align-items-center mt-4">
                    <i class="fa-solid fa-lock mx-2 text-muted"></i>
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
                <div class="border rounded d-flex align-items-center mt-4">
                    <i class="fa-solid fa-lock mx-2 text-muted"></i>
                    <input type="password" name="password_confirmation" id="loginConfirmPwd" placeholder="Confirm Password"
                        class="login-page-user-input p-2 border-0">
                    <span class="m-0">
                        <button type="button" class="btn btn-sm" id="eyeConfirmBtn">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                    </span>
                </div>
                @error('confirm-password')
                    <div class="col">
                        <span class="text-danger small">
                            <small>
                                {{ $message }}
                            </small>
                        </span>
                    </div>
                @enderror
                <div class="col-4 offset-4">
                    <button type="submit" class="btn btn-primary fs-6 w-100 text-center my-4">Sign Up</button>
                </div>
            </form>

            <div class="col text-center">
                <a href="{{ route('auth.loginPage') }}" class="text-decoration-none already-have-acc small">
                    Already have an account?
                </a>
            </div>
        </div>
    </div>
@endsection
