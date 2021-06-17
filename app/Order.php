<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'worker_id','product_id','of'
    ];
    public function worker(){
        return $this->belongsTo(Worker::class);
    }
    public function product(){
        return $this->belongsTo(Product::class);
    }
}
