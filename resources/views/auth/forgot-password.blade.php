@extends('layouts.app')
@section('title', 'Lupa Password')
@section('content')
<section class="auth-page auth-page--center">
    <div class="container auth-container auth-container--single">
        <div class="auth-form-wrap auth-form-wrap--wide">
            <span class="badge">Reset Password</span>
            <h1 class="auth-title">Lupa Password?</h1>
            <p class="auth-desc">Masukkan email Anda dan kami akan mengirimkan link reset password.</p>
            <div class="auth-card">
                @if(session('status'))
                <div style="background:#F0FDF4;border:1px solid #86EFAC;border-radius:10px;padding:12px 16px;color:#15803D;font-size:.875rem;margin-bottom:16px">
                    {{ session('status') }}
                </div>
                @endif
                @if($errors->any())
                <div class="alert alert-error">
                    @foreach($errors->all() as $e)<p>{{ $e }}</p>@endforeach
                </div>
                @endif

                <p style="font-size:.875rem;color:var(--muted);margin-bottom:20px;line-height:1.6">
                    Fitur kirim email reset password memerlukan konfigurasi SMTP di file <code>.env</code>.
                    Untuk sementara, minta admin untuk reset password secara manual melalui panel admin.
                </p>

                <a href="{{ route('login') }}"
                   style="display:block;text-align:center;background:var(--primary);color:#fff;font-weight:700;padding:12px;border-radius:50px;text-decoration:none;font-size:.9rem">
                    ← Kembali ke Login
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
