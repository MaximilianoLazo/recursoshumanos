<?php
set_time_limit(1500);
class Asignacion{

	public function __CONSTRUCT(){
		try{
			$this->cn = Conexion::getConnection();
			$this->cnw = Conexion::getConnectionw();
		}
		catch(Exception $e){
			die($e->getMessage());
		}
	}
	public function __DESTRUCT(){
		//$db;
		$this->cn;
	}
	public function PeriodoActualObtener(){
		try{
			$sql = $this->cn->prepare("SELECT *
																	 FROM periodos
																	WHERE periodo_cerrado = 1
															 ORDER BY periodo_id DESC
															 		LIMIT 1");
			$sql->execute();
			return $sql->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function PeriodosObtener($limite){
		try{

			$sql = 'SELECT *
							  FROM periodos
							 WHERE periodo_cerrado = 1
						ORDER BY periodo_id
								DESC
						   LIMIT ?';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $limite, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function AsignacioenesResumenPeriodo($periodoid, $titular){
		try{

			$sql = 'SELECT asigtipo_id,
										 SUM(asignacion_cantidad)
									AS asignacion_total
							  FROM asignaciones_familiares
							 WHERE asignacion_titular = ?
							 	 AND periodo_id = ?
					  GROUP BY asigtipo_id';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $titular, PDO::PARAM_STR);
			$dec->bindValue(2, $periodoid, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerAsignacionXEmpleadoFilasNum($empndoc, $benndoc, $periodoid){
		try{

			$sql = 'SELECT COUNT(asignacion_id)
									AS asignacioncantidad
							  FROM asignaciones_familiares
							 WHERE legempleado_nrodocto = ?
							 	 AND legempleado_nrodocto_ben = ?
							 	 AND periodo_id = ?
								 AND asigtipo_id != 8';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $empndoc, PDO::PARAM_STR);
			$dec->bindValue(2, $benndoc, PDO::PARAM_STR);
			$dec->bindValue(3, $periodoid, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function AOBFechaPaseLiqObtener($periodoid){
		try{

			$sql = 'SELECT AUD_asignacion_datetime
							  FROM aud_asignaciones_familiares
							 WHERE AUD_periodo_id = ?
						   	 AND AUD_asignacion_estado = 1
					  ORDER BY SEG_asignacion_id
						   LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $periodoid, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function AsignacionesLiqFilasNum($periodoid){
		try{

			$sql = 'SELECT COUNT(asignacion_id)
									AS asignacionc
							  FROM asignaciones_familiares
							 WHERE asignacion_titular = 1
								 AND periodo_id = ?
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $periodoid, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function AsignacionesOBLiqFilasNum($periodoid){
		try{

			$sql = 'SELECT COUNT(asignacion_id) AS asignacionobc
										 FROM asignaciones_familiares
										WHERE asignacion_titular = 2
											AND periodo_id = ? LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $periodoid, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function AsignacionesListado(){
		try{

			date_default_timezone_set("America/Buenos_Aires");
			$fecha_actual = date("Y-m-d");
			//--- Conyuge ---
			$sql = $this->cn->prepare("SELECT DISTINCT a.legempleado_nrodocto AS empleado,
																								 a.legempleado_nrodocto AS beneficiario
																						FROM legajos_conyuge a,
																								 legajos_empleado b
																					 WHERE a.legempleado_nrodocto = b.legempleado_nrodocto
																					 	 AND a.legempleado_nrodocto != a.legconyuge_nrodocto
																						 AND a.legconyuge_activo = 1
																						 AND b.legempleado_activo = 1");
			$sql->execute();
			$conyuge = $sql->fetchAll(PDO::FETCH_OBJ);
			//--- Pre-Natal ---
			$sql = $this->cn->prepare("SELECT DISTINCT a.legempleado_nrodocto AS empleado,
																								 a.legprenatal_benndoc AS beneficiario
																					  FROM legajos_prenatal a,
																								 legajos_empleado b
																					 WHERE a.legempleado_nrodocto = b.legempleado_nrodocto
																					 	 AND a.legempleado_nrodocto = a.legprenatal_benndoc
																					 	 AND a.legprenatal_activo = 1
																					 	 AND b.legempleado_activo = 1");
			$sql->execute();
			$prenatal = $sql->fetchAll(PDO::FETCH_OBJ);
			//--- Hijo Menor ---

			$fecha_uno = date("Y-m-d",strtotime($fecha_actual."- 6 year"));//resto 5 años
			$fecha_dos = date("Y-m-d",strtotime($fecha_uno."- 1 month"));//resto 5 meses
			$sql = $this->cn->prepare("SELECT DISTINCT a.legempleado_nrodocto AS empleado,
																								 a.leghijo_benndoc AS beneficiario
																						FROM legajos_hijo a,
																								 legajos_empleado b
																					 WHERE a.legempleado_nrodocto = b.legempleado_nrodocto
																					   AND a.legempleado_nrodocto = a.leghijo_benndoc
																						 AND a.leghijo_disc != 1
																						 AND a.leghijo_esc != 1
																						 AND a.leghijo_estado != 2
																						 AND a.leghijo_activo = 1
																						 AND b.legempleado_activo = 1
																						 AND a.leghijo_fecnacto
																				 BETWEEN '$fecha_dos' AND '$fecha_actual'");
			$sql->execute();
			$hijomenor = $sql->fetchAll(PDO::FETCH_OBJ);
			//--- Hijo Escolar ---
			$fecha_tres_s = date("Y-m-d",strtotime($fecha_actual."- 23 year"));//resto 23 años
			$fecha_tres = date("Y-m-d",strtotime($fecha_tres_s."- 5 month"));//resto 5 meses
			$sql = $this->cn->prepare("SELECT DISTINCT a.legempleado_nrodocto AS empleado,
																								 a.leghijo_benndoc AS beneficiario
																					  FROM legajos_hijo a,
																						     legajos_empleado b
																					 WHERE a.legempleado_nrodocto = b.legempleado_nrodocto
																					   AND a.legempleado_nrodocto = a.leghijo_benndoc
																						 AND a.leghijo_disc != 1
																						 AND a.leghijo_esc = 1
																						 AND a.leghijo_estado != 2
																						 AND a.leghijo_activo = 1
																						 AND b.legempleado_activo = 1
																						 AND a.leghijo_fecnacto
																				 BETWEEN '$fecha_tres' AND '$fecha_actual'");
			$sql->execute();
			$hijoescolar = $sql->fetchAll(PDO::FETCH_OBJ);
			//--- Hijo con discapacidad // escolar con discapacidad ---
			$sql = $this->cn->prepare("SELECT DISTINCT a.legempleado_nrodocto AS empleado,
				                                         a.leghijo_benndoc AS beneficiario
																						FROM legajos_hijo a,
																						     legajos_empleado b
																					 WHERE a.legempleado_nrodocto = b.legempleado_nrodocto
																					   AND a.legempleado_nrodocto = a.leghijo_benndoc
																						 AND a.leghijo_disc = 1
																						 AND a.leghijo_estado != 2
																						 AND a.leghijo_activo = 1
																						 AND b.legempleado_activo = 1");
			$sql->execute();
			$hijodisc = $sql->fetchAll(PDO::FETCH_OBJ);
			//--- unir todos los arrays---
			$asignaciones = array_merge($conyuge, $prenatal, $hijomenor, $hijoescolar, $hijodisc);
			//--- eliminar contenido duplicado ---
			$asignaciones = array_map('json_encode', $asignaciones);
			$asignaciones = array_unique($asignaciones);
			$asignaciones = array_map('json_decode', $asignaciones);
			sort($asignaciones);
			//--- Retornar contenido ---
			return $asignaciones;

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function AsignacionesOBListado(){
		try{

			date_default_timezone_set("America/Buenos_Aires");
			$fecha_actual = date("Y-m-d");
			//--- Pre-Natal ---
			$sql = $this->cn->prepare("SELECT DISTINCT a.legempleado_nrodocto AS empleado,
																								 a.legprenatal_benndoc AS beneficiario
																						FROM legajos_prenatal a,
																						     legajos_empleado b
																					 WHERE a.legempleado_nrodocto = b.legempleado_nrodocto
																					   AND a.legempleado_nrodocto != a.legprenatal_benndoc
																						 AND a.legprenatal_activo = 1
																						 AND b.legempleado_activo = 1");
			$sql->execute();
			$prenatal = $sql->fetchAll(PDO::FETCH_OBJ);
			//--- Hijo Menor ---
			$fecha_uno = date("Y-m-d",strtotime($fecha_actual."- 5 year"));//resto 5 años
			$fecha_dos = date("Y-m-d",strtotime($fecha_uno."- 5 month"));//resto 5 meses
			$sql = $this->cn->prepare("SELECT DISTINCT a.legempleado_nrodocto AS empleado,
																								 a.leghijo_benndoc AS beneficiario
																						FROM legajos_hijo a,
																						     legajos_empleado b
																					 WHERE a.legempleado_nrodocto = b.legempleado_nrodocto
																					   AND a.legempleado_nrodocto != a.leghijo_benndoc
																						 AND a.leghijo_disc != 1
																						 AND a.leghijo_esc != 1
																						 AND a.leghijo_estado != 2
																						 AND a.leghijo_activo = 1
																						 AND b.legempleado_activo = 1
																						 AND a.leghijo_fecnacto
																				 BETWEEN '$fecha_dos' AND '$fecha_actual'");
			$sql->execute();
			$hijomenor = $sql->fetchAll(PDO::FETCH_OBJ);
			//--- Hijo Escolar ---
			$fecha_tres_s = date("Y-m-d",strtotime($fecha_actual."- 23 year"));//resto 23 años
			$fecha_tres = date("Y-m-d",strtotime($fecha_tres_s."- 5 month"));//resto 5 meses
			$sql = $this->cn->prepare("SELECT DISTINCT a.legempleado_nrodocto AS empleado,
																								 a.leghijo_benndoc AS beneficiario
																						FROM legajos_hijo a,
																								 legajos_empleado b
																					 WHERE a.legempleado_nrodocto = b.legempleado_nrodocto
																					   AND a.legempleado_nrodocto != a.leghijo_benndoc
																						 AND a.leghijo_disc != 1
																						 AND a.leghijo_esc = 1
																						 AND a.leghijo_estado != 2
																						 AND a.leghijo_activo = 1
																						 AND b.legempleado_activo = 1
																						 AND a.leghijo_fecnacto
																				 BETWEEN '$fecha_tres' AND '$fecha_actual'");
			$sql->execute();
			$hijoescolar = $sql->fetchAll(PDO::FETCH_OBJ);
			//--- Hijo con discapacidad // escolar con discapacidad ---
			$sql = $this->cn->prepare("SELECT DISTINCT a.legempleado_nrodocto AS empleado,
																								 a.leghijo_benndoc AS beneficiario
																						FROM legajos_hijo a,
																								 legajos_empleado b
																					 WHERE a.legempleado_nrodocto = b.legempleado_nrodocto
																					   AND a.legempleado_nrodocto != a.leghijo_benndoc
																						 AND a.leghijo_disc = 1
																						 AND a.leghijo_estado != 2
																						 AND a.leghijo_activo = 1
																						 AND b.legempleado_activo = 1");
			$sql->execute();
			$hijodisc = $sql->fetchAll(PDO::FETCH_OBJ);
			//--- unir todos los arrays---
			$asignacionesob = array_merge($prenatal, $hijomenor, $hijoescolar, $hijodisc);
			//--- eliminar contenido duplicado ---
			$asignacionesob = array_map('json_encode', $asignacionesob);
			$asignacionesob = array_unique($asignacionesob);
			$asignacionesob = array_map('json_decode', $asignacionesob);
			sort($asignacionesob);
			//--- Retornar contenido ---
			return $asignacionesob;

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function AyudaEscolarOBListado(){
		try{

			date_default_timezone_set("America/Buenos_Aires");
			$fecha_actual = date("Y-m-d");

			//--- Hijo Escolar ---
			$fecha_tres_s = date("Y-m-d",strtotime($fecha_actual."- 23 year"));//resto 23 años
			$fecha_tres = date("Y-m-d",strtotime($fecha_tres_s."- 5 month"));//resto 5 meses
			$sql = $this->cn->prepare("SELECT DISTINCT a.legempleado_nrodocto AS empleado,
																								 a.leghijo_benndoc AS beneficiario
																						FROM legajos_hijo a,
																								 legajos_empleado b
																					 WHERE a.legempleado_nrodocto = b.legempleado_nrodocto
																					   AND a.legempleado_nrodocto != a.leghijo_benndoc
																						 AND a.leghijo_disc != 1
																						 AND a.leghijo_esc = 1
																						 AND a.leghijo_estado != 2
																						 AND a.leghijo_activo = 1
																						 AND b.legempleado_activo = 1
																						 AND a.leghijo_fecnacto
																				 BETWEEN '$fecha_tres' AND '$fecha_actual'");
			$sql->execute();
			$hijoescolar = $sql->fetchAll(PDO::FETCH_OBJ);
			//--- escolar con discapacidad ---
			$sql = $this->cn->prepare("SELECT DISTINCT a.legempleado_nrodocto AS empleado,
																								 a.leghijo_benndoc AS beneficiario
																						FROM legajos_hijo a,
																								 legajos_empleado b
																					 WHERE a.legempleado_nrodocto = b.legempleado_nrodocto
																					   AND a.legempleado_nrodocto != a.leghijo_benndoc
																						 AND a.leghijo_disc = 1
																						 AND a.leghijo_esc = 1
																						 AND a.leghijo_estado != 2
																						 AND a.leghijo_activo = 1
																						 AND b.legempleado_activo = 1");
			$sql->execute();
			$hijoescdisc = $sql->fetchAll(PDO::FETCH_OBJ);
			//--- unir todos los arrays---
			$ayudaescolarob = array_merge($hijoescolar, $hijoescdisc);
			//--- eliminar contenido duplicado ---
			$ayudaescolarob = array_map('json_encode', $ayudaescolarob);
			$ayudaescolarob = array_unique($ayudaescolarob);
			$ayudaescolarob = array_map('json_decode', $ayudaescolarob);
			sort($ayudaescolarob);
			//--- Retornar contenido ---
			return $ayudaescolarob;

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function EmpleadoObtener($nrodocto){
		try{
			$sql = 'SELECT legempleado_apellido,
										 legempleado_nombres
								FROM legajos_empleado
							 WHERE legempleado_nrodocto = ? LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$dec->execute();

			return $dec->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function AsignacionesInfoListar_DNI($titular){
		try{
			$sql = 'SELECT DISTINCT legempleado_nrodocto
								FROM asignaciones_familiares_info
							 WHERE asignacion_titular = ?
							 	 AND periodo_id = (SELECT max(periodo_id)
								 										 FROM asignaciones_familiares_info)
							 	 AND asignacion_info_estado = 1
						ORDER BY legempleado_nrodocto ASC';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $titular, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetchAll(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function AsignacionesInfoListar_Detalles($titular, $nrodocto){
		try{
			$sql = 'SELECT *
								FROM asignaciones_familiares_info
							 WHERE asignacion_titular = ?
							 	 AND legempleado_nrodocto = ?
								 AND periodo_id = (SELECT max(periodo_id)
								 										 FROM asignaciones_familiares_info)
								 AND asignacion_info_estado = 1
						ORDER BY asignacion_info_tipo,
										 asigtipo_id';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $titular, PDO::PARAM_STR);
			$dec->bindValue(2, $nrodocto, PDO::PARAM_STR);
			$dec->execute();

			return $dec->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function EmpleadoAYNObtener($nrodocto){
		try{
			$sql = 'SELECT legempleado_id,
										 legempleado_nrodocto,
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
	public function ConyugeFilasNum($empleadonrodocto){
		try{

			$sql = 'SELECT COUNT(legconyuge_id) AS conyugec
										 FROM legajos_conyuge
										WHERE legempleado_nrodocto = ?
										  AND legconyuge_activo = 1 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $empleadonrodocto, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ConyugeObtener($empndoc){
		try{
			$sql = 'SELECT legconyuge_id,
										 legconyuge_nrodocto,
										 legconyuge_apellido,
										 legconyuge_nombres
								FROM legajos_conyuge
							 WHERE legempleado_nrodocto = ?
							 	 AND legconyuge_activo = 1
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $empndoc, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function PreNatalFilasNum($empleadonrodocto, $beneficiarionrodocto){
		try{
			$sql = 'SELECT COUNT(legprenatal_id) AS prenatalc
										 FROM legajos_prenatal
										WHERE legempleado_nrodocto = ?
										  AND legprenatal_benndoc = ?
											AND legprenatal_activo = 1 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $empleadonrodocto, PDO::PARAM_STR);
			$dec->bindValue(2, $beneficiarionrodocto, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function PreNatalObtener($empndoc, $benndoc){
		try{
			$sql = 'SELECT legprenatal_id,
										 legempleado_id_ben,
										 legprenatal_benndoc,
										 legprenatal_benapellido,
										 legprenatal_bennombres
								FROM legajos_prenatal
							 WHERE legempleado_nrodocto = ?
							 	 AND legprenatal_benndoc = ?
							 	 AND legprenatal_activo = 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $empndoc, PDO::PARAM_STR);
			$dec->bindValue(2, $benndoc, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function HijoMenorFilasNum($empleadonrodocto, $beneficiarionrodocto, $fechaactual, $fechafinal){
		try{
			$sql = 'SELECT COUNT(leghijo_id) AS hijom
										 FROM legajos_hijo
									  WHERE legempleado_nrodocto = ?
										  AND leghijo_benndoc = ?
											AND leghijo_esc != 1
											AND leghijo_disc != 1
											AND leghijo_estado != 2
											AND leghijo_activo = 1
											AND leghijo_fecnacto BETWEEN ? AND ?
										LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $empleadonrodocto, PDO::PARAM_STR);
			$dec->bindValue(2, $beneficiarionrodocto, PDO::PARAM_STR);
			$dec->bindValue(3, $fechafinal, PDO::PARAM_STR);
			$dec->bindValue(4, $fechaactual, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function HijoMenorObtener($empleadonrodocto, $beneficiarionrodocto, $fecha_actual, $fecha_final){
		try{

			$sql = 'SELECT *
								FROM legajos_hijo
							 WHERE legempleado_nrodocto = ?
							   AND leghijo_benndoc = ?
								 AND leghijo_esc != 1
								 AND leghijo_disc != 1
								 AND leghijo_fecnacto
						 BETWEEN ?
						     AND ?
								 AND leghijo_estado != 2
								 AND leghijo_activo = 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $empleadonrodocto, PDO::PARAM_STR);
			$dec->bindValue(2, $beneficiarionrodocto, PDO::PARAM_STR);
			$dec->bindValue(3, $fecha_final, PDO::PARAM_STR);
			$dec->bindValue(4, $fecha_actual, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	/*
	public function HijoMenorLiqFilasNum($empleadonrodocto, $beneficiarionrodocto, $periodoid){
		try{
			$sql = 'SELECT COUNT(asignacion_id) AS hijomliqc
										 FROM asignaciones
										WHERE legempleado_nrodocto = ?
										  AND _benndoc = ?
											AND periodo_id = ?
											AND asigtipo_id = 2
										LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $empleadonrodocto, PDO::PARAM_STR);
			$dec->bindValue(2, $beneficiarionrodocto, PDO::PARAM_STR);
			$dec->bindValue(3, $periodoid, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	*/
	public function HijosEscFilasNum($empleadonrodocto, $beneficiarionrodocto, $escuelanivel){
		try{

			$sql = 'SELECT COUNT(escnivel_id) AS escuelac
										 FROM legajos_hijo
										WHERE legempleado_nrodocto = ?
										  AND leghijo_benndoc = ?
											AND escnivel_id  = ?
											AND leghijo_esc = 1
											AND leghijo_disc != 1
											AND leghijo_estado != 2
											AND leghijo_activo = 1 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $empleadonrodocto, PDO::PARAM_STR);
			$dec->bindValue(2, $beneficiarionrodocto, PDO::PARAM_STR);
			$dec->bindValue(3, $escuelanivel, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function HijosEscObtener($empleadonrodocto, $beneficiarionrodocto, $escuelanivel){
		try{

			$sql = 'SELECT *
								FROM legajos_hijo
							 WHERE legempleado_nrodocto = ?
							   AND leghijo_benndoc = ?
								 AND escnivel_id  = ?
								 AND leghijo_esc = 1
								 AND leghijo_disc != 1
								 AND leghijo_estado != 2
								 AND leghijo_activo = 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $empleadonrodocto, PDO::PARAM_STR);
			$dec->bindValue(2, $beneficiarionrodocto, PDO::PARAM_STR);
			$dec->bindValue(3, $escuelanivel, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function HijoDiscFilasNum($empleadonrodocto, $beneficiarionrodocto){
		try{

			$sql = 'SELECT COUNT(leghijo_disc) AS hijodisc
										 FROM legajos_hijo
										WHERE legempleado_nrodocto = ?
										  AND leghijo_benndoc = ?
											AND leghijo_disc = 1
											AND leghijo_esc = 0
											AND leghijo_estado != 2
											AND leghijo_activo = 1 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $empleadonrodocto, PDO::PARAM_STR);
			$dec->bindValue(2, $beneficiarionrodocto, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function HijoDiscObtener($empleadonrodocto, $beneficiarionrodocto){
		try{

			$sql = 'SELECT *
								FROM legajos_hijo
							 WHERE legempleado_nrodocto = ?
								 AND leghijo_benndoc = ?
								 AND leghijo_disc = 1
								 AND leghijo_esc = 0
								 AND leghijo_estado != 2
								 AND leghijo_activo = 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $empleadonrodocto, PDO::PARAM_STR);
			$dec->bindValue(2, $beneficiarionrodocto, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function HijoDiscEscFilasNum($empleadonrodocto, $beneficiarionrodocto){
		try{

			$sql = 'SELECT COUNT(leghijo_disc) AS hijodiscesc
			          FROM legajos_hijo
							 WHERE legempleado_nrodocto = ?
							   AND leghijo_benndoc = ?
								 AND leghijo_disc = 1
								 AND leghijo_esc = 1
								 AND leghijo_estado != 2
								 AND leghijo_activo = 1
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $empleadonrodocto, PDO::PARAM_STR);
			$dec->bindValue(2, $beneficiarionrodocto, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function HijoDiscEscObtener($empleadonrodocto, $beneficiarionrodocto){
		try{

			$sql = 'SELECT *
			          FROM legajos_hijo
							 WHERE legempleado_nrodocto = ?
							   AND leghijo_benndoc = ?
								 AND leghijo_disc = 1
								 AND leghijo_esc = 1
								 AND leghijo_estado != 2
								 AND leghijo_activo = 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $empleadonrodocto, PDO::PARAM_STR);
			$dec->bindValue(2, $beneficiarionrodocto, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function AsignacionInformacion($phcid, $peridoid, $asigtipo){
		try{

			$sql = 'SELECT asigtipo_id,
										 asignacion_info
			          FROM asignaciones_familiares
							 WHERE asignacion_phc_id = ?
							   AND periodo_id = ?
								 AND asigtipo_id = ?
						ORDER BY asignacion_id
								DESC
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $phcid, PDO::PARAM_STR);
			$dec->bindValue(2, $peridoid, PDO::PARAM_STR);
			$dec->bindValue(3, $asigtipo, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function AsignacionLiqFilasNum($empleadonrodocto, $beneficiarionrodocto, $periodoid, $liqcod){
		try{
			$sql = 'SELECT COUNT(asignacion_id) AS asignacionliqc
										 FROM asignaciones_familiares
										WHERE legempleado_nrodocto = ?
										  AND legempleado_nrodocto_ben = ?
											AND periodo_id = ?
											AND liqcod_id = ?
										LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $empleadonrodocto, PDO::PARAM_STR);
			$dec->bindValue(2, $beneficiarionrodocto, PDO::PARAM_STR);
			$dec->bindValue(3, $periodoid, PDO::PARAM_STR);
			$dec->bindValue(4, $liqcod, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}

	public function AsignacionGuardarExe($data){
		try{

			$sql = 'INSERT INTO asignaciones_familiares (asignacion_titular,
																									 legempleado_nrodocto,
																									 legempleado_apellido,
																									 legempleado_nombres,
																									 legempleado_id_ben,
																									 legempleado_nrodocto_ben,
																									 legempleado_apellido_ben,
																									 legempleado_nombres_ben,
																									 asignacion_phc_id,
																									 asignacion_phc_bennoficio,
																									 asignacion_phc_nrodocto,
																									 asignacion_phc_apellido,
																									 asignacion_phc_nombres,
																									 periodo_id,
																									 liqcod_id,
																									 asigtipo_id,
																									 asignacion_cantidad,
																									 asignacion_importe,
																									 asignacion_estado)
																						VALUES(:titular,
																									 :empndoc,
																									 :empap,
																									 :empnom,
																									 :benid,
																									 :benndoc,
																									 :benap,
																									 :bennom,
																									 :phcid,
																									 :phcnof,
																									 :phcndoc,
																									 :phcap,
																									 :phcnom,
																									 :periodoid,
																									 :liccid,
																									 :asigtid,
																									 :asigc,
																									 0,
																									 :asigest)';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(':titular', $data->Titular, PDO::PARAM_STR);
			$dec->bindValue(':empndoc', $data->Empndoc, PDO::PARAM_STR);
			$dec->bindValue(':empap', $data->Empapellido, PDO::PARAM_STR);
			$dec->bindValue(':empnom', $data->Empnombres, PDO::PARAM_STR);
			$dec->bindValue(':benid', $data->Benid, PDO::PARAM_STR);
			$dec->bindValue(':benndoc', $data->Benndoc, PDO::PARAM_STR);
			$dec->bindValue(':benap', $data->Benapellido, PDO::PARAM_STR);
			$dec->bindValue(':bennom', $data->Bennombres, PDO::PARAM_STR);
			$dec->bindValue(':phcid', $data->Phcid, PDO::PARAM_STR);
			$dec->bindValue(':phcnof', $data->Phcnoficio, PDO::PARAM_STR);
			$dec->bindValue(':phcndoc', $data->Phcndoc, PDO::PARAM_STR);
			$dec->bindValue(':phcap', $data->Phcapellido, PDO::PARAM_STR);
			$dec->bindValue(':phcnom', $data->Phcnombres, PDO::PARAM_STR);
			$dec->bindValue(':periodoid', $data->Periodoid, PDO::PARAM_STR);
			$dec->bindValue(':liccid', $data->Liqcodid, PDO::PARAM_STR);
			$dec->bindValue(':asigtid', $data->Asigtipoid, PDO::PARAM_STR);
			$dec->bindValue(':asigc', $data->Asigcantidad, PDO::PARAM_STR);
			$dec->bindValue(':asigest', $data->Asigestado, PDO::PARAM_STR);
			$dec->execute();
			//----------------obtner ultimo id Insertado -----------
			$ultimoid = $this->cn->lastInsertId();
			return $ultimoid;
			/*
			//--------------Insert de aditoria de asignaciones ---------------------------
			$ippublica = $_SERVER["REMOTE_ADDR"];
			$pcnombre = gethostbyaddr($_SERVER['REMOTE_ADDR']);
			$pcinformacion = $_SERVER['HTTP_USER_AGENT'];
			$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];

			$sql = 'INSERT INTO aud_asignaciones_familiares (AUD_asignacion_id,
																											 AUD_asignacion_titular,
																											 AUD_asignacion_phc_id,
																											 AUD_legempleado_nrodocto,
																											 AUD_legempleado_apellido,
																											 AUD_legempleado_nombres,
																											 AUD_benndoc,
																											 AUD_bennoficio,
																											 AUD_benapellido,
																											 AUD_bennombres,
																											 AUD_leghijo_nrodocto,
																											 AUD_leghijo_apellido,
																											 AUD_leghijo_nombres,
																											 AUD_periodo_id,
																											 AUD_liqcod_id,
																											 AUD_asignacion_cantidad,
																											 AUD_asignacion_importe,
																											 AUD_asignacion_reajuste,
																											 AUD_asignacion_reajuste_obs,
																											 AUD_asignacion_importe_total,
																											 AUD_asignacion_estado,
																											 AUD_asignacion_observacion,
																											 AUD_asignacion_ippublica,
																											 AUD_asignacion_pcnombre,
																											 AUD_asignacion_pcinformacion,
																											 AUD_asignacion_accion,
																											 AUD_asignacion_datetime,
																											 AUD_asignacion_usuario)
																								VALUES(:ultimoid,
																											 2,
																											 :phcid,
																											 :empnrodocto,
																											 :empapellido,
																											 :empnombres,
																											 :bennrodocto,
																											 :bennrooficio,
																											 :benapellido,
																											 :bennombres,
																											 0,
																											 "",
																											 "",
																											 :periodoid,
																											 214,
																											 1,
																											 0,
																											 0,
																											 "",
																											 0,
																											 1,
																											 "",
																											 :ippublica,
																											 :pcnombre,
																											 :pcinformacion,
																											 "INSERT",
																											 NOW(),
																											 :usuario)';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(':ultimoid', $ultimoid, PDO::PARAM_STR);
			$dec->bindValue(':phcid', $row->legprenatal_id, PDO::PARAM_STR);
			$dec->bindValue(':empnrodocto', $row->legempleado_nrodocto, PDO::PARAM_STR);
			$dec->bindValue(':empapellido', $datosempleado->legempleado_apellido, PDO::PARAM_STR);
			$dec->bindValue(':empnombres', $datosempleado->legempleado_nombres, PDO::PARAM_STR);
			$dec->bindValue(':bennrodocto', $row->legprenatal_benndoc, PDO::PARAM_STR);
			$dec->bindValue(':bennrooficio', $row->legprenatal_bennoficio, PDO::PARAM_STR);
			$dec->bindValue(':benapellido', $row->legprenatal_benapellido, PDO::PARAM_STR);
			$dec->bindValue(':bennombres', $row->legprenatal_bennombres, PDO::PARAM_STR);
			$dec->bindValue(':periodoid', $periodo->periodo_id, PDO::PARAM_STR);
			$dec->bindValue(':ippublica', $ippublica, PDO::PARAM_STR);
			$dec->bindValue(':pcnombre', $pcnombre, PDO::PARAM_STR);
			$dec->bindValue(':pcinformacion', $pcinformacion, PDO::PARAM_STR);
			$dec->bindValue(':usuario', $usuario, PDO::PARAM_STR);
			$dec->execute();

      }
			*/
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function AsignacionInfoGuardarExe($data){
		try{

			$sql = 'INSERT INTO asignaciones_familiares_info (asignacion_id,
																				 								periodo_id,
																				 								asignacion_info_tipo,
																				 								asignacion_info_estado)
																								 VALUES(:asgid,
																											  :periodoid,
																											  :notitipo,
																											  :notiestado)';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(':asgid', $data->Asignacionid, PDO::PARAM_STR);
			$dec->bindValue(':periodoid', $data->Periodoid, PDO::PARAM_STR);
			$dec->bindValue(':notitipo', $data->Asignotitipo, PDO::PARAM_STR);
			$dec->bindValue(':notiestado', $data->Asignotiestado, PDO::PARAM_STR);
			$dec->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function PreNatalAPasarExe($empleadonrodocto, $beneficiarionrodocto){
		try{
			//----------- Pase Pre Natal -------
			//------------Datos pre natales --------
			$sql = 'SELECT * FROM legajos_prenatal
											WHERE legempleado_nrodocto = ?
											  AND legprenatal_benndoc = ?
												AND legprenatal_activo = 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $empleadonrodocto, PDO::PARAM_STR);
			$dec->bindValue(2, $beneficiarionrodocto, PDO::PARAM_STR);
			$dec->execute();
			$datosprenatales = $dec->fetchAll(PDO::FETCH_OBJ);
			//-----------Datos empleados -----------
			$sql = 'SELECT legempleado_apellido,
										 legempleado_nombres
								FROM legajos_empleado
							 WHERE legempleado_nrodocto = ? LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $empleadonrodocto, PDO::PARAM_STR);
			$dec->execute();
			$datosempleado = $dec->fetch(PDO::FETCH_OBJ);
			//----------Datos de periodo actual -----
			$sql = $this->cn->prepare("SELECT periodo_id
																	 FROM periodos
																	WHERE periodo_cerrado = 1
															 ORDER BY periodo_id DESC LIMIT 1");
			$sql->execute();
			$periodo = $sql->fetch(PDO::FETCH_OBJ);

			foreach($datosprenatales as $row){
				//-------------Verificar si el prenatal esta pasado al menos una vez ---------
				/*$sql = 'SELECT * FROM asignaciones_familiares
												WHERE asignacion_phc_id = ?
												  AND legempleado_nrodocto = ?
													AND _benndoc = ?';
				$dec = $this->cn->prepare($sql);
				$dec->bindValue(1, $row->legprenatal_id, PDO::PARAM_STR);
				$dec->bindValue(2, $empleadonrodocto, PDO::PARAM_STR);
				$dec->bindValue(3, $beneficiarionrodocto, PDO::PARAM_STR);
				$dec->execute();

				$num = $dec->rowCount();*/

				$sql = 'INSERT INTO asignaciones_familiares (asignacion_titular,
																										 asignacion_phc_id,
																										 legempleado_nrodocto,
																										 legempleado_apellido,
																										 legempleado_nombres,
																										 _benndoc,
																										 _bennoficio,
																										 _benapellido,
																										 _bennombres,
																										 leghijo_nrodocto,
																										 leghijo_apellido,
																										 leghijo_nombres,
																										 periodo_id,
																										 liqcod_id,
																										 asignacion_cantidad,
																										 asignacion_importe,
																										 asignacion_reajuste,
																										 asignacion_reajuste_obs,
																										 asignacion_importe_total,
																										 asignacion_estado)
																							VALUES(2,
																										 :phcid,
																										 :empnrodocto,
																										 :empapellido,
																										 :empnombres,
																										 :bennrodocto,
																										 :bennrooficio,
																										 :benapellido,
																										 :bennombres,
																										 0,
																										 "",
																										 "",
																										 :periodoid,
																										 214,
																										 1,
																										 0,
																										 0,
																										 "",
																										 0,
																										 1)';

				$dec = $this->cn->prepare($sql);
				$dec->bindValue(':phcid', $row->legprenatal_id, PDO::PARAM_STR);
				$dec->bindValue(':empnrodocto', $row->legempleado_nrodocto, PDO::PARAM_STR);
				$dec->bindValue(':empapellido', $datosempleado->legempleado_apellido, PDO::PARAM_STR);
				$dec->bindValue(':empnombres', $datosempleado->legempleado_nombres, PDO::PARAM_STR);
				$dec->bindValue(':bennrodocto', $row->legprenatal_benndoc, PDO::PARAM_STR);
				$dec->bindValue(':bennrooficio', $row->legprenatal_bennoficio, PDO::PARAM_STR);
				$dec->bindValue(':benapellido', $row->legprenatal_benapellido, PDO::PARAM_STR);
				$dec->bindValue(':bennombres', $row->legprenatal_bennombres, PDO::PARAM_STR);
				$dec->bindValue(':periodoid', $periodo->periodo_id, PDO::PARAM_STR);
				$dec->execute();
				//----------------obtner ultimo id Insertado -----------
				$ultimoid = $this->cn->lastInsertId();
				//--------------Insert de aditoria de asignaciones ---------------------------
				$ippublica = $_SERVER["REMOTE_ADDR"];
				$pcnombre = gethostbyaddr($_SERVER['REMOTE_ADDR']);
				$pcinformacion = $_SERVER['HTTP_USER_AGENT'];
				$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];

				$sql = 'INSERT INTO aud_asignaciones_familiares (AUD_asignacion_id,
																												 AUD_asignacion_titular,
																												 AUD_asignacion_phc_id,
																												 AUD_legempleado_nrodocto,
																												 AUD_legempleado_apellido,
																												 AUD_legempleado_nombres,
																												 AUD_benndoc,
																												 AUD_bennoficio,
																												 AUD_benapellido,
																												 AUD_bennombres,
																												 AUD_leghijo_nrodocto,
																												 AUD_leghijo_apellido,
																												 AUD_leghijo_nombres,
																												 AUD_periodo_id,
																												 AUD_liqcod_id,
																												 AUD_asignacion_cantidad,
																												 AUD_asignacion_importe,
																												 AUD_asignacion_reajuste,
																												 AUD_asignacion_reajuste_obs,
																												 AUD_asignacion_importe_total,
																												 AUD_asignacion_estado,
																												 AUD_asignacion_observacion,
																												 AUD_asignacion_ippublica,
																												 AUD_asignacion_pcnombre,
																												 AUD_asignacion_pcinformacion,
																												 AUD_asignacion_accion,
																												 AUD_asignacion_datetime,
																												 AUD_asignacion_usuario)
																									VALUES(:ultimoid,
																												 2,
																												 :phcid,
																												 :empnrodocto,
																												 :empapellido,
																												 :empnombres,
																												 :bennrodocto,
																												 :bennrooficio,
																												 :benapellido,
																												 :bennombres,
																												 0,
																												 "",
																												 "",
																												 :periodoid,
																												 214,
																												 1,
																												 0,
																												 0,
																												 "",
																												 0,
																												 1,
																												 "",
																												 :ippublica,
																												 :pcnombre,
																												 :pcinformacion,
																												 "INSERT",
																												 NOW(),
																												 :usuario)';

				$dec = $this->cn->prepare($sql);
				$dec->bindValue(':ultimoid', $ultimoid, PDO::PARAM_STR);
				$dec->bindValue(':phcid', $row->legprenatal_id, PDO::PARAM_STR);
				$dec->bindValue(':empnrodocto', $row->legempleado_nrodocto, PDO::PARAM_STR);
				$dec->bindValue(':empapellido', $datosempleado->legempleado_apellido, PDO::PARAM_STR);
				$dec->bindValue(':empnombres', $datosempleado->legempleado_nombres, PDO::PARAM_STR);
				$dec->bindValue(':bennrodocto', $row->legprenatal_benndoc, PDO::PARAM_STR);
				$dec->bindValue(':bennrooficio', $row->legprenatal_bennoficio, PDO::PARAM_STR);
				$dec->bindValue(':benapellido', $row->legprenatal_benapellido, PDO::PARAM_STR);
				$dec->bindValue(':bennombres', $row->legprenatal_bennombres, PDO::PARAM_STR);
				$dec->bindValue(':periodoid', $periodo->periodo_id, PDO::PARAM_STR);
				$dec->bindValue(':ippublica', $ippublica, PDO::PARAM_STR);
				$dec->bindValue(':pcnombre', $pcnombre, PDO::PARAM_STR);
				$dec->bindValue(':pcinformacion', $pcinformacion, PDO::PARAM_STR);
				$dec->bindValue(':usuario', $usuario, PDO::PARAM_STR);
				$dec->execute();

      }
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function PreNatalAOBPasarExe($empleadonrodocto, $beneficiarionrodocto){
		try{
			//----------- Pase Pre Natal -------
			//------------Datos pre natales --------
			$sql = 'SELECT * FROM legajos_prenatal
											WHERE legempleado_nrodocto = ?
											  AND legprenatal_benndoc = ?
												AND legprenatal_activo = 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $empleadonrodocto, PDO::PARAM_STR);
			$dec->bindValue(2, $beneficiarionrodocto, PDO::PARAM_STR);
			$dec->execute();
			$datosprenatales = $dec->fetchAll(PDO::FETCH_OBJ);
			//-----------Datos empleados -----------
			$sql = 'SELECT legempleado_apellido,
										 legempleado_nombres
								FROM legajos_empleado
							 WHERE legempleado_nrodocto = ? LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $empleadonrodocto, PDO::PARAM_STR);
			$dec->execute();
			$datosempleado = $dec->fetch(PDO::FETCH_OBJ);
			//----------Datos de periodo actual -----
			$sql = $this->cn->prepare("SELECT periodo_id
																	 FROM periodos
																	WHERE periodo_cerrado = 1
															 ORDER BY periodo_id DESC LIMIT 1");
			$sql->execute();
			$periodo = $sql->fetch(PDO::FETCH_OBJ);

			foreach($datosprenatales as $row){
				//-------------Verificar si el prenatal esta pasado al menos una vez ---------
				$sql = 'SELECT * FROM asignaciones_familiares
												WHERE asignacion_phc_id = ?
												  AND legempleado_nrodocto = ?
													AND _benndoc = ?';
				$dec = $this->cn->prepare($sql);
				$dec->bindValue(1, $row->legprenatal_id, PDO::PARAM_STR);
				$dec->bindValue(2, $empleadonrodocto, PDO::PARAM_STR);
				$dec->bindValue(3, $beneficiarionrodocto, PDO::PARAM_STR);
				$dec->execute();

				$num = $dec->rowCount();

				if($num > 0 && $num < 10){
					//es mayor a 0, ya esta pasado al menos una vez
					$sql = 'INSERT INTO asignaciones_familiares (asignacion_titular,
																											 asignacion_phc_id,
																											 legempleado_nrodocto,
																											 legempleado_apellido,
																											 legempleado_nombres,
																											 _benndoc,
																											 _bennoficio,
																											 _benapellido,
																											 _bennombres,
																											 leghijo_nrodocto,
																											 leghijo_apellido,
																											 leghijo_nombres,
																											 periodo_id,
																											 liqcod_id,
																											 asignacion_cantidad,
																											 asignacion_importe,
																											 asignacion_reajuste,
																											 asignacion_reajuste_obs,
																											 asignacion_importe_total,
																											 asignacion_estado)
																							  VALUES(2,
																								  		 :phcid,
																											 :empnrodocto,
																											 :empapellido,
																											 :empnombres,
																											 :bennrodocto,
																											 :bennrooficio,
																											 :benapellido,
																											 :bennombres,
																											 0,
																											 "",
																											 "",
																											 :periodoid,
																											 214,
																											 1,
																											 0,
																											 0,
																											 "",
																											 0,
																											 1)';

					$dec = $this->cn->prepare($sql);
					$dec->bindValue(':phcid', $row->legprenatal_id, PDO::PARAM_STR);
					$dec->bindValue(':empnrodocto', $row->legempleado_nrodocto, PDO::PARAM_STR);
					$dec->bindValue(':empapellido', $datosempleado->legempleado_apellido, PDO::PARAM_STR);
					$dec->bindValue(':empnombres', $datosempleado->legempleado_nombres, PDO::PARAM_STR);
					$dec->bindValue(':bennrodocto', $row->legprenatal_benndoc, PDO::PARAM_STR);
					$dec->bindValue(':bennrooficio', $row->legprenatal_bennoficio, PDO::PARAM_STR);
					$dec->bindValue(':benapellido', $row->legprenatal_benapellido, PDO::PARAM_STR);
					$dec->bindValue(':bennombres', $row->legprenatal_bennombres, PDO::PARAM_STR);
					$dec->bindValue(':periodoid', $periodo->periodo_id, PDO::PARAM_STR);
					$dec->execute();
					//----------------obtner ultimo id Insertado -----------
					$ultimoid = $this->cn->lastInsertId();
					//--------------Insert de aditoria de asignaciones ---------------------------
					$ippublica = $_SERVER["REMOTE_ADDR"];
					$pcnombre = gethostbyaddr($_SERVER['REMOTE_ADDR']);
					$pcinformacion = $_SERVER['HTTP_USER_AGENT'];
					$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];

					$sql = 'INSERT INTO aud_asignaciones_familiares (AUD_asignacion_id,
																													 AUD_asignacion_titular,
																													 AUD_asignacion_phc_id,
																													 AUD_legempleado_nrodocto,
																													 AUD_legempleado_apellido,
																													 AUD_legempleado_nombres,
																													 AUD_benndoc,
																													 AUD_bennoficio,
																													 AUD_benapellido,
																													 AUD_bennombres,
																													 AUD_leghijo_nrodocto,
																													 AUD_leghijo_apellido,
																													 AUD_leghijo_nombres,
																													 AUD_periodo_id,
																													 AUD_liqcod_id,
																													 AUD_asignacion_cantidad,
																													 AUD_asignacion_importe,
																													 AUD_asignacion_reajuste,
																													 AUD_asignacion_reajuste_obs,
																													 AUD_asignacion_importe_total,
																													 AUD_asignacion_estado,
																													 AUD_asignacion_observacion,
																													 AUD_asignacion_ippublica,
																													 AUD_asignacion_pcnombre,
																													 AUD_asignacion_pcinformacion,
																													 AUD_asignacion_accion,
																													 AUD_asignacion_datetime,
																													 AUD_asignacion_usuario)
																									  VALUES(:ultimoid,
																										 			 2,
																										  		 :phcid,
																													 :empnrodocto,
																													 :empapellido,
																													 :empnombres,
																													 :bennrodocto,
																													 :bennrooficio,
																													 :benapellido,
																													 :bennombres,
																													 0,
																													 "",
																													 "",
																													 :periodoid,
																													 214,
																													 1,
																													 0,
																													 0,
																													 "",
																													 0,
																													 1,
																													 "",
																													 :ippublica,
																													 :pcnombre,
																													 :pcinformacion,
																													 "INSERT",
																													 NOW(),
																													 :usuario)';

					$dec = $this->cn->prepare($sql);
					$dec->bindValue(':ultimoid', $ultimoid, PDO::PARAM_STR);
					$dec->bindValue(':phcid', $row->legprenatal_id, PDO::PARAM_STR);
					$dec->bindValue(':empnrodocto', $row->legempleado_nrodocto, PDO::PARAM_STR);
					$dec->bindValue(':empapellido', $datosempleado->legempleado_apellido, PDO::PARAM_STR);
					$dec->bindValue(':empnombres', $datosempleado->legempleado_nombres, PDO::PARAM_STR);
					$dec->bindValue(':bennrodocto', $row->legprenatal_benndoc, PDO::PARAM_STR);
					$dec->bindValue(':bennrooficio', $row->legprenatal_bennoficio, PDO::PARAM_STR);
					$dec->bindValue(':benapellido', $row->legprenatal_benapellido, PDO::PARAM_STR);
					$dec->bindValue(':bennombres', $row->legprenatal_bennombres, PDO::PARAM_STR);
					$dec->bindValue(':periodoid', $periodo->periodo_id, PDO::PARAM_STR);
					$dec->bindValue(':ippublica', $ippublica, PDO::PARAM_STR);
					$dec->bindValue(':pcnombre', $pcnombre, PDO::PARAM_STR);
					$dec->bindValue(':pcinformacion', $pcinformacion, PDO::PARAM_STR);
					$dec->bindValue(':usuario', $usuario, PDO::PARAM_STR);
					$dec->execute();

				}else{
					//No es mayor a 0,nunca tuvo un pase a liquidaciones, se pasa por primera vez
					$sql = 'INSERT INTO asignaciones_familiares (asignacion_titular,
																											 asignacion_phc_id,
																											 legempleado_nrodocto,
																											 legempleado_apellido,
																											 legempleado_nombres,
																											 _benndoc,
																											 _bennoficio,
																											 _benapellido,
																											 _bennombres,
																											 leghijo_nrodocto,
																											 leghijo_apellido,
																											 leghijo_nombres,
																											 periodo_id,
																											 liqcod_id,
																											 asignacion_cantidad,
																											 asignacion_importe,
																											 asignacion_reajuste,
																											 asignacion_reajuste_obs,
																											 asignacion_importe_total,
																											 asignacion_estado)
																							  VALUES(2,
																								  		 :phcid,
																											 :empnrodocto,
																											 :empapellido,
																											 :empnombres,
																											 :bennrodocto,
																											 :bennrooficio,
																											 :benapellido,
																											 :bennombres,
																											 0,
																											 "",
																											 "",
																											 :periodoid,
																											 214,
																											 1,
																											 0,
																											 0,
																											 "",
																											 0,
																											 1)';

					$dec = $this->cn->prepare($sql);
					$dec->bindValue(':phcid', $row->legprenatal_id, PDO::PARAM_STR);
					$dec->bindValue(':empnrodocto', $row->legempleado_nrodocto, PDO::PARAM_STR);
					$dec->bindValue(':empapellido', $datosempleado->legempleado_apellido, PDO::PARAM_STR);
					$dec->bindValue(':empnombres', $datosempleado->legempleado_nombres, PDO::PARAM_STR);
					$dec->bindValue(':bennrodocto', $row->legprenatal_benndoc, PDO::PARAM_STR);
					$dec->bindValue(':bennrooficio', $row->legprenatal_bennoficio, PDO::PARAM_STR);
					$dec->bindValue(':benapellido', $row->legprenatal_benapellido, PDO::PARAM_STR);
					$dec->bindValue(':bennombres', $row->legprenatal_bennombres, PDO::PARAM_STR);
					$dec->bindValue(':periodoid', $periodo->periodo_id, PDO::PARAM_STR);
					$dec->execute();
					//----------------obtner ultimo id Insertado -----------
					$ultimoid = $this->cn->lastInsertId();
					//--------------Insert de aditoria de asignaciones ---------------------------
					$ippublica = $_SERVER["REMOTE_ADDR"];
					$pcnombre = gethostbyaddr($_SERVER['REMOTE_ADDR']);
					$pcinformacion = $_SERVER['HTTP_USER_AGENT'];
					$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];

					$sql = 'INSERT INTO aud_asignaciones_familiares (AUD_asignacion_id,
																													 AUD_asignacion_titular,
																													 AUD_asignacion_phc_id,
																													 AUD_legempleado_nrodocto,
																													 AUD_legempleado_apellido,
																													 AUD_legempleado_nombres,
																													 AUD_benndoc,
																													 AUD_bennoficio,
																													 AUD_benapellido,
																													 AUD_bennombres,
																													 AUD_leghijo_nrodocto,
																													 AUD_leghijo_apellido,
																													 AUD_leghijo_nombres,
																													 AUD_periodo_id,
																													 AUD_liqcod_id,
																													 AUD_asignacion_cantidad,
																													 AUD_asignacion_importe,
																													 AUD_asignacion_reajuste,
																													 AUD_asignacion_reajuste_obs,
																													 AUD_asignacion_importe_total,
																													 AUD_asignacion_estado,
																													 AUD_asignacion_observacion,
																													 AUD_asignacion_ippublica,
																													 AUD_asignacion_pcnombre,
																													 AUD_asignacion_pcinformacion,
																													 AUD_asignacion_accion,
																													 AUD_asignacion_datetime,
																													 AUD_asignacion_usuario)
																									  VALUES(:ultimoid,
																										 			 2,
																										  		 :phcid,
																													 :empnrodocto,
																													 :empapellido,
																													 :empnombres,
																													 :bennrodocto,
																													 :bennrooficio,
																													 :benapellido,
																													 :bennombres,
																													 0,
																													 "",
																													 "",
																													 :periodoid,
																													 214,
																													 1,
																													 0,
																													 0,
																													 "",
																													 0,
																													 1,
																													 "",
																													 :ippublica,
																													 :pcnombre,
																													 :pcinformacion,
																													 "INSERT",
																													 NOW(),
																													 :usuario)';

					$dec = $this->cn->prepare($sql);
					$dec->bindValue(':ultimoid', $ultimoid, PDO::PARAM_STR);
					$dec->bindValue(':phcid', $row->legprenatal_id, PDO::PARAM_STR);
					$dec->bindValue(':empnrodocto', $row->legempleado_nrodocto, PDO::PARAM_STR);
					$dec->bindValue(':empapellido', $datosempleado->legempleado_apellido, PDO::PARAM_STR);
					$dec->bindValue(':empnombres', $datosempleado->legempleado_nombres, PDO::PARAM_STR);
					$dec->bindValue(':bennrodocto', $row->legprenatal_benndoc, PDO::PARAM_STR);
					$dec->bindValue(':bennrooficio', $row->legprenatal_bennoficio, PDO::PARAM_STR);
					$dec->bindValue(':benapellido', $row->legprenatal_benapellido, PDO::PARAM_STR);
					$dec->bindValue(':bennombres', $row->legprenatal_bennombres, PDO::PARAM_STR);
					$dec->bindValue(':periodoid', $periodo->periodo_id, PDO::PARAM_STR);
					$dec->bindValue(':ippublica', $ippublica, PDO::PARAM_STR);
					$dec->bindValue(':pcnombre', $pcnombre, PDO::PARAM_STR);
					$dec->bindValue(':pcinformacion', $pcinformacion, PDO::PARAM_STR);
					$dec->bindValue(':usuario', $usuario, PDO::PARAM_STR);
					$dec->execute();
				}
      }
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function HijoMenorAOBPasarExe($empleadonrodocto, $beneficiarionrodocto, $fecha_actual, $fecha_final){
		try{

			$sql = 'SELECT * FROM legajos_hijo
											WHERE legempleado_nrodocto = ?
											  AND leghijo_benndoc = ?
												AND leghijo_esc != 1
												AND leghijo_fecnacto
												BETWEEN ? AND ?
												AND leghijo_estado != 2
												AND leghijo_activo = 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $empleadonrodocto, PDO::PARAM_STR);
			$dec->bindValue(2, $beneficiarionrodocto, PDO::PARAM_STR);
			$dec->bindValue(3, $fecha_final, PDO::PARAM_STR);
			$dec->bindValue(4, $fecha_actual, PDO::PARAM_STR);
			$dec->execute();

			$num = $dec->rowCount();
			if($num > 0){
				//--- Tiene Hijos Menores OB---
				$rows = $dec->fetchAll(PDO::FETCH_OBJ);
				//--- Datos Empleados ---
				$sql = 'SELECT legempleado_apellido,
											 legempleado_nombres
									FROM legajos_empleado
								 WHERE legempleado_nrodocto = ? LIMIT 1';
				$dec = $this->cn->prepare($sql);
				$dec->bindValue(1, $empleadonrodocto, PDO::PARAM_STR);
				$dec->execute();
				$datosempleado = $dec->fetch(PDO::FETCH_OBJ);
				//-- Datos Periodos ---
				$sql = $this->cn->prepare("SELECT periodo_id
																		 FROM periodos
																		WHERE periodo_cerrado = 1
																 ORDER BY periodo_id DESC LIMIT 1");
				$sql->execute();
				$periodo = $sql->fetch(PDO::FETCH_OBJ);

				foreach($rows as $row){
					$sql = 'INSERT INTO asignaciones_familiares (asignacion_titular,
																											 asignacion_phc_id,
																											 legempleado_nrodocto,
																											 legempleado_apellido,
																											 legempleado_nombres,
																											 _benndoc,
																											 _bennoficio,
																											 _benapellido,
																											 _bennombres,
																											 leghijo_nrodocto,
																											 leghijo_apellido,
																											 leghijo_nombres,
																											 periodo_id,
																											 liqcod_id,
																											 asignacion_cantidad,
																											 asignacion_importe,
																											 asignacion_reajuste,
																											 asignacion_reajuste_obs,
																											 asignacion_importe_total,
																											 asignacion_estado)
																							  VALUES(2,
																								  		 :phcid,
																											 :empnrodocto,
																											 :empapellido,
																											 :empnombres,
																											 :bennrodocto,
																											 :bennrooficio,
																											 :benapellido,
																											 :bennombres,
																											 :hijonrodocto,
																											 :hijoapellido,
																											 :hijonombres,
																											 :periodoid,
																											 201,
																											 1,
																											 0,
																											 0,
																											 "",
																											 0,
																											 1)';

					$dec = $this->cn->prepare($sql);
					$dec->bindValue(':phcid', $row->leghijo_id, PDO::PARAM_STR);
					$dec->bindValue(':empnrodocto', $row->legempleado_nrodocto, PDO::PARAM_STR);
					$dec->bindValue(':empapellido', $datosempleado->legempleado_apellido, PDO::PARAM_STR);
					$dec->bindValue(':empnombres', $datosempleado->legempleado_nombres, PDO::PARAM_STR);
					$dec->bindValue(':bennrodocto', $row->leghijo_benndoc, PDO::PARAM_STR);
					$dec->bindValue(':bennrooficio', $row->leghijo_bennoficio, PDO::PARAM_STR);
					$dec->bindValue(':benapellido', $row->leghijo_benapellido, PDO::PARAM_STR);
					$dec->bindValue(':bennombres', $row->leghijo_bennombres, PDO::PARAM_STR);
					$dec->bindValue(':hijonrodocto', $row->leghijo_nrodocto, PDO::PARAM_STR);
					$dec->bindValue(':hijoapellido', $row->leghijo_apellido, PDO::PARAM_STR);
					$dec->bindValue(':hijonombres', $row->leghijo_nombres, PDO::PARAM_STR);
					$dec->bindValue(':periodoid', $periodo->periodo_id, PDO::PARAM_STR);
					$dec->execute();
					//----------------obtner ultimo id Insertado -----------
					$ultimoid = $this->cn->lastInsertId();
					//--------------Insert de aditoria de asignaciones ---------------------------
					$ippublica = $_SERVER["REMOTE_ADDR"];
					$pcnombre = gethostbyaddr($_SERVER['REMOTE_ADDR']);
					$pcinformacion = $_SERVER['HTTP_USER_AGENT'];
					$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];

					$sql = 'INSERT INTO aud_asignaciones_familiares (AUD_asignacion_id,
																													 AUD_asignacion_titular,
																													 AUD_asignacion_phc_id,
																													 AUD_legempleado_nrodocto,
																													 AUD_legempleado_apellido,
																													 AUD_legempleado_nombres,
																													 AUD_benndoc,
																													 AUD_bennoficio,
																													 AUD_benapellido,
																													 AUD_bennombres,
																													 AUD_leghijo_nrodocto,
																													 AUD_leghijo_apellido,
																													 AUD_leghijo_nombres,
																													 AUD_periodo_id,
																													 AUD_liqcod_id,
																													 AUD_asignacion_cantidad,
																													 AUD_asignacion_importe,
																													 AUD_asignacion_reajuste,
																													 AUD_asignacion_reajuste_obs,
																													 AUD_asignacion_importe_total,
																													 AUD_asignacion_estado,
																													 AUD_asignacion_observacion,
																													 AUD_asignacion_ippublica,
																													 AUD_asignacion_pcnombre,
																													 AUD_asignacion_pcinformacion,
																													 AUD_asignacion_accion,
																													 AUD_asignacion_datetime,
																													 AUD_asignacion_usuario)
																									  VALUES(:ultimoid,
																										 			 2,
																										  		 :phcid,
																													 :empnrodocto,
																													 :empapellido,
																													 :empnombres,
																													 :bennrodocto,
																													 :bennrooficio,
																													 :benapellido,
																													 :bennombres,
																													 :hijonrodocto,
																													 :hijoapellido,
																													 :hijonombres,
																													 :periodoid,
																													 201,
																													 1,
																													 0,
																													 0,
																													 "",
																													 0,
																													 1,
																													 "",
																													 :ippublica,
																													 :pcnombre,
																													 :pcinformacion,
																													 "INSERT",
																													 NOW(),
																													 :usuario)';

					$dec = $this->cn->prepare($sql);
					$dec->bindValue(':ultimoid', $ultimoid, PDO::PARAM_STR);
					$dec->bindValue(':phcid', $row->leghijo_id, PDO::PARAM_STR);
					$dec->bindValue(':empnrodocto', $row->legempleado_nrodocto, PDO::PARAM_STR);
					$dec->bindValue(':empapellido', $datosempleado->legempleado_apellido, PDO::PARAM_STR);
					$dec->bindValue(':empnombres', $datosempleado->legempleado_nombres, PDO::PARAM_STR);
					$dec->bindValue(':bennrodocto', $row->leghijo_benndoc, PDO::PARAM_STR);
					$dec->bindValue(':bennrooficio', $row->leghijo_bennoficio, PDO::PARAM_STR);
					$dec->bindValue(':benapellido', $row->leghijo_benapellido, PDO::PARAM_STR);
					$dec->bindValue(':bennombres', $row->leghijo_bennombres, PDO::PARAM_STR);
					$dec->bindValue(':hijonrodocto', $row->leghijo_nrodocto, PDO::PARAM_STR);
					$dec->bindValue(':hijoapellido', $row->leghijo_apellido, PDO::PARAM_STR);
					$dec->bindValue(':hijonombres', $row->leghijo_nombres, PDO::PARAM_STR);
					$dec->bindValue(':periodoid', $periodo->periodo_id, PDO::PARAM_STR);
					$dec->bindValue(':ippublica', $ippublica, PDO::PARAM_STR);
					$dec->bindValue(':pcnombre', $pcnombre, PDO::PARAM_STR);
					$dec->bindValue(':pcinformacion', $pcinformacion, PDO::PARAM_STR);
					$dec->bindValue(':usuario', $usuario, PDO::PARAM_STR);
					$dec->execute();
				}
			}else{
				//--- No tiene Hijos Menores OB
			}

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function PreEscolarAOBPasarExe($empleadonrodocto, $beneficiarionrodocto, $escuelanivel){
		try{
			//-----------obtener datos de preescolar -------
			$sql = 'SELECT * FROM legajos_hijo
											WHERE legempleado_nrodocto = ?
											  AND leghijo_benndoc = ?
												AND escnivel_id  = ?
												AND leghijo_esc = 1
												AND leghijo_disc != 1
												AND leghijo_estado != 2
												AND leghijo_activo = 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $empleadonrodocto, PDO::PARAM_STR);
			$dec->bindValue(2, $beneficiarionrodocto, PDO::PARAM_STR);
			$dec->bindValue(3, $escuelanivel, PDO::PARAM_STR);
			$dec->execute();

			$num = $dec->rowCount();
			if($num > 0){
				//--- Tiene Hijos Preescolares OB---
				$rows = $dec->fetchAll(PDO::FETCH_OBJ);
				//--- Datos Empleados ---
				$sql = 'SELECT legempleado_apellido,
											 legempleado_nombres
									FROM legajos_empleado
								 WHERE legempleado_nrodocto = ? LIMIT 1';
				$dec = $this->cn->prepare($sql);
				$dec->bindValue(1, $empleadonrodocto, PDO::PARAM_STR);
				$dec->execute();
				$datosempleado = $dec->fetch(PDO::FETCH_OBJ);
				//-- Datos Periodos ---
				$sql = $this->cn->prepare("SELECT periodo_id
																		 FROM periodos
																		WHERE periodo_cerrado = 1
																 ORDER BY periodo_id DESC LIMIT 1");
				$sql->execute();
				$periodo = $sql->fetch(PDO::FETCH_OBJ);

				foreach($rows as $row){
					$sql = 'INSERT INTO asignaciones_familiares (asignacion_titular,
																											 asignacion_phc_id,
																											 legempleado_nrodocto,
																											 legempleado_apellido,
																											 legempleado_nombres,
																											 _benndoc,
																											 _bennoficio,
																											 _benapellido,
																											 _bennombres,
																											 leghijo_nrodocto,
																											 leghijo_apellido,
																											 leghijo_nombres,
																											 periodo_id,
																											 liqcod_id,
																											 asignacion_cantidad,
																											 asignacion_importe,
																											 asignacion_reajuste,
																											 asignacion_reajuste_obs,
																											 asignacion_importe_total,
																											 asignacion_estado)
																							  VALUES(2,
																								  		 :phcid,
																											 :empnrodocto,
																											 :empapellido,
																											 :empnombres,
																											 :bennrodocto,
																											 :bennrooficio,
																											 :benapellido,
																											 :bennombres,
																											 :hijonrodocto,
																											 :hijoapellido,
																											 :hijonombres,
																											 :periodoid,
																											 204,
																											 1,
																											 0,
																											 0,
																											 "",
																											 0,
																											 1)';

					$dec = $this->cn->prepare($sql);
					$dec->bindValue(':phcid', $row->leghijo_id, PDO::PARAM_STR);
					$dec->bindValue(':empnrodocto', $row->legempleado_nrodocto, PDO::PARAM_STR);
					$dec->bindValue(':empapellido', $datosempleado->legempleado_apellido, PDO::PARAM_STR);
					$dec->bindValue(':empnombres', $datosempleado->legempleado_nombres, PDO::PARAM_STR);
					$dec->bindValue(':bennrodocto', $row->leghijo_benndoc, PDO::PARAM_STR);
					$dec->bindValue(':bennrooficio', $row->leghijo_bennoficio, PDO::PARAM_STR);
					$dec->bindValue(':benapellido', $row->leghijo_benapellido, PDO::PARAM_STR);
					$dec->bindValue(':bennombres', $row->leghijo_bennombres, PDO::PARAM_STR);
					$dec->bindValue(':hijonrodocto', $row->leghijo_nrodocto, PDO::PARAM_STR);
					$dec->bindValue(':hijoapellido', $row->leghijo_apellido, PDO::PARAM_STR);
					$dec->bindValue(':hijonombres', $row->leghijo_nombres, PDO::PARAM_STR);
					$dec->bindValue(':periodoid', $periodo->periodo_id, PDO::PARAM_STR);
					$dec->execute();
					//----------------obtner ultimo id Insertado -----------
					$ultimoid = $this->cn->lastInsertId();
					//--------------Insert de aditoria de asignaciones ---------------------------
					$ippublica = $_SERVER["REMOTE_ADDR"];
					$pcnombre = gethostbyaddr($_SERVER['REMOTE_ADDR']);
					$pcinformacion = $_SERVER['HTTP_USER_AGENT'];
					$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];

					$sql = 'INSERT INTO aud_asignaciones_familiares (AUD_asignacion_id,
																								AUD_asignacion_titular,
																								AUD_asignacion_phc_id,
																								AUD_legempleado_nrodocto,
																								AUD_legempleado_apellido,
																								AUD_legempleado_nombres,
																								AUD_benndoc,
																								AUD_bennoficio,
																								AUD_benapellido,
																								AUD_bennombres,
																								AUD_leghijo_nrodocto,
																								AUD_leghijo_apellido,
																								AUD_leghijo_nombres,
																								AUD_periodo_id,
																								AUD_liqcod_id,
																								AUD_asignacion_cantidad,
																								AUD_asignacion_importe,
																								AUD_asignacion_reajuste,
																								AUD_asignacion_reajuste_obs,
																								AUD_asignacion_importe_total,
																								AUD_asignacion_estado,
																								AUD_asignacion_observacion,
																								AUD_asignacion_ippublica,
																								AUD_asignacion_pcnombre,
																								AUD_asignacion_pcinformacion,
																								AUD_asignacion_accion,
																								AUD_asignacion_datetime,
																								AUD_asignacion_usuario)
																				 VALUES(:ultimoid,
																					 			2,
																					  		:phcid,
																								:empnrodocto,
																								:empapellido,
																								:empnombres,
																								:bennrodocto,
																								:bennrooficio,
																								:benapellido,
																								:bennombres,
																								:hijonrodocto,
																								:hijoapellido,
																								:hijonombres,
																								:periodoid,
																								204,
																								1,
																								0,
																								0,
																								"",
																								0,
																								1,
																								"",
																								:ippublica,
																								:pcnombre,
																								:pcinformacion,
																								"INSERT",
																								NOW(),
																								:usuario)';

					$dec = $this->cn->prepare($sql);
					$dec->bindValue(':ultimoid', $ultimoid, PDO::PARAM_STR);
					$dec->bindValue(':phcid', $row->leghijo_id, PDO::PARAM_STR);
					$dec->bindValue(':empnrodocto', $row->legempleado_nrodocto, PDO::PARAM_STR);
					$dec->bindValue(':empapellido', $datosempleado->legempleado_apellido, PDO::PARAM_STR);
					$dec->bindValue(':empnombres', $datosempleado->legempleado_nombres, PDO::PARAM_STR);
					$dec->bindValue(':bennrodocto', $row->leghijo_benndoc, PDO::PARAM_STR);
					$dec->bindValue(':bennrooficio', $row->leghijo_bennoficio, PDO::PARAM_STR);
					$dec->bindValue(':benapellido', $row->leghijo_benapellido, PDO::PARAM_STR);
					$dec->bindValue(':bennombres', $row->leghijo_bennombres, PDO::PARAM_STR);
					$dec->bindValue(':hijonrodocto', $row->leghijo_nrodocto, PDO::PARAM_STR);
					$dec->bindValue(':hijoapellido', $row->leghijo_apellido, PDO::PARAM_STR);
					$dec->bindValue(':hijonombres', $row->leghijo_nombres, PDO::PARAM_STR);
					$dec->bindValue(':periodoid', $periodo->periodo_id, PDO::PARAM_STR);
					$dec->bindValue(':ippublica', $ippublica, PDO::PARAM_STR);
					$dec->bindValue(':pcnombre', $pcnombre, PDO::PARAM_STR);
					$dec->bindValue(':pcinformacion', $pcinformacion, PDO::PARAM_STR);
					$dec->bindValue(':usuario', $usuario, PDO::PARAM_STR);
					$dec->execute();
				}
			}else{
				//--- No tiene Hijos Pre-escolares OB ----
			}

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function PrimariaAOBPasarExe($empleadonrodocto, $beneficiarionrodocto, $escuelanivel){
		try{

			$sql = 'SELECT * FROM legajos_hijo
											WHERE legempleado_nrodocto = ?
											  AND leghijo_benndoc = ?
												AND escnivel_id  = ?
												AND leghijo_esc = 1
												AND leghijo_disc != 1
												AND leghijo_estado != 2
												AND leghijo_activo = 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $empleadonrodocto, PDO::PARAM_STR);
			$dec->bindValue(2, $beneficiarionrodocto, PDO::PARAM_STR);
			$dec->bindValue(3, $escuelanivel, PDO::PARAM_STR);
			$dec->execute();

			$num = $dec->rowCount();
			if($num > 0){
				//--- Tiene Hijos Primaria OB---
				$rows = $dec->fetchAll(PDO::FETCH_OBJ);
				//--- Datos Empleados ---
				$sql = 'SELECT legempleado_apellido,
											 legempleado_nombres
								  FROM legajos_empleado
								 WHERE legempleado_nrodocto = ? LIMIT 1';
				$dec = $this->cn->prepare($sql);
				$dec->bindValue(1, $empleadonrodocto, PDO::PARAM_STR);
				$dec->execute();
				$datosempleado = $dec->fetch(PDO::FETCH_OBJ);
				//-- Datos Periodos ---
				$sql = $this->cn->prepare("SELECT periodo_id
					 													 FROM periodos
																		WHERE periodo_cerrado = 1
																 ORDER BY periodo_id DESC LIMIT 1");
				$sql->execute();
				$periodo = $sql->fetch(PDO::FETCH_OBJ);

				foreach($rows as $row){
					$sql = 'INSERT INTO asignaciones_familiares (asignacion_titular,
																						asignacion_phc_id,
																						legempleado_nrodocto,
																						legempleado_apellido,
																						legempleado_nombres,
																						_benndoc,
																						_bennoficio,
																						_benapellido,
																						_bennombres,
																						leghijo_nrodocto,
																						leghijo_apellido,
																						leghijo_nombres,
																						periodo_id,
																						liqcod_id,
																						asignacion_cantidad,
																						asignacion_importe,
																						asignacion_reajuste,
																						asignacion_reajuste_obs,
																						asignacion_importe_total,
																						asignacion_estado)
																		 VALUES(2,
																			  		:phcid,
																						:empnrodocto,
																						:empapellido,
																						:empnombres,
																						:bennrodocto,
																						:bennrooficio,
																						:benapellido,
																						:bennombres,
																						:hijonrodocto,
																						:hijoapellido,
																						:hijonombres,
																						:periodoid,
																						206,
																						1,
																						0,
																						0,
																						"",
																						0,
																						1)';

					$dec = $this->cn->prepare($sql);
					$dec->bindValue(':phcid', $row->leghijo_id, PDO::PARAM_STR);
					$dec->bindValue(':empnrodocto', $row->legempleado_nrodocto, PDO::PARAM_STR);
					$dec->bindValue(':empapellido', $datosempleado->legempleado_apellido, PDO::PARAM_STR);
					$dec->bindValue(':empnombres', $datosempleado->legempleado_nombres, PDO::PARAM_STR);
					$dec->bindValue(':bennrodocto', $row->leghijo_benndoc, PDO::PARAM_STR);
					$dec->bindValue(':bennrooficio', $row->leghijo_bennoficio, PDO::PARAM_STR);
					$dec->bindValue(':benapellido', $row->leghijo_benapellido, PDO::PARAM_STR);
					$dec->bindValue(':bennombres', $row->leghijo_bennombres, PDO::PARAM_STR);
					$dec->bindValue(':hijonrodocto', $row->leghijo_nrodocto, PDO::PARAM_STR);
					$dec->bindValue(':hijoapellido', $row->leghijo_apellido, PDO::PARAM_STR);
					$dec->bindValue(':hijonombres', $row->leghijo_nombres, PDO::PARAM_STR);
					$dec->bindValue(':periodoid', $periodo->periodo_id, PDO::PARAM_STR);
					$dec->execute();
					//----------------obtner ultimo id Insertado -----------
					$ultimoid = $this->cn->lastInsertId();
					//--------------Insert de aditoria de asignaciones ---------------------------
					$ippublica = $_SERVER["REMOTE_ADDR"];
					$pcnombre = gethostbyaddr($_SERVER['REMOTE_ADDR']);
					$pcinformacion = $_SERVER['HTTP_USER_AGENT'];
					$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];

					$sql = 'INSERT INTO aud_asignaciones_familiares (AUD_asignacion_id,
																								AUD_asignacion_titular,
																								AUD_asignacion_phc_id,
																								AUD_legempleado_nrodocto,
																								AUD_legempleado_apellido,
																								AUD_legempleado_nombres,
																								AUD_benndoc,
																								AUD_bennoficio,
																								AUD_benapellido,
																								AUD_bennombres,
																								AUD_leghijo_nrodocto,
																								AUD_leghijo_apellido,
																								AUD_leghijo_nombres,
																								AUD_periodo_id,
																								AUD_liqcod_id,
																								AUD_asignacion_cantidad,
																								AUD_asignacion_importe,
																								AUD_asignacion_reajuste,
																								AUD_asignacion_reajuste_obs,
																								AUD_asignacion_importe_total,
																								AUD_asignacion_estado,
																								AUD_asignacion_observacion,
																								AUD_asignacion_ippublica,
																								AUD_asignacion_pcnombre,
																								AUD_asignacion_pcinformacion,
																								AUD_asignacion_accion,
																								AUD_asignacion_datetime,
																								AUD_asignacion_usuario)
																				 VALUES(:ultimoid,
																					 			2,
																					  		:phcid,
																								:empnrodocto,
																								:empapellido,
																								:empnombres,
																								:bennrodocto,
																								:bennrooficio,
																								:benapellido,
																								:bennombres,
																								:hijonrodocto,
																								:hijoapellido,
																								:hijonombres,
																								:periodoid,
																								206,
																								1,
																								0,
																								0,
																								"",
																								0,
																								1,
																								"",
																								:ippublica,
																								:pcnombre,
																								:pcinformacion,
																								"INSERT",
																								NOW(),
																								:usuario)';

					$dec = $this->cn->prepare($sql);
					$dec->bindValue(':ultimoid', $ultimoid, PDO::PARAM_STR);
					$dec->bindValue(':phcid', $row->leghijo_id, PDO::PARAM_STR);
					$dec->bindValue(':empnrodocto', $row->legempleado_nrodocto, PDO::PARAM_STR);
					$dec->bindValue(':empapellido', $datosempleado->legempleado_apellido, PDO::PARAM_STR);
					$dec->bindValue(':empnombres', $datosempleado->legempleado_nombres, PDO::PARAM_STR);
					$dec->bindValue(':bennrodocto', $row->leghijo_benndoc, PDO::PARAM_STR);
					$dec->bindValue(':bennrooficio', $row->leghijo_bennoficio, PDO::PARAM_STR);
					$dec->bindValue(':benapellido', $row->leghijo_benapellido, PDO::PARAM_STR);
					$dec->bindValue(':bennombres', $row->leghijo_bennombres, PDO::PARAM_STR);
					$dec->bindValue(':hijonrodocto', $row->leghijo_nrodocto, PDO::PARAM_STR);
					$dec->bindValue(':hijoapellido', $row->leghijo_apellido, PDO::PARAM_STR);
					$dec->bindValue(':hijonombres', $row->leghijo_nombres, PDO::PARAM_STR);
					$dec->bindValue(':periodoid', $periodo->periodo_id, PDO::PARAM_STR);
					$dec->bindValue(':ippublica', $ippublica, PDO::PARAM_STR);
					$dec->bindValue(':pcnombre', $pcnombre, PDO::PARAM_STR);
					$dec->bindValue(':pcinformacion', $pcinformacion, PDO::PARAM_STR);
					$dec->bindValue(':usuario', $usuario, PDO::PARAM_STR);
					$dec->execute();
				}
			}else{
				//--- No tiene Hijos En escuela primaria OB
			}

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function SecYSupAOBPasarExe($empleadonrodocto, $beneficiarionrodocto, $escuelanivel){
		try{

			$sql = 'SELECT * FROM legajos_hijo
											WHERE legempleado_nrodocto = ?
												AND leghijo_benndoc = ?
												AND escnivel_id  = ?
												AND leghijo_esc = 1
												AND leghijo_disc != 1
												AND leghijo_estado != 2
												AND leghijo_activo = 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $empleadonrodocto, PDO::PARAM_STR);
			$dec->bindValue(2, $beneficiarionrodocto, PDO::PARAM_STR);
			$dec->bindValue(3, $escuelanivel, PDO::PARAM_STR);
			$dec->execute();

			$num = $dec->rowCount();
			if($num > 0){
				//--- Tiene Hijos en escuela secundaria y superior---
				$rows = $dec->fetchAll(PDO::FETCH_OBJ);
				//--- Datos Empleados ---
				$sql = 'SELECT legempleado_apellido,
											 legempleado_nombres
									FROM legajos_empleado
								 WHERE legempleado_nrodocto = ? LIMIT 1';
				$cel = $this->cn->prepare($sql);
				$cel->bindValue(1, $empleadonrodocto, PDO::PARAM_STR);
				$cel->execute();
				$datosempleado = $cel->fetch(PDO::FETCH_OBJ);
				//-- Datos Periodos ---
				$sql = $this->cn->prepare("SELECT periodo_id
																		 FROM periodos
																		WHERE periodo_cerrado = 1
																 ORDER BY periodo_id DESC LIMIT 1");
				$sql->execute();
				$periodo = $sql->fetch(PDO::FETCH_OBJ);

				foreach($rows as $row){
					$sql = 'INSERT INTO asignaciones_familiares (asignacion_titular,
																						asignacion_phc_id,
																						legempleado_nrodocto,
																						legempleado_apellido,
																						legempleado_nombres,
																						_benndoc,
																						_bennoficio,
																						_benapellido,
																						_bennombres,
																						leghijo_nrodocto,
																						leghijo_apellido,
																						leghijo_nombres,
																						periodo_id,
																						liqcod_id,
																						asignacion_cantidad,
																						asignacion_importe,
																						asignacion_reajuste,
																						asignacion_reajuste_obs,
																						asignacion_importe_total,
																						asignacion_estado)
																		 VALUES(2,
																			  		:phcid,
																						:empnrodocto,
																						:empapellido,
																						:empnombres,
																						:bennrodocto,
																						:bennrooficio,
																						:benapellido,
																						:bennombres,
																						:hijonrodocto,
																						:hijoapellido,
																						:hijonombres,
																						:periodoid,
																						209,
																						1,
																						0,
																						0,
																						"",
																						0,
																						1)';

					$dec = $this->cn->prepare($sql);
					$dec->bindValue(':phcid', $row->leghijo_id, PDO::PARAM_STR);
					$dec->bindValue(':empnrodocto', $row->legempleado_nrodocto, PDO::PARAM_STR);
					$dec->bindValue(':empapellido', $datosempleado->legempleado_apellido, PDO::PARAM_STR);
					$dec->bindValue(':empnombres', $datosempleado->legempleado_nombres, PDO::PARAM_STR);
					$dec->bindValue(':bennrodocto', $row->leghijo_benndoc, PDO::PARAM_STR);
					$dec->bindValue(':bennrooficio', $row->leghijo_bennoficio, PDO::PARAM_STR);
					$dec->bindValue(':benapellido', $row->leghijo_benapellido, PDO::PARAM_STR);
					$dec->bindValue(':bennombres', $row->leghijo_bennombres, PDO::PARAM_STR);
					$dec->bindValue(':hijonrodocto', $row->leghijo_nrodocto, PDO::PARAM_STR);
					$dec->bindValue(':hijoapellido', $row->leghijo_apellido, PDO::PARAM_STR);
					$dec->bindValue(':hijonombres', $row->leghijo_nombres, PDO::PARAM_STR);
					$dec->bindValue(':periodoid', $periodo->periodo_id, PDO::PARAM_STR);
					$dec->execute();
					//----------------obtner ultimo id Insertado -----------
					$ultimoid = $this->cn->lastInsertId();
					//--------------Insert de aditoria de asignaciones ---------------------------
					$ippublica = $_SERVER["REMOTE_ADDR"];
					$pcnombre = gethostbyaddr($_SERVER['REMOTE_ADDR']);
					$pcinformacion = $_SERVER['HTTP_USER_AGENT'];
					$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];

					$sql = 'INSERT INTO aud_asignaciones_familiares (AUD_asignacion_id,
																								AUD_asignacion_titular,
																								AUD_asignacion_phc_id,
																								AUD_legempleado_nrodocto,
																								AUD_legempleado_apellido,
																								AUD_legempleado_nombres,
																								AUD_benndoc,
																								AUD_bennoficio,
																								AUD_benapellido,
																								AUD_bennombres,
																								AUD_leghijo_nrodocto,
																								AUD_leghijo_apellido,
																								AUD_leghijo_nombres,
																								AUD_periodo_id,
																								AUD_liqcod_id,
																								AUD_asignacion_cantidad,
																								AUD_asignacion_importe,
																								AUD_asignacion_reajuste,
																								AUD_asignacion_reajuste_obs,
																								AUD_asignacion_importe_total,
																								AUD_asignacion_estado,
																								AUD_asignacion_observacion,
																								AUD_asignacion_ippublica,
																								AUD_asignacion_pcnombre,
																								AUD_asignacion_pcinformacion,
																								AUD_asignacion_accion,
																								AUD_asignacion_datetime,
																								AUD_asignacion_usuario)
																				 VALUES(:ultimoid,
																					 			2,
																					  		:phcid,
																								:empnrodocto,
																								:empapellido,
																								:empnombres,
																								:bennrodocto,
																								:bennrooficio,
																								:benapellido,
																								:bennombres,
																								:hijonrodocto,
																								:hijoapellido,
																								:hijonombres,
																								:periodoid,
																								209,
																								1,
																								0,
																								0,
																								"",
																								0,
																								1,
																								"",
																								:ippublica,
																								:pcnombre,
																								:pcinformacion,
																								"INSERT",
																								NOW(),
																								:usuario)';

					$dec = $this->cn->prepare($sql);
					$dec->bindValue(':ultimoid', $ultimoid, PDO::PARAM_STR);
					$dec->bindValue(':phcid', $row->leghijo_id, PDO::PARAM_STR);
					$dec->bindValue(':empnrodocto', $row->legempleado_nrodocto, PDO::PARAM_STR);
					$dec->bindValue(':empapellido', $datosempleado->legempleado_apellido, PDO::PARAM_STR);
					$dec->bindValue(':empnombres', $datosempleado->legempleado_nombres, PDO::PARAM_STR);
					$dec->bindValue(':bennrodocto', $row->leghijo_benndoc, PDO::PARAM_STR);
					$dec->bindValue(':bennrooficio', $row->leghijo_bennoficio, PDO::PARAM_STR);
					$dec->bindValue(':benapellido', $row->leghijo_benapellido, PDO::PARAM_STR);
					$dec->bindValue(':bennombres', $row->leghijo_bennombres, PDO::PARAM_STR);
					$dec->bindValue(':hijonrodocto', $row->leghijo_nrodocto, PDO::PARAM_STR);
					$dec->bindValue(':hijoapellido', $row->leghijo_apellido, PDO::PARAM_STR);
					$dec->bindValue(':hijonombres', $row->leghijo_nombres, PDO::PARAM_STR);
					$dec->bindValue(':periodoid', $periodo->periodo_id, PDO::PARAM_STR);
					$dec->bindValue(':ippublica', $ippublica, PDO::PARAM_STR);
					$dec->bindValue(':pcnombre', $pcnombre, PDO::PARAM_STR);
					$dec->bindValue(':pcinformacion', $pcinformacion, PDO::PARAM_STR);
					$dec->bindValue(':usuario', $usuario, PDO::PARAM_STR);
					$dec->execute();
				}
			}else{
				//--- No tiene Hijos En Escuela Secundaria Y Superior OB
			}

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function HijoDiscAOBPasarExe($empleadonrodocto, $beneficiarionrodocto){
		try{

			$sql = 'SELECT * FROM legajos_hijo
											WHERE legempleado_nrodocto = ?
											  AND leghijo_benndoc = ?
												AND leghijo_disc = 1
												AND leghijo_esc = 0
												AND leghijo_estado != 2
												AND leghijo_activo = 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $empleadonrodocto, PDO::PARAM_STR);
			$dec->bindValue(2, $beneficiarionrodocto, PDO::PARAM_STR);
			$dec->execute();

			$num = $dec->rowCount();
			if($num > 0){
				//--- Tiene Hijos Prescolares OB---
				$rows = $dec->fetchAll(PDO::FETCH_OBJ);
				//--- Datos Empleados ---
				$sql = 'SELECT legempleado_apellido,
											 legempleado_nombres
									FROM legajos_empleado
								 WHERE legempleado_nrodocto = ? LIMIT 1';
				$dec = $this->cn->prepare($sql);
				$dec->bindValue(1, $empleadonrodocto, PDO::PARAM_STR);
				$dec->execute();
				$datosempleado = $dec->fetch(PDO::FETCH_OBJ);
				//-- Datos Periodos ---
				$sql = $this->cn->prepare("SELECT periodo_id
																		 FROM periodos
																		WHERE periodo_cerrado = 1
																 ORDER BY periodo_id DESC LIMIT 1");
				$sql->execute();
				$periodo = $sql->fetch(PDO::FETCH_OBJ);

				foreach($rows as $row){
					$sql = 'INSERT INTO asignaciones_familiares (asignacion_titular,
																						asignacion_phc_id,
																						legempleado_nrodocto,
																						legempleado_apellido,
																						legempleado_nombres,
																						_benndoc,
																						_bennoficio,
																						_benapellido,
																						_bennombres,
																						leghijo_nrodocto,
																						leghijo_apellido,
																						leghijo_nombres,
																						periodo_id,
																						liqcod_id,
																						asignacion_cantidad,
																						asignacion_importe,
																						asignacion_reajuste,
																						asignacion_reajuste_obs,
																						asignacion_importe_total,
																						asignacion_estado)
																		 VALUES(2,
																			  		:phcid,
																						:empnrodocto,
																						:empapellido,
																						:empnombres,
																						:bennrodocto,
																						:bennrooficio,
																						:benapellido,
																						:bennombres,
																						:hijonrodocto,
																						:hijoapellido,
																						:hijonombres,
																						:periodoid,
																						202,
																						1,
																						0,
																						0,
																						"",
																						0,
																						1)';

					$dec = $this->cn->prepare($sql);
					$dec->bindValue(':phcid', $row->leghijo_id, PDO::PARAM_STR);
					$dec->bindValue(':empnrodocto', $row->legempleado_nrodocto, PDO::PARAM_STR);
					$dec->bindValue(':empapellido', $datosempleado->legempleado_apellido, PDO::PARAM_STR);
					$dec->bindValue(':empnombres', $datosempleado->legempleado_nombres, PDO::PARAM_STR);
					$dec->bindValue(':bennrodocto', $row->leghijo_benndoc, PDO::PARAM_STR);
					$dec->bindValue(':bennrooficio', $row->leghijo_bennoficio, PDO::PARAM_STR);
					$dec->bindValue(':benapellido', $row->leghijo_benapellido, PDO::PARAM_STR);
					$dec->bindValue(':bennombres', $row->leghijo_bennombres, PDO::PARAM_STR);
					$dec->bindValue(':hijonrodocto', $row->leghijo_nrodocto, PDO::PARAM_STR);
					$dec->bindValue(':hijoapellido', $row->leghijo_apellido, PDO::PARAM_STR);
					$dec->bindValue(':hijonombres', $row->leghijo_nombres, PDO::PARAM_STR);
					$dec->bindValue(':periodoid', $periodo->periodo_id, PDO::PARAM_STR);
					$dec->execute();
					//----------------obtner ultimo id Insertado -----------
					$ultimoid = $this->cn->lastInsertId();
					//--------------Insert de aditoria de asignaciones ---------------------------
					$ippublica = $_SERVER["REMOTE_ADDR"];
					$pcnombre = gethostbyaddr($_SERVER['REMOTE_ADDR']);
					$pcinformacion = $_SERVER['HTTP_USER_AGENT'];
					$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];

					$sql = 'INSERT INTO aud_asignaciones_familiares (AUD_asignacion_id,
																								AUD_asignacion_titular,
																								AUD_asignacion_phc_id,
																								AUD_legempleado_nrodocto,
																								AUD_legempleado_apellido,
																								AUD_legempleado_nombres,
																								AUD_benndoc,
																								AUD_bennoficio,
																								AUD_benapellido,
																								AUD_bennombres,
																								AUD_leghijo_nrodocto,
																								AUD_leghijo_apellido,
																								AUD_leghijo_nombres,
																								AUD_periodo_id,
																								AUD_liqcod_id,
																								AUD_asignacion_cantidad,
																								AUD_asignacion_importe,
																								AUD_asignacion_reajuste,
																								AUD_asignacion_reajuste_obs,
																								AUD_asignacion_importe_total,
																								AUD_asignacion_estado,
																								AUD_asignacion_observacion,
																								AUD_asignacion_ippublica,
																								AUD_asignacion_pcnombre,
																								AUD_asignacion_pcinformacion,
																								AUD_asignacion_accion,
																								AUD_asignacion_datetime,
																								AUD_asignacion_usuario)
																				 VALUES(:ultimoid,
																					 			2,
																					  		:phcid,
																								:empnrodocto,
																								:empapellido,
																								:empnombres,
																								:bennrodocto,
																								:bennrooficio,
																								:benapellido,
																								:bennombres,
																								:hijonrodocto,
																								:hijoapellido,
																								:hijonombres,
																								:periodoid,
																								202,
																								1,
																								0,
																								0,
																								"",
																								0,
																								1,
																								"",
																								:ippublica,
																								:pcnombre,
																								:pcinformacion,
																								"INSERT",
																								NOW(),
																								:usuario)';

					$dec = $this->cn->prepare($sql);
					$dec->bindValue(':ultimoid', $ultimoid, PDO::PARAM_STR);
					$dec->bindValue(':phcid', $row->leghijo_id, PDO::PARAM_STR);
					$dec->bindValue(':empnrodocto', $row->legempleado_nrodocto, PDO::PARAM_STR);
					$dec->bindValue(':empapellido', $datosempleado->legempleado_apellido, PDO::PARAM_STR);
					$dec->bindValue(':empnombres', $datosempleado->legempleado_nombres, PDO::PARAM_STR);
					$dec->bindValue(':bennrodocto', $row->leghijo_benndoc, PDO::PARAM_STR);
					$dec->bindValue(':bennrooficio', $row->leghijo_bennoficio, PDO::PARAM_STR);
					$dec->bindValue(':benapellido', $row->leghijo_benapellido, PDO::PARAM_STR);
					$dec->bindValue(':bennombres', $row->leghijo_bennombres, PDO::PARAM_STR);
					$dec->bindValue(':hijonrodocto', $row->leghijo_nrodocto, PDO::PARAM_STR);
					$dec->bindValue(':hijoapellido', $row->leghijo_apellido, PDO::PARAM_STR);
					$dec->bindValue(':hijonombres', $row->leghijo_nombres, PDO::PARAM_STR);
					$dec->bindValue(':periodoid', $periodo->periodo_id, PDO::PARAM_STR);
					$dec->bindValue(':ippublica', $ippublica, PDO::PARAM_STR);
					$dec->bindValue(':pcnombre', $pcnombre, PDO::PARAM_STR);
					$dec->bindValue(':pcinformacion', $pcinformacion, PDO::PARAM_STR);
					$dec->bindValue(':usuario', $usuario, PDO::PARAM_STR);
					$dec->execute();
				}
			}else{
				//--- No tiene Hijos Menores OB
			}

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function HijoDiscEscAOBPasarExe($empleadonrodocto, $beneficiarionrodocto){
		try{

			$sql = 'SELECT * FROM legajos_hijo
											WHERE legempleado_nrodocto = ?
												AND leghijo_benndoc = ?
												AND leghijo_disc = 1
												AND leghijo_esc = 1
												AND leghijo_estado != 2
												AND leghijo_activo = 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $empleadonrodocto, PDO::PARAM_STR);
			$dec->bindValue(2, $beneficiarionrodocto, PDO::PARAM_STR);
			$dec->execute();

			$num = $dec->rowCount();
			if($num > 0){
				//--- Tiene Hijos Prescolares OB---
				$rows = $dec->fetchAll(PDO::FETCH_OBJ);
				//--- Datos Empleados ---
				$sql = 'SELECT legempleado_apellido,
											 legempleado_nombres
									FROM legajos_empleado
								 WHERE legempleado_nrodocto = ? LIMIT 1';
				$dec = $this->cn->prepare($sql);
				$dec->bindValue(1, $empleadonrodocto, PDO::PARAM_STR);
				$dec->execute();
				$datosempleado = $dec->fetch(PDO::FETCH_OBJ);
				//-- Datos Periodos ---
				$sql = $this->cn->prepare("SELECT periodo_id
																		 FROM periodos
																		WHERE periodo_cerrado = 1
																 ORDER BY periodo_id DESC LIMIT 1");
				$sql->execute();
				$periodo = $sql->fetch(PDO::FETCH_OBJ);

				foreach($rows as $row){
					$sql = 'INSERT INTO asignaciones_familiares (asignacion_titular,
																						asignacion_phc_id,
																						legempleado_nrodocto,
																						legempleado_apellido,
																						legempleado_nombres,
																						_benndoc,
																						_bennoficio,
																						_benapellido,
																						_bennombres,
																						leghijo_nrodocto,
																						leghijo_apellido,
																						leghijo_nombres,
																						periodo_id,
																						liqcod_id,
																						asignacion_cantidad,
																						asignacion_importe,
																						asignacion_reajuste,
																						asignacion_reajuste_obs,
																						asignacion_importe_total,
																						asignacion_estado)
																		 VALUES(2,
																			  		:phcid,
																						:empnrodocto,
																						:empapellido,
																						:empnombres,
																						:bennrodocto,
																						:bennrooficio,
																						:benapellido,
																						:bennombres,
																						:hijonrodocto,
																						:hijoapellido,
																						:hijonombres,
																						:periodoid,
																						212,
																						1,
																						0,
																						0,
																						"",
																						0,
																						1)';

					$dec = $this->cn->prepare($sql);
					$dec->bindValue(':phcid', $row->leghijo_id, PDO::PARAM_STR);
					$dec->bindValue(':empnrodocto', $row->legempleado_nrodocto, PDO::PARAM_STR);
					$dec->bindValue(':empapellido', $datosempleado->legempleado_apellido, PDO::PARAM_STR);
					$dec->bindValue(':empnombres', $datosempleado->legempleado_nombres, PDO::PARAM_STR);
					$dec->bindValue(':bennrodocto', $row->leghijo_benndoc, PDO::PARAM_STR);
					$dec->bindValue(':bennrooficio', $row->leghijo_bennoficio, PDO::PARAM_STR);
					$dec->bindValue(':benapellido', $row->leghijo_benapellido, PDO::PARAM_STR);
					$dec->bindValue(':bennombres', $row->leghijo_bennombres, PDO::PARAM_STR);
					$dec->bindValue(':hijonrodocto', $row->leghijo_nrodocto, PDO::PARAM_STR);
					$dec->bindValue(':hijoapellido', $row->leghijo_apellido, PDO::PARAM_STR);
					$dec->bindValue(':hijonombres', $row->leghijo_nombres, PDO::PARAM_STR);
					$dec->bindValue(':periodoid', $periodo->periodo_id, PDO::PARAM_STR);
					$dec->execute();
					//----------------obtner ultimo id Insertado -----------
					$ultimoid = $this->cn->lastInsertId();
					//--------------Insert de aditoria de asignaciones ---------------------------
					$ippublica = $_SERVER["REMOTE_ADDR"];
					$pcnombre = gethostbyaddr($_SERVER['REMOTE_ADDR']);
					$pcinformacion = $_SERVER['HTTP_USER_AGENT'];
					$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];

					$sql = 'INSERT INTO aud_asignaciones_familiares (AUD_asignacion_id,
																								AUD_asignacion_titular,
																								AUD_asignacion_phc_id,
																								AUD_legempleado_nrodocto,
																								AUD_legempleado_apellido,
																								AUD_legempleado_nombres,
																								AUD_benndoc,
																								AUD_bennoficio,
																								AUD_benapellido,
																								AUD_bennombres,
																								AUD_leghijo_nrodocto,
																								AUD_leghijo_apellido,
																								AUD_leghijo_nombres,
																								AUD_periodo_id,
																								AUD_liqcod_id,
																								AUD_asignacion_cantidad,
																								AUD_asignacion_importe,
																								AUD_asignacion_reajuste,
																								AUD_asignacion_reajuste_obs,
																								AUD_asignacion_importe_total,
																								AUD_asignacion_estado,
																								AUD_asignacion_observacion,
																								AUD_asignacion_ippublica,
																								AUD_asignacion_pcnombre,
																								AUD_asignacion_pcinformacion,
																								AUD_asignacion_accion,
																								AUD_asignacion_datetime,
																								AUD_asignacion_usuario)
																				 VALUES(:ultimoid,
																					 			2,
																					  		:phcid,
																								:empnrodocto,
																								:empapellido,
																								:empnombres,
																								:bennrodocto,
																								:bennrooficio,
																								:benapellido,
																								:bennombres,
																								:hijonrodocto,
																								:hijoapellido,
																								:hijonombres,
																								:periodoid,
																								212,
																								1,
																								0,
																								0,
																								"",
																								0,
																								1,
																								"",
																								:ippublica,
																								:pcnombre,
																								:pcinformacion,
																								"INSERT",
																								NOW(),
																								:usuario)';

					$dec = $this->cn->prepare($sql);
					$dec->bindValue(':ultimoid', $ultimoid, PDO::PARAM_STR);
					$dec->bindValue(':phcid', $row->leghijo_id, PDO::PARAM_STR);
					$dec->bindValue(':empnrodocto', $row->legempleado_nrodocto, PDO::PARAM_STR);
					$dec->bindValue(':empapellido', $datosempleado->legempleado_apellido, PDO::PARAM_STR);
					$dec->bindValue(':empnombres', $datosempleado->legempleado_nombres, PDO::PARAM_STR);
					$dec->bindValue(':bennrodocto', $row->leghijo_benndoc, PDO::PARAM_STR);
					$dec->bindValue(':bennrooficio', $row->leghijo_bennoficio, PDO::PARAM_STR);
					$dec->bindValue(':benapellido', $row->leghijo_benapellido, PDO::PARAM_STR);
					$dec->bindValue(':bennombres', $row->leghijo_bennombres, PDO::PARAM_STR);
					$dec->bindValue(':hijonrodocto', $row->leghijo_nrodocto, PDO::PARAM_STR);
					$dec->bindValue(':hijoapellido', $row->leghijo_apellido, PDO::PARAM_STR);
					$dec->bindValue(':hijonombres', $row->leghijo_nombres, PDO::PARAM_STR);
					$dec->bindValue(':periodoid', $periodo->periodo_id, PDO::PARAM_STR);
					$dec->bindValue(':ippublica', $ippublica, PDO::PARAM_STR);
					$dec->bindValue(':pcnombre', $pcnombre, PDO::PARAM_STR);
					$dec->bindValue(':pcinformacion', $pcinformacion, PDO::PARAM_STR);
					$dec->bindValue(':usuario', $usuario, PDO::PARAM_STR);
					$dec->execute();
				}
			}else{
				//--- No tiene Hijos Menores OB
			}

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function FamiliaNumAOBPasarExe($empleadonrodocto,$beneficiarionrodocto,$familianum){
		try{
			//-- Datos beneficiario ----
			$sql = 'SELECT * FROM legajos_hijo
											WHERE legempleado_nrodocto = ?
											  AND leghijo_benndoc = ?
												AND leghijo_activo = 1
									 ORDER BY leghijo_id DESC LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $empleadonrodocto, PDO::PARAM_STR);
			$dec->bindValue(2, $beneficiarionrodocto, PDO::PARAM_STR);
			$dec->execute();
			$datosbeneficiario = $dec->fetch(PDO::FETCH_OBJ);
			//--- Datos Empleados ---
			$sql = 'SELECT legempleado_nrodocto,
										 legempleado_apellido,
										 legempleado_nombres
							  FROM legajos_empleado
							 WHERE legempleado_nrodocto = ? LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $empleadonrodocto, PDO::PARAM_STR);
			$dec->execute();
			$datosempleado = $dec->fetch(PDO::FETCH_OBJ);
			//-- Datos Periodos ---
			$sql = $this->cn->prepare("SELECT periodo_id
																	 FROM periodos
																	WHERE periodo_cerrado = 1
															 ORDER BY periodo_id DESC LIMIT 1");
			$sql->execute();
			$periodo = $sql->fetch(PDO::FETCH_OBJ);
			//--- Insertar familia numerosa ---
			$sql = 'INSERT INTO asignaciones_familiares (asignacion_titular,
																				asignacion_phc_id,
																				legempleado_nrodocto,
																				legempleado_apellido,
																				legempleado_nombres,
																				_benndoc,
																				_bennoficio,
																				_benapellido,
																				_bennombres,
																				leghijo_nrodocto,
																				leghijo_apellido,
																				leghijo_nombres,
																				periodo_id,
																				liqcod_id,
																				asignacion_cantidad,
																				asignacion_importe,
																				asignacion_reajuste,
																				asignacion_reajuste_obs,
																				asignacion_importe_total,
																				asignacion_estado)
																 VALUES(2,
																				0,
																				:empnrodocto,
																				:empapellido,
																				:empnombres,
																				:bennrodocto,
																				:bennrooficio,
																				:benapellido,
																				:bennombres,
																				0,
																				"",
																				"",
																				:periodoid,
																				203,
																				:familianum,
																				0,
																				0,
																				"",
																				0,
																				1)';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(':empnrodocto', $datosempleado->legempleado_nrodocto, PDO::PARAM_STR);
			$dec->bindValue(':empapellido', $datosempleado->legempleado_apellido, PDO::PARAM_STR);
			$dec->bindValue(':empnombres', $datosempleado->legempleado_nombres, PDO::PARAM_STR);
			$dec->bindValue(':bennrodocto', $datosbeneficiario->leghijo_benndoc, PDO::PARAM_STR);
			$dec->bindValue(':bennrooficio', $datosbeneficiario->leghijo_bennoficio, PDO::PARAM_STR);
			$dec->bindValue(':benapellido', $datosbeneficiario->leghijo_benapellido, PDO::PARAM_STR);
			$dec->bindValue(':bennombres', $datosbeneficiario->leghijo_bennombres, PDO::PARAM_STR);
			$dec->bindValue(':periodoid', $periodo->periodo_id, PDO::PARAM_STR);
			$dec->bindValue(':familianum', $familianum, PDO::PARAM_STR);
			$dec->execute();
			//----------------obtner ultimo id Insertado -----------
			$ultimoid = $this->cn->lastInsertId();
			//--------------Insert de aditoria de asignaciones ---------------------------
			$ippublica = $_SERVER["REMOTE_ADDR"];
			$pcnombre = gethostbyaddr($_SERVER['REMOTE_ADDR']);
			$pcinformacion = $_SERVER['HTTP_USER_AGENT'];
			$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];

			$sql = 'INSERT INTO aud_asignaciones_familiares (AUD_asignacion_id,
																						AUD_asignacion_titular,
																						AUD_asignacion_phc_id,
																						AUD_legempleado_nrodocto,
																						AUD_legempleado_apellido,
																						AUD_legempleado_nombres,
																						AUD_benndoc,
																						AUD_bennoficio,
																						AUD_benapellido,
																						AUD_bennombres,
																						AUD_leghijo_nrodocto,
																						AUD_leghijo_apellido,
																						AUD_leghijo_nombres,
																						AUD_periodo_id,
																						AUD_liqcod_id,
																						AUD_asignacion_cantidad,
																						AUD_asignacion_importe,
																						AUD_asignacion_reajuste,
																						AUD_asignacion_reajuste_obs,
																						AUD_asignacion_importe_total,
																						AUD_asignacion_estado,
																						AUD_asignacion_observacion,
																						AUD_asignacion_ippublica,
																						AUD_asignacion_pcnombre,
																						AUD_asignacion_pcinformacion,
																						AUD_asignacion_accion,
																						AUD_asignacion_datetime,
																						AUD_asignacion_usuario)
																		 VALUES(:ultimoid,
																						2,
																						0,
																						:empnrodocto,
																						:empapellido,
																						:empnombres,
																						:bennrodocto,
																						:bennrooficio,
																						:benapellido,
																						:bennombres,
																						0,
																						"",
																						"",
																						:periodoid,
																						203,
																						:familianum,
																						0,
																						0,
																						"",
																						0,
																						1,
																						"",
																						:ippublica,
																						:pcnombre,
																						:pcinformacion,
																						"INSERT",
																						NOW(),
																						:usuario)';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(':ultimoid', $ultimoid, PDO::PARAM_STR);
			$dec->bindValue(':empnrodocto', $datosempleado->legempleado_nrodocto, PDO::PARAM_STR);
			$dec->bindValue(':empapellido', $datosempleado->legempleado_apellido, PDO::PARAM_STR);
			$dec->bindValue(':empnombres', $datosempleado->legempleado_nombres, PDO::PARAM_STR);
			$dec->bindValue(':bennrodocto', $datosbeneficiario->leghijo_benndoc, PDO::PARAM_STR);
			$dec->bindValue(':bennrooficio', $datosbeneficiario->leghijo_bennoficio, PDO::PARAM_STR);
			$dec->bindValue(':benapellido', $datosbeneficiario->leghijo_benapellido, PDO::PARAM_STR);
			$dec->bindValue(':bennombres', $datosbeneficiario->leghijo_bennombres, PDO::PARAM_STR);
			$dec->bindValue(':periodoid', $periodo->periodo_id, PDO::PARAM_STR);
			$dec->bindValue(':familianum', $familianum, PDO::PARAM_STR);
			$dec->bindValue(':ippublica', $ippublica, PDO::PARAM_STR);
			$dec->bindValue(':pcnombre', $pcnombre, PDO::PARAM_STR);
			$dec->bindValue(':pcinformacion', $pcinformacion, PDO::PARAM_STR);
			$dec->bindValue(':usuario', $usuario, PDO::PARAM_STR);
			$dec->execute();
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function WaldbottAPasarExe($data){
		try{
			$sql = 'UPDATE EMPLEADO
								 SET ASIGFLIAR1 = ?,
								 		 ASIGFLIAR2 = ?,
								     ASIGFLIAR3 = ?,
										 ASIGFLIAR4 = ?,
								     ASIGFLIAR5 = ?,
										 ASIGFLIAR7 = ?,
										 ASIGFLIAR10 = ?,
										 ASIGFLIAR13 = ?,
										 ASIGFLIAR15 = ?,
										 ASIGFLIAR16 = ?
							 WHERE NRODOCTO = ?
								 AND CONDICION = ?';
			$dec = $this->cnw->prepare($sql);
			$dec->bindValue(1, $data->Conyuge, PDO::PARAM_INT);
			$dec->bindValue(2, $data->Hijomenor, PDO::PARAM_INT);
			$dec->bindValue(3, $data->Hijodisc, PDO::PARAM_INT);
			$dec->bindValue(4, $data->FamNumerosa, PDO::PARAM_INT);
			$dec->bindValue(5, $data->Hijopreescolar, PDO::PARAM_INT);
			$dec->bindValue(6, $data->Hijoprimaria, PDO::PARAM_INT);
			$dec->bindValue(7, $data->Hijomedsub, PDO::PARAM_INT);
			$dec->bindValue(8, $data->Hijodiscesc, PDO::PARAM_INT);
			$dec->bindValue(9, $data->Prenatal, PDO::PARAM_INT);
			$dec->bindValue(10, 1, PDO::PARAM_INT);
			$dec->bindValue(11, $data->Nrodocto, PDO::PARAM_INT);
			$dec->bindValue(12, "1", PDO::PARAM_STR);
			$dec->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function WaldbottAsignacionesReset(){
		try{
			$sql = 'UPDATE EMPLEADO
								 SET ASIGFLIAR1 = ?,
								 		 ASIGFLIAR2 = ?,
								     ASIGFLIAR3 = ?,
										 ASIGFLIAR4 = ?,
								     ASIGFLIAR5 = ?,
										 ASIGFLIAR7 = ?,
										 ASIGFLIAR10 = ?,
										 ASIGFLIAR13 = ?,
										 ASIGFLIAR15 = ?
							 WHERE CONDICION = ?';
			$dec = $this->cnw->prepare($sql);
			$dec->bindValue(1, 0, PDO::PARAM_INT);
			$dec->bindValue(2, 0, PDO::PARAM_INT);
			$dec->bindValue(3, 0, PDO::PARAM_INT);
			$dec->bindValue(4, 0, PDO::PARAM_INT);
			$dec->bindValue(5, 0, PDO::PARAM_INT);
			$dec->bindValue(6, 0, PDO::PARAM_INT);
			$dec->bindValue(7, 0, PDO::PARAM_INT);
			$dec->bindValue(8, 0, PDO::PARAM_INT);
			$dec->bindValue(9, 0, PDO::PARAM_INT);
			$dec->bindValue(10, "1", PDO::PARAM_STR);
			$dec->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function AsignacionesOBLiqListado($periodoid){
		try{

			$sql = $this->cn->prepare("SELECT DISTINCT legempleado_nrodocto AS empleado,
																								 legempleado_nrodocto_ben AS beneficiario
																						FROM asignaciones_familiares
																					 WHERE periodo_id = $periodoid
																					 	 AND asignacion_titular = 2
																				ORDER BY legempleado_apellido,
																								 legempleado_nombres");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function AyudaEscolarOBLiqListado($periodoid){
		try{

			$sql = $this->cn->prepare("SELECT DISTINCT legempleado_nrodocto AS empleado,
																								 legempleado_nrodocto_ben AS beneficiario
																						FROM asignaciones_familiares
																					 WHERE periodo_id = $periodoid
																					 	 AND asignacion_titular = 2
																						 AND asigtipo_id > 9
																						 AND asigtipo_id < 14
																				ORDER BY legempleado_apellido,
																								 legempleado_nombres");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function AsignacionLiqImportes($empleadonrodocto, $beneficiarionrodocto, $periodoid){
		try{
			$sql = 'SELECT SUM(asignacion_importe) AS importe,
										 SUM(asignacion_reajuste) AS importe_reajuste,
										 SUM(asignacion_importe_total) AS importe_total
								FROM asignaciones_familiares
							 WHERE legempleado_nrodocto = ?
							   AND legempleado_nrodocto_ben = ?
								 AND periodo_id = ?
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $empleadonrodocto, PDO::PARAM_STR);
			$dec->bindValue(2, $beneficiarionrodocto, PDO::PARAM_STR);
			$dec->bindValue(3, $periodoid, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerAsignacionesParametros($asignaciontipo){
		try{
			$sql = 'SELECT *
								FROM asignaciones_familiares_parametro
							 WHERE liqcod_id = ?
							   AND asigparam_activo = 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $asignaciontipo, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetchAll(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerAsignacionesEscolares($escuela){
		try{
			$sql = 'SELECT *
								FROM asignaciones_familiares_parametro
							 WHERE liqcod_id = ?
							   AND asigparam_activo = 1
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $escuela, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}

	/////////////////////////CODIGO Temporal//////////////////////////////////////////////////
	public function HaberRemunFilasNum($periodoid){
		try{
			$sql = 'SELECT COUNT(liquidacion_id) AS haberremc
										 FROM liquidaciones
										WHERE liqcod_id = 485
											AND periodo_id = ?
										LIMIT 1';
			/*
			$sql = 'SELECT COUNT(haberrem_id) AS haberremc
										 FROM haberes_remunerativos
										WHERE periodo_id = ?
										LIMIT 1';
			*/
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $periodoid, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function AsignacionLiquidacionFilasNum($titular, $periodoid){
		try{

			$sql = 'SELECT COUNT(liquidacion_id) AS liquidacionc
										 FROM liquidaciones
										WHERE liqtipo_id = ?
										  AND periodo_id = ?
										LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $titular, PDO::PARAM_STR);
			$dec->bindValue(2, $periodoid, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function LiquidarAsignacionesOB($asignaciontipo,$impdesde,$imphasta,$imp_asignacion,$periodoid){
		try{
			//$periodoid_anterior = $periodoid - 1;
			$periodoid_anterior = $periodoid;
			//-- Datos Haberes Remunerativos ----
			$sql = 'SELECT legempleado_nrodocto
								FROM liquidaciones
							 WHERE periodo_id = ?
							 	 AND liqcod_id = 485
								 AND liquidacion_titular = 1
							   AND liquidacion_importe BETWEEN ? AND ?';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $periodoid_anterior, PDO::PARAM_STR);
			$dec->bindValue(2, $impdesde, PDO::PARAM_STR);
			$dec->bindValue(3, $imphasta, PDO::PARAM_STR);
			$dec->execute();
			$empleadosnrodocto = $dec->fetchAll(PDO::FETCH_OBJ);

			foreach($empleadosnrodocto as $empleadonrodocto){

				$sql = 'UPDATE asignaciones_familiares
									 SET asignacion_importe = asignacion_cantidad * ?
								 WHERE legempleado_nrodocto = ?
								   AND liqcod_id = ?
									 AND periodo_id = ?';
				$dec = $this->cn->prepare($sql);
				$dec->bindValue(1, $imp_asignacion, PDO::PARAM_STR);
				$dec->bindValue(2, $empleadonrodocto->legempleado_nrodocto, PDO::PARAM_STR);
				$dec->bindValue(3, $asignaciontipo, PDO::PARAM_STR);
				$dec->bindValue(4, $periodoid, PDO::PARAM_STR);
				$dec->execute();

			}
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function AsignacionesXCodigoObtener($empndoc,$benndoc,$periodoid){
		try{

			$sql = 'SELECT a.liqcod_id,
										 SUM(a.asignacion_cantidad) AS asignacioncanttotal,
										 SUM(a.asignacion_importe) AS asignacionimptotal,
										 b.liqcod_descripcion,
										 b.liqcodtipo_id
								FROM asignaciones_familiares a
					INNER JOIN liquidaciones_codigo b
									ON a.liqcod_id = b.liqcod_id
							 WHERE a.legempleado_nrodocto = ?
							   AND a.legempleado_nrodocto_ben = ?
							   AND a.periodo_id = ?
					  GROUP BY a.liqcod_id
					  ORDER BY a.liqcod_id ASC';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $empndoc, PDO::PARAM_STR);
			$dec->bindValue(2, $benndoc, PDO::PARAM_STR);
			$dec->bindValue(3, $periodoid, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function AyudaEscolarXCodigoObtener($empndoc,$benndoc,$periodoid){
		try{

			$sql = 'SELECT a.liqcod_id,
										 SUM(a.asignacion_cantidad) AS asignacioncanttotal,
										 SUM(a.asignacion_importe) AS asignacionimptotal,
										 b.liqcod_descripcion,
										 b.liqcodtipo_id
								FROM asignaciones_familiares a
					INNER JOIN liquidaciones_codigo b
									ON a.liqcod_id = b.liqcod_id
							 WHERE a.legempleado_nrodocto = ?
							   AND a.legempleado_nrodocto_ben = ?
							   AND a.periodo_id = ?
								 AND a.asigtipo_id > 9
								 AND a.asigtipo_id < 14
					  GROUP BY a.liqcod_id
					  ORDER BY a.liqcod_id ASC';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $empndoc, PDO::PARAM_STR);
			$dec->bindValue(2, $benndoc, PDO::PARAM_STR);
			$dec->bindValue(3, $periodoid, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function LiquidarAsignacionesOBLote($data){
		try{
			//
			//$liqcodigo
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
																				 ccosto_codigo,
																				 periodo_id,
																				 liquidacion_observacion,
																			 	 liquidacion_estado)
																	VALUES(5,
																				 :empnrodocto,
																				 :bennrodocto,
																				 0,
																				 2,
																				 :liqcod,
																				 :liqdescripcion,
																				 :canttotal,
																				 :liqcodtip,
																				 :imptotal,
																				 0,
																				 :periodoid,
																				 "",
																				 1)';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(':empnrodocto', $data->empndoc, PDO::PARAM_STR);
			$dec->bindValue(':bennrodocto', $data->benndoc, PDO::PARAM_STR);
			$dec->bindValue(':liqcod', $data->liqcod_id, PDO::PARAM_STR);
			$dec->bindValue(':liqdescripcion', $data->liqcod_descripcion, PDO::PARAM_STR);
			$dec->bindValue(':canttotal', $data->asignacioncanttotal, PDO::PARAM_STR);
			$dec->bindValue(':liqcodtip', $data->liqcodtipo_id, PDO::PARAM_STR);
			$dec->bindValue(':imptotal', $data->asignacionimptotal, PDO::PARAM_STR);
			$dec->bindValue(':periodoid', $data->periodoid, PDO::PARAM_STR);
			$dec->execute();
			/*
			$hremun = Asignacion::HaberesRemunerativosObtener($empndoc, $benndoc, $periodoid);
			$asigfamtotal = Asignacion::AsignacionesFamiliaresObtener($empndoc, $benndoc, $periodoid);
			$hnoremun = Asignacion::HaberesNoRemunerativosObtener($empndoc, $benndoc, $periodoid);
			$descuentos = Asignacion::DescuentosObtener($empndoc, $benndoc, $periodoid);
			*/

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function LiquidarAyudaEscolarOBLote($data){
		try{
			//
			//$liqcodigo
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
																				 ccosto_codigo,
																				 periodo_id,
																				 liquidacion_observacion,
																			 	 liquidacion_estado)
																	VALUES(6,
																				 :empnrodocto,
																				 :bennrodocto,
																				 0,
																				 2,
																				 :liqcod,
																				 :liqdescripcion,
																				 :canttotal,
																				 :liqcodtip,
																				 :imptotal,
																				 0,
																				 :periodoid,
																				 "",
																				 1)';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(':empnrodocto', $data->empndoc, PDO::PARAM_STR);
			$dec->bindValue(':bennrodocto', $data->benndoc, PDO::PARAM_STR);
			$dec->bindValue(':liqcod', $data->liqcod_id, PDO::PARAM_STR);
			$dec->bindValue(':liqdescripcion', $data->liqcod_descripcion, PDO::PARAM_STR);
			$dec->bindValue(':canttotal', $data->asignacioncanttotal, PDO::PARAM_STR);
			$dec->bindValue(':liqcodtip', $data->liqcodtipo_id, PDO::PARAM_STR);
			$dec->bindValue(':imptotal', $data->asignacionimptotal, PDO::PARAM_STR);
			$dec->bindValue(':periodoid', $data->periodoid, PDO::PARAM_STR);
			$dec->execute();
			/*
			$hremun = Asignacion::HaberesRemunerativosObtener($empndoc, $benndoc, $periodoid);
			$asigfamtotal = Asignacion::AsignacionesFamiliaresObtener($empndoc, $benndoc, $periodoid);
			$hnoremun = Asignacion::HaberesNoRemunerativosObtener($empndoc, $benndoc, $periodoid);
			$descuentos = Asignacion::DescuentosObtener($empndoc, $benndoc, $periodoid);
			*/

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function HaberesRemunerativosObtener($empndoc,$benndoc,$periodoid){
		try{

			$sql = 'SELECT SUM(liquidacion_importe) AS hremimp
								FROM liquidaciones
							 WHERE legempleado_nrodocto = ?
							   AND liquidacion_nrodocto = ?
							   AND periodo_id = ?
								 AND liqcodtipo_id = 1
					  GROUP BY liqcodtipo_id';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $empndoc, PDO::PARAM_STR);
			$dec->bindValue(2, $benndoc, PDO::PARAM_STR);
			$dec->bindValue(3, $periodoid, PDO::PARAM_STR);
			$dec->execute();
			$datos = $dec->fetch(PDO::FETCH_OBJ);

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
																				 ccosto_codigo,
																				 periodo_id,
																				 liquidacion_observacion,
																			 	 liquidacion_estado)
																	VALUES(5,
																				 :empnrodocto,
																				 :bennrodocto,
																				 0,
																				 2,
																				 485,
																				 "TOTAL HABERES REMUNERATIVOS",
																				 0,
																				 6,
																				 :imptotal,
																				 0,
																				 :periodoid,
																				 "",
																				 1)';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(':empnrodocto', $empndoc, PDO::PARAM_STR);
			$dec->bindValue(':bennrodocto', $benndoc, PDO::PARAM_STR);
			$dec->bindValue(':imptotal', $datos->hremimp, PDO::PARAM_STR);
			$dec->bindValue(':periodoid', $periodoid, PDO::PARAM_STR);
			$dec->execute();


		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function HaberesRemunerativosObtener_AE($empndoc,$benndoc,$periodoid){
		try{

			$sql = 'SELECT SUM(liquidacion_importe) AS hremimp
								FROM liquidaciones
							 WHERE liqtipo_id = 6
							 	 AND legempleado_nrodocto = ?
							   AND liquidacion_nrodocto = ?
							   AND periodo_id = ?
								 AND liqcodtipo_id = 1
					  GROUP BY liqcodtipo_id';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $empndoc, PDO::PARAM_STR);
			$dec->bindValue(2, $benndoc, PDO::PARAM_STR);
			$dec->bindValue(3, $periodoid, PDO::PARAM_STR);
			$dec->execute();
			$datos = $dec->fetch(PDO::FETCH_OBJ);

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
																				 ccosto_codigo,
																				 periodo_id,
																				 liquidacion_observacion,
																			 	 liquidacion_estado)
																	VALUES(6,
																				 :empnrodocto,
																				 :bennrodocto,
																				 0,
																				 2,
																				 485,
																				 "TOTAL HABERES REMUNERATIVOS",
																				 0,
																				 6,
																				 :imptotal,
																				 0,
																				 :periodoid,
																				 "",
																				 1)';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(':empnrodocto', $empndoc, PDO::PARAM_STR);
			$dec->bindValue(':bennrodocto', $benndoc, PDO::PARAM_STR);
			$dec->bindValue(':imptotal', $datos->hremimp, PDO::PARAM_STR);
			$dec->bindValue(':periodoid', $periodoid, PDO::PARAM_STR);
			$dec->execute();


		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	/*
	public function HaberesRemunerativosGuaradarExe($empndoc,$benndoc,$periodoid){
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
																				 ccosto_codigo,
																				 periodo_id,
																				 liquidacion_observacion,
																			 	 liquidacion_estado)
																	VALUES(5,
																				 :empnrodocto,
																				 :bennrodocto,
																				 0,
																				 2,
																				 218,
																				 "CARGAS FAMILIARES",
																				 0,
																				 2,
																				 :imptotal,
																				 0,
																				 :periodoid,
																				 "",
																				 1)';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(':empnrodocto', $empndoc, PDO::PARAM_STR);
			$dec->bindValue(':bennrodocto', $benndoc, PDO::PARAM_STR);
			$dec->bindValue(':imptotal', $cargasfamimp->carfamimport, PDO::PARAM_STR);
			$dec->bindValue(':periodoid', $periodoid, PDO::PARAM_STR);
			$dec->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	*/
	public function AsignacionesFamiliaresObtener($empndoc,$benndoc,$periodoid){
		try{

			$sql = 'SELECT SUM(liquidacion_importe) AS asigfamimp
								FROM liquidaciones
							 WHERE legempleado_nrodocto = ?
							   AND liquidacion_nrodocto = ?
							   AND periodo_id = ?
								 AND liqcodtipo_id = 2
					  GROUP BY liqcodtipo_id';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $empndoc, PDO::PARAM_STR);
			$dec->bindValue(2, $benndoc, PDO::PARAM_STR);
			$dec->bindValue(3, $periodoid, PDO::PARAM_STR);
			$dec->execute();
			$datos = $dec->fetch(PDO::FETCH_OBJ);

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
																				 ccosto_codigo,
																				 periodo_id,
																				 liquidacion_observacion,
																			 	 liquidacion_estado)
																	VALUES(5,
																				 :empnrodocto,
																				 :bennrodocto,
																				 0,
																				 2,
																				 486,
																				 "TOTAL ASIGNACIONES FAMILIARES",
																				 0,
																				 6,
																				 :imptotal,
																				 0,
																				 :periodoid,
																				 "",
																				 1)';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(':empnrodocto', $empndoc, PDO::PARAM_STR);
			$dec->bindValue(':bennrodocto', $benndoc, PDO::PARAM_STR);
			$dec->bindValue(':imptotal', $datos->asigfamimp, PDO::PARAM_STR);
			$dec->bindValue(':periodoid', $periodoid, PDO::PARAM_STR);
			$dec->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function AsignacionesFamiliaresObtener_AE($empndoc,$benndoc,$periodoid){
		try{

			$sql = 'SELECT SUM(liquidacion_importe) AS asigfamimp
								FROM liquidaciones
							 WHERE liqtipo_id = 6
							 	 AND legempleado_nrodocto = ?
							   AND liquidacion_nrodocto = ?
							   AND periodo_id = ?
								 AND liqcodtipo_id = 2
					  GROUP BY liqcodtipo_id';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $empndoc, PDO::PARAM_STR);
			$dec->bindValue(2, $benndoc, PDO::PARAM_STR);
			$dec->bindValue(3, $periodoid, PDO::PARAM_STR);
			$dec->execute();
			$datos = $dec->fetch(PDO::FETCH_OBJ);

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
																				 ccosto_codigo,
																				 periodo_id,
																				 liquidacion_observacion,
																			 	 liquidacion_estado)
																	VALUES(6,
																				 :empnrodocto,
																				 :bennrodocto,
																				 0,
																				 2,
																				 486,
																				 "TOTAL ASIGNACIONES FAMILIARES",
																				 0,
																				 6,
																				 :imptotal,
																				 0,
																				 :periodoid,
																				 "",
																				 1)';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(':empnrodocto', $empndoc, PDO::PARAM_STR);
			$dec->bindValue(':bennrodocto', $benndoc, PDO::PARAM_STR);
			$dec->bindValue(':imptotal', $datos->asigfamimp, PDO::PARAM_STR);
			$dec->bindValue(':periodoid', $periodoid, PDO::PARAM_STR);
			$dec->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function HaberesNoRemunerativosObtener($empndoc,$benndoc,$periodoid){
		try{

			$sql = 'SELECT SUM(liquidacion_importe) AS hnoremimp
								FROM liquidaciones
							 WHERE legempleado_nrodocto = ?
							   AND liquidacion_nrodocto = ?
							   AND periodo_id = ?
								 AND liqcodtipo_id = 3
					  GROUP BY liqcodtipo_id';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $empndoc, PDO::PARAM_STR);
			$dec->bindValue(2, $benndoc, PDO::PARAM_STR);
			$dec->bindValue(3, $periodoid, PDO::PARAM_STR);
			$dec->execute();
			$datos = $dec->fetch(PDO::FETCH_OBJ);

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
																				 ccosto_codigo,
																				 periodo_id,
																				 liquidacion_observacion,
																			 	 liquidacion_estado)
																	VALUES(5,
																				 :empnrodocto,
																				 :bennrodocto,
																				 0,
																				 2,
																				 487,
																				 "TOTAL HABERESNO REMUNERATIVOS",
																				 0,
																				 6,
																				 :imptotal,
																				 0,
																				 :periodoid,
																				 "",
																				 1)';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(':empnrodocto', $empndoc, PDO::PARAM_STR);
			$dec->bindValue(':bennrodocto', $benndoc, PDO::PARAM_STR);
			$dec->bindValue(':imptotal', $datos->hnoremimp, PDO::PARAM_STR);
			$dec->bindValue(':periodoid', $periodoid, PDO::PARAM_STR);
			$dec->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function HaberesNoRemunerativosObtener_AE($empndoc,$benndoc,$periodoid){
		try{

			$sql = 'SELECT SUM(liquidacion_importe) AS hnoremimp
								FROM liquidaciones
							 WHERE liqtipo_id = 6
							 	 AND legempleado_nrodocto = ?
							   AND liquidacion_nrodocto = ?
							   AND periodo_id = ?
								 AND liqcodtipo_id = 3
					  GROUP BY liqcodtipo_id';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $empndoc, PDO::PARAM_STR);
			$dec->bindValue(2, $benndoc, PDO::PARAM_STR);
			$dec->bindValue(3, $periodoid, PDO::PARAM_STR);
			$dec->execute();
			$datos = $dec->fetch(PDO::FETCH_OBJ);

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
																				 ccosto_codigo,
																				 periodo_id,
																				 liquidacion_observacion,
																			 	 liquidacion_estado)
																	VALUES(6,
																				 :empnrodocto,
																				 :bennrodocto,
																				 0,
																				 2,
																				 487,
																				 "TOTAL HABERESNO REMUNERATIVOS",
																				 0,
																				 6,
																				 :imptotal,
																				 0,
																				 :periodoid,
																				 "",
																				 1)';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(':empnrodocto', $empndoc, PDO::PARAM_STR);
			$dec->bindValue(':bennrodocto', $benndoc, PDO::PARAM_STR);
			$dec->bindValue(':imptotal', $datos->hnoremimp, PDO::PARAM_STR);
			$dec->bindValue(':periodoid', $periodoid, PDO::PARAM_STR);
			$dec->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function DescuentosObtener($empndoc,$benndoc,$periodoid){
		try{

			$sql = 'SELECT SUM(liquidacion_importe) AS descimp
								FROM liquidaciones
							 WHERE legempleado_nrodocto = ?
							   AND liquidacion_nrodocto = ?
							   AND periodo_id = ?
								 AND liqcodtipo_id = 4
					  GROUP BY liqcodtipo_id';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $empndoc, PDO::PARAM_STR);
			$dec->bindValue(2, $benndoc, PDO::PARAM_STR);
			$dec->bindValue(3, $periodoid, PDO::PARAM_STR);
			$dec->execute();
			$datos = $dec->fetch(PDO::FETCH_OBJ);

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
																				 ccosto_codigo,
																				 periodo_id,
																				 liquidacion_observacion,
																			 	 liquidacion_estado)
																	VALUES(5,
																				 :empnrodocto,
																				 :bennrodocto,
																				 0,
																				 2,
																				 488,
																				 "TOTAL DESCUENTOS",
																				 0,
																				 6,
																				 :imptotal,
																				 0,
																				 :periodoid,
																				 "",
																				 1)';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(':empnrodocto', $empndoc, PDO::PARAM_STR);
			$dec->bindValue(':bennrodocto', $benndoc, PDO::PARAM_STR);
			$dec->bindValue(':imptotal', $datos->descimp, PDO::PARAM_STR);
			$dec->bindValue(':periodoid', $periodoid, PDO::PARAM_STR);
			$dec->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function DescuentosObtener_AE($empndoc,$benndoc,$periodoid){
		try{

			$sql = 'SELECT SUM(liquidacion_importe) AS descimp
								FROM liquidaciones
							 WHERE liqtipo_id = 6
							 	 AND legempleado_nrodocto = ?
							   AND liquidacion_nrodocto = ?
							   AND periodo_id = ?
								 AND liqcodtipo_id = 4
					  GROUP BY liqcodtipo_id';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $empndoc, PDO::PARAM_STR);
			$dec->bindValue(2, $benndoc, PDO::PARAM_STR);
			$dec->bindValue(3, $periodoid, PDO::PARAM_STR);
			$dec->execute();
			$datos = $dec->fetch(PDO::FETCH_OBJ);

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
																				 ccosto_codigo,
																				 periodo_id,
																				 liquidacion_observacion,
																			 	 liquidacion_estado)
																	VALUES(6,
																				 :empnrodocto,
																				 :bennrodocto,
																				 0,
																				 2,
																				 488,
																				 "TOTAL DESCUENTOS",
																				 0,
																				 6,
																				 :imptotal,
																				 0,
																				 :periodoid,
																				 "",
																				 1)';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(':empnrodocto', $empndoc, PDO::PARAM_STR);
			$dec->bindValue(':bennrodocto', $benndoc, PDO::PARAM_STR);
			$dec->bindValue(':imptotal', $datos->descimp, PDO::PARAM_STR);
			$dec->bindValue(':periodoid', $periodoid, PDO::PARAM_STR);
			$dec->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function SueldoNetoObtener($empndoc,$benndoc,$periodoid){
		try{
			/////////////////////////////////////////////////////////
			$sql = 'SELECT SUM(liquidacion_importe) AS importe_uno
								FROM liquidaciones
							 WHERE legempleado_nrodocto = ?
							   AND liquidacion_nrodocto = ?
							   AND periodo_id = ?
								 AND liqcodtipo_id = 1
					  GROUP BY liqcodtipo_id';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $empndoc, PDO::PARAM_STR);
			$dec->bindValue(2, $benndoc, PDO::PARAM_STR);
			$dec->bindValue(3, $periodoid, PDO::PARAM_STR);
			$dec->execute();
			$datos_uno = $dec->fetch(PDO::FETCH_OBJ);
			/////////////////////////////////////////////////////////
			$sql = 'SELECT SUM(liquidacion_importe) AS importe_dos
								FROM liquidaciones
							 WHERE legempleado_nrodocto = ?
							   AND liquidacion_nrodocto = ?
							   AND periodo_id = ?
								 AND liqcodtipo_id = 2
					  GROUP BY liqcodtipo_id';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $empndoc, PDO::PARAM_STR);
			$dec->bindValue(2, $benndoc, PDO::PARAM_STR);
			$dec->bindValue(3, $periodoid, PDO::PARAM_STR);
			$dec->execute();
			$datos_dos = $dec->fetch(PDO::FETCH_OBJ);
			/////////////////////////////////////////////////////////
			$sql = 'SELECT SUM(liquidacion_importe) AS importe_tres
								FROM liquidaciones
							 WHERE legempleado_nrodocto = ?
							   AND liquidacion_nrodocto = ?
							   AND periodo_id = ?
								 AND liqcodtipo_id = 3
					  GROUP BY liqcodtipo_id';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $empndoc, PDO::PARAM_STR);
			$dec->bindValue(2, $benndoc, PDO::PARAM_STR);
			$dec->bindValue(3, $periodoid, PDO::PARAM_STR);
			$dec->execute();
			$datos_tres = $dec->fetch(PDO::FETCH_OBJ);
			/////////////////////////////////////////////////////////
			$sql = 'SELECT SUM(liquidacion_importe) AS importe_cuatro
								FROM liquidaciones
							 WHERE legempleado_nrodocto = ?
							   AND liquidacion_nrodocto = ?
							   AND periodo_id = ?
								 AND liqcodtipo_id = 4
					  GROUP BY liqcodtipo_id';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $empndoc, PDO::PARAM_STR);
			$dec->bindValue(2, $benndoc, PDO::PARAM_STR);
			$dec->bindValue(3, $periodoid, PDO::PARAM_STR);
			$dec->execute();
			$datos_cuatro = $dec->fetch(PDO::FETCH_OBJ);
			////////////////////////////////////////////////////
			$importe_neto = $datos_uno->importe_uno + $datos_dos->importe_dos + $datos_tres->importe_tres - $datos_cuatro->importe_cuatro;
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
																				 ccosto_codigo,
																				 periodo_id,
																				 liquidacion_observacion,
																			 	 liquidacion_estado)
																	VALUES(5,
																				 :empnrodocto,
																				 :bennrodocto,
																				 0,
																				 2,
																				 484,
																				 "SUELDO NETO",
																				 0,
																				 6,
																				 :imptotal,
																				 0,
																				 :periodoid,
																				 "",
																				 1)';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(':empnrodocto', $empndoc, PDO::PARAM_STR);
			$dec->bindValue(':bennrodocto', $benndoc, PDO::PARAM_STR);
			$dec->bindValue(':imptotal', $importe_neto, PDO::PARAM_STR);
			$dec->bindValue(':periodoid', $periodoid, PDO::PARAM_STR);
			$dec->execute();


		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function SueldoNetoObtener_AE($empndoc,$benndoc,$periodoid){
		try{
			/////////////////////////////////////////////////////////
			$sql = 'SELECT SUM(liquidacion_importe) AS importe_uno
								FROM liquidaciones
							 WHERE liqtipo_id = 6
							 	 AND legempleado_nrodocto = ?
							   AND liquidacion_nrodocto = ?
							   AND periodo_id = ?
								 AND liqcodtipo_id = 1
					  GROUP BY liqcodtipo_id';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $empndoc, PDO::PARAM_STR);
			$dec->bindValue(2, $benndoc, PDO::PARAM_STR);
			$dec->bindValue(3, $periodoid, PDO::PARAM_STR);
			$dec->execute();
			$datos_uno = $dec->fetch(PDO::FETCH_OBJ);
			/////////////////////////////////////////////////////////
			$sql = 'SELECT SUM(liquidacion_importe) AS importe_dos
								FROM liquidaciones
							 WHERE liqtipo_id = 6
							 	 AND legempleado_nrodocto = ?
							   AND liquidacion_nrodocto = ?
							   AND periodo_id = ?
								 AND liqcodtipo_id = 2
					  GROUP BY liqcodtipo_id';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $empndoc, PDO::PARAM_STR);
			$dec->bindValue(2, $benndoc, PDO::PARAM_STR);
			$dec->bindValue(3, $periodoid, PDO::PARAM_STR);
			$dec->execute();
			$datos_dos = $dec->fetch(PDO::FETCH_OBJ);
			/////////////////////////////////////////////////////////
			$sql = 'SELECT SUM(liquidacion_importe) AS importe_tres
								FROM liquidaciones
							 WHERE liqtipo_id = 6
							 	 AND legempleado_nrodocto = ?
							   AND liquidacion_nrodocto = ?
							   AND periodo_id = ?
								 AND liqcodtipo_id = 3
					  GROUP BY liqcodtipo_id';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $empndoc, PDO::PARAM_STR);
			$dec->bindValue(2, $benndoc, PDO::PARAM_STR);
			$dec->bindValue(3, $periodoid, PDO::PARAM_STR);
			$dec->execute();
			$datos_tres = $dec->fetch(PDO::FETCH_OBJ);
			/////////////////////////////////////////////////////////
			$sql = 'SELECT SUM(liquidacion_importe) AS importe_cuatro
								FROM liquidaciones
							 WHERE liqtipo_id = 6
							 	 AND legempleado_nrodocto = ?
							   AND liquidacion_nrodocto = ?
							   AND periodo_id = ?
								 AND liqcodtipo_id = 4
					  GROUP BY liqcodtipo_id';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $empndoc, PDO::PARAM_STR);
			$dec->bindValue(2, $benndoc, PDO::PARAM_STR);
			$dec->bindValue(3, $periodoid, PDO::PARAM_STR);
			$dec->execute();
			$datos_cuatro = $dec->fetch(PDO::FETCH_OBJ);
			////////////////////////////////////////////////////
			$importe_neto = $datos_uno->importe_uno + $datos_dos->importe_dos + $datos_tres->importe_tres - $datos_cuatro->importe_cuatro;
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
																				 ccosto_codigo,
																				 periodo_id,
																				 liquidacion_observacion,
																			 	 liquidacion_estado)
																	VALUES(6,
																				 :empnrodocto,
																				 :bennrodocto,
																				 0,
																				 2,
																				 484,
																				 "SUELDO NETO",
																				 0,
																				 6,
																				 :imptotal,
																				 0,
																				 :periodoid,
																				 "",
																				 1)';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(':empnrodocto', $empndoc, PDO::PARAM_STR);
			$dec->bindValue(':bennrodocto', $benndoc, PDO::PARAM_STR);
			$dec->bindValue(':imptotal', $importe_neto, PDO::PARAM_STR);
			$dec->bindValue(':periodoid', $periodoid, PDO::PARAM_STR);
			$dec->execute();


		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function LiquidarAsignacionesOBLoteDoble($empndoc,$benndoc,$periodoid){
		try{
			//-- Obtener codigos a liquidar ----
			$sql = 'SELECT legempleado_nrodocto,
										 legempleado_nrodocto_ben,
										 SUM(asignacion_importe) AS carfamimport
								FROM asignaciones_familiares a
							 WHERE legempleado_nrodocto = ?
							   AND legempleado_nrodocto_ben = ?
							   AND periodo_id = ?
					  GROUP BY legempleado_nrodocto
					  ORDER BY liqcod_id ASC';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $empndoc, PDO::PARAM_STR);
			$dec->bindValue(2, $benndoc, PDO::PARAM_STR);
			$dec->bindValue(3, $periodoid, PDO::PARAM_STR);
			$dec->execute();
			$cargasfamimp = $dec->fetch(PDO::FETCH_OBJ);

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
																				 ccosto_codigo,
																				 periodo_id,
																				 liquidacion_observacion,
																			 	 liquidacion_estado)
																	VALUES(5,
																				 :empnrodocto,
																				 :bennrodocto,
																				 0,
																				 2,
																				 218,
																				 "CARGAS FAMILIARES",
																				 0,
																				 2,
																				 :imptotal,
																				 0,
																				 :periodoid,
																				 "",
																				 1)';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(':empnrodocto', $empndoc, PDO::PARAM_STR);
			$dec->bindValue(':bennrodocto', $benndoc, PDO::PARAM_STR);
			$dec->bindValue(':imptotal', $cargasfamimp->carfamimport, PDO::PARAM_STR);
			$dec->bindValue(':periodoid', $periodoid, PDO::PARAM_STR);
			$dec->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ReLiquidarOB($empndoc,$benndoc,$periodoid){
		try{
			//-- Obtener codigos a liquidar ----
			$sql = 'SELECT legempleado_nrodocto,
										 legempleado_nrodocto_ben,
										 SUM(asignacion_importe) AS carfamimport
								FROM asignaciones_familiares a
							 WHERE legempleado_nrodocto = ?
							   AND legempleado_nrodocto_ben = ?
							   AND periodo_id = ?
					  GROUP BY legempleado_nrodocto
					  ORDER BY liqcod_id ASC';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $empndoc, PDO::PARAM_STR);
			$dec->bindValue(2, $benndoc, PDO::PARAM_STR);
			$dec->bindValue(3, $periodoid, PDO::PARAM_STR);
			$dec->execute();
			$cargasfamimp = $dec->fetch(PDO::FETCH_OBJ);

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
																				 ccosto_codigo,
																				 periodo_id,
																				 liquidacion_observacion,
																			 	 liquidacion_estado)
																	VALUES(5,
																				 :empnrodocto,
																				 :bennrodocto,
																				 0,
																				 2,
																				 218,
																				 "CARGAS FAMILIARES",
																				 0,
																				 2,
																				 :imptotal,
																				 0,
																				 :periodoid,
																				 "",
																				 1)';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(':empnrodocto', $empndoc, PDO::PARAM_STR);
			$dec->bindValue(':bennrodocto', $benndoc, PDO::PARAM_STR);
			$dec->bindValue(':imptotal', $cargasfamimp->carfamimport, PDO::PARAM_STR);
			$dec->bindValue(':periodoid', $periodoid, PDO::PARAM_STR);
			$dec->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerOficioNro($empleadonrodocto, $beneficiarionrodocto){
		try{
			$vacio = "";
			$sql = 'SELECT leghijo_bennoficio
								FROM legajos_hijo
							 WHERE leghijo_bennoficio <> ?
							   AND legempleado_nrodocto = ?
								 AND leghijo_benndoc = ?
							 LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $vacio, PDO::PARAM_STR);
			$stm->bindValue(2, $empleadonrodocto, PDO::PARAM_STR);
			$stm->bindValue(3, $beneficiarionrodocto, PDO::PARAM_STR);
			$stm->execute();
			return $stm->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerOficioNro_DOS($empleadonrodocto, $beneficiarionrodocto){
		try{

			$sql = 'SELECT leghijo_bennoficio
								FROM legajos_hijo
							 WHERE legempleado_nrodocto = ?
								 AND leghijo_benndoc = ?
							 LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $empleadonrodocto, PDO::PARAM_STR);
			$stm->bindValue(2, $beneficiarionrodocto, PDO::PARAM_STR);
			$stm->execute();
			return $stm->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}

	/////////////////////////CODIGO VIEJO//////////////////////////////////////////////////
















	public function ListarBeniciariosTitulares(){
		try{
			$fechaactual = date("Y-m-d");
			//--- Conyuge ---
			$sql = $this->cn->prepare("SELECT DISTINCT a.legempleado_nrodocto AS empleado,
																								 a.legempleado_nrodocto AS beneficiario
																						FROM legajos_conyuge a,
																								 legajos_empleado b
																					 WHERE a.legempleado_nrodocto = b.legempleado_nrodocto
																					 	 AND a.legempleado_nrodocto != a.legconyuge_nrodocto
																						 AND a.legconyuge_activo = 1
																						 AND b.legempleado_activo = 1");
			$sql->execute();
			$conyuge = $sql->fetchAll(PDO::FETCH_OBJ);
			//--- Pre-Natal ---
			$sql = $this->cn->prepare("SELECT DISTINCT a.legempleado_nrodocto AS empleado,
																								 a.legprenatal_benndoc AS beneficiario
																					  FROM legajos_prenatal a,
																								 legajos_empleado b
																					 WHERE a.legempleado_nrodocto = b.legempleado_nrodocto
																					 	 AND a.legempleado_nrodocto = a.legprenatal_benndoc
																					 	 AND a.legprenatal_activo = 1
																					 	 AND b.legempleado_activo = 1");
			$sql->execute();
			$prenatal = $sql->fetchAll(PDO::FETCH_OBJ);
			//--- Hijo Menor ---
			$fechafinaluno = date("Y-m-d",strtotime($fechaactual."- 5 year"));//resto 5 años
			$fechafinal = date("Y-m-d",strtotime($fechafinaluno."- 5 month"));
			$fechaactualmenoscinco = date("Y-m-d",strtotime($fechafinal."- 5 year"));//resto 5 años
			$sql = $this->cn->prepare("SELECT DISTINCT a.legempleado_nrodocto AS empleado,
																								 a.leghijo_benndoc AS beneficiario
																						FROM legajos_hijo a,
																								 legajos_empleado b
																					 WHERE a.legempleado_nrodocto = b.legempleado_nrodocto
																					   AND a.legempleado_nrodocto = a.leghijo_benndoc
																						 AND a.leghijo_disc != 1
																						 AND a.leghijo_esc != 1
																						 AND a.leghijo_activo = 1
																						 AND b.legempleado_activo = 1
																						 AND a.leghijo_fecnacto
																				 BETWEEN '$fechaactualmenoscinco' AND '$fechaactual'");
			$sql->execute();
			$hijomenor = $sql->fetchAll(PDO::FETCH_OBJ);
			//--- Hijo Escolar ---
			$fechaactualmenosveintitres_s = date("Y-m-d",strtotime($fechaactual."- 23 year"));//resto 23 años
			$fechaactualmenosveintitres = date("Y-m-d",strtotime($fechaactualmenosveintitres_s."- 5 month"));//resto 5 meses
			$sql = $this->cn->prepare("SELECT DISTINCT a.legempleado_nrodocto AS empleado,
																								 a.leghijo_benndoc AS beneficiario
																					  FROM legajos_hijo a,
																						     legajos_empleado b
																					 WHERE a.legempleado_nrodocto = b.legempleado_nrodocto
																					   AND a.legempleado_nrodocto = a.leghijo_benndoc
																						 AND a.leghijo_disc != 1
																						 AND a.leghijo_esc = 1
																						 AND a.leghijo_activo = 1
																						 AND b.legempleado_activo = 1
																						 AND a.leghijo_fecnacto
																				 BETWEEN '$fechaactualmenosveintitres' AND '$fechaactual'");
			$sql->execute();
			$hijoescolar = $sql->fetchAll(PDO::FETCH_OBJ);
			//--- Hijo con discapacidad // escolar con discapacidad ---
			$sql = $this->cn->prepare("SELECT DISTINCT a.legempleado_nrodocto AS empleado,
				                                         a.leghijo_benndoc AS beneficiario
																						FROM legajos_hijo a,
																						     legajos_empleado b
																					 WHERE a.legempleado_nrodocto = b.legempleado_nrodocto
																					   AND a.legempleado_nrodocto = a.leghijo_benndoc
																						 AND a.leghijo_disc = 1
																						 AND a.leghijo_activo = 1
																						 AND b.legempleado_activo = 1");
			$sql->execute();
			$hijodisc = $sql->fetchAll(PDO::FETCH_OBJ);
			//--- unir todos los arrays---
			$beneficiariostitulares = array_merge($conyuge, $prenatal, $hijomenor, $hijoescolar, $hijodisc);
			//--- eliminar contenido duplicado ---
			$beneficiariostitulares = array_map('json_encode', $beneficiariostitulares);
			$beneficiariostitulares = array_unique($beneficiariostitulares);
			$beneficiariostitulares = array_map('json_decode', $beneficiariostitulares);
			//--- Retornar contenido ---
			return $beneficiariostitulares;

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ListarOtrosBeniciariosHistorico($periodoid){
		try{
			$sql = $this->cn->prepare("SELECT DISTINCT legempleado_nrodocto AS empleado, beneficiario_nrodocto AS beneficiario, beneficiario_nrooficio AS oficio FROM asignaciones_otros WHERE asigotro_periodo = $periodoid ORDER BY legempleado_apellido, legempleado_nombres");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function DatosOtrosBeneficiariosHistorico($empleadonrodocto,$beneficiarionrodocto,$periodoid){
		try{

			$sql = $this->cn->prepare("SELECT *, SUM(asigotro_imptotal) AS obimptotal FROM asignaciones_otros WHERE legempleado_nrodocto = $empleadonrodocto  AND beneficiario_nrodocto = $beneficiarionrodocto AND asigotro_periodo = $periodoid");
			$sql->execute();

			return $sql->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function DatosAsignacionTipo($asignaciontipo,$empleadonrodocto,$beneficiarionrodocto,$periodoid){
		try{

			$sql = $this->cn->prepare("SELECT COUNT(asigotro_tipo) AS obasignaciontipo FROM asignaciones_otros WHERE asigotro_tipo = $asignaciontipo AND legempleado_nrodocto = $empleadonrodocto  AND beneficiario_nrodocto = $beneficiarionrodocto AND asigotro_periodo = $periodoid");
			$sql->execute();

			return $sql->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function DatosAsignacionFanNum($asignaciontipo,$empleadonrodocto,$beneficiarionrodocto,$periodoid){
		try{

			$sql = $this->cn->prepare("SELECT asigotro_cantidad FROM asignaciones_otros WHERE asigotro_tipo = $asignaciontipo AND legempleado_nrodocto = $empleadonrodocto  AND beneficiario_nrodocto = $beneficiarionrodocto AND asigotro_periodo = $periodoid LIMIT 1");
			$sql->execute();

			return $sql->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ListarBeniciariosLiquidaciones(){
		try{
			$periodo = Asignacion::PeriodoActualObtener();
			$periodoid = $periodo->periodo_id;
			$sql = $this->cn->prepare("SELECT DISTINCT legempleado_nrodocto AS empleado,
																								 beneficiario_nrodocto AS beneficiario,
																								 beneficiario_nrooficio AS oficio
																						FROM asignaciones_otros
																					 WHERE asigotro_periodo = $periodoid
																			  ORDER BY legempleado_apellido,
																				         legempleado_nombres");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}


	public function OtrosBeniciariosLiquidacionesImpT(){
		try{
			$periodo = Asignacion::PeriodoActualObtener();
			$periodoid = $periodo->periodo_id;
			$sql = $this->cn->prepare("SELECT SUM(asigotro_imptotal) AS obimptotal FROM asignaciones_otros WHERE asigotro_periodo = $periodoid LIMIT 1");
			$sql->execute();
			return $sql->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerPeriodoAsigOtro(){
		try{

			//$periodo = Asignacion::PeriodoActualObtener();
			//$periodoid = $periodo->periodo_id;
			$sql = $this->cn->prepare("SELECT asigotro_periodo AS periodosasigot FROM asignaciones_otros GROUP BY asigotro_periodo");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}

	public function BeneficiarioObtener($empleadonrodocto, $beneficiarionrodocto){
		try{

			$sql = 'SELECT leghijo_benapellido AS benapellido,
										 leghijo_bennombres AS bennombres
								FROM legajos_hijo
							 WHERE legempleado_nrodocto = ?
							   AND leghijo_benndoc = ?
						ORDER BY leghijo_id DESC LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $empleadonrodocto, PDO::PARAM_STR);
			$stm->bindValue(2, $beneficiarionrodocto, PDO::PARAM_STR);
			$stm->execute();
			//--- Contar registros ---
			$num = $stm->rowCount();
			if($num > 0){
				return $stm->fetch(PDO::FETCH_OBJ);
			}else{
				$sql = 'SELECT legprenatal_benapellido AS benapellido,
											 legprenatal_bennombres AS bennombres
								  FROM legajos_prenatal
								 WHERE legempleado_nrodocto = ?
								   AND legprenatal_benndoc = ?
							ORDER BY legprenatal_id DESC LIMIT 1';
				$stm = $this->cn->prepare($sql);
				$stm->bindValue(1, $empleadonrodocto, PDO::PARAM_STR);
				$stm->bindValue(2, $beneficiarionrodocto, PDO::PARAM_STR);
				$stm->execute();
				return $stm->fetch(PDO::FETCH_OBJ);
			}

		}catch (Exception $e){
			die($e->getMessage());
		}
	}













	public function ParametrosPreNatal(){
		try{
			$sql = $this->cn->prepare("SELECT * FROM parametro_prenatal");
			$sql->execute();

			return $sql->fetchAll(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ParametrosHijo(){
		try{
			$sql = $this->cn->prepare("SELECT * FROM parametro_hijo");
			$sql->execute();

			return $sql->fetchAll(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function HaberesRemunerativos(){
		try{
			$periodo = Asignacion::PeriodoActualObtener();
			$periodoid = $periodo->periodo_id;

			$sql = $this->cn->prepare("SELECT * FROM haberes_remunerativos WHERE periodo_id = $periodoid");
			$sql->execute();

			return $sql->fetchAll(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}

	public function ObtenerPeriodoActivo(){
		try{
			$sql = $this->cn->prepare("SELECT periodo_id,periodo_nombre FROM periodos WHERE periodo_cerrado = 0 ORDER BY periodo_id DESC LIMIT 1");
			$sql->execute();
			return $sql->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function HaberesRemExistentesObtener($periodoid){
		try{
			$sql = 'SELECT COUNT(liquidacion_id) AS hrremunc
								FROM liquidaciones
							 WHERE liqcod_id = 485
							 	 AND periodo_id = ?
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $periodoid, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function LiquidacionCodigoObtener($liqcodid){
		try{
			$sql = 'SELECT *
								FROM liquidaciones_codigo
							 WHERE liqcod_id = ?
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $liqcodid, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ImputacionObtener($ccostos){
		try{
			$sql = 'SELECT *
								FROM imputaciones
							 WHERE imputacion_codigow = ?
							 	 AND imputacion_habilitar = 1
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $ccostos, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function RegistrarHaberRemun($empleadonro,$empleadonrodocto,$centrocostos,$importedecimal,$periodoid,$estado){
		try{

			$sql = 'INSERT INTO haberes_remunerativos (legempleado_numero,legempleado_nrodocto,haberrem_centrocosto,haberrem_importe,periodo_id,haberrem_estado)
			VALUES(?, ?, ?, ?, ?, ?)';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $empleadonro, PDO::PARAM_STR);
			$stm->bindValue(2, $empleadonrodocto, PDO::PARAM_STR);
			$stm->bindValue(3, $centrocostos, PDO::PARAM_STR);
			$stm->bindValue(4, $importedecimal, PDO::PARAM_STR);
			$stm->bindValue(5, $periodoid, PDO::PARAM_STR);
			$stm->bindValue(6, $estado, PDO::PARAM_STR);
			$stm->execute();


		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function HaberesRemunerativosGuardarExe($data){
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
																				 ccosto_codigo,
																				 periodo_id,
																				 liquidacion_observacion,
																				 liquidacion_estado)
																	VALUES(:liqtid,
																				 :empndoc,
																				 :liqndoc,
																				 :numl,
																				 :titular,
																				 :liqcodid,
																				 :liqcoddes,
																				 :liqcant,
																				 :liqcodtid,
																				 :liqimporte,
																				 :imputacion,
																				 :periodoid,
																				 :liqobs,
																				 :liqestado)';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(':liqtid', $data->Liqtipoid, PDO::PARAM_STR);
			$dec->bindValue(':empndoc', $data->Empnrodocto, PDO::PARAM_STR);
			$dec->bindValue(':liqndoc', $data->Liqnrodocto, PDO::PARAM_STR);
			$dec->bindValue(':numl', $data->Legnrodocto, PDO::PARAM_STR);
			$dec->bindValue(':titular', $data->Titular, PDO::PARAM_STR);
			$dec->bindValue(':liqcodid', $data->Liqcodid, PDO::PARAM_STR);
			$dec->bindValue(':liqcoddes', $data->Liqcoddesc, PDO::PARAM_STR);
			$dec->bindValue(':liqcant', $data->Liqcantidad, PDO::PARAM_STR);
			$dec->bindValue(':liqcodtid', $data->Liqcodtipoid, PDO::PARAM_STR);
			$dec->bindValue(':liqimporte', $data->Liqimporte, PDO::PARAM_STR);
			$dec->bindValue(':imputacion', $data->Ccostos, PDO::PARAM_STR);
			$dec->bindValue(':periodoid', $data->Periodoid, PDO::PARAM_STR);
			$dec->bindValue(':liqobs', $data->Liqobs, PDO::PARAM_STR);
			$dec->bindValue(':liqestado', $data->Estado, PDO::PARAM_STR);
			$dec->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerPreNatalRango($rango){
		try{
			$sql = 'SELECT * FROM parametro_prenatal WHERE paramprenatal_id = ? LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $rango, PDO::PARAM_STR);
			$stm->execute();
			return $stm->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerHijoMenorRango($rango){
		try{
			$sql = 'SELECT * FROM parametro_hijo WHERE paramhijo_id = ? LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $rango, PDO::PARAM_STR);
			$stm->execute();
			return $stm->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerHijoDiscRango($rango){
		try{
			$sql = 'SELECT * FROM parametro_hijodisc WHERE 	paramhijodisc_id = ? LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $rango, PDO::PARAM_STR);
			$stm->execute();
			return $stm->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function AsigAdicional($opcion){
		try{
			$sql = 'SELECT * FROM parametro_escnvlo WHERE	paramescnvlo_id = ? LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $opcion, PDO::PARAM_STR);
			$stm->execute();
			return $stm->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}



	public function CalcularPreNatalR1($impdesde,$imphasta,$asignacion,$importeasig){
		try{
			//-- Datos Periodos ---
			$sql = $this->cn->prepare("SELECT periodo_id FROM periodos WHERE periodo_cerrado = 1 ORDER BY periodo_id DESC LIMIT 1");
			$sql->execute();
			$periodo = $sql->fetch(PDO::FETCH_OBJ);
			//-- Datos Haberes Remunerativos ----
			$sql = 'SELECT legempleado_nrodocto FROM haberes_remunerativos WHERE periodo_id = ? AND haberrem_importe BETWEEN ? AND ?';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $periodo->periodo_id, PDO::PARAM_STR);
			$stm->bindValue(2, $impdesde, PDO::PARAM_STR);
			$stm->bindValue(3, $imphasta, PDO::PARAM_STR);
			$stm->execute();
			$empleadosnrodocto = $stm->fetchAll(PDO::FETCH_OBJ);

			foreach($empleadosnrodocto as $empleadonrodocto){
				//
				$sql = 'UPDATE asignaciones SET asignacion_importe = ?, asignacion_importe_total = ? WHERE legempleado_nrodocto = ? AND asigtipo_id = ? AND periodo_id = ?';

				$stm = $this->cn->prepare($sql);
				$stm->bindValue(1, $importeasig, PDO::PARAM_STR);
				$stm->bindValue(2, $importeasig, PDO::PARAM_STR);
				$stm->bindValue(3, $empleadonrodocto->legempleado_nrodocto, PDO::PARAM_STR);
				$stm->bindValue(4, $asignacion, PDO::PARAM_STR);
				$stm->bindValue(5, $periodo->periodo_id, PDO::PARAM_STR);
				$stm->execute();
			}

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function CalcularFamNumR1($asignacion,$importeasig){
		try{
			//-- Datos Periodos ---
			$sql = $this->cn->prepare("SELECT periodo_id FROM periodos WHERE periodo_cerrado = 1 ORDER BY periodo_id DESC LIMIT 1");
			$sql->execute();
			$periodo = $sql->fetch(PDO::FETCH_OBJ);
			//-- Seleccionar Familias Numerosas
			$sql = 'SELECT asignacion_id,
										 legempleado_nrodocto,
										 asigtipo_id,
										 asignacion_cantidad
								FROM asignaciones
						   WHERE periodo_id = ?
							   AND asigtipo_id = ?';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $periodo->periodo_id, PDO::PARAM_STR);
			$stm->bindValue(2, $asignacion, PDO::PARAM_STR);
			$stm->execute();
			$familiasnumerosas = $stm->fetchAll(PDO::FETCH_OBJ);

			foreach($familiasnumerosas as  $familianumerosa){
				// code...
				$importefam = $importeasig * $familianumerosa->asignacion_cantidad;

				$sql = 'UPDATE asignaciones SET asignacion_importe = ?,
																				asignacion_importe_total = ?
																	WHERE asignacion_id = ?';

				$stm = $this->cn->prepare($sql);
				$stm->bindValue(1, $importefam, PDO::PARAM_STR);
				$stm->bindValue(2, $importefam, PDO::PARAM_STR);
				$stm->bindValue(3, $familianumerosa->asignacion_id, PDO::PARAM_STR);
				$stm->execute();

			}


			/*
			foreach($empleadosnrodocto as $empleadonrodocto){
				//
				$sql = 'UPDATE asignaciones_otros SET asigotro_importe = ?, asigotro_imptotal = ? WHERE legempleado_nrodocto = ? AND asigotro_tipo = ? AND asigotro_periodo = ?';

				$stm = $this->cn->prepare($sql);
				$stm->bindValue(1, $importeasig, PDO::PARAM_STR);
				$stm->bindValue(2, $importeasig, PDO::PARAM_STR);
				$stm->bindValue(3, $empleadonrodocto->legempleado_nrodocto, PDO::PARAM_STR);
				$stm->bindValue(4, $asignacion, PDO::PARAM_STR);
				$stm->bindValue(5, $periodo->periodo_id, PDO::PARAM_STR);
				$stm->execute();
			}
			*/

		}catch (Exception $e){
			die($e->getMessage());
		}
	}

	public function ExportarOB($periodoid){
		try{
			$sql = 'SELECT DISTINCT legempleado_nrodocto,beneficiario_nrodocto FROM asignaciones_otros WHERE asigotro_periodo = ?';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $periodoid, PDO::PARAM_STR);
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ExportarOBLiquidaciones($periodoid){
		try{
			$sql = 'SELECT DISTINCT legempleado_nrodocto,
															liquidacion_nrodocto
												 FROM liquidaciones
												WHERE liquidacion_titular = 2
													AND periodo_id = ?';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $periodoid, PDO::PARAM_STR);
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ExportarAEOBLiquidaciones($periodoid){
		try{
			$sql = 'SELECT DISTINCT legempleado_nrodocto,
															liquidacion_nrodocto
												 FROM liquidaciones
												WHERE liquidacion_titular = 2
												AND liqtipo_id = 6
													AND periodo_id = ?
													AND liquidacion_estado = 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $periodoid, PDO::PARAM_STR);
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function OBCantidadObtener($periodoid){
		try{
			$sql = 'SELECT liquidacion_nrodocto
							  FROM liquidaciones
							 WHERE liquidacion_titular = 2
							 	 AND liqtipo_id = 5
								 AND periodo_id = ?
								 AND liquidacion_estado = 1
            GROUP BY liquidacion_nrodocto';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $periodoid, PDO::PARAM_STR);
			$stm->execute();
			return $stm->rowCount();
			//return $stm->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function OBAECantidadObtener($periodoid){
		try{
			$sql = 'SELECT liquidacion_nrodocto
							  FROM liquidaciones
							 WHERE liquidacion_titular = 2
							 AND liqtipo_id = 6
								 AND periodo_id = ?
								 AND liquidacion_estado = 1
            GROUP BY liquidacion_nrodocto';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $periodoid, PDO::PARAM_STR);
			$stm->execute();
			return $stm->rowCount();
			//return $stm->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerCCostos($empleado){
		try{
			$sql = 'SELECT haberrem_centrocosto FROM haberes_remunerativos WHERE legempleado_nrodocto = ? LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $empleado, PDO::PARAM_STR);
			$stm->execute();

			return $stm->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function CCostosObtener($empleado){
		try{
			$sql = 'SELECT ccosto_codigo,
										 legempleado_nrodocto
			 					FROM liquidaciones
							 WHERE legempleado_nrodocto = ?
							 	 AND liquidacion_titular = 1
								 AND liqcod_id = 485
							 LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $empleado, PDO::PARAM_STR);
			$stm->execute();

			return $stm->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerImporteOB($empleado,$beneficiario,$periodoid){
		try{
			$sql = 'SELECT SUM(asigotro_imptotal) AS importeob FROM asignaciones_otros WHERE legempleado_nrodocto = ? AND beneficiario_nrodocto = ? AND asigotro_periodo = ? LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $empleado, PDO::PARAM_STR);
			$stm->bindValue(2, $beneficiario, PDO::PARAM_STR);
			$stm->bindValue(3, $periodoid, PDO::PARAM_STR);
			$stm->execute();

			return $stm->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function SueldoNetoOBObtener($empleado,$beneficiario,$periodoid){
		try{
			$sql = 'SELECT liquidacion_importe
									AS importeob
								FROM liquidaciones
							 WHERE legempleado_nrodocto = ?
							   AND liquidacion_nrodocto = ?
								 AND liqcod_id = 484
								 AND periodo_id = ?
							 LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $empleado, PDO::PARAM_STR);
			$stm->bindValue(2, $beneficiario, PDO::PARAM_STR);
			$stm->bindValue(3, $periodoid, PDO::PARAM_STR);
			$stm->execute();

			return $stm->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function SueldoNetoOBAEObtener($empleado,$beneficiario,$periodoid){
		try{
			$sql = 'SELECT liquidacion_importe
									AS importeob
								FROM liquidaciones
							 WHERE legempleado_nrodocto = ?
							   AND liquidacion_nrodocto = ?
								 AND liqtipo_id = 6
								 AND liqcod_id = 484
								 AND periodo_id = ?
							 LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $empleado, PDO::PARAM_STR);
			$stm->bindValue(2, $beneficiario, PDO::PARAM_STR);
			$stm->bindValue(3, $periodoid, PDO::PARAM_STR);
			$stm->execute();

			return $stm->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function SueldoNetoOBObtenerTotal($periodoid){
		try{
			$sql = 'SELECT SUM(liquidacion_importe)
									AS importesnob
								FROM liquidaciones
							 WHERE liquidacion_titular = 2
							 	 AND liqcod_id = 484
								 AND periodo_id = ?
							 LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $periodoid, PDO::PARAM_STR);
			$stm->execute();

			return $stm->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function SueldoNetoOBAEObtenerTotal($periodoid){
		try{
			$sql = 'SELECT SUM(liquidacion_importe)
									AS importesnob
								FROM liquidaciones
							 WHERE liquidacion_titular = 2
							 AND liqtipo_id = 6
							 	 AND liqcod_id = 484
								 AND periodo_id = ?
								 AND liquidacion_estado = 1
							 LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $periodoid, PDO::PARAM_STR);
			$stm->execute();

			return $stm->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function OficioObtener($empleado,$beneficiario,$periodoid){
		try{
			$sql = 'SELECT asignacion_phc_bennoficio
								FROM asignaciones_familiares
							 WHERE legempleado_nrodocto = ?
							 	 AND asignacion_phc_bennoficio != ""
							   AND legempleado_nrodocto_ben = ?
								 AND periodo_id = ?
							 LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $empleado, PDO::PARAM_STR);
			$stm->bindValue(2, $beneficiario, PDO::PARAM_STR);
			$stm->bindValue(3, $periodoid, PDO::PARAM_STR);
			$stm->execute();

			return $stm->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerAsignacionesOB(){
		try{
			$sql = $this->cn->prepare("SELECT * FROM asignaciones_tipo WHERE asigtipo_activo = 1 ORDER BY asigtipo_nombre");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function DatosBeneficiarioReajuste($nrodocto,$periodoid){
		try{
			$sql = 'SELECT * FROM asignaciones
											WHERE _benndoc = ?
												AND periodo_id = ?
									 ORDER BY legempleado_apellido,
									 					legempleado_nombres';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$stm->bindValue(2, $periodoid, PDO::PARAM_STR);
			$stm->execute();
			return $stm->fetchAll(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function DatosEmpleadoReajuste($nrodocto,$periodoid){
		try{
			//$sql = 'SELECT * FROM asignaciones_otros a, legajos_empleado b WHERE a.legempleado_nrodocto = b.legempleado_nrodocto AND a.legempleado_nrodocto = ? AND a.asigotro_periodo = ?';
			$sql = 'SELECT * FROM asignaciones_otros a WHERE legempleado_nrodocto = ? AND asigotro_periodo = ? ORDER BY beneficiario_apellido, beneficiario_nombres';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$stm->bindValue(2, $periodoid, PDO::PARAM_STR);
			$stm->execute();
			return $stm->fetchAll(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerTipoAsignacion($asignaciontipoid){
		try{
			$sql = 'SELECT * FROM asignaciones_tipo WHERE asigtipo_id = ? LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $asignaciontipoid, PDO::PARAM_STR);
			$stm->execute();
			return $stm->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function AsignacionTipoObtener($asignaciontipoid){
		try{
			$sql = 'SELECT *
								FROM asignaciones_tipo
							 WHERE asigtipo_id = ?
							 LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $asignaciontipoid, PDO::PARAM_STR);
			$stm->execute();
			return $stm->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function HijoObtener_Id($hijoid){
		try{
			$sql = 'SELECT *
								FROM legajos_hijo
							 WHERE leghijo_id = ?
							 LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $hijoid, PDO::PARAM_STR);
			$stm->execute();
			return $stm->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	/*public function PreNatalObener_Id($prenatalid){
		try{
			$sql = 'SELECT *
								FROM asignaciones_tipo
							 WHERE asigtipo_id = ?
							 LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $asignaciontipoid, PDO::PARAM_STR);
			$stm->execute();
			return $stm->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}*/
	public function ObtenerImporteOBReajuste($periodoid){
		try{
			$sql = 'SELECT SUM(asignacion_importe) AS importeobr
							  FROM asignaciones
							 WHERE asigtipo_id != 8
							   AND periodo_id = ?
							 LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $periodoid, PDO::PARAM_STR);
			$stm->execute();
			return $stm->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function RegistrarOBReajauste($data){
		try{
			$sql = 'UPDATE asignaciones_otros SET asigotro_reajuste = ?, asigotro_reajusteobs = ?, asigotro_imptotal = ? WHERE asigotro_id = ?';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->AsigReajuste, PDO::PARAM_STR);
			$stm->bindValue(2, $data->AsigReajusteObs, PDO::PARAM_STR);
			$stm->bindValue(3, $data->AsigImpTotal, PDO::PARAM_STR);
			$stm->bindValue(4, $data->Id, PDO::PARAM_STR);
			$stm->execute();
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function TiposLegajos(){
		try{

			$sql = $this->cn->prepare("SELECT * FROM legajos_tipo WHERE legtipo_habilitar = 1");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerLegajoTipo($id){
		try{

			$sql = 'SELECT * FROM legajos_tipo WHERE legtipo_id = ? LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $id, PDO::PARAM_STR);
			$stm->execute();
			return $stm->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
}
