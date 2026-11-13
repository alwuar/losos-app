<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Mensaje del formulario de contacto. Se guarda siempre y luego se manda a Nerby,
 * donde queda como prospecto en el embudo de ventas.
 */
#[Fillable([
    'first_name', 'last_name', 'email', 'phone', 'company', 'equipment', 'page_url',
])]
class ContactMessage extends Model
{
    protected function casts(): array
    {
        return [
            'nerby_sent_at' => 'datetime',
        ];
    }

    /** Los que todavía no llegan a Nerby. */
    public function scopePending(Builder $query): void
    {
        $query->whereNull('nerby_sent_at');
    }
}
