<?php
		//require_once '../../../../database/Conexion.php';
		//require_once '../../model/empleado.php';
		$ppdl = $_GET['provincia'];
		//$departamentos = new Empleado();
		$departamento = null;

		if(is_numeric($ppdl)){
			$provincia = $ppdl;
		}else{
			$ppdl = explode("-", $ppdl);
			$provincia = $ppdl[1];
			$departamento = $ppdl[2];
		}
			echo "<option value=''>--Seleccione--</option>";
		foreach($this->model->ObtenerDepartamentos($provincia) as $row){
		?>
			<option value="<?php echo $row->departamento_id; ?>"<?php if (!(strcmp($row->departamento_id, $departamento))) {echo "selected=\"selected\"";} ?>><?php echo $row->departamento_nombre; ?></option>
		<?php
		}
?>
