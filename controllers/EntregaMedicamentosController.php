<?php

require_once './models/EntregaMedicamentosModel.php';
require_once './models/BancoMedicamentosModel.php';
require_once './models/PersonasModel.php';
class EntregaMedicamentosController
{
	#estableciendo las vistas
	public function inicioEntregaMedicamentos()
	{

		/*HEADER */
		require_once('./views/includes/cabecera.php');

		require_once('./views/paginas/medicamentos/inicioEntregaMedicamentos.php');

		/* FOOTER */
		require_once('./views/includes/pie.php');
	}

	public function listarEntregaMedicamentos()
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
		SELECT id_entrega_medicamento, entrega_medicamentos.id_presentacion_medicamento, cantidad_entrega, parentesco, rango_edad, descripcion, presentacion, presentacion_medicamentos.id_medicamento, presentacion_medicamentos.id_codigo_categoria, medicamentos.nombre_medicamento,  codigo_categoria_medicamento.codigo, codigo_categoria_medicamento.categoria, fecha_entrega, entrega_medicamentos.id_persona, personas.n_documento FROM entrega_medicamentos INNER JOIN presentacion_medicamentos ON entrega_medicamentos.id_presentacion_medicamento = presentacion_medicamentos.id_presentacion_medicamento INNER JOIN medicamentos ON presentacion_medicamentos.id_medicamento = medicamentos.id_medicamento INNER JOIN presentacion ON presentacion_medicamentos.id_presentacion = presentacion.id_presentacion INNER JOIN codigo_categoria_medicamento ON presentacion_medicamentos.id_codigo_categoria = codigo_categoria_medicamento.id_codigo_categoria INNER JOIN personas ON entrega_medicamentos.id_persona = personas.id_persona ORDER BY id_entrega_medicamento DESC) temp
EOT;


		// Table's primary key 
		$primaryKey = 'id_entrega_medicamento';

		// Array of database columns which should be read and sent back to DataTables. 
		// The `db` parameter represents the column name in the database.  
		// The `dt` parameter represents the DataTables column identifier. 
		$columns = array(

			array('db' => 'nombre_medicamento',   'dt' => 0),
			array('db' => 'presentacion',  'dt' => 1),
			array('db' => 'codigo',   'dt' => 2),
			array('db' => 'categoria', 'dt' => 3),
			array( 
                'db'        => 'cantidad_entrega',
                'dt'        => 4, 
                'formatter' => function( $d, $row ) { 
                    return '<button class="btn btn-primary btn-sm" >'.$d.'</button>'; 
                } 
            ),
			array('db' => 'fecha_entrega', 'dt' => 5),
			array('db' => 'n_documento', 'dt' => 6),
			array('db' => 'parentesco', 'dt' => 7),
			array('db' => 'descripcion', 'dt' => 8),
			array('db' => 'id_entrega_medicamento',   'dt' => 9),

		);

		// Include SQL query processing class 
		require './config/ssp.class.php';

		// Output data as json format 
		echo json_encode(
			SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns)
		);
	}

	public function registrarEntregaMedicamento()
	{
		$fecha_registro = date('Y-m-d');
		$modelPersonas = new PersonasModel();
		$modelEntregaMedicamentos = new EntregaMedicamentosModel();
		$modelBancoMedicamentos = new  BancoMedicamentosModel();
		$id_persona = $_POST['id_persona'];
		$id_presentacion_medicamento = intval($_POST['medicamento']);
		$cantidad_entrega =  intval($_POST['cantidad_entrega']);
		
		/* Validar si existe el medicamento en el Almacen*/
		$consulta_existencia_medicamento = $modelBancoMedicamentos->consultarExistenciaMedicamento($id_presentacion_medicamento);
		if (!empty($consulta_existencia_medicamento)) {

			foreach ($consulta_existencia_medicamento as $consulta_existencia_medicamentos) {
				$id_consulta_existencia = $consulta_existencia_medicamentos->id_presentacion_medicamento;
				$id_banco_medicamento = $consulta_existencia_medicamentos->id_banco_medicamento;		
		}

	}
		if(!empty($id_persona)) {

			$datos = array(
				'id_presentacion_medicamento'         => $id_presentacion_medicamento,
				'cantidad_entrega'    	  	  		  => $cantidad_entrega,	  
				'parentesco'	  					  => $_POST['parentesco'],
				'rango_edad'	      				  => $_POST['rango_edad'],
				'descripcion'	      				  => $_POST['descripcion'],
				'fecha_entrega'	 				  	  => $fecha_registro,
				'id_persona'	 				  	  => $id_persona,
			);
			
			$resultado = $modelEntregaMedicamentos->registrarEntregaMedicamento($datos);

			if ($resultado) {

			$restar_existencia = $modelBancoMedicamentos->restarExistencia($id_banco_medicamento, $cantidad_entrega);

				$data = [
					'data' => [
						'success'            =>  true,
						'message'            => 'Guardado exitosamente',
						'info'               =>  'La Entrega fue guardada exitosamente'
					],
					'code' => 1,
				];
	
				echo json_encode($data);
				exit();
			} else {
				$data = [
					'data' => [
						'success'            =>  false,
						'message'            => 'Ocurrió un error al guardar la Entrega',
						'info'               =>  ''
					],
					'code' => 0,
				];
	
				echo json_encode($data);
				exit();
			}

		}
		$datosPersona = array(
			'tipo_documento'            => $_POST['tipo_documento'],	
			'n_documento'    	  	  	=> $_POST['n_documento'],	
			'nombres'  		 			=> $_POST['nombres'],		  
			'apellidos'	  				=> $_POST['apellidos_persona'],
			'correo'	      			=> $_POST['correo'],
			'telefono'	      			=> $_POST['telefono'],
			'sexo'	 				  	=> $_POST['sexo'],
			'id_estado'	 				=> $_POST['estado'],
			'id_municipio'	 			=> $_POST['municipio'],
			'id_parroquia'	 			=> $_POST['parroquia'],
			'fecha_nacimiento'			=> $_POST['fecha_nacimiento'],
			'fecha_registro'			=> $fecha_registro
		);
		$registrar_persona = $modelPersonas->registrarPersona($datosPersona);
		$ultimo_id = $registrar_persona['ultimo_id'];

		$datos = array(
			'id_presentacion_medicamento'         => $id_presentacion_medicamento,
			'cantidad_entrega'    	  	  		  => $cantidad_entrega,	  
			'parentesco'	  					  => $_POST['parentesco'],
			'rango_edad'	      				  => $_POST['rango_edad'],
			'descripcion'	      				  => $_POST['descripcion'],
			'fecha_entrega'	 				  	  => $fecha_registro,
			'id_persona'	 				  	  => $ultimo_id,
		);

		$resultado = $modelEntregaMedicamentos->registrarEntregaMedicamento($datos);
		if ($resultado) {

			$restar_existencia = $modelBancoMedicamentos->restarExistencia($id_banco_medicamento, $cantidad_entrega);
			$data = [
				'data' => [
					'success'            =>  true,
					'message'            => 'Guardado exitosamente',
					'info'               =>  'La Entrega fue guardada exitosamente'
				],
				'code' => 1,
			];

			echo json_encode($data);
			exit();
		} else {
			$data = [
				'data' => [
					'success'            =>  false,
					'message'            => 'Ocurrió un error al guardar la Entrega',
					'info'               =>  ''
				],
				'code' => 0,
			];

			echo json_encode($data);
			exit();
		}
	}

	

}
