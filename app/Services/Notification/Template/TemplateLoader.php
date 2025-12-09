<?php

namespace App\Services\Notification\Template;

use App\Models\NotificationTemplate;

class TemplateLoader
{
    public static function load(string $key): NotificationTemplate
    {
        return NotificationTemplate::where('key', $key)->firstOrFail();
    }
}
