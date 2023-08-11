<?php
class Importacion{

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
	public function ListarImportes(){
		try{
			$sql = $this->cn->prepare("SELECT * FROM importes_julio");
			$sql->execute();

			return $sql->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerDatosExitentes($nrodocumento){
		try{
			$sql = 'SELECT * FROM importes_julio WHERE legajo_nrodocto = ?';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $nrodocumento, PDO::PARAM_STR);
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerDatosExitentesDos($nrodocumento){
		try{
			$sql = 'SELECT * FROM importes_julio WHERE legajo_nrodocto = ? LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $nrodocumento, PDO::PARAM_STR);
			$stm->execute();

			return $stm->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	/*
	public function ObtenerEmp($nrodocumento){
		try{
			$sql = 'SELECT * FROM importes WHERE legajo_nrodocto = ? LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $nrodocumento, PDO::PARAM_STR);
			$stm->execute();

			return $stm->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	*/
	public function RegistrarImp($nrolegajo,$nrodocumento,$importe,$nombre){
		try{

			$sql = 'INSERT INTO importes_julio (legajo_numero,legajo_nrodocto,legajo_nombre,importe_basico,importe_147,importe_151,importe_151_2)
			VALUES(?, ?, ?, ?, 0, 0, 0)';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $nrolegajo, PDO::PARAM_STR);
			$stm->bindValue(2, $nrodocumento, PDO::PARAM_STR);
			$stm->bindValue(3, $nombre, PDO::PARAM_STR);
			$stm->bindValue(4, $importe, PDO::PARAM_STR);

			$stm->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function RegistarAum($nrolegajo,$nrodocumento,$importeu){
		try{
			$sql = 'UPDATE importes_julio SET importe_basico_feb19 = ? WHERE legajo_nrodocto = ? AND legajo_numero = ?';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $importeu, PDO::PARAM_STR);
			$stm->bindValue(2, $nrodocumento, PDO::PARAM_STR);
			$stm->bindValue(3, $nrolegajo, PDO::PARAM_STR);

			$stm->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function VerificarEstadoTP($concepto){
		try{
			$sql = 'SELECT * FROM cargas WHERE nfactura = ? GROUP BY nfactura';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $concepto, PDO::PARAM_STR);
			$stm->execute();

			return $stm->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ModificarCompraTP($data){
		try{
			$estado = 2;
			$sql = 'UPDATE cargas SET estado = ? WHERE nfactura = ?';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $estado, PDO::PARAM_STR);
			$stm->bindValue(2, $data->ConceptoNum, PDO::PARAM_STR);
			$stm->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	//-----------codigo viejo ----
	public function ListarImputaciones(){
		try{
			//----- Listado de feriados con filtro de año actual -----
			//date_default_timezone_set("America/Buenos_Aires");
			//$año = date("Y");
			$sql = $this->cn->prepare("SELECT * FROM imputaciones WHERE imputacion_habilitar = 1 ORDER BY imputacion_codigos");
			$sql->execute();

		return $sql->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ListarTabladeActividades(){
		try{
			$sql = $this->cn->prepare("SELECT * FROM imputaciones_actividad a, imputaciones b WHERE a.imputacion_id=b.imputacion_id AND a.impactividad_habilitar = 1 ORDER BY a.impactividad_codigos");
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
	public function DeshabilitarFer($data){
		try{
			//---------- Deshabilitar feriado -------
			$sql = 'UPDATE feriados SET feriado_activo = ? WHERE feriado_id = ?';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Feriadoactivo, PDO::PARAM_STR);
			$stm->bindValue(2, $data->Feriadoid, PDO::PARAM_STR);
			$stm->execute();
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

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
}
