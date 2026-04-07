<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MeasurementController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SaleController;

Route::get('/unitsOfMeasurement/{type}', [MeasurementController::class, 'getUnits'])->name('units');
Route::get('/product', [ProductsController::class, 'getProductByIdOrCode']);
Route::get('/inventory/statistics', [InventoryController::class, 'statistics']);
Route::get('/purchase/statistics', [PurchaseController::class, 'statistics']);
Route::get('/sale/statistics', [SaleController::class, 'statistics']);
Route::get('/product/statistics', [ProductsController::class, 'statistics']);
Route::get('product/price', [ProductsController::class, 'getPrice']);
