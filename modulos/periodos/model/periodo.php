<?php
class Periodo
{
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
	public function RegistrarP($data){
		try{
			$sql = 'INSERT INTO periodos (periodo_nombre,periodo_hsext_jor_i,periodo_hsext_jor_f,periodo_presentismo_i,periodo_presentismo_f,periodo_cerrado,periodo_activo)
			VALUES(?, ?, ?, ?, ?, ?, ?)';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Periodonombre, PDO::PARAM_STR);
			$stm->bindValue(2, $data->Periodohorasjori, PDO::PARAM_STR);
			$stm->bindValue(3, $data->Periodohorasjorf, PDO::PARAM_STR);
			$stm->bindValue(4, $data->Periodopresentismoi, PDO::PARAM_STR);
			$stm->bindValue(5, $data->Periodopresentismof, PDO::PARAM_STR);
			$stm->bindValue(6, $data->Periodocerrar, PDO::PARAM_STR);
			$stm->bindValue(7, $data->Periodoactivo, PDO::PARAM_STR);
			$stm->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function ActualizarP($data){
		try{
			$sql = 'UPDATE periodos SET periodo_nombre = ?, periodo_hsext_jor_i = ?, periodo_hsext_jor_f = ?, periodo_presentismo_i = ?, periodo_presentismo_f = ? WHERE periodo_id = ?';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Periodonombre, PDO::PARAM_STR);
			$stm->bindValue(2, $data->Periodohorasjori, PDO::PARAM_STR);
			$stm->bindValue(3, $data->Periodohorasjorf, PDO::PARAM_STR);
			$stm->bindValue(4, $data->Periodopresentismoi, PDO::PARAM_STR);
			$stm->bindValue(5, $data->Periodopresentismof, PDO::PARAM_STR);
			$stm->bindValue(6, $data->Periodoid, PDO::PARAM_STR);
			$stm->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function CerrarPer($data){
		try{
			$sql = 'UPDATE periodos SET periodo_cerrado = ? WHERE periodo_id = ?';

			$stm = $this->cn->prepare($sql);
			$stm->bindValue(1, $data->Periodocerrar, PDO::PARAM_STR);
			$stm->bindValue(2, $data->Periodoid, PDO::PARAM_STR);
			$stm->execute();

		}catch (Exception $e){
			die($e->getMessage());
		}
	}


	// datos viejos
	public function Listar()
	{
		try
		{

		//$result = array();

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

	
	
	
}