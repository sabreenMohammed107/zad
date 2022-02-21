<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AclResoursces extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'role_type' => $this->role_type,
            'permissions' => PermissionsResource::collection($this->getAllPermissions())
        ];

    }
}
