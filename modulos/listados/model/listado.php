<?php
class listado{

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


	public function ListarTotales($per){
		try{

			$sql = 'SELECT COUNT(cjmdg_detsueldo_codconcep) cantidad,SUM(cjmdg_detsueldo_importe) total,cjmdg_detsueldo_detconcep detalle,cjmdg_detsueldo_codconcep codigo ,impacto,liqcodtipo_id_jub
			FROM cjmdg_cabsueldo a,cjmdg_detsueldo b,liquidaciones_codigo_jub c
			WHERE a.cjmdg_cabsueldo_nroleg2=b.cjmdg_detsueldo_nroleg
			AND a.periodo_id = ?
			AND cjmdg_detsueldo_codconcep=c.liqcod_jub_id
			GROUP BY cjmdg_detsueldo_codconcep
			ORDER BY c.liqcod_jub_id,cjmdg_detsueldo_codconcep
			';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $per, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}

	public function ListarTotalesxCat($per){
		try{
			$sql = 'SELECT COUNT(b.categoria_jub_id) cant_cat,SUM(cjmdg_detsueldo_importe) importe_cat,categoria_jub_descripcion
			FROM categoria_jub a,cjmdg_cabsueldo b,cjmdg_detsueldo c
			WHERE a.categoria_jub_id=b.categoria_jub_id
			AND b.periodo_id=?
			AND cjmdg_detsueldo_codconcep=1
			GROUP BY b.categoria_jub_id
			';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $per, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function RegistrarF($data){
		try
		{
			//------------ Insert listado -------------------
			$sql = 'INSERT INTO listados (listado_fecha,listado_observacion,listado_activo)
			VALUES(?, ?, ?)';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->listadofecha, PDO::PARAM_STR);
			$stm->bindValue(2, $data->listadoobservacion, PDO::PARAM_STR);
			$stm->bindValue(3, $data->listadoactivo, PDO::PARAM_STR);
			$stm->execute();
			//----------------obtner ultimo id Insertado -----------
			$ultimoid = $this->cn->lastInsertId();
			// ------Insert auditoria listado--------
			$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];
			$sql ='INSERT INTO aud_listados (AUD_listado_id,AUD_listado_fecha,AUD_listado_observacion,AUD_listado_activo,AUD_accion,AUD_datetime,AUD_usuario) VALUES (?, ?, ?, ?, "INSERT", NOW(), ?)';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $ultimoid, PDO::PARAM_STR);
			$stm->bindValue(2, $data->listadofecha, PDO::PARAM_STR);
			$stm->bindValue(3, $data->listadoobservacion, PDO::PARAM_STR);
			$stm->bindValue(4, $data->listadoactivo, PDO::PARAM_STR);
			$stm->bindValue(5, $usuario, PDO::PARAM_STR);
			$stm->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ActualizarF($data){
		try{
			// --------------- Modificacion de listados--------------------
			$sql = 'UPDATE listados SET listado_fecha = ?, listado_observacion = ? WHERE listado_id = ?';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->listadofecha, PDO::PARAM_STR);
			$stm->bindValue(2, $data->listadoobservacion, PDO::PARAM_STR);
			$stm->bindValue(3, $data->listadoid, PDO::PARAM_STR);
			$stm->execute();
			//-----Insert de auditoria modificacion de listados -----
			$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];
			$sql ='INSERT INTO aud_listados (AUD_listado_id,AUD_listado_fecha,AUD_listado_observacion,AUD_listado_activo,AUD_accion,AUD_datetime,AUD_usuario) VALUES (?, ?, ?, ?, "UPDATE", NOW(), ?)';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->listadoid, PDO::PARAM_STR);
			$stm->bindValue(2, $data->listadofecha, PDO::PARAM_STR);
			$stm->bindValue(3, $data->listadoobservacion, PDO::PARAM_STR);
			$stm->bindValue(4, $data->listadoactivo, PDO::PARAM_STR);
			$stm->bindValue(5, $usuario, PDO::PARAM_STR);
			$stm->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function DeshabilitarFer($data){
		try{
			//---------- Deshabilitar listado -------
			$sql = 'UPDATE listados SET listado_activo = ? WHERE listado_id = ?';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->listadoactivo, PDO::PARAM_STR);
			$stm->bindValue(2, $data->listadoid, PDO::PARAM_STR);
			$stm->execute();
			//------------- auditoria -----------------
			$sql = 'SELECT * FROM listados WHERE listado_id = ?';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->listadoid, PDO::PARAM_STR);
			$stm->execute();
			$row = $stm->fetch(PDO::FETCH_OBJ);
			//--------Insert de auditoria Deshabilitar listado-----
			$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];
			$sql ='INSERT INTO aud_listados (AUD_listado_id,AUD_listado_fecha,AUD_listado_observacion,AUD_listado_activo,AUD_accion,AUD_datetime,AUD_usuario) VALUES (?, ?, ?, ?, "DISABLE", NOW(), ?)';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $row->listado_id, PDO::PARAM_STR);
			$stm->bindValue(2, $row->listado_fecha, PDO::PARAM_STR);
			$stm->bindValue(3, $row->listado_observacion, PDO::PARAM_STR);
			$stm->bindValue(4, $row->listado_activo, PDO::PARAM_STR);
			$stm->bindValue(5, $usuario, PDO::PARAM_STR);
			$stm->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
}
