<?php
class Liquidacion{
	public function __CONSTRUCT(){
		try{
			$this->cn = Conexion::getConnection();
		}catch(Exception $e){
			die($e->getMessage());
		}
	}
	public function __DESTRUCT(){
		$this->cn;
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

	public function CJMDGPeriodoAnteriorObtener(){
		try{
			$sql = $this->cn->prepare("SELECT max(periodo_id),periodo_presentismo_f,periodo_id FROM periodos
																WHERE periodo_id=((select max(periodo_id) from periodos)-1)
																");
			$sql->execute();
			return $sql->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}

	//$this->model->JubNovedadMasivaElimExe($jubliq);

	public function ListarSueldos($periodo){
		try{

			$sql = 'SELECT * FROM legajos a,liq_cab_tmp b,liq_det_tmp c,liquidaciones_codigo_jub d
			WHERE a.legajo_id=b.legajo_id
			AND b.legajo_id=c.legajo_id
			AND b.periodo_id=?
			AND b.empresa_id=2
			AND c.liqcod_jub_id=d.liqcod_jub_id
			ORDER BY a.legajo_id,d.liqcod_jub_id,impacto
			';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $periodo, PDO::PARAM_STR);
			$dec->execute();

			return $dec->fetchAll(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}

	public function ObtenerImporte($per){
		try{
			$sql = 'SELECT * FROM legajos b,liquidaciones_codigo_jub c,legajo_haberjub d
			WHERE c.liqcod_jub_id=1
			AND b.legajo_activo=1
			AND b.empresa_id=2
			AND b.legajo_id=d.legajo_id
			AND d.periodo_id=?
			';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $per, PDO::PARAM_STR);
			$dec->execute();

			return $dec->fetchAll(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}

	public function ObtenerEmpleadosXRecibo($leg){
		try{

			$sql = 'SELECT * FROM legajos a,cjmdg_cabsueldo b,cjmdg_detsueldo c
							WHERE a.legajo_id=b.cjmdg_cabsueldo_nroleg2
							AND b.cjmdg_cabsueldo_nroleg2=c.cjmdg_detsueldo_nroleg
							AND b.periodo_id=c.periodo_id
							AND a.legajo_id=?
						  ';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $leg, PDO::PARAM_STR);
			$dec->execute();

			return $dec->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}

	public function ListarRecibo($leg){
		try{

			$sql = 'SELECT * FROM liq_det_tmp a,liquidaciones_codigo_jub b
							WHERE legajo_id=?
							AND a.liqcod_jub_id=b.liqcod_jub_id
							ORDER BY a.legajo_id,b.liqcod_jub_id,impacto
			 ';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $leg, PDO::PARAM_STR);
			$dec->execute();

			return $dec->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}

	public function ListarReciboxmes($leg,$per){
		try{

			$sql = 'SELECT * FROM liq_det_tmp a,liquidaciones_codigo_jub b
							WHERE legajo_id=?
							AND periodo_id=?
							AND a.liqcod_jub_id=b.liqcod_jub_id
							ORDER BY a.legajo_id,b.liqcod_jub_id,impacto
			 ';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $leg, PDO::PARAM_STR);
			$dec->bindValue(2, $per, PDO::PARAM_STR);
			$dec->execute();

			return $dec->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}

	public function ListarRecibosTodos($leg){
		try{

			$sql = 'SELECT a.periodo_id,periodo_nombre,periodo_hsext_jor_i,periodo_hsext_jor_f
			FROM periodos a,liq_cab_tmp b
			WHERE a.periodo_id=b.periodo_id
			AND b.legajo_id=?
			 ';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $leg, PDO::PARAM_STR);
			$dec->execute();

			return $dec->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}



	public function JubiladoObtenerDoc($doc){
		try{

			$sql = 'SELECT *
							FROM legajos a,obra_social b,documentos_tipo c,legajos_tipos d,legajo_banco e
							WHERE a.legajo_nrodocto= ?
							AND a.legajo_tipo_id=d.legajo_tipo_id
							AND a.legajo_id=e.legajo_id
							AND a.obra_social_id=b.obra_social_id
							AND a.tipo_docto_id =c.doctipo_id
							';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $doc, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}

	public function PeriodoActivoListar(){
		try{

			$sql = "SELECT *
					FROM periodos
					WHERE periodo_cerrado=0
					AND periodo_activo=1
					";
			$dec = $this->cn->prepare($sql);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}

	public function NovedadesJubListar($jub,$per){
		try{

			$sql = "SELECT periodo_id,importe_novedad,a.liqcod_jub_id,b.liqcod_nombre
			FROM liquidacion_novedades a,liquidaciones_codigo_jub b
			WHERE a.liqcod_jub_id=b.liqcod_jub_id
					AND periodo_id=?
					AND a.legajo_id=?
					";

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $per, PDO::PARAM_STR);
			$dec->bindValue(2, $jub, PDO::PARAM_STR);
			$dec->execute();

			return $dec->fetchALL(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}

	public function ListarJubiladosRec(){
		try{

			$sql = "SELECT *
					FROM legajos a,documentos_tipo b, haber_jubilado c
					WHERE empresa_id=2
					AND a.tipo_docto_id=b.doctipo_id
					AND a.jubilado=1
					AND a.legajo_id=c.legajo_id
					";
			$dec = $this->cn->prepare($sql);
			$dec->execute();
			return $dec->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}


	public function PeriodoActual(){
		try{
		$sql = $this->cn->prepare("SELECT * FROM periodos WHERE periodo_cerrado=0");
		$sql->execute();

		return $sql->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function Periodos(){
		try{
		$sql = $this->cn->prepare("SELECT * FROM periodos WHERE periodo_cerrado=1 AND periodo_activo=1 ORDER BY periodo_nombre DESC");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function PeriodosTodosObtener(){
		try{
		$sql = $this->cn->prepare("SELECT * FROM periodos WHERE periodo_activo=1 ORDER BY periodo_nombre DESC");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}


	public function ListarJubilados(){
		try{

			$sql = "SELECT *
					FROM legajos a,documentos_tipo b
					WHERE empresa_id=2
					AND a.tipo_docto_id=b.doctipo_id
					AND a.jubilado=1
					";
			$dec = $this->cn->prepare($sql);
			$dec->execute();
			return $dec->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}

	public function ListarNovedades($per){
		try{


			$sql = "	SELECT a.legajo_id,a.liqcod_jub_id,liqcod_nombre,CONCAT(legajo_apellido,',',legajo_nombres) jubilado,importe_novedad,periodo_id
				FROM liquidacion_novedades a, legajos b, liquidaciones_codigo_jub c
				WHERE periodo_id=?
				AND a.legajo_id=b.legajo_id
				AND a.liqcod_jub_id=c.liqcod_jub_id
					";
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $per, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}

	public function ListarNovedadesTodo(){
		try{

			$sql = "	SELECT *
				FROM liquidaciones_codigo_jub
				order by liqcod_jub_id
					";
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $per, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}

	public function JubiladoTiposListar(){
		try{

			$sql = "SELECT *
							FROM legajos_tipos
							";
			$dec = $this->cn->prepare($sql);
			$dec->execute();
			return $dec->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerNovedades(){
		try{

			$sql = "SELECT *
					FROM liquidaciones_codigo_jub

					";
			$dec = $this->cn->prepare($sql);

			$dec->execute();
			return $dec->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}

	public function UltimoPeriodo(){
		try{

			$sql = 'SELECT *,LEFT(periodo_nombre,4) anio,RIGHT(periodo_nombre,2) mes
						FROM periodos
						WHERE periodo_cerrado=0
						AND periodo_activo=0
						ORDER BY periodo_id DESC
						LIMIT 1
						';
			$dec = $this->cn->prepare($sql);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}


	public function JubiladoObtenerLeg($leg){
		try{

			$sql = 'SELECT *
							FROM legajos a,obra_social b,documentos_tipo c,legajos_tipos d,legajo_banco e
							WHERE a.legajo_id= ?
							AND a.legajo_tipo_id=d.legajo_tipo_id
							AND a.legajo_id=e.legajo_id
							AND a.obra_social_id=b.obra_social_id
							AND a.tipo_docto_id =c.doctipo_id
							';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $leg, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}

	public function LegajosTipo($tipo){
		try{
			$sql = $this->cn->prepare("SELECT a.legajo_id,legajohaber_importe FROM legajos a,legajo_haberjub b
																WHERE a.legajo_id=b.legajo_id and legajo_tipo_id = ? and empresa_id=2 and legajo_activo=1");
			$dec->bindValue(1, $tipo, PDO::PARAM_STR);
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}


public function JubLiqPrevExe($jubliq){
	try{

		$sql = $this->cn->prepare("TRUNCATE liq_cab_tmp");
		$sql->execute();

		$sql = $this->cn->prepare("TRUNCATE liq_det_tmp");
		$sql->execute();

		$sql = $this->cn->prepare("INSERT INTO liq_cab_tmp(legajo_id,categoria_jub_id,periodo_id,empresa_id)(SELECT cjmdg_cabsueldo_nroleg2,cjmdg_cabsueldo_catjub,periodo_id,2 FROM cjmdg_cabsueldo WHERE periodo_id=?)
		");

		$sql->bindValue(1, $jubliq, PDO::PARAM_STR);
		$sql->execute();

		$sql = $this->cn->prepare("INSERT INTO liq_det_tmp(legajo_id,liqcod_jub_id,liq_det_detconcep,liq_det_importe,periodo_id)(SELECT cjmdg_detsueldo_nroleg,cjmdg_detsueldo_codconcep,cjmdg_detsueldo_detconcep,cjmdg_detsueldo_importe,periodo_id FROM cjmdg_detsueldo WHERE periodo_id=?)
		");
		$sql->bindValue(1, $jubliq, PDO::PARAM_STR);
		$sql->execute();

		$nove = Liquidacion::NovedadesPeriodoListar($jubliq);
		foreach($nove as $row){
			$novexjub=Liquidacion::NovedadesPeriodoListarxJub($jubliq,$row->legajo_id,$row->liqcod_jub_id);
			$cantnovxjub=count($novexjub);
			if($cantnovxjub!=0){
					 $sql = 'UPDATE liq_det_tmp
										SET liq_det_importe = ?
										WHERE periodo_id = ?
										and legajo_id = ?';
						$dec = $this->cn->prepare($sql);
						$dec->bindValue(1, $row->importe_novedad, PDO::PARAM_STR);
						$dec->bindValue(2, $jubliq, PDO::PARAM_STR);
						$dec->bindValue(3, $row->legajo_id, PDO::PARAM_STR);

						$dec->execute();
					//update
			}else{
			    $sql=	'INSERT INTO liq_det_tmp(legajo_id,
														liqcod_jub_id,
														liq_det_detconcep,
														liq_det_importe
									 					)
													VALUES(:leg,
													:concep,
													:detconcep,
												  :importe)';
				$dec = $this->cn->prepare($sql);
				$dec->bindValue(':leg', $row->legajo_id, PDO::PARAM_STR);
				$dec->bindValue(':concep', $row->liqcod_jub_id, PDO::PARAM_STR);
				$dec->bindValue(':detconcep', $row->liqcod_nombre, PDO::PARAM_STR);
				$dec->bindValue(':importe', $row->importe_novedad, PDO::PARAM_STR);

				$dec->execute();
				 //insert
			}

		}
		$tot1=Liquidacion::CJMDGLiquidoTotalesPositivos();
		$tot2=Liquidacion::CJMDGLiquidoTotalesNegativos();


	}catch (Exception $e){
		die($e->getMessage());
	}
}

public function JubLiqFinalExe($data){
	try{

		$sql='INSERT INTO liquidaciones_cabecera (legajo_id,categoria_jub_id,periodo_id,empresa_id)(SELECT legajo_id,categoria_jub_id,periodo_id,empresa_id FROM liq_cab_tmp where periodo_id=?)';
		$stm = $this->cn->prepare($sql);
		$stm->bindValue(1, $data->PerioidOld, PDO::PARAM_STR);
		$stm->execute();

		$sql='INSERT INTO liquidaciones_detalle (liq_cab_tmp_id,liqcod_jub_id,liq_det_importe,periodo_id,legajo_id,liq_det_detconcep)(SELECT liq_cab_tmp_id,liqcod_jub_id,liq_det_importe,periodo_id,legajo_id,liq_det_detconcep FROM liq_det_tmp where periodo_id=?)';
		$stm = $this->cn->prepare($sql);
		$stm->bindValue(1, $data->PerioidOld, PDO::PARAM_STR);
		$stm->execute();

		//---Cerrar periodo anterior ----
		$sql = 'UPDATE periodos SET periodo_cerrado = 1 WHERE periodo_id = ?';
		$stm = $this->cn->prepare($sql);
		$stm->bindValue(1, $data->PerioidOld, PDO::PARAM_STR);
		$stm->execute();

		//---Insertar periodo nuevo ----
		$sql = 'INSERT INTO periodos
		(periodo_nombre,periodo_hsext_jor_i,periodo_hsext_jor_f,periodo_presentismo_i,periodo_presentismo_f,periodo_cerrado,periodo_activo)
		VALUES(?, ?, ?, ?, ?, 0, 1)';
		$stm = $this->cn->prepare($sql);
		$stm->bindValue(1, $data->Periodonombre, PDO::PARAM_STR);
		$stm->bindValue(2, $data->PeriodohsiNew, PDO::PARAM_STR);
		$stm->bindValue(3, $data->PeriodohsfNew, PDO::PARAM_STR);
		$stm->bindValue(4, $data->PeriodopreiNew, PDO::PARAM_STR);
		$stm->bindValue(5, $data->PeriodoprefNew, PDO::PARAM_STR);
		$stm->execute();

		/*
		$periodo_anterior=Liquidacion::CJMDGPeriodoAnteriorObtener();

		$sql = $this->cn->prepare("INSERT INTO liq_cab_tmp(legajo_id,categoria_jub_id,periodo_id,empresa_id)(SELECT cjmdg_cabsueldo_nroleg2,cjmdg_cabsueldo_catjub,periodo_id,2 FROM liquidaciones_cabecera WHERE periodo_id=?)
		");

		$sql->bindValue(1, $$periodo_anterior->periodo_id, PDO::PARAM_STR);
		$sql->execute();

		$sql = $this->cn->prepare("INSERT INTO liq_det_tmp(legajo_id,liqcod_jub_id,liq_det_detconcep,liq_det_importe,periodo_id)(SELECT cjmdg_detsueldo_nroleg,cjmdg_detsueldo_codconcep,cjmdg_detsueldo_detconcep,cjmdg_detsueldo_importe,periodo_id FROM liquidaciones_detalle WHERE periodo_id=?)
		");
		$sql->bindValue(1, $periodo_anterior->periodo_id, PDO::PARAM_STR);
		$sql->execute();

		*/

	}catch (Exception $e){
		die($e->getMessage());
	}
}

public function CJMDGLiquidoTotalesPositivos(){
	try{
		$sql = "INSERT INTO liq_det_tmp(liqcod_jub_id,liq_det_importe,legajo_id,periodo_id,liq_det_detconcep)
					(SELECT 600,SUM(IF(cjmdg_detsueldo_codconcep < 100 OR cjmdg_detsueldo_codconcep = 212,cjmdg_detsueldo_importe,0)) positivo,cjmdg_detsueldo_nroleg,periodo_id,:leyenda FROM cjmdg_detsueldo
					GROUP BY cjmdg_detsueldo_nroleg)";

		$dec = $this->cn->prepare($sql);
			$dec->bindValue(':leyenda', "SUBTOTAL POSITIVO", PDO::PARAM_STR);

		$dec->execute();

	}catch (Exception $e){
		die($e->getMessage());
	}
}

public function CJMDGLiquidoTotalesNegativos(){
	try{
		$sql ="INSERT INTO liq_det_tmp(liqcod_jub_id,liq_det_importe,legajo_id,periodo_id,liq_det_detconcep)
					(SELECT 601,SUM(IF(cjmdg_detsueldo_codconcep >= 100,cjmdg_detsueldo_importe,0)) negativo,cjmdg_detsueldo_nroleg,periodo_id,:leyenda2 FROM cjmdg_detsueldo
					GROUP BY cjmdg_detsueldo_nroleg)";
					$dec = $this->cn->prepare($sql);

			$dec->bindValue(':leyenda2', "SUBTOTAL NEGATIVO", PDO::PARAM_STR);
		$dec->execute();

	}catch (Exception $e){
		die($e->getMessage());
	}
}


public function NovedadesPeriodoListar($per){
	try{
		$sql = $this->cn->prepare("SELECT * FROM liquidacion_novedades
															WHERE periodo_id = ?");
		$sql->bindValue(1, $per, PDO::PARAM_STR);
		$sql->execute();
		return $sql->fetchAll(PDO::FETCH_OBJ);
	}catch (Exception $e){
		die($e->getMessage());
	}
}


public function NovedadesPeriodoListarxJub($per,$jub,$cod){
	try{

		$sql = $this->cn->prepare("SELECT * FROM liq_det_tmp
															WHERE periodo_id = ?
															AND legajo_id=?
															AND liqcod_jub_id=?
															");
		$sql->bindValue(1, $per, PDO::PARAM_STR);
		$sql->bindValue(2, $jub, PDO::PARAM_STR);
		$sql->bindValue(3, $cod, PDO::PARAM_STR);
		$sql->execute();
		return $sql->fetchAll(PDO::FETCH_OBJ);
	}catch (Exception $e){
		die($e->getMessage());
	}
}
	public function JubNovedadMasivaElimExe($jubliq){
		try{
			$sql = $this->cn->prepare("TRUNCATE liq_cab_tmp");
			$sql->execute();

			$sql = $this->cn->prepare("TRUNCATE liq_det_tmp");
			$sql->execute();

			//return $sql->fetchAll(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}

	public function GenerarReciboMensualExe($data){
		try{

			$sql = 'SELECT periodo_id FROM periodos
			WHERE periodo_cerrado=0
			AND periodo_activo=1';

			$dec1 = $this->cn->prepare($sql);

			$dec1->execute();

			$pe= $dec1->fetch(PDO::FETCH_OBJ);

				$sql = 'DELETE FROM liquidacion_codigos_mensual
						WHERE legajo_id= ?
						';

				$dec = $this->cn->prepare($sql);
				$dec->bindValue(1, $data->legajo_id, PDO::PARAM_STR);
				$dec->execute();

				$sql = 'DELETE FROM cjmdg_cabsueldo
						WHERE cjmdg_cabsueldo_nroleg2=?
						';

				$dec = $this->cn->prepare($sql);
				$dec->bindValue(1, $data->legajo_id, PDO::PARAM_STR);
				$dec->execute();

				$sql = 'DELETE FROM cjmdg_detsueldo
						WHERE cjmdg_detsueldo_nroleg=?
						';

				$dec = $this->cn->prepare($sql);
				$dec->bindValue(1, $data->legajo_id, PDO::PARAM_STR);
				$dec->execute();

				$sql = 'INSERT INTO cjmdg_cabsueldo(cjmdg_cabsueldo_nroleg2,periodo_id)
				VALUES(:legajo,
				:periodo)';

				$dec = $this->cn->prepare($sql);

				$dec->bindValue(':legajo', $data->legajo_id, PDO::PARAM_STR);
				$dec->bindValue(':periodo', $pe->periodo_id , PDO::PARAM_STR);

				$dec->execute();

				$sql = 'INSERT INTO cjmdg_detsueldo(cjmdg_detsueldo_nroleg,periodo_id,cjmdg_detsueldo_codconcep,cjmdg_detsueldo_importe)
				VALUES(:legajo,
				:periodo,
				:conc,
				:importe)';

				$dec = $this->cn->prepare($sql);

				$dec->bindValue(':legajo', $data->legajo_id, PDO::PARAM_STR);
				$dec->bindValue(':periodo', $pe->periodo_id , PDO::PARAM_STR);
				$dec->bindValue(':conc', $pe->periodo_id , PDO::PARAM_STR);
				$dec->bindValue(':importe', $pe->periodo_id , PDO::PARAM_STR);

				$dec->execute();

				$sql = 'INSERT INTO liquidacion_codigos_mensual(liqcod_id,legajo_id,empresa_id,periodo_id,legajo_tipo_id)
				((SELECT a.liqcod_id,c.legajo_id,2,periodo_id,2
				FROM liquidacion_inicial_codigos a,liquidaciones_codigo b,legajos c,haber_jubilado d
				WHERE c.legajo_id=?
				AND c.legajo_id=d.legajo_id
				AND a.liqcod_id=b.liqcod_id
				AND a.legajo_tipo_id=c.legajo_tipo_id
				)
				UNION ALL
				(SELECT a.liqcod_jub_id,c.legajo_id,2,a.periodo_id,2
				FROM liquidacion_novedades a,liquidaciones_codigo b,legajos c
				WHERE c.legajo_id=?
				AND c.legajo_id=a.legajo_id
				AND a.liqcod_jub_id=b.liqcod_id
				AND a.periodo_id=(SELECT periodo_id FROM periodos WHERE periodo_activo=1 AND periodo_cerrado=0)))';

				$dec = $this->cn->prepare($sql);
				$dec->bindValue(1, $data->legajo_id, PDO::PARAM_STR);
				$dec->bindValue(2, $data->legajo_id, PDO::PARAM_STR);

				$dec->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}

	public function JubNovedadMasivaGuardarExe($data){
		try{

						//$sql = 'INSERT INTO legajo_haberjub (legajo_id,periodo_id,legajo_haberimporte)
						//	(SELECT a.legajo_id,$data->,periodo_id FROM legajos a,legajo_haberjub b
						//	 WHERE a.legajo_id=b.legajo_id)';

						//$dec = $this->cn->prepare($sql);

						//$dec->bindValue(':periodo', $data->peri , PDO::PARAM_STR);
						//$dec->bindValue(':importe', $importe , PDO::PARAM_STR);

						//$dec->execute();
						//*********************************************************//
						//dar de alta en liquidaciones_novedades
						//si es haber, dar de alta en legajo_haberjub
						//ver si
						//********************************************************//


						$sql = 'UPDATE legajo_haberjub
											SET liq_det_importe = ?
											WHERE periodo_id = ?
											and legajo_id = ?';
							$dec = $this->cn->prepare($sql);
							$dec->bindValue(1, $data->importe_nov, PDO::PARAM_STR);
							$dec->bindValue(2, $data->peri, PDO::PARAM_STR);
							$dec->bindValue(3, $data->jubid, PDO::PARAM_STR);

							$dec->execute();


						//$sql = 'INSERT INTO cjmdg_detsueldo(cjmdg_detsueldo_nroleg,cjmdg_detsueldo_codconcep,cjmdg_detsueldo_detconcep,cjmdg_detsueldo_importe)
						//VALUES(
						//	:legajo,
						//	:codtipo,
						//	:detalle,
						//	:importe
						//)';

						//$dec = $this->cn->prepare($sql);
						//$dec->bindValue(':legajo', $data->jubid, PDO::PARAM_STR);
						//$dec->bindValue(':codtipo', $data->novedadtipo , PDO::PARAM_STR);
						//$dec->bindValue(':detalle', "" , PDO::PARAM_STR);
						//$dec->bindValue(':importe', $data->importe_nov, PDO::PARAM_STR);

						//$dec->execute();

						$legajos_tipo = Liquidacion::LegajosTipo($data->jubtipo);

						foreach($legajos_tipo as $row){

							if($data->radioimp==1){$importe=$row->legajo_haber_importe + $data->importe_nov;}else{$importe=$row->legajo_haber_importe * $data->importe_nov/100;}
							$sql = 'INSERT INTO liquidacion_novedades (legajo_id,
												 liqcod_jub_id,
												 importe_novedad,
														 periodo_id,
												 fecha_desde,
												 masiva
												 )
												 VALUES(:legajo,
												 :codtipo,
												 :importe,
												 :peri,
												 Now(),
												 :mas
												 )';
							$dec = $this->cn->prepare($sql);
							$dec->bindValue(':legajo', $data->jubid, PDO::PARAM_STR);
							$dec->bindValue(':codtipo', $data->novedadtipo , PDO::PARAM_STR);
							$dec->bindValue(':importe', $data->importe_nov, PDO::PARAM_STR);
							$dec->bindValue(':peri', $data->peri, PDO::PARAM_STR);
							$dec->bindValue(':mas', 0, PDO::PARAM_STR);

							$dec->execute();

						$sql = 'INSERT INTO legajo_haberjub(legajo_id,periodo_id,legajo_haberimporte)
						VALUES(:legajo,:periodo,:importe)';

						$dec = $this->cn->prepare($sql);

						$dec->bindValue(':legajo', $$row->legajo_id, PDO::PARAM_STR);
						$dec->bindValue(':periodo', $data->peri , PDO::PARAM_STR);
						$dec->bindValue(':importe', $importe , PDO::PARAM_STR);

						$dec->execute();
						}

		}catch (Exception $e){
			die($e->getMessage());
		}
	}


	public function JubMotivoTipoGuardarExe($data){
		try{

			$sql = 'INSERT INTO liquidacion_novedades (legajo_id,
								 liqcod_jub_id,
								 importe_novedad,
				         		 periodo_id,
								 fecha_desde,
								 masiva
								 )
								 VALUES(:legajo,
								 :codtipo,
								 :importe,
								 :peri,
								 Now(),
								 :mas
								 )';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(':legajo', $data->jubid, PDO::PARAM_STR);
			$dec->bindValue(':codtipo', $data->novedadtipo , PDO::PARAM_STR);
			$dec->bindValue(':importe', $data->importe_nov, PDO::PARAM_STR);
		  $dec->bindValue(':peri', $data->peri, PDO::PARAM_STR);
			$dec->bindValue(':mas', 0, PDO::PARAM_STR);

			$dec->execute();

			$sql = 'UPDATE legajo_haberjub
								SET legajohaber_importe = ?
								WHERE periodo_id = ?
								and legajo_id = ?';
				$dec = $this->cn->prepare($sql);
				$dec->bindValue(1, $data->importe_nov, PDO::PARAM_STR);
				$dec->bindValue(2, $data->peri, PDO::PARAM_STR);
				$dec->bindValue(3, $data->jubid, PDO::PARAM_STR);

				$dec->execute();

			//$sql = 'INSERT INTO cjmdg_detsueldo(cjmdg_detsueldo_nroleg,cjmdg_detsueldo_codconcep,cjmdg_detsueldo_detconcep,cjmdg_detsueldo_importe)
			//VALUES(
			//	:legajo,
			//	:codtipo,
			//	:detalle,
			//	:importe
			//)';

			//$dec = $this->cn->prepare($sql);
			//$dec->bindValue(':legajo', $data->jubid, PDO::PARAM_STR);
			//$dec->bindValue(':codtipo', $data->novedadtipo , PDO::PARAM_STR);
			//$dec->bindValue(':detalle', "" , PDO::PARAM_STR);
			//$dec->bindValue(':importe', $data->importe_nov, PDO::PARAM_STR);

			//$dec->execute();


		}catch (Exception $e){
			die($e->getMessage());
		}
	}


	}
