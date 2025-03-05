<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Bootstrap CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hero-section {
            background: url('/images/Laundry_homeNew.jpg') no-repeat center center/cover;
        }

        h1,
        h2 {
            font-family: 'Times New Roman', Times, serif
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
        }
    </style>
</head>

<body>
    @include('template.navbar')

    <main>
        @yield('content')
    </main>

    <script src="../js/bootstrap.bundle.min.js"></script>
</body>

</html>
