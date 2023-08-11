<?php

	$indumentariaid = $_GET['id'];
	$indumentariatalleid = 44;
	echo "<option value=''>--Seleccione--</option>";
	foreach($this->model->IndumentariaTallesObtener($indumentariaid) as $row){
	?>
		<option value="<?php echo $row->indumentaria_talle_id; ?>"<?php if (!(strcmp($row->indumentaria_talle_id, $indumentariatalleid))) {echo "selected=\"selected\"";} ?>><?php echo $row->indumentaria_talle_nombre; ?></option>
	<?php
	}
?>
