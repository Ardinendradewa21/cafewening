@extends('layouts.admin')
@section('title', 'Laporan Penjualan')

@push('styles')
    <style>
        .report-section {
            background-color: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .report-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2rem;
        }

        @media (min-width: 1024px) {
            .report-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
@endpush

@section('content')
    <div class="report-grid">
        <div class="report-section">
            <h3 class="text-xl font-bold mb-4">Laporan Penjualan per Produk</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th class="py-3 px-6">Nama Produk</th>
                            <th class="py-3 px-6 text-center">Jumlah Terjual</th>
                            <th class="py-3 px-6 text-right">Total Pendapatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($laporanProduk as $item)
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="py-4 px-6 font-medium">{{ $item->product_name }}</td>
                                <td class="py-4 px-6 text-center">{{ $item->total_quantity }}</td>
                                <td class="py-4 px-6 text-right font-semibold">Rp{{ number_format($item->total_revenue) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-4">Belum ada data penjualan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="report-section">
            <h3 class="text-xl font-bold mb-4">Laporan Penjualan per Kategori</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th class="py-3 px-6">Kategori</th>
                            <th class="py-3 px-6 text-right">Total Pendapatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($laporanKategori as $item)
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="py-4 px-6 font-medium">{{ ucfirst($item->category) }}</td>
                                <td class="py-4 px-6 text-right font-semibold">Rp{{ number_format($item->total_revenue) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center py-4">Belum ada data penjualan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
