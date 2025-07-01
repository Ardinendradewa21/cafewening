@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@push('styles')
    <style>
        .summary-cards {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1.5rem;
        }

        .card {
            background: white;
            padding: 1.5rem;
            border-radius: 16px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .card .icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            /* Ukuran ikon Lucide */
        }

        .card-info .title {
            font-size: 1rem;
            color: #718096;
            margin-bottom: 0.25rem;
        }

        .card-info .value {
            font-size: 1.75rem;
            font-weight: 700;
            color: #2d3748;
        }

        .bg-blue-100 {
            background-color: #ebf8ff;
        }

        .text-blue-500 {
            color: #4299e1;
        }

        .bg-green-100 {
            background-color: #f0fff4;
        }

        .text-green-500 {
            color: #48bb78;
        }

        .bg-yellow-100 {
            background-color: #fffff0;
        }

        .text-yellow-500 {
            color: #ecc94b;
        }

        .bg-purple-100 {
            background-color: #faf5ff;
        }

        .text-purple-500 {
            color: #9f7aea;
        }
    </style>
@endpush

@section('content')
    <div class="summary-cards">
        <div class="card">
            <div class="icon bg-green-100 text-green-500">
                <i data-lucide="dollar-sign"></i>
            </div>
            <div class="card-info">
                <p class="title">Pendapatan Hari Ini</p>
                <p class="value">Rp{{ number_format($pendapatanHariIni, 0, ',', '.') }}</p>
            </div>
        </div>
        <div class="card">
            <div class="icon bg-blue-100 text-blue-500">
                <i data-lucide="shopping-cart"></i>
            </div>
            <div class="card-info">
                <p class="title">Transaksi Hari Ini</p>
                <p class="value">{{ $transaksiHariIni }}</p>
            </div>
        </div>
        <div class="card">
            <div class="icon bg-purple-100 text-purple-500">
                <i data-lucide="package"></i>
            </div>
            <div class="card-info">
                <p class="title">Total Jenis Produk</p>
                <p class="value">{{ $totalProduk }}</p>
            </div>
        </div>
        <div class="card">
            <div class="icon bg-yellow-100 text-yellow-500">
                <i data-lucide="users"></i>
            </div>
            <div class="card-info">
                <p class="title">Total Pengguna</p>
                <p class="value">{{ $totalPengguna }}</p>
            </div>
        </div>
    </div>

    <div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-8">

        <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-md">
            <h3 class="text-xl font-bold mb-4">Aktivitas Terbaru</h3>
            <div class="space-y-4">
                {{-- Ini adalah contoh data statis, nanti bisa diisi dari database --}}
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-blue-100 text-blue-500 rounded-full flex items-center justify-center">
                        <i data-lucide="shopping-cart"></i>
                    </div>
                    <div>
                        <p class="font-semibold">Transaksi baru #TRX-12345</p>
                        <p class="text-sm text-gray-500">Oleh Kasir 1 - beberapa detik yang lalu</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-green-100 text-green-500 rounded-full flex items-center justify-center">
                        <i data-lucide="user-plus"></i>
                    </div>
                    <div>
                        <p class="font-semibold">Pengguna baru "Kasir 2" telah ditambahkan</p>
                        <p class="text-sm text-gray-500">Oleh Admin - 1 jam yang lalu</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-yellow-100 text-yellow-500 rounded-full flex items-center justify-center">
                        <i data-lucide="package-plus"></i>
                    </div>
                    <div>
                        <p class="font-semibold">Produk "Es Kopi Gula Aren" ditambahkan</p>
                        <p class="text-sm text-gray-500">Oleh Admin - 3 jam yang lalu</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-md">
            <h3 class="text-xl font-bold mb-4">Aksi Cepat</h3>
            <div class="space-y-3">
                <a href="{{ route('admin.produk.create') }}"
                    class="flex items-center gap-3 p-3 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors">
                    <i data-lucide="package-plus" class="text-gray-600"></i>
                    <span class="font-medium">Tambah Produk Baru</span>
                </a>
                <a href="{{ route('admin.users.create') }}"
                    class="flex items-center gap-3 p-3 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors">
                    <i data-lucide="user-plus" class="text-gray-600"></i>
                    <span class="font-medium">Tambah Pengguna</span>
                </a>
                <a href="#"
                    class="flex items-center gap-3 p-3 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors">
                    <i data-lucide="settings" class="text-gray-600"></i>
                    <span class="font-medium">Pengaturan</span>
                </a>
            </div>
        </div>

    </div>
@endsection
