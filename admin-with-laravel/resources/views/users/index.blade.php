@extends('layouts.master')

@section('content')
    <div class="container px-3 pt-2 pb-2">
        <div class="row mt-2 mb-3">
            <div class="col-12 d-flex justify-content-between align-items-top">
                <p class="fs-4 m-0 fw-bold text-capitalize">{{ __('messages.user') }} {{ __('messages.list') }}</p>

                <div class= "d-flex justify-content-end align-items-top">
                    <div class="mx-2">
                        <select name="sorting" id="sorting" class="form-select text-capitalize">
                            <option value="all">{{ __('messages.all') }}</option>
                            <option value="sortByMale">{{ __('messages.male') }}</option>
                            <option value="sortByFemale">{{ __('messages.female') }}</option>
                        </select>
                    </div>
                    <form action="{{ route('users.index') }}" method="get">
                        @csrf
                        <div class="shadow-sm bg-white rounded px-2 d-flex">
                            <input type="search" name="search" class="form-control me-2 px-2 border-0 text-capitalize"
                                value="{{ request('search') }}" placeholder="{{ __('messages.searchUser') }}">
                            <button type="submit" class="py-2 px-3 bg-white border-0">
                                <i class="fa-solid fa-magnifying-glass fa-lg"></i>
                            </button>
                        </div>
                        <span class="d-block text-end text-muted">
                            <small>{{ count($users) }} {{ __('messages.result') }}</small>
                        </span>
                    </form>
                </div>
            </div>
        </div>
        @if (session('updateSuccess'))
            <div class="col-2 d-flex border border-primary rounded p-1 justify-content-between align-items-center">
                <div class="text-primary" role="alert">
                    {{ session('updateSuccess') }}
                </div>
                <button class="btn btn-sm px-1 py-0" id="xmark">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif
        @if (session('deleteSuccess'))
            <div class="col-2 d-flex border border-danger rounded p-1 justify-content-between align-items-center">
                <div class="text-danger" role="alert">
                    {{ session('deleteSuccess') }}
                </div>
                <button class="btn btn-sm px-1 py-0" id="xmark">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        @if (count($users) == 0)
            <div class="row">
                <div class="col">
                    <span class="text-muted p-2"><i>There is no data ....</i></span>
                </div>
            </div>
        @else
            <div class="row mt-1 rounded userTitles">
                <div class="col fw-bold text-center text-capitalize py-2">{{ __('messages.image') }}</div>
                <div class="col-2 fw-bold text-center text-capitalize py-2">{{ __('messages.text') }}</div>
                <div class="col-3 fw-bold text-center text-capitalize py-2">{{ __('messages.email') }}</div>
                <div class="col fw-bold text-center text-capitalize py-2">{{ __('messages.phone') }}</div>
                <div class="col fw-bold text-center text-capitalize py-2">{{ __('messages.gender') }}</div>
                <div class="col-3 fw-bold text-center text-capitalize py-2">{{ __('messages.role') }}</div>
                <div class="col-1 fw-bold text-center text-capitalize py-2"></div>
            </div>

            <div id="userLists">
                @foreach ($users as $user)
                    <div class="row mx-0 border-bottom py-1">
                        <div class="col py-1 text-center">
                            @if ($user->image == null)
                                @if ($user->gender == 'male')
                                    <img src="{{ asset('images/default_user.png') }}" alt=""
                                        class="object-fit-cover userIndexImg">
                                @else
                                    <img src="{{ asset('images/default_female.jpg') }}" alt=""
                                        class="object-fit-cover userIndexImg">
                                @endif
                            @else
                                <img src="{{ asset('storage/' . $user->image) }}" alt=""
                                    class="object-fit-cover userIndexImg">
                            @endif
                        </div>
                        <div
                            class="col-2 text-muted userInfos d-flex align-items-center justify-content-center text-capitalize">
                            {{ $user->name }}
                        </div>
                        <div class="col-3 text-muted userInfos d-flex align-items-center justify-content-center">
                            {{ $user->email }}
                        </div>
                        <div class="col text-muted userInfos d-flex align-items-center justify-content-center">
                            @if ($user->phone == null)
                                --
                            @else
                                {{ $user->phone }}
                            @endif
                        </div>
                        <div
                            class="col text-muted userInfos d-flex align-items-center justify-content-center text-capitalize">
                            @if ($user->gender == null)
                                --
                            @else
                                {{ $user->gender }}
                            @endif
                        </div>
                        <div
                            class="col-3 text-muted userInfos d-flex align-items-center justify-content-center text-capitalize">
                            <form action="{{ route('users.update', $user->id) }}" method="post" class="d-flex">
                                @csrf
                                <select name="role" id="" class="form-select form-select-sm text-capitalize">
                                    <option value="user">{{ __('messages.user') }}</option>
                                    <option value="admin">{{ __('messages.admin') }}</option>
                                </select>
                                <button type="submit"
                                    class="btn btn-sm btn-primary border ms-2 text-capitalize">{{ __('messages.save') }}</button>
                            </form>
                        </div>
                        <div class="col-1 text-muted userInfos d-flex align-items-center justify-content-center">
                            <a href="{{ route('users.delete', $user->id) }}" class="text-black">
                                <button class="btn btn-sm border-0 shadow-sm">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <div>
        {{ $users->links() }}
    </div>
@endsection

@section('scriptSource')
    <script>
        $(document).ready(function() {
            $("#sorting").change(function() {
                $sortingValue = $("#sorting").val()

                if ($sortingValue == "sortByMale") {
                    $.ajax({
                        type: "get",
                        url: "/users/ajax/sort-by-male",
                        dataType: "json",
                        success: function(response) {
                            $responseLists = "",
                                response.forEach(res => {
                                    $responseLists += `
                                    <div id="userLists">
                                        <div class="row mx-0 border-bottom py-1">
                                            <div class="col py-1 text-center">
                                                ${res.profile_photo_path == null && res.gender == 'male'
                                                ? "<img src='{{ asset('images/default_user.png') }}' alt='' class='object-fit-cover userIndexImg'>"
                                                : "<img src='{{ asset('storage/${res.profile_photo_path}') }}' alt='' class='object-fit-cover userIndexImg'>"
                                                }
                                            </div>
                                            <div
                                                class="col-2 text-muted userInfos d-flex align-items-center justify-content-center text-capitalize">
                                                ${res.name}
                                            </div>
                                            <div class="col-3 text-muted userInfos d-flex align-items-center justify-content-center">
                                                ${res.email}
                                            </div>
                                            <div class="col text-muted userInfos d-flex align-items-center justify-content-center">
                                                ${res.phone == null ? "--" : res.phone}
                                            </div>
                                            <div
                                                class="col text-muted userInfos d-flex align-items-center justify-content-center text-capitalize">
                                                ${res.gender == null ? "--" : res.gender}
                                            </div>
                                            <div
                                                class="col-3 text-muted userInfos d-flex align-items-center justify-content-center text-capitalize">
                                                <form action="{{ route('users.update', $user->id) }}" method="post" class="d-flex">
                                                    @csrf
                                                    <select name="role" id="" class="form-select form-select-sm text-capitalize">
                                                        <option value="user">{{ __('messages.user') }}</option>
                                                        <option value="admin">{{ __('messages.admin') }}</option>
                                                    </select>
                                                    <button type="submit" class="btn btn-sm btn-primary border ms-2 text-capitalize">
                                                        {{ __('messages.save') }}
                                                    </button>
                                                </form>
                                            </div>
                                            <div class="col-1 text-muted userInfos d-flex align-items-center justify-content-center">
                                                <a href="{{ route('users.delete', $user->id) }}" class="text-black">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    `
                                });
                            $("#userLists").html($responseLists)
                        }
                    })
                } else if ($sortingValue == "sortByFemale") {
                    $.ajax({
                        type: "get",
                        url: "/users/ajax/sort-by-female",
                        dataType: "json",
                        success: function(response) {
                            $responseLists = "",
                                response.forEach(res => {
                                    $responseLists += `
                                    <div id="userLists">
                                        <div class="row mx-0 border-bottom py-1">
                                            <div class="col py-1 text-center">
                                                ${res.profile_photo_path == null && res.gender == 'female'
                                                ? "<img src='{{ asset('images/default_female.jpg') }}' alt='' class='object-fit-cover userIndexImg'>"
                                                : "<img src='{{ asset('storage/${res.profile_photo_path}') }}' alt='' class='object-fit-cover userIndexImg'>"
                                                }
                                            </div>
                                            <div
                                                class="col-2 text-muted userInfos d-flex align-items-center justify-content-center text-capitalize">
                                                ${res.name}
                                            </div>
                                            <div class="col-3 text-muted userInfos d-flex align-items-center justify-content-center">
                                                ${res.email}
                                            </div>
                                            <div class="col text-muted userInfos d-flex align-items-center justify-content-center">
                                                ${res.phone == null ? "--" : res.phone}

                                            </div>
                                            <div
                                                class="col text-muted userInfos d-flex align-items-center justify-content-center text-capitalize">
                                                ${res.gender == null ? "--" : res.gender}
                                            </div>
                                            <div
                                                class="col-3 text-muted userInfos d-flex align-items-center justify-content-center text-capitalize">
                                                <form action="{{ route('users.update', $user->id) }}" method="post" class="d-flex">
                                                    @csrf
                                                    <select name="role" id="" class="form-select form-select-sm text-capitalize">
                                                        <option value="user">{{ __('messages.user') }}</option>
                                                        <option value="admin">{{ __('messages.admin') }}</option>
                                                    </select>
                                                    <button type="submit" class="btn btn-sm btn-primary border ms-2 text-capitalize">
                                                        {{ __('messages.save') }}
                                                    </button>
                                                </form>
                                            </div>
                                            <div class="col-1 text-muted userInfos d-flex align-items-center justify-content-center">
                                                <a href="{{ route('users.delete', $user->id) }}" class="text-black">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    `
                                });
                            $("#userLists").html($responseLists)
                        }
                    })
                } else if ($sortingValue == "all") {
                    $.ajax({
                        type: "get",
                        url: "/users/ajax/all-user",
                        dataType: "json",
                        success: function(response) {
                            $responseLists = "",
                                response.forEach(res => {
                                    $responseLists += `
                                    <div id="userLists">
                                        <div class="row mx-0 border-bottom py-1">
                                            <div class="col py-1 text-center">
                                                ${res.profile_photo_path == null
                                                    ? res.gender == 'female'
                                                        ? "<img src='{{ asset('images/default_female.jpg') }}' alt='' class='object-fit-cover userIndexImg'>"
                                                        : "<img src='{{ asset('images/default_user.png') }}' alt='' class='object-fit-cover userIndexImg'>"
                                                    : "<img src='{{ asset('storage/${res.profile_photo_path}') }}' alt='' class='object-fit-cover userIndexImg'>"
                                                }
                                            </div>
                                            <div
                                                class="col-2 text-muted userInfos d-flex align-items-center justify-content-center text-capitalize">
                                                ${res.name}
                                            </div>
                                            <div class="col-3 text-muted userInfos d-flex align-items-center justify-content-center">
                                                ${res.email}
                                            </div>
                                            <div class="col text-muted userInfos d-flex align-items-center justify-content-center">
                                                ${res.phone == null ? "--" : res.phone}

                                            </div>
                                            <div
                                                class="col text-muted userInfos d-flex align-items-center justify-content-center text-capitalize">
                                                ${res.gender == null ? "--" : res.gender}
                                            </div>
                                            <div
                                                class="col-3 text-muted userInfos d-flex align-items-center justify-content-center text-capitalize">
                                                <form action="{{ route('users.update', $user->id) }}" method="post" class="d-flex">
                                                    @csrf
                                                    <select name="role" id="" class="form-select form-select-sm text-capitalize">
                                                        <option value="user">{{ __('messages.user') }}</option>
                                                        <option value="admin">{{ __('messages.admin') }}</option>
                                                    </select>
                                                    <button type="submit" class="btn btn-sm btn-primary border ms-2">
                                                        {{ __('messages.save') }}
                                                    </button>
                                                </form>
                                            </div>
                                            <div class="col-1 text-muted userInfos d-flex align-items-center justify-content-center">
                                                <a href="{{ route('users.delete', $user->id) }}" class="text-black">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    `
                                });
                            $("#userLists").html($responseLists)
                        }
                    })
                }
            })
        })
    </script>
@endsection
