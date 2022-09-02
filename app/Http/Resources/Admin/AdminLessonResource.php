<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminLessonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $module = $this->whenLoaded('module');
        return [
            'id' => $this->id,
            'name'=> $this->name,
            'active' => $this->active,
            'position' => $this->position,
            'module' => $this->module,
            'text' => $this->text,
            'tasks' => AdminTaskResource::collection($this->whenLoaded('tasks')),
        ];
    }
}
