<?php

namespace App\Http\Controllers\API;
use App\Boitier;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class boitierController extends Controller
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
            'name' => 'required|string|unique:boitiers,name' .$boitier->id,
            'article' => 'sometimes|string|unique:boitiers,article' .$boitier->id,
            'description' => 'sometimes|string|unique:boitiers,description' .$boitier->id,
        ]);
    }
    public function index()
    {
        $boitiers = Boitier::all();
        return Boitier::latest()->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $boitier= new Boitier();
    //     $data = request()->validate([
    //     'name' => 'required|string|unique:boitiers,name' .$boitier->id,
    // ]);
        if($request->get('image'))
        {
           $image = $request->get('image');
           $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
           \Image::make($request->get('image'))->save(public_path('images/boitiers/').$name);
        $boitier->name = $request->get('name') ;
        $boitier->image = $name;
        $boitier->article = $request->get('article');
        $boitier->description = $request->get('description');
        $boitier->save();
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
        $boitier= new Boitier();

        // $data = request()->validate([
        //     'name' => 'required|string|unique:boitiers,name' .$boitier->id,
        // ]);
        if($request->get('image'))
        {
            $thisBoitier = Boitier::findOrFail($id);
            $boitier->id=$thisBoitier->id;

           $image = $request->get('image');
           $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
           \Image::make($request->get('image'))->save(public_path('images/boitiers/').$name);
        $boitier->name = $request->get('name') ;
        $boitier->image = $name;
        $boitier->article = $request->get('article');
        $boitier->description = $request->get('description');
        File::delete('images/boitiers/' .$thisBoitier->image);
        $thisBoitier->delete();
        $boitier->save();
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
        $boitier = Boitier::findOrFail($id);
        File::delete('images/boitiers/' .$boitier->image);
        $boitier->delete();
        return ['message' =>'user deleted'];
    }
    public function search(){
        if ($search = \Request::get('q')) {
            $boitiers = Boitier::where(function($query) use ($search){
                $query->orWhere('description','LIKE',"%$search%")
                        ->orWhere('id','LIKE',"%$search%")
                        ->orWhere('created_at','LIKE',"%$search%")
                        ->orWhere('updated_at','LIKE',"%$search%")
                        ->orWhere('article','LIKE',"%$search%");
            })->paginate(1000);
        }else{
            $boitiers = Boitier::latest()->paginate(10);
        }
        return $boitiers;
    }
}
