<?php

namespace App\Http\Resources\Learning;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class UserLessonResource extends JsonResource
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
            'user_id' => $this->user_id,
            'is_completed' => $this->is_completed,
            'assigned_at' =>  Carbon::parse($this->assigned_at)->format('d.m.Y'),
            'completed_at' => $this->completed_at != null ?  Carbon::parse($this->completed_at)->format('d.m.Y') : null,
            'learning' => new LearningResource($this->whenLoaded('learning')),
            'learning_id' => $this->learning_id,
            'user_module_id' => $this->user_module_id,
            'lesson_id' => $this->lesson_id,
            'text' =>$this->lesson->text,
            'lesson' => new LessonResource($this->whenLoaded('lesson')),
            'current_task_id' => $this->current_task_id,
            'user_tasks' => UserTaskResource::collection($this->user_tasks),
            'name' => $this->lesson->name
        ];
    }
}
