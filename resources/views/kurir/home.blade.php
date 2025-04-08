@extends('layouts.kurir')
@section('content')
    <div class="main-content">
        @if ($transaksi)
        {{-- ada satu tombol, untuk melanjutkan orderan --}}
        <div class="alert alert-info">
            <h4 class="alert-heading">Ada Pesanan Baru!</h4>
            <p>Pesanan baru telah diterima. Silakan klik tombol di bawah untuk melanjutkan.</p>
            <hr>
            <a href="{{ route('kurir.detail', $transaksi) }}" class="btn btn-primary">
                Lanjutkan Pesanan
            </a>
        </div>
        @else
            <div class="alert alert-info">
                Tidak ada pesanan yang tersedia untuk saat ini.
            </div>
        @endif
    </div>
@endsection
