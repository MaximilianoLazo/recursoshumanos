<?php
require_once 'model/dependencia.php';

session_start();
if(!isset($_SESSION["usuario_id"])){
  header("../legajos/login/index.php");
}

class DependenciaController{

    private $model;

    public function __CONSTRUCT(){
        $this->model = new Dependencia();
    }

    public function Index(){
        require_once 'view/imputacion.php';
    }
    /*public function TablaDeActividades(){
        require_once 'view/tabladeactividades.php';
    }*/
    public function Dependencias(){
        require_once 'view/dependencias.php';
    }
    public function ListadoImputacion(){
      $dep = new Dependencia();

      if(isset($_REQUEST['id'])){
        $dep = $this->model->ObtenerListadoImputacion($_REQUEST['id']);
      }

      require_once 'view/imputaciones-empleado.php';
    }
    public function AplicarDependencia(){
      $apdependencia = new Dependencia();

      $dependenciaid = $_POST["DependenciaId"];
      $contratoids = $_POST["ContratoIds"];
      $imputacionid = $_POST["ImputacionId"];
      /*$fechafinnueva = $_POST["FechaFinNueva"];
      $actualizacion = $_POST["BasicoNuevo"];*/

      foreach($contratoids as $contratoid){
        $apdependencia->AplicarDependenciaExe($dependenciaid,$contratoid,$imputacionid);
      }

    }
    public function AplicacionDependenciaExitosa(){
      //$actualizacionc = new Empleado();
      /*
      if(isset($_REQUEST['id'])){
        $emp = $this->model->Obtener($_REQUEST['id']);
      }
      */
      $imputacionid = $_REQUEST['id'];

      require_once 'view/imputaciones-empleado-actualizado.php';
    }
}
