@extends('layouts.admin')

@section('title', 'Edit Produk')

@push('styles')
    <style>
        .form-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;
        }

        .form-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .form-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2d3748;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .form-title i {
            margin-right: 0.75rem;
            color: #667eea;
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

        .form-input {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: #667eea;
        }

        .form-select {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 1rem;
            background: white;
            transition: border-color 0.3s ease;
        }

        .form-select:focus {
            outline: none;
            border-color: #667eea;
        }

        .form-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 2rem;
        }

        .btn-submit {
            padding: 0.75rem 2rem;
            background: linear-gradient(135deg, #f6ad55, #dd6b20);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(246, 173, 85, 0.3);
        }

        .btn-cancel {
            padding: 0.75rem 2rem;
            background: #e2e8f0;
            color: #2d3748;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-cancel:hover {
            background: #cbd5e0;
        }

        .alert-error {
            padding: 1rem;
            margin-bottom: 1.5rem;
            background-color: #fed7d7;
            color: #c53030;
            border-left: 5px solid #f56565;
            border-radius: 8px;
        }

        .error-text {
            color: #e53e3e;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .current-info {
            background: #e6fffa;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            border-left: 4px solid #38b2ac;
        }

        .current-info h3 {
            color: #234e52;
            margin: 0 0 0.5rem 0;
            font-size: 1rem;
        }

        .current-info p {
            color: #285e61;
            margin: 0;
        }
    </style>
@endpush

@section('content')
    <div class="form-container">
        <div class="form-header">
            <h2 class="form-title">
                <i data-lucide="edit"></i>
                Edit Produk
            </h2>
        </div>

        <div class="current-info">
            <h3>Produk yang sedang diedit:</h3>
            <p><strong>{{ $product->name }}</strong> - Rp{{ number_format($product->price, 0, ',', '.') }}</p>
        </div>

        @if ($errors->any())
            <div class="alert-error">
                <ul style="margin: 0; padding-left: 1rem;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('error'))
            <div class="alert-error">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('admin.produk.update', $product) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name" class="form-label">Nama Produk</label>
                <input type="text" id="name" name="name" class="form-input"
                    value="{{ old('name', $product->name) }}" required>
                @error('name')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="category" class="form-label">Kategori</label>
                <select id="category" name="category" class="form-select" required>
                    <option value="">Pilih Kategori</option>
                    <option value="coffe" {{ old('category', $product->category) == 'coffe' ? 'selected' : '' }}>Makanan
                    </option>
                    <option value="tea" {{ old('category', $product->category) == 'tea' ? 'selected' : '' }}>Minuman
                    </option>
                    <option value="food" {{ old('category', $product->category) == 'food' ? 'selected' : '' }}>Snack
                    </option>
                    <option value="dessert" {{ old('category', $product->category) == 'dessert' ? 'selected' : '' }}>
                        Dessert</option>
                </select>
                @error('category')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="price" class="form-label">Harga (Rp)</label>
                <input type="number" id="price" name="price" class="form-input"
                    value="{{ old('price', $product->price) }}" min="0" step="1000" required>
                @error('price')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="stock" class="form-label">Stok</label>
                <input type="number" id="stock" name="stock" class="form-input"
                    value="{{ old('stock', $product->stock) }}" min="0" required>
                @error('stock')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="icon" class="form-label">Ikon (Opsional)</label>
                <input type="text" id="icon" name="icon" class="form-input"
                    value="{{ old('icon', $product->icon) }}" placeholder="🍔 atau emoji lainnya">
                @error('icon')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-buttons">
                <button type="submit" class="btn-submit">
                    Update Produk
                </button>
                <a href="{{ route('admin.produk.index') }}" class="btn-cancel">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection
