<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * Guarda los archivos subidos desde el panel en storage/app/public
 * (visible en /storage gracias a "php artisan storage:link").
 *
 * Las rutas se guardan como "storage/carpeta/archivo.jpg" para que las vistas
 * las usen igual que las imágenes de public/images (asset()).
 */
class Uploads
{
    public static function store(UploadedFile $file, string $folder): string
    {
        return 'storage/'.$file->store($folder, 'public');
    }

    /**
     * Borra un archivo subido. Las imágenes por defecto de public/images no se tocan.
     */
    public static function delete(?string $path): void
    {
        if ($path && str_starts_with($path, 'storage/')) {
            Storage::disk('public')->delete(substr($path, strlen('storage/')));
        }
    }
}
