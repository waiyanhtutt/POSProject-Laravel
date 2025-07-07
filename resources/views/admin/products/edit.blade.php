@extends('admin.layouts.master')

@section('title','Edit Pizza Product')

@section('content')
     <!-- MAIN CONTENT-->
     <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-2 offset-1">
                        <a href="{{route('product#list')}}"><button class="btn bg-dark text-white my-3">back</button></a>
                    </div>
                </div>
                <div class="col-lg-10 offset-1">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-center title">Update Pizza Product</h3>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-3">
                                    <div class=" ms-5">
                                        <img src="{{asset('storage/'.$pizzaEdit->image)}}" alt="user_photo" class=" img-thumbnail" width="300"/>

                                    </div>
                                </div>

                                <div class="col-8 offset-1">

                                    <form action="{{ route('product#update')}}" method="POST" enctype="multipart/form-data">
                                       @csrf

                                        <input type="hidden" name="pizzaId" value="{{ $pizzaEdit->id }}">

                                        <div class="form-group">
                                            <label for="pizzaName">Name</label>
                                            <input name="pizzaName" type="text" value="{{old('pizzaName',$pizzaEdit->name)}}" class="form-control @error('pizzaName') is-invalid @enderror" placeholder="Enter Your Name...">
                                            @error('pizzaName')
                                                <span class="text-danger"> *
                                                    {{$message}}
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="pizzaDescription">Description</label>
                                            <textarea name="pizzaDescription" class=" form-control @error('pizzaDescription') is-invalid @enderror"" cols="30" rows="5">{{ old('pizzaDescription',$pizzaEdit->description)}}</textarea>
                                            @error('pizzaDescription')
                                                <span class="text-danger"> *
                                                    {{$message}}
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="pizzaImage">Image</label>
                                            <input name="pizzaImage" type="file" class="form-control @error('pizzaImage') is-invalid @enderror">
                                            @error('pizzaImage')
                                                <span class="text-danger"> *
                                                    {{$message}}
                                                </span>
                                            @enderror
                                        </div>


                                        <div class="form-group">
                                            <label for="pizzaCategory" class="control-label mb-1">Category</label>
                                            <select name="pizzaCategory" class=" form-control">
                                                <option selected disabled>Pizza Category...</option>
                                                @foreach ( $category as $eachcategory )
                                                    <option value="{{ $eachcategory->id }}" @if ($pizzaEdit->category_id === $eachcategory->id ) selected @endif >
                                                        {{ $eachcategory->name }}
                                                    </option>
                                                @endforeach

                                            </select>
                                            @error('pizzaCategory')
                                                <div class=" invalid-feedback"> *
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>


                                        <div class="form-group">
                                            <label for="pizzaPrice" class="control-label mb-1">Price</label>
                                            <input id="pizzaPrice" name="pizzaPrice" type="number" value="{{old('pizzaPrice',$pizzaEdit->price)}}" class="form-control @error('pizzaPrice') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Enter Pizza price...">
                                            @error('pizzaPrice')
                                                <div class=" invalid-feedback"> *
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="pizzaWaitingTime" class="control-label mb-1">Waiting Time</label>
                                            <input id="pizzaWaitingTime" name="pizzaWaitingTime" type="number" value="{{old('pizzaWaitingTime',$pizzaEdit->waiting_time)}}" class="form-control @error('pizzaWaitingTime') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Enter Pizza Waiting Time...">
                                            @error('pizzaWaitingTime')
                                                <div class=" invalid-feedback"> *
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="pizzaViewCount" class="control-label mb-1">View Count</label>
                                            <input id="pizzaViewCount" name="pizzaViewCount" type="number" value="{{old('pizzaViewCount',$pizzaEdit->view_count)}}" class=" form-control" aria-required="true" aria-invalid="false" disabled>
                                        </div>

                                        <div class="form-group">
                                            <label for="createdDate" class="control-label mb-1">Created Date</label>
                                            <input id="createdDate" name="createdDate" type="text" value="{{$pizzaEdit->created_at->format('j.F.Y')}}" aria-required="true" aria-invalid="false" class=" form-control" disabled >

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
