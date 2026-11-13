<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\ContactMessage;
use App\Support\Catalog;
use App\Support\NerbyLeads;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function show(Catalog $catalog): View
    {
        return view('pages.contact', [
            'equipment' => $catalog->equipmentOptions(),
            'locations' => config('losos.locations'),
        ]);
    }

    public function store(ContactRequest $request, NerbyLeads $nerby): RedirectResponse
    {
        $data = $request->validated();

        // Primero se guarda aquí; así ningún mensaje se pierde aunque Nerby no responda.
        $message = ContactMessage::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone' => trim($data['phone_code'].' '.$data['phone']),
            'company' => $data['company'] ?? null,
            'equipment' => $data['equipment'] ?? null,
            'page_url' => Str::limit((string) $request->headers->get('referer'), 290, ''),
        ]);

        if (! $nerby->send($message) && $nerby->enabled()) {
            Log::warning('Mensaje de contacto pendiente de llegar a Nerby', ['id' => $message->id, 'error' => $message->nerby_error]);
        } elseif ($nerby->enabled()) {
            // De paso se reintentan los que se quedaron pendientes antes
            $nerby->retryPending(3);
        }

        return redirect()
            ->route('contact')
            ->with('status', 'Gracias por escribirnos. Te contactaremos muy pronto.');
    }
}
