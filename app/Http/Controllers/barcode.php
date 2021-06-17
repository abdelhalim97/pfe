<?php

namespace App\Http\Controllers;
use App\Product;
use App\Button;
use App\Boitier;
use App\Pole;
use App\Ampere;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Worker;
use App\Order;


class barcode extends Controller
{
    public function __construct(){
        $this->middleware('auth:admin');
    }

    public function showAddButton(){
        $products = Product::all();
        return view('elements.add-button')->with('products',$products);
    }
    public function addButton(Request $request){
        $data = request()->validate([
            'image1' => 'sometimes|file|image'
        ]);
        $path = $request->file('image1')->store('uploads','public');
        $element = new Button();
        $element->first_name = $path;
        $element->first_image = request('image1')->getClientOriginalName();//$post->image = $filename;
        $element->save();
        // $element->update(['image1'=>request()->image1->store('uploads','public')
        // ]);
        // Storage::move('storage/' . $path, 'storage/uploads/'. $element->first_image);
        return redirect(route('admin.dashboard'))->with('success','New button created');
    }
    public function showAddBoitier(){
        $products = Product::all();
        return view('elements.add-boitier')->with('products',$products);
    }
    public function addBoitier(Request $request){
        $data = request()->validate([
            'image2' => 'required'
        ]);
        $path = $request->file('image2')->store('uploads','public');
        $element = new Boitier();
        $element->second_name = $path;
        $element->second_image = request('image2')->getClientOriginalName();
        $element->save();
        return redirect(route('admin.dashboard'))->with('success','New Boitier created');
    }
    public function showAddPole(){
        $products = Product::all();
        return view('elements.add-pole')->with('products',$products);
    }
    public function addPole(Request $request){
        $data = request()->validate([
            'image3' => 'required'
        ]);
        $path = $request->file('image3')->store('uploads','public');
        $element = new Pole();
        $element->third_name = $path;
        $element->third_image = request('image3')->getClientOriginalName();
        $element->save();
        return redirect(route('admin.dashboard'))->with('success','New pole\'s type created');
    }
    public function showAddAmpere(){
        $products = Product::all();
        return view('elements.add-ampere')->with('products',$products);
    }
    public function addAmpere(Request $request){
        $data = request()->validate([
            'image4' => 'required|image'
        ]);
        $path = $request->file('image4')->store('uploads','public');

        $element = new Ampere();
        $element->fourth_name = $path;
        $element->fourth_image = request('image4')->getClientOriginalName();
        $element->save();
        return redirect(route('admin.dashboard'))->with('success','New ampere\'s type created');
        }
    public function showElements(){
        $buttons = Button::all();
        $boitiers = Boitier::all();
        $poles = Pole::all();
        $amperes = Ampere::all();
        return view('elements.display-element')->with(compact(['buttons', 'boitiers', 'poles','amperes']));
    }

    public function showAddProduct(){
        $buttons = Button::all();
        $boitiers = Boitier::all();
        $poles = Pole::all();
        $amperes = Ampere::all();
        return view('products.add-product')->with(compact(['buttons', 'boitiers', 'poles','amperes']));
}
public function addProduct(Request $request){
    $data = request()->validate([
        'name' => 'sometimes',
        'image' => 'sometimes|file|image',
        'relation1' => 'required',
        'relation2' => 'required',
        'relation3' => 'required',
        'relation4' => 'required'
    ]);
    $product = new Product();
    $product->first_element_id = request()->get('relation1');
    $product->second_element_id = request()->get('relation2');
    $product->third_element_id = request()->get('relation3');
    $product->fourth_element_id = request()->get('relation4');
    if(request()->hasFile('image')){
        $path = $request->file('image')->store('uploads','public');
        $product->name = $path;
        $product->image = request('image')->getClientOriginalName();
    }
    $product->save();
    return redirect(route('admin.dashboard'))->with('success','product created');
}
public function showProducts(){
    $products = Product::all();
    $buttons = Button::all();
    $boitiers = Boitier::all();
    $poles = Pole::all();
    $amperes = Ampere::all();
    return view('products.display-product')->with(compact(['products','buttons', 'boitiers', 'poles','amperes']));
}
public function show($id){
    $product= Product::find($id);
   $buttonID = Product::find($id)->first_element_id;
   $boitierID = Product::find($id)->second_element_id;
   $poleID = Product::find($id)->third_element_id;
   $ampereID = Product::find($id)->fourth_element_id;

    $button = Button::where('id',$buttonID)->first();
    $boitier = Boitier::where('id',$boitierID)->first();
    $pole = Pole::where('id',$poleID)->first();
    $ampere = Ampere::where('id',$ampereID)->first();
         return view('products.show-product')->with(compact(['product','button','boitier','pole','ampere']));
}
public function updateProduct($id){
    $productR= Product::find($id);
    $products = Product::all();
    $buttonID = Product::find($id)->first_element_id;
    $boitierID = Product::find($id)->second_element_id;
    $poleID = Product::find($id)->third_element_id;
    $ampereID = Product::find($id)->fourth_element_id;

     $buttonR = Button::where('id',$buttonID)->first();
     $boitierR = Boitier::where('id',$boitierID)->first();
     $poleR = Pole::where('id',$poleID)->first();
     $ampereR = Ampere::where('id',$ampereID)->first();

     $buttons = Button::all();
     $boitiers = Boitier::all();
     $poles = Pole::all();
     $amperes = Ampere::all();

        return view('products.edit-product')->with(compact(['products','productR','buttonR','boitierR','poleR','buttons','boitiers','poles','amperes','ampereR']));
}
public function update(Request $request,$id){
    $this->validate($request,[
        'fimage'=>'required',
        'simage'=>'required',
        'timage'=>'required',
        'qimage'=>'required',
        'file'=>'sometimes'
        ]);
        $product = Product::find($id);
        if(request()->hasFile('file')){
            $path = $request->file('file')->store('uploads','public');
            $product->name = $path;
            $product->image = request('file')->getClientOriginalName();
        }
        $imagef= $request->get('fimage');
        $images= $request->get('simage');
        $imaget= $request->get('timage');
        $imageq= $request->get('qimage');

        $button = Button::where('first_image',$imagef)->first();
        $boitier = Boitier::where('second_image',$images)->first();
        $pole = Pole::where('third_image',$imaget)->first();
        $ampere = Ampere::where('fourth_image',$imageq)->first();

        $product->first_element_id=$button->id;
        $product->second_element_id=$boitier->id;
        $product->third_element_id=$pole->id;
        $product->fourth_element_id=$ampere->id;

        $product->save();
        return redirect(route('show.products'))->with('succes','product updated');
}
public function deleteProduct($id){
    $product  = Product::find($id);
    $product->delete();
    return redirect(route('show.products'))->with('succes','product deleted');
}
public function search(){
    if ($search = \Request::get('q')) {
        $orders = Order::where(function($query) use ($search){
            $query->where('id','LIKE',"%$search%")
                    ->orWhere('of','LIKE',"%$search%");
        })->paginate(20);
    }else{
        $orders = Order::latest()->paginate(5);
    }

    return $orders;
}
}
