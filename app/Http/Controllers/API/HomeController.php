<?php

namespace App\Http\Controllers\API;
use App\Ampere;
use App\Pole;
use App\Boitier;
use App\Button;
use App\Product;
use App\Worker;
use App\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function __construct()
    // {
    //     $this->middleware('api');

    // }
    public function index()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = request()->validate([
            'scanner1' => 'required',
            'scanner2' => 'required',
            'scanner3' => 'required',
            'scanner4' => 'required|max:3',
            'family' => 'required',
            'nb_matricule' => 'required'
        ]);
        $nb_matricule=request('nb_matricule');
        $workers=Worker::all();
        foreach($workers as $worker){//$workers->where('nb_matricule','==',$nb_matricule)
            if($worker->nb_matricule==$nb_matricule){
                $scanner1=request('scanner1');
                $scanner2=request('scanner2');
                $scanner3=request('scanner3');
                $scanner4=request('scanner4');
                $family=request()->get('family');
                $scanner=$scanner1 . $scanner2;
                switch($family){
                    case('3120'):
                        if(strlen($scanner3) == 6){
                            $buttonS=$scanner3[0] . $scanner3[1] . $scanner3[2] . $scanner3[3] .$scanner3[4];//w/t N- whats the new length of buttons name
                        }
                        else if(strlen($scanner3) == 4){
                        $buttonS=$scanner3[0] . $scanner3[1] . $scanner3[2] . $scanner3[3];
                        }
                        else{                return (['msg'=>'button field number doesnt exist']);
                        }
                        if(strlen($scanner)==8){
                            $boitierS=$scanner[0] . $scanner[1] . $scanner[3] . "_1";
                            $boitierS2=$scanner[0] . $scanner[1] . $scanner[3] . "_2";/**13 */
                            $poleS=$scanner[2] . $scanner[4] . $scanner[5];//_Bel
                        }
                        else{                return (['msg'=>'1 or 2 field number doesnt exist']);
                        }
                        if(strlen ($scanner4)==4){//cant i concatinate all the string inputs
                            $ampereS=$scanner4[0] . $scanner4[1] . $scanner4[2] . $scanner4[3];
                        }
                        else if(strlen ($scanner4)==3){
                            $ampereS=$scanner4[0] . $scanner4[1]. $scanner4[2];
                        }
                        else if (strlen ($scanner4)==2){
                            $ampereS=$scanner4[0]. $scanner4[1];
                        }
                        else{                return (['msg'=>'ampere number doesnt exist']);
                        }
                        $nb_matBp=false;
                        $buttonBo=false;
                        $boitierBo=false;
                        $boitierBo2=false;
                        $poleBo=false;
                        $ampereBo=false;

                        $buttonIs = Button::all();
                        foreach($buttonIs as $buttonI){
                            $BI=$buttonI->name;
                            $pos=strpos($BI,".");
                            $ext=$BI[$pos];
                            for($i=$pos+1;$i<strlen($BI);$i++){
                                $ext =  $ext.$BI[$i];
                            }
                            if($BI==$buttonS.$ext){
                                $buttonR=$buttonI;//$buttonR=$buttonI->name;
                                $buttonBo=true;
                            }
                        }
                        if ($buttonBo==false)
                        {                return (['msg'=>'button number doesnt exist']);
                        }

                            $boitierSIs = Boitier::all();
                            foreach($boitierSIs as $boitierSI){

                                $BoiI=$boitierSI->name;
                                $pos=strpos($BoiI,".");
                                $ext=$BoiI[$pos];
                                for($i=$pos+1;$i<strlen($BoiI);$i++){
                                    $ext =  $ext.$BoiI[$i];
                                }
                                if($BoiI==$boitierS.$ext){
                                    $boitierR=$boitierSI;
                                    $boitierBo=true;
                                }
                                if($BoiI==$boitierS2.$ext){
                                    $boitierR2=$boitierSI;
                                    $boitierBo2=true;
                                }
                            }
                            if ($boitierBo==false || $boitierBo2==false)
                        {                return (['msg'=>'boitier number doesnt exist']);
                        }
                            $poleIs = Pole::all();
                        foreach($poleIs as $poleI){
                            $PI=$poleI->name;
                            $pos=strpos($PI,".");
                            $ext=$PI[$pos];
                            for($i=$pos+1;$i<strlen($PI);$i++){
                                $ext =  $ext.$PI[$i];
                            }
                            if($PI==$poleS.$ext){
                                $poleR=$poleI;
                                $poleBo=true;
                            }
                        }
                        if ($poleBo==false)
                        {                return (['msg'=>'pole number doesnt exist']);
                        }
                        $ampereIs = Ampere::all();
                        foreach($ampereIs as $ampereI){
                            $AI=$ampereI->name;
                            $pos=strpos($AI,".");
                            $ext=$AI[$pos];
                            for($i=$pos+1;$i<strlen($AI);$i++){
                                $ext =  $ext.$AI[$i];
                            }
                            if($AI==$ampereS.$ext){
                                $ampereR=$ampereI;
                                $ampereBo=true;
                            }
                        }
                        if ($ampereBo==false)
                        {                return (['msg'=>'ampere number doesnt exist']);
                        }
                    break;
                case(2):
                break;
                }
                $Bid=$buttonR->id;
                $Boiid=$boitierR->id;
                $Boiid2=$boitierR2->id;
                $Pid=$poleR->id;
                $ampid=$ampereR->id;
                //return (['msg'=>$Boiid]);
                $p = Product::where(['button_id'=>$Bid,'boitier_id'=>$Boiid,'pole_id'=>$Pid,'ampere_id'=>$ampid])->with('button','boitier','pole','ampere')->first();
                $commande = new Order();
                $commande->product_id=$p->id;
                $commande->worker_id=$worker->id;
                $commande->of= $family. "-".$scanner1. "-".$scanner2. "-".$scanner3. "-".$scanner4;
                $commande->save();
                return $p;

            }


        }
        return (['msg'=>'registration number doesnt exist']);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $scanner3=request('scanner3');

        // if($scanner3[0]=='S'){
        //     $family=request()->get('family');
        //         switch($family){
        //             case('3120'):
        //                 if(strlen($scanner3) == 6){
        //                     $buttonS=$scanner3[0] . $scanner3[1] . $scanner3[2] . $scanner3[3] .$scanner3[4];//w/t N- whats the new length of buttons name
        //                 }
        //                 else if(strlen($scanner3) == 4){
        //                 $buttonS=$scanner3[0] . $scanner3[1] . $scanner3[2] . $scanner3[3];
        //                 }
        //                 else{                return (['msg'=>'button field number doesnt exist']);
        //                 }
        //                 $buttonBo=false;

        //                 $buttonIs = Button::all();
        //                 foreach($buttonIs as $buttonI){
        //                     $BI=$buttonI->name;
        //                     $pos=strpos($BI,".");
        //                     $ext=$BI[$pos];
        //                     for($i=$pos+1;$i<strlen($BI);$i++){
        //                         $ext =  $ext.$BI[$i];
        //                     }
        //                     if($BI==$buttonS.$ext){
        //                         $buttonR=$buttonI;//$buttonR=$buttonI->name;
        //                         $buttonBo=true;
        //                     }
        //                 }
        //                 if ($buttonBo==false)
        //                 {                return (['msg'=>'button number doesnt exist']);
        //                 }

        //             break;
        //         case(2):
        //         break;
        //         }
        //         $Bid=$buttonR->id;
        //         $a = Button::where(['id'=>$Bid])->first();
        //         return $a;
        // }
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

                $scanner1=request('scanner1');
                $scanner2=request('scanner2');
                $family=request()->get('family');
                $scanner=$scanner1 . $scanner2;
                switch($family){
                    case('3120'):
                        if(strlen($scanner)==8){
                            $boitierS2=$scanner[0] . $scanner[1] . $scanner[3] . "_2";/**13 */
                        }
                        else{                return (['msg'=>'1 or 2 field number doesnt exist']);
                        }
                        $boitierBo2=false;
                            $boitierSIs = Boitier::all();
                            foreach($boitierSIs as $boitierSI){
                                $BoiI=$boitierSI->name;
                                $pos=strpos($BoiI,".");
                                $ext=$BoiI[$pos];
                                for($i=$pos+1;$i<strlen($BoiI);$i++){
                                    $ext =  $ext.$BoiI[$i];
                                }
                                if($BoiI==$boitierS2.$ext){
                                    $boitierR2=$boitierSI;
                                    $boitierBo2=true;
                                }
                            }
                            if ($boitierBo2==false)
                        {                return (['msg'=>'boitier 2 doesnt exist']);
                        }
                    break;
                case(2):
                break;
                }
                $Boiid2=$boitierR2->id;
                $a = Boitier::where(['id'=>$Boiid2])->first();
                return $a;
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
}
