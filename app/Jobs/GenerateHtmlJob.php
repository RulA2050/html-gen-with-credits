<?php

namespace App\Jobs;

use App\Models\HtmlGeneration;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Firebase\JWT\JWT;


class GenerateHtmlJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        protected int $generationId,
        protected ?string $generate_html_url = null,
        protected ?string $secret = null,
    ) {
        $this->generate_html_url = $this->generate_html_url ?: config('services.n8n.generate_html_url');
        $this->secret = $this->secret ?: config('services.n8n.secret');
    }

    private function logError(HtmlGeneration $generation, \Throwable $e): void
    {
        $generation->user->increment('points', 3);

        $generation->update([
            'status' => 'FAILED',
            'error_message' => $e->getMessage(),
        ]);
    }
    public function handle(): void
    {
        $generation = HtmlGeneration::find($this->generationId);

        if (!$generation || $generation->status !== 'WAITING') {
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

        $generation->update(['status' => 'GENERATING']);

        try {
            $endpoint = config('services.n8n.generate_html_url');

            $response = Http::withHeader('Authorization', $authorization)->timeout(500)->post($endpoint, [
                'title' => $generation->title,
                'library' => $generation->library,
                'form_payload' => $generation->form_payload,
                'extra_prompt' => $generation->extra_prompt,
            ]);

            if ($response->failed()) {
                throw new \RuntimeException("n8n error: {$response->status()}");
            }
            if (! $response->successful()) {
                throw new \RuntimeException('n8n request was not successful.');
            }

            $data = $response->json();

            $generation->update([
                'status' => 'DONE',
                'html_full' => $data['html'] ?? null,
                'css_raw' => $data['css'] ?? null,
                'js_raw' => $data['js'] ?? null,
                'assets' => $data['assets'] ?? [],
                'editor_schema' => $data['editor_schema'] ?? null,
                'error_message' => null,
            ]);
        } catch (\Throwable $e) {
            $this->logError($generation, $e);
        }
    }
}
