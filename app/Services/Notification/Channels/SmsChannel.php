<?php

namespace App\Services\Notification\Channels;

use App\Interfaces\NotificationChannel;

class SmsChannel implements NotificationChannel
{
    public function send(string $to, string $message): bool
    {
        // برای تست فقط echo می‌کنیم
        echo "Sending SMS to $to: $message\n";
        return true;
    }
}
