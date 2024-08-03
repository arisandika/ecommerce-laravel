<?php

use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\CheckoutController;
use App\Http\Controllers\Front\FrontController;
use App\Livewire\Admin\Dashboard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Auth::routes();

Route::get('/', [FrontController::class, 'index']);
Route::get('/shop', [FrontController::class, 'allProducts']);
Route::get('/shop/categories', [FrontController::class, 'categories']);
Route::get('/shop/{category_slug}', [FrontController::class, 'products']);
Route::get('/shop/{category_slug}/{product_slug}', [FrontController::class, 'singleProduct']);

Route::get('/cart', [CartController::class, 'index']);

Route::middleware(['auth'])->group(function (){

    Route::get('/checkout', [CheckoutController::class, 'index']);
    Route::get('/checkout/payment/{id}', [FrontController::class, 'checkoutPaynow'])->name('checkout.paynow');
    Route::get('/checkout/success/{id}', [FrontController::class, 'checkoutSuccess'])->name('checkout.success');
    
    Route::get('/account', [FrontController::class, 'accountPage'])->name('account.dashboard');

    Route::get('/account/orders', [FrontController::class, 'showOrders'])->name('account.orders');
    Route::get('/account/orders/{orderId}', [FrontController::class, 'showOrdersDetails']);

});

Route::prefix('admin')->middleware(['auth', 'isAdmin'])->group(function () {

    Route::get('/dashboard', App\Livewire\Admin\Dashboard::class)->name('admin.dashboard');
    Route::get('/categories', App\Livewire\Admin\Category\Index::class)->name('admin.categories.index');
    Route::get('/products', App\Livewire\Admin\Product\Index::class)->name('admin.products.index');
    Route::get('/products/add', App\Livewire\Admin\Product\AddProduct::class)->name('admin.products.add');
    Route::get('/products/edit/{id}', App\Livewire\Admin\Product\EditProduct::class)->name('admin.products.edit');
    Route::get('/sliders', App\Livewire\Admin\Slider\Index::class)->name('admin.sliders.index');
    Route::get('/sizes', App\Livewire\Admin\Sizes\Index::class)->name('admin.size.index');
    
    Route::get('/orders', App\Livewire\Admin\Order\Index::class)->name('admin.orders.index');
    Route::get('/orders/{orderId}', [App\Livewire\Admin\Order\Index::class, 'showDetail']);
    
});

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
