<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'userID'=>$this->id,
            'username'=>$this->name,
            'image'=>asset('/storage/profile_images/'.$this->profile_image),
            'bio'=>isset($this->bio)? $this->bio : null,
        ];
    }
}
