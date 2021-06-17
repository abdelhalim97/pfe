<?php

namespace App\Http\Controllers\API;
use App\Pole;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PoleController extends Controller
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
            'name' => 'required|string|unique:poles,name' .$pole->id,
            'article' => 'sometimes|string|unique:poles,article' .$pole->id,
            'description' => 'sometimes|string|unique:poles,description' .$pole->id,
        ]);
    }
    public function index()
    {
        $poles = Pole::all();
        return Pole::latest()->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pole= new Pole();
    //     $data = request()->validate([
    //     'name' => 'required|string|unique:Poles,name' .$pole->id,
    // ]);
        if($request->get('image'))
        {
            $image = $request->get('image');
           $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
           \Image::make($request->get('image'))->save(public_path('images/connetions/').$name);
        $pole->name = $request->get('name') ;
        $pole->image = $name;
        $pole->article = $request->get('article');
        $pole->description = $request->get('description');
        $pole->save();
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
        $pole= new Pole();

        // $data = request()->validate([
        //     'name' => 'required|string|unique:Poles,name' .$pole->id,
        // ]);
        if($request->get('image'))
        {
            $thisPole = Pole::findOrFail($id);
            $pole->id=$thisPole->id;

           $image = $request->get('image');
           $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
           \Image::make($request->get('image'))->save(public_path('images/connetions/').$name);
        $pole->name = $request->get('name');
        $pole->image = $name;
        $pole->article = $request->get('article');
        $pole->description = $request->get('description');
        File::delete('images/connetions/' .$thisPole->image);
        $thisPole->delete();
        $pole->save();
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
        $pole = Pole::findOrFail($id);
        File::delete('images/connetions/' .$pole->image);
        $pole->delete();
        return ['message' =>'user deleted'];
    }
    public function search(){
        if ($search = \Request::get('q')) {
            $poles = Pole::where(function($query) use ($search){
                $query->orWhere('description','LIKE',"%$search%")
                        ->orWhere('id','LIKE',"%$search%")
                        ->orWhere('created_at','LIKE',"%$search%")
                        ->orWhere('updated_at','LIKE',"%$search%")
                        ->orWhere('article','LIKE',"%$search%");
            })->paginate(1000);
        }else{
            $poles = Pole::latest()->paginate(10);
        }
        return $poles;
    }
}
