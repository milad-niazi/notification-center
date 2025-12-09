<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Notification\NotificationService;

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
            'channel' => 'required|string|in:email,sms,push',
            'template' => 'required|string',
            'recipient' => 'required|string',
            'data' => 'nullable|array',
        ]);

        $success = $this->service->send(
            $request->channel,
            $request->template,
            $request->recipient,
            $request->data ?? []
        );

        return response()->json([
            'success' => $success
        ]);
    }
}
