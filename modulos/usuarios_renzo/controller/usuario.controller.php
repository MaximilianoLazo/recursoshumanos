<?php
require_once 'model/usuario.php';
error_reporting(0);
session_start();
if (!isset($_SESSION["usuario_id"])) {
  header('Location: ../login/?c=login&a=Index');
}

class UsuarioController
{

  private $model;

  public function __CONSTRUCT()
  {
    $this->model = new Usuario();
  }
  public function Index()
  {
    require_once 'view/usuarios.php';
  }

  public function UsuarioGuardar()
  {
    $usrg = new Usuario();

    $usrg->UsuarioId = $_REQUEST['hddusuarioid'];
    $usrg->Usuario = $_REQUEST['txtusuario'];
    $usrg->UsuarioTipo = $_REQUEST['cbousuariotipo'];
    //DNI
    $usrg->UsuarioDNI = 0;
    //APELLIDO
    $usrg->UsuarioApellido = "";
    //NOMBRES
    $usrg->UsuarioNombres = "";
    //EMAIL
    $usrg->UsuarioEmail = "";
    //PASS
    $usrg->UsuarioPass = $this->model->hashPassword($usrg->Usuario);
    //TOKEN
    $usrg->UsuarioToken = "";
    //ULTSESION
    $usrg->UsuarioLastSession = "0000-00-00";
    //TOKENPASS
    $usrg->UsuarioTokenPass = "";
    //PASSREQUEST
    $usrg->UsuarioPassRequest = 0;
    //ESTADO
    $usrg->UsuarioEstado = 1;


    if ($usrg->UsuarioId > 0) {
      //----MODIFICACION DE USUARIO
      $this->model->UsuarioActualizar($usrg);
    } else {
      //----NUEVO USUARIO
      $this->model->UsuarioGuardarExe($usrg);
    }

    header("Location: index.php?c=usuario&a=Index");
  }
  public function UsuarioPerfil()
  {
    $usuario_datos = $this->model->UsuarioObtener_ID($_SESSION['usuario_id']);
    $usuario_tipo_datos = $this->model->UsuarioTipoObtener($usuario_datos->usuario_tipo_id);
    require_once 'view/usuario-perfil.php';
  }
  public function ClaveVerificar()
  {
    require_once 'includes/php/usuario-clave-verificar.php';
  }
  public function UsuarioCambiarClave()
  {
    //echo "LLEGO";
    //require_once 'includes/php/usuario-clave-verificar.php';
    $usuario_id = $_REQUEST['UsuarioId'];
    $clave = $_REQUEST['Clave'];

    $clave_hash = $this->model->hashPassword($clave);

    $this->model->UsuarioCambiarClaveExe($usuario_id, $clave_hash);

    $response = array(
      'respuesta' => 1
    );
    echo json_encode($response);
  }
  public function UsuarioBaja()
  {

    $usrb = new Usuario();
    //-------Variables enviadas
    $usrb->UsuarioId = $_REQUEST['hddusuarioidbaja'];
    $usrb->UsurioDescBaja = $_REQUEST['txtusuariobobs'];
    $usrb->UsuarioEstado = 0;

    $this->model->UsuarioBajaExe($usrb);

    header("Location: index.php?c=usuario&a=Index");
  }
  public function UsuarioHabilitar()
  {

    $usrh = new Usuario();
    //-------Variables enviadas
    $usrh->UsuarioId = $_REQUEST['hddusuarioidhab'];
    $usrh->UsuarioEstado = 1;

    $this->model->UsuarioHabilitarExe($usrh);

    header("Location: index.php?c=usuario&a=Index");
  }
  public function UsuarioClaveResetear()
  {
    $usrr = new Usuario();

    $usrr->UsuarioId = $_REQUEST['hddusuarioidres'];
    $usrr->UsuarioNombre = $_REQUEST['hddusuariores'];

    $usrr->UsuarioPass = $this->model->hashPassword($usrr->UsuarioNombre);

    $this->model->UsuarioCambiarClaveExe($usrr->UsuarioId, $usrr->UsuarioPass);


    header("Location: index.php?c=usuario&a=Index");
  }
}
