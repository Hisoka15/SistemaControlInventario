<?php

namespace App\Http\Resources\Exports;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class UserExportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'role' => $this->role->name,
            'email' => $this->email,
            'status' => $this->status,
            'last_login' => $this->last_login ? Carbon::parse($this->last_login)->format('Y-m-d H:i:s') : null,
        ];
    }
}
