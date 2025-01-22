<?php
require_once 'ModeloBase.php';

class MotivosModel extends ModeloBase {

	public function __construct() {
		parent::__construct();
	}

	/*------------Método para registrar un motivo --------*/
	public function registrarMotivo($datos) {
		$db = new ModeloBase();
		try {
			$insertar = $db->insertar('tipo_consulta', $datos);
			return $insertar;
		} catch(PDOException $e) {
			echo $e->getMessage();
		}
	}

	/*------------Método para mostrar un motivo --------*/
	public function obtenerMotivo($id) {
		$db = new ModeloBase();
		$query = "SELECT m.id_tipo_consulta, m.motivo, m.id_especialidad, e.nombre_especialidad FROM tipo_consulta AS m LEFT JOIN especialidad AS e ON m.id_especialidad = e.id_especialidad  WHERE id_tipo_consulta = ".$id."";
		$resultado = $db->obtenerTodos($query);
		
		
		
		return $resultado;
	}

	/*------------Método para listar motivos filtrados por especialidad  --------*/
	public function listarMotivos($id) {
		$db = new ModeloBase();
		$query = "SELECT m.id_tipo_consulta, m.motivo, m.id_especialidad, e.nombre_especialidad FROM tipo_consulta AS m LEFT JOIN especialidad AS e ON m.id_especialidad = e.id_especialidad  WHERE m.id_especialidad = ".$id."";
		$resultado = $db->obtenerTodos($query);
		
		
		
		return $resultado;
	}

	/*------------Método para modificar un motivo --------*/
public function modificarMotivo($id, $datos) {
	$db = new ModeloBase();
	try {
		$editar = $db->editar('tipo_consulta', 'id_tipo_consulta', $id, $datos);
		return $editar;
	} catch(PDOException $e) {
		echo $e->getMessage();
	}
}

	

}