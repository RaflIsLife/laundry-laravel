@extends('layouts.user')

@section('content')
    <div class="container-fluid p-0">
        <div class="main-content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold mb-1">Profil Pengguna</h2>
                    <p class="text-muted">Kelola informasi profil Anda</p>
                </div>
            </div>

            <div class="">
                <div class="card border-0 shadow-sm">
                    @if (Session::has('status'))
                        <div> <span style="color: red">{{ Session::get('status') }}</span> </div>
                    @endif
                    <form action="{{ route('profile.update') }}" method='POST'>
                        @csrf
                        <div class="mb-4">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                value="{{ old('name', Auth::user()->name) }}" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ Auth::user()->email }}">
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Nomor Telepon</label>
                            <input type="tel" class="form-control @error('phone') is-invalid @enderror" name="phone"
                                value="{{ old('phone', Auth::user()->phone) }}" pattern="[0-9]{9,13}" required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                        </div>

                        <div class="mb-4">
                            <label class="form-label">Alamat</label>
                            <div id="map" class="" style="height: 400px"></div>
                            <input type="hidden" id="latitude" name="latitude"
                                value="{{ explode(',', Auth::user()->coordinate)[0] }}">
                            <input type="hidden" id="longitude" name="longitude"
                                value="{{ explode(',', Auth::user()->coordinate)[1] }}">
                            <input type="hidden" id="address" name="address" value="{{ Auth::user()->address }}">
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary px-5">
                                <i class="bi bi-save me-2"></i>Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .avatar-wrapper {
            position: relative;
            display: inline-block;
        }

        .avatar-upload {
            position: absolute;
            bottom: 10px;
            right: 10px;
            border-radius: 50%;
            padding: 8px;
            width: 36px;
            height: 36px;
        }

        .form-control:disabled {
            background-color: #f8f9fa;
            opacity: 1;
        }

        .input-group-text {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
            color: var(--accent-color);
        }
    </style>

    <script>
        var lat = {{ explode(',', Auth::user()->coordinate)[0] }};
        var lng = {{ explode(',', Auth::user()->coordinate)[1] }};

        var map = L.map('map').setView([lat, lng], 17);

        var Stadia_OSMBright = L.tileLayer('https://tiles.stadiamaps.com/tiles/osm_bright/{z}/{x}/{y}{r}.{ext}', {
            minZoom: 0,
            maxZoom: 20,
            attribution: '&copy; <a href="https://www.stadiamaps.com/" target="_blank">Stadia Maps</a> &copy; <a href="https://openmaptiles.org/" target="_blank">OpenMapTiles</a> &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            ext: 'png'
        }).addTo(map);

        var marker = L.marker([lat, lng], {
            draggable: true
        }).addTo(map)

        const myAPIKey = '{{ env('GEOAPIFY_API_KEY') }}';
        function address(newLat, newLng) {
            const reverseGeocodeUrl =
                `https://api.geoapify.com/v1/geocode/reverse?lat=${newLat}&lon=${newLng}&type=amenity&lang=id&format=json&apiKey=${myAPIKey}`;

            fetch(reverseGeocodeUrl)
                .then(response => response.json())
                .then(result => {
                    const address = result.results[0].formatted;
                    document.getElementById('address').value = address;
                })
                .catch(error => console.log('error', error));
        }

        marker.on('dragend', function(e) {
            var position = marker.getLatLng();
            var newLat = position.lat;
            var newLng = position.lng;

            address(newLat, newLng);
            document.getElementById('latitude').value = newLat;
            document.getElementById('longitude').value = newLng;
        });

        map.on('click', function(e) {
            var newLat = e.latlng.lat;
            var newLng = e.latlng.lng;

            marker.setLatLng([newLat, newLng])

            address(newLat, newLng);
            document.getElementById('latitude').value = newLat;
            document.getElementById('longitude').value = newLng;
        });
    </script>
@endsection
