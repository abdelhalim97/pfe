<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    protected $fillable = [
        'full_name','	nb_matricule'
    ];
    public function orders(){
        return $this->hasMany(Order::class);
    }
}
