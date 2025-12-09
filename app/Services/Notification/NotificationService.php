<?php

namespace App\Services\Notification;

use App\Factories\NotificationFactory;
use App\Services\Notification\Template\TemplateLoader;
use App\Services\Notification\Template\TemplateParser;
use App\Models\NotificationLog;

class NotificationService
{
    public function send(string $channel, string $templateKey, string $to, array $data)
    {
        $channelInstance = NotificationFactory::make($channel);

        $template = TemplateLoader::load($templateKey);
        $message = TemplateParser::parse($template->body, $data);

        $status = $channelInstance->send($to, $message);

        NotificationLog::create([
            'channel' => $channel,
            'to' => $to,
            'template' => $templateKey,
            'data' => json_encode($data),
            'status' => $status ? 'sent' : 'failed',
        ]);

        return $status;
    }
}
