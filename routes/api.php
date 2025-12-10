<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\Api\TemplateController;
use App\Http\Controllers\Api\NotificationController;

Route::post('/send-notification', [NotificationController::class, 'send']);
Route::apiResource('templates', TemplateController::class);
