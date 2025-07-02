@extends('layouts.admin')
@section('title', 'Manajemen Produk')

@section('content')
    <div class="bg-white p-6 md:p-8 rounded-xl shadow-md">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Daftar Produk</h2>
            <a href="{{ route('admin.produk.create') }}"
                class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                <i data-lucide="plus-circle" class="mr-2"></i>
                Tambah Produk
            </a>
        </div>

        @if (session('success'))
            <div class="p-4 mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 rounded-lg" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th class="py-3 px-6">Ikon</th>
                        <th class="py-3 px-6">Nama Produk</th>
                        <th class="py-3 px-6">Kategori</th>
                        <th class="py-3 px-6">Stok</th>
                        <th class="py-3 px-6 text-right">Harga</th>
                        <th class="py-3 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="py-4 px-6">{{ $product->icon }}</td>
                            <td class="py-4 px-6 font-medium text-gray-900">{{ $product->name }}</td>
                            <td class="py-4 px-6">{{ $product->category }}</td>
                            <td class="py-4 px-6 font-bold">{{ $product->stock }}</td>
                            <td class="py-4 px-6 text-right">Rp{{ number_format($product->price, 0, ',', '.') }}</td>
                            <td class="py-4 px-6">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('admin.produk.edit', $product->id) }}"
                                        class="px-3 py-1 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 transition-colors">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.produk.destroy', $product->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus produk ini: {{ $product->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600 transition-colors">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-4 px-6 text-center text-gray-500">Belum ada data produk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
