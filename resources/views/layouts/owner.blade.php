<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laundry') }}</title>
    <!-- Bootstrap CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <!-- Link untuk stylesheets lainnya -->
    <link rel="stylesheet" href="../../../bootstrap-icons-1.8.1/bootstrap-icons.css">

    <style>
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
            padding: 20px;
        }

        .sidebar .nav-link {
            color: #495057;
            padding: 12px 20px;
            border-radius: 8px;
            margin: 8px 0;
            transition: all 0.3s;
        }

        .sidebar .nav-link:hover {
            background: var(--secondary-color);
            color: var(--accent-color);
        }

        .sidebar .nav-link.active {
            background: var(--secondary-color);
            color: var(--accent-color);
            font-weight: 500;
        }

        .main-content {
            margin-left: 280px;
            padding: 30px;
            min-height: 100vh;
        }

        .hero-section {
            background: url('/images/Laundry_homeNew.jpg') no-repeat center center/cover;
        }

        h1,
        h2 {
            font-family: 'Times New Roman', Times, serif;
        }

        .hover-card-blue {
            transition: all 0.3s ease;
        }

        .hover-card-blue:hover {
            background-color: #007bff;
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .display-3 {
            font-size: 4rem;
            line-height: 1.1;
        }

        @media (max-width: 768px) {
            .display-3 {
                font-size: 2.5rem;
            }

            .hero-section {
                height: auto;
                padding: 100px 0;
            }

            .sidebar {
                position: static;
                width: 100%;
                box-shadow: none;
            }

            .main-content {
                margin-left: 0;
                padding: 15px;
            }
        }
    </style>
</head>

<body>
    <div class="container-fluid p-0">
        <!-- Sidebar for the Owner layout -->
        <div class="sidebar">
            <div class="text-center mb-5">
                <a href="{{ route('home') }}">
                    <h3 class="fw-bold text-primary">Quick<span class="text-secondary">Wash</span></h3>
                </a>
            </div>

            <nav class="nav flex-column">
                <a class="nav-link" href="{{ route('owner') }}">
                    <i class="bi bi-house-door me-3"></i> Dashboard
                </a>
                <a class="nav-link" href="{{ route('owner') }}">
                    <i class="bi bi-person me-3"></i> Customers
                </a>
                <a class="nav-link" href="{{ route('owner') }}">
                    <i class="bi bi-file-earmark-text me-3"></i> Reports
                </a>
                <hr>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="nav-link w-100 text-start">
                        <i class="bi bi-box-arrow-right me-3"></i> Logout
                    </button>
                </form>
            </nav>
        </div>
        @yield('content')
    </div>


    <!-- Bootstrap JS -->
    <script src="../js/bootstrap.bundle.min.js"></script>
</body>

</html>
