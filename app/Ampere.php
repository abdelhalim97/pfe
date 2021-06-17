<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ampere extends Model
{
    protected $fillable = [
        'name','image'
    ];
    public function products(){
        return $this->hasMany(Product::class);
    }
}
