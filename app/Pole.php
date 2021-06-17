<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pole extends Model
{
    protected $fillable = [
        'name','image'
    ];
    public function products(){
        return $this->hasMany(Product::class);
    }
}
