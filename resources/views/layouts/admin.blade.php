<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Laundry</title>
    <link href="../../../css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="../../../bootstrap-icons-1.8.1/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.css">
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
                <a class="nav-link" href="{{ route('admin.home') }}">
                    <i class="bi bi-house-door me-3"></i> Dashboard
                </a>
                <a class="nav-link" href="{{ route('admin.akun') }}">
                    <i class="bi bi-people me-3"></i> Akun
                </a>
                <a class="nav-link" href="{{ route('admin.layanan') }}">
                    <i class="bi bi-list me-3"></i> Layanan
                </a>
                <a class="nav-link" href="{{ route('admin.history') }}">
                    <i class="bi bi-clock-history me-3"></i> Riwayat
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

    <script src="../../../js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>

    <script>
        new DataTable('#dataTables');
    </script>
</body>

</html>
