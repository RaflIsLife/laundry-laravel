@extends('layouts.admin')

@section('content')
    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Manajemen Layanan</h2>
            <div class="d-flex">
                <a href="{{ route('admin.layanan.create') }}" class="btn btn-primary me-2">
                    <i class="bi bi-plus-circle me-1"></i> Tambah Layanan
                </a>
                {{-- <input type="text" class="form-control" placeholder="Cari pelanggan..."> --}}
            </div>
        </div>
        @if (Session::has('status'))
            <div> <span style="color: red">{{ Session::get('status') }}</span> </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="dataTables">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Nama Layanan</th>
                                <th>Harga per/pcs</th>
                                <th>Harga per/kg</th>
                                <th>Created at</th>
                                <th>Updated at</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Dummy Data -->
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->nama_layanan }}</td>
                                    <td>Rp {{ number_format($item->harga_pcs, 0, ',', '.') }} </td>
                                    <td>Rp {{ number_format($item->harga_kg, 0, ',', '.') }}</td>
                                    <td>{{ $item->created_at }}</td>
                                    <td>{{ $item->updated_at }}</td>
                                    <td>
                                        <a href="{{ route('admin.layanan.update', ['id'=>$item->id ]) }}" class="btn btn-sm btn-warning me-1">
                                            <i class="bi bi-pencil-square"></i>
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

