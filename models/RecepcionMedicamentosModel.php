<?php
require_once 'ModeloBase.php';

class RecepcionMedicamentosModel extends ModeloBase {

	public function __construct() {
		parent::__construct();
	}

/*------------ Método para registrar una medicamento-------*/
	public function registrarRecepcionMedicamento($datos) {
		$db = new ModeloBase();
		try {
			$insertar = $db->insertar('recepcion_medicamentos', $datos);
			return $insertar;
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	/*------------Método para obtener un recepcion de medicamento -------*/
	public function obtenerRecepcionMedicamento($id) {
		$db = new ModeloBase();
		$query = "SELECT * FROM recepcion_medicamentos WHERE id_recepcion_medicamento = ".$id."";
		$resultado = $db->obtenerTodos($query);
		return $resultado;
	}


	/*------------Método para modificar una recepcion de un medicamento--------*/
public function modificarRecepcionMedicamento($id, $datos) {
	$db = new ModeloBase();
	try {
		$editar = $db->editar('recepcion_medicamentos', 'id_recepcion_medicamento', $id, $datos);
		return $editar;
	} catch(PDOException $e) {
		echo $e->getMessage();
	}
}
}