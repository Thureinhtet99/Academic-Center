@extends('layouts.master')

@section('content')
    <div class="showCourseContainer overflow-auto px-3">
        <div class="row mt-3 mb-4">
            <div class="col-10 d-flex align-items-center">
                <p class="fs-4 m-0 fw-bold text-capitalize">{{ auth()->user()->name }}'s profile</p>
            </div>
            <div class="col-2 d-flex justify-content-end align-items-center">
                <a href="{{ route('profile.read', auth()->user()->id) }}">
                    <button type="button" class="btn bg-white shadow-sm">
                        <i class="fa-solid fa-arrow-left mx-1"></i>
                    </button>
                </a>
            </div>
        </div>

        <form action="{{ route('profile.update', auth()->user()->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row gap-5 px-2">
                <div class="col-3 p-0 d-flex flex-column">
                    <div class="shadow-sm bg-white p-1 text-center rounded">
                        @if (auth()->user()->profile_photo_path == null)
                            @if (auth()->user()->gender == 'male')
                                <img src="{{ asset('images/default_user.png') }}" alt="" class="profileImg">
                            @else
                                <img src="{{ asset('images/default_female.jpg') }}" alt="" class="profileImg">
                            @endif
                        @else
                            <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}" alt=""
                                class="rounded profileImg">
                        @endif
                        <div class="row mt-1">
                            <div class="col">
                                <input type="file" name="image" id="" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 bg-white px-3 py-2">
                        <div class="d-flex flex-column">
                            <p class="fw-bold fs-4 my-2">Infos</p>
                            <div class="mt-3">
                                <div class="py-1 d-flex justify-content-between">
                                    <input type="text" class="form-control" placeholder="Name" name="name"
                                        value="{{ old('name', auth()->user()->name) }}" id="">
                                    @error('name')
                                        <span class="mx-1 text-danger">
                                            <small>{{ $message }}</small>
                                        </span>
                                    @enderror
                                </div>
                                <div class="py-1 mt-2 d-flex justify-content-between">
                                    <input type="email" class="form-control" placeholder="Email" name="email"
                                        value="{{ old('email', auth()->user()->email) }}" id="">
                                    @error('email')
                                        <span class="mx-1 text-danger">
                                            <small>{{ $message }}</small>
                                        </span>
                                    @enderror
                                </div>
                                <div class="py-1 mt-2 d-flex align-items-center justify-content-between">
                                    <select name="gender" class="form-select w-75">
                                        <option value="">Choose Gender</option>
                                        <option value="male" @if (auth()->user()->gender == 'male') selected @endif>
                                            Male
                                        </option>
                                        <option value="female" @if (auth()->user()->gender == 'female') selected @endif>
                                            Female
                                        </option>
                                    </select>
                                </div>
                                @error('gender')
                                    <div class="my-0">
                                        <span class="mx-1 my-0 text-danger">
                                            <small>{{ $message }}</small>
                                        </span>
                                    </div>
                                @enderror

                                <div class="py-1 mt-2 d-flex justify-content-between">
                                    <input type="text" class="form-control" placeholder="Phone" name="phone"
                                        value="{{ old('phone', auth()->user()->phone) }}" id="">
                                    @error('phone')
                                        <span class="mx-1 text-danger">
                                            <small>{{ $message }}</small>
                                        </span>
                                    @enderror
                                </div>
                                <div class="py-1 mt-2 d-flex justify-content-between">
                                    <input type="text" name="location" id="location" list="countryList"
                                        placeholder="Enter Location" class="form-control w-75"
                                        value="{{ old('location', auth()->user()->location) }}">
                                    <datalist id="countryList">
                                        @if (isset($countries))
                                            @foreach ($countries as $country)
                                                <option value="{{ $country['name'] }}" class=" text-capitalize">
                                                    {{ $country['name'] }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </datalist>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col p-0 d-flex flex-column">
                    <div class="bg-white px-3 py-2">
                        <p class="fw-bold fs-5">About Me</p>
                        <textarea name="about" class="form-control text-muted fs-6" id="" cols="30" rows="8"
                            placeholder="Enter Your About">
                            {{ old('about', auth()->user()->about) }}
                        </textarea>
                        <div class="row my-1">
                            <div class="col">
                                <button type="submit" class="btn btn-primary float-end">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
