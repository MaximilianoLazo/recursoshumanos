<?php
require_once 'model/empleado.php';
error_reporting(0);
session_start();
if(!isset($_SESSION["usuario_id"])){
  header("../legajos/login/index.php");
}
//----sona horario y formato de fechas--------
date_default_timezone_set("America/Buenos_Aires");
//setlocale(LC_ALL,"es_ES");
setlocale(LC_ALL, 'es_RA.UTF8');
//setlocale(LC_TIME, "es_RA.UTF-8");
setlocale(LC_TIME, 'es_RA.utf-8','spanish');
//setlocale('es_ES.UTF-8'); // I'm french !

class EmpleadoController{

    private $model;
    public function __CONSTRUCT(){
      $this->model = new Empleado();
    }
    public function Index(){
      require_once 'view/empleado.php';
    }

    public function Crud(){
      $emp = new Empleado();

      if(isset($_REQUEST['id'])){
        $emp = $this->model->Obtener($_REQUEST['id']);
      }

      require_once 'view/empleado-editar.php';
    }
    public function EmpleadoPadron(){
      require_once 'view/empleado.php';
    }
    public function EmpleadoInactivo(){
      require_once 'view/empleado-inactivo.php';
    }
    public function EmpleadoGeneral(){
      require_once 'view/empleado-general.php';
    }
    public function GuardarR(){

      date_default_timezone_set("America/Buenos_Aires");
      $fecha_actual = date("Y-m-d");
      $hora_actual = date("H:i:s");
      $rel = new Empleado();

      $rel->Id = $_REQUEST['id'];
      $rel->EmpId = $_REQUEST['empid'];
      $rel->Empnrodocto = $_REQUEST['empnrodocto'];
      $rel->Relojid = $_REQUEST['relojid'];
      $rel->Accessid = $_REQUEST['accessidup'];
      $accessid = $_REQUEST['accessidup'];
      $rel->Semanal = $_REQUEST['semanal'];
      $rel->Lunes = $_REQUEST['lunes'];
      if($rel->Lunes == 1){

      }else{
        $rel->Lunes = 0;
      }
      $rel->Luneshe = $_REQUEST['luneshe'];
      $rel->Luneshs = $_REQUEST['luneshs'];
      $rel->Martes = $_REQUEST['martes'];
      if($rel->Martes == 1){

      }else{
        $rel->Martes = 0;
      }
      $rel->Marteshe = $_REQUEST['marteshe'];
      $rel->Marteshs = $_REQUEST['marteshs'];
      $rel->Miercoles = $_REQUEST['miercoles'];
      if($rel->Miercoles == 1){

      }else{
        $rel->Miercoles = 0;
      }
      $rel->Miercoleshe = $_REQUEST['miercoleshe'];
      $rel->Miercoleshs = $_REQUEST['miercoleshs'];
      $rel->Jueves = $_REQUEST['jueves'];
      if($rel->Jueves == 1){

      }else{
        $rel->Jueves = 0;
      }
      $rel->Jueveshe = $_REQUEST['jueveshe'];
      $rel->Jueveshs = $_REQUEST['jueveshs'];
      $rel->Viernes = $_REQUEST['viernes'];
      if($rel->Viernes == 1){

      }else{
        $rel->Viernes = 0;
      }
      $rel->Vierneshe = $_REQUEST['vierneshe'];
      $rel->Vierneshs = $_REQUEST['vierneshs'];
      $rel->Sabado = $_REQUEST['sabado'];
      if($rel->Sabado == 1){

      }else{
        $rel->Sabado = 0;
      }
      $rel->Sabadohe = $_REQUEST['sabadohe'];
      $rel->Sabadohs = $_REQUEST['sabadohs'];
      $rel->Domingo = $_REQUEST['domingo'];
      if($rel->Domingo == 1){

      }else{
        $rel->Domingo = 0;
      }
      $rel->Domingohe = $_REQUEST['domingohe'];
      $rel->Domingohs = $_REQUEST['domingohs'];
      $rel->Activo = 1;

      $rel->Id > 0
          ? $this->model->ActualizarR($rel)
          : $this->model->RegistrarR($rel);

      /*$fecha_inicio = $this->model->ObtenerFecIni();
      $fecha_final = $fecha_actual;
      foreach($this->model->ObtenerMarcacionesRe($fecha_inicio,$fecha_final,$accessid) as $row){
        $marcacionid = $row->marcacion_id;
        $marcacionaccessid = $row->marcacion_accessid;
        $marcaciondatetime = $row->marcacion_datetime;
        $marcacionfecha = date("Y-m-d", strtotime($marcaciondatetime));
        $fecha_i = date("Y-m-d",strtotime($marcacionfecha."- 1 days"));
        $fecha_f = date("Y-m-d",strtotime($marcacionfecha."+ 1 days"));
        $relojid = $row->reloj_id;
        $relojsegid = $row->relojseg_id;
        //$periodoinicio = $fecha_i;
        //$periodofin = $fecha_f;
        //$periodoid = 10;
        $this->model->ProcesarMarcacionesRe($marcacionid, $marcacionaccessid, $marcaciondatetime, $relojid, $relojsegid, $fecha_i, $fecha_f);
      }*/

      header("Location: index.php?c=empleado&a=Crud&id=$rel->EmpId&startIndex=3");

    }
    public function GuardarRe(){
        date_default_timezone_set("America/Buenos_Aires");
        $fecha_actual = date("Y-m-d");
        $hora_actual = date("H:i:s");
        $rel = new Empleado();

        $rel->Id = $_REQUEST['id'];
        $rel->EmpId = $_REQUEST['empid'];
        $rel->Empnrodocto = $_REQUEST['empnrodocto'];
        $rel->Relojid = $_REQUEST['relojid'];
        $rel->Accessid = $_REQUEST['accessid'];
        $accessid = $_REQUEST['accessid'];
        $rel->Semanal = $_REQUEST['semanal'];
        $rel->Lunes = $_REQUEST['lunesadd'];
        if($rel->Lunes == 1){

        }else{
          $rel->Lunes = 0;
        }
        $rel->Luneshe = $_REQUEST['lunesheadd'];
        $rel->Luneshs = $_REQUEST['luneshsadd'];
        $rel->Martes = $_REQUEST['martesadd'];
        if($rel->Martes == 1){

        }else{
          $rel->Martes = 0;
        }
        $rel->Marteshe = $_REQUEST['martesheadd'];
        $rel->Marteshs = $_REQUEST['marteshsadd'];
        $rel->Miercoles = $_REQUEST['miercolesadd'];
        if($rel->Miercoles == 1){

        }else{
          $rel->Miercoles = 0;
        }
        $rel->Miercoleshe = $_REQUEST['miercolesheadd'];
        $rel->Miercoleshs = $_REQUEST['miercoleshsadd'];
        $rel->Jueves = $_REQUEST['juevesadd'];
        if($rel->Jueves == 1){

        }else{
          $rel->Jueves = 0;
        }
        $rel->Jueveshe = $_REQUEST['juevesheadd'];
        $rel->Jueveshs = $_REQUEST['jueveshsadd'];
        $rel->Viernes = $_REQUEST['viernesadd'];
        if($rel->Viernes == 1){

        }else{
          $rel->Viernes = 0;
        }
        $rel->Vierneshe = $_REQUEST['viernesheadd'];
        $rel->Vierneshs = $_REQUEST['vierneshsadd'];
        $rel->Sabado = $_REQUEST['sabadoadd'];
        if($rel->Sabado == 1){

        }else{
          $rel->Sabado = 0;
        }
        $rel->Sabadohe = $_REQUEST['sabadoheadd'];
        $rel->Sabadohs = $_REQUEST['sabadohsadd'];
        $rel->Domingo = $_REQUEST['domingoadd'];
        if($rel->Domingo == 1){

        }else{
          $rel->Domingo = 0;
        }
        $rel->Domingohe = $_REQUEST['domingoheadd'];
        $rel->Domingohs = $_REQUEST['domingohsadd'];
        $rel->Activo = 1;

        $this->model->RegistrarR($rel);

        $fecha_inicio = $this->model->ObtenerFecIni();
        $fecha_final = $fecha_actual;
        /*foreach($this->model->ObtenerMarcacionesRe($fecha_inicio,$fecha_final,$accessid) as $row){
          $marcacionid = $row->marcacion_id;
          $marcacionaccessid = $row->marcacion_accessid;
          $marcaciondatetime = $row->marcacion_datetime;
          $marcacionfecha = date("Y-m-d", strtotime($marcaciondatetime));
          $fecha_i = date("Y-m-d",strtotime($marcacionfecha."- 1 days"));
          $fecha_f = date("Y-m-d",strtotime($marcacionfecha."+ 1 days"));
          $relojid = $row->reloj_id;
          $relojsegid = $row->relojseg_id;
          //$periodoinicio = $fecha_i;
          //$periodofin = $fecha_f;
          //$periodoid = 10;
          $this->model->ProcesarMarcacionesRe($marcacionid, $marcacionaccessid, $marcaciondatetime, $relojid, $relojsegid, $fecha_i, $fecha_f);
        }*/

        header("Location: index.php?c=empleado&a=Crud&id=$rel->EmpId&startIndex=3");

    }
    public function GuardarReE(){
      date_default_timezone_set("America/Buenos_Aires");
      $fecha_actual = date("Y-m-d");
      $hora_actual = date("H:i:s");
      $rel = new Empleado();

      $rel->Id = $_REQUEST['id'];
      $rel->EmpId = $_REQUEST['empid'];
      $rel->Empnrodocto = $_REQUEST['empnrodocto'];
      $rel->Relojid = $_REQUEST['relojid'];
      $rel->Accessid = $_REQUEST['accessid'];
      $accessid = $_REQUEST['accessid'];
      $rel->Semanal = $_REQUEST['semanalup'];
      if($rel->Semanal == 1){
        //--- semanal ya es 1 ---
      }else{
        $rel->Semanal= 0;
      }

      $this->model->ActualizarRee($rel);

      /*$fecha_inicio = $this->model->ObtenerFecIni();
      $fecha_final = $fecha_actual;
      foreach($this->model->ObtenerMarcacionesRe($fecha_inicio,$fecha_final,$accessid) as $row){
        $marcacionid = $row->marcacion_id;
        $marcacionaccessid = $row->marcacion_accessid;
        $marcaciondatetime = $row->marcacion_datetime;
        $marcacionfecha = date("Y-m-d", strtotime($marcaciondatetime));
        $fecha_i = date("Y-m-d",strtotime($marcacionfecha."- 1 days"));
        $fecha_f = date("Y-m-d",strtotime($marcacionfecha."+ 1 days"));
        $relojid = $row->reloj_id;
        $relojsegid = $row->relojseg_id;
        $this->model->ProcesarMarcacionesRe($marcacionid, $marcacionaccessid, $marcaciondatetime, $relojid, $relojsegid, $fecha_i, $fecha_f);
      }*/

      header("Location: index.php?c=empleado&a=Crud&id=$rel->EmpId&startIndex=3");

    }
    public function DeshabilitarR(){
      $des = new Empleado();

      $des->Activo = 0;
      $des->RelId = $_REQUEST['relojid'];
      $des->EmpId = $_REQUEST['empid'];

        $this->model->DeshabilitarRel($des);

      header("Location: index.php?c=empleado&a=Crud&id=$des->EmpId&startIndex=3");
    }
    public function HijoGuardar(){

      $hjo = new Empleado();

      $datetime = new DateTime();
			$fecha_actual = $datetime->format('Y-m-d');

      $hjo->Id = $_REQUEST['id'];
      $hjo->Empid = $_REQUEST['empid'];
      $hjo->Empnrodocto = $_REQUEST['empnrodocto'];
      $hjo->Bennrodocto = $_REQUEST['bennrodocto'];

      $hjo->Hjondoc = $_REQUEST['hijondoc'];
      $hjo->Hjonrocuil = $_REQUEST['hijonrocuil'];
      $hjo->Hjoapellido = $_REQUEST['hijoapellido'];
      $hjo->Hjonombres = $_REQUEST['hijonombres'];
      $hjo->Hjosexo = $_REQUEST['hijosexo'];
      $hjo->Hjofecnacto = $_REQUEST['hijofecnacto'];
      $hjo->Hjodireccion = $_REQUEST['hijodireccion'];
      $hjo->Hjodirecnro = $_REQUEST['hijodirecnro'];
      $hjo->Hjodirecpiso = $_REQUEST['hijodirecpiso'];
      $hjo->Hjopais = $_REQUEST['hijopais'];
      $hjo->Hjoprovincia = $_REQUEST['hijoprovincia'];
      $hjo->Hjodepartamento = $_REQUEST['hijodepartamento'];
      $hjo->Hjolocalidad = $_REQUEST['hijolocalidad'];
      $hjo->Hjocodpostal = $_REQUEST['hijocodpostal'];
      $hjo->Hjodisc = $_REQUEST['hijodisc'];
      //--- Tiene discapacidad ? ---
      if($hjo->Hjodisc == 1){
        //---Tiene discapaciadad
      }else{
        //---No tiene discapacidad
        $hjo->Hjodisc = 0;
      }

      $empleadodatos = $this->model->EmpleadoObtener($hjo->Empid);
      $hjo->Hjobenapellido = $empleadodatos->legempleado_apellido;
      $hjo->Hjobennombres = $empleadodatos->legempleado_nombres;

      if($hjo->Id > 0){
        //-----El hijo ya esta cargado
        $this->model->HijoActualizarExe($hjo);
      }else{
        //----El hijo no esta cargado
        $hjo->Id = $this->model->HijoGuardarExe($hjo);
      }

      $this->model->AsignacionInfo($hjo);
      $this->model->FamiliaNumerosaInfo($hjo);

      header("Location: index.php?c=empleado&a=Crud&id=$hjo->Empid&startIndex=5");

    }
    public function HijoEscGuardar(){
        $hesc = new Empleado();
        //------- Variables hidden ----
        $hesc->Id = $_REQUEST['eschijoid'];
        $hesc->HijoId = $_REQUEST['eschijoid'];
        $hesc->Empid = $_REQUEST['escempid'];
        $hesc->Empnrodocto = $_REQUEST['escempndoc'];
        $hesc->Bennrodocto = $_REQUEST['escbenndoc'];
        //------ datos de escuela -----
        $hesc->Hjoescnom = $_REQUEST['hijoescnom'];
        $hesc->Hjoescnvl = $_REQUEST['hijoescnvl'];

        $this->model->HijoEscGuardarExe($hesc);

        $this->model->AsignacionInfo($hesc);

        $this->model->FamiliaNumerosaInfo($hesc);

        //header("Location: index.php?c=empleado&a=Crud&id=$hesc->Empid&startIndex=5");

    }
    public function HijoBenGuardar(){
        $hben = new Empleado();
        //------- Variables hidden ----
        $hben->Empid = $_REQUEST['empbenid'];
        $hben->Empnrodocto = $_REQUEST['hddempnrodocto'];
        $hben->Id = $_REQUEST['hijobenid'];
        $hben->HijoId = $_REQUEST['hijobenid'];
        $hben->Benid = $_REQUEST['hddbeneficiarioid'];
        //------ datos de beneficiario -----
        $hben->Hjobenndoc = $_REQUEST['hijobenndoc'];
        $hben->Hjobennoficio = $_REQUEST['hijonbennoficio'];
        $hben->Hjobenapellido = $_REQUEST['hijobenapellido'];
        $hben->Hjobennombres = $_REQUEST['hijobennombres'];
        $hben->PHCid = $hben->HijoId;
        //////////////////////
        $hben->Bennrodoctoan = $_REQUEST['hddbennrodocto'];
        $hben->Bennrodoctoac = $_REQUEST['hijobenndoc'];
        /////////////////////

        if($hben->Benid > 0){
          //---Beneficiario existe
        }else{
          //---Beneficiario no existe
          $hben->Empnrolegajo = 0;
    			$hben->Emptdoc = 0;
    			$hben->Empnrodocumento = $hben->Hjobenndoc;
    			$hben->Empcuil = "";
    			$hben->Empapellido = $hben->Hjobenapellido;
    			$hben->Empnombres = $hben->Hjobennombres;
    			$hben->Empsexotres = 0;
    			$hben->Empfecnacto = '0000-00-00';
    			$hben->Empestcivil = 0;
    			$hben->Empdireccion = "";
    			$hben->Empdirecnro = "";
    			$hben->Empdirecpiso = "";
    			$hben->Empcelular = "";
    			$hben->Emptelefono = "";
    			$hben->Empemail = "";
    			$hben->Emppais = 0;
    			$hben->Empprovincia = 0;
    			$hben->Empdepartamento = 0;
    			$hben->Emplocalidad = 0;
    			$hben->Empcpostal = 0;
    			$hben->Empfecing = '0000-000-00';
          $hben->Emptleg = 9;

          $ultimoid = $this->model->GuardarEmpleadoExe($hben);
          $hben->Benid = $ultimoid;
        }


        $this->model->HijoBenGuardarExe($hben);


        if($_REQUEST['hijobenndoc'] != $_REQUEST['hddbennrodocto']){
          //-----el beneficiario cambio
          $hben->Bennrodocto = $_REQUEST['hddbennrodocto'];
          $this->model->AsignacionInfo($hben);
          $this->model->FamiliaNumerosaInfo($hben);
          //---------
          $hben->Bennrodocto = $_REQUEST['hijobenndoc'];
          $this->model->AsignacionInfo($hben);
          $this->model->FamiliaNumerosaInfo($hben);
        }


        header("Location: index.php?c=empleado&a=Crud&id=$hben->Empid&startIndex=5");

    }
    public function BeneficiarioAutocompletar(){
      require_once 'includes/php/beneficiario_autocompletar.php';
    }
    public function HijoMoPGuardar(){
        $hmop = new Empleado();
        //------- Variables hidden ----
        $hmop->HijoId = $_REQUEST['hijomopid'];
        $hmop->Empid = $_REQUEST['empmopid'];
        //------ datos de madre o padre -----
        $hmop->Hjomopndoc = $_REQUEST['hijomopndoc'];
        $hmop->Hjomopapellido = $_REQUEST['hijomopapellido'];
        $hmop->Hjomopnombres = $_REQUEST['hijomopnombres'];

        $this->model->HijoMoPGuardarExe($hmop);

        header("Location: index.php?c=empleado&a=Crud&id=$hmop->Empid&startIndex=5");

    }
    public function HijoEliminar(){
      $hjo = new Empleado();

      $hjo->Id = $_REQUEST['hijoid'];
      $hjo->Hijoid = $_REQUEST['hijoid'];
      $hjo->Empid = $_REQUEST['empid'];
      $hjo->Empnrodocto = $_REQUEST['hddempndoc'];
      $hjo->Bennrodocto = $_REQUEST['hddbenndoc'];
      $hjo->Activo = 0;

      $this->model->HijoEliminarExe($hjo);

      $this->model->AsignacionInfo($hjo);

      $this->model->FamiliaNumerosaInfo($hjo);
      //header("Location: index.php?c=empleado&a=Crud&id=$hjo->Empid&startIndex=5");
    }
    public function HijoDeshabilitar(){
      $asigdes = new Empleado();

      $asigdes->Id = $_REQUEST['hijoid'];
      $asigdes->Hijoid = $_REQUEST['hijoid'];
      $asigdes->Empid = $_REQUEST['empid'];
      $asigdes->Empnrodocto = $_REQUEST['hddempndoce'];
      $asigdes->Bennrodocto = $_REQUEST['hddbenndoce'];
      $asigdes->Observacion = $_REQUEST['txtasignaciondes'];

      $this->model->HijoDeshabilitarExe($asigdes);

      $this->model->AsignacionInfo($asigdes);
      $this->model->FamiliaNumerosaInfo($asigdes);
      header("Location: index.php?c=empleado&a=Crud&id=$asigdes->Empid&startIndex=5");
    }
    public function HijoHabilitar(){
      $asighab = new Empleado();

      $asighab->Id = $_REQUEST['hijoid'];
      $asighab->Hijoid = $_REQUEST['hijoid'];
      $asighab->Empid = $_REQUEST['empid'];
      $asighab->Empnrodocto = $_REQUEST['hddempndoce'];
      $asighab->Bennrodocto = $_REQUEST['hddbenndoce'];

      $this->model->HijoHabilitarExe($asighab);

      $this->model->AsignacionInfo($asighab);
      $this->model->FamiliaNumerosaInfo($asighab);
      //header("Location: index.php?c=empleado&a=Crud&id=$asighab->Empid&startIndex=5");
    }
    public function PreNatalGuardar(){
        $pnat = new Empleado();
        //--- Variables Hidden ---
        $pnat->Empid = $_REQUEST['empid'];
        $pnat->Empnrodocto = $_REQUEST['empnrodocto'];
        $pnat->Bennrodocto = $_REQUEST['bennrodocto'];
        //-- Datos de prenatal -----
        $pnat->Id = $_REQUEST['hddprenatalid'];
        $pnat->Prenatalfecum = $_REQUEST['txtprenatalfecum'];
        $pnat->Prenatalfecpp = $_REQUEST['txtprenatalfecpp'];

        $empleadodatos = $this->model->EmpleadoObtener($pnat->Empid);
        $pnat->Prenatalbenapp = $empleadodatos->legempleado_apellido;
        $pnat->Prenatalbennom = $empleadodatos->legempleado_nombres;

        $pnat->Id > 0
            ? $this->model->PreNatalActualizar($pnat)
            : $pnat->Id = $this->model->PreNatalGuardarExe($pnat);

        $this->model->PrenatalInfo($pnat);

        header("Location: index.php?c=empleado&a=Crud&id=$pnat->Empid&startIndex=5");

    }

    public function PreNatalEliminar(){

      $prendel = new Empleado();
      $prendel->Id = $_REQUEST['prenatalid'];
      $prendel->Empnrodocto = $_REQUEST['hddempndoc'];
      $prendel->Bennrodocto = $_REQUEST['hddbenndoc'];
      $prendel->PreNatalId = $_REQUEST['prenatalid'];
      $prendel->Empid = $_REQUEST['empid'];
      $this->model->PreNatalEliminarExe($prendel);
      $this->model->PrenatalInfo($prendel);
      header("Location: index.php?c=empleado&a=Crud&id=$prendel->Empid&startIndex=5");

    }
    public function PreNatalBenGuardar(){
        $prenben = new Empleado();
        //------- Variables hidden ----
        $prenben->Id = $_REQUEST['prenatalbenid'];
        $prenben->PrenId = $_REQUEST['prenatalbenid'];
        $prenben->Empid = $_REQUEST['empbenid'];
        $prenben->Empnrodocto = $_REQUEST['hddpernempnrodocto'];
        $prenben->Benid = $_REQUEST['hddprenatalbenid'];
        //------ datos de beneficiario -----
        $prenben->Prenbenndoc = $_REQUEST['prenatalbenndoc'];
        $prenben->Prenbennoficio = $_REQUEST['prenatalnbennoficio'];
        $prenben->Prenbenapellido = $_REQUEST['prenatalbenapellido'];
        $prenben->Prenbennombres = $_REQUEST['prenatalbennombres'];

        if($prenben->Benid > 0){
          //---Beneficiario existe
        }else{
          //---Beneficiario no existe
          $prenben->Empnrolegajo = 0;
    			$prenben->Emptdoc = 0;
    			$prenben->Empnrodocumento = $prenben->Prenbenndoc;
    			$prenben->Empcuil = "";
    			$prenben->Empapellido = $prenben->Prenbenapellido;
    			$prenben->Empnombres = $prenben->Prenbennombres;
    			$prenben->Empsexotres = 0;
    			$prenben->Empfecnacto = '0000-00-00';
    			$prenben->Empestcivil = 0;
    			$prenben->Empdireccion = "";
    			$prenben->Empdirecnro = "";
    			$prenben->Empdirecpiso = "";
    			$prenben->Empcelular = "";
    			$prenben->Emptelefono = "";
    			$prenben->Empemail = "";
    			$prenben->Emppais = 0;
    			$prenben->Empprovincia = 0;
    			$prenben->Empdepartamento = 0;
    			$prenben->Emplocalidad = 0;
    			$prenben->Empcpostal = 0;
    			$prenben->Empfecing = '0000-000-00';
          $prenben->Emptleg = 9;

          $ultimoid = $this->model->GuardarEmpleadoExe($prenben);
          $prenben->Benid = $ultimoid;
        }

        $this->model->PreNatalBenGuardarExe($prenben);

        if($_REQUEST['prenatalbenndoc'] != $_REQUEST['hddpernbennrodocto']){
          //-----el beneficiario cambio
          $prenben->Bennrodocto = $_REQUEST['hddpernbennrodocto'];
          $this->model->PrenatalInfo($prenben);
          //---------
          $prenben->Bennrodocto = $_REQUEST['prenatalbenndoc'];
          $this->model->PrenatalInfo($prenben);
        }

        header("Location: index.php?c=empleado&a=Crud&id=$prenben->Empid&startIndex=5");

    }
    public function PreNatalMoPGuardar(){
        $prenmop = new Empleado();
        //------- Variables hidden ----
        $prenmop->PrenId = $_REQUEST['prenatalmopid'];
        $prenmop->Empid = $_REQUEST['empmopid'];
        //------ datos de madre o padre -----
        $prenmop->Prenmopndoc = $_REQUEST['prenatalmopndoc'];
        $prenmop->Prenmopapellido = $_REQUEST['prenatalmopapellido'];
        $prenmop->Prenmopnombres = $_REQUEST['prenatalmopnombres'];

        $this->model->PreNatalMoPGuardarExe($prenmop);

        header("Location: index.php?c=empleado&a=Crud&id=$prenmop->Empid&startIndex=5");

    }
    public function PreNatalDeshabilitar(){
      $prendes = new Empleado();

      $prendes->Id = $_REQUEST['prenataldesid'];
      $prendes->Prenid = $_REQUEST['prenataldesid'];
      $prendes->Empid = $_REQUEST['empid'];
      $prendes->Empnrodocto = $_REQUEST['hddempndoc'];
      $prendes->Bennrodocto = $_REQUEST['hddbenndoc'];
      $prendes->Observacion = $_REQUEST['txtprenataldeshabilitar'];

      $this->model->PreNatalDeshabilitarExe($prendes);
      $this->model->PrenatalInfo($prendes);

      header("Location: index.php?c=empleado&a=Crud&id=$prendes->Empid&startIndex=5");
    }
    public function PreNatalHabilitar(){
      $prenhab = new Empleado();

      $prenhab->Id = $_REQUEST['prenataldesid'];
      $prenhab->Prenid = $_REQUEST['prenataldesid'];
      $prenhab->Empid = $_REQUEST['empid'];
      $prenhab->Empnrodocto = $_REQUEST['hddpnhempndoc'];
      $prenhab->Bennrodocto = $_REQUEST['hddpnhbenndoc'];

      $this->model->PreNatalHabilitarExe($prenhab);
      $this->model->PrenatalInfo($prenhab);

      header("Location: index.php?c=empleado&a=Crud&id=$prenhab->Empid&startIndex=5");
    }
    public function GuardarC(){
        $cye = new Empleado();

        $cye->Cyetdoc = $_REQUEST['conyugetdoc'];
        $cye->Cyendoc = $_REQUEST['conyugendoc'];
        $cye->Cyeapellido = $_REQUEST['conyugeapellido'];
        $cye->Cyenombres = $_REQUEST['conyugenombres'];
        $cye->Cyecuil = $_REQUEST['conyugenrocuil'];
        $cye->Cyesexo = $_REQUEST['conyugesexo'];
        $cye->Cyefecnacto = $_REQUEST['conyugefecnacto'];
        $cye->Cyedireccion = $_REQUEST['conyugedireccion'];
        $cye->Cyedirecnro = $_REQUEST['conyugedirecnro'];
        $cye->Cyedirecpiso = $_REQUEST['conyugedirecpiso'];
        $cye->Cyecpostal = $_REQUEST['conyugecodpostal'];
        $cye->Cyecelular = $_REQUEST['conyugecelular'];
        $cye->Cyetelefono = $_REQUEST['conyugetelefono'];
        $cye->Cyeemail = $_REQUEST['conyugeemail'];
        $cye->Cyepais = $_REQUEST['conyugepais'];
        $cye->Cyeprovincia = $_REQUEST['conyugeprovincia'];
        $cye->Cyedepartamento = $_REQUEST['conyugedepartamento'];
        $cye->Cyelocalidad = $_REQUEST['conyugelocalidad'];
        $cye->Cyeactivo = 1;
        $cye->Empnrodocto = $_REQUEST['empnrodocto'];
        $cye->Empid = $_REQUEST['empid'];

        $this->model->RegistrarC($cye);

        header("Location: index.php?c=empleado&a=Crud&id=$cye->Empid#steps-uid-0-h-2");
    }
    public function GuardarContrato(){

        $contrato = new Empleado();

        $contrato->EmpTipoLegajoAdd = $_REQUEST['CboEmpTipoLegajoAdd'];
        $contrato->EmpCategoriaAdd = $_REQUEST['TxtEmpCategoriaAdd'];
        $contrato->EmpFechaInicioAdd = $_REQUEST['TxtEmpFechaInicioAdd'];
        $contrato->EmpFechaFinalizacionAdd = $_REQUEST['TxtEmpFechaFinalizacionAdd'];
        $contrato->EmpSecretariaAdd = $_REQUEST['CboEmpSecretariaAdd'];
        $contrato->EmpImputacionAdd = $_REQUEST['CboEmpImputacionAdd'];
        $contrato->EmpDependenciaAdd = $_REQUEST['CboEImpDependenciaadAdd'];
        $contrato->EmpTareaAdd = $_REQUEST['TxtEmpTareaAdd'];
        $contrato->EmpLugarDeTrabajoAdd= $_REQUEST['CboEmpLugarDeTrabajoAdd'];
        $contrato->EmpSueldoBasicoAdd = $_REQUEST['TxtEmpSuedoBasicoAdd'];
        $contrato->EmpModeloContrato = $_REQUEST['CboModeloContrato'];
        $contrato->EmpNroDocto = $_REQUEST['EmpNroDocto'];
        $contrato->EmpId = $_REQUEST['EmpId'];
        $contrato->ContratoId = $_REQUEST['ContratoId'];
        //$contrato->EmpContratoActivo = 1;
        $contrato->ContratoId > 0
            ? $this->model->ActualizarContrato($contrato)
            : $this->model->RegistrarContrato($contrato);

        header("Location: index.php?c=empleado&a=Crud&id=$contrato->EmpId&startIndex=1");

    }
    public function GuardarProveedor(){

        $proveedor = new Empleado();

        $proveedor->Empid = $_REQUEST['hddempid'];
        $proveedor->Empnrodocto = $_REQUEST['hddempnrodocto'];
        $proveedor->Empcontratoproid = $_REQUEST['hddcontratoproid'];
        $proveedor->EmpModeloContrato = $_REQUEST['cbomodelocontrato'];
        
        $proveedor->Empprofechainicioadd = $_REQUEST['txtprofecinicioadd'];
        $proveedor->Empprofechafinaladd = $_REQUEST['txtprofecfinaladd'];
        $proveedor->Empprosecretariaadd = $_REQUEST['cboprosecretariaad'];
        $proveedor->Empprotrabajoadd = $_REQUEST['cboprolugardetrabajoadd'];
        $proveedor->Empprotareaadd = $_REQUEST['txtprotareaadd'];
        $proveedor->Empprosueldobasicoadd = $_REQUEST['txtprosueldobasicoadd'];

        $proveedor->Empcontratoproid > 0
            ? $this->model->ActualizarProveedorExe($proveedor)
            : $this->model->GuardarProveedorExe($proveedor);
            //? $this->model->ActualizarContrato($proveedor)
            //: $this->model->RegistrarContrato($proveedor);

        header("Location: index.php?c=empleado&a=Crud&id=$proveedor->Empid&startIndex=1");

    }
    public function GuardarContratoAct(){
        $contratoact = new Empleado();
        //---- Variables ----
        $nrodnis = $_REQUEST['NrosDocto'];
        $contratoact->EmpNroDocto = $_REQUEST['EmpNroDocto'];
        $contratoact->EmpId = $_REQUEST['EmpId'];
        $contratoact->ContratoId = $_REQUEST['ContratoId'];
        $contratoact->EmpContratoActivo = 1;
        //---- Fin de Variables ---
        //--- Datos para edicion de contrato -----
        $contratoact->EmpTipoLegajoAdd = $_REQUEST['cboemptipolegajoact'];
        $contratoact->EmpCategoriaAdd = $_REQUEST['txtempcategoriaact'];
        $contratoact->EmpFechaInicioAdd = $_REQUEST['txtempfechainicioact'];
        $contratoact->EmpFechaFinalizacionAdd = $_REQUEST['txtempfechafinalizacionact'];
        $contratoact->EmpSecretariaAdd = $_REQUEST['cboempsecretariaact'];
        $contratoact->EmpImputacionAdd = $_REQUEST['cboempimputacionact'];
        $contratoact->EmpDependenciaAdd = $_REQUEST['cboempactividadact'];
        $contratoact->EmpTareaAdd = $_REQUEST['txtemptareaact'];
        $contratoact->EmpLugarDeTrabajoAdd= $_REQUEST['cboemplugardetrabajoact'];
        $contratoact->EmpSueldoBasicoAdd = $_REQUEST['txtempsueldobasicoact'];
        //---Fin Datos para edicion de contrato -----

        $this->model->ActualizarContrato($contratoact);

        //header("Location: index.php?c=empleado&a=Crud&id=$contrato->EmpId&startIndex=1");
        header("Location: index.php?c=empleado&a=ActualizacionDeContratosExitosa&id=$nrodnis");
        //window.location.href = "?c=empleado&a=ActualizacionDeContratosExitosa&id="+nrodnis;

    }
    public function GuardarContratoActualizarI(){
        $contratoacti = new Empleado();

        $contratoacti->ContratoIdActInd = $_REQUEST['ContratoIdActInd'];
        $contratoacti->EmpIdActInd = $_REQUEST['EmpIdActInd'];
        $contratoacti->EmpNroDoctoActInd = $_REQUEST['EmpNroDoctoActInd'];
        /*
        $nrodnis = $_REQUEST['NrosDocto'];
        $contratoact->EmpContratoActivo = 1;
        */
        //---- Fin de Variables ---
        //--- Datos para edicion de contrato -----
        //$contratoacti->EmpTipoLegajoActInd = $_REQUEST['cboemptipolegajoacti'];
        //$contratoacti->EmpCategoriaActInd = $_REQUEST['txtempcategoriaacti'];
        $contratoacti->EmpFechaInicioActInd = $_REQUEST['txtempfechainicioacti'];
        $contratoacti->EmpFechaFinalizacionActInd = $_REQUEST['txtempfechafinalizacionacti'];
        $contratoacti->EmpSecretariaActInd = $_REQUEST['cboempsecretariaacti'];
        $contratoacti->EmpImputacionActInd = $_REQUEST['cboempimputacionacti'];
        $contratoacti->EmpDependenciaActInd = $_REQUEST['cboempdependenciaacti'];
        $contratoacti->EmpTareaActInd = $_REQUEST['txtemptareaacti'];
        $contratoacti->EmpLugarDeTrabajoActInd = $_REQUEST['cboemplugardetrabajoacti'];
        $contratoacti->EmpSueldoBasicoActInd = $_REQUEST['txtempsueldobasicoacti'];
        //---Fin Datos para edicion de contrato -----

        $this->model->ContratoRenovar($contratoacti);

        header("Location: index.php?c=empleado&a=Crud&id=$contratoacti->EmpIdActInd&startIndex=1");

    }
    public function ProveedorContratoActualizarI(){
        $procontratoact = new Empleado();

        $procontratoact->Empid = $_REQUEST['hddproid'];
        $procontratoact->Empnrodocto = $_REQUEST['hddpronrodocto'];
        $procontratoact->Procontratoidanterior = $_REQUEST['hddprocontratoid'];
        //---- Fin de Variables ---
        //--- Datos para edicion de contrato -----
        $procontratoact->Profechainicioactualizacion = $_REQUEST['txtprofechainicioacti'];
        $procontratoact->Profechafinalactualizacion = $_REQUEST['txtprofechafinalacti'];
        $procontratoact->Prosecretariaactualizacion = $_REQUEST['cboprosecretariaacti'];
        $procontratoact->Proltrabajoactualizacion = $_REQUEST['cboproltrabajoacti'];
        $procontratoact->Protareaactualizacion = $_REQUEST['txtprotareaacti'];
        $procontratoact->Prosbasicoactualizacion = $_REQUEST['txtprosueldobasicoacti'];
        //---Fin Datos para edicion de contrato -----

        $this->model->ProveedorContratoRenovar($procontratoact);

        header("Location: index.php?c=empleado&a=Crud&id=$procontratoact->Empid&startIndex=1");

    }
    public function GuardarCPPermanente(){

        $cppermanente = new Empleado();
        //---- Variables Ocultas -----
        $cppermanente->Empid = $_REQUEST['hddempidpp'];
        $cppermanente->Empcppnrodocto = $_REQUEST['hddempnrodoctopp'];
        $cppermanente->Empcppid = $_REQUEST['hddppid'];
        //----- Variables de datos ----
        $cppermanente->Empcppcategoria = $_REQUEST['txtcategoriapp'];
        $cppermanente->Empcppsecretaria = $_REQUEST['cbosecretariapp'];
        //$cppermanente->Empcppimputacion = $_REQUEST['cboimputacionpp'];
        $cppermanente->Empcppltrabajo = $_REQUEST['cbolugartrabajopp'];
        $cppermanente->Empcpptarea = $_REQUEST['txttareapp'];
        $cppermanente->Empcppfecantiguedad = $_REQUEST['txtfecantiguedadpp'];

        $this->model->ActualizarPPermanente($cppermanente);

        header("Location: index.php?c=empleado&a=Crud&id=$cppermanente->Empid&startIndex=1");

    }
    public function GuardarCJornalero(){

        $cjornalero = new Empleado();
        //---- Variables Ocultas -----
        $cjornalero->Empid = $_REQUEST['hddempidjor'];
        $cjornalero->Empcjornrodocto = $_REQUEST['hddempnrodoctojor'];
        $cjornalero->Empcjorid = $_REQUEST['hddidjor'];
        //----- Variables de datos ----
        $cjornalero->Empcjorsecretaria2 = $_REQUEST['cbosecretariajornalero'];
        //$cppermanente->Empcppimputacion = $_REQUEST['cboimputacionpp'];
        $cjornalero->Empcjorltrabajo = $_REQUEST['cbolugartrabajojor'];
        $cjornalero->Empcjortarea = $_REQUEST['txttareajor'];
        $cjornalero->Empcjorfecantiguedad = $_REQUEST['txtfecantiguedadjor'];

        $this->model->ActualizarCJornalero($cjornalero);

        header("Location: index.php?c=empleado&a=Crud&id=$cjornalero->Empid&startIndex=1");

    }
    public function GuardarEs(){
        $est = new Empleado();

        $est->Id = $_REQUEST['id'];
        $est->Empid = $_REQUEST['empid'];
        $est->Empnrodocto = $_REQUEST['empnrodocto'];
        $est->Estudioesc = $_REQUEST['estudioesc'];
        $est->Estudionvl = $_REQUEST['estudionvl'];
        $est->Estudioestado = $_REQUEST['estudioestado'];
        $est->Estudiotitulo = $_REQUEST['estudiotitulo'];
        $est->Estudioarchivo = "";
        $est->Estudioactivo = 1;

        $est->Id > 0
            ? $this->model->ActualizarEs($est)
            : $this->model->RegistrarEs($est);

        header("Location: index.php?c=empleado&a=Crud&id=$est->Empid&startIndex=2");

    }

    public function DeshabilitarEs(){
      $est = new Empleado();

      $est->Activo = 0;
      $est->Estudioid = $_REQUEST['estudioid'];
      $est->Empid = $_REQUEST['empid'];

        $this->model->DeshabilitarEst($est);

      header("Location: index.php?c=empleado&a=Crud&id=$est->Empid&startIndex=2");
    }
    public function EmpleadoAutocompletar(){
      require_once 'includes/php/autocompletar_empleado.php';
    }
    public function GuardarEmpleado(){
        $empleado1 = new Empleado();
        //-------datos personales -----
        //------Variables hidden ------
        $empleado1->Empid = $_REQUEST['hddempide'];
        //$empleado1->Empnrodocumentohdd = $_REQUEST['hddempnrodocto'];
        //$empleado1->Empnrodocumento = $_REQUEST['txtnrodoctoe'];
        $empleado1->Empmovimiento = $_REQUEST['hddempmovimientoe'];
        if($empleado1->Empmovimiento == 2){
          $empleado1->Empnrodocumento = $_REQUEST['hddempnrodocto'];
        }else{
          $empleado1->Empnrodocumento = $_REQUEST['txtnrodoctoe'];
        }
        //----- Variables del Formulario
        $empleado1->Empcuil = $_REQUEST['txtempnrocuile'];
        $empleado1->Empnrolegajo = $_REQUEST['txtempnrolegajoe'];
        $empleado1->Empapellido = $_REQUEST['txtempapellidoe'];
        $empleado1->Empnombres = $_REQUEST['txtempnombrese'];
        $empleado1->Empsexotres = $_REQUEST['cboempsexoe'];
        $empleado1->Empestcivil = $_REQUEST['cboempestadocivile'];
        $empleado1->Empfecnacto = $_REQUEST['txtempfecnace'];
        $empleado1->Empfecing = $_REQUEST['txtempfecinge'];
        $empleado1->Emptleg = 0;

        if($empleado1->Empid > 0){
          //----Actualizar Empleado
          $this->model->ActualizarEmpleadoExe($empleado1);
          header("Location: index.php?c=empleado&a=Crud&id=$empleado1->Empid&startIndex=0");
        }else{
          //---Agregar Nuevo Empleado
          $ultimoid = $this->model->GuardarEmpleadoExe($empleado1);
          header("Location: index.php?c=empleado&a=Crud&id=$ultimoid&startIndex=0");

        }
    }
    public function GuardarEmpleadoDomicilio(){
        $empleado2 = new Empleado();
        //-------datos personales -----
        //------Variables hidden ------
        $empleado2->Empid = $_REQUEST['hddempide'];
        $empleado2->Empnrodocumento = $_REQUEST['hddempnrodoctoe'];
        //----- Variables del Formulario
        $empleado2->Empdireccion = $_REQUEST['txtempdireccione'];
        $empleado2->Empdirecnro = $_REQUEST['txtempdirenroe'];
        $empleado2->Empdirecpiso = $_REQUEST['txtempdirecpisoe'];
        $empleado2->Empcpostal = $_REQUEST['txtempcpostale'];
        $empleado2->Emppais = $_REQUEST['cboemppaise'];
        $empleado2->Empprovincia = $_REQUEST['cboempprovinciae'];
        $empleado2->Empdepartamento = $_REQUEST['cboempdepartamentoe'];
        $empleado2->Emplocalidad = $_REQUEST['cboemplocalidade'];

        $this->model->ActualizarEmpleadoDomicilioExe($empleado2);
        header("Location: index.php?c=empleado&a=Crud&id=$empleado2->Empid&startIndex=0");

    }
    public function GuardarEmpleadoContacto(){
        $empleado3 = new Empleado();
        //-------datos personales -----
        //------Variables hidden ------
        $empleado3->Empid = $_REQUEST['hddempide'];
        $empleado3->Empnrodocumento = $_REQUEST['hddempnrodoctoe'];
        //----- Variables del Formulario
        $empleado3->Empcelular = $_REQUEST['txtempcelulare'];
        $empleado3->Emptelefono = $_REQUEST['txtemptelefonoe'];
        $empleado3->Empemail = $_REQUEST['txtempemaile'];

        $this->model->ActualizarEmpleadoContactoExe($empleado3);
        header("Location: index.php?c=empleado&a=Crud&id=$empleado3->Empid&startIndex=0");

    }
    public function BajaEmpleado(){
        $empleado4 = new Empleado();
        $asiginfo = new Empleado();
        //-------datos personales -----
        //------Variables hidden ------
        $empleado4->Empid = $_REQUEST['hddempide'];
        $empleado4->Empnrodocumento = $_REQUEST['hddempnrodoctoe'];
        //----- Variables del Formulario
        $empleado4->Empfecbaja = $_REQUEST['txtempfecbajae'];
        $empleado4->Empobsbaja = $_REQUEST['txtempbajaobse'];
        //---Dar de baja empleado------
        $this->model->BajaEmpleadoExe($empleado4);
        //-----Obtener Conyuge para dar de baja----
        $conyugedatos = $this->model->ConyugeDeEmpleadoObtener($empleado4->Empnrodocumento);
        //------------dar de baja canyuge del empleado--------
        if($conyugedatos->legconyuge_id > 0){
          //----Tiene conyuge, dar de baja
          $empleado4->Cyeid = $conyugedatos->legconyuge_id;
          $this->model->ConyugeBajaExe($empleado4);
          //---asignacion info ---------
          $asiginfo->Empnrodocto = $conyugedatos->legempleado_nrodocto;
          $asiginfo->Cyeid = $conyugedatos->legconyuge_id;
          $asiginfo->Cyenrodocto = $conyugedatos->legconyuge_nrodocto;
          $this->model->ConyugeInfo($asiginfo);
        }
        //-----Obtener Prenatales para dar de baja----
        $prenatalesdatos = $this->model->PrenatalesDeEmpleadoObtener($empleado4->Empnrodocumento);
        //------------da de baja prenatales del empleado--------
        foreach ($prenatalesdatos as $value):
          // code...
          $empleado4->PreNatalId = $value->legprenatal_id;
          $this->model->PreNatalEliminarExe($empleado4);
          //---asignacion info ---------
          $asiginfo->Id = $value->legprenatal_id;
          $asiginfo->Empnrodocto = $value->legempleado_nrodocto;
          $asiginfo->Bennrodocto = $value->legprenatal_benndoc;
          $this->model->PrenatalInfo($asiginfo);
        endforeach;
        //-----Obtener hijos para dar de baja----
        $hijosdatos = $this->model->HijosDeEmpleadoObtener($empleado4->Empnrodocumento);
        //------------da de baja hijos del empleado--------
        foreach ($hijosdatos as $value):
          // code...
          $empleado4->Activo = 0;
          $empleado4->Hijoid = $value->leghijo_id;
          $this->model->HijoEliminarExe($empleado4);
          //----asignacion info -------
          $asiginfo->Id = $value->leghijo_id;
          $asiginfo->Empnrodocto = $value->legempleado_nrodocto;
          $asiginfo->Bennrodocto = $value->leghijo_benndoc;
          $this->model->AsignacionInfo($asiginfo);
          $this->model->FamiliaNumerosaInfo($asiginfo);
        endforeach;
        //------Obtener ultimo registro de asignaciones---
        //$asignacionesulreg = $this->model->AsignacionesUltimoRegistro();
        //----- poner informacion de asignacion en estado 3 (baja) ----
        //$this->model->AsignacionInfoActualizar($empleado4->Empnrodocumento, $asignacionesulreg->periodo_id, 3);
        header("Location: index.php?c=empleado&a=Index");

    }
    public function ConyugeGuardar(){

      $conyuge1 = new Empleado();
      //-------datos personales -----
      //------Variables hidden ------
      $conyuge1->Empid = $_REQUEST['hddempide'];
      $conyuge1->Empnrodocumentohdd = $_REQUEST['hddempnrodoctoe'];
      $conyuge1->Empnrodocto = $_REQUEST['hddempnrodoctoe'];
      $conyuge1->Cyeid = $_REQUEST['hddcyeide'];
      //----- Variables del Formulario
      $conyuge1->Cyenrodocto = $_REQUEST['txtcyenrodoctoe'];
      $conyuge1->Cyenrocuil = $_REQUEST['txtcyenrocuile'];
      $conyuge1->Cyeapellido = $_REQUEST['txtcyeapellidoe'];
      $conyuge1->Cyenombres = $_REQUEST['txtcyenombrese'];
      $conyuge1->Cyesexo = $_REQUEST['cbocyesexoe'];
      $conyuge1->Cyefecnacto = $_REQUEST['txtcyefecnactoe'];

      $conyuge1->Cyeid > 0
          ? $this->model->ConyugeActualizarExe($conyuge1)
          : $conyuge1->Cyeid = $this->model->ConyugeGuardarExe($conyuge1);

      $this->model->ConyugeInfo($conyuge1);

      header("Location: index.php?c=empleado&a=Crud&id=$conyuge1->Empid&startIndex=4");
    }
    public function ConyugeDomicilioGuardar(){
        $conyuge2 = new Empleado();
        //-------datos personales -----
        //------Variables hidden ------
        $conyuge2->Empid = $_REQUEST['hddempide'];
        $conyuge2->Empnrodocumento = $_REQUEST['hddempnrodoctoe'];
        $conyuge2->Cyeid = $_REQUEST['hddcyeide'];
        //----- Variables del Formulario
        $conyuge2->Cyedireccion = $_REQUEST['txtcyedireccione'];
        $conyuge2->Cyedirecnro = $_REQUEST['txtcyedirecnroe'];
        $conyuge2->Cyedirecpiso = $_REQUEST['txtcyedirecpisoe'];
        $conyuge2->Cyecpostal = $_REQUEST['txtcyecpostale'];
        $conyuge2->Cyepais = $_REQUEST['cbocyepaise'];
        $conyuge2->Cyeprovincia = $_REQUEST['cbocyeprovinciae'];
        $conyuge2->Cyedepartamento = $_REQUEST['cbocyedepartamentoe'];
        $conyuge2->Cyelocalidad = $_REQUEST['cbocyelocalidade'];

        $this->model->ConyugeDomicilioActualizarExe($conyuge2);
        header("Location: index.php?c=empleado&a=Crud&id=$conyuge2->Empid&startIndex=4");

    }
    public function ConyugeGuardarContacto(){
        $conyuge3 = new Empleado();
        //-------datos personales -----
        //------Variables hidden ------
        $conyuge3->Empid = $_REQUEST['hddempide'];
        $conyuge3->Empnrodocumento = $_REQUEST['hddempnrodoctoe'];
        $conyuge3->Cyeid = $_REQUEST['hddcyeide'];
        //----- Variables del Formulario
        $conyuge3->Cyecelular = $_REQUEST['txtcyecelulare'];
        $conyuge3->Cyetelefono = $_REQUEST['txtcyetelefonoe'];
        $conyuge3->Cyeemail = $_REQUEST['txtcyeemaile'];

        $this->model->ConyugeContactoActualizarExe($conyuge3);
        header("Location: index.php?c=empleado&a=Crud&id=$conyuge3->Empid&startIndex=4");

    }
    public function ConyugeBaja(){
        $conyuge4 = new Empleado();
        //-------datos personales -----
        //------Variables hidden ------
        $conyuge4->Empid = $_REQUEST['hddempide'];
        $conyuge4->Empnrodocumento = $_REQUEST['hddempnrodoctoe'];
        $conyuge4->Empnrodocto = $_REQUEST['hddempnrodoctoe'];
        $conyuge4->Cyeid = $_REQUEST['hddcyeide'];
        $conyuge4->Cyenrodocto = $_REQUEST['hddcyenrodoctoe'];
        //----- Variables del Formulario
        $conyuge4->Cyefecbaja = $_REQUEST['txtcyefecbajae'];
        $conyuge4->Cyeobsbaja = $_REQUEST['txtcyebajaobse'];

        $this->model->ConyugeBajaExe($conyuge4);

        $this->model->ConyugeInfo($conyuge4);

        header("Location: index.php?c=empleado&a=Crud&id=$conyuge4->Empid&startIndex=4");

    }
    /*
    public function GuardarEmpleado(){
        $empg = new Empleado();
        //-------datos personales -----
        //------Variables hidden ------
        $empg->Id = $_REQUEST['empid'];
        $empg->Empnrodocumento = $_REQUEST['empnrodocumento'];

        $empg->Emptdoc = $_REQUEST['emptdoc'];
        $empg->Empapellido = $_REQUEST['empapellido'];
        $empg->Empnombres = $_REQUEST['empnombres'];
        $empg->Empcuil = $_REQUEST['empcuil'];
        $empg->Empnroleg = $_REQUEST['empnroleg'];
        $empg->Empsexotres = $_REQUEST['empsexo'];
        $empg->Empestcivil = $_REQUEST['empestcivil'];
        $empg->Empfecnacto = $_REQUEST['empfecnacto'];
        $empg->Empnrolegv = $_REQUEST['empnrolegv'];
        $empg->Empdireccion = $_REQUEST['empdireccion'];
        $empg->Empdirecnro = $_REQUEST['empdirecnro'];
        $empg->Empdirecpiso = $_REQUEST['empdirecpiso'];
        $empg->Empcpostal = $_REQUEST['empcpostal'];
        $empg->Empcelular = $_REQUEST['empcelular'];
        $empg->Emptelefono = $_REQUEST['emptelefono'];
        $empg->Empemail = $_REQUEST['empemail'];
        $empg->Emppais = $_REQUEST['emppais'];
        $empg->Empprovincia = $_REQUEST['empprovincia'];
        $empg->Empdepartamento = $_REQUEST['empdepartamento'];
        $empg->Emplocalidad = $_REQUEST['emplocalidad'];
        $empg->Empfecing = $_REQUEST['empfecing'];
        $empg->Empfecbaja = $_REQUEST['empfecbaja'];
        $empg->Empactivo = $_REQUEST['empactivo'];
        if($empg->Empactivo == 1){

        }else{
          $empg->Empactivo = 0;
        }
        //----------- Datos de Conyuge ----------------
        $empg->Empcyetdoc = $_REQUEST['cyetdoc'];
        $empg->Empcyendoc = $_REQUEST['cyendoc'];
        $empg->Empcyeapellido = $_REQUEST['cyeapellido'];
        $empg->Empcyenombres = $_REQUEST['cyenombres'];
        $empg->Empcyenrocuil = $_REQUEST['cyenrocuil'];
        $empg->Empcyesexo = $_REQUEST['cyesexo'];
        $empg->Empcyefecnacto = $_REQUEST['cyefecnacto'];
        $empg->Empcyedireccion = $_REQUEST['cyedireccion'];
        $empg->Empcyedirecnro = $_REQUEST['cyedirecnro'];
        $empg->Empcyedirecpiso = $_REQUEST['cyedirecpiso'];
        $empg->Empcyecodpostal = $_REQUEST['cyecodpostal'];
        $empg->Empcyecelular = $_REQUEST['cyecelular'];
        $empg->Empcyetelefono = $_REQUEST['cyetelefono'];
        $empg->Empcyeemail = $_REQUEST['cyeemail'];
        $empg->Empcyepais = $_REQUEST['cyepais'];
        $empg->Empcyeprovincia = $_REQUEST['cyeprovincia'];
        $empg->Empcyedepartamento = $_REQUEST['cyedepartamento'];
        $empg->Empcyelocalidad = $_REQUEST['cyelocalidad'];


        if($empg->Id > 0){
          //----Actualizar Empleado
          $this->model->ActualizarE($empg);
          header("Location: index.php?c=empleado&a=Crud&id=$empg->Id&startIndex=0");
        }else{
          //---Agregar Nuevo Empleado
          $ultimoid = $this->model->RegistrarE($empg);
          header("Location: index.php?c=empleado&a=Crud&id=$ultimoid&startIndex=0");
        }

    }
    */

    public function Eliminar(){
        $this->model->Eliminar($_REQUEST['id']);

        header('Location: index.php');
    }

    public function ImprimirContratoI(){
      $nrodocto = $_GET['id'];
      $datoscontrato = $this->model->ObtenerContrato($nrodocto);
     
      if ($datoscontrato->contrato_modelo_id == 1){
        require_once 'includes/pdf/contrato-individual.php';
      }elseif($datoscontrato->contrato_modelo_id ==2){

        require_once 'includes/pdf/contrato-individual-programador.php';
      }else{
        require_once 'includes/pdf/contrato-individual.php';
      }
      
    }
    public function ImprimirProveedorI(){
      $nrodocto = $_GET['id'];
      $datoscontrato = $this->model->ObtenerProveedor($nrodocto);
     
      if ($datoscontrato->contrato_modelo_id == 3){
        require_once 'includes/pdf/proveedor-individual.php';
      }else if($datoscontrato->contrato_modelo_id == 4){

        require_once 'includes/pdf/proveedor-individual-obra.php';
      }else if($datoscontrato->contrato_modelo_id == 5){
        require_once 'includes/pdf/proveedor-individual-modulo.php';
      }else if($datoscontrato->contrato_modelo_id == 6){
        require_once 'includes/pdf/proveedor-individual-OBRA-PROGAMADOR.php';
      }else if($datoscontrato->contrato_modelo_id == 7){
        require_once 'includes/pdf/proveedor-individual-AD-HONOREM-.php';
      }
      else{
        require_once 'includes/pdf/proveedor-individual.php';
      }
      
     
    }
    public function BusquedaContrato(){
      require_once 'view/busquedacontrato.php';
    }
    public function BusquedaAumento(){
      require_once 'view/busquedaaumento.php';
    }
    public function BusquedaAumentoRespuesta(){
      require_once 'view/busquedaaumento-respuesta.php';
    }
    public function BusquedaContratoSinRenovar(){
      require_once 'view/busquedacontratosinrenovar.php';
    }
    public function ImprimirContratoG(){
      require_once 'includes/pdf/contrato-general0.php';
      //header("Location: includes/pdf/contrato-general0.php");
    }
    public function ProvinciasObtener(){
      require_once 'includes/php/obtener_provincias.php';
    }
    public function DepartamentosObtener(){
      require_once 'includes/php/obtener_departamentos.php';
    }
    public function LocalidadesObtener(){
      require_once 'includes/php/obtener_localidades.php';
    }
    public function ActualizacionDeContratos(){
      $actualizacionc = new Empleado();

      $nrodoctos = $_POST["NroDnis"];
      $fechainicionueva = $_POST["FechaInicioNueva"];
      $fechafinnueva = $_POST["FechaFinNueva"];
      $actualizacion = $_POST["BasicoNuevo"];

      foreach($nrodoctos as $nrodocto){
        $actualizacionc->ContratoActualizar($nrodocto,$fechainicionueva,$fechafinnueva,$actualizacion);
      }

    }
    public function ActualizacionDeContratosProveedores(){
      $actualizacionp = new Empleado();

      $nrodoctos = $_POST["NroDnis"];
      $fechainicionueva = $_POST["FechaInicioNueva"];
      $fechafinnueva = $_POST["FechaFinNueva"];
      $actualizacion = $_POST["BasicoNuevo"];

      foreach($nrodoctos as $nrodocto){
        $actualizacionp->ContratoActualizarProveedor($nrodocto,$fechainicionueva,$fechafinnueva,$actualizacion);
      }

    }
    public function ActualizacionDeContratosExitosa(){
      $actualizacionc = new Empleado();
      /*
      if(isset($_REQUEST['id'])){
        $emp = $this->model->Obtener($_REQUEST['id']);
      }
      */
      $nrodnis = $_REQUEST['id'];

      require_once 'view/busquedaaumento-actualizado.php';
    }
    public function ActualizacionDeContratosProveedoresExitosa(){
      $actualizacionc = new Empleado();

      $nrodnis = $_REQUEST['id'];

      require_once 'view/busquedaaumento-actualizado-proveedores.php';
    }
    public function EmpleadoListado(){
      require_once 'view/empleado-listado.php';
    }
    public function EmpleadoListadoRespuesta(){
      require_once 'view/empleado-listado-respuesta.php';
    }
    public function EmpleadoListadoDos(){
      require_once 'view/empleado-listado-dos.php';
    }
    public function EmpleadoListadoRespuestaDos(){
      require_once 'view/empleado-listado-respuesta-dos.php';
    }
    public function EmpleadoListadoPDF(){
      require_once 'includes/pdf/empleados-listado-x-secretaria.php';
    }

}
