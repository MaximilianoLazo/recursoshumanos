
<?php

error_reporting(0);
session_start();
if(!isset($_SESSION['usuario_id'])){
  header('Location: ../login/index.php');
}
require_once '../../../database/Conexion.php';
require_once '../model/marcacion.php';

$marcacion = new Marcacion();

?>

      <?php
        /*
        exec('c:\WINDOWS\system32\cmd.exe /c START /B C:\xampp\htdocs\controlhorario\itktool\online.bat');
        $lineas = file('../../../itktool/online-respuesta.txt');
        */
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
        //----- datos extraidos
        //setlocale(LC_ALL,"es_ES");
        setlocale(LC_ALL, 'es_RA.UTF8');
        //setlocale(LC_TIME, "es_RA.UTF-8");
        setlocale(LC_TIME, 'es_RA.utf-8','spanish');
        //setlocale('es_ES.UTF-8'); // I'm french !
        $nrodocto = $_POST["NroDocto"];
        $fechai = $_POST["FechaI"];
        $fechaf = $_POST["FechaF"];
        //----- calculo para rango de fecahs ----
        $date_start = new DateTime($fechai);
        $date_end = new DateTime("$fechaf 23:59:59");

        $interval = '+1 days';
        $date_interval = DateInterval::createFromDateString($interval);

        $period = new DatePeriod($date_start, $date_interval, $date_end);


      ?>

      <table class="table table-striped table-hover" border="1">
        <thead>
          <tr>
            <th scope="col">Fecha</th>
            <th scope="col">Reloj</th>
            <th scope="col">Entrada</th>
            <th scope="col">Salida</th>
            <th scope="col">Entrada</th>
            <th scope="col">Salida</th>
            <th scope="col">Entrada</th>
            <th scope="col">Salida</th>
            <th scope="col">Novedad</th>
          </tr>
        </thead>
        <tbody>

          <?php foreach($period as $dt): ?>
        <?php
          $fecha = $dt->format('m/d/Y');
          $fechasql = $dt->format('Y-m-d');

        ?>
          <tr>
            <td scope="row"><?php echo (iconv('ISO-8859-2', 'UTF-8', strftime("%a %d/%m/%Y", strtotime("$fecha")))); ?></td>
            <td scope="row"><?php echo $fechasql; ?></td>

              <?php
                $row = $marcacion->ObtenerLicencia($fechasql, $nrodocto);
                if($row > 0){
              ?>
            <td colspan="6" scope="row">
              Tiene Licencia
            </td>
            <td>
              <?php
                  echo $row->licencia_nombre;
              ?>
            </td>
              <?php
                }else{
                $row = $marcacion->ObtenerFeriado($fechasql);
                if($row > 0){
              ?>
            <td colspan="6" scope="row">
              Día Feriado
            </td>
            <td>
              <?php
                  echo $row->feriado_observacion;
              ?>
            </td>
              <?php
                }else{
                $row = $marcacion->ObtenerExcepcion($fechasql, $nrodocto);
                if($row > 0){
                  ?>
                <td scope="row">
                  <?php
                    echo $row->excepcion_horai;
                  ?>
                </td>
                <td scope="row">
                  <?php
                    echo $row->excepcion_horaf;
                  ?>
                </td>
                <td colspan="4" scope="row">

                </td>
                <td>
                  Excepcion
                </td>
                  <?php

                }else{
                $row = $marcacion->ObtenerFichada($fechasql, $nrodocto);
                if($row > 0){
                  ?>
                <td scope="row">
                  <?php
                    //echo date_format($row->marcacion_datetime, 'Y-m-d H:i:s');
                    //echo $row->marcacion_datetime;

                    //$originalDate = "2017-03-08";
                    $hora = date("H:i", strtotime($row->marcacion_datetime));
                    echo $hora;
                  ?>
                </td>
                <td colspan="5" scope="row">

                </td>
                <td>
                  Si ficho
                </td>
                  <?php

                }else{
                  ?>
                <td colspan="6" scope="row">
                </td>
                <td>
                  <?php
                      echo "NO Ficho";
                  ?>
                </td>
                  <?php
                }
                }
                }
                }
              ?>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>

<?php

?>
