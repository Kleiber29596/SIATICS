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
		$query = "SELECT  d.id_doctor, d.id_especialidad,  d.dia_inicio, d.dia_fin, d.hora_inicio, d.hora_fin, pe.id_persona,  pe.n_documento, pe.tipo_documento,  pe.nombres,  pe.apellidos,  pe.sexo, pe.telefono, pe.id_estado, pe.id_municipio, pe.id_parroquia, pe.correo, pe.fecha_nacimiento, es.nombre_especialidad FROM doctor d INNER JOIN personas pe ON d.id_persona = pe.id_persona INNER JOIN especialidad es ON d.id_especialidad = es.id_especialidad WHERE d.id_doctor = ".$id."";
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
		$query = "SELECT d.id_doctor, d.id_especialidad, d.dia_inicio, d.dia_fin, d.hora_inicio, d.hora_fin, pe.id_persona,  pe.n_documento, pe.tipo_documento,  pe.nombres,  pe.apellidos,  pe.sexo, pe.telefono,  pe.correo, pe.fecha_nacimiento, e.nombre_especialidad FROM doctor d INNER JOIN personas pe ON d.id_persona = pe.id_persona INNER JOIN especialidad e ON d.id_especialidad = e.id_especialidad WHERE  d.id_especialidad = " . $elegido . "";
		$resultado = $db->FectAll($query);
		return $resultado;
	}


}