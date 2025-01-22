<?php
require_once './models/MedicamentosModel.php';
class MedicamentosController
{

	#estableciendo las vistas
	public function inicio()
	{

		/*HEADER */
		require_once('./views/includes/cabecera.php');

		require_once('./views/paginas/medicamentos/inicioMedicamentos.php');

		/* FOOTER */
		require_once('./views/includes/pie.php');
	}

	public function listarMedicamentos()
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
		SELECT presentacion_medicamentos.id_presentacion_medicamento, presentacion_medicamentos.id_medicamento, presentacion_medicamentos.id_presentacion,  medicamentos.nombre_medicamento, presentacion.presentacion  FROM presentacion_medicamentos INNER JOIN medicamentos ON presentacion_medicamentos.id_medicamento = medicamentos.id_medicamento  INNER JOIN presentacion ON presentacion_medicamentos.id_presentacion  = presentacion.id_presentacion  ORDER BY presentacion_medicamentos.id_presentacion_medicamento DESC
	) temp
	EOT;


		// Table's primary key 
		$primaryKey = 'id_presentacion_medicamento';

		// Array of database columns which should be read and sent back to DataTables. 
		// The `db` parameter represents the column name in the database.  
		// The `dt` parameter represents the DataTables column identifier. 
		$columns = array(

			array('db' => 'nombre_medicamento',   'dt' => 0),
			array('db' => 'presentacion', 'dt' => 1),
			array('db' => 'id_presentacion_medicamento',   'dt' => 2)

		);

		// Include SQL query processing class 
		require './config/ssp.class.php';

		// Output data as json format 
		echo json_encode(
			SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns)
		);
	}

	public function registrarMedicamento()

	{
		$fecha_registro    = date('Y-m-d');
		
		$modelMedicamentos = new MedicamentosModel();

		$datos_m = array(
						/*datos del recipe*/
			'nombre_medicamento'    => $_POST['nombre_medicamento'],
			'codigo'                => $_POST['id_categoria'],
			'fecha_registro'	    => $fecha_registro
		);
		
		$resultado_m = $modelMedicamentos->registrarMedicamento($datos_m);
		$id_medicamento = $resultado_m['ultimo_id'];

		$datos_pm = array(
			'id_medicamento'    => $id_medicamento,
			'id_presentacion'   => $_POST['id_presentacion'],
			'fecha_registro'	=> $fecha_registro
		);

		$resultado_pm = $modelMedicamentos->registrarPresentacionMedicamento($datos_pm);
		
		if ($resultado_pm) {
			$data = [
				'data' => [
					'success'            =>  true,
					'message'            => 'Guardado exitosamente',
					'info'               =>  'El medicamento se registro con éxito'
				],
				'code' => 1,
			];

			echo json_encode($data);
			exit();
		} else {
			$data = [
				'data' => [
					'success'            =>  false,
					'message'            => 'Ocurrió un error al registrar el medicamento',
					'info'               =>  ''
				],
				'code' => 0,
			];

			echo json_encode($data);
			exit();
		}
	}


	public function selectMedicamentos()
	{
		$modelMedicamentos = new MedicamentosModel();
		$medicamento = $modelMedicamentos->llenarSelectMedicamentos();
		return $medicamento;
	}

	public function listarMedic()
	{
		$modelMedicamentos = new MedicamentosModel();
		$medicamento = $modelMedicamentos->listar();
		return $medicamento;
	}
				/*Metodo para consultar un medicamento*/
	public function ConsultarMedicamento() {
		$id_medicamento =  $_POST['id_medicamento'];
		$dosis 			=  $_POST['dosis'];
		$unidad_medida 	=  $_POST['unidad_medida'];
		$frecuencia		=  $_POST['frecuencia'];
		$cantidad 	   	=  $_POST['cantidad'];
		$intervalo 	   	=  $_POST['intervalo'];

		$modelMedicamentos  = new MedicamentosModel();
		$medicamento = $modelMedicamentos->consultarPresentacionMedicamento($id_medicamento);
		
		foreach($medicamento as $medicamentos){
			$id_presentacion_medicamento = $medicamentos['id_presentacion_medicamento'];
			$nombre_medicamento = $medicamentos['nombre_medicamento'];
			$presentacion = $medicamentos['presentacion'];
		}

		$validar = $modelMedicamentos->consultarRegistroTemporal($id_presentacion_medicamento);
		if($validar){
			$data = [
				'data' => [
					'success'            =>  false,
					'message'            => 'El medicamento ya ha sido agregado',
					'info'               =>  'No pude seleccionar el mismo medicamento dos veces'
				],
				'code' => 0,
			];

			echo json_encode($data);
			exit();
		
		}
		$datos = array(
			'id_presentacion_medicamento' => $id_presentacion_medicamento,
			'dosis' 					  => $dosis,
			'unidad_medida' 			  => $unidad_medida,
			'frecuencia'				  => $frecuencia,
			'cantidad' 			  		  => $cantidad,
			'intervalo' 			      => $intervalo,
		);

		if ($medicamento) {
			$modelMedicamentos->registrarDatosTemporal($datos);
			$data = [
				'data' => [
					'success'            		=>  true,
					'message'            		=> 'Medicamento encontrado',
					'info'               		=> '	',  
					'nombre_medicamento'        =>  $nombre_medicamento,
					'presentacion'        		=>  $presentacion,
					'id_medicamento' 			=>  $id_presentacion_medicamento,
					'dosis'						=>  $dosis,
					'unidad_medida' 			=>  $unidad_medida,
			        'frecuencia'				=>  $frecuencia,
					'cantidad' 			  		=>  $cantidad,
					'intervalo' 			    =>  $intervalo,
				],
				'code' => 0,
			];

			echo json_encode($data);

			exit();
		} else {
			$data = [
				'data' => [
					'success'            =>  false,
					'message'            => 'Ocurrió un error al buscar el medicamento',
					'info'               =>  ''
				],
				'code' => 0,
			];

			echo json_encode($data);
			exit();
		}
		
		
	}

	public function removerMedicamento() {
		$modelMedicamentos = new MedicamentosModel();
		$id_medicamento = $_POST['id_medicamento'];

		$resultado = $modelMedicamentos->removerMedicamento($id_medicamento);


		if ($resultado) {

			$data = [
				'data' => [
					'success'            		=>  true,
					'message'            		=> 'Medicamento eliminado',
					'info'               		=> '',  
				],
				'code' => 0,
			];

			echo json_encode($data);

			exit();
		} else {
			$data = [
				'data' => [
					'success'            =>  false,
					'message'            => 'Ocurrió un error al eliminar el medicamento',
					'info'               =>  ''
				],
				'code' => 0,
			];

			echo json_encode($data);
			exit();
		}


	}

	public function listarActualizacionMedicamento(){
		$modelMedicamentos = new MedicamentosModel();
	
		$id_medicamento = $_POST['id_medicamento'];
		$listar = $modelMedicamentos->obtenerMedicamento($id_medicamento);
		
		foreach($listar as $listar)
		{
	
			$id_presentacion_medicamento       = $listar['id_presentacion_medicamento'];
			$id_medicamento					   = $listar['id_medicamento'];
			$nombre_medicamento				   = $listar['nombre_medicamento'];
			$categoria						   = $listar['codigo'];
			$presentacion					   = $listar['id_presentacion'];

			
		}
	
		$data = [
			'data' => [
				'success'              =>  true,
				'message'              => 'Registro encontrado',
				'info'                 =>  '',
				'id_presentacion_medicamento' => $id_presentacion_medicamento,
				'id_medicamento'			=> $id_medicamento,
				'nombre_medicamento'    => $nombre_medicamento,
				'categoria'             => $categoria,
				'presentacion'          => $presentacion,
	
			],
			'code' => 0,
		];
	
		echo json_encode($data);
	
		exit();
	}


	public function modificarMedicamento(){

		$modelMedicamentos = new MedicamentosModel();
		$id_medicamento = $_POST['id_medicamento'];
		$id_pm = $_POST['id_pm'];
		$datos_m = array(
			'nombre_medicamento'   		=> $_POST['nombre_medicamento_update'],
			'codigo'  					=> $_POST['categoria_update']
		);

		$resultado_m = $modelMedicamentos->modificarMedicamento($id_medicamento, $datos_m);

		$datos_pm = array(
			'id_presentacion'  					=> $_POST['presentacion_update']
			
		);

		$resultado_pm = $modelMedicamentos->modificarPresentacionMedicamento($id_pm, $datos_pm);

		if($resultado_m || $resultado_pm)
		{
			$data = [
				'data' => [
					'success'            =>  true,
					'message'            => 'Guardado exitosamente',
					'info'               =>  'Los datos del medicamento han sido modificados'
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



