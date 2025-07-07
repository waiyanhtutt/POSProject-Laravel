@extends('admin.layouts.master')

@section('title','Change Your Password')

@section('content')
     <!-- MAIN CONTENT-->
     <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                @if (session('incorrectPassword'))
                    <div class=" col-md-6 offset-3">
                        <div class=" text-center alert alert-danger alert-dismissible fade show" role="alert">
                            <strong><i class="fa-solid fa-exclamation"></i> {{session('incorrectPassword')}}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
               @endif

                @if (session('changePassword'))
                    <div class=" col-md-6 offset-3">
                        <div class=" text-center alert alert-warning alert-dismissible fade show" role="alert">
                            <strong><i class="fa-solid fa-key"></i> {{session('changePassword')}}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                @endif

                <div class="row">
                    <div class="col-3 offset-3">
                        <a href="{{route('category#list')}}"><button class="btn bg-info text-white my-3">back</button></a>
                    </div>
                </div>
                <div class="col-lg-6 offset-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-center title-2">Change Your Password</h3>
                            </div>
                            <hr>
                            <form action="{{route('admin#passwordchangedata')}}" method="post" novalidate="novalidate">
                                @csrf
                                <div class="form-group">
                                    <label for="oldPassword" class="control-label mb-1">Old Password</label>
                                    <input id="oldPassword" name="oldPassword" type="password" value="{{old('oldPassword')}}" class="form-control @error('oldPassword') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Enter Your old password...">
                                    @error('oldPassword')
                                        <div class=" invalid-feedback">
                                            {{$message}}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="newPassword" class="control-label mb-1">New Password</label>
                                    <input id="newPassword" name="newPassword" type="password" value="{{old('newPassword')}}" class="form-control @error('newPassword') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Enter Your New Password...">
                                    @error('newPassword')
                                        <div class=" invalid-feedback">
                                            {{$message}}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="confirmPassword" class="control-label mb-1">Confirm Password</label>
                                    <input id="confirmPassword" name="confirmPassword" type="password" value="{{old('confirmPassword')}}" class="form-control @error('confirmPassword') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Confirm Your Password">
                                    @error('confirmPassword')
                                        <div class=" invalid-feedback">
                                            {{$message}}
                                        </div>
                                    @enderror
                                </div>

                                <div>
                                    <button type="submit" class="btn btn-lg btn-info btn-block">
                                        <i class="fa-solid fa-key"></i> Change Password
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection
