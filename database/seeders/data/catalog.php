<?php

/*
|--------------------------------------------------------------------------
| Datos iniciales del catálogo
|--------------------------------------------------------------------------
|
| Solo los usa CatalogSeeder (php artisan db:seed) para llenar la base de
| datos la primera vez. Después todo se administra desde el panel (/admin).
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

    /*
    | Productos — DATOS DE EJEMPLO para la maqueta.
    | Reemplazar con las fichas técnicas reales de cada equipo.
    |
    | specs       → los 4 datos que salen en la tarjeta del listado
    | highlights  → datos destacados en la cabecera del detalle
    | features    → ventajas (título + texto)
    | spec_groups → tabla de especificaciones agrupada
    | gallery     → imágenes del detalle (la primera es la principal)
    | brochure    → PDF opcional en public/ (ej. 'docs/ze215e-pro.pdf')
    */
    'products' => [
        [
            'slug' => 'ze215e-pro',
            'name' => 'ZE215E PRO',
            'brand' => 'Zoomlion',
            'category' => 'maquinaria-muevetierra',
            'type' => 'excavadoras',
            'tagline' => 'Potencia clásica, desempeño evolucionado.',
            'description' => 'Excavadora mediana para obra pesada, minería ligera y movimiento de tierra. Combina un motor Cummins de bajo consumo con un sistema hidráulico de alta eficiencia para trabajar más horas con menos mantenimiento.',
            'image' => 'images/products/ze215e-pro.png',
            'gallery' => [
                'images/products/ze215e-pro.png',
                'images/products/ze215e-pro-2.jpg',
                'images/products/ze215e-pro-3.jpg',
                'images/products/ze215e-pro-4.jpg',
            ],
            'specs' => [
                'Peso operativo' => '21.5 ton',
                'Capacidad de bote' => '1.0 m³',
                'Potencia nominal' => '125 kW',
                'Motor' => 'Cummins',
            ],
            'highlights' => [
                'Peso operativo' => '21,500 kg',
                'Potencia del motor' => '125 kW / 2,050 rpm',
                'Capacidad de bote' => '1.0 – 1.1 m³',
                'Radio máx. de excavación' => '9,900 mm',
                'Profundidad máx. de excavación' => '6,660 mm',
            ],
            'features' => [
                [
                    'title' => 'Hecha para el calor',
                    'text' => 'Sistema de enfriamiento reforzado para operar de forma continua en climas extremos como el de la península.',
                ],
                [
                    'title' => 'Eficiente y confiable',
                    'text' => 'Bomba principal de nueva generación y componentes clave con una vida útil hasta 20% mayor.',
                ],
                [
                    'title' => 'Cómoda y fácil de operar',
                    'text' => 'Cabina presurizada con aire acondicionado automático, asiento ergonómico y monitor a color.',
                ],
            ],
            'spec_groups' => [
                'Datos generales' => [
                    'Peso operativo' => '21,500 kg',
                    'Capacidad de bote' => '1.0 – 1.1 m³',
                    'Velocidad de giro' => '11.5 rpm',
                    'Velocidad de traslación (alta/baja)' => '5.5 / 3.3 km/h',
                ],
                'Motor' => [
                    'Marca / modelo' => 'Cummins QSB6.7',
                    'Potencia nominal' => '125 kW / 2,050 rpm',
                    'Desplazamiento' => '6.7 L',
                    'Capacidad del tanque' => '400 L',
                ],
                'Rango de operación' => [
                    'Radio máx. de excavación' => '9,900 mm',
                    'Profundidad máx. de excavación' => '6,660 mm',
                    'Altura máx. de corte' => '9,580 mm',
                    'Altura máx. de descarga' => '6,750 mm',
                ],
                'Dimensiones' => [
                    'Largo total' => '9,560 mm',
                    'Ancho total' => '2,990 mm',
                    'Altura total' => '3,030 mm',
                    'Ancho de zapata' => '600 mm',
                ],
            ],
            'brochure' => null,
        ],
        [
            'slug' => 'ze135e',
            'name' => 'ZE135E',
            'brand' => 'Zoomlion',
            'category' => 'maquinaria-muevetierra',
            'type' => 'excavadoras',
            'tagline' => 'Compacta, ágil y lista para cualquier obra.',
            'description' => 'Excavadora de 13 toneladas ideal para obra urbana, zanjas e infraestructura, con gran maniobrabilidad y bajo consumo de combustible.',
            'image' => 'images/products/ze135e.png',
            'gallery' => ['images/products/ze135e.png'],
            'specs' => [
                'Peso operativo' => '13.5 ton',
                'Capacidad de bote' => '0.6 m³',
                'Potencia nominal' => '74 kW',
                'Motor' => 'Cummins',
            ],
            'highlights' => [
                'Peso operativo' => '13,500 kg',
                'Potencia del motor' => '74 kW / 2,000 rpm',
                'Capacidad de bote' => '0.6 m³',
                'Profundidad máx. de excavación' => '5,500 mm',
            ],
            'features' => [],
            'spec_groups' => [],
            'brochure' => null,
        ],
        [
            'slug' => 'ze75e',
            'name' => 'ZE75E',
            'brand' => 'Zoomlion',
            'category' => 'maquinaria-muevetierra',
            'type' => 'excavadoras',
            'tagline' => 'Pequeña por fuera, poderosa en la obra.',
            'description' => 'Miniexcavadora para trabajos en espacios reducidos, jardinería, instalaciones hidráulicas y obra residencial.',
            'image' => 'images/products/ze75e.png',
            'gallery' => ['images/products/ze75e.png'],
            'specs' => [
                'Peso operativo' => '7.5 ton',
                'Capacidad de bote' => '0.3 m³',
                'Potencia nominal' => '43 kW',
                'Motor' => 'Yanmar',
            ],
            'highlights' => [
                'Peso operativo' => '7,500 kg',
                'Potencia del motor' => '43 kW / 2,100 rpm',
                'Capacidad de bote' => '0.3 m³',
                'Profundidad máx. de excavación' => '4,100 mm',
            ],
            'features' => [],
            'spec_groups' => [],
            'brochure' => null,
        ],
    ],

    // Marcas aliadas (los logos se suben desde el panel)
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
