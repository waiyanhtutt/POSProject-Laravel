<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    // Create Product list and show
    public function list()
    {
        $pizzaLists = Product::select('products.*', 'categories.name as category_name')
            ->when(request('searchKey'), function ($query) {
                $query->where('products.name', 'like', '%' . request('searchKey') . '%');
            })->leftJoin('categories', 'products.category_id', 'categories.id')
            ->orderBy('created_at', 'desc')->paginate(3);

        $pizzaLists->appends(request()->all());
        return view('admin.products.pizzaList', compact('pizzaLists'));
    }

    // Direct Pizza Create Page
    public function createPage()
    {
        $getpizzaCategory = Category::select('id', 'name')->get();
        // dd($getpizzaCategory->toArray());
        return view('admin.products.create', compact('getpizzaCategory'));
    }

    // Create Pizza Product
    public function productCreate(Request $request)
    {
        // dd($request->all());

        $this->productValidationCheck($request, 'create');
        $getproductdata = $this->requestProductInfo($request);
        // dd($getproductdata);

        $fileName = uniqid() . $request->file('pizzaImage')->getClientOriginalName();
        $request->file('pizzaImage')->storeAs('public', $fileName);
        $getproductdata['image'] = $fileName;

        Product::create($getproductdata);
        return redirect()->route('product#list');
    }

    // View Pizza Product

    public function productView($id)
    {
        $pizzas = Product::select('products.*', 'categories.name as category_name')
            ->leftJoin('categories', 'products.category_id', 'categories.id')
            ->where('products.id', $id)->first();
        return view('admin.products.view', compact('pizzas'));
    }

    // Edit Pizza Product

    public function productEdit($id)
    {
        $pizzaEdit = Product::where('id', $id)->first();
        $category = Category::get();
        return view('admin.products.edit', compact('pizzaEdit', 'category'));
    }

    // Update Pizza Product
    public function productUpdate(Request $request)
    {
        $this->productValidationCheck($request, 'update');
        $getupdatedata = $this->requestProductInfo($request);
        // dd($getupdatedata);

        if ($request->hasFile('pizzaImage')) {
            $updateoldImage = Product::where('id', $request->pizzaId)->first();
            $updateoldImage = $updateoldImage->image;

            if ($updateoldImage !== null) {
                Storage::delete('public/' . $updateoldImage);
            }

            $fileName = uniqid() . $request->file('pizzaImage')->getClientOriginalName();
            $request->file('pizzaImage')->storeAs('public', $fileName);

            $getupdatedata['image'] = $fileName;
        }

        Product::where('id', $request->pizzaId)->update($getupdatedata);

        return redirect()->route('product#list');
    }

    // Delete Pizza Product

    public function productDelete($id)
    {
        $product = Product::where('id', $id)->first();
        $path = $product->image;

        if ($path) {
            Storage::delete('public/' . $path);
        }

        Product::where('id', $id)->delete();

        return redirect()->route('product#list')->with(['deleteMessage' => 'Product Delete Successfully.']);
    }

    // get data From User Request

    private function requestProductInfo($request)
    {
        return [
            'category_id' => $request->pizzaCategory,
            'name' => $request->pizzaName,
            'description' => $request->pizzaDescription,
            'image' => $request->pizzaImage,
            'waiting_time' => $request->pizzaWaitingTime,
            'price' => $request->pizzaPrice
        ];
    }

    // product Validation Check
    private function productValidationCheck($request, $action)
    {
        $validationRules = [
            'pizzaName' => 'required|min:5|unique:products,name,' . $request->pizzaId,
            'pizzaCategory' => 'required',
            'pizzaDescription' => 'required',
            'pizzaWaitingTime' => 'required',
            'pizzaPrice' => 'required'
        ];

        $validationRules['pizzaImage'] = $action == 'create' ? "required|mimes:jpeg,jpg,webp,png,gif|" : "mimes:jpeg,jpg,webp,png,gif";

        Validator::make($request->all(), $validationRules)->validate();
    }

    // Increase View Count With ajax
    public function increaseViewCount(Request $request)
    {
        // Method 1 (Manual Increase View Count)

        //     $product = Product::where('id', $request->values)->first();

        //     $viewCounts = [
        //         'view_count' => $product->view_count + 1
        //     ];

        //     $product->update($viewCounts);

        //     return response()->json([
        //         "status" => "Success",
        //     ], 200);

        // Method 2 (Increase View Count with Laravel's built-in method)

        $product = Product::findOrFail($request->values);

        if ($product) {
            $product->increment('view_count');

            return response()->json([
                "status" => "Success",
                "newCount" => $product->view_count
            ]);
        }

        return response()->json([
            'status' => "Product Not Found!",
        ], 404);
    }
}
