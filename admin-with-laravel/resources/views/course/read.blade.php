@extends('layouts.master')

@section('content')
    <div class="showCourseContainer overflow-auto px-3">
        <div class="row">
            <div class="col ms-1 my-3">
                <p class="fs-4 m-0 fw-bold text-capitalize">{{ __('messages.course') }} {{ __('messages.details') }}</p>
            </div>
            <div class="col d-flex justify-content-end align-items-center">
                <a href="{{ route('course.edit', $courses->courseId) }}">
                    <button type="button" class="btn bg-white shadow-sm">
                        <i class="fa-regular fa-pen-to-square ms-1 me-2"></i>
                        <span class="text-capitalize">{{ __('messages.edit') }}</span>
                    </button>
                </a>
            </div>
        </div>
        <div class="row gap-5 mb-4">
            <div class="col-3 ">
                <div class="row">
                    <div class="col shadow-sm bg-white p-2 text-center">
                        @if ($courses->course_image == null)
                            <img src="{{ asset('images/default-image.png') }}" alt="" class="courseShowImg">
                        @else
                            <img src="{{ asset('storage/' . $courses->course_image) }}" alt=""
                                class="courseShowImg">
                        @endif
                        <span
                            class="d-block fw-bold fs-5 text-muted text-capitalize py-2 my-1">{{ $courses->course_title }}</span>
                    </div>
                </div>

                <div class="row mt-5">
                    <div class="col rounded shadow-sm bg-white ">
                        <div class="row">
                            <div class="col mt-2 mb-3">
                                <span class="fw-bold fs-5 text-capitalize">
                                    {{ __('messages.course') }} {{ __('messages.info') }}
                                </span>
                            </div>
                            <div class="border-bottom py-2 d-flex justify-content-between">
                                <span class="fw-bold fw-bold fs-6 text-capitalize">{{ __('messages.duration') }}</span>
                                <span class="fs-6 text-muted text-capitalize">
                                    <span class="text-black fw-medium"> {{ $courses->course_duration }} </span>
                                    {{ __('messages.month') }}
                                </span>
                            </div>
                            <div class="border-bottom py-2 d-flex justify-content-between">
                                <span class="fw-bold fs-6 text-capitalize">{{ __('messages.author') }}</span>
                                <span class="fs-6 text-muted">
                                    {{ $courses->author_first_name }} {{ $courses->author_last_name }}
                                </span>
                            </div>
                            <div class="border-bottom py-2 d-flex justify-content-between">
                                <span class="fw-bold fs-6 text-capitalize">{{ __('messages.price') }}</span>
                                @if ($courses->course_price == 0)
                                    <span class="fs-6 text-muted">Free</span>
                                @else
                                    <span class="fs-6 text-muted text-capitalize">
                                        <span class="text-black">{{ $courses->course_price }}</span>
                                        {{ __('messages.kyat') }}
                                    </span>
                                @endif
                            </div>
                            <div class="border-bottom py-2 d-flex justify-content-between">
                                <span class="fw-bold fs-6 text-capitalize">{{ __('messages.date') }}</span>
                                <span class="fs-6 text-muted">
                                    {{ \Carbon\Carbon::parse($courses->coursesCreatedAt)->format('j-F-Y') }}
                                </span>
                            </div>
                            <div class="border-bottom py-2 d-flex justify-content-between">
                                <span class="fw-bold fs-6 text-capitalize">{{ __('messages.user') }}</span>
                                <span class="fs-6 fw-medium">{{ $courses->userCount }}</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col">
                <div class="row">
                    <div class="col bg-white py-2 px-4 ">
                        <p class="fw-bold fs-5 text-capitalize">{{ __('messages.description') }}</p>
                        <p class="text-muted fs-6 courseDescription overflow-auto">
                            <small>{{ $courses->course_description }}</small>
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col bg-white py-1 px-4 py-2 ">
                        <p class="fw-bold fs-5 text-capitalize">{{ __('messages.review') }}</p>
                        <div class="row px-2 overflow-auto courseComments">
                            <div class="col border rounded">
                                @foreach ($testimonials as $testimonial)
                                    <div class="row border-bottom py-1">
                                        <div class="col">
                                            <span class="d-block text-muted fs-6 py-1">
                                                <small>
                                                    {{ $testimonial->text }}
                                                </small>
                                            </span>
                                        </div>

                                        <div class="col-2 text-end">
                                            <span><i class="fa-regular fa-message fa-xs"></i></span>
                                            <span class="text-muted">
                                                <small> <i>{{ $testimonial->name }}</i></small>
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
