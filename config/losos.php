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

    /*
    | Imágenes fijas de las secciones. Se reemplazan desde el panel
    | (/admin → Imágenes del sitio); "default" es la que se usa mientras no
    | se haya subido otra.
    */
    'site_images' => [
        'home.hero' => [
            'label' => 'Inicio · Imagen principal',
            'help' => 'Fondo del encabezado de Inicio. JPG horizontal de 1920 × 840 px aprox.',
            'default' => 'images/home/hero.jpg',
        ],
        'about.history' => [
            'label' => 'Quiénes somos · Nuestra historia',
            'help' => 'Imagen cuadrada, 900 × 900 px aprox.',
            'default' => 'images/about/historia.jpg',
        ],
        'services.renta' => [
            'label' => 'Servicios · Renta de maquinaria',
            'help' => 'Horizontal, 900 × 480 px aprox.',
            'default' => 'images/services/renta.jpg',
        ],
        'services.refacciones' => [
            'label' => 'Servicios · Refacciones y lubricantes',
            'help' => 'Horizontal, 900 × 480 px aprox.',
            'default' => 'images/services/refacciones.jpg',
        ],
        'services.servicio-tecnico' => [
            'label' => 'Servicios · Servicio técnico',
            'help' => 'Horizontal, 900 × 480 px aprox.',
            'default' => 'images/services/servicio-tecnico.jpg',
        ],
    ],

];
