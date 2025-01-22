<?php
require_once 'ModeloBase.php';

class DoctorModel extends ModeloBase {

	public function __construct() {
		parent::__construct();
	}

	/*------------Método para registrar un Doctor --------*/
	public function registrarDoctor($datos) {
		$db = new ModeloBase();
		try {
			$insertar = $db->insertar('doctor', $datos);
			return $insertar;
		} catch(PDOException $e) {
			echo $e->getMessage();
		}
	}

	/*------------ Método para mostrar un registro de un Doctor -------*/
	public function obtenerDoctor($id) {
		$db = new ModeloBase();
		$query = "SELECT d.id_doctor, d.id_especialidad, pe.id_persona, CONCAT(pe.tipo_documento,'-',pe.n_documento) AS documeto, CONCAT(pe.p_nombre,' ',pe.p_apellido) AS nombre, pe.sexo, pe.telefono, pe.direccion, pe.correo, pe.fecha_nacimiento, es.nombre_especialidad FROM doctor d INNER JOIN personas pe ON d.id_persona = pe.id_persona INNER JOIN especialidad es ON d.id_especialidad = es.id_especialidad WHERE d.id_doctor = ".$id."";
		$resultado = $db->obtenerTodos($query);
		return $resultado;
	}


	/*----------- Metodo para obtener doctor por especialidad ---------------------------*/
	public function obtenerDoctor_espe($id) {
		$db = new ModeloBase();
		$query = "SELECT d.id_doctor, CONCAT(pe.tipo_documento,'-',pe.n_documento) AS cedula, CONCAT(pe.p_nombre,' ',pe.p_apellido) AS nombre FROM doctor d INNER JOIN personas pe ON d.id_persona = pe.id_persona INNER JOIN especialidad es ON d.id_especialidad = es.id_especialidad WHERE d.id_especialidad = ".$id."";
		$resultado = $db->obtenerTodos($query);
		return $resultado;
	}

	

	/*------------Método para modificar un registro de un Doctor--------*/
	public function modificarDoctor($id, $datos) {
		$db = new ModeloBase();
		try {
			$editar = $db->editar('doctor', 'id_doctor', $id, $datos);
			return $editar;
		} catch(PDOException $e) {
			echo $e->getMessage();
		}
	}

	/*------------Método para llenar select de doctor --------*/
	public function llenarSelectDoctor($elegido)
	{
		$db = new ModeloBase();
		$query = "SELECT d.id_doctor, d.id_especialidad, pe.id_persona, pe.n_documento, pe.tipo_documento, CONCAT(pe.p_nombre,' ',pe.p_apellido) AS nombres, pe.sexo, pe.telefono, pe.correo, pe.fecha_nacimiento, e.nombre_especialidad FROM doctor d INNER JOIN personas pe ON d.id_persona = pe.id_persona INNER JOIN especialidad e ON d.id_especialidad = e.id_especialidad WHERE d.id_especialidad = " . $elegido . "";
		$resultado = $db->FectAll($query);
		return $resultado;
	}



	/*------------Método para llenar select de doctor --------*/
	/*public function llenarSelectDoctor($elegido)
	{
		$db = new ModeloBase();
		$query = "SELECT d.id_doctor, d.id_especialidad, pe.id_persona, pe.n_documento, pe.tipo_documento, CONCAT(pe.p_nombre,' ',pe.p_apellido) AS nombre, pe.sexo, pe.telefono, pe.direccion, pe.correo, pe.fecha_nacimiento, es.nombre_especialidad FROM doctor d INNER JOIN personas pe ON d.id_persona = pe.id_persona INNER JOIN especialidad es ON d.id_especialidad = es.id_especialidad WHERE es.id_especialidad = " . $elegido . "";
		$resultado = $db->FectAll($query);
		return $resultado;
	}*/

	public function horarioDoctor($id_doctor)
	{
		$db = new ModeloBase();
		$query = "SELECT h.dia, TIMESTAMPDIFF(MINUTE, h.hora_entrada, h.hora_salida) AS diferencia_en_minutos, e.tm_porcita FROM horario AS h INNER JOIN doctor AS d ON d.id_doctor = h.id_doctor INNER JOIN especialidad AS e ON e.id_especialidad = d.id_especialidad WHERE h.id_doctor = " . $id_doctor . "";
		$resultado = $db->FectAll($query);
		return $resultado;
	}

    /*SELECT c.fecha_cita, COUNT(*) AS conteo FROM `citas` AS c WHERE c.id_doctor = 23 AND c.estatus = 1 GROUP BY c.fecha_cita ORDER BY c.fecha_cita DESC*/
}