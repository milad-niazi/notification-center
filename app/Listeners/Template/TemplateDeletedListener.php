<?php

namespace App\Listeners\Template;

use App\Events\TemplateDeleted;
use Illuminate\Support\Facades\Log;
use App\Jobs\SendNotificationJob;

class TemplateDeletedListener
{
    public function handle(TemplateDeleted $event)
    {
        $template = $event->template;

        // Log event fired
        Log::channel('notification')->info("TemplateDeleted event fired", [
            'template_id' => $template->id,
            'template_key' => $template->key,
            'time' => now(),
        ]);

        try {
            // Dispatch Job async با fallback
            SendNotificationJob::dispatch(
                ['email', 'sms', 'push'], // آرایه کانال‌ها
                $template->key,           // templateKey
                'milad@example.com',      // recipient
                ['name' => 'Milad']       // data برای template parsing
            );

            Log::channel('notification')->info("Notification Job for delete dispatched successfully", [
                'template_key' => $template->key,
            ]);
        } catch (\Exception $e) {
            Log::channel('notification')->error("Failed to dispatch Notification Job for delete", [
                'template_key' => $template->key,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
