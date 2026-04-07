<?php

namespace App\Repository;

use App\Models\Inventory;
use App\Models\InventoryMovement;

class InventoryRepository
{
    public function updateStock($productId, $quantity, $totalValue)
    {
        $inventory = Inventory::where('product_id', $productId)->first();
        $inventory->stock += $quantity;
        $inventory->total_value += $totalValue;
        $inventory->save();
        return $inventory->id;
    }

    public function updateStockOut($productId, $quantity, $totalValue)
    {
        $inventory = Inventory::where('product_id', $productId)->first();
        if($inventory->stock < $quantity) {
            throw new \Exception('Insufficient stock for product ID: ' . $productId);
        }
        $inventory->stock -= $quantity;
        $inventory->total_value -= $totalValue;
        $inventory->save();
        return $inventory->id;
    }

    public function inputMovement($data, $detail = null)
    {
        return InventoryMovement::create([
            'type' => 'in',
            'purchase_detail_id' => $data['purchase_detail_id'],
            'inventory_id' => $data['inventory_id'],
            'user_id' => auth()->id(),
            'quantity' => $data['quantity'],
            'available' => $data['quantity'],
            'purchase_cost' => $data['unitPrice'],
            'total_purchase_cost' => $data['total'],
            'description' => $detail,
            'date' => now(),
        ]);
    }

    public function outputMovement($data, $details = null, $quantity, $profit, $total_sale_cost)
    {
        return InventoryMovement::create([
            'type' => 'out',
            'sale_detail_id' => $data['sale_detail_id'],
            'inventory_id' => $data['inventory_id'],
            'user_id' => auth()->id(),
            'quantity' => $quantity,
            'sale_cost' => $data['unitPrice'],
            'total_sale_cost' => $total_sale_cost,
            'total_profit' => $profit,
            'description' => $details,
            'date' => now(),
        ]);
    }

    public function getAllInputMovements($inventoryId)
    {
        return InventoryMovement::where('type', 'in')
            ->where('inventory_id', $inventoryId)
            ->where('available', '>', 0)
            ->orderBy('date', 'asc')
            ->get();
    }

    public function updateInputMovement($movementId, $quantity)
    {
        $movement = InventoryMovement::find($movementId);
        if ($movement) {
            $movement->available = $quantity;
            $movement->save();
            return $movement;
        }
        throw new \Exception('Movement not found with ID: ' . $movementId);
    }
}
