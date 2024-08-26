@extends('layouts.master')

@section('content')
    <div class="container overflow-auto p-3 lessonContainer">

        <div class="row mb-3">
            <div class="col-12 d-flex justify-content-between align-items-top">
                <p class="fs-4 m-0 fw-bold text-capitalize">{{ __('messages.review') }}</p>
                <div class= "d-flex justify-content-end align-items-top">
                    <div>
                        <form action="{{ route('testimonial.index') }}" method="get">
                            @csrf
                            <div class="shadow-sm bg-white rounded px-2 d-flex">
                                <input type="search" name="search"
                                    class="form-control text-capitalize me-2 px-2 border-0 searchBar"
                                    value="{{ request('search') }}" placeholder="{{ __('messages.searchReview') }}">
                                <button type="submit" class="py-2 px-3 bg-white border-0">
                                    <i class="fa-solid fa-magnifying-glass fa-lg"></i>
                                </button>
                            </div>
                            <span class="d-block text-end text-muted">
                                <small>{{ count($testimonials) }} {{ __('messages.result') }}</small>
                            </span>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                @if (count($testimonials) == 0)
                    <div class="row">
                        <div class="col px-3">
                            <p class="text-muted"><i>There is no data .....</i></p>
                        </div>
                    </div>
                @else
                    <table class="table table-responsive" id="categoryTable">
                        <thead>
                            <tr>
                                <th class="col-1 text-center" scope="col">#</th>
                                <th class="col-3 text-center text-capitalize" scope="col">
                                    {{ __('messages.course') }} id
                                </th>
                                <th class="col text-center text-capitalize" scope="col">{{ __('messages.text') }}</th>
                                <th class="col-2 text-center text-capitalize" scope="col">{{ __('messages.likeCount') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($testimonials as $testimonial)
                                <tr>
                                    <td class="col-1 text-center">{{ $testimonial->id }}</td>
                                    <td class="col-3 text-muted text-center text-capitalize">
                                        {{ $testimonial->course->id }}
                                    </td>
                                    <td class="col text-muted text-center small">
                                        {{ $testimonial->text }}
                                    </td>
                                    <td class="col-2 text-muted text-center small">
                                        {{ $testimonial->likeCount }}
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
