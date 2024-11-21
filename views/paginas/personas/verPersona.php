<!-- Begin Page Content -->

<?php 
 
if (session_status() === PHP_SESSION_ACTIVE) { 
    //echo "La sesión está activa."; 
    $usuario            = $_SESSION['usuario']; 
    $id_usuario         = $_SESSION['user_id']; 
    $rol                = $_SESSION['rol_usuario']; 
} else { 
    //echo "La sesión no está activa."; 
    session_start(); 
    $usuario            = $_SESSION['usuario']; 
    $id_usuario         = $_SESSION['user_id']; 
    $rol           = $_SESSION['rol_usuario']; 
} 
 
 
 
    require_once 'models/PersonasModel.php'; 
 
    $modelPersonas              = new PersonasModel(); 
 
    $id_persona = $_GET['id']; 
 
    $datos_personas              = $modelPersonas->listarDatosPersona($id_persona);
  
    $historia_consultas          = $modelPersonas->historiaConsultas($id_persona);
 
    foreach ($datos_personas as $datos_personas) { 
        $id_persona                 = $datos_personas['id_persona']; 
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
 
 
if ($rol == 3) { 
    echo "<h1>No tienes los permisos suficientes para ingresar en este modulo</h1>"; 
} else { 
?>


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
                                <div class="section-content mb-3"
                                    style="display: flex; justify-content: space-between; align-items: center;">
                                    <a href="index.php?page=reporteHistorialMedico&id=<?php echo $id_persona; ?>"
                                        style="margin-bottom: 10px; margin-top:20px;" class="btn btn-danger"
                                        title="Reporte ficha" target="_blank">
                                        <i class="fas fa-print"></i>
                                    </a>

                                    <a class="btn btn-primary" href="index.php?page=inicioPersonas">
                                        <i class="fas fa-arrow-circle-left"></i>
                                    </a>
                                </div>
                                <div class="col-12">
                                    <h5>DATOS DE LA PERSONA</h5>
                                    <div class="table-responsive mb-3">
                                        <table class="table table-bordered table-hover ">

                                            <thead>
                                                <tr class="table-primary">
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
                                                <tr class="table-primary">
                                                    <td><?= $documento ?></td>
                                                    <td><?= $nombre_apellido ?></td>
                                                    <td><?= $sexo ?></td>
                                                    <td><?= $telefono ?></td>
                                                    <td><?= $correo ?></td>
                                                    <td><?= $fecha_nacimiento ?></td>
                                                    <td><?= $direccion ?></td>
                                                </tr>

                                            </tbody>


                                            <tfoot>

                                            </tfoot>
                                        </table>

                                    </div>

                                    <p>
                                        <a class="btn btn-primary" data-bs-toggle="collapse" href="#collapseExample"
                                            role="button" aria-expanded="false" aria-controls="collapseExample">
                                            Historial Medico <i class="fas fa-bars"></i>
                                        </a>
                                    </p>
                                    <div class="collapse" id="collapseExample">
                                        <div class="table-responsive mb-3">
                                            <table class="table table-bordered table-hover ">

                                                <thead>
                                                    <tr class="table-primary">
                                                        <th>Tipo de sangre</th>
                                                        <th>Enfermedades</th>
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
                                                        <td style="text-align: center;"><?= $actividad_fisica ?></td>
                                                        <td style="text-align: center;"><?= $cirugia_hospitalaria ?>
                                                        </td>
                                                        <td style="text-align: center;"><?= $alergia ?></td>
                                                        <td style="text-align: center;"><?= $enfermedad_hereditaria ?>
                                                        </td>
                                                    </tr>

                                                </tbody>


                                                <tfoot>

                                                </tfoot>
                                            </table>

                                        </div>


                                        <h5>Histórico de consultas</h5>
                                        <div class="table-responsive">

                                            <table class="table table-bordered table-hover ">

                                                <thead>
                                                    <tr class="table-primary">
                                                        <th>Fecha</th>
                                                        <th>Especialidad</th>
                                                        <th>Especialista</th>
                                                        <th>Motivo</th>
                                                        <th>Diagnostico</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if(!empty($historia_consultas)){
                                                     foreach ($historia_consultas as $h) { ?>


                                                    <tr class="table-primary">
                                                        <td>
                                                            <?php echo $h['fecha_registro'] ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $h['nombre_especialidad'] ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $h['especialista'] ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $h['motivo'] ?>
                                                        </td>
                                                        <td>
                                                            <a href="index.php?page=imprimirRecipe&amp;id=<?php echo $h['id_consulta']?>"
                                                                target="_blank" class="btn btn-danger btn-sm"><i
                                                                    class="fas fa-print"></i></a>&nbsp
                                                        </td>
                                                    </tr>

                                                    <?php }} else{?>

                                                    <tr class="table-primary" style="text-align: center;">
                                                        <td colspan="5" style="text-align: center;">No hay registros
                                                        </td>
                                                    </tr>


                                                    <?php } ?>


                                                </tbody>


                                                <tfoot>

                                                </tfoot>
                                            </table>

                                        </div>

                                    </div>





                                </div>

                            </div>
                        </div>
                    </div>



                </div>
            </div>
        </div>
        <div style=" display: flex; flex-direction: column;">
        </div>

    </div>
    <!-- <footer> 
            <div class="footer"> 
                
            </div> 
    
 
 
    <?php 
} 
 
    ?>