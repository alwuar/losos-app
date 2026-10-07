<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Support\Catalog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
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

    public function store(ContactRequest $request): RedirectResponse
    {
        // Pendiente: enviar por correo / guardar en CRM.
        Log::info('Nuevo mensaje de contacto', $request->validated());

        return redirect()
            ->route('contact')
            ->with('status', 'Gracias por escribirnos. Te contactaremos muy pronto.');
    }
}
