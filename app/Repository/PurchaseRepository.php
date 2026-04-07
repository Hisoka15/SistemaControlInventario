<?php

namespace App\Repository;

use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\Products;

class PurchaseRepository
{
    public function createPurchase(array $data)
    {
        return Purchase::create([
            'number_bill' => $data['number_bill'],
            'provider' => $data['provider'],
            'date_bill' => $data['date_bill'],
            'total' => $data['total'],
            'observation' => $data['bill_observation'],
            'registered_by' => auth()->id()
        ]);
    }

    public function createPurchaseDetail($purchaseId, array $detail, $productId)
    {
        return PurchaseDetail::create([
            'purchase_id' => $purchaseId,
            'product_id' => $productId,
            'quantity' => $detail['quantity'],
            'price' => $detail['unitPrice'],
            'total' => $detail['total'],
            'observation' => $detail['observations']
        ]);
    }

    public function getProduct($idOrCode)
    {
        return Products::where('id', $idOrCode)->orWhere('code', $idOrCode)->first();
    }
}
