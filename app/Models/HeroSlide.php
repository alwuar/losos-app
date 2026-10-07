<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Diapositiva del encabezado de Inicio: imagen, título, texto y hasta dos botones.
 */
#[Fillable([
    'image', 'title', 'text',
    'primary_label', 'primary_url',
    'secondary_label', 'secondary_url',
    'is_active', 'sort_order',
])]
class HeroSlide extends Model
{
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true);
    }

    public function scopeOrdered(Builder $query): void
    {
        $query->orderBy('sort_order')->orderBy('id');
    }

    /**
     * Botones con texto y enlace, en orden: [['label', 'url', 'variant', 'external'], ...]
     */
    public function buttons(): array
    {
        return collect([
            [$this->primary_label, $this->primary_url, 'primary'],
            [$this->secondary_label, $this->secondary_url, 'outline-light'],
        ])
            ->filter(fn (array $button) => filled($button[0]) && filled($button[1]))
            ->map(fn (array $button) => [
                'label' => $button[0],
                'url' => str_starts_with($button[1], '/') ? url($button[1]) : $button[1],
                'variant' => $button[2],
                'external' => str_starts_with($button[1], 'http') && parse_url($button[1], PHP_URL_HOST) !== request()->getHost(),
            ])
            ->values()
            ->all();
    }
}
