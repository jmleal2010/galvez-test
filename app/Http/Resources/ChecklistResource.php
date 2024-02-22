<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChecklistResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'id'=>$this->id,
            'title'=>$this->name,
            'date'=>$this->date,
            'display'=>'background',
            'tasks'=>$this->tasks,
            'description'=>$this->description
        ];
    }
}
