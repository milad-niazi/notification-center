<?php

namespace App\Events;

use App\Models\NotificationTemplate;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class TemplateCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public NotificationTemplate $template;

    public function __construct(NotificationTemplate $template)
    {
        $this->template = $template;
        info("EVENT DISPATCHED FROM TemplateCreated", [
            'template_id' => $template->id,
            'time' => now()->toDateTimeString(),
        ]);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [];
    }
}
