<?php
    session_start();
    if(!isset($_SESSION['usuario_id'])){
      header('Location: ../login/index.php');
    }

    date_default_timezone_set("America/Buenos_Aires");
  //setlocale(LC_ALL,"es_ES");
  setlocale(LC_ALL, 'es_ES.UTF8');
  //setlocale(LC_TIME, "es_RA.UTF-8");
  setlocale(LC_TIME, 'es_ES.utf-8','spanish');
  //setlocale('es_ES.UTF-8'); // I'm french !
    //setlocale('es_ES.UTF-8'); // I'm french !
$id = $_GET['Id'];
$recibosdatos= $this->model->ListarRecibo($id);
$recibosdatos_emp= $this->model->JubiladoObtenerLeg($id);
$cantidadrecibos=count($recibosdatos);
$per=$this->model->CJMDGPeriodoObtener();

?>

<div class="row">
  	<div class="col-md-12">
    	<div id="no-more-tables">
      		<div class="table-wrapper-scroll-y my-custom-scrollbar">
      			<div class="row">

						<table class="data-table table-bordered stripe hover nowrap">
						<tr>
							<th><?php echo "REPARTICION  CAJA DE JUBILACIONES Y PENSIONES DE LA MUNICIPALIDAD DE GUALEGUAY" . "<br>". "DOMICILIO 1er.ENTRERRIANO N° 90 - GUALEGUAY -  ENTRE RIOS " ; ?></th>
	             <th><?php echo "<br>"."C.U.I.L. N° 33-67105652-9"; ?></th>
						</tr>
						</table>
						<table class="data-table table-bordered stripe hover ">
						<tr>
							<th><?php echo "APELLIDO Y NOMBRE"; ?></th>
							<th><?php echo "LEGAJO";  ?></th>
							<th><?php echo "FECHA INGRESO"; ?></th>
              <th><?php echo "RECIBO N°"; ?></th>
						</tr>
						<tr>
							<th><?php echo $recibosdatos_emp->legajo_apellido . " " . $recibosdatos_emp->legajo_nombres; ?></th>
							<th><?php echo $recibosdatos_emp->legajo_id;  ?></th>
      				<th><?php $fec=new datetime($recibosdatos_emp->legajo_fecing); echo $fec_pantalla=$fec->format('d/m/Y');?></th>
              <th><?php echo $recibosdatos_emp->legajo_id; ?></th>
						</tr>
          </table>
          	<table class="data-table table-bordered stripe hover ">
              <tr>
                <th><?php echo "BENEFICIO"; ?></th>
                <th><?php echo "TIPO Y N° DOCUMENTO";  ?></th>
                <th><?php echo "MES DE PAGO"; ?></th>
              </tr>
              <tr>
                <th><?php echo $recibosdatos_emp->legajo_tipo_nombre; ?></th>
                <th><?php echo $recibosdatos_emp->doctipo_abreviacion.":".$recibosdatos_emp->legajo_nrodocto;  ?></th>
                <th><?php echo strftime("%B", strtotime($per->periodo_hsext_jor_f)); ?></th>
              </tr>
              <tr>
               <th style="border: 0px solid;" align="center"><strong></strong></th>
                <th style="border: 0px solid;" align="center"><strong>N° CUENTA</strong></th>
                <th style="border: 0px solid;" align="center"><strong>FECHA DE PAGO</strong></th>
              </tr>
              <tr>
                <th></th>
                <th style="border: 0px solid;" align="center"><strong><?php echo $recibosdatos_emp->sucursal."-".$recibosdatos_emp->numero_cuenta; ?></strong></th>
                <th style="border: 0px solid;" align="center"><strong><?php echo date("t-m-Y", strtotime("$per->periodo_hsext_jor_f")); ?></strong></th>
              </tr>
						</table>
						<table class="data-table table-bordered stripe hover nowrap">
						<thead>
						<tr>
							<th>COD</th>
							<th>DESCRIPCION DE CONCEPTOS</th>
					  	<th>REMUNERACIONES EXENTAS</th>
              <th>DESCUENTOS</th>
						</tr>
						</thead>
						<tbody>
              <?php
                if($cantidadrecibos!=0){?>
                  <?php $pos=0;$neg=0;
                  foreach($recibosdatos as $row):
                  if($row->liqcod_jub_id==600){$pos=$row->liq_det_importe;}
                  if($row->liqcod_jub_id==601){$neg=$row->liq_det_importe;}
                  if($row->liqcod_jub_id<>600 AND $row->liqcod_jub_id<>601){ ?>
                      <tr>
                        <td><?php echo $row->liqcod_jub_id ; ?></td>
                        <td><?php echo $row->liq_det_detconcep;?></td>
                        <td><?php if($row->impacto=='+'){echo $row->liq_det_importe;}; ?></td>
                        <td><?php if($row->impacto=='-'){echo '-'.$row->liq_det_importe;};?></td>
                      </tr>
                    <?php } endforeach;?>
                    <tr>
                        <th></th>
                        <th><?php echo "TOTALES";?></th>
                        <th align="right"><?php echo $pos; ?></th>
                        <th align="right"><?php echo $neg; ?></th>
                    </tr>
                <tr>
                    <th></th>
                    <th></th>
                    <th align="right"><?php echo "TOTAL NETO"; ?></th>
                    <th><?php echo $pos-$neg; ?></th>
              </tr>
             <?php } ?>
						</tbody>
						</table>

				</div>
     		</div>
   		</div>
  	</div>
</div>
