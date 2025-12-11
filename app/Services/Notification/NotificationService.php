<?php

namespace App\Services\Notification;

use Illuminate\Support\Facades\Log;
use App\Factories\NotificationFactory;
use App\Repositories\NotificationLogRepository;
use App\Services\Notification\Template\TemplateLoader;
use App\Services\Notification\Template\TemplateParser;

class NotificationService
{
    protected $logRepo;

    public function __construct(NotificationLogRepository $logRepo)
    {
        $this->logRepo = $logRepo;
    }

    public function send(string $channelType, string $templateKey, string $to, array $data)
    {
        $channelInstance = NotificationFactory::make($channelType);

        $template = TemplateLoader::load($templateKey);
        $message = TemplateParser::parse($template->body, $data);

        $status = $channelInstance->send($to, $message);

        $this->logRepo->create([
            'channel' => $channelType,
            'to' => $to,
            'template' => $templateKey,
            'data' => json_encode($data),
            'status' => $status ? 'sent' : 'failed',
        ]);

        return $status;
    }
    public function sendWithFallback(string $templateKey, string $to, array $channels, array $data = []): bool
    {
        foreach ($channels as $channel) {
            $status = $this->send($channel, $templateKey, $to, $data);
            if ($status) {
                return true; // موفق شد، دیگر کانال‌ها بررسی نمی‌شوند
            }
        }

        // اگر هیچ کانالی موفق نبود
        Log::channel('notification')->error("All channels failed for {$to}", [
            'template_key' => $templateKey,
            'channels' => $channels,
        ]);

        return false;
    }
}
