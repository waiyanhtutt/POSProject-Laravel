<?php

use Faker\Guesser\Name;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;

// Login , Register

Route::middleware(['admin_auth'])->group(function () {
    Route::redirect('/', 'loginPage');
    Route::get('loginPage', [AuthController::class, 'dologin'])->name('auth#login');
    Route::get('registerPage', [AuthController::class, 'doregister'])->name('auth#register');
});


Route::middleware(['auth'])->group(function () {

    // dashboard
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

    Route::middleware(['admin_auth'])->group(function () {
        // admin -> category
        Route::prefix('category')->group(function () {
            // admin -> category(home)
            Route::get('/list', [CategoryController::class, 'list'])->name('category#list');
            // admin -> category(create)
            Route::get('create/page', [CategoryController::class, 'createPage'])->name('category#createPage');
            // admin -> Create category(get data to create)
            Route::post('create', [CategoryController::class, 'create'])->name('category#create');
            // admin -> Delete category
            Route::get('delete/{id}', [CategoryController::class, 'delete'])->name('category#delete');
            // admin -> Edit category
            Route::get('edit/{id}', [CategoryController::class, 'edit'])->name('category#edit');
            // admin -> Update category
            Route::post('update', [CategoryController::class, 'update'])->name('category#update');
        });


        // admin (Account)
        Route::prefix('admin')->group(function () {
            // admin (Change Password)
            Route::get('password/change', [AdminController::class, 'changePassword'])->name('admin#changePassword');
            Route::post('password/changedata/getdata', [AdminController::class, 'passwordChange'])->name('admin#passwordchangedata');

            // admin (Account Infos)
            Route::get('account/infos', [AdminController::class, "infos"])->name("account#infos");

            // admin (Account Infos Edit)
            Route::get('account/edit', [AdminController::class, 'edit'])->name('account#edit');

            // admin (Account Infos Update)
            Route::post('update/{id}', [AdminController::class, 'update'])->name('account#update');

            // admin List
            Route::get('list', [AdminController::class, 'list'])->name('admin#list');

            // admin List Delete
            Route::get('delete/{id}', [AdminController::class, 'delete'])->name('admin#delete');

            // admin Change Role
            Route::get('admin/role/change/{id}', [AdminController::class, 'editRole'])->name('admin#editRole');
            Route::put('admin/role/update/{id}', [AdminController::class, 'updateRole'])->name('admin#updateRole');

            // admin Change Role (with Ajax)
            // Route::post('role/update', [AdminController::class, 'roleUpdatewithAjax'])->name('role#update');
            // admin Change Role (with Btn Group)
            Route::post('/admin/ajax/change-role', [AdminController::class, 'roleUpdatewithAjax'])->name('role#update');
        });

        // admin (product List)
        Route::prefix('product')->group(function () {
            Route::get('list', [ProductController::class, 'list'])->name('product#list');
            Route::get('create', [ProductController::class, 'createPage'])->name('product#create');
            Route::post('create', [ProductController::class, 'productCreate'])->name('product#createList');
            // product Delete
            Route::get('delete/{id}', [ProductController::class, 'productDelete'])->name('product#delete');
            // product view
            Route::get('view/{id}', [ProductController::class, 'productView'])->name('product#view');
            // product edit
            Route::get('eidt/{id}', [ProductController::class, 'productEdit'])->name('product#edit');
            // product update
            Route::post('update', [ProductController::class, 'productUpdate'])->name('product#update');
        });

        // admin (Order Part)
        Route::prefix('orders')->group(function () {
            Route::get('list', [OrderController::class, 'index'])->name('admin#orderList');

            // ajax for status Filter
            Route::get('status/filter', [OrderController::class, 'statusFilter'])->name('status#filter');
            // ajax for Status Update
            Route::post('/status/update', [OrderController::class, 'updateStatus'])->name('update#Status');
            // Show Order List
            Route::get('list/show/{orderCode}', [OrderController::class, 'show'])->name('show#orderList');
        });

        // Admin (user list)
        Route::prefix('users')->group(function () {
            Route::get('lists', [UserController::class, 'lists'])->name('users#lists');

            Route::get('lists/delete/{id}', [UserController::class, 'delete'])->name('user#listsDelete');

            // ajax for Status Update
            Route::post('status/update', [UserController::class, 'updateStatus'])->name('user#statusUpdate');
        });

        // To Cantact (Admin part)
        Route::get('/contact/list', [ContactController::class, 'index'])->name('contact#list');
        Route::delete('/contact/delete/{id}', [ContactController::class, 'destroy'])->name('contact#destroy');
        Route::get('contact/show/message/{id}', [ContactController::class, 'show'])->name('contact#show');
    });

    // user -> home
    Route::group(['prefix' => 'user', 'middleware' => 'user_auth'], function () {
        // Route::get('/home', function () {
        //     return view('user.home');
        // })->name('user#home');

        Route::get('/home', [UserController::class, 'index'])->name('user#home');
        Route::get('pizza/detail/{id}', [UserController::class, 'show'])->name('show#pizza');

        // increase view Count with ajax
        Route::get('view/count', [ProductController::class, 'increaseViewCount'])->name('increase#viewCount');

        // user (change password)
        Route::get('password/edit', [UserController::class, 'editPassword'])->name('user#passwordEdit');
        Route::post('password/update', [UserController::class, 'updatePassword'])->name('user#passwordUpdate');

        // user (Change Account)

        Route::prefix('account')->group(function () {
            Route::get('edit', [UserController::class, 'editAccount'])->name('user#accountEdit');
            Route::post('update/{id}', [UserController::class, 'updateAccount'])->name('user#accountUpdate');
        });

        // sorting
        Route::get('pizza/list', [UserController::class, 'pizzaList'])->name('pizzaList#ajax');
        // category Filter
        Route::get('categoty/filter/{id}', [UserController::class, 'categoryFilterList'])->name('category#FilterList');

        // Add to Cart
        Route::post('addToCart', [UserController::class, 'addToCart'])->name('addttocart#ajax');
        Route::get('cart/list', [UserController::class, 'cartList'])->name('user#cartList');

        // Cart History and Clear Cart
        Route::get('cart/history', [CartController::class, 'history'])->name('cart#history');
        // Clear Cart (All clear)
        Route::delete('cart/clear', [CartController::class, 'clearCart'])->name('cart#clear');
        // clear cart (individually)
        Route::delete('cart/current/clear', [CartController::class, 'clearCurrentCart'])->name('currentCart#clear');

        // Add to orderList
        Route::post('order', [OrderController::class, 'orderList'])->name('user#orderList');

        // To Cantact (user part)
        Route::post('/contact/store', [ContactController::class, 'store'])->name('contact#store');

        // Rating (User Part)
        Route::post('/rate/product', [RatingController::class, 'store'])->name('product#rate');
    });
});
