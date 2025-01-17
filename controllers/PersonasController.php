<?php
function obtener_edad($fecha_nacimiento)
{
    // Validación: la fecha de nacimiento debe ser menor o igual a la fecha actual
    $fecha_nacimiento_obj = new DateTime($fecha_nacimiento);
    $hoy = new DateTime();

    if ($fecha_nacimiento_obj > $hoy) {
        return "Fecha de nacimiento inválida: no puede ser posterior a la fecha actual.";
    }

    // Si la fecha es válida, procedemos con el cálculo de la edad
    $diferencia = $hoy->diff($fecha_nacimiento_obj);
    return $diferencia->format("%y");
}

require_once './models/PersonasModel.php';

class PersonasController
{

	#estableciendo las vistas
	public function inicio()
	{

		/*HEADER */
		require_once('./views/includes/cabecera.php');

		require_once('./views/paginas/personas/inicio_personas.php');

		/* FOOTER */
		require_once('./views/includes/pie.php');
	}

	public function verPersona()
	{

		/*HEADER */
		require_once('./views/includes/cabecera.php');

		require_once('./views/paginas/personas/verPersona.php');

		/* FOOTER */
		require_once('./views/includes/pie.php');
	}

	public function reporteHistorialMedico()
	{

		require_once('./views/paginas/reportes/reporteHistorialMedico.php');

	}
	

	public function listarPersonas()
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
            SELECT pe.id_persona, CONCAT(pe.tipo_documento, '-', pe.n_documento) AS documento, CONCAT(pe.p_nombre,' ',pe.s_nombre,' ', pe.p_apellido,' ',pe.s_apellido) AS nombres_apellidos, pe.sexo, pe.telefono, pe.correo FROM personas AS pe WHERE pe.tipo_persona = 'paciente' ORDER BY pe.id_persona DESC
        ) temp
        EOT;

		// Table's primary key 
		$primaryKey = 'id_persona';

		// Array of database columns which should be read and sent back to DataTables. 
		// The `db` parameter represents the column name in the database.  
		// The `dt` parameter represents the DataTables column identifier. 
		$columns = array(

			array('db' => 'documento',   	   'dt' => 0),
			array('db' => 'nombres_apellidos', 'dt' => 1),
			array('db' => 'id_persona', 	   'dt' => 2)

		);

		// Include SQL query processing class 
		require './config/ssp.class.php';

		// Output data as json format 
		echo json_encode(
			SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns)
		);
	}


	public function verificarDocumento() {
		if (isset($_POST['n_documento'])) {
			$n_documento = $_POST['n_documento'];
			$modelPersonas = new PersonasModel();
	
			// Verificar si el documento ya existe
			$resultado = $modelPersonas->consultarPersona($n_documento);

			foreach($resultado as $r) {
				$nombres = $r['nombres'];
			}

			if ($nombres != '') {
				$data = [
					'success' => false,
					'message' => 'Este número de documento ya está registrado.'
				];
			} else {
				$data = [
					'success' => true,
					'message' => 'El número de documento está disponible.'
				];
			}
			echo json_encode($data);
			exit();
		}
	}

	public function registrarPersona() {
		$n_documento = $_POST['n_documento'];
		$fecha_registro = date('Y-m-d');
		$modelPersonas = new PersonasModel();
		
		// Datos de la persona
		$datosPersona = array(
			'p_nombre'           => $_POST['primer_nombre'],
			's_nombre'           => $_POST['segundo_nombre'],
			'p_apellido'         => $_POST['primer_apellido'],
			's_apellido'         => $_POST['segundo_apellido'],
			'tipo_documento'     => $_POST['tipo_documento'],
			'n_documento'        => $n_documento,
			'fecha_nacimiento'   => $_POST['fecha_nac'],
			'sexo'               => $_POST['sexo'],
			'telefono'           => $_POST['telefono'],
			'correo'             => $_POST['correo'],
			'direccion'          => $_POST['direccion'],
			'tipo_persona'       => $_POST['tipo_persona'],
			'fecha_registro'     => $fecha_registro
		);
	
	
		// Registrar la persona
		$resultado = $modelPersonas->registrarPersona($datosPersona);

		
		
		
		if ($resultado) {
			$data = [
				'data' => [
					'success'            =>  true,
					'message'            => 'Guardado exitosamente',
					'info'               =>  'La persona ha sido registrada con exito'
				],
				'code' => 1,
			];

			echo json_encode($data);
			exit();
		} else {
			$data = [
				'data' => [
					'success'            =>  false,
					'message'            => 'Ocurrió un error al registrar la persona',
					'info'               =>  ''
				],
				'code' => 0,
			];

			echo json_encode($data);
			exit();
		}
		
	}

	/* Registrar historia médica */

	public function registrarHistoriaMedica(){

		$modelPersonas = new PersonasModel();
		$fecha_registro = date('Y-m-d');
		$jsonData = file_get_contents('php://input');
		$data = json_decode($jsonData, true);
		
		$medicado = $data['medicado'];

		
		/* Historial medico */
		$datos_h_medica =  array(
			'tipo_sangre'                  => $data['tipo_sangre'],
			'fumador'     		           => $data['fumador'],
			'alcohol'           	       => $data['alcohol'],
			'actividad_fisica'  		   => $data['ac_fisica'],
			'antec_fami'  		           => $data['antec_fami'],
			'medicado'           		   => $medicado,
			'cirugia_hospitalaria'         => $data['ciru_hospi'],
			'alergia'			 		   => $data['alergia'],
		    'id_persona'		           => $data['id_persona_h'],
			'frecuencia_f'		           => $data['frecuencia_f'],
			'frecuencia_alcohol'		   => $data['frecuencia_alcohol'],
			'frecuencia_ac_f'		       => $data['frecuencia_ac_f'],
			'fecha_reg'                    => $fecha_registro
		);

		$resultado = $modelPersonas->registrarHistoriaMedica($datos_h_medica);
		$id_historia_medica = $resultado['ultimo_id'];

		//Registro de medicamentos

		if($medicado === "Sí") {

			$medicamentos = $data['medicamentos'];

		foreach($medicamentos as $medicamento) {
			$id_medicamento = $medicamento;

			$datos_medicamentos =  array(
				'id_presentacion_medicamento'  => $id_medicamento,
				'id_historia_medica'     	   => $id_historia_medica,
				
			);
			$resultado_medic = $modelPersonas->registrarMedicamentos($datos_medicamentos);
		}

		}

		
		/*Registro de enfermedades */

		$enfermedades = $data['enfermedades'];

		if(!empty($enfermedades)) {
			foreach($enfermedades as $enfermedad) {
				$id_enfermedad = $enfermedad;
	
				$datos_enfermedades =  array(
					'id_patologia'                 => $id_enfermedad,
					'id_historia_medica'     	   => $id_historia_medica,
					'id_persona_h'				   => $id_persona_h
					
				);
				$resultado_enferm = $modelPersonas->registrarEnfermedades($datos_enfermedades);
			}

			

		}

		if ($resultado) {
			$data = [
				'data' => [
					'success'            =>  true,
					'message'            => 'Guardado exitosamente',
					'info'               =>  'La historia médica se ha guardado con exito'
				],
				'code' => 1,
			];

			echo json_encode($data);
			exit();
		} else {
			$data = [
				'data' => [
					'success'            =>  false,
					'message'            => 'Ocurrió un error al guardar la historia medica',
					'info'               =>  ''
				],
				'code' => 0,
			];

			echo json_encode($data);
			exit();
		}

	}


	public function registrarRepresentante() {
		$fecha_registro = date('Y-m-d');
		$modelPersonas = new PersonasModel();
		$id_representado = $_POST['id_representado'];
			
		// Datos personales del representante
		$datos = array(
			'p_nombre'            => $_POST['primer_nombre_r'],
			's_nombre'            => $_POST['segundo_nombre_r'],
			'p_apellido'          => $_POST['primer_apellido_r'],
			's_apellido'          => $_POST['segundo_apellido_r'],
			'tipo_documento'      => $_POST['tipo_documento_r'],
			'n_documento'         => $_POST['n_documento_r'],
			'telefono'            => $_POST['telefono_r'],
			'correo'              => $_POST['correo_r'],
			'direccion'           => $_POST['direccion_r'],
			'fecha_registro'      => $fecha_registro
		);

	
	$registro_p = $modelPersonas->registrarPersona($datos);
	$ultimo_id = $registro_p['ultimo_id'];

		// Datos tbl representante
		$datosRepresentante = array(
			'parentesco'         => $_POST['parentesco'],
			'id_persona'         => $ultimo_id
		);

	$registro_r  = $modelPersonas->registrarRepresentante($datosRepresentante);
	$ultimo_id_r = $registro_r['ultimo_id'];

		// Datos tbl representado
		$datosRepresentado = array(
			// 'parentesco'         => $_POST['parentesco'],
			'id_persona'         => $id_representado
		);

	$registro_representado  = $modelPersonas->registrarRepresentado($datosRepresentado);
	$ultimo_id_representado = $registro_representado['ultimo_id'];

		//Registro tbl intermedia

		$datosTblIntermdia = array(
			'id_representante'   => $ultimo_id_r,
			'id_persona'         => $ultimo_id_representado
		);

	$resultado = $modelPersonas->registrarTblIntermedia($datosTblIntermdia);

	if ($resultado) {
		$data = [
			'data' => [
				'success'            =>  true,
				'message'            => 'Guardado exitosamente',
				'info'               => 'El representante ha sido registrado con exito',
				'id_representado'		 => $id_representado
			],
			'code' => 1,
		];

		echo json_encode($data);
		exit();
	} else {
		$data = [
			'data' => [
				'success'            =>  false,
				'message'            => 'Ocurrió un error al registrar el representante',
				'info'               =>  ''
			],
			'code' => 0,
		];

		echo json_encode($data);
		exit();
	}

		
	}


	public function registrarRepresentado() {
		$fecha_registro = date('Y-m-d');
		$modelPersonas = new PersonasModel();
		$id_representante = $_POST['id_representante'];
			
		// Datos personales del representante
		$datos = array(
			'p_nombre'            => $_POST['primer_nombre_re'],
			's_nombre'            => $_POST['segundo_nombre_re'],
			'p_apellido'          => $_POST['primer_apellido_re'],
			's_apellido'          => $_POST['segundo_apellido_re'],
			'tipo_documento'      => $_POST['tipo_documento_re'],
			'n_documento'         => $_POST['n_documento_re'],
			'telefono'            => $_POST['telefono_re'],
			'correo'              => $_POST['correo_re'],
			'direccion'           => $_POST['direccion_re'],
			'fecha_registro'      => $fecha_registro
		);

	
	$registro_p = $modelPersonas->registrarPersona($datos);
	$ultimo_id_p = $registro_p['ultimo_id'];

		// Datos tbl representados
		$datosRepresentado = array(
			'parentesco'         => $_POST['parentesco'],
			'id_persona'         => $ultimo_id_p
		);

	$registro_representado  = $modelPersonas->registrarRepresentado($datosRepresentado);
	$ultimo_id_representado = $registro_representado['ultimo_id'];

	// Datos tbl representante
	$datosRepresentante = array(
		// 'parentesco'         => $_POST['parentesco'],
		'id_persona'         => $id_representante
	);

	$registro_representante  = $modelPersonas->registrarRepresentante($datosRepresentante);
	$ultimo_id_representante = $registro_representante['ultimo_id'];

		//Registro tbl intermedia

		$datosTblIntermedia = array(
			'id_representante'   => $ultimo_id_representante,
			'id_persona'         => $ultimo_id_representado
		);

	$resultado = $modelPersonas->registrarTblIntermedia($datosTblIntermedia);

	if ($resultado) {
		$data = [
			'data' => [
				'success'            =>  true,
				'message'            => 'Guardado exitosamente',
				'info'               => 'El representado ha sido registrado con exito',
				'id_representante'	 => $id_representante
			],
			'code' => 1,
		];

		echo json_encode($data);
		exit();
	} else {
		$data = [
			'data' => [
				'success'            =>  false,
				'message'            => 'Ocurrió un error al registrar el representado',
				'info'               =>  ''
			],
			'code' => 0,
		];

		echo json_encode($data);
		exit();
	}

		
	}
	


	public function selectEstado()
	{
		$modelPersonas = new PersonasModel();
		$estados = $modelPersonas->selectEstado();
		return $estados;
	}

	public function selectMunicipio()
	{
		$modelPersonas = new PersonasModel();
		$estados = $modelPersonas->selectMunicipio();
		return $estados;
	}

	public function selectParroquia()
	{
		$modelPersonas = new PersonasModel();
		$estados = $modelPersonas->selectParroquia();
		return $estados;
	}




	public function llenarSelectEstado()
	{
		$modelPersonas = new PersonasModel();
		$elegido = $_POST['elegido'];
		$data = $modelPersonas->llenarSelectMunicipio($elegido);

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


	public function listarDatosPersona()
{
    $modelPersonas = new PersonasModel();

    $id_persona = $_POST['id_persona'];

    $listar = $modelPersonas->listarDatosPersona($id_persona);

    if (empty($listar)) {
        $data = [
            'data' => [
                'success' => false,
                'message' => 'No se encontraron registros para esta persona',
                'info' => ''
            ],
            'code' => 1,
        ];
    } else {
        foreach ($listar as $listar) {
            $tipo_documento     = $listar['tipo_documento'];
            $n_documento        = $listar['n_documento'];
            $nombres            = $listar['nombres'];
            $apellidos          = $listar['apellidos'];
            $sexo               = $listar['sexo'];
            $telefono           = $listar['telefono'];
			$direccion          = $listar['direccion'];
            $correo             = $listar['correo'];
            $fecha_nacimiento   = $listar['fecha_nacimiento'];
            $id_persona         = $listar['id_persona'];
        }

        $data = [
            'data' => [
                'success'            => true,
                'message'            => 'Registro encontrado',
                'info'               => '',
                'tipo_documento'     => $tipo_documento,
                'n_documento'        => $n_documento,
                'nombres'            => $nombres,
                'apellidos'          => $apellidos,
                'sexo'               => $sexo,
                'telefono'           => $telefono,
                'direccion'          => $direccion,
                'correo'             => $correo,
                'fecha_nacimiento'   => $fecha_nacimiento,
                'id_persona'         => $id_persona
            ],
            'code' => 0,
        ];
    }

    echo json_encode($data);
    exit();
}

public function listarDatosUpdate()
{
    $modelPersonas = new PersonasModel();

    $id_persona = $_POST['id_persona'];

    $listar = $modelPersonas->listarDatosUpdate($id_persona);

    if (!empty($listar)) {

		foreach ($listar as $listar) {
            $tipo_documento     = $listar['tipo_documento'];
            $n_documento        = $listar['n_documento'];
            $p_nombre           = $listar['p_nombre'];
			$s_nombre			= $listar['s_nombre'];
			$p_apellido			= $listar['p_apellido'];
			$s_apellido			= $listar['s_apellido'];
            $sexo               = $listar['sexo'];
            $telefono           = $listar['telefono'];
			$direccion          = $listar['direccion'];
            $correo             = $listar['correo'];
            $fecha_nacimiento   = $listar['fecha_nacimiento'];
            $id_persona         = $listar['id_persona'];
        }

        $data = [
            'data' => [
                'success'            => true,
                'message'            => 'Registro encontrado',
                'info'               => '',
                'tipo_documento'     => $tipo_documento,
                'n_documento'        => $n_documento,
                'p_nombre'           => $p_nombre,
                's_nombre'	         => $s_nombre,
				'p_apellido'		 => $p_apellido,
				's_apellido'		 => $s_apellido,
                'sexo'               => $sexo,
                'telefono'           => $telefono,
                'direccion'          => $direccion,
                'correo'             => $correo,
                'fecha_nacimiento'   => $fecha_nacimiento,
                'id_persona'         => $id_persona
            ],
            'code' => 0,
        ];
    } else {

		$data = [
            'data' => [
                'success' => false,
                'message' => 'No se encontraron registros para esta persona',
                'info' => ''
            ],
            'code' => 1,
        ];
        
    }

    echo json_encode($data);
    exit();
}




	public function llenarSelectParroquia()
	{
		$modelPersonas = new PersonasModel();
		$elegido = $_POST['municipio'];
		$data = $modelPersonas->llenarSelectParroquia($elegido);

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


	public function consultarPersona()
	{	
		
		$n_documento_persona = $_POST['n_documento_persona'];
		$modelPersonas = new PersonasModel();
		$listar = $modelPersonas->consultarPersona($n_documento_persona);


		foreach ($listar as $lista) {
			$id_persona				= $lista['id_persona'];
			$n_documento_persona 	= $lista['documento'];
			$nombres_persona 		= $lista['nombres'];
			$sexo_persona 		    = $lista['sexo'];
			$fecha_nac  			= $lista['fecha_nacimiento'];
			$tlf_persona 		    = $lista['telefono'];
			$direccion 				= $lista['direccion'];
		}

		$edad_persona = obtener_edad($fecha_nac);
			
		if ($nombres_persona != "") {
			
			$data = [
				'data' => [
					'success'           	 	  	=>  true,
					'message'           	 		=> 'Registro encontrado',
					'info'              	 	    =>  '',
					'id_persona'		   			=> $id_persona,
					'n_documento_persona' 			=> $n_documento_persona,
					'nombres' 		    => $fecha_nac,
					'nombres_persona'				=> $nombres_persona,
					'sexo_persona'			    	=> $sexo_persona,
					'tlf_persona'			    	=> $tlf_persona,
					'direccion'						=> $direccion,
					'edad'							=> $edad_persona,
				],
				'code' => 0,
			];

			
			echo json_encode($data);
			exit();
		}else {

			$data = [
				'data' => [
					'success'            =>  false,
					'message'            => 'Atención!',
					'info'               =>  'Este numero de documento no esta registrado '
				],
				'code' => 0,
			];
			echo json_encode($data);
			exit();

		}
		
	}


	/* Metodo para consultar persona usuario */

	public function consultarPersonaUsuario()
	{	
		
		$n_documento_persona = $_POST['n_documento_persona'];
		$modelPersonas = new PersonasModel();
		$listar = $modelPersonas->consultarPersonaUsuario($n_documento_persona);


		foreach ($listar as $lista) {
			$id_persona			= $lista['id_persona'];
			$tipo_documento 	= $lista['tipo_documento'];
			$n_documento 		= $lista['n_documento'];
			$p_nombre 		    = $lista['p_nombre'];
			$s_nombre  			= $lista['s_nombre'];
			$p_apellido 		= $lista['p_apellido'];
			$s_apellido 		= $lista['s_apellido'];
			$telefono 			= $lista['telefono'];
			$fecha_nac 			= $lista['fecha_nacimiento'];
			$sexo 				= $lista['sexo'];
			$correo 			= $lista['correo'];
			$direccion 			= $lista['direccion'];			
		}

		//$edad_persona = obtener_edad($fecha_nac);
			
		if (!empty($n_documento)) {
			
			$data = [
				'data' => [
					'success'           	 	  	=>  true,
					'message'           	 		=> 'Registro encontrado',
					'info'              	 	    =>  '',
					'id_persona'		   			=> $id_persona,
					'tipo_documento'				=> $tipo_documento,
					'n_documento_persona' 			=> $n_documento,
					'p_nombre'						=> $p_nombre,
					's_nombre'						=> $s_nombre,
					'telefono'						=> $telefono,
					'p_apellido'					=> $p_apellido,
					's_apellido'					=> $s_apellido,
					'fecha_nac'						=> $fecha_nac,
					//'edad_persona'			    	=> $edad_persona,
					'sexo'			    			=> $sexo,
					'correo'						=> $correo,
					'direccion'						=> $direccion
				],
				'code' => 0,
			];
			echo json_encode($data);
			exit();
		}else{

			$data = [
				'data' => [
					'success'            =>  false,
					'message'            => 'Atención!',
					'info'               =>  'Este numero de documento no esta registrado '
				],
				'code' => 0,
			];
			echo json_encode($data);
			exit();

		}		
	}


	/* Metodo para consultar persona / Modulo consulta */

	public function consultarPersonaC()
	{	
		
		$n_documento_persona = $_POST['n_documento_persona'];
		$modelPersonas = new PersonasModel();
		$listar = $modelPersonas->consultarPersonaC($n_documento_persona);


		foreach ($listar as $lista) {

			//Datos del paciente

			$id_persona				= $lista['id_paciente'];
			$n_documento_persona 	= $lista['documento_paciente'];
			$nombres_persona 		= $lista['nombres_paciente'];
			$sexo_persona 		    = $lista['sexo'];
			$fecha_nac  			= $lista['fecha_nacimiento'];
			$tlf_persona 		    = $lista['telefono'];
			$direccion 				= $lista['direccion'];

			//Datos de la cita agendada

			$especialidad				= $lista['nombre_especialidad'];
			$especialista				= $lista['nombres_especialista'];
			$observacion				= $lista['observacion'];
			$estatus					= $lista['estatus'];
			$fecha						= $lista['fecha_cita'];
			$validar_fecha			    = $lista['validar_fecha'];
			$id_cita					= $lista['id_cita'];
			$id_especialidad			= $lista['id_especialidad'];
			$id_especialista			= $lista['id_especialista'];

		}

		$edad_persona = obtener_edad($fecha_nac);
			
		if ($nombres_persona != "") {
			
			$data = [
				'data' => [
					'success'           	 	  	=>  true,
					'message'           	 		=> 'Registro encontrado',
					'info'              	 	    =>  '',
					'id_persona'		   			=> $id_persona,
					'n_documento_persona' 			=> $n_documento_persona,
					'nombres_persona'				=> $nombres_persona,
					'sexo_persona'			    	=> $sexo_persona,
					'tlf_persona'			    	=> $tlf_persona,
					'direccion'						=> $direccion,
					'edad'							=> $edad_persona,
					// Datos de la cita agendada
					'especialidad'				    => $especialidad,
					'especialista'					=> $especialista,
					'observacion'					=> $observacion,
					'estatus'						=> $estatus,
					'fecha'							=> $fecha,
					'id_cita'						=> $id_cita,
					'id_especialidad' 				=> $id_especialidad,
					'id_especialista'				=> $id_especialista,
					'validar_fecha'				    => $validar_fecha
				],
				'code' => 0,
			];

			
			echo json_encode($data);
			exit();
		}else {

			$data = [
				'data' => [
					'success'            =>  false,
					'message'            =>  'Atención!',
					'info'               =>  'Este numero de documento no esta registrado '
				],
				'code' => 0,
			];
			echo json_encode($data);
			exit();

		}
		
	}

	/*Consultar Representante*/ 
	
	public function consultarRepresentante()
	{	
		
		$documento_representante = $_POST['documento_representante'];
		$modelPersonas = new PersonasModel();
		$listar = $modelPersonas->consultarRepresentante($documento_representante);


		foreach ($listar as $lista) {
			$id_representante				= $lista['id_representante'];
			$id_persona_r				    = $lista['id_persona'];
			$documento_representante 	    = $lista['documento'];
			$nombres 						= $lista['nombres'];
			$apellidos 						= $lista['apellidos'];
			$parentesco						= $lista['parentesco'];
			

		}


		if ($nombres != "") {
			
			$data = [
				'data' => [
					'success'           	 	  	=>  true,
					'message'           	 		=> 'Representante encontrado',
					'info'              	 	    =>  '',
					'id_representante'		   	    => $id_representante,
					'id_persona_r'				    => $id_persona_r,
					'documento_representante' 	    => $documento_representante,
					'nombres' 		                => $nombres,
					'apellidos'				        => $apellidos,
					'parentesco'				    => $parentesco
				],
				'code' => 0,
			];

			
			echo json_encode($data);
			exit();
		}else {

			$data = [
				'data' => [
					'success'            =>  false,
					'message'            => 'Atención!',
					'info'               =>  'Este numero de documento no esta registrado '
				],
				'code' => 0,
			];
			echo json_encode($data);
			exit();

		}
		
	}



	public function modificarPersona()
	{
		
		$modelPersonas = new PersonasModel();
		$id_persona = $_POST['id_persona'];

		$datosPersona = array(

			'tipo_documento'   	 => $_POST['tipo_documento'],
			'n_documento'        => $_POST['n_documento'],
			'p_nombre'			 => $_POST['p_nombre'],
			's_nombre'			 => $_POST['s_nombre'],
			'p_apellido'		 => $_POST['p_apellido'],
			's_apellido'		 => $_POST['s_apellido'],
			'sexo'			     => $_POST['sexo'],
			'telefono'			 => $_POST['telefono'],
			'correo'			 => $_POST['correo'],
			'fecha_nacimiento'	 => $_POST['fecha_nac'],
			'direccion'	         => $_POST['direccion']
		);


		$resultado = $modelPersonas->modificarPersona($id_persona, $datosPersona);
		
		if ($resultado) {
			$data = [
				'data' => [
					'success'            =>  true,
					'message'            => 'Guardado exitosamente',
					'info'               =>  'Los datos de la persona han sido modificados'
				],
				'code' => 1,
			];

			echo json_encode($data);
			exit();
		} else {
			$data = [
				'data' => [
					'success'            =>  false,
					'message'            => 'Ocurrió un error al modificar los datos de la persona',
					'info'               =>  ''
				],
				'code' => 0,
			];

			echo json_encode($data);
			exit();
		}
	}

	public function consultarEdad() {
		$fecha_nac = $_POST['fecha_nac'];
		$edad = obtener_edad($fecha_nac);
		$data = [
			'data' => [
				'success'            =>  true,
				'message'            => 'Consulta exitosa',
				'info'               => '',
				'edad'			     => intval($edad)
			],
			'code' => 1,
		];
		echo json_encode($data);
		exit();

}

}