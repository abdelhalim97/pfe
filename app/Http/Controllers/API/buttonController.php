<?php

namespace App\Http\Controllers\API;
use App\Button;
use Illuminate\Validation\Rule;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class buttonController extends Controller
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
            'name' => 'required|string|unique:buttons,name' .$button->id,
            'article' => 'sometimes|string|unique:buttons,article' .$button->id,
            'description' => 'sometimes|string|unique:buttons,description' .$button->id,
        ]);
    }
    public function index()
    {
        $buttons = Button::all();
        return Button::latest()->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $button= new Button();
    //     $data = request()->validate([
    //     'name' => 'required|string|unique:buttons,name' .$button->id,
    // ]);
        if($request->get('image'))
        {
           $image = $request->get('image');
           $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
           \Image::make($request->get('image'))->save(public_path('images/buttons/').$name);
        $button->name = $request->get('name') ;
        $button->image = $name;
        $button->article = $request->get('article');
        $button->description = $request->get('description');
        $button->save();
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
        // if(Button::where(['name'=>$request->get('name'),'article'=>$request->get('boitier'),'description'=>$request->get('pole')])
        // ->first()==null){
        // }
        $button= new Button();
        $thisButton = Button::findOrFail($id);
        $button->id=$thisButton->id;
            if($request->get('image'))
            {
                $thisButton = Button::findOrFail($id);
               $image = $request->get('image');
               $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
               \Image::make($request->get('image'))->save(public_path('images/buttons/').$name);
            $button->name = $request->get('name') ;
            $button->image = $name;
            $button->article = $request->get('article');
            $button->description = $request->get('description');
            File::delete('images/buttons/' .$thisButton->image);
            $thisButton->delete();
            $button->save();
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
        $button = Button::findOrFail($id);
        File::delete('images/buttons/' .$button->image);
        $button->delete();
        return ['message' =>'user deleted'];
    }
    public function search(){
        if ($search = \Request::get('q')) {
            $buttons = Button::where(function($query) use ($search){
                $query->orWhere('description','LIKE',"%$search%")
                        ->orWhere('id','LIKE',"%$search%")
                        ->orWhere('created_at','LIKE',"%$search%")
                        ->orWhere('updated_at','LIKE',"%$search%")
                        ->orWhere('article','LIKE',"%$search%");
            })->paginate(1000);
        }else{
            $buttons = Button::latest()->paginate(10);
        }
        return $buttons;
    }
}
