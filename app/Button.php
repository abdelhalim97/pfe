<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Button extends Model
{
    protected $fillable = [
        'name','image'
    ];
    public function products(){
        return $this->hasMany(Product::class);
    }
}
