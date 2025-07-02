<?php

use App\Models\Product;

// Impor semua controller yang kita butuhkan
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DapurController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\AdminReportController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| File Route Utama
|--------------------------------------------------------------------------
| Dikelompokkan berdasarkan peran: Tamu, Kasir, Dapur, dan Admin.
*/

// --- BAGIAN 1: RUTE UNTUK TAMU (YANG BELUM LOGIN) ---
Route::get('/', [AuthenticatedSessionController::class, 'create'])
    ->middleware('guest')
    ->name('login');

require __DIR__ . '/auth.php'; // Route untuk login, logout, dll dari Breeze

// --- BAGIAN 2: RUTE UNTUK KASIR ---
Route::prefix('kasir')->name('kasir.')->middleware(['auth', 'role:kasir'])->group(function () {
    Route::get('/', function () {
        $products = Product::orderBy('name', 'asc')->get();
        return view('tampilanKasir', ['products' => $products]);
    })->name('dashboard');

    // Route untuk checkout (POST method)
    Route::post('/checkout', [TransactionController::class, 'store'])->name('checkout.store');

    // Route untuk keuangan dengan prefix yang benar
    Route::get('/keuangan', [KeuanganController::class, 'index'])->name('keuangan.index');
});

// --- BAGIAN 2B: RUTE TAMBAHAN UNTUK KEUANGAN (GLOBAL ACCESS) ---
Route::middleware(['auth'])->group(function () {
    Route::get('/keuangan', [KeuanganController::class, 'index'])->name('keuangan.index');
});

// --- BAGIAN 3: RUTE UNTUK DAPUR ---
Route::middleware(['auth', 'role:dapur'])->group(function () {
    Route::get('/dapur', [DapurController::class, 'index'])->name('dapur.index');
    Route::get('/api/dapur/orders', [DapurController::class, 'getActiveOrders']);
    Route::post('/api/dapur/orders/{transaction}/update-status', [DapurController::class, 'updateStatus']);
});

// --- BAGIAN 4: RUTE UNTUK ADMIN ---
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Inventory
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
    Route::post('/inventory/update/{product}', [InventoryController::class, 'update'])->name('inventory.update');

    // Pesanan
    Route::get('/pesanan', [OrderController::class, 'index'])->name('pesanan.index');

    // Laporan
    Route::get('/laporan', [AdminReportController::class, 'index'])->name('laporan.index');

    // CRUD Produk - Menggunakan Resource Route
    Route::resource('produk', ProductController::class)->parameters([
        'produk' => 'product'
    ]);

    // CRUD Users
    Route::resource('users', UserController::class);

    // Route tambahan untuk debugging (opsional, bisa dihapus setelah testing)
    Route::get('/test-routes', function () {
        return [
            'produk.index' => route('admin.produk.index'),
            'produk.create' => route('admin.produk.create'),
            'produk.show' => route('admin.produk.show', 1),
            'produk.edit' => route('admin.produk.edit', 1),
        ];
    })->name('test.routes');
});
