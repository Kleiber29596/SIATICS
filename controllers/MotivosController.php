<?php
require_once './models/MotivosModel.php';
class MotivosController
{

	#estableciendo las vistas
	public function inicio()
	{

		/*HEADER */
		require_once('./views/includes/cabecera.php');

		require_once('./views/paginas/motivos/inicioMotivo.php');

		/* FOOTER */
		require_once('./views/includes/pie.php');
	}

	public function listarMotivos()
	{

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
		SELECT t.id_tipo_consulta, t.motivo, t.id_especialidad, e.nombre_especialidad  FROM tipo_consulta as t LEFT JOIN especialidad AS e ON t.id_especialidad = e.id_especialidad  ORDER BY t.id_tipo_consulta DESC
	) temp
	EOT;


		// Table's primary key 
		$primaryKey = 'id_tipo_consulta';

		// Array of database columns which should be read and sent back to DataTables. 
		// The `db` parameter represents the column name in the database.  
		// The `dt` parameter represents the DataTables column identifier. 
		$columns = array(

			array('db' => 'motivo',                'dt' => 0),
			array('db' => 'nombre_especialidad',   'dt' => 1),
			array('db' => 'id_tipo_consulta',      'dt' => 2)

		);

		// Include SQL query processing class 
		require './config/ssp.class.php';

		// Output data as json format 
		echo json_encode(
			SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns)
		);
	}


	/* Metodo para registrar motivo */
	public function registrarMotivo()

	{
		$fecha_registro    = date('Y-m-d');
		
		$modelMotivos = new MotivosModel();

		$datos = array(
						/*datos del recipe*/
			'motivo'       			=> $_POST['motivo'],
			'id_especialidad'  		=> $_POST['especialidad_motivo'],
			'fecha_registro'	    => $fecha_registro
		);
		
		$resultado = $modelMotivos->registrarMotivo($datos);
		
		if ($resultado) {
			
			$data = [
				'data' => [
					'success'            =>  true,
					'message'            => 'Guardado exitosamente',
					'info'               =>  'El motivo se registro con éxito'
				],
				'code' => 1,
			];

			echo json_encode($data);
			exit();
		} else {
			$data = [
				'data' => [
					'success'            =>  false,
					'message'            => 'Ocurrió un error al registrar el motivo',
					'info'               =>  ''
				],
				'code' => 0,
			];

			echo json_encode($data);
			exit();
		}
	}


	public function listarActualizacionMotivo(){
		$modelMotivos = new MotivosModel();
	
		$id_motivo = $_POST['id_motivo'];
		$listar = $modelMotivos->obtenerMotivo($id_motivo);
		
		foreach($listar as $listar)
		{
	
			$id_motivo     		  = $listar['id_tipo_consulta'];
			$motivo 	 		  = $listar['motivo'];
			$id_especialidad 	  = $listar['id_especialidad'];
			$nombre_especialidad  = $listar['nombre_especialidad'];
		}
	
		$data = [
			'data' => [
				'success'              =>  true,
				'message'              => 'Registro encontrado',
				'info'                 =>  '',
				'id_motivo'  		   => $id_motivo,
				'motivo' 			   => $motivo,
				'id_especialidad'      => $id_especialidad,
				'nombre_especialidad'  => $nombre_especialidad,
	
			],
			'code' => 0,
		];
	
		echo json_encode($data);
	
		exit();
	}


		public function modificarMotivo(){

			$modelMotivos = new MotivosModel();
			$id_motivo = $_POST['id_motivo'];
			$datos = array(
				'motivo'   => $_POST['update_motivo'],
				'id_especialidad'  => $_POST['update_id_especialidad'],
			);
	
			$resultado = $modelMotivos->modificarMotivo($id_motivo, $datos);
	
			if($resultado)
			{
				$data = [
					'data' => [
						'success'            =>  true,
						'message'            => 'Guardado exitosamente',
						'info'               =>  'Los datos del motivo han sido modificados'
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
						'message'            => 'Ocurrió un error al modificar los datos del motivo',
						'info'               =>  ''
					],
					'code' => 0,
				];
		
				echo json_encode($data);
				exit();
			}
	
	
		}


	}

