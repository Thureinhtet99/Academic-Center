@extends('layouts.master')

@section('content')
    <div class="container overflow-auto category-index p-3">
        <div class="row mb-3">
            <div class="col-12 d-flex justify-content-between align-items-top">
                <p class="fs-4 m-0 fw-bold text-capitalize">{{ __('messages.authorList') }}</p>
                <div class= "d-flex justify-content-end align-items-top">
                    <div>
                        <a href="{{ route('author.createIndex') }}">
                            <button type="button" class="btn p-2 border bg-white text-capitalize">
                                <i class="fa-solid fa-plus fa-lg"></i>
                                <small>{{ __('messages.addAuthor') }}</small>
                            </button>
                        </a>
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
                @if (count($authors) == 0)
                    <div class="row">
                        <div class="col px-3">
                            <p class="text-muted"><i>There is no data .....</i></p>
                        </div>
                    </div>
                @else
                    <table class="table table-responsive" id="categoryTable">
                        <thead>
                            <tr>
                                <th class="col">#</th>
                                <th class="col-2 text-center text-capitalize" scope="col">{{ __('messages.image') }}</th>
                                <th class="col text-capitalize" scope="col">{{ __('messages.name') }}</th>
                                <th class="col text-capitalize" scope="col">{{ __('messages.degree') }}</th>
                                <th class="col text-capitalize" scope="col-3">{{ __('messages.email') }}</th>
                                <th class="col-1 text-capitalize" scope="col">{{ __('messages.gender') }}</th>
                                <th class="col-2 text-capitalize" scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($authors as $author)
                                <tr>
                                    <td class="col">{{ $author->id }}</td>
                                    <td class="col-2 text-center">
                                        @if ($author->author_image == null)
                                            @if ($author->author_gender == 'male')
                                                <img src="{{ asset('images/default_user.png') }}"
                                                    class=" object-fit-cover categoryImg rounded" alt="">
                                            @endif
                                            @if ($author->author_gender == 'female')
                                                <img src="{{ asset('images/default_female.jpg') }}"
                                                    class=" object-fit-cover categoryImg rounded" alt="">
                                            @endif
                                        @else
                                            <img src="{{ asset('storage/' . $author->author_image) }}" alt=""
                                                class=" object-fit-cover categoryImg rounded">
                                        @endif
                                    </td>
                                    <td class="col text-muted text-capitalize ">
                                        {{ $author->author_name }}
                                    </td>
                                    <td class="text-muted col">
                                        <small class="text-capitalize">{{ $author->author_degree }}</small>
                                    </td>
                                    <td class="col text-muted">{{ $author->author_email }}</td>
                                    <td class="col-1 text-muted text-capitalize">{{ $author->author_gender }}</td>
                                    <td class="col-2 text-center">
                                        <a href="{{ route('author.edit', $author->id) }}" class="text-decoration-none">
                                            <button class="btn btn-sm mx-1 shadow-sm">
                                                <i class="fa-regular fa-pen-to-square"></i>
                                            </button>
                                        </a>
                                        <a href="{{ route('author.delete', $author->id) }}" class="text-decoration-none">
                                            <button type="submit" class="btn btn-sm mx-1 shadow-sm">
                                                <i class="fa-solid fa-trash-can"></i>
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
@endsection

@section('scriptSource')
    <script>
        let table = new DataTable('#categoryTable');
    </script>
@endsection
