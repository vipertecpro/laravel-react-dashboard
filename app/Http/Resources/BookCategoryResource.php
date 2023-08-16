<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class BookCategoryResource extends JsonResource
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
            'name'          => Str::limit($this->name,10),
            'slug'          => Str::limit($this->slug,10),
            'description'   => Str::limit($this->description,10),
            'is_active'     => $this->is_active,
            'parent_id'     => $this->parent_id,
            'created_at'    => Carbon::parse($this->created_at)->toDayDateTimeString(),
            'updated_at'    => Carbon::parse($this->updated_at)->toDayDateTimeString(),
        ];
    }
}
