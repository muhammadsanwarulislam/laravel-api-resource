<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\StudentResource;

class CourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'course_name' => $this->course_name,
            'course_code' => $this->course_code,
            'created_at' => $this->created_at->diffForHumans(),
            'students' => StudentResource::collection($this->students)
        ];
    }
}
