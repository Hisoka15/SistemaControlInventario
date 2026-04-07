<?php

namespace App\Http\Resources\Exports;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseDetailsExportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'product' => $this->product->name,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'total' => $this->total,
            'observation' => $this->observation,
        ];
    }
}
