<?php

namespace App\Http\Controllers\API;
use App\Product;
use App\Button;
use App\Ampere;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
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
    protected function _validate(Request $request)
	{
		$this->validate($request,[
            'image' => 'required|file|image',
            'boitier' => 'required|string|',
            'button' => 'required|string',
            'pole' => 'required|string',
            'ampere' => 'required|string',
        ]);
    }
    public function index()
    {
        $products = Product::with('button','boitier','pole','ampere')->paginate(10);
        return $products;

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         if($request->get('button') && $request->get('boitier') && $request->get('pole') && $request->get('ampere')){
            if( Product::where(['button_id'=>$request->get('button'),'boitier_id'=>$request->get('boitier'),'pole_id'=>$request->get('pole'),'ampere_id'=>$request->get('ampere')])->first()==null ){
                $product= new Product();
                if($request->get('image'))
            {
               $image = $request->get('image');
               $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
               \Image::make($request->get('image'))->save(public_path('images/products/').$name);
               $product->name = $request->get('name');
               $product->image =  $name;
             }
                $product->button_id=$request->get('button');
                $product->boitier_id=$request->get('boitier');
                $product->pole_id=$request->get('pole');
                $product->ampere_id=$request->get('ampere');
             $product->save();
             return (['msg1' => 'Your product has been created']);
            }
            return (['msg2' => ' product already exists']);
        }
        //  createProduct::create($request->all());
        return (['msg3' => 'some fields is(r) empty']);
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
        if($request->get('button') && $request->get('boitier') && $request->get('pole') && $request->get('ampere')){
            if(Product::where(['button_id'=>$request->get('button'),'boitier_id'=>$request->get('boitier'),'pole_id'=>$request->get('pole'),'ampere_id'=>$request->get('ampere')])
            ->first()==null)
            {
    $thisProduct = Product::findOrFail($id);
                $product = new Product();
                if($request->get('image'))
                {
                   $image = $request->get('image');
                   $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
                   \Image::make($request->get('image'))->save(public_path('images/products/').$name);
                   $product->name = $request->get('name') ;
                   $product->image =  $name;
                }
                $product->button_id=$request->get('button');
                    $product->boitier_id=$request->get('boitier');
                    $product->pole_id=$request->get('pole');
                    $product->ampere_id=$request->get('ampere');
                    $product->id=$thisProduct->id;
                    $thisProduct->delete();
                $product->save();
        return (['msg1' => 'Your product has been created']);
            }
            else if($request->get('button')==$thisProduct->button_id && $request->get('boitier')==$thisProduct->boitier_id && $request->get('pole')==$thisProduct->pole_id && $request->get('ampere')==$thisProduct->ampere_id){
    $thisProduct = Product::findOrFail($id);
                $product= new Product();
                $product->id=$thisProduct->id;
                $thisProduct->delete();
                    $product->button_id=$request->get('button');
                    $product->boitier_id=$request->get('boitier');
                    $product->pole_id=$request->get('pole');
                    $product->ampere_id=$request->get('ampere');
                 if($request->get('image'))
                {
                   $image = $request->get('image');
                   $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
                   \Image::make($request->get('image'))->save(public_path('images/products/').$name);
                   $product->name = $request->get('name');
                   $product->image =  $name;
                 }
                 $product->save();
        return (['msg1' => 'Your product has been created']);
            }
            return (['msg2' => ' product already exists']);
    }
    return (['msg3' => 'some fields is(r) empty']);
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
    }
    public function search(){
        if ($search = \Request::get('q')) {
            $amperes = Ampere::where(function($query) use ($search){
                $query->orWhere('description','LIKE',"%$search%")
                        ->orWhere('id','LIKE',"%$search%")
                        ->orWhere('created_at','LIKE',"%$search%")
                        ->orWhere('updated_at','LIKE',"%$search%")
                        ->orWhere('article','LIKE',"%$search%");
            })->paginate(20);
        }else{
            $amperes = Ampere::latest()->paginate(5);
        }
        return $amperes;
    }
}
