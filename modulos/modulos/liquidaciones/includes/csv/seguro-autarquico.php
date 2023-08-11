<?php
set_time_limit(2800);

$periodoactual = $this->model->PeriodoActualObtener();
$periodoid = $periodoactual->periodo_id;
$datosexportob = $this->model->SeguroAutarquicoDatos($periodoactual->periodo_id);
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
$fecha_dos = strftime("%B", strtotime($fecha_uno));
$fecha_tres = strftime("%Y", strtotime($fecha_uno));




$headers = array('COD ENTE',
                 'DNI',
                 'C.LIQ LEGAJO',
                 'AAAAMM',
                 'COD.DESCUENTO.',
                 'IMPORTE',
                 'CANT SUELDOS',
                 'SSAJ',
                 '%APORTE',
                 '$',
                 'NOMBRE Y APELLIDO');



$file = fopen('file.csv', 'w');



fputcsv($file, $headers, ";");


foreach($datosexportob as $value){

        $sremundatos = $this->model->SRemunerativoObtener($value->legempleado_nrodocto, $periodoid);
        //--- restar saca
        $sacdatos = $this->model->SACObtener($value->legempleado_nrodocto, $periodoid);
        $sremundatosdos = $sremundatos->remunimp - $sacdatos->liquidacion_importe;
        $jubilaciondatos = $this->model->JubilacionObtener($value->legempleado_nrodocto, $periodoid);
        $empleadoresumendatos = $this->model->EmpleadoResumenObtener($value->legempleado_nrodocto);
        //$rest = substr("abcdef", -2);    // devuelve "ef"
        $emplegajonum = substr($empleadoresumendatos->legempleado_numerol, -4);//obtiene el numero de legajo que son los ultimos 4 digitos

        $lineData = array('54',
                          $value->legempleado_nrodocto,
                          $emplegajonum,
                          $periodoactual->periodo_nombre,
                          $value->liqcod_id,
                          $value->liquidacion_importe,
                          '0',
                          $sremundatosdos,
                          '13%',
                          $jubilaciondatos->jubilacionimp,
                          iconv("UTF-8", "Windows-1252",$empleadoresumendatos->legempleado_apellido).', '.iconv("UTF-8", "Windows-1252",$empleadoresumendatos->legempleado_nombres));
        fputcsv($file, $lineData, ";");
    }

// Close file
fclose($file);

// Send file to browser for download
$dest_file = 'file.csv';
$file_name = 'Seguro_autarquico_'.$fecha_dos.'_'.$fecha_tres.'.csv';
$file_size = filesize($dest_file);

header("Content-Type: text/csv; charset=utf-8");
header("Content-disposition: attachment; filename=\"$file_name\"");
header("Content-Length: " . $file_size);
readfile($dest_file);
?>
