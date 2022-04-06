<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class ProductCategory extends Model
{
    use LogsActivity;

    protected static $recordEvents = ['deleted', 'updated', 'created'];

    use SoftDeletes;

    protected $table = 'product_categories';

    protected $fillable = ['name'];

    public function products() {
        return $this->hasMany('App\Product');
    }
}
