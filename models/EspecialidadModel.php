<?php
require_once 'ModeloBase.php';

class EspecialidadModel extends ModeloBase {

	public function __construct() {
		parent::__construct();
	}

	/*------------Método para listar especialidades--------*/
	public function listarEspecialidades() {
		$db = new ModeloBase();
		$query = "SELECT * FROM especialidad";
		$resultado = $db->obtenerTodos($query);
		return $resultado;
	}

	/*------------Método para registrar especialidades--------*/
	public function registrarEspecialidad($datos) {
		$db = new ModeloBase();
		try {
			$insertar = $db->insertar('especialidad', $datos);
			return $insertar;
		} catch(PDOException $e) {
			echo $e->getMessage();
		}
	}

	/*------------Método para mostrar un registro de especialidad--------*/
	public function obtenerEspecialidad($id) {
		$db = new ModeloBase();
		$query = "SELECT * FROM especialidad WHERE id_especialidad = ".$id."";
		$resultado = $db->obtenerTodos($query);
		return $resultado;
	}
/*------------Método para modificar un registro de especialidad--------*/
public function modificarEspecialidad($id, $datos) {
	$db = new ModeloBase();
	try {
		$editar = $db->editar('especialidad', 'id_especialidad', $id, $datos);
		return $editar;
	} catch(PDOException $e) {
		echo $e->getMessage();
	}
}

public function selectEspecialidad()
	{
		$db = new ModeloBase();
		$query = "SELECT * FROM  especialidad";
		$resultado = $db->obtenerTodos($query);
		return $resultado;
	}

	
}