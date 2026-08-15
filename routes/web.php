
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PasswordResetController;
use App\Http\Controllers\Admin\StockController;


/*
|--------------------------------------------------------------------------
| PUBLIK ROUTE (Semua Orang Bisa Akses)
|--------------------------------------------------------------------------
*/
// Halaman Utama & Detail Produk
Route::get('/', [FrontController::class, 'index'])->name('home');
Route::get('/product/{slug}', [FrontController::class, 'show'])->name('product.show');

// Keranjang Belanja (AJAX) - Guest boleh isi keranjang
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/cart/data', [CartController::class, 'getCart'])->name('cart.data');

// Webhook Midtrans (Dipanggil otomatis oleh server Midtrans)
Route::post('/api/midtrans-callback', [CheckoutController::class, 'callback']);

Route::post('/forgot-password', [\App\Http\Controllers\AuthController::class, 'submitResetRequest'])->name('password.request.submit');
Route::get('/verify-otp', [\App\Http\Controllers\AuthController::class, 'showOtpForm'])->name('password.otp.form');
Route::post('/verify-otp', [\App\Http\Controllers\AuthController::class, 'verifyOtp'])->name('password.otp.verify');
Route::get('/reset-password', [\App\Http\Controllers\AuthController::class, 'showResetPasswordForm'])->name('password.reset.form');
Route::post('/reset-password', [\App\Http\Controllers\AuthController::class, 'updatePassword'])->name('password.reset.update');

/*
|--------------------------------------------------------------------------
| GUEST ROUTE (Hanya untuk yang belum login)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
    Route::post('/forgot-password-request', [AuthController::class, 'submitResetRequest'])->name('password.request.submit');
});

/*
|--------------------------------------------------------------------------
| AUTH ROUTE (Hanya untuk yang SUDAH login)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Fitur Member: Checkout & Riwayat
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/payment/{invoice_number}', [CheckoutController::class, 'payment'])->name('checkout.payment');
    Route::post('/checkout/success-local/{invoice_number}', [CheckoutController::class, 'successLocal'])->name('checkout.success_local');
    Route::get('/my-orders', [FrontController::class, 'myOrders'])->name('my-orders');
    Route::get('/order/{invoice_number}', [FrontController::class, 'trackOrder'])->name('order.track');

    /*
    |--------------------------------------------------------------------------
    | ADMIN ROUTE (Tambahkan Middleware Admin nanti jika perlu)
    |--------------------------------------------------------------------------
    */
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('products', ProductController::class)->except(['edit', 'update']);
        Route::get('stock', [StockController::class, 'index'])->name('stock.index');
        Route::post('stock/add', [StockController::class, 'add'])->name('stock.add');

        Route::get('orders/create', [OrderController::class, 'create'])->name('orders.create');
        Route::post('orders/manual', [OrderController::class, 'storeManual'])->name('orders.storeManual');
        Route::get('orders/{order}/invoice', [OrderController::class, 'invoice'])->name('orders.invoice');
        Route::resource('orders', OrderController::class)->only(['index', 'show', 'update']);
        // TAMBAHKAN INI: Manajemen Pengguna
        Route::resource('users', UserController::class)->only(['index', 'destroy']);
        Route::put('users/{user}/role', [UserController::class, 'updateRole'])->name('users.updateRole');

        // TAMBAHKAN INI: Laporan Penjualan
        Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('reports/export/excel', [ReportController::class, 'exportExcel'])->name('reports.excel');
        Route::get('reports/export/print', [ReportController::class, 'printPdf'])->name('reports.print');

        // TAMBAHKAN INI: Manajemen Testimoni
        Route::resource('testimonials', \App\Http\Controllers\Admin\TestimonialController::class)->except(['show', 'edit', 'update']);
        // Manajemen Reset Sandi
        Route::resource('password-resets', \App\Http\Controllers\Admin\PasswordResetController::class)->only(['index', 'update', 'destroy']);
    });


    Route::prefix('owner')->middleware(['auth'])->group(function () {
    
    // 1. Dashboard Owner
    Route::get('/dashboard', [\App\Http\Controllers\Owner\DashboardController::class, 'index'])->name('owner.dashboard');
    
    // // 2. Laporan Penjualan Owner
    Route::get('/reports', [\App\Http\Controllers\Owner\ReportController::class, 'index'])->name('owner.reports.index');
    Route::get('/reports/export-excel', [\App\Http\Controllers\Owner\ReportController::class, 'exportExcel'])->name('owner.reports.excel');
    Route::get('/reports/print-pdf', [\App\Http\Controllers\Owner\ReportController::class, 'printPdf'])->name('owner.reports.print');

});
});