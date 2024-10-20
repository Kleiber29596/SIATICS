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
    $query = "SELECT id_persona, n_documento, tipo_documento, nombres, apellidos, fecha_nacimiento, sexo, telefono,  correo, fecha_registro, direccion  FROM personas  WHERE  id_persona = $id_persona";
    $resultado = $db->obtenerTodos($query);
    return $resultado;
}



	public function consultarPersona($n_documento) {
	    $db = new ModeloBase();
	    $query = "SELECT id_persona, CONCAT(personas.tipo_documento, '-', personas.n_documento) AS documento, CONCAT(personas.nombres, ' ', personas.apellidos) AS nombres, fecha_nacimiento, sexo, telefono, correo, fecha_registro, CONCAT('Recide en el estado ',estado,', municipio ',municipio, ' en la parroquia ',parroquia) as direccion FROM personas LEFT JOIN estados ON personas.id_estado = estados.id_estado LEFT JOIN municipios ON personas.id_municipio = municipios.id_municipio LEFT JOIN parroquias ON personas.id_parroquia = parroquias.id_parroquia WHERE n_documento = ".$n_documento."";
	    $resultado = $db->obtenerTodos($query);
	    return $resultado;
	}


	public function consultarPersonaCita($n_documento) {
	    /*$db = new ModeloBase();
	    $query = "SELECT id_persona, CONCAT(personas.tipo_documento, '-', personas.n_documento) AS documento, CONCAT(personas.nombres, ' ', personas.apellidos) AS nombres, fecha_nacimiento, sexo, telefono, correo, fecha_registro, CONCAT('Estado ',estado,', municipio ',municipio, ' en la parroquia ',parroquia) as direccion FROM personas INNER JOIN estados ON personas.id_estado = estados.id_estado INNER JOIN municipios ON personas.id_municipio = municipios.id_municipio INNER JOIN parroquias ON personas.id_parroquia = parroquias.id_parroquia WHERE n_documento = ".$n_documento."";
	    $resultado = $db->FectAll($query);*/
	    return $n_documento;
	}

}