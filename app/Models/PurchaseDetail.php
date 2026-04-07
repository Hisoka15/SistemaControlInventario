<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseDetail extends Model
{
    use HasFactory;
    protected $fillable = ['purchase_id', 'product_id', 'quantity', 'price', 'total', 'observation'];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'purchase_id');
    }

    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }
    public function inventoryMovements()
    {
        return $this->hasMany(InventoryMovement::class, 'purchase_detail_id');
    }
}
