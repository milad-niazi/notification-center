<?php

namespace App\Services\Notification\Channels;

use App\Interfaces\NotificationChannel;

class PushChannel implements NotificationChannel
{
    public function send(string $to, string $message): bool
    {
        // برای تست فقط echo می‌کنیم
        echo "Sending Push Notification to $to: $message\n";
        return true;
    }
}
