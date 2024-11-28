<?php

require_once 'ModeloBase.php';

class CitasModel extends ModeloBase {

	public function __construct() {
		parent::__construct();
	}

	/*------------ Método para registrar una cita -------*/
	public function registrarCita($datos) {
		$db = new ModeloBase();
		try {
			
			if ($datos) {
				$insertar = $db->insertar('citas', $datos);
				return $insertar;
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	/*------------ Metodo para mostrar un registro --------*/
	public function obtenerCita($id) {
		$db = new ModeloBase();
		$query = "SELECT * FROM citas WHERE id_cita = ".$id."";
		$resultado = $db->obtenerTodos($query);
		return $resultado;
	}

	/*------------ Método para obtener una cita -------*/
	public function historicoCitas($id_paciente) {
		$db = new ModeloBase();
		$query = "SELECT datos_paciente.nombres AS nombres_paciente, datos_paciente.apellidos AS apellidos_paciente, datos_paciente.n_documento AS n_documento_paciente, datos_paciente.tipo_documento AS tipo_documento_paciente, personas.nombres AS nombres_doctor, personas.apellidos AS apellidos_doctor, personas.n_documento AS n_documento_doctor, citas.observacion, citas.fecha_cita, citas.estatus, citas.id_cita, citas.id_paciente, citas.id_especialidad, citas.id_doctor, especialidad.nombre_especialidad FROM citas AS citas JOIN pacientes AS pacientes ON pacientes.id_paciente=citas.id_paciente JOIN especialidad AS especialidad ON especialidad.id_especialidad=citas.id_especialidad JOIN doctor AS doctor ON doctor.id_doctor=citas.id_doctor JOIN personas AS personas ON personas.id_persona=doctor.id_persona JOIN personas AS datos_paciente ON datos_paciente.id_persona=pacientes.id_persona where citas.id_paciente = ".$id_paciente."";
		$resultado = $db->obtenerTodos($query);
		return $resultado;
	}

	/*------------Método para modificar una cita --------*/
	public function modificarCita($id, $datos) {
		$db = new ModeloBase();
		try {
			$editar = $db->editar('citas', 'id_cita', $id, $datos);
			return $editar;
		} catch(PDOException $e) {
			echo $e->getMessage();
		}
	}

	/*------------ Método para consultar nombre de especialidad y nombre del doctor -------*/
	public function consultarEspe_Doct($id_especialidad, $id_doctor) {
		$db = new ModeloBase();
		$query = "SELECT e.nombre_especialidad, CONCAT(p.p_nombre,' ', p.p_apellido) AS nombreDoctor FROM doctor AS d INNER JOIN personas p ON p.id_persona = d.id_persona INNER JOIN especialidad e ON e.id_especialidad = d.id_especialidad WHERE d.id_doctor =".$id_doctor." ";
		$resultado = $db->FectAll($query);
		return $resultado;
	}


	/*------------ Método para consultar las horas de trabajo de un doctor -------*/
	public function consultarHorario($id) {
		$db = new ModeloBase();
		$query = "SELECT id_doctor, TIMEDIFF(hora_fin, hora_inicio) AS diferencia_completa, HOUR(TIMEDIFF(hora_fin, hora_inicio)) AS diferencia_horas FROM doctor WHERE id_doctor = ".$id." ";
		$resultado = $db->obtenerTodos($query);
		return $resultado;
	}

	/*------------ Método para consultar las horas de trabajo de un doctor -------*/
	public function totalRegistros($fecha_seleccionada) {
		$db = new ModeloBase();
		$query = "SELECT COUNT(*) AS total_registros
		FROM citas WHERE fecha_cita = '".$fecha_seleccionada."'";
		$resultado = $db->obtenerTodos($query);
		return $resultado->fetch(PDO::FETCH_ASSOC);
	}

	public function consultarCita($id_doctor) {
		$db = new ModeloBase();
		$query = "SELECT * FROM citas AS c WHERE c.id_doctor =".$id_doctor." AND c.estatus = 1 ORDER BY c.fecha_cita DESC";
		$resultado = $db->obtenerTodos($query);
		return $resultado;
	}


}