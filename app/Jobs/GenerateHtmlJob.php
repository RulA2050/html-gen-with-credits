<?php

namespace App\Jobs;

use App\Models\HtmlGeneration;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class GenerateHtmlJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        protected int $generationId
    ) {}

    public function handle(): void
    {
        $generation = HtmlGeneration::find($this->generationId);

        if (! $generation || $generation->status !== 'WAITING') {
            return;
        }

        $generation->update(['status' => 'GENERATING']);

        try {
            $endpoint = config('services.n8n.generate_html_url');

            $response = Http::timeout(60)->post($endpoint, [
                'title' => $generation->title,
                'library' => $generation->library,
                'form_payload' => $generation->form_payload,
                'extra_prompt' => $generation->extra_prompt,
            ]);

            if ($response->failed()) {
                throw new \RuntimeException("n8n error: {$response->status()}");
            }

            $data = $response->json();

            $generation->update([
                'status' => 'DONE',
                'html_full' => $data['html'] ?? null,
                'css_raw' => $data['css'] ?? null,
                'js_raw' => $data['js'] ?? null,
                'editor_schema' => $data['editor_schema'] ?? null,
                'error_message' => null,
            ]);
        } catch (\Throwable $e) {
            $generation->update([
                'status' => 'FAILED',
                'error_message' => $e->getMessage(),
            ]);
        }
    }
}
