<?php
require_once 'model/importacion.php';
date_default_timezone_set("America/Buenos_Aires");
session_start();
//error_reporting(0);
if(!isset($_SESSION["usuario_id"])){
  header("../importacionliquido/index.php");
}

class ImportacionController{

    private $model;

    public function __CONSTRUCT(){
        $this->model = new Importacion();
    }
    public function Index(){
      require_once 'view/personal0.php';
    }
    public function Personal(){
      require_once 'view/personal.php';
    }
    public function ImportarFondo(){
      require_once 'view/importar_fondo.php';
    }

    public function ImportarCredito(){
      require_once 'view/importar_credito.php';
    }

    public function Archivos(){
      require_once 'view/generar-archivos.php';
    }

    public function CJMDGPersonalImportarFondo(){
      $cjimp = new Importacion();

      if(isset($_POST['btnbancobersadescimportarfondo'])){
        // validate to check uploaded file is a valid csv file

        $file_mimes = array('application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
        if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'],$file_mimes)){
          //
          if(is_uploaded_file($_FILES['file']['tmp_name'])){
              $txt_file = fopen($_FILES['file']['tmp_name'], 'r');

              //Output a line of the file until the end is reached
              while(!feof($txt_file)){

                $linea = fgets($txt_file);

                // Se evalúa a true ya que $var está vacia
                if (!empty($linea)) {
                  //echo '$var es o bien 0, vacía, o no se encuentra definida en absoluto';
                  $cjimp->RegistroCompleto = str_split($linea, 40);

                  //echo "--------------------"."<br/>";
                  $periodo=$this->model->PeriodoObtenerNuevo();

                  foreach ($cjimp->RegistroCompleto as $value) {
                    # code...
                    //echo $value."<br>";
                        //echo $value;
                        //echo "<br>"."<br>";

                        $cjimp->doc =substr($value, 10, 8);
                        $legajo=$this->model->LegajoObtener($cjimp->doc);

                        $cjimp->nroleg= $legajo->legajo_id;

                        $cjimp->importe=substr($value,24,7);

                        //echo $cjimp->fecha." ";
                        //echo $cjimp->categoria."<br>";

                        $this->model->CJMDGLiquidoCabImportarFondo($cjimp->nroleg,$cjimp->importe,$cjimp->doc,$periodo->periodo_id);
                        //echo $cjimp->doc." "."<br>";
                        //echo $cjimp->importe." "."<br>";
                        //echo $cjimp->nroleg." "."<br>";

                    //---numero docto
                    //$cjimp->NumDocto = substr($value, 31, 60);

                  }
                }
              }
              fclose($txt_file);
              $import_status = '?import_status=success';
          }else{
            $import_status = '?import_status=error';
          }
        }else{
          $import_status = '?import_status=invalid_file';
        }
      }
	    //header("Location: ../importacionliquido/?c=importacion&a=personal");
      //require_once 'view/personal.php';
    }



    public function CJMDGPersonalImportar(){
      $cjimp = new Importacion();

      if(isset($_POST['btnbancobersadescimportar1'])){
        // validate to check uploaded file is a valid csv file

        $file_mimes = array('application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
        if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'],$file_mimes)){
          //
          if(is_uploaded_file($_FILES['file']['tmp_name'])){
              $txt_file = fopen($_FILES['file']['tmp_name'], 'r');
              $a=6;$contador=0;$nroleg2=0;
              //Output a line of the file until the end is reached
              while(!feof($txt_file)){

                $linea = fgets($txt_file);

                // Se evalúa a true ya que $var está vacia
                if (!empty($linea)) {
                  //echo '$var es o bien 0, vacía, o no se encuentra definida en absoluto';
                  $cjimp->RegistroCompleto = str_split($linea, 70);

                  //echo "--------------------"."<br/>";
                  $periodo=$this->model->PeriodoObtenerNuevo();

                  foreach ($cjimp->RegistroCompleto as $value) {
                    # code...
                    //echo $value."<br>";

                    $cjimp->CAB = substr($value, 0, 1);
                    if($cjimp->CAB==1){
                        echo "<br>"."<br>";

                        $cjimp->nroleg= substr($value, 2, 3);
                        $cjimp->APNOM = substr($value, 5, 30);
                        $apellidonombres = explode(" ", $cjimp->APNOM);
                        $cjimp->Apellido = $apellidonombres[0]; // porción1
                        $cjimp->Nombres = $apellidonombres[1]." ".$apellidonombres[2]." ".$apellidonombres[3]." ".$apellidonombres[4]; // porción2
                        $cjimp->final = substr($value, 34, 38);

                        if($a>$cjimp->nroleg){$contador=$contador+1;
                            if($contador==0){$nroleg2=$cjimp->nroleg;}else{
                            $nroleg2=$contador.$cjimp->nroleg;}
                            //echo $nroleg2. "---".$cjimp->nroleg." "."<br>";
                        }else{
                            if($contador==0){$nroleg2=$cjimp->nroleg;}else{
                            $nroleg2=$contador.$cjimp->nroleg;}
                            //echo $nroleg2. "---".$cjimp->nroleg." "."<br>";
                        }
                        $cjimp->leg2=$nroleg2;
                        $cjimp->fecha=substr($cjimp->final,1, 8);
                        $cjimp->categoria=substr($cjimp->final,9, 70);

                        //echo $cjimp->Apellido." "."<br>";
                        //echo $cjimp->Nombres." "."<br>";

                        //echo $cjimp->fecha." ";
                        echo $cjimp->categoria."<br>";

                        $resp=$this->model->CJMDGCategoriaImportar($cjimp->categoria);

                        //if($cjimp->categoria=='PENSION'){$categoria_jub_id=10;}else{$categoria_jub_id=6;}
                        //if($cjimp->categoria=='JUB.ORDINARIA'){$categoria_jub_id=1;}


                        $res=$this->model->CJMDGLiquidoCabImportar($cjimp->categoria,$cjimp->leg2,$periodo->periodo_id,$resp->categoria_jub_id);

                    //---numero docto
                    //$cjimp->NumDocto = substr($value, 31, 60);
                  }else{
                    $cjimp->codigo= substr($value, 1, 3);
                    $cjimp->nombrecod = substr($value, 4, 25);
                    $cjimp->importe=substr($value,39, 70);
                    $a=$cjimp->nroleg;
                    //echo $cjimp->codigo."       ";
                    //echo $cjimp->nombrecod."       ";
                    //echo $cjimp->importe."<br>";

                    $res=$this->model->CJMDGLiquidoDetImportar($cjimp,$periodo->periodo_id);
                  }
                  }
                }
              }
      
              if(count($tot1)==0){echo "error";die();}
              fclose($txt_file);
              $import_status = '?import_status=success';

          }else{
            $import_status = '?import_status=error';

          }
        }else{
          $import_status = '?import_status=invalid_file';
        }
      }
	    header("Location: ../importacionliquido/?c=importacion&a=personal");
      //require_once 'view/personal.php';
    }


    public function CJMDGPersonalImportarCuil(){
        $cjimp = new Importacion();

        $coeficiente[0]=5;
        $coeficiente[1]=4;
        $coeficiente[2]=3;
        $coeficiente[3]=2;
        $coeficiente[4]=7;
        $coeficiente[5]=6;
        $coeficiente[6]=5;
        $coeficiente[7]=4;
        $coeficiente[8]=3;
        $coeficiente[9]=2;


        $ini=0;
        $resultado=0;
        $cuit_rearmado=0;
        $doc=$this->model->ObtenerDocumento();

        foreach($doc as $row){
            if($row->sexo_id==1){$ini=20;}
            if($row->sexo_id==2){$ini=27;}
            $sumador = 0;

            if(strlen($row->legajo_nrodocto)==7){echo 'pasa';$cuit=str_pad($row->legajo_nrodocto,8,'0',STR_PAD_LEFT);}else{$cuit=$row->legajo_nrodocto;}
            $cuit1=$ini.$cuit;

            for($i=0;$i<=10;$i=$i+1){
              $sumador = $sumador + (substr($cuit1, $i, 1)) * $coeficiente[$i];//separo cada digito y lo multiplico por el coeficiente }

            }

            $resto=explode('.',($sumador)/11);

              //$resultado1 = explode('.',$sumador / 11);
            $resultado=$sumador-(($resto[0])*11);
              //$resultado = 11 - $resultado1; //saco el digito verificador
            $veri_nro = 11-$resultado;

            //for ($i=0; $i < strlen($cuit); $i= $i +1) { //separo cualquier caracter que no tenga que ver con numeros
            //if ((Ord(substr($cuit, $i, 1)) >= 48) && (Ord(substr($cuit, $i, 1)) <= 57))
            //{
            //$cuit_rearmado = $cuit_rearmado . substr($cuit, $i, 1);
            //}
            //}

            $cjimp->cuit_rearmado=$ini.$row->legajo_nrodocto.$resultado;

            //echo 'cuit1: '.$cuit1.'sumador: '.$sumador . 'resultado1: '.$resultado1 . 'resultado: '. $resultado .'<br>';
            //echo '////'.$ini.'-'.str_pad($row->legajo_nrodocto,1,'0',STR_PAD_LEFT).'-'.$veri_nro.'///'.'<br>';
            //echo $row->legajo_id.'-' .$row->sexo_id;
           // $verificador = substr($cuit_rearmado, 10, 1); //tomo el digito verificador
            $cjimp->lega=$row->legajo_id;
            //For ($i=0; $i <=9; $i=$i+1) {
            //$sumador = $sumador + (substr($cuit_rearmado, $i, 1)) * $coeficiente[$i];//separo cada digito y lo multiplico por el coeficiente }

           // $resultado = $sumador % 11;
           // $resultado = 11 - $resultado; //saco el digito verificador
           // $veri_nro = intval($verificador);

           // If ($veri_nro <> $resultado) {
           // $resultado=0;
           // } else {
           // $cuit_rearmado = substr($cuit_rearmado, 0, 2) . "-" . substr($cuit_rearmado, 2, 8) . "-" . substr($cuit_rearmado, 10, 1);
           // }
           // }

            $res=$this->model->GrabaCuil($cjimp);

      }
      die();

	    //header("Location: ../importacionliquido/?c=importacion&a=personal");
      //require_once 'view/personal.php';

  }


    public function CJMDGPersonalImportar3(){

      $cjimp = new Importacion();

      if(isset($_POST['btnbancobersadescimportar'])){
        // validate to check uploaded file is a valid csv file

        $file_mimes = array('application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
        if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'],$file_mimes)){
          //
          if(is_uploaded_file($_FILES['file']['tmp_name'])){

              $txt_file = fopen($_FILES['file']['tmp_name'], 'r');
              $a=6;$contador=0;$nroleg2=0;
              //Output a line of the file until the end is reached
              while(!feof($txt_file)){

                $linea = fgets($txt_file);

                // Se evalúa a true ya que $var está vacia
                if (!empty($linea)) {
                  //echo '$var es o bien 0, vacía, o no se encuentra definida en absoluto';
                  $cjimp->RegistroCompleto = str_split($linea, 70);

                  //echo "--------------------"."<br/>";
                  //traer periodo de modal
                  //$periodo=$_REQUEST['cboperiodo'];
                  //$periodo=$_REQUEST['hddper'];
                  //$periodo=$this->model->PeriodoObtener();
                  foreach ($cjimp->RegistroCompleto as $value) {
                    # code...
                    //echo $value."<br>";

                    $cjimp->CAB = substr($value, 0, 1);
                    if($cjimp->CAB==1){
                        echo "<br>"."<br>";

                        $cjimp->nroleg= substr($value, 2, 3);
                        $cjimp->APNOM = substr($value, 5, 30);
                        $apellidonombres = explode(" ", $cjimp->APNOM);
                        $cjimp->Apellido = $apellidonombres[0]; // porción1
                        $cjimp->Nombres = $apellidonombres[1]." ".$apellidonombres[2]." ".$apellidonombres[3]." ".$apellidonombres[4]; // porción2
                        $cjimp->final = substr($value, 34, 38);

                        if($a>$cjimp->nroleg){$contador=$contador+1;
                            if($contador==0){$nroleg2=$cjimp->nroleg;}else{
                            $nroleg2=$contador.$cjimp->nroleg;}
                            //echo $nroleg2. "---".$cjimp->nroleg." "."<br>";
                        }else{
                            if($contador==0){$nroleg2=$cjimp->nroleg;}else{
                            $nroleg2=$contador.$cjimp->nroleg;}
                            //echo $nroleg2. "---".$cjimp->nroleg." "."<br>";
                        }
                        $cjimp->leg2=$nroleg2;
                        $cjimp->fecha=substr($cjimp->final,1, 8);
                        $cjimp->categoria=substr($cjimp->final,9, 70);

                        //echo $cjimp->Apellido." "."<br>";
                        //echo $cjimp->Nombres." "."<br>";

                        //echo $cjimp->fecha." ";
                        //echo $cjimp->categoria."<br>";

                      //$res=$this->model->CJMDGLiquidoCabImportar($cjimp->categoria,$cjimp->leg2,$periodo);
                      //$cjimp->NumDocto = substr($value, 31, 60);
                  }else{
                    $cjimp->codigo= substr($value, 1, 3);
                    $cjimp->nombrecod = substr($value, 4, 25);
                    $cjimp->importe=substr($value,39, 70);
                    $a=$cjimp->nroleg;
                    //echo $cjimp->codigo."       ";
                    //echo $cjimp->nombrecod."       ";
                    //echo $cjimp->importe."<br>";
                    //$res=$this->model->CJMDGLiquidoDetImportar($cjimp,$periodo);
                  }

                  }

                }
              }
              fclose($txt_file);
              $import_status = '?import_status=success';
              require_once 'view/personal.php';
          }else{
            $import_status = '?import_status=error';
          }
        }else{
          $import_status = '?import_status=invalid_file';
        }
      }
      require_once 'view/personal.php';
      //header("Location: ../bancos/?c=banco&a=BancoBersaCreditos");
    }

    public function IOSPERDescargar(){
      require_once 'includes/csv/iosper.php';
    }

    public function BERSADescargar(){
      require_once 'includes/txt/bersa.php';
    }

    public function ACTIVOSDescargar(){
      require_once 'includes/txt/activos.php';
    }

    public function PASIVOSDescargar(){
      require_once 'includes/txt/pasivos.php';
    }

    public function LEY3011Descargar(){
      require_once 'includes/csv/ley3011.php';
    }

    public function SEGUDescargar(){
      require_once 'includes/csv/segu.php';
    }

    //////////////////////////////////////////////////////////////////////////////
    public function BancoBersaCreditos(){
      /*$emp = new Empleado();

      if(isset($_REQUEST['id'])){
        $emp = $this->model->Obtener($_REQUEST['id']);
      }*/
      $periododatos = $this->model->PeriodoActualObtener();
      $bersacreditos = $this->model->BersaCreditosListar($periododatos->periodo_id);
      require_once 'view/banco-bersa-creditos.php';
    }

    public function BancoBersaImportar(){
      $bcoimp = new Banco();
      $periododatos = $this->model->PeriodoActualObtener();
      $bcoimp->Bcoperiodo = $periododatos->periodo_id;
      if(isset($_POST['btnbancobersadescimportar'])){
        // validate to check uploaded file is a valid csv file
        //$fictandaimportar->Mtandaid = $_REQUEST['hddmtandaide'];
        $file_mimes = array('application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
        if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'],$file_mimes)){
          //
          if(is_uploaded_file($_FILES['file']['tmp_name'])){
              $txt_file = fopen($_FILES['file']['tmp_name'], 'r');

              //Output a line of the file until the end is reached
              while(!feof($txt_file)){
                //echo fgets($txt_file). "<br />";
                $linea = fgets($txt_file);
                //echo $linea."</br>";
                //echo substr('abcdef', 0, 1);// bcdef

                // Se evalúa a true ya que $var está vacia
                if (!empty($linea)) {
                  //echo '$var es o bien 0, vacía, o no se encuentra definida en absoluto';
                  $bcoimp->Bconrodocto = substr($linea, 5, 8);
                  //echo "DNI: ".$bcoimp->Bconrodocto."<br/>";
                  $empleadodatos = $this->model->ObtenerEmpleado($bcoimp->Bconrodocto);
                  if($empleadodatos->legempleado_numerol > 0){
                    $bcoimp->Bcolegnumerol = $empleadodatos->legempleado_numerol;
                  }else{
                    $bcoimp->Bcolegnumerol = 0;
                  }
                  $bcoimp->Bconrocuil = substr($linea, 3, 11);
                  //echo "CUIL: ".$bcoimp->Bconrocuil."<br/>";
                  $importe_entero = substr($linea, 14, 5);
                  $importe_decimal = substr($linea, 19, 2);
                  $importe = $importe_entero.".".$importe_decimal;
                  $bcoimp->Bcoimporte = number_format($importe, 2, '.', '');
                  //echo "IMPORTE: ".$bcoimp->Bcoimporte."<br/>";
                  $bcoimp->Bcocuotas = substr($linea, 21, 5);
                  //echo "CUOTAS: ".$bcoimp->Bcocuotas."<br/>";
                  $bcoimp->Bcoarchivonom = $_FILES['file']['name'];
                  //echo "ARCHIVO NOMBRE: ".$bcoimp->Bcoarchivonom."</BR>";
                  $bcoimp->Bcolineacompleta = $linea;
                  //echo "LINEA COMPLETA: ".$linea."<BR/>";
                  //echo "--------------------"."<br/>";

                  $this->model->BancoBersaCredImportarExe($bcoimp);
                }
              }
              fclose($txt_file);
              $import_status = '?import_status=success';
          }else{
            $import_status = '?import_status=error';
          }
        }else{
          $import_status = '?import_status=invalid_file';
        }
      }
      header("Location: ../bancos/?c=banco&a=BancoBersaCreditos3");
    }

    public function BancoBersaCredImportar3(){
      $bcoimp = new Banco();
      $periododatos = $this->model->PeriodoActualObtener();
      $bcoimp->Bcoperiodo = $periododatos->periodo_id;
      if(isset($_POST['btnbancobersadescimportar'])){
        // validate to check uploaded file is a valid csv file
        //$fictandaimportar->Mtandaid = $_REQUEST['hddmtandaide'];
        $file_mimes = array('application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
        if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'],$file_mimes)){
          //
          if(is_uploaded_file($_FILES['file']['tmp_name'])){
              $txt_file = fopen($_FILES['file']['tmp_name'], 'r');

              //Output a line of the file until the end is reached
              while(!feof($txt_file)){
                //echo fgets($txt_file). "<br />";
                $linea = fgets($txt_file);
                //echo $linea."</br>";
                //echo substr('abcdef', 0, 1);// bcdef

                // Se evalúa a true ya que $var está vacia
                if (!empty($linea)) {
                  //echo '$var es o bien 0, vacía, o no se encuentra definida en absoluto';
                  $bcoimp->Bconrodocto = substr($linea, 5, 8);
                  //echo "DNI: ".$bcoimp->Bconrodocto."<br/>";
                  $empleadodatos = $this->model->ObtenerEmpleado($bcoimp->Bconrodocto);
                  if($empleadodatos->legempleado_numerol > 0){
                    $bcoimp->Bcolegnumerol = $empleadodatos->legempleado_numerol;
                  }else{
                    $bcoimp->Bcolegnumerol = 0;
                  }
                  $bcoimp->Bconrocuil = substr($linea, 3, 11);
                  //echo "CUIL: ".$bcoimp->Bconrocuil."<br/>";
                  $importe_entero = substr($linea, 14, 5);
                  $importe_decimal = substr($linea, 19, 2);
                  $importe = $importe_entero.".".$importe_decimal;
                  $bcoimp->Bcoimporte = number_format($importe, 2, '.', '');
                  //echo "IMPORTE: ".$bcoimp->Bcoimporte."<br/>";
                  $bcoimp->Bcocuotas = substr($linea, 21, 5);
                  //echo "CUOTAS: ".$bcoimp->Bcocuotas."<br/>";
                  $bcoimp->Bcoarchivonom = $_FILES['file']['name'];
                  //echo "ARCHIVO NOMBRE: ".$bcoimp->Bcoarchivonom."</BR>";
                  $bcoimp->Bcolineacompleta = $linea;
                  //echo "LINIA COMPLETA: ".$linea."<BR/>";
                  //echo "--------------------"."<br/>";

                  $this->model->BancoBersaCredImportarExe($bcoimp);
                }
              }
              fclose($txt_file);
              $import_status = '?import_status=success';
          }else{
            $import_status = '?import_status=error';
          }
        }else{
          $import_status = '?import_status=invalid_file';
        }
      }
      header("Location:?c=importacion&a=personal");
    }

    public function BersaCreditosPaseALiq(){
      $bcoliq = new Banco();
      //------Resetear todos los valores anteriores -----
      $this->model->WaldbottBersaCreditosReset();
      //-----Listar creditos bersa --------------
      $periododatos = $this->model->PeriodoActualObtener();
      $bersacreditos = $this->model->BersaCreditosListar($periododatos->periodo_id);
      foreach($bersacreditos as $row){
        $bcoliq->Bcolegajo = $row->legempleado_numerol;
        $bcocreditoimporte_format = number_format($row->bco_credito_importe, 2, ',', '');
        $bcoliq->BcoImporte = $bcocreditoimporte_format;
        if($bcoliq->Bcolegajo > 0){
          $this->model->BersaCreditosPaseALiqExe($bcoliq);
        }
      }
      //header("Location: index.php");
      header("Location: ../bancos/?c=banco&a=BancoBersaCreditos");
    }
}
