@extends('layouts.kurir')
@section('content')
<div class="main-content">
    @if($transaksi)
    <script>
        window.location.href = "{{ route('kurir.detail', $transaksi) }}";
    </script>
    @else
        <div class="alert alert-info">
            Tidak ada pesanan yang tersedia untuk saat ini.
        </div>
    @endif
</div>
@endsection
