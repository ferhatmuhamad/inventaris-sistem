<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductCategoryController;
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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['role:admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('logout', [LoginController::class, 'logout']);

    Route::get('products', [ProductController::class, 'index'])->name('products');
    Route::get('products/show/{id}', [ProductController::class, 'show'])->name('products.show');
    Route::get('products/edit/{id}', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('products/update/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('products/destroy/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::get('products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('products/store', [ProductController::class, 'store'])->name('products.store');
    Route::get('products/download/{id}', [ProductController::class, 'download'])->name('products.download');
    Route::get('products/searching', [ProductController::class, 'searching'])->name('products.searching');

    Route::get('productcategory', [ProductCategoryController::class, 'index'])->name('productcategory');
    Route::get('productcategory/edit/{id}', [ProductCategoryController::class, 'edit'])->name('productcategory.edit');
    Route::put('productcategory/update/{id}', [ProductCategoryController::class, 'update'])->name('productcategory.update');
    Route::delete('productcategory/destroy/{id}', [ProductCategoryController::class, 'destroy'])->name('productcategory.destroy');
    Route::get('productcategory/create', [ProductCategoryController::class, 'create'])->name('productcategory.create');
    Route::post('productcategory/store', [ProductCategoryController::class, 'store'])->name('productcategory.store');
});

Auth::routes(['register' => false]);


// =========== TIDAK TERPAKAI ===========


// Route::group(['role' => 'admin'], function () {
//     Route::middleware('role:admin')->get('/', [DashboardController::class, 'index'])->name('dashboard');
//     Route::middleware('role:admin')->get('logout', [LoginController::class, 'logout']);
// });

// Route::middleware('role:admin')->get('/', [DashboardController::class, 'index'])->name('dashboard');
// Route::middleware('role:admin')->get('logout', [LoginController::class, 'logout']);

// Route::middleware(['role' => 'admin'], function () {
//     Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
//     Route::get('logout', [LoginController::class, 'logout']);
// });

// Route::middleware('role:admin')->get('/dashboard', function(){
//     return 'Dashboard';
// })->name('dashboard');
// Route::middleware('role:admin')->get('/tes', function(){
//     return view('tes');
// });
