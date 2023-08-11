<?php
  error_reporting(0);
  //----sona horario y formato de fechas--------
  date_default_timezone_set("America/Buenos_Aires");
  //setlocale(LC_ALL,"es_ES");
  setlocale(LC_ALL, 'es_RA.UTF8');
  //setlocale(LC_TIME, "es_RA.UTF-8");
  setlocale(LC_TIME, 'es_RA.utf-8','spanish');
  //setlocale('es_ES.UTF-8'); // I'm french !
  //////////////////////////////////////////////////////////////////
  $periodo=$this->model->CJMDGPeriodoObtener();
  $jub_datos_bersa= $this->model->JubiladoBERSAObtener($periodo->periodo_id);

  $mes=substr($periodo->periodo_nombre + 1,4,2);

  //$mes = date('m') ;
  //$anio=date("Y");
  $anio=substr($periodo->periodo_nombre,0,4);

  //$fecha_actual = $fecha_dos->format('Y-m-d');
  $archivo = fopen('RESCODESCJGUAL-'.$anio.$mes.'.txt', 'w');

  if($archivo == false){
    echo "Error al crear el archivo";
  }else{

   // Escribir en el archivo:
   foreach ($jub_datos_bersa as $value) {

     //---obtner codigo 353 - seguro de vida
     $docu=str_pad($value->cjmdg_bersa_nrodoc,8,"0", STR_PAD_LEFT);
     $valor = explode(".", $value->cjmdg_detsueldo_importe);
     $valor0=str_pad($valor[0],5,"0",STR_PAD_LEFT);
     $valor1=str_pad($valor[1],2,"0",STR_PAD_RIGHT);

     if(strlen($value->cjmdg_bersa_cuotaactual)!=1){
        $cuota=$value->cjmdg_bersa_cuotaactual;}
        else{
        $cuota=str_pad($value->cjmdg_bersa_cuotaactual,2,"0",STR_PAD_LEFT);
      }
     //$valor=str_pad($value->cjmdg_detsueldo_importe,7,"0",STR_PAD_LEFT);
     //$seguro_vida = $this->model->LiquidacionCodigoYDNIObtener($value->legempleado_nrodocto, 353, $periodoactual->periodo_id);
     fwrite($archivo, "480$value->cjmdg_bersa_cuil$valor0$valor1$cuota/$value->cjmdg_bersa_cuotatotal$valor0$valor1" .PHP_EOL);
   }

   fflush($archivo);
  }
  // Cerrar el archivo:
  fclose($archivo);

$dest_file = 'RESCODESCJGUAL-'.$anio.$mes.'.txt';
$file_size = filesize($dest_file);
$file_name = 'RESCODESCJGUAL-'.$anio.$mes.'.txt';

  header("Content-Type: text/csv; charset=utf-8");
  header("Content-disposition: attachment; filename=\"$file_name\"");
  header("Content-Length: " . $file_size);
  readfile($dest_file);
  //borra el archivo
  unlink($dest_file);

?>
