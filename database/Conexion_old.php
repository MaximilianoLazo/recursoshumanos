<?php

class Conexion{
  public static function getConnection(){
    $pdo = new PDO('mysql:host=10.2.0.26;dbname=recursoshumanos', 'adminsistemas', 'Sistemas2020');
    //$pdo = new PDO('mysql:host=localhost;dbname=recursoshumanos', 'root', '');
    //$pdo = new PDO('mysql:host=localhost;dbname=rrhhmigracion', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $pdo->setAttribute(PDO::ATTR_PERSISTENT,true);
    $pdo->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES 'utf8'");
    return $pdo;
  }
}

?>
