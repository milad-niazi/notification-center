<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationLog extends Model
{
    use HasFactory;

    // همه فیلدهایی که mass assignment می‌شوند را اضافه کن
    protected $fillable = [
        'channel',
        'recipient',
        'template_key',
        'data',
        'status',
    ];
}
