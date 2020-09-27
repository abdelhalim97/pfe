<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ampere extends Model
{
    protected $fillable = [
        'fourth_name','fourth_image'
    ];
    public function products(){
        return $this->hasMany(Product::class);
    }
}
