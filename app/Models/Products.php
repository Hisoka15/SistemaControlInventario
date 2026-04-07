<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
        'unit_of_measurement',
        'type_of_measurement',
        'price',
        'status'
    ];

    public function inventories()
    {
        return $this->hasMany(Inventory::class, 'product_id');
    }

    public function saleDetails()
    {
        return $this->hasMany(SaleDetails::class, 'product_id');
    }

    public function purchaseDetails()
    {
        return $this->hasMany(PurchaseDetail::class, 'product_id');
    }
}
