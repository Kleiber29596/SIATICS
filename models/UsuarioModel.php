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
		$query ="SELECT u.id, u.usuario, pe.tipo_persona, u.foto, u.contrasena, u.id_rol, d.id_especialidad, pe.p_nombre, pe.p_apellido, u.estatus, u.id_Persona, d.id_doctor FROM usuario AS u INNER JOIN personas AS pe ON pe.id_persona = u.id_Persona INNER JOIN doctor AS d ON d.id_persona = pe.id_persona WHERE u.usuario = '$usuario'";
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


	
	

