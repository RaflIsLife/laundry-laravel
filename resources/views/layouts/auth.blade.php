<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - @yield('title')</title>


    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <style>
        .auth-card {
            border: 0;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            border-radius: 1rem;
        }

        .auth-form input {
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
        }

        #map {
            height: 180px;
        }
    </style>
</head>
@include('template.navbar')

<body class="bg-light"
    style="background: linear-gradient(55deg, white, blue);
 background-repeat: no-repeat; background-size: cover; background-position: center;">
    <div class="container">
        <div class="row justify-content-center min-vh-100 align-items-center">
            <div class="col-md-8 col-lg-6 ">
                @yield('content')
            </div>
        </div>
    </div>


    <script src="../js/bootstrap.bundle.min.js"></script>
    {{-- <script>
        var map = L.map('map').setView([-6.934930, 106.925816], 15);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        var popup = L.popup

        function onMapClick(e) {
           popup
           .setLatLng(e.latlng)
        .setContent(L.marker(e.latlng).addTo(map))
        .openOn(map);
        }

        map.on('click', onMapClick);
    </script> --}}
</body>

</html>
