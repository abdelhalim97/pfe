<?php

namespace App\Http\Controllers\API;
use App\Worker;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class WorkerController extends Controller
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
        $workers = Worker::all();
        return Worker::latest()->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function _validate(Request $request)
	{
		$this->validate($request,[
            'full_name' => 'required|string',
            'nb_matricule' => 'required|nb_matricule', Rule::unique('workers'),
        ]);
    }

    public function store(Request $request)
    {
        // $this->validate($request,[
        //     'full_name' => 'required|string',
        //     'nb_matricule' => 'required|string|nb_matricule', Rule::unique('workers'),
        // ]);
        // return [$request['full_name']];
        // return Worker::create([
        //     'full_name' => $request['full_name'],
        //     'nb_matricule' => $request['nb_matricule'],
        // ]);
        $worker= new Worker();
        $worker->full_name =  $request['full_name'];
        $worker->nb_matricule =  $request['nb_matricule'];
        $worker->save();

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

        $worker = Worker::findOrFail($id);

        $worker->update($request->all());
        if($request->nb_matricule!=null){
            $worker->nb_matricule=$request['nb_matricule'];
            $worker->save();
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
        $worker = Worker::findOrFail($id);
        $worker->delete();
    }
    public function search(){
        if ($search = \Request::get('q')) {
            $workers = Worker::where(function($query) use ($search){
                $query->orWhere('full_name','LIKE',"%$search%")
                        ->orWhere('id','LIKE',"%$search%")
                        ->orWhere('created_at','LIKE',"%$search%")
                        ->orWhere('updated_at','LIKE',"%$search%")
                        ->orWhere('nb_matricule','LIKE',"%$search%");
            })->paginate(1000);
        }else{
            $workers = Worker::latest()->paginate(10);
        }
        return $workers;
    }
}
