<?php

use App\Models\ContactMessage;
use App\Models\User;
use App\Support\NerbyLeads;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

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

/*
| Reintenta mandar a Nerby los mensajes de contacto que se quedaron pendientes.
|   php artisan losos:prospectos
| Con el cron del scheduler corre solo cada 10 minutos.
*/
Artisan::command('losos:prospectos', function (NerbyLeads $nerby) {
    if (! $nerby->enabled()) {
        $this->warn('Falta NERBY_PROSPECTOS_URL en el .env: los mensajes se guardan, pero no se mandan a Nerby.');

        return 1;
    }

    $sent = $nerby->retryPending(50);
    $pending = ContactMessage::pending()->count();

    $this->info("Enviados: {$sent} · pendientes: {$pending}");
    if ($pending && ($last = ContactMessage::pending()->latest('id')->value('nerby_error'))) {
        $this->line("Último motivo: {$last}");
    }

    return 0;
})->purpose('Mandar a Nerby los mensajes de contacto pendientes');

Schedule::command('losos:prospectos')->everyTenMinutes()->withoutOverlapping();
