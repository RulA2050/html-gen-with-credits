<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HtmlAsset extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'logical_key',
        'library',
        'type',
        'url',
        'position',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Asset default berdasarkan library (plus global).
     * Dipakai buat Bootstrap/Tailwind default.
     */
    public function scopeForLibrary($query, string $library)
    {
        return $query->where('is_active', true)
            ->where(function ($q) use ($library) {
                $q->where('library', $library)
                    ->orWhere('library', 'global');
            })
            ->orderBy('sort_order');
    }

    /**
     * Asset berdasarkan logical key (fontawesome, swiper, dll).
     */
    public function scopeForLogicalKeys($query, array $keys)
    {
        return $query->where('is_active', true)
            ->whereIn('logical_key', $keys)
            ->orderBy('sort_order');
    }
}
