<?php

namespace App\Factories;

use App\Services\Notification\Channels\EmailChannel;
use App\Services\Notification\Channels\SmsChannel;
use App\Services\Notification\Channels\PushChannel;
use App\Interfaces\NotificationChannel;

class NotificationFactory
{
    public static function make(string $type): NotificationChannel
    {
        return match($type) {
            'email' => new EmailChannel(),
            'sms'   => new SMSChannel(),
            'push'  => new PushChannel(),
            default => throw new \Exception("Notification type [$type] not supported")
        };
    }
}
