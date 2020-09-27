<?php

namespace App\Http\Controllers;
use App\Ampere;
use App\Pole;
use App\Boitier;
use App\Button;
use App\Product;
use App\Worker;
use Illuminate\Http\Request;

class Scanner extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('auth'); acces just 4 normal user
        //$this->middleware('guest');//4admin and moderator except normal user and logout
        //$this->middleware('auth:web');//just 4 normal user
        //$this->middleware('auth:api');//doesnt work with any type of auth
        //$this->middleware('web');access 4 all
    }
    public function show(){
        return view('scanner.input');
    }
    public function scannerReader(Request $request){
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
        foreach($workers as $worker){
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
                            $buttonS="N-".$scanner3[0] . $scanner3[1] . $scanner3[2] . $scanner3[3] .$scanner3[4];
                        }
                        else if(strlen($scanner3) == 5){
                        $buttonS="N-".$scanner3[0] . $scanner3[1] . $scanner3[2] . $scanner3[3];
                        }
                        else{return redirect(route('scanner.get'))->with('error','OF button field is wrong');}
                        if(strlen($scanner)==8){
                            $boitierS=$scanner[0] . $scanner[1] . $scanner[3] . "_1";
                            $boitierS2=$scanner[0] . $scanner[1] . $scanner[3] . "_2";/**13 */
                            $poleS=$scanner[2] . $scanner[4] . $scanner[5];//_Bel
                        }
                        else{return redirect(route('scanner.get'))->with('error','OF first or(and) second field is(are) wrong');}
                        if(strlen ($scanner4)==4){
                            $ampereS=$scanner4[0] . $scanner4[1] . $scanner4[2] . $scanner4[3];
                        }
                        else if(strlen ($scanner4)==3){
                            $ampereS=$scanner4[0] . $scanner4[1]. $scanner4[2];
                        }
                        else if (strlen ($scanner4)==2){
                            $ampereS=$scanner4[0]. $scanner4[1];
                        }
                        else{return redirect(route('scanner.get'))->with('error','OF ampere field is wrong');}
                        $buttonBo=false;
                        $boitierBo=false;
                        $boitierBo2=false;
                        $poleBo=false;
                        $ampereBo=false;

                        $buttonIs = Button::all();
                        foreach($buttonIs as $buttonI){
                            $BI=$buttonI->first_image;
                            $pos=strpos($BI,".");
                            $ext=$BI[$pos];
                            for($i=$pos+1;$i<strlen($BI);$i++){
                                $ext =  $ext.$BI[$i];
                            }
                            if($BI==$buttonS.$ext){
                                $buttonR=$buttonI;//$buttonR=$buttonI->first_image;
                                $buttonBo=true;
                            }
                        }
                        if ($buttonBo==false)
                        {return redirect(route('scanner.get'))->with('error','OF  button is wrong');}

                            $boitierSIs = Boitier::all();
                            foreach($boitierSIs as $boitierSI){

                                $BoiI=$boitierSI->second_image;
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
                        {return redirect(route('scanner.get'))->with('error','OF  boitier is wrong');}
                            $poleIs = Pole::all();
                        foreach($poleIs as $poleI){
                            $PI=$poleI->third_image;
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
                        {return redirect(route('scanner.get'))->with('error','OF pole number is wrong');}
                        $ampereIs = Ampere::all();
                        foreach($ampereIs as $ampereI){
                            $AI=$ampereI->fourth_image;
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
                        {return redirect(route('scanner.get'))->with('error','OF ampere number is wrong');}
                        // $boitierR = Boitier::where('second_image',$boitier)->first();
                        // $poleR = Pole::where('third_image',$pole)->first();
                        // $ampereR = Ampere::where('fourth_image',$ampere)->first();
                    break;
                case(2):
                break;
                }
                $Bid=$buttonR->id;
                $Boiid=$boitierR->id;
                $Boiid2=$boitierR2->id;
                $Pid=$poleR->id;
                $ampid=$ampereR->id;
                $products=Product::all();
                foreach($products as $product){
                    if($product->first_element_id ==$Bid &&$product->second_element_id ==$Boiid&&$product->third_element_id ==$Pid&&$product->fourth_element_id ==$ampid){
                        $productR=$product;
                    }
                }
                return view('scanner.result')->with(compact(['buttonR','boitierR', 'boitierR2','poleR','ampereR','productR']));
            }
            else{
                return redirect(route('scanner.get'))->with('error','registration number doesnt exist');
            }
        }

    }
    public function scannerResult(){
        return view('scanner.result');

    }
}
