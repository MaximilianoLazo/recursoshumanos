<?php
require_once 'model/tarea.php';

session_start();
if(!isset($_SESSION["usuario_id"])){
  header("../legajos/login/index.php");
}

class TareaController{

    private $model;

    public function __CONSTRUCT(){
        $this->model = new Tarea();
    }

    public function Index(){
        require_once 'view/tarea.php';
    }
    public function GuardarTarea(){
        $tarea = new Tarea();

        $tarea->TareaNombre = $_REQUEST['TxtTareaNombre'];
        $tarea->TareaId = $_REQUEST['TareaId'];

        $tarea->TareaId > 0
            ? $this->model->ActualizarTarea($tarea)
            : $this->model->RegistrarTarea($tarea);

        header("Location: index.php");
    }
    public function DeshabilitarTarea(){
      $tarea = new Tarea();

      $tarea->TareaId = $_REQUEST['TareaId'];
      $tarea->TareaActivo = 0;

        $this->model->DeshabilitarTar($tarea);

      header("Location: index.php");
    }


    //---------- codigo viejo --------------


}
