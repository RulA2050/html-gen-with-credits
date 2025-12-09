<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopupTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'phone_number',
        'amount_points',
        'status',
        'wa_sent_at',
        'wa_payload',
        'admin_id',
    ];

    protected $casts = [
        'wa_payload' => 'array',
        'wa_sent_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
