<?php

require_once 'ModeloBase.php';

class UsuarioModel extends ModeloBase {

	public function __construct() {
		parent::__construct();
	}

/*------------Metodo para listar usuarios--------*/
	public function listarUsuarios() {
		$db = new ModeloBase();
		$query = "SELECT * FROM usuario";
		$resultado = $db->obtenerTodos($query);
		return $resultado;
	}	
/*------------ Metodo para registrar usuarios--------*/
    public function registrarUsuario($datos) {
    	$data = json_decode($datos);

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
		$datosHorario = [];
		$datosUsuario = [];

		
		 $datosPersona = [
	        'p_nombre' => $miArreglo['p_nombre'],
	        'p_apellido' => $miArreglo['p_apellido'],
	        's_nombre' => $miArreglo['s_nombre'],
	        's_apellido' => $miArreglo['s_apellido'],
	        'sexo' => $miArreglo['sexo'],
	        'fechaNacimiento' => $miArreglo['fechaNacimiento'],
	        'numTelf' => $miArreglo['numTelf'],
	        'tipoDoc' => $miArreglo['tipoDoc'],
	        'numeroDoc' => $miArreglo['numeroDoc'],
	        'correo' => $miArreglo['correo'],
	        'direccion_c' => $miArreglo['direccion_c'],
	        'tipo_persona' => $miArreglo['tipo_persona'],
	    ];

	    $datosHorario = $miArreglo['horarios']; // Esto ya es un arreglo

	    $datosUsuario = [
	        'contrasena' => $miArreglo['contrasena'],
	        'usuario' => $miArreglo['usuario'],
	        'rol' => $miArreglo['rol'],
	        'especialidad' => $miArreglo['especialidad'],
	        'archivo' => $miArreglo['archivo'],
	    ];

		
		return true; 

        /*$db = new ModeloBase();
		try {
			$insertar = $db->insertar('usuario', $datos);
			return $insertar;
		}catch	(PDOException $e) {
			echo $e->getMessage();
		} */
    }
/*------------ Metodo para verificar usuario -------*/
	public function verificarUsuario($usuario, $contrasena)
	{
		$db = new ModeloBase();
		$query ="SELECT * FROM usuario WHERE usuario = '$usuario' AND contrasena = '$contrasena'";
		$resultado = $db->obtenerTodos($query);
		return $resultado;
	}
/*------------ Metodo para mostrar un registro --------*/
	public function obtenerUsuario($id) {
		$db = new ModeloBase();
		$query = "SELECT * FROM usuario WHERE id = ".$id."";
		$resultado = $db->obtenerTodos($query);
		return $resultado;
	}

	public function logoutUsuario() {
		
	}

/*------------ Metodo para modificar un registro --------*/
	public function modificarUsuario($id, $datos) {
		$db = new ModeloBase();
		try {
			$editar = $db->editar('usuario',' ', $id, $datos);
			return $editar;
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

/*------------ Metodo para mostrar un registro Departamentos --------*/

	public function validarEntradaDiaUsuarios($cedula,$nombre,$usuario, $fecha_actual) {
	$db = new ModeloBase();
	$query = "SELECT * FROM usuario WHERE  cedula = '$cedula' AND nombre = '$nombre'  AND  usuario = '$usuario' AND fecha = '$fecha_actual'";
	$resultado = $db->obtenerTodos($query);
	return $resultado;
}





	
/*


	public function eliminarCliente($id) {
		$db = new ModeloBase();
		try {
			$eliminar = $db->eliminar('cliente', $id);
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}
	*/


}


	
	

