<?php

namespace App\Http\Resources\Learning;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
class UserModuleResource extends JsonResource
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
            'learning' => new LearningResource($this->whenLoaded('learning')),
            'module_id' => $this->module_id,
            'current_lesson_id' => $this->current_lesson_id,
            'is_completed' => $this->is_completed,
            'percentage' => $this->percentage,
            'user_lessons' => UserLessonResource::collection($this->whenLoaded('user_lessons')),
            'assigned_at' =>  Carbon::parse($this->assigned_at)->format('d.m.Y'),
            'completed_at' => $this->completed_at != null ?  Carbon::parse($this->completed_at)->format('d.m.Y') : null
        ];
    }
}
