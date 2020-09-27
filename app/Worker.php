<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    // protected $fillable = [
    //     '',''
    // ];
    public function orders(){
        return $this->hasMany(Order::class);
    }
}
