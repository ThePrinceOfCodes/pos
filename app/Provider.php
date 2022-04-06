<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Provider extends Model
{
    use LogsActivity;

    protected static $recordEvents = ['deleted', 'updated', 'created'];

    use SoftDeletes;

    protected $fillable = [
        'name', 'description', 'email', 'phone', 'paymentinfo'
    ];

    public function transactions()
    {
        return $this->hasMany('App\Transaction');
    }

    public function receipts()
    {
        return $this->hasMany('App\Receipt');
    }
}
