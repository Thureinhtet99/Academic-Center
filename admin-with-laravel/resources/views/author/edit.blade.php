@extends('layouts.master')

@section('content')
    <div class="container p-3">

        <div class="row">
            <div class="col-12 text-start">
                <span class="fs-4 m-0 fw-bold">Edit Author</span>
            </div>
        </div>

        <form action="{{ route('author.update', $authors->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row mt-3 px-2">
                <div class="col-6 p-2">
                    <div class="row">
                        <div class="col-12">
                            <label for="name" class="form-label fw-bold">First Name</label>
                            <input type="text" name="name" id="name" placeholder="Enter Name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $authors->author_name) }}">
                            @error('name')
                                <div>
                                    <small class="text-danger"> {{ $message }} </small>
                                </div>
                            @enderror
                        </div>
                        <div class="col-6 mt-4">
                            <label for="email" class="form-label fw-bold">Email</label>
                            <input type="email" name="email" id="email" placeholder="Enter Email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email', $authors->author_email) }}">
                            @error('email')
                                <div>
                                    <small class="text-danger"> {{ $message }} </small>
                                </div>
                            @enderror
                        </div>
                        <div class="col-6 mt-4">
                            <label for="phone" class="form-label fw-bold">Phone</label>
                            <input type="number" name="phone" id="phone" class="form-control"
                                placeholder="Enter Phone" value="{{ old('phone', $authors->author_phone) }}">
                        </div>
                        <div class="col mt-4">
                            <label for="about" class="form-label fw-bold">About</label>
                            <textarea name="about" id="about" cols="30" rows="9"
                                class="form-control @error('about') is-invalid @enderror" placeholder="Enter Author's About">
                                {{ old('about', $authors->author_about) }}
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
                            <label for="birthday" class="form-label fw-bold">Date of Birth</label>
                            <input type="date" name="birthday" id="birthday" class="form-control"
                                placeholder="Date of Birth" value="{{ old('birthday', $authors->author_birthday) }}">
                        </div>
                        <div class="col-6">
                            <label for="gender" class="form-label fw-bold">Gender</label>
                            <select name="gender" id="" class="form-select @error('gender') is-invalid @enderror">
                                <option value="">Select Gender</option>
                                <option value="male" @if ($authors->author_gender == 'male') selected @endif>Male</option>
                                <option value="female" @if ($authors->author_gender == 'female') selected @endif>Female</option>
                            </select>
                            @error('gender')
                                <div>
                                    <small class="text-danger"> {{ $message }} </small>
                                </div>
                            @enderror
                        </div>
                        <div class="col-12 mt-4">
                            <label for="degree" class="form-label fw-bold">Degree</label>
                            <input type="text" name="degree" id="degree" list= "degreeList"
                                placeholder="Enter Degree" class="form-control @error('degree') is-invalid @enderror"
                                value="{{ old('degree', $authors->author_degree) }}">
                            <datalist id="degreeList">
                                @foreach ($degrees as $degree)
                                    <option value="{{ $degree['degree_title'] }}" class=" text-capitalize">
                                        {{ $degree['degree_title'] }}
                                    </option>
                                @endforeach
                            </datalist>
                            @error('degree')
                                <span class="d-block invalid-feedback">
                                    <small>{{ $message }}</small>
                                </span>
                            @enderror
                        </div>
                        <div class="col-12 mt-4">
                            <label for="image" class="form-label fw-bold">Image</label>
                            <input type="file" name="image" id="image" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="col-2 mt-3 offset-10">
                    <div class=" float-end ">
                        <button type="reset" class="btn border">Reset</button>
                        <button type="submit" class="btn btn-primary border">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
