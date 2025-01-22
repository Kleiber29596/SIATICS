<?php
require_once './models/PresentacionModel.php';
class PresentacionController
{

	#estableciendo las vistas
	// public function inicioBancoMedicamentos()
	// {

	// 	/*HEADER */
	// 	require_once('./views/includes/cabecera.php');

	// 	require_once('./views/paginas/banco_medicamentos/inicioBancoMedicamentos.php');

	// 	/* FOOTER */
	// 	require_once('./views/includes/pie.php');
	// }


	public function selectPresentacion()
	{
		$modelPresentacion = new PresentacionModel();
		$presentaciones = $modelPresentacion->selectPresentacion();
		return $presentaciones;
	}

}
