<?php
class Escuela
{

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
	//-------- Listado de escuelas -------------
	public function ListarEscuelas(){
		try{
			$sindatos = 1;
			$activo = 1;
			$sql = 'SELECT * FROM escuelas WHERE escuela_id != ? AND escuela_activo = ? ORDER BY Escuela_nombre';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $sindatos, PDO::PARAM_STR);
			$stm->bindValue(2, $activo, PDO::PARAM_STR);
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	//----------- Insert de escuela--------------
	public function RegistrarE($data){
		try{
			$sql = 'INSERT INTO escuelas (escuela_numero,escuela_nombre,escuela_direccion,escuela_direcnro,escuela_direcpiso,escuela_telefono,escuela_email,pais_id,provincia_id,departamento_id,localidad_id,escuela_codpostal,escuela_activo)
			VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Escnro, PDO::PARAM_STR);
			$stm->bindValue(2, $data->Escnombre, PDO::PARAM_STR);
			$stm->bindValue(3, $data->Escdireccion, PDO::PARAM_STR);
			$stm->bindValue(4, $data->Escdirecnro, PDO::PARAM_STR);
			$stm->bindValue(5, $data->Escdirecpiso, PDO::PARAM_STR);
			$stm->bindValue(6, $data->Esctelefono, PDO::PARAM_STR);
			$stm->bindValue(7, $data->Escemail, PDO::PARAM_STR);
			$stm->bindValue(8, $data->Escpais, PDO::PARAM_STR);
			$stm->bindValue(9, $data->Escprovincia, PDO::PARAM_STR);
			$stm->bindValue(10, $data->Escdepartamento, PDO::PARAM_STR);
			$stm->bindValue(11, $data->Esclocalidad, PDO::PARAM_STR);
			$stm->bindValue(12, $data->Esccpostal, PDO::PARAM_STR);
			$stm->bindValue(13, $data->Activo, PDO::PARAM_STR);
			$stm->execute();
			//----------------obtner ultimo id Insertado -----------
			$ultimoid = $this->cn->lastInsertId();
			// ---------------Insert auditoria Escuelas ------------
			$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];
			$sql ='INSERT INTO aud_escuelas (AUD_escuela_id,AUD_escuela_numero,AUD_escuela_nombre,AUD_escuela_direccion,AUD_escuela_direcnro,AUD_escuela_direcpiso,AUD_escuela_telefono,AUD_escuela_email,AUD_pais_id,AUD_provincia_id,AUD_departamento_id,AUD_localidad_id,AUD_escuela_codpostal,AUD_escuela_activo,AUD_accion,AUD_datetime,AUD_usuario) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, "INSERT", NOW(), ?)';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $ultimoid, PDO::PARAM_STR);
			$stm->bindValue(2, $data->Escnro, PDO::PARAM_STR);
			$stm->bindValue(3, $data->Escnombre, PDO::PARAM_STR);
			$stm->bindValue(4, $data->Escdireccion, PDO::PARAM_STR);
			$stm->bindValue(5, $data->Escdirecnro, PDO::PARAM_STR);
			$stm->bindValue(6, $data->Escdirecpiso, PDO::PARAM_STR);
			$stm->bindValue(7, $data->Esctelefono, PDO::PARAM_STR);
			$stm->bindValue(8, $data->Escemail, PDO::PARAM_STR);
			$stm->bindValue(9, $data->Escpais, PDO::PARAM_STR);
			$stm->bindValue(10, $data->Escprovincia, PDO::PARAM_STR);
			$stm->bindValue(11, $data->Escdepartamento, PDO::PARAM_STR);
			$stm->bindValue(12, $data->Esclocalidad, PDO::PARAM_STR);
			$stm->bindValue(13, $data->Esccpostal, PDO::PARAM_STR);
			$stm->bindValue(14, $data->Activo, PDO::PARAM_STR);
			$stm->bindValue(15, $usuario, PDO::PARAM_STR);
			$stm->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	// ------------ Modificacion de escuela ----------
	public function ActualizarE($data){
		try{
			//---------- Modificacion de escuela ---------------------
			$sql = 'UPDATE escuelas SET escuela_numero = ?, escuela_nombre = ?, escuela_direccion = ?, escuela_direcnro = ?, escuela_direcpiso = ?, escuela_telefono = ?, escuela_email = ?, pais_id = ?, provincia_id = ?, departamento_id = ?, localidad_id = ?, escuela_codpostal = ? WHERE escuela_id = ?';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Escnro, PDO::PARAM_STR);
			$stm->bindValue(2, $data->Escnombre, PDO::PARAM_STR);
			$stm->bindValue(3, $data->Escdireccion, PDO::PARAM_STR);
			$stm->bindValue(4, $data->Escdirecnro, PDO::PARAM_STR);
			$stm->bindValue(5, $data->Escdirecpiso, PDO::PARAM_STR);
			$stm->bindValue(6, $data->Esctelefono, PDO::PARAM_STR);
			$stm->bindValue(7, $data->Escemail, PDO::PARAM_STR);
			$stm->bindValue(8, $data->Escpais, PDO::PARAM_STR);
			$stm->bindValue(9, $data->Escprovincia, PDO::PARAM_STR);
			$stm->bindValue(10, $data->Escdepartamento, PDO::PARAM_STR);
			$stm->bindValue(11, $data->Esclocalidad, PDO::PARAM_STR);
			$stm->bindValue(12, $data->Esccpostal, PDO::PARAM_STR);
			$stm->bindValue(13, $data->Id, PDO::PARAM_STR);
			$stm->execute();
			//----------Auditoria modificacion de escuela -----
			$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];
			$sql ='INSERT INTO aud_escuelas (AUD_escuela_id,AUD_escuela_numero,AUD_escuela_nombre,AUD_escuela_direccion,AUD_escuela_direcnro,AUD_escuela_direcpiso,AUD_escuela_telefono,AUD_escuela_email,AUD_pais_id,AUD_provincia_id,AUD_departamento_id,AUD_localidad_id,AUD_escuela_codpostal,AUD_escuela_activo,AUD_accion,AUD_datetime,AUD_usuario) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, "UPDATE", NOW(), ?)';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Id, PDO::PARAM_STR);
			$stm->bindValue(2, $data->Escnro, PDO::PARAM_STR);
			$stm->bindValue(3, $data->Escnombre, PDO::PARAM_STR);
			$stm->bindValue(4, $data->Escdireccion, PDO::PARAM_STR);
			$stm->bindValue(5, $data->Escdirecnro, PDO::PARAM_STR);
			$stm->bindValue(6, $data->Escdirecpiso, PDO::PARAM_STR);
			$stm->bindValue(7, $data->Esctelefono, PDO::PARAM_STR);
			$stm->bindValue(8, $data->Escemail, PDO::PARAM_STR);
			$stm->bindValue(9, $data->Escpais, PDO::PARAM_STR);
			$stm->bindValue(10, $data->Escprovincia, PDO::PARAM_STR);
			$stm->bindValue(11, $data->Escdepartamento, PDO::PARAM_STR);
			$stm->bindValue(12, $data->Esclocalidad, PDO::PARAM_STR);
			$stm->bindValue(13, $data->Esccpostal, PDO::PARAM_STR);
			$stm->bindValue(14, $data->Activo, PDO::PARAM_STR);
			$stm->bindValue(15, $usuario, PDO::PARAM_STR);
			$stm->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	//----------- Deshabilitar escuela--------
	public function DeshabilitarEsc($data){
		try{
			$sql = 'UPDATE escuelas SET escuela_activo = ? WHERE escuela_id = ?';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Activo, PDO::PARAM_STR);
			$stm->bindValue(2, $data->Id, PDO::PARAM_STR);
			$stm->execute();
			// -----------Obtener Escuela para auditoria -----------
			$sql = 'SELECT * FROM escuelas WHERE escuela_id = ?';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Id, PDO::PARAM_STR);
			$stm->execute();
			$row = $stm->fetch(PDO::FETCH_OBJ);
			//----------Insert de auditoria Deshabilitar escuela -----
			$usuario = $_SESSION["usuario_apellido"].", ".$_SESSION["usuario_nombres"];
			$sql ='INSERT INTO aud_escuelas (AUD_escuela_id,AUD_escuela_numero,AUD_escuela_nombre,AUD_escuela_direccion,AUD_escuela_direcnro,AUD_escuela_direcpiso,AUD_escuela_telefono,AUD_escuela_email,AUD_pais_id,AUD_provincia_id,AUD_departamento_id,AUD_localidad_id,AUD_escuela_codpostal,AUD_escuela_activo,AUD_accion,AUD_datetime,AUD_usuario) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, "DISABLE", NOW(), ?)';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $row->escuela_id, PDO::PARAM_STR);
			$stm->bindValue(2, $row->escuela_numero, PDO::PARAM_STR);
			$stm->bindValue(3, $row->escuela_nombre, PDO::PARAM_STR);
			$stm->bindValue(4, $row->escuela_direccion, PDO::PARAM_STR);
			$stm->bindValue(5, $row->escuela_direcnro, PDO::PARAM_STR);
			$stm->bindValue(6, $row->escuela_direcpiso, PDO::PARAM_STR);
			$stm->bindValue(7, $row->escuela_telefono, PDO::PARAM_STR);
			$stm->bindValue(8, $row->escuela_email, PDO::PARAM_STR);
			$stm->bindValue(9, $row->pais_id, PDO::PARAM_STR);
			$stm->bindValue(10, $row->provincia_id, PDO::PARAM_STR);
			$stm->bindValue(11, $row->departamento_id, PDO::PARAM_STR);
			$stm->bindValue(12, $row->localidad_id, PDO::PARAM_STR);
			$stm->bindValue(13, $row->escuela_codpostal, PDO::PARAM_STR);
			$stm->bindValue(14, $row->escuela_activo, PDO::PARAM_STR);
			$stm->bindValue(15, $usuario, PDO::PARAM_STR);
			$stm->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	// ------------- Listado de Paises ------
	public function Paises(){
		try{
		$sql = $this->cn->prepare("SELECT * FROM paises ORDER BY pais_nombre");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	// -------- Listado de Provincias filtrado -----
	public function ObtenerProvincias($pais){
		try	{
			$sql = 'SELECT * FROM provincias WHERE pais_id = ? ORDER BY provincia_nombre';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $pais, PDO::PARAM_STR);
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	//------ Listado de Departamentos filtrados ----
	public function ObtenerDepartamentos($provincia){
		try{
			$sql = 'SELECT * FROM departamentos WHERE provincia_id = ? ORDER BY departamento_nombre';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $provincia, PDO::PARAM_STR);
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	// ------ Listado de Localidades filtradas -----
	public function ObtenerLocalidades($departamento){
		try{
			$sql = 'SELECT * FROM localidades WHERE departamento_id = ? ORDER BY localidad_nombre';
			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $departamento, PDO::PARAM_STR);
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}

}
