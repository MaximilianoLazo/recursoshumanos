<?php
require_once 'model/legajo.php';
session_start();
if(!isset($_SESSION["usuario_id"])){
  //header('Location: ../login/?c=login&a=Index');
}

class LegajoController{

  private $model;

  public function __CONSTRUCT(){
      $this->model = new Legajo();
  }
  public function Index(){
    //require_once 'view/panel.php';
  }
  public function EmpleadosActivos(){
    require_once 'view/empleado-activo.php';
  }
  public function Pensionados(){
    require_once 'view/pensionados.php';
  }
  public function Jubilados(){
    require_once 'view/jubilados.php';
  }
  public function AJubilar(){
    require_once 'view/a_jubilar.php';
  }

  public function Jubilado(){
    require_once 'view/jubilado.php';
  }

  public function Pensionado(){
    require_once 'view/pensionado.php';
  }

  public function JubiladoEditarSitRev(){
    $expmodidatosjub = new Legajo();

    $expmodidatosjub->legajos_nroleg = $_REQUEST['id'];
    $expmodidatosjub->legajos_fecing = $_REQUEST['textfecha'];

    $this->model->LegajoDatosJubiladoNuevo($expmodidatosjub);
    //if ($expmoditarea->Expventana==1){
    //header("Location: index.php?c=legajo&a=JubiladoEditar&hddjubiladomodiidn=".$_REQUEST['hddjubiladomodiidn']);
    //}else{
    header("Location: index.php?c=legajo&a=JubiladoEditar&id=".$_REQUEST['id']."&seccion=0");

  }

  public function JubiladoEditar(){
    require_once 'view/jubilado_edicion.php';
  }

  //public function HaberEditar(){
  //  require_once 'view/haber_edicion.php';
  //}
  public function ConceptoNov(){
    require_once 'view/novedades_concepto.php';
  }
  public function ConceptoNovCon(){
    require_once 'view/novedades_concepto.php';
  }
  public function DatosJubiladoCompletar(){
    require_once 'includes/php/datos_jubilado_completar.php';
  }

  public function JubiladoModificar(){

    $expmodidatosper = new Legajo();

    $expmodidatosper->legajo_nroleg = $_REQUEST['id'];
    $expmodidatosper->legajo_sexo_id = $_REQUEST['cbosexo'];
    $expmodidatosper->legajo_direccion = $_REQUEST['direccion'];
    $expmodidatosper->legajo_fecnacto = $_REQUEST['textfecha'];
    $expmodidatosper->legajo_ecivil = $_REQUEST['cboecivil'];
    $expmodidatosper->legajo_os = $_REQUEST['cboobrasocial'];
    $expmodidatosper->legajo_localidad = $_REQUEST['cbolocalidad'];
    $expmodidatosper->legajo_celu= $_REQUEST['celular'];

    $this->model->LegajoDatosPersonalesModiExe($expmodidatosper);
    //if ($expmoditarea->Expventana==1){
    //header("Location: index.php?c=legajo&a=JubiladoEditar&hddjubiladomodiidn=".$_REQUEST['hddjubiladomodiidn']);
    //}else{

      header("Location: index.php?c=legajo&a=JubiladoEditar&id=".$_REQUEST['id']."&seccion=0");

      //header("Location: index.php?c=legajo&a=JubiladoEditar&");
    //}
  }

  public function FamiliarEditar(){

    $expmodifamiliar = new Legajo();

    $expmodifamiliar->legajo_id = $_REQUEST['id'];
    $expmodifamiliar->leghijo_tipodocto = $_REQUEST['cbotipodoc'];
    $expmodifamiliar->leghijo_nrodocto= $_REQUEST['hdddni'];
    $expmodifamiliar->leghijo_apellido= $_REQUEST['hddapellido'];
    $expmodifamiliar->leghijo_nombres= $_REQUEST['hddnombre'];
    $expmodifamiliar->sexo_id= $_REQUEST['cbosexo'];
    $expmodifamiliar->leghijo_fecnacto= $_REQUEST['fecnac'];
    $expmodifamiliar->leghijo_direccion= $_REQUEST['direccion'];
    $expmodifamiliar->localidad_id= $_REQUEST['cbolocalidad'];

    //$expmodifamiliar->leghijo_disc = $_REQUEST['checdiscapacidad'];
    //$expmodifamiliar->leghijo_esc = $_REQUEST['checescolaridad'];

    $this->model->LegajoDatosFamiliaresModiExe($expmodifamiliar);
    //if ($expmoditarea->Expventana==1){
    //header("Location: index.php?c=legajo&a=JubiladoEditar&hddjubiladomodiidn=".$_REQUEST['hddjubiladomodiidn']);
    //}else{

      header("Location: index.php?c=legajo&a=JubiladoEditar&id=".$_REQUEST['id']."&seccion=2");

      //header("Location: index.php?c=legajo&a=JubiladoEditar&");
    //}
  }

  public function HaberEditar(){

    $expmodihaber = new Legajo();

    $expmodihaber->legajo_id = $_REQUEST['id'];
    $expmodihaber->legajo_fecnac= $_REQUEST['fecnac'];

    //$expmodifamiliar->leghijo_disc = $_REQUEST['checdiscapacidad'];
    //$expmodifamiliar->leghijo_esc = $_REQUEST['checescolaridad'];

    $this->model->LegajoDatosHaberModiExe($expmodihaber);
    //if ($expmoditarea->Expventana==1){
    //header("Location: index.php?c=legajo&a=JubiladoEditar&hddjubiladomodiidn=".$_REQUEST['hddjubiladomodiidn']);
    //}else{

      header("Location: index.php?c=legajo&a=JubiladoEditar&id=".$_REQUEST['id']."&seccion=5");

      //header("Location: index.php?c=legajo&a=JubiladoEditar&");
    //}
  }


  public function ApoderadoAlta(){

    $expmodidatosper = new Legajo();

    $expmodidatosper->legajo_id = $_REQUEST['hddjubiladoidn'];
    $expmodidatosper->legapoderado_nrodocto = $_REQUEST['hdddni'];
    $expmodidatosper->legapoderado_tipo_docto_id = $_REQUEST['cbotipodoc'];
    $expmodidatosper->legapoderado_nombres = $_REQUEST['hddnombre'];
    $expmodidatosper->legapoderado_apellido = $_REQUEST['hddape'];
    $expmodidatosper->legapoderado_direccion = $_REQUEST['direccion'];
    $expmodidatosper->legapoderado_celular = $_REQUEST['celular'];

     $this->model->ApoderadoGuardarExe($expmodidatosper);

      header("Location: index.php?c=legajo&a=JubiladoEditar&id=".$_REQUEST['hddjubiladoidn']."&seccion=3");
    //if ($expmoditarea->Expventana==1){
    //header("Location: index.php?c=legajo&a=JubiladoEditar&hddjubiladomodiidn=".$_REQUEST['hddjubiladomodiidn']);
    //}else{
    //  header("Location: index.php?c=expediente&a=ExpedienteBandejaTarea");
    //}

  }

  public function ConyugeAlta(){

    $expmodidatosper = new Legajo();

    $expmodidatosper->legajo_id = $_REQUEST['hddjubiladoidn'];
    $expmodidatosper->legapoderado_nrodocto = $_REQUEST['hdddni'];
    $expmodidatosper->legapoderado_tipo_docto_id = $_REQUEST['cbotipodoc'];
    $expmodidatosper->legapoderado_nombres = $_REQUEST['hddnombre'];
    $expmodidatosper->legapoderado_apellido = $_REQUEST['hddape'];
    $expmodidatosper->legapoderado_fec = $_REQUEST['fecnac'];
    $expmodidatosper->legapoderado_direccion = $_REQUEST['direccion'];
    $expmodidatosper->legapoderado_celular = $_REQUEST['celular'];

     $this->model->ConyugeGuardarExe($expmodidatosper);

      header("Location: index.php?c=legajo&a=JubiladoEditar&id=".$_REQUEST['hddjubiladoidn']."&seccion=1");
    //if ($expmoditarea->Expventana==1){
    //header("Location: index.php?c=legajo&a=JubiladoEditar&hddjubiladomodiidn=".$_REQUEST['hddjubiladomodiidn']);
    //}else{
    //  header("Location: index.php?c=expediente&a=ExpedienteBandejaTarea");
    //}

  }

  public function ConyugeModificar(){

    $expmodidatosper = new Legajo();

    $expmodidatosper->legajo_nroleg = $_REQUEST['hddjubiladoidn'];
    $expmodidatosper->legajo_conyugeid = $_REQUEST['hddconyugeidn'];
    $expmodidatosper->legajo_apellido = $_REQUEST['hddapellido'];
    $expmodidatosper->legajo_nombres = $_REQUEST['hddnombre'];
    $expmodidatosper->legajo_dni = $_REQUEST['hdddni'];
    $expmodidatosper->legajo_tipodni = $_REQUEST['cbotipodoc'];
    $expmodidatosper->legajo_fecnac = $_REQUEST['textfecha'];
    $expmodidatosper->legajo_direccion = $_REQUEST['direccion'];
    $expmodidatosper->legajo_celular = $_REQUEST['celular'];

    $this->model->LegajoDatosConyugeModiExe($expmodidatosper);
    //if ($expmoditarea->Expventana==1){
    //header("Location: index.php?c=legajo&a=JubiladoEditar&hddjubiladomodiidn=".$_REQUEST['hddjubiladomodiidn']);
    //}else{

      header("Location:index.php?c=legajo&a=JubiladoEditar&id=".$_REQUEST['hddjubiladoidn']."&seccion=1");

      //header("Location: index.php?c=legajo&a=JubiladoEditar&");
    //}
  }

  public function JubiladoAlta(){

    $expmodidatosper = new Legajo();

    $expmodidatosper->legapoderado_nrodocto = $_REQUEST['hdddni'];
    $expmodidatosper->legapoderado_tipo_docto_id = $_REQUEST['cbotipodoc'];
    $expmodidatosper->legapoderado_nombres = $_REQUEST['hddnombre'];
    $expmodidatosper->legapoderado_apellido = $_REQUEST['hddape'];
    $expmodidatosper->legapoderado_direccion = $_REQUEST['direccion'];
    $expmodidatosper->legapoderado_fecnac = $_REQUEST['textfecha'];
    $expmodidatosper->legapoderado_sexo = $_REQUEST['cbosexo'];
    $expmodidatosper->legapoderado_os = $_REQUEST['cboobrasocial'];
    $expmodidatosper->legapoderado_celular = $_REQUEST['celular'];
    $expmodidatosper->legapoderado_nroleg = $_REQUEST['nroleg'];
    $expmodidatosper->legapoderado_localidad = $_REQUEST['cbolocalidad'];

     $this->model->JubiladoGuardarExe($expmodidatosper);

      header("Location: index.php?c=legajo&a=AJubilar");

  }

  public function ApoderadoEliminar(){

    $expmodidatosper = new Legajo();
    $expmodidatosper->legapoderado_id = $_REQUEST['hddapoderadoidn'];
    $this->model->ApoderadoEliminarExe($expmodidatosper);
    header("Location: index.php?c=legajo&a=JubiladoEditar&id=".$_REQUEST['hddjubiladoidn']."&seccion=3");

  }

  public function ConyugeEliminar(){

    $expmodidatosper = new Legajo();
    $expmodidatosper->legapoderado_id = $_REQUEST['hddapoderadoidn'];
    $expmodidatosper->legjubilado_id = $_REQUEST['hddjubiladoidn'];
    $this->model->ConyugeEliminarExe($expmodidatosper);
    header("Location: index.php?c=legajo&a=JubiladoEditar&id=".$_REQUEST['hddjubiladoidn']."&seccion=1");

  }


  public function ApoderadoModificar(){
    $expmodidatosper = new Legajo();

    $jub=$_REQUEST['hddjubiladoidn'];
    $expmodidatosper->legapoderado_id = $_REQUEST['hddapoderadoidn'];
    $expmodidatosper->legapoderado_tipodni = $_REQUEST['cbotipodoc'];
    $expmodidatosper->legapoderado_dni = $_REQUEST['hdddni'];
  	$expmodidatosper->legapoderado_nombres = $_REQUEST['hddnom'];
	  $expmodidatosper->legapoderado_apellido = $_REQUEST['hddape'];
		$expmodidatosper->legapoderado_direccion = $_REQUEST['direccion'];
    $expmodidatosper->legapoderado_celular = $_REQUEST['celular'];

    $this->model->ApoderadoModificarExe($expmodidatosper);

    header("Location: index.php?c=legajo&a=JubiladoEditar&id=".$jub."&seccion=3");
    //if ($expmoditarea->Expventana==1){
    //header("Location: index.php?c=legajo&a=JubiladoEditar&hddjubiladomodiidn=".$_REQUEST['hddjubiladomodiidn']);
    //}else{
    //  header("Location: index.php?c=expediente&a=ExpedienteBandejaTarea");
    //}
  }
}