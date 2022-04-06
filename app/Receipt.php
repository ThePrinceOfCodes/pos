<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Receipt extends Model
{
    use LogsActivity;

    protected static $recordEvents = ['deleted', 'updated', 'created'];

    protected $fillable = [
        'title', 'provider_id', 'user_id', 'is_store'
    ];

    public function provider()
    {
        return $this->belongsTo('App\Provider');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function products()
    {
        return $this->hasMany('App\ReceivedProduct');
    }
}
