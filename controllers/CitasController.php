<?php
function obtener_edad ($fecha_nacimiento)
{
	$nacimiento = new DateTime($fecha_nacimiento);
	$ahora = new DateTime(date("Y-m-d"));
	$diferencia = $ahora->diff($nacimiento);
	return $diferencia->format("%y");
}

require_once './models/CitasModel.php';
require_once './models/EspecialidadModel.php';
require_once './models/PersonasModel.php';
require_once './models/DoctorModel.php';

class CitasController
{

	#estableciendo las vistas
	public function inicioCitas()
	{

		/*HEADER */
		require_once('./views/includes/cabecera.php');

		require_once('./views/paginas/citas/inicioCitas.php');

		/* FOOTER */
		require_once('./views/includes/pie.php');
	}

	public function listarCitas()
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
			SELECT CONCAT(p.tipo_documento,'-',p.n_documento) AS n_documento_paciente, CONCAT(p.p_nombre, ' ', p.p_apellido) AS nombre, c.fecha_cita, E.nombre_especialidad, c.estatus, c.id_cita FROM citas c INNER JOIN personas as p on c.id_persona = p.id_persona INNER JOIN especialidad AS E ON E.id_especialidad = c.id_especialidad ORDER BY c.id_cita DESC) temp
EOT;


		// Table's primary key 
		$primaryKey = 'id_cita';

		$columns = array(

			array('db' => 'fecha_cita',   'dt' => 0),
			array('db' => 'nombre', 'dt' => 1),
			array('db' => 'n_documento_paciente', 'dt' => 2),
			array(
				'db'        => 'estatus',
				'dt'        => 3,
				'formatter' => function ($d, $row) {
					switch ($d) {
						case 0:
							return '<span class="badge bg-danger">Finalizada</span>';
						case 1:
							return '<span class="badge bg-success">Pendiente</span>';
					}
				}
			),
			array('db' => 'estatus', 'dt' => 4),
			array('db' => 'id_cita', 'dt' => 5)

		);


		// Include SQL query processing class 
		require './config/ssp.class.php';

		// Output data as json format 
		echo json_encode(
			SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns)
		);
	}

	/* Consultar Paciente en el modulo citas */
	public function consultarPaciente()
	{

		$modelPacientes = new PacientesModel();

		$n_documento = $_POST['n_documento'];


		$lista = $modelPacientes->consultarPaciente($n_documento);
		foreach ($lista as $listar) {

			$id_persona     = $listar['id_persona'];
			$n_documento     = $listar['n_documento'];
			$NombreApellido = $listar['nombres'] . " " . $listar['apellidos'];
			$telefono     = $listar['telefono'];
			$correo     = $listar['correo'];
			$sexo     = $listar['sexo'];
			$fecha_nacimiento     = $listar['fecha_nacimiento'];
			$direccion     = $listar['estado'] . " municipio " . $listar['municipio'] . " parroqia " . $listar['parroquia'];

		}
		if ($listar) {
			$data = [
				'data' => [
					'success'            =>  true,
					'message'            => 'Registro encontrado',
					'info'               =>  '',
					'id_persona'		 => $id_persona,
					'n_documento'   	 => $n_documento,
					'nombreApellido'     => $NombreApellido,
					'telefono'			 => $telefono,
					'correo'			 => $correo,
					'sexo'			     => $sexo,
					'fecha_nacimiento'	 => $fecha_nacimiento,
					'direccion'			 => $direccion
				],
				'code' => 0,
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


	public function updateConsultarPaciente()
	{

		$modelPacientes = new PacientesModel();

		$n_documento = $_POST['update_n_documento'];



		$listar = $modelPacientes->consultarPaciente($n_documento);
		foreach ($listar as $listar) {

			$id_paciente	    = $listar['id_paciente'];
			$tipo_documento	    = $listar['tipo_documento'];
			$n_documento 		= $listar['n_documento'];
			$nombres 		    = $listar['nombres'];
			$apellidos 		    = $listar['apellidos'];
			$sexo 		        = $listar['sexo'];
			$telefono 		    = $listar['telefono'];
			$estado 		    = $listar['estado'];
			$municipio 		    = $listar['municipio'];
			$parroquia 		    = $listar['parroquia'];
			$correo 		    = $listar['correo'];
			$fecha_nacimiento   = $listar['fecha_nacimiento'];
			$estatus 		    = $listar['estatus'];
			$id_persona 		= $listar['id_persona'];
		}
		if ($listar) {
			$data = [
				'data' => [
					'success'            =>  true,
					'message'            => 'Registro encontrado',
					'info'               =>  '',
					'id_paciente'		 => $id_paciente,
					'tipo_documento'   	 => $tipo_documento,
					'n_documento'    	 => $n_documento,
					'nombres'			 => $nombres,
					'apellidos'			 => $apellidos,
					'sexo'			     => $sexo,
					'telefono'			 => $telefono,
					'estado'			 => $estado,
					'municipio'			 => $municipio,
					'parroquia'			 => $parroquia,
					'correo'			 => $correo,
					'fecha_nacimiento'	 => $fecha_nacimiento,
					'estatus'		     => $estatus,
					'id_persona'         => $id_persona
				],
				'code' => 0,
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


	public function listarActualizacionCita()
	{
		$modelCitas = new CitasModel();
		$modelPersonas = new PersonasModel();
		$modelDoctor = new DoctorModel();
		$id_cita = $_POST['id_cita'];

		$listar = $modelCitas->obtenerDatoCita($id_cita);


		foreach ($listar as $listar) {
			$id_persona	        	= $listar['id_persona'];
			$nom_especialidad	    = $listar['nombre_especialidad'];
			$id_especialidad      	= $listar['id_especialidad'];
			$Nom_doctor	    		= $listar['Nom_doctor'];
			$id_doctor				= $listar['id_doctor'];
			$fecha_cita 			= $listar['fecha_cita'];
			$estatus 		    	= $listar['estatus'];
			$observacion 		    = $listar['observacion'];
		}

		$datos_personas = $modelPersonas->consultarPersonaCita($id_persona);
		$select_doctor  = $modelDoctor->llenarSelectDoctor($id_especialidad);
		
		$data = [
			'data' => [
				'success'            =>  true,
				'message'            => 'Registro encontrado',
				'info'               =>  '',
				'id_cita'		 	 => $id_cita,
				'nom_especialidad'	 => $nom_especialidad,
				'id_especialidad'    => $id_especialidad,
				'Nom_doctor'		 => $Nom_doctor,
				'id_doctor'    	 	 => $id_doctor,
				'fecha_cita'	     => $fecha_cita,
				'estatus'			 => $estatus,
				'observacion'	 	 => $observacion,
				'datos_personas'	 => $datos_personas,
				'select_doctor'		 => $select_doctor
			],
			'code' => 0,
		];

		echo json_encode($data);

		exit();
	}


	public function consultarEspeDoct(){
		$eventos = [];

		$modelCitas = new CitasModel();
		$datos = [];
		$id_especialidad = $_POST['especialidad'];
		$id_doctor = $_POST['doctor'];
		$fecha_cita = $_POST['nuevaFecha'];

		$resultado = $modelCitas->consultarEspe_Doct($id_especialidad, $id_doctor);
		$conteo_FechaCita = $modelCitas->consultarCita_fecha($id_doctor, $fecha_cita);

		foreach ($resultado as $resultados) {
			$nombre_especialidad	= $resultados->nombre_especialidad;
			$nombre_doctor	        = $resultados->nombreDoctor;
		}				

		$data = [
			'data' => [
				'success'            =>  true,
				'message'            => 'Registro encontrado',
				'info'               =>  '',
				'nombre_especialidad'=> $nombre_especialidad,
				'nombre_doctor'		 => $nombre_doctor,
				'conteo_FechaCita'	 => $conteo_FechaCita
			],
			'code' => 0,
		];
		
		echo json_encode($data);
		exit();
	}


	public function consultarEspeHrsDoct(){
		$modelCitas = new CitasModel();
		$datos = [];
		$id_especialidad = $_POST['especialidad'];
		$id_doctor = $_POST['doctor'];

		//$resultado = $modelCitas->consultarEspe_Doct($id_especialidad, $id_doctor);

		/*foreach ($resultado as $resultados) {
			$nombre_especialidad	= $resultados->nombre_especialidad;
			$nombre_doctor	        = $resultados->nombreDoctor;
		}

		$data = [
			'data' => [
				'success'            =>  true,
				'message'            => 'Registro encontrado',
				'info'               =>  '',
				'nombre_especialidad'=> $nombre_especialidad,
				'nombre_doctor'		 => $nombre_doctor,
			],
			'code' => 0,
		];*/

		$datos = [
			'especialidad' => $id_especialidad,
			'doctor' => $id_doctor
		];
		
		echo json_encode($datos);
		exit();
	}

	
	


	public function obtenerCitasDisponibles()
	{

		$modelCitas = new CitasModel();

		$fecha_seleccionada = $_POST['fecha_seleccionada'];
		$doctor_seleccionado = $_POST['doctor_seleccionado'];
	



		$horario = $modelCitas->consultarHorario($doctor_seleccionado);
		foreach ($horario as $horarios) {

			$horas_trabajo	    = $horarios['diferencia_horas'];
		}

		$total_citas 					= $horas_trabajo = $horas_trabajo * 60 / 30; // 30 minutos corresponde al tiempo de duración de cada cita
		$total_registros 				= $modelCitas->totalRegistros($fecha_seleccionada);
		$citas_disponibles 				= $total_citas - $total_registros['total_registros'];

		
		if ($total_registros) {
			$data = [
				'data' => [
					'success'            =>  true,
					'message'            => 'Registro encontrado',
					'info'               =>  '',
					'citas_disponibles'  => $citas_disponibles
				],
				'code' => 0,
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


	public function registrarCita()
	{


		$modelCitas = new CitasModel();

		$fecha = date("Y-m-d"); //obteniendo fecha del registro

		//REGISTRAR CITA
		$datos = array(
			'id_persona'   			  	    => $_POST['ID'],
			'id_doctor'    					=> $_POST['id_doctor_cita'],
			'id_especialidad'		    	=> $_POST['id_especialidad_cita'],
			'observacion'					=> $_POST['observacion_cita'],
			'estatus'					    => $_POST['estatus_cita'],
			'fecha_cita'					=> $_POST['fecha_cita'],
			'fecha_registro'				=> $fecha
		);

		$verificar = $modelCitas->VerificarCita($_POST['ID'], $_POST['id_especialidad_cita'], $_POST['fecha_cita']);

		if (empty($verificar)) {
			$resultado = $modelCitas->registrarCita($datos);
			if ($resultado) {
				$data = [
					'data' => [
						'success'            =>  true,
						'message'            => 'Guardado exitosamente',
						'info'               =>  'La cita ha sido registrada con exito'
					],
					'code' => 1,
				];

				echo json_encode($data);
				exit();
				//FIN REGISTRAR CITA
			}else{
				$data = [
					'data' => [
						'success'            =>  false,
						'message'            => '¡Uy!',
						'info'               =>  'Ocurrio un error inesperado al intentar registrar esta cita.'
					],
					'code' => 0,
				];

				echo json_encode($data);
				exit();
			}
		} else {
			$data = [
				'data' => [
					'success'            =>  false,
					'message'            => '¡Hey!',
					'info'               =>  'Esta persona ya posee una cita registrada para la misma fecha y especialidad.'
				],
				'code' => 0,
			];

			echo json_encode($data);
			exit();
		}
	}

	public function BuscarCitasXFechas(){
		$doctor = $_POST['doctor'];
		$fechaCita = $_POST['fechaCita'];
		$especialidad = $_POST['especialidad'];

		$modelCitas = new CitasModel();
		$modelEspecialidad = new EspecialidadModel();
		$modelDoctor = new DoctorModel();

		$buscar = $modelCitas->BuscarCitasXFechas($doctor, $fechaCita);
		$espe_nom = $modelEspecialidad->obtenerEspecialidad($especialidad);
		$obtenerDoctor = $modelDoctor->obtenerDoctor($doctor);

		//$espe = [];
		foreach ($espe_nom as $key => $value) {
		    $espe = [
		        'nombre_especialidad' => $value['nombre_especialidad']
		    ];
		}

		foreach ($obtenerDoctor as $key => $value) {
		    $doct = [
		        'nombre' => $value['nombre']
		    ];
		}


		if (!empty($buscar)) {
			$resultados = [];
			$num = 0;
			foreach ($buscar as $key => $value) {
			    // Supongamos que queremos almacenar solo los nombres en un nuevo array
			    $num+=1;
			    $resultados[] = [
			    	'num' => $num,
			        'id_cita' => $value['id_cita'],
			        'nombre' => $value['nombre'],
			        'cedula' => $value['cedula'],
			        'fecha_cita' => $value['fecha_cita'],
			        'observacion' => $value['observacion']
			    ];
			}

			$data = [
				'data' => [
					'success'            =>  true,
					'message'            => 'Citas encontradas',
					'info'               =>  '',
					'citas' 			 =>  $resultados,
					'especialidad' 		 =>	 $espe,
					'obtenerDoctor'      =>  $doct
				],
				'code' => 0,
			];

		echo json_encode($data);
		exit();

		}else{
			$data = [
				'data' => [
					'success'            =>  false,
					'message'            => 'Ocurrió un error al buscar las cita',
					'info'               =>  ''
				],
				'code' => 0,
			];

		echo json_encode($data);
		exit();

		}
	}

	public function modificarCita(){
		$modelCitas = new CitasModel();
		$id_cita = $_POST['id_cita'];

		$datos = array (
			'id_cita' 		  => $_POST['id_cita'],
			'id_especialidad' => $_POST['id_especialidad'],
			'id_doctor'       => $_POST['id_doctor'],
			'fecha_cita'      => $_POST['fecha_cita'],
			// 'estatus'         => $_POST['estatus'],
			'observacion'     => $_POST['observacion']
		);

		$resultado = $modelCitas->modificarCita($id_cita, $datos);

		if ($resultado) {
			$data = [
				'data' => [
					'success'            =>  true,
					'message'            => 'Guardado exitosamente',
					'info'               =>  'La cita ha sido modificada con exito'
				],
				'code' => 1,
			];

			echo json_encode($data);
			exit();
		} else {
			$data = [
				'data' => [
					'success'            =>  false,
					'message'            => 'Ocurrió un error al modificar la cita',
					'info'               =>  ''
				],
				'code' => 0,
			];

			echo json_encode($data);
			exit();
		}


	}


	/*----------Metodo para inactivar cita -------*/

	public function finalizarCita()
	{

		$modelCitas = new CitasModel();
		$id_cita = $_POST['id_cita'];

		$estado = $modelCitas->obtenerCita($id_cita);

		foreach ($estado as $estado) {
			$estado_cita = $estado['estatus'];
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

		if ($resultado) {
			$data = [
				'data' => [
					'success'            =>  true,
					'message'            => 'Guardado exitosamente',
					'info'               =>  'La cita se ha finalizado'
				],
				'code' => 1,
			];

			echo json_encode($data);
			exit();
		} else {
			$data = [
				'data' => [
					'success'            =>  false,
					'message'            => 'Ocurrió un error al finalizar la cita',
					'info'               =>  ''
				],
				'code' => 0,
			];

			echo json_encode($data);
			exit();
		}
	}
}

	


?>