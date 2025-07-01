@extends('layouts.admin')
@section('title', 'Daftar Pesanan')

@push('styles')
    <style>
        .details-row {
            display: none;
            background-color: #f9fafb;
        }

        .details-row.active {
            display: table-row;
        }

        .details-row ul {
            list-style-position: inside;
        }

        .transaction-row {
            cursor: pointer;
            transition: background-color 0.2s ease-in-out;
        }

        .transaction-row:hover {
            background-color: #f0f8ff;
        }
    </style>
@endpush

@section('content')
    <div class="bg-white p-8 rounded-xl shadow-md">
        <h2 class="text-2xl font-bold mb-6">Riwayat Pesanan</h2>

        <div class="mb-6 p-4 bg-gray-50 rounded-lg">
            <form method="GET" action="{{ route('admin.pesanan.index') }}" class="flex items-end gap-4">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700">Cari Kode Transaksi</label>
                    <input type="text" name="search" id="search"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="TRX-..."
                        value="{{ request('search') }}">
                </div>
                <div>
                    <label for="kasir_id" class="block text-sm font-medium text-gray-700">Filter per Kasir</label>
                    <select name="kasir_id" id="kasir_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <option value="">Semua Kasir</option>
                        @foreach ($cashiers as $kasir)
                            <option value="{{ $kasir->id }}" {{ request('kasir_id') == $kasir->id ? 'selected' : '' }}>
                                {{ $kasir->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Filter</button>
                <a href="{{ route('admin.pesanan.index') }}" class="text-gray-600 hover:text-black py-2 px-4">Reset</a>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="p-3 text-left">Kode Transaksi</th>
                        <th class="p-3 text-left">Waktu</th>
                        <th class="p-3 text-left">Kasir</th>
                        <th class="p-3 text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transactions as $transaction)
                        <tr class="transaction-row border-b" data-target="details-{{ $transaction->id }}">
                            <td class="p-3 font-medium">{{ $transaction->transaction_code }}</td>
                            <td class="p-3 text-gray-600">
                                {{ $transaction->created_at->setTimezone('Asia/Jakarta')->format('d M Y, H:i') }}</td>
                            <td class="p-3 text-gray-800">{{ optional($transaction->user)->name ?? 'N/A' }}</td>
                            <td class="p-3 text-right font-bold">
                                Rp{{ number_format($transaction->total_amount, 0, ',', '.') }}</td>
                        </tr>
                        <tr class="details-row" id="details-{{ $transaction->id }}">
                            <td colspan="4" class="p-4 bg-gray-50">
                                <strong class="block mb-2">Detail Pembelian:</strong>
                                <ul class="list-disc pl-5">
                                    @foreach ($transaction->details as $detail)
                                        <li>{{ $detail->quantity }}x {{ $detail->product_name }} (@
                                            Rp{{ number_format($detail->price) }})</li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-4 text-center text-gray-500">Tidak ada data pesanan yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination Links --}}
        <div class="mt-6">
            {{ $transactions->links() }}
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Skrip untuk expand/collapse detail transaksi
            document.querySelectorAll('.transaction-row').forEach(row => {
                row.addEventListener('click', () => {
                    const targetId = row.dataset.target;
                    const detailsRow = document.getElementById(targetId);
                    if (detailsRow) {
                        detailsRow.classList.toggle('active');
                    }
                });
            });
        });
    </script>
@endpush
