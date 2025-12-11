<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Jobs\SendNotificationJob;
use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use App\Services\Notification\NotificationService;
use App\Http\Resources\NotificationTemplateResource;
use App\Services\Notification\Template\TemplateLoader;

class NotificationController extends Controller
{
    protected $service;

    public function __construct(NotificationService $service)
    {
        $this->service = $service;
    }

    public function send(Request $request)
    {
        $request->validate([
            'channels' => 'required|array',
            'channels.*' => 'in:email,sms,push',
            'template' => 'required|string',
            'recipient' => 'required|string',
            'data' => 'nullable|array',
        ]);

        $template = TemplateLoader::load($request->template);

        // Dispatch async Job
        SendNotificationJob::dispatch(
            $request->channels,
            $request->template,
            $request->recipient,
            $request->data ?? []
        );

        return $this->successResponse(new NotificationResource($template), 201);
    }
}
