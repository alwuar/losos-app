<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'category_id', 'product_type_id', 'name', 'slug', 'brand', 'tagline', 'description',
    'card_specs', 'highlights', 'features', 'spec_groups', 'brochure', 'is_published', 'sort_order',
])]
class Product extends Model
{
    protected function casts(): array
    {
        return [
            'card_specs' => 'array',   // [['label' => '', 'value' => ''], …]
            'highlights' => 'array',   // [['label' => '', 'value' => ''], …]
            'features' => 'array',     // [['title' => '', 'text' => ''], …]
            'spec_groups' => 'array',  // [['title' => '', 'rows' => [['label' => '', 'value' => '']]], …]
            'is_published' => 'boolean',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(ProductType::class, 'product_type_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order')->orderBy('id');
    }

    public function scopePublished(Builder $query): void
    {
        $query->where('is_published', true);
    }

    public function scopeOrdered(Builder $query): void
    {
        $query->orderBy('sort_order')->orderBy('id');
    }

    public function coverImage(): ?string
    {
        return $this->images->first()?->path;
    }
}
