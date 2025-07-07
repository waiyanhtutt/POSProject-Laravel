@extends('user.layouts.master')
@section('content')
    <!-- Shop Detail Start -->
    <div class="container-fluid pb-5">
        <div class="row px-xl-5">
            @if (session('RatingSuccess'))
                <div class="col-md-6 offset-3">
                    <div class="text-center alert alert-success alert-dismissible fade show" role="alert">
                        <strong>{{session('RatingSuccess')}}</strong>
                        <button type="button" class=" btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>

            @endif
            <div class="row mb-3">
                <a href="{{route('user#home')}}" class=" text-decoration-none text-dark"><i class="fa-solid fa-arrow-left-long"></i> Back to Home</a>
            </div>
            <div class="col-lg-5 mb-30">
                <div id="product-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner bg-light">
                        <div class="carousel-item active">
                            <img class="w-100 h-100" src="{{asset('storage/'.$pizzaDetails->image)}}" alt="{{$pizzaDetails->name}}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-7 h-auto mb-30">
                <div class="h-100 bg-light p-30">
                    {{-- Hidden Inputs --}}
                    <input type="hidden" name="userId" value="{{Auth::user()->id}}" id="userId">
                    <input type="hidden" name="pizzaId" id="pizzaId" value="{{$pizzaDetails->id}}">

                    <h3>{{$pizzaDetails->name}}</h3>
                    <div class="d-flex mb-3">
                        {{-- Method 1 (Manual Increase View Count) --}}
                        {{-- <small class="pt-1"><i class="fa-regular fa-eye"></i> {{$pizzaDetails->view_count + 1}} view </small> --}}

                       {{-- Method 2 (Increase View Count with Laravel's built-in method) --}}
                        <small class="pt-1"><i class="fa-regular fa-eye"></i> {{$pizzaDetails->view_count}} view </small>
                    </div>
                    <h3 class="font-weight-semi-bold mb-4">{{number_format($pizzaDetails->price,2)}} Ks</h3>
                    <p class="mb-4">{{$pizzaDetails->description}}</p>
                    <div class="d-flex align-items-center mb-4 pt-2 gap-3">
                        <div class="input-group quantity mr-3" style="width: 130px;">

                            <div class="input-group-btn">
                                <button class="btn btn-warning btn-minus">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </div>

                            <input type="text" class="form-control bg-secondary border-0 text-center" value="1" id="orderCount">

                            <div class="input-group-btn">
                                <button class="btn btn-warning btn-plus">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="me-3">
                            <button class="btn btn-warning px-3" id="addToCartBtn"><i class="fa fa-shopping-cart mr-1"></i> Add To Cart</button>
                        </div>
                    </div>

                    <div class="d-flex align-items-center">
                        @if (Auth::check())
                        <form action="{{ route('product#rate') }}" method="POST" class=" d-flex align-items-center">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $pizzaDetails->id }}">

                            <div class="my-2 me-2">
                                <select name="rating_count" class="form-select form-select-sm" required style="min-width: 140px;">
                                    <option value="">Rating</option>
                                    @for($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}"> {{ $i }} Star{{ $i > 1 ? 's' : '' }}
                                        </option>
                                    @endfor
                                </select>
                            </div>

                            <button type="submit" class="btn btn-warning btn-sm my-2">Submit</button>

                        </form>
                        @endif
                    </div>

                    <div class="d-flex pt-2">
                        <strong class="text-dark mr-2">Share on:</strong>
                        <div class="d-inline-flex">
                            <a class="text-dark px-2" href="https://www.facebook.com/" target="_blank">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a class="text-dark px-2" href="https://x.com/?lang=en" target="_blank">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a class="text-dark px-2" href="https://www.linkedin.com/" target="_blank">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a class="text-dark px-2" href="https://www.pinterest.com/" target="_blank">
                                <i class="fab fa-pinterest"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- Shop Detail End -->


    <!-- Products Start -->
    <div class="container-fluid py-5">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="pr-3">You May Also Like</span></h2>
        <div class="row px-xl-5">
            <div class="col">
                <div class="owl-carousel related-carousel">
                    @foreach ($pizzaproducts as $eachPizza)
                        <div class="product-item bg-light">
                            <div class="product-img position-relative overflow-hidden" style="width: 100%; height: 200px;">
                                <img class="img-fluid w-100 h-100" src="{{asset('storage/'.$eachPizza->image)}}" alt="{{$eachPizza->name}}" style="object-fit: cover; object-position: center;">
                                <div class="product-action">
                                    <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
                                    <a class="btn btn-outline-dark btn-square" href="{{route('show#pizza',$eachPizza->id)}}"><i class="fa-solid fa-info"></i></a>
                                </div>
                            </div>
                            <div class="text-center py-4">
                                <a class="h6 text-decoration-none text-truncate" href="">{{$eachPizza->name}}</a>
                                <div class="d-flex align-items-center justify-content-center mt-2">
                                    <h5>{{number_format($eachPizza->price,2)}} Ks</h5>
                                </div>
                                <div class="d-flex align-items-center justify-content-center mb-1">
                                    {{-- <small class="fa fa-star text-primary mr-1"></small>
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small>(99)</small> --}}
                                    @php $avg = round($eachPizza->averageRating()) @endphp
                                        @for($i = 1; $i <= 5; $i++)
                                            <small class="fa fa-star {{ $i <= $avg ? 'text-warning' : 'text-muted' }} mr-1"></small>
                                        @endfor

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- Products End -->
@endsection

@section('script')
<script>
    $(document).ready(function(){

        // // Method 1 (Manual Increase View Count)
        // const productId = $('#pizzaId').val();
        // // console.log(productId);
        // $.ajax({
        //     type: "GET",
        //     url : "/user/view/count",
        //     data : {
        //         values : productId,
        //     },
        //     dataType : "json",
        //     success :function(response){
        //         console.log(response.status);
        //     },
        //     error : function (response){
        //         console.log("Error : ",response);
        //     }
        // });

         // Method 2 (Increase View Count with Laravel's built-in method)
         const productId = $('#pizzaId').val();
         const viewedKey = "viewed_product_" + productId;
        // console.log(productId);
            if(!sessionStorage.getItem(viewedKey)){
                $.ajax({
                    type: "GET",
                    url : "/user/view/count",
                    data : {
                        values : productId,
                    },
                    dataType : "json",
                    success :function(response){
                        console.log(response.status);
                        sessionStorage.setItem(viewedKey,true);
                    },
                    error : function (response){
                        console.log("Error : ",response);
                    }
                });
            }

        $('#addToCartBtn').on('click',function(){
            const values = {
                userIdValue : $('#userId').val(),
                pizzaIdValue : $('#pizzaId').val(),
                countValue : $('#orderCount').val(),
                _token: '{{ csrf_token() }}'
            };
            // console.log(values);

            $.ajax({
                type: "POST",
                url : "{{route('addttocart#ajax')}}",
                data : values,
                dataType: "Json",
                success : function(response){
                    // console.log(response);
                    alert('Pizza added to cart successfully!');
                    window.location.href = '{{route('user#home')}}';

                },
                error: function(response) {
                    alert('Something went wrong. Please try again!');
                    console.log("Error : ",response);
                }

            })


        });

    });
</script>
@endsection
