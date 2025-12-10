<?php

namespace App\Services;

use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Http;

class WhatsAppService
{
    public function __construct(
        protected ?string $secret = null,
        protected ?string $clientIds = null,
    ) {
        $this->secret = $this->secret ?: config('services.wacserv.secret');
        $this->clientIds = $this->clientIds ?: config('services.wacserv.client_id');
    }

    public function sendMessage(int|string $userId, string $phoneNumber, string $message, ?string $clientId = null): void
    {
        $clientId = $clientId ?: ($this->clientIds ?? null);

        if (! $clientId || ! $this->secret) {
            throw new \RuntimeException('WA config missing.');
        }

        $now = time();

        $payload = [
            'user_id' => $userId,
            'role' => 'ci4',
            'client_ids' => $clientId,
            'iat' => $now,
            'exp' => $now + 60 * 5,
        ];

        $jwt = JWT::encode($payload, $this->secret, 'HS256');
        $jwt = "Bearer {$jwt}";
        $url = "https://wacserv.usaha-ku.com/api/fitur/{$clientId}/send-message";

        $response = Http::withHeaders([
            'Authorization' => $jwt,
        ])->post($url, [
            'messages' => $message,
            'phone_number' => $phoneNumber,
        ]);

        if ($response->failed()) {
            throw new \RuntimeException(
                'Failed to send WA message: ' . $response->status() . ' - ' . $response->body() . ' - Client ID' . $clientId
            );
        }
        if($response->successful()){
            Log::info('wa message sent successfully to '.$phoneNumber.' with client id '.$clientId);
        }
    }
}
