<?php

namespace App\Services;

use App\Repository\InventoryRepository;
use App\Repository\SaleRepository;
use Illuminate\Support\Facades\DB;

class SaleService
{
    protected $inventoryRepository;
    protected $saleRepository;

    public function __construct(InventoryRepository $inventoryRepository, SaleRepository $saleRepository)
    {
        $this->inventoryRepository = $inventoryRepository;
        $this->saleRepository = $saleRepository;
    }

    public function createSale($data)
    {
        try {
            DB::beginTransaction();
            $sale = $this->saleRepository->createSale($data);
            $products = [];
            $total_profit = 0;
            foreach ($data['saleDetails'] as $detail) {
                $product_profit = 0;
                $product = $this->saleRepository->getProduct($detail['product']);
                $data['product'] = $product->id;
                $detail['inventory_id'] = $this->inventoryRepository->updateStockOut($data['product'], $detail['quantity'], $detail['total']);
                $inputsInInventory = $this->inventoryRepository->getAllInputMovements($detail['inventory_id']);
                $detail['sale_detail_id'] = $this->saleRepository->createSaleDetail($sale->id, $detail, $product->id)->id;
                if($inputsInInventory->isEmpty()) {
                    throw new \Exception('No hay entradas de inventario para el producto: ' . $product->name);
                }
                $detailMovement = "Venta al cliente '".$data['client']."' con factura N° ".$sale->id;
                $outputQuantity = $detail['quantity'];
                foreach ($inputsInInventory as $input) {
                    $remaining = $outputQuantity - $input->available;
                    if ($remaining <= 0) {
                        $input->available -= $outputQuantity;
                        $input->available = $remaining * -1;
                        $profit = ($outputQuantity * $detail['unitPrice']) - ($input->purchase_cost * $outputQuantity);
                        $total_profit += $profit;
                        $product_profit += $profit;
                        $total_sale_cost = $outputQuantity * $detail['unitPrice'];
                        $this->inventoryRepository->updateInputMovement($input->id, $input->available);
                        $this->inventoryRepository->outputMovement($detail, $detailMovement, $outputQuantity, $profit, $total_sale_cost);
                        break;
                    } else {
                        $outputQuantity = $remaining;
                        $profit = ($input->available * $detail['unitPrice']) - ($input->purchase_cost * $input->available);
                        $total_profit += $profit;
                        $product_profit += $profit;
                        $total_sale_cost = $input->available * $detail['unitPrice'];
                        $this->inventoryRepository->updateInputMovement($input->id, 0);
                        $this->inventoryRepository->outputMovement($detail, $detailMovement, $input->available, $profit, $total_sale_cost);
                    }
                }
                $products[] = [
                    'nombre' => $product->name,
                    'codigo' => $product->code,
                    'cantidad' => $detail['quantity'],
                    'precio' => $detail['unitPrice'],
                    'unidad' => $product->unit_of_measurement,
                ];
                $this->saleRepository->updateProfitInSaleDetail($detail['sale_detail_id'], $product_profit);
            }
            $this->saleRepository->updateProfitInSale($sale->id, $total_profit);
            DB::commit();
            return [
                'sale' => $sale,
                'products' => $products
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
