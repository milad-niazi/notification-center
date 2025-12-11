<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'recipient' => $this->to ?? $this->recipient,
            'template'  => $this->template ?? $this->templateKey,
            'channel'   => $this->channel,
            'status'    => $this->status ?? 'pending',
            'sent_at'   => $this->created_at ?? now(),
            'data'      => json_decode($this->data ?? '{}', true),
        ];
    }
}
