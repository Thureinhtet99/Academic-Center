@extends('layouts.master')

@section('content')
    <div class="container p-3">

        <div class="row">
            <div class="col-12 text-start">
                <span class="fs-4 m-0 fw-bold text-capitalize">{{ __('messages.addNewAutor') }}</span>
            </div>
        </div>

        <form action="{{ route('author.create') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row mt-3 px-2">
                <div class="col-6 p-2">
                    <div class="row">
                        <div class="col-12">
                            <label for="name"
                                class="form-label fw-bold text-capitalize">{{ __('messages.name') }}</label>
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror">
                            @error('name')
                                <div>
                                    <small class="text-danger"> {{ $message }} </small>
                                </div>
                            @enderror
                        </div>
                        <div class="col-6 mt-4">
                            <label for="email"
                                class="form-label fw-bold text-capitalize">{{ __('messages.email') }}</label>
                            <input type="email" name="email" id="email"
                                class="form-control @error('email') is-invalid @enderror">
                            @error('email')
                                <div>
                                    <small class="text-danger"> {{ $message }} </small>
                                </div>
                            @enderror
                        </div>
                        <div class="col-6 mt-4">
                            <label for="phone"
                                class="form-label fw-bold text-capitalize">{{ __('messages.phone') }}</label>
                            <input type="number" name="phone" id="phone" class="form-control">
                        </div>
                        <div class="col mt-4">
                            <label for="about"
                                class="form-label fw-bold text-capitalize">{{ __('messages.about') }}</label>
                            <textarea name="about" id="about" cols="30" rows="9"
                                class="form-control @error('about') is-invalid @enderror">
                            </textarea>
                            @error('about')
                                <div>
                                    <small class="text-danger"> {{ $message }} </small>
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="col-6 p-2">
                    <div class="row">
                        <div class="col-6">
                            <label for="birthday"
                                class="form-label fw-bold text-capitalize">{{ __('messages.birthday') }}</label>
                            <input type="date" name="birthday" id="birthday" class="form-control">
                        </div>
                        <div class="col-6">
                            <label for="gender"
                                class="form-label fw-bold text-capitalize">{{ __('messages.gender') }}</label>
                            <select name="gender" id=""
                                class="form-select text-capitalize @error('gender') is-invalid @enderror">
                                <option value="">{{ __('messages.selectGender') }}</option>
                                <option value="male">{{ __('messages.male') }}</option>
                                <option value="female">{{ __('messages.female') }}</option>
                            </select>
                            @error('gender')
                                <div>
                                    <small class="text-danger"> {{ $message }} </small>
                                </div>
                            @enderror
                        </div>
                        <div class="col-12 mt-4">
                            <label for="degree"
                                class="form-label fw-bold text-capitalize">{{ __('messages.degree') }}</label>
                            <input type="text" name="degree" id="degree" list= "degreeList"
                                class="form-control @error('degree') is-invalid @enderror">
                            <datalist id="degreeList">
                                @foreach ($degrees as $degree)
                                    <option value="{{ $degree['degree_title'] }}">
                                        {{ $degree['degree_title'] }}
                                    </option>
                                @endforeach
                            </datalist>
                            @error('degree')
                                <div>
                                    <small class="text-danger"> {{ $message }} </small>
                                </div>
                            @enderror
                        </div>
                        <div class="col-12 mt-4">
                            <label for="image"
                                class="form-label fw-bold text-capitalize">{{ __('messages.image') }}</label>
                            <input type="file" name="image" id="image" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="col-2 mt-3 offset-10">
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
