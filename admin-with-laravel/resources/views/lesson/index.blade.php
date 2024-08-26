@extends('layouts.master')

@section('content')
    <div class="container overflow-auto p-3 lessonContainer">

        <div class="row mb-3">
            <div class="col-12 d-flex justify-content-between align-items-top">
                <p class="fs-4 m-0 fw-bold text-capitalize">{{ __('messages.lesson') }}</p>
                <div class= "d-flex justify-content-end align-items-top">
                    <div>
                        <a href="{{ route('lesson.createIndex') }}">
                            <button type="button" class="btn p-2 border bg-white mx-3">
                                <i class="fa-solid fa-plus fa-lg"></i>
                                <small class="text-capitalize">{{ __('messages.addNewLesson') }}</small>
                            </button>
                        </a>
                    </div>
                    <div>
                        <form action="{{ route('lesson.index') }}" method="get">
                            @csrf
                            <div class="shadow-sm bg-white rounded px-2 d-flex">
                                <input type="search" name="search"
                                    class="form-control me-2 px-2 border-0 text-capitalize searchBar"
                                    value="{{ request('search') }}" placeholder="{{ __('messages.searchLesson') }}">
                                <button type="submit" class="py-2 px-3 bg-white border-0">
                                    <i class="fa-solid fa-magnifying-glass fa-lg"></i>
                                </button>
                            </div>
                            <span class="d-block text-end text-muted">
                                <small>{{ $lessons->total() }} {{ __('messages.result') }}</small>
                            </span>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row px-3 mb-2">
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
            <div class="col">
                @if (count($lessons) == 0)
                    <div class="row">
                        <div class="col px-3">
                            <p class="text-muted"><i>There is no data .....</i></p>
                        </div>
                    </div>
                @else
                    <table class="table table-responsive">
                        <thead>
                            <tr>
                                <th class="col-1 text-center" scope="col">#</th>
                                <th class="text-center text-capitalize" scope="col">
                                    {{ __('messages.course') }} {{ __('messages.name') }}
                                </th>
                                <th class="text-center text-capitalize" scope="col">
                                    {{ __('messages.lesson') }} {{ __('messages.name') }}</th>
                                <th class="text-center text-capitalize" scope="col">{{ __('messages.description') }}
                                </th>
                                <th class="text-center text-capitalize" scope="col">{{ __('messages.video') }} </th>
                                <th scope="col-2"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lessons as $lesson)
                                <tr>
                                    <td class="col-1 text-muted text-capitalize text-center">
                                        {{ $lesson->id }}
                                    </td>
                                    <td class="col text-muted text-capitalize text-center">
                                        <small>
                                            {{ $lesson->course_title }}
                                        </small>
                                    </td>
                                    <td class="col text-muted text-capitalize text-center">
                                        <small>
                                            {{ $lesson->lesson_name }}
                                        </small>
                                    </td>
                                    <td class="col-3 text-muted">
                                        <small>{{ Str::words($lesson->lesson_description, 15, '.....') }}</small>
                                    </td>
                                    <td class="col-3">
                                        @if ($lesson->lesson_video == null)
                                            <img src="{{ asset('images/default-video.jpg') }}" alt=""
                                                class="lessonVideos">
                                        @else
                                            <video src="{{ asset('storage/' . $lesson->lesson_video) }}"
                                                class="lessonVideos" controls>
                                            </video>
                                        @endif
                                    </td>
                                    <td class="col-2 text-center">
                                        <a href="{{ route('lesson.edit', $lesson->id) }}" class="text-decoration-none">
                                            <button class="btn btn-sm mx-1 shadow-sm">
                                                <i class="fa-regular fa-pen-to-square"></i>
                                            </button>
                                        </a>
                                        <a href="{{ route('lesson.delete', $lesson->id) }}" class="text-decoration-none">
                                            <button class="btn btn-sm mx-1 shadow-sm">
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
        <div class="row mt-1">
            <div class="col py-0">
                {{ $lessons->links() }}
            </div>
        </div>
    </div>
@endsection
