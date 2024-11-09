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
            SELECT pe.id_persona, CONCAT(pe.tipo_documento, '-', pe.n_documento) AS documento, CONCAT(pe.nombres, ' ', pe.apellidos) AS nombre_apellido, pe.sexo, pe.telefono, pe.correo FROM personas AS pe ORDER BY pe.id_persona DESC
        ) temp
        EOT;

		// Table's primary key 
		$primaryKey = 'id_persona';

		// Array of database columns which should be read and sent back to DataTables. 
		// The `db` parameter represents the column name in the database.  
		// The `dt` parameter represents the DataTables column identifier. 
		$columns = array(

			array('db' => 'documento',   	'dt' => 0),
			array('db' => 'nombre_apellido','dt' => 1),
			array('db' => 'id_persona', 	'dt' => 2)

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
			'nombres'            => $_POST['nombres'],
			'apellidos'          => $_POST['apellidos'],
			'tipo_documento'     => $_POST['tipo_documento'],
			'n_documento'        => $n_documento,
			'fecha_nacimiento'   => $_POST['fecha_nac'],
			'sexo'               => $_POST['sexo'],
			'telefono'           => $_POST['telefono'],
			'correo'             => $_POST['correo'],
			'direccion'          => $_POST['direccion'],
			'fecha_registro'     => $fecha_registro
		);
	
		// Registrar la persona
		$resultado_p = $modelPersonas->registrarPersona($datosPersona);
		$ultimo_id_persona = $resultado_p['ultimo_id'];

		
		
		// Verificar si vienen los datos del representante
		if (!empty($_POST['nombres_r']) && !empty($_POST['apellidos_r']) && !empty($_POST['tipo_documento_r']) && !empty($_POST['n_documento_r'])) {
			// Datos personales del representante
			$datosPersonalesRepresentante = array(
				'nombres'            => $_POST['nombres_r'],
				'apellidos'          => $_POST['apellidos_r'],
				'tipo_documento'     => $_POST['tipo_documento_r'],
				'n_documento'        => $_POST['n_documento_r'],
				'telefono'           => $_POST['telefono_r'],
				'correo'             => $_POST['correo_r'],
				'direccion'          => $_POST['direccion_r'],
				'fecha_registro'     => $fecha_registro
			);
	
			$registro_persona_r = $modelPersonas->registrarPersona($datosPersonalesRepresentante);
			$id_persona_r = $registro_persona_r['ultimo_id'];
			
			// Datos del representante
			$datosRepresentante = array(
				'parentesco'         => $_POST['parentesco'],
				'id_persona'         => $id_persona_r
			);
	
			$registro_r = $modelPersonas->registrarRepresentante($datosRepresentante);
			$ultimo_id_r = $registro_r['ultimo_id'];

			$datosTblIntermdia = array(
				'id_representante'   => $ultimo_id_r,
				'id_persona'         => $ultimo_id_persona
			);
			$resultado = $modelPersonas->registrarTblIntermedia($datosTblIntermdia);

		if($resultado['ejecutar']) {
			$data = [
				'data' => [
					'success' => true,
					'message' => 'La persona y su representante ha sido registrado con exito',
					'info' => 'Guardado exitosamente'
				],
				'code' => 1,
			];
			echo json_encode($data);
			exit();

		}else{
			
		}

		}elseif(!empty($_POST['id_representante']) && !empty($_POST['id_persona_r']) ) {

		/*  Registro del representante y menor en la tabla intermedia (representantes_personas) */
		
		$datosTblIntermdia = array(
			'id_representante'   => $_POST['id_representante'],
			'id_persona'         => $ultimo_id_persona
		);
		$modelPersonas->registrarTblIntermedia($datosTblIntermdia);

		$data = [
			'data' => [
				'success' => true,
				'message' => 'La persona y su representante ha sido registrado con exito',
				'info' => ''
			],
			'code' => 1,
		];

		echo json_encode($data);
		exit(); 
	} elseif(!empty($_POST['id_persona_r'])) {
		// Registrar Representante
		$datosRepresentante = array(
			'parentesco'         => $_POST['parentesco'],
			'id_persona'         => $_POST['id_persona_r']
		);

		$registro_r = $modelPersonas->registrarRepresentante($datosRepresentante);
		$ultimo_id_r = $registro_r['ultimo_id'];

		$datosTblIntermdia = array(
			'id_representante'   => $ultimo_id_r,
			'id_persona'         => $ultimo_id_persona
		);
		$modelPersonas->registrarTblIntermedia($datosTblIntermdia);

		$data = [
			'data' => [
				'success' => true,
				'message' => 'La persona y su representante ha sido registrada exitosamente',
				'info' => ''
			],
			'code' => 1,
		];
		
	echo json_encode($data);
	exit();
	}

			
	
	else {
			$data = [
				'data' => [
					'success' => true,
					'message' => 'La persona ha sido registrada con exito',
					'info' => ''
				],
				'code' => 1,
			];
		}
	
		echo json_encode($data);
		exit();
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
			'nombres'			 => $_POST['nombres'],
			'apellidos'			 => $_POST['apellidos'],
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