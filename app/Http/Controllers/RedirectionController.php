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
}
