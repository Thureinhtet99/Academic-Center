@extends('layouts.master')

@section('content')
    <div class="container overflow-auto category-index p-3">
        <div class="row mb-5">
            <div class="col-12 d-flex justify-content-between align-items-top">
                <p class="fs-4 m-0 fw-bold text-capitalize">{{ __('messages.listTrendCourse') }}</p>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                @if (count($actionLogs) == 0)
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
                                <th class="col-3 text-center text-capitalize" scope="col">
                                    {{ __('messages.image') }}
                                </th>
                                <th class="col text-capitalize" scope="col">
                                    {{ __('messages.course') }}
                                    {{ __('messages.name') }}
                                </th>
                                <th class="col-2 text-center text-capitalize" scope="col">
                                    {{ __('messages.viewCount') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($actionLogs as $actionLog)
                                <tr>

                                    <td class="col-1">{{ $actionLog->id }}</td>
                                    <td class="col-3 text-center">
                                        @if ($actionLog->course->course_image == null)
                                            <img src="{{ asset('images/default-image.png') }}"
                                                class=" object-fit-cover border categoryImg rounded" alt="">
                                        @else
                                            <img src="{{ asset('storage/' . $actionLog->course->course_image) }}"
                                                alt="" class="object-fit-cover border categoryImg rounded">
                                        @endif
                                    </td>
                                    <td class="text-muted text-capitalize col">{{ $actionLog->course->course_title }}
                                    </td>
                                    <td class="text-muted text-center col-2 small">{{ $actionLog->viewCount }} </td>
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
