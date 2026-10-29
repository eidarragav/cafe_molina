<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CostumerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\WeightController;
use App\Http\Controllers\MeasureController;
use App\Http\Controllers\MeshController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ToastController;
use App\Http\Controllers\ProductWeightController;
use App\Http\Controllers\OwnOrderController;
use App\Http\Controllers\OwnOrderProductsController;
use App\Http\Controllers\MaquilaOrderController;
use App\Http\Controllers\MaquilaServiceController;
use App\Http\Controllers\MaquilaPackageController;
use App\Http\Controllers\MaquilaMeshController;
use App\Http\Controllers\OrderBoardController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes - Cafe Molina
|--------------------------------------------------------------------------
*/

// Public landing page
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Authentication Routes
Auth::routes();

// Protected Routes (Requires Authentication)
Route::middleware('auth')->group(function () {
    // Redirection after login
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Dashboard & KPIs
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    // Orders Management Board (Kanban / Production Stages)
    Route::get('/orders-board', [OrderBoardController::class, 'index'])->name('manage.orders.index');

    // Own Orders (Cafe Molina brand)
    Route::resource('own-orders', OwnOrderController::class);

    // Maquila Orders (Toll processing)
    Route::resource('maquila-orders', MaquilaOrderController::class);
    Route::get('/maquila-order/{id}', [MaquilaOrderController::class, 'show'])->name('maquila.orders.show');

    // State Updates (AJAX from board)
    Route::patch('/own-orders/{id}/update-selected-state', [OwnOrderController::class, 'updateSelectedState'])
        ->name('own-orders.updateSelectedState');
    Route::patch('/maquila-orders/{id}/update-selected-state', [MaquilaOrderController::class, 'updateSelectedState'])
        ->name('maquila-orders.updateSelectedState');

    // Official Printable PDF Reports
    Route::get('/maquila_pdf/{id}', [MaquilaOrderController::class, 'maquila_pdf'])->name('maquila.pdf');
    Route::get('/own_pdf/{id}', [OwnOrderController::class, 'ownorder_pdf'])->name('own.pdf');

    // Roasting Control & Loss Tracking
    Route::get('/tostiones', [ToastController::class, 'index'])->name('tostiones.index');
    Route::resource('toasts', ToastController::class);

    // Customers / Coffee Growers
    Route::resource('costumers', CostumerController::class);

    // Users / Team / Operators
    Route::resource('users', UserController::class);

    // Catalog & Intermediate Resources
    Route::resource('products', ProductController::class);
    Route::resource('services', ServiceController::class);
    Route::resource('packages', PackageController::class);
    Route::resource('weights', WeightController::class);
    Route::resource('measures', MeasureController::class);
    Route::resource('meshes', MeshController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('product-weights', ProductWeightController::class);
    Route::resource('own-order-products', OwnOrderProductsController::class);
    Route::resource('maquila-services', MaquilaServiceController::class);
    Route::resource('maquila-packages', MaquilaPackageController::class);
    Route::resource('maquila-meshes', MaquilaMeshController::class);
});
