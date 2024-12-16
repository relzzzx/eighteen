<?php

use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\BoothController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SellerController;
use Illuminate\Support\Facades\Route;

// Halaman Awal
Route::get('/', function () {
    return view('welcome');
});

// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile Management
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});

// Orders Management (User)
Route::middleware('auth')->group(function () {
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index'); // Lihat semua pesanan pengguna
    Route::post('orders/{booth_id}', [OrderController::class, 'store'])->name('orders.store'); // Buat pesanan langsung
    Route::get('/orders/{order}/status', [OrderController::class, 'showStatus'])->name('orders.status'); // Lihat status pesanan
    Route::post('/orders/{order}/payment', [OrderController::class, 'uploadPaymentProof'])->name('orders.payment'); // Upload bukti pembayaran QRIS
    Route::post('/orders', [OrderController::class, 'bulkCreate'])->name('orders.bulk');
    Route::post('/orders/bulk-create/{booth_id}', [OrderController::class, 'bulkCreate'])->name('orders.bulkCreate');
    Route::get('/orders/status/{order}', [OrderController::class, 'status'])->name('orders.status');
    Route::post('/create-order/{booth_id}', [OrderController::class, 'create'])->name('order.create');
});

// Payments Validation (Penjual)
Route::middleware('auth')->group(function () {
    Route::get('/payments/{payment}', [PaymentController::class, 'show'])->name('payments.show'); // Lihat detail pembayaran
    Route::post('/payments/{order}/upload', [PaymentController::class, 'upload'])->name('payments.upload'); // Upload pembayaran
    Route::get('/payments/{order}/show', [PaymentController::class, 'show'])->name('payments.show');
    Route::get('/orders/my-search', [OrderController::class, 'myOrdersSearch'])->name('orders.my-search');
    Route::get('/my-orders', [OrderController::class, 'userOrders'])->name('orders.user');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders', [OrderController::class, 'userOrders'])->name('orders.index');
    Route::get('/menus', [MenuController::class, 'index'])->name('menus.index');

//Admin
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
    Route::post('/orders/{id}/approve', [AdminOrderController::class, 'approve'])->name('admin.orders.approve');
    Route::post('/orders/{id}/decline', [AdminOrderController::class, 'decline'])->name('admin.orders.decline');
    Route::post('/admin/orders/{order}/complete', [OrderController::class, 'complete'])->name('admin.orders.complete');
    Route::post('/admin/orders/complete/{order_id}', [AdminOrderController::class, 'completeOrder'])->name('admin.orders.complete');
    Route::patch('/payments/{payment}/approve', [PaymentController::class, 'approvePayment'])->name('payments.approve');
    Route::patch('/payments/{payment}/decline', [PaymentController::class, 'declinePayment'])->name('payments.decline');
    Route::get('/payments/validate', [PaymentController::class, 'validatePayments'])->name('payments.validate'); // Halaman validasi pembayaran
    Route::get('/orders/manage', [OrderController::class, 'manageOrders'])->name('orders.manage');
    Route::patch('/payments/{payment}/approve', [OrderController::class, 'approvePayment'])->name('payments.approve');
    Route::patch('/payments/{payment}/decline', [OrderController::class, 'declinePayment'])->name('payments.decline');
    Route::patch('/orders/{order}/complete', [OrderController::class, 'completeOrder'])->name('orders.complete');
    Route::get('/revenue', [AdminOrderController::class, 'showRevenues'])->name('admin.revenue');

});

Route::middleware(['auth', 'role:penjual'])->group(function () {
    Route::get('/seller/orders', [SellerController::class, 'orders'])->name('seller.orders');
});

});



require __DIR__ . '/auth.php';