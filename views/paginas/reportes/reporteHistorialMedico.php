<?php 
 
 
 require_once 'models/PersonasModel.php'; 
 
 $modelPersonas              = new PersonasModel(); 

 $id_persona = $_GET['id']; 

 $datos_personas              = $modelPersonas->listarDatosPersona($id_persona); 


 foreach ($datos_personas as $datos_personas) { 
     $id_persona                 = $datos_personas['fecha']; 
     $n_documento                = $datos_personas['n_documento']; 
     $tipo_documento             = $datos_personas['direccion']; 
     $documento                  = $datos_personas['n_documento']; 
     $nombre_apellido            = $datos_personas['nombres_apellidos']; 
     $fecha_nacimiento           = $datos_personas['fecha_nacimiento'];
     $sexo                       = $datos_personas['sexo']; 
     $telefono                   = $datos_personas['telefono']; 
     $correo                     = $datos_personas['correo']; 
     $fecha_registro             = $datos_personas['fecha_registro']; 
     $direccion                  = $datos_personas['direccion']; 
     $tipo_sangre                = $datos_personas['tipo_sangre']; 
     $enfermedad                 = $datos_personas['enfermedad']; 
     $fumador                    = $datos_personas['fumador']; 
     $alcohol                    = $datos_personas['alcohol'];
     $actividad_fisica           = $datos_personas['actividad_fisica'];  
     $medicado                   = $datos_personas['medicado'];
     $cirugia_hospitalaria       = $datos_personas['cirugia_hospitalaria'];
     $alergia                    = $datos_personas['alergia'];  
     $enfermedad_hereditaria     = $datos_personas['enfermedad_hereditaria'];       
 } 
 
 
?>

<?php 
 
ob_start(); 
 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REPORTE_HISTORIAL_MEDICO</title>
    <link rel="stylesheet" href="libs/css/sb-admin-2.min.css">
</head>

<body>
    <style>
    body {
        font-family: sans-serif;
        color: #333;
        font-size: 11px;
    }

    table {
        border: solid 1px #000;
        border-collapse: collapse;
        border-spacing: 0;
        width: 100%;
        font-size: 11px;

    }

    tr {
        border: solid 1px #000;
    }

    td {
        border: solid 1px #000;

        padding: 10px;
    }

    th {
        border: solid 1px #000;

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

    <div class="section">

        <div class="row">
            <div class="col-lg-12">
                <!-- <div style="display: flex; flex-direction: column;"><img src="libs/img/cintillo1.png" alt="" style="max-height: 166px;"></div> -->
                <div class="container2">
                    <!--   <img class="img1" src="libs/img/logo1.png" alt="logo 1"> 
                    <img class="img2" src="libs/img/logo2.png" alt="logo 2"> 
                    <img class="img3" src="libs/img/logo3.png" alt="logo 3"> -->
                </div>


                <div class="container mt-4">
                    <div class="container">

                    </div>
                    <div class="row">

                        <div class="card">
                            <div class="card-body">
                                <div class="col-12 mb-3">
                                    <div class="section-header"></div>

                                    <div class="col-12">
                                        <h3>DATOS DE LA PERSONA</h3>
                                        <br>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover ">

                                                <thead>
                                                    <tr>
                                                        <th>Nª documento</th>
                                                        <th>Nombre y Apellido</th>
                                                        <th>Sexo</th>
                                                        <th>Telèfono</th>
                                                        <th>Correo</th>
                                                        <th>Fecha de nacimiento</th>
                                                        <th>Direcciòn</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td><?= $documento ?></td>
                                                        <td><?= $nombre_apellido ?></td>
                                                        <td><?= $sexo ?></td>
                                                        <td><?= $telefono ?></td>
                                                        <td><?= $correo ?></td>
                                                        <td><?= $fecha_nacimiento ?></td>
                                                        <td><?= $direccion ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                        </div>

                                        <h3>HISTORIA MÉDICA</h3>

                                        <div class="collapse" id="collapseExample">
                                            <div class="table-responsive mb-3">
                                                <table class="table table-bordered table-hover ">

                                                    <thead>
                                                        <tr class="table-primary">
                                                            <th>Tipo de sangre</th>
                                                            <th>¿Enfermedad?</th>
                                                            <th>¿Fumador?</th>
                                                            <th>¿Alcohol?</th>
                                                            <th>¿Actividad Fisica?</th>
                                                            <th>¿Cirugías?</th>
                                                            <th>¿Alergias?</th>
                                                            <th>¿Enfermedades hereditarias?</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr class="table-primary">
                                                            <td style="text-align: center;"><?= $tipo_sangre ?></td>
                                                            <td style="text-align: center;"><?= $enfermedad ?></td>
                                                            <td style="text-align: center;"><?= $fumador ?></td>
                                                            <td style="text-align: center;"><?= $alcohol ?></td>
                                                            <td style="text-align: center;"><?= $actividad_fisica ?>
                                                            </td>
                                                            <td style="text-align: center;"><?= $cirugia_hospitalaria ?>
                                                            </td>
                                                            <td style="text-align: center;"><?= $alergia ?></td>
                                                            <td style="text-align: center;"><?= $enfermedad_hereditaria ?></td>
                                                        </tr>

                                                    </tbody>

                                                </table>

                                            </div>



                                        </div>

                                    </div>
                                </div>
                            </div>



                        </div>
                    </div>
                </div>
                <div style="display: flex; flex-direction: column;">
                </div>

            </div>


</body>

</html>

<?php 
 
$html = ob_get_clean(); 
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
 
$nombre_documento = "REPORTE_HISTORIAL_MEDICO_".strtoupper($nombre_apellido); 
 
$dompdf->stream("$nombre_documento", array("Atachment" => false)); 
 
 
 
?>