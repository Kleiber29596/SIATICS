<?php

require_once 'config.php';

$page = $_GET['page'];

if (!empty($page)) {
	#http://crud-mvc/index.php?page=insertar
	$data = array(
		'inicio' => array('model' => 'dashboardModel', 'view' => 'inicio', 'controller' => 'dashboardController'),
		'inicioProfile' => array('model' => 'dashboardModel', 'view' => 'inicioProfile', 'controller' => 'dashboardController'),
		'grafica' => array('model' => 'dashboardModel', 'view' => 'grafica', 'controller' => 'dashboardController'),
		'sexo' => array('model' => 'dashboardModel', 'view' => 'sexo', 'controller' => 'dashboardController'),
		'edad' => array('model' => 'dashboardModel', 'view' => 'edad', 'controller' => 'dashboardController'),
		'filtro' => array('model' => 'dashboardModel', 'view' => 'filtro', 'controller' => 'dashboardController'),
		'todosTiposConsulta' => array('model' => 'dashboardModel', 'view' => 'todosTiposConsulta', 'controller' => 'dashboardController'),

		'inicioUsuario' => array('model' => 'UsuarioModel', 'view' => 'inicioUsuario', 'controller' => 'UsuarioController'),
		'loginUsuario' => array('model' => 'UsuarioModel', 'view' => 'loginUsuario', 'controller' => 'UsuarioController'),
		'logoutUsuario' => array('model' => 'UsuarioModel', 'view' => 'logoutUsuario', 'controller' => 'UsuarioController'),
		/*Url Modulo Usuario*/
		'listarUsuarios' => array('model' => 'UsuarioModel', 'view' => 'listarUsuarios', 'controller' => 'UsuarioController'),
		'ModuloUsuario' => array('model' => 'UsuarioModel', 'view' => 'ModuloUsuario', 'controller' => 'UsuarioController'),
		'registrarUsuario' => array('model' => 'UsuarioModel', 'view' => 'registrarUsuario', 'controller' => 'UsuarioController'),
		'verUsuario' => array('model' => 'UsuarioModel', 'view' => 'verUsuario', 'controller' => 'UsuarioController'),
		'modificarUsuario' => array('model' => 'UsuarioModel', 'view' => 'modificarUsuario', 'controller' => 'UsuarioController'),
		'inactivarUsuario' => array('model' => 'UsuarioModel', 'view' => 'inactivarUsuario', 'controller' => 'UsuarioController'),
		'registrarUsuarioConFoto' => array('model' => 'UsuarioModel', 'view' => 'registrarUsuarioConFoto', 'controller' => 'UsuarioController'),

		/* Modulo Roles */
		'inicioRoles' => array('model' => 'RolesModel', 'view' => 'inicioRoles', 'controller' => 'RolesController'),
		'listarRoles' => array('model' => 'RolesModel', 'view' => 'listarRoles', 'controller' => 'RolesController'),
		'registrarRoles' => array('model' => 'RolesModel', 'view' => 'registrarRoles', 'controller' => 'RolesController'),
		'verRoles' => array('model' => 'RolesModel', 'view' => 'verRoles', 'controller' => 'RolesController'),
		'modificarRoles' => array('model' => 'RolesModel', 'view' => 'modificarRoles', 'controller' => 'RolesController'),
		'inactivarRoles' => array('model' => 'RolesModel', 'view' => 'inactivarRoles', 'controller' => 'RolesController'),

		/* Modulo Especialidad*/
		'inicioEspecialidad' => array('model' => 'EspecialidadModel', 'view' => 'inicioEspecialidad', 'controller' => 'EspecialidadController'),
		'listarEspecialidades' => array('model' => 'EspecialidadModel', 'view' => 'listarEspecialidades', 'controller' => 'EspecialidadController'),
		'registrarEspecialidad' => array('model' => 'EspecialidadModel', 'view' => 'registrarEspecialidad', 'controller' => 'EspecialidadController'),
		'listarActualizacionEspecialidad' => array('model' => 'EspecialidadModel', 'view' => 'listarActualizacionEspecialidad', 'controller' => 'EspecialidadController'),
		'modificarEspecialidad' => array('model' => 'EspecialidadModel', 'view' => 'modificarEspecialidad', 'controller' => 'EspecialidadController'),
		'inactivarEspecialidad' => array('model' => 'EspecialidadModel', 'view' => 'inactivarEspecialidad', 'controller' => 'EspecialidadController'),
		
		/* Modulo Personas*/
		'llenarSelectEstado' 		=> array('model'   => 'PersonasModel', 'view'   => 'llenarSelectEstado',     'controller'     => 'PersonasController'),
		'llenarSelectParroquia' 	=> array('model'   => 'PersonasModel', 'view'   => 'llenarSelectParroquia',  'controller'     => 'PersonasController'),
		'registrarPersona' 			=> array('model'   => 'PersonasModel', 'view'   => 'RegistrarPersona',       'controller'     => 'PersonasController'),
		'registrarRepresentante'    => array('model'   => 'PersonasModel', 'view'   => 'registrarRepresentante', 'controller'     => 'PersonasController'),
		'listarDatosPersona'		=> array('model'   => 'PersonasModel', 'view'   => 'listarDatosPersona',     'controller'     => 'PersonasController'),
		'verDatosPersona'			=> array('model'   => 'PersonasModel', 'view'   => 'verDatosPersona',        'controller'     => 'PersonasController'),
		'listarPersonas'   			=> array('model'   => 'PersonasModel', 'view'   => 'listarPersonas',         'controller'     => 'PersonasController'),
		'modificarPersona' 			=> array('model'   => 'PersonasModel', 'view'   => 'modificarPersona',       'controller'     => 'PersonasController'),
		'verificarDocumento'        => array('model'   => 'PersonasModel', 'view'   => 'verificarDocumento',     'controller'     => 'PersonasController'),
		'consultarPersona'          => array('model'   => 'PersonasModel', 'view'   => 'consultarPersona',   	 'controller'     => 'PersonasController'),
		'consultarPersonaC'          => array('model'   => 'PersonasModel', 'view'  => 'consultarPersonaC',   	 'controller'     => 'PersonasController'),
		'consultarEdad'             => array('model'   => 'PersonasModel', 'view'   => 'consultarEdad',   		 'controller'     => 'PersonasController'),
		'consultarRepresentante'    => array('model'   => 'PersonasModel', 'view'   => 'consultarRepresentante', 'controller'     => 'PersonasController'),
		'verPersona'    			=> array('model'   => 'PersonasModel', 'view'   => 'verPersona',			 'controller'     => 'PersonasController'),
		'reporteHistorialMedico'  	=> array('model'   => 'PersonasModel', 'view'   => 'reporteHistorialMedico', 'controller'     => 'PersonasController'),
		'registrarHistoriaMedica'   => array('model'   => 'PersonasModel', 'view'   => 'registrarHistoriaMedica','controller'     => 'PersonasController'),
		'listarDatosUpdate'  	 	=> array('model'   => 'PersonasModel', 'view'   => 'listarDatosUpdate',		 'controller'     => 'PersonasController'),

		/* Modulo Doctor*/
		'inicioDoctor' 				=> array('model' => 'DoctorModel',   'view' => 'inicioDoctor', 'controller' => 'DoctorController'),
		'listarDoctores' 			=> array('model' => 'DoctorModel', 'view'   => 'listarDoctores', 'controller' => 'DoctorController'),
		'registrarDoctor' 			=> array('model' => 'DoctorModel', 'view'   => 'registrarDoctor', 'controller' => 'DoctorController'),
		'listarActualizacionDoctor' => array('model' => 'DoctorModel', 'view'   => 'listarActualizacionDoctor', 'controller' => 'DoctorController'),
		'modificarDoctor' 			=> array('model' => 'DoctorModel', 'view'   => 'modificarDoctor', 'controller' => 'DoctorController'),
		'inactivarDoctor' 			=> array('model' => 'DoctorModel', 'view'   => 'inactivarDoctor', 'controller' => 'DoctorController'),
		'llenarSelectDoctor' 		=> array('model' => 'DoctorModel', 'view'   => 'llenarSelectDoctor', 'controller' => 'DoctorController'),
		'llenarSelectHorarioDoctor' 		=> array('model' => 'DoctorModel', 'view'   => 'llenarSelectHorarioDoctor', 'controller' => 'DoctorController'),
		'llenarSelectDoctorUpdate'  => array('model' => 'DoctorModel', 'view'   => 'llenarSelectDoctorUpdate', 'controller' => 'DoctorController'),
		/* Modulo Citas*/
		'inicioCitas' => array('model' => 'CitasModel', 'view' => 'inicioCitas', 'controller' => 'CitasController'),
		'listarCitas' => array('model' => 'CitasModel', 'view' => 'listarCitas', 'controller' => 'CitasController'),
		'obtenerCitasDisponibles' => array('model' => 'CitasModel', 'view' => 'obtenerCitasDisponibles', 'controller' => 'CitasController'),
		'consultarEspeDoct' => array('model' => 'CitasModel', 'view' => 'consultarEspeDoct', 'controller' => 'CitasController'),
		'registrarCita' => array('model' => 'CitasModel', 'view' => 'registrarCita', 'controller' => 'CitasController'),
		'BuscarCitasXFechas' => array('model' => 'CitasModel', 'view' => 'BuscarCitasXFechas', 'controller' => 'CitasController'),
		'listarActualizacionCita' => array('model' => 'CitasModel', 'view' => 'listarActualizacionCita', 'controller' => 'CitasController'),
		'modificarCita' => array ('model' => 'CitasModel', 'view' => 'modificarCita', 'controller' => 'CitasController'),
		'finalizarCita' => array ('model' => 'CitasModel', 'view' => 'finalizarCita', 'controller' => 'CitasController'),
		/* Modulo Medicamentos*/
		'inicioMedicamentos'     => array('model' => 'MedicamentosModel', 'view' => 'inicio', 'controller' => 'MedicamentosController'),
		'registrarMedicamento'   => array('model' => 'MedicamentosModel', 'view' => 'registrarMedicamento', 'controller' => 'MedicamentosController'),
		'listarMedicamentos' 	 => array('model' => 'MedicamentosModel', 'view' => 'listarMedicamentos', 'controller' => 'MedicamentosController'),
		'consultarMedicamento' 	 => array('model' => 'MedicamentosModel', 'view' => 'ConsultarMedicamento', 'controller' => 'MedicamentosController'),
		'removerMedicamento'	 => array('model' => 'MedicamentosModel', 'view' => 'removerMedicamento', 'controller' => 'MedicamentosController'),
		'listarActualizacionMedicamento' => array('model' => 'MedicamentosModel', 'view' => 'listarActualizacionMedicamento', 'controller' => 'MedicamentosController'),
		'modificarMedicamento'   => array('model' => 'MedicamentosModel', 'view' => 'modificarMedicamento', 'controller' => 'MedicamentosController'),
		/* Modulo Persona*/
		'inicioPersonas' => array('model' => 'PersonasModel', 'view' => 'inicio', 'controller' => 'PersonasController'),
		/* Modulo Consultas*/
		'inicioConsultas' 	  => array('model' => 'ConsultasModel',   'view' => 'inicio', 		    	 'controller'      	=> 'ConsultasController'),
		'listarConsultas' 	  => array('model' => 'ConsultasModel',   'view' => 'listarConsultas',  	 'controller'      	=> 'ConsultasController'),
		'registrarConsulta'   => array('model' => 'ConsultasModel',   'view' => 'registrarConsulta',	 'controller'      	=> 'ConsultasController'),
		'modificarConsulta'   => array('model' => 'ConsultasModel',   'view' => 'modificarConsulta',	 'controller'      	=> 'ConsultasController'),
		'imprimirRecipe' 	  => array('model' => 'RecipeModel', 	  'view' => 'imprimirRecipe',   	 'controller' 	  	=> 'ConsultasController'),
		'listarDatosConsulta' => array('model' => 'ConsultaModel', 	  'view' => 'listarDatosConsulta',   'controller' 		=> 'ConsultasController'),
		'obtenerDatosReceta'  => array('model' => 'ConsultaModel', 	  'view' => 'obtenerDatosReceta',    'controller'  		=> 'ConsultasController'),
		'modificarReceta'  	  => array('model' => 'ConsultaModel', 	  'view' => 'modificarReceta',       'controller'  		=> 'ConsultasController'),
		/* Modulo motivos */
		'inicioMotivos'  	  			  => array('model' => 'MotivosModel', 	  'view' => 'inicio',         		       'controller'  			=> 'MotivosController'),
		'listarMotivos'  	  			  => array('model' => 'MotivosModel', 	  'view' => 'listarMotivos',               'controller'  			=> 'MotivosController'),
		'registrarMotivo'  	  			  => array('model' => 'MotivosModel', 	  'view' => 'registrarMotivo',       	   'controller'  			=> 'MotivosController'),
		'listarActualizacionMotivo'  	  => array('model' => 'MotivosModel', 	  'view' => 'listarActualizacionMotivo',   'controller'  			=> 'MotivosController'),
		'modificarMotivo'  	  		      => array('model' => 'MotivosModel', 	  'view' => 'modificarMotivo',   		   'controller'  			=> 'MotivosController'),
	);

	foreach ($data as $key => $components) {
		if ($page == $key) {
			$model = $components['model'];
			$view = $components['view'];
			$controller = $components['controller'];
		}
	}

	if (isset($model)) {
		require_once 'controllers/' . $controller . '.php';
		$objeto = new $controller();
		$objeto->$view();
	}
} else {
	header('Location: index.php?page=inicioUsuario');
}