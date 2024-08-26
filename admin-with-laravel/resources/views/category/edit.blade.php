@extends('layouts.master')

@section('content')
    <div class="container overflow-auto category-index p-3 ">
        <div class="row">
            <div class="col-8">
                <div class="col-12 mb-5 d-flex justify-content-between align-items-top">
                    <p class="fs-4 m-0 fw-bold">Lists of Category</p>
                </div>
                <div class="row mt-3">
                    <div class="col">
                        @if (count($categories) == 0)
                            <div class="row">
                                <div class="col px-3">
                                    <p class="text-muted">There is no data.....</p>
                                </div>
                            </div>
                        @else
                            <table class="table table-striped table-responsive" id="categoryTable">
                                <thead>
                                    <tr>
                                        <th class="col text-center" scope="col">#</th>
                                        <th class="col text-center" scope="col">Image</th>
                                        <th class="col" scope="col">Name</th>
                                        <th class="col" scope="col">Description</th>
                                        <th class="col text-center" scope="">Course</th>
                                        <th class="col-2" scope="col-2"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $category)
                                        <tr>
                                            <td class="col-1">{{ $category->id }}</td>
                                            <td class="col-2 text-center">
                                                @if ($category->category_image == null)
                                                    <img src="{{ asset('images/default-image.png') }}" alt=""
                                                        class="categoryImg object-fit-cover rounded">
                                                @else
                                                    <img src="{{ asset('storage/' . $category->category_image) }}"
                                                        alt="" class="categoryImg object-fit-cover rounded">
                                                @endif
                                            </td>
                                            <td class="col-2 text-muted text-capitalize">{{ $category->category_name }}
                                            </td>
                                            <td class="text-muted col-3">
                                                <small>{{ Str::words($category->category_description, 5, '.....') }}</small>
                                            </td>
                                            <td class="col-1 text-muted text-center"> -- </td>
                                            <td class="col-1 text-center">
                                                <a href="{{ route('category.edit', $category->id) }}"
                                                    class="text-decoration-none">
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
                        <p class="fs-4 m-0 fw-bold">Edit Category</p>
                    </div>
                    <div class="col-2">
                        <a href="{{ route('category.index') }}">
                            <button type="button" class="btn border">
                                <i class="fa-solid fa-arrow-left"></i>
                            </button>
                        </a>
                    </div>
                </div>

                <div class="row">
                    <div class="col my-2">
                        <form action="{{ route('category.update', $items->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <label for="name" class="form-label fw-bold">Name</label>
                            <input type="text" name="name" id="name"
                                class="form-control text-capitalize @error('name') is-invalid @enderror"
                                value="{{ old('name', $items->category_name) }}">
                            @error('name')
                                <span class="invalid-feedback ms-1">
                                    <small>{{ $message }}</small>
                                </span>
                            @enderror
                            <label for="image" class="form-label fw-bold mt-4">Category Image</label>
                            <input type="file" name="image" id="image" class="form-control">
                            <label for="description" class="form-label fw-bold mt-4">Description</label>
                            <textarea name="description" id="description" cols="30" rows="10"
                                class="form-control @error('description') is-invalid @enderror">
                                {{ old('description', $items->category_description) }}
                            </textarea>
                            @error('description')
                                <div class="invalid-feedback ms-1">
                                    <small>{{ $message }} </small>
                                </div>
                            @enderror
                            <div class="col mt-4 text-end">
                                <button type="submit" class="btn btn-primary border">Save</button>
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
