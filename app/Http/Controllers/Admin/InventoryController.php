<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    /**
     * Ini adalah fungsi index() yang dicari oleh route.
     * Fungsinya untuk menampilkan halaman manajemen inventory.
     */
    public function index()
    {
        $products = Product::orderBy('name')->get();
        return view('admin.inventory', compact('products'));
    }

    /**
     * Ini adalah fungsi untuk mengupdate stok.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate(['stock' => 'required|integer|min:0']);

        // Logika untuk mencatat riwayat bisa ditambahkan di sini nanti
        $product->stock = $request->stock;
        $product->save();

        return back()->with('success', 'Stok untuk ' . $product->name . ' berhasil diperbarui.');
    }
}
