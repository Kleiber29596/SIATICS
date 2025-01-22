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
//$id = 11;

$objeto = new ConsultasController();

$recetas = $objeto->datosReceta($id);
$medicamentos = $objeto->datosReceta($id);


foreach ($recetas as $receta) {
    $paciente = $receta['paciente'];
    $cedula = $receta['ciPaciente'];
    $edad = $receta['edad'];
    $doctor = $receta['autor'];
    $ciDoctor = $receta['ciDoctor'];
    $fecha_nacimiento = $receta['fecha_nacimiento'];
    $sexo = $receta['sexo'];
    $diagnostico = $receta['diagnostico'];
    $motivo_cosulta = $receta['motivo'];
    $fecha_registro = $receta['fecha_registro'];
    // $mpps = $receta['mpps'];
}

$fecha = DateTime::createFromFormat('Y-m-d', $fecha_nacimiento);
$fechaFormateada = $fecha->format('d-m-Y');

$fecha_r = DateTime::createFromFormat('Y-m-d', $fecha_registro);
$fecha_rFormateada = $fecha_r->format('d-m-Y');
//$edad = obtener_edad($fecha_nacimiento);


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

        .container td{
            width: 40%;
        }

        .header {            
            margin-bottom: 10px;
            width: 100%;
        }

        /*.header .img1 {
            max-width: 150px;
            text-align: right;
        }

        .header .img2 {
            max-width: 150px;
            text-align: left;
        }

        .header h1 {
            margin: 0;
            font-size: 18px;
            text-transform: uppercase;
        }*/

        .header {            
            margin-bottom: 20px;
            width: 100%;
            display: block;
        }

        .header .img1 {
            max-width: 150px;
            position: relative;
            left: 75%;
        }

        .header .img2 {
            max-width: 150px;
            position: relative;
            right: 22%;
        }

        .patient-info,
        .footer {
            margin-top: 20px;
        }

        .patient-info table,
        .footer table {
            width: 100%;
        }

        .patient-info th {
            text-align: left;
            padding: 5px;
        }

        .indications {
            margin: 20px 0;
            border: 1px solid #000;
            min-height: 50px;
            height: auto;
        }

        .datos_D{
            width: 30%;
            position: relative;
            left: 65%;           
        }

        .datos_D th, 
        .datos_D td {
            text-align: center;
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
            border-top: 1px solid #000;
            padding: 10px 0;
            width: 95%;
            margin: auto;
        }

        .footer p {
            font-size: 12px;
        }

        </style>
    </head>

    <body>
        <div class="container">
            <div class="header">
                <img src="<?= SERVERURL?>libs/img/siatics2.png" alt="Logo Cáritas" class="img1">
                <img src="<?= SERVERURL?>libs/img/logoCaritasVzla.png" alt="Logo Cáritas" class="img2">            
            </div>
            <div>
                <center><h2>Informe Médico</h2></center>
                <p style="position: absolute; right: 5%;"><strong>fecha: </strong><?= $fecha_rFormateada; ?></p>
                <hr>
            </div>
            <div class="patient-info">
                <h4><u>Datos de identificación</u></h4>
                <table>
                    <tr>
                        <th>Paciente:</th>
                        <td><?= $paciente; ?></td>
                        <th>Cédula:</th>
                        <td><?= $cedula; ?></td>
                        <th>Edad:</th>
                        <td><?= $edad; ?></td>
                    </tr>
                    <tr>
                        <th>fecha de nacimiento:</th>
                        <td><?= $fechaFormateada; ?></td>
                        <th>sexo:</th>
                        <td><?= $sexo; ?></td>
                    </tr>
                </table>
            </div>
            <h4><u>Motivo de consulta</u></h4>
            <div>
                <p style="margin: left 4px;"><?= $motivo_cosulta; ?></p>
            </div>

            <h4><u>Medicaméntos a suministrar</u></h4>
            <div>
                <ul>
                    <?php foreach ($medicamentos as $m) { ?>
                    <li><p style="margin: left 4px;"> <?= '<strong>'.$m['nombre_medicamento'].':</strong> '.$m['dosis'].' '.$m['unidad_medida'].' cada '.$m['frecuencia'].' por '.$m['duracion'] ;?></p></li>
                    <?php } ?> 
                </ul>      
            </div>

            <h4><u>Desarrollo</u></h4>

            <div class="indications" style="text-align:left;">
                <p style="margin: left 4px;">
                    <?= $diagnostico; ?>
                </p>
            </div>

            <div class="datos_D">
                <table>
                    <tr>
                        <th>Dr(a). </th>
                        <td><?php echo $doctor; ?></td>
                    </tr>
                    <tr>
                        <th>CI. </th>
                        <td><?php echo $ciDoctor; ?></td>
                    </tr>
                    <tr>
                        <th>F.V.P. </th>
                        <td></td>
                    </tr>
                </table>
            </div>

            <div class="footer">                
                <p>* Un plato saludable es indicio de una alimentación balanceada. Las frutas y vegetales son
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

$dompdf->stream("recipe_".$cedula.".pdf", array("Atachment" => false));

?>