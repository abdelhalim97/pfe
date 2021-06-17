<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use App\Worker;
use DB;
class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('guest:admin-api');

    }
    public function index()
    {
        $orders = Order::with('worker')->paginate(10);
        return $orders;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }

public function search(){
    if ($search = \Request::get('q')) {
        $orders = Order::with('worker')
        ->where(function($query) use ($search){
            $query->where('id','LIKE',"%$search%")
            ->orWhere('of','LIKE',"%$search%")
            ->orWhere('created_at','LIKE',"%$search%")
            ->orWhereHas('worker', function ($query) use ($search) {
                $query->where('full_name','LIKE',"%$search%")
                ->orWhere('nb_matricule','LIKE',"%$search%");
            });
        })->paginate(1000);
    }else{
        $orders = Order::with('worker')->paginate(10);
    }

    return $orders;
}

}

