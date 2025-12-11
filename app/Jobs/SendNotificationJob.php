<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use App\Services\Notification\NotificationService;

class SendNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $to;
    public string $templateKey;
    public array $channels;
    public array $data;

    public int $tries = 3;

    public function __construct(array $channels, string $templateKey, string $to, array $data = [])
    {
        $this->channels = $channels;
        $this->templateKey = $templateKey;
        $this->to = $to;
        $this->data = $data;
    }

    public function handle(NotificationService $service)
    {
        try {
            $success = $service->sendWithFallback(
                $this->templateKey,
                $this->to,
                $this->channels,
                $this->data
            );

            if ($success) {
                Log::channel('notification')->info("Notification sent successfully", [
                    'to' => $this->to,
                    'channels' => $this->channels,
                    'template_key' => $this->templateKey,
                ]);
            } else {
                Log::channel('notification')->error("Notification failed on all channels", [
                    'to' => $this->to,
                    'channels' => $this->channels,
                    'template_key' => $this->templateKey,
                ]);
            }
        } catch (\Exception $e) {
            Log::channel('notification')->error("Notification Job Exception", [
                'to' => $this->to,
                'channels' => $this->channels,
                'template_key' => $this->templateKey,
                'error' => $e->getMessage(),
            ]);

            throw $e; // retry job
        }
    }
}
