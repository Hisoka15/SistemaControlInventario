<?php

namespace App\Http\Resources\Exports;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseByIdExportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'number_bill' => $this->number_bill,
            'provider' => $this->provider,
            'date_bill' => $this->date_bill,
            'total' => $this->total,
            'observation' => $this->observation,
            'registered_by' => $this->user->name,
        ];
    }
}
