<?php

require_once './models/UsuarioModel.php';
require_once './models/PersonasModel.php';
require_once './models/DoctorModel.php';
require_once './config/validacion.php';

class UsuarioController
{

	#estableciendo la vista del login
	public function inicioUsuario()
	{

		require_once('./views/paginas/usuarios/inicioUsuario.php');
	}

	#estableciendo las vistas del modulo usuario
	public function ModuloUsuario()
	{

		/*HEADER */
		require_once('./views/includes/cabecera.php');

		require_once('./views/paginas/usuarios/usuarios.php');

		/* FOOTER */
		require_once('./views/includes/pie.php');
	}


	public function loginUsuario()
	{

		$usuario 		= $_POST['usuario'];
		$contrasena 	= $_POST['contrasena'];


		$modelUsuario = new UsuarioModel();
		$resultados = $modelUsuario->verificarUsuario($usuario, $contrasena);
		


		foreach ($resultados as $resultado) {
		
			$id_bd 				= $resultado['id'];
			$usuario_bd 		= $resultado['usuario'];
			$foto_bd 			= $resultado['foto'];
			$contrasena_bd 		= $resultado['contrasena'];
			$rol_bd 			= $resultado['rol'];
			$nombre_bd 			= $resultado['nombre'];
			$apellido_bd 	    = $resultado['apellido'];
			
		}
		
		

		if (!empty($id_bd)) {

			session_start();

			$_SESSION['user_id'] 		= $id_bd;
			$_SESSION['usuario'] 		= $usuario_bd;
			$_SESSION['foto'] 			= $foto_bd;
			$_SESSION['rol_usuario'] 	= $rol_bd;
			$_SESSION['nombre_user'] 	= $nombre_bd;
			$_SESSION['apellido_user'] 	= $apellido_bd;
		

			
			$data = [
				'data' => [
					'success'            =>  true,
					'message'            => 'Usuario encontrado',
					'info'               =>  ''
				],
				'code' => 1,
			];

			echo json_encode($data);
			exit();
		} else {

			$data = [
				'data' => [
					'success'            =>  false,
					'message'            => 'Nombre de usuario o contraseña incorrectos',
					'info'               =>  'En caso de no estar registrado deberás comunicarte con el administrador para el registro respectivo.'
				],
				'code' => 0,
			];

			echo json_encode($data);
			exit();
		}
	}

	public function logoutUsuario()
	{

		session_start();

		session_unset();

		session_destroy();

		header('Location: index.php?page=inicioUsuario');
	}


	public function listarUsuarios()
	{

		// Database connection info 
		$dbDetails = array(
			'host' => 'localhost',
			'user' => 'root',
			'pass' => '',
			'db'   => 'medicina'
		);

		// Table's primary key 
		$primaryKey = 'id';

		// DB table to use 
		$table = <<<EOT
        (
			SELECT u.id, CONCAT(p.tipo_documento, '-', p.n_documento) AS n_documento, u.usuario, CONCAT(p.p_nombre,' ',p.p_apellido) AS nombres_apellidos, p.correo, u.foto, u.estatus, r.rol FROM usuario AS u INNER JOIN personas AS p ON p.id_persona = u.id_Persona INNER JOIN roles AS r ON r.id = u.id_rol ORDER BY u.id DESC) temp
EOT;


		// Array of database columns which should be read and sent back to DataTables. 
		// The `db` parameter represents the column name in the database.  
		// The `dt` parameter represents the DataTables column identifier. 
		$columns = array(

			array('db' => 'n_documento',  		'dt' => 0),
			array('db' => 'usuario',      	    'dt' => 1),
			array('db' => 'rol',      	        'dt' => 2),
			array('db' => 'nombres_apellidos',  'dt' => 3),
			array(
				'db'        => 'foto',
				'dt'        => 4,
				'formatter' => function ($d, $row) {
					return '<img width="50" src="./foto_usuario/' . $d . '">';
				}
			),
			// array( 'db' => 'fecha',     	'dt' => 9 ), 

			array(
				'db'        => 'estatus',
				'dt'        => 5,
				'formatter' => function ($d, $row) {
					return ($d == 1) ? '<button class="btn btn-success btn-sm">Activo</button>' : '<button class="btn btn-danger btn-sm">Inactivo</button>';
				}
			),
			array('db' => 'id', 'dt' => 6),
			array('db' => 'estatus', 'dt' => 7)

			//array( 'db' => 'fecha_registro','dt' => 9 ),

		);

		// Include SQL query processing class 
		require './config/ssp.class.php';

		// Output data as json format 
		echo json_encode(
			SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns)
		);
	}


	public function registrarUsuario()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		    
		    $datosFormUsuario = $_POST['datosFormUsuario'] ?? null;

		    
		    if (json_last_error() != JSON_ERROR_NONE) {
		        // Maneja el error de decodificación
		        echo json_encode([
		            'success' => false,
		            'message' => 'Error al decodificar los datos JSON.',
		            'info' => json_last_error_msg()
		        ]);
		        exit;
		    }

			if ($datosFormUsuario) {
   		   	 	$modelUsuario = new UsuarioModel();
   		   	 	$modelPersonas = new PersonasModel();
   		   	 	$modelDoctor = new DoctorModel();
   		   	 	$data = json_decode($datosFormUsuario);

   		   	 	$miObjeto = new stdClass();
		    	//Datos de persona//
		    	$miObjeto->p_nombre = $data->p_nombre;
		    	$miObjeto->p_apellido = $data->p_apellido;
		    	$miObjeto->s_nombre = $data->s_nombre;
		    	$miObjeto->s_apellido = $data->s_apellido;
		    	$miObjeto->sexo = $data->sexo;
				$miObjeto->fechaNacimiento = $data->fechaNacimiento;
				$miObjeto->numTelf = $data->numTelf;
				$miObjeto->tipoDoc = $data->tipoDoc;
				$miObjeto->numeroDoc = $data->numeroDoc;
				$miObjeto->correo = $data->correo;
				$miObjeto->direccion_c = $data->direccion_c;
				$miObjeto->tipo_persona = $data->tipo_persona;

				//Datos de horario//
				$miObjeto->horarios = $data->horarios; //viene en arreglo
				
				//datos de usuario//
				$miObjeto->contrasena = $data->contrasena;
				$miObjeto->usuario = $data->usuario;
				$miObjeto->rol = $data->rol;
				$miObjeto->especialidad = $data->especialidad;
				$miObjeto->archivo = $data->archivo;

				$miArreglo = (array) $miObjeto;

				$datosPersona = [];
				$datosDoctor = [];

				$datosPersona = [
			        'tipo_persona' => $miArreglo['tipo_persona'],
			        'n_documento' => $miArreglo['numeroDoc'],
			        'tipo_documento' => $miArreglo['tipoDoc'],
			        'p_nombre' => $miArreglo['p_nombre'],
			        's_nombre' => $miArreglo['s_nombre'],
			        'p_apellido' => $miArreglo['p_apellido'],
			        's_apellido' => $miArreglo['s_apellido'],
			        'fecha_nacimiento' => $miArreglo['fechaNacimiento'],
			        'sexo' => $miArreglo['sexo'],
			        'telefono' => $miArreglo['numTelf'],
			        'direccion' => $miArreglo['direccion_c'],
			        'correo' => $miArreglo['correo'],
			    ];



			    //$data = $datos['numeroDoc']; //Este dato es para registrarPersona($datosPersona); para consultar a la persona que se esta insertando y rescatar el id.
			    $RegistroPersona = $modelPersonas->registrarPersona($datosPersona);


			    $id_especialidad = $miArreglo['especialidad'];
			   	$id_persona = $RegistroPersona['ultimo_id'];
			    
			    $datosDoctor = [
			    	'id_persona' => $id_persona,
					'id_especialidad' => $id_especialidad
			    ];

			    $RegistroDoctor = $modelDoctor->registrarDoctor($datosDoctor);

			    $idDoctor = $RegistroDoctor['ultimo_id'];

			   if ($RegistroPersona == true) {

				   	$horario = $miArreglo['horarios'];			

					$datosHorario = [];

					foreach ($horario as $item) {
					    // Asegúrate de que $item sea un objeto y tenga las propiedades necesarias
					    if (is_object($item) && isset($item->dia, $item->hora_entrada, $item->hora_salida)) {
					        $datosHorario[] = [
					            'dia' => $item->dia,
					            'hora_entrada' => trim($item->hora_entrada),
					            'hora_salida' => trim($item->hora_salida),					            
					        	'id_doctor' => $idDoctor
					        ];
					    } else {
					        echo "Error: El horario no es un objeto válido.\n";
					    }
					}

					$datosUsuario = [];

				   	$datosUsuario = [
				    	'id_Persona' => $id_persona,
				        'usuario' => $miArreglo['usuario'],
				        'foto' => $miArreglo['archivo'],
				        'contrasena' => $miArreglo['contrasena'],
				        'id_rol' => $miArreglo['rol'],
				        'estatus' => 1
				    ];

				    $RegistroUsuario = $modelUsuario->registrarUsuario($datosUsuario);
				    $RegistroHorario = $modelUsuario->registrarHorario($datosHorario);

				    if (!$RegistroUsuario) {
				    	echo json_encode('Hubo problemas al registrar el usuario');
				    	exit();
				    }else{
				    	if (!$RegistroHorario) {
					    	echo json_encode('Hubo problemas al registrar el horario');
					    	exit();
					    }else{
					    	echo json_encode(true);
							exit();
					    }
				    }
			   	
			   }else{
					echo json_encode(false);
					exit();
			   }
   		   }else{
   		   		echo json_encode(false);
			    exit();
   		   }		   		   
		}
	}


	public function verUsuario()
	{
		$modelUsuario = new UsuarioModel();

		$id_usuario = $_POST['id_usuario'];

		$listar = $modelUsuario->obtenerUsuario($id_usuario);


		foreach ($listar as $listar) {

			$id_usuario 	= $listar['id'];
			$cedula 		= $listar['cedula'];
			$usuario 		= $listar['usuario'];
			$nombre 		= $listar['nombre'];
			$apellido 		= $listar['apellido'];
			$correo 		= $listar['correo'];
			$estatus 		= $listar['estatus'];
			$rol 			= $listar['rol'];
			$foto 			= $listar['foto'];
			$fecha 			= $listar['fecha'];
		}

		$data = [
			'data' => [
				'success'            =>  true,
				'message'            => 'Registro encontrado',
				'info'               =>  '',
				'id'				 => $id_usuario,
				'cedula'    		 => $cedula,
				'usuario'			 => $usuario,
				'nombre'			 => $nombre,
				'apellido'			 => $apellido,
				'correo'			 => $correo,
				'estatus'		     => $estatus,
				'rol'		     	 => $rol,
				'foto'		     	 => $foto,
				'fecha'		     	 => $fecha,
			],
			'code' => 0,
		];

		echo json_encode($data);

		exit();
	}

	public function modificarUsuario()
	{

		$validator = array('success' => false, 'messages' => array());

		if (!empty($_FILES["archivo"]["name"])) {

			$modelUsuarios = new UsuarioModel();


			$fileName = basename($_FILES["archivo"]["name"]);
			$targetFilePath = './foto_usuario/' . $fileName;


			$fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

			$allowTypes = array('jpg', 'png', 'jpeg');
			if (in_array($fileType, $allowTypes)) {
				if (copy($_FILES["archivo"]["tmp_name"], $targetFilePath)) {

					$uploadedFile = $fileName;
					$fecha_actual = date("d-m-Y");
					/* comprobar campos vacios */

					if ($_POST['cedula_update'] == "" || $_POST['nombre_update'] == "" || $_POST['apellido_update'] == "" || $_POST['correo_update'] == "" || $_POST['contrasena_update'] == "" || $_POST['usuario_update'] == "" || $_POST['estatus_update'] == "") {
						$data = [
							'data' => [
								'error'        => true,
								'message'      => 'Atención',
								'info'         => 'Verifica que todos los campos estén llenos a la hora de registrar un usuario.'
							],
							'code' => 0,
						];

						echo json_encode($data);
						exit();
					}

					if (Validacion::verificar_datos("[0-9]{1,10}", $_POST['cedula_update'])) {

						$data = [
							'data' => [
								'error'        => true,
								'message'      => 'Datos inválidos',
								'info'         => 'Solo se permiten numeros en el campo cédula del usuario.'
							],
							'code' => 0,
						];

						echo json_encode($data);
						exit();
					}

					if (Validacion::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,40}", $_POST['nombre_update'])) {

						$data = [
							'data' => [
								'error'        => true,
								'message'      => 'Datos inválidos',
								'info'         => 'Solo se permiten caracteres alfabéticos con una longitud de 40 caracteres en el nombre del usuario.'
							],
							'code' => 0,
						];

						echo json_encode($data);
						exit();
					}

					if (Validacion::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,40}", $_POST['apellido_update'])) {

						$data = [
							'data' => [
								'error'        => true,
								'message'      => 'Datos inválidos',
								'info'         => 'Solo se permiten caracteres alfabéticos con una longitud de 40 caracteres en el apellido del usuario.'
							],
							'code' => 0,
						];

						echo json_encode($data);
						exit();
					}

					////



					$id_usuario = $_POST['id_usuario_update'];

					$extraer_datos_usuario = $modelUsuarios->obtenerUsuario($id_usuario);

					foreach ($extraer_datos_usuario as $extraer_datos_usuario) {
						$foto_tbl_usuario 		= $extraer_datos_usuario['foto'];
					}

					//var_dump($foto_tbl_usuario); die();

					$route_photo = './foto_usuario/' . $foto_tbl_usuario;

					$imagen = $route_photo;

					if (file_exists($imagen)) {
						if (unlink($imagen)) {
							//echo "La imagen se ha eliminado correctamente.";
						} else {
							//echo "No se pudo eliminar la imagen.";
						}
					} else {
						//echo "La imagen no existe.";
					}

					$datos = array(
						'cedula'    	=> $_POST['cedula_update'],
						'usuario'		=> $_POST['usuario_update'],
						'nombre'		=> $_POST['nombre_update'],
						'apellido'		=> $_POST['apellido_update'],
						'correo'		=> $_POST['correo_update'],
						'foto'			=> $fileName,
						'contrasena'	=> $_POST['contrasena_update'],
						'rol'			=> $_POST['rol_update'],
						'estatus'		=> $_POST['estatus_update'],
					);

					$resultado = $modelUsuarios->modificarUsuario($id_usuario, $datos);

					if ($resultado) {
						$data = [
							'data' => [
								'success'            =>  true,
								'message'            => 'Guardado exitosamente',
								'info'               =>  'Los datos del usuario han sido modificados'
							],
							'code' => 1,
						];

						echo json_encode($data);
						exit();
					} else {
						$data = [
							'data' => [
								'success'            =>  false,
								'message'            => 'Ocurrió un error al modificar los datos del usuario',
								'info'               =>  ''
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
							'message'            => 'No se copio la imagen',
							'info'               =>  ''
						],
						'code' => 0,
					];

					echo json_encode($data);
					exit();
				}
			} else {
				//$validator['messages'] = 'SOLO SE PERMITE FORMATOS JPG, PNG Y JPEG.';

				$data = [
					'data' => [
						'success'            =>  false,
						'message'            => 'Solo se permiten formatos jpg, png y jpeg.',
						'info'               =>  ''
					],
					'code' => 0,
				];

				echo json_encode($data);
				exit();
			}
		} else {

			$modelUsuarios = new UsuarioModel();
			$id_usuario = $_POST['id_usuario_update'];

			$datos = array(
				'cedula'    	=> $_POST['cedula_update'],
				'usuario'		=> $_POST['usuario_update'],
				'nombre'		=> $_POST['nombre_update'],
				'apellido'		=> $_POST['apellido_update'],
				'correo'		=> $_POST['correo_update'],
				'contrasena'	=> $_POST['contrasena_update'],
				'rol'			=> $_POST['rol_update'],
				'estatus'		=> $_POST['estatus_update'],
			);

			$resultado = $modelUsuarios->modificarUsuario($id_usuario, $datos);

			if ($resultado) {
				$data = [
					'data' => [
						'success'            =>  true,
						'message'            => 'Guardado exitosamente',
						'info'               =>  'Los datos del usuario han sido modificados'
					],
					'code' => 1,
				];

				echo json_encode($data);
				exit();
			} else {
				$data = [
					'data' => [
						'success'            =>  false,
						'message'            => 'Ocurrió un error al modificar los datos del usuario',
						'info'               =>  ''
					],
					'code' => 0,
				];

				echo json_encode($data);
				exit();
			}
		}
	}
	/*----------Metodo para inactivar Usuario-------*/

	public function inactivarUsuario()
	{

		$modelUsuarios = new UsuarioModel();
		$id_usuario = $_POST['id_usuario'];

		$estado = $modelUsuarios->obtenerUsuario($id_usuario);

		foreach ($estado as $estado) {
			$estado_usuario = $estado['estatus'];
		}

		if ($estado_usuario == 1) {
			$datos = array(
				'estatus'		=> 0,
			);

			$resultado = $modelUsuarios->modificarUsuario($id_usuario, $datos);
		} else {
			$datos = array(
				'estatus'		=> 1,
			);

			$resultado = $modelUsuarios->modificarUsuario($id_usuario, $datos);
		}

		if ($resultado) {
			$data = [
				'data' => [
					'success'            =>  true,
					'message'            => 'Guardado exitosamente',
					'info'               =>  'El estado del usuario ha sido modificado'
				],
				'code' => 1,
			];

			echo json_encode($data);
			exit();
		} else {
			$data = [
				'data' => [
					'success'            =>  false,
					'message'            => 'Ocurrió un error al modificar el estado del usuario',
					'info'               =>  ''
				],
				'code' => 0,
			];

			echo json_encode($data);
			exit();
		}
	}
}