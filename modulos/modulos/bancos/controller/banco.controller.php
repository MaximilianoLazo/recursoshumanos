<?php
require_once 'model/banco.php';
date_default_timezone_set("America/Buenos_Aires");
session_start();
if(!isset($_SESSION["usuario_id"])){
  header("../legajos/login/index.php");
}

class BancoController{

    private $model;

    public function __CONSTRUCT(){
        $this->model = new Banco();
    }
    public function BancoBersaCreditos(){
      /*$emp = new Empleado();

      if(isset($_REQUEST['id'])){
        $emp = $this->model->Obtener($_REQUEST['id']);
      }*/
      $periododatos = $this->model->PeriodoActualObtener();
      $bersacreditos = $this->model->BersaCreditosListar($periododatos->periodo_id);
      require_once 'view/banco-bersa-creditos.php';
    }
    public function BancoBersaCredImportar(){
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
      header("Location: ../bancos/?c=banco&a=BancoBersaCreditos");
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
