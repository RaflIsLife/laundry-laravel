@extends('layouts.kurir') @section('content')
    <div class="main-content ">
        <div class="row">

            <div
                class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Daftar Pesanan</h1>
            </div>

            <div class="row">
                <div class="col-12">
                    @foreach ($transaksi as $item)
                        
                    
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5 class="card-title">Pesanan #LAU-{{ $item->id }}</h5>
                                    <p class="card-text mb-1">Pelanggan: {{ $item->user->name }}</p>
                                    <p class="card-text mb-1">Alamat: {{ $item->user->address }}</p>
                                    @if($item->status == 'menunggu pengambilan')
                                    <span class="badge bg-warning text-dark">Belum Diambil</span>
                                        
                                        
                                        @elseif($item->status == 'menunggu pengantaran')
                                        <span class="badge bg-info text-dark">Belum Diantar</span>
                                        @endif
                                    
                                </div>
                                <div>
                                    <a href="/courier/order/1" class="btn btn-primary btn-sm">
                                        <i class="bi bi-bicycle"></i> Ambil Sekarang
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    {{-- <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5 class="card-title">Pesanan #LAUNDRY002</h5>
                                    <p class="card-text mb-1">Pelanggan: Jane Smith</p>
                                    <p class="card-text mb-1">Alamat: Jl. Thamrin No.45</p>
                                    <span class="badge bg-info text-dark">Belum Diantar</span>
                                </div>
                                <div>
                                    <a href="/courier/order/2" class="btn btn-success btn-sm">
                                        <i class="bi bi-truck"></i> Antar Sekarang
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
@endsection
