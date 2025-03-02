@extends('layouts.user')

@section('content')
    <div class="container-fluid p-0">

        <!-- Main Content -->
        <div class="main-content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold mb-1">Profil Pengguna</h2>
                    <p class="text-muted">Kelola informasi profil Anda</p>
                </div>
            </div>


            <div class="">
                <div class="card border-0 shadow-sm">
                    {{-- <div class="card-body">
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div> --}}
                        @if (Session::has('status'))
                            <div> <span style="color: red">{{ Session::get('status') }}</span> </div>
                        @endif
                        <form action="{{ route('profile.update') }}" method='POST'>
                            @csrf
                            <div class="mb-4">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" value="{{ old('name', Auth::user()->name) }}" required>

                            </div>

                            <div class="mb-4">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ Auth::user()->email }}">
                            </div>

                            {{-- <div class="mb-4">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" value="{{ Auth::user()->password }}">
                            </div> --}}

                            <div class="mb-4">
                                <label class="form-label">Nomor Telepon</label>

                                    <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                        name="phone" value="{{ old('phone', Auth::user()->phone) }}" pattern="[0-9]{9,13}"
                                        required>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                            </div>

                            <div class="mb-4">
                                <label class="form-label">Alamat</label>
                                <input type="text" name="address" class="form-control"
                                    value="{{ Auth::user()->address }}">

                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary px-5">
                                    <i class="bi bi-save me-2"></i>Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <style>
        .avatar-wrapper {
            position: relative;
            display: inline-block;
        }

        .avatar-upload {
            position: absolute;
            bottom: 10px;
            right: 10px;
            border-radius: 50%;
            padding: 8px;
            width: 36px;
            height: 36px;
        }

        .form-control:disabled {
            background-color: #f8f9fa;
            opacity: 1;
        }

        .input-group-text {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
            color: var(--accent-color);
        }
    </style>

    {{-- <script>
$(document).ready(function() {
    // Update phone code selection based on existing value
    const phoneNumber = "{{ Auth::user()->phone }}";
    if(phoneNumber) {
        const phoneCode = phoneNumber.split(' ')[0];
        $('select[name="phone_code"]').val(phoneCode);
    }
});
</script> --}}
@endsection
