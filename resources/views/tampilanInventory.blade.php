@extends('layouts.admin')
@section('title', 'Manajemen Inventory')

@push('styles')
    <style>
        .stock-status {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
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

        .form-inline {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
    </style>
@endpush

@section('content')
    <div class="bg-white p-8 rounded-xl shadow-md">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Manajemen Stok Produk</h2>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="p-3 text-left">Nama Produk</th>
                        <th class="p-3 text-left">Stok Saat Ini</th>
                        <th class="p-3 text-left">Status</th>
                        <th class="p-3 text-left" style="width: 250px;">Update Stok</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr class="border-b">
                            <td class="p-3 font-medium">{{ $product->name }}</td>
                            <td class="p-3 font-bold text-lg">{{ $product->stock }}</td>
                            <td class="p-3">
                                @if ($product->stock <= 0)
                                    <span class="stock-status status-habis">Habis</span>
                                @elseif ($product->stock <= 10)
                                    <span class="stock-status status-segera-habis">Segera Habis</span>
                                @else
                                    <span class="stock-status status-tersedia">Tersedia</span>
                                @endif
                            </td>
                            <td class="p-3">
                                <form action="{{ route('admin.inventory.update', $product->id) }}" method="POST"
                                    class="form-inline">
                                    @csrf
                                    <input type="number" name="stock" value="{{ $product->stock }}"
                                        class="w-24 border rounded-lg px-2 py-1" required>
                                    <button type="submit"
                                        class="bg-blue-600 text-white px-3 py-1 rounded-lg hover:bg-blue-700">Update</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-4 text-center text-gray-500">Belum ada produk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
