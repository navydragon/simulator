<?php

namespace App\Http\Resources\Learning;

use Illuminate\Http\Resources\Json\JsonResource;

class UserTaskResource extends JsonResource
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
            'learning_id' => $this->learning_id,
            'user_id' => $this->user_id,
            'user_lesson_id' => $this->user_lesson_id,
            'task_id' => $this->task_id,
            'is_completed' => $this->is_completed,
            'current_code' => $this->current_code,
            'current_output' => json_decode($this->current_output),
        ];
    }
}
