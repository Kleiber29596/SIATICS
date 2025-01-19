<?php

function obtener_edad($fecha_nacimiento)
{
    // Validación: la fecha de nacimiento debe ser menor o igual a la fecha actual
    $fecha_nacimiento_obj = new DateTime($fecha_nacimiento);
    $hoy = new DateTime();

    if ($fecha_nacimiento_obj > $hoy) {
        return "Fecha de nacimiento inválida: no puede ser posterior a la fecha actual.";
    }

    // Si la fecha es válida, procedemos con el cálculo de la edad
    $diferencia = $hoy->diff($fecha_nacimiento_obj);
    return $diferencia->format("%y");
}

$id = intval($_GET['id']);


$objeto = new ConsultasController();

$recetas = $objeto->datosReceta($id);
$medicamentos = $objeto->datosReceta($id);


foreach ($recetas as $receta) {
    $paciente = $receta['paciente'];
    $cedula = $receta['ciPaciente'];
    $doctor = $receta['autor'];
    $ciDoctor = $receta['ciDoctor'];
    $fecha_nacimiento = $receta['fecha_nacimiento'];

   
}



$edad = obtener_edad($fecha_nacimiento);


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
    <link rel="stylesheet" href="<?= SERVERURL?>libs/css/sb-admin-2.min.css">
</head>

<body>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Recipe Médico</title>
        <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            margin: 20px auto;
            border: 1px solid #ccc;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header img {
            max-width: 150px;
        }

        .header h1 {
            margin: 0;
            font-size: 18px;
            text-transform: uppercase;
        }

        .patient-info,
        .footer {
            margin-top: 20px;
        }

        .patient-info table,
        .footer table {
            width: 30%;
        }

        .patient-info th,
        .footer th {
            text-align: left;
            padding: 5px;
        }

        .indications {
            margin: 20px 0;
            border: 1px solid #000;
            height: 200px;
        }

        .footer p {
            font-size: 12px;
        }
        </style>
    </head>

    <body>
        <div class="container">
            <div class="header">
                <img src="<?= SERVERURL?>libs/img/siatics2.png" alt="Logo Cáritas">
            </div>

            <div class="patient-info">
                <table>
                    <tr>
                        <th>Paciente:</th>
                        <td><?= $paciente; ?></td>
                    </tr>
                    <tr>
                        <th>Cédula:</th>
                        <td><?= $cedula; ?></td>
                    </tr>
                    <tr>
                        <th>Edad:</th>
                        <td><?= $edad; ?></td>
                    </tr>
                </table>
            </div>

            <div class="indications" style="text-align:left;">
                <?php foreach ($medicamentos as $m) { ?>
                <p style="margin: left 4px;"> <?= $m['nombre_medicamento'].' '.$m['dosis'].' '.$m['unidad_medida'].' cada '.$m['frecuencia'].' por '.$m['duracion'] ;?></p>

                <?php } ?>       
            </div>

            <div class="footer">
                <table>
                    <tr>
                        <th>Doctor(a):</th>
                        <td><?php echo $doctor; ?></td>
                    </tr>
                    <tr>
                        <th>CI:</th>
                        <td><?php echo $ciDoctor; ?></td>
                    </tr>
                    <tr>
                        <th>MPPS:</th>
                        <td><?php echo $mpps; ?></td>
                    </tr>
                </table>
                <p>* Un plato saludable es indicación de una alimentación balanceada. Las frutas y vegetales crudos son
                    salud. ¡Que no falten en tu comida!</p>
            </div>
        </div>
    </body>

    </html>


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