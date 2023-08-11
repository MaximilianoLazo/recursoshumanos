<?php
class Importacion{

	public function __CONSTRUCT(){
		try{
			$this->cn = Conexion::getConnection();
			//$this->cnw = Conexion::getConnectionw();
		}
		catch(Exception $e){
			die($e->getMessage());
		}
	}
	public function __DESTRUCT(){
		//$db;
		$this->cn;
	}

	public function ListarSueldos($periodo){
		try{
			$sql = 'SELECT * FROM legajos a,cjmdg_cabsueldo b,cjmdg_detsueldo c, liquidaciones_codigo_jub d
							WHERE a.cjmdg_personal_nroleg2=b.cjmdg_cabsueldo_nroleg2
							AND b.cjmdg_cabsueldo_nroleg2=c.cjmdg_detsueldo_nroleg
							AND b.periodo_id=c.periodo_id
							AND b.periodo_id=?
							AND c.cjmdg_detsueldo_codconcep=d.liqcod_jub_id
							ORDER BY legajo_apellido,impacto
						  ';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $periodo, PDO::PARAM_STR);
			$dec->execute();

			return $dec->fetchAll(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ListarFondo($periodo){
		try{
			$sql = 'SELECT * FROM cjmdg_fondo
					where periodo_id=?
						  ';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $periodo, PDO::PARAM_STR);
			$dec->execute();

			return $dec->fetchAll(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ListarPeriodos(){
		try{
			$sql = 'SELECT * FROM periodos
						  ';

			$dec = $this->cn->prepare($sql);
			$dec->execute();

			return $dec->fetchAll(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function CJMDGPeriodoObtener(){
		try{
			$sql = $this->cn->prepare("SELECT * FROM periodos
																WHERE periodo_activo=1
																AND periodo_cerrado=0
																ORDER BY periodo_id DESC LIMIT 1");
			$sql->execute();
			return $sql->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}

	public function CJMDGLiquidoTotalesPositivos($per){
		try{
			$sql = "INSERT INTO liq_det_tmp(liqcod_jub_id,liq_det_importe,legajo_id,periodo_id,liq_det_detconcep)
						(SELECT 600,SUM(IF(cjmdg_detsueldo_codconcep < 100 OR cjmdg_detsueldo_codconcep = 212,cjmdg_detsueldo_importe,0)) positivo,cjmdg_detsueldo_nroleg,:periodo,:leyenda FROM cjmdg_detsueldo
						GROUP BY cjmdg_detsueldo_nroleg)";

      $dec = $this->cn->prepare($sql);
			$dec->bindValue(':periodo', $per, PDO::PARAM_STR);
			$dec->bindValue(':leyenda', "SUBTOTAL POSITIVO", PDO::PARAM_STR);

			$dec->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}

	public function CJMDGLiquidoTotalesNegativos($per){
		try{
			$sql ="INSERT INTO liq_det_tmp(liqcod_jub_id,liq_det_importe,legajo_id,periodo_id,liq_det_detconcep)
						(SELECT 600,SUM(IF(cjmdg_detsueldo_codconcep > 100,cjmdg_detsueldo_importe,0))*-1 negativo,cjmdg_detsueldo_nroleg,:periodo,:leyenda2 FROM cjmdg_detsueldo
						GROUP BY cjmdg_detsueldo_nroleg)";
					  $dec = $this->cn->prepare($sql);	
				$dec->bindValue(':periodo', $per, PDO::PARAM_STR);
				$dec->bindValue(':leyenda2', "SUBTOTAL NEGATIVO", PDO::PARAM_STR);
			$dec->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}


	public function CJMDGPersonalObtener(){
		try{
			$sql = $this->cn->prepare("SELECT *
																	 FROM cjmdg_personal");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function LegajoObtener($doc){
		try{
			$sql ="SELECT legajo_id FROM legajos
			WHERE legajo_nrodocto=?
              ";

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $doc, PDO::PARAM_STR);

			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}

/*falta agregar el periodo */
	public function PeriodoObtener($per){
		try{
			$sql = $this->cn->prepare("SELECT *
																 FROM periodos
																WHERE periodo_id=?
															 ");
			$sql->bindValue(1, $per, PDO::PARAM_STR);
			$sql->execute();
			return $sql->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}

	public function PeriodoObtenerNuevo(){
		try{
			$sql = $this->cn->prepare("SELECT *
										FROM periodos
										WHERE periodo_cerrado=0
										AND periodo_activo=1
										");

			$sql->execute();
			return $sql->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}

	public function CJMDGLiquidoCabImportarFondo($legajo,$imp,$doc,$per){
		try{
			$sql = 'INSERT INTO cjmdg_fondo(cjmdg_nroleg,
											cjmdg_importe,
											cjmdg_nrodoc,
											periodo_id
											 )
											VALUES(:leg,
											       :importe,
												   :doc,
												   :per)';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(':leg', $legajo, PDO::PARAM_STR);
			$dec->bindValue(':importe', $imp, PDO::PARAM_STR);
			$dec->bindValue(':doc', $doc, PDO::PARAM_STR);
			$dec->bindValue(':per', $per, PDO::PARAM_STR);
			$dec->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}


	public function CJMDGCategoriaImportar($cat){
		try{

			$sqljub = $this->cn->prepare("SELECT categoria_jub_id
			FROM categoria_jub
			WHERE categoria_jub_ant=?
			");
			$sqljub->bindValue(1, $cat, PDO::PARAM_STR);
			$sqljub->execute();
			return $sqljub->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}

	public function CJMDGLiquidoCabImportar($cat,$num,$per,$categoria_id){
		try{

			$sql = 'INSERT INTO cjmdg_cabsueldo(cjmdg_cabsueldo_catjub,
												cjmdg_cabsueldo_nroleg2,
												periodo_id,
												categoria_jub_id
												)
										VALUES(:cat,
											   :legajo2,
											   :periodo,
	 										   :categoria)';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(':cat', $cat, PDO::PARAM_STR);
			$dec->bindValue(':legajo2', $num, PDO::PARAM_STR);
			$dec->bindValue(':periodo', $per, PDO::PARAM_STR);
			$dec->bindValue(':categoria', $categoria_id, PDO::PARAM_STR);

			$dec->execute();


		}catch (Exception $e){
			die($e->getMessage());
		}
	}

	public function CJMDGLiquidoDetImportar($data,$per){
		try{

			$sql = 'INSERT INTO cjmdg_detsueldo(cjmdg_detsueldo_codconcep,
																					cjmdg_detsueldo_detconcep,
																					 cjmdg_detsueldo_nroleg,
																					 cjmdg_detsueldo_importe,
																					 periodo_id
																					 )
																		VALUES(:codconcep,
																					 :detconcep,
																					 :id,
																					 :importe,
																					 :periodo
																					 )';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(':codconcep', $data->codigo, PDO::PARAM_STR);
			$dec->bindValue(':detconcep', $data->nombrecod, PDO::PARAM_STR);
			$dec->bindValue(':id', $data->leg2, PDO::PARAM_STR);
			$dec->bindValue(':importe', $data->importe, PDO::PARAM_STR);
			$dec->bindValue(':periodo', $per, PDO::PARAM_STR);

			$dec->execute();

			if ($data->codigo==1){
					$sql = 'INSERT INTO cjmdg_3011(cjmdg_nroleg,
					cjmdg_nroleg2,
					 cjmdg_3011_base,
					  periodo_id
					 )
						VALUES(:nroleg,
									:nroleg2,
									:importe,
									:periodo
									)';
				$dec = $this->cn->prepare($sql);
				$dec->bindValue(':nroleg', $data->leg2, PDO::PARAM_STR);
				$dec->bindValue(':nroleg2', $data->leg2, PDO::PARAM_STR);
				$dec->bindValue(':importe', $data->importe, PDO::PARAM_STR);
				$dec->bindValue(':periodo', $per, PDO::PARAM_STR);

				$dec->execute();
			}


		}catch (Exception $e){
			die($e->getMessage());
		}
	}

	public function JubiladoObtener(){
		try{
			$sql = 'SELECT *
			FROM legajos a,documentos_tipo b,sexos c
			WHERE empresa_id=?
			AND a.tipo_docto_id=b.doctipo_id
			AND a.sexo_id=c.sexo_id
			AND a.jubilado=?
			AND a.legajo_activo=?
			';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, 2, PDO::PARAM_STR);
			$dec->bindValue(2, 1, PDO::PARAM_STR);
			$dec->bindValue(3, 1, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetchAll(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}



							//WHERE d.situacion_revista_fecingreso != "NULL"
							//AND empresa_id=2

	public function JubiladoActivoObtener(){
		try{
			$sql = 'SELECT *
					FROM legajos a,documentos_tipo b,sexos c
					WHERE empresa_id=2
					AND a.tipo_docto_id=b.doctipo_id
					AND a.sexo_id=c.sexo_id
					AND legajo_nojubilado=1

							';
			$dec = $this->cn->prepare($sql);

			$dec->execute();
			return $dec->fetchAll(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}

	public function JubiladoPasivoObtener(){
		try{
			$sql = 'SELECT *
					FROM legajos
					WHERE legajo_activo=1
					AND legajo_nojubilado=0
					AND empresa_id=2';
			$dec = $this->cn->prepare($sql);
			$dec->execute();
			return $dec->fetchAll(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}

	public function JubiladoLey3011Obtener($periodo){
		try{
			$sql = 'SELECT legajo_apellido,legajo_nombres,legajo_nrodocto,legajo_fecnacto,cjmdg_3011_base
			FROM legajos, cjmdg_detsueldo a,cjmdg_3011
			WHERE cjmdg_detsueldo_codconcep=120
			AND cjmdg_personal_nroleg2=cjmdg_detsueldo_nroleg
			AND cjmdg_personal_nroleg2=cjmdg_nroleg2
			AND cjmdg_nroleg2=cjmdg_detsueldo_nroleg
			AND a.periodo_id=?
			AND legajo_activo=?
			ORDER BY legajo_apellido,legajo_nombres';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $periodo, PDO::PARAM_STR);
			$dec->bindValue(2, 1, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetchAll(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}

	public function JubiladoSeguObtener($periodo){
		try{
			$sql = 'SELECT legajo_nrodocto,cjmdg_personal_nroleg,cjmdg_personal_nroleg2,cjmdg_detsueldo_importe,legajo_apellido,legajo_nombres,legajo_fecnacto
					FROM legajos, cjmdg_detsueldo
					WHERE (cjmdg_detsueldo_codconcep=121 OR cjmdg_detsueldo_codconcep=122)
					AND legajo_activo=1
					AND legajo_id=cjmdg_detsueldo_nroleg
					AND periodo_id=?
					ORDER BY legajo_id	';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $periodo, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetchAll(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}

	public function JubiladoBERSAObtener($periodo){
		try{
			$sql = 'SELECT * FROM cjmdg_bersa,cjmdg_detsueldo a
							WHERE cjmdg_detsueldo_nroleg=cjmdg_nroleg2
							AND cjmdg_detsueldo_codconcep=160
							AND a.periodo_id=?
							ORDER BY cjmdg_bersa_orden';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $periodo, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetchAll(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}


	public function JubiladoSueldoObtener($leg,$codigo,$per){
		try{
			$sql = 'SELECT cjmdg_detsueldo_importe FROM cjmdg_detsueldo
							WHERE cjmdg_detsueldo_nroleg=?
							and cjmdg_detsueldo_codconcep=?
							and periodo_id=? ';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $leg, PDO::PARAM_STR);
			$dec->bindValue(2, $codigo, PDO::PARAM_STR);
			$dec->bindValue(3, $per, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}

	public function IOSPERImporteObtener($codigo){
		try{
			$sql = 'SELECT * FROM parametros
							WHERE parametro_id=?
							 ';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $codigo, PDO::PARAM_STR);

			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}

	public function ObtenerDocumento(){
		try{
			$sql = 'SELECT legajo_nrodocto,legajo_id,sexo_id FROM legajos
					 ';
			$dec = $this->cn->prepare($sql);

			$dec->execute();
			return $dec->fetchAll(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}

	public function GrabaCuil($data){
		try{
			$sql = 'UPDATE legajos
							 SET legajo_cuil = ?
							 WHERE legajo_id = ?';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $data->cuit_rearmado, PDO::PARAM_INT);
			$dec->bindValue(2, $data->lega, PDO::PARAM_STR);
			$dec->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}

	public function JubiladoSeguroObtener($leg,$codigo){
		try{
			$sql = 'SELECT cjmdg_detsueldo_importe FROM cjmdg_detsueldo
							WHERE cjmdg_detsueldo_nroleg=?
							and cjmdg_detsueldo_codconcep=? ';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $leg, PDO::PARAM_STR);
			$dec->bindValue(2, $codigo, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetchAll(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}

	public function CJMDGPersonalImportar($data){
		try{

			$sql = 'INSERT INTO bancos_creditos (banco_id,
																				 	 legempleado_numerol,
																				 	 legempleado_nrodocto,
																				 	 legempleado_cuil,
																				 	 periodo_id,
																				 	 bco_credito_importe,
																				 	 bco_credito_cuotas,
																				 	 bco_credito_archivo_nombre,
																				 	 bco_credito_linea_completa,
																					 bco_credito_estado)
																	  VALUES(1,
																				 	 :legempl,
																				 	 :ndoc,
																				 	 :ncuil,
																				 	 :periodo,
																				 	 :bcoimporte,
																				 	 :bcocuotas,
																				 	 :bcoarchnom,
																				 	 :bcolincom,
																				 	 1)';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(':legempl', $data->Bcolegnumerol, PDO::PARAM_STR);
			$dec->bindValue(':ndoc', $data->Bconrodocto, PDO::PARAM_STR);
			$dec->bindValue(':ncuil', $data->Bconrocuil, PDO::PARAM_STR);
			$dec->bindValue(':periodo', $data->Bcoperiodo, PDO::PARAM_STR);
			$dec->bindValue(':bcoimporte', $data->Bcoimporte, PDO::PARAM_STR);
			$dec->bindValue(':bcocuotas', $data->Bcocuotas, PDO::PARAM_STR);
			$dec->bindValue(':bcoarchnom', $data->Bcoarchivonom, PDO::PARAM_STR);
			$dec->bindValue(':bcolincom', $data->Bcolineacompleta, PDO::PARAM_STR);
			$dec->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	////////////////////////////////////////////////


	public function PeriodoActualObtener(){
		try{
			$sql = $this->cn->prepare("SELECT periodo_id,
																				periodo_nombre,
																				periodo_presentismo_f
																	 FROM periodos
																	WHERE periodo_cerrado = 1
															 ORDER BY periodo_id DESC LIMIT 1");
			$sql->execute();
			return $sql->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}


		/* try{
			$sql = $this->cn->prepare("SELECT periodo_id,
																				periodo_nombre,
																				periodo_presentismo_f
																	 FROM periodos
																	WHERE periodo_cerrado = 1
															 ORDER BY periodo_id DESC LIMIT 1");
			$sql->execute();
			return $sql->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		} */
	}


	public function BancoBersaCredImportarExe($data){
		try{

			$sql = 'INSERT INTO bancos_creditos (banco_id,
																				 	 legempleado_numerol,
																				 	 legempleado_nrodocto,
																				 	 legempleado_cuil,
																				 	 periodo_id,
																				 	 bco_credito_importe,
																				 	 bco_credito_cuotas,
																				 	 bco_credito_archivo_nombre,
																				 	 bco_credito_linea_completa,
																					 bco_credito_estado)
																	  VALUES(1,
																				 	 :legempl,
																				 	 :ndoc,
																				 	 :ncuil,
																				 	 :periodo,
																				 	 :bcoimporte,
																				 	 :bcocuotas,
																				 	 :bcoarchnom,
																				 	 :bcolincom,
																				 	 1)';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(':legempl', $data->Bcolegnumerol, PDO::PARAM_STR);
			$dec->bindValue(':ndoc', $data->Bconrodocto, PDO::PARAM_STR);
			$dec->bindValue(':ncuil', $data->Bconrocuil, PDO::PARAM_STR);
			$dec->bindValue(':periodo', $data->Bcoperiodo, PDO::PARAM_STR);
			$dec->bindValue(':bcoimporte', $data->Bcoimporte, PDO::PARAM_STR);
			$dec->bindValue(':bcocuotas', $data->Bcocuotas, PDO::PARAM_STR);
			$dec->bindValue(':bcoarchnom', $data->Bcoarchivonom, PDO::PARAM_STR);
			$dec->bindValue(':bcolincom', $data->Bcolineacompleta, PDO::PARAM_STR);
			$dec->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}


	public function BersaCreditosListar($periodoid){
		try{
			$sql = 'SELECT *
								FROM bancos_creditos
							 WHERE periodo_id = ?
								 AND bco_credito_estado > 0';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $periodoid, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetchAll(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function WaldbottBersaCreditosReset(){
		try{
			$sql = 'UPDATE HORAS
								 SET HORAS82 = ?';
			$dec = $this->cnw->prepare($sql);
			$dec->bindValue(1, 0, PDO::PARAM_INT);
			$dec->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function BersaCreditosPaseALiqExe($data){
		try{
			$sql = 'UPDATE HORAS
								 SET HORAS82 = ?
							 WHERE EMPLEADO = ?';
			$dec = $this->cnw->prepare($sql);
			$dec->bindValue(1, $data->BcoImporte, PDO::PARAM_INT);
			$dec->bindValue(2, $data->Bcolegajo, PDO::PARAM_STR);
			$dec->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	//------------CODIGO VIEJO
	public function ObtenerLiquidacion($nrodocto,$periodoid){
		try{
			$sql = 'SELECT *
								FROM liquidaciones
							 WHERE liquidacion_nrodocto = ?
								 AND periodo_id = ?';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$dec->bindValue(2, $periodoid, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetchAll(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerEmpleado($nrodocto){
		try{
			$sql = 'SELECT legempleado_numerol,
										 legempleado_apellido,
										 legempleado_nombres
								FROM legajos_empleado
							 WHERE legempleado_nrodocto = ?
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerBeneficiario($nrodocto){
		try{
			$sql = 'SELECT leghijo_benapellido,
										 leghijo_bennombres
								FROM legajos_hijo
							 WHERE leghijo_benndoc = ?
					  ORDER BY leghijo_id DESC
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerLiquidacionCodxTipo($liqcodid){
		try{
			$sql = 'SELECT *
								FROM liquidaciones_codigo
							 WHERE liqcodtipo_id = ?
							   AND liqcod_estado = 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $liqcodid, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetchAll(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerLiquidacionCodxId($liqcodid){
		try{
			$sql = 'SELECT *
								FROM liquidaciones_codigo
							 WHERE liqcod_id = ?
							   AND liqcod_estado = 1
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $liqcodid, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function LiquidacionDescuentosExe($data){
		try{

			$sql = 'INSERT INTO liquidaciones (liqtipo_id,
																				 legempleado_nrodocto,
																				 liquidacion_nrodocto,
																				 liquidacion_titular,
																				 liqcod_id,
																				 liqcod_descripcion,
																				 liquidacion_cantidad,
																				 liqcodtipo_id,
																				 liquidacion_importe,
																				 periodo_id,
																				 liquidacion_observacion,
																				 liquidacion_estado)
																	VALUES(5,
																				 :empnrodocto,
																				 :bennrodocto,
																				 :titular,
																				 :liqcod,
																				 :liqdescripcion,
																				 :canttotal,
																				 :liqcodtip,
																				 :imptotal,
																				 :periodoid,
																				 :observacion,
																				 1)';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(':empnrodocto', $data->Liqdescndoc, PDO::PARAM_STR);
			$dec->bindValue(':bennrodocto', $data->Liqdescndoc, PDO::PARAM_STR);
			$dec->bindValue(':titular', $data->Liqdesctitular, PDO::PARAM_STR);
			$dec->bindValue(':liqcod', $data->Liqdesccodigo, PDO::PARAM_STR);
			$dec->bindValue(':liqdescripcion', $data->Liqdesccoddescripcion, PDO::PARAM_STR);
			$dec->bindValue(':canttotal', 1, PDO::PARAM_STR);
			$dec->bindValue(':liqcodtip', $data->Liqdesccodtipo, PDO::PARAM_STR);
			$dec->bindValue(':imptotal', $data->Liqdescimporte, PDO::PARAM_STR);
			$dec->bindValue(':periodoid', $data->Liqdescperiodo, PDO::PARAM_STR);
			$dec->bindValue(':observacion', $data->Liqdescobs, PDO::PARAM_STR);
			$dec->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function EmpleadoXLegajoObtener($legajo_numero){
		try{
			$sql = 'SELECT *
								FROM legajos_empleado
							 WHERE legempleado_numerol = ?
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $legajo_numero, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function LiquidacionesImportarExe($data){
		try{

			$sql = 'INSERT INTO liquidaciones (liqtipo_id,
																				 legempleado_nrodocto,
																				 liquidacion_nrodocto,
																				 legempleado_numerol,
																				 liquidacion_titular,
																				 liqcod_id,
																				 liqcod_descripcion,
																				 liquidacion_cantidad,
																				 liqcodtipo_id,
																				 liquidacion_importe,
																				 periodo_id,
																				 liquidacion_observacion,
																				 liquidacion_estado)
																	VALUES(1,
																				 :empnrodocto,
																				 :bennrodocto,
																				 :legnuml,
																				 1,
																				 :liqcod,
																				 :liqdescripcion,
																				 :canttotal,
																				 :codtipo,
																				 :imptotal,
																				 :periodo,
																				 "",
																				 1)';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(':empnrodocto', $data->Nrodocto, PDO::PARAM_STR);
			$dec->bindValue(':bennrodocto', $data->Nrodocto, PDO::PARAM_STR);
			$dec->bindValue(':legnuml', $data->LegajoNumero, PDO::PARAM_STR);
			$dec->bindValue(':liqcod', $data->Liqcod, PDO::PARAM_STR);
			$dec->bindValue(':liqdescripcion', $data->Liqcoddesc, PDO::PARAM_STR);
			$dec->bindValue(':canttotal', $data->Liqcantidad, PDO::PARAM_STR);
			$dec->bindValue(':codtipo', $data->Liqcodtipo, PDO::PARAM_STR);
			$dec->bindValue(':imptotal', $data->Liqimporte, PDO::PARAM_STR);
			$dec->bindValue(':periodo', $data->PeriodoA, PDO::PARAM_STR);


			$dec->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function SeguroAutarquicoDatos(){
		try{
			$sql = $this->cn->prepare("SELECT *
																	 FROM liquidaciones
																	WHERE (liqcod_id = 351
																		 OR liqcod_id = 352
																		 OR liqcod_id = 378
																		 OR liqcod_id = 382)
															 ORDER BY legempleado_nrodocto");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function IOSPERDatos(){
		try{
			/*$sql = $this->cn->prepare("SELECT *
																	 FROM liquidaciones
																	WHERE (liqcod_id = 351
																		 OR liqcod_id = 352
																		 OR liqcod_id = 378
																		 OR liqcod_id = 382)
															 ORDER BY legempleado_nrodocto");*/
		 	$sql = $this->cn->prepare("SELECT DISTINCT legempleado_nrodocto
																	 					FROM liquidaciones
																					 WHERE liqcod_id = 333");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function LiquidacionEmpleadoDniObtener($periodoid){
		try{
			$sql = 'SELECT DISTINCT legempleado_nrodocto,
															legempleado_numerol
												 FROM liquidaciones
							 				  WHERE periodo_id = ?';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $periodoid, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetchAll(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function SRemunerativoObtener($numdocto){
		try{
			$sql = 'SELECT SUM(liquidacion_importe) AS remunimp
								FROM liquidaciones
							 WHERE legempleado_nrodocto = ?
							 	 AND liqcodtipo_id = 1
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $numdocto, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function SNoRemunerativoObtener($numdocto){
		try{
			$sql = 'SELECT SUM(liquidacion_importe) AS noremunimp
								FROM liquidaciones
							 WHERE legempleado_nrodocto = ?
							 	 AND liqcodtipo_id = 3
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $numdocto, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function DescuentosObtener($numdocto){
		try{
			$sql = 'SELECT SUM(liquidacion_importe) AS descuentosimp
								FROM liquidaciones
							 WHERE legempleado_nrodocto = ?
							 	 AND liqcodtipo_id = 4
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $numdocto, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function SACObtener($numdocto){
		try{
			$sql = 'SELECT liquidacion_importe
								FROM liquidaciones
							 WHERE legempleado_nrodocto = ?
							 	 AND liqcod_id = 188
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $numdocto, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);
			/*$datos = $dec->fetch(PDO::FETCH_OBJ);
			if($datos > 0){
				return $datos;
			}else{
				return 0;
			}*/
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function JubilacionObtener($numdocto){
		try{
			$sql = 'SELECT liquidacion_importe as jubilacionimp
								FROM liquidaciones
							 WHERE legempleado_nrodocto = ?
							 	 AND liqcod_id = 330
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $numdocto, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function EmpleadoObtener($numdocto){
		try{
			$sql = 'SELECT *
								FROM legajos_empleado
							 WHERE legempleado_nrodocto = ?
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $numdocto, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function EmpleadoResumenObtener($numdocto){
		try{
			$sql = 'SELECT legempleado_numerol,
										 legempleado_apellido,
										 legempleado_nombres
								FROM legajos_empleado
							 WHERE legempleado_nrodocto = ?
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $numdocto, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function LiquidacionCodigoObtner($liqcod){
		try{
			$sql = 'SELECT *
								FROM liquidaciones_codigo
							 WHERE liqcod_id = ?
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $liqcod, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function LiquidacionCodigoYDNIObtner($nrodocto, $liqcod){
		try{
			$sql = 'SELECT liquidacion_importe
								FROM liquidaciones
							 WHERE legempleado_nrodocto = ?
							 	 AND liqcod_id = ?
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$dec->bindValue(2, $liqcod, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function LegajoTipoObtener($legtipoid){
		try{
			$sql = 'SELECT legtipo_nombre
								FROM legajos_tipo
							 WHERE legtipo_id = ?
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $legtipoid, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
}
