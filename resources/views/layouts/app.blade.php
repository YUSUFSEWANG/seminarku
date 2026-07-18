<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SeminarKu') - Sistem Pendaftaran Kegiatan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .sidebar { min-height: 100vh; background: #1e3a5f; }
        .sidebar .nav-link { color: #adb5bd; padding: 0.6rem 1.2rem; border-radius: 6px; margin: 2px 8px; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background: rgba(255,255,255,0.1); color: #fff; }
        .sidebar .nav-link i { width: 20px; }
        .navbar-brand { font-weight: 700; color: #1e3a5f !important; }
        .card { border: none; box-shadow: 0 2px 8px rgba(0,0,0,0.07); }
        .stat-card { border-left: 4px solid; }
        .badge-status-pending { background-color: #ffc107; color: #000; }
        .badge-status-dikonfirmasi { background-color: #198754; }
        .badge-status-dibatalkan { background-color: #dc3545; }
    </style>
    @stack('styles')
</head>
<body>
<div class="d-flex">
    {{-- Sidebar --}}
    <div class="sidebar d-flex flex-column p-0" style="width:240px; min-width:240px;">
        <div class="p-3 text-center border-bottom border-secondary">
            <h5 class="text-white mb-0 fw-bold"><i class="bi bi-calendar-event"></i> SeminarKu</h5>
            <small class="text-muted">
                @auth
                    {{ auth()->user()->isAdmin() ? 'Panel Admin' : 'Portal Peserta' }}
                @endauth
            </small>
        </div>
        <nav class="flex-grow-1 py-3">
            @auth
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                    <a href="{{ route('admin.kegiatan.index') }}" class="nav-link {{ request()->routeIs('admin.kegiatan.*') ? 'active' : '' }}">
                        <i class="bi bi-calendar-check"></i> Kegiatan
                    </a>
                    <a href="{{ route('admin.pendaftaran.index') }}" class="nav-link {{ request()->routeIs('admin.pendaftaran.*') ? 'active' : '' }}">
                        <i class="bi bi-person-check"></i> Pendaftaran
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <i class="bi bi-people"></i> Pengguna
                    </a>
                @else
                    <a href="{{ route('user.dashboard') }}" class="nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-house"></i> Dashboard
                    </a>
                    <a href="{{ route('user.kegiatan.index') }}" class="nav-link {{ request()->routeIs('user.kegiatan.*') ? 'active' : '' }}">
                        <i class="bi bi-calendar-event"></i> Kegiatan
                    </a>
                    <a href="{{ route('user.pendaftaran.index') }}" class="nav-link {{ request()->routeIs('user.pendaftaran.*') ? 'active' : '' }}">
                        <i class="bi bi-ticket-perforated"></i> Pendaftaran Saya
                    </a>
                @endif
                <hr class="border-secondary mx-3">
                <a href="{{ route('profile.edit') }}" class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                    <i class="bi bi-person-circle"></i> Profil
                </a>
            @endauth
        </nav>
        <div class="p-3 border-top border-secondary">
            @auth
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-light btn-sm w-100">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
            @endauth
        </div>
    </div>

    {{-- Main Content --}}
    <div class="flex-grow-1 d-flex flex-column" style="min-width:0;">
        <nav class="navbar navbar-expand navbar-light bg-white border-bottom px-4 py-2">
            <span class="navbar-brand mb-0">@yield('page-title', 'Dashboard')</span>
            <div class="ms-auto d-flex align-items-center gap-3">
                @auth
                <span class="text-muted small">
                    <i class="bi bi-person-fill"></i> {{ auth()->user()->name }}
                    <span class="badge {{ auth()->user()->isAdmin() ? 'bg-danger' : 'bg-primary' }} ms-1">
                        {{ auth()->user()->isAdmin() ? 'Admin' : 'User' }}
                    </span>
                </span>
                @endauth
            </div>
        </nav>

        <main class="flex-grow-1 p-4">
            {{-- Alert Messages --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle"></i>
                    <ul class="mb-0 mt-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
