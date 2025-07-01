{{--
================================================================================
| HALAMAN DASHBOARD KASIR - VERSI FINAL                                        |
|                                                                              |
| Perubahan:                                                                   |
| 1. Menggunakan layout utama yang sudah diperbarui.                           |
| 2. Judul diubah menjadi "Dashboard - POS System".                            |
| 3. CSS, HTML, dan JavaScript (termasuk data produk yang benar)               |
|    diambil dari kode terbaru yang Anda berikan.                              |
================================================================================
--}}

@extends('layouts.app')

@section('title', 'Dashboard - POS System')

{{-- CSS yang spesifik untuk halaman POS --}}
@push('styles')
    <style>
        .pos-layout {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 2rem;
            height: calc(100vh - 200px);
        }

        .products-section {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
        }

        .section-title i {
            margin-right: 0.75rem;
            color: #667eea;
        }

        .search-container {
            position: relative;
            margin-bottom: 2rem;
        }

        .search-input {
            width: 100%;
            padding: 1rem 1rem 1rem 3rem;
            border: 2px solid rgba(102, 126, 234, 0.2);
            border-radius: 12px;
            font-size: 1rem;
            background: rgba(255, 255, 255, 0.8);
            transition: all 0.3s ease;
        }

        .search-input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #718096;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1.5rem;
        }

        .product-card {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 16px;
            padding: 1.5rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid transparent;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .product-card:hover {
            transform: translateY(-5px);
            border-color: #667eea;
            box-shadow: 0 8px 30px rgba(102, 126, 234, 0.2);
        }

        .product-image {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 50%;
            margin: 0 auto 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
        }

        .product-name {
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 0.5rem;
            font-size: 1.1rem;
        }

        .product-price {
            font-size: 1.2rem;
            font-weight: 700;
            color: #667eea;
        }

        /* Style untuk produk yang stoknya habis */
        .product-card.out-of-stock {
            cursor: not-allowed;
            background: #f1f2f6;
            /* Warna abu-abu */
            position: relative;
            overflow: hidden;
        }

        .product-card.out-of-stock::after {
            content: 'STOK HABIS';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(236, 77, 85, 0.85);
            /* Merah dengan transparansi */
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 700;
            font-size: 1rem;
        }

        .product-card.out-of-stock .product-image,
        .product-card.out-of-stock .product-name,
        .product-card.out-of-stock .product-price {
            opacity: 0.4;
        }

        .cart-section {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
        }

        .cart-items {
            flex: 1;
            overflow-y: auto;
            margin-bottom: 2rem;
            max-height: 400px;
        }

        .cart-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem;
            margin-bottom: 1rem;
            background: rgba(102, 126, 234, 0.05);
            border-radius: 12px;
            border-left: 4px solid #667eea;
        }

        .cart-item-info {
            flex: 1;
        }

        .cart-item-name {
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 0.25rem;
        }

        .cart-item-price {
            color: #718096;
            font-size: 0.9rem;
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-left: 1rem;
        }

        .qty-btn {
            width: 32px;
            height: 32px;
            border: none;
            border-radius: 8px;
            background: #667eea;
            color: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            font-size: 1.1rem;
        }

        .qty-btn:hover {
            background: #5a67d8;
            transform: scale(1.05);
        }

        .qty-display {
            font-weight: 600;
            color: #2d3748;
            min-width: 24px;
            text-align: center;
        }

        .remove-btn {
            background: #e53e3e;
            color: white;
            border: none;
            border-radius: 8px;
            width: 32px;
            height: 32px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            margin-left: 0.5rem;
        }

        .remove-btn:hover {
            background: #c53030;
            transform: scale(1.05);
        }

        .cart-summary {
            border-top: 2px solid rgba(102, 126, 234, 0.1);
            padding-top: 1.5rem;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .total-label {
            font-size: 1.25rem;
            font-weight: 600;
            color: #2d3748;
        }

        .total-amount {
            font-size: 1.5rem;
            font-weight: 700;
            color: #667eea;
        }

        .checkout-btn {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, #48bb78, #38a169);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .checkout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(72, 187, 120, 0.3);
        }

        .checkout-btn:disabled {
            background: #a0aec0;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .checkout-btn i {
            margin-right: 0.5rem;
        }

        .empty-cart {
            text-align: center;
            padding: 2rem;
            color: #718096;
        }

        .empty-cart i {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        @media (max-width: 1024px) {
            .pos-layout {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            }
        }
    </style>
@endpush

@section('content')
    <div class="pos-layout" id="posContent">
        <section class="products-section">
            <h2 class="section-title">
                <i data-lucide="coffee"></i>
                Products
            </h2>
            <div class="search-container">
                <input type="text" class="search-input" placeholder="Search products..." id="searchInput">
                <i data-lucide="search" class="search-icon"></i>
            </div>
            <div class="products-grid" id="productsGrid">
                {{-- Konten produk akan dirender oleh JavaScript di bawah --}}
            </div>
        </section>

        <section class="cart-section">
            <h2 class="section-title">
                <i data-lucide="shopping-bag"></i>
                Cart
            </h2>
            <div class="cart-items" id="cartItems">
                {{-- Konten keranjang akan dirender oleh JavaScript --}}
            </div>
            <div class="cart-summary">
                <div class="total-row">
                    <span class="total-label">Total:</span>
                    <span class="total-amount" id="totalAmount">Rp0</span>
                </div>
                <button class="checkout-btn" id="checkoutBtn" disabled onclick="handleCheckout()">
                    <i data-lucide="credit-card"></i>
                    Checkout
                </button>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        // [UPDATED] Menggunakan data produk dari kode terbaru yang Anda berikan.
        const products = @json($products);
        // Sisa dari JavaScript (fungsi-fungsi) sama persis dengan yang Anda berikan,
        // karena fungsionalitasnya sudah benar.
        let cart = [];
        let filteredProducts = [...products];

        const productsGrid = document.getElementById('productsGrid');
        const cartItems = document.getElementById('cartItems');
        const totalAmount = document.getElementById('totalAmount');
        const checkoutBtn = document.getElementById('checkoutBtn');
        const searchInput = document.getElementById('searchInput');

        function renderProducts() {
            productsGrid.innerHTML = '';
            filteredProducts.forEach(product => {
                const productCard = document.createElement('div');
                productCard.className = 'product-card';

                // Cek jika stok produk adalah 0 atau kurang
                if (product.stock <= 0) {
                    productCard.classList.add('out-of-stock');
                } else {
                    // Hanya tambahkan event click jika produk tersedia
                    productCard.onclick = () => addToCart(product);
                }

                productCard.innerHTML = `
            <div class="product-image">${product.icon}</div>
            <h3 class="product-name">${product.name}</h3>
            <p class="product-price">Rp${product.price.toLocaleString('id-ID')}</p>
        `;
                productsGrid.appendChild(productCard);
            });
        }

        function filterProducts(searchTerm) {
            filteredProducts = products.filter(product =>
                product.name.toLowerCase().includes(searchTerm.toLowerCase()) ||
                product.category.toLowerCase().includes(searchTerm.toLowerCase())
            );
            renderProducts();
        }

        function addToCart(product) {
            const existingItem = cart.find(item => item.id === product.id);
            if (existingItem) {
                existingItem.quantity += 1;
            } else {
                cart.push({
                    ...product,
                    quantity: 1
                });
            }
            updateCartDisplay();
            const productCards = document.querySelectorAll('.product-card');
            productCards.forEach(card => {
                if (card.querySelector('.product-name').textContent === product.name) {
                    card.style.transform = 'scale(0.95)';
                    setTimeout(() => {
                        card.style.transform = '';
                    }, 150);
                }
            });
        }

        function updateQuantity(productId, change) {
            const item = cart.find(item => item.id === productId);
            if (item) {
                item.quantity += change;
                if (item.quantity <= 0) {
                    removeFromCart(productId);
                } else {
                    updateCartDisplay();
                }
            }
        }

        function removeFromCart(productId) {
            cart = cart.filter(item => item.id !== productId);
            updateCartDisplay();
        }

        function calculateTotal() {
            return cart.reduce((total, item) => total + (item.price * item.quantity), 0);
        }

        function updateCartDisplay() {
            if (cart.length === 0) {
                cartItems.innerHTML =
                    `<div class="empty-cart"><i data-lucide="shopping-cart"></i><p>Your cart is empty</p><p>Add some products to get started</p></div>`;
                checkoutBtn.disabled = true;
            } else {
                cartItems.innerHTML = '';
                cart.forEach(item => {
                    const cartItem = document.createElement('div');
                    cartItem.className = 'cart-item';
                    cartItem.innerHTML = `
                    <div class="cart-item-info">
                        <div class="cart-item-name">${item.name}</div>
                        <div class="cart-item-price">Rp${item.price.toLocaleString('id-ID')} × ${item.quantity}</div>
                    </div>
                    <div class="quantity-controls">
                        <button class="qty-btn" onclick="updateQuantity(${item.id}, -1)">-</button>
                        <span class="qty-display">${item.quantity}</span>
                        <button class="qty-btn" onclick="updateQuantity(${item.id}, 1)">+</button>
                    </div>
                    <button class="remove-btn" onclick="removeFromCart(${item.id})"><i data-lucide="x"></i></button>`;
                    cartItems.appendChild(cartItem);
                });
                checkoutBtn.disabled = false;
            }
            const total = calculateTotal();
            totalAmount.textContent = `Rp${total.toLocaleString('id-ID')}`;
            lucide.createIcons();
        }

        function handleCheckout() {
            if (cart.length === 0) return;

            const total = calculateTotal();
            const itemCount = cart.reduce((sum, item) => sum + item.quantity, 0);

            if (confirm(
                    `Konfirmasi checkout?\n\nTotal Item: ${itemCount}\nTotal Harga: Rp${total.toLocaleString('id-ID')}`)) {

                // Nonaktifkan tombol checkout untuk mencegah double-click
                checkoutBtn.disabled = true;
                checkoutBtn.textContent = 'Memproses...';

                // Mengambil CSRF token dari meta tag yang kita buat tadi
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                // Kirim data ke backend menggunakan Fetch API
                fetch("{{ route('kasir.checkout.store') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken // Sertakan token CSRF di header
                        },
                        body: JSON.stringify({
                            cart: cart
                        }) // Kirim data keranjang dalam format JSON
                    })
                    .then(response => response.json()) // Ubah response dari server menjadi object JSON
                    .then(data => {
                        if (data.success) {
                            // Jika backend merespon sukses
                            alert(`Transaksi berhasil!`);
                            // Reset keranjang setelah checkout berhasil
                            cart = [];
                            updateCartDisplay();
                        } else {
                            // Jika backend merespon error
                            alert(`Gagal menyimpan transaksi: ${data.message}`);
                        }
                    })
                    // .catch(error => {
                    //     // Jika terjadi error pada koneksi atau server
                    //     console.error('Error:', error);
                    //     alert('Tidak dapat terhubung ke server. Silakan coba lagi.');
                    // })
                    .finally(() => {
                        // Apapun hasilnya (sukses/gagal), kembalikan tombol checkout ke normal
                        checkoutBtn.disabled = false;
                        checkoutBtn.innerHTML = '<i data-lucide="credit-card"></i> Checkout';
                        lucide.createIcons(); // Render ulang icon
                    });
            }
        }

        searchInput.addEventListener('input', (e) => filterProducts(e.target.value));

        // Inisialisasi awal
        renderProducts();
        updateCartDisplay();
    </script>
@endpush
