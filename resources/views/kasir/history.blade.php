@extends('layouts.kasir')

@section('content')
    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1">History Transaksi</h2>
                <p class="text-muted">Daftar transaksi yang sudah selesai</p>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="dataTables">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Pelanggan</th>
                                <th>Nomor Whatsapp</th>
                                <th>Tanggal Selesai</th>
                                <th>Total</th>
                                <th>Cara Pemesanan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transaksi as $item)
                                <tr valign="middle">
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->user->name }}</td>
                                    <td><a href="http://wa.me/62{{ ltrim($item->user->phone, 0) }}" target="_blank"
                                            rel="noopener noreferrer"> {{ $item->user->phone }} </a></td>
                                    <td>{{ $item->updated_at }}</td>
                                    <td>Rp {{ number_format($item->total_harga) }}</td>
                                    <td>
                                        <span
                                            class="badge bg-{{ $item->cara_pemesanan == 'offline' ? 'success' : 'primary' }}">
                                            {{ ucfirst($item->cara_pemesanan) }}
                                        </span>
                                    </td>
                                    <td>
                                        <form action="{{ route('kasir.transaksi.update-status', $item) }}" method="POST">
                                            @csrf
                                            <select name="status" class="form-select" onchange="this.form.submit()">

                                                <option value="menunggu pengambilan"
                                                    {{ $item->status == 'menunggu pengambilan' ? 'selected' : '' }}>Menunggu
                                                    Pengambilan
                                                </option>

                                                <option value="pengambilan"
                                                    {{ $item->status == 'pengambilan' ? 'selected' : '' }}>Pengambilan
                                                </option>

                                                <option value="antrian laundry"
                                                    {{ $item->status == 'antrian laundry' ? 'selected' : '' }}>Antrian
                                                </option>

                                                <option value="proses laundry"
                                                    {{ $item->status == 'proses laundry' ? 'selected' : '' }}>Proses
                                                </option>

                                                <option value="menunggu pengantaran"
                                                    {{ $item->status == 'menunggu pengantaran' ? 'selected' : '' }}>
                                                    Menunggu Pengantaran
                                                </option>

                                                <option value="pengantaran"
                                                    {{ $item->status == 'pengantaran' ? 'selected' : '' }}>Pengantaran
                                                </option>

                                                <option value="selesai" {{ $item->status == 'selesai' ? 'selected' : '' }}>
                                                    Selesai
                                                </option>
                                            </select>
                                        </form>
                                    </td>
                                    <td>
                                        <a href="{{ route('kasir.detailPesanan', ['transaksi' => $item->id]) }}"
                                            class="btn btn-sm btn-light">
                                            <i class="bi bi-eye"></i>
                                        </a>
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
