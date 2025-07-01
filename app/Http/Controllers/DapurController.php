<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class DapurController extends Controller
{
    // Menampilkan halaman utama Dapur (Kanban Board)
    public function index()
    {
        return view('tampilanDapur');
    }

    // Menyediakan data pesanan aktif untuk di-fetch oleh JavaScript
    public function getActiveOrders()
    {
        $orders = Transaction::with('details')
            ->whereIn('status', ['baru', 'diproses'])
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($orders);
    }

    // Mengupdate status pesanan
    public function updateStatus(Request $request, Transaction $transaction)
    {
        $request->validate(['status' => 'required|in:diproses,selesai']);

        $transaction->status = $request->status;
        $transaction->save();

        return response()->json(['success' => true, 'message' => 'Status berhasil diperbarui.']);
    }
}
