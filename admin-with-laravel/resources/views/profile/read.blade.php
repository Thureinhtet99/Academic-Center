@extends('layouts.master')

@section('content')
    <div class="showCourseContainer overflow-auto px-3">

        <div class="row mt-3 mb-4">
            <div class="col-10 d-flex align-items-center">
                <p class="fs-4 m-0 fw-bold text-capitalize">{{ auth()->user()->name }}'s {{__('messages.profile')}}</p>
                @if (session('updateSuccess'))
                    <div
                        class="col-2 mx-4 d-flex border border-success rounded px-2 py-1 justify-content-between align-items-center">
                        <div class="text-success" role="alert">
                            {{ session('updateSuccess') }}
                        </div>
                        <button class="btn btn-sm px-1 py-0" id="xmark">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                @endif
            </div>
            <div class="col-2 d-flex justify-content-end align-items-center">
                <a href="{{ route('profile.edit', auth()->user()->id) }}">
                    <button type="submit" class="btn bg-white shadow-sm">
                        <i class="fa-regular fa-pen-to-square ms-1 me-2"></i>
                        <span class="text-capitalize">{{__('messages.edit')}}</span>
                    </button>
                </a>
            </div>
        </div>

        <div class="row gap-5 px-2">
            <div class="col-3 p-0 d-flex flex-column">
                <div class="shadow-sm bg-white p-1 text-center rounded">
                    @if (auth()->user()->profile_photo_path == null)
                        @if (auth()->user()->gender == 'male')
                            <img src="{{ asset('images/default_user.png') }}" alt="" class="rounded profileImg">
                        @else
                            <img src="{{ asset('images/default_female.png') }}" alt="" class="rounded profileImg">
                        @endif
                    @else
                        <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}" alt=""
                            class="rounded profileImg">
                    @endif
                </div>
                <div class="mt-4 bg-white px-3 py-2">
                    <div class="d-flex flex-column">
                        <p class="fw-bold fs-4 my-2 text-capitalize">{{__('messages.edit')}}</</p>
                        <div class="mt-3">
                            <div class="border-bottom py-2 d-flex justify-content-between">
                                <span class="text-muted fs-6 text-capitalize">{{__('messages.name')}}</span>
                                <span class="fs-6 fw-medium">
                                    <span class="text-capitalize"> {{ auth()->user()->name }} </span>
                                </span>
                            </div>
                            <div class="border-bottom py-2 d-flex justify-content-between">
                                <span class="text-muted fs-6 text-capitalize">{{__('messages.email')}}</span>
                                <span class="fs-6 fw-medium">{{ auth()->user()->email }}</span>
                            </div>
                            <div class="border-bottom py-2 d-flex justify-content-between">
                                <span class="text-muted fs-6 text-capitalize">{{__('messages.gender')}}</span>
                                <span class="fs-6 text-capitalize fw-medium">{{ auth()->user()->gender }}</span>

                            </div>
                            <div class="border-bottom py-2 d-flex justify-content-between">
                                <span class="text-muted fs-6 text-capitalize">{{__('messages.phone')}}</span>
                                @if (auth()->user()->phone == null)
                                    <span class="fs-6 fw-medium">-----</span>
                                @else
                                    <span class="fs-6 fw-medium">{{ auth()->user()->phone }}</span>
                                @endif
                            </div>
                            <div class="py-2 d-flex justify-content-between">
                                <span class="text-muted fs-6 text-capitalize">{{__('messages.location')}}</span>
                                @if (auth()->user()->location == null)
                                    <span class="fs-6 fw-medium">-----</span>
                                @else
                                    <span class="fs-6 fw-medium">{{ auth()->user()->location }}</span>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col p-0 d-flex flex-column ">
                <div class="bg-white px-3 py-2">
                    <p class="fw-bold fs-5 text-capitalize">{{__('messages.about')}}</p>
                    <p class="text-muted fs-6 courseDescription overflow-auto mt-2">
                        @if (auth()->user()->about == null)
                            <small>-----</small>
                        @else
                            <small>{{ auth()->user()->about }}</small>
                        @endif
                    </p>
                </div>

            </div>
        </div>

    </div>
@endsection
