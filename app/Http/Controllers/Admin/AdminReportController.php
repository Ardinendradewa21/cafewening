<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminReportController extends Controller
{
    /**
     * Ini adalah fungsi index() yang akan menampilkan halaman laporan.
     */
    public function index(Request $request)
    {
        // 1. Laporan Penjualan per Produk
        $laporanProduk = TransactionDetail::select(
            'product_name',
            DB::raw('SUM(quantity) as total_quantity'),
            DB::raw('SUM(price * quantity) as total_revenue')
        )
            ->groupBy('product_name')
            ->orderBy('total_revenue', 'desc')
            ->get();

        // 2. Laporan Penjualan per Kategori
        $laporanKategori = Product::join('transaction_details', 'products.id', '=', 'transaction_details.product_id')
            ->select(
                'products.category',
                DB::raw('SUM(transaction_details.price * transaction_details.quantity) as total_revenue')
            )
            ->groupBy('products.category')
            ->orderBy('total_revenue', 'desc')
            ->get();


        return view('admin.laporan', [
            'laporanProduk' => $laporanProduk,
            'laporanKategori' => $laporanKategori
        ]);
    }
}
