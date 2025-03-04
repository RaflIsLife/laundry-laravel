@extends('layouts.auth')
@section('title', 'Register')

@section('content')
    <div class="auth-card card" style="background-color: rgba(255, 255, 255, 0.751);">
        <div class="card-body p-4 p-sm-5">
            <h2 class="mb-4 text-center">Buat Akun</h2>

            <form action="{{ route('postRegister') }}" method="POST" class="auth-form">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Nama lengkap</label>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                        name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}" required autocomplete="email">

                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                        name="password" required>

                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label">Nomor WhatsApp</label>
                    <input type="tel" class="form-control @error('phone') is-invalid @enderror" name="phone"
                        pattern="[0-9]{9,13}" required>
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="alamat" class="form-label">Alamat</label>
                    <div id="map" class="" style="height: 400px"></div>
                    <input type="hidden" id="latitude" name="latitude">
                    <input type="hidden" id="longitude" name="longitude">
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2">
                    Create Account
                </button>

                <div class="mt-4 text-center">
                    Already have an account?
                    <a href="{{ route('login') }}" class="text-decoration-none">
                        Sign In
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
