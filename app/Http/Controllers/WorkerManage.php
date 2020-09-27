<?php

namespace App\Http\Controllers;
use App\Worker;
use Illuminate\Http\Request;

class WorkerManage extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function addWorker(){

        return view('admin.add-worker');
    }
    public function addNewWorker(Request $request){
        //dd($request->all());
        $data = request()->validate([
            'Fname' => 'required|min:3',
            'age' => 'sometimes',
            'nb_matricule' => 'required'

        ]);
        $worker = new Worker();
        $worker->full_name = request('Fname');
        $worker->age = request('age');
        $worker->nb_matricule = request('nb_matricule');
        $worker->save();
        return redirect(route('admin.worker.display'))->with('success','worker created');
    }




    public function display(){
        $workers = Worker::all();
        return view('admin.display-worker')->with('workers',$workers);
    }


    public function showw($id){
        $worker = Worker::find($id);
        //$admin = Admin::find($id)->paginate(1);
        return view('admin.show-worker')->with('worker',$worker);
    }
    //update admin
    public function updateForm($id){
        $worker = Worker::find($id);
        return view('admin.edit-worker')->with('worker',$worker);
    }

    public function update(Request $request,$id){
        $this->validate($request,[
        'Fname'=>'required',
        'age'=>'sometimes',
        'nb_matricule'=>'required'
        ]);
        $worker = Worker::find($id);
        $worker->full_name = $request->get('Fname');
        $worker->age = $request->get('age');
        $worker->nb_matricule = $request->get('nb_matricule');

        $worker->save();
        return redirect(route('admin.worker.display'))->with('success','worker updated');
    }


    public function deleteWorker($id){
        $worker = Worker::find($id);
            $worker->delete();
        return redirect(route('admin.worker.display'))->with('success','worker deleted');
    }
}
