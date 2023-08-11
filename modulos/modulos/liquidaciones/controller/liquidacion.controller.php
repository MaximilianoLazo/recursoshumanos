<?php
require_once 'model/liquidacion.php';
error_reporting(0);
date_default_timezone_set("America/Buenos_Aires");
session_start();
if(!isset($_SESSION["usuario_id"])){
  header("../legajos/login/index.php");
}

class LiquidacionController{

    private $model;

    public function __CONSTRUCT(){
        $this->model = new Liquidacion();
    }
    public function Liquidacion(){
      echo "Estoy aqui"."<br>";
      //----obtener tipo de liquidacion
      $liquidaciontipo = 1;//mensual
      //----obtener tipo de liquidacion y tipos de legajos
      $liqtipodatos = $this->model->LiquidacionTipoObtener($liquidaciontipo);
      $legtipos = explode(",", $liqtipodatos->legtipo_ids);
      foreach ($legtipos as $value) {
        //echo $value."<br>";
        //---obtener datos de empleados desde su tabla de origen ---
        $empdatos = $this->model->EmpleadoLegajoTipoObtener($value);
        foreach ($empdatos as $row) {
          echo $row->legtipo_id." - ".$row->legempleado_nrodocto."<br>";
          //---Obtner palabras reservadas ---
          $campo = "liqpr_original";
          $proriginaldatos = $this->model->PalabrasReservadasObtener($campo);
          $campo = "liqpr_alias";
          $praliasdatos = $this->model->PalabrasReservadasObtener($campo);
          echo var_dump($proriginaldatos)."<br>";
          echo "--- Separador ---<br>";
          echo var_dump($praliasdatos)."<br>";
          echo "---------FORMULA----------<br>";
          //--------Obtener codigos remunerativos
          //$hrdatos = $this->model->HaberesRemunerativosObtener();
          //--------Obtener codigos asignaciones familiares
          //--------Obtener codigos no remunerativos
          //--------Obtener codigos Descuentos
          //--------Obtener codigos contribuciones patronales
          //--------Obtener codigos calculos varios (Totales)
          //-----inicio remplazo de variables
          $formula = "sbasico_importe AS importe FROM sueldos_basicos WHERE legempleado_nrodocto = empndoc";
          //$remplazar = $proriginaldatos;
          /*$remplazar = array($praliasdatos);
          //$remplazo = $praliasdatos;
          $remplazo = array($proriginaldatos);*/
          $remplazar = array("empndoc");
          $remplazo = array("36583053");
          $formula_dos = str_replace($remplazar, $remplazo, $formula);
          echo $formula_dos."<br>";
          //----fin remplazo de variables
          //echo $formula_dos."<br>";
          //$formula_tres = $this->model->GetDatos($formula_dos);
          //echo $formula_tres."------<br>";

        }
      }

    }
    public function LiquidacionBusqueda(){
      require_once 'view/liquidacion-busqueda.php';
    }
    public function LiquidacionBusquedaRespuesta(){
      require_once 'view/liquidacion-busqueda-respuesta.php';
    }
    public function LiquidacionImportada(){
      require_once 'view/liquidacion-importar.php';
    }
    public function AyudaEscolarImportada(){
      require_once 'view/ayudaescolar-importar.php';
    }
    public function LiquidacionDescuentos(){
      $liqdesc = new Liquidacion();

      //------Variables hidden -----------
      $liqdesc->Liqdescndoc = $_REQUEST['hddndoce'];
      $liqdesc->Liqdescperiodo = $_REQUEST['hddperiodoe'];
      $liqdesc->Liqdesctitular = $_REQUEST['hddtitulare'];
      $liqdesc->Empnrodocto = $_REQUEST['hddempndoclde'];
      //------Variables del Formulario---------
      $liqdesc->Liqdesccodigo = $_REQUEST['cboliqcoddescuentoe'];
      $datosliqcod = $this->model->ObtenerLiquidacionCodxId($_REQUEST['cboliqcoddescuentoe']);
      $liqdesc->Liqdesccoddescripcion = $datosliqcod->liqcod_descripcion;
      $liqdesc->Liqdesccodtipo = $datosliqcod->liqcodtipo_id;
      $liqdesc->Liqdescimporte = $_REQUEST['txtliqimportee'];
      $liqdesc->Liqdescobs = $_REQUEST['txtliqobse'];

      $this->model->LiquidacionDescuentosExe($liqdesc);

      header("Location: ../liquidaciones/?c=liquidacion&a=LiquidacionBusqueda&id=$liqdesc->Liqdescndoc");
      //header("Location: ../asignaciones/?c=asignacion&a=BusquedaOBReajuste&id=$asig->NDocConsultado");
    }
    public function HaberGuardar(){
      $liqhab = new Liquidacion();

      $liqhab->Liqndoc = $_REQUEST['hddlicndoc'];
      $datosliqul = $this->model->LiquidacionBenUlObtener($liqhab->Liqndoc);

      $liqhab->Empndoccc = $datosliqul->legempleado_nrodocto;
      $liqhab->Empnleg = 0;
      $liqhab->LiqTitular = 2;

      $liqhab->Habercodliq = $_REQUEST['cbohabercodliq'];

      $datosliqcod = $this->model->ObtenerLiquidacionCodxId($liqhab->Habercodliq);
      $liqhab->Liqdesccodtipo = $datosliqcod->liqcodtipo_id;
      $liqhab->Liqdesccoddescripcion = $datosliqcod->liqcod_descripcion;
      $liqhab->Liqcantidad = 0;
      $liqhab->LiqTipo = 6;
      $liqhab->Haberimporte = $_REQUEST['txthaberimporte'];
      $liqhab->Liqccosto = 0;
      $liqhab->Liqperiodoid = $datosliqul->periodo_id;
      $liqhab->Liqobs = "";
      $liqhab->Liqest = 1;

      $this->model->LiquidacionHaberesExe($liqhab);

      $empndoc = $liqhab->Empndoccc;
      $benndoc = $liqhab->Liqndoc;
      $periodoid = 32;

      $haberremun = $this->model->HaberesRemunerativosObtener_AE($empndoc, $benndoc, $periodoid);
      $this->model->HaberesRemunerativos_AE_UPDATE($empndoc, $benndoc, $haberremun->hremimp);
      //////////////////////////////////////////////////////////
      $asigfam = $this->model->AsignacionesFamiliaresObtener_AE($empndoc, $benndoc, $periodoid);
      $this->model->AsignacionesFamiliaresObtener_AE_UPDATE($empndoc, $benndoc, $asigfam->asigfamimp);
      /////////////////////////////////////////////////////////////////
      $habernoremun = $this->model->HaberesNoRemunerativosObtener_AE($empndoc, $benndoc, $periodoid);
      $this->model->HaberesNoRemunerativosObtener_AE_UPDATE($empndoc, $benndoc, $habernoremun->hnoremimp);
      //////////////////////////////////////////////////////////////////
      $descuentos = $this->model->DescuentosObtener_AE($empndoc, $benndoc, $periodoid);
      $this->model->DescuentosObtener_AE_UPDATE($empndoc, $benndoc, $descuentos->descimp);
      ///////////////////////////////////////////////////////////////
      $sneto = $this->model->SueldoNetoObtener_AE($empndoc, $benndoc, $periodoid);
      $this->model->SueldoNetoObtener_AE_UPDATE($empndoc, $benndoc, $sneto);


      header("Location: ../liquidaciones/?c=liquidacion&a=LiquidacionBusqueda&id=$liqhab->Liqndoc");
      //header("Location: ../asignaciones/?c=asignacion&a=BusquedaOBReajuste&id=$asig->NDocConsultado");
    }
    public function LiquidacionesImportar(){
      $liqimp = new Liquidacion();
      $periododatos = $this->model->PeriodoActualObtener();
      $liqimp->PeriodoA = $periododatos->periodo_id;
      if(isset($_POST['btnliquidacionimportar'])){
        // validate to check uploaded file is a valid csv file
        //$fictandaimportar->Mtandaid = $_REQUEST['hddmtandaide'];
        $file_mimes = array('application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
        if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'],$file_mimes)){
          //
          if(is_uploaded_file($_FILES['file']['tmp_name'])){
              $csv_file = fopen($_FILES['file']['tmp_name'], 'r');
              //fgetcsv($csv_file);
              // get data records from csv file
              while(($datos = fgetcsv($csv_file, 1000, ";")) !== FALSE){
                // Check if employee already exists with same email
                $fictandaimportar->Trabajoid = 0;
                $fictandaimportar->Secretariaid = 0;
                //$fictandaimportar->Relojid = 0;

                $legajo_numero = intval(preg_replace('/[^0-9]+/', '', $datos[0]), 10);
                //echo $resultado; // resultado: 102030

                if(is_numeric($legajo_numero) AND strlen($legajo_numero) > 5){
                  //------- Si es numerico --------
                  $empleadodatos = $this->model->EmpleadoXlegajoObtener($legajo_numero);
                  // Se evalúa a true ya que $var está vacia
                  if(!empty($empleadodatos->legempleado_nrodocto)){
                    //---- se encontro empleado------
                    //-----DATOS DE CSV --------
                    $liqimp->LegajoNumero = $datos[0];//Numero de legajo
                    $liqimp->Liqcod = $datos[2];//Codigo de liquidacion
                    $codlicdatos = $this->model->LiquidacionCodigoObtner($liqimp->Liqcod);
                    $liqimp->Liqcodtipo = $codlicdatos->liqcodtipo_id;
                    $liqimp->Liqcoddesc = $datos[3];//Descripcion de codigo
                    $liqimp->Liqcantidad = $datos[4];// Cantidad
                    //$liqimporte_format = number_format($datos[6], 2, '.', '');
                    $liqimporte_format = str_replace(',','.',$datos[6]);
                    $liqimp->Liqimporte = $liqimporte_format;//importes
                    //-----DATOS TABLA legajos_empleado -----
                    $liqimp->Nrodocto = $empleadodatos->legempleado_nrodocto;
                    $liqimp->Benndocto = $empleadodatos->legempleado_nrodocto;
                    $this->model->LiquidacionesImportarExe($liqimp);
                  }else{
                    //echo '$var es o bien 0, vacía, o no se encuentra definida en absoluto';
                    //---- se encontro empleado------
                    //-----DATOS DE CSV --------
                    $liqimp->LegajoNumero = $datos[0];//Numero de legajo
                    $liqimp->Liqcod = $datos[2];
                    $codlicdatos = $this->model->LiquidacionCodigoObtner($liqimp->Liqcod);
                    $liqimp->Liqcodtipo = $codlicdatos->liqcodtipo_id;
                    $liqimp->Liqcoddesc = $datos[3];
                    $liqimp->Liqcantidad = $datos[4];
                    //$liqimp->Liqimporte = $datos[6];
                    //$liqimporte_format = number_format($datos[6], 2, '.', '');
                    $liqimporte_format = str_replace(',','.',$datos[6]);
                    $liqimp->Liqimporte =$liqimporte_format;
                    //-----DATOS TABLA legajos_empleado -----
                    $liqimp->Nrodocto = 0;
                    $liqimp->Benndocto = 0;
                    $this->model->LiquidacionesImportarExe($liqimp);
                  }
                }else{
                  //---pasar siguiente registro, no cumple las condiciones de dni
                }
              }
              ///---segir con los codigos de calculo

              $empdatos = $this->model->LiquidacionEmpleadoDniObtener($liqimp->PeriodoA);
              foreach($empdatos as $row){

                // code...
                $liqimp->Nrodocto = $row->legempleado_nrodocto;
                $liqimp->LegajoNumero = $row->legempleado_numerol;
                $liqimp->Liqcod = 484;
                $liqimp->Liqcoddesc = "SUELDO NETO";
                $liqimp->Liqcantidad = 0;
                $liqimp->Liqcodtipo = 6;
                //----Datos de empleado---
                //$empleadodatos = $this->model->EmpleadoResumenObtener($row->legempleado_nrodocto);
                //---Sueldo Remumunerativo -------
                $sremunerativo = $this->model->SRemunerativoObtener($row->legempleado_nrodocto);
                $liqimp->Sremunerativo = $sremunerativo->remunimp;
                //----Sueldo no Remunerativo ---------
                $snoremunerativo = $this->model->SNoRemunerativoObtener($row->legempleado_nrodocto);
                $liqimp->Snoremunerativo = $snoremunerativo->noremunimp;
                //----Obtener asignaciones
                $asignacionfamiliares = $this->model->AsignacionesFamiliaresObtener($row->legempleado_nrodocto);
                //---Obtener Descuentos ---------
                $descuentos = $this->model->DescuentosObtener($row->legempleado_nrodocto);
                $liqimp->Descuentos = $descuentos->descuentosimp;
                //---Calculo de Sueldo Neto
                $liqimp->Liqimporte = $sremunerativo->remunimp
                                    + $asignacionfamiliares->asigfamimp
                                    + $snoremunerativo->noremunimp
                                    - $descuentos->descuentosimp;
                //----Insertar conceptos de totales
                $this->model->LiquidacionesImportarExe($liqimp);

              }
              fclose($csv_file);
              $import_status = '?import_status=success';
          }else{
            $import_status = '?import_status=error';
          }
        }else{
          $import_status = '?import_status=invalid_file';
        }
      }
      header("Location: ../liquidaciones/?c=liquidacion&a=LiquidacionImportada");
    }
    public function LiquidacionesCodigoImportar(){
      $liqimp = new Liquidacion();
      $periododatos = $this->model->PeriodoActualObtener();
      $liqimp->PeriodoA = $periododatos->periodo_id;
      if(isset($_POST['btnliquidacionimportar'])){
        // validate to check uploaded file is a valid csv file
        //$fictandaimportar->Mtandaid = $_REQUEST['hddmtandaide'];
        $file_mimes = array('application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
        if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'],$file_mimes)){
          //
          if(is_uploaded_file($_FILES['file']['tmp_name'])){
              $csv_file = fopen($_FILES['file']['tmp_name'], 'r');
              //fgetcsv($csv_file);
              // get data records from csv file
              while(($datos = fgetcsv($csv_file, 1000, ";")) !== FALSE){
                // Check if employee already exists with same email
                $fictandaimportar->Trabajoid = 0;
                $fictandaimportar->Secretariaid = 0;
                //$fictandaimportar->Relojid = 0;

                $documento_numero = intval(preg_replace('/[^0-9]+/', '', $datos[0]), 10);
                //echo $resultado; // resultado: 102030

                if(is_numeric($documento_numero) AND strlen($documento_numero) > 5){
                  //------- Si es numerico --------
                  $empleadodatos = $this->model->EmpleadoObtener($documento_numero);
                  // Se evalúa a true ya que $var está vacia
                  if(!empty($empleadodatos->legempleado_nrodocto)){
                    //---- se encontro empleado------
                    //-----DATOS DE CSV --------
                    $liqimp->LegajoNumero = $empleadodatos->legempleado_numerol;//Numero de legajo
                    $liqimp->Liqcod = 221;//Codigo de liquidacion
                    $codlicdatos = $this->model->LiquidacionCodigoObtner($liqimp->Liqcod);
                    $liqimp->Liqcodtipo = $codlicdatos->liqcodtipo_id;
                    $liqimp->Liqcoddesc = $codlicdatos->liqcod_descripcion;//Descripcion de codigo
                    $liqimp->Liqcantidad = 1;// Cantidad
                    //$liqimporte_format = number_format($datos[6], 2, '.', '');
                    $liqimporte_format = str_replace(',','.',$datos[2]);
                    $liqimp->Liqimporte = $liqimporte_format;//importes
                    //-----DATOS TABLA legajos_empleado -----
                    $liqimp->Nrodocto = $empleadodatos->legempleado_nrodocto;
                    $liqimp->Benndocto = $datos[1];
                    $this->model->LiquidacionesCodImportarExe($liqimp);
                  }else{
                    //echo '$var es o bien 0, vacía, o no se encuentra definida en absoluto';
                    //---- se encontro empleado------
                    //-----DATOS DE CSV --------
                    $liqimp->LegajoNumero = 0;//Numero de legajo
                    $liqimp->Liqcod = 221;
                    $codlicdatos = $this->model->LiquidacionCodigoObtner($liqimp->Liqcod);
                    $liqimp->Liqcodtipo = $codlicdatos->liqcodtipo_id;
                    $liqimp->Liqcoddesc = $codlicdatos->liqcod_descripcion;
                    $liqimp->Liqcantidad = 1;
                    //$liqimp->Liqimporte = $datos[6];
                    //$liqimporte_format = number_format($datos[6], 2, '.', '');
                    $liqimporte_format = str_replace(',','.',$datos[2]);
                    $liqimp->Liqimporte =$liqimporte_format;
                    //-----DATOS TABLA legajos_empleado -----
                    $liqimp->Nrodocto = $datos[0];
                    $liqimp->Benndocto = $datos[1];
                    $this->model->LiquidacionesCodImportarExe($liqimp);
                  }
                }else{
                  //---pasar siguiente registro, no cumple las condiciones de dni
                }
              }
              ///---segir con los codigos de calculo

              /*$empdatos = $this->model->LiquidacionEmpleadoDniObtener($liqimp->PeriodoA);
              foreach($empdatos as $row){

                // code...
                $liqimp->Nrodocto = $row->legempleado_nrodocto;
                $liqimp->LegajoNumero = $row->legempleado_numerol;
                $liqimp->Liqcod = 484;
                $liqimp->Liqcoddesc = "SUELDO NETO";
                $liqimp->Liqcantidad = 0;
                $liqimp->Liqcodtipo = 6;
                //----Datos de empleado---
                //$empleadodatos = $this->model->EmpleadoResumenObtener($row->legempleado_nrodocto);
                //---Sueldo Remumunerativo -------
                $sremunerativo = $this->model->SRemunerativoObtener($row->legempleado_nrodocto);
                $liqimp->Sremunerativo = $sremunerativo->remunimp;
                //----Sueldo no Remunerativo ---------
                $snoremunerativo = $this->model->SNoRemunerativoObtener($row->legempleado_nrodocto);
                $liqimp->Snoremunerativo = $snoremunerativo->noremunimp;
                //----Obtener asignaciones
                $asignacionfamiliares = $this->model->AsignacionesFamiliaresObtener($row->legempleado_nrodocto);
                //---Obtener Descuentos ---------
                $descuentos = $this->model->DescuentosObtener($row->legempleado_nrodocto);
                $liqimp->Descuentos = $descuentos->descuentosimp;
                //---Calculo de Sueldo Neto
                $liqimp->Liqimporte = $sremunerativo->remunimp
                                    + $asignacionfamiliares->asigfamimp
                                    + $snoremunerativo->noremunimp
                                    - $descuentos->descuentosimp;
                //----Insertar conceptos de totales
                $this->model->LiquidacionesImportarExe($liqimp);

              }*/
              fclose($csv_file);
              $import_status = '?import_status=success';
          }else{
            $import_status = '?import_status=error';
          }
        }else{
          $import_status = '?import_status=invalid_file';
        }
      }
      header("Location: ../liquidaciones/?c=liquidacion&a=LiquidacionImportada");
    }
    public function AyudaEscolarImportar(){
      $liqimp = new Liquidacion();
      //$periododatos = $this->model->PeriodoActualObtener();
      //$liqimp->PeriodoA = $periododatos->periodo_id;
      $liqimp->PeriodoA = 32;
      if(isset($_POST['btnayudaescolarimportar'])){
        // validate to check uploaded file is a valid csv file
        //$fictandaimportar->Mtandaid = $_REQUEST['hddmtandaide'];
        $file_mimes = array('application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
        if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'],$file_mimes)){
          //
          if(is_uploaded_file($_FILES['file']['tmp_name'])){
              $csv_file = fopen($_FILES['file']['tmp_name'], 'r');
              //fgetcsv($csv_file);
              // get data records from csv file
              while(($datos = fgetcsv($csv_file, 1000, ";")) !== FALSE){
                // Check if employee already exists with same email
                $fictandaimportar->Trabajoid = 0;
                $fictandaimportar->Secretariaid = 0;
                //$fictandaimportar->Relojid = 0;

                $legajo_numero = intval(preg_replace('/[^0-9]+/', '', $datos[0]), 10);
                //echo $resultado; // resultado: 102030

                if(is_numeric($legajo_numero) AND strlen($legajo_numero) > 5){
                  //------- Si es numerico --------
                  $empleadodatos = $this->model->EmpleadoXlegajoObtener($legajo_numero);
                  // Se evalúa a true ya que $var está vacia
                  if(!empty($empleadodatos->legempleado_nrodocto)){
                    //---- se encontro empleado------
                    //-----DATOS DE CSV --------
                    $liqimp->LegajoNumero = $datos[0];//Numero de legajo
                    $liqimp->Liqcod = $datos[2];//Codigo de liquidacion
                    if($liqimp->Liqcod == 221){
                      $liqimp->Liqtipoid = 3;
                    }else{
                      $liqimp->Liqtipoid = 2;
                    }
                    $codlicdatos = $this->model->LiquidacionCodigoObtner($liqimp->Liqcod);
                    $liqimp->Liqcodtipo = $codlicdatos->liqcodtipo_id;
                    $liqimp->Liqcoddesc = $datos[3];//Descripcion de codigo
                    $liqimp->Liqcantidad = $datos[4];// Cantidad
                    //$liqimporte_format = number_format($datos[6], 2, '.', '');
                    $liqimporte_format = str_replace(',','.',$datos[6]);
                    $liqimp->Liqimporte = $liqimporte_format;//importes
                    //-----DATOS TABLA legajos_empleado -----
                    $liqimp->Nrodocto = $empleadodatos->legempleado_nrodocto;
                    $this->model->AyudaEscolarImportarExe($liqimp);
                  }else{
                    //echo '$var es o bien 0, vacía, o no se encuentra definida en absoluto';
                    //---- se encontro empleado------
                    //-----DATOS DE CSV --------
                    $liqimp->LegajoNumero = $datos[0];//Numero de legajo
                    $liqimp->Liqcod = $datos[2];
                    $codlicdatos = $this->model->LiquidacionCodigoObtner($liqimp->Liqcod);
                    $liqimp->Liqcodtipo = $codlicdatos->liqcodtipo_id;
                    $liqimp->Liqcoddesc = $datos[3];
                    $liqimp->Liqcantidad = $datos[4];
                    //$liqimp->Liqimporte = $datos[6];
                    //$liqimporte_format = number_format($datos[6], 2, '.', '');
                    $liqimporte_format = str_replace(',','.',$datos[6]);
                    $liqimp->Liqimporte =$liqimporte_format;
                    //-----DATOS TABLA legajos_empleado -----
                    $liqimp->Nrodocto = 0;
                    $this->model->AyudaEscolarImportarExe($liqimp);
                  }
                }else{
                  //---pasar siguiente registro, no cumple las condiciones de dni
                }
              }
              ///---segir con los codigos de calculo

              $empdatos = $this->model->LiquidacionEmpleadoDniObtener($liqimp->PeriodoA);
              foreach($empdatos as $row){

                // code...
                $liqimp->Nrodocto = $row->legempleado_nrodocto;
                $liqimp->LegajoNumero = $row->legempleado_numerol;
                $liqimp->Liqcod = 484;
                $liqimp->Liqcoddesc = "SUELDO NETO";
                $liqimp->Liqcantidad = 0;
                $liqimp->Liqcodtipo = 6;
                //----Datos de empleado---
                //$empleadodatos = $this->model->EmpleadoResumenObtener($row->legempleado_nrodocto);
                //---Sueldo Remumunerativo -------
                $sremunerativo = $this->model->SRemunerativoObtener_AY($row->legempleado_nrodocto);
                $liqimp->Sremunerativo = $sremunerativo->remunimp;
                //----Sueldo no Remunerativo ---------
                $snoremunerativo = $this->model->SNoRemunerativoObtener($row->legempleado_nrodocto);
                $liqimp->Snoremunerativo = $snoremunerativo->noremunimp;
                //----Obtener asignaciones
                $asignacionfamiliares = $this->model->AsignacionesFamiliaresObtener($row->legempleado_nrodocto);
                //---Obtener Descuentos ---------
                $descuentos = $this->model->DescuentosObtener($row->legempleado_nrodocto);
                $liqimp->Descuentos = $descuentos->descuentosimp;
                //---Calculo de Sueldo Neto
                $liqimp->Liqimporte = $sremunerativo->remunimp
                                    + $asignacionfamiliares->asigfamimp
                                    + $snoremunerativo->noremunimp
                                    - $descuentos->descuentosimp;
                //----Insertar conceptos de totales
                $this->model->AyudaEscolarImportarExe($liqimp);

              }
              fclose($csv_file);
              $import_status = '?import_status=success';
          }else{
            $import_status = '?import_status=error';
          }
        }else{
          $import_status = '?import_status=invalid_file';
        }
      }
      header("Location: ../liquidaciones/?c=liquidacion&a=LiquidacionImportada");
    }
    public function SeguroAutarquicoDescargar(){
      require_once 'includes/csv/seguro-autarquico.php';
    }
    public function IOSPERDescargar(){
      require_once 'includes/csv/iosper.php';
    }
    public function SeguroDeVidaDescargar(){
      require_once 'includes/txt/seguro-vida.php';
    }
    public function LiquidarAsignacionesFamiliares(){
      //
      $liqcodasigfam = $this->model->LiquidacionCodObtener(2);
      echo var_dump($liqcodasigfam);
    }
}
