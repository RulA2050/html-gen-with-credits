<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HtmlGeneration extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'library',
        'status',
        'form_payload',
        'extra_prompt',
        'html_full',
        'css_raw',
        'js_raw',
        'editor_schema',
        'error_message',
    ];

    protected $casts = [
        'form_payload' => 'array',
        'editor_schema' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

