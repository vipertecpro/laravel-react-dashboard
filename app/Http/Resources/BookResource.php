<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'title'         => $this->title,
            'slug'          => $this->slug,
            'ISBN_10'       => $this->ISBN_10,
            'ISBN_13'       => $this->ISBN_13,
            'author'        => $this->author,
            'created_by'    => $this->created_by,
            'created_at'    => Carbon::parse($this->created_at)->toDayDateTimeString(),
            'updated_at'    => Carbon::parse($this->updated_at)->toDayDateTimeString(),
        ];
    }
}
