<?php

/*
|--------------------------------------------------------------------------
| Catálogo de productos y servicios
|--------------------------------------------------------------------------
|
| Contenido de la maqueta. Cuando el catálogo pase a base de datos basta con
| reemplazar App\Support\Catalog por consultas a modelos: las vistas reciben
| los mismos arreglos.
|
| Imágenes: public/images/... (si el archivo no existe se muestra un
| placeholder gris con la ruta esperada).
|
*/

return [

    'categories' => [

        'maquinaria-muevetierra' => [
            'name' => 'Maquinaria Muevetierra',
            'label' => 'Categoría',
            'summary' => 'Excavadoras · Cargadores · Retroexcavadoras · Bulldozers · Motoniveladoras',
            'excerpt' => 'Excavadoras, cargadores, retroexcavadoras, bulldozers y motoniveladoras.',
            'description' => 'Ideal para afrontar terrenos difíciles, con equipos que destacan por su resistencia, eficiencia y tecnología avanzada.',
            'image' => 'images/categories/maquinaria-muevetierra.jpg',
            'benefits' => [
                'Alta durabilidad y resistencia',
                'Tecnología de confianza',
                'Bajo costo de mantenimiento',
            ],
            'types' => [
                'excavadoras' => 'Excavadoras',
                'cargadores' => 'Cargadores',
                'retroexcavadoras' => 'Retroexcavadoras',
                'bulldozers' => 'Bulldozers',
                'motoniveladoras' => 'Motoniveladoras',
            ],
        ],

        'equipo-industrial' => [
            'name' => 'Equipo Industrial',
            'label' => 'Industrial',
            'card_title' => 'Monta cargas',
            'summary' => 'Montacargas · Plataformas de elevación',
            'excerpt' => 'Plataformas de elevación y montacargas para tareas en altura y transporte de materiales.',
            'description' => 'Equipos para tareas en altura y movimiento de materiales, pensados para operar de forma segura y eficiente.',
            'image' => 'images/categories/equipo-industrial.jpg',
            'benefits' => [
                'Operación segura en altura',
                'Maniobrabilidad en espacios reducidos',
                'Respaldo de servicio postventa',
            ],
            'types' => [
                'montacargas' => 'Montacargas',
                'plataformas-de-elevacion' => 'Plataformas de elevación',
            ],
        ],

    ],

    // Productos de ejemplo para la maqueta (reemplazar por el catálogo real)
    'products' => [
        [
            'slug' => 'ze215e-pro',
            'name' => 'ZE215E PRO',
            'category' => 'maquinaria-muevetierra',
            'type' => 'excavadoras',
            'image' => 'images/products/ze215e-pro.png',
            'specs' => [
                'Peso operativo' => '21.5 ton',
                'Capacidad de bote' => '1.0 m³',
                'Potencia nominal' => '125 kW',
                'Motor' => 'Cummins',
            ],
        ],
        [
            'slug' => 'ze215e-pro-2',
            'name' => 'ZE215E PRO',
            'category' => 'maquinaria-muevetierra',
            'type' => 'excavadoras',
            'image' => 'images/products/ze215e-pro.png',
            'specs' => [
                'Peso operativo' => '21.5 ton',
                'Capacidad de bote' => '1.0 m³',
                'Potencia nominal' => '125 kW',
                'Motor' => 'Cummins',
            ],
        ],
        [
            'slug' => 'ze215e-pro-3',
            'name' => 'ZE215E PRO',
            'category' => 'maquinaria-muevetierra',
            'type' => 'excavadoras',
            'image' => 'images/products/ze215e-pro.png',
            'specs' => [
                'Peso operativo' => '21.5 ton',
                'Capacidad de bote' => '1.0 m³',
                'Potencia nominal' => '125 kW',
                'Motor' => 'Cummins',
            ],
        ],
    ],

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
