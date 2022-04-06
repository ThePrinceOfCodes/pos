<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class PaymentMethod extends Model
{
    use SoftDeletes;
    use LogsActivity;

    protected static $recordEvents = ['deleted', 'updated', 'created'];

    protected $fillable = ['name', 'description'];
    public function transactions() {
        return $this->hasMany('App\Transaction', 'payment_method_id', 'id');
    }
}
