<?php

$id = intval($_GET['id']);

$objeto = new ConsultasController();

$recetas = $objeto->datosReceta($id);
$medicamentos = $objeto->datosReceta($id);

?>

<?php

ob_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Médico</title>
    <link rel="stylesheet" href="libs/css/sb-admin-2.min.css">
</head>

<body>
    <style>
    body {
        font-family: arial;
        color: #333;

    }

    table {
        border: solid 1px #000;
        border-collapse: collapse;
        border-spacing: 0;
        width: 100%;
    }

    tr {
        border: solid 1px #000;
    }

    td {
        border: solid 1px #000;
        font-size: 16px;
        padding: 10px;
    }

    th {
        border: solid 1px #000;
        font-size: 16px;
        padding: 5px;
    }

    .btn-success {
        background-color: #48C9B0;
        color: #FFF;
        border: none;
        padding: 5px;
        border-radius: 5px;
    }

    .btn-danger {
        background-color: #E74C3C;
        color: #FFF;
        border: none;
        padding: 5px;
        border-radius: 5px;
    }
    </style>

    <!-- Banner
    <div class="container" style="margin-top: 20px;">
        <table style="border: 0px">
            <tr style="border: 0px">
                <th rowspan="2" style="border: 0px">
                    <img style="width: 100%; margin-top: 5px; float: left;" src="<?= SERVERURL ?>libs/img/cintillo1.png"
                        alt="">
                </th>
            </tr>
            <tr style="border: 0px">
                <th style="border: 0px"></th>
            </tr>
        </table><br><br>
    </div><br><br><br>
 -->
    <?php
				foreach ($recetas as $receta){
                    $autor      = $receta['autor'];
                    $paciente   = $receta['paciente'];
                }
                    
					?>

    <div class="container">
        <table style="background:#e2e3e5;">
            <thead>
                <tr style="border: 0px">
                    <th style="text-align: left;">
                        <p style="margin: 0px;">Fecha: <?php echo date("d/m/Y") ?></p>
                    </th>
                    <th style="text-align: left;">
                        <p style="margin: 0px;">Hora: <?php echo date("h:i a") ?></p>
                    </th>
                </tr>
                <tr style="border: 0px">
                    <th style="text-align: left;">
                        <p style="margin: 0px;">Doctor: <?php echo $autor ?></p>
                    </th>
                    <th style="text-align: left;">
                        <p style="margin: 0px;">Paciente: <?php echo $paciente ?></p>
                    </th>
                </tr>

            </thead>
        </table>
    </div><br>

    <!-- Encabezado -->
    <div class="container" style="margin-bottom: 20px;">
        <h2 style="text-align: center; border:none;">Receta médica</h2>
    </div><br>

    <table class="table table-bordered" style="background:#e2e3e5;">
        <tr>
            <th>Medicamento</th>
            <th>Dosis</th>
            <th>Frecuencia</th>
            <th>Duracion</th>
        </tr>

        <?php
			if(!empty($medicamentos)){
				foreach ($medicamentos as $m){
                    $instrucciones = $m['instrucciones'];
                    
					?>
        <tr>
            <td><?=$m['nombre_medicamento']." ".$m['presentacion'];?></td>
            <td><?=
            $m['dosis']." ".$m['unidad_medida'];?></td>
            <td><?='cada '.$m['frecuencia'].' horas';?></td>
            <td><?='por '.$m['duracion'];?></td>
        </tr>
        <?php
				}
			}
			
			?>
    </table>
    <br>
    <table style="background:#e2e3e5;">
        <thead>
            <tr>
                <th>Intrucciones adicionales</th>
            </tr>

        </thead>
        <tbody>
            <tr>
                <td>
                    <p><?=$instrucciones;?></p>
                </td>
            </tr>
        </tbody>
    </table>

    <p>

</body>

</html>

<?php

$html=ob_get_clean();
//echo $html;


require_once 'libs/dompdf/dompdf/autoload.inc.php';

use Dompdf\Dompdf;
$dompdf = new Dompdf();

$options = $dompdf->getOptions();
$options->set(array('isRemoteEnabled' => true));
$dompdf = new Dompdf(array('enable_remote' => true));
$dompdf->setOptions($options); 

$dompdf->loadHtml($html);

$dompdf->setPaper('letter');

$dompdf->render();

$dompdf->stream("recipe.pdf", array("Atachment" => false));

?>