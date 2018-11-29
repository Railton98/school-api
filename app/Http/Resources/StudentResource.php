<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Services\LinksGenerator;

class StudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $links = new LinksGenerator;
        $links->addGet('students.show', route('students.show', $this->id));
        $links->addPut('students.update', route('students.update', $this->id));
        $links->addDelete('students.destroy', route('students.destroy', $this->id));

        return [
            'id'        => (int) $this->id,
            'name'      => $this->name,
            'birth'     => $this->birth,
            'gender'    => $this->gender,
            'classroom' => new ClassroomResource($this->whenLoaded('classroom')),
            'links'     => $links->toArray()
        ];
    }
}
