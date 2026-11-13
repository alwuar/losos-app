<?php

namespace App\Support;

use App\Models\ContactMessage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Throwable;

/**
 * Manda los mensajes de contacto a Nerby, donde quedan como prospectos.
 * La dirección (con su clave) sale de Nerby → Ventas → Recibir de mi sitio y va en NERBY_PROSPECTOS_URL.
 */
class NerbyLeads
{
    /** Después de tantos intentos se deja de reintentar solo; el mensaje sigue guardado. */
    public const MAX_ATTEMPTS = 30;

    public function enabled(): bool
    {
        return filled(config('services.nerby.leads_url'));
    }

    /** Manda un mensaje. Devuelve si Nerby lo recibió; si no, queda pendiente con el motivo. */
    public function send(ContactMessage $message): bool
    {
        if (! $this->enabled() || $message->nerby_sent_at) {
            return (bool) $message->nerby_sent_at;
        }

        $message->increment('nerby_attempts');

        try {
            $response = Http::asForm()->acceptJson()->timeout(6)->connectTimeout(4)
                ->post(config('services.nerby.leads_url'), [
                    'nombre' => $message->first_name,
                    'apellido' => $message->last_name,
                    'correo' => $message->email,
                    'telefono' => $message->phone,
                    'empresa' => $message->company,
                    'interes' => $message->equipment,
                    'mensaje' => $message->equipment
                        ? "Pidió información de: {$message->equipment}"
                        : 'Escribió desde el formulario de contacto.',
                ]);

            if ($response->successful() && $response->json('ok') === true) {
                $message->forceFill(['nerby_sent_at' => now(), 'nerby_error' => null])->save();

                return true;
            }

            $error = 'Nerby respondió '.$response->status().': '.$response->body();
        } catch (Throwable $e) {
            $error = $e->getMessage();
        }

        $message->forceFill(['nerby_error' => Str::limit($error, 290)])->save();

        return false;
    }

    /** Reintenta los pendientes, del más viejo al más nuevo. Devuelve cuántos llegaron. */
    public function retryPending(int $limit = 20): int
    {
        if (! $this->enabled()) {
            return 0;
        }

        return ContactMessage::pending()
            ->where('nerby_attempts', '<', self::MAX_ATTEMPTS)
            ->oldest('id')
            ->limit($limit)
            ->get()
            ->filter(fn (ContactMessage $message) => $this->send($message))
            ->count();
    }
}
