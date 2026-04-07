<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;
    protected $fillable = ['number_bill', 'provider', 'date_bill', 'total', 'registered_by', 'observation'];

    public function purchase_details()
    {
        return $this->hasMany(PurchaseDetail::class, 'purchase_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'registered_by');
    }
}
