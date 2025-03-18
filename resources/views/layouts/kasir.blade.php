<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir Dashboard - Laundry</title>
    <link href="../../../css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../bootstrap-icons-1.8.1/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <style>
        .order-status {
            font-size: 0.8rem;
            padding: 5px 10px;
            border-radius: 20px;
        }

        :root {
            --primary-color: #ffffff;
            --secondary-color: #89CFF0;
            --accent-color: #1e90ff;
        }

        body {
            background-color: #f8f9fa;
        }

        .sidebar {
            background: var(--primary-color);
            min-height: 100vh;
            box-shadow: 3px 0 10px rgba(0, 0, 0, 0.1);
            position: fixed;
            width: 280px;
        }

        .main-content {
            margin-left: 280px;
            padding: 30px;
            min-height: 100vh;
        }

        .nav-link {
            color: #495057;
            padding: 12px 20px;
            border-radius: 8px;
            margin: 8px 0;
            transition: all 0.3s;
        }

        .nav-link:hover {
            background: var(--secondary-color);
            color: var(--accent-color);
        }

        .nav-link.active {
            background: var(--secondary-color);
            color: var(--accent-color);
            font-weight: 500;
        }

        .order-card {
            background: white;
            border: none;
            border-radius: 15px;
            transition: transform 0.2s;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .order-card:hover {
            transform: translateY(-3px);
        }

        .status-badge {
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
        }

        .badge-processing {
            background: #e3f2fd;
            color: #2196f3;
        }

        .badge-waiting {
            background: #fff3e0;
            color: #ff9800;
        }

        .order-icon {
            width: 50px;
            height: 50px;
            background: var(--secondary-color);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .hidden {
            visibility: hidden;
            opacity: 0;
            height: 0;
            overflow: hidden;
            transition: opacity 0.3s ease, height 0.3s ease;
        }

        .visible {
            visibility: visible;
            opacity: 1;
            height: auto;
        }
    </style>
</head>

<body>
    <div class="container-fluid p-0">
        <div class="sidebar p-3 navbar-expand">
            <div class="text-center mb-5">
                <a href="{{ route('home') }}">
                    <h3 class="fw-bold text-primary">Quick<span class="text-secondary">Wash</span></h3>
                </a>
            </div>
            <nav class="nav flex-column">
                <a class="nav-link" href="{{ route('kasir') }}">
                    <i class="bi bi-house-door me-3"></i>Buat Pesanan Baru
                </a>
                <a class="nav-link" href="{{ route('kasir.transaksi') }}">
                    <i class="bi bi-people me-3"></i> Pesanan Berlangsung
                </a>
                <a class="nav-link" href="{{ route('kasir.history') }}">
                    <i class="bi bi-clock-history me-3"></i> History
                </a>
                <hr>
                <form method="POST" action="{{ route('logout') }} ">
                    @csrf
                    <button type="submit" class="nav-link w-100 text-start">
                        <i class="bi bi-box-arrow-right me-3"></i> Keluar
                    </button>
                </form>
            </nav>
        </div>
        @yield('content')
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script src="../../../js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>

    <script>
        new DataTable('#dataTables');
    </script>
</body>

</html>
