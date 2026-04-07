<?php

namespace App\Http\Resources\Exports;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductExportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'code' => $this->code,
            'name' => $this->name,
            'description' => $this->description,
            'type_of_measurement' => $this->type_of_measurement,
            'unit_of_measurement' => $this->unit_of_measurement,
            'price' => $this->price,
            'status' => $this->status ? 'active' : 'inactive',
        ];
    }
}
