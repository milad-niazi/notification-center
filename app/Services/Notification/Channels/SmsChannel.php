<?php

namespace App\Services\Notification\Channels;

use App\Interfaces\NotificationChannel;

class EmailChannel implements NotificationChannel
{
    public function send(string $to, string $message): bool
    {
        // اینجا می‌توانی از Mail::send لاراول استفاده کنی
        // فعلاً برای تست فقط echo
        echo "Sending Email to $to: $message\n";
        return true; // فرض کن همیشه موفق است
    }
}
