<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // 1. Ambil semua data dari model Product
        $products = Product::latest()->get(); // latest() untuk mengurutkan dari yang terbaru

        // 2. Kirim data products ke view 'tampilanProduk'
        return view('tampilanProduk', ['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Fungsi ini hanya perlu menampilkan view yang berisi form tambah produk.
        return view('tampilanProduk_create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi data yang masuk dari form
        // Ini memastikan data yang kita terima sesuai format yang diinginkan.
        $request->validate([
            'name' => 'required|string|max:255', // Wajib diisi, harus teks, maks 255 karakter
            'price' => 'required|integer',        // Wajib diisi, harus angka
            'category' => 'required|string',      // Wajib diisi, harus teks
            'icon' => 'nullable|string|max:10', // Boleh kosong, jika diisi harus teks maks 10 karakter
        ]);
        // 2. Jika validasi berhasil, simpan data ke database
        // Product::create() akan membuat baris baru di tabel 'products'.
        // $request->all() mengambil semua data dari form yang sudah divalidasi.
        Product::create($request->all());

        // 3. Redirect (arahkan kembali) pengguna ke halaman daftar produk
        // ->with('success', '...') akan mengirimkan pesan flash ke sesi
        // yang bisa kita tampilkan di halaman selanjutnya.
        return redirect()->route('produk.index')
            ->with('success', 'Produk baru berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    // Perhatikan 'Product $product'. Laravel secara otomatis akan mencari
    // data produk di database berdasarkan {id} yang ada di URL.
    public function edit(Product $product)
    {
        // Kirim data produk yang ditemukan ke sebuah view baru untuk form edit.
        return view('admin.produk.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        // 1. Validasi data yang masuk, sama seperti saat 'store'
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|integer',
            'category' => 'required|string',
            'icon' => 'nullable|string|max:10',
        ]);

        // 2. Update data produk yang ada (ditemukan oleh Route Model Binding)
        //    dengan data baru dari request.
        $product->update($request->all());

        // 3. Redirect kembali ke halaman daftar produk dengan pesan sukses.
        return redirect()->route('produk.index')
            ->with('success', 'Produk berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // 1. Hapus data produk dari database.
        $product->delete();

        // 2. Redirect kembali ke halaman daftar produk dengan pesan sukses.
        return redirect()->route('produk.index')
            ->with('success', 'Produk berhasil dihapus!');
    }
}
