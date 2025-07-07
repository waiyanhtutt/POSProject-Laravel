@extends('admin.layouts.master')

@section('title','Order List Page')

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
                                <h2 class="title-1">Order List</h2>

                            </div>
                        </div>
                        <div class="table-data__tool-right">
                            <div class=" d-flex align-items-center">
                                <label for="order-status" class=" me-2 mb-0" style="white-space: nowrap; min-width: 100px;">Order Status</label>
                                <select name="status" id="orderStatus" class=" form-select form-select-sm">
                                    <option value="">All</option>
                                    <option value="0" >Pending</option>
                                    <option value="1" >Success</option>
                                    <option value="2" >Reject</option>
                                </select>

                               <a href="{{route('admin#orderList')}}" class="btn btn-secondary btn-sm">
                                    <i class="fa-solid fa-rotate"></i>
                               </a>

                            </div>

                        </div>
                    </div>

                    <div class="row my-3">
                        <div class="col">
                            <h5 class=" text-secondary">Search Key : {{request('searchKey')}}</h5>
                        </div>

                        <div class=" col-auto mb-3">
                            <form class="form-header" action="{{route('admin#orderList')}}" method="GET">
                                @csrf
                                    <input class="au-input au-input--xl" type="text" name="searchKey" placeholder="Search Orders..." id="search" value="{{request('searchKey')}}" />
                                    <button class="au-btn--submit" type="submit">
                                        <i class="zmdi zmdi-search"></i>
                                    </button>
                            </form>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class=" col-md-3">
                            <h4 class=" text-muted"><i class="fa-solid fa-database"> </i>
                            {{$orderLists->total()}}
                            </h4>
                        </div>
                    </div>

                        @if (count($orderLists) !== 0)
                        <div class="table-responsive table-responsive-data2">
                            <table class="table table-data2 text-center">
                                <thead>
                                    <tr>
                                        <th>User ID</th>
                                        <th>User Name</th>
                                        <th>Order Date</th>
                                        <th>Order Code</th>
                                        <th>Amount</th>
                                        <th>Status</th>

                                    </tr>
                                </thead>
                                <tbody id="orderList">
                                    @foreach ($orderLists as $orderList)
                                    <tr class="tr-shadow my-2">

                                        <td>{{$orderList->user_id}}
                                            <input type="hidden" class="orderId" value="{{$orderList->id}}">
                                        </td>
                                        <td class=" col-2">{{$orderList->user->name}}</td>
                                        <td class=" col-2">{{$orderList->created_at->format('j F Y')}}</td>
                                        <td>
                                           <a href="{{route('show#orderList',$orderList->order_code)}}" class=" text-decoration-none">{{$orderList->order_code}}
                                            </a> </td>
                                        <td class=" col-2 amount">{{number_format($orderList->total_price)}} Ks</td>
                                        <td class=" col-3">
                                            <select name="status" class=" form-select form-select-sm changeStatus">
                                                <option value="0" @if ($orderList->status == 0) selected @endif >Pending</option>
                                                <option value="1" @if ($orderList->status == 1) selected @endif >Success</option>
                                                <option value="2" @if ($orderList->status == 2) selected @endif >Rejected</option>
                                            </select>
                                        </td>

                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                            <div>
                               {{$orderLists->links()}}
                             </div>
                        </div>
                        @else
                            <h3 class=" text-muted text-center">There is no order here!</h3>
                        @endif
                    <!-- END DATA TABLE -->
                </div>

            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection
@section('script')

<script>
    $(document).ready(function(){
        $(document).change(function(){
            const orderStatus =  $('#orderStatus').val();
            // console.log(orderStatus);

            $.ajax({
                type: "GET",
                url : "{{route('status#filter')}}",
                data : {
                    status : orderStatus,
                },
                dataType : "json",

                success : function(response){
                    // console.log("AJAX success:", response);

                    let getOrderLists = "";
                    let months = ["January","February","March","April","May","June","July","August","September","October","November","December"];

                    response.orders.data.forEach(order=>{

                        const date = new Date(order.created_at);
                        const getMonths = months[date.getMonth()];
                        const getDay = date.getDate();
                        const getYear = date.getFullYear();
                        // console.log(date);
                        // console.log(getDay);
                        // console.log(getMonths);
                        // console.log(getYear);

                        const formattedDate = `${getDay} ${getMonths} ${getYear}`;
                        // console.log(formattedDate);

                        getOrderLists += `
                            <tr class="tr-shadow my-2">

                                        <td>${order.user_id}
                                            <input type="hidden" class="orderId" value="${order.id}">
                                        </td>
                                        <td class=" col-2">${order.user.name}</td>
                                        <td class=" col-2">${formattedDate}</td>
                                        <td>${order.order_code}</td>
                                        <td class=" col-2 amount">${Number(order.total_price).toLocaleString()} Ks</td>
                                        <td class=" col-3">
                                            <select name="status" class=" form-select form-select-sm changeStatus" >
                                                <option value="0" ${order.status == 0 ? 'selected' : ""} >Pending</option>
                                                <option value="1" ${order.status == 1 ? "selected" : ""} >Success</option>
                                                <option value="2" ${order.status == 2 ? "selected" : "" } >Rejected</option>
                                            </select>
                                        </td>
                            </tr>`
                    });

                    $('#orderList').html(getOrderLists);

                },
                error : function (response){
                    console.error("AJAX error:", response);
                }
            });

        });

        $(document).on('change', '.changeStatus', function () {
            let currentStatus = $(this).val();
            let currentrow = $(this).closest('tr');
            let orderId = currentrow.find('.orderId').val();
            console.log(orderId);
            // console.log(currentrow.find('.amount').html());

            let datas = {
                status : currentStatus,
                orderId : orderId,
                _token : "{{csrf_token()}}"
            };

            $.ajax({
                type : "POST",
                url : "{{route('update#Status')}}",
                data : datas,
                dataType : "json",
                success : function(response){
                    alert(response.message);
                },
                error : function(xhr){
                    console.error('Status Update Fail :', xhr.responseText);
                }
            })
        });


    });
</script>

@endsection


