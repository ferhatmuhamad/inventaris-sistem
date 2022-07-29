<?php

use App\Http\Controllers\API\ProductController as APIProductController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AllUserController;
use App\Http\Controllers\GraphController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\MonthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StockOpController;
use App\Http\Controllers\StockInController;
use App\Http\Controllers\StockReportController;
use App\Http\Controllers\StockOutController;
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

Route::group(['middleware' => ['auth']], function (){

// Route::middleware(['role:admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/read', [DashboardController::class, 'read'])->name('dashboard.read');
    Route::get('/user', [DashboardController::class, 'user'])->name('dashboard.user');
    Route::delete('/destroy/{id}', [DashboardController::class, 'destroy'])->name('dashboard.destroy');
    Route::get('grafik', [GraphController::class, 'index'])->name('graph');
    Route::get('logout', [LoginController::class, 'logout']);

    // PROFILE
    Route::get('profile/{id}', [ProfileController::class, 'index'])->name('profile');
    Route::get('profile/edit/{id}', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile/update/{id}', [ProfileController::class, 'update'])->name('profile.update');

    // USER
    Route::get('alluser', [AllUserController::class, 'index'])->name('alluser');
    Route::get('alluser/data', [AllUserController::class, 'read'])->name('alluser.read');
    Route::delete('alluser/destroy/{id}', [AllUserController::class, 'destroy'])->name('alluser.destroy');

    // PERIODE
    Route::get('periode', [PeriodeController::class, 'index'])->name('periode');
    Route::get('periode/data', [PeriodeController::class, 'read'])->name('periode.data');
    Route::get('periode/edit/{id}', [PeriodeController::class, 'edit'])->name('periode.edit');
    Route::put('periode/update/{id}', [PeriodeController::class, 'update'])->name('periode.update');
    Route::delete('periode/destroy/{id}', [PeriodeController::class, 'destroy'])->name('periode.destroy');
    Route::get('periode/create', [PeriodeController::class, 'create'])->name('periode.create');
    Route::post('periode/store', [PeriodeController::class, 'store'])->name('periode.store');

    Route::get('month', [MonthController::class, 'index'])->name('month');
    Route::get('month/data', [MonthController::class, 'read'])->name('month.data');
    Route::get('month/edit/{id}', [MonthController::class, 'edit'])->name('month.edit');
    Route::put('month/update/{id}', [MonthController::class, 'update'])->name('month.update');
    Route::delete('month/destroy/{id}', [MonthController::class, 'destroy'])->name('month.destroy');
    Route::get('month/create', [MonthController::class, 'create'])->name('month.create');
    Route::post('month/store', [MonthController::class, 'store'])->name('month.store');

    // Route::resource('products', 'App/Http/Controllers/ProductController');
    Route::get('products', [ProductController::class, 'index'])->name('products');
    Route::get('products/data', [ProductController::class, 'read'])->name('products.data');
    Route::get('products/show/{id}', [ProductController::class, 'show'])->name('products.show');
    Route::get('products/edit/{id}', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('products/update/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('products/destroy/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::get('products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('products/store', [ProductController::class, 'store'])->name('products.store');
    Route::get('products/download/{id}', [ProductController::class, 'download'])->name('products.download');
    Route::get('products/searching', [ProductController::class, 'searching'])->name('products.searching');

    Route::get('productcategory', [ProductCategoryController::class, 'index'])->name('productcategory');
    Route::get('productcategory/data', [ProductCategoryController::class, 'read'])->name('productcategory.data');
    Route::get('productcategory/edit/{id}', [ProductCategoryController::class, 'edit'])->name('productcategory.edit');
    Route::put('productcategory/update/{id}', [ProductCategoryController::class, 'update'])->name('productcategory.update');
    Route::delete('productcategory/destroy/{id}', [ProductCategoryController::class, 'destroy'])->name('productcategory.destroy');
    Route::get('productcategory/create', [ProductCategoryController::class, 'create'])->name('productcategory.create');
    Route::post('productcategory/store', [ProductCategoryController::class, 'store'])->name('productcategory.store');

    Route::get('customers', [CustomerController::class, 'index'])->name('customers');
    Route::get('customers/data', [CustomerController::class, 'read'])->name('customers.data');
    Route::get('customers/edit/{id}', [CustomerController::class, 'edit'])->name('customers.edit');
    Route::put('customers/update/{id}', [CustomerController::class, 'update'])->name('customers.update');
    Route::delete('customers/destroy/{id}', [CustomerController::class, 'destroy'])->name('customers.destroy');
    Route::get('customers/create', [CustomerController::class, 'create'])->name('customers.create');
    Route::post('customers/store', [CustomerController::class, 'store'])->name('customers.store');

    Route::get('suppliers', [SupplierController::class, 'index'])->name('suppliers');
    Route::get('suppliers/data', [SupplierController::class, 'read'])->name('suppliers.data');
    Route::get('suppliers/edit/{id}', [SupplierController::class, 'edit'])->name('suppliers.edit');
    Route::put('suppliers/update/{id}', [SupplierController::class, 'update'])->name('suppliers.update');
    Route::delete('suppliers/destroy/{id}', [SupplierController::class, 'destroy'])->name('suppliers.destroy');
    Route::get('suppliers/create', [SupplierController::class, 'create'])->name('suppliers.create');
    Route::post('suppliers/store', [SupplierController::class, 'store'])->name('suppliers.store');

    Route::get('warehouses', [WarehouseController::class, 'index'])->name('warehouses');
    Route::get('warehouses/data', [WarehouseController::class, 'read'])->name('warehouses.data');
    Route::get('warehouses/edit/{id}', [WarehouseController::class, 'edit'])->name('warehouses.edit');
    Route::put('warehouses/update/{id}', [WarehouseController::class, 'update'])->name('warehouses.update');
    Route::delete('warehouses/destroy/{id}', [WarehouseController::class, 'destroy'])->name('warehouses.destroy');
    Route::get('warehouses/create', [WarehouseController::class, 'create'])->name('warehouses.create');
    Route::post('warehouses/store', [WarehouseController::class, 'store'])->name('warehouses.store');

    Route::get('stockopname', [StockOpController::class, 'index'])->name('stockopname');
    Route::get('stockopname/read', [StockOpController::class, 'read'])->name('stockopname.read');
    Route::get('stockopname/data/{id}', [StockOpController::class, 'data'])->name('stockopname.data');
    Route::get('stockopname/edit/{id}', [StockOpController::class, 'edit'])->name('stockopname.edit');
    Route::put('stockopname/update/{id}', [StockOpController::class, 'update'])->name('stockopname.update');
    Route::delete('stockopname/destroy/{id}', [StockOpController::class, 'destroy'])->name('stockopname.destroy');
    Route::get('stockopname/create', [StockOpController::class, 'create'])->name('stockopname.create');
    Route::post('stockopname/store', [StockOpController::class, 'store'])->name('stockopname.store');

    Route::get('stockin', [StockInController::class, 'index'])->name('stockin');
    Route::get('stockin/read', [StockInController::class, 'read'])->name('stockin.read');
    Route::get('stockin/data/{id}', [StockInController::class, 'data'])->name('stockin.data');
    Route::get('stockin/edit/{id}', [StockInController::class, 'edit'])->name('stockin.edit');
    Route::put('stockin/update/{id}', [StockInController::class, 'update'])->name('stockin.update');
    Route::delete('stockin/destroy/{id}', [StockInController::class, 'destroy'])->name('stockin.destroy');
    Route::get('stockin/create', [StockInController::class, 'create'])->name('stockin.create');
    Route::post('stockin/store', [StockInController::class, 'store'])->name('stockin.store');

    Route::get('stockout', [StockOutController::class, 'index'])->name('stockout');
    Route::get('stockout/read', [StockOutController::class, 'read'])->name('stockout.read');
    Route::get('stockout/show/{id}', [StockOutController::class, 'show'])->name('stockout.show');
    Route::get('stockout/edit/{id}', [StockOutController::class, 'edit'])->name('stockout.edit');
    Route::put('stockout/update/{id}', [StockOutController::class, 'update'])->name('stockout.update');
    Route::delete('stockout/destroy/{id}', [StockOutController::class, 'destroy'])->name('stockout.destroy');
    Route::get('stockout/create', [StockOutController::class, 'create'])->name('stockout.create');
    Route::post('stockout/store', [StockOutController::class, 'store'])->name('stockout.store');
    Route::get('stockout/{id}/set-status', [StockOutController::class, 'setstatus'])->name('stockout.setstatus');

    Route::get('stockreport', [StockReportController::class, 'index'])->name('stockreport');
    Route::get('stockreport/data', [StockReportController::class, 'read'])->name('stockreport.data');
    Route::get('stockreport/show/{id}', [StockReportController::class, 'show'])->name('stockreport.show');
});

Auth::routes(['register' => true]);


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
