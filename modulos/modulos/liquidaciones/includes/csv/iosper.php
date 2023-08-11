<?php
set_time_limit(2800);

$periodoactual = $this->model->PeriodoActualObtener();
$periodoid = $periodoactual->periodo_id;
$datosiosper = $this->model->IOSPERDatos($periodoid);
//----sona horario y formato de fechas--------
date_default_timezone_set("America/Buenos_Aires");
//setlocale(LC_ALL,"es_ES");
setlocale(LC_ALL, 'es_RA.UTF8');
//setlocale(LC_TIME, "es_RA.UTF-8");
setlocale(LC_TIME, 'es_RA.utf-8','spanish');
//setlocale('es_ES.UTF-8'); // I'm french !

$fecha_uno = date("Y-m-d",strtotime($periodoactual->periodo_presentismo_f."+ 1 days"));//sumo 1 dia
/*
$fecha_dos = new DateTime($fecha_uno);
$fecha_actual = $fecha_dos->format('Y-m-d');
echo "12/28/2002 - %V,%G,%Y = " . strftime("%V,%G,%Y", strtotime("12/28/2002")) . "\n";
*/

//$fecha_dos = strtotime("$fecha_uno");
//$dia = strftime("%B", strtotime(date("Y-m-d", $fecha_dos)));
$fecha_dos = strftime("%m", strtotime($fecha_uno));
$fecha_tres = strftime("%Y", strtotime($fecha_uno));




$headers = array('CUIL',
                 'DNI',
                 'TIPO DOC',
                 'APELLIDO Y NOMBRES',
                 'COD. LIQ',
                 'S REVISTA',
                 'ESTADO',
                 'REPARTICION',
                 'APORTE PERSONAL',
                 'ADHERENTE SECUNDARIO',
                 'FONDO VOLUNTARIO',
                 'HIJO MENOR DE 35',
                 'MENOR A CARGO',
                 'CREDITO ASISTENCIAL',
                 'S. SIN DESC',
                 'S. NETO',
                 'REAJUSTE A. PERSONAL',
                 'REAJUSTE AD. SEC.',
                 'REAJUSTE F. VOL.',
                 'REAJUSTE HJO MENOR 35',
                 'REAJUSTE MENOR A C.',
                 'REAJUSTE C. ASISTENCIAL',
                 'A. PATRONAL O.',
                 'REAJUSTE A. PAT. O.');



$file = fopen('MunicipalidadGualeguay_'.$fecha_dos.'_'.$fecha_tres.'.csv', 'w');



fputcsv($file, $headers, ";");


foreach($datosiosper as $value){


        $empleadodatos = $this->model->EmpleadoObtener($value->legempleado_nrodocto);
        $apnom = iconv("UTF-8", "Windows-1252",$empleadodatos->legempleado_apellido).' '.iconv("UTF-8", "Windows-1252",$empleadodatos->legempleado_nombres);
        $emplegajonum = substr($empleadodatos->legempleado_numerol, -4);//obtiene el numero de legajo que son los ultimos 4 digitos
        $IOSPERdatos = $this->model->LiquidacionCodigoYDNIObtener($value->legempleado_nrodocto, 333, $periodoid);
        $fondovoluntario = $this->model->LiquidacionCodigoYDNIObtener($value->legempleado_nrodocto, 339, $periodoid);
        $fondovoluntarioformat = number_format($fondovoluntario->liquidacion_importe, 2, '.', '');
        $hijomenor35 = $this->model->LiquidacionCodigoYDNIObtener($value->legempleado_nrodocto, 340, $periodoid);
        $hijomenor35format = number_format($hijomenor35->liquidacion_importe, 2, '.', '');
        $hijomenoracargo = $this->model->LiquidacionCodigoYDNIObtener($value->legempleado_nrodocto, 363, $periodoid);
        $hijomenoracargoformat = number_format($hijomenoracargo->liquidacion_importe, 2, '.', '');
        $adherentesec = $this->model->LiquidacionCodigoYDNIObtener($value->legempleado_nrodocto, 341, $periodoid);
        $adherentesecformat = number_format($adherentesec->liquidacion_importe, 2, '.', '');
        $creditoasistencial = $this->model->LiquidacionCodigoYDNIObtener($value->legempleado_nrodocto, 338, $periodoid);
        $creditoasistencialformat = number_format($creditoasistencial->liquidacion_importe, 2, '.', '');
        //---Horas, adicionales, simples dobles---------
        $hssimples = $this->model->LiquidacionCodigoYDNIObtener($value->legempleado_nrodocto, 140, $periodoid);
        $hsdobles = $this->model->LiquidacionCodigoYDNIObtener($value->legempleado_nrodocto, 141, $periodoid);
        //$hsadic = $this->model->LiquidacionCodigoYDNIObtner($value->legempleado_nrodocto, 142);
        //---Sueldo Remumunerativo -------
        $sremunerativo = $this->model->SRemunerativoObtener($value->legempleado_nrodocto, $periodoid);
        //---Calculo de sueldo sujeto a descuentos-----
        $ssindescuentos = $sremunerativo->remunimp
                        - $hssimples->liquidacion_importe
                        - $hsdobles->liquidacion_importe;
        $ssindescuentosformat = number_format($ssindescuentos, 2, '.', '');
        //----Sueldo no Remunerativo ---------
        $snoremunerativo = $this->model->SNoRemunerativoObtener($value->legempleado_nrodocto, $periodoid);
        //---Obtener Descuentos ---------
        $descuentos = $this->model->DescuentosObtener($value->legempleado_nrodocto, $periodoid);
        //----SAC ---------
        $sac = $this->model->SACObtener($value->legempleado_nrodocto, $periodoid);
        //---Calculo Sueldo Neto-------
        $sueldoneto = $sremunerativo->remunimp
                    + $snoremunerativo->noremunimp
                    - $descuentos->descuentosimp;
        $sueldonetoformat = number_format($sueldoneto, 2, '.', '');
        //---Calculo aporte patronal obra social---
        if($sac->liquidacion_importe > 0){
          //----tiene sac
          if($ssindescuentos < 59034){
            $sremunerativocpos = 59034;
          }else{
            $sremunerativocpos = $ssindescuentos;
          }
        }else{
          //---no tiene sac
          if($ssindescuentos < 36441){
            $sremunerativocpos = 36441;
          }else{
            $sremunerativocpos = $ssindescuentos;
          }
        }

        $contptaosocial = $sremunerativocpos * 5 / 100;


        $cantidadformatoformat = number_format($contptaosocial, 2, ',', '');
        //-----fin Calculo aporte patronal obra social---
        //-----Situacion de revista ------
        $legtipodatos = $this->model->LegajoTipoObtener($empleadodatos->legtipo_id);

        $lineData = array($empleadodatos->legempleado_nrocuil,
                          $value->legempleado_nrodocto,
                          '1',
                          $apnom,
                          $emplegajonum,
                          $legtipodatos->legtipo_nombre,
                          'S/N',
                          'Municipalidad de Gualeguay',
                          $IOSPERdatos->liquidacion_importe,
                          $adherentesecformat,
                          $fondovoluntarioformat,
                          $hijomenor35format,
                          $hijomenoracargoformat,
                          $creditoasistencialformat,
                          $ssindescuentosformat,
                          $sueldonetoformat,
                          '0.00',
                          '0.00',
                          '0.00',
                          '0.00',
                          '0.00',
                          '0.00',
                          $cantidadformatoformat,
                          '0.00');
        fputcsv($file, $lineData, ";");
    }

// Close file
fclose($file);

// Send file to browser for download
//$dest_file = 'file.csv';
$dest_file = 'MunicipalidadGualeguay_'.$fecha_dos.'_'.$fecha_tres.'.csv';
$file_name = 'MunicipalidadGualeguay_'.$fecha_dos.'_'.$fecha_tres.'.csv';
$file_size = filesize($dest_file);

header("Content-Type: text/csv; charset=utf-8");
header("Content-disposition: attachment; filename=\"$file_name\"");
header("Content-Length: " . $file_size);
readfile($dest_file);
//borra el archivo
unlink($dest_file);
?>
