<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'code_inventory',
        'product_id',
        'stock',
        'description',
        'total_value',
        'status',
    ];

    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }
    public function inventoryMovements()
    {
        return $this->hasMany(InventoryMovement::class, 'inventory_id');
    }
}
