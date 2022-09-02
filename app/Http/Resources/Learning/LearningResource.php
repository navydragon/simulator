<?php

namespace App\Http\Resources\Learning;

use Illuminate\Http\Resources\Json\JsonResource;

class LearningResource extends JsonResource
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
            'course_id' => $this->course_id,
            'current_module_id' => $this->current_module_id,
            'current_lesson_id' => $this->current_lesson_id,
            'is_completed' => $this->is_completed,
            'percentage' => $this->percentage,
            'course' => new CourseResource($this->whenLoaded('course')),
            'user_modules' => UserModuleResource::collection($this->whenLoaded('user_modules')),
        ];
    }
}
