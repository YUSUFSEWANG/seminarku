<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - SeminarKu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #1e3a5f 0%, #2d6a9f 100%); min-height: 100vh; }
        .register-card { border: none; box-shadow: 0 20px 60px rgba(0,0,0,0.3); }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center py-5">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="text-center text-white mb-4">
                <i class="bi bi-calendar-event fs-1"></i>
                <h3 class="fw-bold mt-2">SeminarKu</h3>
                <p class="opacity-75">Daftarkan akun Anda</p>
            </div>
            <div class="card register-card">
                <div class="card-body p-4">
                    <h5 class="fw-semibold mb-4">Buat Akun Baru</h5>

                    @if($errors->any())
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $error)
                            <div><i class="bi bi-exclamation-triangle"></i> {{ $error }}</div>
                        @endforeach
                    </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name') }}" required autofocus maxlength="255" placeholder="Nama lengkap Anda">
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Alamat Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email') }}" required maxlength="255" placeholder="email@contoh.com">
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">No. Telepon</label>
                                <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" maxlength="20" placeholder="08xxxxxxxxxx">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Instansi/Universitas</label>
                                <input type="text" name="institution" class="form-control" value="{{ old('institution') }}" maxlength="255" placeholder="Nama institusi">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Password <span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                                       required placeholder="Min 8 karakter, huruf besar+kecil, angka, simbol">
                                <div class="form-text">Minimal 8 karakter dengan kombinasi huruf besar, kecil, angka, dan simbol.</div>
                                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Konfirmasi Password <span class="text-danger">*</span></label>
                                <input type="password" name="password_confirmation" class="form-control" required placeholder="Ulangi password">
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary w-100 py-2">
                                    <i class="bi bi-person-plus"></i> Buat Akun
                                </button>
                            </div>
                        </div>
                    </form>
                    <hr>
                    <p class="text-center mb-0 text-muted small">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="text-primary">Masuk di sini</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
