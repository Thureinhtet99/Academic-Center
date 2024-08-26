@extends('layouts.master')

@section('content')
    <div class="container overflow-auto category-index p-3">
        <div class="row mb-3">
            <div class="col-12 d-flex justify-content-between align-items-top">
                <p class="fs-4 m-0 fw-bold text-capitalize">{{ __('messages.catList') }}</p>
                <div class= "d-flex justify-content-end align-items-top">
                    <div>
                        <button type="button"
                            class="btn p-2 border text-capitalize @error('name') text-danger border-danger @enderror bg-white addCategoryBtn"
                            data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <i class="fa-solid fa-plus fa-lg "></i>
                            <small>{{ __('messages.addCat') }}</small>
                        </button>
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Category</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>

                                    <form action="{{ route('category.create') }}" method="post" id="postForm"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-body" id="modalBody">
                                            <label for="name"
                                                class="form-label fw-bold text-capitalize">{{ __('messages.name') }}</label>
                                            <input type="text" name="name" id="name"
                                                class="form-control @error('name') is-invalid @enderror"
                                                placeholder="Enter Category Name" value="{{ old('name') }}">
                                            @error('name')
                                                <span class="d-block invalid-feedback">
                                                    <small>{{ $message }}</small>
                                                </span>
                                            @enderror
                                            <label for="image"
                                                class="form-label fw-bold mt-3 text-capitalize">{{ __('messages.image') }}</label>
                                            <input type="file" name="image" id="" class="form-control">

                                            <label for="description"
                                                class="form-label mt-3 fw-bold text-capitalize">{{ __('messages.description') }}</label>
                                            <textarea name="description" id="description" cols="20" rows="5"
                                                class="form-control @error('description') is-invalid @enderror" placeholder="Enter Description">
                                                        {{ old('description') }}
                                                    </textarea>
                                            @error('description')
                                                <span class="d-block invalid-feedback">
                                                    <small>{{ $message }}</small>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="modal-footer">
                                            <button type="reset" class="btn border">
                                                <i class="fa-solid fa-arrows-rotate fa-lg"></i>
                                            </button>
                                            <button type="submit" class="btn btn-primary border">Submit</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row px-3 mb-3">
            @if (session('createSuccess'))
                <div class="col-2 d-flex border border-success rounded py-1 justify-content-between align-items-center">
                    <div class="text-success" role="alert">
                        {{ session('createSuccess') }}
                    </div>
                    <button class="btn btn-sm px-1 py-0" id="xmark">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            @endif
            @if (session('updateSuccess'))
                <div class="col-2 d-flex border border-primary rounded py-1 justify-content-between align-items-center">
                    <div class="text-primary" role="alert">
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
            <div class="col-12">
                @if (count($categories) == 0)
                    <div class="row">
                        <div class="col px-3">
                            <p class="text-muted"><i>There is no data.....</i></p>
                        </div>
                    </div>
                @else
                    <div>
                        <table class="table table-responsive categoryTable" id="categoryTable">
                            <thead>
                                <tr>
                                    <th class="col">#</th>
                                    <th class="col-2 text-center" scope="col-2">Image</th>
                                    <th class="col-2" scope="col-2">Name</th>
                                    <th class="col-4" scope="col-4">Description</th>
                                    <th class="col-1 text-center" scope="col-1">Courses</th>
                                    <th class="col-2" scope="col-2"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                    <tr>
                                        <td class="col">{{ $category->id }}</td>
                                        <td class="col-2 text-center">
                                            @if ($category->category_image == null)
                                                <img src="{{ asset('images/default-image.png') }}" alt=""
                                                    class="object-fit-cover categoryImg rounded">
                                            @else
                                                <img src="{{ asset('storage/' . $category->category_image) }}"
                                                    alt="" class="object-fit-cover categoryImg rounded">
                                            @endif
                                        </td>
                                        <td class="text-muted text-capitalize col-2">
                                            {{ $category->category_name }}
                                        </td>
                                        <td class="text-muted col-4">
                                            <small>{{ Str::words($category->category_description, 15, '.....') }}</small>
                                        </td>

                                        <td class="col-1 text-center"> {{ $category->course_count }} </td>

                                        <td class="col-2 text-center">
                                            <a href="{{ route('category.edit', $category->id) }}"
                                                class="text-decoration-none">
                                                <button class="btn btn-sm mx-1 shadow-sm">
                                                    <i class="fa-regular fa-pen-to-square"></i>
                                                </button>
                                            </a>
                                            <a href="{{ route('category.delete', $category->id) }}"
                                                class="text-decoration-none">
                                                <button class="btn btn-sm mx-1 shadow-sm">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('scriptSource')
    <script>
        let table = new DataTable('#categoryTable');
    </script>
@endsection
