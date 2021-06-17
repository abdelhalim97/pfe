<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name','image','button_id','boitier_id','pole_id','ampere_id'
    ];
    public function button(){
        return $this->belongsTo(Button::class);
    }
    public function boitier(){
        return $this->belongsTo(Boitier::class);
    }
    public function pole(){
        return $this->belongsTo(Pole::class);
    }
    public function ampere(){
        return $this->belongsTo(Ampere::class);
    }
    public function workers(){
        return $this->hasMany(Worker::class);
    }
}
