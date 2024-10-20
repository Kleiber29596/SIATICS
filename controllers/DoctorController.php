<?php

require_once './models/DoctorModel.php';
require_once './models/PersonasModel.php';

class DoctorController {

	#estableciendo la vista del login
	public function inicioDoctor() {

        /*HEADER */
        require_once('./views/includes/cabecera.php');

        require_once('./views/paginas/doctor/inicioDoctor.php');

		/* FOOTER */
        require_once('./views/includes/pie.php');
	}

  
    public function listarDoctores(){

        // Database connection info 
        $dbDetails = array( 
            'host' => 'localhost', 
            'user' => 'root', 
            'pass' => '', 
            'db'   => 'medicina' 
        ); 
         
        // DB table to use 
        $table = <<<EOT
        (
            SELECT d.id_doctor, d.id_especialidad,  pe.id_persona,  pe.n_documento,  pe.nombres,  pe.apellidos,  pe.sexo, pe.telefono,  pe.correo, e.nombre_especialidad FROM doctor d INNER JOIN personas pe ON d.id_persona = pe.id_persona INNER JOIN especialidad e ON d.id_especialidad = e.id_especialidad ORDER BY id_doctor DESC) temp
        EOT;
   
        // Table's primary key 
        $primaryKey = 'id_doctor'; 
         
        // Array of database columns which should be read and sent back to DataTables. 
        // The `db` parameter represents the column name in the database.  
        // The `dt` parameter represents the DataTables column identifier. 
        $columns = array( 
            
            array( 'db' => 'n_documento',   'dt' => 0 ),
            array( 'db' => 'nombres',     	'dt' => 1 ),
            array( 'db' => 'apellidos',     'dt' => 2 ),    
            array( 'db' => 'nombre_especialidad',   'dt' => 3 ),      
            array( 'db' => 'id_doctor', 'dt' => 4 )
            
        ); 	
         
        // Include SQL query processing class 
        require './config/ssp.class.php'; 
         
        // Output data as json format 
        echo json_encode( 
            SSP::simple( $_GET, $dbDetails, $table, $primaryKey, $columns ) 
        ); 
         
    
    
    }

    public function registrarDoctor(){
        $fecha_registro = date('Y-m-d');
		$modelPersonas  = new PersonasModel();
        $modelDoctor = new DoctorModel();
		$datosPersona = array(
			'nombres'         => $_POST['nombres'],
			'apellidos'    	  => $_POST['apellidos'],
			'tipo_documento'  => $_POST['tipo_documento'],
			'n_documento'	  => $_POST['n_documento'],
			'fecha_nacimiento'=> $_POST['fecha_nac'],
			'sexo'		      => $_POST['sexo'],
			'telefono'		  => $_POST['telefono'],
			'id_estado'       => $_POST['estado'],
			'id_municipio'    => $_POST['municipio'],
			'id_parroquia'    => $_POST['parroquia'],
            'correo'          => $_POST['correo'],
            'fecha_registro'  => $fecha_registro
		);
		$registro_persona = $modelPersonas->registrarPersona($datosPersona);
		$id_persona = $registro_persona['ultimo_id'];

        $datosDoctor = array(
            'id_especialidad' => $_POST['especialidad'],
			'hora_inicio' 	  => $_POST['hora_inicio'],
			'hora_fin' 	      => $_POST['hora_fin'],
			'dia_inicio' 	  => $_POST['dia_inicio'],
			'dia_fin' 	      => $_POST['dia_fin'],
			'id_persona'      => $id_persona
		);
		$resultado = $modelDoctor->registrarDoctor($datosDoctor);
	
      
		if($resultado['ejecutar'])
		{
			$data = [
				'data' => [
					'success'            =>  true,
					'message'            => 'Guardado exitosamente',
					'info'               =>  'El Doctor ha sigo guardado en la base de datos'
				],
				'code' => 1,
			];
	
			echo json_encode($data);
			exit();
		}
		else {
			$data = [
				'data' => [
					'success'            =>  false,
					'message'            => 'Ocurrió un error al guardar el Doctor',
					'info'               =>  ''
				],
				'code' => 0,
			];
	
			echo json_encode($data);
			exit();
		}


	}

    public function listarActualizacionDoctor(){
		$modelDoctor = new DoctorModel();

		$id_doctor = $_POST['id_doctor'];
		$listar = $modelDoctor->obtenerDoctor($id_doctor);

		
		foreach ($listar as $item) {
            $id_doctor 			= $item['id_doctor'];
            $tipo_documento 	= $item['tipo_documento'];
            $n_documento 		= $item['n_documento'];
            $nombres 			= $item['nombres'];
            $apellidos 			= $item['apellidos'];
            $sexo 				= $item['sexo'];
            $id_especialidad 	= $item['id_especialidad'];
            $telefono			= $item['telefono'];
            $estado 			= $item['id_estado'];
            $municipio 			= $item['id_municipio'];
            $parroquia 			= $item['id_parroquia'];
            $correo 			= $item['correo'];
            $fecha_nacimiento   = $item['fecha_nacimiento'];
            $id_persona 		= $item['id_persona'];
			$dia_inicio   		= $item['dia_inicio'];
			$dia_fin   			= $item['dia_fin'];
			$hora_inicio   		= $item['hora_inicio'];
			$hora_fin			= $item['hora_fin'];
			$fecha_nacimiento   = $item['fecha_nacimiento'];
        }

		$data = [
			'data' => [
				'success'            =>  true,
				'message'            => 'Registro encontrado',
				'info'               =>  '',
				'id_doctor'		     => $id_doctor,
				'tipo_documento'   	 => $tipo_documento,
				'n_documento'    	 => $n_documento,
				'nombres'			 => $nombres,
				'apellidos'			 => $apellidos,
				'sexo'			     => $sexo,
				'id_especialidad'    => $id_especialidad,
				'telefono'			 => $telefono,
                'estado'			 => $estado,
				'municipio'			 => $municipio,
				'parroquia'			 => $parroquia,
                'correo'			 => $correo,
                'fecha_nacimiento'	 => $fecha_nacimiento,
                'id_persona'         => $id_persona,
				'dia_inicio'		 => $dia_inicio,
				'dia_fin'			 => $dia_fin,
				'hora_inicio'		 => $hora_inicio,
				'hora_fin'			 => $hora_fin,

			],
			'code' => 0,
		];

		echo json_encode($data);

		exit();
	}

    public function modificarDoctor(){

		$modelPersonas = new PersonasModel();
        $modelDoctor = new DoctorModel();
        $id_persona = $_POST['id_persona'];
		$id_doctor = $_POST['id_doctor'];
		
		$datosPersona = array(

			'tipo_documento'   	 => $_POST['update_tipo_documento'],
			'n_documento'        => $_POST['update_n_documento'],
			'nombres'			 => $_POST['update_nombres'],
			'apellidos'			 => $_POST['update_apellidos'],
			'sexo'			     => $_POST['update_sexo'],
			'telefono'			 => $_POST['update_telefono'],
			'id_estado' 		 => $_POST['update_estado'],
            'id_municipio' 		 => $_POST['update_municipio'],
            'id_parroquia' 		 => $_POST['update_parroquia'],
            'correo'			 => $_POST['update_correo'],
            'fecha_nacimiento'	 => $_POST['update_fecha_nac']
		);
		
		
        $modificarPersona = $modelPersonas->modificarPersona($id_persona, $datosPersona);
        $datosDoctor = array(

			'id_especialidad'	 => $_POST['update_id_especialidad'],
			'hora_inicio' 		 => $_POST['update_hora_inicio'],
			'hora_fin' 		 	 => $_POST['update_hora_fin'],
			'dia_inicio' 		 => $_POST['update_dia_inicio'],
			'dia_fin' 		 	 => $_POST['update_dia_fin']
		);

		
        $resultado = $modelDoctor->modificarDoctor($id_doctor, $datosDoctor);

		if($resultado || $modificarPersona)
		{
			$data = [
				'data' => [
					'success'            =>  true,
					'message'            => 'Guardado exitosamente',
					'info'               =>  'Los datos del Doctor han sido modificados'
				],
				'code' => 1,
			];
	
			echo json_encode($data);
			exit();
		}
		else {
			$data = [
				'data' => [
					'success'            =>  false,
					'message'            => 'Ocurrió un error al modificar los datos del Doctor',
					'info'               =>  ''
				],
				'code' => 0,
			];
	
			echo json_encode($data);
			exit();
		}


	}
	/*----------Metodo para inactivar un Doctor------*/

	public function inactivarDoctor(){

		$modelDoctor = new DoctorModel();
		$id_doctor = $_POST['id_doctor'];

		$estado = $modelDoctor->obtenerDoctor($id_doctor);

		foreach ($estado as $estado) 
		{
			$estado_doctor = $estado['estatus'];
		}

		if($estado_doctor == 1)
		{
			$datos = array(
				'estatus'		=> 0,
			);
	
			$resultado = $modelDoctor->modificarDoctor($id_doctor, $datos);
		}else{
			$datos = array(
				'estatus'		=> 1,
			);
	
			$resultado = $modelDoctor->modificarDoctor($id_doctor, $datos);
		}

		if($resultado)
		{
			$data = [
				'data' => [
					'success'            =>  true,
					'message'            => 'Guardado exitosamente',
					'info'               =>  'El estado del doctor ha sido modificado'
				],
				'code' => 1,
			];
	
			echo json_encode($data);
			exit();
		}
		else {
			$data = [
				'data' => [
					'success'            =>  false,
					'message'            => 'Ocurrió un error al modificar el estado del doctor',
					'info'               =>  ''
				],
				'code' => 0,
			];
	
			echo json_encode($data);
			exit();
		}
	}
/*-------- llenar select para registrar doctor --------*/
	public function llenarSelectDoctor()
	{
		$modelDoctor = new DoctorModel();
		$elegido = $_POST['elegido'];
		$data = $modelDoctor->llenarSelectDoctor($elegido);

		$data = [
			'data' => [
				'success'            =>  true,
				'message'            => 'Registro encontrado',
				'info'               =>  '',
				'data'				 =>  $data,
			],
			'code' => 0,
		];

		echo json_encode($data);

		exit();
	}
	/*-------- llenar select para actualizar doctor --------*/
	public function llenarSelectDoctorUpdate()
	{
		$modelDoctor = new DoctorModel();
		$elegido = $_POST['elegido'];
		$data = $modelDoctor->llenarSelectDoctor($elegido);

		$data = [
			'data' => [
				'success'            =>  true,
				'message'            => 'Registro encontrado',
				'info'               =>  '',
				'data'				 =>  $data,
			],
			'code' => 0,
		];

		echo json_encode($data);

		exit();
	}



	
}

