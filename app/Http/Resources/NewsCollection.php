<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class NewsCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        
        return [
            'title' => $this->title,
            'content' => $this->content,
            'creation_date' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s')
        ];
    }
}
