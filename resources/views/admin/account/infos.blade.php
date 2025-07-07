@extends('admin.layouts.master')

@section('title','Account Information')

@section('content')
     <!-- MAIN CONTENT-->
     <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    @if (session('updateSuccess'))
                    <div class=" col-md-6 offset-3">
                        <div class=" text-center alert alert-success alert-dismissible fade show" role="alert">
                            <strong>{{session('updateSuccess')}}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
               @endif
                </div>

                <div class="col-lg-10 offset-1">

                    <div class="row">
                        <a href="{{route('category#list')}}"><button class="btn bg-dark text-white my-3">back</button></a>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-center title">Personal Information</h3>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-3">
                                    <div>
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

                                    <div class=" ms-3 my-2">
                                        <a href="{{route('account#edit')}}">
                                            <button class=" text-primary text-decoration-underline"><i class="fa-solid fa-gear me-3"></i> Edit Your Infos</button>
                                        </a>
                                    </div>


                                </div>

                                <div class="col-9">
                                        {{-- <h3 class="title">Personal Information</h3>
                                        <p class=" text-secondary">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Veniam, provident.</p> --}}

                                        <div class="row">
                                            <div class="col-6">
                                                <div class="card shadow-sm">
                                                    <div class="card-body">
                                                        <div class="row align-items-center">
                                                            <div class="col">
                                                                <h4 class="text-dark text-xs mb-1">Name</h4>
                                                                <p class="h6 text-muted">{{Auth::user()->name}}</p>
                                                            </div>

                                                            <div class="col-auto">
                                                                <i class="fa-regular fa-user"></i>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="card shadow-sm">
                                                    <div class="card-body">
                                                        <div class="row align-items-center">
                                                            <div class="col">
                                                                <h4 class="text-dark text-xs mb-1">Email</h4>
                                                                <p class="h6 text-muted">{{Auth::user()->email}}</p>
                                                            </div>

                                                            <div class="col-auto">
                                                                <i class="fa-regular fa-envelope"></i>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <div class="card shadow-sm">
                                                    <div class="card-body">
                                                        <div class="row align-items-center">
                                                            <div class="col">
                                                                <h4 class="text-dark text-xs mb-1">Phone</h4>
                                                                <p class="h6 text-muted">{{Auth::user()->phone}}</p>
                                                            </div>

                                                            <div class="col-auto">
                                                                <i class="fa-solid fa-phone"></i>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <div class="card shadow-sm">
                                                    <div class="card-body">
                                                        <div class="row align-items-center">
                                                            <div class="col">
                                                                <h4 class="text-dark text-xs mb-1">Gender</h4>
                                                                <p class="h6 text-muted">{{Auth::user()->gender}}</p>
                                                            </div>

                                                            <div class="col-auto">
                                                                <i class="fa-solid fa-person-half-dress"></i>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <div class="card shadow-sm">
                                                    <div class="card-body">
                                                        <div class="row align-items-center">
                                                            <div class="col">
                                                                <h4 class="text-dark text-xs mb-1">Address</h4>
                                                                <p class="h6 text-muted">{{Auth::user()->address}}</p>
                                                            </div>

                                                            <div class="col-auto">
                                                                <i class="fa-regular fa-address-book"></i>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <div class="card shadow-sm">
                                                    <div class="card-body">
                                                        <div class="row align-items-center">
                                                            <div class="col">
                                                                <h4 class="text-dark text-xs mb-1">Join Date</h4>
                                                                <p class="h5 text-muted">{{Auth::user()->created_at->format('j.F.Y')}}</p>
                                                            </div>

                                                            <div class="col-auto">
                                                                <i class="fa-regular fa-calendar"></i>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
