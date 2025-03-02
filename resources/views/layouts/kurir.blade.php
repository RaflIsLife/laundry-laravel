<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - Dashboard</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../bootstrap-icons-1.8.1/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #ffffff;
            --secondary-color: #89CFF0;
            --accent-color: #1e90ff;
        }

        html {
        overflow-x: hidden;
    }

        body {
            background-color: #f8f9fa;
        }

        .sidebar {
            background: var(--primary-color);
            min-height: 100vh;
            box-shadow: 3px 0 10px rgba(0,0,0,0.1);
            position: fixed;
            width: 280px;
        }

        .main-content {
            margin-left: 280px;
            padding: 30px;
            min-height: 100vh;
            width: calc(100% - 280px); /* Tambahkan ini */
            box-sizing: border-box; /* Tambahkan ini */
        }
        .fixed-bottom {
        width: calc(100% - 280px);
        left: 280px;
        right: 0;
        padding-right: 30px; /* Sesuaikan dengan padding main content */
        box-sizing: border-box;
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
            color: var(--primary-color);
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
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
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
        <!-- Sidebar -->
        <div class="sidebar p-3">
            <div class="text-center mb-5">
                <a href="{{ route('home') }}">

                    <h3 class="fw-bold text-primary">Quick<span class="text-secondary">Wash</span></h3>
                </a>
            </div>

            <nav class="nav flex-column">
                <a class="nav-link" href="{{route('kurir')}}">
                    <i class="bi bi-house-door me-3"></i> Beranda
                </a>
                <a class="nav-link" href="{{ route('kurir.detail') }}">
                    <i class="bi bi-basket me-3"></i> Detail
                </a>
                <form method="POST" action=" {{ route('logout') }} ">
                    @csrf
                    <button type="submit" class="nav-link w-100 text-start">
                        <i class="bi bi-box-arrow-right me-3"></i> Keluar
                    </button>
                </form>
            </nav>
        </div>

        <!-- Main Content -->
        @yield('content')
    </div>

    <script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>
