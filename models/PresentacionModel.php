<?php
require_once 'ModeloBase.php';

class PresentacionModel extends ModeloBase {

	public function __construct() {
		parent::__construct();
	}

	/*------------Método para listar presentaciones--------*/
	public function listarPresentaciones() {
		$db = new ModeloBase();
		$query = "SELECT * FROM presentacion";
		$resultado = $db->obtenerTodos($query);
		return $resultado;
	}

	/*------------Método para registrar presentaciones--------*/
	public function registrarPresentacion($datos) {
		$db = new ModeloBase();
		try {
			$insertar = $db->insertar('presentacion', $datos);
			return $insertar;
		} catch(PDOException $e) {
			echo $e->getMessage();
		}
	}

	/*------------Método para mostrar un registro de presentacion--------*/
	public function obtenerPresentacion($id) {
		$db = new ModeloBase();
		$query = "SELECT * FROM presentacion WHERE id_presentacion = ".$id."";
		$resultado = $db->obtenerTodos($query);
		return $resultado;
	}

	/*------------Método para modificar un registro de presentacion--------*/
	public function modificarPresentacion($id, $datos) {
		$db = new ModeloBase();
		try {
			$editar = $db->editar('presentacion', 'id_presentacion', $id, $datos);
			return $editar;
		} catch(PDOException $e) {
			echo $e->getMessage();
		}
	}

	public function selectPresentacion()
	{
		$db = new ModeloBase();
		$query = "SELECT * FROM presentacion";
		$resultado = $db->obtenerTodos($query);
		return $resultado;
	}
}
