@extends('layouts.kurir') @section('content')
    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
            <div>
                <h1 class="h2">Detail
                    @if ($transaksi->status == 'menunggu pengambilan')
                        Pengambilan
                    @elseif ($transaksi->status == 'menunggu pengantaran')
                        Pengantaran
                    @endif
                </h1>
            </div>
        </div>

        <div class="row mb-4 g-3">
            <div class="col-12 mb-3">
                <div class="border rounded p-3 bg-white">
                    <h5 class="mb-3"><i class="bi bi-geo-alt"></i> Alamat Tujuan</h5>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <h4 class="fw-bold">{{ $transaksi->user->name }}</h4>
                                <p class="mb-1">{{ $transaksi->user->address }}</p>
                                <a class="text-muted" href="http://wa.me/62{{ ltrim($transaksi->user->phone, 0) }}">
                                    <small class="d-flex align-items-center">
                                        <i class="bi bi-whatsapp pr-2"></i>{{ $transaksi->user->phone }}
                                    </small>
                                </a>
                            </div>


                        </div>
                        <div class="col-md-4">
                            <div class="ratio ratio-1x1 bg-secondary rounded">
                                <div class="d-flex align-items-center justify-content-center text-white" id="map">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4 g-3">
            <div class="col-12 mb-3">
                <div class="border rounded p-3 bg-white">
                    <h2 class="mb-3 fw-bold"></i> Detail Layanan</h2>
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table stripe" id="dataTables">
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
                                        <td class="fw-bold">Rp {{ number_format($transaksi->subtotal, 0, ',', '.') }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-5">
            <div class="col-xl-6 col-lg-12">
                <div class="border rounded p-3 bg-white h-100">
                    <h5 class="mb-3"><i class="bi bi-clipboard-data"></i> Detail Pesanan</h5>
                    <dl class="row">
                        <dt class="col-sm-4">No. Pesanan</dt>
                        <dd class="col-sm-8">#LAU-{{ $transaksi->id }}</dd>

                        <dt class="col-sm-4">Tanggal Masuk</dt>
                        <dd class="col-sm-8">{{ $transaksi->created_at }}</dd>

                        <dt class="col-sm-4">Type Layanan</dt>
                        <dd class="col-sm-8">
                            <span class="badge bg-primary">
                                @foreach ($transaksiLayanan as $items)
                                    {{ $items->layanan->nama_layanan }} @if (!$loop->last)
                                        +
                                    @endif
                                @endforeach
                            </span>
                        </dd>
                    </dl>
                </div>
            </div>

            <div class="col-xl-6 col-lg-12">
                <div class="border rounded p-3 bg-white h-100">
                    <h5 class="mb-3"><i class="bi bi-wallet2"></i> Pembayaran</h5>
                    <dl class="row d-flex">
                        <div class="col-md-6">
                            <dt class="col-sm-6">Metode Pembayaran</dt>
                            <dd class="col-sm-6">{{ ucwords($transaksi->pembayaran) }}</dd>
                            @if ($transaksi->pembayaran == 'cod' && $transaksi->status_pembayaran == 'proses')
                                <form action="{{ route('kurir.mark-paid', $transaksi) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success">
                                        <i class="bi bi-check2-circle"></i> Tandai Pembayaran Selesai
                                    </button>
                                </form>
                            @else
                                <dt class="col-sm-4">Subtotal</dt>
                                <dd class="col-sm-8">Rp {{ number_format($transaksi->subtotal, 0, ',', '.') }},-</dd>
                            @endif
                        </div>
                        <div class="col-md-6">
                            @if ($transaksi->pembayaran == 'cod' && $transaksi->status_pembayaran == 'proses')
                                <dt class="col-sm-4">Subtotal</dt>
                                <dd class="col-sm-8">Rp {{ number_format($transaksi->subtotal, 0, ',', '.') }},-</dd>
                            @endif
                            <dt class="col-sm-4">Total Ongkir</dt>
                            <dd class="col-sm-8">Rp {{ number_format($transaksi->ongkir, 0, ',', '.') }},-</dd>

                            <dt class="col-sm-4">Total Harga</dt>
                            <dd class="col-sm-8 fs-5">
                                <span class="badge bg-secondary">Rp
                                    {{ number_format($transaksi->total_harga, 0, ',', '.') }},-
                                </span>
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>

        <div class="fixed-bottom bg-light py-3 border-top">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex gap-2 justify-content-end">
                            @if (in_array($transaksi->status, ['menunggu pengambilan', 'pengambilan', 'menunggu pengantaran', 'pengantaran']))
                                <form action="{{ route('kurir.complete-order', $transaksi) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-lg">
                                        <i class="bi bi-check2-circle"></i> Tandai Selesai
                                    </button>
                                </form>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        new DataTable('#dataTables');

        var latUser = {{ explode(',', $transaksi->user->address)[0] }};
        var lngUser = {{ explode(',', $transaksi->user->address)[1] }};
        const addressUser = '{{ $transaksi->user->address }}';

        var latCompany = {{ explode(',', $companyProfile->address)[0] }};
        var lngCompany = {{ explode(',', $companyProfile->address)[1] }};
        const addressCompany = '{{ $companyProfile->address }}';

        var map = L.map('map').setView([latCompany, lngCompany], 17);

        var Stadia_OSMBright = L.tileLayer('https://tiles.stadiamaps.com/tiles/osm_bright/{z}/{x}/{y}{r}.{ext}', {
            minZoom: 0,
            maxZoom: 20,
            attribution: '&copy; <a href="https://www.stadiamaps.com/" target="_blank">Stadia Maps</a> &copy; <a href="https://openmaptiles.org/" target="_blank">OpenMapTiles</a> &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            ext: 'png'
        }).addTo(map);

        var marker = L.marker([latUser, lngUser]).addTo(map)
        var marker = L.marker([latCompany, lngCompany]).addTo(map)

        var requestOptions = {
            method: 'GET',
        };
        const myAPIKey = env('GEOAPIFY_API_KEY');
        const url =
            `https://api.geoapify.com/v1/routing?waypoints=${addressCompany}|${addressUser}&mode=motorcycle&details=instruction_details&apiKey=${myAPIKey}`;

        fetch(url).then(res => res.json()).then(result => {
            L.geoJSON(result, {
                style: (feature) => {
                    return {
                        color: "rgba(20, 137, 255, 0.7)",
                        weight: 5
                    };
                }
            }).bindPopup((layer) => {
                return `${layer.feature.properties.distance} ${layer.feature.properties.distance_units}, ${layer.feature.properties.time}`
            }).addTo(map);
        }, error => console.log(err));
    </script>
@endpush
