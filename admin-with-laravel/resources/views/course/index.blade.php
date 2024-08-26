@extends('layouts.master')

@section('content')
    <div class="container p-3">
        <div class="row mb-3">
            <div class="col-12 d-flex justify-content-between align-items-top">
                <p class="fs-4 m-0 fw-bold text-capitalize">{{ __('messages.course') }}</p>
                <div class= "d-flex justify-content-end align-items-top">
                    <div>
                        <a href="{{ route('course.createIndex') }}">
                            <button type="button" class="btn p-2 border bg-white mx-3">
                                <i class="fa-solid fa-plus fa-lg"></i>
                                <small class="text-capitalize">{{ __('messages.addNewCourse') }}</small>
                            </button>
                        </a>
                    </div>
                    <div>
                        <form action="{{ route('course.index') }}" method="get">
                            @csrf
                            <div class="shadow-sm bg-white rounded px-2 d-flex">
                                <input type="search" name="search" class="form-control me-2 px-2 border-0"
                                    value="{{ request('search') }}" placeholder="{{ __('messages.searchCourses') }}">
                                <button type="submit" class="py-2 px-3 bg-white border-0">
                                    <i class="fa-solid fa-magnifying-glass fa-lg"></i>
                                </button>
                            </div>
                            <span class="d-block text-end text-muted me-2">
                                <small>{{ count($courses) }} {{ __('messages.result') }}</small>
                            </span>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row px-3 mb-3">
            @if (session('updateSuccess'))
                <div class="col-2 d-flex border border-success rounded py-1 justify-content-between align-items-center">
                    <div class="text-success" role="alert">
                        {{ session('updateSuccess') }}
                    </div>
                    <button class="btn btn-sm px-1 py-0" id="xmark">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            @endif
            @if (session('deleteSuccess'))
                <div class="col-2 d-flex border border-danger rounded py-1 justify-content-between align-items-center">
                    <div class="text-danger" role="alert">
                        {{ session('deleteSuccess') }}
                    </div>
                    <button class="btn btn-sm px-1 py-0" id="xmark">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            @endif
        </div>

        <div class="row">
            <div class="col-12 d-flex py-0 justify-content-between align-items-center">
                <div class="row">
                    <div class="col px-3 overflow-auto courseOverFlow">
                        @if (count($courses) == 0)
                            <div class="row">
                                <div class="col">
                                    <span class="text-muted text-capitalize"><i>{{ __('messages.noData') }}</i></span>
                                </div>
                            </div>
                        @else
                            @foreach ($courses as $course)
                                <div class="row bg-white rounded mb-3">
                                    <div class="col-3">
                                        <div class="row">
                                            <div class="col">
                                                @if ($course->course_image == null)
                                                    <img src="{{ asset('images/default-image.png') }}"
                                                        class="d-block py-1 courseImg" alt="">
                                                @else
                                                    <img src="{{ asset('storage/' . $course->course_image) }}"
                                                        class="d-block py-1 courseImg" alt="">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col d-flex flex-column justify-content-around">
                                        <div class="row">
                                            <div class="col-1 offset-11 p-0 text-end">
                                                <div class="btn-group dropstart">
                                                    <button type="button" class="btn btn-sm" data-bs-toggle="dropdown"
                                                        aria-expanded="false">
                                                        <i class="fa-solid fa-ellipsis"></i>
                                                    </button>
                                                    <ul class="dropdown-menu p-0">
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="{{ route('course.edit', $course->courseId) }}">
                                                                <small
                                                                    class="text-capitalize">{{ __('messages.edit') }}</small>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="{{ route('course.delete', $course->courseId) }}">
                                                                <small
                                                                    class="text-capitalize">{{ __('messages.delete') }}</small>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <span class="fs-4 fw-bold text-capitalize">{{ $course->course_title }}
                                                </span>
                                            </div>

                                            <div class="col-2 text-end py-0 px-1">
                                                <i class="fa-solid fa-tag"></i>
                                                <span class="px-1">
                                                    <a href="" class="text-decoration-none text-black">
                                                        <small class="text-capitalize">
                                                            <i>{{ $course->category_name }}</i>
                                                        </small>
                                                    </a>
                                                </span>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col">
                                                <span class="text-muted">
                                                    <small>{{ Str::words($course->course_description, 55, '.....') }}</small>
                                                </span>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-3">
                                                <span class="text-muted fw-medium text-uppercase">
                                                    <i>
                                                        {{ Str::limit($course->author_name, 10, '.....') }}
                                                    </i>
                                                </span>
                                            </div>
                                            <div class="col-2 p-0">
                                                <span class="text-muted">
                                                    <small>
                                                        <i>
                                                            {{ \Carbon\Carbon::parse($course->coursesCreatedAt)->format('j-F-Y') }}
                                                        </i>
                                                    </small>
                                                </span>
                                            </div>
                                            <div class="col text-center">
                                                <a href="{{ route('course.read', $course->courseId) }}"
                                                    class="text-decoration-none">
                                                    <i class="fa-regular fa-comments text-black"></i>
                                                    <span
                                                        class="text-muted"><small>{{ $course->testimonialCount }}</small></span>
                                                </a>
                                            </div>
                                            <div class="col text-end">
                                                <a href="{{ route('course.read', $course->courseId) }}"
                                                    class="text-decoration-none text-capitalize">
                                                    <span><small><i>{{ __('messages.viewDetails') }} >>></i></small></span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
