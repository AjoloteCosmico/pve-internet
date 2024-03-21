<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Symfony\Component\Process\Process; 
use Symfony\Component\Process\Exception\ProcessFailedException;

class ReportController extends Controller
{
    public function generate($report)
       {
           $caminoalpoder=public_path();
           $process = new Process(['python3', $report.'.py'],$caminoalpoder);
           $process->run();
           if (!$process->isSuccessful()) {
               throw new ProcessFailedException($process);
           }
           $data = $process->getOutput();
           
               return response()->download(public_path('storage/'.$report.'.xlsx'));
          
       }
       public function semanal ($semana,$user){
        //la semana 1 comenzo el lunes 1 de enero
        $dias=$semana*7;
        $inicio=date('01-01-2024')->modify('+ '.$dias.' days');
        dd($inicio);
        return view('reports.semanal');
       }
}
