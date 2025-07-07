<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RatingCollection;
use App\Http\Resources\RatingResource;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ratings = Rating::all();

        return new RatingCollection($ratings);
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
            'user_id'   => 'required|exists:users,id',
            'product_id'   => 'required|exists:products,id',
            'rating_count' => 'required|integer|min:1|max:5',
        ]);

        $rating = Rating::create($validated);

        return response()->json([
            'message' => "Rating Created Successfully!",
            'data' => new RatingResource($rating)
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
        $rating = Rating::find($id);

        if (!$rating) {
            return response()->json([
                'message' => 'rating not found.'
            ], 404);
        }

        return new RatingResource($rating);
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
        $rating = Rating::findOrFail($id);

        if (!$rating) {
            return response()->json(['message' => 'rating not found'], 404);
        }

        $validated = $request->validate([
            'user_id'   => 'sometimes|exists:users,id',
            'product_id'   => 'sometimes|exists:products,id',
            'rating_count' => 'sometimes|integer|min:1|max:5',
        ]);

        $rating->update($validated);

        return response()->json([
            'message' => 'rating updated.',
            'data'    => new RatingResource($rating)
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
        $rating = Rating::findOrFail($id);
        if (!$rating) {
            return response()->json([
                'message' => "rating Not Found."
            ], 404);
        }
        $rating->delete();

        return response()->json([
            'message' => "rating deleted successfully."
        ]);
    }
}
