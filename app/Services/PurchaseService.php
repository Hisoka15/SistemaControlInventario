<?php

namespace App\Services;

use App\Repository\InventoryRepository;
use App\Repository\PurchaseRepository;
use Illuminate\Support\Facades\DB;

class PurchaseService
{
    protected $inventoryRepository;
    protected $purchaseRepository;

    public function __construct(InventoryRepository $inventoryRepository, PurchaseRepository $purchaseRepository)
    {
        $this->inventoryRepository = $inventoryRepository;
        $this->purchaseRepository = $purchaseRepository;
    }

    public function createPurchase($data)
    {
        try {
            DB::beginTransaction();
            $purchase = $this->purchaseRepository->createPurchase($data);
            foreach ($data['purchaseDetails'] as $detail) {
                $data['product_id'] = $this->purchaseRepository->getProduct($detail['product'])->id;
                $detail['purchase_detail_id'] = $this->purchaseRepository->createPurchaseDetail($purchase->id, $detail, $data['product_id'])->id;
                $detail['inventory_id'] = $this->inventoryRepository->updateStock($data['product_id'], $detail['quantity'], $detail['total']);
                $detailMovement = "Compra a proveedor '".$data['provider']."' con factura N° ".$data['number_bill'];
                $this->inventoryRepository->inputMovement($detail, $detailMovement);
            }
            DB::commit();
            return $purchase;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
