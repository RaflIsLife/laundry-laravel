@extends('layouts.admin')

@section('content')
    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Daftar Pesanan Berlangsung</h2>
            <div class="d-flex">
                <input type="text" class="form-control me-2" placeholder="Cari pesanan...">
                <select class="form-select" style="width: 200px;">
                    <option>Filter Pembayaran</option>
                    <option>Qris</option>
                    <option>COD</option>
                </select>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
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
                                        <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.detailPesanan', ['transaksi' => $item->id]) }}">
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
