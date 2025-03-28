@extends('layouts.user')

@section('content')
    <div class="container-fluid p-0">
        <div class="main-content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold mb-1">Pesanan Baru</h2>
                    <p class="text-muted">Isi form berikut untuk membuat pesanan baru</p>
                </div>
            </div>

            <form action="{{ route('pesananBaru.post') }}" method="POST">
                @csrf
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
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
                                        <label class="form-label">Akumulasi Harga</label>
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
                            <i class="bi bi-plus-lg me-2"></i>Tambah Pesanan
                        </button>

                        <div class="row mt-3">
                            <input class="form-control" name="ongkir" type="hidden" id="ongkir" value="0">
                            <div class="col text-end">
                                <h5>SubTotal: <span id="total-harga-layanan">0</span></h5>
                                <h5>Total Ongkir: <span id="ongkirView">0</span></h5>
                                <h5>Total Keseluruhan: <span id="total-keseluruhan">0</span></h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">Cara Bayar</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment_method" id="qris"
                                        value="qris" required>
                                    <label class="form-check-label" for="qris">
                                        <i class="bi bi-qr-code me-2"></i> Bayar sekarang (Online)
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment_method" id="cod"
                                        value="cod">
                                    <label class="form-check-label" for="cod">
                                        <i class="bi bi-cash-coin me-2"></i> Bayar di Kurir (COD)
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-end" id="submitPlacement">
                    <button type="submit" class="btn btn-primary px-5" id="submit">
                        <i class="bi bi-check2-circle me-2"></i>Buat Pesanan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
    <script>
        $(document).ready(function() {

            
            const addressUser = '{{ Auth::user()->coordinate }}';
            const addressCompany = '{{ $companyProfile->coordinate }}';

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
                // ceil = membulatkan desimalk yang terdekat
                var ongkir = Math.ceil(jarak / 100) * 200 * 2;

                document.getElementById('ongkir').value = parseInt(ongkir);
            });

            let nomorItem = 1;

            function formatRupiah(angka) {
                return 'Rp ' + angka.toLocaleString('id-ID');
            }

            // Fungsi untuk menghitung subtotal tiap item dan total keseluruhan
            function updatePrices() {
                let total = 0;
                let totalHargaLayanan = 0;
                $('.item-pesanan').each(function() {
                    let quantity = parseFloat($(this).find('.quantity').val());
                    if (isNaN(quantity)) {
                        quantity = 0;
                    }

                    // Ambil unit (pcs atau kg)
                    let unit = $(this).find('.pilih-satuan').val();

                    // Ambil data harga dari option yg dipilih
                    let serviceSelected = $(this).find('.jenis-layanan option:selected');
                    let hargaPcs = parseFloat(serviceSelected.data('harga-pcs')) || 0;
                    let hargaKg = parseFloat(serviceSelected.data('harga-kg')) || 0;

                    // Pilih harga sesuai unit
                    let harga = (unit === 'pcs') ? hargaPcs : hargaKg;

                    // Hitung subtotal
                    let subtotal = quantity * harga;

                    // Tampilkan di input akumulasi-harga
                    $(this).find('.akumulasi-harga').val(formatRupiah(subtotal));

                    // Tambahkan ke total
                    total += subtotal;
                });
                totalHargaLayanan = total;
                total += parseInt(ongkir.value);

                $('#total-harga-layanan').text(formatRupiah(totalHargaLayanan));
                $('#ongkirView').text(formatRupiah(parseInt(ongkir.value)));
                $('#total-keseluruhan').text(formatRupiah(total));
            }

            // Saat tombol "Tambah Pesanan" diklik
            $('#tambah-item').click(function() {
                const itemBaru = $('.item-pesanan:first').clone();

                // Ganti name index [0] -> [nomorItem]
                $(itemBaru).find('input, select').each(function() {
                    if ($(this).attr('name')) {
                        const namaLama = $(this).attr('name');
                        const namaBaru = namaLama.replace('[0]', '[' + nomorItem + ']');
                        $(this).attr('name', namaBaru).val('');
                    }
                });

                // Tampilkan tombol hapus
                $(itemBaru).find('.hapus-item').show();

                // Reset akumulasi harga jadi Rp 0
                $(itemBaru).find('.akumulasi-harga').val('Rp 0');

                // Masukkan item pesanan baru ke container
                $('#daftar-pesanan').append(itemBaru);

                nomorItem++;
                updatePrices();
            });

            // Hapus item pesanan
            $(document).on('click', '.hapus-item', function() {
                if ($('.item-pesanan').length > 1) {
                    $(this).closest('.item-pesanan').remove();
                    updatePrices();
                }
            });

            // Jika unit pcs/kg berubah, atur step & min, lalu update harga
            $(document).on('change', '.pilih-satuan', function() {
                let inputJumlah = $(this).closest('.item-pesanan').find('.quantity');
                if ($(this).val() === 'pcs') {
                    inputJumlah.attr('step', '1').attr('min', '1');
                } else {
                    inputJumlah.attr('step', '0.1').attr('min', '0.1');
                }
                updatePrices();
            });

            // Jika jenis layanan berubah, tetap panggil updatePrices
            $(document).on('change', '.jenis-layanan', function() {
                updatePrices();
            });

            // Jika quantity berubah
            $(document).on('input', '.quantity', function() {
                updatePrices();
            });
        });
    </script>
@endpush
