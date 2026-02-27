<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Counter;
class RedirectionController extends Controller
{
    public function credencial(){
        $Clicks=Counter::where('name','credencial_redirect')->first();
        $Clicks->value=$Clicks->value+1;
        $Clicks->save();
        return redirect()->away('https://www.pveaju.unam.mx/credencial');
    }
    public function redirect_counter($counter_name){
        $Clicks=Counter::where('name',$counter_name)->first();
        if($Clicks){
            $Clicks->value=$Clicks->value+1;
            $Clicks->save();
            return redirect()->away( $Clicks->url);
        }else{
            return redirect()->away('https://www.pveaju.unam.mx/encuesta/01/seguimiento_egresados_UNAM/');
        }
        
   
    }
}
