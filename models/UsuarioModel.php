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
        $db = new ModeloBase();
		try {
			$insertar = $db->insertar('usuario', $datos);
			return $insertar;
		}catch	(PDOException $e) {
			echo $e->getMessage();
		}
    }
/*------------ Metodo para registrar Horario--------*/
    public function registrarHorario($datos) { 
    	$db = new ModeloBase();
    	try {
		    foreach ($datos as $data) {
		        // Llamar a la función insertar para cada horario
		      $insertar = $db->insertar('horario', $data);
		      //echo "Horario para " . $data['dia'] . " insertado correctamente.\n";		        
		    }

		    if ($insertar) {	            
	            return $insertar;
	        } else {
	            //echo "Error al insertar el horario para " . $data['dia'] . ".\n";
	            return false;
	        }

		} catch (PDOException $e) {
		    echo "Error: " . $e->getMessage();
		}
    }
/*------------ Metodo para verificar usuario -------*/
	public function verificarUsuario($usuario)
	{
		$db = new ModeloBase();
		$query ="SELECT u.id, u.usuario, pe.tipo_persona, u.foto, u.contrasena, u.id_rol, d.id_especialidad, pe.p_nombre, pe.p_apellido, u.estatus, u.id_Persona, d.id_doctor, r.rol FROM usuario AS u INNER JOIN personas AS pe ON pe.id_persona = u.id_Persona INNER JOIN doctor AS d ON d.id_persona = pe.id_persona INNER JOIN roles AS r ON r.id = u.id_rol  WHERE u.usuario = '$usuario'";
		$resultado = $db->obtenerTodos($query);
		return $resultado;	
	}


	
/*------------ Metodo para mostrar un registro --------*/
	public function obtenerUsuario($id) {
		$db = new ModeloBase();
		$query = "SELECT usuario,id_rol, usuario.id, usuario.estatus, usuario.foto, usuario.fecha_registro, CONCAT(p.p_nombre,' ',p.p_apellido) AS nombre_apellido, CONCAT(p.tipo_documento,' ',p.n_documento) AS documento, r.rol FROM usuario INNER JOIN personas AS p ON usuario.id_Persona = p.id_persona INNER JOIN roles AS r ON r.id = usuario.id_rol WHERE usuario.id = ".$id."";
		$resultado = $db->obtenerTodos($query);
		return $resultado;
	}



	/*------------ Metodo para mostrar un registro --------*/
	public function listarDatosUsuario($id) {
		$db = new ModeloBase();
		$query = "SELECT p.id_persona, p.tipo_documento, p.n_documento, p.p_nombre, p.s_nombre, p.p_apellido, p.s_apellido, p.correo, p.direccion, DATE_FORMAT(p.fecha_nacimiento, '%d/%m/%Y') AS fecha_nac, p.fecha_nacimiento, p.sexo, p.telefono,  p.correo, p.fecha_registro, p.direccion, p.telefono, u.usuario, u.id_rol, u.estatus, u.foto, r.rol, u.id, u.id_rol FROM  usuario AS u INNER JOIN  personas AS p ON p.id_persona = u.id_Persona INNER JOIN roles AS r ON r.id = u.id_rol  WHERE u.id  = ".$id."";
		$resultado = $db->obtenerTodos($query);
		return $resultado;
	}


/*------------ Metodo para modificar un registro --------*/
	public function modificarUsuario($id, $datos) {
		$db = new ModeloBase();
		try {
			$editar = $db->editar('usuario','id', $id, $datos);
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


	
	

