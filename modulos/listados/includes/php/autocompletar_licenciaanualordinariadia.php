<?php

error_reporting(0);
session_start();
if(!isset($_SESSION['usuario_id'])){
  header('Location: ../login/index.php');
}

require_once '../../../../database/Conexion.php';
require_once '../../model/licencia.php';
$licenciaauto = new Licencia();

$nrodocto = $_POST["NroDocto"];
$licenciaid = $_POST["LicenciaId"];
$fechainicio = $_POST["FechaI"];
$fechafinal = $_POST["FechaF"];
$diasc = null;

$periodoi = strtotime("$fechainicio");
$periodof = strtotime("$fechafinal");

date_default_timezone_set("America/Buenos_Aires");
setlocale(LC_ALL, 'es_RA.UTF8');
setlocale(LC_TIME, 'es_RA.utf-8','spanish');

//-----------
$fecha_inicio = new DateTime($fechainicio);
$fecha_final = new DateTime("$fechafinal 23:59:59");

$intervalo = '+1 days';
//$intervalo = new DateInterval('P1D');
$fecha_intervalo = DateInterval::createFromDateString($intervalo);
$fecha_rango = new DatePeriod($fecha_inicio, $fecha_intervalo, $fecha_final);
//----------
$fechai = new DateTime($fechainicio);
$fechaf = new DateTime($fechafinal);

$diff = $fechai->diff($fechaf);
$licenciadias = $diff->days + 1;

$dliccargadas = $licenciaauto->ObtenerLicenciasAORango($nrodocto, $fechainicio, $fechafinal);
$fecha_liccargadasu = date("d/m/Y", strtotime($dliccargadas->lproceso_fecha));

$laodisponibles = $licenciaauto->ObtenerLicenciasAnualesOrdinariasLibres($nrodocto);
$laodisponiblesc = null;
foreach($laodisponibles as $row){
 $laodisponiblesc = $laodisponiblesc + $row->licanualord_dias_disponibles;
}
$laodisponible = $licenciaauto->ObtenerLicenciaAnualOrdinariaLibre($nrodocto);
$fracciondisp = $laodisponible->licanualord_fracciones_disponibles;
$laodispprim = $laodisponible->licanualord_dias_disponibles;
?>
  <?php
    if($fechafinal >= $fechainicio){
      ?>
      <div class="col-md-12">
        <div id="no-more-tables">
          <div class="table-wrapper-scroll-y-bis my-custom-scrollbar-bis">
            <table class="table table-striped table-hover table-striped">
              <thead>
                <tr>
                  <th style="font-size: 12px;">Fecha</th>
                  <th style="font-size: 12px; text-align: right;">Licencias/C</th>
                </tr>
              </thead>
              <tbody>
                <?php
                foreach($fecha_rango as $fecha_i){
                  $weekDay = $fecha_i->format('N');


                  $fecha_sql = $fecha_i->format('Y-m-d');
                  $feriadodia = $licenciaauto->ObtenerFeriadoDia($fecha_sql);

                  if($weekDay !== '6' && $weekDay !== '7' && !isset($feriadodia->feriado_fecha)){

                    $fecha = $fecha_i->format('m/d/Y');
                    $fecha_dos = $fecha_i->format('d/m/Y');
                    $diaenletras = (iconv('ISO-8859-2', 'UTF-8', strftime("%A", strtotime("$fecha"))));
                    $diaenletras = ucfirst($diaenletras);

                    $diasc = $diasc + 1;
                  ?>
                  <tr>
                    <td style="font-size: 12px;" data-title="Fecha:"><?php echo $diaenletras." ".$fecha_dos; ?></td>
                    <td style="font-size: 12px; text-align: right;" data-title="Licencias/C:"><?php echo $dliccargadas->licc; ?></td>
                </tr>
                <?php

                  echo PHP_EOL;
                  }
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
        <div class="form-group">
        </div>
      </div>
      <?php
    }else{
      ?>
      <div class="col-md-12">
        <div id="no-more-tables">
          <div class="table-wrapper-scroll-y-bis my-custom-scrollbar-bis">
            <table class="table table-striped table-hover table-striped">
              <thead>
                <tr>
                  <th style="font-size: 12px;">-</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="font-size: 12px;" data-title="-"><?php echo "Datos no disponibles..."; ?></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <?php
    }

  ?>
  <div class="col-md-12">
  	<div class="form-group">
      <?php
          if($fechafinal >= $fechainicio){
            if($diasc > 0){
              //--- inicio y final de limite ---
              if($laodisponiblesc >= $diasc){
                if($dliccargadas->licrangc > 0){
                  ?>
                  <div class="alert alert-danger" role="alert" style="font-size: 12px;">
                    <?php echo "La licencia <strong>".$dliccargadas->licencia_nombre."</strong> fue cargada el día <strong>".$fecha_liccargadasu."</strong>"; ?>
                  </div>
                  <?php
                }else{
                  if($fracciondisp > 1){
                    ?>
                    <div class="alert alert-success" role="alert" style="font-size: 12px;">
                      <?php echo "Procesar ".$diasc." día/s de licencia/s..." ?>
                    </div>
                    <?php
                  }else{
                    if($diasc >= $laodispprim){
                      ?>
                      <div class="alert alert-success" role="alert" style="font-size: 12px;">
                        <?php echo "Procesar ".$diasc." día/s de licencia/s..." ?>
                      </div>
                      <?php
                    }else{
                      ?>
                      <div class="alert alert-danger" role="alert" style="font-size: 12px;">
                        <?php echo "La licencia <strong>".$laodisponible->licencia_nombre."</strong> no puede ser Fraccionada"; ?>
                      </div>
                      <?php
                    }
                  }
                }
              //--- inicio y final de limite ---
              }else{
                ?>
                <div class="alert alert-danger" role="alert" style="font-size: 12px;">
                  <?php echo "Los Días Ingresados superan la cantidad de Licencias Disponibles" ?>
                </div>
                <?php
              }
            }else{
              ?>
              <div class="alert alert-danger" role="alert" style="font-size: 12px;">
                Día/s no disponibles
              </div>
              <?php
            }

          }else{
            ?>
            <div class="alert alert-danger" role="alert" style="font-size: 12px;">
              La fecha final debe ser mayor o igual a la fecha de inicio..
            </div>
            <?php
          }
      ?>
  	</div>
  </div>

  <form id="" action="?c=licencia&a=GuardarLicenciaAnualOrdinaria" method="POST" enctype="multipart/form-data">
  <div class="col-md-12">
  	<div class="form-group">
      <input type="hidden" class="form-control" id="txtnrodocto" name="txtnrodocto" value="<?php echo $nrodocto; ?>">
      <!--<input type="hidden" class="form-control" id="txtlicenciaid" name="txtlicenciaid" value="<?php //echo $licenciaid; ?>">-->
      <input type="hidden" class="form-control" id="txtfechainicio" name="txtfechainicio" value="<?php echo $fechainicio; ?>">
      <input type="hidden" class="form-control" id="txtfechafinal" name="txtfechafinal" value="<?php echo $fechafinal; ?>">
      <input type="hidden" class="form-control" id="txtdiaslao" name="txtdiaslao" value="<?php echo $diasc; ?>">
      <?php
        if($fechafinal >= $fechainicio){
          if($diasc > 0){
            if($laodisponiblesc >= $diasc){
              if($dliccargadas->licrangc > 0){
                ?>
                <button type="submit" class="btn btn-secondary" disabled>Guardar LICENCIA</button>
                <?php
              }else{
                if($fracciondisp > 1){
                  ?>
                  <button type="submit" class="btn btn-primary">Guardar LICENCIA</button>
                  <?php
                }else{
                  if($diasc >= $laodispprim){
                    ?>
                    <button type="submit" class="btn btn-primary">Guardar LICENCIA</button>
                    <?php
                  }else{
                    ?>
                    <button type="submit" class="btn btn-secondary" disabled>Guardar LICENCIA</button>
                    <?php
                  }
                }
              }
            }else{
              ?>
              <button type="submit" class="btn btn-secondary" disabled>Guardar LICENCIA</button>
              <?php
            }
          }else{
            ?>
            <button type="submit" class="btn btn-secondary" disabled>Guardar LICENCIA</button>
            <?php
          }
        }else{
          ?>
          <button type="submit" class="btn btn-secondary" disabled>Guardar LICENCIA</button>
          <?php
        }
      ?>
  	</div>
  </div>
</form>
