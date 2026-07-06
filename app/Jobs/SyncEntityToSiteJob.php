<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\Site;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SyncEntityToSiteJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public int $backoff = 30;

    /**
     * @param array<string, mixed> $payload
     */
    public function __construct(
        public Site $site,
        public string $entity,
        public array $payload,
    ) {
    }

    public function handle(): void
    {
        $body = json_encode($this->payload, JSON_THROW_ON_ERROR);
        $signature = hash_hmac('sha256', $body, $this->site->api_secret);

        $baseUrl = rtrim($this->site->api_base_url, '/');

        $response = Http::withHeaders([
            'X-Site-Signature' => $signature,
            'Content-Type' => 'application/json',
        ])
            ->timeout(10)
            ->withBody($body, 'application/json')
            ->post("{$baseUrl}/sync/{$this->entity}");

        if (!$response->successful()) {
            Log::warning('Content-sync: спутник отклонил push', [
                'site' => $this->site->code,
                'entity' => $this->entity,
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            $this->fail("Sync to {$this->site->code} failed with status {$response->status()}");

            return;
        }

        $this->site->update(['last_synced_at' => now()]);
    }
}
