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
    style="background: linear-gradient(55deg, white, blue); background-repeat: no-repeat; background-size: cover; background-position: center;">
    <div class="container">
        <div class="row justify-content-center min-vh-100 align-items-center">
            <div class="col-md-8 col-lg-6 ">
                @yield('content')
            </div>
        </div>
    </div>


    <script src="../js/bootstrap.bundle.min.js"></script>
    <script>
        var map = L.map('map').setView([-6.934930, 106.925816], 17);

        var Stadia_OSMBright = L.tileLayer('https://tiles.stadiamaps.com/tiles/osm_bright/{z}/{x}/{y}{r}.{ext}', {
            minZoom: 0,
            maxZoom: 20,
            attribution: '&copy; <a href="https://www.stadiamaps.com/" target="_blank">Stadia Maps</a> &copy; <a href="https://openmaptiles.org/" target="_blank">OpenMapTiles</a> &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            ext: 'png'
        }).addTo(map);

        var markers = [];
        const myAPIKey = '{{ env('GEOAPIFY_API_KEY') }}';

        map.on('click', function(e) {
            var lat = e.latlng.lat;
            var lng = e.latlng.lng;
            
            markers.forEach(marker => map.removeLayer(marker));
            markers = [];
            
            const reverseGeocodeUrl =
                `https://api.geoapify.com/v1/geocode/reverse?lat=${lat}&lon=${lng}&type=amenity&lang=id&format=json&apiKey=${myAPIKey}`;
            fetch(reverseGeocodeUrl)
                .then(response => response.json())
                .then(result => {
                    const address = result.results[0].formatted;
                    document.getElementById('address').value = address;

                })
                .catch(error => console.log('error', error));
            var marker = L.marker([lat, lng]).addTo(map);
            markers.push(marker);

            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;
        })
    </script>

</body>

</html>
