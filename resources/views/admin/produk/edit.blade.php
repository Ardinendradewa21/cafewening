@extends('layouts.admin')
@section('title', 'Edit Produk')

@section('content')
    <div class="bg-white p-8 rounded-xl shadow-md max-w-2xl mx-auto">
        <h2 class="text-2xl font-bold mb-6">Edit Produk: {{ $product->name }}</h2>

        <form action="{{ route('admin.produk.update', $product->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="name" class="block mb-2 font-medium text-gray-700">Nama Produk</label>
                <input type="text" name="name" id="name" class="w-full border border-gray-300 rounded-lg px-3 py-2"
                    value="{{ old('name', $product->name) }}" required>
            </div>
            <div class="mb-4">
                <label for="price" class="block mb-2 font-medium text-gray-700">Harga</label>
                <input type="number" name="price" id="price"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2" value="{{ old('price', $product->price) }}"
                    required>
            </div>
            <div class="mb-4">
                <label for="stock" class="block mb-2 font-medium text-gray-700">Stok</label>
                <input type="number" name="stock" id="stock"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2" value="{{ old('stock', $product->stock) }}"
                    required min="0">
            </div>
            <div class="mb-4">
                <label for="category" class="block mb-2 font-medium text-gray-700">Kategori</label>
                <input type="text" name="category" id="category"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2"
                    value="{{ old('category', $product->category) }}" required>
            </div>
            <div class="mb-6">
                <label for="icon" class="block mb-2 font-medium text-gray-700">Ikon (Emoji)</label>
                <input type="text" name="icon" id="icon"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2" value="{{ old('icon', $product->icon) }}">
            </div>
            <div class="flex items-center">
                <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700">Update
                    Produk</button>
                <a href="{{ route('admin.produk.index') }}" class="text-gray-600 ml-4 hover:underline">Batal</a>
            </div>
        </form>
    </div>
@endsection
