<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductCollection;

class ProductApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();

        return new ProductCollection($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id'   => 'required|integer',
            'name'          => 'required|string|max:255',
            'description'   => 'required|string',
            'image'         => 'nullable|string',
            'waiting_time'  => 'required|integer',
            'price'         => 'required|numeric',
        ]);

        $product = Product::create($validated);

        return response()->json([
            'message' => "Products Create Successfully!",
            'data' => new ProductResource($product)
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'message' => 'Product not found.'
            ], 404);
        }

        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $validated = $request->validate([
            'category_id'   => 'sometimes|integer',
            'name'          => 'sometimes|string|max:255',
            'description'   => 'sometimes|string',
            'image'         => 'nullable|string',
            'waiting_time'  => 'sometimes|integer',
            'price'         => 'sometimes|numeric',
        ]);

        $product->update($validated);

        return response()->json([
            'message' => 'product updated.',
            'data'    => new ProductResource($product)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        if (!$product) {
            return response()->json([
                'message' => "product Not Found."
            ], 404);
        }
        $product->delete();

        return response()->json([
            'message' => "Product deleted successfully."
        ]);
    }
}
