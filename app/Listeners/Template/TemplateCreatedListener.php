<?php

namespace App\Listeners\Template;

use App\Events\TemplateCreated;
use Illuminate\Support\Facades\Log;
use App\Services\Notification\NotificationService;

class TemplateCreatedListener
{
    protected NotificationService $service;

    public function __construct()
    {
        Log::channel('notification')->info("CONSTRUCTOR");
        $this->service = new NotificationService();
    }

    public function handle(TemplateCreated $event)
    {
        $template = $event->template;

        Log::channel('notification')->info("TemplateCreated event fired", [
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

            Log::channel('notification')->info("Notification sent successfully", [
                'template_key' => $template->key,
            ]);
        } catch (\Exception $e) {
            Log::channel('notification')->error("Notification failed", [
                'template_key' => $template->key,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
