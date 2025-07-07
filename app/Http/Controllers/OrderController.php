<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderList;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // Order List (Part Of User)
    public function orderList(Request $request)
    {

        $total = 0;

        foreach ($request->orders as $item) {
            $data = OrderList::create([
                'user_id' => $item['userId'],
                'product_id' => $item['productId'],
                'qty' => $item['qty'],
                'total' => $item['total'],
                'order_code' => $item['order_code'],
            ]);

            $total += $data->total;
        }

        // logger($data->order_code);
        // logger($total);

        Cart::where('user_id', Auth::user()->id)->delete();

        Order::create([
            'user_id' => Auth::user()->id,
            'order_code' => $data->order_code,
            'total_price' => $total + 3000

        ]);

        // logger($order);
        return response()->json([
            'status' => 'Success',
            'message' => 'Order received',
            'data' => $request->orders
        ]);
    }

    // part of Admin
    public function index()
    {
        $orderLists = Order::with('user')->when(request('searchKey'), function ($query) {
            $query->where('order_code', 'like', '%' . request('searchKey') . '%')
                ->orWhere('user_id', 'like', '%' . request('searchKey') . '%');
        })
            ->orderBy('created_at', 'desc')->paginate(5);
        return view('admin.orders.index', compact('orderLists'));
    }

    // status Filter (Part of Admin)
    public function statusFilter(Request $request)
    {
        // logger($request->status);

        //=> Method 1
        // $orders = Order::when($request->status !== null, function ($query) use ($request) {
        //     $query->where('status', $request->status);
        // })
        //     ->with('user') // to eager load user
        //     ->orderBy('created_at', 'desc')
        //     ->paginate(5);

        //=> Method 2

        $query = Order::with('user')->when(request('searchKey'), function ($query) {
            $query->where('order_code', 'like', '%' . request('searchKey') . '%')
                ->orWhere('user_id', 'like', '%' . request('searchKey') . '%');
        });

        if ($request->status !== null) {
            $query->where('status', $request->status);
        }

        $order = $query->orderBy('created_at', 'desc')->paginate(5)->appends($request->except('page'));

        // $order->appends([
        //     'status' => request('status'),
        //     'searchKey' => request('searchKey'),
        // ]);

        return response()->json([
            'status' => "Success",
            'orders' => $order
        ], 200);
    }

    // Status Update or Change (Part of Admin)

    public function updateStatus(Request $request)
    {
        $order = Order::findOrFail($request->orderId);

        $order->status = $request->status;
        $order->save();

        return response()->json([
            "message" => 'Order status updated successfully.',
        ], 200);
    }

    // show (order List)
    public function show($orderCode)
    {
        $orderLists = OrderList::where('order_code', $orderCode)->with(['product', 'user'])->get();
        $order = Order::where('order_code', $orderCode)->with('user')->first();

        return view('admin.orders.show', compact('orderLists', 'order'));
    }
}
