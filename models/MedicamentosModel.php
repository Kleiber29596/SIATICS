<?php
require_once 'ModeloBase.php';

class MedicamentosModel extends ModeloBase {

	public function __construct() {
		parent::__construct();
	}

/*------------ Método para registrar una medicamento-------*/
	public function registrarMedicamento($datos) {
		$db = new ModeloBase();
		try {
			$insertar = $db->insertar('medicamentos', $datos);
			return $insertar;
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	/*------------ Método para registrar una presentacion-medicamento -------*/
	public function registrarPresentacionMedicamento($datos) {
		$db = new ModeloBase();
		try {
			$insertar = $db->insertar('presentacion_medicamentos', $datos);
			return $insertar;
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	public function selectCategoria()
	{
		$db = new ModeloBase();
		$query = "SELECT * FROM  codigo_categoria_medicamento";
		$resultado = $db->obtenerTodos($query);
		return $resultado;
	}


/*------------ Método para obtener una Medicamento -------*/
public function consultarPresentacionMedicamento($id_medicamento) {
	$db = new ModeloBase();
	$query = "SELECT pre_me.id_presentacion_medicamento, pre_me.id_medicamento, pre_me.id_presentacion, m.nombre_medicamento,  pre.presentacion, m.codigo, c.categoria  FROM presentacion_medicamentos AS pre_me INNER JOIN  medicamentos AS m ON  pre_me.id_medicamento = m.id_medicamento INNER JOIN presentacion AS pre ON pre_me.id_presentacion = pre.id_presentacion INNER JOIN categoria_medicamento AS c ON m.codigo = c.codigo  WHERE id_presentacion_medicamento = ".$id_medicamento."";
	$resultado = $db->obtenerTodos($query);
	return $resultado;
}

/*------------ Método para obtener una Medicamento -------*/
public function consultarMedicamento($nombre_medicamento) {
	$db = new ModeloBase();
	$query = "SELECT * FROM `medicamentos` WHERE `nombre_medicamento` = "."'".$nombre_medicamento."'"."";
	$resultado = $db->obtenerTodos($query);
	return $resultado;
}

/*------------ Método para obtener una Medicamento -------*/
public function consultarRegistroTemporal($id_medicamento) {
	$db = new ModeloBase();
	$query = "SELECT * FROM `tbl_temporal_medicamentos` WHERE `id_presentacion_medicamento`  = ".$id_medicamento."";
	$resultado = $db->FectAll($query);
	return $resultado;
}



/*------------Método para modificar un Medicamento --------*/
public function modificarCita($id, $datos) {
	$db = new ModeloBase();
	try {
		$editar = $db->editar('citas', 'id_cita', $id, $datos);
		return $editar;
	} catch(PDOException $e) {
		echo $e->getMessage();
	}
}

/*------------ Método para llenar select Medicamentos -------*/
public function llenarSelectMedicamentos()
{
	$db = new ModeloBase();
	$query = "SELECT presentacion_medicamentos.id_presentacion_medicamento, presentacion_medicamentos.id_medicamento, presentacion_medicamentos.id_presentacion,  medicamentos.nombre_medicamento, presentacion.presentacion  FROM presentacion_medicamentos INNER JOIN medicamentos ON presentacion_medicamentos.id_medicamento = medicamentos.id_medicamento  INNER JOIN presentacion ON presentacion_medicamentos.id_presentacion  = presentacion.id_presentacion";
	$resultado = $db->obtenerTodos($query);
	return $resultado;
}

public function listar()
{
	$db = new ModeloBase();
	$query = "SELECT m.id_medicamento, m.nombre_medicamento, m.codigo, m.fecha_registro, c.categoria FROM medicamentos AS m INNER JOIN categoria_medicamento AS c ON m.codigo = c.codigo";
	$resultado = $db->obtenerTodos($query);
	return $resultado;
}


/*------------ Método para registrar datos del medicamento en la tabla temporal -------*/
public function registrarDatosTemporal($datos) {
	$db = new ModeloBase();
	try {
		$insertar = $db->insertar('tbl_temporal_medicamentos', $datos);
		return $insertar;
	} catch (PDOException $e) {
		echo $e->getMessage();
	}
}

/* Eliminar Medicamento de la tabla temporal */
public function eliminarMedicamentoTemp() {
	#$cedula = intval($cedula);
	$db = new ModeloBase();
	$query = "DELETE FROM tbl_temporal_medicamentos";
	$resultado = $db->obtenerTodos($query);
	return $resultado;
}


/*------------ Método para remnover medicamento de la tabla temporal -------*/
public function removerMedicamento($id) {
	$db = new ModeloBase();
	$query = "DELETE FROM tbl_temporal_medicamentos WHERE id_presentacion_medicamento = $id";
	$resultado = $db->obtenerTodos($query);
	return $resultado;
}

public function listarMedicamentosTemporales() {
	$db = new ModeloBase();
	$query = "SELECT * FROM  tbl_temporal_medicamentos";
	$resultado = $db->obtenerTodos($query);
	return $resultado;
}



}