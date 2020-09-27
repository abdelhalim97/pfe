<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pole extends Model
{
    protected $fillable = [
        'third_name','third_image'
    ];
    public function products(){
        return $this->hasMany(Product::class);
    }
}
