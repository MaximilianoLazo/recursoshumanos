<?php
require_once 'model/panel.php';
session_start();
if(!isset($_SESSION["usuario_id"])){
  header('Location: ../login/?c=login&a=Index');
}

class PanelController{

  private $model;

  public function __CONSTRUCT(){
      $this->model = new Panel();
  }
  public function Index(){
    require_once 'view/panel.php';
  }

}
