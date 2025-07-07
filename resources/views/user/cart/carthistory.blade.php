@extends('user.layouts.master')

@section('content')
<!-- Cart Start -->
<div class="container-fluid" style="height:500px">
        <div class="row px-xl-5">

            <div class="col-lg-8 offset-lg-2 table-responsive mb-5">
                <table class="table table-light table-borderless table-hover text-center mb-0" id="tableDatas">
                    <thead class="thead-dark">
                        <tr>
                            <th>Date</th>
                            <th>Order ID</th>
                            <th>Total Price</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @foreach ($cartHistoryLists as $cartHistoryList)

                        <tr>
                            <td class="align-middle"> {{$cartHistoryList->created_at->format('j F Y')}}</td>
                            <td class="align-middle"> {{$cartHistoryList->order_code}}</td>
                            <td class="align-middle col-3"> {{number_format($cartHistoryList->total_price,2)}} Ks</td>
                            <td class="align-middle col-3">
                                @if ($cartHistoryList->status == 0)
                                    <button class="btn btn-sm shadow-sm btn-warning">Pending...</button>
                                @elseif($cartHistoryList->status == 1)
                                    <button class="btn btn-sm shadow-sm btn-success">Success...</button>
                                @elseif($cartHistoryList->status == 2)
                                    <button class="btn btn-sm shadow-sm btn-danger">Reject...</button>
                                @endif
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>

            </div>
            <div class="mt-3">
                {{$cartHistoryLists->links()}}
            </div>

        </div>
    </div>
</div>
<!-- Cart End -->
@endsection

@section('script')

<script>

</script>

@endsection






