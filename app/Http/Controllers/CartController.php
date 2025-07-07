<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\FuncCall;

class CartController extends Controller
{
    public function history()
    {
        $cartHistoryLists = Order::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->paginate(5);
        return view('user.cart.carthistory', compact('cartHistoryLists'));
    }

    public function clearCart()
    {
        Cart::where('user_id', Auth::user()->id)->delete();

        return response()->json([
            'status' => 'Success',
        ]);
    }

    public function clearCurrentCart(Request $request)
    {
        // logger($request->all());
        Cart::where('user_id', Auth::user()->id)->where('product_id', $request->idforProduct)->where('id', $request->idforCart)
            ->delete();

        return response()->json([
            'status' => 'Success',
            'message' => 'Item removed from cart.'
        ]);
    }
}
