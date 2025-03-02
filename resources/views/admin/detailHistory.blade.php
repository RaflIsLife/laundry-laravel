@extends('layouts.admin')

@section('content')

    <!-- Main Content -->
    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1">Detail Riwayat</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.history') }}">Riwayat</a></li>
                        <li class="breadcrumb-item active">LN-{{ $transaksi->id }}</li>
                    </ol>
                </nav>
            </div>
            <a href="{{ route('admin.history') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Kembali
            </a>
        </div>

        <!-- Order Summary -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <dl class="row mb-0">
                            <dt class="col-sm-4">Nama Pemesan</dt>
                            <dd class="col-sm-8 fw-bold text-danger">{{ $transaksi->user->name }}</dd>

                            <dt class="col-sm-4">Nomor Pesanan</dt>
                            <dd class="col-sm-8 fw-bold text-primary">LN-{{ $transaksi->id }}</dd>

                            <dt class="col-sm-4">Tanggal Pesan</dt>
                            <dd class="col-sm-8">{{ $transaksi->created_at }}</dd>

                            <dt class="col-sm-4">Status</dt>
                            <dd class="col-sm-8">
                                <span class="status-badge badge-completed">
                                    {{ $transaksi->status }}
                                </span>
                            </dd>
                        </dl>
                    </div>

                    <div class="col-md-6">
                        <dl class="row mb-0">
                            <dt class="col-sm-4">Total Harga</dt>
                            <dd class="col-sm-8 fw-bold">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</dd>

                            <dt class="col-sm-4">Metode Pembayaran</dt>
                            <dd class="col-sm-8">


                                    @if ($transaksi->pembayaran == 'qris')
                                    <i class="bi bi-qr-code me-2"></i>QRIS
                                @else
                                    <i class="bi bi-cash-coin me-2"></i>COD
                                @endif

                            </dd>

                            {{-- @if($order->payment_method === 'qris')
                            <dt class="col-sm-4">Status Pembayaran</dt>
                            <dd class="col-sm-8">
                                <span class="badge bg-success">
                                    <i class="bi bi-check-circle me-2"></i>Lunas
                                </span>
                            </dd>
                            @endif --}}
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Items -->
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h5 class="fw-bold mb-4">Detail Layanan</h5>
                <div class="table-responsive">
                    <table class="table">
                        <thead class="table-light">
                            <tr>
                                <th>Jenis Layanan</th>
                                <th>Kuantitas</th>
                                <th>Harga Satuan</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transaksiLayanan as $item)
                                <tr>
                                    <td>{{ $item->layanan->nama_layanan }}</td>
                                    <td>
                                        {{ $item->qty }}
                                        <span class="text-muted">{{ $item->type_qty }}</span>
                                    </td>
                                    <td>
                                        @if ($item->type_qty == 'pcs')

                                        Rp {{ number_format($item->layanan->harga_pcs, 0, ',', '.') }}
                                       @else
                                        Rp {{ number_format($item->layanan->harga_kg, 0, ',', '.') }}
                                        @endif
                                    </td>
                                    <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <td colspan="3" class="text-end fw-bold">Total</td>
                                <td class="fw-bold">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                {{-- @if($order->payment_method === 'qris')
                <div class="mt-4 border-top pt-4">
                    <h6 class="fw-bold mb-3">Bukti Pembayaran</h6>
                    <img src="{{ asset('storage/'.$order->payment_proof) }}"
                         alt="QR Code"
                         style="max-width: 200px; border-radius: 8px">
                </div>
                @endif --}}
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

    .badge-proses {
        background: #e3f2fd;
        color: #2196f3;
    }

    .badge-completed {
        background: #e8f5e9;
        color: #2e7d32;
    }

    .badge-canceled {
        background: #ffebee;
        color: #c62828;
    }

    table th {
        background-color: var(--secondary-color) !important;
        color: var(--accent-color);
    }

    .table tbody tr:hover {
        background-color: #f8f9fa;
    }
</style>
@endsection
