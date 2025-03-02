<!-- Main Content -->
{{-- todo: use pagination --}}
@extends('layouts.user')

@section('content')
    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1">Halo, {{ Auth::user()->name }} </h2>
                <p class="text-muted">{{ now()->translatedFormat('l, d F Y') }}</p>
            </div>
            <a class="btn btn-primary" href="{{ route('pesananBaru') }}">
                <i class="bi bi-plus-lg me-2"></i> Pesan Baru
            </a>
        </div>

        <h4 class="mb-4 fw-bold">Pesanan Aktif</h4>

        <!-- Order List -->
        <div class="row g-4">
            @foreach ($transaksi as $item)
                <div class="col-md-6">
                    <div class="order-card p-4">
                        <div class="d-flex align-items-start mb-3">
                            <div class="order-icon me-3">
                                <i class="bi bi-bag-check text-primary fs-5"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1">#LAU-{{ $item->id }}</h5>
                                <span class="status-badge badge-processing">{{ $item->status }}</span>
                            </div>
                        </div>
                        <hr style="background-color: black; height: 4px;">
                        <div class="row">
                            {{-- <div class="col-3" style="width: 160px">
                                <small class="text-muted">Estimasi Selesai</small>
                                <p class="mb-0">5 Jan 2024 - 17:00</p>
                            </div> ESTIMASI SELESAI AKAN MUNCUL JIKA PESANAN SUDAH MENCAPAI PROSES LAUNDRY --}}
                            <div class="col-3">
                                <small class="text-muted">Total Harga</small>
                                <p class="mb-0 fw-bold">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</p>
                            </div>
                            <div class="col-3">
                                <small class="text-muted">Jumlah Layanan</small>
                                <p class="mb-0 fw-bold">{{ $item->qty }}</p>
                            </div>
                        </div>
                        <div class="text-end">
                            <a class="btn btn-sm btn-outline-primary" href="{{ route('detailPesanan', $item->id) }}">
                                Detail <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
@endsection
