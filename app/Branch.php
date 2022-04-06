<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    //
    protected $fillable = [
        'name', 'address', 'description', 'active'
    ];

    public function User() {
        return $this->hasMany(User::class);
    }
}
