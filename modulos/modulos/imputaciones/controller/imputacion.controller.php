<?php
require_once 'model/imputacion.php';

session_start();
if(!isset($_SESSION["usuario_id"])){
  header("../legajos/login/index.php");
}

class ImputacionController{

    private $model;

    public function __CONSTRUCT(){
        $this->model = new Imputacion();
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
    public function GuardarI(){
        $imputacion = new Imputacion();

        $imputacion->ImputacionId = $_REQUEST['imputacionid'];
        $imputacion->ImputacionCodigoW = $_REQUEST['imputacioncodigow'];
        $imputacion->ImputacionCodigoS = $_REQUEST['imputacioncodigos'];
        $imputacion->ImputacionNombre = $_REQUEST['imputacionnombre'];

        $imputacion->ImputacionId > 0
            ? $this->model->ActualizarI($imputacion)
            : $this->model->RegistrarI($imputacion);

        header("Location: index.php");
    }
    public function GuardarIAC(){
        $imputacion = new Imputacion();

        $imputacion->ImpActividadId = $_REQUEST['impactividadid'];
        $imputacion->ImpActividadCodigoS = $_REQUEST['impactividadcodigos'];
        $imputacion->ImpActividadNombre = $_REQUEST['impactividadnombre'];
        $imputacion->ImputacionId = $_REQUEST['imputacionnombre'];

        $imputacion->ImpActividadId > 0
            ? $this->model->ActualizarIAC($imputacion)
            : $this->model->RegistrarIAC($imputacion);

        header("Location: index.php?c=imputacion&a=TablaDeActividades");
    }
    public function DeshabilitarImputacion(){
      $imputacion40 = new Imputacion();

      $imputacion40->ImputacionId = $_REQUEST['imputacionid'];
      $imputacion40->ImputacionActivo = 0;

        $this->model->DeshabilitarImputacionExe($imputacion40);

      header("Location: index.php");
    }
    public function ListadoEmpleadosXImputaciones(){
      $imputacion = new Imputacion();

      if(isset($_REQUEST['id'])){
        $imputacion = $this->model->ObtenerEmpleadosXImputaciones($_REQUEST['id']);
      }

      require_once 'view/imputacion-xempleado.php';
    }
}
