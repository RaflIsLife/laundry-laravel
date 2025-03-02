@extends('layouts.kurir') @section('content')
    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
            <div>
                <h1 class="h2">Detail Pengantaran</h1>
            </div>
        </div>

        <!-- Map & Address Section -->
        <div class="row mb-4 g-3">
            <div class="col-12 mb-3">
                <div class="border rounded p-3 bg-white">
                    <h5 class="mb-3"><i class="bi bi-geo-alt"></i> Alamat Tujuan</h5>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <h4 class="fw-bold">John Doe</h4>
                                <p class="mb-1">Jl. Sudirman No. 123, Gedung Plaza Lt. 5</p>
                                <p class="mb-1">Kec. Menteng, Jakarta Pusat</p>
                                <p class="text-muted"><small><i class="bi bi-telephone"></i> 0812-3456-7890</small></p>
                            </div>


                        </div>
                        <div class="col-md-4">
                            <!-- Tempat untuk map integration -->
                            <div class="ratio ratio-1x1 bg-secondary rounded">
                                <div class="d-flex align-items-center justify-content-center text-white">
                                    <i class="bi bi-map fs-1"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Details -->
        <div class="row g-3 mb-5">
            <div class="col-xl-6 col-lg-12">
                <div class="border rounded p-3 bg-white h-100">
                    <h5 class="mb-3"><i class="bi bi-clipboard-data"></i> Detail Pesanan</h5>
                    <dl class="row">
                        <dt class="col-sm-4">No. Pesanan</dt>
                        <dd class="col-sm-8">LAUNDRY-001234</dd>

                        <dt class="col-sm-4">Tanggal Masuk</dt>
                        <dd class="col-sm-8">15 Maret 2024 10:00 WIB</dd>

                        <dt class="col-sm-4">Type Layanan</dt>
                        <dd class="col-sm-8">
                            <span class="badge bg-primary">Pakaian + Sprei</span>
                        </dd>
{{--
                        <dt class="col-sm-4">Total Berat</dt>
                        <dd class="col-sm-8">4.5 kg</dd> --}}
                    </dl>
                </div>
            </div>

            <div class="col-xl-6 col-lg-12">
                <div class="border rounded p-3 bg-white h-100">
                    <h5 class="mb-3"><i class="bi bi-wallet2"></i> Pembayaran</h5>
                    <dl class="row">
                        <dt class="col-sm-4">Qris</dt>
                        <dd class="col-sm-8">Rp 85.000,-</dd>


                        <dt class="col-sm-4">Metode Pembayaran</dt>
                        <dd class="col-sm-8">Transfer Bank</dd>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Action Button -->
        <div class="fixed-bottom bg-light py-3 border-top">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex gap-2 justify-content-end">

                            <button class="btn btn-success btn-lg">
                                <i class="bi bi-check2-circle"></i> Tandai Selesai
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
