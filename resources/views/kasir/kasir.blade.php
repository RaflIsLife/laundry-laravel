@extends('layouts.kasir')

@section('content')
    <div class="container-fluid p-0">
        <div class="main-content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold mb-1">Transaksi Baru</h2>
                    <p class="text-muted">Isi form berikut untuk membuat transaksi baru</p>
                    @if (Session::has('status'))
                        <div>
                            <span style="color: red">{{ Session::get('status') }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <form action="{{ route('postKasir') }}" method="POST">
                @csrf
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="row mb-5">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama Pelanggan</label>
                                    <input type="text" id="name"class="form-control" name="name"
                                        autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nohp" class="form-label">Nomor WhatsApp</label>
                                    <input type="tel" id="phone" class="form-control" name="phone"
                                        autocomplete="off" required>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="tambah-alamat" name="pengantaran"
                                        value="ya">
                                    <label class="form-check-label" for="tambah-alamat">
                                        Antar Pesanan Setelah Selesai
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div id="alamat-container" class="hidden">
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        {{-- <label class="form-label">Cari Alamat</label>
                                        <input type="text" class="form-control" id="search-alamat"
                                            name="alamat_pengambilan"> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div id="map"
                                        style="height: 300px; background-color: #e9ecef; display: flex; align-items: center; justify-content: center; border-radius: 8px;">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <input type="hidden" id="latitude" name="latitude">
                            <input type="hidden" id="longitude" name="longitude">
                        </div>
                        <div id="daftar-pesanan">
                            <div class="item-pesanan mb-4">
                                <div class="row g-3">
                                    <div class="col-md-5">
                                        <label class="form-label">Jenis Layanan</label>
                                        <select class="form-select jenis-layanan" name="services[0][service_id]" required>
                                            @foreach ($layanan as $item)
                                                <option value="{{ $item->id }}" data-harga-pcs="{{ $item->harga_pcs }}"
                                                    data-harga-kg="{{ $item->harga_kg }}">
                                                    {{ $item->nama_layanan }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label">Jumlah</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control quantity" name="services[0][quantity]"
                                                step="1" min="1" required>
                                            <select class="form-select pilih-satuan" name="services[0][unit]"
                                                style="max-width: 90px">
                                                <option value="pcs">pcs</option>
                                                <option value="kg">kg</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label">Subtotal</label>
                                        <input type="text" class="form-control akumulasi-harga" readonly value="0">
                                    </div>

                                    <div class="col-md-1 align-self-end">
                                        <button type="button" class="btn btn-danger btn-sm hapus-item"
                                            style="display: none">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="button" class="btn btn-secondary btn-sm" id="tambah-item">
                            <i class="bi bi-plus-lg me-2"></i>Tambah Layanan
                        </button>

                        <div class="row mt-3">
                            <div class="col text-end">
                                <input type="hidden" id="ongkir" name="ongkir" value="0">
                                <div id="hargaView" class="hidden">
                                    <h5>Total Harga: <span id="total-hargaView">0</span></h5>
                                    <h5>Ongkir: <span id="ongkirView">0</span></h5>
                                </div>
                                <h5>Total Keseluruhan: <span id="total-keseluruhan">0</span></h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">Pembayaran</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Metode Pembayaran</label>
                                    <select class="form-select" name="pembayaran">
                                        <option value="qris">QRIS</option>
                                        <option value="cod">Cash</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Status Pembayaran</label>
                                    <select class="form-select" name="status_pembayaran">
                                        <option value="lunas">Lunas</option>
                                        <option value="proses">Belum Dibayar</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary px-5">
                        <i class="bi bi-check2-circle me-2"></i>Simpan Transaksi
                    </button>
                </div>
            </form>
        </div>
    </div>
    {{-- todo: buat auto complete untuk coordinate pada map --}}
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- jQuery UI JS -->
    <script src="../../../js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            let nomorItem = 1;

            function formatRupiah(angka) {
                return 'Rp ' + angka.toLocaleString('id-ID');
            }

            $(function() {
                // Terapkan autocomplete ke kedua input
                $("#name, #phone").autocomplete({
                        source: function(request, response) {
                            $.ajax({
                                url: "{{ route('autocomplete') }}",
                                dataType: "json",
                                data: {
                                    term: request.term
                                },
                                success: function(data) {
                                    response(data);
                                }
                            });
                        },
                        minLength: 1,
                        select: function(event, ui) {
                            // Isi kedua input saat salah satu opsi dipilih
                            $("#name").val(ui.item.name);
                            $("#phone").val(ui.item.phone);
                            $("#coordinate").val(ui.item.coordinate);
                            return false;
                        }
                    })
                    // Kustomisasi tampilan dropdown
                    .autocomplete("instance")._renderItem = function(ul, item) {
                        return $("<li>")
                            .append("<div>" + item.label + "</div>")
                            .appendTo(ul);
                    };
            });

            $('#tambah-alamat').change(function() {
                const container = $('#alamat-container');
                const viewHarga = $('#hargaView');
                if ($(this).is(':checked')) {
                    container.removeClass('hidden').addClass('visible');
                    viewHarga.removeClass('hidden').addClass('visible');

                    // Inisialisasi ulang map setelah container terlihat
                    setTimeout(() => {
                        map.invalidateSize();
                    }, 300); // Sesuaikan timeout dengan durasi transisi CSS
                } else {
                    container.removeClass('visible').addClass('hidden');
                    viewHarga.removeClass('visible').addClass('hidden');
                }
            });

            var map = L.map('map').setView([-6.934930, 106.925816], 17);

            var Stadia_OSMBright = L.tileLayer(
                'https://tiles.stadiamaps.com/tiles/osm_bright/{z}/{x}/{y}{r}.{ext}', {
                    minZoom: 0,
                    maxZoom: 20,
                    attribution: '&copy; <a href="https://www.stadiamaps.com/" target="_blank">Stadia Maps</a> &copy; <a href="https://openmaptiles.org/" target="_blank">OpenMapTiles</a> &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                    ext: 'png'
                }).addTo(map);

            var markers = [];
            var ongkirInt = 0;
            map.on('click', function(e) {
                var lat = e.latlng.lat;
                var lng = e.latlng.lng;
                const addressUser = `${lat},${lng}`;
                const addressCompany = '{{ $companyProfile->address }}';

                markers.forEach(marker => map.removeLayer(marker));
                markers = [];

                var marker = L.marker([lat, lng]).addTo(map);
                markers.push(marker);

                document.getElementById('latitude').value = lat;
                document.getElementById('longitude').value = lng;
                var jarak = 0;

                var requestOptions = {
                    method: 'GET',
                };
                const myAPIKey = '{{ env('GEOAPIFY_API_KEY') }}';
                const url =
                    `https://api.geoapify.com/v1/routing?waypoints=${addressCompany}|${addressUser}&mode=motorcycle&details=instruction_details&apiKey=${myAPIKey}`;

                async function getDistance() {
                    try {
                        const response = await fetch(url);
                        const result = await response.json();
                        const jarak = result.features[0].properties.distance;
                        return jarak;
                    } catch (error) {
                        console.log('error', error);
                    }
                }

                getDistance().then(jarak => {
                    // 100 meter = 200 perak
                    // ceil = membulatkan desimal ke yang terdekat
                    var ongkir = Math.ceil(jarak / 100) * 200;
                    ongkirInt = ongkir;

                    $('#ongkirView').text(formatRupiah(parseInt(ongkirInt)));
                    document.getElementById('ongkir').value = parseInt(ongkir);

                });
            });




            function updatePrices() {
                let total = 0;
                $('.item-pesanan').each(function() {
                    let quantity = parseFloat($(this).find('.quantity').val()) || 0;
                    if (isNaN(quantity)) {
                        quantity = 0;
                    }
                    let unit = $(this).find('.pilih-satuan').val();
                    let serviceSelected = $(this).find('.jenis-layanan option:selected');
                    let hargaPcs = parseFloat(serviceSelected.data('harga-pcs')) || 0;
                    let hargaKg = parseFloat(serviceSelected.data('harga-kg')) || 0;

                    let harga = unit === 'pcs' ?
                        hargaPcs :
                        hargaKg;

                    let subtotal = quantity * harga;

                    $(this).find('.akumulasi-harga').val(formatRupiah(subtotal));
                    total += subtotal;
                });
                $('#total-hargaView').text(formatRupiah(total));
                $('#total-keseluruhan').text(formatRupiah(total + ongkirInt));
            }

            $('#tambah-item').click(function() {
                const itemBaru = $('.item-pesanan:first').clone();

                $(itemBaru).find('input, select').each(function() {
                    const name = $(this).attr('name')?.replace('[0]', '[' + nomorItem + ']');
                    if (name) $(this).attr('name', name).val('');
                });

                $(itemBaru).find('.hapus-item').show();
                $(itemBaru).find('.akumulasi-harga').val('0');

                $('#daftar-pesanan').append(itemBaru);
                nomorItem++;
                updatePrices();
            });

            $(document).on('click', '.hapus-item', function() {
                if ($('.item-pesanan').length > 1) {
                    $(this).closest('.item-pesanan').remove();
                    updatePrices();
                }
            });

            $(document).on('change input', '.pilih-satuan, .jenis-layanan, .quantity', function() {
                if ($(this).hasClass('pilih-satuan')) {
                    const input = $(this).closest('.item-pesanan').find('.quantity');
                    const step = $(this).val() === 'kg' ? '0.1' : '1';
                    input.attr('step', step).attr('min', step);
                }
                updatePrices();
            });
        });
    </script>
@endsection
