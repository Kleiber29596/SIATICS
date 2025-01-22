<?php
require_once 'ModeloBase.php';

class EntregaMedicamentosModel extends ModeloBase {

	public function __construct() {
		parent::__construct();
	}

/*------------ Método para registrar una medicamento-------*/
	public function registrarEntregaMedicamento($datos) {
		$db = new ModeloBase();
		try {
			$insertar = $db->insertar('entrega_medicamentos', $datos);
			return $insertar;
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}
}