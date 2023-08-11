<?php
class imputacion{

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
	public function ListarImputaciones(){
		try{

			$sql = $this->cn->prepare("SELECT * FROM imputaciones WHERE imputacion_habilitar = 1 ORDER BY imputacion_codigow");
			$sql->execute();

			return $sql->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ListarSecretarias(){
		try{
			$sql = $this->cn->prepare("SELECT * FROM secretarias WHERE secretaria_habilitar = 1 AND secretaria_id != 6");
			$sql->execute();

			return $sql->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	/*public function ListarTabladeActividades(){
		try{
			$sql = $this->cn->prepare("SELECT * FROM imputaciones_actividad a, imputaciones b WHERE a.imputacion_id=b.imputacion_id AND a.impactividad_habilitar = 1 ORDER BY a.impactividad_codigos");
			$sql->execute();

			return $sql->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}*/
	public function ListarDependencias(){
		try{
			$sql = $this->cn->prepare("SELECT * FROM imputaciones_dependencias a, imputaciones b WHERE a.imputacion_id=b.imputacion_id AND a.impdependencia_habilitar = 1 ORDER BY a.impdependencia_nombre");
			$sql->execute();

			return $sql->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function RegistrarI($data){
		try
		{
			//------------ Insert Centro de Costo -------------------
			$sql = 'INSERT INTO imputaciones (imputacion_codigow,imputacion_codigos,imputacion_nombre,imputacion_habilitar)
			VALUES(?, ?, ?, 1)';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->ImputacionCodigoW, PDO::PARAM_STR);
			$stm->bindValue(2, $data->ImputacionCodigoS, PDO::PARAM_STR);
			$stm->bindValue(3, $data->ImputacionNombre, PDO::PARAM_STR);
			$stm->execute();
			//----------------obtner ultimo id Insertado -----------
			/*
			$ultimoid = $this->cn->lastInsertId();
			// ------Insert auditoria feriado--------
			$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];
			$sql ='INSERT INTO aud_feriados (AUD_feriado_id,AUD_feriado_fecha,AUD_feriado_observacion,AUD_feriado_activo,AUD_accion,AUD_datetime,AUD_usuario) VALUES (?, ?, ?, ?, "INSERT", NOW(), ?)';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $ultimoid, PDO::PARAM_STR);
			$stm->bindValue(2, $data->Feriadofecha, PDO::PARAM_STR);
			$stm->bindValue(3, $data->Feriadoobservacion, PDO::PARAM_STR);
			$stm->bindValue(4, $data->Feriadoactivo, PDO::PARAM_STR);
			$stm->bindValue(5, $usuario, PDO::PARAM_STR);
			$stm->execute();
			*/
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ActualizarI($data){
		try{
			// --------------- Modificacion de Centro de Costos--------------------
			$sql = 'UPDATE imputaciones SET imputacion_codigow = ?, imputacion_codigos = ?, imputacion_nombre = ? WHERE imputacion_id = ?';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->ImputacionCodigoW, PDO::PARAM_STR);
			$stm->bindValue(2, $data->ImputacionCodigoS, PDO::PARAM_STR);
			$stm->bindValue(3, $data->ImputacionNombre, PDO::PARAM_STR);
			$stm->bindValue(4, $data->ImputacionId, PDO::PARAM_STR);
			$stm->execute();
			//-----Insert de auditoria modificacion de feriados -----
			/*
			$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];
			$sql ='INSERT INTO aud_feriados (AUD_feriado_id,AUD_feriado_fecha,AUD_feriado_observacion,AUD_feriado_activo,AUD_accion,AUD_datetime,AUD_usuario) VALUES (?, ?, ?, ?, "UPDATE", NOW(), ?)';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Feriadoid, PDO::PARAM_STR);
			$stm->bindValue(2, $data->Feriadofecha, PDO::PARAM_STR);
			$stm->bindValue(3, $data->Feriadoobservacion, PDO::PARAM_STR);
			$stm->bindValue(4, $data->Feriadoactivo, PDO::PARAM_STR);
			$stm->bindValue(5, $usuario, PDO::PARAM_STR);
			$stm->execute();
			*/
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function RegistrarIAC($data){
		try
		{
			$sql = 'INSERT INTO imputaciones_actividad (impactividad_codigos,impactividad_nombre,imputacion_id,impactividad_habilitar)
			VALUES(?, ?, ?, 1)';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->ImpActividadCodigoS, PDO::PARAM_STR);
			$stm->bindValue(2, $data->ImpActividadNombre, PDO::PARAM_STR);
			$stm->bindValue(3, $data->ImputacionId, PDO::PARAM_STR);
			$stm->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ActualizarIAC($data){
		try{
			$sql = 'UPDATE imputaciones_actividad SET impactividad_codigos = ?, impactividad_nombre = ?, imputacion_id = ? WHERE impactividad_id = ?';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->ImpActividadCodigoS, PDO::PARAM_STR);
			$stm->bindValue(2, $data->ImpActividadNombre, PDO::PARAM_STR);
			$stm->bindValue(3, $data->ImputacionId, PDO::PARAM_STR);
			$stm->bindValue(4, $data->ImpActividadId, PDO::PARAM_STR);
			$stm->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function DeshabilitarImputacionExe($data){
		try{
			//---------- Deshabilitar Imputacion -------
			$sql = 'UPDATE imputaciones SET imputacion_habilitar = ? WHERE imputacion_id = ?';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->ImputacionActivo, PDO::PARAM_STR);
			$stm->bindValue(2, $data->ImputacionId, PDO::PARAM_STR);
			$stm->execute();
			/*
			//------------- auditoria -----------------
			$sql = 'SELECT * FROM feriados WHERE feriado_id = ?';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Feriadoid, PDO::PARAM_STR);
			$stm->execute();
			$row = $stm->fetch(PDO::FETCH_OBJ);
			//--------Insert de auditoria Deshabilitar Feriado-----
			$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];
			$sql ='INSERT INTO aud_feriados (AUD_feriado_id,AUD_feriado_fecha,AUD_feriado_observacion,AUD_feriado_activo,AUD_accion,AUD_datetime,AUD_usuario) VALUES (?, ?, ?, ?, "DISABLE", NOW(), ?)';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $row->feriado_id, PDO::PARAM_STR);
			$stm->bindValue(2, $row->feriado_fecha, PDO::PARAM_STR);
			$stm->bindValue(3, $row->feriado_observacion, PDO::PARAM_STR);
			$stm->bindValue(4, $row->feriado_activo, PDO::PARAM_STR);
			$stm->bindValue(5, $usuario, PDO::PARAM_STR);
			$stm->execute();
			*/
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function EmpleadosXImputacion($imputacionid){
		try{
			$sql = 'SELECT COUNT(a.imputacion_id) AS imputacionc FROM legajos_contrato a, legajos_empleado b WHERE a.legempleado_nrodocto = b.legempleado_nrodocto AND a.imputacion_id = ? AND b.legempleado_activo = 1 AND a.legcontrato_activo = 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $imputacionid, PDO::PARAM_STR);
			$stm->execute();

			return $stm->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ImputacionesXSecretaria($secretariaid){
		try{
			$sql = 'SELECT COUNT(secretaria_id) AS imputacionsc FROM legajos_contrato WHERE secretaria_id = ? AND legtipo_id = 1 AND legcontrato_activo = 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $secretariaid, PDO::PARAM_STR);
			$stm->execute();

			return $stm->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerEmpleadosXImputaciones($id){
		try{
			$sql = 'SELECT * FROM legajos_empleado a, legajos_contrato b, sexos c, estados_civiles d, legajos_tipo e WHERE a.legempleado_nrodocto = b.legempleado_nrodocto AND a.sexo_id = c.sexo_id AND a.estcivil_id = d.estcivil_id AND a.legtipo_id = e.legtipo_id AND b.imputacion_id = ? AND a.legempleado_activo = 1 AND b.legcontrato_activo = 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $id, PDO::PARAM_STR);
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function BuscarEmpleadosXImputaciones($imputacionid, $search){
		try{
			$sql = "SELECT * FROM legajos_empleado a, legajos_contrato b, sexos c, estados_civiles d, legajos_tipo e WHERE a.legempleado_nrodocto = b.legempleado_nrodocto AND a.sexo_id = c.sexo_id AND a.estcivil_id = d.estcivil_id AND a.legtipo_id = e.legtipo_id AND b.imputacion_id = ? AND a.legempleado_activo = 1 AND b.legcontrato_activo = 1 AND (a.legempleado_apellido LIKE '%$search%' OR a.legempleado_nombres LIKE '%$search%')";
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $imputacionid, PDO::PARAM_STR);
			//$stm->bindValue(2, $search, PDO::PARAM_STR);
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
}
