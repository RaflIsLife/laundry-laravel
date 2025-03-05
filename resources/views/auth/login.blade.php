@extends('layouts.auth')
@section('title', 'Login')

@section('content')
    <div class="auth-card card" style="background-color: rgba(255, 255, 255, 0.751);">
        <div class="card-body p-4 p-sm-5">
            <h2 class="mb-4 text-center">Selamat datang kembali</h2>

            <form method="POST" action="{{ route('postLogin') }}" class="auth-form">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                        name="password" required autocomplete="current-password">
                </div>

                <div class="mb-3 d-flex justify-content-between align-items-center">
                    @if (Session::has('status'))
                        <div> <span style="color: red">{{ Session::get('status') }}</span> </div>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2">
                    Sign In
                </button>

                <div class="mt-4 text-center">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="text-decoration-none">
                        Create one
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
