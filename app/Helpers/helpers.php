<?php

function  validar_cuenta($cuenta)
        {
            //formatear cuenta rellenando 9 digitos con un 0 a la izt
            $cuenta=str_pad($cuenta, 9, "0", STR_PAD_LEFT);
            $SumaNones=0;
            $SumaPares=0;
            $Suma = 0;

            if (strlen($cuenta) < 8){
                return False;
            }

            $SumaNones = $cuenta[0] + $cuenta[2] + $cuenta[4] + $cuenta[6];
            $SumaPares = $cuenta[1] + $cuenta[3] + $cuenta[5] + $cuenta[7];
            $SumaNones = $SumaNones * 3;
            $SumaPares = $SumaPares * 7;
            $Suma = $SumaNones + $SumaPares;
            if($SumaNones==0 && $SumaPares==0){ //esto es para evitar el caso en que typean '000000000' pues la operacion daria (0*3+0*7)%10=0 (num valido) pero sabemos  q no es
                return False;
            }
            $verfiDigit= $Suma % 10;
            if((Int)$verfiDigit==(Int)$cuenta[8]){
                return True;
            }
            else{
                return False;
            }
        }