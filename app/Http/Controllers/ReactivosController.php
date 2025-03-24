<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Reactivo;
use App\Models\Option;
use App\Models\Bloqueo;
use DB;
class ReactivosController extends Controller
{
    public static function chooseType($id,$Reactivos){
        $Reactivo=Reactivo::find($id);
        if($Reactivo->type=="text"){
            return view('components.reactivos.text',compact('Reactivo'));
        }
        
        if($Reactivo->type=="number"){
            return view('components.reactivos.number',compact('Reactivo'));
        }
        if($Reactivo->type=="label"){
            return view('components.reactivos.label',compact('Reactivo'));
        }
        
        if($Reactivo->type=="option"){
            $Bloqueos=DB::table('bloqueos')->join('reactivos','bloqueos.bloqueado','reactivos.clave')
            ->where('clave_reactivo','=',$Reactivo->clave)->get();
            $Bloqueos=$Bloqueos->whereIn('bloqueado',$Reactivos->unique('clave')->pluck('clave')->toArray());
            $Bloqueos=$Bloqueos->whereIn('clave_reactivo',$Reactivos->unique('clave')->pluck('clave')->toArray());
            
            
            if($Reactivo->archtype){
                $Opciones=Option::where('reactivo',$Reactivo->archtype)->get();
            }else{
                $Opciones=Option::where('reactivo',$Reactivo->clave)->orderBy('clave', 'ASC')->get();   
            }
        
            // return view('components.reactivos.option',compact('Reactivo','Opciones','Bloqueos'));
            if($Opciones->count() > 5){
                return view('components.reactivos.option_large',compact('Reactivo','Opciones','Bloqueos'));
            }else{
                return view('components.reactivos.option',compact('Reactivo','Opciones','Bloqueos'));
            }
        }
        if($Reactivo->type=="multiple_option"){
            $Opciones=Option::where('reactivo',$Reactivo->clave)
            ->whereHas('reactivo', function($query){
                $query->where('rules', 'act')->orWhereNull('rules');
            })
            ->get();
            //$Opciones=Option::where('reactivo',$Reactivo->clave)->get();
            $Bloqueos = DB::table('bloqueos')->join('reactivos', 'bloqueos.clave_reactivo', '=', 'reactivos.clave')->select('bloqueos.*')
            ->whereIn('reactivos.section', [$section, 'act' . $section])
            ->where('reactivos.rules', '=', 'act')
            ->orderBy('orden')
            ->get();
            $Bloqueos=$Bloqueos->whereIn('bloqueado',$Reactivos->unique('clave')->pluck('clave')->toArray());
            //$Bloqueos=DB::table('bloqueos')->join('reactivos','bloqueos.bloqueado','reactivos.clave')
            //->where('clave_reactivo','=',$Reactivo->clave)->get();


        //    dd($Bloqueos->where('valor',18)->count());
            return view('components.reactivos.multiple',compact('Reactivo','Opciones','Bloqueos'));   
        }
    }
}
