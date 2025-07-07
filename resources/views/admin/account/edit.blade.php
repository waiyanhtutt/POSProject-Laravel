@extends('admin.layouts.master')

@section('title','Edit Account Information')

@section('content')
     <!-- MAIN CONTENT-->
     <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-lg-10 offset-1">

                    <div class="row">
                        <a href="{{route('account#infos')}}"><button class="btn bg-dark text-white my-3">back</button></a>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-center title">Edit Your Information</h3>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-3">
                                    <div class=" ms-5">
                                        @if (Auth::user()->image == null)
                                            @if(Auth::user()->gender == 'female')
                                                <img src="{{asset('images/female.png')}}" alt="" class=" img-thumbnail shadow-sm">
                                            @else
                                                <img src="{{asset('images/defaultuser.jpg')}}" alt="" class=" img-thumbnail shadow-sm">

                                            @endif
                                        @else
                                            <img src="{{asset('storage/'.Auth::user()->image)}}" alt="user_photo" class=" img-thumbnail shadow-sm" width="300">
                                        @endif
                                    </div>
                                </div>

                                <div class="col-8 offset-1">

                                    <form action="{{route('account#update',Auth::user()->id)}}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input name="name" type="text" value="{{old('name',Auth::user()->name)}}" class="form-control @error('name') is-invalid @enderror" placeholder="Enter Your Name...">
                                            @error('name')
                                                <span class="text-danger"> *
                                                    {{$message}}
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input name="email" type="email" value="{{old('email',Auth::user()->email)}}" class="form-control @error('email') is-invalid @enderror"" placeholder="Enter Your Email...">
                                            @error('email')
                                                <span class="text-danger"> *
                                                    {{$message}}
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="image">Image</label>
                                            <input name="image" type="file" class="form-control @error('image') is-invalid @enderror">
                                            @error('image')
                                                <span class="text-danger"> *
                                                    {{$message}}
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="phone">Phone Number</label>
                                            <input name="phone" type="text" value="{{old('phone',Auth::user()->phone)}}" class="form-control @error('phone') is-invalid @enderror"" placeholder="Enter Your Phonenumber...">
                                            @error('phone')
                                                <span class="text-danger"> *
                                                    {{$message}}
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label>Gender</label>
                                            <select name="gender" class="form-control @error('gender') is-invalid @enderror"">
                                                <option selected disabled>Choose Gender...</option>
                                                <option value="male" @if (Auth::user()->gender === 'male') selected @endif >Male</option>
                                                <option value="female" @if (Auth::user()->gender === 'female') selected @endif>Female</option>
                                            </select>
                                            @error('gender')
                                                <span class="text-danger"> *
                                                    {{$message}}
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="address">Address</label>
                                            <textarea name="address" class=" form-control @error('address') is-invalid @enderror"" cols="30" rows="5">{{ old('address',Auth::user()->address)}}</textarea>
                                            @error('address')
                                                <span class="text-danger"> *
                                                    {{$message}}
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="role">Role</label>
                                            <input name="role" value="{{old('role',Auth::user()->role)}}" type="text" class="form-control" disabled>
                                        </div>

                                        <div class="form-group">
                                            <button type="submit" class=" form-control btn btn-outline-dark w-100"><i class="fa-solid fa-pen-to-square"></i> Update</button>
                                        </div>

                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection



