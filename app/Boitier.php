<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Boitier extends Model
{
    protected $fillable = [
        'second_name','second_image'
    ];
    public function products(){
        return $this->hasMany(Product::class);
    }
}
