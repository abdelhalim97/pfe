<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Button extends Model
{
    protected $fillable = [
        'first_name','first_image'
    ];
    public function products(){
        return $this->hasMany(Product::class);
    }
}
