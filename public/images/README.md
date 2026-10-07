# Imágenes por defecto del sitio

Las imágenes de productos, categorías, marcas y secciones se suben desde el
panel administrativo (`/admin`) y se guardan en `storage/app/public`
(visibles en `/storage` después de `php artisan storage:link`).

Esta carpeta solo guarda las imágenes que trae el sitio de inicio:

| Ruta | Uso |
| --- | --- |
| `brand/logo-losos.png` | Logo del header, footer y panel |
| `home/hero.jpg` | Foto principal de Inicio (se puede reemplazar desde el panel) |
| `categories/*.jpg` | Imágenes iniciales de las categorías |

Mientras falte una imagen, el sitio muestra un recuadro gris en su lugar.
