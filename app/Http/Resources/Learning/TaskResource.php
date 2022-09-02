<?php

namespace App\Http\Resources\Learning;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\TaskTypeResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'lesson_id' => $this->lesson_id,
            'task_type' => new TaskTypeResource($this->type),
            'description' => $this->description,
            'start_code' => $this->start_code,
            'hint' => $this->hint,
            'feedback' => $this->feedback,
            'position' => $this->position,
            'next_task_id' => $this->next_task_id,
            'right_output' => json_decode($this->right_output)
        ];
    }
}
