@extends('layouts.user')

@push('styles')
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

    .order-item:hover {
        transform: translateX(5px);
    }

    .pagination .page-item.active .page-link {
        background-color: var(--secondary-color);
        border-color: var(--secondary-color);
    }
</style>
@endpush

@section('content')
    <div class="container-fluid p-0">
        <div class="main-content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold mb-1">Riwayat Pesanan</h2>
                    <p class="text-muted">Daftar seluruh transaksi yang pernah dilakukan</p>
                </div>
            </div>

            <div class="row">
                @foreach ($transaksi as $item)
                    <div class="col-12 mb-4 order-item" data-status="completed">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <div class="d-flex align-items-center">
                                            <div class="order-icon bg-primary text-white rounded-3 p-3 me-3">
                                                <i class="bi bi-receipt-cutoff fs-4"></i>
                                            </div>
                                            <div>
                                                <h5 class="fw-bold mb-1">{{ $item->id }}</h5>
                                                <div class="d-flex align-items-center">
                                                    <span class="status-badge badge-completed me-2">
                                                        completed
                                                    </span>
                                                    <small class="text-muted">
                                                        <i class="bi bi-calendar me-1"></i>
                                                        {{ $item->created_at }}
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        <h4 class="text-primary fw-bold">Rp
                                            {{ number_format($item->total_harga, 0, ',', '.') }}</h4>
                                        <a href="{{ route('detailRiwayat', [$item->id]) }}"
                                            class="btn btn-link text-decoration-none">
                                            Detail Pesanan <i class="bi bi-chevron-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="d-flex justify-content-center mt-4">
                    {{ $transaksi->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
