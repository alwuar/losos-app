<?php

/*
|--------------------------------------------------------------------------
| Datos generales de Distribuidora Losos
|--------------------------------------------------------------------------
|
| Información de contacto, navegación y marcas que se reutilizan en el
| header, footer y páginas. Cambiar aquí actualiza todo el sitio.
|
*/

return [

    'name' => 'Distribuidora Losos',

    'tagline' => 'Donde la confianza se convierte en construcción.',

    'description' => 'Distribuidora mexicana de maquinaria de construcción nueva. Donde la confianza se convierte en construcción.',

    'contact' => [
        'email' => env('LOSOS_EMAIL', 'ventas@losos.mx'),
        'phone' => '999 234 1212',
        'phone_href' => '+529992341212',
        'whatsapp' => env('LOSOS_WHATSAPP', '529992341212'),
        'whatsapp_message' => 'Hola, me gustaría recibir información sobre su maquinaria.',
    ],

    'locations' => [
        'office' => [
            'name' => 'Oficina',
            'short' => 'Calle 116 núm 430 por 59F, Col. Bojorquez, Mérida, Yuc.',
            'full' => 'Calle 116 núm 430 por 59F, Col. Bojorquez. C.P. 97230, Mérida, Yucatán.',
        ],
        'showroom' => [
            'name' => 'Patio de exhibición',
            'short' => 'Periférico–Ticimul Km 3.5, Fracc. Santa Cruz. C.P. 97394',
            'full' => 'Periférico–Ticimul Km 3.5, Fracc. Santa Cruz. C.P. 97394, Umán, Yucatán.',
        ],
    ],

    'social' => [
        'facebook' => env('LOSOS_FACEBOOK_URL', '#'),
        'instagram' => env('LOSOS_INSTAGRAM_URL', '#'),
    ],

    // Navegación principal (nombre de ruta => etiqueta)
    'navigation' => [
        'home' => 'Inicio',
        'about' => 'Quienes somos',
        'products.index' => 'Productos',
        'services' => 'Servicios',
        'contact' => 'Contacto',
    ],

    // Marcas aliadas. Coloca los logos en public/images/brands/
    'brands' => [
        ['name' => 'Zoomlion', 'logo' => 'images/brands/zoomlion.png'],
        ['name' => 'Manitou', 'logo' => 'images/brands/manitou.png'],
        ['name' => 'Ammann', 'logo' => 'images/brands/ammann.png'],
        ['name' => 'Case', 'logo' => 'images/brands/case.png'],
        ['name' => 'Mega', 'logo' => 'images/brands/mega.png'],
        ['name' => 'Soosan', 'logo' => 'images/brands/soosan.png'],
        ['name' => 'Eedy', 'logo' => 'images/brands/eedy.png'],
        ['name' => 'Donaldson', 'logo' => 'images/brands/donaldson.png'],
        ['name' => 'Lubral', 'logo' => 'images/brands/lubral.png'],
    ],

];
