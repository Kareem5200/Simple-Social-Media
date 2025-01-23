<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'commentID'=>$this->id,
            'comment'=>$this->comment,
            'username'=>$this->user->name,
            'userID'=>$this->user->id,
            'userImage'=>asset('/storage/profile_images/'.$this->user->profile_image),
            'time'=>Carbon::parse($this->created_at)->diffForHumans(),
        ];
    }
}
