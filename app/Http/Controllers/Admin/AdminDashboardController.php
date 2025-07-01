<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // <-- Pastikan ini ada

class AdminDashboardController extends Controller
{
    /**
     * Ini adalah fungsi yang dicari oleh Laravel.
     * Pastikan seluruh blok kode ini ada di dalam controller Anda.
     */
    public function index()
    {
        // Mengambil data ringkasan untuk ditampilkan di kartu
        $pendapatanHariIni = Transaction::whereDate('created_at', Carbon::today())->sum('total_amount');
        $transaksiHariIni = Transaction::whereDate('created_at', Carbon::today())->count();
        $totalProduk = Product::count();
        $totalPengguna = User::count();

        // Mengirim semua data ke view
        return view('admin.dashboard', [
            'pendapatanHariIni' => $pendapatanHariIni,
            'transaksiHariIni' => $transaksiHariIni,
            'totalProduk' => $totalProduk,
            'totalPengguna' => $totalPengguna,
        ]);
    }
}
