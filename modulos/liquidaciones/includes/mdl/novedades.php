<?php

class Licencia{

	public function __CONSTRUCT(){
		try{
			$this->cn = Conexion::getConnection();
		}
		catch(Exception $e){
			die($e->getMessage());
		}
	}
	public function __DESTRUCT(){
		$db;
		$this->cn;
	}
	public function EmpleadoObtener_DNI($nrodocto){
		try{

			$sql = 'SELECT legempleado_apellido,
										 legempleado_nombres,
										 legtipo_id,
										 legempleado_activo
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
	public function SecYTrabajoObtener($nrodocto){
		try{

			$sql = 'SELECT *
								FROM empleado_secretaria_lugar_trabajo
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
	public function SecretariaObtener($secretariaid){
		try{

			$sql = 'SELECT *
								FROM secretarias
							 WHERE secretaria_id = ?
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $secretariaid, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function TrabajoObtener($trabajoid){
		try{

			$sql = 'SELECT *
								FROM lugares_trabajo
							 WHERE trabajo_id = ?
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $trabajoid, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function LegajoTipoObtener($legtipoid){
		try{

			$sql = 'SELECT *
								FROM legajos_tipo
							 WHERE legtipo_id = ?
							 LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $legtipoid, PDO::PARAM_STR);
			$stm->execute();
			return $stm->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function LicenciasListar(){
		try{

			$sql = $this->cn->prepare("SELECT *
																	 FROM licencias
																	WHERE licencia_activo = 1
															 ORDER BY licencia_nombre");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function LicenciaObtener_CANTIDAD($licenciaid, $fechai, $fechaf){
		try{

			$sql = 'SELECT DISTINCT COUNT(legempleado_nrodocto)
									AS emp_cantidad
								FROM licencias_proceso
							 WHERE licencia_id = ?
								 AND lproceso_fecha
						 BETWEEN ?
						 		 AND ?
								 AND lproceso_activo = 1';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $licenciaid, PDO::PARAM_STR);
			$stm->bindValue(2, $fechai, PDO::PARAM_STR);
			$stm->bindValue(3, $fechaf, PDO::PARAM_STR);
			$stm->execute();
			return $stm->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function LicenciaObtener_FECHA($licenciaid, $fechai, $fechaf){
		try{

			$sql = 'SELECT *
								FROM licencias_proceso a
		 			INNER JOIN licencias b
						 			ON a.licencia_id = b.licencia_id
								 AND a.licencia_id = ?
								 AND a.lproceso_fecha
						 BETWEEN ?
						 		 AND ?
								 AND a.lproceso_activo = 1
						GROUP BY a.lproceso_fecha,
										 a.legempleado_nrodocto';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $licenciaid, PDO::PARAM_STR);
			$stm->bindValue(2, $fechai, PDO::PARAM_STR);
			$stm->bindValue(3, $fechaf, PDO::PARAM_STR);
			$stm->execute();
			return $stm->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function LicenciaObtener_NOMBRE($licenciaid){
		try{

			$sql = 'SELECT *
								FROM licencias
							 WHERE licencia_id = ?
							 LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $licenciaid, PDO::PARAM_STR);
			$stm->execute();
			return $stm->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function PeriodoActualObtener(){
		try{
			$sql = $this->cn->prepare("SELECT *
																	 FROM periodos
																	WHERE periodo_cerrado = 1
															 ORDER BY periodo_id DESC LIMIT 1");
			$sql->execute();
			return $sql->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	///////////////CODIGOS VIEJOS//////////////////////
	//------ Sentencias nuevas
	public function ListarLicencias(){
		try{

			$sql = $this->cn->prepare("SELECT *
																	 FROM licencias
																	WHERE licencia_vac = 0
																		AND licencia_activo = 1
															 ORDER BY licencia_nombre");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ListarLicenciasAnualesOrdinarias(){
		try{

			$sql = $this->cn->prepare("SELECT *
																	 FROM licencias
																	WHERE licencia_activo = 1
																		AND licencia_vac = 1
															 ORDER BY licencia_nombre");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerLicenciasAgrupadas($licenciaid, $nrodocto, $fecha_inicio, $fecha_licenciau){
		try{

			if($licenciaid == "T"){
				$sql = 'SELECT *, COUNT(a.licencia_id) AS licenciasac FROM licencias_proceso a, licencias b WHERE a.licencia_id = b.licencia_id AND a.legempleado_nrodocto = ? AND a.lproceso_activo = 1 AND a.lproceso_fecha BETWEEN ? AND ? GROUP BY a.licencia_id ORDER BY b.licencia_nombre';
				$stm = $this->cn->prepare($sql);
				$stm->bindValue(1, $nrodocto, PDO::PARAM_STR);
				$stm->bindValue(2, $fecha_inicio, PDO::PARAM_STR);
				$stm->bindValue(3, $fecha_licenciau, PDO::PARAM_STR);
				$stm->execute();
				return $stm->fetchAll(PDO::FETCH_OBJ);
			}else{
				$sql = 'SELECT *, COUNT(a.licencia_id) AS licenciasac FROM licencias_proceso a, licencias b WHERE a.licencia_id = b.licencia_id AND a.legempleado_nrodocto = ? AND a.lproceso_activo = 1 AND a.licencia_id = ? AND a.lproceso_fecha BETWEEN ? AND ? GROUP BY a.licencia_id ORDER BY b.licencia_nombre';
				$stm = $this->cn->prepare($sql);
				$stm->bindValue(1, $nrodocto, PDO::PARAM_STR);
				$stm->bindValue(2, $licenciaid, PDO::PARAM_STR);
				$stm->bindValue(3, $fecha_inicio, PDO::PARAM_STR);
				$stm->bindValue(4, $fecha_licenciau, PDO::PARAM_STR);
				$stm->execute();
				return $stm->fetchAll(PDO::FETCH_OBJ);
			}

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerLicenciaAnualOrdinariaLibre($nrodocto){
		try{

			$sql = 'SELECT * FROM licencias_anuales_ordinarias a, licencias b WHERE a.licencia_id = b.licencia_id AND a.licanualord_dias_disponibles > 0 AND a.legempleado_nrodocto = ? ORDER BY a.licencia_id LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$stm->execute();
			return $stm->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerLicenciasAnualesOrdinariasLibres($nrodocto){
		try{

			$sql = 'SELECT * FROM licencias_anuales_ordinarias a, licencias b WHERE a.licencia_id = b.licencia_id AND a.licanualord_dias_disponibles > 0 AND a.legempleado_nrodocto = ? ORDER BY a.licencia_id';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$stm->execute();
			return $stm->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerLicencias($licenciaid, $nrodocto, $fecha_inicio, $fecha_licenciau){
		try{

			if($licenciaid == "T"){
				$sql = 'SELECT * FROM licencias_proceso a, licencias b WHERE a.licencia_id = b.licencia_id AND a.legempleado_nrodocto = ? AND a.lproceso_activo = 1 AND a.lproceso_fecha BETWEEN ? AND ? ORDER BY a.lproceso_fecha';
				$stm = $this->cn->prepare($sql);
				$stm->bindValue(1, $nrodocto, PDO::PARAM_STR);
				$stm->bindValue(2, $fecha_inicio, PDO::PARAM_STR);
				$stm->bindValue(3, $fecha_licenciau, PDO::PARAM_STR);
				$stm->execute();
				return $stm->fetchAll(PDO::FETCH_OBJ);
			}else{
				$sql = 'SELECT * FROM licencias_proceso a, licencias b WHERE a.licencia_id = b.licencia_id AND a.legempleado_nrodocto = ? AND a.lproceso_activo = 1 AND a.licencia_id = ? AND a.lproceso_fecha BETWEEN ? AND ? ORDER BY a.lproceso_fecha';
				$stm = $this->cn->prepare($sql);
				$stm->bindValue(1, $nrodocto, PDO::PARAM_STR);
				$stm->bindValue(2, $licenciaid, PDO::PARAM_STR);
				$stm->bindValue(3, $fecha_inicio, PDO::PARAM_STR);
				$stm->bindValue(4, $fecha_licenciau, PDO::PARAM_STR);
				$stm->execute();
				return $stm->fetchAll(PDO::FETCH_OBJ);
			}

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerLicAnuOrdCargadas($nrodocto){
		try{

			$sql = 'SELECT * FROM licencias_proceso a, licencias b WHERE a.licencia_id = b.licencia_id AND a.legempleado_nrodocto = ? AND b.licencia_vac = 1 AND a.lproceso_activo = 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$stm->execute();
			return $stm->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerLicAnuOrdAgrupadas($nrodocto){
		try{

			$sql = 'SELECT *, COUNT(a.lproceso_fecha) AS licanuorddiasc FROM licencias_proceso a, licencias b WHERE a.licencia_id = b.licencia_id AND a.legempleado_nrodocto = ? AND b.licencia_vac = 1 AND a.lproceso_activo = 1 GROUP BY b.licencia_nombre';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$stm->execute();
			return $stm->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerLicenciasCargadas($nrodocto, $fecha_sql){
		try{

			$sql = 'SELECT *, COUNT(lproceso_id) AS licc FROM licencias_proceso WHERE legempleado_nrodocto = ? AND lproceso_fecha = ? GROUP BY lproceso_fecha';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$stm->bindValue(2, $fecha_sql, PDO::PARAM_STR);
			$stm->execute();
			return $stm->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObterDiaTipo($diatipo){
		try{

			$sql = 'SELECT * FROM licencias_dias_tipo WHERE	licdia_tipo_id = ? LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $diatipo, PDO::PARAM_STR);
			$stm->execute();
			return $stm->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerLicenciaAnualOrdinariaId($licanuordid){
		try{

			$sql = 'SELECT licencia_nombre FROM licencias WHERE licencia_id = ? LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $licanuordid, PDO::PARAM_STR);
			$stm->execute();
			return $stm->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function LicenciasAnualOrdinariaCargadas($nrodocto, $licanuordid){
		try{

			$sql = 'SELECT * FROM licencias_proceso a, licencias b WHERE a.licencia_id = b.licencia_id AND a.legempleado_nrodocto = ? AND a.licencia_id = ? AND a.lproceso_activo = 1 ORDER BY a.lproceso_fecha';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$stm->bindValue(2, $licanuordid, PDO::PARAM_STR);
			$stm->execute();
			return $stm->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ListarLugaresDeTrabajo(){
		try{

			$sql = $this->cn->prepare("SELECT * FROM lugares_trabajo WHERE trabajo_activo = 1 ORDER BY trabajo_nombre");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerUltimaFecLicEmp($nrodocto){
		try{

			$sql = 'SELECT lproceso_fecha FROM licencias_proceso WHERE legempleado_nrodocto = ? AND lproceso_activo = 1 ORDER BY lproceso_fecha DESC LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$stm->execute();
			return $stm->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}

	public function ObtenerLicenciasFilFechas($nrodocto, $fecha_inicio, $fecha_final){
		try{

			$sql = $this->cn->prepare("SELECT a.licencia_id,b.licencia_nombre FROM licencias_proceso a, licencias b WHERE a.licencia_id = b.licencia_id AND a.legempleado_nrodocto = '$nrodocto' AND a.lproceso_activo = 1  AND a.lproceso_fecha BETWEEN '$fecha_inicio' AND '$fecha_final' GROUP BY a.licencia_id");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerLicenciasFilFechasEliminar($nrodocto, $licenciaid, $fecha_inicio, $fecha_final){
		try{

			$sql = $this->cn->prepare("SELECT lproceso_id,lproceso_fecha FROM licencias_proceso WHERE legempleado_nrodocto = '$nrodocto' AND licencia_id = '$licenciaid' AND lproceso_activo = 1 AND lproceso_fecha BETWEEN '$fecha_inicio' AND '$fecha_final' ORDER BY lproceso_fecha");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerLicAnuOrdFilFechas($nrodocto, $fechacorte){
		try{

			$sql = $this->cn->prepare("SELECT a.licencia_id,b.licencia_nombre FROM licencias_proceso a, licencias b WHERE a.licencia_id = b.licencia_id AND a.legempleado_nrodocto = '$nrodocto' AND b.licencia_vac = 1 AND a.lproceso_activo = 1  AND a.lproceso_fecha >= '$fechacorte' GROUP BY a.licencia_id");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerLicAnuOrdFilFechasEliminar($nrodocto, $fechacorte, $licenciaid){
		try{

			$sql = $this->cn->prepare("SELECT lproceso_id,lproceso_fecha,lproceso_proceso FROM licencias_proceso WHERE legempleado_nrodocto = '$nrodocto' AND licencia_id = '$licenciaid' AND lproceso_activo = 1 AND lproceso_fecha >= '$fechacorte' ORDER BY lproceso_fecha");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function LicenciaEliminarExe($licenciaid, $licenciasobs){
		try{
			//---- Eliminar licencia ----
			$sql = 'UPDATE licencias_proceso SET 	lproceso_activo = 0 WHERE lproceso_id = ?';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $licenciaid, PDO::PARAM_STR);
			$stm->execute();
			//----------Auditoria de eliminacion de licencias -----
			$sql = 'SELECT * FROM licencias_proceso WHERE lproceso_id = ? LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $licenciaid, PDO::PARAM_STR);
			$stm->execute();
			$row = $stm->fetch(PDO::FETCH_OBJ);
			//---------- Datos para la auditoria ----------------
			$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];
			$ippublica = $_SERVER["REMOTE_ADDR"];
			$pcnombre = gethostbyaddr($_SERVER['REMOTE_ADDR']);
			$pcinformacion = $_SERVER['HTTP_USER_AGENT'];

			$sql ='INSERT INTO aud_licencias_proceso (AUD_lproceso_id,AUD_legempleado_nrodocto,AUD_licencia_id,AUD_lproceso_fecha,AUD_lproceso_proceso,AUD_lproceso_activo,AUD_lproceso_observacion,AUD_lproceso_ippublica,AUD_lproceso_pcnombre,AUD_lproceso_pcinformacion,AUD_accion,AUD_datetime,AUD_usuario) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, "DISABLE", NOW(), ?)';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $row->lproceso_id, PDO::PARAM_STR);
			$stm->bindValue(2, $row->legempleado_nrodocto, PDO::PARAM_STR);
			$stm->bindValue(3, $row->licencia_id, PDO::PARAM_STR);
			$stm->bindValue(4, $row->lproceso_fecha, PDO::PARAM_STR);
			$stm->bindValue(5, $row->lproceso_proceso, PDO::PARAM_STR);
			$stm->bindValue(6, $row->lproceso_activo, PDO::PARAM_STR);
			$stm->bindValue(7, $licenciasobs, PDO::PARAM_STR);
			$stm->bindValue(8, $ippublica, PDO::PARAM_STR);
			$stm->bindValue(9, $pcnombre, PDO::PARAM_STR);
			$stm->bindValue(10, $pcinformacion, PDO::PARAM_STR);
			$stm->bindValue(11, $usuario, PDO::PARAM_STR);
			$stm->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function LicenciaAnualOrdinariaCortarExe($licprocesoid,$liccortetipoid,$liccortarobservacion){
		try{
			//---- Cortar licencia ----
			$sql = 'UPDATE licencias_proceso SET 	lproceso_activo = 0 WHERE lproceso_id = ?';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $licprocesoid, PDO::PARAM_STR);
			$stm->execute();
			//----------Auditoria de corte de licencias -----
			$sql = 'SELECT * FROM licencias_proceso WHERE lproceso_id = ? LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $licprocesoid, PDO::PARAM_STR);
			$stm->execute();
			$row = $stm->fetch(PDO::FETCH_OBJ);
			//---------- Datos para la auditoria ----------------
			$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];
			$ippublica = $_SERVER["REMOTE_ADDR"];
			$pcnombre = gethostbyaddr($_SERVER['REMOTE_ADDR']);
			$pcinformacion = $_SERVER['HTTP_USER_AGENT'];

			$sql ='INSERT INTO aud_licencias_proceso (AUD_lproceso_id,AUD_legempleado_nrodocto,AUD_licencia_id,AUD_lproceso_fecha,AUD_lproceso_proceso,AUD_lproceso_activo,AUD_lproceso_observacion,AUD_lproceso_ippublica,AUD_lproceso_pcnombre,AUD_lproceso_pcinformacion,AUD_accion,AUD_datetime,AUD_usuario) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, "CUT", NOW(), ?)';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $row->lproceso_id, PDO::PARAM_STR);
			$stm->bindValue(2, $row->legempleado_nrodocto, PDO::PARAM_STR);
			$stm->bindValue(3, $row->licencia_id, PDO::PARAM_STR);
			$stm->bindValue(4, $row->lproceso_fecha, PDO::PARAM_STR);
			$stm->bindValue(5, $row->lproceso_proceso, PDO::PARAM_STR);
			$stm->bindValue(6, $row->lproceso_activo, PDO::PARAM_STR);
			$stm->bindValue(7, $liccortarobservacion, PDO::PARAM_STR);
			$stm->bindValue(8, $ippublica, PDO::PARAM_STR);
			$stm->bindValue(9, $pcnombre, PDO::PARAM_STR);
			$stm->bindValue(10, $pcinformacion, PDO::PARAM_STR);
			$stm->bindValue(11, $usuario, PDO::PARAM_STR);
			$stm->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerLicenciaAnualOrdinaria($licenciaid, $nrodocto){
		try{

			$sql = 'SELECT * FROM licencias_anuales_ordinarias WHERE licencia_id = ? AND legempleado_nrodocto = ? LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $licenciaid, PDO::PARAM_STR);
			$stm->bindValue(2, $nrodocto, PDO::PARAM_STR);
			$stm->execute();
			return $stm->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerLicAnuOrdDenegar($nrodocto){
		try{

			$sql = 'SELECT * FROM licencias_anuales_ordinarias a, licencias b WHERE a.licencia_id = b.licencia_id AND legempleado_nrodocto = ? AND licanualord_dias_disponibles != 0 AND licanualord_denegada = 0';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$stm->execute();
			return $stm->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerLicAnuOrdDenegadas($nrodocto){
		try{

			$sql = 'SELECT * FROM licencias_anuales_ordinarias a, licencias b WHERE a.licencia_id = b.licencia_id AND legempleado_nrodocto = ? AND licanualord_dias_disponibles != 0 AND licanualord_denegada = 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$stm->execute();
			return $stm->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function LicenciaAnualOrdinariaDenegarExe($licnrodocto, $licenciaid, $licenciasobs){
		try{
			//---- Denegar licencia ----
			$sql = 'UPDATE licencias_anuales_ordinarias SET	licanualord_denegada = 1 WHERE legempleado_nrodocto = ? AND licencia_id = ?';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $licnrodocto, PDO::PARAM_STR);
			$stm->bindValue(2, $licenciaid, PDO::PARAM_STR);
			$stm->execute();
			//----------Auditoria denegacion de licencias -----
			$sql = 'SELECT * FROM licencias_anuales_ordinarias WHERE legempleado_nrodocto = ? AND licencia_id = ? LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $licnrodocto, PDO::PARAM_STR);
			$stm->bindValue(2, $licenciaid, PDO::PARAM_STR);
			$stm->execute();
			$row = $stm->fetch(PDO::FETCH_OBJ);
			//---------- Datos para la auditoria ----------------
			$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];
			$ippublica = $_SERVER["REMOTE_ADDR"];
			$pcnombre = gethostbyaddr($_SERVER['REMOTE_ADDR']);
			$pcinformacion = $_SERVER['HTTP_USER_AGENT'];

			$sql ='INSERT INTO aud_licencias_anuales_ordinarias (AUD_licanualord_id,AUD_licencia_id,AUD_legempleado_nrodocto,AUD_licanualord_dias,AUD_licanualord_dias_disponibles,AUD_licanualord_fracciones,AUD_licanualord_fracciones_disponibles,AUD_licanualord_denegada,AUD_licanualord_habilitar,AUD_licanualord_movimiento_tipo_id,AUD_licanualord_observacion,AUD_licanualord_ippublica,AUD_licanualord_pcnombre,AUD_licanualord_pcinformacion,AUD_licanualord_accion,AUD_licanualord_datetime,AUD_licanualord_usuario) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 3, ?, ?, ?, ?, "DENY", NOW(), ?)';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $row->licanualord_id, PDO::PARAM_STR);
			$stm->bindValue(2, $row->licencia_id, PDO::PARAM_STR);
			$stm->bindValue(3, $row->legempleado_nrodocto, PDO::PARAM_STR);
			$stm->bindValue(4, $row->licanualord_dias, PDO::PARAM_STR);
			$stm->bindValue(5, $row->licanualord_dias_disponibles, PDO::PARAM_STR);
			$stm->bindValue(6, $row->licanualord_fracciones, PDO::PARAM_STR);
			$stm->bindValue(7, $row->licanualord_fracciones_disponibles, PDO::PARAM_STR);
			$stm->bindValue(8, $row->licanualord_denegada, PDO::PARAM_STR);
			$stm->bindValue(9, $row->licanualord_habilitar, PDO::PARAM_STR);
			$stm->bindValue(10, $licenciasobs, PDO::PARAM_STR);
			$stm->bindValue(11, $ippublica, PDO::PARAM_STR);
			$stm->bindValue(12, $pcnombre, PDO::PARAM_STR);
			$stm->bindValue(13, $pcinformacion, PDO::PARAM_STR);
			$stm->bindValue(14, $usuario, PDO::PARAM_STR);
			$stm->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerLicenciasRango($nrodocto, $licenciaid, $fechainicio, $fechafinal){
		try{

			$sql = $this->cn->prepare("SELECT *, COUNT(a.licencia_id) AS licrangc FROM licencias_proceso a, licencias b WHERE a.licencia_id = b.licencia_id AND a.legempleado_nrodocto = '$nrodocto' AND a.licencia_id = '$licenciaid' AND a.lproceso_activo = 1  AND a.lproceso_fecha BETWEEN '$fechainicio' AND '$fechafinal' GROUP BY a.licencia_id ORDER BY a.lproceso_fecha LIMIT 1");
			$sql->execute();
			return $sql->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerLicenciasAORango($nrodocto, $fechainicio, $fechafinal){
		try{

			$sql = $this->cn->prepare("SELECT *, COUNT(a.licencia_id) AS licrangc FROM licencias_proceso a, licencias b WHERE a.licencia_id = b.licencia_id AND a.legempleado_nrodocto = '$nrodocto' AND a.lproceso_activo = 1  AND a.lproceso_fecha BETWEEN '$fechainicio' AND '$fechafinal' GROUP BY a.licencia_id ORDER BY a.lproceso_fecha LIMIT 1");
			$sql->execute();
			return $sql->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	//------ Sentencias Viejas
	public function PeriodoUCerrado(){
		try{
			$sql = $this->cn->prepare("SELECT * FROM periodos WHERE periodo_cerrado = 1 ORDER BY periodo_id DESC LIMIT 1");
			$sql->execute();
			return $sql->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ListarInasistenciasNroDocto(){
		try{

			$periodoucerrado = Licencia::PeriodoUCerrado();
			$periodoui = $periodoucerrado->periodo_presentismo_i;
			$periodouf = $periodoucerrado->periodo_presentismo_f;
			/*
			$sql = 'SELECT DISTINCT a.legempleado_nrodocto FROM licencias_proceso a, licencias b WHERE a.licencia_id = b.licencia_id AND b.licencia_presentismo = 1 AND a.lproceso_fecha BETWEEN ? AND ? ORDER BY a.lproceso_fecha';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $periodoui, PDO::PARAM_STR);
			$stm->bindValue(2, $periodouf, PDO::PARAM_STR);
			$stm->execute();
			return $stm->fetchAll(PDO::FETCH_OBJ);
			*/
			$sql = $this->cn->prepare("SELECT DISTINCT a.legempleado_nrodocto FROM licencias_proceso a, licencias b WHERE a.licencia_id = b.licencia_id AND b.licencia_presentismo = 1 AND a.lproceso_activo = 1 AND a.lproceso_fecha BETWEEN '$periodoui' AND '$periodouf' ORDER BY a.lproceso_fecha");
			$sql->execute();

			return $sql->fetchAll(PDO::FETCH_OBJ);





		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function DatosEmpleado($nrodocto){
		try{

			$sql = 'SELECT legempleado_apellido,legempleado_nombres FROM legajos_empleado WHERE legempleado_nrodocto = ? LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$stm->execute();
			return $stm->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerFeriadoDia($fecha){
		try{

			$sql = 'SELECT feriado_fecha FROM feriados WHERE feriado_fecha = ? AND feriado_activo = 1 LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $fecha, PDO::PARAM_STR);
			$stm->execute();
			return $stm->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function DatosLicenciasPre($nrodocto){
		try{

			$periodoucerrado = Licencia::PeriodoUCerrado();
			$periodoui = $periodoucerrado->periodo_presentismo_i;
			$periodouf = $periodoucerrado->periodo_presentismo_f;

			/*
			$sql = "SELECT b.licencia_nombre, COUNT(b.licencia_nombre) AS licenciacantidad FROM licencias_proceso a, licencias b WHERE a.licencia_id = b.licencia_id AND a.legempleado_nrodocto = ? AND a.lproceso_activo > 0 AND b.licencia_presentismo = 1 AND a.lproceso_fecha BETWEEN '$periodoui' AND '$periodouf' GROUP BY b.licencia_nombre";
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$stm->bindValue(2, $periodoui, PDO::PARAM_STR);
			$stm->bindValue(3, $periodouf, PDO::PARAM_STR);
			//$stm->execute();
			//return $stm->fetchAll(PDO::FETCH_OBJ);
			*/

			$sql = $this->cn->prepare("SELECT a.licencia_nombre, COUNT(a.licencia_nombre) AS licenciac FROM licencias a, licencias_proceso b WHERE a.licencia_id = b.licencia_id AND b.licencia_id > 0 AND b.legempleado_nrodocto = '$nrodocto' AND b.lproceso_activo = 1 AND a.licencia_presentismo = 1 AND b.lproceso_fecha BETWEEN '$periodoui' AND '$periodouf' GROUP BY a.licencia_nombre");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_OBJ);

			/*
			$sql = $this->cn->prepare("SELECT licencia_id FROM licencias_proceso WHERE legempleado_nrodocto = '$nrodocto' AND lproceso_fecha BETWEEN '2019-07-01' AND '2019-07-31' GROUP BY licencia_id");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_OBJ);
			*/


		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerLicenciasXEmpleado($nrodocto, $fechainicial, $fechafinal){
		try{

			$sql = $this->cn->prepare("SELECT * FROM licencias_proceso a, licencias b, legajos_empleado c WHERE a.licencia_id = b.licencia_id AND a.legempleado_nrodocto = c.legempleado_nrodocto AND a.lproceso_activo = 1 AND a.legempleado_nrodocto = '$nrodocto' AND a.lproceso_fecha BETWEEN '$fechainicial' AND '$fechafinal' ORDER BY a.lproceso_fecha");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function DatosLicenciasPrePru(){
		try{

			$periodoucerrado = Licencia::PeriodoUCerrado();
			$periodoui = $periodoucerrado->periodo_presentismo_i;
			$periodouf = $periodoucerrado->periodo_presentismo_f;


			$sql = $this->cn->prepare("SELECT * FROM licencias a, licencias_proceso b WHERE a.licencia_id = b.licencia_id AND b.licencia_id > 0  AND b.lproceso_activo = 1 AND a.licencia_presentismo = 1 AND b.lproceso_fecha BETWEEN '$periodoui' AND '$periodouf'");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function GuardarLicenciaExe($data){
		try{

			$sql = 'INSERT INTO licencias_proceso (viejo_id,licencia_codviejo,legempleado_nrodocto,licencia_id,lproceso_fecha,lproceso_proceso,lproceso_activo)
			VALUES(0, 0, ?, ?, ?, ?, 1)';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Nrodocto, PDO::PARAM_STR);
			$stm->bindValue(2, $data->Licenciaid, PDO::PARAM_STR);
			$stm->bindValue(3, $data->Fechalicencia, PDO::PARAM_STR);
			$stm->bindValue(4, $data->Licproceso, PDO::PARAM_STR);
			$stm->execute();

			//----------------obtner ultimo id Insertado -----------
			$ultimoid = $this->cn->lastInsertId();
			//---------- Datos para la auditoria ----------------
			$ippublica = $_SERVER["REMOTE_ADDR"];
			$pcnombre = gethostbyaddr($_SERVER['REMOTE_ADDR']);
			$pcinformacion = $_SERVER['HTTP_USER_AGENT'];
			$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];

			$sql ='INSERT INTO aud_licencias_proceso (AUD_lproceso_id,AUD_legempleado_nrodocto,AUD_licencia_id,AUD_lproceso_fecha,AUD_lproceso_proceso,AUD_lproceso_activo,AUD_lproceso_observacion,AUD_lproceso_ippublica,AUD_lproceso_pcnombre,AUD_lproceso_pcinformacion,AUD_accion,AUD_datetime,AUD_usuario) VALUES (?, ?, ?, ?, ?, 1, "", ?, ?, ?, "INSERT", NOW(), ?)';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $ultimoid, PDO::PARAM_STR);
			$stm->bindValue(2, $data->Nrodocto, PDO::PARAM_STR);
			$stm->bindValue(3, $data->Licenciaid, PDO::PARAM_STR);
			$stm->bindValue(4, $data->Fechalicencia, PDO::PARAM_STR);
			$stm->bindValue(5, $data->Licproceso, PDO::PARAM_STR);
			$stm->bindValue(6, $ippublica, PDO::PARAM_STR);
			$stm->bindValue(7, $pcnombre, PDO::PARAM_STR);
			$stm->bindValue(8, $pcinformacion, PDO::PARAM_STR);
			$stm->bindValue(9, $usuario, PDO::PARAM_STR);
			$stm->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function GuardarLicenciaAnualOrdinariaExe($data){
		try{

			$sql = 'INSERT INTO licencias_proceso (viejo_id,licencia_codviejo,legempleado_nrodocto,licencia_id,lproceso_fecha,lproceso_proceso,lproceso_activo)
			VALUES(0, 0, ?, ?, ?, ?, 1)';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Nrodocto, PDO::PARAM_STR);
			$stm->bindValue(2, $data->Licenciaid, PDO::PARAM_STR);
			$stm->bindValue(3, $data->Fechalicencia, PDO::PARAM_STR);
			$stm->bindValue(4, $data->Laotipo, PDO::PARAM_STR);
			$stm->execute();

			//----------------obtner ultimo id Insertado -----------
			$ultimoid = $this->cn->lastInsertId();
			//---------- Datos para la auditoria ----------------
			$ippublica = $_SERVER["REMOTE_ADDR"];
			$pcnombre = gethostbyaddr($_SERVER['REMOTE_ADDR']);
			$pcinformacion = $_SERVER['HTTP_USER_AGENT'];
			$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];

			$sql ='INSERT INTO aud_licencias_proceso (AUD_lproceso_id,AUD_legempleado_nrodocto,AUD_licencia_id,AUD_lproceso_fecha,AUD_lproceso_proceso,AUD_lproceso_activo,AUD_lproceso_observacion,AUD_lproceso_ippublica,AUD_lproceso_pcnombre,AUD_lproceso_pcinformacion,AUD_accion,AUD_datetime,AUD_usuario) VALUES (?, ?, ?, ?, ?, 1, "", ?, ?, ?, "INSERT", NOW(), ?)';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $ultimoid, PDO::PARAM_STR);
			$stm->bindValue(2, $data->Nrodocto, PDO::PARAM_STR);
			$stm->bindValue(3, $data->Licenciaid, PDO::PARAM_STR);
			$stm->bindValue(4, $data->Fechalicencia, PDO::PARAM_STR);
			$stm->bindValue(5, $data->Laotipo, PDO::PARAM_STR);
			$stm->bindValue(6, $ippublica, PDO::PARAM_STR);
			$stm->bindValue(7, $pcnombre, PDO::PARAM_STR);
			$stm->bindValue(8, $pcinformacion, PDO::PARAM_STR);
			$stm->bindValue(9, $usuario, PDO::PARAM_STR);
			$stm->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function Secretarias(){
		try{
			$sql = $this->cn->prepare("SELECT * FROM secretarias WHERE secretaria_id != 9");
			$sql->execute();

		return $sql->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function RegistrarL($data){
		try
		{

			$sql = 'INSERT INTO lugares_trabajo (trabajo_nombre,secretaria_id,trabajo_activo)
			VALUES(?, ?, ?)';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Trabajonombre, PDO::PARAM_STR);
			$stm->bindValue(2, $data->Trabajosec, PDO::PARAM_STR);
			$stm->bindValue(3, $data->Trabajoactivo, PDO::PARAM_STR);
			$stm->execute();
			//----------------obtner ultimo id Insertado -----------
			$ultimoid = $this->cn->lastInsertId();
			// ------Insert auditoria Lugar de trabajo--------
			$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];
			$sql ='INSERT INTO aud_lugares_trabajo (AUD_trabajo_id,AUD_trabajo_nombre,AUD_secretaria_id,AUD_trabajo_activo,AUD_accion,AUD_datetime,AUD_usuario) VALUES (?, ?, ?, ?, "INSERT", NOW(), ?)';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $ultimoid, PDO::PARAM_STR);
			$stm->bindValue(2, $data->Trabajonombre, PDO::PARAM_STR);
			$stm->bindValue(3, $data->Trabajosec, PDO::PARAM_STR);
			$stm->bindValue(4, $data->Trabajoactivo, PDO::PARAM_STR);
			$stm->bindValue(5, $usuario, PDO::PARAM_STR);
			$stm->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ActualizarL($data){
		try{
			$sql = 'UPDATE lugares_trabajo SET trabajo_nombre = ?, secretaria_id = ? WHERE trabajo_id = ?';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Trabajonombre, PDO::PARAM_STR);
			$stm->bindValue(2, $data->Trabajosec, PDO::PARAM_STR);
			$stm->bindValue(3, $data->Trabajoid, PDO::PARAM_STR);
			$stm->execute();
			//-----Insert de auditoria modificacion de Lugares de trabajo -----
			$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];
			$sql ='INSERT INTO aud_lugares_trabajo (AUD_trabajo_id,AUD_trabajo_nombre,AUD_secretaria_id,AUD_trabajo_activo,AUD_accion,AUD_datetime,AUD_usuario) VALUES (?, ?, ?, ?, "UPDATE", NOW(), ?)';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Trabajoid, PDO::PARAM_STR);
			$stm->bindValue(2, $data->Trabajonombre, PDO::PARAM_STR);
			$stm->bindValue(3, $data->Trabajosec, PDO::PARAM_STR);
			$stm->bindValue(4, $data->Trabajoactivo, PDO::PARAM_STR);
			$stm->bindValue(5, $usuario, PDO::PARAM_STR);
			$stm->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function DescontarLicenciaAnualOrdinariaExe($diaslao, $laoid){
		try{
			$sql = 'UPDATE licencias_anuales_ordinarias SET licanualord_dias_disponibles = ? WHERE licanualord_id = ?';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $diaslao, PDO::PARAM_STR);
			$stm->bindValue(2, $laoid, PDO::PARAM_STR);
			$stm->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function DevolverLicenciaAnualOrdinariaExe($nuevodisponible, $fracciondisponible, $nrodocto, $licanualordid, $motivo, $fracciones, $observacion){
		try{
			$sql = 'UPDATE licencias_anuales_ordinarias SET licanualord_dias_disponibles = ?, licanualord_fracciones = ?, licanualord_fracciones_disponibles = ? WHERE legempleado_nrodocto = ? AND licanualord_id = ?';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $nuevodisponible, PDO::PARAM_STR);
			$stm->bindValue(2, $fracciones, PDO::PARAM_STR);
			$stm->bindValue(3, $fracciondisponible, PDO::PARAM_STR);
			$stm->bindValue(4, $nrodocto, PDO::PARAM_STR);
			$stm->bindValue(5, $licanualordid, PDO::PARAM_STR);
			$stm->execute();
			//----------Auditoria de corte de licencias -----
			$sql = 'SELECT * FROM licencias_anuales_ordinarias WHERE licanualord_id = ? LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $licanualordid, PDO::PARAM_STR);
			$stm->execute();
			$row = $stm->fetch(PDO::FETCH_OBJ);
			//---------- Datos para la auditoria ----------------
			$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];
			$ippublica = $_SERVER["REMOTE_ADDR"];
			$pcnombre = gethostbyaddr($_SERVER['REMOTE_ADDR']);
			$pcinformacion = $_SERVER['HTTP_USER_AGENT'];

			$sql ='INSERT INTO aud_licencias_anuales_ordinarias (AUD_licanualord_id,AUD_licencia_id,AUD_legempleado_nrodocto,AUD_licanualord_dias,AUD_licanualord_dias_disponibles,AUD_licanualord_fracciones,AUD_licanualord_fracciones_disponibles,AUD_licanualord_denegada,AUD_licanualord_habilitar,AUD_licanualord_movimiento_tipo_id,AUD_licanualord_observacion,AUD_licanualord_ippublica,AUD_licanualord_pcnombre,AUD_licanualord_pcinformacion,AUD_licanualord_accion,AUD_licanualord_datetime,AUD_licanualord_usuario) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, "CUT", NOW(), ?)';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $row->licanualord_id, PDO::PARAM_STR);
			$stm->bindValue(2, $row->licencia_id, PDO::PARAM_STR);
			$stm->bindValue(3, $row->legempleado_nrodocto, PDO::PARAM_STR);
			$stm->bindValue(4, $row->licanualord_dias, PDO::PARAM_STR);
			$stm->bindValue(5, $row->licanualord_dias_disponibles, PDO::PARAM_STR);
			$stm->bindValue(6, $row->licanualord_fracciones, PDO::PARAM_STR);
			$stm->bindValue(7, $row->licanualord_fracciones_disponibles, PDO::PARAM_STR);
			$stm->bindValue(8, $row->licanualord_denegada, PDO::PARAM_STR);
			$stm->bindValue(9, $row->licanualord_habilitar, PDO::PARAM_STR);
			$stm->bindValue(10, $motivo, PDO::PARAM_STR);
			$stm->bindValue(11, $observacion, PDO::PARAM_STR);
			$stm->bindValue(12, $ippublica, PDO::PARAM_STR);
			$stm->bindValue(13, $pcnombre, PDO::PARAM_STR);
			$stm->bindValue(14, $pcinformacion, PDO::PARAM_STR);
			$stm->bindValue(15, $usuario, PDO::PARAM_STR);
			$stm->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function FraccionarLicenciaAnualOrdinariaExe($licenciaaoid, $fraccionar){
		try{
			$sql = 'UPDATE licencias_anuales_ordinarias SET licanualord_fracciones_disponibles = ? WHERE licanualord_id = ?';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $fraccionar, PDO::PARAM_STR);
			$stm->bindValue(2, $licenciaaoid, PDO::PARAM_STR);
			$stm->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function DeshabilitarLug($data){
		try{

			$sql = 'UPDATE lugares_trabajo SET trabajo_activo = ? WHERE trabajo_id = ?';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Trabajoactivo, PDO::PARAM_STR);
			$stm->bindValue(2, $data->Trabajoid, PDO::PARAM_STR);
			$stm->execute();
			//------------- auditoria -----------------
			$sql = 'SELECT * FROM lugares_trabajo WHERE trabajo_id = ?';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Trabajoid, PDO::PARAM_STR);
			$stm->execute();
			$row = $stm->fetch(PDO::FETCH_OBJ);
			//--------Insert de auditoria Deshabilitar Lugar de trabajo-----
			$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];
			$sql ='INSERT INTO aud_lugares_trabajo (AUD_trabajo_id,AUD_trabajo_nombre,AUD_secretaria_id,AUD_trabajo_activo,AUD_accion,AUD_datetime,AUD_usuario) VALUES (?, ?, ?, ?, "DISABLE", NOW(), ?)';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $row->trabajo_id, PDO::PARAM_STR);
			$stm->bindValue(2, $row->trabajo_nombre, PDO::PARAM_STR);
			$stm->bindValue(3, $row->secretaria_id, PDO::PARAM_STR);
			$stm->bindValue(4, $row->trabajo_activo, PDO::PARAM_STR);
			$stm->bindValue(5, $usuario, PDO::PARAM_STR);
			$stm->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}

	//----------- codigo viejo

	public function Listar(){
		try{

		$sql = $this->cn->prepare("SELECT * FROM legajos_empleado a, legajos_contrato b, lugares_trabajo c, secretariaS d WHERE  a.legempleado_nrodocto=b.legempleado_nrodocto AND b.trabajo_id=c.trabajo_id AND c.secretaria_id=d.secretaria_id");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_OBJ);

		} catch (Exception $e)
		{
			die($e->getMessage());
		}
	}

	public function TiposDocto()
	{
		try
		{

		//$result = array();

		$sql = $this->cn->prepare("SELECT * FROM documentos_tipo ORDER BY doctipo_abreviacion");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_OBJ);

		} catch (Exception $e)
		{
			die($e->getMessage());
		}
	}

	public function Sexos()
	{
		try
		{

		//$result = array();

		$sql = $this->cn->prepare("SELECT * FROM sexos ORDER BY sexo_nombre");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_OBJ);

		} catch (Exception $e)
		{
			die($e->getMessage());
		}
	}

	public function EstadosC()
	{
		try
		{

		//$result = array();

		$sql = $this->cn->prepare("SELECT * FROM estados_civiles");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_OBJ);

		} catch (Exception $e)
		{
			die($e->getMessage());
		}
	}

	public function Paises()
	{
		try
		{

		//$result = array();

		$sql = $this->cn->prepare("SELECT * FROM paises ORDER BY pais_nombre");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_OBJ);

		} catch (Exception $e)
		{
			die($e->getMessage());
		}
	}

	public function ObtenerProvincias($pais)
	{
		try
		{
			//$activo = 1;
			$sql = 'SELECT * FROM provincias WHERE pais_id = ? ORDER BY provincia_nombre';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $pais, PDO::PARAM_STR);
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);

		} catch (Exception $e)
		{
			die($e->getMessage());
		}
	}
	public function ObtenerDepartamentos($provincia)
	{
		try
		{
			//$activo = 1;
			$sql = 'SELECT * FROM departamentos WHERE provincia_id = ? ORDER BY departamento_nombre';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $provincia, PDO::PARAM_STR);
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);

		} catch (Exception $e)
		{
			die($e->getMessage());
		}
	}
	public function ObtenerLocalidades($departamento)
	{
		try
		{
			//$activo = 1;
			$sql = 'SELECT * FROM localidades WHERE departamento_id = ? ORDER BY localidad_nombre';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $departamento, PDO::PARAM_STR);
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);

		} catch (Exception $e)
		{
			die($e->getMessage());
		}
	}

	public function Provincias()
	{
		try
		{

		//$result = array();

		$sql = $this->cn->prepare("SELECT * FROM provincias");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_OBJ);

		} catch (Exception $e)
		{
			die($e->getMessage());
		}
	}
	public function departamentos()
	{
		try
		{

		//$result = array();

		$sql = $this->cn->prepare("SELECT * FROM departamentos");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_OBJ);

		} catch (Exception $e)
		{
			die($e->getMessage());
		}
	}
	public function Localidades()
	{
		try
		{

		//$result = array();

		$sql = $this->cn->prepare("SELECT * FROM localidades");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_OBJ);

		} catch (Exception $e)
		{
			die($e->getMessage());
		}
	}

	public function Escuelas()
	{
		try
		{

		//$result = array();

		$sql = $this->cn->prepare("SELECT * FROM escuelas ORDER BY escuela_nombre");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_OBJ);

		} catch (Exception $e)
		{
			die($e->getMessage());
		}
		//$this->cn->CloseConnection();
		//echo "conexion cerrada";
	}

	public function EscuelasNivel()
	{
		try
		{

		//$result = array();

		$sql = $this->cn->prepare("SELECT * FROM escuelas_nivel ORDER BY escnivel_nombre");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_OBJ);

		} catch (Exception $e)
		{
			die($e->getMessage());
		}
	}

	public function EscuelasEstado()
	{
		try
		{

		//$result = array();

		$sql = $this->cn->prepare("SELECT * FROM escuelas_estado ORDER BY escestado_nombre");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_OBJ);

		} catch (Exception $e)
		{
			die($e->getMessage());
		}
	}

	public function TiposLegajos()
	{
		try
		{

		//$result = array();

		$sql = $this->cn->prepare("SELECT * FROM legajos_tipo");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_OBJ);

		} catch (Exception $e)
		{
			die($e->getMessage());
		}
	}
	public function CentroCostos()
	{
		try
		{

		//$result = array();

		$sql = $this->cn->prepare("SELECT * FROM centro_costos");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_OBJ);

		} catch (Exception $e)
		{
			die($e->getMessage());
		}
	}


	public function LugaresTrabajo()
	{
		try
		{

		//$result = array();

		$sql = $this->cn->prepare("SELECT * FROM lugares_trabajo");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_OBJ);

		} catch (Exception $e)
		{
			die($e->getMessage());
		}
	}
	public function Relojes()
	{
		try
		{
			$activo = 1;
			//$sql = 'SELECT * FROM relojes a, relojes_tipo b WHERE a.relojtipo_id=b.relojtipo_id AND a.reloj_habilitar = ? ORDER BY a.reloj_nombre';
			$sql = 'SELECT a.reloj_id,a.reloj_nombre,b.relojtipo_nombre,a.reloj_ip,a.reloj_nodo, COUNT(c.reloj_id) AS empleados FROM relojes a, relojes_tipo b, legajos_reloj c WHERE a.relojtipo_id=b.relojtipo_id AND a.reloj_id=c.reloj_id AND a.reloj_habilitar = ? GROUP BY a.reloj_nombre ORDER BY a.reloj_nombre ASC';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $activo, PDO::PARAM_STR);
			$stm->execute();
		/*
		$sql = $this->cn->prepare("SELECT * FROM relojes ORDER BY reloj_nombre");
		$sql->execute();
		*/

			return $stm->fetchAll(PDO::FETCH_OBJ);

		} catch (Exception $e)
		{
			die($e->getMessage());
		}
	}
	public function Reloj($relojid)
	{
		try
		{
			$sql = 'SELECT * FROM relojes a, relojes_tipo b WHERE a.relojtipo_id=b.relojtipo_id AND a.reloj_id = ?';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $relojid, PDO::PARAM_STR);
			$stm->execute();

			return $stm->fetch(PDO::FETCH_OBJ);

		} catch (Exception $e)
		{
			die($e->getMessage());
		}
	}
	public function ObtenerReloj($nrodocto)
	{
		try
		{
			$activo = 1;
			$sql = 'SELECT * FROM legajos_reloj a, relojes b WHERE a.reloj_id=b.reloj_id AND a.legempleado_nrodocto = ? AND a.legreloj_activo = ?';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$stm->bindValue(2, $activo, PDO::PARAM_STR);
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);

		} catch (Exception $e)
		{
			die($e->getMessage());
		}
	}
	public function AutocompletarReloj($relojid)
	{
		try
		{
			$sql = 'SELECT DISTINCT reloj_id FROM relojes WHERE reloj_id = ? ORDER BY reloj_id ASC LIMIT 0,10';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $relojid, PDO::PARAM_STR);
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);

		} catch (Exception $e)
		{
			die($e->getMessage());
		}
	}
	public function AutocompletarReloj3($relojid2)
	{
		try
		{
			$sql = 'SELECT relojtipo_id FROM relojes WHERE reloj_id = ? ORDER BY relojtipo_id ASC LIMIT 0,10';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $relojid2, PDO::PARAM_STR);
			$stm->execute();

			return $stm->fetch(PDO::FETCH_OBJ);

		} catch (Exception $e)
		{
			die($e->getMessage());
		}
	}

	public function AutocompletarReloj2($relojid)
	{
		try
		{
			$sql = 'SELECT b.relojtipo_nombre,a.reloj_ip,a.reloj_nodo FROM relojes a, relojes_tipo b WHERE a.relojtipo_id=b.relojtipo_id AND a.reloj_id = ?';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $relojid, PDO::PARAM_STR);
			$stm->execute();

			//$rs = $db->prepare("SELECT proveedor_nombre FROM proveedores WHERE proveedor_codigo='$codproveedor'");

			return $stm->fetch(PDO::FETCH_OBJ);

		} catch (Exception $e)
		{
			die($e->getMessage());
		}
	}
	public function AutocompletarReloj4($relojtipoid)
	{
		try
		{
			$sql = 'SELECT relojtipo_nombre FROM relojes_tipo WHERE relojtipo_id = ? ORDER BY relojtipo_nombre';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $relojtipoid, PDO::PARAM_STR);
			$stm->execute();

			//$rs = $db->prepare("SELECT proveedor_nombre FROM proveedores WHERE proveedor_codigo='$codproveedor'");

			return $stm->fetch(PDO::FETCH_OBJ);

		} catch (Exception $e)
		{
			die($e->getMessage());
		}
	}
	public function ObtenerConyuge($nrodocto)
	{
		try
		{
			$activo = 1;
			$sql = 'SELECT * FROM legajos_conyuge WHERE legempleado_nrodocto = ? AND legconyuge_activo = ?';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$stm->bindValue(2, $activo, PDO::PARAM_STR);
			$stm->execute();

			return $stm->fetch(PDO::FETCH_OBJ);

		} catch (Exception $e)
		{
			die($e->getMessage());
		}
	}

	public function Obtener($id)
	{
		try
		{
			$sql = 'SELECT * FROM legajos_empleado a, sexos b, legajos_contrato c, legajos_reloj d WHERE a.sexo_id=b.sexo_id AND a.legempleado_nrodocto=c.legempleado_nrodocto AND a.legempleado_nrodocto=d.legempleado_nrodocto AND a.legempleado_id = ?';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $id, PDO::PARAM_STR);
			$stm->execute();

			return $stm->fetch(PDO::FETCH_OBJ);

		} catch (Exception $e)
		{
			die($e->getMessage());
		}
			//$this->cn->CloseConnection();
			//echo "conexion cerrada";
	}


	public function Eliminar($id)
	{
		try
		{
			$stm = $this->pdo
			            ->prepare("DELETE FROM alumnos WHERE id = ?");

			$stm->execute(array($id));
		} catch (Exception $e)
		{
			die($e->getMessage());
		}
	}

	public function Actualizar($data)
	{
		try
		{
			$sql = "UPDATE alumnos SET
						Nombre          = ?,
						Apellido        = ?,
                        Correo        = ?,
						Sexo            = ?,
						FechaNacimiento = ?
				    WHERE id = ?";

			$this->pdo->prepare($sql)
			     ->execute(
				    array(
                        $data->Nombre,
                        $data->Correo,
                        $data->Apellido,
                        $data->Sexo,
                        $data->FechaNacimiento,
                        $data->id
					)
				);
		} catch (Exception $e)
		{
			die($e->getMessage());
		}
	}
	public function RegistrarR($data)
	{
		try
		{

			$sql = 'INSERT INTO legajos_reloj (legempleado_nrodocto,reloj_id,legreloj_semanal,access_id,legreloj_lunes,legreloj_luneshe,legreloj_luneshs,legreloj_martes,legreloj_marteshe,legreloj_marteshs,legreloj_miercoles,legreloj_miercoleshe,legreloj_miercoleshs,legreloj_jueves,legreloj_jueveshe,legreloj_jueveshs,legreloj_viernes,legreloj_vierneshe,legreloj_vierneshs,legreloj_sabado,legreloj_sabadohe,legreloj_sabadohs,legreloj_domingo,legreloj_domingohe,legreloj_domingohs,legreloj_activo)
			VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Empnrodocto, PDO::PARAM_STR);
			$stm->bindValue(2, $data->Relojid, PDO::PARAM_STR);
			$stm->bindValue(3, $data->Semanal, PDO::PARAM_STR);
			$stm->bindValue(4, $data->Accessid, PDO::PARAM_STR);
			$stm->bindValue(5, $data->Lunes, PDO::PARAM_STR);
			$stm->bindValue(6, $data->Luneshe, PDO::PARAM_STR);
			$stm->bindValue(7, $data->Luneshs, PDO::PARAM_STR);
			$stm->bindValue(8, $data->Martes, PDO::PARAM_STR);
			$stm->bindValue(9, $data->Marteshe, PDO::PARAM_STR);
			$stm->bindValue(10, $data->Marteshs, PDO::PARAM_STR);
			$stm->bindValue(11, $data->Miercoles, PDO::PARAM_STR);
			$stm->bindValue(12, $data->Miercoleshe, PDO::PARAM_STR);
			$stm->bindValue(13, $data->Miercoleshs, PDO::PARAM_STR);
			$stm->bindValue(14, $data->Jueves, PDO::PARAM_STR);
			$stm->bindValue(15, $data->Jueveshe, PDO::PARAM_STR);
			$stm->bindValue(16, $data->Jueveshs, PDO::PARAM_STR);
			$stm->bindValue(17, $data->Viernes, PDO::PARAM_STR);
			$stm->bindValue(18, $data->Vierneshe, PDO::PARAM_STR);
			$stm->bindValue(19, $data->Vierneshs, PDO::PARAM_STR);
			$stm->bindValue(20, $data->Sabado, PDO::PARAM_STR);
			$stm->bindValue(21, $data->Sabadohe, PDO::PARAM_STR);
			$stm->bindValue(22, $data->Sabadohs, PDO::PARAM_STR);
			$stm->bindValue(23, $data->Domingo, PDO::PARAM_STR);
			$stm->bindValue(24, $data->Domingohe, PDO::PARAM_STR);
			$stm->bindValue(25, $data->Domingohs, PDO::PARAM_STR);
			$stm->bindValue(26, $data->Activo, PDO::PARAM_STR);
			$stm->execute();


		} catch (Exception $e)
		{
			die($e->getMessage());
		}
	}

	public function ActualizarR($data)
	{
		try
		{

			$sql = 'UPDATE legajos_reloj SET legreloj_lunes = ?, legreloj_luneshe = ?, legreloj_luneshs = ?, legreloj_martes = ?, legreloj_marteshe = ?, legreloj_marteshs = ?, legreloj_miercoles = ?, legreloj_miercoleshe = ?, legreloj_miercoleshs = ?, legreloj_jueves = ?, legreloj_jueveshe = ?, legreloj_jueveshs = ?, legreloj_viernes = ?, legreloj_vierneshe = ?, legreloj_vierneshs = ?, legreloj_sabado = ?, legreloj_sabadohe = ?, legreloj_sabadohs = ?, legreloj_domingo = ?, legreloj_domingohe = ?, legreloj_domingohs = ? WHERE legreloj_id = ?';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Lunes, PDO::PARAM_STR);
			$stm->bindValue(2, $data->Luneshe, PDO::PARAM_STR);
			$stm->bindValue(3, $data->Luneshs, PDO::PARAM_STR);
			$stm->bindValue(4, $data->Martes, PDO::PARAM_STR);
			$stm->bindValue(5, $data->Marteshe, PDO::PARAM_STR);
			$stm->bindValue(6, $data->Marteshs, PDO::PARAM_STR);
			$stm->bindValue(7, $data->Miercoles, PDO::PARAM_STR);
			$stm->bindValue(8, $data->Miercoleshe, PDO::PARAM_STR);
			$stm->bindValue(9, $data->Miercoleshs, PDO::PARAM_STR);
			$stm->bindValue(10, $data->Jueves, PDO::PARAM_STR);
			$stm->bindValue(11, $data->Jueveshe, PDO::PARAM_STR);
			$stm->bindValue(12, $data->Jueveshs, PDO::PARAM_STR);
			$stm->bindValue(13, $data->Viernes, PDO::PARAM_STR);
			$stm->bindValue(14, $data->Vierneshe, PDO::PARAM_STR);
			$stm->bindValue(15, $data->Vierneshs, PDO::PARAM_STR);
			$stm->bindValue(16, $data->Sabado, PDO::PARAM_STR);
			$stm->bindValue(17, $data->Sabadohe, PDO::PARAM_STR);
			$stm->bindValue(18, $data->Sabadohs, PDO::PARAM_STR);
			$stm->bindValue(19, $data->Domingo, PDO::PARAM_STR);
			$stm->bindValue(20, $data->Domingohe, PDO::PARAM_STR);
			$stm->bindValue(21, $data->Domingohs, PDO::PARAM_STR);
			$stm->bindValue(22, $data->Id, PDO::PARAM_STR);
			$stm->execute();


		} catch (Exception $e)
		{
			die($e->getMessage());
		}
	}
	//-------------- tabla Hijos --------------------

	public function RegistrarH($data)
	{
		try
		{

			$sql = 'INSERT INTO legajos_hijo (legempleado_nrodocto,leghijo_bentdoc,leghijo_benndoc,leghijo_benapellido,leghijo_bennombres,leghijo_moptdoc,leghijo_mopndoc,leghijo_mopapellido,leghijo_mopnombres,leghijo_tipodocto,leghijo_nrodocto,leghijo_nrocuil,leghijo_apellido,leghijo_nombres,sexo_id,leghijo_fecnacto,leghijo_direccion,leghijo_direcnro,leghijo_direcpiso,pais_id,provincia_id,departamento_id,localidad_id,leghijo_codpostal,leghijo_disc,leghijo_esc,escuela_id,escnivel_id,escestado_id,leghijo_activo)
			VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Empnrodocto, PDO::PARAM_STR);
			$stm->bindValue(2, $data->Hjobentdoc, PDO::PARAM_STR);
			$stm->bindValue(3, $data->Hjobenndoc, PDO::PARAM_STR);
			$stm->bindValue(4, $data->Hjobenapellido, PDO::PARAM_STR);
			$stm->bindValue(5, $data->Hjobennombres, PDO::PARAM_STR);
			$stm->bindValue(6, $data->Hjomoptdoc, PDO::PARAM_STR);
			$stm->bindValue(7, $data->Hjomopndoc, PDO::PARAM_STR);
			$stm->bindValue(8, $data->Hjomopapellido, PDO::PARAM_STR);
			$stm->bindValue(9, $data->Hjomopnombres, PDO::PARAM_STR);
			$stm->bindValue(10, $data->Hjotdoc, PDO::PARAM_STR);
			$stm->bindValue(11, $data->Hjondoc, PDO::PARAM_STR);
			$stm->bindValue(12, $data->Hjonrocuil, PDO::PARAM_STR);
			$stm->bindValue(13, $data->Hjoapellido, PDO::PARAM_STR);
			$stm->bindValue(14, $data->Hjonombres, PDO::PARAM_STR);
			$stm->bindValue(15, $data->Hjosexo, PDO::PARAM_STR);
			$stm->bindValue(16, $data->Hjofecnacto, PDO::PARAM_STR);
			$stm->bindValue(17, $data->Hjodireccion, PDO::PARAM_STR);
			$stm->bindValue(18, $data->Hjodirecnro, PDO::PARAM_STR);
			$stm->bindValue(19, $data->Hjodirecpiso, PDO::PARAM_STR);
			$stm->bindValue(20, $data->Hjopais, PDO::PARAM_STR);
			$stm->bindValue(21, $data->Hjoprovincia, PDO::PARAM_STR);
			$stm->bindValue(22, $data->Hjodepartamento, PDO::PARAM_STR);
			$stm->bindValue(23, $data->Hjolocalidad, PDO::PARAM_STR);
			$stm->bindValue(24, $data->Hjocodpostal, PDO::PARAM_STR);
			$stm->bindValue(25, $data->Hjodisc, PDO::PARAM_STR);
			$stm->bindValue(26, $data->Hjoesc, PDO::PARAM_STR);
			$stm->bindValue(27, $data->Hjoescnom, PDO::PARAM_STR);
			$stm->bindValue(28, $data->Hjoescnvl, PDO::PARAM_STR);
			$stm->bindValue(29, $data->Hjoescest, PDO::PARAM_STR);
			$stm->bindValue(30, $data->Hjoactivo, PDO::PARAM_STR);
			$stm->execute();


		} catch (Exception $e)
		{
			die($e->getMessage());
		}
	}
	public function ActualizarH($data)
	{
		try
		{

			$sql = 'UPDATE legajos_hijo SET legempleado_nrodocto = ?, leghijo_bentdoc = ?, leghijo_benndoc = ?, leghijo_benapellido = ?, leghijo_bennombres = ?, leghijo_moptdoc = ?, leghijo_mopndoc = ?, leghijo_mopapellido = ?, leghijo_mopnombres = ?, leghijo_tipodocto = ?, leghijo_nrodocto = ?, leghijo_nrocuil = ?, leghijo_apellido = ?, leghijo_nombres = ?, sexo_id = ?, leghijo_fecnacto = ?, leghijo_direccion = ?, leghijo_direcnro = ?, leghijo_direcpiso = ?, pais_id = ?, provincia_id = ?, departamento_id = ?, localidad_id = ?, leghijo_codpostal = ?, leghijo_disc = ?, leghijo_esc = ?, escuela_id = ?, escnivel_id = ?, escestado_id = ?, leghijo_activo = ? WHERE leghijo_id = ?';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Empnrodocto, PDO::PARAM_STR);
			$stm->bindValue(2, $data->Hjobentdoc, PDO::PARAM_STR);
			$stm->bindValue(3, $data->Hjobenndoc, PDO::PARAM_STR);
			$stm->bindValue(4, $data->Hjobenapellido, PDO::PARAM_STR);
			$stm->bindValue(5, $data->Hjobennombres, PDO::PARAM_STR);
			$stm->bindValue(6, $data->Hjomoptdoc, PDO::PARAM_STR);
			$stm->bindValue(7, $data->Hjomopndoc, PDO::PARAM_STR);
			$stm->bindValue(8, $data->Hjomopapellido, PDO::PARAM_STR);
			$stm->bindValue(9, $data->Hjomopnombres, PDO::PARAM_STR);
			$stm->bindValue(10, $data->Hjotdoc, PDO::PARAM_STR);
			$stm->bindValue(11, $data->Hjondoc, PDO::PARAM_STR);
			$stm->bindValue(12, $data->Hjonrocuil, PDO::PARAM_STR);
			$stm->bindValue(13, $data->Hjoapellido, PDO::PARAM_STR);
			$stm->bindValue(14, $data->Hjonombres, PDO::PARAM_STR);
			$stm->bindValue(15, $data->Hjosexo, PDO::PARAM_STR);
			$stm->bindValue(16, $data->Hjofecnacto, PDO::PARAM_STR);
			$stm->bindValue(17, $data->Hjodireccion, PDO::PARAM_STR);
			$stm->bindValue(18, $data->Hjodirecnro, PDO::PARAM_STR);
			$stm->bindValue(19, $data->Hjodirecpiso, PDO::PARAM_STR);
			$stm->bindValue(20, $data->Hjopais, PDO::PARAM_STR);
			$stm->bindValue(21, $data->Hjoprovincia, PDO::PARAM_STR);
			$stm->bindValue(22, $data->Hjodepartamento, PDO::PARAM_STR);
			$stm->bindValue(23, $data->Hjolocalidad, PDO::PARAM_STR);
			$stm->bindValue(24, $data->Hjocodpostal, PDO::PARAM_STR);
			$stm->bindValue(25, $data->Hjodisc, PDO::PARAM_STR);
			$stm->bindValue(26, $data->Hjoesc, PDO::PARAM_STR);
			$stm->bindValue(27, $data->Hjoescnom, PDO::PARAM_STR);
			$stm->bindValue(28, $data->Hjoescnvl, PDO::PARAM_STR);
			$stm->bindValue(29, $data->Hjoescest, PDO::PARAM_STR);
			$stm->bindValue(30, $data->Hjoactivo, PDO::PARAM_STR);
			$stm->bindValue(31, $data->Id, PDO::PARAM_STR);
			$stm->execute();


		} catch (Exception $e)
		{
			die($e->getMessage());
		}
	}
	public function DeshabilitarHjo($data)
	{
		try
		{

			$sql = 'UPDATE legajos_hijo SET 	leghijo_activo = ? WHERE leghijo_id = ?';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Activo, PDO::PARAM_STR);
			$stm->bindValue(2, $data->Hijoid, PDO::PARAM_STR);

			$stm->execute();


		} catch (Exception $e)
		{
			die($e->getMessage());
		}
	}
	public function ObtenerHijos($nrodocto)
	{
		try
		{
			$activo = 1;
			$sql = 'SELECT a.leghijo_id,b.legempleado_nrodocto,a.leghijo_bentdoc,a.leghijo_benndoc,a.leghijo_benapellido,a.leghijo_bennombres,a.leghijo_moptdoc,a.leghijo_mopndoc,a.leghijo_mopapellido,a.leghijo_mopnombres,a.leghijo_tipodocto,a.leghijo_nrodocto,a.leghijo_nrocuil,a.leghijo_apellido,a.leghijo_nombres,a.sexo_id,a.leghijo_fecnacto,a.leghijo_direccion,a.leghijo_direcnro,a.leghijo_direcpiso,a.pais_id,a.provincia_id,a.departamento_id,a.localidad_id,a.leghijo_codpostal,a.leghijo_disc,a.leghijo_esc,c.escuela_id,c.escuela_nombre,d.escnivel_id,d.escnivel_nombre,e.escestado_id,e.escestado_nombre,a.leghijo_activo FROM legajos_hijo a, legajos_empleado b, escuelas c, escuelas_nivel d, escuelas_estado e WHERE a.legempleado_nrodocto=b.legempleado_nrodocto AND a.escuela_id=c.escuela_id AND a.escnivel_id=d.escnivel_id AND a.escestado_id=e.escestado_id AND a.legempleado_nrodocto = ? AND a.leghijo_activo = ?';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$stm->bindValue(2, $activo, PDO::PARAM_STR);
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);

		} catch (Exception $e)
		{
			die($e->getMessage());
		}
	}
	public function RegistrarC($data)
	{
		try
		{

			$sql = 'INSERT INTO legajos_conyuge (legempleado_nrodocto,legconyuge_tipodocto,legconyuge_nrodocto,legconyuge_nrocuil,legconyuge_apellido,legconyuge_nombres,sexo_id,legconyuge_fecnacto,legconyuge_direccion,legconyuge_direcnro,legconyuge_direcpiso,legconyuge_celular,legconyuge_telefono,legconyuge_email,pais_id,provincia_id,departamento_id,localidad_id,legconyuge_codpostal,legconyuge_activo)
			VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Empnrodocto, PDO::PARAM_STR);
			$stm->bindValue(2, $data->Cyetdoc, PDO::PARAM_STR);
			$stm->bindValue(3, $data->Cyendoc, PDO::PARAM_STR);
			$stm->bindValue(4, $data->Cyecuil, PDO::PARAM_STR);
			$stm->bindValue(5, $data->Cyeapellido, PDO::PARAM_STR);
			$stm->bindValue(6, $data->Cyenombres, PDO::PARAM_STR);
			$stm->bindValue(7, $data->Cyesexo, PDO::PARAM_STR);
			$stm->bindValue(8, $data->Cyefecnacto, PDO::PARAM_STR);
			$stm->bindValue(9, $data->Cyedireccion, PDO::PARAM_STR);
			$stm->bindValue(10, $data->Cyedirecnro, PDO::PARAM_STR);
			$stm->bindValue(11, $data->Cyedirecpiso, PDO::PARAM_STR);
			$stm->bindValue(12, $data->Cyecelular, PDO::PARAM_STR);
			$stm->bindValue(13, $data->Cyetelefono, PDO::PARAM_STR);
			$stm->bindValue(14, $data->Cyeemail, PDO::PARAM_STR);
			$stm->bindValue(15, $data->Cyepais, PDO::PARAM_STR);
			$stm->bindValue(16, $data->Cyeprovincia, PDO::PARAM_STR);
			$stm->bindValue(17, $data->Cyedepartamento, PDO::PARAM_STR);
			$stm->bindValue(18, $data->Cyelocalidad, PDO::PARAM_STR);
			$stm->bindValue(19, $data->Cyecpostal, PDO::PARAM_STR);
			$stm->bindValue(20, $data->Cyeactivo, PDO::PARAM_STR);
			$stm->execute();


		} catch (Exception $e)
		{
			die($e->getMessage());
		}
	}
	//--------------- tabla estudios -----------------------

	public function RegistrarEs($data)
	{
		try
		{

			$sql = 'INSERT INTO legajos_estudio (legempleado_nrodocto,escuela_id,escnivel_id,escestado_id,legestudio_titulo,legestudio_archivo,legestudio_activo)
			VALUES(?, ?, ?, ?, ?, ?, ?)';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Empnrodocto, PDO::PARAM_STR);
			$stm->bindValue(2, $data->Estudioesc, PDO::PARAM_STR);
			$stm->bindValue(3, $data->Estudionvl, PDO::PARAM_STR);
			$stm->bindValue(4, $data->Estudioestado, PDO::PARAM_STR);
			$stm->bindValue(5, $data->Estudiotitulo, PDO::PARAM_STR);
			$stm->bindValue(6, $data->Estudioarchivo, PDO::PARAM_STR);
			$stm->bindValue(7, $data->Estudioactivo, PDO::PARAM_STR);

			$stm->execute();


		} catch (Exception $e)
		{
			die($e->getMessage());
		}
	}

	public function ActualizarEs($data)
	{
		try
		{

			$sql = 'UPDATE legajos_estudio SET escuela_id = ?, escnivel_id = ?, escestado_id = ?, legestudio_titulo = ? WHERE legestudio_id = ?';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Estudioesc, PDO::PARAM_STR);
			$stm->bindValue(2, $data->Estudionvl, PDO::PARAM_STR);
			$stm->bindValue(3, $data->Estudioestado, PDO::PARAM_STR);
			$stm->bindValue(4, $data->Estudiotitulo, PDO::PARAM_STR);
			$stm->bindValue(5, $data->Id, PDO::PARAM_STR);

			$stm->execute();


		} catch (Exception $e)
		{
			die($e->getMessage());
		}
	}
	public function DeshabilitarEst($data)
	{
		try
		{

			$sql = 'UPDATE legajos_estudio SET 	legestudio_activo = ? WHERE legestudio_id = ?';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Activo, PDO::PARAM_STR);
			$stm->bindValue(2, $data->Estudioid, PDO::PARAM_STR);

			$stm->execute();


		} catch (Exception $e)
		{
			die($e->getMessage());
		}
	}
	public function ObtenerEstudios($nrodocto)
	{
		try
		{
			$activo = 1;
			$sql = 'SELECT * FROM legajos_estudio a,escuelas b, escuelas_nivel c, escuelas_estado d WHERE a.escuela_id=b.escuela_id AND a.escnivel_id=c.escnivel_id AND a.escestado_id=d.escestado_id AND a.legempleado_nrodocto = ? AND a.legestudio_activo = ?';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$stm->bindValue(2, $activo, PDO::PARAM_STR);
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);

		} catch (Exception $e)
		{
			die($e->getMessage());
		}
	}
	public function RegistrarE($data)
	{
		try
		{
			$activo = 1;
			$trabajoid = 69;
			$secretariaid = 9;
			//--------- Insert de empleados -------------
			$sql = 'INSERT INTO legajos_empleado (legempleado_numero,legempleado_tipodocto,legempleado_nrodocto,legempleado_nrocuil,legempleado_apellido,legempleado_nombres,sexo_id,legempleado_fecnacto,estcivil_id,legempleado_direccion,legempleado_direcnro,legempleado_direcpiso,legempleado_celular,legempleado_telefono,legempleado_email,pais_id,provincia_id,departamento_id,localidad_id,legempleado_codpostal,legempleado_fecingreso,legempleado_activo)
			VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Empnroleg, PDO::PARAM_STR);
			$stm->bindValue(2, $data->Emptdoc, PDO::PARAM_STR);
			$stm->bindValue(3, $data->Empnrodocumento, PDO::PARAM_STR);
			$stm->bindValue(4, $data->Empcuil, PDO::PARAM_STR);
			$stm->bindValue(5, $data->Empapellido, PDO::PARAM_STR);
			$stm->bindValue(6, $data->Empnombres, PDO::PARAM_STR);
			$stm->bindValue(7, $data->Empsexotres, PDO::PARAM_STR);
			$stm->bindValue(8, $data->Empfecnacto, PDO::PARAM_STR);
			$stm->bindValue(9, $data->Empestcivil, PDO::PARAM_STR);
			$stm->bindValue(10, $data->Empdireccion, PDO::PARAM_STR);
			$stm->bindValue(11, $data->Empdirecnro, PDO::PARAM_STR);
			$stm->bindValue(12, $data->Empdirecpiso, PDO::PARAM_STR);
			$stm->bindValue(13, $data->Empcelular, PDO::PARAM_STR);
			$stm->bindValue(14, $data->Emptelefono, PDO::PARAM_STR);
			$stm->bindValue(15, $data->Empemail, PDO::PARAM_STR);
			$stm->bindValue(16, $data->Emppais, PDO::PARAM_STR);
			$stm->bindValue(17, $data->Empprovincia, PDO::PARAM_STR);
			$stm->bindValue(18, $data->Empdepartamento, PDO::PARAM_STR);
			$stm->bindValue(19, $data->Emplocalidad, PDO::PARAM_STR);
			$stm->bindValue(20, $data->Empcpostal, PDO::PARAM_STR);
			$stm->bindValue(21, $data->Empfecing, PDO::PARAM_STR);
			$stm->bindValue(22, $activo, PDO::PARAM_STR);
			$stm->execute();

			//------------ Insert de contrato --------------
			$sql = 'INSERT INTO legajos_contrato (legempleado_nrodocto,secretaria_id,trabajo_id) VALUES (?, ?, ?)';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Empnrodocumento, PDO::PARAM_STR);
			$stm->bindValue(2, $secretariaid, PDO::PARAM_STR);
			$stm->bindValue(3, $trabajoid, PDO::PARAM_STR);
			$stm->execute();

			//------------ Insert de Reloj -------------------
			$sql = 'INSERT INTO legajos_reloj (legempleado_nrodocto) VALUES (?)';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Empnrodocumento, PDO::PARAM_STR);
			$stm->execute();


		} catch (Exception $e)
		{
			die($e->getMessage());
		}
	}
	public function ActualizarE($data)
	{
		try
		{

			$sql = 'UPDATE legajos_empleado SET legempleado_numero = ?, legempleado_nrocuil = ?, legempleado_apellido = ?, legempleado_nombres = ?, sexo_id = ?, legempleado_fecnacto = ?, estcivil_id = ?, legempleado_direccion = ?, legempleado_direcnro = ?, legempleado_direcpiso = ?, legempleado_celular = ?, legempleado_telefono = ?, legempleado_email = ?, pais_id = ?, provincia_id = ?, departamento_id = ?, localidad_id = ?, legempleado_codpostal = ?, legempleado_activo = ? WHERE legempleado_id = ?';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Empnroleg, PDO::PARAM_STR);
			$stm->bindValue(2, $data->Empcuil, PDO::PARAM_STR);
			$stm->bindValue(3, $data->Empapellido, PDO::PARAM_STR);
			$stm->bindValue(4, $data->Empnombres, PDO::PARAM_STR);
			$stm->bindValue(5, $data->Empsexotres, PDO::PARAM_STR);
			$stm->bindValue(6, $data->Empfecnacto, PDO::PARAM_STR);
			$stm->bindValue(7, $data->Empestcivil, PDO::PARAM_STR);
			$stm->bindValue(8, $data->Empdireccion, PDO::PARAM_STR);
			$stm->bindValue(9, $data->Empdirecnro, PDO::PARAM_STR);
			$stm->bindValue(10, $data->Empdirecpiso, PDO::PARAM_STR);
			$stm->bindValue(11, $data->Empcelular, PDO::PARAM_STR);
			$stm->bindValue(12, $data->Emptelefono, PDO::PARAM_STR);
			$stm->bindValue(13, $data->Empemail, PDO::PARAM_STR);
			$stm->bindValue(14, $data->Emppais, PDO::PARAM_STR);
			$stm->bindValue(15, $data->Empprovincia, PDO::PARAM_STR);
			$stm->bindValue(16, $data->Empdepartamento, PDO::PARAM_STR);
			$stm->bindValue(17, $data->Emplocalidad, PDO::PARAM_STR);
			$stm->bindValue(18, $data->Empcpostal, PDO::PARAM_STR);
			$stm->bindValue(19, $data->Empactivo, PDO::PARAM_STR);
			$stm->bindValue(20, $data->Id, PDO::PARAM_STR);
			$stm->execute();

			$sql = 'UPDATE legajos_contrato SET legtipo_id = ?, legcontrato_fecinicio = ?, legcontrato_fecfin = ?, cencosto_codigo = ?, secretaria_id = ?, legcontrato_categoria = ?, trabajo_id = ?, legcontrato_tarea = ?, legcontrato_sbasico = ?, legcontrato_activo = ? WHERE legcontrato_id = ?';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Empcomtipo, PDO::PARAM_STR);
			$stm->bindValue(2, $data->Empfecinicio, PDO::PARAM_STR);
			$stm->bindValue(3, $data->Empfecfin, PDO::PARAM_STR);
			$stm->bindValue(4, $data->Empinputacion, PDO::PARAM_STR);
			$stm->bindValue(5, $data->Empsecretaria, PDO::PARAM_STR);
			$stm->bindValue(6, $data->Empcategoria, PDO::PARAM_STR);
			$stm->bindValue(7, $data->Empltrabajo, PDO::PARAM_STR);
			$stm->bindValue(8, $data->Emptarea, PDO::PARAM_STR);
			$stm->bindValue(9, $data->Empbasico, PDO::PARAM_STR);
			$stm->bindValue(10, $data->Empactivo, PDO::PARAM_STR);
			$stm->bindValue(11, $data->Empcontratoid, PDO::PARAM_STR);
			$stm->execute();

			$sql = 'UPDATE legajos_reloj SET reloj_id = ?, access_id = ?, legreloj_semanal = ? WHERE legempleado_nrodocto = ? AND legreloj_activo = ?';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Empreloj, PDO::PARAM_STR);
			$stm->bindValue(2, $data->Emprelojid, PDO::PARAM_STR);
			$stm->bindValue(3, $data->Emprelsemanal, PDO::PARAM_STR);
			$stm->bindValue(4, $data->Empnrodocumento, PDO::PARAM_STR);
			$stm->bindValue(5, $data->Empactivo, PDO::PARAM_STR);
			$stm->execute();

			$sql = 'UPDATE legajos_conyuge SET legconyuge_tipodocto = ?, legconyuge_nrodocto = ?, legconyuge_nrocuil = ?, legconyuge_apellido = ?, legconyuge_nombres = ?, sexo_id = ?, legconyuge_fecnacto = ?, legconyuge_direccion = ?, legconyuge_direcnro = ?, legconyuge_direcpiso = ?, legconyuge_celular = ?, legconyuge_telefono = ?, legconyuge_email = ?, pais_id = ?, provincia_id = ?, departamento_id = ?, localidad_id = ?, legconyuge_codpostal = ? WHERE legempleado_nrodocto = ? AND legconyuge_activo = ?';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Empcyetdoc, PDO::PARAM_STR);
			$stm->bindValue(2, $data->Empcyendoc, PDO::PARAM_STR);
			$stm->bindValue(3, $data->Empcyenrocuil, PDO::PARAM_STR);
			$stm->bindValue(4, $data->Empcyeapellido, PDO::PARAM_STR);
			$stm->bindValue(5, $data->Empcyenombres, PDO::PARAM_STR);
			$stm->bindValue(6, $data->Empcyesexo, PDO::PARAM_STR);
			$stm->bindValue(7, $data->Empcyefecnacto, PDO::PARAM_STR);
			$stm->bindValue(8, $data->Empcyedireccion, PDO::PARAM_STR);
			$stm->bindValue(9, $data->Empcyedirecnro, PDO::PARAM_STR);
			$stm->bindValue(10, $data->Empcyedirecpiso, PDO::PARAM_STR);
			$stm->bindValue(11, $data->Empcyecelular, PDO::PARAM_STR);
			$stm->bindValue(12, $data->Empcyetelefono, PDO::PARAM_STR);
			$stm->bindValue(13, $data->Empcyeemail, PDO::PARAM_STR);
			$stm->bindValue(14, $data->Empcyepais, PDO::PARAM_STR);
			$stm->bindValue(15, $data->Empcyeprovincia, PDO::PARAM_STR);
			$stm->bindValue(16, $data->Empcyedepartamento, PDO::PARAM_STR);
			$stm->bindValue(17, $data->Empcyelocalidad, PDO::PARAM_STR);
			$stm->bindValue(18, $data->Empcyecodpostal, PDO::PARAM_STR);
			$stm->bindValue(19, $data->Empnrodocumento, PDO::PARAM_STR);
			$stm->bindValue(20, $data->Empactivo, PDO::PARAM_STR);
			$stm->execute();

		} catch (Exception $e)
		{
			die($e->getMessage());
		}
	}
	public function DeshabilitarRel($data)
	{
		try
		{

			$sql = 'UPDATE legajos_reloj SET 	legreloj_activo = ? WHERE legreloj_id = ?';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Activo, PDO::PARAM_STR);
			$stm->bindValue(2, $data->RelId, PDO::PARAM_STR);

			$stm->execute();


		} catch (Exception $e)
		{
			die($e->getMessage());
		}
	}
	public function Registrar(Alumno $data)
	{
		try
		{
		$sql = "INSERT INTO alumnos (Nombre,Correo,Apellido,Sexo,FechaNacimiento,FechaRegistro)
		        VALUES (?, ?, ?, ?, ?, ?)";

		$this->pdo->prepare($sql)
		     ->execute(
				array(
                    $data->Nombre,
                    $data->Correo,
                    $data->Apellido,
                    $data->Sexo,
                    $data->FechaNacimiento,
                    date('Y-m-d')
                )
			);
		} catch (Exception $e)
		{
			die($e->getMessage());
		}
	}
	public function ObtenerEmpleadoDatos($search){
		try{

			$sql = "SELECT * FROM legajos_empleado WHERE legempleado_activo = 1 AND (legempleado_apellido LIKE '%$search%' OR legempleado_nombres LIKE '%$search%') LIMIT 0,10";
			$stm = $this->cn->prepare($sql);
			$stm->execute();
			return $stm->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerEmpleadoDatosRes($nrodocto){
		try{
			//--- Obter tipo de Legajo ----
			$sql = 'SELECT legtipo_id FROM legajos_empleado WHERE legempleado_nrodocto = ? LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$stm->execute();
			$datoslegajo = $stm->fetch(PDO::FETCH_OBJ);
			$legajoid = $datoslegajo->legtipo_id;
			//---- Obtener Datos del Empleado ---
			if($legajoid == 1){
				//---Contrado ---
				$sql = 'SELECT a.legempleado_apellido,a.legempleado_nombres,a.legempleado_fecingreso FROM legajos_empleado a, legajos_contrato b WHERE a.legempleado_nrodocto = b.legempleado_nrodocto AND a.legempleado_nrodocto = ? LIMIT 1';
				$stm = $this->cn->prepare($sql);
				$stm->bindValue(1, $nrodocto, PDO::PARAM_STR);
				$stm->execute();
			}elseif($legajoid == 2){
				//---Jornalero ---
				$sql = 'SELECT a.legempleado_apellido,a.legempleado_nombres,a.legempleado_fecingreso FROM legajos_empleado a, legajos_jornalero b WHERE a.legempleado_nrodocto = b.legempleado_nrodocto AND  a.legempleado_nrodocto = ? LIMIT 1';
				$stm = $this->cn->prepare($sql);
				$stm->bindValue(1, $nrodocto, PDO::PARAM_STR);
				$stm->execute();
			}elseif($legajoid == 3){
				//---Planta Permanente --
				$sql = 'SELECT a.legempleado_apellido,a.legempleado_nombres,a.legempleado_fecingreso FROM legajos_empleado a, legajos_ppermanente b WHERE a.legempleado_nrodocto = b.legempleado_nrodocto AND  a.legempleado_nrodocto = ? LIMIT 1';
				$stm = $this->cn->prepare($sql);
				$stm->bindValue(1, $nrodocto, PDO::PARAM_STR);
				$stm->execute();
			}elseif($legajoid == 4){
				//---Proveedor --
			}elseif($legajoid == 5){
				//--- Funcionarios --
			}elseif($legajoid == 6){
				//--- Concejo deliberante --
			}else{
				//--- Defaul error --
			}
			return $stm->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ListarLicenciasEpecificas(){
		try{

			/*$sql = $this->cn->prepare("SELECT DISTINCT a.legempleado_nrodocto
																						FROM licencias_proceso a,
																								 licencias b
																					 WHERE a.licencia_id = b.licencia_id
																					 	 AND a.licencia_id > 60
																						 AND a.lproceso_activo = 1
																						 AND a.lproceso_fecha > '2020-04-29'
																			 ORDER BY a.lproceso_fecha");*/
		 $sql = $this->cn->prepare("SELECT DISTINCT a.legempleado_nrodocto
																						FROM licencias_proceso a,
																								 licencias b
																					 WHERE a.licencia_id = b.licencia_id
																					 	 AND b.licencia_vac = 1
																						 AND a.lproceso_activo = 1
																						 AND a.lproceso_fecha > '2020-03-16'
																			 ORDER BY a.lproceso_fecha");
			$sql->execute();

			return $sql->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function DatosLicenciasPreEspecifica($nrodocto){
		try{

			/*$sql = $this->cn->prepare("SELECT a.licencia_nombre,
																				COUNT(a.licencia_nombre) AS licenciac
																	 FROM licencias a,
																	 			licencias_proceso b
																	WHERE a.licencia_id = b.licencia_id
																	  AND b.licencia_id > 60
																		AND b.legempleado_nrodocto = '$nrodocto'
																		AND b.lproceso_activo = 1
																		AND b.lproceso_fecha > '2020-04-29'
															 GROUP BY a.licencia_nombre");*/
		 $sql = $this->cn->prepare("SELECT a.licencia_nombre,
																				COUNT(a.licencia_nombre) AS licenciac
																	 FROM licencias a,
																	 			licencias_proceso b
																	WHERE a.licencia_id = b.licencia_id
																		AND (b.licencia_id = 61
																		 OR b.licencia_id = 64
																		 OR b.licencia_id = 65)
																		AND b.legempleado_nrodocto = '$nrodocto'
																		AND b.lproceso_activo = 1
																		AND b.lproceso_fecha
																BETWEEN '2020-03-17'
																		AND '2020-07-31'
															 GROUP BY a.licencia_nombre");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function situacionuno($nrodocto){
		try{

			$sql = $this->cn->prepare("SELECT b.secretaria_nombre
																	 FROM legajos_contrato a,
																	 			secretarias b
																	WHERE a.secretaria_id = b.secretaria_id
																		AND a.legempleado_nrodocto = '$nrodocto'
																		AND a.legcontrato_activo = 1
																  LIMIT 1");
			$sql->execute();
			return $sql->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function situaciondos($nrodocto){
		try{

			$sql = $this->cn->prepare("SELECT b.secretaria_nombre
																	 FROM legajos_jornalero a,
																	 			secretarias b
																	WHERE a.secretaria_id = b.secretaria_id
																		AND a.legempleado_nrodocto = '$nrodocto'
																		AND a.legjornalero_activo = 1
																  LIMIT 1");
			$sql->execute();
			return $sql->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function situaciontres($nrodocto){
		try{

			$sql = $this->cn->prepare("SELECT b.secretaria_nombre
																	 FROM legajos_ppermanente a,
																	 			secretarias b
																	WHERE a.secretaria_id = b.secretaria_id
																		AND a.legempleado_nrodocto = '$nrodocto'
																		AND a.legppermanente_activo = 1
																  LIMIT 1");
			$sql->execute();
			return $sql->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function EmpleadoListar2020(){
		try{
			/*$activo = "2020-01-01";
			$sql = 'SELECT *
								FROM legajos_empleado
							 WHERE legempleado_fecingreso > ? ';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $activo, PDO::PARAM_STR);
			$stm->execute();*/
			$fecha1 = '2020-03-17';
			$fecha2 = '2020-07-31';

			$sql = 'SELECT *
								FROM licencias_proceso a
		 			INNER JOIN legajos_empleado b
						 			ON a.legempleado_nrodocto = b.legempleado_nrodocto
								 AND (a.licencia_id = 61
								 	OR a.licencia_id = 64
									OR a.licencia_id = 65)
								 AND a.lproceso_fecha
						 BETWEEN ?
						 		 AND ?
								 AND a.lproceso_activo = 1
						GROUP BY a.legempleado_nrodocto';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $fecha1, PDO::PARAM_STR);
			$stm->bindValue(2, $fecha2, PDO::PARAM_STR);
			$stm->execute();
			return $stm->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	/*public function ContratadoListar2020($nrodocto){
		try{

			$sql = $this->cn->prepare("SELECT legcontrato_fecinicio,
																				legcontrato_fecfin,
																				legcontrato_sbasico
																	 FROM legajos_contrato
																	WHERE legempleado_nrodocto =  '$nrodocto'
																	  AND legcontrato_activo = 1
															 ORDER BY legcontrato_id DESC
															 		LIMIT 1");
			$sql->execute();
			return $sql->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}*/
	/*public function ProveedorListar2020($nrodocto){
		try{

			$sql = $this->cn->prepare("SELECT legproveedor_fecinicio,
																				legproveedor_fecfin,
																				legproveedor_sbasico
																	 FROM legajos_proveedor
																	WHERE legempleado_nrodocto =  '$nrodocto'
																	  AND legproveedor_activo = 1
															 ORDER BY legproveedor_id DESC
															 		LIMIT 1");
			$sql->execute();
			return $sql->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}*/
}
