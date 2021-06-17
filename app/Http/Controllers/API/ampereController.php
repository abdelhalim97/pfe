<?php

namespace App\Http\Controllers\API;
use App\Ampere;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ampereController extends Controller
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
            'name' => 'required|string|unique:amperes,name' .$ampere->id,
            'article' => 'sometimes|string|unique:amperes,article' .$ampere->id,
            'description' => 'sometimes|string|unique:amperes,description' .$ampere->id,
        ]);
    }
    public function index()
    {
        $amperes = Ampere::all();
        return Ampere::latest()->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ampere= new Ampere();
    //     $data = request()->validate([
    //     'name' => 'required|string|unique:amperes,name' .$ampere->id,
    // ]);
        if($request->get('image'))
        {
           $image = $request->get('image');
           $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
           \Image::make($request->get('image'))->save(public_path('images/emperages/').$name);
        $ampere->name = $request->get('name') ;
        $ampere->image = $name;
        $ampere->article = $request->get('article');
        $ampere->description = $request->get('description');
        $ampere->save();
         }
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
        $ampere= new Ampere();
        $thisAmpere = Ampere::findOrFail($id);
        $ampere->id = $thisAmpere->id;
        // if(!$request->get('image')){
        // File::delete('images/emperages/' .$thisAmpere->image);
        //     $ampere->name=$thisAmpere->name;
        //     $ampere->image=$thisAmpere->image;
        // $thisAmpere->delete();
        //     $ampere->article = $request->get('article');
        // $ampere->description = $request->get('description');
        // $ampere->save();
        // return ('msg1');
        // }
        // $data = request()->validate([
        //     'name' => 'required|string|unique:amperes,name' .$ampere->id,
        // ]);
        if($request->get('image'))
        {
            // if(Ampere::where(['article'=>$request->get('article'),'description'=>$request->get('description')])->first()==null){

                   $image = $request->get('image');
                   $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
                   \Image::make($request->get('image'))->save(public_path('images/emperages/').$name);
                $ampere->name = $request->get('name');
                $ampere->image = $name;
                $ampere->article = $request->get('article');
                $ampere->description = $request->get('description');
                File::delete('images/emperages/' .$thisAmpere->image);
                $thisAmpere->delete();
                $ampere->save();
            // }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ampere = Ampere::findOrFail($id);
        File::delete('images/emperages/' .$ampere->image);
        $ampere->delete();
        return ['message' =>'user deleted'];
    }
    public function search(){
        if ($search = \Request::get('q')) {
            $amperes = Ampere::where(function($query) use ($search){
                $query->orWhere('description','LIKE',"%$search%")
                        ->orWhere('id','LIKE',"%$search%")
                        ->orWhere('created_at','LIKE',"%$search%")
                        ->orWhere('updated_at','LIKE',"%$search%")
                        ->orWhere('article','LIKE',"%$search%");
            })->paginate(1000);
        }else{
            $amperes = Ampere::latest()->paginate(10);
        }
        return $amperes;
    }
}
