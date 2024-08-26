@extends('layouts.master')

@section('content')
    <div class="container p-3 overflow-auto categoryIndex">
        <div class="row gap-4">
            <div class="col-12 d-flex align-items-center">
                <p class="fs-4 m-0 fw-bold text-capitalize">{{ __('messages.carousel') }}</p>
                @if (session('updateSuccess'))
                    <div
                        class="col-2 mx-4 d-flex border border-success rounded px-2 py-1 justify-content-between align-items-center">
                        <div class="text-success" role="alert">
                            {{ session('updateSuccess') }}
                        </div>
                        <button class="btn btn-sm px-1 py-0" id="xmark">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                @endif
                @if (session('deleteSuccess'))
                    <div
                        class="col-2 mx-4 d-flex border border-danger rounded px-2 py-1 justify-content-between align-items-center">
                        <div class="text-danger" role="alert">
                            {{ session('deleteSuccess') }}
                        </div>
                        <button class="btn btn-sm px-1 py-0" id="xmark">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                @endif
            </div>
            <div class="col-4 px-3">
                <div class="row">
                    <form action="{{ route('carousel.create') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="image" class="form-control mt-2" value="{{ old('image') }}">
                        @error('image')
                            <div>
                                <small class="text-danger"> {{ $message }} </small>
                            </div>
                        @enderror
                        <input type="text" name="description" class="form-control mt-2" placeholder="Enter Description"
                            value="{{ old('description') }}">
                        @error('description')
                            <div>
                                <small class="text-danger"> {{ $message }} </small>
                            </div>
                        @enderror
                        <button type="submit"
                            class="btn btn-primary w-25 border my-2 text-capitalize float-end">{{ __('messages.submit') }}</button>
                    </form>
                </div>
                <div class="row mt-4 overflow-auto carouselImageContainer">
                    @foreach ($carousels as $carousel)
                        <div class="col-6 p-1 position-relative">
                            <img src="{{ asset('storage/' . $carousel->carousel_image) }}" alt=""
                                class="p-1 border carouselImg">
                            <a href="{{ route('carousel.delete', $carousel->id) }}">
                                <button
                                    class="border-0 bg-transparent text-danger carouselDeletBtn position-absolute end-0">
                                    <i class="fa-solid fa-xmark fa-lg"></i>
                                </button>
                            </a>
                        </div>
                    @endforeach
                </div>

            </div>
            <div class="col">
                <div id="carouselExampleAutoplaying" class="carousel slide carousel-fade" data-bs-ride="true">
                    <div class="carousel-inner">
                        @foreach ($carousels as $index => $carousel)
                            <div class="carousel-item {{ $index === 0 ? ' active' : '' }} imgBlur">
                                <img src="{{ asset('storage/' . $carousel->carousel_image) }}"
                                    class="d-block w-100 landingCarousalImg" alt="..." />

                                <p
                                    class="landingCarousalSecondTxt text-capitalize text-white fw-bold text-center fs-4 w-50">
                                    {{ $carousel->carousel_description }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
