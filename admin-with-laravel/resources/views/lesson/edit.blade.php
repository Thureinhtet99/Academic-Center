@extends('layouts.master')

@section('content')
    <div class="container p-3">

        <div class="row">
            <div class="col text-center">
                <span class="fs-4 m-0 fw-bold">Edit Lesson</span>
            </div>
        </div>

        <form action="{{ route('lesson.update', $lessons->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row mt-4">
                <div class="col-6">
                    <div class="row">
                        <div class="col-6">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" id="name" class="form-control text-capitalize"
                                placeholder="Enter Lesson Name" value="{{ old('lesson_name', $lessons->lesson_name) }}">
                            @error('name')
                                <span class="d-block invalid-feedback">
                                    <small>{{ $message }}</small>
                                </span>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label for="lessonVideo" class="form-label fw-bold">Lesson Video</label>
                            <input type="file" name="lessonVideo" class="form-control"
                                value="{{ old('lesson_video', $lessons->lesson_video) }}">
                            @error('lessonVideo')
                                <span class="d-block invalid-feedback">
                                    <small>{{ $message }}</small>
                                </span>
                            @enderror
                        </div>
                        <div class="col-12 mt-4">
                            <label for="description" class="form-label mt-3">Description</label>
                            <textarea name="description" id="description" cols="30" rows="12" class="form-control"
                                placeholder="Enter Lesson Description">
                                {{ old('description', $lessons->lesson_description) }}
                            </textarea>
                            @error('description')
                                <span class="d-block invalid-feedback">
                                    <small>{{ $message }}</small>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="row">
                        <div class="col-6">
                            <label for="courseName" class="form-label">Course Name</label>
                            <select name="courseName" id="courseName" class="form-select text-capitalize">
                                <option value="">Choose Course</option>
                                @foreach ($courses as $course)
                                    <option value="{{ $course->id }}" class="text-capitalize"
                                        @if ($course->id == $lessons->course_id) selected @endif>
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
                    <button type="reset" class="btn border">Reset</button>
                    <button type="submit" class="btn btn-primary border">Submit</button>
                </div>
            </div>
        </form>
    </div>
@endsection
