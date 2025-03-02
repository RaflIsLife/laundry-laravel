@extends('layouts.admin')

@section('content')
    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Manajemen User</h2>
            <div class="d-flex">
                <a href="{{ route('admin.akun.create') }}" class="btn btn-primary me-2">
                    <i class="bi bi-plus-circle me-1"></i> Tambah Akun
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
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Telepon</th>
                                <th>Tanggal Daftar</th>
                                <th>Role</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->phone }}</td>
                                    <td>{{ $item->created_at }}</td>
                                    <td>

                                        <span
                                            class="badge @switch($item->role)
                                            @case('owner')
                                                bg-success
                                                @break
                                            @case('admin')
                                                bg-primary
                                                @break
                                            @case('kasir')
                                                bg-info
                                                @break
                                            @case('kurir')
                                                bg-secondary
                                                @break
                                            @case('customer')
                                                bg-warning
                                                @break

                                            @default

                                        @endswitch ">{{ $item->role }}</span>


                                    </td>
                                    <td>
                                        <a href="{{ route('admin.akun.update', ['id' => $item->id]) }}"
                                            class="btn btn-sm btn-warning me-1">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('admin.akun.delete', ['id' => $item->id]) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Yakin ingin menghapus {{ $item->name }}?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
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
