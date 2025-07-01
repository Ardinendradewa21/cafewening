<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('name')->get();
        return view('admin.inventory', compact('products'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate(['stock' => 'required|integer|min:0']);

        // Nanti di sini kita bisa tambahkan logika untuk mencatat riwayat perubahan stok
        $product->stock = $request->stock;
        $product->save();

        return back()->with('success', 'Stok untuk ' . $product->name . ' berhasil diperbarui.');
    }
}
