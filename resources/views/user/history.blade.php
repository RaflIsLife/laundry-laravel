{{-- todo: use pagination --}}
@extends('layouts.user')

@section('content')
    <div class="container-fluid p-0">
        <!-- Main Content -->
        <div class="main-content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold mb-1">Riwayat Pesanan</h2>
                    <p class="text-muted">Daftar seluruh transaksi yang pernah dilakukan</p>
                </div>
                {{-- <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="filterDropdown"
                        data-bs-toggle="dropdown">
                        <i class="bi bi-funnel me-2"></i>Filter
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item filter-option" data-filter="all" href="#">Semua</a></li>
                        <li><a class="dropdown-item filter-option" data-filter="completed" href="#">Selesai</a></li>
                        <li><a class="dropdown-item filter-option" data-filter="progress" href="#">Dalam Proses</a>
                        </li>
                        <li><a class="dropdown-item filter-option" data-filter="canceled" href="#">Dibatalkan</a></li>
                    </ul>
                </div> --}}
            </div>

            <!-- Order List -->
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
                                        <h4 class="text-primary fw-bold">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</h4>
                                        <a href="{{ route('detailRiwayat', [$item->id]) }}" class="btn btn-link text-decoration-none">
                                            Detail Pesanan <i class="bi bi-chevron-right"></i>
                                        </a>
                                    </div>
                                </div>

                                <!-- Order Items -->

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>

        <!-- Pagination -->
        {{-- <nav class="mt-4">
            <ul class="pagination justify-content-center">
                <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1">Previous</a>
                </li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="#">Next</a>
                </li>
            </ul>
        </nav> --}}
    </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    {{-- <script>
$(document).ready(function() {
    $('.filter-option').click(function(e) {
        e.preventDefault();
        const filter = $(this).data('filter');
        const $orderItems = $('.order-item');

        // Update filter text
        $('#filterDropdown').html(`${$(this).text()} <i class="bi bi-chevron-down"></i>`);

        if(filter === 'all') {
            $orderItems.show();
        } else {
            $orderItems.each(function() {
                $(this).toggle($(this).data('status') === filter);
            });
        }
    });
});
</script> --}}

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
@endsection
