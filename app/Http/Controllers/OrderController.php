<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Ini adalah fungsi index() yang dicari oleh route Anda.
     */
    public function index(Request $request)
    {
        // Ambil query dasar dengan relasi ke user (kasir) dan detail produk
        $query = Transaction::with(['user', 'details'])->latest();

        // Logika untuk filter pencarian
        if ($request->filled('search')) {
            $query->where('transaction_code', 'like', '%' . $request->search . '%');
        }

        // Logika untuk filter kasir
        if ($request->filled('kasir_id')) {
            $query->where('user_id', $request->kasir_id);
        }

        // Tampilkan 15 data per halaman
        $transactions = $query->paginate(15);

        // Ambil semua user dengan peran 'kasir' untuk dropdown filter
        $cashiers = User::where('role', 'kasir')->get();

        // Kirim data ke view
        return view('admin.pesanan', [
            'transactions' => $transactions,
            'cashiers' => $cashiers,
        ]);
    }
}
