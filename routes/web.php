<?php

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

Route::get('/', function () {
    return view("welcome");
})->name('welcome');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Resource Routes
Route::resource('users', App\Http\Controllers\UserController::class);
Route::resource('costumers', App\Http\Controllers\CostumerController::class);
Route::resource('products', App\Http\Controllers\ProductController::class);
Route::resource('services', App\Http\Controllers\ServiceController::class);
Route::resource('packages', App\Http\Controllers\PackageController::class);
Route::resource('weights', App\Http\Controllers\WeightController::class);
Route::resource('measures', App\Http\Controllers\MeasureController::class);
Route::resource('meshes', App\Http\Controllers\MeshController::class);
Route::resource('roles', App\Http\Controllers\RoleController::class);
Route::resource('toasts', App\Http\Controllers\ToastController::class);
Route::resource('product-weights', App\Http\Controllers\ProductWeightController::class);
Route::resource('own-orders', App\Http\Controllers\OwnOrderController::class);
Route::resource('own-order-products', App\Http\Controllers\OwnOrderProductsController::class);
Route::resource('maquila-orders', App\Http\Controllers\MaquilaOrderController::class);
Route::resource('maquila-services', App\Http\Controllers\MaquilaServiceController::class);
Route::resource('maquila-packages', App\Http\Controllers\MaquilaPackageController::class);
Route::resource('maquila-meshes', App\Http\Controllers\MaquilaMeshController::class);



