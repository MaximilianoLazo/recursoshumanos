<?php
set_time_limit(2800);
error_reporting(0);
//$datosiosper = $this->model->IOSPERDatos();
//----sona horario y formato de fechas--------
date_default_timezone_set("America/Buenos_Aires");
//setlocale(LC_ALL,"es_ES");
setlocale(LC_ALL, 'es_RA.UTF8');
//setlocale(LC_TIME, "es_RA.UTF-8");
setlocale(LC_TIME, 'es_RA.utf-8','spanish');
//setlocale('es_ES.UTF-8'); // I'm french !
$periodo=$this->model->CJMDGPeriodoObtener();

$mes=substr($periodo->periodo_nombre,4,2);
//$mesAnterior = date('m', strtotime('-1 month')) ;

$anio=substr($periodo->periodo_nombre,0,4);
//$anio=date("Y");

$jub_datos = $this->model->JubiladoObtener();

//$fecha_actual = $fecha_dos->format('Y-m-d');
$file = fopen('CAJAJUBILMUNICIPALGUALEGUAY_'.$mes.$anio.'.csv', 'c+');

//$dia = strftime("%B", strtotime(date("Y-m-d", $fecha_dos)));
$contar=0;
foreach ($jub_datos as $value) {$contar=$contar+1;
      //echo $contar."<br>"."-".$value->cjmdg_personal_nroleg2."<br>";
      //$uno=51746;
      $jub_sueldo = $this->model->JubiladoSueldoObtener($value->cjmdg_personal_nroleg2,100,$periodo->periodo_id);
      $importeiosper=0;$descuento=0;$uno=54989;$dos=4;$tres=81;$haber=0;$habercalculo=0;$a=0;$ad=0;$calc=0;$calc1=0;$imp111=0;
      $jub_sueldo = $this->model->JubiladoSueldoObtener($value->cjmdg_personal_nroleg2,100,$periodo->periodo_id);
      $importeiosper=$jub_sueldo->cjmdg_detsueldo_importe;$importe100=$jub_sueldo->cjmdg_detsueldo_importe;

      $jub_sueldo = $this->model->JubiladoSueldoObtener($value->cjmdg_personal_nroleg2,109,$periodo->periodo_id);
      if($jub_sueldo<>""){$importeiosper=$importeiosper+$jub_sueldo->cjmdg_detsueldo_importe;}

      //$a="00".number_format($importeiosper,2,'.','')."|";
      $a=str_pad(number_format($importeiosper,2,'.',''),9,"0", STR_PAD_LEFT)."|";
      //$descuento=$descuento+$importeiosper;

      $jub_sueldo = $this->model->JubiladoSueldoObtener($value->cjmdg_personal_nroleg2,101,$periodo->periodo_id);
      if($jub_sueldo==""){$ad=$ad;}else{$ad=$ad+$jub_sueldo->cjmdg_detsueldo_importe;  $descuento=$descuento+$jub_sueldo->cjmdg_detsueldo_importe;}

      $jub_sueldo = $this->model->JubiladoSueldoObtener($value->cjmdg_personal_nroleg2,104,$periodo->periodo_id);
      if($jub_sueldo==""){$ad=$ad;}else{$ad=$ad+$jub_sueldo->cjmdg_detsueldo_importe;  $descuento=$descuento+$jub_sueldo->cjmdg_detsueldo_importe;}

      $jub_sueldo = $this->model->JubiladoSueldoObtener($value->cjmdg_personal_nroleg2,105,$periodo->periodo_id);
      if($jub_sueldo==""){$ad=$ad;}else{$ad=$ad+$jub_sueldo->cjmdg_detsueldo_importe;  $descuento=$descuento+$jub_sueldo->cjmdg_detsueldo_importe;}

      if($ad==0){$a=$a."0.00|";}else{$a=$a.str_pad(number_format($ad,2,'.',''),9,"0", STR_PAD_LEFT)."|";}

      $jub_sueldo = $this->model->JubiladoSueldoObtener($value->cjmdg_personal_nroleg2,106,$periodo->periodo_id);
      if($jub_sueldo==""){$a=$a."0.00|";$importefondo=0;}else{$a=$a.str_pad(number_format($jub_sueldo->cjmdg_detsueldo_importe,2,'.',''),7,"0", STR_PAD_LEFT)."|";$importefondo=$jub_sueldo->cjmdg_detsueldo_importe;$descuento=$descuento+$jub_sueldo->cjmdg_detsueldo_importe;}

      $jub_sueldo = $this->model->JubiladoSueldoObtener($value->cjmdg_personal_nroleg2,111,$periodo->periodo_id);
      if($jub_sueldo==""){$a=$a."0.00|";}else{$a=$a.str_pad(number_format($jub_sueldo->cjmdg_detsueldo_importe,2,'.',''),7,"0", STR_PAD_LEFT)."|";$imp111=$jub_sueldo->cjmdg_detsueldo_importe;$descuento=$descuento+$jub_sueldo->cjmdg_detsueldo_importe;}

      $jub_sueldo = $this->model->JubiladoSueldoObtener($value->cjmdg_personal_nroleg2,109,$periodo->periodo_id);
      if($jub_sueldo==""){$descuento=$descuento+$importeiosper;}else{$descuento=$descuento+$importeiosper-$jub_sueldo->cjmdg_detsueldo_importe;}

      //$jub_sueldo = $this->model->JubiladoSueldoObtener($value->cjmdg_personal_nroleg2,107);
      //if($jub_sueldo==""){$a=$a."0.00|";}else{$a=$a.$jub_sueldo->cjmdg_detsueldo_importe."|";}
      $a=$a."0.00|";
      //107 y 108 van en columna L
          $adher=0;
          $jub_sueldo = $this->model->JubiladoSueldoObtener($value->cjmdg_personal_nroleg2,107,$periodo->periodo_id);
          if($jub_sueldo==""){

          }else{
            $adher=$adher+$jub_sueldo->cjmdg_detsueldo_importe;
            $descuento=$descuento+$jub_sueldo->cjmdg_detsueldo_importe;
          }

          $jub_sueldo = $this->model->JubiladoSueldoObtener($value->cjmdg_personal_nroleg2,108,$periodo->periodo_id);
          if($jub_sueldo==""){

          }else{$adher=$adher+$jub_sueldo->cjmdg_detsueldo_importe;
            $descuento=$descuento+$jub_sueldo->cjmdg_detsueldo_importe;
          }
          if ($adher==0){$a=$a."0.00|";}else{$a=$a.str_pad(number_format($adher,2,'.',''),9,"0", STR_PAD_LEFT)."|";}

      //$jub_sueldo = $this->model->JubiladoSueldoObtener($value->cjmdg_personal_nroleg2,106);
      //if($jub_sueldo==""){$a=$a."0.00|";}else{$a=$a.$jub_sueldo->cjmdg_detsueldo_importe."|";}

      $jub_sueldo = $this->model->JubiladoSueldoObtener($value->cjmdg_personal_nroleg2,1,$periodo->periodo_id);
      $haber=$jub_sueldo->cjmdg_detsueldo_importe;
      $habercalculo=$jub_sueldo->cjmdg_detsueldo_importe;;
      if($value->cjmdg_personal_jub=="ACTIVO"){

        $jub_sueldo = $this->model->JubiladoSueldoObtener($value->cjmdg_personal_nroleg2,3,$periodo->periodo_id);
        if($jub_sueldo!=""){$haber=$haber+$jub_sueldo->cjmdg_detsueldo_importe;}
        $jub_sueldo = $this->model->JubiladoSueldoObtener($value->cjmdg_personal_nroleg2,4,$periodo->periodo_id);
        if($jub_sueldo!=""){$haber=$haber+$jub_sueldo->cjmdg_detsueldo_importe;}
        $jub_sueldo = $this->model->JubiladoSueldoObtener($value->cjmdg_personal_nroleg2,7,$periodo->periodo_id);
        if($jub_sueldo!=""){$haber=$haber+$jub_sueldo->cjmdg_detsueldo_importe;}
        $jub_sueldo = $this->model->JubiladoSueldoObtener($value->cjmdg_personal_nroleg2,12,$periodo->periodo_id);
        if($jub_sueldo!=""){$haber=$haber+$jub_sueldo->cjmdg_detsueldo_importe;}
        $jub_sueldo = $this->model->JubiladoSueldoObtener($value->cjmdg_personal_nroleg2,20,$periodo->periodo_id);
        if($jub_sueldo!=""){$haber=$haber+$jub_sueldo->cjmdg_detsueldo_importe;}
        $jub_sueldo = $this->model->JubiladoSueldoObtener($value->cjmdg_personal_nroleg2,21,$periodo->periodo_id);
        if($jub_sueldo!=""){$haber=$haber+$jub_sueldo->cjmdg_detsueldo_importe;}
        $jub_sueldo = $this->model->JubiladoSueldoObtener($value->cjmdg_personal_nroleg2,22,$periodo->periodo_id);
        if($jub_sueldo!=""){$haber=$haber+$jub_sueldo->cjmdg_detsueldo_importe;}
        $jub_sueldo = $this->model->JubiladoSueldoObtener($value->cjmdg_personal_nroleg2,23,$periodo->periodo_id);
        if($jub_sueldo!=""){$haber=$haber+$jub_sueldo->cjmdg_detsueldo_importe;}
        $jub_sueldo = $this->model->JubiladoSueldoObtener($value->cjmdg_personal_nroleg2,41,$periodo->periodo_id);
        if($jub_sueldo!=""){$haber=$haber+$jub_sueldo->cjmdg_detsueldo_importe;}
        $jub_sueldo = $this->model->JubiladoSueldoObtener($value->cjmdg_personal_nroleg2,42,$periodo->periodo_id);
        if($jub_sueldo!=""){$haber=$haber+$jub_sueldo->cjmdg_detsueldo_importe;}
        $jub_sueldo = $this->model->JubiladoSueldoObtener($value->cjmdg_personal_nroleg2,43,$periodo->periodo_id);
        if($jub_sueldo!=""){$haber=$haber+$jub_sueldo->cjmdg_detsueldo_importe;}
        $jub_sueldo = $this->model->JubiladoSueldoObtener($value->cjmdg_personal_nroleg2,50,$periodo->periodo_id);
        if($jub_sueldo!=""){$haber=$haber+$jub_sueldo->cjmdg_detsueldo_importe;}
        $desc=0;
        $jub_sueldo = $this->model->JubiladoSueldoObtener($value->cjmdg_personal_nroleg2,80,$periodo->periodo_id);
        if($jub_sueldo==""){$a=$a.str_pad(number_format($haber,2,'.',''),9,"0", STR_PAD_LEFT)."|";}else{$desc=$jub_sueldo->cjmdg_detsueldo_importe;$a=$a.str_pad(number_format($haber-$jub_sueldo->cjmdg_detsueldo_importe,2,'.',''),9,"0", STR_PAD_LEFT)."|";}
        //$a=$a.str_pad(number_format($haber,2,'.',''),9,"0", STR_PAD_LEFT)."|";
      }
      else{
        $a=$a.str_pad(number_format($haber,2,'.',''),9,"0", STR_PAD_LEFT)."|";$haber=$jub_sueldo->cjmdg_detsueldo_importe;
      }
      if($value->cjmdg_personal_jub=="ACTIVO"){
        $importeacobrar=$haber-$descuento-$desc;

      }else{$importeacobrar=$habercalculo-$descuento;}

      //echo $value->cjmdg_personal_cuil."-".$habercalculo."-".$descuento."-".$importeacobrar."<br>";
      //$importeacobrar=$haber-$importe100-$importefondo;
      //$jub_sueldo = $this->model->JubiladoSueldoObtener($value->cjmdg_personal_nroleg2,106);
      //if($jub_sueldo==""){$a=$a."0.00|";}else{$a=$a.$jub_sueldo->cjmdg_detsueldo_importe."|";}
      $a=$a.str_pad(number_format($importeacobrar,2,'.',''),9,"0", STR_PAD_LEFT)."|";

      //$jub_sueldo = $this->model->JubiladoSueldoObtener($value->cjmdg_personal_nroleg2,106);
      //if($jub_sueldo==""){$a=$a."0.00|";}else{$a=$a.$jub_sueldo->cjmdg_detsueldo_importe."|";}
      $a=$a."0.00|0.00|0.00|";
      //$jub_sueldo = $this->model->JubiladoSueldoObtener($value->cjmdg_personal_nroleg2,106);
      //if($jub_sueldo==""){$a=$a."0.00|";}else{$a=$a.$jub_sueldo->cjmdg_detsueldo_importe."|";}

      //$jub_sueldo = $this->model->JubiladoSueldoObtener($value->cjmdg_personal_nroleg2,106);
      //if($jub_sueldo==""){$a=$a."0.00|";}else{$a=$a.$jub_sueldo->cjmdg_detsueldo_importe."|";}

      //$jub_sueldo = $this->model->JubiladoSueldoObtener($value->cjmdg_personal_nroleg2,106);
      //if($jub_sueldo==""){$a=$a."0.00|";}else{$a=$a.$jub_sueldo->cjmdg_detsueldo_importe."|";}
      if($imp111!=0){$a=$a.str_pad(number_format($imp111,2,'.',''),9,"0", STR_PAD_LEFT)."|";}else{$a=$a."0.00|";}

      //$jub_sueldo = $this->model->JubiladoSueldoObtener($value->cjmdg_personal_nroleg2,106);
      //if($jub_sueldo==""){$a=$a."0.00|";}else{$a=$a.$jub_sueldo->cjmdg_detsueldo_importe."|";}

      //$jub_sueldo = $this->model->JubiladoSueldoObtener($value->cjmdg_personal_nroleg2,106);
      //if($jub_sueldo==""){$a=$a."0.00|";}else{$a=$a.$jub_sueldo->cjmdg_detsueldo_importe."|";}
      $a=$a."0.00|0.00|";
      $haber_activo=$haber * 5.5/100;
      $haber_pasivo=$haber * 4/100;

      $io_basico_pa = $this->model->IOSPERImporteObtener(1);
      $minimo=$io_basico_pa->parametro_monto;
      $io_basico_act=$this->model->IOSPERImporteObtener(2);
      $minimo_act=$io_basico_act->parametro->monto;
      if($value->cjmdg_personal_jub=="ACTIVO"){
          if($haber_activo <= $minimo_act){$a=$a.$minimo_act."|0.00";}else
            {$a=$a.str_pad(number_format(($haber_activo),2,'.',''),9,"0", STR_PAD_LEFT)."|0.00";}
      } else{
            //if($contar==92){echo $haber."-".$uno;}
            if($haber_pasivo <= $minimo){$a=$a.$minimo."|0.00";}else
              {$a=$a.str_pad(number_format(($haber_pasivo),2,'.',''),9,"0", STR_PAD_LEFT)."|0.00";}
            //if($haber>$uno){$a=$a.str_pad(number_format(($haber * 4 / 100),2,'.',''),9,"0", STR_PAD_LEFT)."|0.00";}
            //  elseif($calc2<$importeiosper){$a=$a."001697.00|0.00";}else{$a=$a.str_pad(number_format(floor($calc2),2,'.',''),9,"0", STR_PAD_LEFT)."|0.00";}
          //}
      }
      //echo $contar."haber:".$haber."-"."uno:".$uno."-".$importeiosper."-".$calc1."<br>";
      //$a=$a."0.00"
      //$jub_sueldo = $this->model->JubiladoSueldoObtener($value->cjmdg_personal_nroleg2,106);
      //if($jub_sueldo==""+-89){$a=$a."0.00|";}else{$a=$a.$jub_sueldo->cjmdg_detsueldo_importe."|";}

      if(strlen($value->legajo_nrodocto)<8){$doc="0".$value->legajo_nrodocto;}else{$doc=$value->legajo_nrodocto;}
      
      $cad=$value->legajo_cuil."|".$doc."|".$value->tipo_docto_id."|".str_pad($value->legajo_apellido." ".$value->legajo_nombres,30," ", STR_PAD_RIGHT)."|00".$value->legajo_id."|".str_pad($value->cjmdg_personal_jub,10," ", STR_PAD_RIGHT)."|SN|CAJA MUNICIPAL DE GUALEGUAY|".$a;
      //echo $cad."<br>";
      $lineData = array($cad);
      fputcsv($file, $lineData, ";",chr(0));
}

//exit();
// Close file
fclose($file);


// Send file to browser for download
//$dest_file = 'file.csv';
$dest_file = 'CAJAJUBILMUNICIPALGUALEGUAY_'.$mes.$anio.'.csv';
$file_name = 'CAJAJUBILMUNICIPALGUALEGUAY_'.$mes.$anio.'.csv';

$file_size = filesize($dest_file);

header("Content-Type: text/csv; charset=utf-8");
header("Content-disposition: attachment; filename=\"$file_name\"");
header("Content-Length: " . $file_size);
readfile($dest_file);
//borra el archivo
unlink($dest_file);
?>
