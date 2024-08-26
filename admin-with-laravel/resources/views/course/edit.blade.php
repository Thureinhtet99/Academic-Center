@extends('layouts.master')

@section('content')
    <div class="container editCourseContainer ps-3 overflow-auto">
        <form action="{{ route('course.update', $courses->courseId) }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-3 ms-1 my-3">
                    <p class="fs-4 m-0 fw-bold text-capitalize">{{ __('messages.editCourse') }}</p>
                </div>
                @if (session('deleteSuccess'))
                    <div class="col-2 d-flex rounded align-items-center">
                        <div class="text-danger" role="alert">
                            {{ session('deleteSuccess') }}
                        </div>
                        <button class="btn btn-sm px-1 py-0" id="xmark">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                @endif
                <div class="col d-flex justify-content-end align-items-center">
                    <button type="submit" class="btn bg-primary text-white text-capitalize">
                        <i class="fa-regular fa-floppy-disk mx-1"></i>
                        <span>{{ __('messages.submit') }}</span>
                    </button>
                </div>
            </div>

            <div class="row gap-5 mb-4">
                <div class="col-3 ">
                    <div class="row">
                        <div class="col shadow-sm bg-white p-2 text-center">
                            @if ($courses->course_image == null)
                                <img src="{{ asset('images/default-image.png') }}" alt=""
                                    class=" object-fit-cover courseShowImg">
                            @else
                                <img src="{{ asset('storage/' . $courses->course_image) }}" alt=""
                                    class=" object-fit-cover courseShowImg">
                            @endif
                            <input type="file" class="form-control mt-2" name="image" id="">
                            <input type="text" name="title" id="" class="form-control text-capitalize my-1"
                                value="{{ old('title', $courses->course_title) }}">
                        </div>
                    </div>

                    <div class="row mt-5">
                        <div class="col rounded shadow-sm bg-white ">
                            <div class="row">
                                <div class="col mt-2 mb-3">
                                    <span class="fw-bold fs-4 text-capitalize">
                                        {{ __('messages.course') }} {{ __('messages.info') }}
                                    </span>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="text-muted col mt-1 fs-6 text-capitalize">{{ __('messages.duration') }}</div>
                                <div class="fs-6 col px-2 fw-medium">
                                    <div class="input-group">
                                        <input type="number" class="form-control" name="duration"
                                            value="{{ old('duration', $courses->course_duration) }}">
                                        <span class="input-group-text p-1">
                                            <small class=" text-capitalize">{{ __('messages.month') }}</small>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="text-muted col mt-1 fs-6 text-capitalize">{{ __('messages.category') }}</div>
                                <div class="fs-6 col px-2 fw-medium">
                                    <select name="authorName" id="" class="form-select text-capitalize">
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                @if ($category->id == $courses->category_id) selected @endif>
                                                {{ $category->category_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="text-muted col mt-1 fs-6 text-capitalize">{{ __('messages.author') }}</div>
                                <div class="fs-6 col px-2 fw-medium">
                                    <select name="authorName" id="" class="form-select">
                                        @foreach ($authors as $author)
                                            <option value="{{ $author->id }}"
                                                @if ($author->id == $courses->author_id) selected @endif>
                                                {{ $author->author_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="text-muted col mt-1 fs-6 text-capitalize">{{ __('messages.price') }}</div>
                                <div class="fs-6 col px-2 fw-medium">
                                    <div class="input-group">
                                        <input type="number" class="form-control" name="price"
                                            value="{{ old('price', $courses->course_price) }}">
                                        <span class="input-group-text p-1">
                                            <small>{{ __('messages.kyat') }}</small>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="border-bottom py-2 d-flex justify-content-between">
                                <span class="text-muted fs-6 text-capitalize">{{ __('messages.user') }}</span>
                                <span class="fs-6 fw-medium">{{ $courses->userCount }}</span>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col">
                    <div class="row">
                        <div class="col bg-white py-2 px-4 ">
                            <p class="fw-bold fs-5  text-capitalize">{{ __('messages.description') }}</p>
                            <textarea name="description" id="" cols="30" rows="8" class="form-control">
                                {{ old('description', $courses->course_description) }}
                            </textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col bg-white py-1 px-4 py-2 ">
                            <p class="fw-bold fs-5 text-capitalize">{{ __('messages.review') }}</p>
                            <div class="row px-2 overflow-auto editCourseComments">
                                <div class="col border rounded">
                                    @if (count($testimonials) == 0)
                                        <div class="row">
                                            <div class="col">
                                                <span
                                                    class="text-muted text-capitalize"><i>{{ __('messages.noTestimonial') }}</i></span>
                                            </div>
                                        </div>
                                    @else
                                        @foreach ($testimonials as $testimonial)
                                            <div class="row border-bottom py-1">
                                                <div class="col">
                                                    <span class="d-block text-muted fs-6 py-1">
                                                        <small>
                                                            {{ $testimonial->text }}
                                                        </small>
                                                    </span>
                                                </div>
                                                <div class="col-2 px-0 d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <span><i class="fa-regular fa-message fa-xs"></i></span>
                                                        <span class="text-muted">
                                                            <small> <i>{{ $testimonial->name }}</i> </small>
                                                        </span>
                                                    </div>
                                                    <span>
                                                        <a
                                                            href="{{ route('testimonial.delete', $testimonial->testimonialId) }}">
                                                            <button type="button" class="btn btn-sm">
                                                                <i class="fa-regular fa-trash-can"></i>
                                                            </button>
                                                        </a>
                                                    </span>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>
@endsection
