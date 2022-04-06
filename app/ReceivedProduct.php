<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class ReceivedProduct extends Model
{
    use LogsActivity;

    protected static $recordEvents = ['deleted', 'updated', 'created'];

    protected $fillable = [
        'receipt_id', 'product_id', 'stock', 'stock_defective', 'store', 'store_defective'
    ];

    public function receipt()
    {
        return $this->belongsTo('App\Receipt');
    }

    public function product()
    {
        return $this->belongsTo('App\Product');
    }
}
