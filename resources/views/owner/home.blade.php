@extends('layouts.owner')

@section('content')
<div class="container-fluid p-0">
    <div class="main-content">
        <h2 class="mb-4">Dashboard Owner</h2>

        <div class="row">
            <!-- Kartu Total Pemasukan -->
            <div class="col-md-4">
                <div class="card text-white bg-success mb-3">
                    <div class="card-header">Total Pemasukan</div>
                    <div class="card-body">
                        <h4 class="card-title">Rp {{ number_format($transaksi->sum('total_harga'), 0, ',', '.') }}</h4>
                    </div>
                </div>
            </div>

            <!-- Kartu Total Pesanan -->
            <div class="col-md-4">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-header">Total Pesanan</div>
                    <div class="card-body">
                        <h4 class="card-title">{{ $transaksi->count() }} Pesanan</h4>
                    </div>
                </div>
            </div>

            <!-- Kartu Total Pelanggan -->
            <div class="col-md-4">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-header">Total Pelanggan</div>
                    <div class="card-body">
                        <h4 class="card-title">{{ $user->count() }} Pelanggan</h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grafik Pemasukan Bulanan -->
        <div class="card mb-4">
            <div class="card-header">Grafik Pemasukan Bulanan</div>
            <div class="card-body">
                <canvas id="pemasukanChart"></canvas>
            </div>
        </div>

        <!-- Tabel Riwayat Transaksi -->
        <div class="card">
            <div class="card-header">Riwayat Transaksi</div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Pelanggan</th>
                            <th>Tanggal</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transaksi as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->user->name }}</td>
                                <td>{{ $item->created_at }}</td>
                                <td>Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge bg-success">
                                        {{ $item->status }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

    <script>
        // Data untuk grafik pemasukan bulanan
        var pemasukanData = @json($grafikPemasukan); // Pastikan ini adalah array data yang diterima dari controller

        // Ambil bulan dan total pemasukan
        var bulan = pemasukanData.map(function(item) {
            return item.bulan;
        });
        var totalPemasukan = pemasukanData.map(function(item) {
            return item.total_harga;
        });

        // Buat chart
        var ctx = document.getElementById('pemasukanChart').getContext('2d');
        var pemasukanChart = new Chart(ctx, {
            type: 'line', // Jenis grafik: line chart
            data: {
                labels: bulan,
                datasets: [{
                    label: 'Pemasukan Bulanan',
                    data: totalPemasukan,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
