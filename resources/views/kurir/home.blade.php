@extends('layouts.kurir') @section('content')
    <div class="main-content ">


        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1">Detail Pengantaran/Pengambilan</h2>
                <p class="text-muted">Daftar seluruh Pengantaran/Pengambilan yang belum dilakukan</p>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-12">
                @foreach ($transaksi as $item)
                    <div class="col-12 mb-4 order-item" data-status="completed">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <div class="d-flex align-items-start"> <!-- Changed to align-items-start -->
                                            <div class="order-icon
                                             @if ($item->status == 'menunggu pengambilan')
                                            bg-warning
                                            @elseif($item->status == 'menunggu pengantaran')
                                            bg-info
                                            @endif
                                            text-white rounded-3 p-3 me-3">
                                                <i class="bi bi-receipt-cutoff fs-4"></i>
                                            </div>
                                            <div class="w-100">
                                                <h5 class="fw-bold mb-1">Pesanan #{{ $item->id }}</h5>
                                                <div class="d-flex justify-content-between align-items-start mb-2">
                                                    <div>
                                                        <div class="mb-2">
                                                            <p class="mb-1 text-muted">
                                                                <i class="bi bi-person me-1"></i>
                                                                {{ $item->user->name }}
                                                            </p>
                                                            <p class="mb-1 text-muted">
                                                                <i class="bi bi-geo-alt me-1"></i>
                                                                {{ $item->user->address }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div>
                                                    <div class="mb-2">
                                                        @if ($item->status == 'menunggu pengambilan')
                                                            <span class="badge bg-warning text-dark">Belum Diambil</span>
                                                        @elseif($item->status == 'menunggu pengantaran')
                                                            <span class="badge bg-info text-dark">Belum Diantar</span>
                                                        @endif
                                                        <div class="d-flex align-items-center text-muted mt-2">
                                                            <i class="bi bi-calendar me-1"></i>
                                                            <small>{{ $item->created_at->translatedFormat('d F Y H:i') }}</small>
                                                        </div>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-end mt-3 mt-md-0">
                                        <a href="{{ route('kurir.detail', ['transaksi' => $item->id]) }}"
                                            class="btn

                                            @if ($item->status == 'menunggu pengambilan')
                                            btn-warning
                                            @elseif($item->status == 'menunggu pengantaran')
                                            btn-info
                                            @endif
                                             btn-sm">
                                            <i class="bi bi-bicycle"></i>
                                            @if ($item->status == 'menunggu pengambilan')
                                            Ambil Sekarang
                                            @elseif($item->status == 'menunggu pengantaran')
                                            Antar Sekarang
                                            @endif
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                {{-- <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5 class="card-title">Pesanan #LAUNDRY002</h5>
                                    <p class="card-text mb-1">Pelanggan: Jane Smith</p>
                                    <p class="card-text mb-1">Alamat: Jl. Thamrin No.45</p>
                                    <span class="badge bg-info text-dark">Belum Diantar</span>
                                </div>
                                <div>
                                    <a href="/courier/order/2" class="btn btn-success btn-sm">
                                        <i class="bi bi-truck"></i> Antar Sekarang
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div> --}}
            </div>
        </div>

    </div>
    <style>
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            display: inline-flex;
            align-items: center;
        }

        .badge-completed {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .badge-progress {
            background: #fff3e0;
            color: #ef6c00;
        }

        .badge-canceled {
            background: #ffebee;
            color: #c62828;
        }

        .order-item {
            transition: all 0.3s ease;
        }

        .order-icon {
            transition: transform 0.3s ease;
        }

        .order-item:hover .order-icon {
            transform: rotate(-15deg);
        }

        .btn-outline-primary {
            border-width: 2px;
            font-weight: 500;
        }

        .text-muted i {
            width: 20px;
            text-align: center;
        }

        .pagination .page-item.active .page-link {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }
    </style>
@endsection
