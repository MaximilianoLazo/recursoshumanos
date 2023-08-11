<form id="frm-conyugeagregar" action="?c=liquidacion&a=ReciboDescargarPrueba" method="post" enctype="multipart/form-data">
<div class="modal fade bd-example-modal-lg" id="dataTableViewRecibo" name="dataTableViewRecibo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog modal-lg" role="document">
						<div class="modal-content">
										<div class="modal-header">
											<h4 class="modal-title" id="exampleModalLabel"></h4>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										</div>
										<div class="modal-body">
										<input type="hidden" id="reciboiddos" name="reciboiddos">

										<div class="col-md-8">
							</div>
              <div id="tabladatorecibo">
                <?php
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

                              <th><?php  $fec=new datetime($recibosdatos_emp->legajo_fecing); echo $fec_pantalla=$fec->format('d/m/Y');?></th>
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
                                <th><?php $m=new datetime($per->periodo_hsext_jor_f); echo $m->format('F'); ?></th>
                              </tr>
                              <tr>
                                <th><?php echo "BENEFICIO otr"; ?></th>
                                <th><?php echo "TIPO Y N° DOCUMENTO"; ?></th>
                                <th><?php echo "MES DE PAGO"; ?></th>
                              </tr>
                              <tr>
                                <th><?php echo $recibosdatos_emp->legajo_tipo_nombre; ?></th>
                                <th><?php echo $recibosdatos_emp->doctipo_abreviacion.":".$recibosdatos_emp->legajo_nrodocto;  ?></th>
                                <th><?php $m=new datetime($per->periodo_hsext_jor_f); echo $m->format('F'); ?></th>
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
                                  foreach($recibosdatos as $row):        ?>
                                      <tr>
                                        <td><?php echo $row->liqcod_jub_id ; ?></td>
                                        <td><?php echo $row->liq_det_detconcep;?></td>
                                        <td><?php if($row->impacto=='+'){echo $row->liq_det_importe; }   ?></td>
                                        <td><?php if($row->impacto=='-'){echo '-'.$row->liq_det_importe;}?></td>
                                      </tr>
                                  <?php endforeach;?>
                                 <tr>
                                     <th></th>
                                     <th align="right"><?php echo "SUBTOTALES"; ?></th>
                                     <th><?php if($row->liqcod_jub_id==600){echo $row->liq_det_importe;$pos=$row->liq_det_importe;} //if($rem!=0){echo $rem;} ?></th>
                                     <th><?php if($row->liqcod_jub_id==601){echo $row->liq_det_importe;$neg=$row->liq_det_importe;}//if($desc!=0){echo $desc;} ?></th>
                                 </tr>
                               <tr>
                                   <th></th>
                                   <th></th>
                                   <th align="right"><?php echo "TOTAL"; ?></th>
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
              </div>
              </div>

				<div class="modal-footer">
					<button type="button" class="btn btn-success">CSV</button>
          <button type="button" class="btn btn-danger" id="BtnImprimirPases">PDF</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				</div>
		</div>
  </div>
</div>
</form>
