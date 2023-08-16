<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class RoleResource extends JsonResource
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
            'description'   => Str::words($this->description,'5'),
            'is_active'     => $this->is_active,
            'guard_name'    => $this->guard_name,
            'user_type'     => $this->user_type,
            'record_access' => $this->record_access,
            'created_at'    => Carbon::parse($this->created_at)->toDayDateTimeString(),
            'updated_at'    => Carbon::parse($this->updated_at)->toDayDateTimeString(),
        ];
    }
}
