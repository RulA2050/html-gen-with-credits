<?php

namespace App\Notifications\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;

class WhatsAppChannel
{
    public function send($notifiable, Notification $notification): void
    {
        // Ambil tujuan (nomor WA) dari model
        if (! $to = $notifiable->routeNotificationForWhatsApp()) {
            return;
        }

        // Data pesan dari notification
        $data = $notification->toWhatsApp($notifiable);

        // Contoh: kirim ke API WA kamu sendiri
        Http::post(config('services.whatsapp.endpoint') . '/send', [
            'to'      => $to,
            'message' => $data['message'],
            // tambahin param lain kalau perlu (token, template_id, dsb)
            // 'token' => config('services.whatsapp.token'),
        ]);
    }
}
