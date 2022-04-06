<?php

namespace App;

use eloquentFilter\QueryFilter\ModelFilters\Filterable;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use Filterable;

    private static $whiteListFilter = [
        'user_id',
        'created_at',
    ];

    protected $fillable = [
        'client_id', 'user_id'
    ];
    public function client() {
        return $this->belongsTo('App\Client');
    }
    public function transactions() {
        return $this->hasMany('App\Transaction');
    }
    public function products() {
        return $this->hasMany(SoldProduct::class);
    }
    public function user() {
        return $this->belongsTo('App\User');
    }
}
