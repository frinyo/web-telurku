<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These 
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [MainController::class, 'index'])->name('Home');
Route::get('/products', [MainController::class, 'allProducts'])->name('Product.All');
Route::get('/product/{product}', [MainController::class, 'detailProduct'])->name('Product.Detail');
Route::get('/about', function () {
    return view('pages.about');
})->name('About');
Route::get('/contact', function () {
    return view('pages.contact');
})->name('Contact');
Route::post('/send-message', [MainController::class, 'sendMessage'])->name('SendMessage');

// GUEST
Route::group(['middleware' => 'guest'], function () {
    Route::get('/login', [AuthController::class, 'loginView'])->name('Auth.LoginView');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('Auth.Login');
    Route::get('/register', [AuthController::class, 'registerView'])->name('Auth.RegisterView');
    Route::post('/register', [AuthController::class, 'register'])->name('Auth.Register');
    Route::get('/admin-login', function () {
        return view('pages.admin.adminLogin');
    })->name('Admin.Login');
    Route::post('/admin-login', [AuthController::class, 'authenticate'])->name('Auth.Login');
});

// AUTH
Route::group(['middleware' => 'auth'], function () {
    Route::get('/my-orders', [OrderController::class, 'myOrder'])->name('Orders');
    Route::get('/my-profile',  [MainController::class, 'myProfile'])->name('Profile');

    Route::get('/cart', [CartItemController::class, 'index'])->name('Cart.View');
    Route::post('/cart', [CartItemController::class, 'store'])->name('Cart.Add');
    Route::delete('/cart/{cartItem}',  [CartItemController::class, 'destroy'])->name('Cart.Delete');
    Route::post('/cart/checkout', [CartItemController::class, 'checkout'])->name('Cart.Checkout');

    Route::get('/checkout', [OrderController::class, 'create'])->name('Checkout.View');
    Route::post('/checkout/order', [OrderController::class, 'store'])->name('Checkout.Order');

    Route::post('/logout', [AuthController::class, 'logout'])->name('Auth.Logout');
});


// ADMIN DASHBOARD
Route::group(['prefix' => 'admin-dashboard', 'middleware' => 'isAdmin'], function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('Admin.Dashboard');

    Route::get('/products',  [ProductController::class, 'index'])->name('Admin.Products');
    Route::get('/add-product',  [ProductController::class, 'create'])->name('Admin.CreateProduct');
    Route::post('/add-product',  [ProductController::class, 'store'])->name('Admin.StoreProduct');
    Route::get('/edit-product/{product}',  [ProductController::class, 'edit'])->name('Admin.EditProduct');
    Route::put('/edit-product/{product}',  [ProductController::class, 'update'])->name('Admin.UpdateProduct');
    Route::get('/product/{product}',  [ProductController::class, 'show'])->name('Admin.ShowProduct');
    Route::delete('/product/{product}',  [ProductController::class, 'destroy'])->name('Admin.DeleteProduct');

    Route::get('/orders',  [OrderController::class, 'index'])->name('Admin.Orders');
    Route::get('/orders/{status}',  [OrderController::class, 'byStatus'])->name('Admin.OrdersByStatus');
    Route::post('/order/update/{order}/{status}',  [OrderController::class, 'changeOrderStatus'])->name('Admin.StatusOrder');
    Route::post('/orders/print', [OrderController::class, 'printReport'])->name('Admin.PrintReport');

    Route::get('/messages',  [AdminDashboardController::class, 'messageList'])->name('Admin.Messages');
    Route::get('/users',  [AdminDashboardController::class, 'userList'])->name('Admin.Users');
    Route::delete('/user/{user}',  [AdminDashboardController::class, 'deleteUser'])->name('Admin.DeleteUser');
});
