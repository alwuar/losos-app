@props(['title' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex, nofollow">

    <title>{{ $title ? $title.' · ' : '' }}Panel · {{ config('losos.name') }}</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}">

    @vite(['resources/scss/admin.scss', 'resources/js/admin.js'])
</head>
<body class="admin">
    <aside class="admin-sidebar" id="admin-sidebar">
        <a href="{{ route('admin.dashboard') }}" class="admin-sidebar__brand">
            <x-brand.logo />
            <span>Panel</span>
        </a>

        <x-admin.nav />

        <div class="admin-sidebar__footer">
            <a href="{{ route('home') }}" target="_blank" rel="noopener" class="admin-nav__link">
                <i class="bi bi-box-arrow-up-right" aria-hidden="true"></i> Ver sitio
            </a>

            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="admin-nav__link">
                    <i class="bi bi-door-open" aria-hidden="true"></i> Cerrar sesión
                </button>
            </form>
        </div>
    </aside>

    <div class="admin-main">
        <header class="admin-topbar">
            <button type="button" class="admin-topbar__toggle" data-admin-sidebar-toggle aria-controls="admin-sidebar" aria-label="Menú">
                <i class="bi bi-list" aria-hidden="true"></i>
            </button>
            <span class="admin-topbar__user">
                <i class="bi bi-person-circle" aria-hidden="true"></i> {{ auth()->user()->name }}
            </span>
        </header>

        <main class="admin-content">
            <x-admin.flash />

            {{ $slot }}
        </main>
    </div>
</body>
</html>
