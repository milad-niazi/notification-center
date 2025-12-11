<?php

namespace App\Repositories;

use App\Models\NotificationLog;

class NotificationLogRepository
{
    public function create(array $data)
    {
        return NotificationLog::create($data);
    }
}
