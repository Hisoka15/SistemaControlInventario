<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'client',
        'date_bill',
        'total',
        'observation',
        'registered_by',
        'profit',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'registered_by');
    }

    public function saleDetails()
    {
        return $this->hasMany(SaleDetails::class, 'sale_id');
    }
}
