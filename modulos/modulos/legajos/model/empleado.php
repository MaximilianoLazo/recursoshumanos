<?php

date_default_timezone_set("America/Buenos_Aires");
$fechahoy = date("Y/m/d");
$horahoy = date("H:i:s");

class Empleado{

	public function __CONSTRUCT(){
		try{
			$this->cn = Conexion::getConnection();
		}catch(Exception $e){
			die($e->getMessage());
		}
	}
	public function __DESTRUCT(){
		//$db;
		$this->cn;
	}
	//-----------20210823------
	public function LocalidadObtener($localidadid){
		try{

			$sql = 'SELECT *
								FROM localidades
							 WHERE localidad_id = ?
							 LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $localidadid, PDO::PARAM_STR);
			$stm->execute();
			return $stm->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function SecretariasListar(){
		try{

			$sql = $this->cn->prepare("SELECT *
																	 FROM secretarias
																	WHERE secretaria_habilitar = 1
															 ORDER BY secretaria_nombre");
			$sql->execute();

			return $sql->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function SituacionRevistaListar(){
		try{

			$sql = $this->cn->prepare("SELECT *
																	 FROM legajos_tipo
																	WHERE legtipo_habilitar = 1
															 ORDER BY legtipo_nombre");
			$sql->execute();

			return $sql->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	//-----------20210823------
	//-------Sentencias nuevas -----
	public function ObtenerContrato($nrodocto){
		try{

			$sql = 'SELECT a.legcontrato_id,
										 a.legcontrato_fecinicio,
										 a.legcontrato_fecfin,
										 a.legcontrato_tarea,
										 a.legcontrato_sbasico,
										 b.legempleado_nrodocto,
										 b.legempleado_nrocuil,
										 b.legempleado_apellido,
										 b.legempleado_nombres,
										 b.sexo_id,
										 b.legempleado_direccion,
										 b.legempleado_direcnro,
										 b.localidad_id,
										 b.legempleado_fecingreso,
										 c.secretaria_id,
										 c.secretaria_nombre,
										 d.imputacion_codigow,
										 d.imputacion_id,
										 d.imputacion_nombre,
										 e.impdependencia_id,
										 e.impdependencia_nombre,
										 f.trabajo_id,
										 f.trabajo_nombre,
										 g.contrato_modelo_id
								FROM legajos_contrato a,
										 legajos b,
										 secretarias c,
										 imputaciones d,
										 imputaciones_dependencias e,
										 lugares_trabajo f,
										 contratos_modelos g
							 WHERE a.legempleado_nrodocto = b.legempleado_nrodocto
							 	 AND a.secretaria_id = c.secretaria_id
							 	 AND a.imputacion_id = d.imputacion_id
							 	 AND a.impdependencia_id = e.impdependencia_id
							 	 AND a.trabajo_id = f.trabajo_id
								 AND a.contrato_modelo_id = g.contrato_modelo_id
							 	 AND a.legempleado_nrodocto = ?
							 	 AND a.legcontrato_activo = 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$dec->execute();

			return $dec->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ListarModeloContrato(){
		try{

			$sql = $this->cn->prepare("SELECT * FROM contratos_modelos WHERE leg_modelo_activo = 1");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}

	}
	public function ObtenerProveedor($nrodocto){
		try{

			$sql = 'SELECT * FROM legajos_proveedor a, legajos b, secretarias c, lugares_trabajo d, contratos_modelos e WHERE a.contrato_modelo_id = e.contrato_modelo_id AND a.legempleado_nrodocto = b.legempleado_nrodocto AND a.secretaria_id = c.secretaria_id AND a.trabajo_id = d.trabajo_id AND a.legempleado_nrodocto = ? AND a.legproveedor_activo = 1 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerContratodos($nrodocto){
		try{

			$sql = 'SELECT a.legcontrato_id,a.legcontrato_fecinicio,a.legcontrato_fecfin,a.legcontrato_tarea,a.legcontrato_sbasico,b.legempleado_nrodocto,b.legempleado_nrocuil,b.legempleado_apellido,b.legempleado_nombres,b.sexo_id,b.legempleado_direccion,b.legempleado_direcnro,b.legempleado_fecingreso,c.secretaria_id,c.secretaria_nombre,d.imputacion_codigow,d.imputacion_id,d.imputacion_nombre,f.trabajo_id,f.trabajo_nombre FROM legajos_contrato a, legajos b, secretarias c, imputaciones d, lugares_trabajo f WHERE a.legempleado_nrodocto = b.legempleado_nrodocto AND a.secretaria_id = c.secretaria_id AND a.imputacion_id = d.imputacion_id AND a.trabajo_id = f.trabajo_id AND a.legempleado_nrodocto = ? AND a.legcontrato_activo = 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$dec->execute();

			return $dec->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerContratosProveedor($nrodocto){
		try{

			$sql = 'SELECT a.legproveedor_id,
										 a.legproveedor_fecinicio,
										 a.legproveedor_fecfin,
										 a.legproveedor_tarea,
										 a.legproveedor_sbasico,
										 b.legempleado_nrodocto,
										 b.legempleado_nrocuil,
										 b.legempleado_apellido,
										 b.legempleado_nombres,
										 b.sexo_id,
										 b.legempleado_direccion,
										 b.legempleado_direcnro,
										 b.legempleado_fecingreso,
										 c.secretaria_id,
										 c.secretaria_nombre,
										 d.trabajo_id,
										 d.trabajo_nombre
								FROM legajos_proveedor a,
										 legajos b,
										 secretarias c,
										 lugares_trabajo d
							 WHERE a.legempleado_nrodocto = b.legempleado_nrodocto
							 	 AND a.secretaria_id = c.secretaria_id
								 AND a.trabajo_id = d.trabajo_id
								 AND a.legempleado_nrodocto = ?
								 AND a.legproveedor_activo = 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$dec->execute();

			return $dec->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerPPermanente($nrodocto){
		try{

			$sql = 'SELECT * FROM legajos_ppermanente a, legajos b, secretarias c, imputaciones d, lugares_trabajo e WHERE a.legempleado_nrodocto = b.legempleado_nrodocto AND a.secretaria_id = c.secretaria_id AND a.imputacion_id = d.imputacion_id AND a.trabajo_id = e.trabajo_id AND a.legempleado_nrodocto = ? AND a.legppermanente_activo = 1 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerJornalero($nrodocto){
		try{

			$sql = 'SELECT *,a.secretaria_id FROM legajos_jornalero a, legajos b, secretarias c, imputaciones d, lugares_trabajo e WHERE a.secretaria_id = c.secretaria_id AND a.legempleado_nrodocto = b.legempleado_nrodocto AND a.imputacion_id = d.imputacion_id AND a.trabajo_id = e.trabajo_id AND a.legempleado_nrodocto = ? AND a.legjornalero_activo = 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerDependencias($imputacionid){
		try{

			$sql = 'SELECT * FROM imputaciones_dependencias WHERE imputacion_id = ? ORDER BY impdependencia_nombre';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $imputacionid, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ConyugeObtener($empndoc){
		try{
			$sql = 'SELECT *
								FROM legajos_conyuge
							 WHERE legempleado_nrodocto = ?
							   AND legconyuge_activo = 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $empndoc, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerSexos(){
		try{
			$sql = $this->cn->prepare("SELECT *
																	 FROM sexos
															 ORDER BY sexo_nombre");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function Paises(){
		try{

			$sql = $this->cn->prepare("SELECT *
																	 FROM paises
															 ORDER BY pais_nombre");
			$sql->execute();

			return $sql->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function Provincias(){
		try{

		$sql = $this->cn->prepare("SELECT *
			 													 FROM provincias
														 ORDER BY provincia_nombre");
		$sql->execute();
		return $sql->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function departamentos(){
		try{

			$sql = $this->cn->prepare("SELECT *
																	 FROM departamentos
															 ORDER BY departamento_nombre");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function Localidades(){
		try{

			$sql = $this->cn->prepare("SELECT *
																	 FROM localidades
															 ORDER BY localidad_nombre");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ConyugeGuardarExe($data){
		try{

			$sql = 'INSERT INTO legajos_conyuge (legempleado_nrodocto,
																					 legconyuge_nrodocto,
																					 legconyuge_nrocuil,
																					 legconyuge_apellido,
																					 legconyuge_nombres,
																					 sexo_id,
																					 legconyuge_fecnacto,
																					 legconyuge_activo)
																		VALUES(:empnrodocto,
																					 :cyenrodocto,
																					 :cyenrocuil,
																					 :cyeapellido,
																					 :cyenombres,
																					 :cyesexo,
																					 :cyefecnacto,
																					 1)';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(':empnrodocto', $data->Empnrodocumentohdd, PDO::PARAM_STR);
			$dec->bindValue(':cyenrodocto', $data->Cyenrodocto, PDO::PARAM_STR);
			$dec->bindValue(':cyenrocuil', $data->Cyenrocuil, PDO::PARAM_STR);
			$dec->bindValue(':cyeapellido', $data->Cyeapellido, PDO::PARAM_STR);
			$dec->bindValue(':cyenombres', $data->Cyenombres, PDO::PARAM_STR);
			$dec->bindValue(':cyesexo', $data->Cyesexo, PDO::PARAM_STR);
			$dec->bindValue(':cyefecnacto', $data->Cyefecnacto, PDO::PARAM_STR);
			$dec->execute();
			//----------------obtner ultimo id Insertado -----------
			$ultimoid = $this->cn->lastInsertId();
			// ---------------Insert auditoria  conyuge ------------
			$sql = 'SELECT *
								FROM legajos_conyuge
							 WHERE legconyuge_id = ?
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $ultimoid, PDO::PARAM_STR);
			$dec->execute();
			$row = $dec->fetch(PDO::FETCH_OBJ);

			$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];
			$ippublica = $_SERVER["REMOTE_ADDR"];
			$pcnombre = gethostbyaddr($_SERVER['REMOTE_ADDR']);
			$pcinformacion = $_SERVER['HTTP_USER_AGENT'];

			$sql ='INSERT INTO aud_legajos_conyuge (AUD_legconyuge_id,
																						  AUD_legempleado_nrodocto,
																							AUD_legconyuge_tipodocto,
																							AUD_legconyuge_nrodocto,
																							AUD_legconyuge_nrocuil,
																							AUD_legconyuge_apellido,
																							AUD_legconyuge_nombres,
																							AUD_sexo_id,
																							AUD_legconyuge_fecnacto,
																							AUD_legconyuge_direccion,
																							AUD_legconyuge_direcnro,
																							AUD_legconyuge_direcpiso,
																							AUD_legconyuge_celular,
																							AUD_legconyuge_telefono,
																							AUD_legconyuge_email,
																							AUD_pais_id,
																							AUD_provincia_id,
																							AUD_departamento_id,
																							AUD_localidad_id,
																							AUD_legconyuge_codpostal,
																							AUD_legconyuge_activo,
																							AUD_legconyuge_observacion,
																							AUD_legconyuge_ippublica,
																							AUD_legconyuge_pcnombre,
																							AUD_legconyuge_pcinformacion,
																							AUD_legconyuge_accion,
																							AUD_legconyuge_datetime,
																							AUD_legconyuge_usuario)
																			VALUES (:cyeid,
																			 			  :empndoc,
																						  :cyetdoc,
																						  :cyendoc,
																						  :cyencuil,
																						  :cyeapellido,
																						  :cyenombres,
																						  :cyesexo,
																						  :cyefecnac,
																						  :cyedireccion,
																						  :cyedirecnro,
																						  :cyedirecpiso,
																						  :cyecelular,
																						  :cyetelfono,
																						  :cyeemail,
																						  :cyepais,
																						  :cyeprovincia,
																						  :cyedepartamento,
																						  :cyelocalidad,
																						  :cyecpostal,
																						  :cyeactivo,
																						  "",
																						  :cyeippublica,
																						  :cyepcnombre,
																						  :cyepcinformacion,
																						  "INSERT",
																						  NOW(),
																						  :cyeusuario)';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(':cyeid', $row->legconyuge_id, PDO::PARAM_STR);
			$dec->bindValue(':empndoc', $row->legempleado_nrodocto, PDO::PARAM_STR);
			$dec->bindValue(':cyetdoc', $row->legconyuge_tipodocto, PDO::PARAM_STR);
			$dec->bindValue(':cyendoc', $row->legconyuge_nrodocto, PDO::PARAM_STR);
			$dec->bindValue(':cyencuil', $row->legconyuge_nrocuil, PDO::PARAM_STR);
			$dec->bindValue(':cyeapellido', $row->legconyuge_apellido, PDO::PARAM_STR);
			$dec->bindValue(':cyenombres', $row->legconyuge_nombres, PDO::PARAM_STR);
			$dec->bindValue(':cyesexo', $row->sexo_id, PDO::PARAM_STR);
			$dec->bindValue(':cyefecnac', $row->legconyuge_fecnacto, PDO::PARAM_STR);
			$dec->bindValue(':cyedireccion', $row->legconyuge_direccion, PDO::PARAM_STR);
			$dec->bindValue(':cyedirecnro', $row->legconyuge_direcnro, PDO::PARAM_STR);
			$dec->bindValue(':cyedirecpiso', $row->legconyuge_direcpiso, PDO::PARAM_STR);
			$dec->bindValue(':cyecelular', $row->legconyuge_celular, PDO::PARAM_STR);
			$dec->bindValue(':cyetelfono', $row->legconyuge_telefono, PDO::PARAM_STR);
			$dec->bindValue(':cyeemail', $row->legconyuge_email, PDO::PARAM_STR);
			$dec->bindValue(':cyepais', $row->pais_id, PDO::PARAM_STR);
			$dec->bindValue(':cyeprovincia', $row->provincia_id, PDO::PARAM_STR);
			$dec->bindValue(':cyedepartamento', $row->departamento_id, PDO::PARAM_STR);
			$dec->bindValue(':cyelocalidad', $row->localidad_id, PDO::PARAM_STR);
			$dec->bindValue(':cyecpostal', $row->legconyuge_codpostal, PDO::PARAM_STR);
			$dec->bindValue(':cyeactivo', $row->legconyuge_activo, PDO::PARAM_STR);
			$dec->bindValue(':cyeippublica', $ippublica, PDO::PARAM_STR);
			$dec->bindValue(':cyepcnombre', $pcnombre, PDO::PARAM_STR);
			$dec->bindValue(':cyepcinformacion', $pcinformacion, PDO::PARAM_STR);
			$dec->bindValue(':cyeusuario', $usuario, PDO::PARAM_STR);
			$dec->execute();
			return $ultimoid;
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ConyugeActualizarExe($data){
		try{

			$sql = 'UPDATE legajos_conyuge
								 SET legconyuge_nrodocto = ?,
										 legconyuge_nrocuil = ?,
										 legconyuge_apellido = ?,
										 legconyuge_nombres = ?,
										 sexo_id = ?,
										 legconyuge_fecnacto = ?
							 WHERE legconyuge_id = ?';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $data->Cyenrodocto, PDO::PARAM_STR);
			$dec->bindValue(2, $data->Cyenrocuil, PDO::PARAM_STR);
			$dec->bindValue(3, $data->Cyeapellido, PDO::PARAM_STR);
			$dec->bindValue(4, $data->Cyenombres, PDO::PARAM_STR);
			$dec->bindValue(5, $data->Cyesexo, PDO::PARAM_STR);
			$dec->bindValue(6, $data->Cyefecnacto, PDO::PARAM_STR);
			$dec->bindValue(7, $data->Cyeid, PDO::PARAM_STR);
			$dec->execute();
			// ---------------Insert auditoria  conyuge ------------
			$sql = 'SELECT *
								FROM legajos_conyuge
							 WHERE legconyuge_id = ?
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $data->Cyeid, PDO::PARAM_STR);
			$dec->execute();
			$row = $dec->fetch(PDO::FETCH_OBJ);
			//------------Datos para auditoria ----------
			$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];
			$ippublica = $_SERVER["REMOTE_ADDR"];
			$pcnombre = gethostbyaddr($_SERVER['REMOTE_ADDR']);
			$pcinformacion = $_SERVER['HTTP_USER_AGENT'];

			$sql ='INSERT INTO aud_legajos_conyuge (AUD_legconyuge_id,
																						  AUD_legempleado_nrodocto,
																							AUD_legconyuge_tipodocto,
																							AUD_legconyuge_nrodocto,
																							AUD_legconyuge_nrocuil,
																							AUD_legconyuge_apellido,
																							AUD_legconyuge_nombres,
																							AUD_sexo_id,
																							AUD_legconyuge_fecnacto,
																							AUD_legconyuge_direccion,
																							AUD_legconyuge_direcnro,
																							AUD_legconyuge_direcpiso,
																							AUD_legconyuge_celular,
																							AUD_legconyuge_telefono,
																							AUD_legconyuge_email,
																							AUD_pais_id,
																							AUD_provincia_id,
																							AUD_departamento_id,
																							AUD_localidad_id,
																							AUD_legconyuge_codpostal,
																							AUD_legconyuge_activo,
																							AUD_legconyuge_observacion,
																							AUD_legconyuge_ippublica,
																							AUD_legconyuge_pcnombre,
																							AUD_legconyuge_pcinformacion,
																							AUD_legconyuge_accion,
																							AUD_legconyuge_datetime,
																							AUD_legconyuge_usuario)
																			VALUES (:cyeid,
																			 			  :empndoc,
																						  :cyetdoc,
																						  :cyendoc,
																						  :cyencuil,
																						  :cyeapellido,
																						  :cyenombres,
																						  :cyesexo,
																						  :cyefecnac,
																						  :cyedireccion,
																						  :cyedirecnro,
																						  :cyedirecpiso,
																						  :cyecelular,
																						  :cyetelfono,
																						  :cyeemail,
																						  :cyepais,
																						  :cyeprovincia,
																						  :cyedepartamento,
																						  :cyelocalidad,
																						  :cyecpostal,
																						  :cyeactivo,
																						  "",
																						  :cyeippublica,
																						  :cyepcnombre,
																						  :cyepcinformacion,
																						  "UPDATE",
																						  NOW(),
																						  :cyeusuario)';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(':cyeid', $row->legconyuge_id, PDO::PARAM_STR);
			$dec->bindValue(':empndoc', $row->legempleado_nrodocto, PDO::PARAM_STR);
			$dec->bindValue(':cyetdoc', $row->legconyuge_tipodocto, PDO::PARAM_STR);
			$dec->bindValue(':cyendoc', $row->legconyuge_nrodocto, PDO::PARAM_STR);
			$dec->bindValue(':cyencuil', $row->legconyuge_nrocuil, PDO::PARAM_STR);
			$dec->bindValue(':cyeapellido', $row->legconyuge_apellido, PDO::PARAM_STR);
			$dec->bindValue(':cyenombres', $row->legconyuge_nombres, PDO::PARAM_STR);
			$dec->bindValue(':cyesexo', $row->sexo_id, PDO::PARAM_STR);
			$dec->bindValue(':cyefecnac', $row->legconyuge_fecnacto, PDO::PARAM_STR);
			$dec->bindValue(':cyedireccion', $row->legconyuge_direccion, PDO::PARAM_STR);
			$dec->bindValue(':cyedirecnro', $row->legconyuge_direcnro, PDO::PARAM_STR);
			$dec->bindValue(':cyedirecpiso', $row->legconyuge_direcpiso, PDO::PARAM_STR);
			$dec->bindValue(':cyecelular', $row->legconyuge_celular, PDO::PARAM_STR);
			$dec->bindValue(':cyetelfono', $row->legconyuge_telefono, PDO::PARAM_STR);
			$dec->bindValue(':cyeemail', $row->legconyuge_email, PDO::PARAM_STR);
			$dec->bindValue(':cyepais', $row->pais_id, PDO::PARAM_STR);
			$dec->bindValue(':cyeprovincia', $row->provincia_id, PDO::PARAM_STR);
			$dec->bindValue(':cyedepartamento', $row->departamento_id, PDO::PARAM_STR);
			$dec->bindValue(':cyelocalidad', $row->localidad_id, PDO::PARAM_STR);
			$dec->bindValue(':cyecpostal', $row->legconyuge_codpostal, PDO::PARAM_STR);
			$dec->bindValue(':cyeactivo', $row->legconyuge_activo, PDO::PARAM_STR);
			$dec->bindValue(':cyeippublica', $ippublica, PDO::PARAM_STR);
			$dec->bindValue(':cyepcnombre', $pcnombre, PDO::PARAM_STR);
			$dec->bindValue(':cyepcinformacion', $pcinformacion, PDO::PARAM_STR);
			$dec->bindValue(':cyeusuario', $usuario, PDO::PARAM_STR);
			$dec->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ConyugeDomicilioActualizarExe($data){
		try{

			$sql = 'UPDATE legajos_conyuge SET legconyuge_direccion = ?,
																				 legconyuge_direcnro = ?,
																				 legconyuge_direcpiso = ?,
																				 pais_id = ?,
																				 provincia_id = ?,
																				 departamento_id = ?,
																				 localidad_id = ?,
																				 legconyuge_codpostal = ?
																	 WHERE legconyuge_id = ?
																	 	 AND legempleado_nrodocto = ?';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $data->Cyedireccion, PDO::PARAM_STR);
			$dec->bindValue(2, $data->Cyedirecnro, PDO::PARAM_STR);
			$dec->bindValue(3, $data->Cyedirecpiso, PDO::PARAM_STR);
			$dec->bindValue(4, $data->Cyepais, PDO::PARAM_STR);
			$dec->bindValue(5, $data->Cyeprovincia, PDO::PARAM_STR);
			$dec->bindValue(6, $data->Cyedepartamento, PDO::PARAM_STR);
			$dec->bindValue(7, $data->Cyelocalidad, PDO::PARAM_STR);
			$dec->bindValue(8, $data->Cyecpostal, PDO::PARAM_STR);
			$dec->bindValue(9, $data->Cyeid, PDO::PARAM_STR);
			$dec->bindValue(10, $data->Empnrodocumento, PDO::PARAM_STR);
			$dec->execute();

			// ---------------Insert auditoria  conyuge ------------
			$sql = 'SELECT *
								FROM legajos_conyuge
							 WHERE legconyuge_id = ?
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $data->Cyeid, PDO::PARAM_STR);
			$dec->execute();
			$row = $dec->fetch(PDO::FETCH_OBJ);
			//------------Datos para auditoria ----------
			$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];
			$ippublica = $_SERVER["REMOTE_ADDR"];
			$pcnombre = gethostbyaddr($_SERVER['REMOTE_ADDR']);
			$pcinformacion = $_SERVER['HTTP_USER_AGENT'];

			$sql ='INSERT INTO aud_legajos_conyuge (AUD_legconyuge_id,
																						  AUD_legempleado_nrodocto,
																							AUD_legconyuge_tipodocto,
																							AUD_legconyuge_nrodocto,
																							AUD_legconyuge_nrocuil,
																							AUD_legconyuge_apellido,
																							AUD_legconyuge_nombres,
																							AUD_sexo_id,
																							AUD_legconyuge_fecnacto,
																							AUD_legconyuge_direccion,
																							AUD_legconyuge_direcnro,
																							AUD_legconyuge_direcpiso,
																							AUD_legconyuge_celular,
																							AUD_legconyuge_telefono,
																							AUD_legconyuge_email,
																							AUD_pais_id,
																							AUD_provincia_id,
																							AUD_departamento_id,
																							AUD_localidad_id,
																							AUD_legconyuge_codpostal,
																							AUD_legconyuge_activo,
																							AUD_legconyuge_observacion,
																							AUD_legconyuge_ippublica,
																							AUD_legconyuge_pcnombre,
																							AUD_legconyuge_pcinformacion,
																							AUD_legconyuge_accion,
																							AUD_legconyuge_datetime,
																							AUD_legconyuge_usuario)
																			VALUES (:cyeid,
																			 			  :empndoc,
																						  :cyetdoc,
																						  :cyendoc,
																						  :cyencuil,
																						  :cyeapellido,
																						  :cyenombres,
																						  :cyesexo,
																						  :cyefecnac,
																						  :cyedireccion,
																						  :cyedirecnro,
																						  :cyedirecpiso,
																						  :cyecelular,
																						  :cyetelfono,
																						  :cyeemail,
																						  :cyepais,
																						  :cyeprovincia,
																						  :cyedepartamento,
																						  :cyelocalidad,
																						  :cyecpostal,
																						  :cyeactivo,
																						  "",
																						  :cyeippublica,
																						  :cyepcnombre,
																						  :cyepcinformacion,
																						  "UPDATE",
																						  NOW(),
																						  :cyeusuario)';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(':cyeid', $row->legconyuge_id, PDO::PARAM_STR);
			$dec->bindValue(':empndoc', $row->legempleado_nrodocto, PDO::PARAM_STR);
			$dec->bindValue(':cyetdoc', $row->legconyuge_tipodocto, PDO::PARAM_STR);
			$dec->bindValue(':cyendoc', $row->legconyuge_nrodocto, PDO::PARAM_STR);
			$dec->bindValue(':cyencuil', $row->legconyuge_nrocuil, PDO::PARAM_STR);
			$dec->bindValue(':cyeapellido', $row->legconyuge_apellido, PDO::PARAM_STR);
			$dec->bindValue(':cyenombres', $row->legconyuge_nombres, PDO::PARAM_STR);
			$dec->bindValue(':cyesexo', $row->sexo_id, PDO::PARAM_STR);
			$dec->bindValue(':cyefecnac', $row->legconyuge_fecnacto, PDO::PARAM_STR);
			$dec->bindValue(':cyedireccion', $row->legconyuge_direccion, PDO::PARAM_STR);
			$dec->bindValue(':cyedirecnro', $row->legconyuge_direcnro, PDO::PARAM_STR);
			$dec->bindValue(':cyedirecpiso', $row->legconyuge_direcpiso, PDO::PARAM_STR);
			$dec->bindValue(':cyecelular', $row->legconyuge_celular, PDO::PARAM_STR);
			$dec->bindValue(':cyetelfono', $row->legconyuge_telefono, PDO::PARAM_STR);
			$dec->bindValue(':cyeemail', $row->legconyuge_email, PDO::PARAM_STR);
			$dec->bindValue(':cyepais', $row->pais_id, PDO::PARAM_STR);
			$dec->bindValue(':cyeprovincia', $row->provincia_id, PDO::PARAM_STR);
			$dec->bindValue(':cyedepartamento', $row->departamento_id, PDO::PARAM_STR);
			$dec->bindValue(':cyelocalidad', $row->localidad_id, PDO::PARAM_STR);
			$dec->bindValue(':cyecpostal', $row->legconyuge_codpostal, PDO::PARAM_STR);
			$dec->bindValue(':cyeactivo', $row->legconyuge_activo, PDO::PARAM_STR);
			$dec->bindValue(':cyeippublica', $ippublica, PDO::PARAM_STR);
			$dec->bindValue(':cyepcnombre', $pcnombre, PDO::PARAM_STR);
			$dec->bindValue(':cyepcinformacion', $pcinformacion, PDO::PARAM_STR);
			$dec->bindValue(':cyeusuario', $usuario, PDO::PARAM_STR);
			$dec->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ConyugeContactoActualizarExe($data){
		try{

			$sql = 'UPDATE legajos_conyuge SET legconyuge_celular = ?,
																				 legconyuge_telefono = ?,
																				 legconyuge_email = ?
																	 WHERE legconyuge_id = ?';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $data->Cyecelular, PDO::PARAM_STR);
			$dec->bindValue(2, $data->Cyetelefono, PDO::PARAM_STR);
			$dec->bindValue(3, $data->Cyeemail, PDO::PARAM_STR);
			$dec->bindValue(4, $data->Cyeid, PDO::PARAM_STR);
			$dec->execute();
			// ---------------Insert auditoria  conyuge ------------
			$sql = 'SELECT *
								FROM legajos_conyuge
							 WHERE legconyuge_id = ?
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $data->Cyeid, PDO::PARAM_STR);
			$dec->execute();
			$row = $dec->fetch(PDO::FETCH_OBJ);
			//------------Datos para auditoria ----------
			$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];
			$ippublica = $_SERVER["REMOTE_ADDR"];
			$pcnombre = gethostbyaddr($_SERVER['REMOTE_ADDR']);
			$pcinformacion = $_SERVER['HTTP_USER_AGENT'];

			$sql ='INSERT INTO aud_legajos_conyuge (AUD_legconyuge_id,
																						  AUD_legempleado_nrodocto,
																							AUD_legconyuge_tipodocto,
																							AUD_legconyuge_nrodocto,
																							AUD_legconyuge_nrocuil,
																							AUD_legconyuge_apellido,
																							AUD_legconyuge_nombres,
																							AUD_sexo_id,
																							AUD_legconyuge_fecnacto,
																							AUD_legconyuge_direccion,
																							AUD_legconyuge_direcnro,
																							AUD_legconyuge_direcpiso,
																							AUD_legconyuge_celular,
																							AUD_legconyuge_telefono,
																							AUD_legconyuge_email,
																							AUD_pais_id,
																							AUD_provincia_id,
																							AUD_departamento_id,
																							AUD_localidad_id,
																							AUD_legconyuge_codpostal,
																							AUD_legconyuge_activo,
																							AUD_legconyuge_observacion,
																							AUD_legconyuge_ippublica,
																							AUD_legconyuge_pcnombre,
																							AUD_legconyuge_pcinformacion,
																							AUD_legconyuge_accion,
																							AUD_legconyuge_datetime,
																							AUD_legconyuge_usuario)
																			VALUES (:cyeid,
																			 			  :empndoc,
																						  :cyetdoc,
																						  :cyendoc,
																						  :cyencuil,
																						  :cyeapellido,
																						  :cyenombres,
																						  :cyesexo,
																						  :cyefecnac,
																						  :cyedireccion,
																						  :cyedirecnro,
																						  :cyedirecpiso,
																						  :cyecelular,
																						  :cyetelfono,
																						  :cyeemail,
																						  :cyepais,
																						  :cyeprovincia,
																						  :cyedepartamento,
																						  :cyelocalidad,
																						  :cyecpostal,
																						  :cyeactivo,
																						  "",
																						  :cyeippublica,
																						  :cyepcnombre,
																						  :cyepcinformacion,
																						  "UPDATE",
																						  NOW(),
																						  :cyeusuario)';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(':cyeid', $row->legconyuge_id, PDO::PARAM_STR);
			$dec->bindValue(':empndoc', $row->legempleado_nrodocto, PDO::PARAM_STR);
			$dec->bindValue(':cyetdoc', $row->legconyuge_tipodocto, PDO::PARAM_STR);
			$dec->bindValue(':cyendoc', $row->legconyuge_nrodocto, PDO::PARAM_STR);
			$dec->bindValue(':cyencuil', $row->legconyuge_nrocuil, PDO::PARAM_STR);
			$dec->bindValue(':cyeapellido', $row->legconyuge_apellido, PDO::PARAM_STR);
			$dec->bindValue(':cyenombres', $row->legconyuge_nombres, PDO::PARAM_STR);
			$dec->bindValue(':cyesexo', $row->sexo_id, PDO::PARAM_STR);
			$dec->bindValue(':cyefecnac', $row->legconyuge_fecnacto, PDO::PARAM_STR);
			$dec->bindValue(':cyedireccion', $row->legconyuge_direccion, PDO::PARAM_STR);
			$dec->bindValue(':cyedirecnro', $row->legconyuge_direcnro, PDO::PARAM_STR);
			$dec->bindValue(':cyedirecpiso', $row->legconyuge_direcpiso, PDO::PARAM_STR);
			$dec->bindValue(':cyecelular', $row->legconyuge_celular, PDO::PARAM_STR);
			$dec->bindValue(':cyetelfono', $row->legconyuge_telefono, PDO::PARAM_STR);
			$dec->bindValue(':cyeemail', $row->legconyuge_email, PDO::PARAM_STR);
			$dec->bindValue(':cyepais', $row->pais_id, PDO::PARAM_STR);
			$dec->bindValue(':cyeprovincia', $row->provincia_id, PDO::PARAM_STR);
			$dec->bindValue(':cyedepartamento', $row->departamento_id, PDO::PARAM_STR);
			$dec->bindValue(':cyelocalidad', $row->localidad_id, PDO::PARAM_STR);
			$dec->bindValue(':cyecpostal', $row->legconyuge_codpostal, PDO::PARAM_STR);
			$dec->bindValue(':cyeactivo', $row->legconyuge_activo, PDO::PARAM_STR);
			$dec->bindValue(':cyeippublica', $ippublica, PDO::PARAM_STR);
			$dec->bindValue(':cyepcnombre', $pcnombre, PDO::PARAM_STR);
			$dec->bindValue(':cyepcinformacion', $pcinformacion, PDO::PARAM_STR);
			$dec->bindValue(':cyeusuario', $usuario, PDO::PARAM_STR);
			$dec->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ConyugeBajaExe($data){
		try{

			$sql = 'UPDATE legajos_conyuge SET	legconyuge_activo = 0
																		WHERE legconyuge_id = ?';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $data->Cyeid, PDO::PARAM_STR);
			$dec->execute();
			// ---------------Insert auditoria  conyuge ------------
			$sql = 'SELECT *
								FROM legajos_conyuge
							 WHERE legconyuge_id = ?
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $data->Cyeid, PDO::PARAM_STR);
			$dec->execute();
			$row = $dec->fetch(PDO::FETCH_OBJ);
			//------------Datos para auditoria ----------
			$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];
			$ippublica = $_SERVER["REMOTE_ADDR"];
			$pcnombre = gethostbyaddr($_SERVER['REMOTE_ADDR']);
			$pcinformacion = $_SERVER['HTTP_USER_AGENT'];

			$sql ='INSERT INTO aud_legajos_conyuge (AUD_legconyuge_id,
																						  AUD_legempleado_nrodocto,
																							AUD_legconyuge_tipodocto,
																							AUD_legconyuge_nrodocto,
																							AUD_legconyuge_nrocuil,
																							AUD_legconyuge_apellido,
																							AUD_legconyuge_nombres,
																							AUD_sexo_id,
																							AUD_legconyuge_fecnacto,
																							AUD_legconyuge_direccion,
																							AUD_legconyuge_direcnro,
																							AUD_legconyuge_direcpiso,
																							AUD_legconyuge_celular,
																							AUD_legconyuge_telefono,
																							AUD_legconyuge_email,
																							AUD_pais_id,
																							AUD_provincia_id,
																							AUD_departamento_id,
																							AUD_localidad_id,
																							AUD_legconyuge_codpostal,
																							AUD_legconyuge_activo,
																							AUD_legconyuge_observacion,
																							AUD_legconyuge_ippublica,
																							AUD_legconyuge_pcnombre,
																							AUD_legconyuge_pcinformacion,
																							AUD_legconyuge_accion,
																							AUD_legconyuge_datetime,
																							AUD_legconyuge_usuario)
																			VALUES (:cyeid,
																			 			  :empndoc,
																						  :cyetdoc,
																						  :cyendoc,
																						  :cyencuil,
																						  :cyeapellido,
																						  :cyenombres,
																						  :cyesexo,
																						  :cyefecnac,
																						  :cyedireccion,
																						  :cyedirecnro,
																						  :cyedirecpiso,
																						  :cyecelular,
																						  :cyetelfono,
																						  :cyeemail,
																						  :cyepais,
																						  :cyeprovincia,
																						  :cyedepartamento,
																						  :cyelocalidad,
																						  :cyecpostal,
																						  :cyeactivo,
																						  "",
																						  :cyeippublica,
																						  :cyepcnombre,
																						  :cyepcinformacion,
																						  "DISABLE",
																						  NOW(),
																						  :cyeusuario)';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(':cyeid', $row->legconyuge_id, PDO::PARAM_STR);
			$dec->bindValue(':empndoc', $row->legempleado_nrodocto, PDO::PARAM_STR);
			$dec->bindValue(':cyetdoc', $row->legconyuge_tipodocto, PDO::PARAM_STR);
			$dec->bindValue(':cyendoc', $row->legconyuge_nrodocto, PDO::PARAM_STR);
			$dec->bindValue(':cyencuil', $row->legconyuge_nrocuil, PDO::PARAM_STR);
			$dec->bindValue(':cyeapellido', $row->legconyuge_apellido, PDO::PARAM_STR);
			$dec->bindValue(':cyenombres', $row->legconyuge_nombres, PDO::PARAM_STR);
			$dec->bindValue(':cyesexo', $row->sexo_id, PDO::PARAM_STR);
			$dec->bindValue(':cyefecnac', $row->legconyuge_fecnacto, PDO::PARAM_STR);
			$dec->bindValue(':cyedireccion', $row->legconyuge_direccion, PDO::PARAM_STR);
			$dec->bindValue(':cyedirecnro', $row->legconyuge_direcnro, PDO::PARAM_STR);
			$dec->bindValue(':cyedirecpiso', $row->legconyuge_direcpiso, PDO::PARAM_STR);
			$dec->bindValue(':cyecelular', $row->legconyuge_celular, PDO::PARAM_STR);
			$dec->bindValue(':cyetelfono', $row->legconyuge_telefono, PDO::PARAM_STR);
			$dec->bindValue(':cyeemail', $row->legconyuge_email, PDO::PARAM_STR);
			$dec->bindValue(':cyepais', $row->pais_id, PDO::PARAM_STR);
			$dec->bindValue(':cyeprovincia', $row->provincia_id, PDO::PARAM_STR);
			$dec->bindValue(':cyedepartamento', $row->departamento_id, PDO::PARAM_STR);
			$dec->bindValue(':cyelocalidad', $row->localidad_id, PDO::PARAM_STR);
			$dec->bindValue(':cyecpostal', $row->legconyuge_codpostal, PDO::PARAM_STR);
			$dec->bindValue(':cyeactivo', $row->legconyuge_activo, PDO::PARAM_STR);
			$dec->bindValue(':cyeippublica', $ippublica, PDO::PARAM_STR);
			$dec->bindValue(':cyepcnombre', $pcnombre, PDO::PARAM_STR);
			$dec->bindValue(':cyepcinformacion', $pcinformacion, PDO::PARAM_STR);
			$dec->bindValue(':cyeusuario', $usuario, PDO::PARAM_STR);
			$dec->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}

	public function ObtenerHijosMenores($empleadonrodocto, $fechaactual, $fechafinal){
		try{
			$sql = 'SELECT *
								FROM legajos_hijo
							 WHERE legempleado_nrodocto = ?
							 	 AND leghijo_esc != 1
								 AND leghijo_disc != 1
								 AND leghijo_estado != 2
								 AND leghijo_activo = 1
								 AND leghijo_fecnacto
						 BETWEEN ?
						 		 AND ?
						ORDER BY leghijo_fecnacto DESC';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $empleadonrodocto, PDO::PARAM_STR);
			$dec->bindValue(2, $fechafinal, PDO::PARAM_STR);
			$dec->bindValue(3, $fechaactual, PDO::PARAM_STR);
			$dec->execute();

			return $dec->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerHijosMenoresOB($empleadonrodocto, $fechaactual, $fechafinal){
		try{
			$sql = 'SELECT *
								FROM legajos_hijo
							 WHERE legempleado_nrodocto = ?
							 	 AND legempleado_nrodocto != leghijo_benndoc
							 	 AND leghijo_esc != 1
								 AND leghijo_disc != 1
								 AND leghijo_estado != 2
								 AND leghijo_activo = 1
								 AND leghijo_fecnacto
						 BETWEEN ?
						 		 AND ?';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $empleadonrodocto, PDO::PARAM_STR);
			$dec->bindValue(2, $fechafinal, PDO::PARAM_STR);
			$dec->bindValue(3, $fechaactual, PDO::PARAM_STR);
			$dec->execute();

			return $dec->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function HijoGuardarExe($data){
		try{

			$sql = 'INSERT INTO legajos_hijo (legempleado_nrodocto,
																				legempleado_id_ben,
																				leghijo_benndoc,
																				leghijo_bennoficio,
																				leghijo_benapellido,
																				leghijo_bennombres,
																				leghijo_mopndoc,
																				leghijo_mopapellido,
																				leghijo_mopnombres,
																				leghijo_nrodocto,
																				leghijo_nrocuil,
																				leghijo_apellido,
																				leghijo_nombres,
																				sexo_id,
																				leghijo_fecnacto,
																				leghijo_direccion,
																				leghijo_direcnro,
																				leghijo_direcpiso,
																				pais_id,
																				provincia_id,
																				departamento_id,
																				localidad_id,
																				leghijo_codpostal,
																				leghijo_disc,
																				leghijo_esc,
																				escuela_id,
																				escnivel_id,
																				escestado_id,
																				leghijo_estado,
																				leghijo_activo)
																 VALUES(:empndoc,
																	 			0,
																				:benndoc,
																				"",
																				:benap,
																				:bennom,
																				0,
																				"",
																				"",
																				:hjondoc,
																				:hjoncuil,
																				:hjoapellido,
																				:hjonombres,
																				:hjosexo,
																				:hjofecnac,
																				:hjodirec,
																				:hjodirecnro,
																				:hjodirecpiso,
																				:hjopais,
																				:hjoprovincia,
																				:hjodepto,
																				:hjolocalidad,
																				:hjocpostal,
																				:hjodisc,
																				0,
																				0,
																				0,
																				0,
																				1,
																				1)';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(':empndoc', $data->Empnrodocto, PDO::PARAM_STR);
			$dec->bindValue(':benndoc', $data->Empnrodocto, PDO::PARAM_STR);
			$dec->bindValue(':benap', $data->Hjobenapellido, PDO::PARAM_STR);
			$dec->bindValue(':bennom', $data->Hjobennombres, PDO::PARAM_STR);
			$dec->bindValue(':hjondoc', $data->Hjondoc, PDO::PARAM_STR);
			$dec->bindValue(':hjoncuil', $data->Hjonrocuil, PDO::PARAM_STR);
			$dec->bindValue(':hjoapellido', $data->Hjoapellido, PDO::PARAM_STR);
			$dec->bindValue(':hjonombres', $data->Hjonombres, PDO::PARAM_STR);
			$dec->bindValue(':hjosexo', $data->Hjosexo, PDO::PARAM_STR);
			$dec->bindValue(':hjofecnac', $data->Hjofecnacto, PDO::PARAM_STR);
			$dec->bindValue(':hjodirec', $data->Hjodireccion, PDO::PARAM_STR);
			$dec->bindValue(':hjodirecnro', $data->Hjodirecnro, PDO::PARAM_STR);
			$dec->bindValue(':hjodirecpiso', $data->Hjodirecpiso, PDO::PARAM_STR);
			$dec->bindValue(':hjopais', $data->Hjopais, PDO::PARAM_STR);
			$dec->bindValue(':hjoprovincia', $data->Hjoprovincia, PDO::PARAM_STR);
			$dec->bindValue(':hjodepto', $data->Hjodepartamento, PDO::PARAM_STR);
			$dec->bindValue(':hjolocalidad', $data->Hjolocalidad, PDO::PARAM_STR);
			$dec->bindValue(':hjocpostal', $data->Hjocodpostal, PDO::PARAM_STR);
			$dec->bindValue(':hjodisc', $data->Hjodisc, PDO::PARAM_STR);
			$dec->execute();
			//----------------obtner ultimo id Insertado -----------
			$ultimoid = $this->cn->lastInsertId();
			// ---------------Insert auditoria Hijos ------------
			$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];
			$ippublica = $_SERVER["REMOTE_ADDR"];
			$pcnombre = gethostbyaddr($_SERVER['REMOTE_ADDR']);
			$pcinformacion = $_SERVER['HTTP_USER_AGENT'];

			$sql ='INSERT INTO legajos_hijo_aud (AUD_leghijo_id,
																					 AUD_legempleado_nrodocto,
																					 AUD_legempleado_id_ben,
																					 AUD_leghijo_bentdoc,
																					 AUD_leghijo_benndoc,
																					 AUD_leghijo_bennoficio,
																					 AUD_leghijo_benapellido,
																					 AUD_leghijo_bennombres,
																					 AUD_leghijo_moptdoc,
																					 AUD_leghijo_mopndoc,
																					 AUD_leghijo_mopapellido,
																					 AUD_leghijo_mopnombres,
																					 AUD_leghijo_tipodocto,
																					 AUD_leghijo_nrodocto,
																					 AUD_leghijo_nrocuil,
																					 AUD_leghijo_apellido,
																					 AUD_leghijo_nombres,
																					 AUD_sexo_id,
																					 AUD_leghijo_fecnacto,
																					 AUD_leghijo_direccion,
																					 AUD_leghijo_direcnro,
																					 AUD_leghijo_direcpiso,
																					 AUD_pais_id,
																					 AUD_provincia_id,
																					 AUD_departamento_id,
																					 AUD_localidad_id,
																					 AUD_leghijo_codpostal,
																					 AUD_leghijo_disc,
																					 AUD_leghijo_esc,
																					 AUD_escuela_id,
																					 AUD_escnivel_id,
																					 AUD_escestado_id,
																					 AUD_leghijo_estado,
																					 AUD_leghijo_activo,
																					 AUD_leghijo_ippublica,
																					 AUD_leghijo_pcnombre,
																					 AUD_leghijo_pcinformacion,
																					 AUD_leghijo_accion,
																					 AUD_leghijo_observacion,
																					 AUD_leghijo_datetime,
																					 AUD_leghijo_usuario)
																	 VALUES (?,
																		 			 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 1,
																					 1,
																					 ?,
																					 ?,
																					 ?,
																					 "INSERT",
																					 "",
																					 NOW(),
																					 ?)';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $ultimoid, PDO::PARAM_STR);
			$dec->bindValue(2, $data->Empnrodocto, PDO::PARAM_STR);
			$dec->bindValue(3, 0, PDO::PARAM_STR);
			$dec->bindValue(4, "", PDO::PARAM_STR);
			$dec->bindValue(5, $data->Empnrodocto, PDO::PARAM_STR);
			$dec->bindValue(6, "", PDO::PARAM_STR);
			$dec->bindValue(7, $data->Hjobenapellido, PDO::PARAM_STR);
			$dec->bindValue(8, $data->Hjobennombres, PDO::PARAM_STR);
			$dec->bindValue(9, "", PDO::PARAM_STR);
			$dec->bindValue(10, 0, PDO::PARAM_STR);
			$dec->bindValue(11, "", PDO::PARAM_STR);
			$dec->bindValue(12, "", PDO::PARAM_STR);
			$dec->bindValue(13, "", PDO::PARAM_STR);
			$dec->bindValue(14, $data->Hjondoc, PDO::PARAM_STR);
			$dec->bindValue(15, $data->Hjonrocuil, PDO::PARAM_STR);
			$dec->bindValue(16, $data->Hjoapellido, PDO::PARAM_STR);
			$dec->bindValue(17, $data->Hjonombres, PDO::PARAM_STR);
			$dec->bindValue(18, $data->Hjosexo, PDO::PARAM_STR);
			$dec->bindValue(19, $data->Hjofecnacto, PDO::PARAM_STR);
			$dec->bindValue(20, $data->Hjodireccion, PDO::PARAM_STR);
			$dec->bindValue(21, $data->Hjodirecnro, PDO::PARAM_STR);
			$dec->bindValue(22, $data->Hjodirecpiso, PDO::PARAM_STR);
			$dec->bindValue(23, $data->Hjopais, PDO::PARAM_STR);
			$dec->bindValue(24, $data->Hjoprovincia, PDO::PARAM_STR);
			$dec->bindValue(25, $data->Hjodepartamento, PDO::PARAM_STR);
			$dec->bindValue(26, $data->Hjolocalidad, PDO::PARAM_STR);
			$dec->bindValue(27, $data->Hjocodpostal, PDO::PARAM_STR);
			$dec->bindValue(28, $data->Hjodisc, PDO::PARAM_STR);
			$dec->bindValue(29, 0, PDO::PARAM_STR);
			$dec->bindValue(30, 0, PDO::PARAM_STR);
			$dec->bindValue(31, 0, PDO::PARAM_STR);
			$dec->bindValue(32, 0, PDO::PARAM_STR);
			$dec->bindValue(33, $ippublica, PDO::PARAM_STR);
			$dec->bindValue(34, $pcnombre, PDO::PARAM_STR);
			$dec->bindValue(35, $pcinformacion, PDO::PARAM_STR);
			$dec->bindValue(36, $usuario, PDO::PARAM_STR);
			$dec->execute();
			return $ultimoid;
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function HijoActualizarExe($data){
		try{

			$sql = 'UPDATE legajos_hijo SET leghijo_nrodocto = ?,
																			leghijo_nrocuil = ?,
																			leghijo_apellido = ?,
																			leghijo_nombres = ?,
																			sexo_id = ?,
																			leghijo_fecnacto = ?,
																			leghijo_direccion = ?,
																			leghijo_direcnro = ?,
																			leghijo_direcpiso = ?,
																			pais_id = ?,
																			provincia_id = ?,
																			departamento_id = ?,
																			localidad_id = ?,
																			leghijo_codpostal = ?,
																			leghijo_disc = ?,
																			leghijo_activo = 1
																WHERE leghijo_id = ?';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Hjondoc, PDO::PARAM_STR);
			$stm->bindValue(2, $data->Hjonrocuil, PDO::PARAM_STR);
			$stm->bindValue(3, $data->Hjoapellido, PDO::PARAM_STR);
			$stm->bindValue(4, $data->Hjonombres, PDO::PARAM_STR);
			$stm->bindValue(5, $data->Hjosexo, PDO::PARAM_STR);
			$stm->bindValue(6, $data->Hjofecnacto, PDO::PARAM_STR);
			$stm->bindValue(7, $data->Hjodireccion, PDO::PARAM_STR);
			$stm->bindValue(8, $data->Hjodirecnro, PDO::PARAM_STR);
			$stm->bindValue(9, $data->Hjodirecpiso, PDO::PARAM_STR);
			$stm->bindValue(10, $data->Hjopais, PDO::PARAM_STR);
			$stm->bindValue(11, $data->Hjoprovincia, PDO::PARAM_STR);
			$stm->bindValue(12, $data->Hjodepartamento, PDO::PARAM_STR);
			$stm->bindValue(13, $data->Hjolocalidad, PDO::PARAM_STR);
			$stm->bindValue(14, $data->Hjocodpostal, PDO::PARAM_STR);
			$stm->bindValue(15, $data->Hjodisc, PDO::PARAM_STR);
			$stm->bindValue(16, $data->Id, PDO::PARAM_STR);
			$stm->execute();
			//----------Auditoria modificacion de hijos -----
			$sql = 'SELECT *
								FROM legajos_hijo
							 WHERE leghijo_id = ?
							 LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Id, PDO::PARAM_STR);
			$stm->execute();
			$row = $stm->fetch(PDO::FETCH_OBJ);
			//---------- Datos para la auditoria ----------------
			$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];
			$ippublica = $_SERVER["REMOTE_ADDR"];
			$pcnombre = gethostbyaddr($_SERVER['REMOTE_ADDR']);
			$pcinformacion = $_SERVER['HTTP_USER_AGENT'];

			$sql ='INSERT INTO legajos_hijo_aud (AUD_leghijo_id,
																					 AUD_legempleado_nrodocto,
																					 AUD_legempleado_id_ben,
																					 AUD_leghijo_bentdoc,
																					 AUD_leghijo_benndoc,
																					 AUD_leghijo_bennoficio,
																					 AUD_leghijo_benapellido,
																					 AUD_leghijo_bennombres,
																					 AUD_leghijo_moptdoc,
																					 AUD_leghijo_mopndoc,
																					 AUD_leghijo_mopapellido,
																					 AUD_leghijo_mopnombres,
																					 AUD_leghijo_tipodocto,
																					 AUD_leghijo_nrodocto,
																					 AUD_leghijo_nrocuil,
																					 AUD_leghijo_apellido,
																					 AUD_leghijo_nombres,
																					 AUD_sexo_id,
																					 AUD_leghijo_fecnacto,
																					 AUD_leghijo_direccion,
																					 AUD_leghijo_direcnro,
																					 AUD_leghijo_direcpiso,
																					 AUD_pais_id,AUD_provincia_id,
																					 AUD_departamento_id,
																					 AUD_localidad_id,
																					 AUD_leghijo_codpostal,
																					 AUD_leghijo_disc,
																					 AUD_leghijo_esc,
																					 AUD_escuela_id,
																					 AUD_escnivel_id,
																					 AUD_escestado_id,
																					 AUD_leghijo_estado,
																					 AUD_leghijo_activo,
																					 AUD_leghijo_ippublica,
																					 AUD_leghijo_pcnombre,
																					 AUD_leghijo_pcinformacion,
																					 AUD_leghijo_accion,
																					 AUD_leghijo_observacion,
																					 AUD_leghijo_datetime,
																					 AUD_leghijo_usuario)
																	 VALUES (?,
																		 			 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 "UPDATE",
																					 "",
																					 NOW(),
																					 ?)';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $row->leghijo_id, PDO::PARAM_STR);
			$stm->bindValue(2, $row->legempleado_nrodocto, PDO::PARAM_STR);
			$stm->bindValue(3, $row->legempleado_id_ben, PDO::PARAM_STR);
			$stm->bindValue(4, $row->leghijo_bentdoc, PDO::PARAM_STR);
			$stm->bindValue(5, $row->leghijo_benndoc, PDO::PARAM_STR);
			$stm->bindValue(6, $row->leghijo_bennoficio, PDO::PARAM_STR);
			$stm->bindValue(7, $row->leghijo_benapellido, PDO::PARAM_STR);
			$stm->bindValue(8, $row->leghijo_bennombres, PDO::PARAM_STR);
			$stm->bindValue(9, $row->leghijo_moptdoc, PDO::PARAM_STR);
			$stm->bindValue(10, $row->leghijo_mopndoc, PDO::PARAM_STR);
			$stm->bindValue(11, $row->leghijo_mopapellido, PDO::PARAM_STR);
			$stm->bindValue(12, $row->leghijo_mopnombres, PDO::PARAM_STR);
			$stm->bindValue(13, $row->leghijo_tipodocto, PDO::PARAM_STR);
			$stm->bindValue(14, $row->leghijo_nrodocto, PDO::PARAM_STR);
			$stm->bindValue(15, $row->leghijo_nrocuil, PDO::PARAM_STR);
			$stm->bindValue(16, $row->leghijo_apellido, PDO::PARAM_STR);
			$stm->bindValue(17, $row->leghijo_nombres, PDO::PARAM_STR);
			$stm->bindValue(18, $row->sexo_id, PDO::PARAM_STR);
			$stm->bindValue(19, $row->leghijo_fecnacto, PDO::PARAM_STR);
			$stm->bindValue(20, $row->leghijo_direccion, PDO::PARAM_STR);
			$stm->bindValue(21, $row->leghijo_direcnro, PDO::PARAM_STR);
			$stm->bindValue(22, $row->leghijo_direcpiso, PDO::PARAM_STR);
			$stm->bindValue(23, $row->pais_id, PDO::PARAM_STR);
			$stm->bindValue(24, $row->provincia_id, PDO::PARAM_STR);
			$stm->bindValue(25, $row->departamento_id, PDO::PARAM_STR);
			$stm->bindValue(26, $row->localidad_id, PDO::PARAM_STR);
			$stm->bindValue(27, $row->leghijo_codpostal, PDO::PARAM_STR);
			$stm->bindValue(28, $row->leghijo_disc, PDO::PARAM_STR);
			$stm->bindValue(29, $row->leghijo_esc, PDO::PARAM_STR);
			$stm->bindValue(30, $row->escuela_id, PDO::PARAM_STR);
			$stm->bindValue(31, $row->escnivel_id, PDO::PARAM_STR);
			$stm->bindValue(32, $row->escestado_id, PDO::PARAM_STR);
			$stm->bindValue(33, $row->leghijo_estado, PDO::PARAM_STR);
			$stm->bindValue(34, $row->leghijo_activo, PDO::PARAM_STR);
			$stm->bindValue(35, $ippublica, PDO::PARAM_STR);
			$stm->bindValue(36, $pcnombre, PDO::PARAM_STR);
			$stm->bindValue(37, $pcinformacion, PDO::PARAM_STR);
			$stm->bindValue(38, $usuario, PDO::PARAM_STR);
			$stm->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function HijoEscGuardarExe($data){
		try{

			$sql = 'UPDATE legajos_hijo
								 SET leghijo_esc = ?,
								 		 escuela_id = ?,
								 		 escnivel_id = ?
							 WHERE leghijo_id = ?';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, 1, PDO::PARAM_STR);
			$dec->bindValue(2, $data->Hjoescnom, PDO::PARAM_STR);
			$dec->bindValue(3, $data->Hjoescnvl, PDO::PARAM_STR);
			$dec->bindValue(4, $data->HijoId, PDO::PARAM_STR);
			$dec->execute();

			//----------Auditoria modificacion de hijos -----
			$sql = 'SELECT *
								FROM legajos_hijo
							 WHERE leghijo_id = ?
							 LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->HijoId, PDO::PARAM_STR);
			$stm->execute();
			$row = $stm->fetch(PDO::FETCH_OBJ);
			//---------- Datos para la auditoria ----------------
			$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];
			$ippublica = $_SERVER["REMOTE_ADDR"];
			$pcnombre = gethostbyaddr($_SERVER['REMOTE_ADDR']);
			$pcinformacion = $_SERVER['HTTP_USER_AGENT'];

			$sql ='INSERT INTO legajos_hijo_aud (AUD_leghijo_id,
																					 AUD_legempleado_nrodocto,
																					 AUD_legempleado_id_ben,
																					 AUD_leghijo_bentdoc,
																					 AUD_leghijo_benndoc,
																					 AUD_leghijo_bennoficio,
																					 AUD_leghijo_benapellido,
																					 AUD_leghijo_bennombres,
																					 AUD_leghijo_moptdoc,
																					 AUD_leghijo_mopndoc,
																					 AUD_leghijo_mopapellido,
																					 AUD_leghijo_mopnombres,
																					 AUD_leghijo_tipodocto,
																					 AUD_leghijo_nrodocto,
																					 AUD_leghijo_nrocuil,
																					 AUD_leghijo_apellido,
																					 AUD_leghijo_nombres,
																					 AUD_sexo_id,
																					 AUD_leghijo_fecnacto,
																					 AUD_leghijo_direccion,
																					 AUD_leghijo_direcnro,
																					 AUD_leghijo_direcpiso,
																					 AUD_pais_id,AUD_provincia_id,
																					 AUD_departamento_id,
																					 AUD_localidad_id,
																					 AUD_leghijo_codpostal,
																					 AUD_leghijo_disc,
																					 AUD_leghijo_esc,
																					 AUD_escuela_id,
																					 AUD_escnivel_id,
																					 AUD_escestado_id,
																					 AUD_leghijo_estado,
																					 AUD_leghijo_activo,
																					 AUD_leghijo_ippublica,
																					 AUD_leghijo_pcnombre,
																					 AUD_leghijo_pcinformacion,
																					 AUD_leghijo_accion,
																					 AUD_leghijo_observacion,
																					 AUD_leghijo_datetime,
																					 AUD_leghijo_usuario)
																	 VALUES (?,
																		 			 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 "UPDATE",
																					 "",
																					 NOW(),
																					 ?)';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $row->leghijo_id, PDO::PARAM_STR);
			$stm->bindValue(2, $row->legempleado_nrodocto, PDO::PARAM_STR);
			$stm->bindValue(3, $row->legempleado_id_ben, PDO::PARAM_STR);
			$stm->bindValue(4, $row->leghijo_bentdoc, PDO::PARAM_STR);
			$stm->bindValue(5, $row->leghijo_benndoc, PDO::PARAM_STR);
			$stm->bindValue(6, $row->leghijo_bennoficio, PDO::PARAM_STR);
			$stm->bindValue(7, $row->leghijo_benapellido, PDO::PARAM_STR);
			$stm->bindValue(8, $row->leghijo_bennombres, PDO::PARAM_STR);
			$stm->bindValue(9, $row->leghijo_moptdoc, PDO::PARAM_STR);
			$stm->bindValue(10, $row->leghijo_mopndoc, PDO::PARAM_STR);
			$stm->bindValue(11, $row->leghijo_mopapellido, PDO::PARAM_STR);
			$stm->bindValue(12, $row->leghijo_mopnombres, PDO::PARAM_STR);
			$stm->bindValue(13, $row->leghijo_tipodocto, PDO::PARAM_STR);
			$stm->bindValue(14, $row->leghijo_nrodocto, PDO::PARAM_STR);
			$stm->bindValue(15, $row->leghijo_nrocuil, PDO::PARAM_STR);
			$stm->bindValue(16, $row->leghijo_apellido, PDO::PARAM_STR);
			$stm->bindValue(17, $row->leghijo_nombres, PDO::PARAM_STR);
			$stm->bindValue(18, $row->sexo_id, PDO::PARAM_STR);
			$stm->bindValue(19, $row->leghijo_fecnacto, PDO::PARAM_STR);
			$stm->bindValue(20, $row->leghijo_direccion, PDO::PARAM_STR);
			$stm->bindValue(21, $row->leghijo_direcnro, PDO::PARAM_STR);
			$stm->bindValue(22, $row->leghijo_direcpiso, PDO::PARAM_STR);
			$stm->bindValue(23, $row->pais_id, PDO::PARAM_STR);
			$stm->bindValue(24, $row->provincia_id, PDO::PARAM_STR);
			$stm->bindValue(25, $row->departamento_id, PDO::PARAM_STR);
			$stm->bindValue(26, $row->localidad_id, PDO::PARAM_STR);
			$stm->bindValue(27, $row->leghijo_codpostal, PDO::PARAM_STR);
			$stm->bindValue(28, $row->leghijo_disc, PDO::PARAM_STR);
			$stm->bindValue(29, $row->leghijo_esc, PDO::PARAM_STR);
			$stm->bindValue(30, $row->escuela_id, PDO::PARAM_STR);
			$stm->bindValue(31, $row->escnivel_id, PDO::PARAM_STR);
			$stm->bindValue(32, $row->escestado_id, PDO::PARAM_STR);
			$stm->bindValue(33, $row->leghijo_estado, PDO::PARAM_STR);
			$stm->bindValue(34, $row->leghijo_activo, PDO::PARAM_STR);
			$stm->bindValue(35, $ippublica, PDO::PARAM_STR);
			$stm->bindValue(36, $pcnombre, PDO::PARAM_STR);
			$stm->bindValue(37, $pcinformacion, PDO::PARAM_STR);
			$stm->bindValue(38, $usuario, PDO::PARAM_STR);
			$stm->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function HijoBenGuardarExe($data){
		try{

			$sql = 'UPDATE legajos_hijo
								 SET legempleado_id_ben = ?,
								 		 leghijo_benndoc = ?,
								 		 leghijo_bennoficio = ?,
								 		 leghijo_benapellido = ?,
										 leghijo_bennombres = ?
							 WHERE leghijo_id = ?';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $data->Benid, PDO::PARAM_STR);
			$dec->bindValue(2, $data->Hjobenndoc, PDO::PARAM_STR);
			$dec->bindValue(3, $data->Hjobennoficio, PDO::PARAM_STR);
			$dec->bindValue(4, $data->Hjobenapellido, PDO::PARAM_STR);
			$dec->bindValue(5, $data->Hjobennombres, PDO::PARAM_STR);
			$dec->bindValue(6, $data->HijoId, PDO::PARAM_STR);
			$dec->execute();

			//----------Auditoria modificacion de hijos -----
			$sql = 'SELECT *
								FROM legajos_hijo
							 WHERE leghijo_id = ?
							 LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->HijoId, PDO::PARAM_STR);
			$stm->execute();
			$row = $stm->fetch(PDO::FETCH_OBJ);
			//---------- Datos para la auditoria ----------------
			$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];
			$ippublica = $_SERVER["REMOTE_ADDR"];
			$pcnombre = gethostbyaddr($_SERVER['REMOTE_ADDR']);
			$pcinformacion = $_SERVER['HTTP_USER_AGENT'];

			$sql ='INSERT INTO legajos_hijo_aud (AUD_leghijo_id,
																					 AUD_legempleado_nrodocto,
																					 AUD_legempleado_id_ben,
																					 AUD_leghijo_bentdoc,
																					 AUD_leghijo_benndoc,
																					 AUD_leghijo_bennoficio,
																					 AUD_leghijo_benapellido,
																					 AUD_leghijo_bennombres,
																					 AUD_leghijo_moptdoc,
																					 AUD_leghijo_mopndoc,
																					 AUD_leghijo_mopapellido,
																					 AUD_leghijo_mopnombres,
																					 AUD_leghijo_tipodocto,
																					 AUD_leghijo_nrodocto,
																					 AUD_leghijo_nrocuil,
																					 AUD_leghijo_apellido,
																					 AUD_leghijo_nombres,
																					 AUD_sexo_id,
																					 AUD_leghijo_fecnacto,
																					 AUD_leghijo_direccion,
																					 AUD_leghijo_direcnro,
																					 AUD_leghijo_direcpiso,
																					 AUD_pais_id,AUD_provincia_id,
																					 AUD_departamento_id,
																					 AUD_localidad_id,
																					 AUD_leghijo_codpostal,
																					 AUD_leghijo_disc,
																					 AUD_leghijo_esc,
																					 AUD_escuela_id,
																					 AUD_escnivel_id,
																					 AUD_escestado_id,
																					 AUD_leghijo_estado,
																					 AUD_leghijo_activo,
																					 AUD_leghijo_ippublica,
																					 AUD_leghijo_pcnombre,
																					 AUD_leghijo_pcinformacion,
																					 AUD_leghijo_accion,
																					 AUD_leghijo_observacion,
																					 AUD_leghijo_datetime,
																					 AUD_leghijo_usuario)
																	 VALUES (?,
																		 			 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 "UPDATE",
																					 "",
																					 NOW(),
																					 ?)';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $row->leghijo_id, PDO::PARAM_STR);
			$stm->bindValue(2, $row->legempleado_nrodocto, PDO::PARAM_STR);
			$stm->bindValue(3, $row->legempleado_id_ben, PDO::PARAM_STR);
			$stm->bindValue(4, $row->leghijo_bentdoc, PDO::PARAM_STR);
			$stm->bindValue(5, $row->leghijo_benndoc, PDO::PARAM_STR);
			$stm->bindValue(6, $row->leghijo_bennoficio, PDO::PARAM_STR);
			$stm->bindValue(7, $row->leghijo_benapellido, PDO::PARAM_STR);
			$stm->bindValue(8, $row->leghijo_bennombres, PDO::PARAM_STR);
			$stm->bindValue(9, $row->leghijo_moptdoc, PDO::PARAM_STR);
			$stm->bindValue(10, $row->leghijo_mopndoc, PDO::PARAM_STR);
			$stm->bindValue(11, $row->leghijo_mopapellido, PDO::PARAM_STR);
			$stm->bindValue(12, $row->leghijo_mopnombres, PDO::PARAM_STR);
			$stm->bindValue(13, $row->leghijo_tipodocto, PDO::PARAM_STR);
			$stm->bindValue(14, $row->leghijo_nrodocto, PDO::PARAM_STR);
			$stm->bindValue(15, $row->leghijo_nrocuil, PDO::PARAM_STR);
			$stm->bindValue(16, $row->leghijo_apellido, PDO::PARAM_STR);
			$stm->bindValue(17, $row->leghijo_nombres, PDO::PARAM_STR);
			$stm->bindValue(18, $row->sexo_id, PDO::PARAM_STR);
			$stm->bindValue(19, $row->leghijo_fecnacto, PDO::PARAM_STR);
			$stm->bindValue(20, $row->leghijo_direccion, PDO::PARAM_STR);
			$stm->bindValue(21, $row->leghijo_direcnro, PDO::PARAM_STR);
			$stm->bindValue(22, $row->leghijo_direcpiso, PDO::PARAM_STR);
			$stm->bindValue(23, $row->pais_id, PDO::PARAM_STR);
			$stm->bindValue(24, $row->provincia_id, PDO::PARAM_STR);
			$stm->bindValue(25, $row->departamento_id, PDO::PARAM_STR);
			$stm->bindValue(26, $row->localidad_id, PDO::PARAM_STR);
			$stm->bindValue(27, $row->leghijo_codpostal, PDO::PARAM_STR);
			$stm->bindValue(28, $row->leghijo_disc, PDO::PARAM_STR);
			$stm->bindValue(29, $row->leghijo_esc, PDO::PARAM_STR);
			$stm->bindValue(30, $row->escuela_id, PDO::PARAM_STR);
			$stm->bindValue(31, $row->escnivel_id, PDO::PARAM_STR);
			$stm->bindValue(32, $row->escestado_id, PDO::PARAM_STR);
			$stm->bindValue(33, $row->leghijo_estado, PDO::PARAM_STR);
			$stm->bindValue(34, $row->leghijo_activo, PDO::PARAM_STR);
			$stm->bindValue(35, $ippublica, PDO::PARAM_STR);
			$stm->bindValue(36, $pcnombre, PDO::PARAM_STR);
			$stm->bindValue(37, $pcinformacion, PDO::PARAM_STR);
			$stm->bindValue(38, $usuario, PDO::PARAM_STR);
			$stm->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function HijoMoPGuardarExe($data){
		try{

			$sql = 'UPDATE legajos_hijo
								 SET leghijo_mopndoc = ?,
								 		 leghijo_mopapellido = ?,
										 leghijo_mopnombres = ?
							 WHERE leghijo_id = ?';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $data->Hjomopndoc, PDO::PARAM_STR);
			$dec->bindValue(2, $data->Hjomopapellido, PDO::PARAM_STR);
			$dec->bindValue(3, $data->Hjomopnombres, PDO::PARAM_STR);
			$dec->bindValue(4, $data->HijoId, PDO::PARAM_STR);
			$dec->execute();

			//----------Auditoria modificacion de hijos -----
			$sql = 'SELECT *
								FROM legajos_hijo
							 WHERE leghijo_id = ?
							 LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->HijoId, PDO::PARAM_STR);
			$stm->execute();
			$row = $stm->fetch(PDO::FETCH_OBJ);
			//---------- Datos para la auditoria ----------------
			$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];
			$ippublica = $_SERVER["REMOTE_ADDR"];
			$pcnombre = gethostbyaddr($_SERVER['REMOTE_ADDR']);
			$pcinformacion = $_SERVER['HTTP_USER_AGENT'];

			$sql ='INSERT INTO legajos_hijo_aud (AUD_leghijo_id,
																					 AUD_legempleado_nrodocto,
																					 AUD_legempleado_id_ben,
																					 AUD_leghijo_bentdoc,
																					 AUD_leghijo_benndoc,
																					 AUD_leghijo_bennoficio,
																					 AUD_leghijo_benapellido,
																					 AUD_leghijo_bennombres,
																					 AUD_leghijo_moptdoc,
																					 AUD_leghijo_mopndoc,
																					 AUD_leghijo_mopapellido,
																					 AUD_leghijo_mopnombres,
																					 AUD_leghijo_tipodocto,
																					 AUD_leghijo_nrodocto,
																					 AUD_leghijo_nrocuil,
																					 AUD_leghijo_apellido,
																					 AUD_leghijo_nombres,
																					 AUD_sexo_id,
																					 AUD_leghijo_fecnacto,
																					 AUD_leghijo_direccion,
																					 AUD_leghijo_direcnro,
																					 AUD_leghijo_direcpiso,
																					 AUD_pais_id,AUD_provincia_id,
																					 AUD_departamento_id,
																					 AUD_localidad_id,
																					 AUD_leghijo_codpostal,
																					 AUD_leghijo_disc,
																					 AUD_leghijo_esc,
																					 AUD_escuela_id,
																					 AUD_escnivel_id,
																					 AUD_escestado_id,
																					 AUD_leghijo_estado,
																					 AUD_leghijo_activo,
																					 AUD_leghijo_ippublica,
																					 AUD_leghijo_pcnombre,
																					 AUD_leghijo_pcinformacion,
																					 AUD_leghijo_accion,
																					 AUD_leghijo_observacion,
																					 AUD_leghijo_datetime,
																					 AUD_leghijo_usuario)
																	 VALUES (?,
																		 			 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 "UPDATE",
																					 "",
																					 NOW(),
																					 ?)';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $row->leghijo_id, PDO::PARAM_STR);
			$stm->bindValue(2, $row->legempleado_nrodocto, PDO::PARAM_STR);
			$stm->bindValue(3, $row->legempleado_id_ben, PDO::PARAM_STR);
			$stm->bindValue(4, $row->leghijo_bentdoc, PDO::PARAM_STR);
			$stm->bindValue(5, $row->leghijo_benndoc, PDO::PARAM_STR);
			$stm->bindValue(6, $row->leghijo_bennoficio, PDO::PARAM_STR);
			$stm->bindValue(7, $row->leghijo_benapellido, PDO::PARAM_STR);
			$stm->bindValue(8, $row->leghijo_bennombres, PDO::PARAM_STR);
			$stm->bindValue(9, $row->leghijo_moptdoc, PDO::PARAM_STR);
			$stm->bindValue(10, $row->leghijo_mopndoc, PDO::PARAM_STR);
			$stm->bindValue(11, $row->leghijo_mopapellido, PDO::PARAM_STR);
			$stm->bindValue(12, $row->leghijo_mopnombres, PDO::PARAM_STR);
			$stm->bindValue(13, $row->leghijo_tipodocto, PDO::PARAM_STR);
			$stm->bindValue(14, $row->leghijo_nrodocto, PDO::PARAM_STR);
			$stm->bindValue(15, $row->leghijo_nrocuil, PDO::PARAM_STR);
			$stm->bindValue(16, $row->leghijo_apellido, PDO::PARAM_STR);
			$stm->bindValue(17, $row->leghijo_nombres, PDO::PARAM_STR);
			$stm->bindValue(18, $row->sexo_id, PDO::PARAM_STR);
			$stm->bindValue(19, $row->leghijo_fecnacto, PDO::PARAM_STR);
			$stm->bindValue(20, $row->leghijo_direccion, PDO::PARAM_STR);
			$stm->bindValue(21, $row->leghijo_direcnro, PDO::PARAM_STR);
			$stm->bindValue(22, $row->leghijo_direcpiso, PDO::PARAM_STR);
			$stm->bindValue(23, $row->pais_id, PDO::PARAM_STR);
			$stm->bindValue(24, $row->provincia_id, PDO::PARAM_STR);
			$stm->bindValue(25, $row->departamento_id, PDO::PARAM_STR);
			$stm->bindValue(26, $row->localidad_id, PDO::PARAM_STR);
			$stm->bindValue(27, $row->leghijo_codpostal, PDO::PARAM_STR);
			$stm->bindValue(28, $row->leghijo_disc, PDO::PARAM_STR);
			$stm->bindValue(29, $row->leghijo_esc, PDO::PARAM_STR);
			$stm->bindValue(30, $row->escuela_id, PDO::PARAM_STR);
			$stm->bindValue(31, $row->escnivel_id, PDO::PARAM_STR);
			$stm->bindValue(32, $row->escestado_id, PDO::PARAM_STR);
			$stm->bindValue(33, $row->leghijo_estado, PDO::PARAM_STR);
			$stm->bindValue(34, $row->leghijo_activo, PDO::PARAM_STR);
			$stm->bindValue(35, $ippublica, PDO::PARAM_STR);
			$stm->bindValue(36, $pcnombre, PDO::PARAM_STR);
			$stm->bindValue(37, $pcinformacion, PDO::PARAM_STR);
			$stm->bindValue(38, $usuario, PDO::PARAM_STR);
			$stm->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function AsignacionInfoGuardarExe($data){
		try{

			$sql = 'INSERT INTO asignaciones_familiares_info (asignacion_titular,
																				 								asignacion_phc_id,
																				 								legempleado_nrodocto,
																				 								legempleado_nrodocto_ben,
																												periodo_id,
																												asigtipo_id,
																												asignacion_cantidad,
																												asignacion_info_tipo,
																												asignacion_info_obs,
																												asignacion_info_estado)
																								 VALUES(:asgtitular,
																											  :phcid,
																											  :empndoc,
																											  :benndoc,
																												:periodoid,
			 																									:asigtid,
																												:asigcant,
			 																									:asigtinfo,
																												:infoobs,
			 																								  :infoestado)';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(':asgtitular', $data->Asigtitular, PDO::PARAM_STR);
			$dec->bindValue(':phcid', $data->PHCid, PDO::PARAM_STR);
			$dec->bindValue(':empndoc', $data->Empnrodocto, PDO::PARAM_STR);
			$dec->bindValue(':benndoc', $data->Bennrodocto, PDO::PARAM_STR);
			$dec->bindValue(':periodoid', $data->Periodoid, PDO::PARAM_STR);
			$dec->bindValue(':asigtid', $data->Asigtipo, PDO::PARAM_STR);
			$dec->bindValue(':asigcant', $data->Asigcantidad, PDO::PARAM_STR);
			$dec->bindValue(':asigtinfo', $data->Asiginfo, PDO::PARAM_STR);
			$dec->bindValue(':infoobs', $data->Asinginfoobs, PDO::PARAM_STR);
			$dec->bindValue(':infoestado', $data->Asiginfoestado, PDO::PARAM_STR);
			$dec->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function AsignacionInfoActualizarExe($data){
		try{
			$sql = 'UPDATE asignaciones_familiares_info SET asignacion_cantidad = ?,
																											asignacion_info_obs = ?
																								WHERE asignacion_info_id = ?';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $data->Asigcantidad, PDO::PARAM_STR);
			$dec->bindValue(2, $data->Asinginfoobs, PDO::PARAM_STR);
			$dec->bindValue(3, $data->Asiginfoid, PDO::PARAM_STR);
			$dec->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function PreNatalGuardarExe($data){
		try{
			$sql = 'INSERT INTO legajos_prenatal (legempleado_nrodocto,
																						legempleado_id_ben,
																						legprenatal_bentdoc,
																						legprenatal_benndoc,
																						legprenatal_bennoficio,
																						legprenatal_benapellido,
																						legprenatal_bennombres,
																						legprenatal_madretdoc,
																						legprenatal_madrendoc,
																						legprenatal_madreapellido,
																						legprenatal_madrenombres,
																						legprenatal_fecum,
																						legprenatal_fecpp,
																						legprenatal_estado,
																						legprenatal_activo)
																		 VALUES(:empndoc,
																			 			:benid,
																			 			0,
																						:benndoc,
																						"",
																						:benap,
																						:bennom,
																						0,
																						0,
																						"",
																						"",
																						:pnfecum,
																						:pnfecpp,
																						1,
																						1)';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(':empndoc', $data->Empnrodocto, PDO::PARAM_STR);
			$dec->bindValue(':benid', $data->Empid, PDO::PARAM_STR);
			$dec->bindValue(':benndoc', $data->Empnrodocto, PDO::PARAM_STR);
			$dec->bindValue(':benap', $data->Prenatalbenapp, PDO::PARAM_STR);
			$dec->bindValue(':bennom', $data->Prenatalbennom, PDO::PARAM_STR);
			$dec->bindValue(':pnfecum', $data->Prenatalfecum, PDO::PARAM_STR);
			$dec->bindValue(':pnfecpp', $data->Prenatalfecpp, PDO::PARAM_STR);
			$dec->execute();
			//----------------obtner ultimo id Insertado -----------
			$ultimoid = $this->cn->lastInsertId();
			// ---------------Insert auditoria Pre-Natal ------------
			$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];
			$ippublica = $_SERVER["REMOTE_ADDR"];
			$pcnombre = gethostbyaddr($_SERVER['REMOTE_ADDR']);
			$pcinformacion = $_SERVER['HTTP_USER_AGENT'];

			$sql ='INSERT INTO legajos_prenatal_aud (AUD_legprenatal_id,
																							 AUD_legempleado_nrodocto,
																							 AUD_legempleado_id_ben,
																							 AUD_legprenatal_bentdoc,
																							 AUD_legprenatal_benndoc,
																							 AUD_legprenatal_bennoficio,
																							 AUD_legprenatal_benapellido,
																							 AUD_legprenatal_bennombres,
																							 AUD_legprenatal_madretdoc,
																							 AUD_legprenatal_madrendoc,
																							 AUD_legprenatal_madreapellido,
																							 AUD_legprenatal_madrenombres,
																							 AUD_legprenatal_fecum,
																							 AUD_legprenatal_fecpp,
																							 AUD_legprenatal_estado,
																							 AUD_legprenatal_activo,
																							 AUD_legprenatal_ippublica,
																							 AUD_legprenatal_pcnombre,
																							 AUD_legprenatal_pcinformacion,
																							 AUD_legprenatal_accion,
																							 AUD_legprenatal_observacion,
																							 AUD_legprenatal_datetime,
																							 AUD_legprenatal_usuario)
																			 VALUES (?,
																				 			 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 1,
																							 1,
																							 ?,
																							 ?,
																							 ?,
																							 "INSERT",
																							 "",
																							 NOW(),
																							 ?)';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $ultimoid, PDO::PARAM_STR);
			$stm->bindValue(2, $data->Empnrodocto, PDO::PARAM_STR);
			$stm->bindValue(3, 0, PDO::PARAM_STR);
			$stm->bindValue(4, 0, PDO::PARAM_STR);
			$stm->bindValue(5, $data->Empnrodocto, PDO::PARAM_STR);
			$stm->bindValue(6, "", PDO::PARAM_STR);
			$stm->bindValue(7, $data->Prenatalbenapp, PDO::PARAM_STR);
			$stm->bindValue(8, $data->Prenatalbennom, PDO::PARAM_STR);
			$stm->bindValue(9, 0, PDO::PARAM_STR);
			$stm->bindValue(10, 0, PDO::PARAM_STR);
			$stm->bindValue(11, "", PDO::PARAM_STR);
			$stm->bindValue(12, "", PDO::PARAM_STR);
			$stm->bindValue(13, $data->Prenatalfecum, PDO::PARAM_STR);
			$stm->bindValue(14, $data->Prenatalfecpp, PDO::PARAM_STR);
			$stm->bindValue(15, $ippublica, PDO::PARAM_STR);
			$stm->bindValue(16, $pcnombre, PDO::PARAM_STR);
			$stm->bindValue(17, $pcinformacion, PDO::PARAM_STR);
			$stm->bindValue(18, $usuario, PDO::PARAM_STR);
			$stm->execute();
			return $ultimoid;

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function PreNatalActualizar($data){
		try{
			$sql = 'UPDATE legajos_prenatal SET legprenatal_fecum = ?,
																					legprenatal_fecpp = ?
																		WHERE legprenatal_id = ?';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $data->Prenatalfecum, PDO::PARAM_STR);
			$dec->bindValue(2, $data->Prenatalfecpp, PDO::PARAM_STR);
			$dec->bindValue(3, $data->Id, PDO::PARAM_STR);
			$dec->execute();
			//------------- Auditoria-----------------
			$sql = 'SELECT *
								FROM legajos_prenatal
							 WHERE legprenatal_id = ?
							 LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Id, PDO::PARAM_STR);
			$stm->execute();
			$row = $stm->fetch(PDO::FETCH_OBJ);

			$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];
			$ippublica = $_SERVER["REMOTE_ADDR"];
			$pcnombre = gethostbyaddr($_SERVER['REMOTE_ADDR']);
			$pcinformacion = $_SERVER['HTTP_USER_AGENT'];

			$sql ='INSERT INTO legajos_prenatal_aud (AUD_legprenatal_id,
																							 AUD_legempleado_nrodocto,
																							 AUD_legempleado_id_ben,
																							 AUD_legprenatal_bentdoc,
																							 AUD_legprenatal_benndoc,
																							 AUD_legprenatal_bennoficio,
																							 AUD_legprenatal_benapellido,
																							 AUD_legprenatal_bennombres,
																							 AUD_legprenatal_madretdoc,
																							 AUD_legprenatal_madrendoc,
																							 AUD_legprenatal_madreapellido,
																							 AUD_legprenatal_madrenombres,
																							 AUD_legprenatal_fecum,
																							 AUD_legprenatal_fecpp,
																							 AUD_legprenatal_estado,
																							 AUD_legprenatal_activo,
																							 AUD_legprenatal_ippublica,
																							 AUD_legprenatal_pcnombre,
																							 AUD_legprenatal_pcinformacion,
																							 AUD_legprenatal_accion,
																							 AUD_legprenatal_observacion,
																							 AUD_legprenatal_datetime,
																							 AUD_legprenatal_usuario)
																			 VALUES (?,
																				 			 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 "UPDATE",
																							 "",
																							 NOW(),
																							 ?)';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $row->legprenatal_id, PDO::PARAM_STR);
			$stm->bindValue(2, $row->legempleado_nrodocto, PDO::PARAM_STR);
			$stm->bindValue(3, $row->legempleado_id_ben, PDO::PARAM_STR);
			$stm->bindValue(4, $row->legprenatal_bentdoc, PDO::PARAM_STR);
			$stm->bindValue(5, $row->legprenatal_benndoc, PDO::PARAM_STR);
			$stm->bindValue(6, $row->legprenatal_bennoficio, PDO::PARAM_STR);
			$stm->bindValue(7, $row->legprenatal_benapellido, PDO::PARAM_STR);
			$stm->bindValue(8, $row->legprenatal_bennombres, PDO::PARAM_STR);
			$stm->bindValue(9, $row->legprenatal_madretdoc, PDO::PARAM_STR);
			$stm->bindValue(10, $row->legprenatal_madrendoc, PDO::PARAM_STR);
			$stm->bindValue(11, $row->legprenatal_madreapellido, PDO::PARAM_STR);
			$stm->bindValue(12, $row->legprenatal_madrenombres, PDO::PARAM_STR);
			$stm->bindValue(13, $row->legprenatal_fecum, PDO::PARAM_STR);
			$stm->bindValue(14, $row->legprenatal_fecpp, PDO::PARAM_STR);
			$stm->bindValue(15, $row->legprenatal_estado, PDO::PARAM_STR);
			$stm->bindValue(16, $row->legprenatal_activo, PDO::PARAM_STR);
			$stm->bindValue(17, $ippublica, PDO::PARAM_STR);
			$stm->bindValue(18, $pcnombre, PDO::PARAM_STR);
			$stm->bindValue(19, $pcinformacion, PDO::PARAM_STR);
			$stm->bindValue(20, $usuario, PDO::PARAM_STR);
			$stm->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function PreNatalEliminarExe($data){
		try{
			$sql = 'UPDATE legajos_prenatal SET legprenatal_activo = 0
																		WHERE legprenatal_id = ?';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->PreNatalId, PDO::PARAM_STR);
			$stm->execute();

			//------------- Auditoria-----------------
			$sql = 'SELECT *
								FROM legajos_prenatal
							 WHERE legprenatal_id = ?
							 LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->PreNatalId, PDO::PARAM_STR);
			$stm->execute();
			$row = $stm->fetch(PDO::FETCH_OBJ);

			$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];
			$ippublica = $_SERVER["REMOTE_ADDR"];
			$pcnombre = gethostbyaddr($_SERVER['REMOTE_ADDR']);
			$pcinformacion = $_SERVER['HTTP_USER_AGENT'];

			$sql ='INSERT INTO legajos_prenatal_aud (AUD_legprenatal_id,
																							 AUD_legempleado_nrodocto,
																							 AUD_legempleado_id_ben,
																							 AUD_legprenatal_bentdoc,
																							 AUD_legprenatal_benndoc,
																							 AUD_legprenatal_bennoficio,
																							 AUD_legprenatal_benapellido,
																							 AUD_legprenatal_bennombres,
																							 AUD_legprenatal_madretdoc,
																							 AUD_legprenatal_madrendoc,
																							 AUD_legprenatal_madreapellido,
																							 AUD_legprenatal_madrenombres,
																							 AUD_legprenatal_fecum,
																							 AUD_legprenatal_fecpp,
																							 AUD_legprenatal_estado,
																							 AUD_legprenatal_activo,
																							 AUD_legprenatal_ippublica,
																							 AUD_legprenatal_pcnombre,
																							 AUD_legprenatal_pcinformacion,
																							 AUD_legprenatal_accion,
																							 AUD_legprenatal_observacion,
																							 AUD_legprenatal_datetime,
																							 AUD_legprenatal_usuario)
																			 VALUES (?,
																				 			 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 "DISABLE",
																							 "",
																							 NOW(),
																							 ?)';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $row->legprenatal_id, PDO::PARAM_STR);
			$stm->bindValue(2, $row->legempleado_nrodocto, PDO::PARAM_STR);
			$stm->bindValue(3, $row->legempleado_id_ben, PDO::PARAM_STR);
			$stm->bindValue(4, $row->legprenatal_bentdoc, PDO::PARAM_STR);
			$stm->bindValue(5, $row->legprenatal_benndoc, PDO::PARAM_STR);
			$stm->bindValue(6, $row->legprenatal_bennoficio, PDO::PARAM_STR);
			$stm->bindValue(7, $row->legprenatal_benapellido, PDO::PARAM_STR);
			$stm->bindValue(8, $row->legprenatal_bennombres, PDO::PARAM_STR);
			$stm->bindValue(9, $row->legprenatal_madretdoc, PDO::PARAM_STR);
			$stm->bindValue(10, $row->legprenatal_madrendoc, PDO::PARAM_STR);
			$stm->bindValue(11, $row->legprenatal_madreapellido, PDO::PARAM_STR);
			$stm->bindValue(12, $row->legprenatal_madrenombres, PDO::PARAM_STR);
			$stm->bindValue(13, $row->legprenatal_fecum, PDO::PARAM_STR);
			$stm->bindValue(14, $row->legprenatal_fecpp, PDO::PARAM_STR);
			$stm->bindValue(15, $row->legprenatal_estado, PDO::PARAM_STR);
			$stm->bindValue(16, $row->legprenatal_activo, PDO::PARAM_STR);
			$stm->bindValue(17, $ippublica, PDO::PARAM_STR);
			$stm->bindValue(18, $pcnombre, PDO::PARAM_STR);
			$stm->bindValue(19, $pcinformacion, PDO::PARAM_STR);
			$stm->bindValue(20, $usuario, PDO::PARAM_STR);
			$stm->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function PreNatalBenGuardarExe($data){
		try{

			$sql = 'UPDATE legajos_prenatal
								 SET legempleado_id_ben = ?,
								 		 legprenatal_benndoc = ?,
								 		 legprenatal_bennoficio = ?,
								 		 legprenatal_benapellido = ?,
										 legprenatal_bennombres = ?
							 WHERE legprenatal_id = ?';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $data->Benid, PDO::PARAM_STR);
			$dec->bindValue(2, $data->Prenbenndoc, PDO::PARAM_STR);
			$dec->bindValue(3, $data->Prenbennoficio, PDO::PARAM_STR);
			$dec->bindValue(4, $data->Prenbenapellido, PDO::PARAM_STR);
			$dec->bindValue(5, $data->Prenbennombres, PDO::PARAM_STR);
			$dec->bindValue(6, $data->PrenId, PDO::PARAM_STR);
			$dec->execute();
			//------------- Auditoria-----------------
			$sql = 'SELECT *
								FROM legajos_prenatal
							 WHERE legprenatal_id = ?
							 LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->PrenId, PDO::PARAM_STR);
			$stm->execute();
			$row = $stm->fetch(PDO::FETCH_OBJ);

			$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];
			$ippublica = $_SERVER["REMOTE_ADDR"];
			$pcnombre = gethostbyaddr($_SERVER['REMOTE_ADDR']);
			$pcinformacion = $_SERVER['HTTP_USER_AGENT'];

			$sql ='INSERT INTO legajos_prenatal_aud (AUD_legprenatal_id,
																							 AUD_legempleado_nrodocto,
																							 AUD_legempleado_id_ben,
																							 AUD_legprenatal_bentdoc,
																							 AUD_legprenatal_benndoc,
																							 AUD_legprenatal_bennoficio,
																							 AUD_legprenatal_benapellido,
																							 AUD_legprenatal_bennombres,
																							 AUD_legprenatal_madretdoc,
																							 AUD_legprenatal_madrendoc,
																							 AUD_legprenatal_madreapellido,
																							 AUD_legprenatal_madrenombres,
																							 AUD_legprenatal_fecum,
																							 AUD_legprenatal_fecpp,
																							 AUD_legprenatal_estado,
																							 AUD_legprenatal_activo,
																							 AUD_legprenatal_ippublica,
																							 AUD_legprenatal_pcnombre,
																							 AUD_legprenatal_pcinformacion,
																							 AUD_legprenatal_accion,
																							 AUD_legprenatal_observacion,
																							 AUD_legprenatal_datetime,
																							 AUD_legprenatal_usuario)
																			 VALUES (?,
																				 			 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 "UPDATE",
																							 "",
																							 NOW(),
																							 ?)';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $row->legprenatal_id, PDO::PARAM_STR);
			$stm->bindValue(2, $row->legempleado_nrodocto, PDO::PARAM_STR);
			$stm->bindValue(3, $row->legempleado_id_ben, PDO::PARAM_STR);
			$stm->bindValue(4, $row->legprenatal_bentdoc, PDO::PARAM_STR);
			$stm->bindValue(5, $row->legprenatal_benndoc, PDO::PARAM_STR);
			$stm->bindValue(6, $row->legprenatal_bennoficio, PDO::PARAM_STR);
			$stm->bindValue(7, $row->legprenatal_benapellido, PDO::PARAM_STR);
			$stm->bindValue(8, $row->legprenatal_bennombres, PDO::PARAM_STR);
			$stm->bindValue(9, $row->legprenatal_madretdoc, PDO::PARAM_STR);
			$stm->bindValue(10, $row->legprenatal_madrendoc, PDO::PARAM_STR);
			$stm->bindValue(11, $row->legprenatal_madreapellido, PDO::PARAM_STR);
			$stm->bindValue(12, $row->legprenatal_madrenombres, PDO::PARAM_STR);
			$stm->bindValue(13, $row->legprenatal_fecum, PDO::PARAM_STR);
			$stm->bindValue(14, $row->legprenatal_fecpp, PDO::PARAM_STR);
			$stm->bindValue(15, $row->legprenatal_estado, PDO::PARAM_STR);
			$stm->bindValue(16, $row->legprenatal_activo, PDO::PARAM_STR);
			$stm->bindValue(17, $ippublica, PDO::PARAM_STR);
			$stm->bindValue(18, $pcnombre, PDO::PARAM_STR);
			$stm->bindValue(19, $pcinformacion, PDO::PARAM_STR);
			$stm->bindValue(20, $usuario, PDO::PARAM_STR);
			$stm->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function PreNatalMoPGuardarExe($data){
		try{

			$sql = 'UPDATE legajos_prenatal
								 SET legprenatal_madrendoc = ?,
								 		 legprenatal_madreapellido = ?,
										 legprenatal_madrenombres = ?
							 WHERE legprenatal_id = ?';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $data->Prenmopndoc, PDO::PARAM_STR);
			$dec->bindValue(2, $data->Prenmopapellido, PDO::PARAM_STR);
			$dec->bindValue(3, $data->Prenmopnombres, PDO::PARAM_STR);
			$dec->bindValue(4, $data->PrenId, PDO::PARAM_STR);
			$dec->execute();
			//------------- Auditoria-----------------
			$sql = 'SELECT *
								FROM legajos_prenatal
							 WHERE legprenatal_id = ?
							 LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->PrenId, PDO::PARAM_STR);
			$stm->execute();
			$row = $stm->fetch(PDO::FETCH_OBJ);

			$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];
			$ippublica = $_SERVER["REMOTE_ADDR"];
			$pcnombre = gethostbyaddr($_SERVER['REMOTE_ADDR']);
			$pcinformacion = $_SERVER['HTTP_USER_AGENT'];

			$sql ='INSERT INTO legajos_prenatal_aud (AUD_legprenatal_id,
																							 AUD_legempleado_nrodocto,
																							 AUD_legempleado_id_ben,
																							 AUD_legprenatal_bentdoc,
																							 AUD_legprenatal_benndoc,
																							 AUD_legprenatal_bennoficio,
																							 AUD_legprenatal_benapellido,
																							 AUD_legprenatal_bennombres,
																							 AUD_legprenatal_madretdoc,
																							 AUD_legprenatal_madrendoc,
																							 AUD_legprenatal_madreapellido,
																							 AUD_legprenatal_madrenombres,
																							 AUD_legprenatal_fecum,
																							 AUD_legprenatal_fecpp,
																							 AUD_legprenatal_estado,
																							 AUD_legprenatal_activo,
																							 AUD_legprenatal_ippublica,
																							 AUD_legprenatal_pcnombre,
																							 AUD_legprenatal_pcinformacion,
																							 AUD_legprenatal_accion,
																							 AUD_legprenatal_observacion,
																							 AUD_legprenatal_datetime,
																							 AUD_legprenatal_usuario)
																			 VALUES (?,
																				 			 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 "UPDATE",
																							 "",
																							 NOW(),
																							 ?)';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $row->legprenatal_id, PDO::PARAM_STR);
			$stm->bindValue(2, $row->legempleado_nrodocto, PDO::PARAM_STR);
			$stm->bindValue(3, $row->legempleado_id_ben, PDO::PARAM_STR);
			$stm->bindValue(4, $row->legprenatal_bentdoc, PDO::PARAM_STR);
			$stm->bindValue(5, $row->legprenatal_benndoc, PDO::PARAM_STR);
			$stm->bindValue(6, $row->legprenatal_bennoficio, PDO::PARAM_STR);
			$stm->bindValue(7, $row->legprenatal_benapellido, PDO::PARAM_STR);
			$stm->bindValue(8, $row->legprenatal_bennombres, PDO::PARAM_STR);
			$stm->bindValue(9, $row->legprenatal_madretdoc, PDO::PARAM_STR);
			$stm->bindValue(10, $row->legprenatal_madrendoc, PDO::PARAM_STR);
			$stm->bindValue(11, $row->legprenatal_madreapellido, PDO::PARAM_STR);
			$stm->bindValue(12, $row->legprenatal_madrenombres, PDO::PARAM_STR);
			$stm->bindValue(13, $row->legprenatal_fecum, PDO::PARAM_STR);
			$stm->bindValue(14, $row->legprenatal_fecpp, PDO::PARAM_STR);
			$stm->bindValue(15, $row->legprenatal_estado, PDO::PARAM_STR);
			$stm->bindValue(16, $row->legprenatal_activo, PDO::PARAM_STR);
			$stm->bindValue(17, $ippublica, PDO::PARAM_STR);
			$stm->bindValue(18, $pcnombre, PDO::PARAM_STR);
			$stm->bindValue(19, $pcinformacion, PDO::PARAM_STR);
			$stm->bindValue(20, $usuario, PDO::PARAM_STR);
			$stm->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function PreNatalDeshabilitarExe($data){
		try{

			$sql = 'UPDATE legajos_prenatal
								 SET legprenatal_estado = 2
							 WHERE legprenatal_id = ?';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Prenid, PDO::PARAM_STR);
			$stm->execute();
			//------------- Auditoria-----------------
			$sql = 'SELECT *
								FROM legajos_prenatal
							 WHERE legprenatal_id = ?
							 LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Prenid, PDO::PARAM_STR);
			$stm->execute();
			$row = $stm->fetch(PDO::FETCH_OBJ);

			$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];
			$ippublica = $_SERVER["REMOTE_ADDR"];
			$pcnombre = gethostbyaddr($_SERVER['REMOTE_ADDR']);
			$pcinformacion = $_SERVER['HTTP_USER_AGENT'];

			$sql ='INSERT INTO legajos_prenatal_aud (AUD_legprenatal_id,
																							 AUD_legempleado_nrodocto,
																							 AUD_legempleado_id_ben,
																							 AUD_legprenatal_bentdoc,
																							 AUD_legprenatal_benndoc,
																							 AUD_legprenatal_bennoficio,
																							 AUD_legprenatal_benapellido,
																							 AUD_legprenatal_bennombres,
																							 AUD_legprenatal_madretdoc,
																							 AUD_legprenatal_madrendoc,
																							 AUD_legprenatal_madreapellido,
																							 AUD_legprenatal_madrenombres,
																							 AUD_legprenatal_fecum,
																							 AUD_legprenatal_fecpp,
																							 AUD_legprenatal_estado,
																							 AUD_legprenatal_activo,
																							 AUD_legprenatal_ippublica,
																							 AUD_legprenatal_pcnombre,
																							 AUD_legprenatal_pcinformacion,
																							 AUD_legprenatal_accion,
																							 AUD_legprenatal_observacion,
																							 AUD_legprenatal_datetime,
																							 AUD_legprenatal_usuario)
																			 VALUES (?,
																				 			 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 "DISABLE",
																							 ?,
																							 NOW(),
																							 ?)';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $row->legprenatal_id, PDO::PARAM_STR);
			$stm->bindValue(2, $row->legempleado_nrodocto, PDO::PARAM_STR);
			$stm->bindValue(3, $row->legempleado_id_ben, PDO::PARAM_STR);
			$stm->bindValue(4, $row->legprenatal_bentdoc, PDO::PARAM_STR);
			$stm->bindValue(5, $row->legprenatal_benndoc, PDO::PARAM_STR);
			$stm->bindValue(6, $row->legprenatal_bennoficio, PDO::PARAM_STR);
			$stm->bindValue(7, $row->legprenatal_benapellido, PDO::PARAM_STR);
			$stm->bindValue(8, $row->legprenatal_bennombres, PDO::PARAM_STR);
			$stm->bindValue(9, $row->legprenatal_madretdoc, PDO::PARAM_STR);
			$stm->bindValue(10, $row->legprenatal_madrendoc, PDO::PARAM_STR);
			$stm->bindValue(11, $row->legprenatal_madreapellido, PDO::PARAM_STR);
			$stm->bindValue(12, $row->legprenatal_madrenombres, PDO::PARAM_STR);
			$stm->bindValue(13, $row->legprenatal_fecum, PDO::PARAM_STR);
			$stm->bindValue(14, $row->legprenatal_fecpp, PDO::PARAM_STR);
			$stm->bindValue(15, $row->legprenatal_estado, PDO::PARAM_STR);
			$stm->bindValue(16, $row->legprenatal_activo, PDO::PARAM_STR);
			$stm->bindValue(17, $ippublica, PDO::PARAM_STR);
			$stm->bindValue(18, $pcnombre, PDO::PARAM_STR);
			$stm->bindValue(19, $pcinformacion, PDO::PARAM_STR);
			$stm->bindValue(20, $data->Observacion, PDO::PARAM_STR);
			$stm->bindValue(21, $usuario, PDO::PARAM_STR);
			$stm->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function PreNatalHabilitarExe($data){
		try{

			$sql = 'UPDATE legajos_prenatal
								 SET legprenatal_estado = 1
							 WHERE legprenatal_id = ?';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Prenid, PDO::PARAM_STR);
			$stm->execute();
			//------------- Auditoria-----------------
			$sql = 'SELECT *
								FROM legajos_prenatal
							 WHERE legprenatal_id = ?
							 LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Prenid, PDO::PARAM_STR);
			$stm->execute();
			$row = $stm->fetch(PDO::FETCH_OBJ);

			$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];
			$ippublica = $_SERVER["REMOTE_ADDR"];
			$pcnombre = gethostbyaddr($_SERVER['REMOTE_ADDR']);
			$pcinformacion = $_SERVER['HTTP_USER_AGENT'];

			$sql ='INSERT INTO legajos_prenatal_aud (AUD_legprenatal_id,
																							 AUD_legempleado_nrodocto,
																							 AUD_legempleado_id_ben,
																							 AUD_legprenatal_bentdoc,
																							 AUD_legprenatal_benndoc,
																							 AUD_legprenatal_bennoficio,
																							 AUD_legprenatal_benapellido,
																							 AUD_legprenatal_bennombres,
																							 AUD_legprenatal_madretdoc,
																							 AUD_legprenatal_madrendoc,
																							 AUD_legprenatal_madreapellido,
																							 AUD_legprenatal_madrenombres,
																							 AUD_legprenatal_fecum,
																							 AUD_legprenatal_fecpp,
																							 AUD_legprenatal_estado,
																							 AUD_legprenatal_activo,
																							 AUD_legprenatal_ippublica,
																							 AUD_legprenatal_pcnombre,
																							 AUD_legprenatal_pcinformacion,
																							 AUD_legprenatal_accion,
																							 AUD_legprenatal_observacion,
																							 AUD_legprenatal_datetime,
																							 AUD_legprenatal_usuario)
																			 VALUES (?,
																				 			 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 ?,
																							 "ENABLE",
																							 "",
																							 NOW(),
																							 ?)';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $row->legprenatal_id, PDO::PARAM_STR);
			$stm->bindValue(2, $row->legempleado_nrodocto, PDO::PARAM_STR);
			$stm->bindValue(3, $row->legempleado_id_ben, PDO::PARAM_STR);
			$stm->bindValue(4, $row->legprenatal_bentdoc, PDO::PARAM_STR);
			$stm->bindValue(5, $row->legprenatal_benndoc, PDO::PARAM_STR);
			$stm->bindValue(6, $row->legprenatal_bennoficio, PDO::PARAM_STR);
			$stm->bindValue(7, $row->legprenatal_benapellido, PDO::PARAM_STR);
			$stm->bindValue(8, $row->legprenatal_bennombres, PDO::PARAM_STR);
			$stm->bindValue(9, $row->legprenatal_madretdoc, PDO::PARAM_STR);
			$stm->bindValue(10, $row->legprenatal_madrendoc, PDO::PARAM_STR);
			$stm->bindValue(11, $row->legprenatal_madreapellido, PDO::PARAM_STR);
			$stm->bindValue(12, $row->legprenatal_madrenombres, PDO::PARAM_STR);
			$stm->bindValue(13, $row->legprenatal_fecum, PDO::PARAM_STR);
			$stm->bindValue(14, $row->legprenatal_fecpp, PDO::PARAM_STR);
			$stm->bindValue(15, $row->legprenatal_estado, PDO::PARAM_STR);
			$stm->bindValue(16, $row->legprenatal_activo, PDO::PARAM_STR);
			$stm->bindValue(17, $ippublica, PDO::PARAM_STR);
			$stm->bindValue(18, $pcnombre, PDO::PARAM_STR);
			$stm->bindValue(19, $pcinformacion, PDO::PARAM_STR);
			$stm->bindValue(20, $usuario, PDO::PARAM_STR);
			$stm->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function EmpleadoObtener($id){
		try{
			$sql = 'SELECT * FROM legajos
											WHERE legempleado_id = ?';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $id, PDO::PARAM_STR);
			$dec->execute();

			return $dec->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerPreNatalAsignacionDeshabilitada($empleadonrodocto){
		try{

			$sql = 'SELECT *
								FROM legajos_prenatal
							 WHERE legempleado_nrodocto = ?
							   AND legprenatal_estado = 2';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $empleadonrodocto, PDO::PARAM_STR);
			$dec->execute();

			return $dec->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	//------Sentencias Viejas ----
	public function ListarEmpleados(){
		try{
		$sql = $this->cn->prepare("SELECT * FROM legajos a, sexos b, estados_civiles c WHERE a.sexo_id=b.sexo_id AND a.estcivil_id=c.estcivil_id AND a.legajo_estado_id='1' AND a.empresa_id = 1 ");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerTipoLegajo($nrodocto){
		try{

			$sql = 'SELECT b.legtipo_nombre FROM legajos a, legajos_tipo b WHERE a.legajo_tipo_id = b.legajo_tipo_id AND a.legajo_nrodocto = ? LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$stm->execute();
			return $stm->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ListarEmpInactivos(){
		try{
			$sql = $this->cn->prepare("SELECT * FROM legajos WHERE legempleado_activo = 0");
			$sql->execute();

			return $sql->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ListarEmpGeneral(){
		try{
			$sql = $this->cn->prepare("SELECT * FROM legajos");
			$sql->execute();

			return $sql->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerImputacion($imputacionid){
		try{

			$sql = 'SELECT * FROM imputaciones WHERE imputacion_id = ? LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $imputacionid, PDO::PARAM_STR);
			$stm->execute();

			return $stm->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ListarImputaciones(){
		try{

			$sql = $this->cn->prepare("SELECT * FROM imputaciones WHERE imputacion_habilitar = 1 ORDER BY imputacion_nombre");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ListarTareas(){
		try{
			$sql = $this->cn->prepare("SELECT * FROM tareas WHERE tarea_activo = 1 ORDER BY tarea_nombre");
			$sql->execute();

			return $sql->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerActividades($imputacionid){
		try{

			$sql = 'SELECT * FROM imputaciones_actividad WHERE imputacion_id = ? ORDER BY impactividad_nombre';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $imputacionid, PDO::PARAM_STR);
			$stm->execute();
			return $stm->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function TiposDocto(){
		try{
			$sql = $this->cn->prepare("SELECT * FROM documentos_tipo ORDER BY doctipo_abreviacion");
			$sql->execute();

			return $sql->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function Sexos(){
		try{

			$sql = $this->cn->prepare("SELECT * FROM sexos ORDER BY sexo_nombre");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function EstadosC(){
		try{

			$sql = $this->cn->prepare("SELECT * FROM estados_civiles");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}

	public function ObtenerProvincias($pais){
		try{

			$sql = 'SELECT *
								FROM provincias
							 WHERE pais_id = ?
						ORDER BY provincia_nombre';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $pais, PDO::PARAM_STR);
			$stm->execute();
			return $stm->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
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
	public function ObtenerLugaresDeTrabajo($secretariaid){
		try{
			$sql = 'SELECT * FROM lugares_trabajo WHERE secretaria_id = ? ORDER BY trabajo_nombre';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $secretariaid, PDO::PARAM_STR);
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerLugarDeTrabajo($trabajoid){
		try{
			$sql = 'SELECT * FROM lugares_trabajo WHERE trabajo_id = ? ORDER BY trabajo_nombre LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $trabajoid, PDO::PARAM_STR);
			$stm->execute();

			return $stm->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
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





	public function Escuelas(){
		try{
			$sql = $this->cn->prepare("SELECT * FROM escuelas WHERE escuela_activo = 1 ORDER BY escuela_nombre");
			$sql->execute();

			return $sql->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}

	public function EscuelasNivel(){
		try{
			$sql = $this->cn->prepare("SELECT * FROM escuelas_nivel WHERE escnivel_activo = 1 ORDER BY escnivel_nombre");
			$sql->execute();

			return $sql->fetchAll(PDO::FETCH_OBJ);

		}catch(Exception $e){
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

	public function TiposLegajos(){
		try{

			$sql = $this->cn->prepare("SELECT * FROM legajos_tipo WHERE legtipo_habilitar = 1");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ListarTiposLegajosA(){
		try{

			$sql = $this->cn->prepare("SELECT * FROM legajos_tipo WHERE legtipo_id != 2 AND legtipo_id != 3");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
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

	public function Secretarias(){
		try{

			$sql = $this->cn->prepare("SELECT * FROM secretarias WHERE secretaria_habilitar = 1 ORDER BY secretaria_nombre");
			$sql->execute();

			return $sql->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}

	public function ContrProv(){
		try{

			$sql = $this->cn->prepare("SELECT * FROM legajos_tipo WHERE (legtipo_id = 1 OR legtipo_id = 4)");
			$sql->execute();

			return $sql->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function LugaresTrabajo(){
		try{

			$sql = $this->cn->prepare("SELECT * FROM lugares_trabajo WHERE trabajo_activo = 1 ORDER BY trabajo_nombre");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ListarContratosModelos(){
		try{

			$sql = $this->cn->prepare("SELECT * FROM contratos_modelos WHERE leg_modelo_activo = 1 ORDER BY contrato_modelonombre");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}

	}
	public function Relojes(){
		try{
			$activo = 1;
			$sql = 'SELECT * FROM relojes WHERE reloj_habilitar = ? ORDER BY reloj_nombre';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $activo, PDO::PARAM_STR);
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
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

	public function ObtenerReloj2($nrodocto){
		try{
			$sql = 'SELECT * FROM legajos_reloj WHERE legempleado_nrodocto = ? AND legreloj_activo = 1 LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$stm->execute();

			return $stm->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerContratoId($id){
		try{

			$sql = 'SELECT * FROM legajos_contrato WHERE legcontrato_id = ? LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $id, PDO::PARAM_STR);
			$stm->execute();

			return $stm->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerContratoProveedorId($id){
		try{

			$sql = 'SELECT * FROM legajos_proveedor WHERE legproveedor_id = ? LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $id, PDO::PARAM_STR);
			$stm->execute();
			return $stm->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ListarContratos($secretaria, $lugardetrabajo, $tipodecontrato, $sbasicodesde, $sbasicohasta, $ordenci){
		try{

			if(empty($sbasicodesde)){
    		//echo '$var es o bien 0, vacía, o no se encuentra definida en absoluto';
				$sbasicodesdedos = 0;
			}else{
				$sbasicodesdedos = $sbasicodesde;
			}
			if(empty($sbasicohasta)){
    		//echo '$var es o bien 0, vacía, o no se encuentra definida en absoluto';
				$sbasicohastados = 9999999;
			}else{
				$sbasicohastados = $sbasicohasta;
			}

			if($ordenci == 1){
				$ordencontrato = "c.trabajo_nombre,b.legempleado_apellido";
			}else{
				$ordencontrato = "c.trabajo_nombre,b.legempleado_nrodocto";
			}
			//$tipodecontrato = 1;
			if($lugardetrabajo == "T"){

				$sql = 'SELECT * FROM legajos_contrato a,
															legajos b,
															lugares_trabajo c
												 WHERE a.legempleado_nrodocto = b.legempleado_nrodocto
												 AND a.trabajo_id = c.trabajo_id
												 AND a.secretaria_id = ?
												 AND b.legtipo_id = 1
												 AND b.legempleado_activo = 1
												 AND a.legcontrato_activo = 1
												 AND a.legcontrato_sbasico
											   BETWEEN ? AND ?
												 ORDER BY '.$ordencontrato.'';
				$stm = $this->cn->prepare($sql);
				//$stm->bindValue(1, $tipodecontrato, PDO::PARAM_STR);
				$stm->bindValue(1, $secretaria, PDO::PARAM_STR);
				$stm->bindValue(2, $sbasicodesdedos, PDO::PARAM_STR);
				$stm->bindValue(3, $sbasicohastados, PDO::PARAM_STR);
				$stm->execute();

			}else{

				$sql = 'SELECT * FROM legajos_contrato a,
															legajos b,
															lugares_trabajo c
												WHERE a.legempleado_nrodocto = b.legempleado_nrodocto
												AND a.trabajo_id = c.trabajo_id
												AND a.secretaria_id = ?
												AND a.trabajo_id = ?
												AND a.legtipo_id = 1
												AND b.legempleado_activo = 1
												AND a.legcontrato_activo = 1
												AND a.legcontrato_sbasico
												BETWEEN ? AND ?
												ORDER BY '.$ordencontrato.'';
				$stm = $this->cn->prepare($sql);
				//$stm->bindValue(1, $tipodecontrato, PDO::PARAM_STR);
				$stm->bindValue(1, $secretaria, PDO::PARAM_STR);
				$stm->bindValue(2, $lugardetrabajo, PDO::PARAM_STR);
				$stm->bindValue(3, $sbasicodesdedos, PDO::PARAM_STR);
				$stm->bindValue(4, $sbasicohastados, PDO::PARAM_STR);
				$stm->execute();

			}

			return $stm->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ListarContratosProveedor($secretaria, $lugardetrabajo, $tipodecontrato, $sbasicodesde, $sbasicohasta, $ordenci){
		try{

			if(empty($sbasicodesde)){
    		//echo '$var es o bien 0, vacía, o no se encuentra definida en absoluto';
				$sbasicodesdedos = 0;
			}else{
				$sbasicodesdedos = $sbasicodesde;
			}
			if(empty($sbasicohasta)){
    		//echo '$var es o bien 0, vacía, o no se encuentra definida en absoluto';
				$sbasicohastados = 9999999;
			}else{
				$sbasicohastados = $sbasicohasta;
			}

			if($ordenci == 1){
				$ordencontrato = "c.trabajo_nombre,b.legempleado_apellido";
			}else{
				$ordencontrato = "c.trabajo_nombre,b.legempleado_nrodocto";
			}
			//$tipodecontrato = 1;
			if($lugardetrabajo == "T"){

				$sql = 'SELECT * FROM legajos_proveedor a,
															legajos b,
															lugares_trabajo c
												WHERE a.legempleado_nrodocto = b.legempleado_nrodocto
													AND a.trabajo_id = c.trabajo_id
													AND a.secretaria_id = ?
													AND b.legempleado_activo = 1
													AND a.legproveedor_activo = 1
													AND b.legtipo_id = 4
													AND a.legproveedor_sbasico
											BETWEEN ? AND ?
										 ORDER BY '.$ordencontrato.'';
				$stm = $this->cn->prepare($sql);
				$stm->bindValue(1, $secretaria, PDO::PARAM_STR);
				$stm->bindValue(2, $sbasicodesdedos, PDO::PARAM_STR);
				$stm->bindValue(3, $sbasicohastados, PDO::PARAM_STR);
				$stm->execute();

			}else{

				$sql = 'SELECT * FROM legajos_proveedor a,
															legajos b,
															lugares_trabajo c
												WHERE a.legempleado_nrodocto = b.legempleado_nrodocto
												  AND a.trabajo_id = c.trabajo_id
													AND a.secretaria_id = ?
													AND a.trabajo_id = ?
													AND b.legempleado_activo = 1
													AND a.legproveedor_activo = 1
													AND a.legproveedor_sbasico
											BETWEEN ?
											    AND ?
										 ORDER BY '.$ordencontrato.'';
				$stm = $this->cn->prepare($sql);
				$stm->bindValue(1, $secretaria, PDO::PARAM_STR);
				$stm->bindValue(2, $lugardetrabajo, PDO::PARAM_STR);
				$stm->bindValue(3, $sbasicodesdedos, PDO::PARAM_STR);
				$stm->bindValue(4, $sbasicohastados, PDO::PARAM_STR);
				$stm->execute();

			}

			return $stm->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ListarContratosSinRenovar($secretaria, $tipodecontrato, $ordenci){
		try{
			date_default_timezone_set("America/Buenos_Aires");
			$fecha_actual = date("Y-m-d");
			$hora_actual = date("H:i:s");

			if($ordenci == 1){
				$ordencontrato = "c.trabajo_nombre,b.legempleado_apellido";
			}else{
				$ordencontrato = "c.trabajo_nombre,b.legempleado_nrodocto";
			}

				$sql = 'SELECT *,a.secretaria_id FROM legajos_contrato a, legajos b, lugares_trabajo c WHERE a.legempleado_nrodocto = b.legempleado_nrodocto AND a.trabajo_id = c.trabajo_id AND a.secretaria_id = ? AND a.legcontrato_fecfin < ? AND b.legempleado_activo = 1 AND a.legcontrato_activo = 1 ORDER BY '.$ordencontrato.'';
				$stm = $this->cn->prepare($sql);
				$stm->bindValue(1, $secretaria, PDO::PARAM_STR);
				$stm->bindValue(2, $fecha_actual, PDO::PARAM_STR);
				$stm->execute();
				return $stm->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ListarContratosActualizacion($secretaria, $lugardetrabajo, $ordenci, $fechaingreso, $sueldobasico){
		try{

			date_default_timezone_set("America/Buenos_Aires");
			$fecha_actual = date("Y-m-d");
			$hora_actual = date("H:i:s");

			if($ordenci == 1){
				$ordencontrato = "c.trabajo_nombre,b.legempleado_apellido";
			}else{
				$ordencontrato = "c.trabajo_nombre,b.legempleado_nrodocto";
			}
			//$contratotipo = 1;
			if($lugardetrabajo == "T"){

				//----- sentencia con clausula mostrar solo contratos vencidos ---

				$sql = 'SELECT * FROM legajos_contrato a,
															legajos b,
															lugares_trabajo c
												WHERE a.legempleado_nrodocto = b.legempleado_nrodocto
												  AND a.trabajo_id = c.trabajo_id
													AND a.secretaria_id = ?
													AND b.legempleado_fecingreso <= ?
													AND a.legcontrato_fecfin < ?
													AND a.impdependencia_id > 0
													AND a.legcontrato_sbasico > ?
													AND b.legempleado_activo = 1
													AND a.legcontrato_activo = 1
										 ORDER BY '.$ordencontrato.'';
				$stm = $this->cn->prepare($sql);
				$stm->bindValue(1, $secretaria, PDO::PARAM_STR);
				$stm->bindValue(2, $fechaingreso, PDO::PARAM_STR);
				$stm->bindValue(3, $fecha_actual, PDO::PARAM_STR);
				$stm->bindValue(4, $sueldobasico, PDO::PARAM_STR);
				$stm->execute();


			}else{

				$sql = 'SELECT *
									FROM legajos_contrato a,
											 legajos b,
											 lugares_trabajo c
								 WHERE a.legempleado_nrodocto = b.legempleado_nrodocto
								 	 AND a.trabajo_id = c.trabajo_id
									 AND a.trabajo_id = ?
									 AND b.legempleado_fecingreso <= ?
									 AND a.legcontrato_fecfin < ?
									 AND a.impdependencia_id > 0
									 AND a.legcontrato_sbasico > ?
									 AND b.legempleado_activo = 1
									 AND a.legcontrato_activo = 1
							ORDER BY '.$ordencontrato.'';
				$stm = $this->cn->prepare($sql);
				$stm->bindValue(1, $lugardetrabajo, PDO::PARAM_STR);
				$stm->bindValue(2, $fechaingreso, PDO::PARAM_STR);
				$stm->bindValue(3, $fecha_actual, PDO::PARAM_STR);
				$stm->bindValue(4, $sueldobasico, PDO::PARAM_STR);
				$stm->execute();

			}
			return $stm->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ListarProveedorActualizacion($secretaria, $lugardetrabajo, $ordenci, $fechaingreso, $sueldobasico){
		try{

			date_default_timezone_set("America/Buenos_Aires");
			$fecha_actual = date("Y-m-d");
			$hora_actual = date("H:i:s");

			if($ordenci == 1){
				$ordencontrato = "c.trabajo_nombre,b.legempleado_apellido";
			}else{
				$ordencontrato = "c.trabajo_nombre,b.legempleado_nrodocto";
			}
			//$contratotipo = 1;
			if($lugardetrabajo == "T"){

				$sql = 'SELECT * FROM legajos_proveedor a, legajos b, lugares_trabajo c WHERE a.legempleado_nrodocto = b.legempleado_nrodocto AND a.trabajo_id = c.trabajo_id AND a.secretaria_id = ? AND b.legempleado_fecingreso <= ? AND a.legproveedor_fecfin < ? AND a.legproveedor_sbasico > ? AND b.legempleado_activo = 1 AND a.legproveedor_activo = 1 ORDER BY '.$ordencontrato.'';
				$stm = $this->cn->prepare($sql);
				$stm->bindValue(1, $secretaria, PDO::PARAM_STR);
				$stm->bindValue(2, $fechaingreso, PDO::PARAM_STR);
				$stm->bindValue(3, $fecha_actual, PDO::PARAM_STR);
				$stm->bindValue(4, $sueldobasico, PDO::PARAM_STR);
				$stm->execute();

			}else{

				$sql = 'SELECT * FROM legajos_proveedor a, legajos b, lugares_trabajo c WHERE a.legempleado_nrodocto = b.legempleado_nrodocto AND a.trabajo_id = c.trabajo_id AND a.secretaria_id = ? AND a.trabajo_id = ? AND b.legempleado_fecingreso <= ? AND a.legproveedor_fecfin < ? AND a.legproveedor_sbasico > ? AND b.legempleado_activo = 1 AND a.legproveedor_activo = 1 ORDER BY '.$ordencontrato.'';
				$stm = $this->cn->prepare($sql);
				$stm->bindValue(1, $secretaria, PDO::PARAM_STR);
				$stm->bindValue(2, $lugardetrabajo, PDO::PARAM_STR);
				$stm->bindValue(3, $fechaingreso, PDO::PARAM_STR);
				$stm->bindValue(4, $fecha_actual, PDO::PARAM_STR);
				$stm->bindValue(5, $sueldobasico, PDO::PARAM_STR);
				$stm->execute();

			}
			return $stm->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerPteMuniciapal(){
		try{
			$secretaria = 1;
			$sql = 'SELECT a.secretaria_id,a.secretaria_profesion,b.legempleado_apellido,b.legempleado_nombres,b.sexo_id,b.legempleado_firma FROM secretarias a, legajos b WHERE a.legempleado_id=b.legempleado_id AND a.secretaria_id = ?';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $secretaria, PDO::PARAM_STR);
			$stm->execute();

			return $stm->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerSecretario($secretariaid){
		try{
			if($secretariaid == 1){
				$secretariaid = 2;
			}else{
				//--- esta bien ---
			}
			$sql = 'SELECT a.secretaria_id,a.secretaria_nombre,a.secretaria_nombrec,a.secretaria_profesion,b.legempleado_apellido,b.legempleado_nombres,b.sexo_id,b.legempleado_firma FROM secretarias a, legajos b WHERE a.legempleado_id=b.legempleado_id AND a.secretaria_id = ?';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $secretariaid, PDO::PARAM_STR);
			$stm->execute();

			return $stm->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerSecretaria($secretaria){
		try{
			$sql = 'SELECT secretaria_nombre FROM secretarias WHERE secretaria_id = ? LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $secretaria, PDO::PARAM_STR);
			$stm->execute();

			return $stm->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function Obtener($id){
		try{
			$sql = 'SELECT * FROM legajos a,
			 											sexos b
											WHERE a.sexo_id = b.sexo_id
											  AND a.legempleado_id = ?';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $id, PDO::PARAM_STR);
			$stm->execute();

			return $stm->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
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
	public function RegistrarR($data){
		try{

			$sql = 'INSERT INTO legajos_reloj (legempleado_nrodocto,reloj_id,legreloj_semanal,marcacion_accessid,legreloj_lunes,legreloj_luneshe,legreloj_luneshs,legreloj_martes,legreloj_marteshe,legreloj_marteshs,legreloj_miercoles,legreloj_miercoleshe,legreloj_miercoleshs,legreloj_jueves,legreloj_jueveshe,legreloj_jueveshs,legreloj_viernes,legreloj_vierneshe,legreloj_vierneshs,legreloj_sabado,legreloj_sabadohe,legreloj_sabadohs,legreloj_domingo,legreloj_domingohe,legreloj_domingohs,legreloj_activo)
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


		}catch (Exception $e){
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
	/*
	//-------------- Tabla Hijos - Insert --------------------
	public function RegistrarH($data){
		try{

			$sql = 'INSERT INTO legajos_hijo (legempleado_nrodocto,leghijo_bentdoc,leghijo_benndoc,leghijo_bennoficio,leghijo_benapellido,leghijo_bennombres,leghijo_moptdoc,leghijo_mopndoc,leghijo_mopapellido,leghijo_mopnombres,leghijo_tipodocto,leghijo_nrodocto,leghijo_nrocuil,leghijo_apellido,leghijo_nombres,sexo_id,leghijo_fecnacto,leghijo_direccion,leghijo_direcnro,leghijo_direcpiso,pais_id,provincia_id,departamento_id,localidad_id,leghijo_codpostal,leghijo_disc,leghijo_esc,escuela_id,escnivel_id,escestado_id,leghijo_estado,leghijo_activo)
			VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1, 1)';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Empnrodocto, PDO::PARAM_STR);
			$stm->bindValue(2, $data->Hjobentdoc, PDO::PARAM_STR);
			$stm->bindValue(3, $data->Hjobenndoc, PDO::PARAM_STR);
			$stm->bindValue(4, $data->HjoOficio, PDO::PARAM_STR);
			$stm->bindValue(5, $data->Hjobenapellido, PDO::PARAM_STR);
			$stm->bindValue(6, $data->Hjobennombres, PDO::PARAM_STR);
			$stm->bindValue(7, $data->Hjomoptdoc, PDO::PARAM_STR);
			$stm->bindValue(8, $data->Hjomopndoc, PDO::PARAM_STR);
			$stm->bindValue(9, $data->Hjomopapellido, PDO::PARAM_STR);
			$stm->bindValue(10, $data->Hjomopnombres, PDO::PARAM_STR);
			$stm->bindValue(11, $data->Hjotdoc, PDO::PARAM_STR);
			$stm->bindValue(12, $data->Hjondoc, PDO::PARAM_STR);
			$stm->bindValue(13, $data->Hjonrocuil, PDO::PARAM_STR);
			$stm->bindValue(14, $data->Hjoapellido, PDO::PARAM_STR);
			$stm->bindValue(15, $data->Hjonombres, PDO::PARAM_STR);
			$stm->bindValue(16, $data->Hjosexo, PDO::PARAM_STR);
			$stm->bindValue(17, $data->Hjofecnacto, PDO::PARAM_STR);
			$stm->bindValue(18, $data->Hjodireccion, PDO::PARAM_STR);
			$stm->bindValue(19, $data->Hjodirecnro, PDO::PARAM_STR);
			$stm->bindValue(20, $data->Hjodirecpiso, PDO::PARAM_STR);
			$stm->bindValue(21, $data->Hjopais, PDO::PARAM_STR);
			$stm->bindValue(22, $data->Hjoprovincia, PDO::PARAM_STR);
			$stm->bindValue(23, $data->Hjodepartamento, PDO::PARAM_STR);
			$stm->bindValue(24, $data->Hjolocalidad, PDO::PARAM_STR);
			$stm->bindValue(25, $data->Hjocodpostal, PDO::PARAM_STR);
			$stm->bindValue(26, $data->Hjodisc, PDO::PARAM_STR);
			$stm->bindValue(27, $data->Hjoesc, PDO::PARAM_STR);
			$stm->bindValue(28, $data->Hjoescnom, PDO::PARAM_STR);
			$stm->bindValue(29, $data->Hjoescnvl, PDO::PARAM_STR);
			$stm->bindValue(30, $data->Hjoescest, PDO::PARAM_STR);
			//$stm->bindValue(31, $data->Hjoactivo, PDO::PARAM_STR);
			$stm->execute();
			//----------------obtner ultimo id Insertado -----------
			$ultimoid = $this->cn->lastInsertId();
			// ---------------Insert auditoria Hijos ------------
			$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];
			$ippublica = $_SERVER["REMOTE_ADDR"];
			$pcnombre = gethostbyaddr($_SERVER['REMOTE_ADDR']);
			$pcinformacion = $_SERVER['HTTP_USER_AGENT'];
			$sql ='INSERT INTO aud_legajos_hijo (AUD_leghijo_id,AUD_legempleado_nrodocto,AUD_leghijo_bentdoc,AUD_leghijo_benndoc,AUD_leghijo_bennoficio,AUD_leghijo_benapellido,AUD_leghijo_bennombres,AUD_leghijo_moptdoc,AUD_leghijo_mopndoc,AUD_leghijo_mopapellido,AUD_leghijo_mopnombres,AUD_leghijo_tipodocto,AUD_leghijo_nrodocto,AUD_leghijo_nrocuil,AUD_leghijo_apellido,AUD_leghijo_nombres,AUD_sexo_id,AUD_leghijo_fecnacto,AUD_leghijo_direccion,AUD_leghijo_direcnro,AUD_leghijo_direcpiso,AUD_pais_id,AUD_provincia_id,AUD_departamento_id,AUD_localidad_id,AUD_leghijo_codpostal,AUD_leghijo_disc,AUD_leghijo_esc,AUD_escuela_id,AUD_escnivel_id,AUD_escestado_id,AUD_leghijo_estado,AUD_leghijo_activo,AUD_leghijo_ippublica,AUD_leghijo_pcnombre,AUD_leghijo_pcinformacion,AUD_leghijo_accion,AUD_leghijo_datetime,AUD_leghijo_usuario) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1, 1, ?, ?, ?, "INSERT", NOW(), ?)';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $ultimoid, PDO::PARAM_STR);
			$stm->bindValue(2, $data->Empnrodocto, PDO::PARAM_STR);
			$stm->bindValue(3, $data->Hjobentdoc, PDO::PARAM_STR);
			$stm->bindValue(4, $data->Hjobenndoc, PDO::PARAM_STR);
			$stm->bindValue(5, $data->HjoOficio, PDO::PARAM_STR);
			$stm->bindValue(6, $data->Hjobenapellido, PDO::PARAM_STR);
			$stm->bindValue(7, $data->Hjobennombres, PDO::PARAM_STR);
			$stm->bindValue(8, $data->Hjomoptdoc, PDO::PARAM_STR);
			$stm->bindValue(9, $data->Hjomopndoc, PDO::PARAM_STR);
			$stm->bindValue(10, $data->Hjomopapellido, PDO::PARAM_STR);
			$stm->bindValue(11, $data->Hjomopnombres, PDO::PARAM_STR);
			$stm->bindValue(12, $data->Hjotdoc, PDO::PARAM_STR);
			$stm->bindValue(13, $data->Hjondoc, PDO::PARAM_STR);
			$stm->bindValue(14, $data->Hjonrocuil, PDO::PARAM_STR);
			$stm->bindValue(15, $data->Hjoapellido, PDO::PARAM_STR);
			$stm->bindValue(16, $data->Hjonombres, PDO::PARAM_STR);
			$stm->bindValue(17, $data->Hjosexo, PDO::PARAM_STR);
			$stm->bindValue(18, $data->Hjofecnacto, PDO::PARAM_STR);
			$stm->bindValue(19, $data->Hjodireccion, PDO::PARAM_STR);
			$stm->bindValue(20, $data->Hjodirecnro, PDO::PARAM_STR);
			$stm->bindValue(21, $data->Hjodirecpiso, PDO::PARAM_STR);
			$stm->bindValue(22, $data->Hjopais, PDO::PARAM_STR);
			$stm->bindValue(23, $data->Hjoprovincia, PDO::PARAM_STR);
			$stm->bindValue(24, $data->Hjodepartamento, PDO::PARAM_STR);
			$stm->bindValue(25, $data->Hjolocalidad, PDO::PARAM_STR);
			$stm->bindValue(26, $data->Hjocodpostal, PDO::PARAM_STR);
			$stm->bindValue(27, $data->Hjodisc, PDO::PARAM_STR);
			$stm->bindValue(28, $data->Hjoesc, PDO::PARAM_STR);
			$stm->bindValue(29, $data->Hjoescnom, PDO::PARAM_STR);
			$stm->bindValue(30, $data->Hjoescnvl, PDO::PARAM_STR);
			$stm->bindValue(31, $data->Hjoescest, PDO::PARAM_STR);
			$stm->bindValue(32, $ippublica, PDO::PARAM_STR);
			$stm->bindValue(33, $pcnombre, PDO::PARAM_STR);
			$stm->bindValue(34, $pcinformacion, PDO::PARAM_STR);
			$stm->bindValue(35, $usuario, PDO::PARAM_STR);
			$stm->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	*/
	//-------------- Tabla Hijos - UpDate --------------------
	/*
	public function ActualizarH($data){
		try{

			$sql = 'UPDATE legajos_hijo SET legempleado_nrodocto = ?, leghijo_bentdoc = ?, leghijo_benndoc = ?, leghijo_bennoficio = ?, leghijo_benapellido = ?, leghijo_bennombres = ?, leghijo_moptdoc = ?, leghijo_mopndoc = ?, leghijo_mopapellido = ?, leghijo_mopnombres = ?, leghijo_tipodocto = ?, leghijo_nrodocto = ?, leghijo_nrocuil = ?, leghijo_apellido = ?, leghijo_nombres = ?, sexo_id = ?, leghijo_fecnacto = ?, leghijo_direccion = ?, leghijo_direcnro = ?, leghijo_direcpiso = ?, pais_id = ?, provincia_id = ?, departamento_id = ?, localidad_id = ?, leghijo_codpostal = ?, leghijo_disc = ?, leghijo_esc = ?, escuela_id = ?, escnivel_id = ?, escestado_id = ? WHERE leghijo_id = ?';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Empnrodocto, PDO::PARAM_STR);
			$stm->bindValue(2, $data->Hjobentdoc, PDO::PARAM_STR);
			$stm->bindValue(3, $data->Hjobenndoc, PDO::PARAM_STR);
			$stm->bindValue(4, $data->HjoOficio, PDO::PARAM_STR);
			$stm->bindValue(5, $data->Hjobenapellido, PDO::PARAM_STR);
			$stm->bindValue(6, $data->Hjobennombres, PDO::PARAM_STR);
			$stm->bindValue(7, $data->Hjomoptdoc, PDO::PARAM_STR);
			$stm->bindValue(8, $data->Hjomopndoc, PDO::PARAM_STR);
			$stm->bindValue(9, $data->Hjomopapellido, PDO::PARAM_STR);
			$stm->bindValue(10, $data->Hjomopnombres, PDO::PARAM_STR);
			$stm->bindValue(11, $data->Hjotdoc, PDO::PARAM_STR);
			$stm->bindValue(12, $data->Hjondoc, PDO::PARAM_STR);
			$stm->bindValue(13, $data->Hjonrocuil, PDO::PARAM_STR);
			$stm->bindValue(14, $data->Hjoapellido, PDO::PARAM_STR);
			$stm->bindValue(15, $data->Hjonombres, PDO::PARAM_STR);
			$stm->bindValue(16, $data->Hjosexo, PDO::PARAM_STR);
			$stm->bindValue(17, $data->Hjofecnacto, PDO::PARAM_STR);
			$stm->bindValue(18, $data->Hjodireccion, PDO::PARAM_STR);
			$stm->bindValue(19, $data->Hjodirecnro, PDO::PARAM_STR);
			$stm->bindValue(20, $data->Hjodirecpiso, PDO::PARAM_STR);
			$stm->bindValue(21, $data->Hjopais, PDO::PARAM_STR);
			$stm->bindValue(22, $data->Hjoprovincia, PDO::PARAM_STR);
			$stm->bindValue(23, $data->Hjodepartamento, PDO::PARAM_STR);
			$stm->bindValue(24, $data->Hjolocalidad, PDO::PARAM_STR);
			$stm->bindValue(25, $data->Hjocodpostal, PDO::PARAM_STR);
			$stm->bindValue(26, $data->Hjodisc, PDO::PARAM_STR);
			$stm->bindValue(27, $data->Hjoesc, PDO::PARAM_STR);
			$stm->bindValue(28, $data->Hjoescnom, PDO::PARAM_STR);
			$stm->bindValue(29, $data->Hjoescnvl, PDO::PARAM_STR);
			$stm->bindValue(30, $data->Hjoescest, PDO::PARAM_STR);
			$stm->bindValue(31, $data->Id, PDO::PARAM_STR);
			$stm->execute();
			//----------Auditoria modificacion de hijos -----
			$sql = 'SELECT * FROM legajos_hijo WHERE leghijo_id = ? LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Id, PDO::PARAM_STR);
			$stm->execute();
			$row = $stm->fetch(PDO::FETCH_OBJ);
			//---------- Datos para la auditoria ----------------
			$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];
			$ippublica = $_SERVER["REMOTE_ADDR"];
			$pcnombre = gethostbyaddr($_SERVER['REMOTE_ADDR']);
			$pcinformacion = $_SERVER['HTTP_USER_AGENT'];

			$sql ='INSERT INTO aud_legajos_hijo (AUD_leghijo_id,AUD_legempleado_nrodocto,AUD_leghijo_bentdoc,AUD_leghijo_benndoc,AUD_leghijo_bennoficio,AUD_leghijo_benapellido,AUD_leghijo_bennombres,AUD_leghijo_moptdoc,AUD_leghijo_mopndoc,AUD_leghijo_mopapellido,AUD_leghijo_mopnombres,AUD_leghijo_tipodocto,AUD_leghijo_nrodocto,AUD_leghijo_nrocuil,AUD_leghijo_apellido,AUD_leghijo_nombres,AUD_sexo_id,AUD_leghijo_fecnacto,AUD_leghijo_direccion,AUD_leghijo_direcnro,AUD_leghijo_direcpiso,AUD_pais_id,AUD_provincia_id,AUD_departamento_id,AUD_localidad_id,AUD_leghijo_codpostal,AUD_leghijo_disc,AUD_leghijo_esc,AUD_escuela_id,AUD_escnivel_id,AUD_escestado_id,AUD_leghijo_estado,AUD_leghijo_activo,AUD_leghijo_ippublica,AUD_leghijo_pcnombre,AUD_leghijo_pcinformacion,AUD_leghijo_accion,AUD_leghijo_datetime,AUD_leghijo_usuario) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, "UPDATE", NOW(), ?)';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $row->leghijo_id, PDO::PARAM_STR);
			$stm->bindValue(2, $row->legempleado_nrodocto, PDO::PARAM_STR);
			$stm->bindValue(3, $row->leghijo_bentdoc, PDO::PARAM_STR);
			$stm->bindValue(4, $row->leghijo_benndoc, PDO::PARAM_STR);
			$stm->bindValue(5, $row->leghijo_bennoficio, PDO::PARAM_STR);
			$stm->bindValue(6, $row->leghijo_benapellido, PDO::PARAM_STR);
			$stm->bindValue(7, $row->leghijo_bennombres, PDO::PARAM_STR);
			$stm->bindValue(8, $row->leghijo_moptdoc, PDO::PARAM_STR);
			$stm->bindValue(9, $row->leghijo_mopndoc, PDO::PARAM_STR);
			$stm->bindValue(10, $row->leghijo_mopapellido, PDO::PARAM_STR);
			$stm->bindValue(11, $row->leghijo_mopnombres, PDO::PARAM_STR);
			$stm->bindValue(12, $row->leghijo_tipodocto, PDO::PARAM_STR);
			$stm->bindValue(13, $row->leghijo_nrodocto, PDO::PARAM_STR);
			$stm->bindValue(14, $row->leghijo_nrocuil, PDO::PARAM_STR);
			$stm->bindValue(15, $row->leghijo_apellido, PDO::PARAM_STR);
			$stm->bindValue(16, $row->leghijo_nombres, PDO::PARAM_STR);
			$stm->bindValue(17, $row->sexo_id, PDO::PARAM_STR);
			$stm->bindValue(18, $row->leghijo_fecnacto, PDO::PARAM_STR);
			$stm->bindValue(19, $row->leghijo_direccion, PDO::PARAM_STR);
			$stm->bindValue(20, $row->leghijo_direcnro, PDO::PARAM_STR);
			$stm->bindValue(21, $row->leghijo_direcpiso, PDO::PARAM_STR);
			$stm->bindValue(22, $row->pais_id, PDO::PARAM_STR);
			$stm->bindValue(23, $row->provincia_id, PDO::PARAM_STR);
			$stm->bindValue(24, $row->departamento_id, PDO::PARAM_STR);
			$stm->bindValue(25, $row->localidad_id, PDO::PARAM_STR);
			$stm->bindValue(26, $row->leghijo_codpostal, PDO::PARAM_STR);
			$stm->bindValue(27, $row->leghijo_disc, PDO::PARAM_STR);
			$stm->bindValue(28, $row->leghijo_esc, PDO::PARAM_STR);
			$stm->bindValue(29, $row->escuela_id, PDO::PARAM_STR);
			$stm->bindValue(30, $row->escnivel_id, PDO::PARAM_STR);
			$stm->bindValue(31, $row->escestado_id, PDO::PARAM_STR);
			$stm->bindValue(32, $row->leghijo_estado, PDO::PARAM_STR);
			$stm->bindValue(33, $row->leghijo_activo, PDO::PARAM_STR);
			$stm->bindValue(34, $ippublica, PDO::PARAM_STR);
			$stm->bindValue(35, $pcnombre, PDO::PARAM_STR);
			$stm->bindValue(36, $pcinformacion, PDO::PARAM_STR);
			$stm->bindValue(37, $usuario, PDO::PARAM_STR);
			$stm->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}*/
	//---- Eliminar Registro Tabla Hijos ----
	public function HijoEliminarExe($data){
		try{
			$sql = 'UPDATE legajos_hijo
								 SET leghijo_activo = ?
							 WHERE leghijo_id = ?';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Activo, PDO::PARAM_STR);
			$stm->bindValue(2, $data->Hijoid, PDO::PARAM_STR);
			$stm->execute();
			//----------Auditoria modificacion de hijos -----
			$sql = 'SELECT *
								FROM legajos_hijo
							 WHERE leghijo_id = ?
							 LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Hijoid, PDO::PARAM_STR);
			$stm->execute();
			$row = $stm->fetch(PDO::FETCH_OBJ);
			//---------- Datos para la auditoria ----------------
			$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];
			$ippublica = $_SERVER["REMOTE_ADDR"];
			$pcnombre = gethostbyaddr($_SERVER['REMOTE_ADDR']);
			$pcinformacion = $_SERVER['HTTP_USER_AGENT'];

			$sql ='INSERT INTO legajos_hijo_aud (AUD_leghijo_id,
																					 AUD_legempleado_nrodocto,
																					 AUD_legempleado_id_ben,
																					 AUD_leghijo_bentdoc,
																					 AUD_leghijo_benndoc,
																					 AUD_leghijo_bennoficio,
																					 AUD_leghijo_benapellido,
																					 AUD_leghijo_bennombres,
																					 AUD_leghijo_moptdoc,
																					 AUD_leghijo_mopndoc,
																					 AUD_leghijo_mopapellido,
																					 AUD_leghijo_mopnombres,
																					 AUD_leghijo_tipodocto,
																					 AUD_leghijo_nrodocto,
																					 AUD_leghijo_nrocuil,
																					 AUD_leghijo_apellido,
																					 AUD_leghijo_nombres,
																					 AUD_sexo_id,
																					 AUD_leghijo_fecnacto,
																					 AUD_leghijo_direccion,
																					 AUD_leghijo_direcnro,
																					 AUD_leghijo_direcpiso,
																					 AUD_pais_id,AUD_provincia_id,
																					 AUD_departamento_id,
																					 AUD_localidad_id,
																					 AUD_leghijo_codpostal,
																					 AUD_leghijo_disc,
																					 AUD_leghijo_esc,
																					 AUD_escuela_id,
																					 AUD_escnivel_id,
																					 AUD_escestado_id,
																					 AUD_leghijo_estado,
																					 AUD_leghijo_activo,
																					 AUD_leghijo_ippublica,
																					 AUD_leghijo_pcnombre,
																					 AUD_leghijo_pcinformacion,
																					 AUD_leghijo_accion,
																					 AUD_leghijo_observacion,
																					 AUD_leghijo_datetime,
																					 AUD_leghijo_usuario)
																	 VALUES (?,
																		 			 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 "DISABLE",
																					 "",
																					 NOW(),
																					 ?)';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $row->leghijo_id, PDO::PARAM_STR);
			$stm->bindValue(2, $row->legempleado_nrodocto, PDO::PARAM_STR);
			$stm->bindValue(3, $row->legempleado_id_ben, PDO::PARAM_STR);
			$stm->bindValue(4, $row->leghijo_bentdoc, PDO::PARAM_STR);
			$stm->bindValue(5, $row->leghijo_benndoc, PDO::PARAM_STR);
			$stm->bindValue(6, $row->leghijo_bennoficio, PDO::PARAM_STR);
			$stm->bindValue(7, $row->leghijo_benapellido, PDO::PARAM_STR);
			$stm->bindValue(8, $row->leghijo_bennombres, PDO::PARAM_STR);
			$stm->bindValue(9, $row->leghijo_moptdoc, PDO::PARAM_STR);
			$stm->bindValue(10, $row->leghijo_mopndoc, PDO::PARAM_STR);
			$stm->bindValue(11, $row->leghijo_mopapellido, PDO::PARAM_STR);
			$stm->bindValue(12, $row->leghijo_mopnombres, PDO::PARAM_STR);
			$stm->bindValue(13, $row->leghijo_tipodocto, PDO::PARAM_STR);
			$stm->bindValue(14, $row->leghijo_nrodocto, PDO::PARAM_STR);
			$stm->bindValue(15, $row->leghijo_nrocuil, PDO::PARAM_STR);
			$stm->bindValue(16, $row->leghijo_apellido, PDO::PARAM_STR);
			$stm->bindValue(17, $row->leghijo_nombres, PDO::PARAM_STR);
			$stm->bindValue(18, $row->sexo_id, PDO::PARAM_STR);
			$stm->bindValue(19, $row->leghijo_fecnacto, PDO::PARAM_STR);
			$stm->bindValue(20, $row->leghijo_direccion, PDO::PARAM_STR);
			$stm->bindValue(21, $row->leghijo_direcnro, PDO::PARAM_STR);
			$stm->bindValue(22, $row->leghijo_direcpiso, PDO::PARAM_STR);
			$stm->bindValue(23, $row->pais_id, PDO::PARAM_STR);
			$stm->bindValue(24, $row->provincia_id, PDO::PARAM_STR);
			$stm->bindValue(25, $row->departamento_id, PDO::PARAM_STR);
			$stm->bindValue(26, $row->localidad_id, PDO::PARAM_STR);
			$stm->bindValue(27, $row->leghijo_codpostal, PDO::PARAM_STR);
			$stm->bindValue(28, $row->leghijo_disc, PDO::PARAM_STR);
			$stm->bindValue(29, $row->leghijo_esc, PDO::PARAM_STR);
			$stm->bindValue(30, $row->escuela_id, PDO::PARAM_STR);
			$stm->bindValue(31, $row->escnivel_id, PDO::PARAM_STR);
			$stm->bindValue(32, $row->escestado_id, PDO::PARAM_STR);
			$stm->bindValue(33, $row->leghijo_estado, PDO::PARAM_STR);
			$stm->bindValue(34, $row->leghijo_activo, PDO::PARAM_STR);
			$stm->bindValue(35, $ippublica, PDO::PARAM_STR);
			$stm->bindValue(36, $pcnombre, PDO::PARAM_STR);
			$stm->bindValue(37, $pcinformacion, PDO::PARAM_STR);
			$stm->bindValue(38, $usuario, PDO::PARAM_STR);
			$stm->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function HijoDeshabilitarExe($data){
		try{

			$sql = 'UPDATE legajos_hijo
								 SET leghijo_estado = 2
							 WHERE leghijo_id = ?';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Hijoid, PDO::PARAM_STR);
			$stm->execute();
			//----------Auditoria modificacion de hijos -----
			$sql = 'SELECT *
								FROM legajos_hijo
							 WHERE leghijo_id = ?
							 LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Hijoid, PDO::PARAM_STR);
			$stm->execute();
			$row = $stm->fetch(PDO::FETCH_OBJ);
			//---------- Datos para la auditoria ----------------
			$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];
			$ippublica = $_SERVER["REMOTE_ADDR"];
			$pcnombre = gethostbyaddr($_SERVER['REMOTE_ADDR']);
			$pcinformacion = $_SERVER['HTTP_USER_AGENT'];

			$sql ='INSERT INTO legajos_hijo_aud (AUD_leghijo_id,
																					 AUD_legempleado_nrodocto,
																					 AUD_legempleado_id_ben,
																					 AUD_leghijo_bentdoc,
																					 AUD_leghijo_benndoc,
																					 AUD_leghijo_bennoficio,
																					 AUD_leghijo_benapellido,
																					 AUD_leghijo_bennombres,
																					 AUD_leghijo_moptdoc,
																					 AUD_leghijo_mopndoc,
																					 AUD_leghijo_mopapellido,
																					 AUD_leghijo_mopnombres,
																					 AUD_leghijo_tipodocto,
																					 AUD_leghijo_nrodocto,
																					 AUD_leghijo_nrocuil,
																					 AUD_leghijo_apellido,
																					 AUD_leghijo_nombres,
																					 AUD_sexo_id,
																					 AUD_leghijo_fecnacto,
																					 AUD_leghijo_direccion,
																					 AUD_leghijo_direcnro,
																					 AUD_leghijo_direcpiso,
																					 AUD_pais_id,AUD_provincia_id,
																					 AUD_departamento_id,
																					 AUD_localidad_id,
																					 AUD_leghijo_codpostal,
																					 AUD_leghijo_disc,
																					 AUD_leghijo_esc,
																					 AUD_escuela_id,
																					 AUD_escnivel_id,
																					 AUD_escestado_id,
																					 AUD_leghijo_estado,
																					 AUD_leghijo_activo,
																					 AUD_leghijo_ippublica,
																					 AUD_leghijo_pcnombre,
																					 AUD_leghijo_pcinformacion,
																					 AUD_leghijo_accion,
																					 AUD_leghijo_observacion,
																					 AUD_leghijo_datetime,
																					 AUD_leghijo_usuario)
																	 VALUES (?,
																		 			 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 "UPDATE",
																					 ?,
																					 NOW(),
																					 ?)';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $row->leghijo_id, PDO::PARAM_STR);
			$stm->bindValue(2, $row->legempleado_nrodocto, PDO::PARAM_STR);
			$stm->bindValue(3, $row->legempleado_id_ben, PDO::PARAM_STR);
			$stm->bindValue(4, $row->leghijo_bentdoc, PDO::PARAM_STR);
			$stm->bindValue(5, $row->leghijo_benndoc, PDO::PARAM_STR);
			$stm->bindValue(6, $row->leghijo_bennoficio, PDO::PARAM_STR);
			$stm->bindValue(7, $row->leghijo_benapellido, PDO::PARAM_STR);
			$stm->bindValue(8, $row->leghijo_bennombres, PDO::PARAM_STR);
			$stm->bindValue(9, $row->leghijo_moptdoc, PDO::PARAM_STR);
			$stm->bindValue(10, $row->leghijo_mopndoc, PDO::PARAM_STR);
			$stm->bindValue(11, $row->leghijo_mopapellido, PDO::PARAM_STR);
			$stm->bindValue(12, $row->leghijo_mopnombres, PDO::PARAM_STR);
			$stm->bindValue(13, $row->leghijo_tipodocto, PDO::PARAM_STR);
			$stm->bindValue(14, $row->leghijo_nrodocto, PDO::PARAM_STR);
			$stm->bindValue(15, $row->leghijo_nrocuil, PDO::PARAM_STR);
			$stm->bindValue(16, $row->leghijo_apellido, PDO::PARAM_STR);
			$stm->bindValue(17, $row->leghijo_nombres, PDO::PARAM_STR);
			$stm->bindValue(18, $row->sexo_id, PDO::PARAM_STR);
			$stm->bindValue(19, $row->leghijo_fecnacto, PDO::PARAM_STR);
			$stm->bindValue(20, $row->leghijo_direccion, PDO::PARAM_STR);
			$stm->bindValue(21, $row->leghijo_direcnro, PDO::PARAM_STR);
			$stm->bindValue(22, $row->leghijo_direcpiso, PDO::PARAM_STR);
			$stm->bindValue(23, $row->pais_id, PDO::PARAM_STR);
			$stm->bindValue(24, $row->provincia_id, PDO::PARAM_STR);
			$stm->bindValue(25, $row->departamento_id, PDO::PARAM_STR);
			$stm->bindValue(26, $row->localidad_id, PDO::PARAM_STR);
			$stm->bindValue(27, $row->leghijo_codpostal, PDO::PARAM_STR);
			$stm->bindValue(28, $row->leghijo_disc, PDO::PARAM_STR);
			$stm->bindValue(29, $row->leghijo_esc, PDO::PARAM_STR);
			$stm->bindValue(30, $row->escuela_id, PDO::PARAM_STR);
			$stm->bindValue(31, $row->escnivel_id, PDO::PARAM_STR);
			$stm->bindValue(32, $row->escestado_id, PDO::PARAM_STR);
			$stm->bindValue(33, $row->leghijo_estado, PDO::PARAM_STR);
			$stm->bindValue(34, $row->leghijo_activo, PDO::PARAM_STR);
			$stm->bindValue(35, $ippublica, PDO::PARAM_STR);
			$stm->bindValue(36, $pcnombre, PDO::PARAM_STR);
			$stm->bindValue(37, $pcinformacion, PDO::PARAM_STR);
			$stm->bindValue(38, $data->Observacion, PDO::PARAM_STR);
			$stm->bindValue(39, $usuario, PDO::PARAM_STR);
			$stm->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function HijoHabilitarExe($data){
		try{
			//----- habilitar la asignacion del hijo seleccionado ----
			$sql = 'UPDATE legajos_hijo
							   SET leghijo_estado = 1
							 WHERE leghijo_id = ?';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Hijoid, PDO::PARAM_STR);
			$stm->execute();
			//----------Auditoria modificacion de hijos -----
			$sql = 'SELECT *
								FROM legajos_hijo
							 WHERE leghijo_id = ?
							 LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Hijoid, PDO::PARAM_STR);
			$stm->execute();
			$row = $stm->fetch(PDO::FETCH_OBJ);
			//---------- Datos para la auditoria ----------------
			$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];
			$ippublica = $_SERVER["REMOTE_ADDR"];
			$pcnombre = gethostbyaddr($_SERVER['REMOTE_ADDR']);
			$pcinformacion = $_SERVER['HTTP_USER_AGENT'];

			$sql ='INSERT INTO legajos_hijo_aud (AUD_leghijo_id,
																					 AUD_legempleado_nrodocto,
																					 AUD_legempleado_id_ben,
																					 AUD_leghijo_bentdoc,
																					 AUD_leghijo_benndoc,
																					 AUD_leghijo_bennoficio,
																					 AUD_leghijo_benapellido,
																					 AUD_leghijo_bennombres,
																					 AUD_leghijo_moptdoc,
																					 AUD_leghijo_mopndoc,
																					 AUD_leghijo_mopapellido,
																					 AUD_leghijo_mopnombres,
																					 AUD_leghijo_tipodocto,
																					 AUD_leghijo_nrodocto,
																					 AUD_leghijo_nrocuil,
																					 AUD_leghijo_apellido,
																					 AUD_leghijo_nombres,
																					 AUD_sexo_id,
																					 AUD_leghijo_fecnacto,
																					 AUD_leghijo_direccion,
																					 AUD_leghijo_direcnro,
																					 AUD_leghijo_direcpiso,
																					 AUD_pais_id,AUD_provincia_id,
																					 AUD_departamento_id,
																					 AUD_localidad_id,
																					 AUD_leghijo_codpostal,
																					 AUD_leghijo_disc,
																					 AUD_leghijo_esc,
																					 AUD_escuela_id,
																					 AUD_escnivel_id,
																					 AUD_escestado_id,
																					 AUD_leghijo_estado,
																					 AUD_leghijo_activo,
																					 AUD_leghijo_ippublica,
																					 AUD_leghijo_pcnombre,
																					 AUD_leghijo_pcinformacion,
																					 AUD_leghijo_accion,
																					 AUD_leghijo_observacion,
																					 AUD_leghijo_datetime,
																					 AUD_leghijo_usuario)
																	 VALUES (?,
																		 			 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 ?,
																					 "UPDATE",
																					 "",
																					 NOW(),
																					 ?)';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $row->leghijo_id, PDO::PARAM_STR);
			$stm->bindValue(2, $row->legempleado_nrodocto, PDO::PARAM_STR);
			$stm->bindValue(3, $row->legempleado_id_ben, PDO::PARAM_STR);
			$stm->bindValue(4, $row->leghijo_bentdoc, PDO::PARAM_STR);
			$stm->bindValue(5, $row->leghijo_benndoc, PDO::PARAM_STR);
			$stm->bindValue(6, $row->leghijo_bennoficio, PDO::PARAM_STR);
			$stm->bindValue(7, $row->leghijo_benapellido, PDO::PARAM_STR);
			$stm->bindValue(8, $row->leghijo_bennombres, PDO::PARAM_STR);
			$stm->bindValue(9, $row->leghijo_moptdoc, PDO::PARAM_STR);
			$stm->bindValue(10, $row->leghijo_mopndoc, PDO::PARAM_STR);
			$stm->bindValue(11, $row->leghijo_mopapellido, PDO::PARAM_STR);
			$stm->bindValue(12, $row->leghijo_mopnombres, PDO::PARAM_STR);
			$stm->bindValue(13, $row->leghijo_tipodocto, PDO::PARAM_STR);
			$stm->bindValue(14, $row->leghijo_nrodocto, PDO::PARAM_STR);
			$stm->bindValue(15, $row->leghijo_nrocuil, PDO::PARAM_STR);
			$stm->bindValue(16, $row->leghijo_apellido, PDO::PARAM_STR);
			$stm->bindValue(17, $row->leghijo_nombres, PDO::PARAM_STR);
			$stm->bindValue(18, $row->sexo_id, PDO::PARAM_STR);
			$stm->bindValue(19, $row->leghijo_fecnacto, PDO::PARAM_STR);
			$stm->bindValue(20, $row->leghijo_direccion, PDO::PARAM_STR);
			$stm->bindValue(21, $row->leghijo_direcnro, PDO::PARAM_STR);
			$stm->bindValue(22, $row->leghijo_direcpiso, PDO::PARAM_STR);
			$stm->bindValue(23, $row->pais_id, PDO::PARAM_STR);
			$stm->bindValue(24, $row->provincia_id, PDO::PARAM_STR);
			$stm->bindValue(25, $row->departamento_id, PDO::PARAM_STR);
			$stm->bindValue(26, $row->localidad_id, PDO::PARAM_STR);
			$stm->bindValue(27, $row->leghijo_codpostal, PDO::PARAM_STR);
			$stm->bindValue(28, $row->leghijo_disc, PDO::PARAM_STR);
			$stm->bindValue(29, $row->leghijo_esc, PDO::PARAM_STR);
			$stm->bindValue(30, $row->escuela_id, PDO::PARAM_STR);
			$stm->bindValue(31, $row->escnivel_id, PDO::PARAM_STR);
			$stm->bindValue(32, $row->escestado_id, PDO::PARAM_STR);
			$stm->bindValue(33, $row->leghijo_estado, PDO::PARAM_STR);
			$stm->bindValue(34, $row->leghijo_activo, PDO::PARAM_STR);
			$stm->bindValue(35, $ippublica, PDO::PARAM_STR);
			$stm->bindValue(36, $pcnombre, PDO::PARAM_STR);
			$stm->bindValue(37, $pcinformacion, PDO::PARAM_STR);
			$stm->bindValue(38, $usuario, PDO::PARAM_STR);
			$stm->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerHijo($nrodocto){
		try{
			$sql = 'SELECT *
								FROM legajos_hijo a,
										 escuelas b,
										 escuelas_nivel c,
										 legajos d,
										 legajos_tipo e
							 WHERE a.escuela_id = b.escuela_id
							 	 AND a.escnivel_id = c.escnivel_id
								 AND a.legempleado_nrodocto = d.legempleado_nrodocto
								 AND a.leghijo_nrodocto = ?
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function HijosDeEmpleadoObtener($nrodocto){
		try{

			$sql = 'SELECT leghijo_id,
										 legempleado_nrodocto,
										 leghijo_benndoc
								FROM legajos_hijo
							 WHERE legempleado_nrodocto = ?';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function PrenatalesDeEmpleadoObtener($nrodocto){
		try{

			$sql = 'SELECT legprenatal_id,
										 legempleado_nrodocto,
										 legprenatal_benndoc
								FROM legajos_prenatal
							 WHERE legempleado_nrodocto = ?';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ConyugeDeEmpleadoObtener($nrodocto){
		try{

			$sql = 'SELECT legconyuge_id,
										 legempleado_nrodocto,
										 legconyuge_nrodocto
								FROM legajos_conyuge
							 WHERE legempleado_nrodocto = ?
							 	 AND legconyuge_activo = 1
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function AsignacionesUltimoRegistro(){
		try{
			$sql = $this->cn->prepare("SELECT *
																	 FROM asignaciones_familiares
															 ORDER BY asignacion_id
															 		 DESC
																	LIMIT 1");
			$sql->execute();
			return $sql->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function AsignacionInfoActualizar($nrodocto, $periodoid, $asignacioninfo){
		try{

			$sql = 'UPDATE asignaciones_familiares
								 SET asignacion_info = ?
							 WHERE legempleado_nrodocto = ?
							 	 AND periodo_id = ?';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $asignacioninfo, PDO::PARAM_STR);
			$stm->bindValue(2, $nrodocto, PDO::PARAM_STR);
			$stm->bindValue(3, $periodoid, PDO::PARAM_STR);
			$stm->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function AsignacionIdInfoActualizar($asignacionid, $periodoid, $asignacioninfo){
		try{

			$sql = 'UPDATE asignaciones_familiares
								 SET asignacion_info = ?
							 WHERE asignacion_id = ?
							 	 AND periodo_id = ?';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $asignacioninfo, PDO::PARAM_STR);
			$stm->bindValue(2, $asignacionid, PDO::PARAM_STR);
			$stm->bindValue(3, $periodoid, PDO::PARAM_STR);
			$stm->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function AsignacionPreNatalInformacion($prenatalid, $peridoid){
		try{

			$sql = 'SELECT asignacion_id,
										 legempleado_nrodocto,
										 legempleado_nrodocto_ben,
										 asigtipo_id,
										 asignacion_info
			          FROM asignaciones_familiares
							 WHERE asignacion_phc_id = ?
							   AND periodo_id = ?
								 AND asigtipo_id = 1
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $prenatalid, PDO::PARAM_STR);
			$dec->bindValue(2, $peridoid, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function AsignacionHijoInformacion($hijoid, $peridoid){
		try{

			$sql = 'SELECT asignacion_id,
										 legempleado_nrodocto,
										 legempleado_nrodocto_ben,
										 asigtipo_id,
										 asignacion_info
			          FROM asignaciones_familiares
							 WHERE asignacion_phc_id = ?
							   AND periodo_id = ?
								 AND asigtipo_id > 1
								 AND asigtipo_id < 8
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $hijoid, PDO::PARAM_STR);
			$dec->bindValue(2, $peridoid, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function AsignacionPrenatalObtener($prenatalid, $empndoc, $benndoc){
		try{

			$sql = 'SELECT *
			          FROM legajos_prenatal
							 WHERE legprenatal_id = ?
							 	 AND legempleado_nrodocto = ?
								 AND legprenatal_benndoc = ?
								 AND legprenatal_estado != 2
								 AND legprenatal_activo = 1
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $prenatalid, PDO::PARAM_STR);
			$dec->bindValue(2, $empndoc, PDO::PARAM_STR);
			$dec->bindValue(3, $benndoc, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function AsignacionHijoObtener_V($hijoid, $empndoc, $benndoc){
		try{

			$sql = 'SELECT *
			          FROM legajos_hijo_asignaciones
							 WHERE leghijo_id = ?
							 	 AND legempleado_nrodocto = ?
								 AND leghijo_benndoc = ?
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $hijoid, PDO::PARAM_STR);
			$dec->bindValue(2, $empndoc, PDO::PARAM_STR);
			$dec->bindValue(3, $benndoc, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function FamiliaNumerosaObtener_V($empndoc, $benndoc){
		try{

			$sql = 'SELECT COUNT(leghijo_id)
									AS asignacion_cantidad
			          FROM legajos_hijo_asignaciones
							 WHERE legempleado_nrodocto = ?
							 	 AND leghijo_benndoc = ?
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $empndoc, PDO::PARAM_STR);
			$dec->bindValue(2, $benndoc, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function AsignacionInfoPrenatalNueva($prenatalid, $titulo, $periodoid, $infotipo){
		try{

			$sql = 'SELECT *
			          FROM asignaciones_familiares_info
							 WHERE asignacion_phc_id = ?
							 	 AND periodo_id = ?
								 AND asigtipo_id = 1
								 AND asignacion_info_tipo = ?
								 AND asignacion_info_estado = 1
						ORDER BY asignacion_info_id
								DESC
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $prenatalid, PDO::PARAM_STR);
			$dec->bindValue(2, $periodoid, PDO::PARAM_STR);
			$dec->bindValue(3, $infotipo, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function AsignacionInfoHijoNueva($hijoid, $titulo, $periodoid, $infotipo){
		try{

			$sql = 'SELECT *
			          FROM asignaciones_familiares_info
							 WHERE asignacion_phc_id = ?
							 	 AND periodo_id = ?
								 AND asignacion_info_tipo = ?
								 AND asignacion_info_estado = 1
						ORDER BY asignacion_info_id
								DESC
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $hijoid, PDO::PARAM_STR);
			$dec->bindValue(2, $periodoid, PDO::PARAM_STR);
			$dec->bindValue(3, $infotipo, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ConyugeInfoNueva($cyeid, $periodoid, $infotipo){
		try{

			$sql = 'SELECT *
			          FROM asignaciones_familiares_info
							 WHERE asignacion_phc_id = ?
							 	 AND periodo_id = ?
								 AND asigtipo_id = 9
								 AND asignacion_info_tipo = ?
								 AND asignacion_info_estado = 1
						ORDER BY asignacion_info_id
								DESC
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $cyeid, PDO::PARAM_STR);
			$dec->bindValue(2, $periodoid, PDO::PARAM_STR);
			$dec->bindValue(3, $infotipo, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function FamNumInfoNueva($empndoc, $benndoc, $periodoid, $infotipo){
		try{

			$sql = 'SELECT *
			          FROM asignaciones_familiares_info
							 WHERE asignacion_phc_id = 0
							 	 AND legempleado_nrodocto = ?
								 AND legempleado_nrodocto_ben = ?
							 	 AND periodo_id = ?
								 AND asigtipo_id = 8
								 AND asignacion_info_tipo = ?
								 AND asignacion_info_estado = 1
						ORDER BY asignacion_info_id
								DESC
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $empndoc, PDO::PARAM_STR);
			$dec->bindValue(2, $benndoc, PDO::PARAM_STR);
			$dec->bindValue(3, $periodoid, PDO::PARAM_STR);
			$dec->bindValue(4, $infotipo, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function AsignacionInfoBaja($asiginfoid){
		try{

			$sql = 'UPDATE asignaciones_familiares_info SET asignacion_info_estado = 0
																								WHERE asignacion_info_id = ?';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $asiginfoid, PDO::PARAM_STR);
			$dec->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function AsignacionPrenatalUltimaObtener($prenatalid, $empndoc, $benndoc, $periodoid){
		try{

			$sql = 'SELECT *
			          FROM asignaciones_familiares
							 WHERE legempleado_nrodocto = ?
							 	 AND legempleado_nrodocto_ben = ?
							 	 AND asignacion_phc_id = ?
								 AND periodo_id = ?
								 AND asigtipo_id = 1
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $empndoc, PDO::PARAM_STR);
			$dec->bindValue(2, $benndoc, PDO::PARAM_STR);
			$dec->bindValue(3, $prenatalid, PDO::PARAM_STR);
			$dec->bindValue(4, $periodoid, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function AsignacionHijoUltimaObtener($hijoid, $empndoc, $benndoc, $periodoid){
		try{

			$sql = 'SELECT *
			          FROM asignaciones_familiares
							 WHERE legempleado_nrodocto = ?
							 	 AND legempleado_nrodocto_ben = ?
							 	 AND asignacion_phc_id = ?
								 AND periodo_id = ?
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $empndoc, PDO::PARAM_STR);
			$dec->bindValue(2, $benndoc, PDO::PARAM_STR);
			$dec->bindValue(3, $hijoid, PDO::PARAM_STR);
			$dec->bindValue(4, $periodoid, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function AsignacionConyugeUltimaObtener($empndoc, $cyendoc, $periodoid){
		try{

			$sql = 'SELECT *
			          FROM asignaciones_familiares
							 WHERE legempleado_nrodocto = ?
							 	 AND asignacion_phc_nrodocto = ?
								 AND periodo_id = ?
								 AND asigtipo_id = 9
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $empndoc, PDO::PARAM_STR);
			$dec->bindValue(2, $cyendoc, PDO::PARAM_STR);
			$dec->bindValue(3, $periodoid, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function FamiliaNumerosaUltimaObtener($empndoc, $benndoc, $periodoid){
		try{

			$sql = 'SELECT *
			          FROM asignaciones_familiares
							 WHERE legempleado_nrodocto = ?
							 	 AND legempleado_nrodocto_ben = ?
								 AND periodo_id = ?
								 AND asigtipo_id = 8
							 LIMIT 1';
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
	public function ObtenerContratoTipo($empdocto){
		try{
			$sql = 'SELECT 	b.legtipo_nombre FROM legajos a, legajos_tipo b WHERE a.legtipo_id = b.legtipo_id AND a.legempleado_nrodocto = ? ORDER BY a.legtipo_id DESC LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $empdocto, PDO::PARAM_STR);
			$stm->execute();

			return $stm->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerHijos($nrodocto){
		try{

			$sql = 'SELECT a.leghijo_id,
										 b.legempleado_nrodocto,
										 a.leghijo_bentdoc,
										 a.leghijo_benndoc,
										 a.leghijo_benapellido,
										 a.leghijo_bennombres,
										 a.leghijo_moptdoc,
										 a.leghijo_mopndoc,
										 a.leghijo_mopapellido,
										 a.leghijo_mopnombres,
										 a.leghijo_tipodocto,
										 a.leghijo_nrodocto,
										 a.leghijo_nrocuil,
										 a.leghijo_apellido,
										 a.leghijo_nombres,
										 a.sexo_id,
										 a.leghijo_fecnacto,
										 a.leghijo_direccion,
										 a.leghijo_direcnro,
										 a.leghijo_direcpiso,
										 a.pais_id,
										 a.provincia_id,
										 a.departamento_id,
										 a.localidad_id,
										 a.leghijo_codpostal,
										 a.leghijo_disc,
										 a.leghijo_esc,
										 c.escuela_id,
										 c.escuela_nombre,
										 d.escnivel_id,
										 d.escnivel_nombre,
										 e.escestado_id,
										 e.escestado_nombre,
										 a.leghijo_activo
								FROM legajos_hijo a,
										 legajos b,
										 escuelas c,
										 escuelas_nivel d,
										 escuelas_estado e
							 WHERE a.legempleado_nrodocto = b.legempleado_nrodocto
							 	 AND a.escuela_id = c.escuela_id
								 AND a.escnivel_id = d.escnivel_id
								 AND a.escestado_id = e.escestado_id
								 AND a.legempleado_nrodocto = ?
								 AND a.leghijo_activo = ?';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$dec->bindValue(2, 1, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetchAll(PDO::FETCH_OBJ);

		} catch (Exception $e)
		{
			die($e->getMessage());
		}
	}

	public function ObtenerPreNatal($empleadonrodocto){
		try{
			$sql = 'SELECT *
								FROM legajos_prenatal
							 WHERE legempleado_nrodocto = ?
							 	 AND legprenatal_estado != 2
							 	 AND legprenatal_activo = 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $empleadonrodocto, PDO::PARAM_STR);
			$dec->execute();

			return $dec->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerHijosEscolares($empleadonrodocto, $escuelanivel){
		try{
			$sql = 'SELECT *
								FROM legajos_hijo a,
										 escuelas b
							 WHERE a.escuela_id = b.escuela_id
								 AND a.legempleado_nrodocto = ?
								 AND a.escnivel_id = ?
								 AND a.leghijo_disc != 1
								 AND a.leghijo_esc = 1
								 AND a.leghijo_estado != 2
								 AND a.leghijo_activo = 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $empleadonrodocto, PDO::PARAM_STR);
			$stm->bindValue(2, $escuelanivel, PDO::PARAM_STR);
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerHijosEscolares2($id){
		try{
			$datosempleado = Empleado::Obtener($id);
			$empleadonrodocto = $datosempleado->legempleado_nrodocto;

			$sql = 'SELECT *
								FROM legajos_hijo a,
										 escuelas b
							 WHERE a.escuela_id = b.escuela_id
								 AND a.legempleado_nrodocto = ?
								 AND a.leghijo_esc = 1
								 AND a.leghijo_activo = 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $empleadonrodocto, PDO::PARAM_STR);
			$stm->execute();
			return $stm->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerHijosConCapacidadesDiferentes($empleadonrodocto){
		try{
			$sql = 'SELECT *
								FROM legajos_hijo
							 WHERE legempleado_nrodocto = ?
							   AND leghijo_disc = 1
								 AND leghijo_esc != 1
								 AND leghijo_estado != 2
								 AND leghijo_activo = 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $empleadonrodocto, PDO::PARAM_STR);
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerHijosEscConCapacidadesDiferentes($empleadonrodocto){
		try{
			$sql = 'SELECT *
								FROM legajos_hijo a,
										 escuelas b
							 WHERE a.escuela_id = b.escuela_id
								 AND a.legempleado_nrodocto = ?
								 AND a.leghijo_disc = 1
								 AND a.leghijo_esc = 1
								 AND a.leghijo_estado != 2
								 AND a.leghijo_activo = 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $empleadonrodocto, PDO::PARAM_STR);
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerHijosAsignacionDeshabilitada($empleadonrodocto){
		try{

			$sql = 'SELECT * FROM legajos_hijo WHERE legempleado_nrodocto = ? AND leghijo_estado = 2';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $empleadonrodocto, PDO::PARAM_STR);
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerHijosSinAsignacion($empleadonrodocto, $fechaactual, $fechafinal){
		try{
			$sql = 'SELECT * FROM legajos_hijo WHERE legempleado_nrodocto = ? AND leghijo_disc != 1 AND leghijo_esc != 1 AND leghijo_activo = 1 AND leghijo_fecnacto NOT BETWEEN ? AND ?';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $empleadonrodocto, PDO::PARAM_STR);
			$stm->bindValue(2, $fechafinal, PDO::PARAM_STR);
			$stm->bindValue(3, $fechaactual, PDO::PARAM_STR);
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
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
	public function RegistrarContrato($data){
		try{

			$sql = 'INSERT INTO legajos_contrato (legempleado_nrodocto,legcontrato_fecinicio,legcontrato_fecfin,imputacion_id,impdependencia_id,secretaria_id,trabajo_id,legcontrato_tarea,legcontrato_sbasico,legcontrato_activo,contrato_modelo_id)
			VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, 1,?)';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->EmpNroDocto, PDO::PARAM_STR);
			//$stm->bindValue(2, $data->EmpTipoLegajoAdd, PDO::PARAM_STR);
			$stm->bindValue(2, $data->EmpFechaInicioAdd, PDO::PARAM_STR);
			$stm->bindValue(3, $data->EmpFechaFinalizacionAdd, PDO::PARAM_STR);
			$stm->bindValue(4, $data->EmpImputacionAdd, PDO::PARAM_STR);
			$stm->bindValue(5, $data->EmpDependenciaAdd, PDO::PARAM_STR);
			$stm->bindValue(6, $data->EmpSecretariaAdd, PDO::PARAM_STR);
			//$stm->bindValue(8, $data->EmpCategoriaAdd, PDO::PARAM_STR);
			$stm->bindValue(7, $data->EmpLugarDeTrabajoAdd, PDO::PARAM_STR);
			$stm->bindValue(8, $data->EmpTareaAdd, PDO::PARAM_STR);
			$stm->bindValue(9, $data->EmpSueldoBasicoAdd, PDO::PARAM_STR);
			$stm->bindValue(10,$data->EmpModeloContrato,PDO::PARAM_STR);
			$stm->execute();

			$sql = 'UPDATE legajos SET legtipo_id = ? WHERE legempleado_nrodocto = ?';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->EmpTipoLegajoAdd, PDO::PARAM_STR);
			$stm->bindValue(2, $data->EmpNroDocto, PDO::PARAM_STR);
			$stm->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function GuardarProveedorExe($data){
		try{
			//-------- Cambiar tipo de legajo de 0 a 4 (proveedor) ------
			$sql = 'UPDATE legajos SET legtipo_id = 4 WHERE legempleado_nrodocto = ?';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Empnrodocto, PDO::PARAM_STR);
			$stm->execute();
			//------ Alta de contrato de proveedor ---------
			$sql = 'INSERT INTO legajos_proveedor (legempleado_nrodocto,legproveedor_fecinicio,legproveedor_fecfin,secretaria_id,trabajo_id,legproveedor_tarea,legproveedor_sbasico,contrato_modelo_id,legproveedor_activo)
			VALUES(?, ?, ?, ?, ?, ?, ?, ?, 1)';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Empnrodocto, PDO::PARAM_STR);
			$stm->bindValue(2, $data->Empprofechainicioadd, PDO::PARAM_STR);
			$stm->bindValue(3, $data->Empprofechafinaladd, PDO::PARAM_STR);
			$stm->bindValue(4, $data->Empprosecretariaadd, PDO::PARAM_STR);
			$stm->bindValue(5, $data->Empprotrabajoadd, PDO::PARAM_STR);
			$stm->bindValue(6, $data->Empprotareaadd, PDO::PARAM_STR);
			$stm->bindValue(7, $data->Empprosueldobasicoadd, PDO::PARAM_STR);
			$stm->bindValue(8, $data->EmpModeloContrato, PDO::PARAM_STR);
			$stm->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ActualizarContrato($data){
		try{

			$sql = 'UPDATE legajos_contrato SET legempleado_nrodocto = ?, legcontrato_fecinicio = ?, legcontrato_fecfin = ?, imputacion_id = ?, impdependencia_id = ?, secretaria_id = ?, trabajo_id = ?, legcontrato_tarea = ?, legcontrato_sbasico = ?, contrato_modelo_id = ?, legcontrato_activo = 1 WHERE legcontrato_id = ?';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->EmpNroDocto, PDO::PARAM_STR);
			$stm->bindValue(2, $data->EmpFechaInicioAdd, PDO::PARAM_STR);
			$stm->bindValue(3, $data->EmpFechaFinalizacionAdd, PDO::PARAM_STR);
			$stm->bindValue(4, $data->EmpImputacionAdd, PDO::PARAM_STR);
			$stm->bindValue(5, $data->EmpDependenciaAdd, PDO::PARAM_STR);
			$stm->bindValue(6, $data->EmpSecretariaAdd, PDO::PARAM_STR);
			$stm->bindValue(7, $data->EmpLugarDeTrabajoAdd, PDO::PARAM_STR);
			$stm->bindValue(8, $data->EmpTareaAdd, PDO::PARAM_STR);
			$stm->bindValue(9, $data->EmpSueldoBasicoAdd, PDO::PARAM_STR);
			$stm->bindValue(10, $data->EmpModeloContrato, PDO::PARAM_STR);

			$stm->bindValue(11, $data->ContratoId, PDO::PARAM_STR);

			$stm->execute();
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ActualizarProveedorExe($data){
		try{

			$sql = 'UPDATE legajos_proveedor SET legempleado_nrodocto = ?, legproveedor_fecinicio = ?, legproveedor_fecfin = ?, secretaria_id = ?, trabajo_id = ?, legproveedor_tarea = ?, legproveedor_sbasico = ?, contrato_modelo_id = ?, legproveedor_activo = 1 WHERE legproveedor_id = ?';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Empnrodocto, PDO::PARAM_STR);
			$stm->bindValue(2, $data->Empprofechainicioadd, PDO::PARAM_STR);
			$stm->bindValue(3, $data->Empprofechafinaladd, PDO::PARAM_STR);
			$stm->bindValue(4, $data->Empprosecretariaadd, PDO::PARAM_STR);
			$stm->bindValue(5, $data->Empprotrabajoadd, PDO::PARAM_STR);
			$stm->bindValue(6, $data->Empprotareaadd, PDO::PARAM_STR);
			$stm->bindValue(7, $data->Empprosueldobasicoadd, PDO::PARAM_STR);
			$stm->bindValue(8, $data->EmpModeloContrato, PDO::PARAM_STR);
			$stm->bindValue(9, $data->Empcontratoproid, PDO::PARAM_STR);


			$stm->execute();
		}catch (Exception $e){
			die($e->getMessage());
		}
	}

	public function ActualizarPPermanente($data){
		try{

			$imputacion = 2;
			$sql = 'UPDATE legajos_ppermanente SET legempleado_nrodocto = ?, imputacion_id = ?, secretaria_id = ?, trabajo_id = ?, legppermanente_categoria = ?, legppermanente_tarea = ?, legppermanente_fecantiguedad = ?, legppermanente_activo = 1 WHERE legppermanente_id = ?';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Empcppnrodocto, PDO::PARAM_STR);
			$stm->bindValue(2, $imputacion, PDO::PARAM_STR);
			$stm->bindValue(3, $data->Empcppsecretaria, PDO::PARAM_STR);
			$stm->bindValue(4, $data->Empcppltrabajo, PDO::PARAM_STR);
			$stm->bindValue(5, $data->Empcppcategoria, PDO::PARAM_STR);
			$stm->bindValue(6, $data->Empcpptarea, PDO::PARAM_STR);
			$stm->bindValue(7, $data->Empcppfecantiguedad, PDO::PARAM_STR);
			$stm->bindValue(8, $data->Empcppid, PDO::PARAM_STR);
			$stm->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ActualizarCJornalero($data){
		try{

			$imputacion = 2;
			$sql = 'UPDATE legajos_jornalero SET legempleado_nrodocto = ?, imputacion_id = ?, secretaria_id = ?, trabajo_id = ?, legjornalero_tarea = ?, legjornalero_fecantiguedad = ?, legjornalero_activo = 1 WHERE legjornalero_id = ?';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Empcjornrodocto, PDO::PARAM_STR);
			$stm->bindValue(2, $imputacion, PDO::PARAM_STR);
			$stm->bindValue(3, $data->Empcjorsecretaria2, PDO::PARAM_STR);
			$stm->bindValue(4, $data->Empcjorltrabajo, PDO::PARAM_STR);
			$stm->bindValue(5, $data->Empcjortarea, PDO::PARAM_STR);
			$stm->bindValue(6, $data->Empcjorfecantiguedad, PDO::PARAM_STR);
			$stm->bindValue(7, $data->Empcjorid, PDO::PARAM_STR);
			$stm->execute();

		}catch (Exception $e){
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
	public function GuardarEmpleadoExe($data){
		try{
			//--------- Insert de empleados -------------
			$sql = 'INSERT INTO legajos (legempleado_numerop,
																						legempleado_tipodocto,
																						legempleado_nrodocto,
																						legempleado_nrocuil,
																						legempleado_apellido,
																						legempleado_nombres,
																						sexo_id,
																						legempleado_fecnacto,
																						estcivil_id,
																						legempleado_direccion,
																						legempleado_direcnro,
																						legempleado_direcpiso,
																						legempleado_celular,
																						legempleado_telefono,
																						legempleado_email,
																						pais_id,provincia_id,
																						departamento_id,
																						localidad_id,
																						legempleado_codpostal,
																						legempleado_fecingreso,
																						legtipo_id,
																						legempleado_activo)
																		 VALUES(:emplegajo,
																			 			:emptdoc,
																						:empndoc,
																						:empncuil,
																						:empapellido,
																						:empnombres,
																						:empsexo,
																						:empfecnacto,
																						:empecivil,
																						:empdireccion,
																						:empdirecnro,
																						:empdirecpiso,
																						:empcelular,
																						:emptelefono,
																						:empemail,
																						:emppais,
																						:empprovincia,
																						:empdepartamento,
																						:emplocalidad,
																						:empcpostal,
																						:empfecing,
																						:emptleg,
																						1)';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(':emplegajo', $data->Empnrolegajo, PDO::PARAM_STR);
			$stm->bindValue(':emptdoc', $data->Emptdoc, PDO::PARAM_STR);
			$stm->bindValue(':empndoc', $data->Empnrodocumento, PDO::PARAM_STR);
			$stm->bindValue(':empncuil', $data->Empcuil, PDO::PARAM_STR);
			$stm->bindValue(':empapellido', $data->Empapellido, PDO::PARAM_STR);
			$stm->bindValue(':empnombres', $data->Empnombres, PDO::PARAM_STR);
			$stm->bindValue(':empsexo', $data->Empsexotres, PDO::PARAM_STR);
			$stm->bindValue(':empfecnacto', $data->Empfecnacto, PDO::PARAM_STR);
			$stm->bindValue(':empecivil', $data->Empestcivil, PDO::PARAM_STR);
			$stm->bindValue(':empdireccion', $data->Empdireccion, PDO::PARAM_STR);
			$stm->bindValue(':empdirecnro', $data->Empdirecnro, PDO::PARAM_STR);
			$stm->bindValue(':empdirecpiso', $data->Empdirecpiso, PDO::PARAM_STR);
			$stm->bindValue(':empcelular', $data->Empcelular, PDO::PARAM_STR);
			$stm->bindValue(':emptelefono', $data->Emptelefono, PDO::PARAM_STR);
			$stm->bindValue(':empemail', $data->Empemail, PDO::PARAM_STR);
			$stm->bindValue(':emppais', $data->Emppais, PDO::PARAM_STR);
			$stm->bindValue(':empprovincia', $data->Empprovincia, PDO::PARAM_STR);
			$stm->bindValue(':empdepartamento', $data->Empdepartamento, PDO::PARAM_STR);
			$stm->bindValue(':emplocalidad', $data->Emplocalidad, PDO::PARAM_STR);
			$stm->bindValue(':empcpostal', $data->Empcpostal, PDO::PARAM_STR);
			$stm->bindValue(':empfecing', $data->Empfecing, PDO::PARAM_STR);
			$stm->bindValue(':emptleg', $data->Emptleg, PDO::PARAM_STR);
			$stm->execute();
			//----------------obtner ultimo id Insertado -----------
			$ultimoid = $this->cn->lastInsertId();
			// ---------------Insert auditoria  empleado ------------
			$sql = 'SELECT * FROM legajos WHERE legempleado_id = ? LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $ultimoid, PDO::PARAM_STR);
			$stm->execute();
			$row = $stm->fetch(PDO::FETCH_OBJ);

			$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];
			$ippublica = $_SERVER["REMOTE_ADDR"];
			$pcnombre = gethostbyaddr($_SERVER['REMOTE_ADDR']);
			$pcinformacion = $_SERVER['HTTP_USER_AGENT'];

			$sql ='INSERT INTO aud_legajos (AUD_legempleado_id,
																							 AUD_legempleado_numerop,
																							 AUD_legempleado_numerol,
																							 AUD_legempleado_tipodocto,
																							 AUD_legempleado_nrodocto,
																							 AUD_legempleado_nrocuil,
																							 AUD_legempleado_apellido,
																							 AUD_legempleado_nombres,
																							 AUD_sexo_id,
																							 AUD_legempleado_fecnacto,
																							 AUD_estcivil_id,
																							 AUD_legempleado_direccion,
																							 AUD_legempleado_direcnro,
																							 AUD_legempleado_direcpiso,
																							 AUD_legempleado_celular,
																							 AUD_legempleado_telefono,
																							 AUD_legempleado_email,
																							 AUD_pais_id,
																							 AUD_provincia_id,
																							 AUD_departamento_id,
																							 AUD_localidad_id,
																							 AUD_legempleado_codpostal,
																							 AUD_legempleado_fecingreso,
																							 AUD_legempleado_fecbaja,
																							 AUD_legempleado_imagen,
																							 AUD_legtipo_id,
																							 AUD_legempleado_activo,
																							 AUD_legempleado_observacion,
																							 AUD_legempleado_ippublica,
																							 AUD_legempleado_pcnombre,
																							 AUD_legempleado_pcinformacion,
																							 AUD_legempleado_accion,
																							 AUD_legempleado_datetime,
																						 	 AUD_legempleado_usuario)
																			 VALUES (:empid,
																				 			 :emplegajop,
																							 :emplegajol,
																							 :emptdoc,
																							 :empndoc,
																							 :empncuil,
																							 :empapellido,
																							 :empnombres,
																							 :empsexo,
																							 :empfecnacto,
																							 :empecivil,
																							 :empdireccion,
																							 :empdirecnro,
																							 :empdirecpiso,
																							 :empcelular,
																							 :emptelefono,
																							 :empemail,
																							 :emppais,
																							 :empprovincia,
																							 :empdepartamento,
																							 :emplocalidad,
																							 :empcpostal,
																							 :empfecing,
																							 :empfecbaja,
																							 :empimagen,
																							 :emptipoid,
																							 :empactivo,
																							 "",
																							 :empippublica,
																							 :emppcnombre,
																							 :emppcinformacion,
																							 "INSERT",
																							 NOW(),
																							 :empusuario)';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(':empid', $row->legempleado_id, PDO::PARAM_STR);
			$stm->bindValue(':emplegajop', $row->legempleado_numerop, PDO::PARAM_STR);
			$stm->bindValue(':emplegajol', $row->legempleado_numerol, PDO::PARAM_STR);
			$stm->bindValue(':emptdoc', $row->legempleado_tipodocto, PDO::PARAM_STR);
			$stm->bindValue(':empndoc', $row->legempleado_nrodocto, PDO::PARAM_STR);
			$stm->bindValue(':empncuil', $row->legempleado_nrocuil, PDO::PARAM_STR);
			$stm->bindValue(':empapellido', $row->legempleado_apellido, PDO::PARAM_STR);
			$stm->bindValue(':empnombres', $row->legempleado_nombres, PDO::PARAM_STR);
			$stm->bindValue(':empsexo', $row->sexo_id, PDO::PARAM_STR);
			$stm->bindValue(':empfecnacto', $row->legempleado_fecnacto, PDO::PARAM_STR);
			$stm->bindValue(':empecivil', $row->estcivil_id, PDO::PARAM_STR);
			$stm->bindValue(':empdireccion', $row->legempleado_direccion, PDO::PARAM_STR);
			$stm->bindValue(':empdirecnro', $row->legempleado_direcnro, PDO::PARAM_STR);
			$stm->bindValue(':empdirecpiso', $row->legempleado_direcpiso, PDO::PARAM_STR);
			$stm->bindValue(':empcelular', $row->legempleado_celular, PDO::PARAM_STR);
			$stm->bindValue(':emptelefono', $row->legempleado_telefono, PDO::PARAM_STR);
			$stm->bindValue(':empemail', $row->legempleado_email, PDO::PARAM_STR);
			$stm->bindValue(':emppais', $row->pais_id, PDO::PARAM_STR);
			$stm->bindValue(':empprovincia', $row->provincia_id, PDO::PARAM_STR);
			$stm->bindValue(':empdepartamento', $row->departamento_id, PDO::PARAM_STR);
			$stm->bindValue(':emplocalidad', $row->localidad_id, PDO::PARAM_STR);
			$stm->bindValue(':empcpostal', $row->legempleado_codpostal, PDO::PARAM_STR);
			$stm->bindValue(':empfecing', $row->legempleado_fecingreso, PDO::PARAM_STR);
			$stm->bindValue(':empfecbaja', $row->legempleado_fecbaja, PDO::PARAM_STR);
			$stm->bindValue(':empimagen', $row->legempleado_imagen, PDO::PARAM_STR);
			$stm->bindValue(':emptipoid', $row->legtipo_id, PDO::PARAM_STR);
			$stm->bindValue(':empactivo', $row->legempleado_activo, PDO::PARAM_STR);
			$stm->bindValue(':empippublica', $ippublica, PDO::PARAM_STR);
			$stm->bindValue(':emppcnombre', $pcnombre, PDO::PARAM_STR);
			$stm->bindValue(':emppcinformacion', $pcinformacion, PDO::PARAM_STR);
			$stm->bindValue(':empusuario', $usuario, PDO::PARAM_STR);
			$stm->execute();

			return $ultimoid;

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ActualizarEmpleadoExe($data){
		try{

			/*$sql = 'UPDATE legajos SET legempleado_numerop = ?,
																					legempleado_nrodocto = ?,
																					legempleado_nrocuil = ?,
																					legempleado_apellido = ?,
																					legempleado_nombres = ?,
																					sexo_id = ?,
																					legempleado_fecnacto = ?,
																					estcivil_id = ?,
																					legempleado_fecingreso = ?,
																					legtipo_id = 0,
																					legempleado_activo = 1
																		WHERE legempleado_id = ?';
																		*/
			$sql = 'UPDATE legajos SET legempleado_numerop = ?,
																					legempleado_nrodocto = ?,
																					legempleado_nrocuil = ?,
																					legempleado_apellido = ?,
																					legempleado_nombres = ?,
																					sexo_id = ?,
																					legempleado_fecnacto = ?,
																					estcivil_id = ?,
																					legempleado_fecingreso = ?,
																					legempleado_activo = 1
																		WHERE legempleado_id = ?';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Empnrolegajo, PDO::PARAM_STR);
			$stm->bindValue(2, $data->Empnrodocumento, PDO::PARAM_STR);
			$stm->bindValue(3, $data->Empcuil, PDO::PARAM_STR);
			$stm->bindValue(4, $data->Empapellido, PDO::PARAM_STR);
			$stm->bindValue(5, $data->Empnombres, PDO::PARAM_STR);
			$stm->bindValue(6, $data->Empsexotres, PDO::PARAM_STR);
			$stm->bindValue(7, $data->Empfecnacto, PDO::PARAM_STR);
			$stm->bindValue(8, $data->Empestcivil, PDO::PARAM_STR);
			$stm->bindValue(9, $data->Empfecing, PDO::PARAM_STR);
			$stm->bindValue(10, $data->Empid, PDO::PARAM_STR);
			$stm->execute();

			// ---------------Insert auditoria  empleado ------------
			$sql = 'SELECT * FROM legajos WHERE legempleado_id = ? LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Empid, PDO::PARAM_STR);
			$stm->execute();
			$row = $stm->fetch(PDO::FETCH_OBJ);

			$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];
			$ippublica = $_SERVER["REMOTE_ADDR"];
			$pcnombre = gethostbyaddr($_SERVER['REMOTE_ADDR']);
			$pcinformacion = $_SERVER['HTTP_USER_AGENT'];

			$sql ='INSERT INTO aud_legajos (AUD_legempleado_id,
																							 AUD_legempleado_numerop,
																							 AUD_legempleado_numerol,
																							 AUD_legempleado_tipodocto,
																							 AUD_legempleado_nrodocto,
																							 AUD_legempleado_nrocuil,
																							 AUD_legempleado_apellido,
																							 AUD_legempleado_nombres,
																							 AUD_sexo_id,
																							 AUD_legempleado_fecnacto,
																							 AUD_estcivil_id,
																							 AUD_legempleado_direccion,
																							 AUD_legempleado_direcnro,
																							 AUD_legempleado_direcpiso,
																							 AUD_legempleado_celular,
																							 AUD_legempleado_telefono,
																							 AUD_legempleado_email,
																							 AUD_pais_id,
																							 AUD_provincia_id,
																							 AUD_departamento_id,
																							 AUD_localidad_id,
																							 AUD_legempleado_codpostal,
																							 AUD_legempleado_fecingreso,
																							 AUD_legempleado_fecbaja,
																							 AUD_legempleado_imagen,
																							 AUD_legtipo_id,
																							 AUD_legempleado_activo,
																							 AUD_legempleado_observacion,
																							 AUD_legempleado_ippublica,
																							 AUD_legempleado_pcnombre,
																							 AUD_legempleado_pcinformacion,
																							 AUD_legempleado_accion,
																							 AUD_legempleado_datetime,
																						 	 AUD_legempleado_usuario)
																			 VALUES (:empid,
																				 			 :emplegajop,
																							 :emplegajol,
																							 :emptdoc,
																							 :empndoc,
																							 :empncuil,
																							 :empapellido,
																							 :empnombres,
																							 :empsexo,
																							 :empfecnacto,
																							 :empecivil,
																							 :empdireccion,
																							 :empdirecnro,
																							 :empdirecpiso,
																							 :empcelular,
																							 :emptelefono,
																							 :empemail,
																							 :emppais,
																							 :empprovincia,
																							 :empdepartamento,
																							 :emplocalidad,
																							 :empcpostal,
																							 :empfecing,
																							 :empfecbaja,
																							 :empimagen,
																							 :emptipoid,
																							 :empactivo,
																							 "",
																							 :empippublica,
																							 :emppcnombre,
																							 :emppcinformacion,
																							 "UPDATE",
																							 NOW(),
																							 :empusuario)';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(':empid', $row->legempleado_id, PDO::PARAM_STR);
			$stm->bindValue(':emplegajop', $row->legempleado_numerop, PDO::PARAM_STR);
			$stm->bindValue(':emplegajol', $row->legempleado_numerol, PDO::PARAM_STR);
			$stm->bindValue(':emptdoc', $row->legempleado_tipodocto, PDO::PARAM_STR);
			$stm->bindValue(':empndoc', $row->legempleado_nrodocto, PDO::PARAM_STR);
			$stm->bindValue(':empncuil', $row->legempleado_nrocuil, PDO::PARAM_STR);
			$stm->bindValue(':empapellido', $row->legempleado_apellido, PDO::PARAM_STR);
			$stm->bindValue(':empnombres', $row->legempleado_nombres, PDO::PARAM_STR);
			$stm->bindValue(':empsexo', $row->sexo_id, PDO::PARAM_STR);
			$stm->bindValue(':empfecnacto', $row->legempleado_fecnacto, PDO::PARAM_STR);
			$stm->bindValue(':empecivil', $row->estcivil_id, PDO::PARAM_STR);
			$stm->bindValue(':empdireccion', $row->legempleado_direccion, PDO::PARAM_STR);
			$stm->bindValue(':empdirecnro', $row->legempleado_direcnro, PDO::PARAM_STR);
			$stm->bindValue(':empdirecpiso', $row->legempleado_direcpiso, PDO::PARAM_STR);
			$stm->bindValue(':empcelular', $row->legempleado_celular, PDO::PARAM_STR);
			$stm->bindValue(':emptelefono', $row->legempleado_telefono, PDO::PARAM_STR);
			$stm->bindValue(':empemail', $row->legempleado_email, PDO::PARAM_STR);
			$stm->bindValue(':emppais', $row->pais_id, PDO::PARAM_STR);
			$stm->bindValue(':empprovincia', $row->provincia_id, PDO::PARAM_STR);
			$stm->bindValue(':empdepartamento', $row->departamento_id, PDO::PARAM_STR);
			$stm->bindValue(':emplocalidad', $row->localidad_id, PDO::PARAM_STR);
			$stm->bindValue(':empcpostal', $row->legempleado_codpostal, PDO::PARAM_STR);
			$stm->bindValue(':empfecing', $row->legempleado_fecingreso, PDO::PARAM_STR);
			$stm->bindValue(':empfecbaja', $row->legempleado_fecbaja, PDO::PARAM_STR);
			$stm->bindValue(':empimagen', $row->legempleado_imagen, PDO::PARAM_STR);
			$stm->bindValue(':emptipoid', $row->legtipo_id, PDO::PARAM_STR);
			$stm->bindValue(':empactivo', $row->legempleado_activo, PDO::PARAM_STR);
			$stm->bindValue(':empippublica', $ippublica, PDO::PARAM_STR);
			$stm->bindValue(':emppcnombre', $pcnombre, PDO::PARAM_STR);
			$stm->bindValue(':emppcinformacion', $pcinformacion, PDO::PARAM_STR);
			$stm->bindValue(':empusuario', $usuario, PDO::PARAM_STR);
			$stm->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ActualizarEmpleadoDomicilioExe($data){
		try{

			$sql = 'UPDATE legajos SET legempleado_direccion = ?,
																					legempleado_direcnro = ?,
																					legempleado_direcpiso = ?,
																					pais_id = ?,
																					provincia_id = ?,
																					departamento_id = ?,
																					localidad_id = ?,
																					legempleado_codpostal = ?
																		WHERE legempleado_nrodocto = ?';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Empdireccion, PDO::PARAM_STR);
			$stm->bindValue(2, $data->Empdirecnro, PDO::PARAM_STR);
			$stm->bindValue(3, $data->Empdirecpiso, PDO::PARAM_STR);
			$stm->bindValue(4, $data->Emppais, PDO::PARAM_STR);
			$stm->bindValue(5, $data->Empprovincia, PDO::PARAM_STR);
			$stm->bindValue(6, $data->Empdepartamento, PDO::PARAM_STR);
			$stm->bindValue(7, $data->Emplocalidad, PDO::PARAM_STR);
			$stm->bindValue(8, $data->Empcpostal, PDO::PARAM_STR);
			$stm->bindValue(9, $data->Empnrodocumento, PDO::PARAM_STR);
			$stm->execute();

			// ---------------Insert auditoria  empleado ------------
			$sql = 'SELECT * FROM legajos WHERE legempleado_nrodocto = ? LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Empnrodocumento, PDO::PARAM_STR);
			$stm->execute();
			$row = $stm->fetch(PDO::FETCH_OBJ);

			$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];
			$ippublica = $_SERVER["REMOTE_ADDR"];
			$pcnombre = gethostbyaddr($_SERVER['REMOTE_ADDR']);
			$pcinformacion = $_SERVER['HTTP_USER_AGENT'];

			$sql ='INSERT INTO aud_legajos (AUD_legempleado_id,
																							 AUD_legempleado_numerop,
																							 AUD_legempleado_numerol,
																							 AUD_legempleado_tipodocto,
																							 AUD_legempleado_nrodocto,
																							 AUD_legempleado_nrocuil,
																							 AUD_legempleado_apellido,
																							 AUD_legempleado_nombres,
																							 AUD_sexo_id,
																							 AUD_legempleado_fecnacto,
																							 AUD_estcivil_id,
																							 AUD_legempleado_direccion,
																							 AUD_legempleado_direcnro,
																							 AUD_legempleado_direcpiso,
																							 AUD_legempleado_celular,
																							 AUD_legempleado_telefono,
																							 AUD_legempleado_email,
																							 AUD_pais_id,
																							 AUD_provincia_id,
																							 AUD_departamento_id,
																							 AUD_localidad_id,
																							 AUD_legempleado_codpostal,
																							 AUD_legempleado_fecingreso,
																							 AUD_legempleado_fecbaja,
																							 AUD_legempleado_imagen,
																							 AUD_legtipo_id,
																							 AUD_legempleado_activo,
																							 AUD_legempleado_observacion,
																							 AUD_legempleado_ippublica,
																							 AUD_legempleado_pcnombre,
																							 AUD_legempleado_pcinformacion,
																							 AUD_legempleado_accion,
																							 AUD_legempleado_datetime,
																						 	 AUD_legempleado_usuario)
																			 VALUES (:empid,
																				 			 :emplegajop,
																							 :emplegajol,
																							 :emptdoc,
																							 :empndoc,
																							 :empncuil,
																							 :empapellido,
																							 :empnombres,
																							 :empsexo,
																							 :empfecnacto,
																							 :empecivil,
																							 :empdireccion,
																							 :empdirecnro,
																							 :empdirecpiso,
																							 :empcelular,
																							 :emptelefono,
																							 :empemail,
																							 :emppais,
																							 :empprovincia,
																							 :empdepartamento,
																							 :emplocalidad,
																							 :empcpostal,
																							 :empfecing,
																							 :empfecbaja,
																							 :empimagen,
																							 :emptipoid,
																							 :empactivo,
																							 "",
																							 :empippublica,
																							 :emppcnombre,
																							 :emppcinformacion,
																							 "UPDATE",
																							 NOW(),
																							 :empusuario)';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(':empid', $row->legempleado_id, PDO::PARAM_STR);
			$stm->bindValue(':emplegajop', $row->legempleado_numerop, PDO::PARAM_STR);
			$stm->bindValue(':emplegajol', $row->legempleado_numerol, PDO::PARAM_STR);
			$stm->bindValue(':emptdoc', $row->legempleado_tipodocto, PDO::PARAM_STR);
			$stm->bindValue(':empndoc', $row->legempleado_nrodocto, PDO::PARAM_STR);
			$stm->bindValue(':empncuil', $row->legempleado_nrocuil, PDO::PARAM_STR);
			$stm->bindValue(':empapellido', $row->legempleado_apellido, PDO::PARAM_STR);
			$stm->bindValue(':empnombres', $row->legempleado_nombres, PDO::PARAM_STR);
			$stm->bindValue(':empsexo', $row->sexo_id, PDO::PARAM_STR);
			$stm->bindValue(':empfecnacto', $row->legempleado_fecnacto, PDO::PARAM_STR);
			$stm->bindValue(':empecivil', $row->estcivil_id, PDO::PARAM_STR);
			$stm->bindValue(':empdireccion', $row->legempleado_direccion, PDO::PARAM_STR);
			$stm->bindValue(':empdirecnro', $row->legempleado_direcnro, PDO::PARAM_STR);
			$stm->bindValue(':empdirecpiso', $row->legempleado_direcpiso, PDO::PARAM_STR);
			$stm->bindValue(':empcelular', $row->legempleado_celular, PDO::PARAM_STR);
			$stm->bindValue(':emptelefono', $row->legempleado_telefono, PDO::PARAM_STR);
			$stm->bindValue(':empemail', $row->legempleado_email, PDO::PARAM_STR);
			$stm->bindValue(':emppais', $row->pais_id, PDO::PARAM_STR);
			$stm->bindValue(':empprovincia', $row->provincia_id, PDO::PARAM_STR);
			$stm->bindValue(':empdepartamento', $row->departamento_id, PDO::PARAM_STR);
			$stm->bindValue(':emplocalidad', $row->localidad_id, PDO::PARAM_STR);
			$stm->bindValue(':empcpostal', $row->legempleado_codpostal, PDO::PARAM_STR);
			$stm->bindValue(':empfecing', $row->legempleado_fecingreso, PDO::PARAM_STR);
			$stm->bindValue(':empfecbaja', $row->legempleado_fecbaja, PDO::PARAM_STR);
			$stm->bindValue(':empimagen', $row->legempleado_imagen, PDO::PARAM_STR);
			$stm->bindValue(':emptipoid', $row->legtipo_id, PDO::PARAM_STR);
			$stm->bindValue(':empactivo', $row->legempleado_activo, PDO::PARAM_STR);
			$stm->bindValue(':empippublica', $ippublica, PDO::PARAM_STR);
			$stm->bindValue(':emppcnombre', $pcnombre, PDO::PARAM_STR);
			$stm->bindValue(':emppcinformacion', $pcinformacion, PDO::PARAM_STR);
			$stm->bindValue(':empusuario', $usuario, PDO::PARAM_STR);
			$stm->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ActualizarEmpleadoContactoExe($data){
		try{

			$sql = 'UPDATE legajos SET legempleado_celular = ?,
																					legempleado_telefono = ?,
																					legempleado_email = ?
																		WHERE legempleado_nrodocto = ?';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Empcelular, PDO::PARAM_STR);
			$stm->bindValue(2, $data->Emptelefono, PDO::PARAM_STR);
			$stm->bindValue(3, $data->Empemail, PDO::PARAM_STR);
			$stm->bindValue(4, $data->Empnrodocumento, PDO::PARAM_STR);
			$stm->execute();

			// ---------------Insert auditoria  empleado ------------
			$sql = 'SELECT * FROM legajos WHERE legempleado_nrodocto = ? LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Empnrodocumento, PDO::PARAM_STR);
			$stm->execute();
			$row = $stm->fetch(PDO::FETCH_OBJ);

			$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];
			$ippublica = $_SERVER["REMOTE_ADDR"];
			$pcnombre = gethostbyaddr($_SERVER['REMOTE_ADDR']);
			$pcinformacion = $_SERVER['HTTP_USER_AGENT'];

			$sql ='INSERT INTO aud_legajos (AUD_legempleado_id,
																							 AUD_legempleado_numerop,
																							 AUD_legempleado_numerol,
																							 AUD_legempleado_tipodocto,
																							 AUD_legempleado_nrodocto,
																							 AUD_legempleado_nrocuil,
																							 AUD_legempleado_apellido,
																							 AUD_legempleado_nombres,
																							 AUD_sexo_id,
																							 AUD_legempleado_fecnacto,
																							 AUD_estcivil_id,
																							 AUD_legempleado_direccion,
																							 AUD_legempleado_direcnro,
																							 AUD_legempleado_direcpiso,
																							 AUD_legempleado_celular,
																							 AUD_legempleado_telefono,
																							 AUD_legempleado_email,
																							 AUD_pais_id,
																							 AUD_provincia_id,
																							 AUD_departamento_id,
																							 AUD_localidad_id,
																							 AUD_legempleado_codpostal,
																							 AUD_legempleado_fecingreso,
																							 AUD_legempleado_fecbaja,
																							 AUD_legempleado_imagen,
																							 AUD_legtipo_id,
																							 AUD_legempleado_activo,
																							 AUD_legempleado_observacion,
																							 AUD_legempleado_ippublica,
																							 AUD_legempleado_pcnombre,
																							 AUD_legempleado_pcinformacion,
																							 AUD_legempleado_accion,
																							 AUD_legempleado_datetime,
																						 	 AUD_legempleado_usuario)
																			 VALUES (:empid,
																				 			 :emplegajop,
																							 :emplegajol,
																							 :emptdoc,
																							 :empndoc,
																							 :empncuil,
																							 :empapellido,
																							 :empnombres,
																							 :empsexo,
																							 :empfecnacto,
																							 :empecivil,
																							 :empdireccion,
																							 :empdirecnro,
																							 :empdirecpiso,
																							 :empcelular,
																							 :emptelefono,
																							 :empemail,
																							 :emppais,
																							 :empprovincia,
																							 :empdepartamento,
																							 :emplocalidad,
																							 :empcpostal,
																							 :empfecing,
																							 :empfecbaja,
																							 :empimagen,
																							 :emptipoid,
																							 :empactivo,
																							 "",
																							 :empippublica,
																							 :emppcnombre,
																							 :emppcinformacion,
																							 "UPDATE",
																							 NOW(),
																							 :empusuario)';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(':empid', $row->legempleado_id, PDO::PARAM_STR);
			$stm->bindValue(':emplegajop', $row->legempleado_numerop, PDO::PARAM_STR);
			$stm->bindValue(':emplegajol', $row->legempleado_numerol, PDO::PARAM_STR);
			$stm->bindValue(':emptdoc', $row->legempleado_tipodocto, PDO::PARAM_STR);
			$stm->bindValue(':empndoc', $row->legempleado_nrodocto, PDO::PARAM_STR);
			$stm->bindValue(':empncuil', $row->legempleado_nrocuil, PDO::PARAM_STR);
			$stm->bindValue(':empapellido', $row->legempleado_apellido, PDO::PARAM_STR);
			$stm->bindValue(':empnombres', $row->legempleado_nombres, PDO::PARAM_STR);
			$stm->bindValue(':empsexo', $row->sexo_id, PDO::PARAM_STR);
			$stm->bindValue(':empfecnacto', $row->legempleado_fecnacto, PDO::PARAM_STR);
			$stm->bindValue(':empecivil', $row->estcivil_id, PDO::PARAM_STR);
			$stm->bindValue(':empdireccion', $row->legempleado_direccion, PDO::PARAM_STR);
			$stm->bindValue(':empdirecnro', $row->legempleado_direcnro, PDO::PARAM_STR);
			$stm->bindValue(':empdirecpiso', $row->legempleado_direcpiso, PDO::PARAM_STR);
			$stm->bindValue(':empcelular', $row->legempleado_celular, PDO::PARAM_STR);
			$stm->bindValue(':emptelefono', $row->legempleado_telefono, PDO::PARAM_STR);
			$stm->bindValue(':empemail', $row->legempleado_email, PDO::PARAM_STR);
			$stm->bindValue(':emppais', $row->pais_id, PDO::PARAM_STR);
			$stm->bindValue(':empprovincia', $row->provincia_id, PDO::PARAM_STR);
			$stm->bindValue(':empdepartamento', $row->departamento_id, PDO::PARAM_STR);
			$stm->bindValue(':emplocalidad', $row->localidad_id, PDO::PARAM_STR);
			$stm->bindValue(':empcpostal', $row->legempleado_codpostal, PDO::PARAM_STR);
			$stm->bindValue(':empfecing', $row->legempleado_fecingreso, PDO::PARAM_STR);
			$stm->bindValue(':empfecbaja', $row->legempleado_fecbaja, PDO::PARAM_STR);
			$stm->bindValue(':empimagen', $row->legempleado_imagen, PDO::PARAM_STR);
			$stm->bindValue(':emptipoid', $row->legtipo_id, PDO::PARAM_STR);
			$stm->bindValue(':empactivo', $row->legempleado_activo, PDO::PARAM_STR);
			$stm->bindValue(':empippublica', $ippublica, PDO::PARAM_STR);
			$stm->bindValue(':emppcnombre', $pcnombre, PDO::PARAM_STR);
			$stm->bindValue(':emppcinformacion', $pcinformacion, PDO::PARAM_STR);
			$stm->bindValue(':empusuario', $usuario, PDO::PARAM_STR);
			$stm->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function BajaEmpleadoExe($data){
		try{

			$sql = 'UPDATE legajos_empleado SET legempleado_fecbaja = ?,
																					legtipo_id = 0,
																					legempleado_activo = 0
																		WHERE legempleado_nrodocto = ?';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Empfecbaja, PDO::PARAM_STR);
			$stm->bindValue(2, $data->Empnrodocumento, PDO::PARAM_STR);
			$stm->execute();

			// ---------------Insert auditoria  empleado ------------
			$sql = 'SELECT * FROM legajos_empleado WHERE legempleado_nrodocto = ? LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Empnrodocumento, PDO::PARAM_STR);
			$stm->execute();
			$row = $stm->fetch(PDO::FETCH_OBJ);

			$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];
			$ippublica = $_SERVER["REMOTE_ADDR"];
			$pcnombre = gethostbyaddr($_SERVER['REMOTE_ADDR']);
			$pcinformacion = $_SERVER['HTTP_USER_AGENT'];

			$sql ='INSERT INTO aud_legajos_empleado (AUD_legempleado_id,
																							 AUD_legempleado_numerop,
																							 AUD_legempleado_numerol,
																							 AUD_legempleado_tipodocto,
																							 AUD_legempleado_nrodocto,
																							 AUD_legempleado_nrocuil,
																							 AUD_legempleado_apellido,
																							 AUD_legempleado_nombres,
																							 AUD_sexo_id,
																							 AUD_legempleado_fecnacto,
																							 AUD_estcivil_id,
																							 AUD_legempleado_direccion,
																							 AUD_legempleado_direcnro,
																							 AUD_legempleado_direcpiso,
																							 AUD_legempleado_celular,
																							 AUD_legempleado_telefono,
																							 AUD_legempleado_email,
																							 AUD_pais_id,
																							 AUD_provincia_id,
																							 AUD_departamento_id,
																							 AUD_localidad_id,
																							 AUD_legempleado_codpostal,
																							 AUD_legempleado_fecingreso,
																							 AUD_legempleado_fecbaja,
																							 AUD_legempleado_imagen,
																							 AUD_legtipo_id,
																							 AUD_legempleado_activo,
																							 AUD_legempleado_observacion,
																							 AUD_legempleado_ippublica,
																							 AUD_legempleado_pcnombre,
																							 AUD_legempleado_pcinformacion,
																							 AUD_legempleado_accion,
																							 AUD_legempleado_datetime,
																						 	 AUD_legempleado_usuario)
																			 VALUES (:empid,
																				 			 :emplegajop,
																							 :emplegajol,
																							 :emptdoc,
																							 :empndoc,
																							 :empncuil,
																							 :empapellido,
																							 :empnombres,
																							 :empsexo,
																							 :empfecnacto,
																							 :empecivil,
																							 :empdireccion,
																							 :empdirecnro,
																							 :empdirecpiso,
																							 :empcelular,
																							 :emptelefono,
																							 :empemail,
																							 :emppais,
																							 :empprovincia,
																							 :empdepartamento,
																							 :emplocalidad,
																							 :empcpostal,
																							 :empfecing,
																							 :empfecbaja,
																							 :empimagen,
																							 :emptipoid,
																							 :empactivo,
																							 :empobsbaja,
																							 :empippublica,
																							 :emppcnombre,
																							 :emppcinformacion,
																							 "DISABLE",
																							 NOW(),
																							 :empusuario)';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(':empid', $row->legempleado_id, PDO::PARAM_STR);
			$stm->bindValue(':emplegajop', $row->legempleado_numerop, PDO::PARAM_STR);
			$stm->bindValue(':emplegajol', $row->legempleado_numerol, PDO::PARAM_STR);
			$stm->bindValue(':emptdoc', $row->legempleado_tipodocto, PDO::PARAM_STR);
			$stm->bindValue(':empndoc', $row->legempleado_nrodocto, PDO::PARAM_STR);
			$stm->bindValue(':empncuil', $row->legempleado_nrocuil, PDO::PARAM_STR);
			$stm->bindValue(':empapellido', $row->legempleado_apellido, PDO::PARAM_STR);
			$stm->bindValue(':empnombres', $row->legempleado_nombres, PDO::PARAM_STR);
			$stm->bindValue(':empsexo', $row->sexo_id, PDO::PARAM_STR);
			$stm->bindValue(':empfecnacto', $row->legempleado_fecnacto, PDO::PARAM_STR);
			$stm->bindValue(':empecivil', $row->estcivil_id, PDO::PARAM_STR);
			$stm->bindValue(':empdireccion', $row->legempleado_direccion, PDO::PARAM_STR);
			$stm->bindValue(':empdirecnro', $row->legempleado_direcnro, PDO::PARAM_STR);
			$stm->bindValue(':empdirecpiso', $row->legempleado_direcpiso, PDO::PARAM_STR);
			$stm->bindValue(':empcelular', $row->legempleado_celular, PDO::PARAM_STR);
			$stm->bindValue(':emptelefono', $row->legempleado_telefono, PDO::PARAM_STR);
			$stm->bindValue(':empemail', $row->legempleado_email, PDO::PARAM_STR);
			$stm->bindValue(':emppais', $row->pais_id, PDO::PARAM_STR);
			$stm->bindValue(':empprovincia', $row->provincia_id, PDO::PARAM_STR);
			$stm->bindValue(':empdepartamento', $row->departamento_id, PDO::PARAM_STR);
			$stm->bindValue(':emplocalidad', $row->localidad_id, PDO::PARAM_STR);
			$stm->bindValue(':empcpostal', $row->legempleado_codpostal, PDO::PARAM_STR);
			$stm->bindValue(':empfecing', $row->legempleado_fecingreso, PDO::PARAM_STR);
			$stm->bindValue(':empfecbaja', $row->legempleado_fecbaja, PDO::PARAM_STR);
			$stm->bindValue(':empimagen', $row->legempleado_imagen, PDO::PARAM_STR);
			$stm->bindValue(':emptipoid', $row->legtipo_id, PDO::PARAM_STR);
			$stm->bindValue(':empactivo', $row->legempleado_activo, PDO::PARAM_STR);
			$stm->bindValue(':empobsbaja', $data->Empobsbaja, PDO::PARAM_STR);
			$stm->bindValue(':empippublica', $ippublica, PDO::PARAM_STR);
			$stm->bindValue(':emppcnombre', $pcnombre, PDO::PARAM_STR);
			$stm->bindValue(':emppcinformacion', $pcinformacion, PDO::PARAM_STR);
			$stm->bindValue(':empusuario', $usuario, PDO::PARAM_STR);
			$stm->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	/*
	public function ActualizarE($data){
		try{

			$sql = 'UPDATE legajos_empleado SET legempleado_numero = ?, legempleado_nrocuil = ?, legempleado_apellido = ?, legempleado_nombres = ?, sexo_id = ?, legempleado_fecnacto = ?, estcivil_id = ?, legempleado_direccion = ?, legempleado_direcnro = ?, legempleado_direcpiso = ?, legempleado_celular = ?, legempleado_telefono = ?, legempleado_email = ?, pais_id = ?, provincia_id = ?, departamento_id = ?, localidad_id = ?, legempleado_codpostal = ?,legempleado_fecingreso = ?, legempleado_activo = ? WHERE legempleado_id = ?';

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
			$stm->bindValue(19, $data->Empfecing, PDO::PARAM_STR);
			$stm->bindValue(20, $data->Empactivo, PDO::PARAM_STR);
			$stm->bindValue(21, $data->Id, PDO::PARAM_STR);
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

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	*/
	public function DeshabilitarRel($data){
		try{

			$sql = 'UPDATE legajos_reloj SET 	legreloj_activo = ? WHERE legreloj_id = ?';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Activo, PDO::PARAM_STR);
			$stm->bindValue(2, $data->RelId, PDO::PARAM_STR);

			$stm->execute();


		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ActualizarRee($data){
		try{

			$sql = 'UPDATE legajos_reloj SET reloj_id = ?, marcacion_accessid = ?, legreloj_semanal = ? WHERE legempleado_nrodocto = ? AND legreloj_activo = 1';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Relojid, PDO::PARAM_STR);
			$stm->bindValue(2, $data->Accessid, PDO::PARAM_STR);
			$stm->bindValue(3, $data->Semanal, PDO::PARAM_STR);
			$stm->bindValue(4, $data->Empnrodocto, PDO::PARAM_STR);
			$stm->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function FechasDeReferencia(){
		try{
			$sql = $this->cn->prepare("SELECT * FROM legajos_contrato GROUP BY legcontrato_fecinicio ORDER BY legcontrato_fecinicio DESC LIMIT 10");
			$sql->execute();

			return $sql->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerActualizacion($nrodocto){
		try{

			$sql = 'SELECT * FROM legajos_contrato_base_importes WHERE lcb_id = 2 AND legempleado_nrodocto = ? LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$stm->execute();

			return $stm->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerActualizacionDOS($nrodocto){
		try{

			/*$sql = 'SELECT *
								FROM legajos_contrato
							 WHERE legempleado_nrodocto = ?
							   AND legcontrato_fecfin = "2021-02-28"
							 	 AND legcontrato_sbasico > 0
					  ORDER BY legcontrato_id
								DESC
							 LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $nrodocto, PDO::PARAM_STR);*/
			$sql = 'SELECT *
								FROM liquidaciones
							 WHERE legempleado_nrodocto = ?
							 	 AND liqtipo_id = 1
							 	 AND liquidacion_titular = 1
							   AND liqcod_id = 1
								 AND periodo_id = 37
					  ORDER BY liquidacion_id
								DESC
							 LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$stm->execute();
			return $stm->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function Codigo151Obtener($nrodocto){
		try{

			$sql = 'SELECT *
								FROM liquidaciones
							 WHERE legempleado_nrodocto = ?
							 	 AND liqtipo_id = 1
							 	 AND liquidacion_titular = 1
							   AND liqcod_id = 151
								 AND periodo_id = 37
					  ORDER BY liquidacion_id
								DESC
							 LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$stm->execute();
			return $stm->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function SueldoBasicoObtener_LIQUIDACION($nrodocto){
		try{

			$sql = 'SELECT *
								FROM liquidaciones
							 WHERE legempleado_nrodocto = ?
							 	 AND liqtipo_id = 1
							 	 AND liquidacion_titular = 1
							   AND liqcod_id = 1
					  ORDER BY liquidacion_id
								DESC
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerSBase2019($nrodocto){
		try{
			//$sql = 'SELECT *, COUNT(lcbi_id) AS basec FROM legajos_contrato_base_importes WHERE lcb_id = 2 AND legempleado_nrodocto = ? LIMIT 1';
			$sql = 'SELECT * FROM legajos_contrato_base_importes WHERE lcb_id = 1 AND legempleado_nrodocto = ? LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$stm->execute();

			return $stm->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerSBasePro2019($nrodocto){
		try{
			//$sql = 'SELECT *, COUNT(lcbi_id) AS basec FROM legajos_contrato_base_importes WHERE lcb_id = 2 AND legempleado_nrodocto = ? LIMIT 1';
			$sql = 'SELECT * FROM legajos_proveedor_base_importes WHERE lpb_id = 1 AND legempleado_nrodocto = ? LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$stm->execute();

			return $stm->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerActualizacionProveedorDOS($nrodocto){
		try{

			$sql = 'SELECT *
							  FROM legajos_proveedor
							 WHERE legempleado_nrodocto = ?
								 AND legproveedor_sbasico > 0
						ORDER BY legproveedor_id
								DESC
							 LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$stm->execute();

			return $stm->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerActualizacionProveedor($nrodocto){
		try{

			$sql = 'SELECT * FROM legajos_proveedor_base_importes WHERE lpb_id = 3 AND legempleado_nrodocto = ? LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$stm->execute();

			return $stm->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ContratoActualizar($nrodocto,$fechainicionueva,$fechafinnueva,$actualizacion){
		try{
			//----- Verificar si el empleado tiene contrato activo(estado 1) ----
			$sql = 'SELECT *
								FROM legajos_contrato
							 WHERE legempleado_nrodocto = ?
							 	 AND legcontrato_activo = 1
							 LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$stm->execute();
			$contratoc = $stm->rowCount();
			$contratoactual = $stm->fetch(PDO::FETCH_OBJ);
			//----- Obtener Importe Base -----

			$sql = 'SELECT *
								FROM liquidaciones
							 WHERE legempleado_nrodocto = ?
							 	 AND liqtipo_id = 1
							 	 AND liquidacion_titular = 1
							   AND liqcod_id = 1
								 AND periodo_id = 43
					  ORDER BY liquidacion_id
								DESC
							 LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$stm->execute();
			$importebase = $stm->fetch(PDO::FETCH_OBJ);


			////////////////////////
			$sql = 'SELECT *
								FROM liquidaciones
							 WHERE legempleado_nrodocto = ?
							 	 AND liqtipo_id = 1
							 	 AND liquidacion_titular = 1
							   AND liqcod_id = 151
								 AND periodo_id = 41
					  ORDER BY liquidacion_id
								DESC
							 LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$stm->execute();
			$cod151 = $stm->fetch(PDO::FETCH_OBJ);
			//--Activo cuando no hay codigo de aumento---
			$cod151->liquidacion_importe = 0;
			//////////////////////////


			//--- verificar si el empleado tiene importe base ----
			//$importebasec = $stm->rowCount();
			$importebasebis = $importebase->liquidacion_importe + $cod151->liquidacion_importe;

			if($importebasebis > 0){

				//$importebase = $stm->fetch(PDO::FETCH_OBJ);
				$importeaumento = $importebasebis * $actualizacion / 100;
				//$basiconuevo = $contratoactual->legcontrato_sbasico + $importeaumento;
				$basiconuevo = $importebasebis + $importeaumento;
				if($basiconuevo <= 31429.50){
					$basiconuevo = 31429.50;
				}

			}else{

				$importeaumento = $contratoactual->legcontrato_sbasico * $actualizacion / 100;
				$basiconuevo = $contratoactual->legcontrato_sbasico + $importeaumento;

			}


			//---- si tiene contrato en estado uno pasar a dos (vencido)
			if($contratoc > 0){

				//-------- pasamos en contrato actual (ya vencido) a estado 2 ------
				$sql = 'UPDATE legajos_contrato SET	legcontrato_activo = 2 WHERE legempleado_nrodocto = ? AND legcontrato_activo = 1';
				$stm = $this->cn->prepare($sql);
				$stm->bindValue(1, $nrodocto, PDO::PARAM_STR);
				$stm->execute();
				//--- Insertamos nuevo contrato ------
				$sql = 'INSERT INTO legajos_contrato (legempleado_nrodocto,legcontrato_fecinicio,legcontrato_fecfin,imputacion_id,impdependencia_id,secretaria_id,trabajo_id,legcontrato_tarea,legcontrato_sbasico,legcontrato_activo)
				VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, 1)';

				$stm = $this->cn->prepare($sql);
				$stm->bindValue(1, $nrodocto, PDO::PARAM_STR);
				//$stm->bindValue(2, $contratoactual->legtipo_id, PDO::PARAM_STR);
				$stm->bindValue(2, $fechainicionueva, PDO::PARAM_STR);
				$stm->bindValue(3, $fechafinnueva, PDO::PARAM_STR);
				$stm->bindValue(4, $contratoactual->imputacion_id, PDO::PARAM_STR);
				$stm->bindValue(5, $contratoactual->impdependencia_id, PDO::PARAM_STR);
				$stm->bindValue(6, $contratoactual->secretaria_id, PDO::PARAM_STR);
				//$stm->bindValue(8, $contratoactual->legcontrato_categoria, PDO::PARAM_STR);
				$stm->bindValue(7, $contratoactual->trabajo_id, PDO::PARAM_STR);
				$stm->bindValue(8, $contratoactual->legcontrato_tarea, PDO::PARAM_STR);
				$stm->bindValue(9, $basiconuevo, PDO::PARAM_STR);
				$stm->execute();

			}else{
				//-- error no tiene contrato no corresponde actualizacion ---
			}

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ContratoActualizarProveedor($nrodocto,$fechainicionueva,$fechafinnueva,$actualizacion){
		try{
			//----- Verificar si el empleado tiene contrato activo(estado 1) ----
			$sql = 'SELECT * FROM legajos_proveedor WHERE legempleado_nrodocto = ? AND legproveedor_activo = 1 LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$stm->execute();
			$contratoc = $stm->rowCount();
			$contratoactual = $stm->fetch(PDO::FETCH_OBJ);

			/*$sql = 'SELECT * FROM legajos_proveedor_base_importes WHERE	lpb_id = 3 AND legempleado_nrodocto = ? LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$stm->execute();
			$importebase = $stm->fetch(PDO::FETCH_OBJ);*/
			$sql = 'SELECT *
							  FROM legajos_proveedor
							 WHERE legempleado_nrodocto = ?
								 AND legproveedor_sbasico > 0
						ORDER BY legproveedor_id
								DESC
							 LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$stm->execute();
			$importebase = $stm->fetch(PDO::FETCH_OBJ);

			//--- verificar si el empleado tiene importe base ----
			$importebasebis = $importebase->legproveedor_sbasico;
			if($importebasebis > 0){

				//$importebase = $stm->fetch(PDO::FETCH_OBJ);
				$importeaumento = $importebase->legproveedor_sbasico * $actualizacion / 100;
				//$importeaumento = $contratoactual->legproveedor_sbasico * $actualizacion / 100;
				//$basiconuevo = $importebase->lpbi_importe + $importeaumento;
				$basiconuevo = $contratoactual->legproveedor_sbasico + $importeaumento;

			}else{

				$importeaumento = $contratoactual->legproveedor_sbasico * $actualizacion / 100;
				$basiconuevo = $contratoactual->legproveedor_sbasico + $importeaumento;

			}

			//---- si tiene contrato en estado uno pasar a dos (vencido)
			if($contratoc > 0){

				//-------- pasamos en contrato actual (ya vencido) a estado 2 ------
				$sql = 'UPDATE legajos_proveedor SET legproveedor_activo = 2 WHERE legempleado_nrodocto = ? AND legproveedor_activo = 1';
				$stm = $this->cn->prepare($sql);
				$stm->bindValue(1, $nrodocto, PDO::PARAM_STR);
				$stm->execute();
				//--- Insertamos nuevo contrato ------
				$sql = 'INSERT INTO legajos_proveedor (legempleado_nrodocto,legproveedor_fecinicio,legproveedor_fecfin,secretaria_id,trabajo_id,legproveedor_tarea,legproveedor_sbasico,legproveedor_activo)
				VALUES(?, ?, ?, ?, ?, ?, ?, 1)';

				$stm = $this->cn->prepare($sql);
				$stm->bindValue(1, $nrodocto, PDO::PARAM_STR);
				$stm->bindValue(2, $fechainicionueva, PDO::PARAM_STR);
				$stm->bindValue(3, $fechafinnueva, PDO::PARAM_STR);
				$stm->bindValue(4, $contratoactual->secretaria_id, PDO::PARAM_STR);
				$stm->bindValue(5, $contratoactual->trabajo_id, PDO::PARAM_STR);
				$stm->bindValue(6, $contratoactual->legproveedor_tarea, PDO::PARAM_STR);
				$stm->bindValue(7, $basiconuevo, PDO::PARAM_STR);
				$stm->execute();

			}else{
				//-- error no tiene contrato no corresponde actualizacion ---
			}

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ContratoRenovar($data){
		try{
			//-------- pasamos en contrato actual (ya vencido) a estado 2 ------
			$sql = 'UPDATE legajos_contrato SET	legcontrato_activo = 2 WHERE legcontrato_id = ? AND legcontrato_activo = 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->ContratoIdActInd, PDO::PARAM_STR);
			$stm->execute();
			//--- Insertamos nuevo contrato ------
			$sql = 'INSERT INTO legajos_contrato (legempleado_nrodocto,legcontrato_fecinicio,legcontrato_fecfin,imputacion_id,impdependencia_id,secretaria_id,trabajo_id,legcontrato_tarea,legcontrato_sbasico,legcontrato_activo)
			VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, 1)';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->EmpNroDoctoActInd, PDO::PARAM_STR);
			//$stm->bindValue(2, $data->EmpTipoLegajoActInd, PDO::PARAM_STR);
			$stm->bindValue(2, $data->EmpFechaInicioActInd, PDO::PARAM_STR);
			$stm->bindValue(3, $data->EmpFechaFinalizacionActInd, PDO::PARAM_STR);
			$stm->bindValue(4, $data->EmpImputacionActInd, PDO::PARAM_STR);
			$stm->bindValue(5, $data->EmpDependenciaActInd, PDO::PARAM_STR);
			$stm->bindValue(6, $data->EmpSecretariaActInd, PDO::PARAM_STR);
			//$stm->bindValue(7, $data->EmpCategoriaActInd, PDO::PARAM_STR);
			$stm->bindValue(7, $data->EmpLugarDeTrabajoActInd, PDO::PARAM_STR);
			$stm->bindValue(8, $data->EmpTareaActInd, PDO::PARAM_STR);
			$stm->bindValue(9, $data->EmpSueldoBasicoActInd, PDO::PARAM_STR);
			$stm->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ProveedorContratoRenovar($data){
		try{
			//-------- pasamos en contrato actual (ya vencido) a estado 2 ------
			$sql = 'UPDATE legajos_proveedor SET	legproveedor_activo = 2 WHERE legproveedor_id = ? AND legproveedor_activo = 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Procontratoidanterior, PDO::PARAM_STR);
			$stm->execute();
			//--- Insertamos nuevo contrato ------
			$sql = 'INSERT INTO legajos_proveedor (legempleado_nrodocto,legproveedor_fecinicio,legproveedor_fecfin,secretaria_id,trabajo_id,legproveedor_tarea,legproveedor_sbasico,legproveedor_activo)
			VALUES(?, ?, ?, ?, ?, ?, ?, 1)';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Empnrodocto, PDO::PARAM_STR);
			$stm->bindValue(2, $data->Profechainicioactualizacion, PDO::PARAM_STR);
			$stm->bindValue(3, $data->Profechafinalactualizacion, PDO::PARAM_STR);
			$stm->bindValue(4, $data->Prosecretariaactualizacion, PDO::PARAM_STR);
			$stm->bindValue(5, $data->Proltrabajoactualizacion, PDO::PARAM_STR);
			$stm->bindValue(6, $data->Protareaactualizacion, PDO::PARAM_STR);
			$stm->bindValue(7, $data->Prosbasicoactualizacion, PDO::PARAM_STR);
			$stm->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerContratosactualizados($nrodocto){
		try{
			$sql = 'SELECT * FROM legajos_contrato a, legajos_empleado b, lugares_trabajo c WHERE a.legempleado_nrodocto = b.legempleado_nrodocto AND a.trabajo_id = c.trabajo_id AND a.legempleado_nrodocto = ? AND a.legcontrato_activo = 1 LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$stm->execute();

			return $stm->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerContratosProveedoresactualizados($nrodocto){
		try{

			$sql = 'SELECT * FROM legajos_proveedor a, legajos_empleado b, lugares_trabajo c WHERE a.legempleado_nrodocto = b.legempleado_nrodocto AND a.trabajo_id = c.trabajo_id AND a.legempleado_nrodocto = ? AND a.legproveedor_activo = 1 LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$stm->execute();
			return $stm->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	function Porcentaje($cantidad,$porciento,$decimales){
		return $cantidad * $porciento / 100;
	}
	function MesEnLetra($mesenletras){
	  switch($mesenletras) {
	    case 1:
	      $mesletra = "ENERO";
	      break;
	    case 2:
	      $mesletra = "FEBRERO";
	      break;
	    case 3:
	      $mesletra = "MARZO";
	      break;
	    case 4:
	      $mesletra = "ABRIL";
	      break;
	    case 5:
	      $mesletra = "MAYO";
	      break;
	    case 6:
	      $mesletra = "JUNIO";
	      break;
	    case 7:
	      $mesletra = "JULIO";
	      break;
	    case 8:
	      $mesletra = "AGOSTO";
	      break;
	    case 9:
	      $mesletra = "SEPTIEMBRE";
	      break;
	    case 10:
	      $mesletra = "OCTUBRE";
	      break;
	    case 11:
	      $mesletra = "NOVIEMBRE";
	      break;
	    case 12:
	      $mesletra = "DICIEMBRE";
	      break;
	    default:
	      $mesletra = "ERROR";
	  }
	  return $mesletra;
	}
	function CalculaEdad($fechanacimiento){
		date_default_timezone_set("America/Buenos_Aires");

  	list($ano,$mes,$dia) = explode("-",$fechanacimiento);
  	$ano_diferencia  = date("Y") - $ano;
  	$mes_diferencia = date("m") - $mes;
  	$dia_diferencia   = date("d") - $dia;
  	if ($dia_diferencia < 0 || $mes_diferencia < 0)
    	$ano_diferencia--;
  	return $ano_diferencia;
	}
	public function PeriodoActual(){
		try{
			$sql = $this->cn->prepare("SELECT * FROM periodos WHERE periodo_cerrado = 0 LIMIT 1");
			$sql->execute();
			return $sql->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function PeriodoUCerrado(){
		try{
			$sql = $this->cn->prepare("SELECT * FROM periodos WHERE periodo_cerrado = 1 ORDER BY periodo_id DESC LIMIT 1");
			$sql->execute();
			return $sql->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function PeriodosUsDos(){
		try{
			$sql = $this->cn->prepare("SELECT * FROM periodos ORDER BY periodo_id DESC LIMIT 2");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerFecIni(){
		try{
			$periodo_actual = Empleado::PeriodoActual();
			$periodo_ucerrado = Empleado::PeriodoUCerrado();
			date_default_timezone_set("America/Buenos_Aires");
			$fecha_actual = date("Y-m-d");
			$hora_actual = date("H:i:s");
			$periodoactuali = $periodo_actual->periodo_hsext_jor_i;
			$fechaactualmesnum = strftime("%m", strtotime($fecha_actual));
			$periodoactualmesnum = strftime("%m", strtotime($periodoactuali));
			if($fechaactualmesnum > $periodoactualmesnum){
				$fechainicial = $periodo_actual->periodo_hsext_jor_i;
			}else{
				$fechainicial = $periodo_ucerrado->periodo_hsext_jor_i;
			}
			return $fechainicial;
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerFecIFdos($accessid){
		try{

			$sql = 'SELECT MAX(DATE_FORMAT(marcacion_datetime, "%Y-%m-%d")) AS fecmax, MIN(DATE_FORMAT(marcacion_datetime, "%Y-%m-%d")) AS fecmin FROM marcaciones WHERE marcacion_accessid = ?';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $accessid, PDO::PARAM_STR);
			$stm->execute();
			return $stm->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ObtenerMarcacionesRe($fecha_inicio,$fecha_final,$accessid){
		try{

			$sql = $this->cn->prepare("SELECT * FROM marcaciones WHERE marcacion_accessid = '$accessid' AND mestado_id != 2 AND mestado_id != 3 AND DATE(marcacion_datetime) BETWEEN '$fecha_inicio' AND '$fecha_final'");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ProcesarMarcacionesRe($marcacionid, $marcacionaccessid, $marcaciondatetime, $relojid, $relojsegid, $fecha_i, $fecha_f){
		try{
				//------ obtener dias que ficha el empleado -----
				$sql = 'SELECT * FROM legajos_reloj WHERE marcacion_accessid = ? AND legreloj_activo = 1';
				$stm = $this->cn->prepare($sql);
				$stm->bindValue(1, $marcacionaccessid, PDO::PARAM_STR);
				$stm->execute();
				$rows = $stm->fetchAll(PDO::FETCH_OBJ);
				$legrelc = $stm->rowCount();
				$semanal = 1;
				if($semanal == 1){
					//----- Fecha y Hora actual -------
					date_default_timezone_set("America/Buenos_Aires");
					$fechaactual = date("Y-m-d");
					//$hora = date("H:i:s");
					/*
					$sql = $this->cn->prepare("SELECT DATE(marcacion_datetime) AS umarcacion FROM marcaciones WHERE marcacion_accessid = '$marcacionaccessid' AND mestado_id != 1 AND DATE(marcacion_datetime) BETWEEN '$periodoinicio' AND '$periodofin' ORDER BY marcacion_id DESC LIMIT 1");
					$sql->execute();
					$mproceso = $sql->fetch(PDO::FETCH_OBJ);
					$mprocesoc = $sql->rowCount();
					*/
					/*
					if($mprocesoc > 0){
						$periodoin = $mproceso->umarcacion;
						if($periodoin > $periodoinicio){
							$periodoi = $periodoin;
						}else{
							$periodoi = $periodoinicio;
						}
					}else{
						$periodoin = $periodoinicio;
					}
					if($periodofin > $fechaactual){
						$periodofi = $fechaactual;
					}else{
						$periodofi = $periodofin;
					}
					$periodofi = $periodofin;
					$periodoin = $periodoinicio;
					*/

					$periodoi = strtotime("$fecha_i");
					$periodof = strtotime("$fecha_f");

					//-------Recorrer fechas de periodo hasta fecha actual--------
					for($i=$periodoi; $i<=$periodof; $i+=86400){
						foreach($rows as $rowlr){

							//echo $fecha_actual."<br>";
							/*echo $marcacionaccessid."<br>";
							echo $marcaciondatetime."<br>";
							echo date("Y-m-d", $periodoi)."<br>";
							echo date("Y-m-d", $periodof)."<br>";
						  echo date("Y-m-d", $i)."<br>";
							echo "-------------"."<br>";*/


							//----- buscar marcacion de entrada
							$sql = 'SELECT * FROM marcaciones_proceso WHERE legreloj_id = ? AND marcacion_accessid = ? AND CAST(mprocesom_entrada AS DATE) = ?';
							$stm = $this->cn->prepare($sql);
							$stm->bindValue(1, $rowlr->legreloj_id, PDO::PARAM_STR);
							$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
							$stm->bindValue(3, date("Y-m-d", $i), PDO::PARAM_STR);
							$stm->execute();
							$mprocer = $stm->fetch(PDO::FETCH_OBJ);
							$mproce = $stm->rowCount();
							//------Preguntar si ya se poroceso la entrada ------
							if($mproce == 1){
								//--------Ya esta procesada la entrada, preguntar salida
								$sql = 'SELECT * FROM marcaciones_proceso WHERE legreloj_id = ? AND marcacion_accessid = ? AND CAST(mprocesom_salida AS DATE) = ?';
								$stm = $this->cn->prepare($sql);
								$stm->bindValue(1, $rowlr->legreloj_id, PDO::PARAM_STR);
								$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
								$stm->bindValue(3, date("Y-m-d", $i), PDO::PARAM_STR);
								$stm->execute();
								$mprocs = $stm->rowCount();
								if($mprocs == 1){
									//--- Marcacion de salida encontrada, descartar actual
									$proceso = 4;
									$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
									$stm = $this->cn->prepare($sql);
									$stm->bindValue(1, $proceso, PDO::PARAM_STR);
									$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
									$stm->execute();
								}else{
									//--- Marcacion de salida no encontrada, empezar a buscar
									$dia = strftime("%w", strtotime(date("Y-m-d", $i)));
									if($dia == 0){
										//--- Domingo ---
										/*foreach($rows as $rowlr){*/
											if($rowlr->legreloj_domingo == 1){
												//-----Si, ficha. Define hasta que punto se busca la marcacion de salida--------
												$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_domingohs;
												$horarioti = strtotime('-50 minute', strtotime($horfec));
												$horarioti = date ('Y-m-d H:i:s', $horarioti);
												$horariotf = strtotime('+50 minute', strtotime($horfec));
												$horariotf = date ('Y-m-d H:i:s', $horariotf);
												if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
													//---- Se encontro la marcacion de salida -----
													$datetime = new DateTime("$marcaciondatetime");
													$time = $datetime->format('H:i:s');
													$salida = date("Y-m-d", $i)." ".$time;
													$sql = 'UPDATE marcaciones_proceso SET mprocesop_salida = ?, mprocesom_salida = ? WHERE CAST(mprocesom_entrada AS DATE) = ? AND marcacion_accessid = ? AND legreloj_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $marcaciondatetime, PDO::PARAM_STR);
													$stm->bindValue(2, $salida, PDO::PARAM_STR);
													$stm->bindValue(3, date("Y-m-d", $i), PDO::PARAM_STR);
													$stm->bindValue(4, $marcacionaccessid, PDO::PARAM_STR);
													$stm->bindValue(5, $rowlr->legreloj_id, PDO::PARAM_STR);
													$stm->execute();
													//--- Cambiar estado de marcacion actual
													$proceso = 3;
													$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $proceso, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
													$stm->execute();
												}else{
													//----- Marcacion de salida no encontrada en este rango de busqueda, consultar marcacion Entrada en estado 1 descartar -----
													$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_domingohe;
													$horarioti = strtotime('-50 minute', strtotime($horfec));
													$horarioti = date ('Y-m-d H:i:s', $horarioti);
													$horariotf = strtotime('+50 minute', strtotime($horfec));
													$horariotf = date ('Y-m-d H:i:s', $horariotf);
													if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
														//------- esta en el rango y ya esta procesada la entrada, preguntar si es estado 1 Descartar-----
														$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->execute();
														$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
														$marcacionc = $stm->rowCount();
														$mestado = $marcacionr->mestado_id;
														if($mestado == 1){
															//------ Descartar actual -------
															$proceso = 9;
															$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
															$stm = $this->cn->prepare($sql);
															$stm->bindValue(1, $proceso, PDO::PARAM_STR);
															$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
															$stm->execute();
														}else{
															//----- No descartar, tiene un estado distinto a uno -----
														}
													}else{
														//-------- No se encontro en el rango de entrada, consultar si es igual a 1, descartar ----
														$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->execute();
														$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
														$marcacionc = $stm->rowCount();
														$mestado = $marcacionr->mestado_id;
														if($mestado == 1){
															//------ Descartar actual -------
															$proceso = 5;
															$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
															$stm = $this->cn->prepare($sql);
															$stm->bindValue(1, $proceso, PDO::PARAM_STR);
															$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
															$stm->execute();
														}else{
															//----- No descartar, tiene un estado distinto a uno -----
														}
													}
												}
											}else{
												//--- No ficha dia domingo, consultar si es distinto a estado uno ----
												$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
												$stm->execute();
												$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
												$marcacionc = $stm->rowCount();
												$mestado = $marcacionr->mestado_id;
												if($mestado == 1){
													//------ Descartar actual -------
													$proceso = 6;
													$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $proceso, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
													$stm->execute();
												}else{
													//------- No descartar, no es estado 1 -------
												}
											}
										//}
									}elseif($dia == 1){
										//---Lunes----
										//foreach($rows as $rowlr){
											if($rowlr->legreloj_lunes == 1){
												//-----Si, ficha. Define hasta que punto se busca la marcacion--------
												$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_luneshs;
												$horarioti = strtotime('-50 minute', strtotime($horfec));
												$horarioti = date ('Y-m-d H:i:s', $horarioti);
												$horariotf = strtotime('+50 minute', strtotime($horfec));
												$horariotf = date ('Y-m-d H:i:s', $horariotf);
												if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
													//---- Se encontro la marcacion -----
													$datetime = new DateTime("$marcaciondatetime");
													$time = $datetime->format('H:i:s');
													$salida = date("Y-m-d", $i)." ".$time;
													$sql = 'UPDATE marcaciones_proceso SET mprocesop_salida = ?, mprocesom_salida = ? WHERE CAST(mprocesom_entrada AS DATE) = ? AND marcacion_accessid = ? AND legreloj_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $marcaciondatetime, PDO::PARAM_STR);
													$stm->bindValue(2, $salida, PDO::PARAM_STR);
													$stm->bindValue(3, date("Y-m-d", $i), PDO::PARAM_STR);
													$stm->bindValue(4, $marcacionaccessid, PDO::PARAM_STR);
													$stm->bindValue(5, $rowlr->legreloj_id, PDO::PARAM_STR);
													$stm->execute();
													//--- Cambiar estado de marcacion actual
													$proceso = 3;
													$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $proceso, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
													$stm->execute();
												}else{
													//----- Marcacion no encontrada en este rango de busqueda, consultar marcacion Entrada en estado 1 descartar -----
													$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_luneshe;
													$horarioti = strtotime('-50 minute', strtotime($horfec));
													$horarioti = date ('Y-m-d H:i:s', $horarioti);
													$horariotf = strtotime('+50 minute', strtotime($horfec));
													$horariotf = date ('Y-m-d H:i:s', $horariotf);
													if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
														//------- esta en el rango y ya esta procesada la entrada, preguntar si es estado 1 Descartar-----
														$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->execute();
														$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
														$marcacionc = $stm->rowCount();
														$mestado = $marcacionr->mestado_id;
														if($mestado == 1){
															//------ Descartar actual -------
															$proceso = 9;
															$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
															$stm = $this->cn->prepare($sql);
															$stm->bindValue(1, $proceso, PDO::PARAM_STR);
															$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
															$stm->execute();
														}else{
															//----- No descartar, tiene un estado distinto a uno -----
														}
													}else{
														//-------- No se encontro en el rango de entrada, consultar si es igual a 1, descartar ----
														$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->execute();
														$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
														$marcacionc = $stm->rowCount();
														$mestado = $marcacionr->mestado_id;
														if($mestado == 1){
															//------ Descartar actual -------
															$proceso = 5;
															$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
															$stm = $this->cn->prepare($sql);
															$stm->bindValue(1, $proceso, PDO::PARAM_STR);
															$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
															$stm->execute();
														}else{
															//----- No descartar, tiene un estado distinto a uno -----
														}
													}
												}
											}else{
												//--- No ficha dia Lunes, consultar si es distinto a estado uno ----
												$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
												$stm->execute();
												$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
												$marcacionc = $stm->rowCount();
												$mestado = $marcacionr->mestado_id;
												if($mestado == 1){
													//------ Descartar actual -------
													$proceso = 6;
													$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $proceso, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
													$stm->execute();
												}else{
													//------- No descartar, no es estado 1 -------
												}
											}
										//}
									}elseif($dia == 2){
										//---Martes----
										//foreach($rows as $rowlr){
											if($rowlr->legreloj_martes == 1){
												//-----Si, ficha. Define hasta que punto se busca la marcacion--------
												$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_marteshs;
												$horarioti = strtotime('-50 minute', strtotime($horfec));
												$horarioti = date ('Y-m-d H:i:s', $horarioti);
												$horariotf = strtotime('+50 minute', strtotime($horfec));
												$horariotf = date ('Y-m-d H:i:s', $horariotf);
												if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
													//---- Se encontro la marcacion -----
													$datetime = new DateTime("$marcaciondatetime");
													$time = $datetime->format('H:i:s');
													$salida = date("Y-m-d", $i)." ".$time;
													$sql = 'UPDATE marcaciones_proceso SET mprocesop_salida = ?, mprocesom_salida = ? WHERE CAST(mprocesom_entrada AS DATE) = ? AND marcacion_accessid = ? AND legreloj_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $marcaciondatetime, PDO::PARAM_STR);
													$stm->bindValue(2, $salida, PDO::PARAM_STR);
													$stm->bindValue(3, date("Y-m-d", $i), PDO::PARAM_STR);
													$stm->bindValue(4, $marcacionaccessid, PDO::PARAM_STR);
													$stm->bindValue(5, $rowlr->legreloj_id, PDO::PARAM_STR);
													$stm->execute();
													//--- Cambiar estado de marcacion actual
													$proceso = 3;
													$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $proceso, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
													$stm->execute();
												}else{
													//----- Marcacion no encontrada en este rango de busqueda, consultar marcacion Entrada en estado 1 descartar -----
													$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_marteshe;
													$horarioti = strtotime('-50 minute', strtotime($horfec));
													$horarioti = date ('Y-m-d H:i:s', $horarioti);
													$horariotf = strtotime('+50 minute', strtotime($horfec));
													$horariotf = date ('Y-m-d H:i:s', $horariotf);
													if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
														//------- esta en el rango y ya esta procesada la entrada, preguntar si es estado 1 Descartar-----
														$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->execute();
														$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
														$marcacionc = $stm->rowCount();
														$mestado = $marcacionr->mestado_id;
														if($mestado == 1){
															//------ Descartar actual -------
															$proceso = 9;
															$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
															$stm = $this->cn->prepare($sql);
															$stm->bindValue(1, $proceso, PDO::PARAM_STR);
															$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
															$stm->execute();
														}else{
															//----- No descartar, tiene un estado distinto a uno -----
														}
													}else{
														//-------- No se encontro en el rango de entrada, consultar si es igual a 1, descartar ----
														$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->execute();
														$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
														$marcacionc = $stm->rowCount();
														$mestado = $marcacionr->mestado_id;
														if($mestado == 1){
															//------ Descartar actual -------
															$proceso = 5;
															$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
															$stm = $this->cn->prepare($sql);
															$stm->bindValue(1, $proceso, PDO::PARAM_STR);
															$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
															$stm->execute();
														}else{
															//----- No descartar, tiene un estado distinto a uno -----
														}
													}
												}
											}else{
												//--- No ficha dia martes, consultar si es distinto a estado uno ----
												$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
												$stm->execute();
												$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
												$marcacionc = $stm->rowCount();
												$mestado = $marcacionr->mestado_id;
												if($mestado == 1){
													//------ Descartar actual -------
													$proceso = 6;
													$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $proceso, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
													$stm->execute();
												}else{
													//------- No descartar, no es estado 1 -------
												}
											}
										//}
									}elseif($dia == 3){
										//---Miercoles----
										//foreach($rows as $rowlr){
											if($rowlr->legreloj_miercoles == 1){
												//-----Si, ficha. Define hasta que punto se busca la marcacion--------
												$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_miercoleshs;
												$horarioti = strtotime('-50 minute', strtotime($horfec));
												$horarioti = date ('Y-m-d H:i:s', $horarioti);
												$horariotf = strtotime('+50 minute', strtotime($horfec));
												$horariotf = date ('Y-m-d H:i:s', $horariotf);
												if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
													//---- Se encontro la marcacion -----
													$datetime = new DateTime("$marcaciondatetime");
													$time = $datetime->format('H:i:s');
													$salida = date("Y-m-d", $i)." ".$time;
													$sql = 'UPDATE marcaciones_proceso SET mprocesop_salida = ?, mprocesom_salida = ? WHERE CAST(mprocesom_entrada AS DATE) = ? AND marcacion_accessid = ? AND legreloj_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $marcaciondatetime, PDO::PARAM_STR);
													$stm->bindValue(2, $salida, PDO::PARAM_STR);
													$stm->bindValue(3, date("Y-m-d", $i), PDO::PARAM_STR);
													$stm->bindValue(4, $marcacionaccessid, PDO::PARAM_STR);
													$stm->bindValue(5, $rowlr->legreloj_id, PDO::PARAM_STR);
													$stm->execute();
													//--- Cambiar estado de marcacion actual
													$proceso = 3;
													$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $proceso, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
													$stm->execute();
												}else{
													//----- Marcacion no encontrada en este rango de busqueda, consultar marcacion Entrada en estado 1 descartar -----
													$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_miercoleshe;
													$horarioti = strtotime('-50 minute', strtotime($horfec));
													$horarioti = date ('Y-m-d H:i:s', $horarioti);
													$horariotf = strtotime('+50 minute', strtotime($horfec));
													$horariotf = date ('Y-m-d H:i:s', $horariotf);
													if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
														//------- esta en el rango y ya esta procesada la entrada, preguntar si es estado 1 Descartar-----
														$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->execute();
														$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
														$marcacionc = $stm->rowCount();
														$mestado = $marcacionr->mestado_id;
														if($mestado == 1){
															//------ Descartar actual -------
															$proceso = 9;
															$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
															$stm = $this->cn->prepare($sql);
															$stm->bindValue(1, $proceso, PDO::PARAM_STR);
															$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
															$stm->execute();
														}else{
															//----- No descartar, tiene un estado distinto a uno -----
														}
													}else{
														//-------- No se encontro en el rango de entrada, consultar si es igual a 1, descartar ----
														$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->execute();
														$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
														$marcacionc = $stm->rowCount();
														$mestado = $marcacionr->mestado_id;
														if($mestado == 1){
															//------ Descartar actual -------
															$proceso = 5;
															$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
															$stm = $this->cn->prepare($sql);
															$stm->bindValue(1, $proceso, PDO::PARAM_STR);
															$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
															$stm->execute();
														}else{
															//----- No descartar, tiene un estado distinto a uno -----
														}
													}
												}
											}else{
												//--- No ficha dia miercoles, consultar si es distinto a estado uno ----
												$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
												$stm->execute();
												$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
												$marcacionc = $stm->rowCount();
												$mestado = $marcacionr->mestado_id;
												if($mestado == 1){
													//------ Descartar actual -------
													$proceso = 6;
													$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $proceso, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
													$stm->execute();
												}else{
													//------- No descartar, no es estado 1 -------
												}
											}
										//}
									}elseif($dia == 4){
										//---Jueves----
										//foreach($rows as $rowlr){
											if($rowlr->legreloj_jueves == 1){
												//-----Si, ficha. Define hasta que punto se busca la marcacion--------
												$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_jueveshs;
												$horarioti = strtotime('-50 minute', strtotime($horfec));
												$horarioti = date ('Y-m-d H:i:s', $horarioti);
												$horariotf = strtotime('+50 minute', strtotime($horfec));
												$horariotf = date ('Y-m-d H:i:s', $horariotf);
												if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
													//---- Se encontro la marcacion -----
													$datetime = new DateTime("$marcaciondatetime");
													$time = $datetime->format('H:i:s');
													$salida = date("Y-m-d", $i)." ".$time;
													$sql = 'UPDATE marcaciones_proceso SET mprocesop_salida = ?, mprocesom_salida = ? WHERE CAST(mprocesom_entrada AS DATE) = ? AND marcacion_accessid = ? AND legreloj_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $marcaciondatetime, PDO::PARAM_STR);
													$stm->bindValue(2, $salida, PDO::PARAM_STR);
													$stm->bindValue(3, date("Y-m-d", $i), PDO::PARAM_STR);
													$stm->bindValue(4, $marcacionaccessid, PDO::PARAM_STR);
													$stm->bindValue(5, $rowlr->legreloj_id, PDO::PARAM_STR);
													$stm->execute();
													//--- Cambiar estado de marcacion actual
													$proceso = 3;
													$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $proceso, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
													$stm->execute();
												}else{
													//----- Marcacion no encontrada en este rango de busqueda, consultar marcacion Entrada en estado 1 descartar -----
													$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_jueveshe;
													$horarioti = strtotime('-50 minute', strtotime($horfec));
													$horarioti = date ('Y-m-d H:i:s', $horarioti);
													$horariotf = strtotime('+50 minute', strtotime($horfec));
													$horariotf = date ('Y-m-d H:i:s', $horariotf);
													if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
														//------- esta en el rango y ya esta procesada la entrada, preguntar si es estado 1 Descartar-----
														$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->execute();
														$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
														$marcacionc = $stm->rowCount();
														$mestado = $marcacionr->mestado_id;
														if($mestado == 1){
															//------ Descartar actual -------
															$proceso = 9;
															$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
															$stm = $this->cn->prepare($sql);
															$stm->bindValue(1, $proceso, PDO::PARAM_STR);
															$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
															$stm->execute();
														}else{
															//----- No descartar, tiene un estado distinto a uno -----
														}
													}else{
														//-------- No se encontro en el rango de entrada, consultar si es igual a 1, descartar ----
														$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->execute();
														$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
														$marcacionc = $stm->rowCount();
														$mestado = $marcacionr->mestado_id;
														if($mestado == 1){
															//------ Descartar actual -------
															$proceso = 5;
															$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
															$stm = $this->cn->prepare($sql);
															$stm->bindValue(1, $proceso, PDO::PARAM_STR);
															$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
															$stm->execute();
														}else{
															//----- No descartar, tiene un estado distinto a uno -----
														}
													}
												}
											}else{
												//--- No ficha dia jueves, consultar si es distinto a estado uno ----
												$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
												$stm->execute();
												$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
												$marcacionc = $stm->rowCount();
												$mestado = $marcacionr->mestado_id;
												if($mestado == 1){
													//------ Descartar actual -------
													$proceso = 6;
													$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $proceso, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
													$stm->execute();
												}else{
													//------- No descartar, no es estado 1 -------
												}
											}
										//}
									}elseif($dia == 5){
										//---Viernes----
										//foreach($rows as $rowlr){
											if($rowlr->legreloj_viernes == 1){
												//-----Si, ficha. Define hasta que punto se busca la marcacion--------
												$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_vierneshs;
												$horarioti = strtotime('-50 minute', strtotime($horfec));
												$horarioti = date ('Y-m-d H:i:s', $horarioti);
												$horariotf = strtotime('+50 minute', strtotime($horfec));
												$horariotf = date ('Y-m-d H:i:s', $horariotf);
												if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
													//---- Se encontro la marcacion -----
													$datetime = new DateTime("$marcaciondatetime");
													$time = $datetime->format('H:i:s');
													$salida = date("Y-m-d", $i)." ".$time;
													$sql = 'UPDATE marcaciones_proceso SET mprocesop_salida = ?, mprocesom_salida = ? WHERE CAST(mprocesom_entrada AS DATE) = ? AND marcacion_accessid = ? AND legreloj_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $marcaciondatetime, PDO::PARAM_STR);
													$stm->bindValue(2, $salida, PDO::PARAM_STR);
													$stm->bindValue(3, date("Y-m-d", $i), PDO::PARAM_STR);
													$stm->bindValue(4, $marcacionaccessid, PDO::PARAM_STR);
													$stm->bindValue(5, $rowlr->legreloj_id, PDO::PARAM_STR);
													$stm->execute();
													//--- Cambiar estado de marcacion actual
													$proceso = 3;
													$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $proceso, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
													$stm->execute();
												}else{
													//----- Marcacion no encontrada en este rango de busqueda, consultar marcacion Entrada en estado 1 descartar -----
													$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_vierneshe;
													$horarioti = strtotime('-50 minute', strtotime($horfec));
													$horarioti = date ('Y-m-d H:i:s', $horarioti);
													$horariotf = strtotime('+50 minute', strtotime($horfec));
													$horariotf = date ('Y-m-d H:i:s', $horariotf);
													if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
														//------- esta en el rango y ya esta procesada la entrada, preguntar si es estado 1 Descartar-----
														$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->execute();
														$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
														$marcacionc = $stm->rowCount();
														$mestado = $marcacionr->mestado_id;
														if($mestado == 1){
															//------ Descartar actual -------
															$proceso = 9;
															$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
															$stm = $this->cn->prepare($sql);
															$stm->bindValue(1, $proceso, PDO::PARAM_STR);
															$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
															$stm->execute();
														}else{
															//----- No descartar, tiene un estado distinto a uno -----
														}
													}else{
														//-------- No se encontro en el rango de entrada, consultar si es igual a 1, descartar ----
														$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->execute();
														$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
														$marcacionc = $stm->rowCount();
														$mestado = $marcacionr->mestado_id;
														if($mestado == 1){
															//------ Descartar actual -------
															$proceso = 5;
															$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
															$stm = $this->cn->prepare($sql);
															$stm->bindValue(1, $proceso, PDO::PARAM_STR);
															$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
															$stm->execute();
														}else{
															//----- No descartar, tiene un estado distinto a uno -----
														}
													}
												}
											}else{
												//--- No ficha dia viernes, consultar si es distinto a estado uno ----
												$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
												$stm->execute();
												$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
												$marcacionc = $stm->rowCount();
												$mestado = $marcacionr->mestado_id;
												if($mestado == 1){
													//------ Descartar actual -------
													$proceso = 6;
													$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $proceso, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
													$stm->execute();
												}else{
													//------- No descartar, no es estado 1 -------
												}
											}
										//}
									}elseif($dia == 6){
										//---Sabado----
										//foreach($rows as $rowlr){
											if($rowlr->legreloj_sabado == 1){
												//-----Si, ficha. Define hasta que punto se busca la marcacion--------
												$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_sabadohs;
												$horarioti = strtotime('-50 minute', strtotime($horfec));
												$horarioti = date ('Y-m-d H:i:s', $horarioti);
												$horariotf = strtotime('+50 minute', strtotime($horfec));
												$horariotf = date ('Y-m-d H:i:s', $horariotf);
												if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
													//---- Se encontro la marcacion -----
													$datetime = new DateTime("$marcaciondatetime");
													$time = $datetime->format('H:i:s');
													$salida = date("Y-m-d", $i)." ".$time;
													$sql = 'UPDATE marcaciones_proceso SET mprocesop_salida = ?, mprocesom_salida = ? WHERE CAST(mprocesom_entrada AS DATE) = ? AND marcacion_accessid = ? AND legreloj_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $marcaciondatetime, PDO::PARAM_STR);
													$stm->bindValue(2, $salida, PDO::PARAM_STR);
													$stm->bindValue(3, date("Y-m-d", $i), PDO::PARAM_STR);
													$stm->bindValue(4, $marcacionaccessid, PDO::PARAM_STR);
													$stm->bindValue(5, $rowlr->legreloj_id, PDO::PARAM_STR);
													$stm->execute();
													//--- Cambiar estado de marcacion actual
													$proceso = 3;
													$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $proceso, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
													$stm->execute();
												}else{
													//----- Marcacion no encontrada en este rango de busqueda, consultar marcacion Entrada en estado 1 descartar -----
													$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_sabadohe;
													$horarioti = strtotime('-50 minute', strtotime($horfec));
													$horarioti = date ('Y-m-d H:i:s', $horarioti);
													$horariotf = strtotime('+50 minute', strtotime($horfec));
													$horariotf = date ('Y-m-d H:i:s', $horariotf);
													if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
														//------- esta en el rango y ya esta procesada la entrada, preguntar si es estado 1 Descartar-----
														$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->execute();
														$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
														$marcacionc = $stm->rowCount();
														$mestado = $marcacionr->mestado_id;
														if($mestado == 1){
															//------ Descartar actual -------
															$proceso = 9;
															$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
															$stm = $this->cn->prepare($sql);
															$stm->bindValue(1, $proceso, PDO::PARAM_STR);
															$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
															$stm->execute();
														}else{
															//----- No descartar, tiene un estado distinto a uno -----
														}
													}else{
														//-------- No se encontro en el rango de entrada, consultar si es igual a 1, descartar ----
														$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->execute();
														$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
														$marcacionc = $stm->rowCount();
														$mestado = $marcacionr->mestado_id;
														if($mestado == 1){
															//------ Descartar actual -------
															$proceso = 5;
															$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
															$stm = $this->cn->prepare($sql);
															$stm->bindValue(1, $proceso, PDO::PARAM_STR);
															$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
															$stm->execute();
														}else{
															//----- No descartar, tiene un estado distinto a uno -----
														}
													}
												}
											}else{
												//--- No ficha dia Sabado, consultar si es distinto a estado uno ----
												$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
												$stm->execute();
												$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
												$marcacionc = $stm->rowCount();
												$mestado = $marcacionr->mestado_id;
												if($mestado == 1){
													//------ Descartar actual -------
													$proceso = 6;
													$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $proceso, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
													$stm->execute();
												}else{
													//------- No descartar, no es estado 1 -------
												}
											}
										//}
									}else{
										//--- Default Error, descartar ---
										$proceso = 7;
										$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
										$stm = $this->cn->prepare($sql);
										$stm->bindValue(1, $proceso, PDO::PARAM_STR);
										$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
										$stm->execute();
									}
								}
							}else{
								//-------Entrada no procesada, preguntar si hay marcaciones para procesar----------
								$dia = strftime("%w", strtotime(date("Y-m-d", $i)));
								if($dia == 0){
									//---Domingo----
									//foreach($rows as $rowlr){
										if($rowlr->legreloj_domingo == 1){
											//-----Si, ficha. Define hasta que punto se busca la marcacion--------
											$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_domingohe;
											$horarioti = strtotime('-50 minute', strtotime($horfec));
											$horarioti = date ('Y-m-d H:i:s', $horarioti);
											$horariotf = strtotime('+50 minute', strtotime($horfec));
											$horariotf = date ('Y-m-d H:i:s', $horariotf);
											if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
												//------------Se encontro la marcacion---------
												$condicion = 1;
												$datetime = new DateTime("$marcaciondatetime");
												$time = $datetime->format('H:i:s');
												$entrada = date("Y-m-d", $i)." ".$time;
												$salida = "0000-00-00 00:00:00";
												//--- aca comienzo periodo
												$fechaamd = date("Y-m-d", $i);
												$periodo_dos_ultimos = Empleado::PeriodosUsDos();
												foreach($periodo_dos_ultimos as $periodo_row){
													if($fechaamd>=$periodo_row->periodo_hsext_jor_i && $fechaamd<=$periodo_row->periodo_hsext_jor_f){
														//esta en este rango
														$periodo_ok = $periodo_row->periodo_id;
													}else{
														//no esta en este rango
													}
												}
												//--- aca fin periodo
												$ficha = 1;
												$cerrado = 0;
												$activo = 1;
												//-------- Insert de marcacion entrada ------
												$sql = 'INSERT INTO marcaciones_proceso
												(legempleado_nrodocto,marcacion_accessid,mcondicion_id,reloj_id,legreloj_id,mprocesop_entrada,mprocesop_salida,mprocesom_entrada,mprocesom_salida,periodo_id,mproceso_ficha,mproceso_cerrado,mproceso_activo)
												VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $rowlr->legempleado_nrodocto, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
												$stm->bindValue(3, $condicion, PDO::PARAM_STR);
												$stm->bindValue(4, $rowlr->reloj_id, PDO::PARAM_STR);
												$stm->bindValue(5, $rowlr->legreloj_id, PDO::PARAM_STR);
												$stm->bindValue(6, $marcaciondatetime, PDO::PARAM_STR);
												$stm->bindValue(7, $salida, PDO::PARAM_STR);
												$stm->bindValue(8, $entrada, PDO::PARAM_STR);
												$stm->bindValue(9, $salida, PDO::PARAM_STR);
												$stm->bindValue(10, $periodo_ok, PDO::PARAM_STR);
												$stm->bindValue(11, $ficha, PDO::PARAM_STR);
												$stm->bindValue(12, $cerrado, PDO::PARAM_STR);
												$stm->bindValue(13, $activo, PDO::PARAM_STR);
												$stm->execute();
												//------ Update de Marcacion a estado procesada---
												$proceso = 2;
												$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $proceso, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
												$stm->execute();

											}else{
												//----No se encontro marcacion (Entrada) en este rango de busqueda, preguntar salida-----
												$sql = 'SELECT * FROM marcaciones_proceso WHERE marcacion_accessid = ? AND CAST(mprocesom_salida AS DATE) = ? AND legreloj_id = ?';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $marcacionaccessid, PDO::PARAM_STR);
												$stm->bindValue(2, date("Y-m-d", $i), PDO::PARAM_STR);
												$stm->bindValue(3, $rowlr->legreloj_id, PDO::PARAM_STR);
												$stm->execute();
												$mprocs = $stm->rowCount();
												//----Preguntar si esta procesada la salida
												if($mprocs == 1){
													//--------Ya esta procesada la salida, descartar marcacion actual
													//----- Marcacion no encontrada en este rango de busqueda, consultar marcacion estado 1 -----
													$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
													$stm->execute();
													$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
													$marcacionc = $stm->rowCount();
													$mestado = $marcacionr->mestado_id;
													if($mestado == 1){
														//------ Descartar actual -------
														$proceso = 8;
														$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $proceso, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
														$stm->execute();
													}else{
														//----- No descartar, tiene un estado distinto a uno -----
													}
												}else{
													//-----Define hasta que punto se busca la marcacion de salida--------
													$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_domingohs;
													$horarioti = strtotime('-50 minute', strtotime($horfec));
													$horarioti = date ('Y-m-d H:i:s', $horarioti);
													$horariotf = strtotime('+50 minute', strtotime($horfec));
													$horariotf = date ('Y-m-d H:i:s', $horariotf);
													if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
														//---- Se encontro marcacion de Salida
														$condicion = 1;
														$entrada = "0000-00-00 00:00:00";
														$datetime = new DateTime("$marcaciondatetime");
														$time = $datetime->format('H:i:s');
														$salida = date("Y-m-d", $i)." ".$time;
														//--- aca comienzo periodo
														$fechaamd = date("Y-m-d", $i);
														$periodo_dos_ultimos = Empleado::PeriodosUsDos();
														foreach($periodo_dos_ultimos as $periodo_row){
															if($fechaamd>=$periodo_row->periodo_hsext_jor_i && $fechaamd<=$periodo_row->periodo_hsext_jor_f){
																//esta en este rango
																$periodo_ok = $periodo_row->periodo_id;
															}else{
																//no esta en este rango
															}
														}
														//--- aca fin periodo
														$ficha = 1;
														$cerrado = 0;
														$activo = 1;
														//-------- Insert de marcacion salida ------
														$sql = 'INSERT INTO marcaciones_proceso
														(legempleado_nrodocto,marcacion_accessid,mcondicion_id,reloj_id,legreloj_id,mprocesop_entrada,mprocesop_salida,mprocesom_entrada,mprocesom_salida,periodo_id,mproceso_ficha,mproceso_cerrado,mproceso_activo)
														VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $rowlr->legempleado_nrodocto, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->bindValue(3, $condicion, PDO::PARAM_STR);
														$stm->bindValue(4, $rowlr->reloj_id, PDO::PARAM_STR);
														$stm->bindValue(5, $rowlr->legreloj_id, PDO::PARAM_STR);
														$stm->bindValue(6, $entrada, PDO::PARAM_STR);
														$stm->bindValue(7, $marcaciondatetime, PDO::PARAM_STR);
														$stm->bindValue(8, $entrada, PDO::PARAM_STR);
														$stm->bindValue(9, $salida, PDO::PARAM_STR);
														$stm->bindValue(10, $periodo_ok, PDO::PARAM_STR);
														$stm->bindValue(11, $ficha, PDO::PARAM_STR);
														$stm->bindValue(12, $cerrado, PDO::PARAM_STR);
														$stm->bindValue(13, $activo, PDO::PARAM_STR);
														$stm->execute();
														//------ Update de Marcacion a estado procesada---
														$proceso = 3;
														$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $proceso, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
														$stm->execute();

													}else{
														//----- Marcacion no encontrada en este rango de busqueda, consultar marcacion estado 1 -----
														$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->execute();
														$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
														$marcacionc = $stm->rowCount();
														$mestado = $marcacionr->mestado_id;
														if($mestado == 1){
															//------ Descartar actual -------
															$proceso = 5;
															$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
															$stm = $this->cn->prepare($sql);
															$stm->bindValue(1, $proceso, PDO::PARAM_STR);
															$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
															$stm->execute();
														}else{
															//----- No descartar, tiene un estado distinto a uno -----
														}
													}
												}
											}
										}else{
											//--- No ficha dia domingo, consultar si es distinto a estado uno ----
											$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
											$stm = $this->cn->prepare($sql);
											$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
											$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
											$stm->execute();
											$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
											$marcacionc = $stm->rowCount();
											$mestado = $marcacionr->mestado_id;
											if($mestado == 1){
												//------ Descartar actual -------
												$proceso = 6;
												$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $proceso, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
												$stm->execute();
											}else{
												//------- No descartar, no es estado 1 -------
											}
										}
									//}
								}elseif($dia == 1){
									//---Lunes----
									//foreach($rows as $rowlr){
										if($rowlr->legreloj_lunes == 1){
											//-----Si, ficha. Define hasta que punto se busca la marcacion--------
											$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_luneshe;
											$horarioti = strtotime('-50 minute', strtotime($horfec));
											$horarioti = date ('Y-m-d H:i:s', $horarioti);
											$horariotf = strtotime('+50 minute', strtotime($horfec));
											$horariotf = date ('Y-m-d H:i:s', $horariotf);
											if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
												//------------Se encontro la marcacion---------
												$condicion = 1;
												$datetime = new DateTime("$marcaciondatetime");
												$time = $datetime->format('H:i:s');
												$entrada = date("Y-m-d", $i)." ".$time;
												$salida = "0000-00-00 00:00:00";
												//--- aca comienzo periodo
												$fechaamd = date("Y-m-d", $i);
												$periodo_dos_ultimos = Empleado::PeriodosUsDos();
												foreach($periodo_dos_ultimos as $periodo_row){
													if($fechaamd>=$periodo_row->periodo_hsext_jor_i && $fechaamd<=$periodo_row->periodo_hsext_jor_f){
														//esta en este rango
														$periodo_ok = $periodo_row->periodo_id;
													}else{
														//no esta en este rango
													}
												}
												//--- aca fin periodo
												$ficha = 1;
												$cerrado = 0;
												$activo = 1;
												//-------- Insert de marcacion entrada ------
												$sql = 'INSERT INTO marcaciones_proceso
												(legempleado_nrodocto,marcacion_accessid,mcondicion_id,reloj_id,legreloj_id,mprocesop_entrada,mprocesop_salida,mprocesom_entrada,mprocesom_salida,periodo_id,mproceso_ficha,mproceso_cerrado,mproceso_activo)
												VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $rowlr->legempleado_nrodocto, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
												$stm->bindValue(3, $condicion, PDO::PARAM_STR);
												$stm->bindValue(4, $rowlr->reloj_id, PDO::PARAM_STR);
												$stm->bindValue(5, $rowlr->legreloj_id, PDO::PARAM_STR);
												$stm->bindValue(6, $marcaciondatetime, PDO::PARAM_STR);
												$stm->bindValue(7, $salida, PDO::PARAM_STR);
												$stm->bindValue(8, $entrada, PDO::PARAM_STR);
												$stm->bindValue(9, $salida, PDO::PARAM_STR);
												$stm->bindValue(10, $periodo_ok, PDO::PARAM_STR);
												$stm->bindValue(11, $ficha, PDO::PARAM_STR);
												$stm->bindValue(12, $cerrado, PDO::PARAM_STR);
												$stm->bindValue(13, $activo, PDO::PARAM_STR);
												$stm->execute();
												//------ Update de Marcacion a estado procesada---
												$proceso = 2;
												$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $proceso, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
												$stm->execute();

											}else{
												//----No se encontro marcacion (Entrada) en este rango de busqueda, preguntar salida-----
												$sql = 'SELECT * FROM marcaciones_proceso WHERE marcacion_accessid = ? AND CAST(mprocesom_salida AS DATE) = ? AND legreloj_id = ?';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $marcacionaccessid, PDO::PARAM_STR);
												$stm->bindValue(2, date("Y-m-d", $i), PDO::PARAM_STR);
												$stm->bindValue(3, $rowlr->legreloj_id, PDO::PARAM_STR);
												$stm->execute();
												$mprocs = $stm->rowCount();
												//----Preguntar si esta procesada la salida
												if($mprocs == 1){
													//--------Ya esta procesada la salida, descartar marcacion actual
													//----- Marcacion no encontrada en este rango de busqueda, consultar marcacion estado 1 -----
													$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
													$stm->execute();
													$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
													$marcacionc = $stm->rowCount();
													$mestado = $marcacionr->mestado_id;
													if($mestado == 1){
														//------ Descartar actual -------
														$proceso = 8;
														$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $proceso, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
														$stm->execute();
													}else{
														//----- No descartar, tiene un estado distinto a uno -----
													}

												}else{
													//-----Define hasta que punto se busca la marcacion de salida--------
													$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_luneshs;
													$horarioti = strtotime('-50 minute', strtotime($horfec));
													$horarioti = date ('Y-m-d H:i:s', $horarioti);
													$horariotf = strtotime('+50 minute', strtotime($horfec));
													$horariotf = date ('Y-m-d H:i:s', $horariotf);
													if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
														//---- Se encontro marcacion de Salida
														$condicion = 1;
														$entrada = "0000-00-00 00:00:00";
														$datetime = new DateTime("$marcaciondatetime");
														$time = $datetime->format('H:i:s');
														$salida = date("Y-m-d", $i)." ".$time;
														//--- aca comienzo periodo
														$fechaamd = date("Y-m-d", $i);
														$periodo_dos_ultimos = Empleado::PeriodosUsDos();
														foreach($periodo_dos_ultimos as $periodo_row){
															if($fechaamd>=$periodo_row->periodo_hsext_jor_i && $fechaamd<=$periodo_row->periodo_hsext_jor_f){
																//esta en este rango
																$periodo_ok = $periodo_row->periodo_id;
															}else{
																//no esta en este rango
															}
														}
														//--- aca fin periodo
														$ficha = 1;
														$cerrado = 0;
														$activo = 1;
														//-------- Insert de marcacion salida ------
														$sql = 'INSERT INTO marcaciones_proceso
														(legempleado_nrodocto,marcacion_accessid,mcondicion_id,reloj_id,legreloj_id,mprocesop_entrada,mprocesop_salida,mprocesom_entrada,mprocesom_salida,periodo_id,mproceso_ficha,mproceso_cerrado,mproceso_activo)
														VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $rowlr->legempleado_nrodocto, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->bindValue(3, $condicion, PDO::PARAM_STR);
														$stm->bindValue(4, $rowlr->reloj_id, PDO::PARAM_STR);
														$stm->bindValue(5, $rowlr->legreloj_id, PDO::PARAM_STR);
														$stm->bindValue(6, $entrada, PDO::PARAM_STR);
														$stm->bindValue(7, $marcaciondatetime, PDO::PARAM_STR);
														$stm->bindValue(8, $entrada, PDO::PARAM_STR);
														$stm->bindValue(9, $salida, PDO::PARAM_STR);
														$stm->bindValue(10, $periodo_ok, PDO::PARAM_STR);
														$stm->bindValue(11, $ficha, PDO::PARAM_STR);
														$stm->bindValue(12, $cerrado, PDO::PARAM_STR);
														$stm->bindValue(13, $activo, PDO::PARAM_STR);
														$stm->execute();
														//------ Update de Marcacion a estado procesada---
														$proceso = 3;
														$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $proceso, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
														$stm->execute();

													}else{
														//----- Marcacion no encontrada en este rango de busqueda, consultar marcacion estado 1 -----
														$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->execute();
														$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
														$marcacionc = $stm->rowCount();
														$mestado = $marcacionr->mestado_id;
														if($mestado == 1){
															//------ Descartar actual -------
															$proceso = 5;
															$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
															$stm = $this->cn->prepare($sql);
															$stm->bindValue(1, $proceso, PDO::PARAM_STR);
															$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
															$stm->execute();
														}else{
															//----- No descartar, tiene un estado distinto a uno -----
														}
													}
												}
											}
										}else{
											//--- No ficha dia lunes, consultar si es distinto a estado uno ----
											$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
											$stm = $this->cn->prepare($sql);
											$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
											$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
											$stm->execute();
											$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
											$marcacionc = $stm->rowCount();
											$mestado = $marcacionr->mestado_id;
											if($mestado == 1){
												//------ Descartar actual -------
												$proceso = 6;
												$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $proceso, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
												$stm->execute();
											}else{
												//------- No descartar, no es estado 1 -------
											}
										}
									//}
								}elseif($dia == 2){
									//---Martes----
									//foreach($rows as $rowlr){
										if($rowlr->legreloj_martes == 1){
											//-----Si, ficha. Define hasta que punto se busca la marcacion--------
											$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_marteshe;
											$horarioti = strtotime('-50 minute', strtotime($horfec));
											$horarioti = date ('Y-m-d H:i:s', $horarioti);
											$horariotf = strtotime('+50 minute', strtotime($horfec));
											$horariotf = date ('Y-m-d H:i:s', $horariotf);
											if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
												//------------Se encontro la marcacion---------
												$condicion = 1;
												$datetime = new DateTime("$marcaciondatetime");
												$time = $datetime->format('H:i:s');
												$entrada = date("Y-m-d", $i)." ".$time;
												$salida = "0000-00-00 00:00:00";
												//--- aca comienzo periodo
												$fechaamd = date("Y-m-d", $i);
												$periodo_dos_ultimos = Empleado::PeriodosUsDos();
												foreach($periodo_dos_ultimos as $periodo_row){
													if($fechaamd>=$periodo_row->periodo_hsext_jor_i && $fechaamd<=$periodo_row->periodo_hsext_jor_f){
														//esta en este rango
														$periodo_ok = $periodo_row->periodo_id;
													}else{
														//no esta en este rango
													}
												}
												//--- aca fin periodo
												$ficha = 1;
												$cerrado = 0;
												$activo = 1;
												//-------- Insert de marcacion entrada ------
												$sql = 'INSERT INTO marcaciones_proceso
												(legempleado_nrodocto,marcacion_accessid,mcondicion_id,reloj_id,legreloj_id,mprocesop_entrada,mprocesop_salida,mprocesom_entrada,mprocesom_salida,periodo_id,mproceso_ficha,mproceso_cerrado,mproceso_activo)
												VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $rowlr->legempleado_nrodocto, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
												$stm->bindValue(3, $condicion, PDO::PARAM_STR);
												$stm->bindValue(4, $rowlr->reloj_id, PDO::PARAM_STR);
												$stm->bindValue(5, $rowlr->legreloj_id, PDO::PARAM_STR);
												$stm->bindValue(6, $marcaciondatetime, PDO::PARAM_STR);
												$stm->bindValue(7, $salida, PDO::PARAM_STR);
												$stm->bindValue(8, $entrada, PDO::PARAM_STR);
												$stm->bindValue(9, $salida, PDO::PARAM_STR);
												$stm->bindValue(10, $periodo_ok, PDO::PARAM_STR);
												$stm->bindValue(11, $ficha, PDO::PARAM_STR);
												$stm->bindValue(12, $cerrado, PDO::PARAM_STR);
												$stm->bindValue(13, $activo, PDO::PARAM_STR);
												$stm->execute();
												//------ Update de Marcacion a estado procesada---
												$proceso = 2;
												$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $proceso, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
												$stm->execute();

											}else{
												//----No se encontro marcacion (Entrada) en este rango de busqueda, preguntar salida-----
												$sql = 'SELECT * FROM marcaciones_proceso WHERE marcacion_accessid = ? AND CAST(mprocesom_salida AS DATE) = ? AND legreloj_id = ?';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $marcacionaccessid, PDO::PARAM_STR);
												$stm->bindValue(2, date("Y-m-d", $i), PDO::PARAM_STR);
												$stm->bindValue(3, $rowlr->legreloj_id, PDO::PARAM_STR);
												$stm->execute();
												$mprocs = $stm->rowCount();
												//----Preguntar si esta procesada la salida
												if($mprocs == 1){
													//--------Ya esta procesada la salida, descartar marcacion actual
													//----- Marcacion no encontrada en este rango de busqueda, consultar marcacion estado 1 -----
													$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
													$stm->execute();
													$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
													$marcacionc = $stm->rowCount();
													$mestado = $marcacionr->mestado_id;
													if($mestado == 1){
														//------ Descartar actual -------
														$proceso = 8;
														$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $proceso, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
														$stm->execute();
													}else{
														//----- No descartar, tiene un estado distinto a uno -----
													}
												}else{
													//-----Define hasta que punto se busca la marcacion de salida--------
													$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_marteshs;
													$horarioti = strtotime('-50 minute', strtotime($horfec));
													$horarioti = date ('Y-m-d H:i:s', $horarioti);
													$horariotf = strtotime('+50 minute', strtotime($horfec));
													$horariotf = date ('Y-m-d H:i:s', $horariotf);
													if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
														//---- Se encontro marcacion de Salida
														$condicion = 1;
														$entrada = "0000-00-00 00:00:00";
														$datetime = new DateTime("$marcaciondatetime");
														$time = $datetime->format('H:i:s');
														$salida = date("Y-m-d", $i)." ".$time;
														//--- aca comienzo periodo
														$fechaamd = date("Y-m-d", $i);
														$periodo_dos_ultimos = Empleado::PeriodosUsDos();
														foreach($periodo_dos_ultimos as $periodo_row){
															if($fechaamd>=$periodo_row->periodo_hsext_jor_i && $fechaamd<=$periodo_row->periodo_hsext_jor_f){
																//esta en este rango
																$periodo_ok = $periodo_row->periodo_id;
															}else{
																//no esta en este rango
															}
														}
														//--- aca fin periodo
														$ficha = 1;
														$cerrado = 0;
														$activo = 1;
														//-------- Insert de marcacion salida ------
														$sql = 'INSERT INTO marcaciones_proceso
														(legempleado_nrodocto,marcacion_accessid,mcondicion_id,reloj_id,legreloj_id,mprocesop_entrada,mprocesop_salida,mprocesom_entrada,mprocesom_salida,periodo_id,mproceso_ficha,mproceso_cerrado,mproceso_activo)
														VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $rowlr->legempleado_nrodocto, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->bindValue(3, $condicion, PDO::PARAM_STR);
														$stm->bindValue(4, $rowlr->reloj_id, PDO::PARAM_STR);
														$stm->bindValue(5, $rowlr->legreloj_id, PDO::PARAM_STR);
														$stm->bindValue(6, $entrada, PDO::PARAM_STR);
														$stm->bindValue(7, $marcaciondatetime, PDO::PARAM_STR);
														$stm->bindValue(8, $entrada, PDO::PARAM_STR);
														$stm->bindValue(9, $salida, PDO::PARAM_STR);
														$stm->bindValue(10, $periodo_ok, PDO::PARAM_STR);
														$stm->bindValue(11, $ficha, PDO::PARAM_STR);
														$stm->bindValue(12, $cerrado, PDO::PARAM_STR);
														$stm->bindValue(13, $activo, PDO::PARAM_STR);
														$stm->execute();
														//------ Update de Marcacion a estado procesada---
														$proceso = 3;
														$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $proceso, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
														$stm->execute();

													}else{
														//----- Marcacion no encontrada en este rango de busqueda, consultar marcacion estado 1 -----
														$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->execute();
														$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
														$marcacionc = $stm->rowCount();
														$mestado = $marcacionr->mestado_id;
														if($mestado == 1){
															//------ Descartar actual -------
															$proceso = 5;
															$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
															$stm = $this->cn->prepare($sql);
															$stm->bindValue(1, $proceso, PDO::PARAM_STR);
															$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
															$stm->execute();
														}else{
															//----- No descartar, tiene un estado distinto a uno -----
														}
													}
												}
											}
										}else{
											//--- No ficha dia martes, consultar si es distinto a estado uno ----
											$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
											$stm = $this->cn->prepare($sql);
											$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
											$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
											$stm->execute();
											$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
											$marcacionc = $stm->rowCount();
											$mestado = $marcacionr->mestado_id;
											if($mestado == 1){
												//------ Descartar actual -------
												$proceso = 6;
												$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $proceso, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
												$stm->execute();
											}else{
												//------- No descartar, no es estado 1 -------
											}
										}
									//}
								}elseif($dia == 3){
									//---Miercoles----
									//foreach($rows as $rowlr){
										if($rowlr->legreloj_miercoles == 1){
											//-----Si, ficha. Define hasta que punto se busca la marcacion--------
											$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_miercoleshe;
											$horarioti = strtotime('-50 minute', strtotime($horfec));
											$horarioti = date ('Y-m-d H:i:s', $horarioti);
											$horariotf = strtotime('+50 minute', strtotime($horfec));
											$horariotf = date ('Y-m-d H:i:s', $horariotf);
											if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
												//------------Se encontro la marcacion---------
												$condicion = 1;
												$datetime = new DateTime("$marcaciondatetime");
												$time = $datetime->format('H:i:s');
												$entrada = date("Y-m-d", $i)." ".$time;
												$salida = "0000-00-00 00:00:00";
												//--- aca comienzo periodo
												$fechaamd = date("Y-m-d", $i);
												$periodo_dos_ultimos = Empleado::PeriodosUsDos();
												foreach($periodo_dos_ultimos as $periodo_row){
													if($fechaamd>=$periodo_row->periodo_hsext_jor_i && $fechaamd<=$periodo_row->periodo_hsext_jor_f){
														//esta en este rango
														$periodo_ok = $periodo_row->periodo_id;
													}else{
														//no esta en este rango
													}
												}
												//--- aca fin periodo
												$ficha = 1;
												$cerrado = 0;
												$activo = 1;
												//-------- Insert de marcacion entrada ------
												$sql = 'INSERT INTO marcaciones_proceso
												(legempleado_nrodocto,marcacion_accessid,mcondicion_id,reloj_id,legreloj_id,mprocesop_entrada,mprocesop_salida,mprocesom_entrada,mprocesom_salida,periodo_id,mproceso_ficha,mproceso_cerrado,mproceso_activo)
												VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $rowlr->legempleado_nrodocto, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
												$stm->bindValue(3, $condicion, PDO::PARAM_STR);
												$stm->bindValue(4, $rowlr->reloj_id, PDO::PARAM_STR);
												$stm->bindValue(5, $rowlr->legreloj_id, PDO::PARAM_STR);
												$stm->bindValue(6, $marcaciondatetime, PDO::PARAM_STR);
												$stm->bindValue(7, $salida, PDO::PARAM_STR);
												$stm->bindValue(8, $entrada, PDO::PARAM_STR);
												$stm->bindValue(9, $salida, PDO::PARAM_STR);
												$stm->bindValue(10, $periodo_ok, PDO::PARAM_STR);
												$stm->bindValue(11, $ficha, PDO::PARAM_STR);
												$stm->bindValue(12, $cerrado, PDO::PARAM_STR);
												$stm->bindValue(13, $activo, PDO::PARAM_STR);
												$stm->execute();
												//------ Update de Marcacion a estado procesada---
												$proceso = 2;
												$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $proceso, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
												$stm->execute();

											}else{
												//----No se encontro marcacion (Entrada) en este rango de busqueda, preguntar salida-----
												$sql = 'SELECT * FROM marcaciones_proceso WHERE marcacion_accessid = ? AND CAST(mprocesom_salida AS DATE) = ? AND legreloj_id = ?';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $marcacionaccessid, PDO::PARAM_STR);
												$stm->bindValue(2, date("Y-m-d", $i), PDO::PARAM_STR);
												$stm->bindValue(3, $rowlr->legreloj_id, PDO::PARAM_STR);
												$stm->execute();
												$mprocs = $stm->rowCount();
												//----Preguntar si esta procesada la salida
												if($mprocs == 1){
													//--------Ya esta procesada la salida, descartar marcacion actual
													//----- Marcacion no encontrada en este rango de busqueda, consultar marcacion estado 1 -----
													$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
													$stm->execute();
													$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
													$marcacionc = $stm->rowCount();
													$mestado = $marcacionr->mestado_id;
													if($mestado == 1){
														//------ Descartar actual -------
														$proceso = 8;
														$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $proceso, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
														$stm->execute();
													}else{
														//----- No descartar, tiene un estado distinto a uno -----
													}
												}else{
													//-----Define hasta que punto se busca la marcacion de salida--------
													$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_miercoleshs;
													$horarioti = strtotime('-50 minute', strtotime($horfec));
													$horarioti = date ('Y-m-d H:i:s', $horarioti);
													$horariotf = strtotime('+50 minute', strtotime($horfec));
													$horariotf = date ('Y-m-d H:i:s', $horariotf);
													if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
														//---- Se encontro marcacion de Salida
														$condicion = 1;
														$entrada = "0000-00-00 00:00:00";
														$datetime = new DateTime("$marcaciondatetime");
														$time = $datetime->format('H:i:s');
														$salida = date("Y-m-d", $i)." ".$time;
														//--- aca comienzo periodo
														$fechaamd = date("Y-m-d", $i);
														$periodo_dos_ultimos = Empleado::PeriodosUsDos();
														foreach($periodo_dos_ultimos as $periodo_row){
															if($fechaamd>=$periodo_row->periodo_hsext_jor_i && $fechaamd<=$periodo_row->periodo_hsext_jor_f){
																//esta en este rango
																$periodo_ok = $periodo_row->periodo_id;
															}else{
																//no esta en este rango
															}
														}
														//--- aca fin periodo
														$ficha = 1;
														$cerrado = 0;
														$activo = 1;
														//-------- Insert de marcacion salida ------
														$sql = 'INSERT INTO marcaciones_proceso
														(legempleado_nrodocto,marcacion_accessid,mcondicion_id,reloj_id,legreloj_id,mprocesop_entrada,mprocesop_salida,mprocesom_entrada,mprocesom_salida,periodo_id,mproceso_ficha,mproceso_cerrado,mproceso_activo)
														VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $rowlr->legempleado_nrodocto, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->bindValue(3, $condicion, PDO::PARAM_STR);
														$stm->bindValue(4, $rowlr->reloj_id, PDO::PARAM_STR);
														$stm->bindValue(5, $rowlr->legreloj_id, PDO::PARAM_STR);
														$stm->bindValue(6, $entrada, PDO::PARAM_STR);
														$stm->bindValue(7, $marcaciondatetime, PDO::PARAM_STR);
														$stm->bindValue(8, $entrada, PDO::PARAM_STR);
														$stm->bindValue(9, $salida, PDO::PARAM_STR);
														$stm->bindValue(10, $periodo_ok, PDO::PARAM_STR);
														$stm->bindValue(11, $ficha, PDO::PARAM_STR);
														$stm->bindValue(12, $cerrado, PDO::PARAM_STR);
														$stm->bindValue(13, $activo, PDO::PARAM_STR);
														$stm->execute();
														//------ Update de Marcacion a estado procesada---
														$proceso = 3;
														$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $proceso, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
														$stm->execute();

													}else{
														//----- Marcacion no encontrada en este rango de busqueda, consultar marcacion estado 1 -----
														$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->execute();
														$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
														$marcacionc = $stm->rowCount();
														$mestado = $marcacionr->mestado_id;
														if($mestado == 1){
															//------ Descartar actual -------
															$proceso = 5;
															$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
															$stm = $this->cn->prepare($sql);
															$stm->bindValue(1, $proceso, PDO::PARAM_STR);
															$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
															$stm->execute();
														}else{
															//----- No descartar, tiene un estado distinto a uno -----
														}
													}
												}
											}
										}else{
											//--- No ficha dia miercoles, consultar si es distinto a estado uno ----
											$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
											$stm = $this->cn->prepare($sql);
											$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
											$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
											$stm->execute();
											$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
											$marcacionc = $stm->rowCount();
											$mestado = $marcacionr->mestado_id;
											if($mestado == 1){
												//------ Descartar actual -------
												$proceso = 6;
												$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $proceso, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
												$stm->execute();
											}else{
												//------- No descartar, no es estado 1 -------
											}
										}
									//}
								}elseif($dia == 4){
									//---Jueves----
									//foreach($rows as $rowlr){
										if($rowlr->legreloj_jueves == 1){
											//-----Si, ficha. Define hasta que punto se busca la marcacion--------
											$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_jueveshe;
											$horarioti = strtotime('-50 minute', strtotime($horfec));
											$horarioti = date ('Y-m-d H:i:s', $horarioti);
											$horariotf = strtotime('+50 minute', strtotime($horfec));
											$horariotf = date ('Y-m-d H:i:s', $horariotf);
											if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
												//------------Se encontro la marcacion---------
												$condicion = 1;
												$datetime = new DateTime("$marcaciondatetime");
												$time = $datetime->format('H:i:s');
												$entrada = date("Y-m-d", $i)." ".$time;
												$salida = "0000-00-00 00:00:00";
												//--- aca comienzo periodo
												$fechaamd = date("Y-m-d", $i);
												$periodo_dos_ultimos = Empleado::PeriodosUsDos();
												foreach($periodo_dos_ultimos as $periodo_row){
													if($fechaamd>=$periodo_row->periodo_hsext_jor_i && $fechaamd<=$periodo_row->periodo_hsext_jor_f){
														//esta en este rango
														$periodo_ok = $periodo_row->periodo_id;
													}else{
														//no esta en este rango
													}
												}
												//--- aca fin periodo
												$ficha = 1;
												$cerrado = 0;
												$activo = 1;
												//-------- Insert de marcacion entrada ------
												$sql = 'INSERT INTO marcaciones_proceso
												(legempleado_nrodocto,marcacion_accessid,mcondicion_id,reloj_id,legreloj_id,mprocesop_entrada,mprocesop_salida,mprocesom_entrada,mprocesom_salida,periodo_id,mproceso_ficha,mproceso_cerrado,mproceso_activo)
												VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $rowlr->legempleado_nrodocto, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
												$stm->bindValue(3, $condicion, PDO::PARAM_STR);
												$stm->bindValue(4, $rowlr->reloj_id, PDO::PARAM_STR);
												$stm->bindValue(5, $rowlr->legreloj_id, PDO::PARAM_STR);
												$stm->bindValue(6, $marcaciondatetime, PDO::PARAM_STR);
												$stm->bindValue(7, $salida, PDO::PARAM_STR);
												$stm->bindValue(8, $entrada, PDO::PARAM_STR);
												$stm->bindValue(9, $salida, PDO::PARAM_STR);
												$stm->bindValue(10, $periodo_ok, PDO::PARAM_STR);
												$stm->bindValue(11, $ficha, PDO::PARAM_STR);
												$stm->bindValue(12, $cerrado, PDO::PARAM_STR);
												$stm->bindValue(13, $activo, PDO::PARAM_STR);
												$stm->execute();
												//------ Update de Marcacion a estado procesada---
												$proceso = 2;
												$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $proceso, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
												$stm->execute();

											}else{
												//----No se encontro marcacion (Entrada) en este rango de busqueda, preguntar salida-----
												$sql = 'SELECT * FROM marcaciones_proceso WHERE marcacion_accessid = ? AND CAST(mprocesom_salida AS DATE) = ? AND legreloj_id = ?';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $marcacionaccessid, PDO::PARAM_STR);
												$stm->bindValue(2, date("Y-m-d", $i), PDO::PARAM_STR);
												$stm->bindValue(3, $rowlr->legreloj_id, PDO::PARAM_STR);
												$stm->execute();
												$mprocs = $stm->rowCount();
												//----Preguntar si esta procesada la salida
												if($mprocs == 1){
													//--------Ya esta procesada la salida, descartar marcacion actual
													//----- Marcacion no encontrada en este rango de busqueda, consultar marcacion estado 1 -----
													$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
													$stm->execute();
													$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
													$marcacionc = $stm->rowCount();
													$mestado = $marcacionr->mestado_id;
													if($mestado == 1){
														//------ Descartar actual -------
														$proceso = 8;
														$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $proceso, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
														$stm->execute();
													}else{
														//----- No descartar, tiene un estado distinto a uno -----
													}
												}else{
													//-----Define hasta que punto se busca la marcacion de salida--------
													$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_jueveshs;
													$horarioti = strtotime('-50 minute', strtotime($horfec));
													$horarioti = date ('Y-m-d H:i:s', $horarioti);
													$horariotf = strtotime('+50 minute', strtotime($horfec));
													$horariotf = date ('Y-m-d H:i:s', $horariotf);
													if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
														//---- Se encontro marcacion de Salida
														$condicion = 1;
														$entrada = "0000-00-00 00:00:00";
														$datetime = new DateTime("$marcaciondatetime");
														$time = $datetime->format('H:i:s');
														$salida = date("Y-m-d", $i)." ".$time;
														//--- aca comienzo periodo
														$fechaamd = date("Y-m-d", $i);
														$periodo_dos_ultimos = Empleado::PeriodosUsDos();
														foreach($periodo_dos_ultimos as $periodo_row){
															if($fechaamd>=$periodo_row->periodo_hsext_jor_i && $fechaamd<=$periodo_row->periodo_hsext_jor_f){
																//esta en este rango
																$periodo_ok = $periodo_row->periodo_id;
															}else{
																//no esta en este rango
															}
														}
														//--- aca fin periodo
														$ficha = 1;
														$cerrado = 0;
														$activo = 1;
														//-------- Insert de marcacion salida ------
														$sql = 'INSERT INTO marcaciones_proceso
														(legempleado_nrodocto,marcacion_accessid,mcondicion_id,reloj_id,legreloj_id,mprocesop_entrada,mprocesop_salida,mprocesom_entrada,mprocesom_salida,periodo_id,mproceso_ficha,mproceso_cerrado,mproceso_activo)
														VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $rowlr->legempleado_nrodocto, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->bindValue(3, $condicion, PDO::PARAM_STR);
														$stm->bindValue(4, $rowlr->reloj_id, PDO::PARAM_STR);
														$stm->bindValue(5, $rowlr->legreloj_id, PDO::PARAM_STR);
														$stm->bindValue(6, $entrada, PDO::PARAM_STR);
														$stm->bindValue(7, $marcaciondatetime, PDO::PARAM_STR);
														$stm->bindValue(8, $entrada, PDO::PARAM_STR);
														$stm->bindValue(9, $salida, PDO::PARAM_STR);
														$stm->bindValue(10, $periodo_ok, PDO::PARAM_STR);
														$stm->bindValue(11, $ficha, PDO::PARAM_STR);
														$stm->bindValue(12, $cerrado, PDO::PARAM_STR);
														$stm->bindValue(13, $activo, PDO::PARAM_STR);
														$stm->execute();
														//------ Update de Marcacion a estado procesada---
														$proceso = 3;
														$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $proceso, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
														$stm->execute();

													}else{
														//----- Marcacion no encontrada en este rango de busqueda, consultar marcacion estado 1 -----
														$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->execute();
														$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
														$marcacionc = $stm->rowCount();
														$mestado = $marcacionr->mestado_id;
														if($mestado == 1){
															//------ Descartar actual -------
															$proceso = 5;
															$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
															$stm = $this->cn->prepare($sql);
															$stm->bindValue(1, $proceso, PDO::PARAM_STR);
															$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
															$stm->execute();
														}else{
															//----- No descartar, tiene un estado distinto a uno -----
														}
													}
												}
											}
										}else{
											//--- No ficha dia jueves, consultar si es distinto a estado uno ----
											$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
											$stm = $this->cn->prepare($sql);
											$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
											$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
											$stm->execute();
											$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
											$marcacionc = $stm->rowCount();
											$mestado = $marcacionr->mestado_id;
											if($mestado == 1){
												//------ Descartar actual -------
												$proceso = 6;
												$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $proceso, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
												$stm->execute();
											}else{
												//------- No descartar, no es estado 1 -------
											}
										}
									//}
								}elseif($dia == 5){
									//---Viernes----
									//foreach($rows as $rowlr){
										if($rowlr->legreloj_viernes == 1){
											//-----Si, ficha. Define hasta que punto se busca la marcacion--------
											$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_vierneshe;
											$horarioti = strtotime('-50 minute', strtotime($horfec));
											$horarioti = date ('Y-m-d H:i:s', $horarioti);
											$horariotf = strtotime('+50 minute', strtotime($horfec));
											$horariotf = date ('Y-m-d H:i:s', $horariotf);
											if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
												//------------Se encontro la marcacion---------
												$condicion = 1;
												$datetime = new DateTime("$marcaciondatetime");
												$time = $datetime->format('H:i:s');
												$entrada = date("Y-m-d", $i)." ".$time;
												$salida = "0000-00-00 00:00:00";
												//--- aca comienzo periodo
												$fechaamd = date("Y-m-d", $i);
												$periodo_dos_ultimos = Empleado::PeriodosUsDos();
												foreach($periodo_dos_ultimos as $periodo_row){
													if($fechaamd>=$periodo_row->periodo_hsext_jor_i && $fechaamd<=$periodo_row->periodo_hsext_jor_f){
														//esta en este rango
														$periodo_ok = $periodo_row->periodo_id;
													}else{
														//no esta en este rango
													}
												}
												//--- aca fin periodo
												$ficha = 1;
												$cerrado = 0;
												$activo = 1;
												//-------- Insert de marcacion entrada ------
												$sql = 'INSERT INTO marcaciones_proceso
												(legempleado_nrodocto,marcacion_accessid,mcondicion_id,reloj_id,legreloj_id,mprocesop_entrada,mprocesop_salida,mprocesom_entrada,mprocesom_salida,periodo_id,mproceso_ficha,mproceso_cerrado,mproceso_activo)
												VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $rowlr->legempleado_nrodocto, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
												$stm->bindValue(3, $condicion, PDO::PARAM_STR);
												$stm->bindValue(4, $rowlr->reloj_id, PDO::PARAM_STR);
												$stm->bindValue(5, $rowlr->legreloj_id, PDO::PARAM_STR);
												$stm->bindValue(6, $marcaciondatetime, PDO::PARAM_STR);
												$stm->bindValue(7, $salida, PDO::PARAM_STR);
												$stm->bindValue(8, $entrada, PDO::PARAM_STR);
												$stm->bindValue(9, $salida, PDO::PARAM_STR);
												$stm->bindValue(10, $periodo_ok, PDO::PARAM_STR);
												$stm->bindValue(11, $ficha, PDO::PARAM_STR);
												$stm->bindValue(12, $cerrado, PDO::PARAM_STR);
												$stm->bindValue(13, $activo, PDO::PARAM_STR);
												$stm->execute();
												//------ Update de Marcacion a estado procesada---
												$proceso = 2;
												$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $proceso, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
												$stm->execute();

											}else{
												//----No se encontro marcacion (Entrada) en este rango de busqueda, preguntar salida-----
												$sql = 'SELECT * FROM marcaciones_proceso WHERE marcacion_accessid = ? AND CAST(mprocesom_salida AS DATE) = ? AND legreloj_id = ?';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $marcacionaccessid, PDO::PARAM_STR);
												$stm->bindValue(2, date("Y-m-d", $i), PDO::PARAM_STR);
												$stm->bindValue(3, $rowlr->legreloj_id, PDO::PARAM_STR);
												$stm->execute();
												$mprocs = $stm->rowCount();
												//----Preguntar si esta procesada la salida
												if($mprocs == 1){
													//--------Ya esta procesada la salida, descartar marcacion actual
													//----- Marcacion no encontrada en este rango de busqueda, consultar marcacion estado 1 -----
													$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
													$stm->execute();
													$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
													$marcacionc = $stm->rowCount();
													$mestado = $marcacionr->mestado_id;
													if($mestado == 1){
														//------ Descartar actual -------
														$proceso = 8;
														$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $proceso, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
														$stm->execute();
													}else{
														//----- No descartar, tiene un estado distinto a uno -----
													}
												}else{
													//-----Define hasta que punto se busca la marcacion de salida--------
													$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_vierneshs;
													$horarioti = strtotime('-50 minute', strtotime($horfec));
													$horarioti = date ('Y-m-d H:i:s', $horarioti);
													$horariotf = strtotime('+50 minute', strtotime($horfec));
													$horariotf = date ('Y-m-d H:i:s', $horariotf);
													if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
														//---- Se encontro marcacion de Salida
														$condicion = 1;
														$entrada = "0000-00-00 00:00:00";
														$datetime = new DateTime("$marcaciondatetime");
														$time = $datetime->format('H:i:s');
														$salida = date("Y-m-d", $i)." ".$time;
														//--- aca comienzo periodo
														$fechaamd = date("Y-m-d", $i);
														$periodo_dos_ultimos = Empleado::PeriodosUsDos();
														foreach($periodo_dos_ultimos as $periodo_row){
															if($fechaamd>=$periodo_row->periodo_hsext_jor_i && $fechaamd<=$periodo_row->periodo_hsext_jor_f){
																//esta en este rango
																$periodo_ok = $periodo_row->periodo_id;
															}else{
																//no esta en este rango
															}
														}
														//--- aca fin periodo
														$ficha = 1;
														$cerrado = 0;
														$activo = 1;
														//-------- Insert de marcacion salida ------
														$sql = 'INSERT INTO marcaciones_proceso
														(legempleado_nrodocto,marcacion_accessid,mcondicion_id,reloj_id,legreloj_id,mprocesop_entrada,mprocesop_salida,mprocesom_entrada,mprocesom_salida,periodo_id,mproceso_ficha,mproceso_cerrado,mproceso_activo)
														VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $rowlr->legempleado_nrodocto, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->bindValue(3, $condicion, PDO::PARAM_STR);
														$stm->bindValue(4, $rowlr->reloj_id, PDO::PARAM_STR);
														$stm->bindValue(5, $rowlr->legreloj_id, PDO::PARAM_STR);
														$stm->bindValue(6, $entrada, PDO::PARAM_STR);
														$stm->bindValue(7, $marcaciondatetime, PDO::PARAM_STR);
														$stm->bindValue(8, $entrada, PDO::PARAM_STR);
														$stm->bindValue(9, $salida, PDO::PARAM_STR);
														$stm->bindValue(10, $periodo_ok, PDO::PARAM_STR);
														$stm->bindValue(11, $ficha, PDO::PARAM_STR);
														$stm->bindValue(12, $cerrado, PDO::PARAM_STR);
														$stm->bindValue(13, $activo, PDO::PARAM_STR);
														$stm->execute();
														//------ Update de Marcacion a estado procesada---
														$proceso = 3;
														$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $proceso, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
														$stm->execute();

													}else{
														//----- Marcacion no encontrada en este rango de busqueda, consultar marcacion estado 1 -----
														$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->execute();
														$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
														$marcacionc = $stm->rowCount();
														$mestado = $marcacionr->mestado_id;
														if($mestado == 1){
															//------ Descartar actual -------
															$proceso = 5;
															$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
															$stm = $this->cn->prepare($sql);
															$stm->bindValue(1, $proceso, PDO::PARAM_STR);
															$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
															$stm->execute();
														}else{
															//----- No descartar, tiene un estado distinto a uno -----
														}
													}
												}
											}
										}else{
											//--- No ficha dia viernes, consultar si es distinto a estado uno ----
											$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
											$stm = $this->cn->prepare($sql);
											$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
											$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
											$stm->execute();
											$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
											$marcacionc = $stm->rowCount();
											$mestado = $marcacionr->mestado_id;
											if($mestado == 1){
												//------ Descartar actual -------
												$proceso = 6;
												$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $proceso, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
												$stm->execute();
											}else{
												//------- No descartar, no es estado 1 -------
											}
										}
									//}
								}elseif($dia == 6){
									//---Sabado----
									//foreach($rows as $rowlr){
										if($rowlr->legreloj_sabado == 1){
											//-----Si, ficha. Define hasta que punto se busca la marcacion--------
											$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_sabadohe;
											$horarioti = strtotime('-50 minute', strtotime($horfec));
											$horarioti = date ('Y-m-d H:i:s', $horarioti);
											$horariotf = strtotime('+50 minute', strtotime($horfec));
											$horariotf = date ('Y-m-d H:i:s', $horariotf);
											if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
												//------------Se encontro la marcacion---------
												$condicion = 1;
												$datetime = new DateTime("$marcaciondatetime");
												$time = $datetime->format('H:i:s');
												$entrada = date("Y-m-d", $i)." ".$time;
												$salida = "0000-00-00 00:00:00";
												//--- aca comienzo periodo
												$fechaamd = date("Y-m-d", $i);
												$periodo_dos_ultimos = Empleado::PeriodosUsDos();
												foreach($periodo_dos_ultimos as $periodo_row){
													if($fechaamd>=$periodo_row->periodo_hsext_jor_i && $fechaamd<=$periodo_row->periodo_hsext_jor_f){
														//esta en este rango
														$periodo_ok = $periodo_row->periodo_id;
													}else{
														//no esta en este rango
													}
												}
												//--- aca fin periodo
												$ficha = 1;
												$cerrado = 0;
												$activo = 1;
												//-------- Insert de marcacion entrada ------
												$sql = 'INSERT INTO marcaciones_proceso
												(legempleado_nrodocto,marcacion_accessid,mcondicion_id,reloj_id,legreloj_id,mprocesop_entrada,mprocesop_salida,mprocesom_entrada,mprocesom_salida,periodo_id,mproceso_ficha,mproceso_cerrado,mproceso_activo)
												VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $rowlr->legempleado_nrodocto, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
												$stm->bindValue(3, $condicion, PDO::PARAM_STR);
												$stm->bindValue(4, $rowlr->reloj_id, PDO::PARAM_STR);
												$stm->bindValue(5, $rowlr->legreloj_id, PDO::PARAM_STR);
												$stm->bindValue(6, $marcaciondatetime, PDO::PARAM_STR);
												$stm->bindValue(7, $salida, PDO::PARAM_STR);
												$stm->bindValue(8, $entrada, PDO::PARAM_STR);
												$stm->bindValue(9, $salida, PDO::PARAM_STR);
												$stm->bindValue(10, $periodo_ok, PDO::PARAM_STR);
												$stm->bindValue(11, $ficha, PDO::PARAM_STR);
												$stm->bindValue(12, $cerrado, PDO::PARAM_STR);
												$stm->bindValue(13, $activo, PDO::PARAM_STR);
												$stm->execute();
												//------ Update de Marcacion a estado procesada---
												$proceso = 2;
												$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $proceso, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
												$stm->execute();

											}else{
												//----No se encontro marcacion (Entrada) en este rango de busqueda, preguntar salida-----
												$sql = 'SELECT * FROM marcaciones_proceso WHERE marcacion_accessid = ? AND CAST(mprocesom_salida AS DATE) = ? AND legreloj_id = ?';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $marcacionaccessid, PDO::PARAM_STR);
												$stm->bindValue(2, date("Y-m-d", $i), PDO::PARAM_STR);
												$stm->bindValue(3, $rowlr->legreloj_id, PDO::PARAM_STR);
												$stm->execute();
												$mprocs = $stm->rowCount();
												//----Preguntar si esta procesada la salida
												if($mprocs == 1){
													//--------Ya esta procesada la salida, descartar marcacion actual
													//----- Marcacion no encontrada en este rango de busqueda, consultar marcacion estado 1 -----
													$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
													$stm = $this->cn->prepare($sql);
													$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
													$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
													$stm->execute();
													$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
													$marcacionc = $stm->rowCount();
													$mestado = $marcacionr->mestado_id;
													if($mestado == 1){
														//------ Descartar actual -------
														$proceso = 8;
														$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $proceso, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
														$stm->execute();
													}else{
														//----- No descartar, tiene un estado distinto a uno -----
													}
												}else{
													//-----Define hasta que punto se busca la marcacion de salida--------
													$horfec = date("Y-m-d", $i)." ".$rowlr->legreloj_sabadohs;
													$horarioti = strtotime('-50 minute', strtotime($horfec));
													$horarioti = date ('Y-m-d H:i:s', $horarioti);
													$horariotf = strtotime('+50 minute', strtotime($horfec));
													$horariotf = date ('Y-m-d H:i:s', $horariotf);
													if($marcaciondatetime >= $horarioti && $marcaciondatetime <= $horariotf){
														//---- Se encontro marcacion de Salida
														$condicion = 1;
														$entrada = "0000-00-00 00:00:00";
														$datetime = new DateTime("$marcaciondatetime");
														$time = $datetime->format('H:i:s');
														$salida = date("Y-m-d", $i)." ".$time;
														//--- aca comienzo periodo
														$fechaamd = date("Y-m-d", $i);
														$periodo_dos_ultimos = Empleado::PeriodosUsDos();
														foreach($periodo_dos_ultimos as $periodo_row){
															if($fechaamd>=$periodo_row->periodo_hsext_jor_i && $fechaamd<=$periodo_row->periodo_hsext_jor_f){
																//esta en este rango
																$periodo_ok = $periodo_row->periodo_id;
															}else{
																//no esta en este rango
															}
														}
														//--- aca fin periodo
														$ficha = 1;
														$cerrado = 0;
														$activo = 1;
														//-------- Insert de marcacion salida ------
														$sql = 'INSERT INTO marcaciones_proceso
														(legempleado_nrodocto,marcacion_accessid,mcondicion_id,reloj_id,legreloj_id,mprocesop_entrada,mprocesop_salida,mprocesom_entrada,mprocesom_salida,periodo_id,mproceso_ficha,mproceso_cerrado,mproceso_activo)
														VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $rowlr->legempleado_nrodocto, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->bindValue(3, $condicion, PDO::PARAM_STR);
														$stm->bindValue(4, $rowlr->reloj_id, PDO::PARAM_STR);
														$stm->bindValue(5, $rowlr->legreloj_id, PDO::PARAM_STR);
														$stm->bindValue(6, $entrada, PDO::PARAM_STR);
														$stm->bindValue(7, $marcaciondatetime, PDO::PARAM_STR);
														$stm->bindValue(8, $entrada, PDO::PARAM_STR);
														$stm->bindValue(9, $salida, PDO::PARAM_STR);
														$stm->bindValue(10, $periodo_ok, PDO::PARAM_STR);
														$stm->bindValue(11, $ficha, PDO::PARAM_STR);
														$stm->bindValue(12, $cerrado, PDO::PARAM_STR);
														$stm->bindValue(13, $activo, PDO::PARAM_STR);
														$stm->execute();
														//------ Update de Marcacion a estado procesada---
														$proceso = 3;
														$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $proceso, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
														$stm->execute();

													}else{
														//----- Marcacion no encontrada en este rango de busqueda, consultar marcacion estado 1 -----
														$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
														$stm = $this->cn->prepare($sql);
														$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
														$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
														$stm->execute();
														$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
														$marcacionc = $stm->rowCount();
														$mestado = $marcacionr->mestado_id;
														if($mestado == 1){
															//------ Descartar actual -------
															$proceso = 5;
															$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
															$stm = $this->cn->prepare($sql);
															$stm->bindValue(1, $proceso, PDO::PARAM_STR);
															$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
															$stm->execute();
														}else{
															//----- No descartar, tiene un estado distinto a uno -----
														}
													}
												}
											}
										}else{
											//--- No ficha dia sabado, consultar si es distinto a estado uno ----
											$sql = 'SELECT mestado_id FROM marcaciones WHERE marcacion_id = ? AND marcacion_accessid = ? LIMIT 1';
											$stm = $this->cn->prepare($sql);
											$stm->bindValue(1, $marcacionid, PDO::PARAM_STR);
											$stm->bindValue(2, $marcacionaccessid, PDO::PARAM_STR);
											$stm->execute();
											$marcacionr = $stm->fetch(PDO::FETCH_OBJ);
											$marcacionc = $stm->rowCount();
											$mestado = $marcacionr->mestado_id;
											if($mestado == 1){
												//------ Descartar actual -------
												$proceso = 6;
												$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
												$stm = $this->cn->prepare($sql);
												$stm->bindValue(1, $proceso, PDO::PARAM_STR);
												$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
												$stm->execute();
											}else{
												//------- No descartar, no es estado 1 -------
											}
										}
									//}
								}else{
									//---Default Error
									$proceso = 7;
									$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
									$stm = $this->cn->prepare($sql);
									$stm->bindValue(1, $proceso, PDO::PARAM_STR);
									$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
									$stm->execute();
								}
							}
						}/*elseif($legrelc == 2){

							//----- El empleado tiene dos turnos
							$proceso = 10;
							$sql = 'UPDATE marcaciones SET mestado_id = ? WHERE marcacion_id = ?';
							$stm = $this->cn->prepare($sql);
							$stm->bindValue(1, $proceso, PDO::PARAM_STR);
							$stm->bindValue(2, $marcacionid, PDO::PARAM_STR);
							$stm->execute();

						}else{
							//------ Tiene mas de dos turnos o ninguno
						}*/

					}
				}else{
				//Empleado no semanal
				}
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function HijoAutocompletar($nrodocto){
		try{

			$sql = 'SELECT * FROM legajos_hijo WHERE leghijo_nrodocto = ? LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$stm->execute();
			return $stm->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function EmpleadoAutocompletar($nrodocto){
		try{

			$sql = 'SELECT *
								FROM legajos_empleado
							 WHERE legempleado_nrodocto = ?
							 LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$stm->execute();
			return $stm->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function MoPAutocompletar($nrodocto){
		try{

			$sql = 'SELECT leghijo_moptdoc,leghijo_mopndoc,leghijo_mopapellido,leghijo_mopnombres FROM legajos_hijo WHERE leghijo_mopndoc = ? ORDER BY leghijo_mopndoc DESC LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$stm->execute();
			return $stm->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	/*public function BeneficiarioAutocompletar($nrodocto){
		try{

			$sql = 'SELECT leghijo_bentdoc,leghijo_benndoc,leghijo_benapellido,leghijo_bennombres FROM legajos_hijo WHERE leghijo_benndoc = ? ORDER BY leghijo_benndoc DESC LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$stm->execute();
			return $stm->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}*/
	public function EmpleadosXSecretiriaObtener($secretariaid, $srevista){
		try{
			//---Contratados ----
			$sql = 'SELECT DISTINCT a.legempleado_nrodocto AS empdni,
										 a.secretaria_id AS empsecretaria,
										 a.trabajo_id AS emptrabrajo,
										 d.trabajo_nombre AS emptrabajonombre,
										 a.legcontrato_tarea AS emptarea,
										 b.legempleado_apellido AS empapellido,
										 b.legempleado_nombres AS empnombres,
										 b.legempleado_fecingreso AS empfecingreso,
										 c.legtipo_nombre AS emptlegajo
			 					FROM legajos_contrato a
					INNER JOIN legajos_empleado b
						 			ON a.legempleado_nrodocto = b.legempleado_nrodocto
					INNER JOIN legajos_tipo c
									ON b.legtipo_id = c.legtipo_id
					INNER JOIN lugares_trabajo d
									ON a.trabajo_id = d.trabajo_id
							 WHERE a.secretaria_id = ?
							 	 AND a.legcontrato_activo = 1
								 AND b.legtipo_id = ?
								 AND b.legempleado_activo = 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $secretariaid, PDO::PARAM_STR);
			$dec->bindValue(2, $srevista, PDO::PARAM_STR);
			$dec->execute();
			$contratados = $dec->fetchAll(PDO::FETCH_OBJ);
			//---Jornaleros ------
			$sql = 'SELECT DISTINCT a.legempleado_nrodocto AS empdni,
										 a.secretaria_id AS empsecretaria,
										 a.trabajo_id AS emptrabrajo,
										 d.trabajo_nombre AS emptrabajonombre,
										 a.legjornalero_tarea AS emptarea,
										 b.legempleado_apellido AS empapellido,
										 b.legempleado_nombres AS empnombres,
										 b.legempleado_fecingreso AS empfecingreso,
										 c.legtipo_nombre AS emptlegajo
			 					FROM legajos_jornalero a
					INNER JOIN legajos_empleado b
						 			ON a.legempleado_nrodocto = b.legempleado_nrodocto
					INNER JOIN legajos_tipo c
									ON b.legtipo_id = c.legtipo_id
					INNER JOIN lugares_trabajo d
									ON a.trabajo_id = d.trabajo_id
							 WHERE a.secretaria_id = ?
							 	 AND a.legjornalero_activo = 1
								 AND b.legtipo_id = ?
								 AND b.legempleado_activo = 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $secretariaid, PDO::PARAM_STR);
			$dec->bindValue(2, $srevista, PDO::PARAM_STR);
			$dec->execute();
			$jornaleros = $dec->fetchAll(PDO::FETCH_OBJ);
			//---Planta Permanente ----
			$sql = 'SELECT DISTINCT a.legempleado_nrodocto AS empdni,
										 a.secretaria_id AS empsecretaria,
										 a.trabajo_id AS emptrabrajo,
										 d.trabajo_nombre AS emptrabajonombre,
										 a.legppermanente_tarea AS emptarea,
										 b.legempleado_apellido AS empapellido,
										 b.legempleado_nombres AS empnombres,
										 b.legempleado_fecingreso AS empfecingreso,
							CONCAT (c.legtipo_nombre, ": CAT ", a.legppermanente_categoria) AS emptlegajo
			 					FROM legajos_ppermanente a
					INNER JOIN legajos_empleado b
						 			ON a.legempleado_nrodocto = b.legempleado_nrodocto
					INNER JOIN legajos_tipo c
									ON b.legtipo_id = c.legtipo_id
					INNER JOIN lugares_trabajo d
									ON a.trabajo_id = d.trabajo_id
							 WHERE a.secretaria_id = ?
							 	 AND a.legppermanente_activo = 1
								 AND b.legtipo_id = ?
								 AND b.legempleado_activo = 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $secretariaid, PDO::PARAM_STR);
			$dec->bindValue(2, $srevista, PDO::PARAM_STR);
			$dec->execute();
			$ppermante = $dec->fetchAll(PDO::FETCH_OBJ);
			//----Mezclar arrays ------
			$empleadostotal = array_merge($contratados, $jornaleros, $ppermante);
			$empleadostotal = array_map('json_encode', $empleadostotal);
			$empleadostotal = array_unique($empleadostotal);
			$empleadostotal = array_map('json_decode', $empleadostotal);
			sort($empleadostotal);
			//return $empleadostotal->fetchAll(PDO::FETCH_ASSOC);
			return $empleadostotal;


		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function EmpleadosXSecretiriaObtenerDos($secretariaid, $srevista){
		try{
			//---Contratados ----
			$sql = 'SELECT DISTINCT a.legempleado_nrodocto AS empdni,
										 a.secretaria_id AS empsecretaria,
										 a.trabajo_id AS emptrabrajo,
										 d.trabajo_nombre AS emptrabajonombre,
										 a.legcontrato_tarea AS emptarea,
										 b.legempleado_apellido AS empapellido,
										 b.legempleado_nombres AS empnombres,
										 b.legempleado_fecingreso AS empfecingreso,
										 c.legtipo_nombre AS emptlegajo
			 					FROM legajos_contrato a
					INNER JOIN legajos_empleado b
						 			ON a.legempleado_nrodocto = b.legempleado_nrodocto
					INNER JOIN legajos_tipo c
									ON b.legtipo_id = c.legtipo_id
					INNER JOIN lugares_trabajo d
									ON a.trabajo_id = d.trabajo_id
							 WHERE a.secretaria_id = ?
							 	 AND a.legcontrato_activo = 1
								 AND b.legempleado_activo = 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $secretariaid, PDO::PARAM_STR);
			$dec->execute();
			$contratados = $dec->fetchAll(PDO::FETCH_OBJ);
			//---Jornaleros ------
			$sql = 'SELECT DISTINCT a.legempleado_nrodocto AS empdni,
										 a.secretaria_id AS empsecretaria,
										 a.trabajo_id AS emptrabrajo,
										 d.trabajo_nombre AS emptrabajonombre,
										 a.legjornalero_tarea AS emptarea,
										 b.legempleado_apellido AS empapellido,
										 b.legempleado_nombres AS empnombres,
										 b.legempleado_fecingreso AS empfecingreso,
										 c.legtipo_nombre AS emptlegajo
			 					FROM legajos_jornalero a
					INNER JOIN legajos_empleado b
						 			ON a.legempleado_nrodocto = b.legempleado_nrodocto
					INNER JOIN legajos_tipo c
									ON b.legtipo_id = c.legtipo_id
					INNER JOIN lugares_trabajo d
									ON a.trabajo_id = d.trabajo_id
							 WHERE a.secretaria_id = ?
							 	 AND a.legjornalero_activo = 1
								 AND b.legempleado_activo = 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $secretariaid, PDO::PARAM_STR);
			$dec->execute();
			$jornaleros = $dec->fetchAll(PDO::FETCH_OBJ);
			//---Planta Permanente ----
			$sql = 'SELECT DISTINCT a.legempleado_nrodocto AS empdni,
										 a.secretaria_id AS empsecretaria,
										 a.trabajo_id AS emptrabrajo,
										 d.trabajo_nombre AS emptrabajonombre,
										 a.legppermanente_tarea AS emptarea,
										 b.legempleado_apellido AS empapellido,
										 b.legempleado_nombres AS empnombres,
										 b.legempleado_fecingreso AS empfecingreso,
							CONCAT (c.legtipo_nombre, ": CAT ", a.legppermanente_categoria) AS emptlegajo
			 					FROM legajos_ppermanente a
					INNER JOIN legajos_empleado b
						 			ON a.legempleado_nrodocto = b.legempleado_nrodocto
					INNER JOIN legajos_tipo c
									ON b.legtipo_id = c.legtipo_id
					INNER JOIN lugares_trabajo d
									ON a.trabajo_id = d.trabajo_id
							 WHERE a.secretaria_id = ?
							 	 AND a.legppermanente_activo = 1
								 AND b.legempleado_activo = 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $secretariaid, PDO::PARAM_STR);
			$dec->execute();
			$ppermante = $dec->fetchAll(PDO::FETCH_OBJ);
			//----Mezclar arrays ------
			$empleadostotal = array_merge($contratados, $jornaleros, $ppermante);
			$empleadostotal = array_map('json_encode', $empleadostotal);
			$empleadostotal = array_unique($empleadostotal);
			$empleadostotal = array_map('json_decode', $empleadostotal);
			sort($empleadostotal);
			//return $empleadostotal->fetchAll(PDO::FETCH_ASSOC);
			return $empleadostotal;


		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function EmpleadosXLTrabajoObtener($trabajoid, $srevista){
		try{
			//---Contratados ----
			$sql = 'SELECT DISTINCT a.legempleado_nrodocto AS empdni,
										 a.secretaria_id AS empsecretaria,
										 a.trabajo_id AS emptrabrajo,
										 d.trabajo_nombre AS emptrabajonombre,
										 a.legcontrato_tarea AS emptarea,
										 b.legempleado_apellido AS empapellido,
										 b.legempleado_nombres AS empnombres,
										 b.legempleado_fecingreso AS empfecingreso,
										 c.legtipo_nombre AS emptlegajo
			 					FROM legajos_contrato a
					INNER JOIN legajos_empleado b
						 			ON a.legempleado_nrodocto = b.legempleado_nrodocto
					INNER JOIN legajos_tipo c
									ON b.legtipo_id = c.legtipo_id
					INNER JOIN lugares_trabajo d
									ON a.trabajo_id = d.trabajo_id
							 WHERE a.trabajo_id = ?
							 	 AND a.legcontrato_activo = 1
								 AND b.legtipo_id = ?
								 AND b.legempleado_activo = 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $trabajoid, PDO::PARAM_STR);
			$dec->bindValue(2, $srevista, PDO::PARAM_STR);
			$dec->execute();
			$contratados = $dec->fetchAll(PDO::FETCH_OBJ);
			//---Jornaleros ------
			$sql = 'SELECT DISTINCT a.legempleado_nrodocto AS empdni,
										 a.secretaria_id AS empsecretaria,
										 a.trabajo_id AS emptrabrajo,
										 d.trabajo_nombre AS emptrabajonombre,
										 a.legjornalero_tarea AS emptarea,
										 b.legempleado_apellido AS empapellido,
										 b.legempleado_nombres AS empnombres,
										 b.legempleado_fecingreso AS empfecingreso,
										 c.legtipo_nombre AS emptlegajo
			 					FROM legajos_jornalero a
					INNER JOIN legajos_empleado b
						 			ON a.legempleado_nrodocto = b.legempleado_nrodocto
					INNER JOIN legajos_tipo c
									ON b.legtipo_id = c.legtipo_id
					INNER JOIN lugares_trabajo d
									ON a.trabajo_id = d.trabajo_id
							 WHERE a.trabajo_id = ?
							 	 AND a.legjornalero_activo = 1
								 AND b.legtipo_id = ?
								 AND b.legempleado_activo = 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $trabajoid, PDO::PARAM_STR);
			$dec->bindValue(2, $srevista, PDO::PARAM_STR);
			$dec->execute();
			$jornaleros = $dec->fetchAll(PDO::FETCH_OBJ);
			//---Planta Permanente ----
			$sql = 'SELECT DISTINCT a.legempleado_nrodocto AS empdni,
										 a.secretaria_id AS empsecretaria,
										 a.trabajo_id AS emptrabrajo,
										 d.trabajo_nombre AS emptrabajonombre,
										 a.legppermanente_tarea AS emptarea,
										 b.legempleado_apellido AS empapellido,
										 b.legempleado_nombres AS empnombres,
										 b.legempleado_fecingreso AS empfecingreso,
						 CONCAT (c.legtipo_nombre, ": CAT ", a.legppermanente_categoria) AS emptlegajo
			 					FROM legajos_ppermanente a
					INNER JOIN legajos_empleado b
						 			ON a.legempleado_nrodocto = b.legempleado_nrodocto
					INNER JOIN legajos_tipo c
									ON b.legtipo_id = c.legtipo_id
					INNER JOIN lugares_trabajo d
									ON a.trabajo_id = d.trabajo_id
							 WHERE a.trabajo_id = ?
							 	 AND a.legppermanente_activo = 1
								 AND b.legtipo_id = ?
								 AND b.legempleado_activo = 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $trabajoid, PDO::PARAM_STR);
			$dec->bindValue(2, $srevista, PDO::PARAM_STR);
			$dec->execute();
			$ppermante = $dec->fetchAll(PDO::FETCH_OBJ);
			//----Mezclar arrays ------
			$empleadostotal = array_merge($contratados, $jornaleros, $ppermante);
			$empleadostotal = array_map('json_encode', $empleadostotal);
			$empleadostotal = array_unique($empleadostotal);
			$empleadostotal = array_map('json_decode', $empleadostotal);
			sort($empleadostotal);
			//return $empleadostotal->fetchAll(PDO::FETCH_ASSOC);
			return $empleadostotal;


		}catch (Exception $e){
			die($e->getMessage());
		}
	}

	public function EmpleadosXLTrabajoObtenerDos($trabajoid, $srevista){
		try{
			//---Contratados ----
			$sql = 'SELECT DISTINCT a.legempleado_nrodocto AS empdni,
										 a.secretaria_id AS empsecretaria,
										 a.trabajo_id AS emptrabrajo,
										 d.trabajo_nombre AS emptrabajonombre,
										 a.legcontrato_tarea AS emptarea,
										 b.legempleado_apellido AS empapellido,
										 b.legempleado_nombres AS empnombres,
										 b.legempleado_fecingreso AS empfecingreso,
										 c.legtipo_nombre AS emptlegajo
			 					FROM legajos_contrato a
					INNER JOIN legajos_empleado b
						 			ON a.legempleado_nrodocto = b.legempleado_nrodocto
					INNER JOIN legajos_tipo c
									ON b.legtipo_id = c.legtipo_id
					INNER JOIN lugares_trabajo d
									ON a.trabajo_id = d.trabajo_id
							 WHERE a.trabajo_id = ?
							 	 AND a.legcontrato_activo = 1
								 AND b.legempleado_activo = 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $trabajoid, PDO::PARAM_STR);
			$dec->execute();
			$contratados = $dec->fetchAll(PDO::FETCH_OBJ);
			//---Jornaleros ------
			$sql = 'SELECT DISTINCT a.legempleado_nrodocto AS empdni,
										 a.secretaria_id AS empsecretaria,
										 a.trabajo_id AS emptrabrajo,
										 d.trabajo_nombre AS emptrabajonombre,
										 a.legjornalero_tarea AS emptarea,
										 b.legempleado_apellido AS empapellido,
										 b.legempleado_nombres AS empnombres,
										 b.legempleado_fecingreso AS empfecingreso,
										 c.legtipo_nombre AS emptlegajo
			 					FROM legajos_jornalero a
					INNER JOIN legajos_empleado b
						 			ON a.legempleado_nrodocto = b.legempleado_nrodocto
					INNER JOIN legajos_tipo c
									ON b.legtipo_id = c.legtipo_id
					INNER JOIN lugares_trabajo d
									ON a.trabajo_id = d.trabajo_id
							 WHERE a.trabajo_id = ?
							 	 AND a.legjornalero_activo = 1
								 AND b.legempleado_activo = 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $trabajoid, PDO::PARAM_STR);
			$dec->execute();
			$jornaleros = $dec->fetchAll(PDO::FETCH_OBJ);
			//---Planta Permanente ----
			$sql = 'SELECT DISTINCT a.legempleado_nrodocto AS empdni,
										 a.secretaria_id AS empsecretaria,
										 a.trabajo_id AS emptrabrajo,
										 d.trabajo_nombre AS emptrabajonombre,
										 a.legppermanente_tarea AS emptarea,
										 b.legempleado_apellido AS empapellido,
										 b.legempleado_nombres AS empnombres,
										 b.legempleado_fecingreso AS empfecingreso,
						 CONCAT (c.legtipo_nombre, ": CAT ", a.legppermanente_categoria) AS emptlegajo
			 					FROM legajos_ppermanente a
					INNER JOIN legajos_empleado b
						 			ON a.legempleado_nrodocto = b.legempleado_nrodocto
					INNER JOIN legajos_tipo c
									ON b.legtipo_id = c.legtipo_id
					INNER JOIN lugares_trabajo d
									ON a.trabajo_id = d.trabajo_id
							 WHERE a.trabajo_id = ?
							 	 AND a.legppermanente_activo = 1
								 AND b.legempleado_activo = 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $trabajoid, PDO::PARAM_STR);
			$dec->execute();
			$ppermante = $dec->fetchAll(PDO::FETCH_OBJ);
			//----Mezclar arrays ------
			$empleadostotal = array_merge($contratados, $jornaleros, $ppermante);
			$empleadostotal = array_map('json_encode', $empleadostotal);
			$empleadostotal = array_unique($empleadostotal);
			$empleadostotal = array_map('json_decode', $empleadostotal);
			sort($empleadostotal);
			//return $empleadostotal->fetchAll(PDO::FETCH_ASSOC);
			return $empleadostotal;


		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ConyugeInfo($data){

		$con = new Empleado();
		$conyugedatos = Empleado::ConyugeObtener($data->Empnrodocto);
		///////////////////////////////////////////////////////////
		$asignacionultimoreg = Empleado::AsignacionesUltimoRegistro();
		$periodoidup = $asignacionultimoreg->periodo_id;
		$periodoidsi = $asignacionultimoreg->periodo_id + 1;
		/////////////////////////////////////////////////////////
		$cyeasignacionantdatos = Empleado::AsignacionConyugeUltimaObtener($data->Empnrodocto, $data->Cyenrodocto, $periodoidup);

		if(!empty($conyugedatos)){
			//---el conyuge tiene asignacion
			if(!empty($cyeasignacionantdatos)){
				//--- El conyuge tiene asignacion en el ultimo periodo
				if($conyugedatos->legconyuge_nrodocto == $cyeasignacionantdatos->asignacion_phc_nrodocto){
					//--- conyuege con mismo ndoc
				}else{
					//--- conyuge con distinto ndoc
				}
			}else{
				//---El conyuge no tiene asignacion en el periodo anterior (Info-Alta)
				//---Verificar INFO EXISTENTE
				$infotipo = 3;//baja
				$asiginfoexistente = Empleado::ConyugeInfoNueva($data->Cyeid, $periodoidsi, $infotipo);
				if(!empty($asiginfoexistente)){
					//---La asignacion info existe, dar de baja
					Empleado::AsignacionInfoBaja($asiginfoexistente->asignacion_info_id);
				}//----la asignacion info no existente
				//----Insertar asignacion info alta-----
				//----
				$con->Asigtitular = 1;
				$con->PHCid = $data->Cyeid;
				$con->Empnrodocto = $data->Empnrodocto;
				$con->Bennrodocto = $data->Empnrodocto;
				$con->Periodoid = $periodoidsi;
				$con->Asigtipo = 9;
				$con->Asigcantidad = 1;
				$con->Asiginfo = 1;
				$con->Asinginfoobs = "";
				$con->Asiginfoestado = 1;
				//----
				Empleado::AsignacionInfoGuardarExe($con);

			}
		}else{
			//---el conyuge no tiene asignacion ---
			if(!empty($cyeasignacionantdatos)){
				//--- El conyuge tiene asignacion en el ultimo periodo
				$infotipo = 1;//alta
				$asiginfoexistente = Empleado::ConyugeInfoNueva($data->Cyeid, $periodoidsi, $infotipo);
				if(!empty($asiginfoexistente)){
					//---La asignacion info existe, dar de baja
					Empleado::AsignacionInfoBaja($asiginfoexistente->asignacion_info_id);
				}//----la asignacion info no existente
				//----Insertar asignacion info baja-----
				//----
				$con->Asigtitular = 1;
				$con->PHCid = $data->Cyeid;
				$con->Empnrodocto = $data->Empnrodocto;
				$con->Bennrodocto = $data->Empnrodocto;
				$con->Periodoid = $periodoidsi;
				$con->Asigtipo = 9;
				$con->Asigcantidad = 1;
				$con->Asiginfo = 3;//baja
				$con->Asinginfoobs = "";
				$con->Asiginfoestado = 1;
				//----
				Empleado::AsignacionInfoGuardarExe($con);
			}else{
				//---El conyuge no tiene asignacion en el periodo anterior ni actual (Info-Alta)
				$infotipo = 1;//alta
				$asiginfoexistente = Empleado::ConyugeInfoNueva($data->Cyeid, $periodoidsi, $infotipo);
				if(!empty($asiginfoexistente)){
					//---La asignacion info existe, dar de baja
					Empleado::AsignacionInfoBaja($asiginfoexistente->asignacion_info_id);
				}//----la asignacion info no existente
				$infotipo = 3;//baja
				$asiginfoexistente = Empleado::ConyugeInfoNueva($data->Cyeid, $periodoidsi, $infotipo);
				if(!empty($asiginfoexistente)){
					//---La asignacion info existe, dar de baja
					Empleado::AsignacionInfoBaja($asiginfoexistente->asignacion_info_id);
				}//----la asignacion info no existente
			}
		}
	}
	public function PrenatalInfo($data){

		$pre = new Empleado();
		$preasignaciondatos = Empleado::AsignacionPrenatalObtener($data->Id, $data->Empnrodocto, $data->Bennrodocto);
		$pre->Empnrodocto = $data->Empnrodocto;
		$pre->Bennrodocto = $data->Bennrodocto;
		///////////////////////////////////////////////////////////
		$asignacionultimoreg = Empleado::AsignacionesUltimoRegistro();
		$periodoidup = $asignacionultimoreg->periodo_id;
		$periodoidsi = $asignacionultimoreg->periodo_id + 1;
		/////////////////////////////////////////////////////////
		$titular = $pre->Empnrodocto == $pre->Bennrodocto ? 1 : 2;
		/////////////////////////////////////////////////////////
		$preasignacionantdatos = Empleado::AsignacionPrenatalUltimaObtener($data->Id, $pre->Empnrodocto, $pre->Bennrodocto, $periodoidup);

		if(!empty($preasignaciondatos)){
			//---el prenatal tiene asignacion
			if(!empty($preasignacionantdatos)){
				//--- El prenatal tiene asignacion en el ultimo periodo
				//---Verificar INFO EXISTENTE
				$infotipo = 1;//alta
				$asiginfoexistente = Empleado::AsignacionInfoPrenatalNueva($data->Id, $titular, $periodoidsi, $infotipo);
				if(!empty($asiginfoexistente)){
					//---La asignacion info existe, dar de baja
					Empleado::AsignacionInfoBaja($asiginfoexistente->asignacion_info_id);
				}//----la asignacion info no existente
				$infotipo = 3;//baja
				$asiginfoexistente = Empleado::AsignacionInfoPrenatalNueva($data->Id, $titular, $periodoidsi, $infotipo);
				if(!empty($asiginfoexistente)){
					//---La asignacion info existe, dar de baja
					Empleado::AsignacionInfoBaja($asiginfoexistente->asignacion_info_id);
				}//----la asignacion info no existente
			}else{
				//---El prenatal no tiene asignacion en el periodo anterior (Info-Alta)
				//---VERIFICAR INFO EXISTENTE
				$infotipo = 1;//alta
				$asiginfoexistente = Empleado::AsignacionInfoPrenatalNueva($data->Id, $titular, $periodoidsi, $infotipo);
				if(empty($asiginfoexistente)){
					//----la asignacion info no existente
					//----Insertar nueva asignacion info -----
					//----
					$pre->Asigtitular = $titular;
					$pre->PHCid = $data->Id;
					$pre->Periodoid = $periodoidsi;
					$pre->Asigtipo = 1;
					$pre->Asigcantidad = 1;
					$pre->Asiginfo = 1;
					$pre->Asinginfoobs = "";
					$pre->Asiginfoestado = 1;
					//----
					Empleado::AsignacionInfoGuardarExe($pre);
				}//---La asignacion info existe
			}
		}else{
			//---el prenatal no tiene asignacion ---
			//$preasignacionantdatos = Empleado::AsignacionHijoUltimaObtener($data->Id, $asi->Empnrodocto, $asi->Bennrodocto, $periodoidup);
			if(!empty($preasignacionantdatos)){
				//----el prenatal tiene asignacion en el ultimo pase
				//----Insertar asignacion info baja -----
				$pre->Asigtitular = $titular;
				$pre->PHCid = $data->Id;
				$pre->Periodoid = $periodoidsi;
				$pre->Asigtipo = 1;
				$pre->Asigcantidad = 1;
				$pre->Asiginfo = 3;//baja
				$pre->Asinginfoobs = "";
				$pre->Asiginfoestado = 1;
				Empleado::AsignacionInfoGuardarExe($pre);
			}
			//---VERIFICAR INFO EXISTENTE, DISTINTO A BAJA
			$infotipo = 1;//alta
			$asiginfoexistente = Empleado::AsignacionInfoPrenatalNueva($data->Id, $titular, $periodoidsi, $infotipo);
			if(!empty($asiginfoexistente)){
				//---La asignacion info existe, dar de baja
				Empleado::AsignacionInfoBaja($asiginfoexistente->asignacion_info_id);
			}//----la asignacion info no existente
		}
	}
	public function AsignacionInfo($data){

		$asi = new Empleado();
		$hjoasignaciondatos = Empleado::AsignacionHijoObtener_V($data->Id, $data->Empnrodocto, $data->Bennrodocto);
		$asi->Empnrodocto = $data->Empnrodocto;
		$asi->Bennrodocto = $data->Bennrodocto;
		///////////////////////////////////////////////////////////
		$asignacionultimoreg = Empleado::AsignacionesUltimoRegistro();
		$periodoidup = $asignacionultimoreg->periodo_id;
		$periodoidsi = $asignacionultimoreg->periodo_id + 1;
		/////////////////////////////////////////////////////////
		$titular = $asi->Empnrodocto == $asi->Bennrodocto ? 1 : 2;
		/////////////////////////////////////////////////////////
		$hjoasignacionantdatos = Empleado::AsignacionHijoUltimaObtener($data->Id, $asi->Empnrodocto, $asi->Bennrodocto, $periodoidup);

		if(!empty($hjoasignaciondatos)){
			//---el hijo tiene asignacion
			if(!empty($hjoasignacionantdatos)){
				//--- El hijo tiene asignacion en el ultimo periodo
				if($hjoasignacionantdatos->asigtipo_id != $hjoasignaciondatos->asigtipo_id){
					//----la asignacion tiene distinto tipo (Info-Alta)
					//---Verificar INFO EXISTENTE
					$infotipo = 1;//alta
					$asiginfoexistente = Empleado::AsignacionInfoHijoNueva($data->Id, $titular, $periodoidsi, $infotipo);
					if(!empty($asiginfoexistente)){
						//---La asignacion info existe, dar de baja
						Empleado::AsignacionInfoBaja($asiginfoexistente->asignacion_info_id);
					}//----la asignacion info no existente

					$infotipo = 3;//baja
					$asiginfoexistente = Empleado::AsignacionInfoHijoNueva($data->Id, $titular, $periodoidsi, $infotipo);
					if(empty($asiginfoexistente)){
						//-no existe baja
						//----Insertar vieja asignacion info -----
						//----
						$asi->Asigtitular = $titular;
						$asi->PHCid = $data->Id;
						$asi->Periodoid = $periodoidsi;
						$asi->Asigtipo = $hjoasignacionantdatos->asigtipo_id;
						$asi->Asigcantidad = 1;
						$asi->Asiginfo = 3;
						$asi->Asinginfoobs = "";
						$asi->Asiginfoestado = 1;
						//----
						Empleado::AsignacionInfoGuardarExe($asi);
					}//----Ya existe baja
					//----Insertar nueva asignacion info -----
					//----
					$asi->Asigtitular = $titular;
					$asi->PHCid = $data->Id;
					$asi->Periodoid = $periodoidsi;
					$asi->Asigtipo = $hjoasignaciondatos->asigtipo_id;
					$asi->Asigcantidad = 1;
					$asi->Asiginfo = 1;
					$asi->Asinginfoobs = "";
					$asi->Asiginfoestado = 1;
					//----
					Empleado::AsignacionInfoGuardarExe($asi);
				}else{
					//---la asignacion tiene el mismo tipo (Info-Ninguna)

					//---Verificar INFO EXISTENTE
					$infotipo = 1;//alta
					$asiginfoexistente = Empleado::AsignacionInfoHijoNueva($data->Id, $titular, $periodoidsi, $infotipo);
					if(!empty($asiginfoexistente)){
						//---La asignacion info existe, dar de baja
						Empleado::AsignacionInfoBaja($asiginfoexistente->asignacion_info_id);
					}//----la asignacion info no existente
					$infotipo = 3;//baja
					$asiginfoexistente = Empleado::AsignacionInfoHijoNueva($data->Id, $titular, $periodoidsi, $infotipo);
					if(!empty($asiginfoexistente)){
						//---La asignacion info existe, dar de baja
						Empleado::AsignacionInfoBaja($asiginfoexistente->asignacion_info_id);
					}//----la asignacion info no existente
				}
			}else{
				//---El hijo no tiene asignacion en el periodo anterior (Info-Alta)
				//---VERIFICAR INFO EXISTENTE
				$infotipo = 1;//alta
				$asiginfoexistente = Empleado::AsignacionInfoHijoNueva($data->Id, $titular, $periodoidsi, $infotipo);
				if(!empty($asiginfoexistente)){
					//---La asignacion info existe
					if($asiginfoexistente->asigtipo_id != $hjoasignaciondatos->asigtipo_id){
						//----la asignacion cambio
						Empleado::AsignacionInfoBaja($asiginfoexistente->asignacion_info_id);
						//----Insertar nueva asignacion info -----
						//----
						$asi->Asigtitular = $titular;
						$asi->PHCid = $data->Id;
						$asi->Periodoid = $periodoidsi;
						$asi->Asigtipo = $hjoasignaciondatos->asigtipo_id;
						$asi->Asigcantidad = 1;
						$asi->Asiginfo = 1;
						$asi->Asinginfoobs = "";
						$asi->Asiginfoestado = 1;
						//----
						Empleado::AsignacionInfoGuardarExe($asi);
					}
				}else{
					//----la asignacion info no existente
					//----Insertar nueva asignacion info -----
					//----
					$asi->Asigtitular = $titular;
					$asi->PHCid = $data->Id;
					$asi->Periodoid = $periodoidsi;
					$asi->Asigtipo = $hjoasignaciondatos->asigtipo_id;
					$asi->Asigcantidad = 1;
					$asi->Asiginfo = 1;
					$asi->Asinginfoobs = "";
					$asi->Asiginfoestado = 1;
					//----
					Empleado::AsignacionInfoGuardarExe($asi);
				}
			}
		}else{
			//---el hijo no tiene asignacion ---
			$hjoasignacionantdatos = Empleado::AsignacionHijoUltimaObtener($data->Id, $asi->Empnrodocto, $asi->Bennrodocto, $periodoidup);
			if(!empty($hjoasignacionantdatos)){
				//----el hijo tiene asignacion en el ultimo pase
				//----Insertar asignacion info baja -----
				$asi->Asigtitular = $titular;
				$asi->PHCid = $data->Id;
				$asi->Periodoid = $periodoidsi;
				$asi->Asigtipo = $hjoasignacionantdatos->asigtipo_id;
				$asi->Asigcantidad = 1;
				$asi->Asiginfo = 3;//baja
				$asi->Asinginfoobs = "";
				$asi->Asiginfoestado = 1;
				Empleado::AsignacionInfoGuardarExe($asi);
			}
			//---VERIFICAR INFO EXISTENTE, DISTINTO A BAJA
			$infotipo = 1;//alta
			$asiginfoexistente = Empleado::AsignacionInfoHijoNueva($data->Id, $titular, $periodoidsi, $infotipo);
			if(!empty($asiginfoexistente)){
				//---La asignacion info existe, dar de baja
				Empleado::AsignacionInfoBaja($asiginfoexistente->asignacion_info_id);
			}//----la asignacion info no existente
		}
	}
	public function ObtenerModeloContrato(){
		try{

			$sql = $this->cn->prepare("SELECT * FROM contratos_modelos WHERE leg_modelo_activo = 1 ORDER BY contrato_modelonombre");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}

	}
	public function ObtenerModeloContratos($id){

		try
		{

			$sql = 'SELECT * FROM contratos_modelos WHERE legtipo_id = ? AND leg_modelo_activo = 1 ORDER BY contrato_modelonombre ';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $id, PDO::PARAM_INT);
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);

		} catch (Exception $e)
		{
			die($e->getMessage());
		}
	}
	public function FamiliaNumerosaInfo($data){

		$fnu = new Empleado();
		$asignacionultimoreg = Empleado::AsignacionesUltimoRegistro();
		$periodoidup = $asignacionultimoreg->periodo_id;
		$periodoidsi = $asignacionultimoreg->periodo_id + 1;
		$famnumdatos = Empleado::FamiliaNumerosaObtener_V($data->Empnrodocto, $data->Bennrodocto);
		$titular = $data->Empnrodocto == $data->Bennrodocto ? 1 : 2;
		/*if($data->Empnrodocto == $data->Bennrodocto){
			$titular = 1;
		}else{
			$titular = 2;
		}*/
		$famnumanteriordatos = Empleado::FamiliaNumerosaUltimaObtener($data->Empnrodocto, $data->Bennrodocto, $periodoidup);

		if(!empty($famnumdatos)){
			$famnumdatosc = $famnumdatos->asignacion_cantidad;
			$familianum = 0;
			if($famnumdatosc < 3){
				//----- no tiene familia numerosa actual
				//echo "no tiene familia numerosa"."<br>";
				if(!empty($famnumanteriordatos)){
					//---- tiene familia numerosa en periodo anterior
					//echo "tiene familia numerosa en periodo anterior"."<br>";
					//---- asignacion info baja periodo anterior---
					$infotipo = 1;//alta
					$famnumexistente = Empleado::FamNumInfoNueva($data->Empnrodocto, $data->Bennrodocto, $periodoidsi, $infotipo);
					if(!empty($famnumexistente)){
						//---info alta existe, dar de baja
						Empleado::AsignacionInfoBaja($famnumexistente->asignacion_info_id);
					}
					$infotipo = 2;//modificacion
					$famnumexistente = Empleado::FamNumInfoNueva($data->Empnrodocto, $data->Bennrodocto, $periodoidsi, $infotipo);
					if(!empty($famnumexistente)){
						//---info modificacion existe, dar de baja
						Empleado::AsignacionInfoBaja($famnumexistente->asignacion_info_id);
					}
					//---- Insertar baja de familia numerosa de periodo anterior -----
					$infotipo = 3;//baja
					$famnumexistente = Empleado::FamNumInfoNueva($data->Empnrodocto, $data->Bennrodocto, $periodoidsi, $infotipo);
					if(empty($famnumexistente)){
						//--- familia numerosa info no existe, Insertar ----
						$fnu->Asigtitular = $titular;
						$fnu->PHCid = 0;
						$fnu->Empnrodocto = $data->Empnrodocto;
						$fnu->Bennrodocto = $data->Bennrodocto;
						$fnu->Periodoid = $periodoidsi;
						$fnu->Asigtipo = 8;
						$fnu->Asigcantidad = $famnumanteriordatos->asignacion_cantidad;
						$fnu->Asiginfo = 3;//baja
						$fnu->Asinginfoobs = "";
						$fnu->Asiginfoestado = 1;
						//----
						Empleado::AsignacionInfoGuardarExe($fnu);
					}//---famiia numerosa info baja existe
				}else{
					//---- No tiene familia numerosa en el periodo anterior, sin asignacion info
					//---- asignacion info baja periodo anterior---
					$infotipo = 1;//alta
					$famnumexistente = Empleado::FamNumInfoNueva($data->Empnrodocto, $data->Bennrodocto, $periodoidsi, $infotipo);
					if(!empty($famnumexistente)){
						//---info alta existe, dar de baja
						Empleado::AsignacionInfoBaja($famnumexistente->asignacion_info_id);
					}
					$infotipo = 2;//modificacion
					$famnumexistente = Empleado::FamNumInfoNueva($data->Empnrodocto, $data->Bennrodocto, $periodoidsi, $infotipo);
					if(!empty($famnumexistente)){
						//---info modificacion existe, dar de baja
						Empleado::AsignacionInfoBaja($famnumexistente->asignacion_info_id);
					}
					$infotipo = 3;//baja
					$famnumexistente = Empleado::FamNumInfoNueva($data->Empnrodocto, $data->Bennrodocto, $periodoidsi, $infotipo);
					if(!empty($famnumexistente)){
						//---info modificacion existe, dar de baja
						Empleado::AsignacionInfoBaja($famnumexistente->asignacion_info_id);
					}
				}
			}else{
				//--- tiene familia numerosa acual
				//echo "tiene familia numerosa"."<br>";
				$familianum = $famnumdatosc - 2;
				if(!empty($famnumanteriordatos)){
					//---- tiene familia numerosa en periodo anterior
					//echo "tiene familia numerosa en periodo anterior"."<br>";
					$familianuman = $famnumanteriordatos->asignacion_cantidad;
					//echo "Familia Numerosa anterior: ".$familianuman."<br>";
					//echo "Familia Numerosa actual: ".$familianum."<br>";
					if($familianum == $familianuman){
						//----- son iguales, sin asignacion info
						//echo "son iguales, sin asignacion info"."<br>";
						$infotipo = 1;//alta
						$famnumexistente = Empleado::FamNumInfoNueva($data->Empnrodocto, $data->Bennrodocto, $periodoidsi, $infotipo);
						if(!empty($famnumexistente)){
							//---existe info alta
							Empleado::AsignacionInfoBaja($famnumexistente->asignacion_info_id);
						}
						$infotipo = 2;
						$famnumexistente = Empleado::FamNumInfoNueva($data->Empnrodocto, $data->Bennrodocto, $periodoidsi, $infotipo);
						if(!empty($famnumexistente)){
							//---existe info modificacion
							Empleado::AsignacionInfoBaja($famnumexistente->asignacion_info_id);
						}
						$infotipo = 3;
						$famnumexistente = Empleado::FamNumInfoNueva($data->Empnrodocto, $data->Bennrodocto, $periodoidsi, $infotipo);
						if(!empty($famnumexistente)){
							//---existe info baja
							Empleado::AsignacionInfoBaja($famnumexistente->asignacion_info_id);
						}
					}elseif($familianum < $familianuman || $familianum > $familianuman){
						//------ famnum actual mayor o menor a la anterior, asignacion info moficacion
						$infotipo = 1;//alta
						$famnumexistente = Empleado::FamNumInfoNueva($data->Empnrodocto, $data->Bennrodocto, $periodoidsi, $infotipo);
						if(!empty($famnumexistente)){
							//---existe info alta
							Empleado::AsignacionInfoBaja($famnumexistente->asignacion_info_id);
						}
						$infotipo = 3;//baja
						$famnumexistente = Empleado::FamNumInfoNueva($data->Empnrodocto, $data->Bennrodocto, $periodoidsi, $infotipo);
						if(!empty($famnumexistente)){
							//---existe info baja
							Empleado::AsignacionInfoBaja($famnumexistente->asignacion_info_id);
						}
						$infotipo = 2;//modificacion
						$famnumexistente = Empleado::FamNumInfoNueva($data->Empnrodocto, $data->Bennrodocto, $periodoidsi, $infotipo);
						if(!empty($famnumexistente)){
							//---existe info modificacion
							$fnu->Asiginfoid = $famnumexistente->asignacion_info_id;
							$fnu->Asigcantidad = $familianum;
							$fnu->Asinginfoobs = "Es una modificacion";
							Empleado::AsignacionInfoActualizarExe($fnu);

						}else{
							//---no existe info modificacion
							$fnu->Asigtitular = $titular;
							$fnu->PHCid = 0;
							$fnu->Empnrodocto = $data->Empnrodocto;
							$fnu->Bennrodocto = $data->Bennrodocto;
							$fnu->Periodoid = $periodoidsi;
							$fnu->Asigtipo = 8;
							$fnu->Asigcantidad = $familianum;
							$fnu->Asiginfo = 2;//modificacion
							$fnu->Asinginfoobs = "Es un alta dos";
							$fnu->Asiginfoestado = 1;
							//----
							Empleado::AsignacionInfoGuardarExe($fnu);
						}
					}else{

					}
				}else{
					//---- No tiene familia numerosa en el periodo anterior, si en el acual famnun info alta
					//echo "No tiene familia numerosa en el periodo anterior, si en el acual asignacion info alta"."<br>";
					$infotipo = 1;//alta
					$famnumexistente = Empleado::FamNumInfoNueva($data->Empnrodocto, $data->Bennrodocto, $periodoidsi, $infotipo);
					if(!empty($famnumexistente)){
						//echo "Familia Numerosa info existe, Verificar si son iguales"."<br>";
						//---La asignacion info existe, dar de baja
						if($familianum != $famnumexistente->asignacion_cantidad){
							//echo "Familia Numerosa cambio de cantidad"."<br>";
							//---- la cantidad de familia numerosa cambio
							$fnu->Asiginfoid = $famnumexistente->asignacion_info_id;
							$fnu->Asigcantidad = $familianum;
							$fnu->Asinginfoobs = "";
							Empleado::AsignacionInfoActualizarExe($fnu);
						}//---- la cantidad de familia numerosa sigue igual
					}else{
						//----la asignacion info no existente
						//echo "Familia Numerosa info no existe"."<br>";
						$fnu->Asigtitular = $titular;
						$fnu->PHCid = 0;
						$fnu->Empnrodocto = $data->Empnrodocto;
						$fnu->Bennrodocto = $data->Bennrodocto;
						$fnu->Periodoid = $periodoidsi;
						$fnu->Asigtipo = 8;
						$fnu->Asigcantidad = $familianum;
						$fnu->Asiginfo = 1;//alta
						$fnu->Asinginfoobs = "";
						$fnu->Asiginfoestado = 1;
						//----
						Empleado::AsignacionInfoGuardarExe($fnu);
					}
				}
			}
		}else{
			//---sin asignaciones acuales
			//echo "sin asignaciones acuales"."<br>";
			if(!empty($famnumanteriordatos)){
				//---- tiene familia numerosa en periodo anterior
				//echo "tiene familia numerosa en periodo anterior"."<br>";
				$infotipo = 3;//modificacion
				$famnumexistente = Empleado::FamNumInfoNueva($data->Empnrodocto, $data->Bennrodocto, $periodoidsi, $infotipo);
				if(empty($famnumexistente)){
					//---- familia numerosa info baja
					$fnu = array();
					$fnu->Asigtitular = $titular;
					$fnu->PHCid = 0;
					$fnu->Empnrodocto = $data->Empnrodocto;
					$fnu->Bennrodocto = $data->Bennrodocto;
					$fnu->Periodoid = $periodoidsi;
					$fnu->Asigtipo = 8;
					$fnu->Asigcantidad = $famnumanteriordatos->asignacion_cantidad;
					$fnu->Asiginfo = 3;//baja
					$fnu->Asinginfoobs = "";
					$fnu->Asiginfoestado = 1;
					//----
					Empleado::AsignacionInfoGuardarExe($fnu);
				}
			}//---- No tiene familia numerosa en el periodo anterior, sin familia numerosa info
		}
	}


}
