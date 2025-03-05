@extends('layouts.admin')

@section('content')
    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Daftar Pesanan Berlangsung</h2>
        </div>
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover stripe" id="dataTables">
                        <thead>
                            <tr>
                                <th>No. Pesanan</th>
                                <th>Pelanggan</th>
                                <th>Tanggal Masuk</th>
                                <th>Estimasi Selesai</th>
                                <th>Pembayaran</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transaksi as $item)
                                <tr>
                                    <td>#LAU-{{ $item->id }}</td>
                                    <td>{{ $item->user->name }}</td>
                                    <td>{{ $item->created_at }}</td>
                                    <td>2023-09-22</td>
                                    <td>
                                        <span
                                            class="badge
                                @switch($item->pembayaran)
                                    @case('qris')
                                        bg-primary
                                        @break
                                    @case('cod')
                                        bg-secondary
                                        @break
                                @endswitch
                                 ">{{ $item->pembayaran }}</span>
                                    </td>
                                    <td>
                                        <a class="btn btn-sm btn-outline-primary"
                                            href="{{ route('admin.detailPesanan', ['transaksi' => $item->id]) }}">
                                            <i class="bi bi-eye"></i>
                                            </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
