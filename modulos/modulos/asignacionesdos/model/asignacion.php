<?php
class Asignacion{

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
	public function ListarOtrosBeniciarios(){
		try{
			$fechaactual = date("Y-m-d");
			//--- Pre-Natal ---
			$sql = $this->cn->prepare("SELECT DISTINCT a.legempleado_nrodocto AS empleado,a.legprenatal_benndoc AS beneficiario FROM legajos_prenatal a, legajos_empleado b WHERE a.legempleado_nrodocto = b.legempleado_nrodocto AND a.legempleado_nrodocto != a.legprenatal_benndoc AND a.legprenatal_activo = 1 AND b.legempleado_activo = 1");
			$sql->execute();
			$prenatal = $sql->fetchAll(PDO::FETCH_OBJ);
			//--- Hijo Menor ---
			$fechaactualmenoscinco = date("Y-m-d",strtotime($fechaactual."- 5 year"));//resto 5 años
			$sql = $this->cn->prepare("SELECT DISTINCT a.legempleado_nrodocto AS empleado, a.leghijo_benndoc AS beneficiario FROM legajos_hijo a, legajos_empleado b WHERE a.legempleado_nrodocto = b.legempleado_nrodocto AND a.legempleado_nrodocto != a.leghijo_benndoc AND a.leghijo_disc != 1 AND a.leghijo_esc != 1 AND a.leghijo_estado != 2 AND a.leghijo_activo = 1 AND b.legempleado_activo = 1 AND a.leghijo_fecnacto BETWEEN '$fechaactualmenoscinco' AND '$fechaactual'");
			$sql->execute();
			$hijomenor = $sql->fetchAll(PDO::FETCH_OBJ);
			//--- Hijo Escolar ---
			$fechaactualmenosveintitres = date("Y-m-d",strtotime($fechaactual."- 23 year"));//resto 23 años
			$sql = $this->cn->prepare("SELECT DISTINCT a.legempleado_nrodocto AS empleado, a.leghijo_benndoc AS beneficiario FROM legajos_hijo a, legajos_empleado b WHERE a.legempleado_nrodocto = b.legempleado_nrodocto AND a.legempleado_nrodocto != a.leghijo_benndoc AND a.leghijo_disc != 1 AND a.leghijo_esc = 1 AND a.leghijo_estado != 2 AND a.leghijo_activo = 1 AND b.legempleado_activo = 1 AND a.leghijo_fecnacto BETWEEN '$fechaactualmenosveintitres' AND '$fechaactual'");
			$sql->execute();
			$hijoescolar = $sql->fetchAll(PDO::FETCH_OBJ);
			//--- Hijo con discapacidad // escolar con discapacidad ---
			$sql = $this->cn->prepare("SELECT DISTINCT a.legempleado_nrodocto AS empleado, a.leghijo_benndoc AS beneficiario FROM legajos_hijo a, legajos_empleado b WHERE a.legempleado_nrodocto = b.legempleado_nrodocto AND a.legempleado_nrodocto != a.leghijo_benndoc AND a.leghijo_disc = 1 AND a.leghijo_estado != 2 AND a.leghijo_activo = 1 AND b.legempleado_activo = 1");
			$sql->execute();
			$hijodisc = $sql->fetchAll(PDO::FETCH_OBJ);
			//--- unir todos los arrays---
			$otrosbeneficiarios = array_merge($prenatal, $hijomenor, $hijoescolar, $hijodisc);
			//--- eliminar contenido duplicado ---
			$otrosbeneficiarios = array_map('json_encode', $otrosbeneficiarios);
			$otrosbeneficiarios = array_unique($otrosbeneficiarios);
			$otrosbeneficiarios = array_map('json_decode', $otrosbeneficiarios);
			//--- Retornar contenido ---
			return $otrosbeneficiarios;

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ListarBeniciariosTitulares(){
		try{
			$fechaactual = date("Y-m-d");
			//--- Pre-Natal ---
			$sql = $this->cn->prepare("SELECT DISTINCT a.legempleado_nrodocto AS empleado,a.legprenatal_benndoc AS beneficiario FROM legajos_prenatal a, legajos_empleado b WHERE a.legempleado_nrodocto = b.legempleado_nrodocto AND a.legempleado_nrodocto = a.legprenatal_benndoc AND a.legprenatal_activo = 1 AND b.legempleado_activo = 1");
			$sql->execute();
			$prenatal = $sql->fetchAll(PDO::FETCH_OBJ);
			//--- Hijo Menor ---
			$fechafinaluno = date("Y-m-d",strtotime($fechaactual."- 5 year"));//resto 5 años
			$fechafinal = date("Y-m-d",strtotime($fechafinaluno."- 5 month"));
			$fechaactualmenoscinco = date("Y-m-d",strtotime($fechafinal."- 5 year"));//resto 5 años
			$sql = $this->cn->prepare("SELECT DISTINCT a.legempleado_nrodocto AS empleado, a.leghijo_benndoc AS beneficiario FROM legajos_hijo a, legajos_empleado b WHERE a.legempleado_nrodocto = b.legempleado_nrodocto AND a.legempleado_nrodocto = a.leghijo_benndoc AND a.leghijo_disc != 1 AND a.leghijo_esc != 1 AND a.leghijo_activo = 1 AND b.legempleado_activo = 1 AND a.leghijo_fecnacto BETWEEN '$fechaactualmenoscinco' AND '$fechaactual'");
			$sql->execute();
			$hijomenor = $sql->fetchAll(PDO::FETCH_OBJ);
			//--- Hijo Escolar ---
			$fechaactualmenosveintitres = date("Y-m-d",strtotime($fechaactual."- 23 year"));//resto 23 años
			$sql = $this->cn->prepare("SELECT DISTINCT a.legempleado_nrodocto AS empleado, a.leghijo_benndoc AS beneficiario FROM legajos_hijo a, legajos_empleado b WHERE a.legempleado_nrodocto = b.legempleado_nrodocto AND a.legempleado_nrodocto = a.leghijo_benndoc AND a.leghijo_disc != 1 AND a.leghijo_esc = 1 AND a.leghijo_activo = 1 AND b.legempleado_activo = 1 AND a.leghijo_fecnacto BETWEEN '$fechaactualmenosveintitres' AND '$fechaactual'");
			$sql->execute();
			$hijoescolar = $sql->fetchAll(PDO::FETCH_OBJ);
			//--- Hijo con discapacidad // escolar con discapacidad ---
			$sql = $this->cn->prepare("SELECT DISTINCT a.legempleado_nrodocto AS empleado, a.leghijo_benndoc AS beneficiario FROM legajos_hijo a, legajos_empleado b WHERE a.legempleado_nrodocto = b.legempleado_nrodocto AND a.legempleado_nrodocto = a.leghijo_benndoc AND a.leghijo_disc = 1 AND a.leghijo_activo = 1 AND b.legempleado_activo = 1");
			$sql->execute();
			$hijodisc = $sql->fetchAll(PDO::FETCH_OBJ);
			//--- unir todos los arrays---
			$beneficiariostitulares = array_merge($prenatal, $hijomenor, $hijoescolar, $hijodisc);
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
	public function ListarOtrosBeniciariosLiquidaciones(){
		try{
			$periodo = Asignacion::ObtenerPeriodoActual();
			$periodoid = $periodo->periodo_id;
			$sql = $this->cn->prepare("SELECT DISTINCT legempleado_nrodocto AS empleado, beneficiario_nrodocto AS beneficiario, beneficiario_nrooficio AS oficio FROM asignaciones_otros WHERE asigotro_periodo = $periodoid ORDER BY legempleado_apellido, legempleado_nombres");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function OtrosBeniciariosLiquidacionesImpT(){
		try{
			$periodo = Asignacion::ObtenerPeriodoActual();
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

			//$periodo = Asignacion::ObtenerPeriodoActual();
			//$periodoid = $periodo->periodo_id;
			$sql = $this->cn->prepare("SELECT asigotro_periodo AS periodosasigot FROM asignaciones_otros GROUP BY asigotro_periodo");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function DatosEmpleado($empleadonrodocto){
		try{
			$sql = 'SELECT legempleado_apellido,legempleado_nombres,legtipo_id FROM legajos_empleado WHERE legempleado_nrodocto = ? LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $empleadonrodocto, PDO::PARAM_STR);
			$stm->execute();

			return $stm->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function DatosBeneficiario($empleadonrodocto, $beneficiarionrodocto){
		try{
			$sql = 'SELECT leghijo_benapellido AS benapellido, leghijo_bennombres AS bennombres FROM legajos_hijo WHERE legempleado_nrodocto = ? AND leghijo_benndoc = ? ORDER BY leghijo_id DESC LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $empleadonrodocto, PDO::PARAM_STR);
			$stm->bindValue(2, $beneficiarionrodocto, PDO::PARAM_STR);
			$stm->execute();
			//--- Contar registros ---
			$num = $stm->rowCount();
			if($num > 0){
				return $stm->fetch(PDO::FETCH_OBJ);
			}else{
				$sql = 'SELECT legprenatal_benapellido AS benapellido, legprenatal_bennombres AS bennombres FROM legajos_prenatal WHERE legempleado_nrodocto = ? AND legprenatal_benndoc = ? ORDER BY legprenatal_id DESC LIMIT 1';
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
	public function DatosPreNatal($empleadonrodocto, $beneficiarionrodocto){
		try{
			$sql = 'SELECT COUNT(legprenatal_id) AS prenatalc FROM legajos_prenatal WHERE legempleado_nrodocto = ? AND legprenatal_benndoc = ? AND legprenatal_activo = 1 LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $empleadonrodocto, PDO::PARAM_STR);
			$stm->bindValue(2, $beneficiarionrodocto, PDO::PARAM_STR);
			$stm->execute();

			return $stm->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function PasarPreNatalOB($empleadonrodocto, $beneficiarionrodocto){
		try{
			//----------- Pase Pre Natal -------
			$sql = 'SELECT * FROM legajos_prenatal WHERE legempleado_nrodocto = ? AND legprenatal_benndoc = ? AND legprenatal_activo = 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $empleadonrodocto, PDO::PARAM_STR);
			$stm->bindValue(2, $beneficiarionrodocto, PDO::PARAM_STR);
			$stm->execute();
			$datosprenatalesob = $stm->fetchAll(PDO::FETCH_OBJ);

			$sql = 'SELECT legempleado_apellido,legempleado_nombres FROM legajos_empleado WHERE legempleado_nrodocto = ? LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $empleadonrodocto, PDO::PARAM_STR);
			$stm->execute();
			$datosempleadoob = $stm->fetch(PDO::FETCH_OBJ);

			$sql = $this->cn->prepare("SELECT periodo_id FROM periodos WHERE periodo_cerrado = 1 ORDER BY periodo_id DESC LIMIT 1");
			$sql->execute();
			$periodo = $sql->fetch(PDO::FETCH_OBJ);

			foreach($datosprenatalesob as $row){
				$sql = 'SELECT * FROM asignaciones_otros WHERE asigotro_preohjo_id = ? AND legempleado_nrodocto = ? AND beneficiario_nrodocto = ?';
				$stm = $this->cn->prepare($sql);
				$stm->bindValue(1, $row->legprenatal_id, PDO::PARAM_STR);
				$stm->bindValue(2, $empleadonrodocto, PDO::PARAM_STR);
				$stm->bindValue(3, $beneficiarionrodocto, PDO::PARAM_STR);
				$stm->execute();
				$num = $stm->rowCount();
				if($num > 0 && $num < 10){
					//es mayor a 0
					$asignacionesob = $stm->fetchAll(PDO::FETCH_OBJ);
					$sql = 'INSERT INTO asignaciones_otros (asigotro_preohjo_id,legempleado_nrodocto,legempleado_apellido,legempleado_nombres,beneficiario_nrodocto,beneficiario_nrooficio,beneficiario_apellido,beneficiario_nombres,leghijo_nrodocto,leghijo_apellido,leghijo_nombres,asigotro_periodo,asigotro_tipo,asigotro_cantidad,asigotro_importe,asigotro_estado)
					VALUES(?, ?, ?, ?, ?, ?, ?, ?, 0, 0, 0, ?, 1, 1, 0, 1)';

					$stm = $this->cn->prepare($sql);
					$stm->bindValue(1, $row->legprenatal_id, PDO::PARAM_STR);
					$stm->bindValue(2, $row->legempleado_nrodocto, PDO::PARAM_STR);
					$stm->bindValue(3, $datosempleadoob->legempleado_apellido, PDO::PARAM_STR);
					$stm->bindValue(4, $datosempleadoob->legempleado_nombres, PDO::PARAM_STR);
					$stm->bindValue(5, $row->legprenatal_benndoc, PDO::PARAM_STR);
					$stm->bindValue(6, $row->legprenatal_bennoficio, PDO::PARAM_STR);
					$stm->bindValue(7, $row->legprenatal_benapellido, PDO::PARAM_STR);
					$stm->bindValue(8, $row->legprenatal_bennombres, PDO::PARAM_STR);
					$stm->bindValue(9, $periodo->periodo_id, PDO::PARAM_STR);
					$stm->execute();
				}else{
					//No es mayor a 0
				}


      }
			//----------- Pase Hijo Menor ----

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function DatosHijoMenor($empleadonrodocto, $beneficiarionrodocto, $fechaactual, $fechafinal){
		try{
			$sql = 'SELECT COUNT(leghijo_id) AS hijom FROM legajos_hijo WHERE legempleado_nrodocto = ? AND leghijo_benndoc = ? AND leghijo_esc != 1 AND leghijo_disc != 1 AND leghijo_fecnacto BETWEEN ? AND ? AND leghijo_estado != 2 AND leghijo_activo = 1 LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $empleadonrodocto, PDO::PARAM_STR);
			$stm->bindValue(2, $beneficiarionrodocto, PDO::PARAM_STR);
			$stm->bindValue(3, $fechafinal, PDO::PARAM_STR);
			$stm->bindValue(4, $fechaactual, PDO::PARAM_STR);
			$stm->execute();

			return $stm->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function PasarHijoMenorOb($empleadonrodocto, $beneficiarionrodocto, $fechaactual, $fechafinal){
		try{

			$sql = 'SELECT * FROM legajos_hijo WHERE legempleado_nrodocto = ? AND leghijo_benndoc = ? AND leghijo_esc != 1 AND leghijo_fecnacto BETWEEN ? AND ? AND leghijo_estado != 2 AND leghijo_activo = 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $empleadonrodocto, PDO::PARAM_STR);
			$stm->bindValue(2, $beneficiarionrodocto, PDO::PARAM_STR);
			$stm->bindValue(3, $fechafinal, PDO::PARAM_STR);
			$stm->bindValue(4, $fechaactual, PDO::PARAM_STR);
			$stm->execute();

			$num = $stm->rowCount();
			if($num > 0){
				//--- Tiene Hijos Menores OB---
				$rows = $stm->fetchAll(PDO::FETCH_OBJ);
				//--- Datos Empleados ---
				$sql = 'SELECT legempleado_apellido,legempleado_nombres FROM legajos_empleado WHERE legempleado_nrodocto = ? LIMIT 1';
				$stm = $this->cn->prepare($sql);
				$stm->bindValue(1, $empleadonrodocto, PDO::PARAM_STR);
				$stm->execute();
				$datosempleadoob = $stm->fetch(PDO::FETCH_OBJ);
				//-- Datos Periodos ---
				$sql = $this->cn->prepare("SELECT periodo_id FROM periodos WHERE periodo_cerrado = 1 ORDER BY periodo_id DESC LIMIT 1");
				$sql->execute();
				$periodo = $sql->fetch(PDO::FETCH_OBJ);

				foreach($rows as $row){
					$sql = 'INSERT INTO asignaciones_otros (asigotro_preohjo_id,legempleado_nrodocto,legempleado_apellido,legempleado_nombres,beneficiario_nrodocto,beneficiario_nrooficio,beneficiario_apellido,beneficiario_nombres,leghijo_nrodocto,leghijo_apellido,leghijo_nombres,asigotro_periodo,asigotro_tipo,asigotro_cantidad,asigotro_importe,asigotro_estado)
					VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 2, 1, 0, 1)';

					$stm = $this->cn->prepare($sql);
					$stm->bindValue(1, $row->leghijo_id, PDO::PARAM_STR);
					$stm->bindValue(2, $row->legempleado_nrodocto, PDO::PARAM_STR);
					$stm->bindValue(3, $datosempleadoob->legempleado_apellido, PDO::PARAM_STR);
					$stm->bindValue(4, $datosempleadoob->legempleado_nombres, PDO::PARAM_STR);
					$stm->bindValue(5, $row->leghijo_benndoc, PDO::PARAM_STR);
					$stm->bindValue(6, $row->leghijo_bennoficio, PDO::PARAM_STR);
					$stm->bindValue(7, $row->leghijo_benapellido, PDO::PARAM_STR);
					$stm->bindValue(8, $row->leghijo_bennombres, PDO::PARAM_STR);
					$stm->bindValue(9, $row->leghijo_nrodocto, PDO::PARAM_STR);
					$stm->bindValue(10, $row->leghijo_apellido, PDO::PARAM_STR);
					$stm->bindValue(11, $row->leghijo_nombres, PDO::PARAM_STR);
					$stm->bindValue(12, $periodo->periodo_id, PDO::PARAM_STR);
					$stm->execute();
				}
			}else{
				//--- No tiene Hijos Menores OB
			}

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function DatosHijosEsc($empleadonrodocto, $beneficiarionrodocto, $escuelanivel){
		try{
			$sql = 'SELECT COUNT(escnivel_id) AS escuelac FROM legajos_hijo WHERE legempleado_nrodocto = ? AND leghijo_benndoc = ? AND escnivel_id  = ? AND leghijo_esc = 1 AND leghijo_disc != 1 AND leghijo_estado != 2 AND leghijo_activo = 1 LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $empleadonrodocto, PDO::PARAM_STR);
			$stm->bindValue(2, $beneficiarionrodocto, PDO::PARAM_STR);
			$stm->bindValue(3, $escuelanivel, PDO::PARAM_STR);
			$stm->execute();

			return $stm->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function PasarPreEscolarOb($empleadonrodocto, $beneficiarionrodocto, $escuelanivel){
		try{

			$sql = 'SELECT * FROM legajos_hijo WHERE legempleado_nrodocto = ? AND leghijo_benndoc = ? AND escnivel_id  = ? AND leghijo_esc = 1 AND leghijo_disc != 1 AND leghijo_estado != 2 AND leghijo_activo = 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $empleadonrodocto, PDO::PARAM_STR);
			$stm->bindValue(2, $beneficiarionrodocto, PDO::PARAM_STR);
			$stm->bindValue(3, $escuelanivel, PDO::PARAM_STR);
			$stm->execute();

			$num = $stm->rowCount();
			if($num > 0){
				//--- Tiene Hijos Prescolares OB---
				$rows = $stm->fetchAll(PDO::FETCH_OBJ);
				//--- Datos Empleados ---
				$sql = 'SELECT legempleado_apellido,legempleado_nombres FROM legajos_empleado WHERE legempleado_nrodocto = ? LIMIT 1';
				$stm = $this->cn->prepare($sql);
				$stm->bindValue(1, $empleadonrodocto, PDO::PARAM_STR);
				$stm->execute();
				$datosempleadoob = $stm->fetch(PDO::FETCH_OBJ);
				//-- Datos Periodos ---
				$sql = $this->cn->prepare("SELECT periodo_id FROM periodos WHERE periodo_cerrado = 1 ORDER BY periodo_id DESC LIMIT 1");
				$sql->execute();
				$periodo = $sql->fetch(PDO::FETCH_OBJ);

				foreach($rows as $row){
					$sql = 'INSERT INTO asignaciones_otros (asigotro_preohjo_id,legempleado_nrodocto,legempleado_apellido,legempleado_nombres,beneficiario_nrodocto,beneficiario_nrooficio,beneficiario_apellido,beneficiario_nombres,leghijo_nrodocto,leghijo_apellido,leghijo_nombres,asigotro_periodo,asigotro_tipo,asigotro_cantidad,asigotro_importe,asigotro_estado)
					VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 4, 1, 0, 1)';

					$stm = $this->cn->prepare($sql);
					$stm->bindValue(1, $row->leghijo_id, PDO::PARAM_STR);
					$stm->bindValue(2, $row->legempleado_nrodocto, PDO::PARAM_STR);
					$stm->bindValue(3, $datosempleadoob->legempleado_apellido, PDO::PARAM_STR);
					$stm->bindValue(4, $datosempleadoob->legempleado_nombres, PDO::PARAM_STR);
					$stm->bindValue(5, $row->leghijo_benndoc, PDO::PARAM_STR);
					$stm->bindValue(6, $row->leghijo_bennoficio, PDO::PARAM_STR);
					$stm->bindValue(7, $row->leghijo_benapellido, PDO::PARAM_STR);
					$stm->bindValue(8, $row->leghijo_bennombres, PDO::PARAM_STR);
					$stm->bindValue(9, $row->leghijo_nrodocto, PDO::PARAM_STR);
					$stm->bindValue(10, $row->leghijo_apellido, PDO::PARAM_STR);
					$stm->bindValue(11, $row->leghijo_nombres, PDO::PARAM_STR);
					$stm->bindValue(12, $periodo->periodo_id, PDO::PARAM_STR);
					$stm->execute();
				}
			}else{
				//--- No tiene Hijos Menores OB
			}

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function PasarPrimariaOb($empleadonrodocto, $beneficiarionrodocto, $escuelanivel){
		try{

			$sql = 'SELECT * FROM legajos_hijo WHERE legempleado_nrodocto = ? AND leghijo_benndoc = ? AND escnivel_id  = ? AND leghijo_esc = 1 AND leghijo_disc != 1 AND leghijo_estado != 2 AND leghijo_activo = 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $empleadonrodocto, PDO::PARAM_STR);
			$stm->bindValue(2, $beneficiarionrodocto, PDO::PARAM_STR);
			$stm->bindValue(3, $escuelanivel, PDO::PARAM_STR);
			$stm->execute();

			$num = $stm->rowCount();
			if($num > 0){
				//--- Tiene Hijos Prescolares OB---
				$rows = $stm->fetchAll(PDO::FETCH_OBJ);
				//--- Datos Empleados ---
				$sql = 'SELECT legempleado_apellido,legempleado_nombres FROM legajos_empleado WHERE legempleado_nrodocto = ? LIMIT 1';
				$stm = $this->cn->prepare($sql);
				$stm->bindValue(1, $empleadonrodocto, PDO::PARAM_STR);
				$stm->execute();
				$datosempleadoob = $stm->fetch(PDO::FETCH_OBJ);
				//-- Datos Periodos ---
				$sql = $this->cn->prepare("SELECT periodo_id FROM periodos WHERE periodo_cerrado = 1 ORDER BY periodo_id DESC LIMIT 1");
				$sql->execute();
				$periodo = $sql->fetch(PDO::FETCH_OBJ);

				foreach($rows as $row){
					$sql = 'INSERT INTO asignaciones_otros (asigotro_preohjo_id,legempleado_nrodocto,legempleado_apellido,legempleado_nombres,beneficiario_nrodocto,beneficiario_nrooficio,beneficiario_apellido,beneficiario_nombres,leghijo_nrodocto,leghijo_apellido,leghijo_nombres,asigotro_periodo,asigotro_tipo,asigotro_cantidad,asigotro_importe,asigotro_estado)
					VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 5, 1, 0, 1)';

					$stm = $this->cn->prepare($sql);
					$stm->bindValue(1, $row->leghijo_id, PDO::PARAM_STR);
					$stm->bindValue(2, $row->legempleado_nrodocto, PDO::PARAM_STR);
					$stm->bindValue(3, $datosempleadoob->legempleado_apellido, PDO::PARAM_STR);
					$stm->bindValue(4, $datosempleadoob->legempleado_nombres, PDO::PARAM_STR);
					$stm->bindValue(5, $row->leghijo_benndoc, PDO::PARAM_STR);
					$stm->bindValue(6, $row->leghijo_bennoficio, PDO::PARAM_STR);
					$stm->bindValue(7, $row->leghijo_benapellido, PDO::PARAM_STR);
					$stm->bindValue(8, $row->leghijo_bennombres, PDO::PARAM_STR);
					$stm->bindValue(9, $row->leghijo_nrodocto, PDO::PARAM_STR);
					$stm->bindValue(10, $row->leghijo_apellido, PDO::PARAM_STR);
					$stm->bindValue(11, $row->leghijo_nombres, PDO::PARAM_STR);
					$stm->bindValue(12, $periodo->periodo_id, PDO::PARAM_STR);
					$stm->execute();
				}
			}else{
				//--- No tiene Hijos Menores OB
			}

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function PasarSecYSupOb($empleadonrodocto, $beneficiarionrodocto, $escuelanivel){
		try{

			$sql = 'SELECT * FROM legajos_hijo WHERE legempleado_nrodocto = ? AND leghijo_benndoc = ? AND escnivel_id  = ? AND leghijo_esc = 1 AND leghijo_disc != 1 AND leghijo_estado != 2 AND leghijo_activo = 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $empleadonrodocto, PDO::PARAM_STR);
			$stm->bindValue(2, $beneficiarionrodocto, PDO::PARAM_STR);
			$stm->bindValue(3, $escuelanivel, PDO::PARAM_STR);
			$stm->execute();

			$num = $stm->rowCount();
			if($num > 0){
				//--- Tiene Hijos Prescolares OB---
				$rows = $stm->fetchAll(PDO::FETCH_OBJ);
				//--- Datos Empleados ---
				$sql = 'SELECT legempleado_apellido,legempleado_nombres FROM legajos_empleado WHERE legempleado_nrodocto = ? LIMIT 1';
				$stm = $this->cn->prepare($sql);
				$stm->bindValue(1, $empleadonrodocto, PDO::PARAM_STR);
				$stm->execute();
				$datosempleadoob = $stm->fetch(PDO::FETCH_OBJ);
				//-- Datos Periodos ---
				$sql = $this->cn->prepare("SELECT periodo_id FROM periodos WHERE periodo_cerrado = 1 ORDER BY periodo_id DESC LIMIT 1");
				$sql->execute();
				$periodo = $sql->fetch(PDO::FETCH_OBJ);

				foreach($rows as $row){
					$sql = 'INSERT INTO asignaciones_otros (asigotro_preohjo_id,legempleado_nrodocto,legempleado_apellido,legempleado_nombres,beneficiario_nrodocto,beneficiario_nrooficio,beneficiario_apellido,beneficiario_nombres,leghijo_nrodocto,leghijo_apellido,leghijo_nombres,asigotro_periodo,asigotro_tipo,asigotro_cantidad,asigotro_importe,asigotro_estado)
					VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 6, 1, 0, 1)';

					$stm = $this->cn->prepare($sql);
					$stm->bindValue(1, $row->leghijo_id, PDO::PARAM_STR);
					$stm->bindValue(2, $row->legempleado_nrodocto, PDO::PARAM_STR);
					$stm->bindValue(3, $datosempleadoob->legempleado_apellido, PDO::PARAM_STR);
					$stm->bindValue(4, $datosempleadoob->legempleado_nombres, PDO::PARAM_STR);
					$stm->bindValue(5, $row->leghijo_benndoc, PDO::PARAM_STR);
					$stm->bindValue(6, $row->leghijo_bennoficio, PDO::PARAM_STR);
					$stm->bindValue(7, $row->leghijo_benapellido, PDO::PARAM_STR);
					$stm->bindValue(8, $row->leghijo_bennombres, PDO::PARAM_STR);
					$stm->bindValue(9, $row->leghijo_nrodocto, PDO::PARAM_STR);
					$stm->bindValue(10, $row->leghijo_apellido, PDO::PARAM_STR);
					$stm->bindValue(11, $row->leghijo_nombres, PDO::PARAM_STR);
					$stm->bindValue(12, $periodo->periodo_id, PDO::PARAM_STR);
					$stm->execute();
				}
			}else{
				//--- No tiene Hijos Menores OB
			}

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function DatosHijoDisc($empleadonrodocto, $beneficiarionrodocto){
		try{
			$sql = 'SELECT COUNT(leghijo_disc) AS hijodisc FROM legajos_hijo WHERE legempleado_nrodocto = ? AND leghijo_benndoc = ? AND leghijo_disc = 1 AND leghijo_esc = 0 AND leghijo_estado != 2 AND leghijo_activo = 1 LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $empleadonrodocto, PDO::PARAM_STR);
			$stm->bindValue(2, $beneficiarionrodocto, PDO::PARAM_STR);
			$stm->execute();

			return $stm->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function PasarHijoDisc($empleadonrodocto, $beneficiarionrodocto){
		try{

			$sql = 'SELECT * FROM legajos_hijo WHERE legempleado_nrodocto = ? AND leghijo_benndoc = ? AND leghijo_disc = 1 AND leghijo_esc = 0 AND leghijo_estado != 2 AND leghijo_activo = 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $empleadonrodocto, PDO::PARAM_STR);
			$stm->bindValue(2, $beneficiarionrodocto, PDO::PARAM_STR);
			$stm->execute();

			$num = $stm->rowCount();
			if($num > 0){
				//--- Tiene Hijos Prescolares OB---
				$rows = $stm->fetchAll(PDO::FETCH_OBJ);
				//--- Datos Empleados ---
				$sql = 'SELECT legempleado_apellido,legempleado_nombres FROM legajos_empleado WHERE legempleado_nrodocto = ? LIMIT 1';
				$stm = $this->cn->prepare($sql);
				$stm->bindValue(1, $empleadonrodocto, PDO::PARAM_STR);
				$stm->execute();
				$datosempleadoob = $stm->fetch(PDO::FETCH_OBJ);
				//-- Datos Periodos ---
				$sql = $this->cn->prepare("SELECT periodo_id FROM periodos WHERE periodo_cerrado = 1 ORDER BY periodo_id DESC LIMIT 1");
				$sql->execute();
				$periodo = $sql->fetch(PDO::FETCH_OBJ);

				foreach($rows as $row){
					$sql = 'INSERT INTO asignaciones_otros (asigotro_preohjo_id,legempleado_nrodocto,legempleado_apellido,legempleado_nombres,beneficiario_nrodocto,beneficiario_nrooficio,beneficiario_apellido,beneficiario_nombres,leghijo_nrodocto,leghijo_apellido,leghijo_nombres,asigotro_periodo,asigotro_tipo,asigotro_cantidad,asigotro_importe,asigotro_estado)
					VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 3, 1, 0, 1)';

					$stm = $this->cn->prepare($sql);
					$stm->bindValue(1, $row->leghijo_id, PDO::PARAM_STR);
					$stm->bindValue(2, $row->legempleado_nrodocto, PDO::PARAM_STR);
					$stm->bindValue(3, $datosempleadoob->legempleado_apellido, PDO::PARAM_STR);
					$stm->bindValue(4, $datosempleadoob->legempleado_nombres, PDO::PARAM_STR);
					$stm->bindValue(5, $row->leghijo_benndoc, PDO::PARAM_STR);
					$stm->bindValue(6, $row->leghijo_bennoficio, PDO::PARAM_STR);
					$stm->bindValue(7, $row->leghijo_benapellido, PDO::PARAM_STR);
					$stm->bindValue(8, $row->leghijo_bennombres, PDO::PARAM_STR);
					$stm->bindValue(9, $row->leghijo_nrodocto, PDO::PARAM_STR);
					$stm->bindValue(10, $row->leghijo_apellido, PDO::PARAM_STR);
					$stm->bindValue(11, $row->leghijo_nombres, PDO::PARAM_STR);
					$stm->bindValue(12, $periodo->periodo_id, PDO::PARAM_STR);
					$stm->execute();
				}
			}else{
				//--- No tiene Hijos Menores OB
			}

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function DatosHijoDiscEsc($empleadonrodocto, $beneficiarionrodocto){
		try{
			$sql = 'SELECT COUNT(leghijo_disc) AS hijodiscesc FROM legajos_hijo WHERE legempleado_nrodocto = ? AND leghijo_benndoc = ? AND leghijo_disc = 1 AND leghijo_esc = 1 AND leghijo_estado != 2 AND leghijo_activo = 1 LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $empleadonrodocto, PDO::PARAM_STR);
			$stm->bindValue(2, $beneficiarionrodocto, PDO::PARAM_STR);
			$stm->execute();

			return $stm->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function PasarHijoDiscEsc($empleadonrodocto, $beneficiarionrodocto){
		try{

			$sql = 'SELECT * FROM legajos_hijo WHERE legempleado_nrodocto = ? AND leghijo_benndoc = ? AND leghijo_disc = 1 AND leghijo_esc = 1 AND leghijo_estado != 2 AND leghijo_activo = 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $empleadonrodocto, PDO::PARAM_STR);
			$stm->bindValue(2, $beneficiarionrodocto, PDO::PARAM_STR);
			$stm->execute();

			$num = $stm->rowCount();
			if($num > 0){
				//--- Tiene Hijos Prescolares OB---
				$rows = $stm->fetchAll(PDO::FETCH_OBJ);
				//--- Datos Empleados ---
				$sql = 'SELECT legempleado_apellido,legempleado_nombres FROM legajos_empleado WHERE legempleado_nrodocto = ? LIMIT 1';
				$stm = $this->cn->prepare($sql);
				$stm->bindValue(1, $empleadonrodocto, PDO::PARAM_STR);
				$stm->execute();
				$datosempleadoob = $stm->fetch(PDO::FETCH_OBJ);
				//-- Datos Periodos ---
				$sql = $this->cn->prepare("SELECT periodo_id FROM periodos WHERE periodo_cerrado = 1 ORDER BY periodo_id DESC LIMIT 1");
				$sql->execute();
				$periodo = $sql->fetch(PDO::FETCH_OBJ);

				foreach($rows as $row){
					$sql = 'INSERT INTO asignaciones_otros (asigotro_preohjo_id,legempleado_nrodocto,legempleado_apellido,legempleado_nombres,beneficiario_nrodocto,beneficiario_nrooficio,beneficiario_apellido,beneficiario_nombres,leghijo_nrodocto,leghijo_apellido,leghijo_nombres,asigotro_periodo,asigotro_tipo,asigotro_cantidad,asigotro_importe,asigotro_estado)
					VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 7, 1, 0, 1)';

					$stm = $this->cn->prepare($sql);
					$stm->bindValue(1, $row->leghijo_id, PDO::PARAM_STR);
					$stm->bindValue(2, $row->legempleado_nrodocto, PDO::PARAM_STR);
					$stm->bindValue(3, $datosempleadoob->legempleado_apellido, PDO::PARAM_STR);
					$stm->bindValue(4, $datosempleadoob->legempleado_nombres, PDO::PARAM_STR);
					$stm->bindValue(5, $row->leghijo_benndoc, PDO::PARAM_STR);
					$stm->bindValue(6, $row->leghijo_bennoficio, PDO::PARAM_STR);
					$stm->bindValue(7, $row->leghijo_benapellido, PDO::PARAM_STR);
					$stm->bindValue(8, $row->leghijo_bennombres, PDO::PARAM_STR);
					$stm->bindValue(9, $row->leghijo_nrodocto, PDO::PARAM_STR);
					$stm->bindValue(10, $row->leghijo_apellido, PDO::PARAM_STR);
					$stm->bindValue(11, $row->leghijo_nombres, PDO::PARAM_STR);
					$stm->bindValue(12, $periodo->periodo_id, PDO::PARAM_STR);
					$stm->execute();
				}
			}else{
				//--- No tiene Hijos Menores OB
			}

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function PasarFamiliaNum($empleadonrodocto,$beneficiarionrodocto,$familianum){
		try{
			//-- Datos beneficiario ----
			$sql = 'SELECT * FROM legajos_hijo WHERE legempleado_nrodocto = ? AND leghijo_benndoc = ? AND leghijo_activo = 1 ORDER BY leghijo_id DESC LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $empleadonrodocto, PDO::PARAM_STR);
			$stm->bindValue(2, $beneficiarionrodocto, PDO::PARAM_STR);
			$stm->execute();
			$datosbeneficiarios = $stm->fetch(PDO::FETCH_OBJ);
			//--- Datos Empleados ---
			$sql = 'SELECT legempleado_nrodocto,legempleado_apellido,legempleado_nombres FROM legajos_empleado WHERE legempleado_nrodocto = ? LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $empleadonrodocto, PDO::PARAM_STR);
			$stm->execute();
			$datosempleadoob = $stm->fetch(PDO::FETCH_OBJ);
			//-- Datos Periodos ---
			$sql = $this->cn->prepare("SELECT periodo_id FROM periodos WHERE periodo_cerrado = 1 ORDER BY periodo_id DESC LIMIT 1");
			$sql->execute();
			$periodo = $sql->fetch(PDO::FETCH_OBJ);
			//--- Insertar familia numerosa ---
			$sql = 'INSERT INTO asignaciones_otros (asigotro_preohjo_id,legempleado_nrodocto,legempleado_apellido,legempleado_nombres,beneficiario_nrodocto,beneficiario_nrooficio,beneficiario_apellido,beneficiario_nombres,leghijo_nrodocto,leghijo_apellido,leghijo_nombres,asigotro_periodo,asigotro_tipo,asigotro_cantidad,asigotro_importe,asigotro_estado)
			VALUES(0, ?, ?, ?, ?, ?, ?, ?, 0, "", "", ?, 8, ?, 0, 1)';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $datosempleadoob->legempleado_nrodocto, PDO::PARAM_STR);
			$stm->bindValue(2, $datosempleadoob->legempleado_apellido, PDO::PARAM_STR);
			$stm->bindValue(3, $datosempleadoob->legempleado_nombres, PDO::PARAM_STR);
			$stm->bindValue(4, $datosbeneficiarios->leghijo_benndoc, PDO::PARAM_STR);
			$stm->bindValue(5, $datosbeneficiarios->leghijo_bennoficio, PDO::PARAM_STR);
			$stm->bindValue(6, $datosbeneficiarios->leghijo_benapellido, PDO::PARAM_STR);
			$stm->bindValue(7, $datosbeneficiarios->leghijo_bennombres, PDO::PARAM_STR);
			$stm->bindValue(8, $periodo->periodo_id, PDO::PARAM_STR);
			$stm->bindValue(9, $familianum, PDO::PARAM_STR);
			$stm->execute();


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
			$periodo = Asignacion::ObtenerPeriodoActual();
			$periodoid = $periodo->periodo_id;

			$sql = $this->cn->prepare("SELECT * FROM haberes_remunerativos WHERE periodo_id = $periodoid");
			$sql->execute();

			return $sql->fetchAll(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerPeriodoActual(){
		try{
			$sql = $this->cn->prepare("SELECT periodo_id,periodo_nombre FROM periodos WHERE periodo_cerrado = 1 ORDER BY periodo_id DESC LIMIT 1");
			$sql->execute();
			return $sql->fetch(PDO::FETCH_OBJ);
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
	public function ObtenerHaberesExistentes($periodoid){
		try{
			$sql = 'SELECT * FROM haberes_remunerativos WHERE periodo_id = ?';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $periodoid, PDO::PARAM_STR);
			$stm->execute();
			return $stm->fetchAll(PDO::FETCH_OBJ);

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

			$sql = 'SELECT legempleado_nrodocto FROM haberes_remunerativos WHERE periodo_id = ? AND haberrem_importe BETWEEN ? AND ?';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $periodo->periodo_id, PDO::PARAM_STR);
			$stm->bindValue(2, $impdesde, PDO::PARAM_STR);
			$stm->bindValue(3, $imphasta, PDO::PARAM_STR);
			$stm->execute();
			$empleadosnrodocto = $stm->fetchAll(PDO::FETCH_OBJ);

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
			$sql = 'SELECT asigotro_id,legempleado_nrodocto,asigotro_tipo,asigotro_cantidad FROM asignaciones_otros WHERE	asigotro_periodo = ? AND asigotro_tipo = ?';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $periodo->periodo_id, PDO::PARAM_STR);
			$stm->bindValue(2, $asignacion, PDO::PARAM_STR);
			$stm->execute();
			$familiasnumerosas = $stm->fetchAll(PDO::FETCH_OBJ);

			foreach($familiasnumerosas as  $familianumerosa){
				// code...
				$importefam = $importeasig * $familianumerosa->asigotro_cantidad;

				$sql = 'UPDATE asignaciones_otros SET asigotro_importe = ?, asigotro_imptotal = ? WHERE asigotro_id = ?';

				$stm = $this->cn->prepare($sql);
				$stm->bindValue(1, $importefam, PDO::PARAM_STR);
				$stm->bindValue(2, $importefam, PDO::PARAM_STR);
				$stm->bindValue(3, $familianumerosa->asigotro_id, PDO::PARAM_STR);
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
	public function ObtenerBeneficiarioImp($empleadonrodocto, $beneficiarionrodocto){
		try{
			$periodo = Asignacion::ObtenerPeriodoActual();
			//$periodoid = $periodo->periodo_id;
			$sql = 'SELECT SUM(asigotro_importe) AS importeob, SUM(asigotro_reajuste) AS reajusteob, SUM(asigotro_imptotal) AS imptotal FROM asignaciones_otros WHERE legempleado_nrodocto = ? AND beneficiario_nrodocto = ? AND asigotro_periodo = ? LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $empleadonrodocto, PDO::PARAM_STR);
			$stm->bindValue(2, $beneficiarionrodocto, PDO::PARAM_STR);
			$stm->bindValue(3, $periodo->periodo_id, PDO::PARAM_STR);
			$stm->execute();

			return $stm->fetch(PDO::FETCH_OBJ);

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
			$sql = 'SELECT * FROM asignaciones_otros WHERE beneficiario_nrodocto = ? AND asigotro_periodo = ? ORDER BY legempleado_apellido, legempleado_nombres';
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
	public function ObtenerImporteOBReajuste($periodoid){
		try{
			$sql = 'SELECT SUM(asigotro_importe) AS importeobr FROM asignaciones_otros WHERE asigotro_tipo != 8 AND asigotro_periodo = ? LIMIT 1';
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
	public function ObtenerOficioNro($empleadonrodocto, $beneficiarionrodocto){
		try{

			$sql = 'SELECT leghijo_bennoficio FROM legajos_hijo WHERE leghijo_bennoficio != " " AND legempleado_nrodocto = ? AND leghijo_benndoc = ? LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $empleadonrodocto, PDO::PARAM_STR);
			$stm->bindValue(2, $beneficiarionrodocto, PDO::PARAM_STR);
			$stm->execute();
			return $stm->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
}
