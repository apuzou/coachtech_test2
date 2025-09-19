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

// 商品一覧ページ
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// 商品登録ページ
Route::get('/products/register', [ProductController::class, 'create'])->name('products.create');

// 商品登録処理
Route::post('/products/register', [ProductController::class, 'store'])->name('products.store');

// 商品詳細ページ
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// 商品更新
Route::put('/products/{product}/update', [ProductController::class, 'update'])->name('products.update');

// 商品削除
Route::delete('/products/{product}/delete', [ProductController::class, 'destroy'])->name('products.destroy');

// 商品検索
Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
