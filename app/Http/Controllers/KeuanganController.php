<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KeuanganController extends Controller
{
    public function index(Request $request)
    {
        // Ambil input filter dari request
        $input = $request->only(['tanggal', 'bulan', 'rentang_awal', 'rentang_akhir']);

        // Query dasar untuk transaksi
        $query = Transaction::with('details');

        // Terapkan filter berdasarkan input
        if (!empty($input['tanggal'])) {
            // Filter per tanggal
            $query->byDate($input['tanggal']);
        } elseif (!empty($input['bulan'])) {
            // Filter per bulan
            $date = Carbon::parse($input['bulan']);
            $query->byMonth($date->year, $date->month);
        } elseif (!empty($input['rentang_awal']) && !empty($input['rentang_akhir'])) {
            // Filter rentang tanggal
            $query->byDateRange($input['rentang_awal'], $input['rentang_akhir']);
        }

        // Ambil data transaksi dengan pagination
        $transactions = $query->orderBy('created_at', 'desc')->paginate(20);

        // Hitung statistik
        $totalPendapatan = $query->sum('total_amount');
        $jumlahTransaksi = $query->count();

        // Cari produk terlaris dalam periode yang sama
        $produkTerlarisQuery = TransactionDetail::select('product_name', DB::raw('SUM(quantity) as total_quantity'))
            ->whereHas('transaction', function ($q) use ($input) {
                if (!empty($input['tanggal'])) {
                    $q->byDate($input['tanggal']);
                } elseif (!empty($input['bulan'])) {
                    $date = Carbon::parse($input['bulan']);
                    $q->byMonth($date->year, $date->month);
                } elseif (!empty($input['rentang_awal']) && !empty($input['rentang_akhir'])) {
                    $q->byDateRange($input['rentang_awal'], $input['rentang_akhir']);
                }
            })
            ->groupBy('product_name')
            ->orderBy('total_quantity', 'desc')
            ->first();

        return view('tampilanKeuangan', [
            'transactions' => $transactions,
            'totalPendapatan' => $totalPendapatan,
            'jumlahTransaksi' => $jumlahTransaksi,
            'produkTerlaris' => $produkTerlarisQuery,
            'input' => $input
        ]);
    }
}
