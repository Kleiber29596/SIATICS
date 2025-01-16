<?php
require_once 'ModeloBase.php';

class PersonasModel extends ModeloBase
{

	public function __construct()
	{
		parent::__construct();
	}

	public function registrarPersona($datos)
	{
		$db = new ModeloBase();
		try {
			$insertar = $db->insertar('personas', $datos);
			return $insertar;
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	/* Registrar representante */
	public function registrarRepresentante($datos)
	{
		$db = new ModeloBase();
		try {
			$insertar = $db->insertar('representantes', $datos);

			return $insertar;
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}


	/* Registrar enfermedades /historia médica */

	public function registrarEnfermedades($datos)
	{
		$db = new ModeloBase();
		try {
			$insertar = $db->insertar('histo_patologias', $datos);
			return $insertar;
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}


	/* Registrar medicamentos /historia médica */

	public function registrarMedicamentos($datos)
	{
		$db = new ModeloBase();
		try {
			$insertar = $db->insertar('histo_medic', $datos);
			return $insertar;
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}



	
	/* Registrar Historia Medica */
	public function registrarHistoriaMedica($datos)
	{
		$db = new ModeloBase();
		try {
			$insertar = $db->insertar('historia_medica', $datos);

			return $insertar;
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}



	/* Registrar representante y menor en la tbl intermedia  */
	public function registrarTblIntermedia($datos)
	{
		$db = new ModeloBase();
		try {
			$insertar = $db->insertar('representantes_personas', $datos);

			return $insertar;
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}


	/*------------Método para modificar un registro de una persona --------*/
	public function modificarPersona($id, $datos)
	{
		$db = new ModeloBase();
		try {
			$editar = $db->editar('personas', 'id_persona', $id, $datos);
			return $editar;
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	/*------------ --------*/

	/*------------ Método para llenar select municipios -------*/
	public function llenarSelectMunicipio($elegido)
	{
		$db = new ModeloBase();
		$query = "SELECT * FROM municipios WHERE id_estado = " . $elegido . "";
		$resultado = $db->FectAll($query);
		return $resultado;
	}

	/*------------ Método para llenar select parroquias -------*/
	public function llenarSelectParroquia($elegido)
	{
		$db = new ModeloBase();
		$query = "SELECT * FROM parroquias WHERE id_municipio =  " . $elegido . "";
		$resultado = $db->FectAll($query);
		return $resultado;
	}
	public function selectEstado()
	{
		$db = new ModeloBase();
		$query = "SELECT * FROM  estados";
		$resultado = $db->obtenerTodos($query);
		return $resultado;
	}

	public function selectMunicipio()
	{
		$db = new ModeloBase();
		$query = "SELECT * FROM  municipios";
		$resultado = $db->obtenerTodos($query);
		return $resultado;
	}

	public function SelectParroquia()
	{
		$db = new ModeloBase();
		$query = "SELECT * FROM  parroquias";
		$resultado = $db->obtenerTodos($query);
		return $resultado;
	}

	/*------------Método para consultar un registro de una persona mediante la cedula --------*/
public function listarDatosPersona($id_persona) {
    $db = new ModeloBase();
    $query = "SELECT p.id_persona,  CONCAT(p.tipo_documento,' ',p.n_documento) AS documento, CONCAT(p.p_nombre,' ',p.p_apellido) AS nombres_apellidos, DATE_FORMAT(p.fecha_nacimiento, '%d/%m/%Y') AS fecha_nac, p.fecha_nacimiento, p.sexo, p.telefono,  p.correo, p.fecha_registro, p.direccion, h.id, h.tipo_sangre, h.fumador, h.alcohol, h.actividad_fisica, h.medicado, h.cirugia_hospitalaria, h.alergia, h.antec_fami FROM  personas AS p  LEFT JOIN historia_medica AS h ON h.id_persona = p.id_persona WHERE p.id_persona = $id_persona";
    $resultado = $db->obtenerTodos($query);
    return $resultado;
}

/*------------Método listar datos para actualizar persona --------*/
public function listarDatosUpdate($id_persona) {
    $db = new ModeloBase();
    $query = "SELECT p.id_persona, p.n_documento, p.tipo_documento, p.n_documento, p.p_nombre, p.s_nombre, p.p_apellido, p.s_apellido, p.fecha_nacimiento, p.sexo, p.telefono,  p.correo, p.fecha_registro, p.direccion FROM  personas AS p WHERE p.id_persona = $id_persona";
    $resultado = $db->obtenerTodos($query);
    return $resultado;
}

public function listarEnfermedades($id_historia_medica) {
    $db = new ModeloBase();
    $query = "SELECT hp.id_histo_patologia, hp.id_historia_medica, hp.id_patologia, p.nombre AS nombre_patologia from histo_patologias AS hp LEFT JOIN patologias AS p ON hp.id_patologia = p.id_patologia WHERE id_historia_medica = $id_historia_medica";
    $resultado = $db->FectAssoc($query);
    return $resultado;
}



/*------------ Método para llenar select Enfermedades -------*/
public function selectEnfermedades()
{
	$db = new ModeloBase();
	$query = "SELECT * FROM patologias";
	$resultado = $db->obtenerTodos($query);
	return $resultado;
}


public function listarMedicamentos($id_historia_medica) {
    $db = new ModeloBase();
    $query = "SELECT hm.id_histo_medic, hm.id_historia_medica, hm.id_presentacion_medicamento, pre_medic.id_medicamento, pre_medic.id_presentacion, CONCAT(m.nombre_medicamento,' ',p.presentacion) AS nombre_medicamento from histo_medic AS hm LEFT JOIN presentacion_medicamentos AS pre_medic ON hm.id_presentacion_medicamento = pre_medic.id_presentacion_medicamento LEFT JOIN medicamentos AS m ON pre_medic.id_medicamento = m.id_medicamento LEFT JOIN presentacion AS p ON p.id_presentacion = pre_medic.id_presentacion WHERE id_historia_medica = $id_historia_medica";
    $resultado = $db->FectAssoc($query);
    return $resultado;
}



	public function consultarPersona($n_documento) {
	    $db = new ModeloBase();
	    $query = "SELECT personas.id_persona, CONCAT(personas.tipo_documento, '-', personas.n_documento) AS documento, CONCAT(personas.p_nombre, ' ', personas.s_nombre,' ', personas.p_apellido,' ', personas.s_apellido) AS nombres, fecha_nacimiento, sexo, telefono, correo, fecha_registro, personas.direccion, representantes.parentesco, representantes.id_representante FROM personas LEFT JOIN representantes ON personas.id_persona = representantes.id_persona WHERE personas.n_documento =".$n_documento."";
	    $resultado = $db->obtenerTodos($query);
	    return $resultado;
	}

	public function consultarPersonaUsuario($n_documento) {
	    $db = new ModeloBase();
	    $query = "SELECT p.id_persona, p.tipo_documento, p.n_documento, p.p_nombre, p.s_nombre, p.p_apellido, p.s_apellido, p.fecha_nacimiento, p.sexo, p.telefono, p.correo, p.direccion FROM personas p WHERE n_documento = '$n_documento'";
	    $resultado = $db->obtenerTodos($query);
	    return $resultado;
	}

	/*------ Metodo para consultar persona / Modulo consulta -------*/
	
	public function consultarPersonaC($n_documento) {
	    $db = new ModeloBase();
	    $query = "SELECT 
        p.id_persona AS id_paciente, 
        CONCAT(p.tipo_documento, '-', p.n_documento) AS documento_paciente, 
        CONCAT(p.p_nombre, ' ', p.s_nombre, ' ', p.p_apellido, ' ', p.s_apellido) AS nombres_paciente, 
        p.fecha_nacimiento, 
        p.sexo, 
        p.telefono, 
        p.correo, 
        p.fecha_registro AS fecha_registro_paciente, 
        p.direccion, 
        r.parentesco, 
        r.id_representante,
        c.id_cita, 
        c.id_especialidad, 
        c.observacion, 
        c.estatus, 
        DATE_FORMAT(c.fecha_cita, '%d/%m/%Y') AS fecha_cita, c.fecha_cita AS validar_fecha,  -- Aquí aplicamos el formato
        c.id_doctor,
        e.nombre_especialidad, 
        d.id_persona AS id_especialista, 
        CONCAT(es.tipo_documento, '-', es.n_documento) AS documento_especialista, 
        CONCAT(es.p_nombre, ' ', es.s_nombre, ' ', es.p_apellido, ' ', es.s_apellido) AS nombres_especialista
    FROM 
        personas AS p
    LEFT JOIN 
        representantes AS r ON p.id_persona = r.id_persona
    LEFT JOIN 
        citas AS c ON c.id_persona = p.id_persona AND c.estatus = 1 
    LEFT JOIN 
        especialidad AS e ON e.id_especialidad = c.id_especialidad
    LEFT JOIN 
        doctor AS d ON d.id_doctor = c.id_doctor
    LEFT JOIN 
        personas AS es ON d.id_persona = es.id_persona
    WHERE 
        p.n_documento = " . $n_documento . "";
	    $resultado = $db->obtenerTodos($query);
	    return $resultado;
	}

	public function consultarRepresentante($documento_representante) {
	    $db = new ModeloBase();
	    $query = "SELECT p.id_persona, CONCAT(p.p_nombre,' ',p.s_nombre) AS nombres, CONCAT(p.p_apellido,' ',p.s_apellido) AS apellidos, CONCAT(p.tipo_documento ,' ',p.n_documento) AS documento, r.id_representante, r.parentesco FROM personas AS p LEFT JOIN representantes AS r ON r.id_persona = p.id_persona WHERE n_documento = ".$documento_representante."";
	    $resultado = $db->obtenerTodos($query);
	    return $resultado;
	}

	public function verRepresentante($id_persona) {
	    $db = new ModeloBase();
	    $query = "SELECT  representantes_personas.id_representante_persona, representantes_personas.id_representante, r.id_persona, r.parentesco, CONCAT(p.p_nombre,' ',p.s_nombre,' ',p.p_apellido,' ',p.s_apellido) AS nombres_apellidos, CONCAT(p.tipo_documento,' ',p.n_documento)  AS documento,  p.telefono, p.correo, p.direccion FROM representantes_personas INNER JOIN representantes AS r ON r.id_representante = representantes_personas.id_representante INNER  JOIN personas AS p ON p.id_persona = r.id_persona WHERE representantes_personas.id_persona = ".$id_persona."";
	    $resultado = $db->FectAssoc($query);
	    return $resultado;
	}



	public function consultarPersonaCita($id_persona) {
	    $db = new ModeloBase();
	    $query = "SELECT p.id_persona, CONCAT(p.tipo_documento,'-',p.n_documento) AS cedula, CONCAT(p.p_nombre,' ',p.p_apellido) AS nombre, TIMESTAMPDIFF(YEAR, p.fecha_nacimiento, CURDATE()) AS edad, p.sexo, p.telefono, p.direccion, p.correo FROM personas p WHERE p.id_persona = ".$id_persona."";
	    $resultado = $db->FectAll($query);
	    return $resultado;
	}


	public function historiaConsultas($id_persona) {
		$db = new ModeloBase();
	    $query = "SELECT c.id_consulta, c.diagnostico, c.id_especialidad, c.id_tipo_consulta, DATE_FORMAT(c.fecha_registro,'%d/%m/%Y') AS fecha_registro, e.nombre_especialidad, t.motivo, CONCAT(p.p_nombre,' ',p.p_apellido) AS especialista FROM consultas AS c INNER JOIN especialidad AS e ON e.id_especialidad = c.id_especialidad INNER JOIN tipo_consulta AS t ON t.id_tipo_consulta = c.id_consulta INNER JOIN personas AS p ON p.id_persona = c.id_persona WHERE c.id_persona = ".$id_persona."";
	    $resultado = $db->FectAssoc($query);
	    return $resultado;
	}


}