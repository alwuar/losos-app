<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'slug', 'label', 'card_title', 'summary', 'excerpt', 'description', 'image', 'benefits', 'sort_order'])]
class Category extends Model
{
    protected function casts(): array
    {
        return [
            'benefits' => 'array',
        ];
    }

    public function types(): HasMany
    {
        return $this->hasMany(ProductType::class)->orderBy('sort_order')->orderBy('id');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function scopeOrdered(Builder $query): void
    {
        $query->orderBy('sort_order')->orderBy('id');
    }
}
