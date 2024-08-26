@extends('layouts.master')

@section('content')
    <div class="container p-3">
        <div class="row">
            <div class="col text-center">
                <span class="fs-4 m-0 fw-bold text-capitalize">{{ __('messages.addNewCourse') }}</span>
            </div>
        </div>

        <form action="{{ route('course.create') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row mt-4">
                <div class="col">
                    <label for="title" class="form-label fw-bold text-capitalize">{{ __('messages.title') }}</label>
                    <input type="text" name="title" id="title"
                        class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}">
                    @error('title')
                        <span class="d-block invalid-feedback">
                            <small>{{ $message }}</small>
                        </span>
                    @enderror
                </div>
                <div class="col">
                    <label for="authorName" class="form-label fw-bold text-capitalize">
                        {{ __('messages.author') }} {{ __('messages.name') }}
                    </label>
                    <select name="authorName" id="authorName"
                        class="form-select text-capitalize @error('authorName') is-invalid @enderror">
                        <option value="" class="text-capitalize"> {{ __('messages.chooseAuthorName') }}</option>
                        @foreach ($authors as $author)
                            <option value="{{ $author->id }}" class="text-capitalize">
                                {{ $author->author_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('authorName')
                        <span class="d-block invalid-feedback">
                            <small>{{ $message }}</small>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row mt-3">
                <div class="col">
                    <label for="category" class="form-label fw-bold text-capitalize">{{ __('messages.category') }}</label>
                    <select name="courseCategory" id="category"
                        class="form-select text-capitalize @error('courseCategory') is-invalid @enderror">
                        <option value="" class="fw-bold text-capitalize">{{ __('messages.chooseCat') }}</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" class="text-capitalize">
                                {{ $category->category_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('courseCategory')
                        <span class="d-block invalid-feedback">
                            <small>{{ $message }}</small>
                        </span>
                    @enderror
                </div>
                <div class="col">
                    <label for="duration" class="form-label fw-bold text-capitalize">{{ __('messages.duration') }}</label>
                    <div class="input-group">
                        <input type="text" name="duration" id="duration"
                            class="form-control @error('duration') is-invalid @enderror" value="{{ old('duration') }}">
                        <span class="input-group-text">Months</span>
                    </div>
                    @error('duration')
                        <span class="d-block invalid-feedback">
                            <small>{{ $message }}</small>
                        </span>
                    @enderror
                </div>
                <div class="col">
                    <label for="image" class="form-label fw-bold text-capitalize">{{ __('messages.image') }}</label>
                    <input type="file" name="image" id="image" class="form-control">
                </div>
                <div class="col">
                    <label for="price" class="form-label fw-bold text-capitalize">{{ __('messages.price') }}</label>
                    <div class="input-group">
                        <input type="text" name="price" class="form-control @error('price') is-invalid @enderror"
                            value="{{ old('price') }}">
                        <span class="input-group-text">MMK</span>
                    </div>
                    @error('price')
                        <span class="d-block invalid-feedback">
                            <small>{{ $message }}</small>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row mt-3">
                <div class="col">
                    <label for="description"
                        class="form-label fw-bold text-capitalize">{{ __('messages.description') }}</label>
                    <textarea name="description" id="description" cols="30" rows="9"
                        class="form-control @error('description') is-invalid @enderror" value="{{ old('description') }}">
                    </textarea>
                    @error('description')
                        <span class="d-block invalid-feedback">
                            <small>{{ $message }}</small>
                        </span>
                    @enderror
                </div>
                <div class="col">
                    <label for="about" class="form-label fw-bold text-capitalize">{{ __('messages.about') }}</label>
                    <textarea name="about" id="about" cols="30" rows="9"
                        class="form-control @error('about') is-invalid @enderror" value="{{ old('about') }}">
                    </textarea>
                    @error('about')
                        <span class="d-block invalid-feedback">
                            <small>{{ $message }}</small>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row mt-4 px-2">
                <div class="col-2 offset-10">
                    <div class=" float-end ">
                        <button type="reset" class="btn border"><i class="fa-solid fa-arrows-rotate fa-lg"></i></button>
                        <button type="submit"
                            class="btn btn-primary border text-capitalize">{{ __('messages.submit') }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
