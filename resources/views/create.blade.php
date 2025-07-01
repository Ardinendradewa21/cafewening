@extends('layouts.admin')
@section('title', 'Tambah Produk Baru')

@section('content')
    <div class="bg-white p-8 rounded-xl shadow-md">
        <h2 class="text-2xl font-bold mb-6">Formulir Tambah Produk Baru</h2>

        <form action="{{ route('admin.produk.store') }}" method="POST">
            @csrf

            {{-- Perhatikan: semua input di bawah ini TIDAK memiliki atribut 'value' --}}
            {{-- yang memanggil $product, kecuali untuk old() helper --}}

            <div class="mb-4">
                <label for="name" class="block mb-2 font-medium">Nama Produk</label>
                <input type="text" name="name" id="name" class="w-full border rounded-lg px-3 py-2"
                    value="{{ old('name') }}" required>
            </div>

            <div class="mb-4">
                <label for="price" class="block mb-2 font-medium">Harga</label>
                <input type="number" name="price" id="price" class="w-full border rounded-lg px-3 py-2"
                    value="{{ old('price') }}" required>
            </div>

            <div class="mb-4">
                <label for="stock" class="block mb-2 font-medium">Stok Awal</label>
                <input type="number" name="stock" id="stock" class="w-full border rounded-lg px-3 py-2"
                    value="{{ old('stock', 0) }}" required min="0">
            </div>

            <div class="mb-4">
                <label for="category" class="block mb-2 font-medium">Kategori</label>
                <input type="text" name="category" id="category" class="w-full border rounded-lg px-3 py-2"
                    value="{{ old('category') }}" required>
            </div>

            <div class="mb-6">
                <label for="icon" class="block mb-2 font-medium">Ikon (Emoji)</label>
                <input type="text" name="icon" id="icon" class="w-full border rounded-lg px-3 py-2"
                    value="{{ old('icon') }}">
            </div>

            <div>
                Produk</button>
                <a href="{{ route('admin.produk.index') }}" class="text-gray-600 ml-4">Batal</a>
            </div>
        </form>
    </div>
@endsection
