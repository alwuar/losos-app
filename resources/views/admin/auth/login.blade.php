<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>Iniciar sesión · Panel · {{ config('losos.name') }}</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    @vite(['resources/scss/admin.scss', 'resources/js/admin.js'])
</head>
<body class="admin">
    <main class="admin-login">
        <div class="admin-login__card">
            <div class="admin-login__logo"><x-brand.logo /></div>

            <h1 class="admin-login__title">Panel administrativo</h1>
            <p class="admin-login__text">Inicia sesión para administrar el sitio.</p>

            <form method="POST" action="{{ route('admin.login.store') }}" class="admin-form" novalidate>
                @csrf

                <x-forms.input name="email" type="email" label="Correo" autocomplete="username" required autofocus />
                <x-forms.input name="password" type="password" label="Contraseña" autocomplete="current-password" required />

                <div class="form-check mt-3">
                    <input class="form-check-input" type="checkbox" name="remember" value="1" id="remember">
                    <label class="form-check-label" for="remember">Mantener la sesión iniciada</label>
                </div>

                <x-ui.button type="submit" class="w-100 mt-4" style="height: 42px">Entrar</x-ui.button>
            </form>
        </div>
    </main>
</body>
</html>
