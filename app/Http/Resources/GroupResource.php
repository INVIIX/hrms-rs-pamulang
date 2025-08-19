<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GroupResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'depth' => $this->depth,
            'parent' => new GroupResource($this->whenLoaded('parent')),
            'children' => GroupResource::collection($this->whenLoaded('children'))
        ];
    }
}
