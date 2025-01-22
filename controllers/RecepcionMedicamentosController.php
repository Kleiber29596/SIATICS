<?php
require_once './models/RecepcionMedicamentosModel.php';
require_once './models/BancoMedicamentosModel.php';
class RecepcionMedicamentosController
{

	#estableciendo las vistas
	 public function inicioRecepcionMedicamentos()
	 {

	/*HEADER */
	require_once('./views/includes/cabecera.php');

	require_once('./views/paginas/medicamentos/inicioRecepcionMedicamentos.php');

	/* FOOTER */
	require_once('./views/includes/pie.php');
}

public function listarRecepcionMedicamentos()
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
			SELECT id_recepcion_medicamento, medicamento, cantidad, procedencia, fecha_vencimiento, descripcion, recepcion_medicamentos.fecha_registro, nombre_medicamento, presentacion,  codigo, categoria, presentacion_medicamentos.id_medicamento, presentacion_medicamentos.id_presentacion, presentacion_medicamentos.id_codigo_categoria FROM recepcion_medicamentos INNER JOIN presentacion_medicamentos ON recepcion_medicamentos.medicamento = presentacion_medicamentos.id_presentacion_medicamento INNER JOIN medicamentos ON presentacion_medicamentos.id_medicamento = medicamentos.id_medicamento INNER JOIN presentacion ON presentacion_medicamentos.id_presentacion = presentacion.id_presentacion INNER JOIN codigo_categoria_medicamento ON presentacion_medicamentos.id_codigo_categoria = codigo_categoria_medicamento.id_codigo_categoria ORDER BY id_recepcion_medicamento ASC) temp
EOT;


		// Table's primary key 
		$primaryKey = 'id_recepcion_medicamento';

		// Array of database columns which should be read and sent back to DataTables. 
		// The `db` parameter represents the column name in the database.  
		// The `dt` parameter represents the DataTables column identifier. 
		$columns = array(

			array('db' => 'nombre_medicamento',   'dt' => 0),
			array('db' => 'presentacion',  'dt' => 1),
			array('db' => 'categoria',   'dt' => 2),
			array('db' => 'procedencia', 'dt' => 3),
			array( 
                'db'        => 'cantidad',
                'dt'        => 4, 
                'formatter' => function( $d, $row ) { 
                    return '<button class="btn btn-primary btn-sm">'.$d.'</button>'; 
                } 
            ),
			array('db' => 'fecha_registro', 'dt' => 5),
			array('db' => 'fecha_vencimiento', 'dt' => 6),
			array('db' => 'descripcion', 'dt' => 7),
			array('db' => 'id_recepcion_medicamento',   'dt' => 8),
			
			

		);

		// Include SQL query processing class 
		require './config/ssp.class.php';

		// Output data as json format 
		echo json_encode(
			SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns)
		);
	}

public function registrarRecepcionMedicamento()
	{
		$fecha_registro = date('Y-m-d');
		$modelRecepcionMedicamento = new RecepcionMedicamentosModel();
		$modelBancoMedicamentos = new  BancoMedicamentosModel();
		$id_presentacion_medicamento = intval($_POST['medicamento']);
		$cantidad =  intval($_POST['cantidad']);


		
		$datos = array(
			'medicamento'         => $id_presentacion_medicamento,
			'cantidad'    	  	  => $cantidad,
			'procedencia'  		  => $_POST['procedencia'],		  
			'fecha_vencimiento'	  => $_POST['fecha_vencimiento'],
			'descripcion'	      => $_POST['descripcion_recepcion'],
			'fecha_registro'	  => $fecha_registro
		);

		/* Validar si existe el medicamento en el Almacen*/
		$consulta_existencia_medicamento = $modelBancoMedicamentos->consultarExistenciaMedicamento($id_presentacion_medicamento);
		if (!empty($consulta_existencia_medicamento)) {
			foreach ($consulta_existencia_medicamento as $consulta_existencia_medicamentos) {
				$id_consulta_existencia = $consulta_existencia_medicamentos->id_presentacion_medicamento;
				$id_banco_medicamento = $consulta_existencia_medicamentos->id_banco_medicamento;		
		}

	}
	

		if ($id_presentacion_medicamento == $id_consulta_existencia) {
		
			$agregar_existencia = $modelBancoMedicamentos->agregarNuevaExistencia($id_banco_medicamento, $cantidad);
		}else {

		
			$datos_almacen = array(
				'id_presentacion_medicamento' => $id_presentacion_medicamento,
				'cantidad'    	  	  => $cantidad,
				'fecha_registro'	  => $fecha_registro
			);

			$agregar_nueva_existencia = $modelBancoMedicamentos->registrarExistencia($datos_almacen);

		}

		
		$resultado = $modelRecepcionMedicamento->registrarRecepcionMedicamento($datos);
		if ($resultado) {
			$data = [
				'data' => [
					'success'            =>  true,
					'message'            => 'Guardado exitosamente',
					'info'               =>  'La recepcion fue guardada exitosamente'
				],
				'code' => 1,
			];

			echo json_encode($data);
			exit();
		} else {
			$data = [
				'data' => [
					'success'            =>  false,
					'message'            => 'Ocurrió un error al guardar el paciente',
					'info'               =>  ''
				],
				'code' => 0,
			];

			echo json_encode($data);
			exit();
		}
	}

	public function listarActualizacionRecepcionMedicamento(){
		
		$modelRecepcionMedicamento = new RecepcionMedicamentosModel();
		$id_recepcion_medicamento = $_POST['id_recepcion_medicamento'];
		$listar = $modelRecepcionMedicamento->obtenerRecepcionMedicamento($id_recepcion_medicamento);
		
		foreach($listar as $listar)
		{

			$id_recepcion_medicamento   = $listar['id_recepcion_medicamento'];
			$medicamento				= $listar['medicamento'];
			$cantidad 					= $listar['cantidad'];
			$procedencia 				= $listar['procedencia'];
			$fecha_vencimiento 		    = $listar['fecha_vencimiento'];
			$descripcion 				= $listar['descripcion'];
		}

		$data = [
			'data' => [
				'success'              =>  true,
				'message'              => 'Registro encontrado',
				'info'                 =>  '',
				'medicamento'      	   => $medicamento,
				'cantidad'     	 	   => $cantidad,
				'procedencia'      	   => $procedencia,
				'fecha_vencimiento'    => $fecha_vencimiento,
				'descripcion'      	   => $descripcion,
			],
			'code' => 0,
		];

		echo json_encode($data);

		exit();
	}

	public function modificarRecepcionMedicamento(){

		$modelRecepcionMedicamento = new RecepcionMedicamentosModel();
		$id_recepcion_medicamento = $_POST['id_recepcion_medicamento'];
		$datos = array(
			'medicamento'   		=> $_POST['medicamento'],
			'procedencia'  			=> $_POST['procedencia'],
			'cantidad'  			=> $_POST['cantidad'],
			'fecha_vencimiento'  	=> $_POST['fecha_vencimiento'],
			'descripcion'  			=> $_POST['descripcion'],
		);

		$resultado = $modelRecepcionMedicamento->modificarRecepcionMedicamento($id_recepcion_medicamento, $datos);
	
		if($resultado)
		{
			$data = [
				'data' => [
					'success'            =>  true,
					'message'            => 'Guardado exitosamente',
					'info'               =>  'Los datos de la recepcion han sido modificados'
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


}
