<?php

namespace App\Http\Resources\Learning;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
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
            'name' => $this->name,
            'active' => $this->active,
            'learning' =>  LearningResource::collection($this->whenLoaded('learnings')),
            'modules' => ModuleResource::collection($this->whenLoaded('modules')),
        ];
    }
}
