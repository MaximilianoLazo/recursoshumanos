 <?php

		$nrodocto = $_POST['val'];

    $data = array();

    $datosempleado = $this->model->EmpleadoObtener($nrodocto);

    if(empty($datosempleado)){
      //----El empleado no existe ----
      $data["condicion"] = 0;
    }else{
      //-----El empleado Existe -----
      $data["condicion"] = 1;
      $data["empapellido"] = $datosempleado->legempleado_apellido;
      $data["empnombres"] = $datosempleado->legempleado_nombres;
      if($datosempleado->legtipo_id == 1){
        //-------CONTRATADO
        $contratadodatos = $this->model->ContratadoObtener($nrodocto);
        $data["fictdetalletrabajoid"] = $contratadodatos->trabajo_id;
        $data["fictdetallesecretariaid"] = $contratadodatos->secretaria_id;
        //----Obtener lugar de trabajo - nombre -----
        $ltrabajodatos = $this->model->LTrabajoXIdObtener($contratadodatos->trabajo_id);
        $data["fictdetalletrabajonombre"] = $ltrabajodatos->trabajo_nombre;
        //----Obtener secretaria - nombre -----
        $secretariadatos = $this->model->SecretariaXIdObtener($contratadodatos->secretaria_id);
        $data["fictdetallesecretarianombre"] = $secretariadatos->secretaria_nombre;
      }elseif($datosempleado->legtipo_id == 2){
        //-------JORNALERO
        $jornalerodatos = $this->model->JornaleroObtener($nrodocto);
        $data["fictdetalletrabajoid"] = $jornalerodatos->trabajo_id;
        $data["fictdetallesecretariaid"] = $jornalerodatos->secretaria_id;
        //----Obtener lugar de trabajo - nombre -----
        $ltrabajodatos = $this->model->LTrabajoXIdObtener($jornalerodatos->trabajo_id);
        $data["fictdetalletrabajonombre"] = $ltrabajodatos->trabajo_nombre;
        //----Obtener secretaria - nombre -----
        $secretariadatos = $this->model->SecretariaXIdObtener($jornalerodatos->secretaria_id);
        $data["fictdetallesecretarianombre"] = $secretariadatos->secretaria_nombre;
      }elseif($datosempleado->legtipo_id == 3){
        //--------PPERMANENTE
        $ppermanentedatos = $this->model->PPermanenteObtener($nrodocto);
        $data["fictdetalletrabajoid"] = $ppermanentedatos->trabajo_id;
        $data["fictdetallesecretaria"]= $ppermanentedatos->secretaria_id;
        //----Obtener lugar de trabajo - nombre -----
        $ltrabajodatos = $this->model->LTrabajoXIdObtener($ppermanentedatos->trabajo_id);
        $data["fictdetalletrabajonombre"] = $ltrabajodatos->trabajo_nombre;
        //----Obtener secretaria - nombre -----
        $secretariadatos = $this->model->SecretariaXIdObtener($ppermanentedatos->secretaria_id);
        $data["fictdetallesecretarianombre"] = $secretariadatos->secretaria_nombre;
      }elseif($datosempleado->legtipo_id == 4){
        //--------PROVEEDOR--------
        $proveedordatos = $this->model->ProveedorObtener($nrodocto);
        $data["fictdetalletrabajoid"] = $proveedordatos->trabajo_id;
        $data["fictdetallesecretaria"] = $proveedordatos->secretaria_id;
        //----Obtener lugar de trabajo - nombre -----
        $ltrabajodatos = $this->model->LTrabajoXIdObtener($proveedordatos->trabajo_id);
        $data["fictdetalletrabajonombre"] = $ltrabajodatos->trabajo_nombre;
        //----Obtener secretaria - nombre -----
        $secretariadatos = $this->model->SecretariaXIdObtener($proveedordatos->secretaria_id);
        $data["fictdetallesecretarianombre"] = $secretariadatos->secretaria_nombre;
      }else{
        //--------default, error ----
      }
      //-------Datos de Reloj ------------
      $emprelojdatos = $this->model->EmpleadoXRelojObtener($nrodocto);
      if($emprelojdatos->reloj_id > 0){
        $data["fictdetallerelojid"] = $emprelojdatos->reloj_id;
        //-------Obtener reloj - nombre -----
        $relojdatos = $this->model->RelojObtener($emprelojdatos->reloj_id);
        $data["fictdetallerelojnombre"] = $relojdatos->reloj_nombre;
      }else{
        $data["fictdetallerelojid"] = 13;
        $data["fictdetallerelojnombre"] = "Sin reloj";
      }


    }
 		echo json_encode($data);
 ?>
