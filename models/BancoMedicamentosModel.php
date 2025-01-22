<?php
require_once 'ModeloBase.php';

class BancoMedicamentosModel extends ModeloBase {

	public function __construct() {
		parent::__construct();
	}

/*------------ Método para registrar una existencia -------*/
	public function registrarExistencia($datos) {
		$db = new ModeloBase();
		try {
			$insertar = $db->insertar('banco_medicamentos', $datos);
			return $insertar;
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

    
/*------------ Método para consultar existencia de un Medicamento -------*/
public function consultarExistenciaMedicamento($id_presentacion_medicamento) {
	$db = new ModeloBase();
	$query = "SELECT * FROM `banco_medicamentos` WHERE `id_presentacion_medicamento` = ".$id_presentacion_medicamento."";
	$resultado = $db->FectAll($query);
	return $resultado;
}

/*------------ Método para Agregar existencia de un Medicamento al almacen -------*/
public function agregarNuevaExistencia($id_banco_medicamento, $existencia)
	{
		$db = new ModeloBase();
		$query = "UPDATE banco_medicamentos SET  cantidad = cantidad  + $existencia WHERE  id_banco_medicamento = ".$id_banco_medicamento." ";
		$resultado = $db->obtenerTodos($query);
		return $resultado;
	}

/*------------ Método para Agregar existencia de un Medicamento al almacen -------*/
public function restarExistencia($id_banco_medicamento, $existencia)
	{
		$db = new ModeloBase();
		$query = "UPDATE banco_medicamentos SET  cantidad = cantidad  -  $existencia WHERE  id_banco_medicamento = ".$id_banco_medicamento." ";
		$resultado = $db->obtenerTodos($query);
		return $resultado;
	}

}



