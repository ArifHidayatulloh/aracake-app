<?php

use App\Http\Controllers\Admin\Delivery\DeliveryMethodController;
use App\Http\Controllers\Admin\Order\OrderStatusController;
use App\Http\Controllers\Admin\Payment\PaymentMethodController;
use App\Http\Controllers\Admin\Product\CategoryController;
use App\Http\Controllers\Admin\Product\ProductController;
use App\Http\Controllers\Admin\System\SystemSettingController;
use App\Http\Controllers\Admin\System\WorkingHourController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('admin.dashboard');


// ---- Admin ---- //
Route::prefix('admin')->group(function () {
    // ---- Kategori Produk ---- //
    Route::prefix('category')->group(function () {
        Route::get('/index', [CategoryController::class, 'index'])->name('admin.category.index');
        Route::get('/create', [CategoryController::class, 'create'])->name('admin.category.create');
        Route::post('/store', [CategoryController::class, 'store'])->name('admin.category.store');
        Route::get('/edit/{category:slug}', [CategoryController::class, 'edit'])->name('admin.category.edit');
        Route::put('/update/{category:slug}', [CategoryController::class, 'update'])->name('admin.category.update');
        Route::get('/set-active/{category:slug', [CategoryController::class, 'setActive'])->name('admin.category.set-active');
    });
    // ---- End Kategori Produk ---- //

    // ---- Metode Pengiriman ---- //
    Route::prefix('delivery-method')->group(function () {
        Route::get('/index', [DeliveryMethodController::class, 'index'])->name('admin.delivery-method.index');
        Route::get('/create', [DeliveryMethodController::class, 'create'])->name('admin.delivery-method.create');
        Route::post('/store', [DeliveryMethodController::class, 'store'])->name('admin.delivery-method.store');
        Route::get('/edit/{deliveryMethod:id}', [DeliveryMethodController::class, 'edit'])->name('admin.delivery-method.edit');
        Route::put('/update/{deliveryMethod:id}', [DeliveryMethodController::class, 'update'])->name('admin.delivery-method.update');
    });
    // ---- End Metode Pengiriman ---- //

    // ---- Metode Pembayaran ---- //
    Route::prefix('payment-method')->group(function () {
        Route::get('/index', [PaymentMethodController::class, 'index'])->name('admin.payment-method.index');
        Route::get('/create', [PaymentMethodController::class, 'create'])->name('admin.payment-method.create');
        Route::post('/store', [PaymentMethodController::class, 'store'])->name('admin.payment-method.store');
        Route::get('/edit/{paymentMethod:id}', [PaymentMethodController::class, 'edit'])->name('admin.payment-method.edit');
        Route::put('/update/{paymentMethod:id}', [PaymentMethodController::class, 'update'])->name('admin.payment-method.update');
    });
    // ---- End Metode Pembayaran ---- //

    // ---- Order Status ----//
    Route::prefix('order-status')->group(function () {
        Route::get('/index', [OrderStatusController::class, 'index'])->name('admin.order-status.index');
        Route::get('/create', [OrderStatusController::class, 'create'])->name('admin.order-status.create');
        Route::post('/store', [OrderStatusController::class, 'store'])->name('admin.order-status.store');
        Route::get('/edit/{orderStatus:id}', [OrderStatusController::class, 'edit'])->name('admin.order-status.edit');
        Route::put('/update/{orderStatus:id}', [OrderStatusController::class, 'update'])->name('admin.order-status.update');
    });
    // ---- End Order Status ----//

    // ---- Pengaturan Sistem ----//
    Route::prefix('system-setting')->group(function () {
        Route::get('/index', [SystemSettingController::class, 'index'])->name('admin.system-setting.index');
        Route::get('/create', [SystemSettingController::class, 'create'])->name('admin.system-setting.create');
        Route::post('/store', [SystemSettingController::class, 'store'])->name('admin.system-setting.store');
        Route::get('/edit/{systemSetting:id}', [SystemSettingController::class, 'edit'])->name('admin.system-setting.edit');
        Route::put('/update/{systemSetting:id}', [SystemSettingController::class, 'update'])->name('admin.system-setting.update');
    });
    // ---- End Pengaturan Sistem ----//

    // ---- Rute untuk Working Hours (hanya index, edit, update) ---- //
    Route::resource('working-hour', WorkingHourController::class)->only([
        'index',
        'edit',
        'update'
    ]);
    // ---- End Rute untuk Working Hours ---- //

    // ---- Rute untuk Product ---- //
    Route::prefix('product')->group(function () {
        Route::get('/index', [ProductController::class, 'index'])->name('admin.product.index');
        Route::get('/create', [ProductController::class, 'create'])->name('admin.product.create');
        Route::post('/store', [ProductController::class, 'store'])->name('admin.product.store');
        Route::get('{product:slug}', [ProductController::class, 'show'])->name('admin.product.show');
        Route::get('/edit/{product:slug}', [ProductController::class, 'edit'])->name('admin.product.edit');
        Route::put('/update/{product:slug}', [ProductController::class, 'update'])->name('admin.product.update');
    });
    // ---- End Rute untuk Product ---- //

});
// ---- End Admin ---- //
