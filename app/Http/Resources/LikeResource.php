<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LikeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'LikeID'=>$this->id,
            'userID'=>$this->user->id,
            'username'=>$this->user->name,
            'userImage'=>asset('/storage/profile_images/'.$this->user->profile_image),
        ];
    }
}
