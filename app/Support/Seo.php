<?php

namespace App\Support;

use Illuminate\Support\Str;

/**
 * Ayudantes para meta tags y datos estructurados (schema.org).
 */
class Seo
{
    /**
     * Texto plano de hasta 160 caracteres para meta description.
     */
    public static function description(?string $text, int $limit = 160): string
    {
        $text = Str::squish(strip_tags((string) $text));

        return Str::limit($text ?: config('losos.description'), $limit, '…');
    }

    /**
     * URL absoluta de una imagen local (o externa) para Open Graph.
     *
     * @return array{url: string, width: int|null, height: int|null}|null
     */
    public static function image(?string $path): ?array
    {
        if (blank($path)) {
            return null;
        }

        if (str_starts_with($path, 'http')) {
            return ['url' => $path, 'width' => null, 'height' => null];
        }

        $file = public_path($path);

        if (! is_file($file)) {
            return null;
        }

        [$width, $height] = @getimagesize($file) ?: [null, null];

        return ['url' => asset($path), 'width' => $width, 'height' => $height];
    }

    /**
     * La empresa como negocio local (se publica en todas las páginas).
     */
    public static function business(): array
    {
        $contact = config('losos.contact');
        $office = config('losos.locations.office');

        return array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'LocalBusiness',
            '@id' => url('/#empresa'),
            'name' => config('losos.name'),
            'description' => config('losos.description'),
            'slogan' => config('losos.tagline'),
            'url' => route('home'),
            'logo' => asset('images/brand/logo-losos.png'),
            'image' => asset(config('losos.seo.image')),
            'email' => $contact['email'],
            'telephone' => $contact['phone_href'],
            'address' => static::address($office),
            'location' => collect(config('losos.locations'))
                ->map(fn (array $place) => [
                    '@type' => 'Place',
                    'name' => $place['name'],
                    'address' => static::address($place),
                ])
                ->values()
                ->all(),
            'areaServed' => ['@type' => 'Country', 'name' => 'México'],
            'sameAs' => collect(config('losos.social'))
                ->filter(fn ($url) => filled($url) && str_starts_with($url, 'http'))
                ->values()
                ->all(),
        ]);
    }

    public static function website(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            '@id' => url('/#sitio'),
            'name' => config('losos.name'),
            'url' => route('home'),
            'inLanguage' => config('losos.seo.lang'),
            'publisher' => ['@id' => url('/#empresa')],
        ];
    }

    /**
     * @param  array<int, array{label: string, url?: string|null}>  $items
     */
    public static function breadcrumbs(array $items): array
    {
        $items = [['label' => 'Inicio', 'url' => route('home')], ...$items];

        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => collect($items)->values()->map(fn (array $item, int $index) => array_filter([
                '@type' => 'ListItem',
                'position' => $index + 1,
                'name' => $item['label'],
                'item' => $item['url'] ?? url()->current(),
            ]))->all(),
        ];
    }

    protected static function address(array $place): array
    {
        return array_filter([
            '@type' => 'PostalAddress',
            'streetAddress' => $place['street'] ?? $place['full'] ?? null,
            'addressLocality' => $place['locality'] ?? null,
            'addressRegion' => $place['region'] ?? null,
            'postalCode' => $place['postal_code'] ?? null,
            'addressCountry' => 'MX',
        ]);
    }
}
