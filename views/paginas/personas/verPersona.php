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
    $datos_representante         = $modelPersonas->verRepresentante($id_persona);
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

    foreach ($datos_representante as $datos) { 
        $nombres_apellidos_r            = $datos['nombres_apellidos']; 
        $documento_r                    = $datos['documento']; 
        $direccion_r                    = $datos['direccion']; 
        $telefono_r                     = $datos['telefono']; 
        $correo_r                       = $datos['correo'];
        $parentesco                     = $datos['parentesco']; 

    } 


   


    
 

?>



<?php 
 
 
if ($rol == 4 || $rol == 5 || $rol == 6 || $rol == 1) { 
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
                                        style="margin-bottom: 10px; margin-top:20px;" class="btn btn-secondary"
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
                                                    <th>Acciones</th>
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
                                                    <td>
                                                        <?php

                                                            $fecha_nacimiento_obj = new DateTime($fecha_nacimiento);
                                                            $hoy = new DateTime();

                                                            // Si la fecha es válida, procedemos con el cálculo de la edad
                                                            $diferencia = $hoy->diff($fecha_nacimiento_obj);
                                                            $edad_generada = $diferencia->format("%y");


                                                            if($edad_generada < 18)
                                                            {
                                                                ?>

                                                        <button title="Agregrar representante" class="btn btn-danger"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modalAgregarRepresentante">Agregar
                                                            Representante <i class="fas fa-plus"></i></button>

                                                        <?php
                                                            }else{
                                                                ?>

                                                        <button title="Agregrar representante" class="btn btn-danger"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modalAgregarRepresentado">Agregar
                                                            Representado <i class="fas fa-plus"></i></button>

                                                        <?php
    
                                                            }
                                                        ?>
                                                    </td>


                                                </tr>

                                            </tbody>


                                            <tfoot>

                                            </tfoot>
                                        </table>

                                    </div>

                                    <!-- Datos del representante-->

                                    <?php if(!empty($nombres_apellidos_r)) {?>
                                    <h5>DATOS DEL REPRESENTANTE</h5>
                                    <div class="table-responsive mb-3">
                                        <table class="table table-bordered table-hover ">

                                            <thead>
                                                <tr class="table-primary">
                                                    <th>Nº documento</th>
                                                    <th>Nombres/apellidos</th>
                                                    <th>Telefono</th>
                                                    <th>Correo</th>
                                                    <th>Direccion</th>
                                                    <th>Parentesco</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="table-primary">
                                                    <td style="text-align: center;"><?= $documento_r ?></td>
                                                    <td style="text-align: center;"><?= $nombres_apellidos_r ?></td>
                                                    <td style="text-align: center;"><?= $telefono_r ?></td>
                                                    <td style="text-align: center;"><?= $correo_r ?></td>
                                                    <td style="text-align: center;"><?= $direccion_r ?></td>
                                                    <td style="text-align: center;"><?= $parentesco ?></td>

                                                </tr>

                                            </tbody>


                                            <tfoot>

                                            </tfoot>
                                        </table>

                                    </div>
                                    <?php }else{}?>


                                    <p>
                                        <a class="btn btn-primary" data-bs-toggle="collapse" href="#collapseExample"
                                            role="button" aria-expanded="false" aria-controls="collapseExample">
                                            Historial Medico <i class="fas fa-arrow-down"></i>
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
                                                        <td style="text-align: center;"><?= $actividad_fisica ?>
                                                        </td>
                                                        <td style="text-align: center;"><?= $cirugia_hospitalaria ?>
                                                        </td>
                                                        <td style="text-align: center;"><?= $alergia ?></td>
                                                        <td style="text-align: center;">
                                                            <?= $enfermedad_hereditaria ?>
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
                                                    <tr class="table-success">
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


                                                    <tr class="table-success">
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

                                                    <tr class="table-success" style="text-align: center;">
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
                
            </div> -->


    <!-- Modal -->
    <div class="modal fade" id="modalAgregarRepresentante" tabindex="-1"
        aria-labelledby="modalAgregarRepresentanteLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAgregarRepresentanteLabel">Agregar Representante <i
                            class="fas fa-user"></i></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" id="registrar_representante">


                        <div class="row">

                            <div class="col-sm-2 mb-3">
                                <div class="form-group" id="grupo_tipo_documento_r">
                                    <label class="formulario__label" for="tipo_documento_r">Tipo de
                                        documento</label>
                                    <select class="form-control formulario__validacion__input" name="tipo_documento_r"
                                        id="tipo_documento_r">
                                        <option value="">Seleccione</option>
                                        <option value="V">V</option>
                                        <option value="E">E</option>
                                        <option value="P">P</option>
                                    </select>
                                    <i class="formulario__validacion-estado fas fa-times-circle"></i>
                                </div>
                            </div>



                            <div class="col-sm-3 mb-3" id="grupo_n_documento_r">
                                <label class="formulario__label" for="n_documento_representante">Nº
                                    documento</label>
                                <div class="form-group">
                                    <input type="hidden" value="<?= $id_persona ?>" id="id_representado">
                                    <input class="form-control formulario__validacion__input" type="text"
                                        id="n_documento_r" name="n_documento_r" placeholder="Nº de documento">
                                    <i class="formulario__validacion-estado fas fa-times-circle"></i>
                                </div>
                                <p class="formulario__input-error">El número de documento debe contener solo numeros
                                    y
                                    un
                                    mínimo de 7
                                    digitos y máximo 8.
                                </p>
                            </div>

                            <div class="col-sm-2 mb-3">
                                <div class="form-group" id="grupo_sexo">
                                    <label class="formulario__label" for="sexo">Sexo</label>
                                    <br>
                                    Masculino <input class="formulario__validacion__input" type="radio" name="sexo"
                                        id="sexo" value="Masculino" selected>
                                </div>
                            </div>
                            <div class="col-sm-2 mb-3">
                                <div class="form-group" id="grupo_sexo">
                                    <label class="formulario__label" for="sexo"></label>
                                    <br>
                                    Femenino <input class="formulario__validacion__input" type="radio" name="sexo"
                                        id="sexo" value="Femenino">
                                </div>
                            </div>
                            <div class="col-sm-3 mb-3" id="grupo_fecha_nac">
                                <div class="form-group">
                                    <label class="formulario__label" for="fecha_nac_r">Fecha de nacimiento</label>
                                    <input type="date" class="form-control formulario__validacion__input" id="fecha_nac_r"
                                        name="fecha_nac" required>
                                    <i class="formulario__validacion-estado fas fa-times-circle"></i>
                                </div>
                                <p class="formulario__input-error">La fecha de nacimiento no puede ser una fecha
                                    futura.
                                </p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-3 mb-3" id="grupo_primer_nombre_r">
                                <label class="formulario__label" for="primer_nombre_r">Primer nombre</label>
                                <div class="form-group">
                                    <input class="form-control formulario__validacion__input" onkeyup="pmayus(this);"
                                        type="text" id="primer_nombre_r" name="primer_nombre_r"
                                        placeholder="Primer nombre" required>
                                    <i class="formulario__validacion-estado fas fa-times-circle"></i>
                                </div>
                                <p class="formulario__input-error">El nombre debe contener Letras, numeros, guion y
                                    guion_bajo</p>
                            </div>

                            <div class="col-sm-3 mb-3" id="grupo_segundo_nombre_r">
                                <label class="formulario__label" for="segundo_nombre_r">Segundo nombre</label>
                                <div class="form-group">
                                    <input class="form-control formulario__validacion__input" type="text"
                                        id="segundo_nombre_r" name="segundo_nombre_r" placeholder="Segundo nombre">
                                    <i class="formulario__validacion-estado fas fa-times-circle"></i>
                                </div>
                                <p class="formulario__input-error">El nombre debe contener Letras, numeros, guion y
                                    guion_bajo</p>
                            </div>

                            <div class="col-sm-3 mb-3" id="grupo_primer_apellido_r">
                                <label class="formulario__label" for="primer_apellido">Primer apellido</label>
                                <div class="form-group ">
                                    <input class="form-control formulario__validacion__input" type="text"
                                        id="primer_apellido_r" name="primer_apellido_r" placeholder="Primer apellido"
                                        required>
                                    <i class="formulario__validacion-estado fas fa-times-circle"></i>
                                </div>
                                <p class="formulario__input-error">El apellido debe contener Letras y espacios,
                                    pueden
                                    llevar acentos.</p>
                            </div>

                            <div class="col-sm-3 mb-3" id="grupo_segundo_apellido_r">
                                <label class="formulario__label" for="grupo_primer_apellido">Segundo
                                    apellido</label>
                                <div class="form-group ">
                                    <input class="form-control formulario__validacion__input" type="text"
                                        id="segundo_apellido_r" name="segundo_apellido_r"
                                        placeholder="Segundo apellido">
                                    <i class="formulario__validacion-estado fas fa-times-circle"></i>
                                </div>
                                <p class="formulario__input-error">El apellido debe contener Letras y espacios,
                                    pueden
                                    llevar acentos.</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-3 mb-3">
                                <div class="form-group" id="grupo_parentesco">
                                    <label class="formulario__label" for="parentesco">Parentesco</label>
                                    <select class="form-control" id="parentesco" name="parentesco">
                                        <option value="">Seleccione</option>
                                        <option value="padre">Padre</option>
                                        <option value="madre">Madre</option>
                                        <option value="otro">Abuela/o</option>
                                        <option value="otro">Hermana/o</option>
                                    </select>
                                    <i class="formulario__validacion-estado fas fa-times-circle"></i>
                                </div>
                                <p class="formulario__input-error">El número de documento debe contener solo
                                    numeros
                                    y
                                    un
                                    mínimo de 7
                                    digitos y máximo 8.
                                </p>
                            </div>

                            <div class="col-sm-3" id="grupo_telefono_r">
                                <label class="formulario__label" for="telefono_r">Telefono</label>
                                <div class="form-group">
                                    <input class="form-control formulario__validacion__input" type="text"
                                        id="telefono_r" name="telefono_r" placeholder="telefono...">
                                    <i class="formulario__validacion-estado fas fa-times-circle"></i>
                                </div>
                                <p class="formulario__input-error">El numero de telefono debe contener solo
                                    numeros
                                    y 11
                                    digitos
                                </p>
                            </div>

                            <div class="col-sm-3" id="grupo_correo_r">
                                <label class="formulario__label" for="correo">Correo</label>
                                <div class="form-group">
                                    <input class="form-control formulario__validacion__input" type="email" id="correo_r"
                                        name="correo_r" placeholder="jhon@gmail.com">
                                    <i class="formulario__validacion-estado fas fa-times-circle"></i>
                                </div>
                                <p class="formulario__input-error">El correo solo puede contener letras,
                                    numeros,
                                    puntos,
                                    guiones.
                                </p>
                            </div>

                            <div class="col-sm-3" id="grupo_direccion_r">
                                <label class="formulario__label " for="direccion">Dirección</label>
                                <div class="form-group">
                                    <input class="form-control formulario__validacion__input" type="text"
                                        id="direccion_r" name="direccion_r" placeholder="Dirección">
                                    <i class="formulario__validacion-estado fas fa-times-circle"></i>
                                </div>
                                <p class="formulario__input-error">La dirección puede contener solo letras,
                                    numeros,
                                    espacios, puntos, numerales y guiones.
                                </p>
                            </div>
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="agregar_representante">Guardar</button>
                </div>
            </div>
        </div>
    </div>




    <?php 
} 
 
    ?>