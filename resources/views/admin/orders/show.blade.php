@extends('admin.layouts.master')

@section('title','Order List Page')

@section('content')
     <!-- MAIN CONTENT-->
     <div class="main-content">

        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class=" mb-2">
                    <a href="{{route('admin#orderList')}}" class=" text-decoration-none text-secondary">
                        <i class="fa-solid fa-arrow-left me-2"></i>Back
                    </a>
                </div>

                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    <div class="table-data__tool">
                        <div class="table-data__tool-left">
                            <div class="overview-wrap">
                                <h2 class=" me-2">Order List Info </h2>

                            </div>
                        </div>
                    </div>

                    {{-- <div class="row">
                         <div class="col-9 offset-6 text-success small fs-6 d-flex align-items-center">
                            <i class="fa-solid fa-bell me-2"></i> Includes Delivery Fees
                        </div>
                    </div> --}}

                    <div class="row">
                        <div class="col-md-3 mb-0">
                            <div class="card h-80 shadow-sm">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h5 class="text-dark text-xs mb-1">Name</h5>
                                            <p class="h6 text-muted">{{$order->user->name}}</p>
                                        </div>

                                        <div class="col-auto">
                                            <i class="fa-regular fa-user"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-md-3 mb-0">
                            <div class="card h-80 shadow-sm">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h5 class="text-dark text-xs mb-1">Order Code</h5>
                                            <p class="h6 text-muted">{{$order->order_code}}</p>
                                        </div>

                                        <div class="col-auto">
                                            <i class="fa-solid fa-barcode me-2"></i>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-md-3 mb-0">
                            <div class="card h-80 shadow-sm">
                                <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="text-success small text-nowrap d-flex align-items-center">
                                                <i class="fa-solid fa-bell me-2"></i> Includes Delivery Fees
                                            </div>
                                            <div class="col">
                                                <h5 class="text-dark text-xs mb-1">Total Price</h5>
                                                <p class="h6 text-muted">{{number_format($order->total_price)}} Ks</p>
                                            </div>

                                            <div class="col-auto">
                                                <i class="fa-solid fa-money-check-dollar me-2"></i>
                                            </div>

                                        </div>



                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-0">
                            <div class="card h-80 shadow-sm">

                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h5 class="text-dark text-xs mb-1">Order Status</h5>
                                            <p class="h6 text-muted">
                                                @if ($order->status == 0)
                                                    Pending
                                                @elseif($order->status == 1)
                                                    Success
                                                @elseif($order->status == 2)
                                                    Rejected
                                                @endif
                                            </p>
                                        </div>

                                        <div class="col-auto">
                                            <i class="fa-solid fa-signal me-2"></i>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>



                        <div class="table-responsive table-responsive-data2">
                            <table class="table table-data2 text-center">
                                <thead>
                                    <tr>
                                        <th>OrderList ID</th>
                                        <th>Product Image</th>
                                        <th>Product Name</th>
                                        <th>Order Date</th>
                                        <th>Quantity</th>
                                        <th>Total</th>

                                    </tr>
                                </thead>
                                <tbody id="orderList">
                                    @foreach ($orderLists as $orderList)
                                    <tr class="tr-shadow my-2">
                                        <td>{{$orderList->id}}</td>
                                        <td class=" col-2">
                                            <img src="{{asset('storage/'.$orderList->product->image)}}" class=" img-thumbnail shadow-sm" alt="">
                                        </td>
                                        <td>{{$orderList->product->name}}</td>
                                        <td>{{$orderList->created_at->format('j F Y')}}</td>
                                        <td>{{$orderList->qty}}</td>
                                        <td>{{number_format($orderList->total)}} Ks</td>
                                    </tr>
                                </tbody>
                                    @endforeach
                            </table>
                            <div>
                               {{-- {{$orderLists->links()}} --}}
                             </div>
                        </div>

                    <!-- END DATA TABLE -->
                </div>

            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection


