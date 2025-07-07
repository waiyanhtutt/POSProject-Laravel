@extends('admin.layouts.master')

@section('title','Product List Page')

@section('content')
     <!-- MAIN CONTENT-->
     <div class="main-content">

        <div class="section__content section__content--p30">
            <div class="container-fluid">
               @if (session('deleteMessage'))
                <div class=" col-md-6 offset-3">
                        <div class=" text-center alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>{{session('deleteMessage')}}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
               @endif
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    <div class="table-data__tool">
                        <div class="table-data__tool-left">
                            <div class="overview-wrap">
                                <h2 class="title-1">Product List</h2>

                            </div>
                        </div>
                        <div class="table-data__tool-right">
                            <a href="{{route('product#create')}}">
                                <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                    <i class="zmdi zmdi-plus"></i>Add Your Product
                                </button>
                            </a>
                        </div>
                    </div>

                    <div class="row my-3">
                        <div class="col">
                            <h5 class=" text-secondary">Search Key : {{ request('searchKey')}}</h5>
                        </div>

                        <div class=" col-auto mb-3">
                            <form class="form-header" action="{{route('product#list')}}" method="GET">
                                @csrf
                                    <input class="au-input au-input--xl" type="text" name="searchKey" placeholder="Search for Your product..." value="{{request('searchKey')}}" />
                                    <button class="au-btn--submit" type="submit">
                                        <i class="zmdi zmdi-search"></i>
                                    </button>
                            </form>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class=" col-md-3">
                            <h4 class=" text-muted"><i class="fa-solid fa-database"> {{$pizzaLists->total()}}</i></h4>
                        </div>
                    </div>

                        @if (count($pizzaLists) !== 0)
                        <div class="table-responsive table-responsive-data2">
                            <table class="table table-data2 text-center">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Category</th>
                                        <th>View Count</th>
                                        <th></th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pizzaLists as $pizzalist )
                                    <tr class="tr-shadow my-2">
                                        <td class="col-2"><img src="{{asset('storage/'.$pizzalist->image)}}" class=" img-thumbnail shadow-sm" alt=""></td>
                                        <td class="col-2">{{$pizzalist->name}}</td>
                                        <td class="col-2">{{$pizzalist->price}}</td>
                                        <td class="col-2">{{$pizzalist->category_name}}</td>
                                        <td class="col-2"><i class="fa-regular fa-eye"></i> {{$pizzalist->view_count}}</td>
                                        <td class="col-2">
                                            <div class="table-data-feature">

                                                <a href="{{route('product#view',$pizzalist->id)}}" class="me-3">
                                                    <button class="item" data-toggle="tooltip" data-placement="top" title="View">
                                                        <i class="fa-regular fa-eye"></i>
                                                    </button>
                                                </a>

                                                <a href="{{route('product#edit',$pizzalist->id)}}" class=" me-3">
                                                    <button class="item" data-toggle="tooltip" data-placement="top" title="Edit">
                                                        <i class="zmdi zmdi-edit"></i>
                                                    </button>
                                                </a>
                                                <a href="{{route('product#delete',$pizzalist->id)}}">
                                                    <button class="item" data-toggle="tooltip" data-placement="top" title="Delete">
                                                        <i class="zmdi zmdi-delete"></i>
                                                    </button>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                            <div>
                               {{$pizzaLists->links()}}
                             </div>
                        </div>
                        @else
                            <h3 class=" text-muted text-center">There is no Product here!</h3>
                        @endif



                    <!-- END DATA TABLE -->
                </div>

            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection
