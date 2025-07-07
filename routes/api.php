<?php

use App\Http\Controllers\Api\CategoriesApiController;
use App\Http\Controllers\Api\ContactApiController;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\RatingApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// manual API Testing with Postman For Contact

Route::get('/contact/list', [ContactApiController::class, 'index']);
Route::post('/contact/create', [ContactApiController::class, 'store']);
Route::get('/contact/show/{id}', [ContactApiController::class, 'show']);
Route::put('/contact/update/{id}', [ContactApiController::class, 'update']);
Route::delete('/contact/delete/{id}', [ContactApiController::class, 'destroy']);

// Api for Product
Route::apiResource('/products', ProductApiController::class);

// Api for Category
Route::apiResource('/categories', CategoriesApiController::class);

// Api for Rating
Route::apiResource('/ratings', RatingApiController::class);
