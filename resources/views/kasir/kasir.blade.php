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
                                    <label class="form-label">Nama Pelanggan</label>
                                    <input type="text" class="form-control" name="customer_name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nomor WhatsApp</label>
                                    <input type="tel" class="form-control" name="customer_phone" required>
                                </div>
                            </div>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            let nomorItem = 1;

            function formatRupiah(angka) {
                return 'Rp ' + angka.toLocaleString('id-ID');
            }

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

                $('#total-keseluruhan').text(formatRupiah(total));
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
