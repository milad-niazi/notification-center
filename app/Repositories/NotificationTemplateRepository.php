<?php

namespace App\Repositories;

use App\Models\NotificationTemplate;

class NotificationTemplateRepository
{
    public function all()
    {
        return NotificationTemplate::all();
    }

    public function find($id)
    {
        return NotificationTemplate::findOrFail($id);
    }

    public function create(array $data)
    {
        return NotificationTemplate::create($data);
    }

    public function update($id, array $data)
    {
        $template = $this->find($id);
        $template->update($data);
        return $template;
    }

    public function delete($id)
    {
        $template = $this->find($id);
        return $template->delete();
    }
}
