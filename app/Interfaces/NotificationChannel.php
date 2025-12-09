<?php

namespace App\Interfaces;

interface NotificationChannel
{
    public function send(string $to, string $message): bool;
}
