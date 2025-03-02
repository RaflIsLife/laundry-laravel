@extends('layouts.admin')

@section('content')
<div class="main-content">
    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="mb-4">Tambah Layanan Baru</h4>
            <form action="{{ route('admin.layanan.post') }}" method="POST" class="auth-form">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Nama Layanan</label>
                            <input type="text" name="nama_layanan" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Harga</label>
                            <input type="text" name="harga" class="form-control" required>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i> Simpan
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
