<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dapur - Kitchen Display</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            background-color: #f3f4f6;
        }

        .kanban-board {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            height: calc(100vh - 100px);
        }

        .kanban-column {
            background-color: #e5e7eb;
            padding: 1rem;
            border-radius: 12px;
        }

        .kanban-column-title {
            font-size: 1.25rem;
            font-weight: bold;
            padding: 0.5rem;
            margin-bottom: 1rem;
        }

        .kanban-cards {
            height: 100%;
            overflow-y: auto;
            padding-right: 8px;
        }

        .order-card {
            background-color: white;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-left: 5px solid;
        }

        .order-card.status-baru {
            border-color: #3b82f6;
        }

        .order-card.status-diproses {
            border-color: #f59e0b;
        }

        .order-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .order-code {
            font-weight: bold;
        }

        .order-time {
            font-size: 0.875rem;
            color: #6b7280;
        }

        .order-items ul {
            list-style-position: inside;
            padding-left: 5px;
        }

        .order-actions {
            margin-top: 1rem;
            text-align: right;
        }

        .btn-action {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 6px;
            color: white;
            cursor: pointer;
            font-weight: 500;
        }

        .btn-proses {
            background-color: #f59e0b;
        }

        .btn-selesai {
            background-color: #10b981;
        }
    </style>
</head>

<body>
    <header class="bg-white shadow-md p-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold">Kitchen Display System</h1>
        {{-- BAGIAN INI MENAMPILKAN NAMA PENGGUNA DAN TOMBOL LOGOUT --}}
    <div class="flex items-center gap-4">
        <span class="font-medium">{{ Auth::user()->name }}</span>

        {{-- Form ini akan menangani proses logout --}}
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md transition-colors">
                Logout
            </button>
        </form>
    </div>
    </header>

    <main class="p-6">
        <div class="kanban-board">
            <div class="kanban-column">
                <h2 class="kanban-column-title">Pesanan Baru</h2>
                <div class="kanban-cards" id="col-baru"></div>
            </div>
            <div class="kanban-column">
                <h2 class="kanban-column-title">Sedang Dibuat</h2>
                <div class="kanban-cards" id="col-diproses"></div>
            </div>
            <div class="kanban-column">
                <h2 class="kanban-column-title">Selesai</h2>
                <div class="kanban-cards" id="col-selesai"></div>
            </div>
        </div>
    </main>

    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Fungsi untuk membuat kartu pesanan
        function createOrderCard(order) {
            let itemsHtml = '<ul>';
            order.details.forEach(item => {
                itemsHtml += `<li>${item.quantity}x ${item.product_name}</li>`;
            });
            itemsHtml += '</ul>';

            let actionButton = '';
            if (order.status === 'baru') {
                actionButton =
                    `<button class="btn-action btn-proses" onclick="updateStatus(${order.id}, 'diproses')">Mulai Buat</button>`;
            } else if (order.status === 'diproses') {
                actionButton =
                    `<button class="btn-action btn-selesai" onclick="updateStatus(${order.id}, 'selesai')">Selesaikan</button>`;
            }

            const card = document.createElement('div');
            card.id = `order-${order.id}`;
            card.className = `order-card status-${order.status}`;
            card.innerHTML = `
                <div class="order-card-header">
                    <span class="order-code">${order.transaction_code}</span>
                    <span class="order-time">${new Date(order.created_at).toLocaleTimeString('id-ID')}</span>
                </div>
                <div class="order-items">${itemsHtml}</div>
                <div class="order-actions">${actionButton}</div>
            `;
            return card;
        }

        // Fungsi untuk merender semua pesanan ke kolom yang benar
        function renderOrders(orders) {
            // Kosongkan semua kolom
            document.getElementById('col-baru').innerHTML = '';
            document.getElementById('col-diproses').innerHTML = '';
            document.getElementById('col-selesai').innerHTML = '';

            orders.forEach(order => {
                const card = createOrderCard(order);
                document.getElementById(`col-${order.status}`).appendChild(card);
            });
        }

        // Fungsi untuk mengambil data pesanan dari server
        async function fetchOrders() {
            try {
                const response = await fetch('/api/dapur/orders');
                const orders = await response.json();
                renderOrders(orders);
            } catch (error) {
                console.error('Gagal mengambil data pesanan:', error);
            }
        }

        // Fungsi untuk mengupdate status pesanan
        async function updateStatus(orderId, newStatus) {
            try {
                const response = await fetch(`/api/dapur/orders/${orderId}/update-status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        status: newStatus
                    })
                });
                const result = await response.json();
                if (result.success) {
                    // Ambil ulang data untuk merefresh tampilan
                    fetchOrders();
                } else {
                    alert('Gagal mengupdate status.');
                }
            } catch (error) {
                console.error('Error saat update status:', error);
            }
        }

        // Polling: panggil fetchOrders setiap 10 detik
        setInterval(fetchOrders, 10000);

        // Panggil sekali saat halaman pertama kali dimuat
        fetchOrders();
    </script>
</body>

</html>
