@extends('layouts.app')

@section('title', 'Laporan Keuangan')

@push('styles')
    <style>
        .summary-cards {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .card {
            background: white;
            padding: 1.5rem;
            border-radius: 16px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .card-title {
            font-size: 1rem;
            color: #718096;
            margin-bottom: 0.5rem;
        }

        .card-value {
            font-size: 2rem;
            font-weight: 700;
            color: #2d3748;
        }

        .filters {
            background: white;
            padding: 1.5rem;
            border-radius: 16px;
            margin-bottom: 2rem;
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
            align-items: flex-end;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
        }

        .form-label {
            font-weight: 600;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .form-control {
            padding: 0.75rem;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
        }

        .btn-filter {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            background: #962d2d;
            color: white;
            cursor: pointer;
        }

        .report-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .report-table th,
        .report-table td {
            padding: 1rem 1.5rem;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }

        .report-table th {
            background: #f7fafc;
        }

        .transaction-row {
            cursor: pointer;
        }

        .details-row {
            display: none;
        }

        .details-row.active {
            display: table-row;
        }

        .details-row ul {
            list-style: none;
            padding-left: 1rem;
            margin: 0.5rem 0;
        }

        .details-row li {
            padding: 0.25rem 0;
        }

        .empty-row td {
            text-align: center;
            padding: 3rem;
            color: #718096;
        }
    </style>
@endpush

@section('content')
    <div class="filters">
        <form method="GET" action="{{ route('keuangan.index') }}" class="d-flex flex-grow-1 gap-4">
            <div class="filter-group">
                <label for="tanggal" class="form-label">Per Tanggal</label>
                <input type="date" name="tanggal" class="form-control" value="{{ $input['tanggal'] ?? '' }}">
            </div>
            <div class="filter-group">
                <label for="bulan" class="form-label">Per Bulan</label>
                <input type="month" name="bulan" class="form-control" value="{{ $input['bulan'] ?? '' }}">
            </div>
            <div class="filter-group">
                <label for="rentang_awal" class="form-label">Rentang Awal</label>
                <input type="date" name="rentang_awal" class="form-control" value="{{ $input['rentang_awal'] ?? '' }}">
            </div>
            <div class="filter-group">
                <label for="rentang_akhir" class="form-label">Rentang Akhir</label>
                <input type="date" name="rentang_akhir" class="form-control" value="{{ $input['rentang_akhir'] ?? '' }}">
            </div>
            <button type="submit" class="btn-filter">Terapkan</button>
        </form>
    </div>

    <div class="summary-cards">
        <div class="card">
            <div class="card-title">Total Pendapatan</div>
            <div class="card-value">Rp{{ number_format($totalPendapatan, 0, ',', '.') }}</div>
        </div>
        <div class="card">
            <div class="card-title">Jumlah Transaksi</div>
            <div class="card-value">{{ $jumlahTransaksi }}</div>
        </div>
        <div class="card">
            <div class="card-title">Produk Terlaris</div>
            <div class="card-value">{{ $produkTerlaris->product_name ?? 'N/A' }}</div>
            @if ($produkTerlaris)
                <small>Terjual: {{ $produkTerlaris->total_quantity }}</small>
            @endif
        </div>
    </div>

    <table class="report-table">
        <thead>
            <tr>
                <th>Kode Transaksi</th>
                <th>Waktu</th>
                <th>Total</th>
                <th>Detail</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transactions as $transaction)
                <tr class="transaction-row" data-target="details-{{ $transaction->id }}">
                    <td>{{ $transaction->transaction_code }}</td>
                    <td>{{ $transaction->created_at->setTimezone('Asia/Jakarta')->format('d M Y, H:i') }}</td>
                    <td>Rp{{ number_format($transaction->total_amount, 0, ',', '.') }}</td>
                    <td>Klik untuk lihat</td>
                </tr>
                <tr class="details-row" id="details-{{ $transaction->id }}">
                    <td colspan="4">
                        <strong>Detail Pembelian:</strong>
                        <ul>
                            @foreach ($transaction->details as $detail)
                                <li>{{ $detail->quantity }}x {{ $detail->product_name }} @
                                    Rp{{ number_format($detail->price, 0, ',', '.') }}</li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
            @empty
                <tr class="empty-row">
                    <td colspan="4">Tidak ada data transaksi untuk periode yang dipilih.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const transactionRows = document.querySelectorAll('.transaction-row');
            transactionRows.forEach(row => {
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
