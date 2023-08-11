<?php
require_once 'model/liquidacion.php';
error_reporting(0);
session_start();
if (!isset($_SESSION["usuario_id"])) {
  header("../liquidacion/login/index.php");
}
//----sona horario y formato de fechas--------
date_default_timezone_set("America/Buenos_Aires");
//setlocale(LC_ALL,"es_ES");
setlocale(LC_ALL, 'es_RA.UTF8');
//setlocale(LC_TIME, "es_RA.UTF-8");
setlocale(LC_TIME, 'es_RA.utf-8', 'spanish');
//setlocale('es_ES.UTF-8'); // I'm french !

class LiquidacionController
{
  private $model;
  public function __CONSTRUCT()
  {
    $this->model = new Liquidacion();
  }
  public function Index()
  {
    require_once 'view/novedades.php';
  }

  public function ListadoReciboRespuesta(){
    require_once 'view/recibos-respuesta.php';
  }
  public function ListadoRecibos()
  {
    require_once 'view/recibos.php';
  }
  public function ListadoRecibosPorLote(){
    require_once 'view/recibos-por-lote.php';
  }
  public function ImprimirLoteRecibos(){
    $id= $_REQUEST["val"];

    echo $id;

    //require_once 'includes/pdf/recibo-por-lote.php';
  }
  public function ReciboOTPDF()
  {
    $id= $_REQUEST['tid'];
    //--fechas
    //$fecha_inicio = $_REQUEST['FechaI'];

    //$fecha_inicio = date("d/m/Y", strtotime($fecha_inicio));
    //$fecha_final = $_REQUEST['FechaF'];
    //$fecha_final = date("d/m/Y", strtotime($fecha_final));
    //$archivo_nombre = $fecha_inicio;
    $recibosdatos= $this->model->ListarRecibo($id);
    $recibosdatos_emp= $this->model->JubiladoObtenerLeg($id);
    $per=$this->model->CJMDGPeriodoObtener();
    $m=new datetime($per->periodo_hsext_jor_f);
    $fec=$m->format('F');

    require_once 'includes/pdf/recibo.php';
  }

  public function ReciboxEmp()
  {
    $recibojub->legajo_id = $_REQUEST['Id'];

    $this->model->GenerarReciboMensualExe($recibojub);

    require_once 'includes/php/recibo-xempleado.php';
  }

  public function ReciboxEmpxmes()
  {
    $recibojub->legajo_id = $_REQUEST['Id'];

    $this->model->GenerarReciboMensualExe($recibojub);

    require_once 'includes/php/recibo-xmes.php';
  }

  public function Novedades()
  {
    require_once 'view/novedades.php';
  }


  public function ReciboDescargarPrueba(){
    require_once 'includes/pdf/recibo.php';
  }

  public function ReciboDescargarPruebaxmes(){
    require_once 'includes/pdf/recibo-xmes.php';
  }

  public function LiquidacionMensual()
  {
    require_once 'view/liquidacion_mensual.php';
  }
  public function LiqPreviaMensual()
  {
    require_once 'view/liquidacion_previa_mensual.php';
  }
  public function NovedadesEditar(){
    require_once 'view/novedades_edicion.php';
  }

  public function LiqxJubilado(){
    require_once 'view/jubilado-activo.php';
  }

  public function NovedadesIngresoAyuda(){
    require_once 'includes/php/novedadesingreso-ayuda.php';
  }

  public function ReciboEditar(){
    require_once 'view/mostrar-recibo.php';
  }

  public function NovedadesMasivas(){
    require_once 'view/novedadesxtanda.php';
  }

  public function AltaNovedadxtanda()
  {
      $expnovedad->peri = $_REQUEST['hddper'];
      $expnovedad->novedadtipo = $_REQUEST['cbonovedadtipo'];
      $expnovedad->jubtipo = $_REQUEST['cbotipodoc'];
      $expnovedad->radioimp = $_REQUEST['radioresi'];
      $expnovedad->importe_nov = $_REQUEST['txtimportenov'];

      $this->model->JubNovedadMasivaGuardarExe($expnovedad);

      header("Location: index.php?c=liquidacion&a=NovedadesMasivas");

  }

  public function LiquidacionPrevia()
  {

      $jubliq = $_REQUEST['hddper'];
      $this->model->JubLiqPrevExe($jubliq);

    //require_once 'view/liquidacion_previa_mensual.php';
    header("Location: index.php?c=liquidacion&a=LiqPreviaMensual");

  }

  public function LiquidacionFinal()
  {

    $año = date("Y");
    $mesletra = strftime("%B");
    $mesnumero = strftime("%m");
    $dianumero = strftime("%d");
    $dialetra = strftime("%A");
    $fecha = date("Y-m-d");
    $fechanumerica = date("Ymd");
    $horanumerica = date("His");


    $periodo =  $this->model->CJMDGPeriodoObtener();
    $periodo_actual->PerioidOld = $periodo->periodo_id;
    $periodohsi = $periodo->periodo_hsext_jor_i;
    $periodohsf = $periodo->periodo_hsext_jor_f;
    $periodoprei = $periodo->periodo_presentismo_i;
    $periodopref = $periodo->periodo_presentismo_f;

      //---Periodo actual vencido, Crear Nuevo ----
      //---creando fecha inicio nuevo periodo
      //--- horas extras y jornal----
      $periodohsf_arr = date("Y-m-d", strtotime($periodohsf));
      $periodo_actual->PeriodohsiNew = date("Y-m-d",strtotime($periodohsf_arr."+ 1 days"));
      //--- Presentismo -----
      $periodoprei_arr = date("Y-m-d", strtotime($periodoprei));
      $periodo_actual->PeriodopreiNew = date("Y-m-d",strtotime($periodoprei_arr."+ 1 month"));
      //----Creando fecha final nuevo periodo ---
      //--- horas extras y jornal----
      $periodohsf_nuevo_año = $año;
      $periodohsf_nuevo_mes = date("m",strtotime($periodo_actual->PeriodohsiNew."+ 1 month"));
      $periodohsf_nuevo_dia = 14;
      $periodo_actual->PeriodohsfNew = $periodohsf_nuevo_año."-".$periodohsf_nuevo_mes."-".$periodohsf_nuevo_dia;
      //---- Presentismo -----
      $periodoprei_arr = new DateTime($periodo_actual->PeriodopreiNew);
      $periodoprei_arr->modify('last day of this month');
      $periodo_actual->PeriodoprefNew = $periodoprei_arr->format('Y-m-d'); // imprime por ejemplo: 31/12/2012
      //----nombre de periodo-----
      $periodo_actual->Periodonombre = $periodohsf_nuevo_año."".$periodohsf_nuevo_mes;

      //$periodo_actual->GuardarPeriodoNuevo($periodoanteriorid,$periodo_nombre,$periodohsi_nuevo,$periodohsf_nuevo,$periodoprei_nuevo,$periodopref_nuevo);

      $this->model->JubLiqFinalExe($periodo_actual);

      header("Location: index.php?c=liquidacion&a=LiqPreviaMensual");

}

  public function AltaNovedad()
  {

    $expnovedad->jubid = $_REQUEST['hddjub'];
    $expnovedad->peri = $_REQUEST['hddper'];
    $expnovedad->novedadtipo = $_REQUEST['cbonovedadtipo'];
    $expnovedad->importe_nov = $_REQUEST['txtimportenov'];

    $this->model->JubMotivoTipoGuardarExe($expnovedad);

    header("Location: index.php?c=liquidacion&a=NovedadesEditar&id=".$_REQUEST['hddjub']);

    }

  }
