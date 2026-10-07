<?php

/*
|--------------------------------------------------------------------------
| Servicios
|--------------------------------------------------------------------------
|
| Textos de la página de Servicios. Las imágenes de cada servicio se cambian
| desde el panel (/admin → Imágenes del sitio). Productos, categorías y
| marcas viven en la base de datos.
|
*/

return [

    'services' => [
        'renta' => [
            'number' => '01',
            'label' => 'Renta',
            'title' => 'Renta de maquinaria',
            'excerpt' => 'Renta de maquinaria de construcción para proyectos de corto y largo plazo.',
            'description' => 'Renta de maquinaria de construcción para proyectos de corto y largo plazo, con el respaldo y la asesoría de Distribuidora Losos.',
            'cta' => 'Solicitar más información',
            'image' => 'images/services/renta.jpg',
        ],
        'refacciones' => [
            'number' => '02',
            'label' => 'Refacciones',
            'title' => 'Refacciones y lubricantes',
            'excerpt' => 'Partes 100% originales y lubricantes Lubral para proteger el rendimiento de tu equipo.',
            'description' => 'Refacciones y partes 100% originales para tu equipo, además de lubricantes de marca Lubral. Trabajar con refacciones originales protege el rendimiento y la vida útil de tu maquinaria.',
            'brand' => 'Lubral',
            'image' => 'images/services/refacciones.jpg',
        ],
        'servicio-tecnico' => [
            'number' => '03',
            'label' => 'Servicio técnico',
            'title' => 'Servicio técnico en sitio',
            'excerpt' => 'Mantenimiento preventivo y correctivo especializado, con técnicos capacitados.',
            'description' => 'Servicio de mantenimiento preventivo y correctivo especializado, en sitio, con técnicos capacitados en las marcas que distribuimos.',
            'cta' => 'Agendar servicio',
            'image' => 'images/services/servicio-tecnico.jpg',
        ],
    ],

];
