<?php
error_reporting(0);
session_start();
if(!isset($_SESSION['usuario_id'])){
  header('Location: ../login/index.php');
}
require_once '../../../database/Conexion.php';
require_once '../model/panel.php';

$prueba = new Panel();
?>

      <?php
        exec('c:\WINDOWS\system32\cmd.exe /c START /B C:\xampp\htdocs\controlhorario\itktool\online.bat');
        $lineas = file('../../../itktool/online-respuesta.txt');
        /*
        foreach($lineas as $numero => $linea){
          $dato = explode(" ", $linea);
          //-----Datos a insertar ------
          $ippuerto = explode(":", $dato[0]);
          $ip = $ippuerto[0];
          $nodo = $dato[1];
          $codigoe = $dato[2];
          $accion = "SELECT/PANEL";

            $prueba->RelojesSeg($ip, $nodo, $codigoe, $accion);
        }
        */
      ?>
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th scope="col">Nombre</th>
            <th scope="col">Tipo</th>
            <th scope="col">IP</th>
            <th scope="col">Nodo</th>
            <th scope="col">Empleados</th>
            <th scope="col">Estado</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach($prueba->Relojes() as $row): ?>
        <?php
            foreach($lineas as $numero => $linea) {
              $dato = explode(" ", $linea);

              $ip = explode(":", $dato[0]);
              if($ip[0] == $row->reloj_ip && $dato[2] == 1){
                $estado = 1;
              }elseif($ip[0] == $row->reloj_ip && $dato[2] == 1014){
                $estado = 0;
              }else{

              }
            }

        ?>
          <tr>
            <th scope="row"><?php echo $row->reloj_nombre; ?></th>
            <th scope="row"><?php echo $row->relojtipo_nombre; ?></th>
            <th scope="row"><?php echo $row->reloj_ip; ?></th>
            <th scope="row"><?php echo $row->reloj_nodo; ?></th>
            <th scope="row"><?php echo $row->empleados; ?></th>
            <th scope="row">
              <?php
                if($estado == 1){
                  ?>
                    <span class="badge badge-success">En linea</span>
                  <?php
                }elseif($estado == 0){
                  ?>
                    <span class="badge badge-danger">Fuera de Linea</span>
                  <?php
                }else{

                }
              ?>
            </th>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
