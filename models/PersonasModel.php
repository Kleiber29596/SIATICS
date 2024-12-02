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
    $query = "SELECT p.id_persona, p.n_documento, p.tipo_documento,  CONCAT(p.tipo_documento,'-',p.n_documento) AS documento, CONCAT(p.p_nombre,' ',p.p_apellido) AS nombres_apellidos,  p.fecha_nacimiento, p.sexo, p.telefono,  p.correo, p.fecha_registro, p.direccion, h.tipo_sangre, h.enfermedad, h.fumador, h.alcohol, h.actividad_fisica, h.medicado, h.cirugia_hospitalaria, h.alergia, h.enfermedad_hereditaria FROM  personas AS p  INNER JOIN historia_medica AS h ON h.id_persona = p.id_persona WHERE p.id_persona = $id_persona";
    $resultado = $db->obtenerTodos($query);
    return $resultado;
}



	public function consultarPersona($n_documento) {
	    $db = new ModeloBase();
	    $query = "SELECT personas.id_persona, CONCAT(personas.tipo_documento, '-', personas.n_documento) AS documento, CONCAT(personas.p_nombre, ' ', personas.s_nombre,' ', personas.p_apellido,' ', personas.s_apellido) AS nombres, fecha_nacimiento, sexo, telefono, correo, fecha_registro, personas.direccion, representantes.parentesco, representantes.id_representante FROM personas LEFT JOIN representantes ON personas.id_persona = representantes.id_persona WHERE personas.n_documento =".$n_documento."";
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



	public function consultarPersonaCita($n_documento) {
	    /*$db = new ModeloBase();
	    $query = "SELECT id_persona, CONCAT(personas.tipo_documento, '-', personas.n_documento) AS documento, CONCAT(personas.nombres, ' ', personas.apellidos) AS nombres, fecha_nacimiento, sexo, telefono, correo, fecha_registro, CONCAT('Estado ',estado,', municipio ',municipio, ' en la parroquia ',parroquia) as direccion FROM personas INNER JOIN estados ON personas.id_estado = estados.id_estado INNER JOIN municipios ON personas.id_municipio = municipios.id_municipio INNER JOIN parroquias ON personas.id_parroquia = parroquias.id_parroquia WHERE n_documento = ".$n_documento."";
	    $resultado = $db->FectAll($query);*/
	    return $n_documento;
	}


	public function historiaConsultas($id_persona) {
		$db = new ModeloBase();
	    $query = "SELECT c.id_consulta, c.diagnostico, c.id_especialidad, c.id_tipo_consulta, c.fecha_registro, e.nombre_especialidad, t.motivo, CONCAT(p.p_nombre,' ',p.p_apellido) AS especialista FROM consultas AS c INNER JOIN especialidad AS e ON e.id_especialidad = c.id_especialidad INNER JOIN tipo_consulta AS t ON t.id_tipo_consulta = c.id_consulta INNER JOIN personas AS p ON p.id_persona = c.id_persona WHERE c.id_persona = ".$id_persona."";
	    $resultado = $db->FectAssoc($query);
	    return $resultado;
	}


}