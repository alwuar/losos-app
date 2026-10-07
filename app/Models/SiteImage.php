<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Throwable;

/**
 * Imágenes fijas de las secciones del sitio (hero, nuestra historia, servicios…).
 *
 * Las claves y las imágenes por defecto están en config/losos.php (site_images).
 * En las vistas: SiteImage::path('home.hero')
 */
#[Fillable(['key', 'label', 'help', 'path', 'sort_order'])]
class SiteImage extends Model
{
    /** @var array<string, string|null>|null */
    protected static ?array $cache = null;

    /**
     * Ruta pública de la imagen (la subida desde el panel o la de config/losos.php).
     */
    public static function path(string $key, ?string $fallback = null): ?string
    {
        if (static::$cache === null) {
            try {
                static::$cache = static::query()->pluck('path', 'key')->all();
            } catch (Throwable) {
                static::$cache = []; // sin base de datos todavía: se usan las imágenes por defecto
            }
        }

        // Las claves llevan punto (home.hero), por eso no se usa config('losos.site_images.home.hero')
        return static::$cache[$key] ?? $fallback ?? (config('losos.site_images')[$key]['default'] ?? null);
    }

    public static function flushCache(): void
    {
        static::$cache = null;
    }
}
