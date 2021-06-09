<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
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

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('lang/{lang}', function ($lang) {
    session(['lang' => $lang]);
    App::setLocale($lang);

    return redirect()->back();
});

Route::middleware(['auth:sanctum', 'verified'])->get('/products', function() {
    $products = App\Models\Product::all();
    return view('products')->with('productos', $products);
});

Route::get('/products', function(){
    $productos = App\Product::where('precio','>','1')->paginate(10);
    return view('products')->with('productos',$productos);
});

Route::get('/products', [ProductController::class,'show'])->name('products');

Route::get('add-to-cart/{id}', [ProductController::class,'addToCart']);

Route::get('cart', [ProductController::class,'cart'])->name('cart');

Route::patch('update-cart',[ProductController::class,'update']);

Route::delete('remove-from-cart',[ProductController::class,'remove']);

Route::get('venta', 'ProductsController@venta')->middleware('venta');
