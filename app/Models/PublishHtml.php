<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PublishHtml extends Model
{
    protected $table = 'publish_htmls';
    protected $fillable = [
        'title',
        'url',
        'html_generation_id',
        'status',
    ];

    public function htmlGeneration()
    {
        return $this->belongsTo(HtmlGeneration::class);
    }
}
