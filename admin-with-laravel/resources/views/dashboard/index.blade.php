@extends('layouts.master')

@section('content')
    <div class="container-fluid overflow-auto dashboardIndex py-2">

        {{-- Welcome --}}
        <div class="row align-items-center" id="dashboardTitle">
            <div class="col-12 d-flex justify-content-between text-start">
                <div>
                    <h1 class="fs-3 fw-bolder m-0">{{ __('messages.welcome') }},
                        <span class="fw-medium fs-4 text-capitalize">{{ auth()->user()->name }}</span>
                    </h1>
                </div>
                <div class="my-2 text-end">
                    <div class="py-2 px-3 text-center shadow-sm bg-white rounded" id="calender">
                        <i class="fa-regular fa-calendar me-1"></i>
                        <small id="dateTime"></small>
                    </div>
                </div>
            </div>
        </div>
        {{-- End welcome --}}

        <div class="row gap-3 px-2 align-items-center my-4">
            <div class="col bg-white rounded shadow-sm px-3 py-2 d-flex justify-content-between">
                <div class="px-2 category-border">
                    <p class="m-0 fw-medium text-capitalize">{{ __('messages.category') }}</p>
                    <p class="m-0 fs-3 fw-bold  ">{{ count($categories) }}</p>
                </div>
                <div>
                    <i class="fa-solid fa-list-check fa-lg card-category rounded px-2 py-3"></i>
                </div>
            </div>
            <div class="col bg-white rounded shadow-sm px-3 py-2 d-flex justify-content-between">
                <div class="px-2 course-border">
                    <p class="m-0 fw-medium text-capitalize">{{ __('messages.course') }}</p>
                    <p class="m-0 fs-3 fw-bold  ">{{ count($courses) }}</p>
                </div>
                <div>
                    <i class="fa-solid fa-chalkboard-user fa-lg card-course rounded px-2 py-3"></i>
                </div>
            </div>
            <div class="col bg-white rounded shadow-sm px-3 py-2 d-flex justify-content-between">
                <div class="px-2 user-border">
                    <p class="m-0 fw-medium text-capitalize">{{ __('messages.user') }}</p>
                    <p class="m-0 fs-3 fw-bold  ">{{ count($users) }}</p>
                </div>
                <div>
                    <i class="fa-solid fa-users fa-lg card-user rounded px-2 py-3"></i>
                </div>
            </div>
            <div class="col bg-white rounded shadow-sm px-3 py-2 d-flex justify-content-between">
                <div class="px-2 author-border">
                    <p class="m-0 fw-medium text-capitalize">{{ __('messages.author') }}</p>
                    <p class="m-0 fs-3 fw-bold  ">{{ count($authors) }}</p>
                </div>
                <div>
                    <i class="fa-solid fa-feather-pointed fa-lg author-color rounded px-2 py-3"></i>
                </div>
            </div>
        </div>

        <div class="row px-2 mt-4 gap-4">
            <div class="col-4 py-2 shadow-sm bg-white d-flex flex-column justify-content-between rounded">
                <div class="col-12 py-2">
                    <span class="fw-bold fs-5 p-2 text-capitalize">{{ __('messages.authorList') }}</span>
                </div>

                <div class="col-12">
                    @if (count($authors) == 0)
                        <p class="text-muted text-center mt-5">No data available.....</p>
                    @else
                        @for ($i = 0; $i < min(5, count($authors)); $i++)
                            <div class="d-flex align-items-center border-bottom py-1">
                                @if ($authors[$i]->author_image == null)
                                    @if ($authors[$i]->author_gender == 'male')
                                        <img src="{{ asset('images/default_user.png') }}" alt=""
                                            class="rounded-circle ms-2 me-3 author-img">
                                    @else
                                        <img src="{{ asset('images/default_female.jpg') }}" alt=""
                                            class="rounded-circle ms-2 me-3 author-img">
                                    @endif
                                @else
                                    <img src="{{ asset('storage/' . $authors[$i]->author_image) }}" alt=""
                                        class="rounded-circle ms-2 me-3 author-img">
                                @endif
                                <div class="px-0 py-2">
                                    <p class="fw-medium fs-6 m-0">
                                        {{ $authors[$i]->author_first_name }}
                                        {{ $authors[$i]->author_last_name }}
                                    </p>
                                    <p class="text-capitalize text-muted m-0">
                                        <small>{{ $authors[$i]->author_degree }}</small>
                                    </p>
                                </div>
                            </div>
                        @endfor
                    @endif
                </div>
                @if (count($authors) == 0)
                    <div class="col-12 pt-4 d-flex justify-content-center align-items-center"></div>
                @else
                    <div class="col-12 pt-4 d-flex justify-content-center align-items-center">
                        <a href="{{ route('author.index') }}"
                            class="text-decoration-none text-muted text-capitalize view-all-authors">
                            {{ __('messages.viewAllAuthor') }}
                        </a>
                    </div>
                @endif
            </div>

            <div class="col p-2 shadow-sm bg-white rounded d-flex flex-column justify-content-between">
                <div class="row d-flex justify-content-between align-items-center">
                    <div class="col">
                        <p class="fw-bold fs-5 m-0 p-2 text-capitalize">{{ __('messages.userList') }}</p>
                    </div>
                </div>

                @if (count($users) == 0)
                    <p class="text-muted text-center mt-5">No data available.....</p>
                @else
                    <table class="table table-responsive mt-2">
                        <thead>
                            <tr class="text-capitalize">
                                <th scope="col">{{ __('messages.image') }}</th>
                                <th scope="col">{{ __('messages.name') }}</th>
                                <th scope="col">{{ __('messages.email') }}</th>
                                <th scope="col">{{ __('messages.gender') }}</th>
                            </tr>
                        </thead>
                        <tbody class="">
                            @for ($i = 0; $i < min(4, count($users)); $i++)
                                <tr>
                                    <td>
                                        @if ($users[$i]->image == null)
                                            @if ($users[$i]->gender == 'male')
                                                <img src="{{ asset('images/default_user.png') }}" alt=""
                                                    class="rounded-circle dashboardUserImg">
                                            @else
                                                <img src="{{ asset('images/default_female.jpg') }}" alt=""
                                                    class="rounded-circle dashboardUserImg">
                                            @endif
                                        @else
                                            <img src="{{ asset('storage/' . $users[$i]->image) }}" alt=""
                                                class="rounded-circle dashboardUserImg">
                                        @endif
                                    </td>
                                    <td class="text-muted text-capitalize">{{ $users[$i]->name }}</td>
                                    <td class="text-muted">{{ $users[$i]->email }}</td>
                                    <td class="text-muted text-capitalize">
                                        @if ($users[$i]->gender == null)
                                            --
                                        @else
                                            {{ $users[$i]->gender }}
                                        @endif
                                    </td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                @endif

                @if (count($authors) == 0)
                    <div class="col-12 pt-4 d-flex justify-content-center align-items-center"></div>
                @else
                    <div class="col-12 pt-3 d-flex justify-content-center align-items-center ">
                        <a href="{{ route('users.index') }}"
                            class="text-decoration-none text-muted text-capitalize view-all-authors ">
                            {{ __('messages.viewAllUser') }}
                        </a>
                    </div>
                @endif

            </div>
        </div>
    </div>
@endsection
