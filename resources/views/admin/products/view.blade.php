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
                <div class="row">
                    <div class="col-2 offset-1">
                        {{-- <a href="{{route('product#list')}}"><button class="btn bg-dark text-white my-3">back</button></a> --}}
                        <button class=" btn bg-dark text-white my-3" onclick="history.back()">Back</button>
                    </div>
                </div>
                <div class="col-lg-10 offset-1">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-center title">Your Product Detail</h3>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-3">
                                    <div>
                                        <img src="{{asset('storage/'.$pizzas->image)}}" alt="user_photo" class=" img-thumbnail" width="300" />

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
                                                                <p class="h6 text-muted">{{$pizzas->name}}</p>
                                                            </div>

                                                            <div class="col-auto">
                                                                <i class="fa-solid fa-file-lines fs-4"></i>
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
                                                                <h4 class="text-dark text-xs mb-1">Price</h4>
                                                                <p class="h6 text-muted">{{$pizzas->price}}</p>
                                                            </div>

                                                            <div class="col-auto">
                                                                <i class="fa-solid fa-sack-dollar fs-4"></i>
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
                                                                <h4 class="text-dark text-xs mb-1">Waiting Time</h4>
                                                                <p class="h6 text-muted">{{$pizzas->waiting_time}} minute</p>
                                                            </div>

                                                            <div class="col-auto">
                                                                <i class="fa-solid fa-clock fs-4"></i>
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
                                                                <h4 class="text-dark text-xs mb-1">View Count</h4>
                                                                <p class="h6 text-muted">{{$pizzas->view_count}} </p>
                                                            </div>

                                                            <div class="col-auto">
                                                                <i class="fa-solid fa-binoculars fs-4"></i>
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
                                                                <h4 class="text-dark text-xs mb-1">Category_Name</h4>
                                                                <p class="h6 text-muted">{{$pizzas->category_name}}</p>
                                                            </div>

                                                            <div class="col-auto">
                                                                <i class="fa-solid fa-table fs-4"></i>
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
                                                                <h4 class="text-dark text-xs mb-1">Listing Time</h4>
                                                                <p class="h5 text-muted">{{Auth::user()->created_at->format('j.F.Y')}}</p>
                                                            </div>

                                                            <div class="col-auto">
                                                                <i class="fa-regular fa-calendar fs-4"></i>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-12">
                                                <div class="card shadow-sm">
                                                    <div class="card-body">
                                                        <div class="row align-items-center">
                                                            <div class="col">
                                                                <h4 class="text-dark text-xs mb-1">Details <i class="fa-regular fa-pen-to-square"></i></h4>
                                                                <p class="h6 text-muted text-justify mt-2">{{$pizzas->description}}</p>
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
