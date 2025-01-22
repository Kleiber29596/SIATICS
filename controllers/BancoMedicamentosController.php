<?php
require_once './models/MedicamentosModel.php';
class BancoMedicamentosController
{
	#estableciendo las vistas
	public function inicioBancoMedicamentos()
	{

		/*HEADER */
		require_once('./views/includes/cabecera.php');

		require_once('./views/paginas/medicamentos/inicioBancoMedicamentos.php');

		/* FOOTER */
		require_once('./views/includes/pie.php');
	}

	public function listarBancoMedicamentos()
	{

		// Database connection info 
		$dbDetails = array(
			'host' => 'localhost',
			'user' => 'root',
			'pass' => '',
			'db'   => 'medicina'
		);

		// DB table to use 
		$table = <<<EOT
        (
			SELECT id_banco_medicamento, banco_medicamentos.id_presentacion_medicamento, cantidad, banco_medicamentos.fecha_registro, presentacion_medicamentos.id_medicamento, presentacion_medicamentos.id_presentacion, presentacion_medicamentos.id_codigo_categoria, nombre_medicamento, presentacion, codigo, categoria  FROM banco_medicamentos INNER JOIN presentacion_medicamentos ON banco_medicamentos.id_presentacion_medicamento = presentacion_medicamentos.id_presentacion_medicamento INNER JOIN medicamentos ON presentacion_medicamentos.id_medicamento = medicamentos.id_medicamento INNER JOIN presentacion ON presentacion_medicamentos.id_presentacion = presentacion.id_presentacion INNER JOIN codigo_categoria_medicamento ON presentacion_medicamentos.id_codigo_categoria = codigo_categoria_medicamento.id_codigo_categoria ORDER BY id_banco_medicamento DESC) temp
EOT;


		// Table's primary key 
		$primaryKey = 'id_presentacion_medicamento';

		// Array of database columns which should be read and sent back to DataTables. 
		// The `db` parameter represents the column name in the database.  
		// The `dt` parameter represents the DataTables column identifier. 
		$columns = array(

			array('db' => 'nombre_medicamento',   'dt' => 0),
			array('db' => 'presentacion', 'dt' => 1),
			array('db' => 'codigo', 'dt' => 2),
			array('db' => 'categoria', 'dt' => 3),
			array( 
                'db'        => 'cantidad',
                'dt'        => 4, 
                'formatter' => function( $d, $row ) { 
                    return '<button class="btn btn-primary btn-sm">'.$d.'</button>'; 
                } 
            ),
			array('db' => 'id_banco_medicamento',   'dt' => 5)

		);

		// Include SQL query processing class 
		require './config/ssp.class.php';

		// Output data as json format 
		echo json_encode(
			SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns)
		);
	}

}
