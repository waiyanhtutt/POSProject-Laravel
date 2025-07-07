@extends('user.layouts.master')

@section('content')
     <!-- Shop Start -->
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

            @if (session('contactSuccess'))
                <div class="col-md-6 offset-3">
                    <div class="text-center alert alert-success alert-dismissible fade show" role="alert">
                        <strong>{{session('contactSuccess')}}</strong>
                        <button type="button" class=" btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>

            @endif
        </div>
        <div class="row px-xl-5">
            <!-- Shop Sidebar Start -->
            <div class="col-lg-3 col-md-4">
                <!-- Price Start -->
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="pr-3">Filter by Category</span></h5>
                <div class="bg-light p-4 mb-30">
                    <form>
                        <div class="d-flex align-items-center justify-content-between mb-3 bg-dark text-white px-3 py-1">
                            <label class="mt-2" for="price-all"> All Categories</label>
                            <span class="badge border font-weight-normal ">{{count($pizzaCategories)}}</span>
                        </div>

                        <div class="d-flex align-items-center mb-3 pt-1 shadow-sm">
                            <a href="{{route('user#home')}}" class=" text-decoration-none text-dark">All Pizza</a>
                        </div>

                        @foreach ($pizzaCategories as $pizzaCategory)
                            <div class=" d-flex align-items-center justify-content-between mb-3 pt-1 shadow-sm">
                                <a href="{{route('category#FilterList',$pizzaCategory->id)}}" class=" text-decoration-none text-dark">{{$pizzaCategory->name}}</a>

                                <span class="badge border font-weight-normal text-dark">
                                    {{$pizzaCategory->products->count()}}
                                </span>
                            </div>
                        @endforeach

                    </form>
                </div>
                <!-- Price End -->

            </div>
            <!-- Shop Sidebar End -->

            <!-- Shop Product Start -->
            <div class="col-lg-9 col-md-8">
                <div class="row pb-3">
                    <div class="col-12 pb-1">
                        <div class="d-flex align-items-center justify-content-between mb-4 mt-3 mt-lg-0">
                            <div>
                                <a href="{{route('user#cartList')}}">
                                    <button type="button" class="btn btn-warning position-relative">
                                        <i class="fa-solid fa-cart-plus"></i>
                                        Cart
                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{$cartCount}}
                                        </span>
                                    </button>
                                </a>

                                <a href="{{route('cart#history')}}">
                                    <button type="button" class="btn btn-warning position-relative ms-2">
                                        <i class="fa-solid fa-clock-rotate-left"></i>
                                        History
                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{$cartHistoryCount}}
                                        </span>
                                    </button>
                                </a>
                            </div>

                            <div class="ml-2">
                                <div class="btn-group">
                                   <select name="sorting" id="sortingPizzaList" class=" form-select">
                                    <option value="" selected disabled>Choose Your Favourite</option>
                                    <option value="desc">Latest Pizza</option>
                                    <option value="asc">Classic Pizza</option>
                                   </select>
                                </div>

                                {{-- <div class="btn-group ml-2">
                                    <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">Showing</button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#">10</a>
                                        <a class="dropdown-item" href="#">20</a>
                                        <a class="dropdown-item" href="#">30</a>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                    @if (count($pizzaproducts) !== 0)
                        <div id="pizzaDataList" class="row">
                            @foreach ($pizzaproducts as $pizzaproduct)
                                <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                                    <div class="product-item bg-light mb-4 pizzaItems">
                                        <div class="product-img position-relative overflow-hidden" style="height: 250px;">
                                            <img class="img-fluid w-100 h-100" src="{{asset('storage/'.$pizzaproduct->image)}}"  alt="{{$pizzaproduct->name}}" style="object-fit: cover">
                                            <div class="product-action">
                                                <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
                                                <a class="btn btn-outline-dark btn-square" href="{{route('show#pizza',$pizzaproduct->id)}}"><i class="fa-solid fa-info"></i></a>
                                            </div>
                                        </div>
                                        <div class="text-center py-4">
                                            <a class="h6 text-decoration-none text-truncate" href="">{{$pizzaproduct->name}}</a>
                                            <div class="d-flex align-items-center justify-content-center mt-2">
                                                <h5>{{number_format($pizzaproduct->price,2)}} Ks</h5>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-center mb-1">
                                                @php $avg = round($pizzaproduct->averageRating()) @endphp
                                                @for($i = 1; $i <= 5; $i++)
                                                    <small class="fa fa-star {{ $i <= $avg ? 'text-warning' : 'text-muted' }} mr-1"></small>
                                                @endfor

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center w-100 my-5 text-muted">
                            <p>No pizzas found in this category!</p>
                            <i class="fa-solid fa-pizza-slice fa-2x"></i>

                        </div>
                    @endif


                </div>
            </div>
            <!-- Shop Product End -->
        </div>
    </div>
    <!-- Shop End -->
@endsection
@section('script')
<script>
    $(document).ready(function(){
       $("#sortingPizzaList").on('change',function(){
        // e.preventDefault();

        const sortingValue = $(this).val();

        $.ajax({
            type: "GET",
            url : "{{url('user/pizza/list')}}",
            data: {status: sortingValue},
            dataType: "json",
            success : function (response){
                // console.log(response);
                let pizzaList = "";
                response.forEach(pizza=>{
                   pizzaList += `<div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                                <div class="product-item bg-light mb-4">
                                    <div class="product-img position-relative overflow-hidden" style="height: 250px;">
                                        <img class="img-fluid w-100 h-100" src="{{asset('storage/${pizza.image}')}}"  alt="${pizza.name}" style="object-fit: cover">
                                        <div class="product-action">
                                            <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
                                            <a class="btn btn-outline-dark btn-square" href=""><i class="fa-solid fa-info"></i></a>
                                        </div>
                                    </div>
                                    <div class="text-center py-4">
                                        <a class="h6 text-decoration-none text-truncate" href="">${pizza.name}</a>
                                        <div class="d-flex align-items-center justify-content-center mt-2">
                                            <h5>${Number(pizza.price).toLocaleString(undefined, { minimumFractionDigits: 2 })} Ks</h5>
                                        </div>
                                        {{-- <div class="d-flex align-items-center justify-content-center mb-1">
                                            <small class="fa fa-star text-warning mr-1"></small>
                                            <small class="fa fa-star text-warning mr-1"></small>
                                            <small class="fa fa-star text-warning mr-1"></small>
                                            <small class="fa fa-star text-warning mr-1"></small>
                                            <small class="fa fa-star text-warning mr-1"></small>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>`;
                });

                $('#pizzaDataList').html(pizzaList);

            }
        });

       })
    });
</script>

@endsection



