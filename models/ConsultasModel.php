<?php

require_once 'ModeloBase.php';

class ConsultasModel extends ModeloBase {

	public function __construct() {
		parent::__construct();
	}

/*------------ Método para registrar una consulta -------*/
	public function registrarConsulta($datos) {
		$db = new ModeloBase();
		try {
			$insertar = $db->insertar('consultas', $datos);
			return $insertar;
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	/*-------	Listar tipos de consultas	-------------------- */
	public function SelectTipos()
	{
		$db = new ModeloBase();
		$query = "SELECT * FROM  tipo_consulta";
		$resultado = $db->obtenerTodos($query);
		return $resultado;
	}


	/*-------	Listar tipos de consultas	-------------------- */
	public function listarDatosConsulta($id_consulta)
	{
		$db = new ModeloBase();
		$query = "SELECT c.id_consulta, c.id_tipo_consulta, c.id_persona, c.diagnostico, tipo_c.motivo, CONCAT(p.nombres, ' ', p.apellidos) AS nombres_apellidos, peso, altura, presion_arterial from consultas AS c INNER JOIN tipo_consulta AS tipo_c ON c.id_tipo_consulta = tipo_c.id_tipo_consulta  INNER JOIN personas AS p ON c.id_persona = p.id_persona WHERE c.id_consulta = ".$id_consulta."";
		$resultado = $db->obtenerTodos($query);
		return $resultado;
	}


		/*------------Método para modificar datos de una consulta --------*/
		public function modificarConsulta($id, $datos)
		{
			$db = new ModeloBase();
			try {
				$editar = $db->editar('consultas', 'id_consulta', $id, $datos);
				return $editar;
			} catch (PDOException $e) {
				echo $e->getMessage();
			}
		}

}