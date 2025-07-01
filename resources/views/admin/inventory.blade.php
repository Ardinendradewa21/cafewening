@extends('layouts.admin')
@section('title', 'Manajemen Inventory')

@push('styles')
    <style>
        /* Style untuk status stok */
        .stock-status {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            display: inline-block;
        }

        .status-tersedia {
            background-color: #c6f6d5;
            color: #2f855a;
        }

        .status-segera-habis {
            background-color: #feebc8;
            color: #9c4221;
        }

        .status-habis {
            background-color: #fed7d7;
            color: #c53030;
        }

        /* Style untuk form inline di dalam tabel */
        .form-inline {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-inline .form-control {
            width: 80px;
            padding: 0.5rem;
            border: 1px solid #d2d6dc;
            border-radius: 6px;
        }

        .form-inline .btn {
            padding: 0.5rem 1rem;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            color: white;
            background-color: #3b82f6;
            /* Warna biru */
        }

        .form-inline .btn:hover {
            background-color: #2563eb;
        }
    </style>
@endpush

@section('content')
    <div class="bg-white p-6 md:p-8 rounded-xl shadow-md">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Manajemen Stok Produk</h2>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="py-3 px-6">Nama Produk</th>
                        <th scope="col" class="py-3 px-6">Stok Saat Ini</th>
                        <th scope="col" class="py-3 px-6">Status</th>
                        <th scope="col" class="py-3 px-6" style="width: 250px;">Update Stok</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="py-4 px-6 font-medium text-gray-900">{{ $product->name }}</td>
                            <td class="py-4 px-6 font-bold text-lg text-gray-800">{{ $product->stock }}</td>
                            <td class="py-4 px-6">
                                @if ($product->stock <= 0)
                                    <span class="stock-status status-habis">Habis</span>
                                @elseif ($product->stock <= 10)
                                    <span class="stock-status status-segera-habis">Segera Habis</span>
                                @else
                                    <span class="stock-status status-tersedia">Tersedia</span>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                <form action="{{ route('admin.inventory.update', $product->id) }}" method="POST"
                                    class="form-inline">
                                    @csrf
                                    <input type="number" name="stock" value="{{ $product->stock }}" class="form-control"
                                        required min="0">
                                    <button type="submit" class="btn">Update</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr class="bg-white border-b">
                            <td colspan="4" class="py-4 px-6 text-center text-gray-500">Belum ada data produk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
