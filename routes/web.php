<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DeveloperMenuController;
use App\Http\Controllers\DeveloperUserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\StockInController;
use App\Models\Category;
use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
    return view('test');
});

/*
Public Route
*/

Route::get('/', function () {
    return view('welcome');
});

/*
Dashboard
*/

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

/*
Authenticated Route
*/

Route::middleware('auth')->group(function () {

    /*    
    AJAX    
    */

    Route::get('/sales/product/{id}', [SalesController::class, 'getProduct'])
        ->name('sales.product');

    Route::get('/stock_in/product/{id}', [StockInController::class, 'getProduct'])
        ->name('stock_in.product');

    /*    
    Master Data    
    */

    Route::resource('categories', CategoryController::class)
        ->except(['show']);

    Route::resource('products', ProductController::class)
        ->except(['show']);

    /*    
    Transaction    
    */

    Route::resource('sales', SalesController::class)
        ->except(['show', 'edit', 'update', 'destroy']);

    Route::resource('stock_in', StockInController::class)
        ->except(['show', 'edit', 'update', 'destroy']);

    /*    
    Report    
    */

    Route::prefix('report')
        ->name('report.')
        ->group(function () {

            Route::get('/product', [ReportController::class, 'product'])
                ->name('product');

            Route::get('/sales', [ReportController::class, 'sales'])
                ->name('sales');

            Route::get('/stock-in', [ReportController::class, 'stockIn'])
                ->name('stock_in');
        });

    /*    
    Export    
    */

    Route::prefix('report')
        ->name('report.')
        ->group(function () {

            /*        
        Sales Report        
        */

            Route::get('/sales', [ReportController::class, 'sales'])
                ->name('sales');

            Route::get('/sales/export/excel', [ReportController::class, 'exportSalesExcel'])
                ->name('sales.excel');

            Route::get('/sales/export/pdf', [ReportController::class, 'exportSalesPdf'])
                ->name('sales.pdf');

            /*        
        Stock In Report        
        */

            Route::get('/stock-in', [ReportController::class, 'stockIn'])
                ->name('stock_in');

            Route::get('/stock-in/export/excel', [ReportController::class, 'exportStockInExcel'])
                ->name('stock_in.excel');

            Route::get('/stock-in/export/pdf', [ReportController::class, 'exportStockInPdf'])
                ->name('stock_in.pdf');

            /*        
        Product Report        
        */

            Route::get('/product', [ReportController::class, 'product'])
                ->name('product');

            Route::get('/product/export/excel', [ReportController::class, 'exportProductExcel'])
                ->name('product.excel');

            Route::get('/product/export/pdf', [ReportController::class, 'exportProductPdf'])
                ->name('product.pdf');
        });



    /*    
    Developer    
    */

    Route::prefix('developer')
        ->name('developer.')
        ->middleware('role:developer')
        ->group(function () {

            Route::resource('users', DeveloperUserController::class)
                ->except(['show']);

            Route::patch(
                'menus/{menu}/toggle',
                [DeveloperMenuController::class, 'toggle']
            )->name('menus.toggle');

            Route::resource('menus', DeveloperMenuController::class)
                ->except(['show']);
        });

    /*    
    Profile    
    */

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::get('/profile/show', [ProfileController::class, 'show'])
        ->name('profile.show');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__ . '/auth.php';
