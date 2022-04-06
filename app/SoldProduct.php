<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SoldProduct extends Model
{
    protected $fillable = [
        'sale_id', 'product_id', 'price', 'qty', 'total_amount', 'payment_method_id', 'is_new', 'txref'
    ];

    public function product()
    {
        return $this->belongsTo('App\Product');
    }
    public function sale()
    {
        return $this->belongsTo('App\Sale');
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }
}
