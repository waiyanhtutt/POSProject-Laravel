@extends('admin.layouts.master')

@section('title','Edit Account Information')

@section('content')
     <!-- MAIN CONTENT-->
     <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-2 offset-1">
                        <a href="{{route('admin#list')}}"><button class="btn bg-dark text-white my-3">back</button></a>
                    </div>
                </div>
                <div class="col-lg-10 offset-1">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-center title">Change Your Role</h3>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-3">
                                    <div class=" ms-5">
                                        @if ($account->image == null)
                                            @if($account->gender == 'female')
                                                <img src="{{asset('images/female.png')}}" alt="" class=" img-thumbnail shadow-sm">
                                            @else
                                                <img src="{{asset('images/defaultuser.jpg')}}" alt="" class=" img-thumbnail shadow-sm">

                                            @endif
                                        @else
                                            <img src="{{asset('storage/'.$account->image)}}" alt="user_photo" class=" img-thumbnail shadow-sm" width="300">
                                        @endif
                                    </div>
                                </div>

                                <div class="col-8 offset-1">

                                    <form action="{{route('admin#updateRole',$account->id)}}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input name="name" type="text" value="{{old('name',$account->name)}}" class="form-control" disabled placeholder="Enter Your Name...">

                                        </div>

                                        <div class="form-group">
                                            <label for="role">Role</label>
                                            <select name="role" class=" form-select">
                                                <option value="admin" @if ($account->role == 'admin' )
                                                    selected
                                                @endif >Admin</option>
                                                <option value="user" @if ($account->role == 'user' )
                                                    selected
                                                @endif >User</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input name="email" type="email" value="{{old('email',$account->email)}}" class="form-control" disabled placeholder="Enter Your Email...">

                                        </div>

                                        <div class="form-group">
                                            <label for="image">Image</label>
                                            <input name="image" type="file" class="form-control" disabled>

                                        </div>

                                        <div class="form-group">
                                            <label for="phone">Phone Number</label>
                                            <input name="phone" type="text" value="{{old('phone',$account->phone)}}" class="form-control" disabled placeholder="Enter Your Phonenumber...">

                                        </div>

                                        <div class="form-group">
                                            <label>Gender</label>
                                            <select name="gender" class="form-control" disabled>
                                                <option selected disabled>Choose Gender...</option>
                                                <option value="male" @if ($account->gender === 'male') selected @endif >Male</option>
                                                <option value="female" @if ($account->gender === 'female') selected @endif>Female</option>
                                            </select>

                                        </div>

                                        <div class="form-group">
                                            <label for="address">Address</label>
                                            <textarea name="address" class=" form-control  " disabled cols="30" rows="5">{{ old('address',$account->address)}}</textarea>

                                        </div>

                                        <div class="form-group">
                                            <button type="submit" class=" form-control btn btn-outline-dark w-100"><i class="fa-solid fa-pen-to-square"></i> Change </button>
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
