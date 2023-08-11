<?php

error_reporting(0);
session_start();
if(!isset($_SESSION['usuario_id'])){
  header('Location: ../login/index.php');
}

$nrodocto = $_POST["NroDocto"];
$licenciaid = $_POST["LicenciaId"];
$fechainicio = $_POST["FechaI"];
$fechafinal = $_POST["FechaF"];

$periodoi = strtotime("$fechainicio");
$periodof = strtotime("$fechafinal");

date_default_timezone_set("America/Buenos_Aires");
setlocale(LC_ALL, 'es_RA.UTF8');
setlocale(LC_TIME, 'es_RA.utf-8','spanish');

//-----------
$fecha_inicio = new DateTime($fechainicio);
$fecha_final = new DateTime("$fechafinal 23:59:59");

$intervalo = '+1 days';
$fecha_intervalo = DateInterval::createFromDateString($intervalo);
$fecha_rango = new DatePeriod($fecha_inicio, $fecha_intervalo, $fecha_final);
//----------
$fechai = new DateTime($fechainicio);
$fechaf = new DateTime($fechafinal);

$diff = $fechai->diff($fechaf);
$licenciadias = $diff->days + 1;

$dliccargadas = $licenciaauto->ObtenerLicenciasRango($nrodocto, $licenciaid, $fechainicio, $fechafinal);
$fecha_liccargadasu = date("d/m/Y", strtotime($dliccargadas->lproceso_fecha));

?>
  <?php
  if($licenciaid > 0){
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
                //for($i=$periodoi; $i<=$periodof; $i+=86400){
                foreach($fecha_rango as $fecha_i){
                  //$fecha = date("m/d/Y", $i);
                  $fecha = $fecha_i->format('m/d/Y');
                  //$fecha_dos = date("d/m/Y", $i);
                  $fecha_dos = $fecha_i->format('d/m/Y');
                  //$fecha_sql = date("Y-m-d", $i);
                  $fecha_sql = $fecha_i->format('Y-m-d');
                  $diaenletras = (iconv('ISO-8859-2', 'UTF-8', strftime("%A", strtotime("$fecha"))));
                  $diaenletras = ucfirst($diaenletras);
                  //$dliccargadas = $licenciaauto->ObtenerLicenciasCargadas($nrodocto, $fecha_sql);
                ?>
                <tr>
                  <td style="font-size: 12px;" data-title="Fecha:"><?php echo $diaenletras." ".$fecha_dos; ?></td>
                  <td style="font-size: 12px; text-align: right;" data-title="Licencias/C:"><?php echo $dliccargadas->licc; ?></td>
                </tr>
                <?php
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
        if($licenciaid > 0){
          if($fechafinal >= $fechainicio){
            if($dliccargadas->licrangc > 0){
              ?>
              <div class="alert alert-danger" role="alert" style="font-size: 12px;">
                <?php echo "La licencia <strong>".$dliccargadas->licencia_nombre."</strong> fue cargada el día <strong>".$fecha_liccargadasu."</strong>"; ?>
              </div>
              <?php
            }else{
              ?>
              <div class="alert alert-success" role="alert" style="font-size: 12px;">
                <?php echo "Procesar ".$licenciadias." día/s de licencia/s..." ?>
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
        }else{
          ?>
          <div class="alert alert-danger" role="alert" style="font-size: 12px;">
            Seleccione tipo de licencia para de continuar...
          </div>
          <?php
        }
      ?>
  	</div>
  </div>
  <form id="" action="?c=licencia&a=GuardarLicencia" method="POST" enctype="multipart/form-data">
  <div class="col-md-12">
  	<div class="form-group">
      <input type="hidden" class="form-control" id="txtnrodocto" name="txtnrodocto" value="<?php echo $nrodocto; ?>">
      <input type="hidden" class="form-control" id="txtlicenciaid" name="txtlicenciaid" value="<?php echo $licenciaid; ?>">
      <input type="hidden" class="form-control" id="txtfechainicio" name="txtfechainicio" value="<?php echo $fechainicio; ?>">
      <input type="hidden" class="form-control" id="txtfechafinal" name="txtfechafinal" value="<?php echo $fechafinal; ?>">
      <?php
      if($licenciaid > 0){
        if($fechafinal >= $fechainicio){
          if($dliccargadas->licrangc > 0){
            ?>
            <button type="submit" class="btn btn-secondary" disabled>Guardar LICENCIA</button>
            <?php
          }else{
            ?>
            <button type="submit" class="btn btn-primary">Guardar LICENCIA</button>
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
