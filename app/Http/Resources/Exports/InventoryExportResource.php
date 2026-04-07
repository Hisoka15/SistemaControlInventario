<?php

namespace App\Http\Resources\Exports;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InventoryExportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'code_inventory' => $this->code_inventory,
            'product' => $this->product->name,
            'stock' => $this->stock,
            'total_value' => $this->total_value,
            'description' => $this->description,
            'status' => $this->status ? 'active' : 'inactive',
        ];
    }
}
