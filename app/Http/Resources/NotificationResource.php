<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'notification_ID'=>$this->id,
            'data'=>$this->data,
            'time'=>Carbon::parse($this->created_at)->diffForHumans(),
            'read'=>is_null($this->read_at)?false:true,
        ];
    }
}
