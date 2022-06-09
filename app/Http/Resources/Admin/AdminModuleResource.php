<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminModuleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $course = $this->whenLoaded('course');
        return [
            'id' => $this->id,
            'name'=> $this->name,
            'active' => $this->active,
            'position' => $this->position,
            'course' => $this->course,
            'lessons' => AdminLessonResource::collection($this->whenLoaded('lessons')),
        ];

    }
}
