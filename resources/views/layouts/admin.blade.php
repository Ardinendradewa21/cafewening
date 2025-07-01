<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - Cafe Cangkir Wening</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdnjs.cloudflare.com/ajax/libs/lucide/0.263.1/umd/lucide.js"></script>
    {{-- CSS yang sama seperti sebelumnya, ditambah style logout yang dipindah --}}
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #962d2d 0%, #962d2d 100%);
            min-height: 100vh;
        }

        .app-container {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 280px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-right: 1px solid rgba(255, 255, 255, 0.2);
            padding: 2rem 0;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
        }

        .sidebar-header {
            padding: 0 2rem 2rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        .sidebar-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 0.5rem;
        }

        .sidebar-subtitle {
            font-size: 0.875rem;
            color: #718096;
        }

        .nav-menu {
            list-style: none;
            padding: 0;
        }

        .nav-item {
            margin-bottom: 0.5rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 1rem 2rem;
            color: #4a5568;
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }

        .nav-link:hover {
            background: rgba(102, 126, 234, 0.1);
            border-left-color: #962d2d;
            color: #962d2d;
        }

        .nav-link.active {
            background: rgba(102, 126, 234, 0.15);
            border-left-color: #962d2d;
            color: #962d2d;
            font-weight: 600;
        }

        .nav-link i {
            margin-right: 1rem;
            width: 20px;
            height: 20px;
        }

        .main-content {
            flex: 1;
            padding: 2rem;
            overflow-y: auto;
        }

        .main-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 1.5rem 2rem;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .page-title {
            font-size: 2rem;
            font-weight: 700;
            color: #2d3748;
            flex: 1;
        }

        .sidebar-footer {
            margin-top: auto;
            padding: 2rem;
            padding-top: 1rem;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
        }

        .logout-btn {
            display: flex;
            width: 100%;
            align-items: center;
            justify-content: center;
            padding: 0.75rem 1.5rem;
            background: linear-gradient(135deg, #ff6b6b, #ee5a24);
            color: white;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .logout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(238, 90, 36, 0.3);
        }

        .logout-btn i {
            margin-right: 0.5rem;
        }
    </style>
    @stack('styles')
</head>

<body>
    <div class="app-container">
        <nav class="sidebar">
            <div>
                <div class="sidebar-header">
                    <h1 class="sidebar-title">Cafe Cangkir Wening</h1>
                    <p class="sidebar-subtitle">Admin Panel</p>
                </div>

                {{-- Link navigasi yang sudah diperbaiki --}}
                <ul class="nav-menu">
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}"
                            class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i data-lucide="layout-dashboard"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.produk.index') }}"
                            class="nav-link {{ request()->routeIs('admin.produk.*') ? 'active' : '' }}">
                            <i data-lucide="package"></i> Produk
                        </a>
                    </li>
                    <li class="nav-item">
                        {{-- Nonaktifkan sementara sampai halamannya dibuat --}}
                        <a href="{{ route('admin.inventory.index') }}"
                            class="nav-link {{ request()->routeIs('admin.inventory.index') ? 'active' : '' }}">
                            <i data-lucide="clipboard-list"></i> Inventory
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.pesanan.index') }}"
                            class="nav-link {{ request()->routeIs('admin.pesanan.index') ? 'active' : '' }}">
                            <i data-lucide="shopping-bag"></i> Pesanan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.laporan.index') }}"
                            class="nav-link {{ request()->routeIs('admin.laporan.index') ? 'active' : '' }}">
                            <i data-lucide="bar-chart-3"></i> Laporan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.users.index') }}"
                            class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                            <i data-lucide="users"></i> Pengguna
                        </a>
                    </li>
                </ul>
            </div>
            {{-- [PERUBAHAN] Tombol logout sekarang ada di sini --}}
            <div class="sidebar-footer">
                {{-- Form ini mengirimkan permintaan POST ke route logout --}}
                <form id="logout-form-admin" method="POST" action="{{ route('logout') }}" style="display: none;">
                    @csrf
                </form>

                {{-- Tombol ini men-trigger submit form di atas, bukan link biasa --}}
                <button class="logout-btn"
                    onclick="event.preventDefault(); document.getElementById('logout-form-admin').submit();">
                    <i data-lucide="log-out"></i>
                    <span>Sign Out</span>
                </button>
            </div>
        </nav>
        <main class="main-content">
            <header class="main-header">
                <h1 class="page-title">@yield('title')</h1>
            </header>
            @yield('content')
        </main>
    </div>
    <script>
        // Inisialisasi icon setelah halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            lucide.createIcons();
        });
    </script>
    @stack('scripts')
</body>

</html>
