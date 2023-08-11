<?php
require_once 'model/login.php';
session_start();
if(!isset($_SESSION["usuario_id"])){
  header("../legajos/login/index.php");
}
class LoginController{

    private $model;

    public function __CONSTRUCT(){
        $this->model = new Login();
    }

    public function Index(){
      require_once 'view/login.php';
    }
    public function ListadoDeUsuarios(){
      require_once 'view/usuario.php';
    }
    public function UsuariosListado(){
      require_once 'view/usuario.php';
    }
    public function RecuperarClave(){
      require_once 'view/usuario-recupera-clave.php';
    }
    public function UsuarioCambiaClave(){

      if(empty($_REQUEST['id']) AND empty($_REQUEST['token'])){
        exit;
      }

      $user_id = $_REQUEST['id'];
      $token = $_REQUEST['token'];

      if(!$this->model->verificaTokenPass($user_id, $token)){
        echo 'No se pudo verificar los Datos';
        exit;
      }

      require_once 'view/usuario-cambia-clave.php';

    }
    public function UsuarioRecuperarClave(){
        require_once 'view/usuario-recupera-clave.php';
    }
    public function UsuarioClaveGuardar(){

      $user_id = $_POST['user_id'];
      $token = $_POST['token'];
      $password = $_POST['password'];
      $con_password = $_POST['con_password'];


    	if($this->model->validaPassword($password, $con_password)){

    		$pass_hash = $this->model->hashPassword($password);

    		if($this->model->cambiaPassword($pass_hash, $user_id, $token)){
    			echo "Contrase&ntilde;a Modificada <br> <a href='index.php' >Iniciar Sesion</a>";
    		}else{
    			echo "Error al modificar contrase&ntilde;a";
    		}

    	}else{
    		echo 'Las contraseñas no coinciden';
    	}

    }

}
