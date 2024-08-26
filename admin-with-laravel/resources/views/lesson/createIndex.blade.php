@extends('layouts.master')

@section('content')
    <div class="container p-3">

        <div class="row">
            <div class="col text-center">
                <span class="fs-4 m-0 fw-bold text-capitalize">{{ __('messages.addNewLesson') }}</span>
            </div>
        </div>

        <form action="{{ route('lesson.create') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row mt-4">
                <div class="col-6">
                    <div class="row">
                        <div class="col-6">
                            <label for="name"
                                class="form-label fw-bold text-capitalize">{{ __('messages.name') }}</label>
                            <input type="text" name="name" id="name" class="form-control">
                            @error('name')
                                <span class="d-block invalid-feedback">
                                    <small>{{ $message }}</small>
                                </span>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label for="lessonVideo" class="form-label fw-bold text-capitalize">
                                {{ __('messages.lesson') }} {{ __('messages.video') }}
                            </label>
                            <input type="file" name="lessonVideo" class="form-control">
                            @error('lessonVideo')
                                <span class="d-block invalid-feedback">
                                    <small>{{ $message }}</small>
                                </span>
                            @enderror
                        </div>
                        <div class="col-12 mt-4">
                            <label for="description"
                                class="form-label fw-bold mt-3 text-capitalize">{{ __('messages.description') }}</label>
                            <textarea name="description" id="description" cols="30" rows="12" class="form-control">
                            </textarea>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="row">
                        <div class="col-6">
                            <label for="courseName" class="form-label fw-bold text-capitalize">
                                {{ __('messages.course') }} {{ __('messages.name') }}
                            </label>
                            <select name="courseName" id="courseName" class="form-select text-capitalize">
                                <option value="">Choose Course</option>
                                @foreach ($courses as $course)
                                    <option value="{{ $course->id }}" class="text-capitalize">
                                        {{ $course->course_title }}
                                    </option>
                                @endforeach
                            </select>
                            @error('courseName')
                                <span class="d-block invalid-feedback">
                                    <small>{{ $message }}</small>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-12 text-end">
                    <button type="reset" class="btn border"><i class="fa-solid fa-arrows-rotate"></i></button>
                    <button type="submit"
                        class="btn btn-primary border text-capitalize">{{ __('messages.submit') }}</button>
                </div>
            </div>
        </form>
    </div>
@endsection
