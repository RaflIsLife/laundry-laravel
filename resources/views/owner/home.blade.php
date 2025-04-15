@extends('layouts.owner')

@section('content')
    <div class="container-fluid p-0">
        <div class="main-content">
            <h2 class="mb-4">Dashboard Owner</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="card text-white bg-success mb-3">
                        <div class="card-header">Total Pemasukan</div>
                        <div class="card-body">
                            <h4 class="card-title">Rp {{ number_format($transaksi->sum('total_harga'), 0, ',', '.') }}</h4>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card text-white bg-primary mb-3">
                        <div class="card-header">Total Pesanan</div>
                        <div class="card-body">
                            <h4 class="card-title">{{ $transaksi->count() }} Pesanan</h4>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card text-white bg-warning mb-3">
                        <div class="card-header">Total Pelanggan</div>
                        <div class="card-body">
                            <h4 class="card-title">{{ $user->count() }} Pelanggan</h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">Grafik Pemasukan</div>
                <div class="card-body">
                    <canvas id="pemasukanChart"></canvas>
                </div>
            </div>

            <div class="card">
                <div class="card-header">Perbandingan Transaksi Offline dan Online</div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <canvas id="myChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var pemasukanData = @json($grafikPemasukan);

        var tanggal = pemasukanData.map(function(item) {
            return item.tanggal;
        });
        var totalPemasukan = pemasukanData.map(function(item) {
            return item.total_harga;
        });

        var ctx1 = document.getElementById('pemasukanChart').getContext('2d');
        var pemasukanChart = new Chart(ctx1, {
            type: 'line',
            data: {
                labels: tanggal,
                datasets: [{
                    label: 'Table Pemasukan',
                    data: totalPemasukan,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderWidth: 1,
                    pointRadius: 5,
                    pointHoverRadius: 10,
                    cubicInterpolationMode: 'monotone',
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

        const ctx = document.getElementById('myChart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: @json($labelsCaraPemesanan),
                datasets: [{
                    label: 'Jumlah Transaksi',
                    data: @json($valuesCaraPemesanan),
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)', // Warna offline
                        'rgba(54, 162, 235, 0.2)' // Warna online
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Perbandingan Transaksi'
                    }
                }
            }
        });
    </script>
@endsection
