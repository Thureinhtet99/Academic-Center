@extends('layouts.master')

@section('content')
    <div class="container overflow-auto category-index p-3 ">
        <div class="row">
            <div class="col-8">
                <div class="col-12 mb-5 d-flex justify-content-between align-items-top">
                    <p class="fs-4 m-0 fw-bold text-capitalize">{{ __('messages.blog') }} {{ __('messages.list') }}</p>
                </div>
                <div class="row mt-3">
                    <div class="col">
                        @if (count($blogs) == 0)
                            <div class="row">
                                <div class="col px-3">
                                    <p class="text-muted">There is no data.....</p>
                                </div>
                            </div>
                        @else
                            <table class="table table-striped table-responsive" id="categoryTable">
                                <thead>
                                    <tr>
                                        <th class="col text-center text-capitalize" scope="col">#</th>
                                        <th class="col text-center text-capitalize" scope="col">
                                            {{ __('messages.image') }}
                                        </th>
                                        <th class="col text-capitalize" scope="col">
                                            {{ __('messages.title') }}
                                        </th>
                                        <th class="col text-capitalize" scope="col">
                                            {{ __('messages.description') }}
                                        </th>
                                        <th class="col-2 text-capitalize" scope="col-2"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($blogs as $blog)
                                        <tr>
                                            <td class="col-1">{{ $blog->id }}</td>
                                            <td class="col-2 text-center">
                                                @if ($blog->blog_image == null)
                                                    <img src="{{ asset('images/default-image.png') }}" alt=""
                                                        class="categoryImg rounded w-75 object-fit-cover">
                                                @else
                                                    <img src="{{ asset('storage/' . $blog->blog_image) }}" alt=""
                                                        class="categoryImg rounded w-75 object-fit-cover">
                                                @endif
                                            </td>
                                            <td class="col-2 text-muted text-capitalize">{{ $blog->blog_title }}
                                            </td>
                                            <td class="col-3 text-muted ">
                                                <small>{{ Str::words($blog->blog_description, 5, '.....') }}</small>
                                            </td>
                                            <td class="col-1 text-center">
                                                <a href="{{ route('blog.edit', $blog->id) }}" class="text-decoration-none">
                                                    <button class="btn btn-sm border">
                                                        <i class="fa-regular fa-pen-to-square"></i>
                                                    </button>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif

                    </div>
                </div>
            </div>

            <div class="col-4 rounded shadow-sm">
                <div class="row">
                    <div class="col">
                        <p class="fs-4 m-0 fw-bold">Edit Blog</p>
                    </div>
                    <div class="col-2">
                        <a href="{{ route('blog.index') }}">
                            <button type="button" class="btn border">
                                <i class="fa-solid fa-arrow-left"></i>
                            </button>
                        </a>
                    </div>
                </div>

                <div class="row">
                    <div class="col my-2">
                        <form action="{{ route('blog.update', $items->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <label for="title" class="form-label fw-bold text-capitalize">
                                {{ __('messages.title') }}
                            </label>
                            <input type="text" name="title" id="title"
                                class="form-control text-capitalize @error('title') is-invalid @enderror"
                                value="{{ old('title', $items->blog_title) }}">
                            @error('title')
                                <span class="invalid-feedback ms-1">
                                    <small>{{ $message }}</small>
                                </span>
                            @enderror
                            <div class="row">
                                <div class="col-6">
                                    <label for="category" class="form-label fw-bold text-capitalize mt-4">
                                        {{ __('messages.category') }}
                                    </label>
                                    <select name="category" id="category"
                                        class="form-select text-capitalize @error('category') is-invalid @enderror">
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" class="text-capitalize">
                                                {{ $category->category_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category')
                                        <span class="invalid-feedback ms-1">
                                            <small>{{ $message }}</small>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-6">
                                    <label for="author" class="form-label fw-bold text-capitalize mt-4">
                                        {{ __('messages.author') }}
                                    </label>
                                    <input type="text" name="author" id="author" class="form-control"
                                        value="{{ old('author', $items->author->author_name) }}" disabled>
                                </div>
                            </div>

                            <label for="image" class="form-label fw-bold mt-4 text-capitalize">
                                {{ __('messages.image') }}
                            </label>
                            <input type="file" name="image" id="image" class="form-control">
                            <label for="description" class="form-label fw-bold mt-4 text-capitalize">
                                {{ __('messages.description') }}
                            </label>
                            <textarea name="description" id="description" cols="30" rows="7"
                                class="form-control @error('description') is-invalid @enderror">
                                {{ old('description', $items->blog_description) }}
                            </textarea>
                            @error('description')
                                <div class="invalid-feedback ms-1">
                                    <small>{{ $message }} </small>
                                </div>
                            @enderror
                            <div class="col mt-4 text-end">
                                <button type="submit" class="btn btn-primary text-capitalize">
                                    {{ __('messages.save') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('scriptSource')
    <script>
        let table = new DataTable('#categoryTable');
    </script>
@endsection
