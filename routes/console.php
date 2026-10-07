<?php

use App\Models\User;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/*
| Crea (o actualiza) un usuario para entrar al panel /admin.
|   php artisan losos:admin
*/
Artisan::command('losos:admin {email?} {--name=}', function (?string $email = null) {
    $email ??= $this->ask('Correo del administrador');
    $name = $this->option('name') ?: $this->ask('Nombre', 'Administrador');
    $password = $this->secret('Contraseña (mínimo 8 caracteres)');

    if (! filter_var($email, FILTER_VALIDATE_EMAIL) || strlen((string) $password) < 8) {
        $this->error('Correo inválido o contraseña muy corta.');

        return 1;
    }

    User::updateOrCreate(['email' => $email], ['name' => $name, 'password' => $password]);

    $this->info("Listo: {$email} ya puede entrar a /admin");

    return 0;
})->purpose('Crear o actualizar un usuario del panel administrativo');
