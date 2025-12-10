<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Services\Notification\NotificationService;

class ApiController extends Controller
{
    use ApiResponser;
    public function sendNotification(Request $request)
    {
        $service = new NotificationService();

        $success = $service->send(
            $request->channel,
            $request->template,
            $request->to,
            $request->data
        );

        return response()->json([
            "success" => $success
        ]);
    }
}
