<?php
require_once 'model/escuela.php';

 	session_start();
	if(!isset($_SESSION["usuario_id"])){
		header("../legajos/login/index.php");
	}

class EscuelaController{

    private $model;

    public function __CONSTRUCT(){
        $this->model = new Escuela();
    }

    public function Index(){
        require_once 'view/escuela.php';
    }
    public function GuardarE(){
        $escuela = new Escuela();

        $escuela->Id = $_REQUEST['escuelaid'];
        $escuela->Escnombre = $_REQUEST['escuelanombre'];
        $escuela->Escnro = $_REQUEST['escuelanro'];
        $escuela->Escdireccion = $_REQUEST['escueladireccion'];
        $escuela->Escdirecnro = $_REQUEST['escueladirecnro'];
        $escuela->Escdirecpiso = $_REQUEST['escueladirecpiso'];
        $escuela->Esccpostal = $_REQUEST['escuelacpostal'];
        $escuela->Esctelefono = $_REQUEST['escuelatelefono'];
        $escuela->Escemail = $_REQUEST['escuelaemail'];
        $escuela->Escpais = $_REQUEST['escuelapais'];
        $escuela->Escprovincia = $_REQUEST['escuelaprovincia'];
        $escuela->Escdepartamento = $_REQUEST['escueladepartamento'];
        $escuela->Esclocalidad = $_REQUEST['escuelalocalidad'];
        $escuela->Activo = 1;

        $escuela->Id > 0
            ? $this->model->ActualizarE($escuela)
            : $this->model->RegistrarE($escuela);

        header("Location: index.php");
    }
    public function DeshabilitarE(){
        $escuela = new Escuela();

        $escuela->Id = $_REQUEST['escuelaid'];
        $escuela->Activo = 0;

        $this->model->DeshabilitarEsc($escuela);

        header("Location: index.php");
    }
}
