<?php

namespace App\Repository;

use App\Models\Sale;
use App\Models\SaleDetails;
use App\Models\Products;

class SaleRepository
{
    public function createSale(array $data)
    {
        return Sale::create([
            'client' => $data['client'],
            'date_bill' => $data['date_bill'],
            'total' => $data['total'],
            'observation' => $data['bill_observation'],
            'registered_by' => auth()->id()
        ]);
    }

    public function createSaleDetail($saleId, array $detail, $productId)
    {
        return SaleDetails::create([
            'sale_id' => $saleId,
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

    public function updateProfitInSale($saleId, $profit)
    {
        $sale = Sale::find($saleId);
        if ($sale) {
            $sale->profit = $profit;
            $sale->save();
        }
    }

    public function updateProfitInSaleDetail($saleDetailId, $profit)
    {
        $saleDetail = SaleDetails::find($saleDetailId);
        if ($saleDetail) {
            $saleDetail->profit = $profit;
            $saleDetail->save();
        }
    }
}
