<?php
class Indumentaria{

	public function __CONSTRUCT(){
		try{
			$this->cn = Conexion::getConnection();
		}catch(Exception $e){
			die($e->getMessage());
		}
	}
	public function __DESTRUCT(){
		$db;
		$this->cn;
	}
	public function ObtenerEmpleadoDatos($search){
		try{

			$sql = "SELECT *
								FROM legajos_empleado
							 WHERE legempleado_activo = 1
							   AND (legempleado_apellido
							  LIKE '%$search%' OR legempleado_nombres
								LIKE '%$search%')
							 LIMIT 0,10";
			$dec = $this->cn->prepare($sql);
			$dec->execute();
			return $dec->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function EmpleadoObtener($nrodocto){
		try{

			$sql = 'SELECT *
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
	public function ContratadoObtener($nrodocto){
		try{
			$sql = 'SELECT *
								FROM legajos_contrato
							 WHERE legempleado_nrodocto = ?
							   AND legcontrato_activo = 1
						ORDER BY legcontrato_id DESC
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function JornaleroObtener($nrodocto){
		try{
			$sql = 'SELECT *
								FROM legajos_jornalero
							 WHERE legempleado_nrodocto = ?
							   AND legjornalero_activo = 1
						ORDER BY legjornalero_id DESC
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function PPermanenteObtener($nrodocto){
		try{
			$sql = 'SELECT *
								FROM legajos_ppermanente
							 WHERE legempleado_nrodocto = ?
							   AND legppermanente_activo = 1
						ORDER BY legppermanente_id DESC
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ProveedorObtener($nrodocto){
		try{
			$sql = 'SELECT *
								FROM legajos_proveedor
							 WHERE legempleado_nrodocto = ?
							   AND legproveedor_activo = 1
						ORDER BY legproveedor_id DESC
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function EmpleadoHelpObtener($search){
		try{

			$sql = "SELECT *
								FROM legajos_empleado
							WHERE legempleado_activo = 1
							  AND (CONCAT_WS(' ', legempleado_apellido, legempleado_nombres)
							 LIKE '%$search%'
							   OR CONCAT_WS(' ', legempleado_nombres, legempleado_apellido)
							 LIKE '%$search%')
							LIMIT 0,10";
			$dec = $this->cn->prepare($sql);
			$dec->execute();
			return $dec->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function IndumentariaOrdenGuardarExe($nrodocto){
		try{
			$usuarioid = $_SESSION["usuario_id"];
			$sql = 'INSERT INTO indumentarias_ordenes (legempleado_nrodocto,
																				 				 usuario_id,
																								 indumentaria_orden_estado)
																				  VALUES(:ndoc,
																							   :usrid,
																						 	   1)';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(':ndoc', $nrodocto, PDO::PARAM_STR);
			$dec->bindValue(':usrid', $usuarioid, PDO::PARAM_STR);
			$dec->execute();
			//----------------obtner ultimo id Insertado -----------
			$ultimoid = $this->cn->lastInsertId();
			// ---------------Insert auditoria indumentarias ------------
			$sql = 'SELECT *
								FROM indumentarias_ordenes
							 WHERE indumentaria_orden_id = ?
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $ultimoid, PDO::PARAM_STR);
			$dec->execute();
			$row = $dec->fetch(PDO::FETCH_OBJ);
			//-----------Informacion para auditoria ---------------
			$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];
			$ippublica = $_SERVER["REMOTE_ADDR"];
			$pcnombre = gethostbyaddr($_SERVER['REMOTE_ADDR']);
			$pcinformacion = $_SERVER['HTTP_USER_AGENT'];

			$sql ='INSERT INTO aud_indumentarias_ordenes(AUD_indumentaria_orden_id,
																									 AUD_legempleado_nrodocto,
																									 AUD_usuario_id,
																									 AUD_indumentaria_orden_estado,
																								   AUD_indumentaria_orden_ippublica,
																								 	 AUD_indumentaria_orden_pcnombre,
																									 AUD_indumentaria_orden_pcinformacion,
																									 AUD_indumentaria_orden_accion,
																									 AUD_indumentaria_orden_observacion,
																									 AUD_indumentaria_orden_datetime,
																									 AUD_indumentaria_orden_usuario)
																				    VALUES(:indordenid,
																								   :empndoc,
																								   :usrid,
																								   :indordenest,
																									 :indordenippublica,
																									 :indordenpcnombre,
																									 :indordenpcinformacion,
																								   "INSERT",
																									 "",
																								   NOW(),
																								   :indordenusuario)';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(':indordenid', $row->indumentaria_orden_id, PDO::PARAM_STR);
			$dec->bindValue(':empndoc', $row->legempleado_nrodocto, PDO::PARAM_STR);
			$dec->bindValue(':usrid', $row->usuario_id, PDO::PARAM_STR);
			$dec->bindValue(':indordenest', $row->indumentaria_orden_estado, PDO::PARAM_STR);
			$dec->bindValue(':indordenippublica', $ippublica, PDO::PARAM_STR);
			$dec->bindValue(':indordenpcnombre', $pcnombre, PDO::PARAM_STR);
			$dec->bindValue(':indordenpcinformacion', $pcinformacion, PDO::PARAM_STR);
			$dec->bindValue(':indordenusuario', $usuario, PDO::PARAM_STR);
			$dec->execute();

			return $ultimoid;

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function IndumentariaOrdenObtener($nrodocto){
		try{

			$sql = 'SELECT *
								FROM indumentarias_ordenes
							 WHERE legempleado_nrodocto = ?
							 	 AND indumentaria_orden_estado = 1
						ORDER BY indumentaria_orden_id DESC
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function IndumentariaCarritoPendiente($nrodocto, $indordenultimoid){
		try{

			$sql = 'SELECT *
								FROM indumentarias_entregas a,
										 indumentarias b,
										 indumentarias_talles c,
										 indumentarias_colores d
							 WHERE a.indumentaria_id = b.indumentaria_id
							 	 AND a.indumentaria_talle_id = c.indumentaria_talle_id
								 AND a.indumentaria_color_id = d.indumentaria_color_id
							 	 AND a.legempleado_nrodocto = ?
								 AND a.indumentaria_entrega_estado = 1
						ORDER BY a.indumentaria_entrega_id';
			$dec = $this->cn->prepare($sql);
			//$dec->bindValue(1, $indordenultimoid, PDO::PARAM_STR);
			$dec->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function IndumentariaListar(){
		try{
			$sql = $this->cn->prepare("SELECT *
																	 FROM indumentarias
																	WHERE indumentaria_estado = 1
															 ORDER BY indumentaria_nombre");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function IndumentariaColorListar(){
		try{
			$sql = $this->cn->prepare("SELECT *
																	 FROM indumentarias_colores
																	WHERE indumentaria_color_estado = 1
															 ORDER BY indumentaria_color_nombre");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function IndumentariaTallesObtener($indumentariaid){
		try{

			$sql = 'SELECT *
								FROM indumentarias_talles
							 WHERE indumentaria_id = ?
								 AND indumentaria_talle_estado = 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $indumentariaid, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function IndumentariaCarroGuardarExe($data){
		try{

			$sql = 'INSERT INTO indumentarias_entregas (indumentaria_orden_id,
																									indumentaria_id,
																									indumentaria_entrega_cantidad,
																									indumentaria_entrega_observacion,
																									indumentaria_talle_id,
																									indumentaria_color_id,
																									legempleado_nrodocto,
																									trabajo_id,
																									secretaria_id,
																									indumentaria_entrega_fecha,
																									indumentaria_entrega_estado)
																					 VALUES(:indumentariaorden,
																									:indumentariaid,
																									:indumentariac,
																									:indumentariaobs,
																									:tallleid,
																									:colorid,
																									:empndoc,
																									:trabajoid,
																									:secid,
																									:indumentariafec,
																									1)';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(':indumentariaorden', $data->Indumentariaorden, PDO::PARAM_STR);
			$dec->bindValue(':indumentariaid', $data->Indumentariaid, PDO::PARAM_STR);
			$dec->bindValue(':indumentariac', $data->Indumentariac, PDO::PARAM_STR);
			$dec->bindValue(':indumentariaobs', $data->Indumentariaobs, PDO::PARAM_STR);
			$dec->bindValue(':tallleid', $data->Talleid, PDO::PARAM_STR);
			$dec->bindValue(':colorid', $data->Colorid, PDO::PARAM_STR);
			$dec->bindValue(':empndoc', $data->Empndoc, PDO::PARAM_STR);
			$dec->bindValue(':trabajoid', $data->Trabajoid, PDO::PARAM_STR);
			$dec->bindValue(':secid', $data->Secretariaid, PDO::PARAM_STR);
			$dec->bindValue(':indumentariafec', $data->IndumentariaFecha, PDO::PARAM_STR);
			$dec->execute();
			//----------------obtner ultimo id Insertado -----------
			$ultimoid = $this->cn->lastInsertId();
			// ---------------Insert auditoria indumentarias ------------
			$sql = 'SELECT *
								FROM indumentarias_entregas
							 WHERE indumentaria_entrega_id = ?
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $ultimoid, PDO::PARAM_STR);
			$dec->execute();
			$row = $dec->fetch(PDO::FETCH_OBJ);
			//-----------Informacion para auditoria ---------------
			$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];
			$ippublica = $_SERVER["REMOTE_ADDR"];
			$pcnombre = gethostbyaddr($_SERVER['REMOTE_ADDR']);
			$pcinformacion = $_SERVER['HTTP_USER_AGENT'];

			$sql ='INSERT INTO aud_indumentarias_entregas(AUD_indumentaria_entrega_id,
																										AUD_indumentaria_orden_id,
																										AUD_indumentaria_id,
																										AUD_indumentaria_entrega_cantidad,
																										AUD_indumentaria_entrega_observacion,
																										AUD_indumentaria_talle_id,
																										AUD_indumentaria_color_id,
																										AUD_legempleado_nrodocto,
																										AUD_trabajo_id,
																										AUD_secretaria_id,
																										AUD_indumentaria_entrega_fecha,
																										AUD_indumentaria_entrega_estado,
																								    AUD_indumentaria_entrega_ippublica,
																								 	  AUD_indumentaria_entrega_pcnombre,
																									  AUD_indumentaria_entrega_pcinformacion,
																									  AUD_indumentaria_entrega_accion,
																									  AUD_indumentaria_entrega_datetime,
																									  AUD_indumentaria_entrega_usuario)
																					   VALUES(:indentregaid,
																									  :indordenid,
																									  :indumentariaid,
																									  :indentregac,
																									  :indentregaobs,
																									  :indtalleid,
																										:indcolorid,
																										:empdoc,
																										:trabajoid,
																										:secretariaid,
																										:indentregafec,
																										:indentregaestado,
																										:indentregaippublica,
																										:indentregapcnombre,
																										:indentregapcinformacion,
																									  "INSERT",
																									  NOW(),
																									  :indentregausuario)';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(':indentregaid', $row->indumentaria_entrega_id, PDO::PARAM_STR);
			$dec->bindValue(':indordenid', $row->indumentaria_orden_id, PDO::PARAM_STR);
			$dec->bindValue(':indumentariaid', $row->indumentaria_id, PDO::PARAM_STR);
			$dec->bindValue(':indentregac', $row->indumentaria_entrega_cantidad, PDO::PARAM_STR);
			$dec->bindValue(':indentregaobs', $row->indumentaria_entrega_observacion, PDO::PARAM_STR);
			$dec->bindValue(':indtalleid', $row->indumentaria_talle_id, PDO::PARAM_STR);
			$dec->bindValue(':indcolorid', $row->indumentaria_color_id, PDO::PARAM_STR);
			$dec->bindValue(':empdoc', $row->legempleado_nrodocto, PDO::PARAM_STR);
			$dec->bindValue(':trabajoid', $row->trabajo_id, PDO::PARAM_STR);
			$dec->bindValue(':secretariaid', $row->secretaria_id, PDO::PARAM_STR);
			$dec->bindValue(':indentregafec', $row->indumentaria_entrega_fecha, PDO::PARAM_STR);
			$dec->bindValue(':indentregaestado', $row->indumentaria_entrega_estado, PDO::PARAM_STR);
			$dec->bindValue(':indentregaippublica', $ippublica, PDO::PARAM_STR);
			$dec->bindValue(':indentregapcnombre', $pcnombre, PDO::PARAM_STR);
			$dec->bindValue(':indentregapcinformacion', $pcinformacion, PDO::PARAM_STR);
			$dec->bindValue(':indentregausuario', $usuario, PDO::PARAM_STR);
			$dec->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function IndumentariaCarroActualizar($data){
		try{

			$sql = 'UPDATE indumentarias_entregas
								 SET indumentaria_id = ?,
								 		 indumentaria_entrega_cantidad = ?,
								 	 	 indumentaria_entrega_observacion = ?,
										 indumentaria_talle_id = ?,
										 indumentaria_color_id = ?,
										 trabajo_id = ?,
										 secretaria_id = ?
							 WHERE indumentaria_entrega_id = ?';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $data->Indumentariaid, PDO::PARAM_STR);
			$dec->bindValue(2, $data->Indumentariac, PDO::PARAM_STR);
			$dec->bindValue(3, $data->Indumentariaobs, PDO::PARAM_STR);
			$dec->bindValue(4, $data->Talleid, PDO::PARAM_STR);
			$dec->bindValue(5, $data->Colorid, PDO::PARAM_STR);
			$dec->bindValue(6, $data->Trabajoid, PDO::PARAM_STR);
			$dec->bindValue(7, $data->Secretariaid, PDO::PARAM_STR);
			$dec->bindValue(8, $data->Indentregaid, PDO::PARAM_STR);
			$dec->execute();
			// ---------------Insert auditoria indumentarias ------------
			$sql = 'SELECT *
								FROM indumentarias_entregas
							 WHERE indumentaria_entrega_id = ?
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $data->Indentregaid, PDO::PARAM_STR);
			$dec->execute();
			$row = $dec->fetch(PDO::FETCH_OBJ);
			//-----------Informacion para auditoria ---------------
			$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];
			$ippublica = $_SERVER["REMOTE_ADDR"];
			$pcnombre = gethostbyaddr($_SERVER['REMOTE_ADDR']);
			$pcinformacion = $_SERVER['HTTP_USER_AGENT'];

			$sql ='INSERT INTO aud_indumentarias_entregas(AUD_indumentaria_entrega_id,
																										AUD_indumentaria_orden_id,
																										AUD_indumentaria_id,
																										AUD_indumentaria_entrega_cantidad,
																										AUD_indumentaria_entrega_observacion,
																										AUD_indumentaria_talle_id,
																										AUD_indumentaria_color_id,
																										AUD_legempleado_nrodocto,
																										AUD_trabajo_id,
																										AUD_secretaria_id,
																										AUD_indumentaria_entrega_fecha,
																										AUD_indumentaria_entrega_estado,
																								    AUD_indumentaria_entrega_ippublica,
																								 	  AUD_indumentaria_entrega_pcnombre,
																									  AUD_indumentaria_entrega_pcinformacion,
																									  AUD_indumentaria_entrega_accion,
																									  AUD_indumentaria_entrega_datetime,
																									  AUD_indumentaria_entrega_usuario)
																					   VALUES(:indentregaid,
																									  :indordenid,
																									  :indumentariaid,
																									  :indentregac,
																									  :indentregaobs,
																									  :indtalleid,
																										:indcolorid,
																										:empdoc,
																										:trabajoid,
																										:secretariaid,
																										:indentregafec,
																										:indentregaestado,
																										:indentregaippublica,
																										:indentregapcnombre,
																										:indentregapcinformacion,
																									  "UPDATE",
																									  NOW(),
																									  :indentregausuario)';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(':indentregaid', $row->indumentaria_entrega_id, PDO::PARAM_STR);
			$dec->bindValue(':indordenid', $row->indumentaria_orden_id, PDO::PARAM_STR);
			$dec->bindValue(':indumentariaid', $row->indumentaria_id, PDO::PARAM_STR);
			$dec->bindValue(':indentregac', $row->indumentaria_entrega_cantidad, PDO::PARAM_STR);
			$dec->bindValue(':indentregaobs', $row->indumentaria_entrega_observacion, PDO::PARAM_STR);
			$dec->bindValue(':indtalleid', $row->indumentaria_talle_id, PDO::PARAM_STR);
			$dec->bindValue(':indcolorid', $row->indumentaria_color_id, PDO::PARAM_STR);
			$dec->bindValue(':empdoc', $row->legempleado_nrodocto, PDO::PARAM_STR);
			$dec->bindValue(':trabajoid', $row->trabajo_id, PDO::PARAM_STR);
			$dec->bindValue(':secretariaid', $row->secretaria_id, PDO::PARAM_STR);
			$dec->bindValue(':indentregafec', $row->indumentaria_entrega_fecha, PDO::PARAM_STR);
			$dec->bindValue(':indentregaestado', $row->indumentaria_entrega_estado, PDO::PARAM_STR);
			$dec->bindValue(':indentregaippublica', $ippublica, PDO::PARAM_STR);
			$dec->bindValue(':indentregapcnombre', $pcnombre, PDO::PARAM_STR);
			$dec->bindValue(':indentregapcinformacion', $pcinformacion, PDO::PARAM_STR);
			$dec->bindValue(':indentregausuario', $usuario, PDO::PARAM_STR);
			$dec->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function IndumentariaCarroEliminarExe($data){
		try{

			$sql = 'UPDATE indumentarias_entregas
								 SET indumentaria_entrega_estado = 0
							 WHERE indumentaria_entrega_id = ?';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $data->Indentregaid, PDO::PARAM_STR);
			$dec->execute();
			// ---------------Insert auditoria indumentarias ------------
			$sql = 'SELECT *
								FROM indumentarias_entregas
							 WHERE indumentaria_entrega_id = ?
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $data->Indentregaid, PDO::PARAM_STR);
			$dec->execute();
			$row = $dec->fetch(PDO::FETCH_OBJ);
			//-----------Informacion para auditoria ---------------
			$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];
			$ippublica = $_SERVER["REMOTE_ADDR"];
			$pcnombre = gethostbyaddr($_SERVER['REMOTE_ADDR']);
			$pcinformacion = $_SERVER['HTTP_USER_AGENT'];

			$sql ='INSERT INTO aud_indumentarias_entregas(AUD_indumentaria_entrega_id,
																										AUD_indumentaria_orden_id,
																										AUD_indumentaria_id,
																										AUD_indumentaria_entrega_cantidad,
																										AUD_indumentaria_entrega_observacion,
																										AUD_indumentaria_talle_id,
																										AUD_indumentaria_color_id,
																										AUD_legempleado_nrodocto,
																										AUD_trabajo_id,
																										AUD_secretaria_id,
																										AUD_indumentaria_entrega_fecha,
																										AUD_indumentaria_entrega_estado,
																								    AUD_indumentaria_entrega_ippublica,
																								 	  AUD_indumentaria_entrega_pcnombre,
																									  AUD_indumentaria_entrega_pcinformacion,
																									  AUD_indumentaria_entrega_accion,
																									  AUD_indumentaria_entrega_datetime,
																									  AUD_indumentaria_entrega_usuario)
																					   VALUES(:indentregaid,
																									  :indordenid,
																									  :indumentariaid,
																									  :indentregac,
																									  :indentregaobs,
																									  :indtalleid,
																										:indcolorid,
																										:empdoc,
																										:trabajoid,
																										:secretariaid,
																										:indentregafec,
																										:indentregaestado,
																										:indentregaippublica,
																										:indentregapcnombre,
																										:indentregapcinformacion,
																									  "DISABLE",
																									  NOW(),
																									  :indentregausuario)';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(':indentregaid', $row->indumentaria_entrega_id, PDO::PARAM_STR);
			$dec->bindValue(':indordenid', $row->indumentaria_orden_id, PDO::PARAM_STR);
			$dec->bindValue(':indumentariaid', $row->indumentaria_id, PDO::PARAM_STR);
			$dec->bindValue(':indentregac', $row->indumentaria_entrega_cantidad, PDO::PARAM_STR);
			$dec->bindValue(':indentregaobs', $row->indumentaria_entrega_observacion, PDO::PARAM_STR);
			$dec->bindValue(':indtalleid', $row->indumentaria_talle_id, PDO::PARAM_STR);
			$dec->bindValue(':indcolorid', $row->indumentaria_color_id, PDO::PARAM_STR);
			$dec->bindValue(':empdoc', $row->legempleado_nrodocto, PDO::PARAM_STR);
			$dec->bindValue(':trabajoid', $row->trabajo_id, PDO::PARAM_STR);
			$dec->bindValue(':secretariaid', $row->secretaria_id, PDO::PARAM_STR);
			$dec->bindValue(':indentregafec', $row->indumentaria_entrega_fecha, PDO::PARAM_STR);
			$dec->bindValue(':indentregaestado', $row->indumentaria_entrega_estado, PDO::PARAM_STR);
			$dec->bindValue(':indentregaippublica', $ippublica, PDO::PARAM_STR);
			$dec->bindValue(':indentregapcnombre', $pcnombre, PDO::PARAM_STR);
			$dec->bindValue(':indentregapcinformacion', $pcinformacion, PDO::PARAM_STR);
			$dec->bindValue(':indentregausuario', $usuario, PDO::PARAM_STR);
			$dec->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function IndumentariaOrdenTerminar($entrega_numero){
		try{

			$sql = 'UPDATE indumentarias_ordenes
								 SET indumentaria_orden_estado = 2
							 WHERE indumentaria_orden_id = ?';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $entrega_numero, PDO::PARAM_STR);
			$dec->execute();
			// ---------------Insert auditoria indumentarias ------------
			$sql = 'SELECT *
								FROM indumentarias_ordenes
							 WHERE indumentaria_orden_id = ?
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $entrega_numero, PDO::PARAM_STR);
			$dec->execute();
			$row = $dec->fetch(PDO::FETCH_OBJ);
			//-----------Informacion para auditoria ---------------
			$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];
			$ippublica = $_SERVER["REMOTE_ADDR"];
			$pcnombre = gethostbyaddr($_SERVER['REMOTE_ADDR']);
			$pcinformacion = $_SERVER['HTTP_USER_AGENT'];

			$sql ='INSERT INTO aud_indumentarias_ordenes(AUD_indumentaria_orden_id,
																									 AUD_legempleado_nrodocto,
																									 AUD_usuario_id,
																									 AUD_indumentaria_orden_estado,
																								   AUD_indumentaria_orden_ippublica,
																								 	 AUD_indumentaria_orden_pcnombre,
																									 AUD_indumentaria_orden_pcinformacion,
																									 AUD_indumentaria_orden_accion,
																									 AUD_indumentaria_orden_observacion,
																									 AUD_indumentaria_orden_datetime,
																									 AUD_indumentaria_orden_usuario)
																				    VALUES(:indordenid,
																								   :empndoc,
																								   :usrid,
																								   :indordenest,
																									 :indordenippublica,
																									 :indordenpcnombre,
																									 :indordenpcinformacion,
																								   "UPDATE",
																									 "",
																								   NOW(),
																								   :indordenusuario)';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(':indordenid', $row->indumentaria_orden_id, PDO::PARAM_STR);
			$dec->bindValue(':empndoc', $row->legempleado_nrodocto, PDO::PARAM_STR);
			$dec->bindValue(':usrid', $row->usuario_id, PDO::PARAM_STR);
			$dec->bindValue(':indordenest', $row->indumentaria_orden_estado, PDO::PARAM_STR);
			$dec->bindValue(':indordenippublica', $ippublica, PDO::PARAM_STR);
			$dec->bindValue(':indordenpcnombre', $pcnombre, PDO::PARAM_STR);
			$dec->bindValue(':indordenpcinformacion', $pcinformacion, PDO::PARAM_STR);
			$dec->bindValue(':indordenusuario', $usuario, PDO::PARAM_STR);
			$dec->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function IndumentariaEntregaGuardarExe($entrega_numero, $fecha_actual){
		try{

			$sql = 'UPDATE indumentarias_entregas
								 SET indumentaria_entrega_fecha = ?,
								 		 indumentaria_entrega_estado = 2
							 WHERE indumentaria_entrega_estado = 1
							 	 AND indumentaria_orden_id = ?';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $fecha_actual, PDO::PARAM_STR);
			$dec->bindValue(2, $entrega_numero, PDO::PARAM_STR);
			$dec->execute();
			// ---------------Insert auditoria indumentarias entregas-------------
			//-----------Informacion para auditoria ---------------
			$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];
			$ippublica = $_SERVER["REMOTE_ADDR"];
			$pcnombre = gethostbyaddr($_SERVER['REMOTE_ADDR']);
			$pcinformacion = $_SERVER['HTTP_USER_AGENT'];

			$sql = 'SELECT *
								FROM indumentarias_entregas
							 WHERE indumentaria_orden_id = ?
							 	 AND indumentaria_entrega_estado = 2';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $entrega_numero, PDO::PARAM_STR);
			$dec->execute();
			$rows = $dec->fetchAll(PDO::FETCH_OBJ);
			foreach($rows as $row){

				$sql ='INSERT INTO aud_indumentarias_entregas(AUD_indumentaria_entrega_id,
																											AUD_indumentaria_orden_id,
																											AUD_indumentaria_id,
																											AUD_indumentaria_entrega_cantidad,
																											AUD_indumentaria_entrega_observacion,
																											AUD_indumentaria_talle_id,
																											AUD_indumentaria_color_id,
																											AUD_legempleado_nrodocto,
																											AUD_trabajo_id,
																											AUD_secretaria_id,
																											AUD_indumentaria_entrega_fecha,
																											AUD_indumentaria_entrega_estado,
																									    AUD_indumentaria_entrega_ippublica,
																									 	  AUD_indumentaria_entrega_pcnombre,
																										  AUD_indumentaria_entrega_pcinformacion,
																										  AUD_indumentaria_entrega_accion,
																										  AUD_indumentaria_entrega_datetime,
																										  AUD_indumentaria_entrega_usuario)
																						   VALUES(:indentregaid,
																										  :indordenid,
																										  :indumentariaid,
																										  :indentregac,
																										  :indentregaobs,
																										  :indtalleid,
																											:indcolorid,
																											:empdoc,
																											:trabajoid,
																											:secretariaid,
																											:indentregafec,
																											:indentregaestado,
																											:indentregaippublica,
																											:indentregapcnombre,
																											:indentregapcinformacion,
																										  "UPDATE",
																										  NOW(),
																										  :indentregausuario)';
				$dec = $this->cn->prepare($sql);
				$dec->bindValue(':indentregaid', $row->indumentaria_entrega_id, PDO::PARAM_STR);
				$dec->bindValue(':indordenid', $row->indumentaria_orden_id, PDO::PARAM_STR);
				$dec->bindValue(':indumentariaid', $row->indumentaria_id, PDO::PARAM_STR);
				$dec->bindValue(':indentregac', $row->indumentaria_entrega_cantidad, PDO::PARAM_STR);
				$dec->bindValue(':indentregaobs', $row->indumentaria_entrega_observacion, PDO::PARAM_STR);
				$dec->bindValue(':indtalleid', $row->indumentaria_talle_id, PDO::PARAM_STR);
				$dec->bindValue(':indcolorid', $row->indumentaria_color_id, PDO::PARAM_STR);
				$dec->bindValue(':empdoc', $row->legempleado_nrodocto, PDO::PARAM_STR);
				$dec->bindValue(':trabajoid', $row->trabajo_id, PDO::PARAM_STR);
				$dec->bindValue(':secretariaid', $row->secretaria_id, PDO::PARAM_STR);
				$dec->bindValue(':indentregafec', $row->indumentaria_entrega_fecha, PDO::PARAM_STR);
				$dec->bindValue(':indentregaestado', $row->indumentaria_entrega_estado, PDO::PARAM_STR);
				$dec->bindValue(':indentregaippublica', $ippublica, PDO::PARAM_STR);
				$dec->bindValue(':indentregapcnombre', $pcnombre, PDO::PARAM_STR);
				$dec->bindValue(':indentregapcinformacion', $pcinformacion, PDO::PARAM_STR);
				$dec->bindValue(':indentregausuario', $usuario, PDO::PARAM_STR);
				$dec->execute();

			}

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function IndumentariaStockDescontar($entrega_numero, $fecha_actual){
		try{

			$sql = 'UPDATE indumentarias_entregas
								 SET indumentaria_entrega_fecha = ?,
								 		 indumentaria_entrega_estado = 3
							 WHERE indumentaria_entrega_estado = 2
							 	 AND indumentaria_orden_id = ?';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $fecha_actual, PDO::PARAM_STR);
			$dec->bindValue(2, $entrega_numero, PDO::PARAM_STR);
			$dec->execute();
			// ---------------Insert auditoria indumentarias entregas-------------
			//-----------Informacion para auditoria ---------------
			$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];
			$ippublica = $_SERVER["REMOTE_ADDR"];
			$pcnombre = gethostbyaddr($_SERVER['REMOTE_ADDR']);
			$pcinformacion = $_SERVER['HTTP_USER_AGENT'];

			$sql = 'SELECT *
								FROM indumentarias_entregas
							 WHERE indumentaria_orden_id = ?
							 	 AND indumentaria_entrega_estado = 3';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $entrega_numero, PDO::PARAM_STR);
			$dec->execute();
			$rows = $dec->fetchAll(PDO::FETCH_OBJ);
			foreach($rows as $row){

				$sql ='INSERT INTO aud_indumentarias_entregas(AUD_indumentaria_entrega_id,
																											AUD_indumentaria_orden_id,
																											AUD_indumentaria_id,
																											AUD_indumentaria_entrega_cantidad,
																											AUD_indumentaria_entrega_observacion,
																											AUD_indumentaria_talle_id,
																											AUD_indumentaria_color_id,
																											AUD_legempleado_nrodocto,
																											AUD_trabajo_id,
																											AUD_secretaria_id,
																											AUD_indumentaria_entrega_fecha,
																											AUD_indumentaria_entrega_estado,
																									    AUD_indumentaria_entrega_ippublica,
																									 	  AUD_indumentaria_entrega_pcnombre,
																										  AUD_indumentaria_entrega_pcinformacion,
																										  AUD_indumentaria_entrega_accion,
																										  AUD_indumentaria_entrega_datetime,
																										  AUD_indumentaria_entrega_usuario)
																						   VALUES(:indentregaid,
																										  :indordenid,
																										  :indumentariaid,
																										  :indentregac,
																										  :indentregaobs,
																										  :indtalleid,
																											:indcolorid,
																											:empdoc,
																											:trabajoid,
																											:secretariaid,
																											:indentregafec,
																											:indentregaestado,
																											:indentregaippublica,
																											:indentregapcnombre,
																											:indentregapcinformacion,
																										  "UPDATE",
																										  NOW(),
																										  :indentregausuario)';
				$dec = $this->cn->prepare($sql);
				$dec->bindValue(':indentregaid', $row->indumentaria_entrega_id, PDO::PARAM_STR);
				$dec->bindValue(':indordenid', $row->indumentaria_orden_id, PDO::PARAM_STR);
				$dec->bindValue(':indumentariaid', $row->indumentaria_id, PDO::PARAM_STR);
				$dec->bindValue(':indentregac', $row->indumentaria_entrega_cantidad, PDO::PARAM_STR);
				$dec->bindValue(':indentregaobs', $row->indumentaria_entrega_observacion, PDO::PARAM_STR);
				$dec->bindValue(':indtalleid', $row->indumentaria_talle_id, PDO::PARAM_STR);
				$dec->bindValue(':indcolorid', $row->indumentaria_color_id, PDO::PARAM_STR);
				$dec->bindValue(':empdoc', $row->legempleado_nrodocto, PDO::PARAM_STR);
				$dec->bindValue(':trabajoid', $row->trabajo_id, PDO::PARAM_STR);
				$dec->bindValue(':secretariaid', $row->secretaria_id, PDO::PARAM_STR);
				$dec->bindValue(':indentregafec', $row->indumentaria_entrega_fecha, PDO::PARAM_STR);
				$dec->bindValue(':indentregaestado', $row->indumentaria_entrega_estado, PDO::PARAM_STR);
				$dec->bindValue(':indentregaippublica', $ippublica, PDO::PARAM_STR);
				$dec->bindValue(':indentregapcnombre', $pcnombre, PDO::PARAM_STR);
				$dec->bindValue(':indentregapcinformacion', $pcinformacion, PDO::PARAM_STR);
				$dec->bindValue(':indentregausuario', $usuario, PDO::PARAM_STR);
				$dec->execute();
				//--------------Descuento de Stock
				$sql = 'SELECT *
									FROM indumentarias_stocks
								 WHERE indumentaria_id = ?
								 	 AND indumentaria_talle_id = ?
									 AND indumentaria_color_id = ?';
				$dec = $this->cn->prepare($sql);
				$dec->bindValue(1, $row->indumentaria_id, PDO::PARAM_STR);
				$dec->bindValue(2, $row->indumentaria_talle_id, PDO::PARAM_STR);
				$dec->bindValue(3, $row->indumentaria_color_id, PDO::PARAM_STR);
				$dec->execute();
				$row_dos = $dec->fetch(PDO::FETCH_OBJ);

				$stocknuevo = $row_dos->indumentaria_stock_cantidad - $row->indumentaria_entrega_cantidad;

				$sql = 'UPDATE indumentarias_stocks
									 SET indumentaria_stock_cantidad = ?
								 WHERE indumentaria_stock_id = ?';

				$dec = $this->cn->prepare($sql);
				$dec->bindValue(1, $stocknuevo, PDO::PARAM_STR);
				$dec->bindValue(2, $row_dos->indumentaria_stock_id, PDO::PARAM_STR);
				$dec->execute();
				//----------auditoria stock ----------
				$sql = 'SELECT *
									FROM indumentarias_stocks
								 WHERE indumentaria_stock_id = ?';
				$dec = $this->cn->prepare($sql);
				$dec->bindValue(1, $row_dos->indumentaria_stock_id, PDO::PARAM_STR);
				$dec->execute();
				$row_tres = $dec->fetch(PDO::FETCH_OBJ);

				$sql ='INSERT INTO aud_indumentarias_stocks(AUD_indumentaria_stock_id,
																										AUD_indumentaria_stock_codigo_barra,
																										AUD_indumentaria_id,
																										AUD_indumentaria_talle_id,
																										AUD_indumentaria_color_id,
																										AUD_indumentaria_stock_cantidad,
																										AUD_indumentaria_stock_minimo,
																										AUD_indumentaria_stock_estado,
																									  AUD_indumentaria_stock_ippublica,
																									 	AUD_indumentaria_stock_pcnombre,
																										AUD_indumentaria_stock_pcinformacion,
																										AUD_indumentaria_stock_accion,
																										AUD_indumentaria_stock_datetime,
																										AUD_indumentaria_stock_usuario)
																					   VALUES(:indstockid,
																									  :indstockcodb,
																									  :indumentariaid,
																									  :indumentariatalleid,
																									  :indumentariacolorid,
																									  :indstockcantidad,
																										:indstockminimo,
																										:indstockestado,
																										:indstockippublica,
																										:indstockpcnombre,
																										:indstockpcinformacion,
																									  "UPDATE",
																									  NOW(),
																									  :indstockusuario)';
				$dec = $this->cn->prepare($sql);
				$dec->bindValue(':indstockid', $row_tres->indumentaria_stock_id, PDO::PARAM_STR);
				$dec->bindValue(':indstockcodb', $row_tres->indumentaria_stock_codigo_barra, PDO::PARAM_STR);
				$dec->bindValue(':indumentariaid', $row_tres->indumentaria_id, PDO::PARAM_STR);
				$dec->bindValue(':indumentariatalleid', $row_tres->indumentaria_talle_id, PDO::PARAM_STR);
				$dec->bindValue(':indumentariacolorid', $row_tres->indumentaria_color_id, PDO::PARAM_STR);
				$dec->bindValue(':indstockcantidad', $row_tres->indumentaria_stock_cantidad, PDO::PARAM_STR);
				$dec->bindValue(':indstockminimo', $row_tres->indumentaria_stock_minimo, PDO::PARAM_STR);
				$dec->bindValue(':indstockestado', $row_tres->indumentaria_stock_estado, PDO::PARAM_STR);
				$dec->bindValue(':indstockippublica', $ippublica, PDO::PARAM_STR);
				$dec->bindValue(':indstockpcnombre', $pcnombre, PDO::PARAM_STR);
				$dec->bindValue(':indstockpcinformacion', $pcinformacion, PDO::PARAM_STR);
				$dec->bindValue(':indstockusuario', $usuario, PDO::PARAM_STR);
				$dec->execute();

			}

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function IndumentariaEntregaObtner($entrega_numero){
		try{

			$sql = 'SELECT *
								FROM indumentarias_entregas
							 WHERE indumentaria_orden_id = ?
								 AND (indumentaria_entrega_estado = 2
								  OR indumentaria_entrega_estado = 3)';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $entrega_numero, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function IndumentariasEntregasListar($nrodocto, $fechainicio, $fechafinal){
		try{

			$sql = 'SELECT *
								FROM indumentarias_entregas a
					INNER JOIN indumentarias b
					 			  ON a.indumentaria_id = b.indumentaria_id
					INNER JOIN indumentarias_talles c
									ON a.indumentaria_talle_id = c.indumentaria_talle_id
					INNER JOIN indumentarias_colores d
									ON a.indumentaria_color_id = d.indumentaria_color_id
							 WHERE a.legempleado_nrodocto = ?
								 AND (a.indumentaria_entrega_estado = 2
								  OR a.indumentaria_entrega_estado = 3)
								 AND a.indumentaria_entrega_fecha
						 BETWEEN ?
						     AND ?
						ORDER BY a.indumentaria_entrega_fecha,
								     a.indumentaria_orden_id';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $nrodocto, PDO::PARAM_STR);
			$dec->bindValue(2, $fechainicio, PDO::PARAM_STR);
			$dec->bindValue(3, $fechafinal, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function IndumentariasEntregasListarXFecha($fechainicio, $fechafinal){
		try{

			$sql = 'SELECT *
								FROM indumentarias_entregas a
					INNER JOIN indumentarias b
					 			  ON a.indumentaria_id = b.indumentaria_id
					INNER JOIN indumentarias_talles c
									ON a.indumentaria_talle_id = c.indumentaria_talle_id
					INNER JOIN indumentarias_colores d
									ON a.indumentaria_color_id = d.indumentaria_color_id
					INNER JOIN lugares_trabajo e
									ON a.trabajo_id = e.trabajo_id
					INNER JOIN secretarias f
									ON a.secretaria_id = f.secretaria_id
					INNER JOIN legajos_empleado g
									ON a.legempleado_nrodocto = g.legempleado_nrodocto
								 AND (a.indumentaria_entrega_estado = 2
								  OR a.indumentaria_entrega_estado = 3)
								 AND a.indumentaria_entrega_fecha
						 BETWEEN ?
						     AND ?
						ORDER BY a.indumentaria_entrega_fecha,
								     a.indumentaria_orden_id';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $fechainicio, PDO::PARAM_STR);
			$dec->bindValue(2, $fechafinal, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function IndumentariasEntregasListarXFechaXSecretaria($fechainicio, $fechafinal, $secretaria){
		try{

			$sql = 'SELECT *
								FROM indumentarias_entregas a
					INNER JOIN indumentarias b
					 			  ON a.indumentaria_id = b.indumentaria_id
					INNER JOIN indumentarias_talles c
									ON a.indumentaria_talle_id = c.indumentaria_talle_id
					INNER JOIN indumentarias_colores d
									ON a.indumentaria_color_id = d.indumentaria_color_id
					INNER JOIN lugares_trabajo e
									ON a.trabajo_id = e.trabajo_id
					INNER JOIN secretarias f
									ON a.secretaria_id = f.secretaria_id
					INNER JOIN legajos_empleado g
									ON a.legempleado_nrodocto = g.legempleado_nrodocto
								 AND a.secretaria_id = ?
								 AND (a.indumentaria_entrega_estado = 2
								  OR a.indumentaria_entrega_estado = 3)
								 AND a.indumentaria_entrega_fecha
						 BETWEEN ?
						     AND ?
						ORDER BY a.indumentaria_entrega_fecha,
								     a.indumentaria_orden_id';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $secretaria, PDO::PARAM_STR);
			$dec->bindValue(2, $fechainicio, PDO::PARAM_STR);
			$dec->bindValue(3, $fechafinal, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function IndumentariasEntregasListarXFechaXSecretariaXLTrabajo($fechainicio, $fechafinal, $secretaria, $ltrabajo){
		try{

			$sql = 'SELECT *
								FROM indumentarias_entregas a
					INNER JOIN indumentarias b
					 			  ON a.indumentaria_id = b.indumentaria_id
					INNER JOIN indumentarias_talles c
									ON a.indumentaria_talle_id = c.indumentaria_talle_id
					INNER JOIN indumentarias_colores d
									ON a.indumentaria_color_id = d.indumentaria_color_id
					INNER JOIN lugares_trabajo e
									ON a.trabajo_id = e.trabajo_id
					INNER JOIN secretarias f
									ON a.secretaria_id = f.secretaria_id
					INNER JOIN legajos_empleado g
									ON a.legempleado_nrodocto = g.legempleado_nrodocto
								 AND a.secretaria_id = ?
								 AND a.trabajo_id = ?
								 AND (a.indumentaria_entrega_estado = 2
									OR a.indumentaria_entrega_estado = 3)
								 AND a.indumentaria_entrega_fecha
						 BETWEEN ?
						     AND ?
						ORDER BY a.indumentaria_entrega_fecha,
								     a.indumentaria_orden_id';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $secretaria, PDO::PARAM_STR);
			$dec->bindValue(2, $ltrabajo, PDO::PARAM_STR);
			$dec->bindValue(3, $fechainicio, PDO::PARAM_STR);
			$dec->bindValue(4, $fechafinal, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function IndumentariasEntregasListarXFechaXLTrabajo($fechainicio, $fechafinal, $ltrabajo){
		try{

			$sql = 'SELECT *
								FROM indumentarias_entregas a
					INNER JOIN indumentarias b
					 			  ON a.indumentaria_id = b.indumentaria_id
					INNER JOIN indumentarias_talles c
									ON a.indumentaria_talle_id = c.indumentaria_talle_id
					INNER JOIN indumentarias_colores d
									ON a.indumentaria_color_id = d.indumentaria_color_id
					INNER JOIN lugares_trabajo e
									ON a.trabajo_id = e.trabajo_id
					INNER JOIN secretarias f
									ON a.secretaria_id = f.secretaria_id
					INNER JOIN legajos_empleado g
									ON a.legempleado_nrodocto = g.legempleado_nrodocto
								 AND a.trabajo_id = ?
								 AND (a.indumentaria_entrega_estado = 2
									OR a.indumentaria_entrega_estado = 3)
								 AND a.indumentaria_entrega_fecha
						 BETWEEN ?
						     AND ?
						ORDER BY a.indumentaria_entrega_fecha,
								     a.indumentaria_orden_id';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $ltrabajo, PDO::PARAM_STR);
			$dec->bindValue(2, $fechainicio, PDO::PARAM_STR);
			$dec->bindValue(3, $fechafinal, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function IndumentariasEntregasListarFil($indumentariatipo, $nrodocto, $fechainicio, $fechafinal){
		try{

			$sql = 'SELECT *
								FROM indumentarias_entregas a
					INNER JOIN indumentarias b
					 			  ON a.indumentaria_id = b.indumentaria_id
					INNER JOIN indumentarias_talles c
									ON a.indumentaria_talle_id = c.indumentaria_talle_id
					INNER JOIN indumentarias_colores d
									ON a.indumentaria_color_id = d.indumentaria_color_id
							 WHERE a.indumentaria_id = ?
							 	 AND a.legempleado_nrodocto = ?
								 AND (a.indumentaria_entrega_estado = 2
									OR a.indumentaria_entrega_estado = 3)
								 AND a.indumentaria_entrega_fecha
						 BETWEEN ?
						     AND ?
						ORDER BY a.indumentaria_entrega_fecha,
								     a.indumentaria_orden_id';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $indumentariatipo, PDO::PARAM_STR);
			$dec->bindValue(2, $nrodocto, PDO::PARAM_STR);
			$dec->bindValue(3, $fechainicio, PDO::PARAM_STR);
			$dec->bindValue(4, $fechafinal, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function IndumentariaObtener($indumentariaid){
		try{

			$sql = 'SELECT *
								FROM indumentarias
							 WHERE indumentaria_id = ?
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $indumentariaid, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function IndumentariaTalleListar(){
		try{

			$sql = $this->cn->prepare("SELECT *
																	 FROM indumentarias_talles a
														 INNER JOIN indumentarias b
									 					 			   ON a.indumentaria_id = b.indumentaria_id
																	WHERE a.indumentaria_talle_estado = 1
															 ORDER BY b.indumentaria_nombre,
															 					a.indumentaria_talle_nombre");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function IndumentariaTalleObtener($talleid){
		try{

			$sql = 'SELECT *
								FROM indumentarias_talles
							 WHERE indumentaria_talle_id = ?
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $talleid, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function IndumentariacolorObtener($colorid){
		try{

			$sql = 'SELECT *
								FROM indumentarias_colores
							 WHERE indumentaria_color_id = ?
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $colorid, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function LugarTrabajoObtener($trabajoid){
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
	public function LugaresTrabajoListar(){
		try{
			$sql = $this->cn->prepare("SELECT *
																	 FROM lugares_trabajo
																	WHERE trabajo_activo = 1
															 ORDER BY trabajo_nombre");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_OBJ);
		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function IndumentariaTipoGuardarExe($data){
		try{

			$sql = 'INSERT INTO indumentarias (indumentaria_nombre,
																			 	 indumentaria_estado)
																  VALUES(:indumentarianombre,
																				 1)';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(':indumentarianombre', $data->TipoIndumentarianombre, PDO::PARAM_STR);
			$dec->execute();
			//----------------obtner ultimo id Insertado -----------
			$ultimoid = $this->cn->lastInsertId();
			// ---------------Insert auditoria indumentarias ------------
			$sql = 'SELECT *
								FROM indumentarias
							 WHERE indumentaria_id = ?
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $ultimoid, PDO::PARAM_STR);
			$dec->execute();
			$row = $dec->fetch(PDO::FETCH_OBJ);
			//-----------Informacion para auditoria ---------------
			$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];
			$ippublica = $_SERVER["REMOTE_ADDR"];
			$pcnombre = gethostbyaddr($_SERVER['REMOTE_ADDR']);
			$pcinformacion = $_SERVER['HTTP_USER_AGENT'];

			$sql ='INSERT INTO aud_indumentarias(AUD_indumentaria_id,
																					 AUD_indumentaria_nombre,
																					 AUD_indumentaria_estado,
																				   AUD_indumentaria_ippublica,
																				 	 AUD_indumentaria_pcnombre,
																					 AUD_indumentaria_pcinformacion,
																					 AUD_indumentaria_accion,
																					 AUD_indumentaria_observacion,
																					 AUD_indumentaria_datetime,
																					 AUD_indumentaria_usuario)
																	 VALUES (:indid,
																					 :indnombre,
																					 :indestado,
																					 :indippublica,
																					 :indpcnombre,
																					 :indpcinformacion,
																					 "INSERT",
																					 "",
																					 NOW(),
																					 :indusuario)';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(':indid', $row->indumentaria_id, PDO::PARAM_STR);
			$dec->bindValue(':indnombre', $row->indumentaria_nombre, PDO::PARAM_STR);
			$dec->bindValue(':indestado', $row->indumentaria_estado, PDO::PARAM_STR);
			$dec->bindValue(':indippublica', $ippublica, PDO::PARAM_STR);
			$dec->bindValue(':indpcnombre', $pcnombre, PDO::PARAM_STR);
			$dec->bindValue(':indpcinformacion', $pcinformacion, PDO::PARAM_STR);
			$dec->bindValue(':indusuario', $usuario, PDO::PARAM_STR);
			$dec->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function IndumentariaTipoActualizar($data){
		try{

			$sql = 'UPDATE indumentarias
								 SET indumentaria_nombre = ?
							 WHERE indumentaria_id = ?';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $data->TipoIndumentarianombre, PDO::PARAM_STR);
			$dec->bindValue(2, $data->TipoIndumentariaid, PDO::PARAM_STR);
			$dec->execute();
			// ---------------Update auditoria indumentarias ------------
			$sql = 'SELECT *
								FROM indumentarias
							 WHERE indumentaria_id = ?
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $data->TipoIndumentariaid, PDO::PARAM_STR);
			$dec->execute();
			$row = $dec->fetch(PDO::FETCH_OBJ);
			//-----------Informacion para auditoria ---------------
			$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];
			$ippublica = $_SERVER["REMOTE_ADDR"];
			$pcnombre = gethostbyaddr($_SERVER['REMOTE_ADDR']);
			$pcinformacion = $_SERVER['HTTP_USER_AGENT'];

			$sql ='INSERT INTO aud_indumentarias(AUD_indumentaria_id,
																					 AUD_indumentaria_nombre,
																					 AUD_indumentaria_estado,
																				   AUD_indumentaria_ippublica,
																				 	 AUD_indumentaria_pcnombre,
																					 AUD_indumentaria_pcinformacion,
																					 AUD_indumentaria_accion,
																					 AUD_indumentaria_observacion,
																					 AUD_indumentaria_datetime,
																					 AUD_indumentaria_usuario)
																	 VALUES (:indid,
																					 :indnombre,
																					 :indestado,
																					 :indippublica,
																					 :indpcnombre,
																					 :indpcinformacion,
																					 "UPDATE",
																					 "",
																					 NOW(),
																					 :indusuario)';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(':indid', $row->indumentaria_id, PDO::PARAM_STR);
			$dec->bindValue(':indnombre', $row->indumentaria_nombre, PDO::PARAM_STR);
			$dec->bindValue(':indestado', $row->indumentaria_estado, PDO::PARAM_STR);
			$dec->bindValue(':indippublica', $ippublica, PDO::PARAM_STR);
			$dec->bindValue(':indpcnombre', $pcnombre, PDO::PARAM_STR);
			$dec->bindValue(':indpcinformacion', $pcinformacion, PDO::PARAM_STR);
			$dec->bindValue(':indusuario', $usuario, PDO::PARAM_STR);
			$dec->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function IndumentariaTipoEliminarExe($data){
		try{

			$sql = 'UPDATE indumentarias
								 SET indumentaria_estado = 0
							 WHERE indumentaria_id = ?';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $data->TipoIndumentariaid, PDO::PARAM_STR);
			$dec->execute();
			// ---------------Update auditoria indumentarias ------------
			$sql = 'SELECT *
								FROM indumentarias
							 WHERE indumentaria_id = ?
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $data->TipoIndumentariaid, PDO::PARAM_STR);
			$dec->execute();
			$row = $dec->fetch(PDO::FETCH_OBJ);
			//-----------Informacion para auditoria ---------------
			$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];
			$ippublica = $_SERVER["REMOTE_ADDR"];
			$pcnombre = gethostbyaddr($_SERVER['REMOTE_ADDR']);
			$pcinformacion = $_SERVER['HTTP_USER_AGENT'];

			$sql ='INSERT INTO aud_indumentarias(AUD_indumentaria_id,
																					 AUD_indumentaria_nombre,
																					 AUD_indumentaria_estado,
																				   AUD_indumentaria_ippublica,
																				 	 AUD_indumentaria_pcnombre,
																					 AUD_indumentaria_pcinformacion,
																					 AUD_indumentaria_accion,
																					 AUD_indumentaria_observacion,
																					 AUD_indumentaria_datetime,
																					 AUD_indumentaria_usuario)
																	 VALUES (:indid,
																					 :indnombre,
																					 :indestado,
																					 :indippublica,
																					 :indpcnombre,
																					 :indpcinformacion,
																					 "DISABLE",
																					 "",
																					 NOW(),
																					 :indusuario)';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(':indid', $row->indumentaria_id, PDO::PARAM_STR);
			$dec->bindValue(':indnombre', $row->indumentaria_nombre, PDO::PARAM_STR);
			$dec->bindValue(':indestado', $row->indumentaria_estado, PDO::PARAM_STR);
			$dec->bindValue(':indippublica', $ippublica, PDO::PARAM_STR);
			$dec->bindValue(':indpcnombre', $pcnombre, PDO::PARAM_STR);
			$dec->bindValue(':indpcinformacion', $pcinformacion, PDO::PARAM_STR);
			$dec->bindValue(':indusuario', $usuario, PDO::PARAM_STR);
			$dec->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function IndumentariaTalleGuardarExe($data){
		try{

			$sql = 'INSERT INTO indumentarias_talles (indumentaria_talle_nombre,
																								indumentaria_id,
																			 	 				indumentaria_talle_estado)
																  			 VALUES(:indumentariatallenombre,
																					 			:indumentariaid,
																				 				1)';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(':indumentariatallenombre', $data->Talleindumentarianombre, PDO::PARAM_STR);
			$dec->bindValue(':indumentariaid', $data->Induementariaid, PDO::PARAM_STR);
			$dec->execute();
			//----------------obtner ultimo id Insertado -----------
			$ultimoid = $this->cn->lastInsertId();
			// ---------------Insert auditoria indumentarias ------------
			$sql = 'SELECT *
								FROM indumentarias_talles
							 WHERE indumentaria_talle_id = ?
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $ultimoid, PDO::PARAM_STR);
			$dec->execute();
			$row = $dec->fetch(PDO::FETCH_OBJ);
			//-----------Informacion para auditoria ---------------
			$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];
			$ippublica = $_SERVER["REMOTE_ADDR"];
			$pcnombre = gethostbyaddr($_SERVER['REMOTE_ADDR']);
			$pcinformacion = $_SERVER['HTTP_USER_AGENT'];

			$sql ='INSERT INTO aud_indumentarias_talles(AUD_indumentaria_talle_id,
																									AUD_indumentaria_id,
																									AUD_indumentaria_talle_nombre,
																									AUD_indumentaria_talle_estado,
																								  AUD_indumentaria_talle_ippublica,
																								 	AUD_indumentaria_talle_pcnombre,
																									AUD_indumentaria_talle_pcinformacion,
																									AUD_indumentaria_talle_accion,
																									AUD_indumentaria_talle_observacion,
																									AUD_indumentaria_talle_datetime,
																									AUD_indumentaria_talle_usuario)
																				   VALUES(:indtalleid,
																								  :indumentariaid,
																								  :indtallenombre,
																								  :indtalleestado,
																									:indtalleippublica,
																									:indtallepcnombre,
																									:indtallepcinformacion,
																								  "INSERT",
																									"",
																								  NOW(),
																								  :indtalleusuario)';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(':indtalleid', $row->indumentaria_talle_id, PDO::PARAM_STR);
			$dec->bindValue(':indumentariaid', $row->indumentaria_id, PDO::PARAM_STR);
			$dec->bindValue(':indtallenombre', $row->indumentaria_talle_nombre, PDO::PARAM_STR);
			$dec->bindValue(':indtalleestado', $row->indumentaria_talle_estado, PDO::PARAM_STR);
			$dec->bindValue(':indtalleippublica', $ippublica, PDO::PARAM_STR);
			$dec->bindValue(':indtallepcnombre', $pcnombre, PDO::PARAM_STR);
			$dec->bindValue(':indtallepcinformacion', $pcinformacion, PDO::PARAM_STR);
			$dec->bindValue(':indtalleusuario', $usuario, PDO::PARAM_STR);
			$dec->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function IndumentariaTalleActualizar($data){
		try{

			$sql = 'UPDATE indumentarias_talles
								 SET indumentaria_talle_nombre = ?,
								 		 indumentaria_id = ?
							 WHERE indumentaria_talle_id = ?';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $data->Talleindumentarianombre, PDO::PARAM_STR);
			$dec->bindValue(2, $data->Induementariaid, PDO::PARAM_STR);
			$dec->bindValue(3, $data->Talleindumentariaid, PDO::PARAM_STR);
			$dec->execute();
			// ---------------Insert auditoria indumentarias ------------
			$sql = 'SELECT *
								FROM indumentarias_talles
							 WHERE indumentaria_talle_id = ?
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $data->Talleindumentariaid, PDO::PARAM_STR);
			$dec->execute();
			$row = $dec->fetch(PDO::FETCH_OBJ);
			//-----------Informacion para auditoria ---------------
			$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];
			$ippublica = $_SERVER["REMOTE_ADDR"];
			$pcnombre = gethostbyaddr($_SERVER['REMOTE_ADDR']);
			$pcinformacion = $_SERVER['HTTP_USER_AGENT'];

			$sql ='INSERT INTO aud_indumentarias_talles(AUD_indumentaria_talle_id,
																									AUD_indumentaria_id,
																									AUD_indumentaria_talle_nombre,
																									AUD_indumentaria_talle_estado,
																								  AUD_indumentaria_talle_ippublica,
																								 	AUD_indumentaria_talle_pcnombre,
																									AUD_indumentaria_talle_pcinformacion,
																									AUD_indumentaria_talle_accion,
																									AUD_indumentaria_talle_observacion,
																									AUD_indumentaria_talle_datetime,
																									AUD_indumentaria_talle_usuario)
																				   VALUES(:indtalleid,
																								  :indumentariaid,
																								  :indtallenombre,
																								  :indtalleestado,
																									:indtalleippublica,
																									:indtallepcnombre,
																									:indtallepcinformacion,
																								  "UPDATE",
																									"",
																								  NOW(),
																								  :indtalleusuario)';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(':indtalleid', $row->indumentaria_talle_id, PDO::PARAM_STR);
			$dec->bindValue(':indumentariaid', $row->indumentaria_id, PDO::PARAM_STR);
			$dec->bindValue(':indtallenombre', $row->indumentaria_talle_nombre, PDO::PARAM_STR);
			$dec->bindValue(':indtalleestado', $row->indumentaria_talle_estado, PDO::PARAM_STR);
			$dec->bindValue(':indtalleippublica', $ippublica, PDO::PARAM_STR);
			$dec->bindValue(':indtallepcnombre', $pcnombre, PDO::PARAM_STR);
			$dec->bindValue(':indtallepcinformacion', $pcinformacion, PDO::PARAM_STR);
			$dec->bindValue(':indtalleusuario', $usuario, PDO::PARAM_STR);
			$dec->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function IndumentariaTalleEliminarExe($data){
		try{

			$sql = 'UPDATE indumentarias_talles
								 SET indumentaria_talle_estado = 0
							 WHERE indumentaria_talle_id = ?';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $data->TalleIndumentariaid, PDO::PARAM_STR);
			$dec->execute();
			// ---------------Insert auditoria indumentarias ------------
			$sql = 'SELECT *
								FROM indumentarias_talles
							 WHERE indumentaria_talle_id = ?
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $data->TalleIndumentariaid, PDO::PARAM_STR);
			$dec->execute();
			$row = $dec->fetch(PDO::FETCH_OBJ);
			//-----------Informacion para auditoria ---------------
			$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];
			$ippublica = $_SERVER["REMOTE_ADDR"];
			$pcnombre = gethostbyaddr($_SERVER['REMOTE_ADDR']);
			$pcinformacion = $_SERVER['HTTP_USER_AGENT'];

			$sql ='INSERT INTO aud_indumentarias_talles(AUD_indumentaria_talle_id,
																									AUD_indumentaria_id,
																									AUD_indumentaria_talle_nombre,
																									AUD_indumentaria_talle_estado,
																								  AUD_indumentaria_talle_ippublica,
																								 	AUD_indumentaria_talle_pcnombre,
																									AUD_indumentaria_talle_pcinformacion,
																									AUD_indumentaria_talle_accion,
																									AUD_indumentaria_talle_observacion,
																									AUD_indumentaria_talle_datetime,
																									AUD_indumentaria_talle_usuario)
																				   VALUES(:indtalleid,
																								  :indumentariaid,
																								  :indtallenombre,
																								  :indtalleestado,
																									:indtalleippublica,
																									:indtallepcnombre,
																									:indtallepcinformacion,
																								  "DISABLE",
																									"",
																								  NOW(),
																								  :indtalleusuario)';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(':indtalleid', $row->indumentaria_talle_id, PDO::PARAM_STR);
			$dec->bindValue(':indumentariaid', $row->indumentaria_id, PDO::PARAM_STR);
			$dec->bindValue(':indtallenombre', $row->indumentaria_talle_nombre, PDO::PARAM_STR);
			$dec->bindValue(':indtalleestado', $row->indumentaria_talle_estado, PDO::PARAM_STR);
			$dec->bindValue(':indtalleippublica', $ippublica, PDO::PARAM_STR);
			$dec->bindValue(':indtallepcnombre', $pcnombre, PDO::PARAM_STR);
			$dec->bindValue(':indtallepcinformacion', $pcinformacion, PDO::PARAM_STR);
			$dec->bindValue(':indtalleusuario', $usuario, PDO::PARAM_STR);
			$dec->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function IndumentariaColorGuardarExe($data){
		try{

			$sql = 'INSERT INTO indumentarias_colores (indumentaria_color_nombre,
																			 	 				 indumentaria_color_estado)
																  			  VALUES(:indumentariacolornombre,
																				 				 1)';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(':indumentariacolornombre', $data->Colorindumentarianombre, PDO::PARAM_STR);
			$dec->execute();
			//----------------obtner ultimo id Insertado -----------
			$ultimoid = $this->cn->lastInsertId();
			// ---------------Insert auditoria indumentarias ------------
			$sql = 'SELECT *
								FROM indumentarias_colores
							 WHERE indumentaria_color_id = ?
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $ultimoid, PDO::PARAM_STR);
			$dec->execute();
			$row = $dec->fetch(PDO::FETCH_OBJ);
			//-----------Informacion para auditoria ---------------
			$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];
			$ippublica = $_SERVER["REMOTE_ADDR"];
			$pcnombre = gethostbyaddr($_SERVER['REMOTE_ADDR']);
			$pcinformacion = $_SERVER['HTTP_USER_AGENT'];

			$sql ='INSERT INTO aud_indumentarias_colores(AUD_indumentaria_color_id,
																									 AUD_indumentaria_color_nombre,
																									 AUD_indumentaria_color_estado,
																								   AUD_indumentaria_color_ippublica,
																								 	 AUD_indumentaria_color_pcnombre,
																									 AUD_indumentaria_color_pcinformacion,
																									 AUD_indumentaria_color_accion,
																									 AUD_indumentaria_color_observacion,
																									 AUD_indumentaria_color_datetime,
																									 AUD_indumentaria_color_usuario)
																					 VALUES (:indcolorid,
																									 :indcolornombre,
																									 :indcolorestado,
																									 :indcolorippublica,
																									 :indcolorpcnombre,
																									 :indcolorpcinformacion,
																									 "INSERT",
																									 "",
																									 NOW(),
																									 :indcolorusuario)';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(':indcolorid', $row->indumentaria_color_id, PDO::PARAM_STR);
			$dec->bindValue(':indcolornombre', $row->indumentaria_color_nombre, PDO::PARAM_STR);
			$dec->bindValue(':indcolorestado', $row->indumentaria_color_estado, PDO::PARAM_STR);
			$dec->bindValue(':indcolorippublica', $ippublica, PDO::PARAM_STR);
			$dec->bindValue(':indcolorpcnombre', $pcnombre, PDO::PARAM_STR);
			$dec->bindValue(':indcolorpcinformacion', $pcinformacion, PDO::PARAM_STR);
			$dec->bindValue(':indcolorusuario', $usuario, PDO::PARAM_STR);
			$dec->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function IndumentariaColorActualizar($data){
		try{

			$sql = 'UPDATE indumentarias_colores
								 SET indumentaria_color_nombre = ?
							 WHERE indumentaria_color_id = ?';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $data->Colorindumentarianombre, PDO::PARAM_STR);
			$dec->bindValue(2, $data->Colorindumentariaid, PDO::PARAM_STR);
			$dec->execute();
			// ---------------Insert auditoria indumentarias ------------
			$sql = 'SELECT *
								FROM indumentarias_colores
							 WHERE indumentaria_color_id = ?
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $data->Colorindumentariaid, PDO::PARAM_STR);
			$dec->execute();
			$row = $dec->fetch(PDO::FETCH_OBJ);
			//-----------Informacion para auditoria ---------------
			$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];
			$ippublica = $_SERVER["REMOTE_ADDR"];
			$pcnombre = gethostbyaddr($_SERVER['REMOTE_ADDR']);
			$pcinformacion = $_SERVER['HTTP_USER_AGENT'];

			$sql ='INSERT INTO aud_indumentarias_colores(AUD_indumentaria_color_id,
																									 AUD_indumentaria_color_nombre,
																									 AUD_indumentaria_color_estado,
																								   AUD_indumentaria_color_ippublica,
																								 	 AUD_indumentaria_color_pcnombre,
																									 AUD_indumentaria_color_pcinformacion,
																									 AUD_indumentaria_color_accion,
																									 AUD_indumentaria_color_observacion,
																									 AUD_indumentaria_color_datetime,
																									 AUD_indumentaria_color_usuario)
																					 VALUES (:indcolorid,
																									 :indcolornombre,
																									 :indcolorestado,
																									 :indcolorippublica,
																									 :indcolorpcnombre,
																									 :indcolorpcinformacion,
																									 "UPDATE",
																									 "",
																									 NOW(),
																									 :indcolorusuario)';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(':indcolorid', $row->indumentaria_color_id, PDO::PARAM_STR);
			$dec->bindValue(':indcolornombre', $row->indumentaria_color_nombre, PDO::PARAM_STR);
			$dec->bindValue(':indcolorestado', $row->indumentaria_color_estado, PDO::PARAM_STR);
			$dec->bindValue(':indcolorippublica', $ippublica, PDO::PARAM_STR);
			$dec->bindValue(':indcolorpcnombre', $pcnombre, PDO::PARAM_STR);
			$dec->bindValue(':indcolorpcinformacion', $pcinformacion, PDO::PARAM_STR);
			$dec->bindValue(':indcolorusuario', $usuario, PDO::PARAM_STR);
			$dec->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function IndumentariaColorEliminarExe($data){
		try{

			$sql = 'UPDATE indumentarias_colores
								 SET indumentaria_color_estado = 0
							 WHERE indumentaria_color_id = ?';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $data->ColorIndumentariaid, PDO::PARAM_STR);
			$dec->execute();
			// ---------------Insert auditoria indumentarias ------------
			$sql = 'SELECT *
								FROM indumentarias_colores
							 WHERE indumentaria_color_id = ?
							 LIMIT 1';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $data->ColorIndumentariaid, PDO::PARAM_STR);
			$dec->execute();
			$row = $dec->fetch(PDO::FETCH_OBJ);
			//-----------Informacion para auditoria ---------------
			$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];
			$ippublica = $_SERVER["REMOTE_ADDR"];
			$pcnombre = gethostbyaddr($_SERVER['REMOTE_ADDR']);
			$pcinformacion = $_SERVER['HTTP_USER_AGENT'];

			$sql ='INSERT INTO aud_indumentarias_colores(AUD_indumentaria_color_id,
																									 AUD_indumentaria_color_nombre,
																									 AUD_indumentaria_color_estado,
																								   AUD_indumentaria_color_ippublica,
																								 	 AUD_indumentaria_color_pcnombre,
																									 AUD_indumentaria_color_pcinformacion,
																									 AUD_indumentaria_color_accion,
																									 AUD_indumentaria_color_observacion,
																									 AUD_indumentaria_color_datetime,
																									 AUD_indumentaria_color_usuario)
																					 VALUES (:indcolorid,
																									 :indcolornombre,
																									 :indcolorestado,
																									 :indcolorippublica,
																									 :indcolorpcnombre,
																									 :indcolorpcinformacion,
																									 "DISABLE",
																									 "",
																									 NOW(),
																									 :indcolorusuario)';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(':indcolorid', $row->indumentaria_color_id, PDO::PARAM_STR);
			$dec->bindValue(':indcolornombre', $row->indumentaria_color_nombre, PDO::PARAM_STR);
			$dec->bindValue(':indcolorestado', $row->indumentaria_color_estado, PDO::PARAM_STR);
			$dec->bindValue(':indcolorippublica', $ippublica, PDO::PARAM_STR);
			$dec->bindValue(':indcolorpcnombre', $pcnombre, PDO::PARAM_STR);
			$dec->bindValue(':indcolorpcinformacion', $pcinformacion, PDO::PARAM_STR);
			$dec->bindValue(':indcolorusuario', $usuario, PDO::PARAM_STR);
			$dec->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function IndumentariaStockListar(){
		try{

			$sql = $this->cn->prepare("SELECT *
																	 FROM indumentarias_stocks a
														 INNER JOIN indumentarias b
									 					 			   ON a.indumentaria_id = b.indumentaria_id
														 INNER JOIN indumentarias_talles c
									 					 			   ON a.indumentaria_talle_id = c.indumentaria_talle_id
														 INNER JOIN indumentarias_colores d
									 					 			   ON a.indumentaria_color_id = d.indumentaria_color_id
																	WHERE a.indumentaria_stock_estado = 1");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function IndumentariaStockGuardarExe($data){
		try{

			$sql = 'INSERT INTO indumentarias_stocks(indumentaria_stock_codigo_barra,
																				 			 indumentaria_id,
																							 indumentaria_talle_id,
																						   indumentaria_color_id,
																						   indumentaria_stock_cantidad,
																						   indumentaria_stock_minimo,
																						   indumentaria_stock_estado)
																				VALUES(:cbarras,
																							 :indumentariaid,
																							 :talleid,
																							 :colorid,
																							 :indumentariac,
																							 :indumentariacmin,
																						 	 1)';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(':cbarras', $data->Stockindumentariacbarras, PDO::PARAM_STR);
			$dec->bindValue(':indumentariaid', $data->Indumentariaid, PDO::PARAM_STR);
			$dec->bindValue(':talleid', $data->Indumentariatalleid, PDO::PARAM_STR);
			$dec->bindValue(':colorid', $data->Indumentariacolorid, PDO::PARAM_STR);
			$dec->bindValue(':indumentariac', $data->Stockindumentariacantidad, PDO::PARAM_STR);
			$dec->bindValue(':indumentariacmin', $data->Stockindumentariacantidadmin, PDO::PARAM_STR);
			$dec->execute();
			//----------------obtner ultimo id Insertado -----------
			$ultimoid = $this->cn->lastInsertId();
			//----------auditoria stock ----------
			$sql = 'SELECT *
								FROM indumentarias_stocks
							 WHERE indumentaria_stock_id = ?';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $ultimoid, PDO::PARAM_STR);
			$dec->execute();
			$row = $dec->fetch(PDO::FETCH_OBJ);
			//-----------Informacion para auditoria ---------------
			$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];
			$ippublica = $_SERVER["REMOTE_ADDR"];
			$pcnombre = gethostbyaddr($_SERVER['REMOTE_ADDR']);
			$pcinformacion = $_SERVER['HTTP_USER_AGENT'];

			$sql ='INSERT INTO aud_indumentarias_stocks(AUD_indumentaria_stock_id,
																									AUD_indumentaria_stock_codigo_barra,
																									AUD_indumentaria_id,
																									AUD_indumentaria_talle_id,
																									AUD_indumentaria_color_id,
																									AUD_indumentaria_stock_cantidad,
																									AUD_indumentaria_stock_minimo,
																									AUD_indumentaria_stock_estado,
																									AUD_indumentaria_stock_ippublica,
																									AUD_indumentaria_stock_pcnombre,
																									AUD_indumentaria_stock_pcinformacion,
																									AUD_indumentaria_stock_accion,
																									AUD_indumentaria_stock_datetime,
																									AUD_indumentaria_stock_usuario)
																					 VALUES(:indstockid,
																									:indstockcodb,
																									:indumentariaid,
																									:indumentariatalleid,
																									:indumentariacolorid,
																									:indstockcantidad,
																									:indstockminimo,
																									:indstockestado,
																									:indstockippublica,
																									:indstockpcnombre,
																									:indstockpcinformacion,
																									"INSERT",
																									NOW(),
																									:indstockusuario)';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(':indstockid', $row->indumentaria_stock_id, PDO::PARAM_STR);
			$dec->bindValue(':indstockcodb', $row->indumentaria_stock_codigo_barra, PDO::PARAM_STR);
			$dec->bindValue(':indumentariaid', $row->indumentaria_id, PDO::PARAM_STR);
			$dec->bindValue(':indumentariatalleid', $row->indumentaria_talle_id, PDO::PARAM_STR);
			$dec->bindValue(':indumentariacolorid', $row->indumentaria_color_id, PDO::PARAM_STR);
			$dec->bindValue(':indstockcantidad', $row->indumentaria_stock_cantidad, PDO::PARAM_STR);
			$dec->bindValue(':indstockminimo', $row->indumentaria_stock_minimo, PDO::PARAM_STR);
			$dec->bindValue(':indstockestado', $row->indumentaria_stock_estado, PDO::PARAM_STR);
			$dec->bindValue(':indstockippublica', $ippublica, PDO::PARAM_STR);
			$dec->bindValue(':indstockpcnombre', $pcnombre, PDO::PARAM_STR);
			$dec->bindValue(':indstockpcinformacion', $pcinformacion, PDO::PARAM_STR);
			$dec->bindValue(':indstockusuario', $usuario, PDO::PARAM_STR);
			$dec->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function IndumentariaStockActualizar($data){
		try{

			$sql = 'UPDATE indumentarias_stocks
								 SET indumentaria_stock_codigo_barra = ?,
								 		 indumentaria_stock_cantidad = ?,
								 	 	 indumentaria_stock_minimo = ?
							 WHERE indumentaria_stock_id = ?';

			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $data->Stockindumentariacbarras, PDO::PARAM_STR);
			$dec->bindValue(2, $data->Stockindumentariacantidad, PDO::PARAM_STR);
			$dec->bindValue(3, $data->Stockindumentariacantidadmin, PDO::PARAM_STR);
			$dec->bindValue(4, $data->Stockindumentariaid, PDO::PARAM_STR);
			$dec->execute();
			//----------auditoria stock ----------
			$sql = 'SELECT *
								FROM indumentarias_stocks
							 WHERE indumentaria_stock_id = ?';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $data->Stockindumentariaid, PDO::PARAM_STR);
			$dec->execute();
			$row = $dec->fetch(PDO::FETCH_OBJ);
			//-----------Informacion para auditoria ---------------
			$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];
			$ippublica = $_SERVER["REMOTE_ADDR"];
			$pcnombre = gethostbyaddr($_SERVER['REMOTE_ADDR']);
			$pcinformacion = $_SERVER['HTTP_USER_AGENT'];

			$sql ='INSERT INTO aud_indumentarias_stocks(AUD_indumentaria_stock_id,
																									AUD_indumentaria_stock_codigo_barra,
																									AUD_indumentaria_id,
																									AUD_indumentaria_talle_id,
																									AUD_indumentaria_color_id,
																									AUD_indumentaria_stock_cantidad,
																									AUD_indumentaria_stock_minimo,
																									AUD_indumentaria_stock_estado,
																									AUD_indumentaria_stock_ippublica,
																									AUD_indumentaria_stock_pcnombre,
																									AUD_indumentaria_stock_pcinformacion,
																									AUD_indumentaria_stock_accion,
																									AUD_indumentaria_stock_datetime,
																									AUD_indumentaria_stock_usuario)
																					 VALUES(:indstockid,
																									:indstockcodb,
																									:indumentariaid,
																									:indumentariatalleid,
																									:indumentariacolorid,
																									:indstockcantidad,
																									:indstockminimo,
																									:indstockestado,
																									:indstockippublica,
																									:indstockpcnombre,
																									:indstockpcinformacion,
																									"UPDATE",
																									NOW(),
																									:indstockusuario)';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(':indstockid', $row->indumentaria_stock_id, PDO::PARAM_STR);
			$dec->bindValue(':indstockcodb', $row->indumentaria_stock_codigo_barra, PDO::PARAM_STR);
			$dec->bindValue(':indumentariaid', $row->indumentaria_id, PDO::PARAM_STR);
			$dec->bindValue(':indumentariatalleid', $row->indumentaria_talle_id, PDO::PARAM_STR);
			$dec->bindValue(':indumentariacolorid', $row->indumentaria_color_id, PDO::PARAM_STR);
			$dec->bindValue(':indstockcantidad', $row->indumentaria_stock_cantidad, PDO::PARAM_STR);
			$dec->bindValue(':indstockminimo', $row->indumentaria_stock_minimo, PDO::PARAM_STR);
			$dec->bindValue(':indstockestado', $row->indumentaria_stock_estado, PDO::PARAM_STR);
			$dec->bindValue(':indstockippublica', $ippublica, PDO::PARAM_STR);
			$dec->bindValue(':indstockpcnombre', $pcnombre, PDO::PARAM_STR);
			$dec->bindValue(':indstockpcinformacion', $pcinformacion, PDO::PARAM_STR);
			$dec->bindValue(':indstockusuario', $usuario, PDO::PARAM_STR);
			$dec->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function IndumentariaStockObtener($data){
		try{

			$sql = 'SELECT *
								FROM indumentarias_stocks
							 WHERE indumentaria_id = ?
							 	 AND indumentaria_talle_id = ?
								 AND indumentaria_color_id = ?
							 LIMIT 1';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Indumentariaidf, PDO::PARAM_STR);
			$stm->bindValue(2, $data->Indumentariatalleidf, PDO::PARAM_STR);
			$stm->bindValue(3, $data->Indumentariacoloridf, PDO::PARAM_STR);
			$stm->execute();
			return $stm->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function OrdenPendienteObtener($ordennumero){
		try{

			$sql = 'SELECT *
								FROM indumentarias_entregas a
					INNER JOIN indumentarias b
					        ON a.indumentaria_id = b.indumentaria_id
				  INNER JOIN indumentarias_talles c
					 				ON a.indumentaria_talle_id = c.indumentaria_talle_id
					INNER JOIN indumentarias_colores d
									ON a.indumentaria_color_id = d.indumentaria_color_id
							 WHERE a.indumentaria_orden_id = ?
							   AND (a.indumentaria_entrega_estado = 2
									OR a.indumentaria_entrega_estado = 3)';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $ordennumero, PDO::PARAM_STR);
			$stm->execute();
			return $stm->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
}
