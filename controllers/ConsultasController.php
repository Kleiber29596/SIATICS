<?php

require_once './models/ConsultasModel.php';
require_once './models/RecipeModel.php';
require_once './models/MedicamentosModel.php';
require_once './models/CitasModel.php';


class ConsultasController {

	#estableciendo las vistas
	public function inicio() {

        require_once('./views/includes/cabecera.php');
        require_once('./views/paginas/consultas/inicio_consultas.php');
        require_once('./views/includes/pie.php');
 
        }




public function listarConsultas()
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
		SELECT DISTINCT c.id_consulta, c.id_tipo_consulta, c.id_persona,  DATE_FORMAT(c.fecha_registro, '%d/%m/%Y') AS fecha_registro, c.edad, t.codigo, t.motivo,  CONCAT(p.tipo_documento, '-', p.n_documento) AS documento, CONCAT(p.p_nombre, ' ', p.s_nombre, ' ', p.p_apellido, ' ', p.s_apellido) AS nombre_apellido,  e.modalidad FROM consultas c INNER JOIN tipo_consulta t ON c.id_tipo_consulta = t.id_tipo_consulta
INNER JOIN personas p ON c.id_persona = p.id_persona
INNER JOIN especialidad e ON c.id_especialidad = e.id_especialidad
ORDER BY c.id_consulta DESC
        ) temp 
EOT;

		// Table's primary key 
		$primaryKey = 'id_consulta';

		// Array of database columns which should be read and sent back to DataTables. 
		// The `db` parameter represents the column name in the database.  
		// The `dt` parameter represents the DataTables column identifier. 
		$columns = array(
			
			array('db' => 'fecha_registro',      'dt' => 0),
			array('db' => 'nombre_apellido',	 'dt' => 1),
			array('db' => 'documento',  		 'dt' => 2),
			array('db' => 'motivo',     		 'dt' => 3),
			array('db' => 'modalidad',  		 'dt' => 4),
			array('db' => 'id_consulta', 		 'dt' => 5)

		);

		// Include SQL query processing class 
		require './config/ssp.class.php';

		// Output data as json format 
		echo json_encode(
			SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns)
		);
	}

	public function registrarConsulta()

	{
		session_start();

		$fecha_registro    = date('Y-m-d');
		$modelRecipe	   = new RecipeModel();
		$modelMedicamentos = new MedicamentosModel();
		$modelConsultas    = new ConsultasModel();
		$modelCitas 	   = new CitasModel();

		$datos = array(
						/*datos del recipe*/
			'instrucciones'       	=> $_POST['instrucciones'],
			'fecha_registro'  		=> $fecha_registro,
			'id_usuario'			=> $_SESSION['user_id'],
		);

	

		$registro_recipe = $modelRecipe->registrarRecipe($datos);

		$id_recipe = $registro_recipe['ultimo_id'];
						/*datos intermedia */
		//REGISTRAR ESTUDIOS
		$medicamentos = $modelMedicamentos->listarMedicamentosTemporales();

		//var_dump($medicamentos); die();

		if(!empty($medicamentos)){

			foreach($medicamentos as $medicamento)
			{
				$id_medicamento 	    = $medicamento['id_presentacion_medicamento'];
				$dosis 	   				= $medicamento['dosis'];
				$unidad_medida 	   	    = $medicamento['unidad_medida'];
				$frecuencia 	   	    = $medicamento['frecuencia'];
				$cantidad 	   	    	= $medicamento['cantidad'];
				$intervalo 	   	    	= $medicamento['intervalo'];

				$datos_intermedia= array(
					'id_presentacion_medicamento' => $id_medicamento,
					'id_recipe' 				  => $id_recipe,
					'dosis' 			  		  => $dosis,
					'unidad_medida' 			  => $unidad_medida,
					'frecuencia' 			  	  => $frecuencia ,
					'cantidad' 			  		  => $cantidad,
					'intervalo' 			      => $intervalo,
					'fecha_registro'			  => $fecha_registro,
					'estatus' 					  => 1
				);
	
				$registro_intermedia = $modelRecipe->registrarTblIntermedia($datos_intermedia);
			}

			
			
		}
			
		$peso   = $_POST['peso'];
		$altura = $_POST['altura'];
		$id_cita = $_POST['id_cita_agendada'];

		/*datos de la consulta*/
		$datos_consulta = array(
			'id_persona'         	=> $_POST['id_persona'],
			'id_tipo_consulta'  	=> $_POST['tipo_consulta'],
			'diagnostico'		    => $_POST['diagnostico'],
			'peso'		            => intval($peso),
			'altura'		        => intval($altura),
			'presion_arterial'		=> $_POST['presion_arterial'],
			'id_especialidad'		=> $_POST['id_especialidad'],
			'id_doctor'				=> $_POST['id_especialista'],
			'fecha_registro'  		=> $fecha_registro,
			'id_recipe'				=> $id_recipe,
			'id'			        => $_SESSION['user_id']
		);

		
		$resultado = $modelConsultas->registrarConsulta($datos_consulta);
		$respuesta = $resultado['ejecutar'];


		if ($respuesta) {

			if(isset($id_cita) && $id_cita != ''){

				$estado = $modelCitas->obtenerCita($id_cita);
		
				foreach ($estado as $e) {
					$estado_cita = $e['estatus'];
				}
		
				if ($estado_cita == 1) {
					$datos = array(
						'estatus'		=> 0,
					);
		
					$resultado = $modelCitas->modificarCita($id_cita, $datos);
				} else {
					$datos = array(
						'estatus'		=> 1,
					);
		
					$resultado = $modelCitas->modificarCita($id_cita, $datos);
				}



			}
			
			$modelMedicamentos->eliminarMedicamentoTemp();
		
			$data = [
				'data' => [
					'success'            =>  true,
					'message'            => 'Guardado exitosamente',
					'info'               =>  'La consulta ha sido registrada con éxito'
				],
				'code' => 1,
			];

			
			echo json_encode($data);
			exit();
		} else {
			$data = [
				'data' => [
					'success'            =>  false,
					'message'            => 'Ocurrió un error al registrar a la consulta',
					'info'               =>  ''
				],
				'code' => 0,
			];

			echo json_encode($data);
			exit();
		}
	}

	public function selectTipoConsulta()
	{
		$modelConsultas = new ConsultasModel();
		$estados = $modelConsultas->selectTipos();
		return $estados;
	}

	public function datosReceta($id_consulta)
	{
		$modelRecipe = new RecipeModel();
		$receta = $modelRecipe->consultarReceta($id_consulta); 
		return $receta;
	}

	
	


	#estableciendo la vista del reporte
	public function imprimirRecipe() {

		require_once('./views/paginas/reportes/recipe.php');
	}


	public function listarDatosConsulta()
	{	
		
		$id_consulta = $_POST['id_consulta'];
		$modelConsultas = new ConsultasModel();
		$modelRecipes = new RecipeModel();

		$listar = $modelConsultas->listarDatosConsulta($id_consulta);
		
		foreach ($listar as $lista) {
			$id_consulta				= $lista['id_consulta'];
			$id_tipo_consulta			= $lista['id_tipo_consulta'];
			$tipo_consulta 				= $lista['id_tipo_consulta'];
			$diagnostico 				= $lista['diagnostico'];
			$nombres_persona 			= $lista['nombres_apellidos'];
			$altura 			        = $lista['altura'];
			$peso 			            = $lista['peso'];
			$presion_arterial 			= $lista['presion_arterial'];

		}

		$receta_medicamentos = $modelRecipes->consultarRecetaUpdate($id_consulta);

		
			
		if ($listar) {
			
			$data = [
				'data' => [
					'success'           	 	  	=>  true,
					'message'           	 		=> 'Registro encontrado',
					'info'              	 	    =>  '',
					'id_consulta'		   			=> $id_consulta,
					'tipo_consulta'		   			=> $tipo_consulta,
					'diagnostico'		   			=> $diagnostico,
					'nombres_persona'		   		=> $nombres_persona,
					'receta_medicamentos'			=> $receta_medicamentos,
					'altura'					    => $altura,
					'peso'							=> $peso,
					'presion_arterial'				=> $presion_arterial

				],
				'code' => 0,
			];
			echo json_encode($data);

			exit();

		}else {

			$data = [
				'data' => [
					'success'            =>  false,
					'message'            => 'Error al obtener datos de consulta',
					'info'               =>  'Error al obtener datos de consulta'
				],
				'code' => 0,
			];
			echo json_encode($data);
			exit();

		}
			
		
		
	}

	public function obtenerDatosReceta()
	{	
		
		$id_receta          = $_POST['id_receta'];
		$modelRecipes       = new RecipeModel();
		
		$listar = $modelRecipes->obtenerDatosReceta($id_receta);
		

		foreach ($listar as $lista) {
			$id_presentacion_medicamento = $lista->id_presentacion_medicamento; 
			$dosis = $lista->dosis; 
			$unidad_medida = $lista->unidad_medida; 
			$frecuencia = $lista->frecuencia; 
			$cantidad = $lista->cantidad; 
			$intervalo = $lista->intervalo; 
		}

		
			
		if ($intervalo != '') {
			
			$data = [
				'data' => [
					'success'           	 	  	=>  true,
					'message'           	 		=> 'Registro encontrado',
					'info'              	 	    =>  '',
					'id_presentacion_medicamento'   => $id_presentacion_medicamento,
					'dosis'		   					=> $dosis,
					'unidad_medida'		   			=> $unidad_medida,
					'frecuencia'		   		    => $frecuencia,
					'cantidad'			            => $cantidad,
					'intervalo'			            => $intervalo

				],
				'code' => 0,
			];
			echo json_encode($data);

			exit();

		}else {

			$data = [
				'data' => [
					'success'            =>  false,
					'message'            => 'Error al obtener datos de consulta',
					'info'               =>  'Error al obtener datos de consulta'
				],
				'code' => 0,
			];
			echo json_encode($data);
			exit();

		}
			
		
		
	}


	public function modificarConsulta()
	{	
		$id_consulta_update = $_POST['id_consulta_update'];


		$modelConsultas = new ConsultasModel();

		$datos = array(
			'id_tipo_consulta'         	            => $_POST['update_tipo_consulta'],
			'peso'							        => $_POST['update_peso'],
			'altura'							    => $_POST['update_altura'],
			'presion_arterial'				        => $_POST['update_presion_arterial'],
			'diagnostico'					        => $_POST['update_diagnostico'],
		
		);
		
		$modificar = $modelConsultas->modificarConsulta($id_consulta_update, $datos);

		if ($modificar) {
			
			$data = [
				'data' => [
					'success'           	 	  	=>  true,
					'message'           	 		=> 'Consulta modificada',
					'info'              	 	    =>  '',
					
				],
				'code' => 0,
			];
			echo json_encode($data);

			exit();

		}else {

			$data = [
				'data' => [
					'success'            =>  false,
					'message'            => 'Error al modificar la consulta',
					'info'               =>  ''
				],
				'code' => 0,
			];
			echo json_encode($data);
			exit();

		}
			
		
		
	}




public function modificarReceta()
	{	
		$id_consulta_update = $_POST['id_consulta_update'];
		$id_receta = $_POST['id_receta_update'];
		$modelRecipes = new RecipeModel();

		$datos = array(
			'id_recipe_medicamento'		        => 	$id_receta,
			'id_presentacion_medicamento'         	=> $_POST['medicamento_update'],
			'dosis'    	  							=> $_POST['dosis_update'],
			'frecuencia'  							=> $_POST['frecuencia_update'],
			'cantidad'		    					=> $_POST['cantidad_update'],
			'intervalo'		            			=> $_POST['intervalo_update'],
		);
		
		$modificar = $modelRecipes->modificarReceta($id_receta, $datos);
		$recetas = $modelRecipes->consultarRecetaUpdate($id_consulta_update);

		if ($recetas) {
			
			$data = [
				'data' => [
					'success'           	 	  	=>  true,
					'message'           	 		=> 'Receta modificada',
					'info'              	 	    =>  '',
					'recetas'   					=> $recetas
					

				],
				'code' => 0,
			];
			echo json_encode($data);

			exit();

		}else {

			$data = [
				'data' => [
					'success'            =>  false,
					'message'            => 'Error al obtener datos de consulta',
					'info'               =>  'Error al obtener datos de consulta'
				],
				'code' => 0,
			];
			echo json_encode($data);
			exit();

		}
			
		
		
	}

	public function suspenderTratamiento()
	{
		$id_receta 					= $_POST['id_receta_suspension'];
		$observacion_suspension 	= $_POST['observacion_suspension'];
		$id_consulta_update 		= $_POST['id_consulta_update'];

		$modelRecipes = new RecipeModel();
		$datos = array(
			'estatus'					=> 0,
			'observacion_suspension'	=> $observacion_suspension
		);

		$modificar = $modelRecipes->modificarReceta($id_receta, $datos);

		$receta_medicamentos = $modelRecipes->consultarRecetaUpdate($id_consulta_update);

		if ($modificar) {
			
			$data = [
				'data' => [
					'success'           	 	  	=>  true,
					'message'           	 		=> 'Tratamiento suspendido exitosamente',
					'info'              	 	    =>  '',
					'receta_medicamentos'   		=> $receta_medicamentos
					
				],
				'code' => 0,
			];
			echo json_encode($data);

			exit();

		}else {

			$data = [
				'data' => [
					'success'            =>  false,
					'message'            => 'Error al suspender el tratamiento',
					'info'               =>  ''
				],
				'code' => 0,
			];
			echo json_encode($data);
			exit();

		}
	}

}