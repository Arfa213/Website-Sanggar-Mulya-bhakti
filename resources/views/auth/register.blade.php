@extends('layouts.app')

@section('title', 'Daftar Anggota')

@section('content')
<section class="auth-page auth-page--center">
    <div class="container auth-container auth-container--single">

        <div class="auth-form-wrap auth-form-wrap--wide">
            <span class="badge">Pendaftaran</span>
            <h1 class="auth-title">Daftar Anggota</h1>
            <p class="auth-desc">Bergabunglah dengan komunitas pencinta seni traditional</p>

            <div class="auth-card">
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

{{-- SESSION ERROR --}}
@if(session('error'))
    <div class="alert alert-error">{{ session('error') }}</div>
@endif
                @if($errors->any())
                    <div class="alert alert-error">
                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('register.post') }}">
                    @csrf

                    <div class="form-group">
                        <label for="name">Nama Lengkap <span class="required">*</span></label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            class="form-input @error('name') is-error @enderror"
                            placeholder="Masukan Nama Lengkap"
                            value="{{ old('name') }}"
                            required
                        >
                        @error('name')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email <span class="required">*</span></label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-input @error('email') is-error @enderror"
                            placeholder="Nama@gmail.com"
                            value="{{ old('email') }}"
                            required
                        >
                        @error('email')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label for="alamat">Alamat <span class="required">*</span></label>
                        <textarea
                            id="alamat"
                            name="alamat"
                            class="form-input form-textarea @error('alamat') is-error @enderror"
                            placeholder="Masukan alamat Lengkap"
                            rows="3"
                            required
                        >{{ old('alamat') }}</textarea>
                        @error('alamat')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Password <span class="required">*</span></label>
                        <div class="input-password-wrap">
                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="form-input @error('password') is-error @enderror"
                                placeholder="Minimal 8 Karakter"
                                required
                            >
                            <button type="button" class="toggle-pw" aria-label="Tampilkan password">
                                <svg class="eye-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            </button>
                        </div>
                        @error('password')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Konfirmasi Password <span class="required">*</span></label>
                        <div class="input-password-wrap">
                            <input
                                type="password"
                                id="password_confirmation"
                                name="password_confirmation"
                                class="form-input"
                                placeholder="Ulangi Password"
                                required
                            >
                            <button type="button" class="toggle-pw" aria-label="Tampilkan password">
                                <svg class="eye-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn-submit">Daftar</button>

                    <p class="form-switch">
                        Sudah punya akun?
                        <a href="{{ route('login') }}">Masuk di sini</a>
                    </p>
                </form>
            </div>
        </div>

    </div>
</section>
@endsection