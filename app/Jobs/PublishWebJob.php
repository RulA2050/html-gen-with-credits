<?php

namespace App\Jobs;

use App\Models\HtmlGeneration;
use App\Models\PublishHtml;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Firebase\JWT\JWT;


class PublishWebJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        protected int $generationId,
        protected ?string $url = null,
        protected ?string $fullHtml,
        protected ?string $publish_url = null,
        protected ?string $secret = null,
    ) {
        $this->publish_url = $this->publish_url ?: config('services.n8n.publish_url');
        $this->secret = $this->secret ?: config('services.n8n.secret');
    }

    public function handle(): void
    {
        $generation = HtmlGeneration::find($this->generationId);

        $publishHtml = PublishHtml::where('html_generation_id', $this->generationId)->first();
        if( $publishHtml->status === 'PUBLISHED' ) {
            // Already published
            return;
        }

        $payload = [
            'generation_id' => $this->generationId,
            'timestamp' => time(),
            'user_id' => $generation->user_id,
            'exp' => time() + 300,
            'iat' => time(),
        ];

        $authorization = JWT::encode($payload, $this->secret, 'HS256');
        $authorization = "Bearer {$authorization}";

        $publishHtml->update(['status' => 'PREPARING_PUBLISH']);

        try {
            $endpoint = config('services.n8n.publish_url');

            $response = Http::withHeader('Authorization', $authorization)->timeout(500)->post($endpoint, [
                'title' => $generation->title,
                'html_content' => $this->fullHtml,
                'url' => $this->url,
            ]);


            if ($response->failed()) {
                throw new \RuntimeException("n8n error: {$response->status()}");
            }
            if (! $response->successful()) {
                throw new \RuntimeException('n8n request was not successful.');
            }

            $data = $response->json();

            $publishHtml->update([
                'url' => $data['url'] ?? $this->url,
                'status' => 'PUBLISHED',
            ]);
        } catch (\Throwable $e) {
            \Log::error('PublishWebJob error: ' . $e->getMessage());
            $publishHtml->update([
                'status' => 'FAILED',
            ]);
            return;
        }
    }
}
