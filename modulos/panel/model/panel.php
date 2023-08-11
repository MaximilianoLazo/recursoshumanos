<?php
class Panel{
	public function __CONSTRUCT(){
		try{
			$this->cn = Conexion::getConnection();
		}catch(Exception $e){
			die($e->getMessage());
		}
	}
	public function __DESTRUCT(){
		$this->cn;
	}

	public function NochesListar(){
		try{

			$sql = 'SELECT *
								FROM noches';
			$dec = $this->cn->prepare($sql);
			$dec->execute();
			return $dec->fetchAll(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function NocheEstadisticaObtener_E($nocheid){
		try{

			$sql = 'SELECT SUM(venta_cantidad) AS entrada_cantidad,
										 SUM(venta_importe) AS entrada_importe
								FROM ventas
							 WHERE noche_id = ?
							 	 AND ubicacion_id != 7
							 	 AND ubicacion_detalle_id = 0
							 	 AND ubicacion_detalle_numero = 0
								 AND venta_estado_id = 2';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $nocheid, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function NocheEstadisticaObtener_U($nocheid){
		try{

			$sql = 'SELECT SUM(venta_importe) AS ubicacion_importe
								FROM ventas
							 WHERE noche_id = ?
							 	 AND ubicacion_detalle_id > 0
							 	 AND ubicacion_detalle_numero > 0
								 AND venta_estado_id = 2';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $nocheid, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}

	public function NocheEstadisticaObtener_EFE($nocheid, $pagometodo){
		try{

			$sql = 'SELECT SUM(venta_importe) AS efectivo_importe
								FROM ventas
							 WHERE noche_id = ?
								 AND pago_metodo_id = ?
								 AND venta_estado_id = 2';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $nocheid, PDO::PARAM_STR);
			$dec->bindValue(2, $pagometodo, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	public function NocheEstadisticaObtener_TAR($nocheid, $pagometodo){
		try{

			$sql = 'SELECT SUM(venta_importe) AS tarjeta_importe
								FROM ventas
							 WHERE noche_id = ?
								 AND pago_metodo_id = ?
								 AND venta_estado_id = 2';
			$dec = $this->cn->prepare($sql);
			$dec->bindValue(1, $nocheid, PDO::PARAM_STR);
			$dec->bindValue(2, $pagometodo, PDO::PARAM_STR);
			$dec->execute();
			return $dec->fetch(PDO::FETCH_OBJ);

		}catch (Exception $e){
			die($e->getMessage());
		}
	}
	
	
}
