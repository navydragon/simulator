<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminTaskResource extends JsonResource
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
            'type' => $this->type,
            'typeId' => $this->task_type_id,
            'lessonId' => $this->lesson_id,
            'lesson' => new AdminLessonResource($this->whenLoaded('lesson')),
            'description'=> $this->description,
            'position' => $this->position,
            'startCode' => $this->start_code,
            'preCode' => $this->pre_code,
            'postCode' => $this->post_code,
            'active' => (boolean) $this->active,
            'rightCode' => $this->right_code,
            'rightOutput' => json_decode($this->right_output)
        ];
    }
}
