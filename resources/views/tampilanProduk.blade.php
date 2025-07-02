@extends('layouts.admin')

@section('title', 'Manajemen Produk')

{{-- CSS khusus untuk halaman produk --}}
@push('styles')
    <style>
        .products-management {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2d3748;
            display: flex;
            align-items: center;
        }

        .section-title i {
            margin-right: 0.75rem;
            color: #667eea;
        }

        .add-btn {
            display: inline-flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
            background: linear-gradient(135deg, #48bb78, #38a169);
            color: white;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .add-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(72, 187, 120, 0.3);
        }

        .add-btn i {
            margin-right: 0.5rem;
        }

        .products-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        .products-table th,
        .products-table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }

        .products-table th {
            background: rgba(102, 126, 234, 0.1);
            font-weight: 600;
            color: #2d3748;
        }

        .products-table tr:hover {
            background: rgba(102, 126, 234, 0.05);
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .btn-edit,
        .btn-delete {
            padding: 0.5rem 0.75rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            color: white;
            display: inline-flex;
            align-items: center;
        }

        .btn-edit {
            background-color: #f6ad55;
        }

        .btn-edit:hover {
            background-color: #dd6b20;
        }

        .btn-delete {
            background-color: #f56565;
        }

        .btn-delete:hover {
            background-color: #c53030;
        }

        .alert-success {
            padding: 1rem;
            margin-bottom: 1.5rem;
            background-color: #c6f6d5;
            color: #2f855a;
            border-left: 5px solid #38a169;
            border-radius: 8px;
        }
    </style>
@endpush

@section('content')

    @if (session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="products-management">
        <div class="section-header">
            <h2 class="section-title">
                <i data-lucide="package"></i>
                Daftar Produk
            </h2>
            {{-- Tombol ini akan mengarah ke halaman form tambah produk --}}
            <a href="{{ route('admin.produk.create') }}" class="add-btn">
                <i data-lucide="plus-circle"></i>
                Tambah Produk
            </a>
        </div>

        <div style="overflow-x: auto;">
            <table class="products-table">
                <thead>
                    <tr>
                        <th>Ikon</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Kita akan looping data $products yang dikirim dari controller --}}
                    @forelse ($products as $product)
                        <tr>
                            <td>{{ $product->icon }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->category }}</td>
                            <td>{{ $product->stock }}</td>
                            <td>Rp{{ number_format($product->price, 0, ',', '.') }}</td>
                            <td>
                                <div class="action-buttons">
                                    {{-- Tombol untuk Edit & Hapus --}}
                                    <a href="{{ route('admin.produk.edit', $product->id) }}" class="btn-edit">Edit</a>
                                    <form action="{{ route('admin.produk.destroy', $product->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini: {{ $product->name }}?')">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        {{-- Tampilan jika tidak ada produk sama sekali --}}
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 2rem;">
                                Belum ada data produk.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
