<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CountryController as C;
use App\Http\Controllers\HotelController as H;
use App\Http\Controllers\FrontController as F;
use App\Http\Controllers\OrderController as O;
use App\Http\Controllers\CartController as Cart;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', function () {
    return view('welcome');
});

//Country

Route::prefix('countries')->name('countries-')->group(function () {
    Route::get('', [C::class, 'index'])->name('index');
    Route::get('create', [C::class, 'create'])->name('create');
    Route::post('', [C::class, 'store'])->name('store');
    Route::get('edit/{country}', [C::class, 'edit'])->name('edit');
    Route::put('{country}', [C::class, 'update'])->name('update');
    Route::delete('{country}', [C::class, 'destroy'])->name('delete');
    Route::get('show/{id}', [C::class, 'show'])->name('show');
    Route::get('show', [C::class, 'link'])->name('show-route'); // apsidarom linko dali kuri su JS bus galima modifikuoti.
});

//Hotels

Route::prefix('hotels')->name('hotels-')->group(function () {
    Route::get('', [H::class, 'index'])->name('index');
    Route::get('create', [H::class, 'create'])->name('create');
    Route::post('', [H::class, 'store'])->name('store');
    Route::get('edit/{hotel}', [H::class, 'edit'])->name('edit');
    Route::put('{hotel}', [H::class, 'update'])->name('update');
    Route::delete('{hotel}', [H::class, 'destroy'])->name('delete');
    Route::get('show/{id}', [H::class, 'show'])->name('show');
    Route::put('/delete-pic/{hotel}', [A::class, 'deletePic'])->name('delete-pic');
});

//front
Route::get('', [F::class, 'index'])->name('front-index');
Route::post('add-it-to-cart', [O::class, 'add'])->name('front-add');
Route::get('my-order', [O::class, 'showMyOrders'])->name('my-order');
Route::post('add-travel-to-the-cart', [Cart::class, 'add'])->name('front-add-cart');
Route::get('my-small-cart', [Cart::class, 'showSmallCart'])->name('my-small-cart');
Route::delete('my-small-cart', [Cart::class, 'deleteSmallCart'])->name('my-small-cart');
//linkas tas pats bet method kitoks. 

// Orders
Route::prefix('orders')->name('orders-')->group(
    function () {
        Route::get('', [O::class, 'index'])->name('index');
        Route::put('status/{order}', [O::class, 'setStatus'])->name('status');
    }
);
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
