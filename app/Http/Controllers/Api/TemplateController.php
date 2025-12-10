<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Http\Resources\NotificationTemplateResource;
use App\Repositories\NotificationTemplateRepository;

class TemplateController extends ApiController
{
    protected $repo;

    public function __construct(NotificationTemplateRepository $repo)
    {
        $this->repo = $repo;
    }

    public function index()
    {
        $templates = $this->repo->all();
        return $this->successResponse(NotificationTemplateResource::collection($templates), 200);
    }

    public function show($id)
    {
        try {
            $template = $this->repo->find($id);
            return $this->successResponse(new NotificationTemplateResource($template), 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->errorResponse("Template not found", 404);
        }
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'key' => 'required|string|unique:notification_templates,key',
            'subject' => 'required|string',
            'body' => 'required|string',
        ]);

        $template = $this->repo->create($data);
        return $this->successResponse(new NotificationTemplateResource($template), 201);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'key' => 'sometimes|string|unique:notification_templates,key,' . $id,
            'subject' => 'sometimes|string',
            'body' => 'sometimes|string',
        ]);

        try {
            $template = $this->repo->update($id, $data);
            return $this->successResponse(new NotificationTemplateResource($template), 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->errorResponse("Template not found", 404);
        }
    }

    public function destroy($id)
    {
        try {
            $this->repo->delete($id);
            return $this->successResponse(null, 200, "Template deleted");
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->errorResponse("Template not found", 404);
        }
    }
}
