<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class PermissionResource extends JsonResource
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
            'name'          => $this->name,
            'slug'          => $this->slug,
            'description'   => $this->description,
            'is_active'     => $this->is_active,
            'guard_name'    => $this->guard_name,
            'created_at'    => Carbon::parse($this->created_at)->toDayDateTimeString(),
            'updated_at'    => Carbon::parse($this->updated_at)->toDayDateTimeString(),
        ];
    }
}
