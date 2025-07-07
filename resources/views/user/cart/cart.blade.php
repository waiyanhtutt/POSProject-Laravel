@extends('user.layouts.master')

@section('content')
<!-- Cart Start -->
<div class="container-fluid">
        <div class="row px-xl-5">

            <div class="col-lg-8 table-responsive mb-5">
                <table class="table table-light table-borderless table-hover text-center mb-0" id="tableDatas">
                    <thead class="thead-dark">
                        <tr>
                            <th>Image</th>
                            <th>Products</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @foreach ($cartLists as $cartList)

                        <tr>
                            {{-- Method 1 --}}
                            {{-- <input type="hidden" id="pizzaPrice" value="{{$cartList->product->price}}"> --}}

                            <td><img src="{{asset('storage/'.$cartList->product->image)}}" alt="{{$cartList->product->name}}" class=" img-fluid h-100" style="width: 100px;"></td>
                            <td class="align-middle"> {{$cartList->product->name}}

                            <input type="hidden" id="cartId" value="{{$cartList->id}}">
                            <input type="hidden" id="productId" value="{{$cartList->product_id}}">
                            <input type="hidden" id="userId" value="{{$cartList->user_id}}">
                            <input type="hidden" class="total" value="{{$cartList->product->price*$cartList->qty}}">

                            </td>
                            <td class="align-middle" id="pizzaPrice">{{number_format($cartList->product->price,2)}} Ks</td>
                            <td class="align-middle">
                                <div class="input-group quantity mx-auto" style="width: 100px;">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-warning btn-minus" >
                                        <i class="fa fa-minus"></i>
                                        </button>
                                    </div>

                                    <input type="text" class="form-control form-control-sm bg-secondary border-0 text-center" value="{{$cartList->qty}}" id="qty">

                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-warning btn-plus">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>

                                </div>
                            </td>

                            <td class="align-middle col-3" id="totalPrice">
                               {{number_format($cartList->product->price*$cartList->qty,2)}} Ks
                            </td>
                            <td class="align-middle"><button class="btn btn-sm btn-warning removeBtn" ><i class="fa fa-trash"></i></button></td>
                        </tr>
                        @endforeach


                    </tbody>
                </table>
            </div>
            <div class="col-lg-4">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-dark text-white py-2 px-3">Cart Summary</span></h5>
                <div class="bg-light p-30 mb-5">
                <div class="border-bottom pb-2">
                    <div class="d-flex justify-content-between mb-3">
                        <h6>Subtotal</h6>
                        <h6 id="subtotalprice">{{number_format($totalPrice,2)}} Ks</h6>
                    </div>
                    <div class="d-flex justify-content-between">
                        <h6 class="font-weight-medium">Delevery Fees</h6>
                        <h6 class="font-weight-medium">3000 Ks</h6>
                    </div>
                </div>
                <div class="pt-2">
                    <div class="d-flex justify-content-between mt-2">
                        <h5>Total</h5>
                        <h5 id="plusdeleveryfee">{{number_format($totalPrice + 3000,2) }} Ks</h5>
                    </div>
                    <button class="btn btn-block btn-warning font-weight-bold my-3 py-3" id="checkoutBtn">Proceed To Checkout</button>

                    <button class="btn btn-block btn-dark font-weight-bold my-3 py-3" id="clearCartBtn">Clear Cart</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Cart End -->
@endsection

@section('script')

<script>
    $(document).ready(function(){
        $('.btn-plus').click(function(e){
            //=> extract value in input box (Method 1)

            // console.log(e.target);
            // let parentValue = $(this).closest('tr');
            // let price = parentValue.find('#pizzaPrice').val();
            // let quantity = parentValue.find('#qty').val();
            // let totalValue = price*quantity;
            // console.log(totalValue);
            // let formattedTotal = totalValue.toLocaleString(undefined,{minimumFractionDigits:2}) + " Ks";
            // parentValue.find('#totalPrice').html(formattedTotal);

            //=> Extract Value in Td (Method 2)
            let parentValue = $(this).closest('tr');
            let price = parentValue.find('#pizzaPrice').text();
            let numericValuePrice = parseFloat(price.replace(/[^0-9.]/g,""));
            // console.log(numericValuePrice);
            let quantity = parentValue.find('#qty').val();
            let totalValue = numericValuePrice*quantity;
            // console.log(totalValue);
            let formattedTotal = totalValue.toLocaleString(undefined,{minimumFractionDigits:2}) + " Ks";
            parentValue.find('#totalPrice').html(formattedTotal);
            parentValue.find('.total').val(totalValue);

            calculateCartTotal();
        });

        $('.btn-minus').click(function(e){
            // console.log(e.target);
            // let parentValue = $(this).parents('tr');
            // let price = parentValue.find('#pizzaPrice').val();
            // let quantity = parentValue.find('#qty').val();
            // let totalValue = price*quantity;
            // let formattedTotal = totalValue.toLocaleString(undefined,{minimumFractionDigits:2}) + "Ks";
            // parentValue.find('#totalPrice').html(formattedTotal);

            //=> Method 2
            let parentValue = $(this).parents('tr');
            let price = parentValue.find('#pizzaPrice').text();
            let numericValuePrice = parseFloat(price.replace(/[^0-9.]/g,""));
            // console.log(numericValuePrice);
            let quantity = parentValue.find('#qty').val();
            let totalValue = numericValuePrice*quantity;
            // console.log(totalValue);
            let formattedTotal = totalValue.toLocaleString(undefined,{minimumFractionDigits:2}) + " Ks";
            parentValue.find('#totalPrice').html(formattedTotal);
            parentValue.find('.total').val(totalValue);

            calculateCartTotal();
        });


        function calculateCartTotal() {
            let total = 0;
            $('#tableDatas tr').each(function(index, row){
                let priceText = $(row).find('#totalPrice').text();
                let numericvaluetotalprice = parseFloat(priceText.replace(/[^0-9.]/g, ''));

                if(!isNaN(numericvaluetotalprice)){
                    total += numericvaluetotalprice;
                }

            });

            let formattedTotalPrice = total.toLocaleString(undefined, { minimumFractionDigits: 2 }) + " Ks";
            // console.log("Total Sum one:", total.toLocaleString(undefined, { minimumFractionDigits: 2 }) + " Ks");

            $('#subtotalprice').html(formattedTotalPrice);
            let deleveryfees = 3000;
            let grandTotal = total + deleveryfees;
            let formattedgrandTotal = grandTotal.toLocaleString(undefined,{minimumFractionDigits:2}) + " Ks";

            $('#plusdeleveryfee').html(formattedgrandTotal);
        }

        $('#checkoutBtn').click(function(){
            const orderList = [];
            const randomNumber = Math.floor(Math.random() * 10000001);
            const orderCode = 'POS' + randomNumber;

           $('#tableDatas tbody tr').each(function(index,row){

            // console.log($(row).find('.total').val());

               orderList.push({
                'userId': $(row).find('#userId').val(),
                'productId': $(row).find('#productId').val(),
                'qty': $(row).find('#qty').val(),
                'total' : $(row).find('.total').val(),
                'order_code' : orderCode,
               });

           });

        //    console.log("Order List to send:", orderList);

           $.ajax({
                type: "POST",
                url: "{{route('user#orderList')}}",
                data: {
                    orders : orderList,
                    _token : '{{csrf_token()}}'

                },
                dataType: "json",
                success: function(response){
                    // console.log(response);
                   if(response.status == "Success"){
                    alert('Order placed successfully!');
                    window.location.href = '{{route('user#home')}}';
                   }
                },
                error: function(response){
                    console.log("Error : ", response);
                }
           });
        });

        // clear cart (individually)
        $('.removeBtn').click(function(){

           const trDatas = $(this).closest('tr');
           const productId = trDatas.find('#productId').val();
           const cartId = trDatas.find('#cartId').val();
           console.log(cartId);

           $.ajax({
            type:"POST",
            url: "{{route('currentCart#clear')}}",
            data : {
                'idforProduct' : productId,
                'idforCart' : cartId,
                _method: 'DELETE',
                _token : '{{csrf_token()}}'
            },
            dataType: "json",
            success : function(response){
                if (response.status === "Success") {
                        alert('Cart deleted successfully!');
                    } else {
                        alert('Failed to delete cart.');
                    }
            },
            error: function(response){
                console.error("AJAX error:", response);
            }

           });

           trDatas.remove();
           calculateCartTotal();

        });

        // Clear Cart (All clear)
        $('#clearCartBtn').click(function(){
            $('#tableDatas tbody tr').remove();
            $('#subtotalprice').html('0 Ks');
            $('#plusdeleveryfee').html('0 ks');

            $.ajax({
                type : "POST",
                url : "{{route('cart#clear')}}",
                data: {
                    _method: 'DELETE',
                    _token: '{{ csrf_token() }}'
                },
                dataType : "json",
                success: function(response){
                    if (response.status === "Success") {
                        alert('Cart cleared successfully!');
                    } else {
                        alert('Failed to clear cart.');
                    }
                },
                error:function(response){
                    console.error("AJAX error:", response);
                    alert('Error clearing cart.');
                }
            });

        });

    });
</script>

@endsection






