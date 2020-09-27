<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name','image','first_element_id','second_element_id','third_element_id'
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
