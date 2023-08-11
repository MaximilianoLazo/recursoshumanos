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
  $jub_datos_bersa= $this->model->JubiladoPasivoObtener();

  //$mes = date('m') ;
  //$anio=date("Y");
  $mes=substr($periodo->periodo_nombre,4,2);
  $anio=substr($periodo->periodo_nombre,2,2);
  //$fecha_actual = $fecha_dos->format('Y-m-d');
  $archivo = fopen('ARLAZA-J'.'.txt', 'w');

  if($archivo == false){
    echo "Error al crear el archivo";
  }else{

   // Escribir en el archivo:
   foreach ($jub_datos_bersa as $value) {

     //---obtner codigo 353 - seguro de vida
     //$docu=str_pad($value->cjmdg_bersa_nrodoc,8,"0", STR_PAD_LEFT);
     //$valor = explode(".", $value->cjmdg_detsueldo_importe);
     //$valor0=str_pad($valor[0],5,"0",STR_PAD_LEFT);
     //$valor1=str_pad($valor[1],2,"0",STR_PAD_RIGHT);

     $jub_sueldo = $this->model->JubiladoSueldoObtener($value->cjmdg_personal_nroleg2,1,$periodo->periodo_id);
     $a=str_pad(number_format($jub_sueldo->cjmdg_detsueldo_importe,2,',',''),12,"0", STR_PAD_LEFT);

     $ape=str_pad($value->legajo_apellido." ".$value->legajo_nombres,31," ", STR_PAD_RIGHT);
     $valor='000102905330000000800000000';
     $valor1='000000000000000000000000000000000000000000000ENTRE RIOS RESTO DE LA PROVINCIA                  ';
     $valor2='00000000000090000000001010100000000';
     $valor3='000000000000000000000000000000000000000000000000000000030';
     $valor4='00000000000000000000000000000000000000';
     $valor5='0000000000000000000000000000000000000';
     $valor6='000000000000000000000000000000000000000000000000';
     //$seguro_vida = $this->model->LiquidacionCodigoYDNIObtener($value->legempleado_nrodocto, 353, $periodoactual->periodo_id);
     fwrite($archivo,"$value->legajo_cuil$ape$valor$a$a$valor1$a$a$a$valor2$a$valor3$a$valor4$a$valor6$a$valor5$a" .PHP_EOL);
   }

   fflush($archivo);
  }
  // Cerrar el archivo:
  fclose($archivo);

$dest_file = 'ARLAZA-J'.'.txt';
$file_size = filesize($dest_file);
$file_name = 'ARLAZA-J'.'.txt';

  header("Content-Type: text/csv; charset=utf-8");
  header("Content-disposition: attachment; filename=\"$file_name\"");
  header("Content-Length: " . $file_size);
  readfile($dest_file);
  //borra el archivo
  unlink($dest_file);

?>
