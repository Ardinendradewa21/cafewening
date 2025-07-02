@extends('layouts.admin')
@section('title', 'Edit Produk')

@push('styles')
    <style>
        .form-container {
            background: white;
            padding: 2rem;
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #2d3748;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2);
        }

        .btn-submit {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            background: linear-gradient(135deg, #48bb78, #38a169);
            color: white;
            transition: all 0.3s ease;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
        }

        .btn-back {
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            color: #4a5568;
            background-color: #e2e8f0;
            margin-right: 1rem;
            transition: all 0.3s ease;
        }

        .btn-back:hover {
            background-color: #cbd5e0;
        }
    </style>
@endpush

@section('content')
    <div class="form-container">
        <h2 class="text-2xl font-bold mb-6">Edit Produk: {{ $product->name }}</h2>

        {{-- Form untuk update produk --}}
        <form action="{{ route('admin.produk.update', $product->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name" class="form-label">Nama Produk</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $product->name }}" required>
            </div>

            <div class="form-group">
                <label for="price" class="form-label">Harga</label>
                <input type="number" name="price" id="price" class="form-control" value="{{ $product->price }}"
                    required>
            </div>

            <div class="form-group">
                <label for="stock" class="form-label">Stok</label>
                <input type="number" name="stock" id="stock" class="form-control" value="{{ $product->stock }}"
                    required min="0">
            </div>

            <div class="form-group">
                <label for="category" class="form-label">Kategori</label>
                <input type="text" name="category" id="category" class="form-control" value="{{ $product->category }}"
                    required>
            </div>

            <div class="form-group">
                <label for="icon" class="form-label">Ikon (Emoji)</label>
                <input type="text" name="icon" id="icon" class="form-control" value="{{ $product->icon }}">
            </div>

            <div>
                <a href="{{ route('admin.produk.index') }}" class="btn-back">Batal</a>
                <button type="submit" class="btn-submit">Update Produk</button>
            </div>
        </form>
    </div>
@endsection
