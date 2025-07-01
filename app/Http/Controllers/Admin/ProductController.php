<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return view('admin.produk.index', ['products' => Product::latest()->get()]);
    }
    public function create()
    {
        return view('admin.produk.create');
    }
    public function store(Request $request)
    {
        Product::create($request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'category' => 'required|string|max:255',
            'icon' => 'nullable|string|max:10',
        ]));
        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil ditambahkan.');
    }
    public function edit(Product $product)
    {
        return view('admin.produk.edit', compact('product'));
    }
    public function update(Request $request, Product $product)
    {
        $product->update($request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'category' => 'required|string|max:255',
            'icon' => 'nullable|string|max:10',
        ]));
        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil diperbarui.');
    }
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil dihapus.');
    }
}
