<?php

namespace App\Http\Controllers;

use App\Support\Catalog;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(Catalog $catalog): View
    {
        return view('pages.home', [
            'features' => [
                [
                    'title' => 'Calidad de primer nivel',
                    'text' => 'Solo trabajamos con equipos de marcas reconocidas, con garantía de rendimiento y durabilidad.',
                ],
                [
                    'title' => 'Soporte completo',
                    'text' => 'Asesoramiento y servicio postventa para que tu equipo siga operando al máximo nivel.',
                ],
                [
                    'title' => 'Asesoría personalizada',
                    'text' => 'Un equipo de expertos te ayuda a elegir el equipo adecuado para tu proyecto.',
                ],
                [
                    'title' => 'Más allá de la venta',
                    'text' => 'Te acompañamos con confianza y honestidad durante todo el ciclo de vida de tu equipo.',
                ],
            ],
            'categories' => $catalog->categories(),
            'services' => $catalog->services(),
            'brands' => $catalog->brands(),
        ]);
    }
}
