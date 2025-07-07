<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Expr\FuncCall;

class UserController extends Controller
{
    public function index()
    {
        $pizzaproducts = Product::orderBy('created_at', 'desc')->get();
        $pizzaCategories = Category::all();
        $cartCount = Cart::where('user_id', Auth::user()->id)->count();
        $cartHistoryCount = Order::where('user_id', Auth::user()->id)->count();
        return view('user.main.home', compact('pizzaproducts', 'pizzaCategories', 'cartCount', 'cartHistoryCount'));
    }

    public function editPassword()
    {
        return view('user.account.changePassword');
    }

    public function updatePassword(Request $request)
    {
        $this->passwordValidationCheck($request);
        $currentUserId = Auth::user()->id;
        $userPassword = User::select('password')->where('id', $currentUserId)->first();
        $userHashPassword = $userPassword->password;

        if (Hash::check($request->oldPassword, $userHashPassword)) {
            $userNewPassword = [
                "password" => Hash::make($request->newPassword)
            ];

            User::where('id', $currentUserId)->update($userNewPassword);

            return back()->with(['changePassword' => 'Password Changed']);
        }

        return back()->with(['incorrectPassword' => "Old Password does not match"]);
    }

    // user (account Update)
    public function editAccount()
    {
        return view('user.account.accountEdit');
    }

    public function updateAccount(Request $request, $id)
    {
        $this->accountValidationCheck($request, $id);
        $user = User::findOrFail($id);
        $data = $this->getUpdateUserData($request);

        if ($request->hasFile('image')) {

            if ($user->image) {
                Storage::delete('public/' . $user->image);
            }

            $fileName = uniqid() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public', $fileName);
            $data['image'] = $fileName;
        }

        $user->update($data);
        return redirect()->route('user#home')->with(['updateSuccess' => 'Updated Success']);
    }

    private function getUpdateUserData($request)
    {
        return [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'address' => $request->address,
            'updated_at' => Carbon::now()

        ];
    }

    private function passwordValidationCheck($request)
    {
        Validator::make($request->all(), [
            'oldPassword' => 'required|min:8|max:15',
            'newPassword' => 'required|min:8|max:15',
            'confirmPassword' => 'required|min:8|max:15|same:newPassword',
        ])->validate();
    }

    private function accountValidationCheck($request, $id)
    {
        Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'image' => 'mimes:png,jpg,jpeg|file',
            'phone' => 'required',
            'gender' => 'required',
            'address' => 'required'
        ])->validate();
    }

    // Sorting(ajax)
    public function pizzaList(Request $request)
    {
        // logger($request->all());
        if ($request->status == "desc") {
            $data = Product::orderBy('created_at', 'desc')->get();
        } else {
            $data = Product::orderBy('created_at', 'asc')->get();
        }

        return response()->json($data);
    }

    // Add To Cart(ajax)
    public function addToCart(Request $request)
    {
        $data = $this->getOrderData($request);
        // logger($data);

        Cart::create($data);
        return response()->json([
            'message' => "Added to cart successfully.",
            'data' => $data
        ], 200);
    }

    // To get Cart data
    private function getOrderData($request)
    {
        return [
            'user_id' => $request->userIdValue,
            'product_id' => $request->pizzaIdValue,
            'qty' => $request->countValue,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];
    }

    // Cart List (method 1)

    // public function cartList()
    // {
    //     $cartLists = Cart::select('carts.*', 'products.name as pizza_name', 'products.price as pizza_price')->leftjoin('products', 'products.id', 'carts.product_id')
    //         ->where('carts.user_id', Auth::user()->id)->get();
    //     // dd($cartLists->toArray());

    //     $totalPrice = 0;

    //     foreach ($cartLists as $cartList) {
    //         $totalPrice += $cartList->pizza_price * $cartList->qty;
    //         // dd($totalPrice);
    //     }

    //     return view('user.cart.cart', compact('cartLists', 'totalPrice'));
    // }

    // Cart List (method 2)

    public function cartList()
    {
        $cartLists = Cart::with('product')->where('user_id', Auth::user()->id)->get();
        // dd($cartLists->toArray());

        $totalPrice = 0;

        foreach ($cartLists as $cartList) {
            $totalPrice += $cartList->product->price * $cartList->qty;
            // dd($totalPrice);
        }

        return view('user.cart.cart', compact('cartLists', 'totalPrice'));
    }

    // Filtering with Category
    public function categoryFilterList($id)
    {
        $pizzaproducts = Product::where('category_id', $id)->orderBy('created_at', 'desc')->get();
        $pizzaCategories = Category::all();
        $cartCount = Cart::where('user_id', Auth::user()->id)->count();
        $cartHistoryCount = Order::where('user_id', Auth::user()->id)->count();

        return view('user.main.home', compact('pizzaproducts', 'pizzaCategories', 'cartCount', 'cartHistoryCount'));
    }

    public function show($id)
    {
        $pizzaDetails = Product::findOrFail($id);
        $pizzaproducts = Product::get();
        return view('user.main.detail', compact('pizzaDetails', 'pizzaproducts'));
    }

    // Admin Part( Show User List)
    public function lists(Request $request)
    {
        $searchKey = request('searchKey');

        $query = User::where('role', 'user');

        if ($searchKey) {
            $query->where('name', 'like', '%' . $searchKey . '%');
        }

        $users =  $query->orderBy('created_at', 'desc')->paginate(5)->appends($request->except('page'));

        return view('admin.users.list', compact('users'));
    }

    public function updateStatus(Request $request)
    {

        $user = User::findOrFail($request->userId);

        $user->role = $request->status;
        $user->save();

        return response()->json([
            'message' => "Role Updated Sucessfully",
        ], 200);
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);

        if ($user->image) {
            Storage::delete('public/' . $user->image);
        }

        $user->delete();

        return back()->with('deleteMessage', 'User deleted successfully.');
    }
}
