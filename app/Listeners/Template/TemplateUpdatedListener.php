<?php

namespace App\Listeners\Template;

use App\Events\TemplateUpdated;
use Illuminate\Support\Facades\Log;
use App\Services\Notification\NotificationService;

class TemplateUpdatedListener
{
    protected NotificationService $service;

    public function __construct()
    {
        $this->service = new NotificationService();
    }

    public function handle(TemplateUpdated $event)
    {
        $template = $event->template;

        Log::channel('notification')->info("TemplateUpdated event fired", [
            'template_id' => $template->id,
            'template_key' => $template->key,
            'time' => now(),
        ]);

        try {
            $this->service->send(
                "email",
                $template->key,
                "milad@example.com",
                ["name" => "Milad"]
            );

            Log::channel('notification')->info("Notification for update sent successfully", [
                'template_key' => $template->key,
            ]);
        } catch (\Exception $e) {
            Log::channel('notification')->error("Notification for update failed", [
                'template_key' => $template->key,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
