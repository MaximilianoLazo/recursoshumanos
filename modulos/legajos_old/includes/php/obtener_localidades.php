<?php
		//require_once '../../../../database/Conexion.php';
		//require_once '../../model/empleado.php';
		$ppdl = $_GET['departamento'];
		//$localidades = new Empleado();
		$localidad = null;

		if(is_numeric($ppdl)){
			$departamento = $ppdl;
		}else{
			$ppdl = explode("-", $ppdl);
			$departamento = $ppdl[2];
			$localidad = $ppdl[3];
		}
			echo "<option value=''>--Seleccione--</option>";
		foreach($this->model->ObtenerLocalidades($departamento) as $row){
		?>
			<option value="<?php echo $row->localidad_id; ?>"<?php if (!(strcmp($row->localidad_id, $localidad))) {echo "selected=\"selected\"";} ?>><?php echo $row->localidad_nombre; ?></option>
		<?php
		}
?>
