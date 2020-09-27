<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    // protected $fillable = [
    //     '',''
    // ];
    public function worker(){
        return $this->belongsTo(Worker::class);
    }
    public function product(){
        return $this->belongsTo(Product::class);
    }
}
