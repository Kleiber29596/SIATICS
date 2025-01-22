<?php

require_once './models/EspecialidadModel.php';

class EspecialidadController {

	#estableciendo la vista del login
	public function inicioEspecialidad() {

        /*HEADER */
        require_once('./views/includes/cabecera.php');

        require_once('./views/paginas/especialidad/inicioEspecialidad.php');

		/* FOOTER */
        require_once('./views/includes/pie.php');
	}

	public function listarEspecialidades()
	{
		// Database connection info 
		$dbDetails = array(
			'host' => 'localhost',
			'user' => 'root',
			'pass' => '',
			'db'   => 'medicina'
		);


		$table = 'especialidad';

		// Table's primary key 
		$primaryKey = 'id_especialidad';

		// Array of database columns which should be read and sent back to DataTables. 
		// The `db` parameter represents the column name in the database.  
		// The `dt` parameter represents the DataTables column identifier. 
		$columns = array(

			
			array('db' => 'nombre_especialidad',  'dt' => 0),
			array('db' => 'modalidad',            'dt' => 1),
			array('db' => 'tm_porcita',		      'dt' => 2),			      
			array('db' => 'id_especialidad', 	  'dt' => 3)

		);

		// Include SQL query processing class 
		require './config/ssp.class.php';

		// Output data as json format 
		echo json_encode(
			SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns)
		);
	}

	public function selectEspecialidad()
	{
		$modelEspecialidad = new EspecialidadModel();
		$especialidades = $modelEspecialidad->selectEspecialidad();
		return $especialidades;
	}


	public function selectEspecialidadCitas()
	{
		$modelEspecialidad = new EspecialidadModel();
		$especialidades = $modelEspecialidad->selectEspecialidadCitas();
		return $especialidades;
	}



	

    public function registrarEspecialidad(){

		$modelEspecialidad = new EspecialidadModel();
        $fecha_registro = date('Y-m-d');
		$datos = array(
			'nombre_especialidad'   => $_POST['especialidad'],
			'modalidad'  		    => $_POST['modalidad'],
			'tm_porcita'  			=> $_POST['tm_cita']
		);


		$resultado = $modelEspecialidad->registrarEspecialidad($datos);

		if($resultado)
		{
			$data = [
				'data' => [
					'success'            =>  true,
					'message'            => 'Guardado exitosamente',
					'info'               =>  'La especialidad ha sigo guardada en la base de datos'
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
					'message'            => 'Ocurrió un error al guardar la especialidad',
					'info'               =>  ''
				],
				'code' => 0,
			];
	
			echo json_encode($data);
			exit();
		}


	}

    public function listarActualizacionEspecialidad(){
		$modelEspecialidad = new EspecialidadModel();

		$id_especialidad = $_POST['id_especialidad'];
		$listar = $modelEspecialidad->obtenerEspecialidad($id_especialidad);
		
		foreach($listar as $listar)
		{

			$id_especialidad      = $listar['id_especialidad'];
			$especialidad  		  = $listar['nombre_especialidad'];
			$modalidad 			  = $listar['modalidad'];
			$tm_porcita			  = $listar['tm_porcita'];
		}

		$data = [
			'data' => [
				'success'              =>  true,
				'message'              => 'Registro encontrado',
				'info'                 =>  '',
				'id_especialidad'      => $id_especialidad,
				'especialidad'  => $especialidad,
				'modalidad' 		   => $modalidad,
				'tm_porcita'		   => $tm_porcita

			],
			'code' => 0,
		];

		echo json_encode($data);

		exit();
	}

	public function modificarEspecialidad(){

		$modelEspecialidad = new EspecialidadModel();
		$id_especialidad = $_POST['id_especialidad'];
		$datos = array(
			'nombre_especialidad'   => $_POST['especialidad'],
			'modalidad'      => $_POST['modalidad'],
			'tm_porcita'     => $_POST['tm_porcita'],
		);

		$resultado = $modelEspecialidad->modificarEspecialidad($id_especialidad, $datos);

		if($resultado)
		{
			$data = [
				'data' => [
					'success'            =>  true,
					'message'            => 'Guardado exitosamente',
					'info'               =>  'Los datos de la especialidad han sido modificados'
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
					'message'            => 'Ocurrió un error al modificar los datos de la especialidad',
					'info'               =>  ''
				],
				'code' => 0,
			];
	
			echo json_encode($data);
			exit();
		}


	}
	/*----------Metodo para inactivar Especialidad-------*/

	public function inactivarEspecialidad(){

		$modelEspecialidad = new especialidadModel();
		$id_especialidad = $_POST['id_especialidad'];
		$estado = $modelEspecialidad->obtenerEspecialidad($id_especialidad);

		foreach ($estado as $estado) 
		{
			$estado_especialidad = $estado['estatus_especialidad'];
		}

		if($estado_especialidad == 1)
		{
			$datos = array(
				'estatus_especialidad'		=> 0,
			);
	
			$resultado = $modelEspecialidad->modificarEspecialidad($id_especialidad, $datos);
		}else{
			$datos = array(
				'estatus_especialidad'		=> 1,
			);
	
			$resultado = $modelEspecialidad->modificarEspecialidad($id_especialidad, $datos);
		}

		if($resultado)
		{
			$data = [
				'data' => [
					'success'            =>  true,
					'message'            => 'Guardado exitosamente',
					'info'               =>  'El estado de la especialidad ha sido modificado'
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
					'message'            => 'Ocurrió un error al modificar el estado de la especialidad',
					'info'               =>  ''
				],
				'code' => 0,
			];
	
			echo json_encode($data);
			exit();
		}
	}
}

