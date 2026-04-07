<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\Exports\ExportsController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\GeneratePDFController;

Route::get('/hello-world', function () {
    return 'Hello World';
});

// path for development
//Route::get('/generate', [GeneratePDFController::class, 'generatePDF']);

Route::get('/', function () {
    return redirect()->route('login');
});

Route::prefix('process')->group(function () {
    Route::post('/register', [AuthController::class, 'register'])->name('process-register');
    Route::post('/login', [AuthController::class, 'login'])->name('process-login');
    Route::get('/logout', [AuthController::class, 'logout'])->name('process-logout');
});

Route::get('/login', function () {
    return view('Auth.login');
})->name('login');

Route::prefix('/app')->middleware('auth:sanctum')->group(function () {
    Route::get('/dashboard', function () {
        return view('Dashboard.DashboardPage');
    })->middleware('check_permission:view_dashboard_admin')->name('dashboard');
    Route::get('/users', [UserController::class, 'index'])->middleware('check_permission:view_users')->name('users.index');
    Route::get('configuration', [ConfigurationController::class, 'index'])->middleware('check_permission:show_section_configuration')->name('configuration.index');
    Route::get('/permissions', [PermissionController::class, 'index'])->middleware('check_permission:view_permissions')->name('permissions.index');
    Route::get('/user/{user}/role', [UserController::class, 'changeRole'])->middleware('check_permission:change_role_to_users')->name('users.changeRole');
    Route::get('/user/{user}/status', [UserController::class, 'changeStatus'])->middleware('check_permission:change_status_to_users')->name('users.changeStatus');
    Route::get('/new_user', [UserController::class, 'store'])->middleware('check_permission:create_new_user')->name('users.store');
    Route::get('/sales', [SaleController::class, 'index'])->middleware('check_permission:view_sales')->name('sales.index');
    Route::get('/sales/register', [SaleController::class, 'create'])->middleware('check_permission:register_sales')->name('sales.register');
    Route::get('/sales/store', [SaleController::class, 'store'])->middleware('check_permission:store_sales')->name('sales.store');
    Route::get('/reports', function () {
        return view('reports.index');
    })->middleware('check_permission:view_reports')->name('reports.index');
    Route::get('/information', function () {
        return view('information.index');
    })->name('information.index');
    Route::get('/purchases', [PurchaseController::class, 'index'])->middleware('check_permission:view_purchases')->name('purchases.index');
    Route::get('/purchases/register', [PurchaseController::class, 'create'])->middleware('check_permission:register_purchases')->name('purchases.register');
    Route::get('/purchases/store', [PurchaseController::class, 'store'])->middleware('check_permission:store_purchases')->name('purchases.store');
    Route::get('/products', [ProductsController::class, 'index'])->middleware('check_permission:view_products')->name('products.index');
    Route::get('/new_product', [ProductsController::class, 'store'])->middleware('check_permission:create_new_product')->name('products.store');
    Route::get('/product/{product}/edit', [ProductsController::class, 'update'])->middleware('check_permission:update_product')->name('products.update');
    Route::get('/product/{product}/delete', [ProductsController::class, 'destroy'])->middleware('check_permission:delete_product')->name('products.delete');
    Route::get('/backups', [BackupController::class, 'index'])->middleware('check_permission:view_backups')->name('backups.index');
    Route::get('/new_backup', [BackupController::class, 'store'])->middleware('check_permission:create_backups')->name('backups.store');
    Route::get('/backup/{backup}/restore', [BackupController::class, 'restore'])->middleware('check_permission:restore_backups')->name('backups.restore');
    Route::get('/new_role', [RoleController::class, 'store'])->middleware('check_permission:create_new_role')->name('roles.store');
    Route::get('/role/{role}/edit', [RoleController::class, 'update'])->middleware('check_permission:update_role')->name('roles.update');
    Route::get('/inventory', [InventoryController::class, 'index'])->middleware('check_permission:view_inventory')->name('inventory.index');
    Route::get('/new_inventory', [InventoryController::class, 'store'])->middleware('check_permission:create_new_inventory')->name('inventory.store');
    Route::prefix('/exports')->middleware('check_permission:export_data')->group(function () {
        Route::get('/users', [ExportsController::class, 'exportUsers'])->name('export.users');
        Route::get('/products', [ExportsController::class, 'exportProducts'])->name('export.products');
        Route::get('/inventories', [ExportsController::class, 'exportInventory'])->name('export.inventory');
        Route::get('/purchases', [ExportsController::class, 'exportPurchases'])->name('export.purchases');
        Route::get('/sales', [ExportsController::class, 'exportSales'])->name('export.sales');
        Route::get('/purchase/{id}', [ExportsController::class, 'exportPurchaseById'])->name('export.purchase');
    });
    Route::prefix('/pdf')->middleware('check_permission:store_sales')->group(function () {
        Route::get('/show', [GeneratePDFController::class, 'show'])->name('pdf.show');
    });
});
