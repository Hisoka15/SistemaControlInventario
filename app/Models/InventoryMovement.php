<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryMovement extends Model
{
    use HasFactory;
    protected $fillable = [
        'type',
        'purchase_detail_id',
        'sale_detail_id',
        'inventory_id',
        'user_id',
        'quantity',
        'available',
        'purchase_cost',
        'sale_cost',
        'total_purchase_cost',
        'total_sale_cost',
        'total_profit',
        'total_loss',
        'total_value',
        'description',
        'date'
    ];

    public function purchaseDetail()
    {
        return $this->belongsTo(PurchaseDetail::class, 'purchase_detail_id');
    }
    public function saleDetail()
    {
        return $this->belongsTo(SaleDetails::class, 'sale_detail_id');
    }
    public function inventory()
    {
        return $this->belongsTo(Inventory::class, 'inventory_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
