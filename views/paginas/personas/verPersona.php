<!-- Begin Page Content -->
<style>
.collapse-container-h {
    padding: 10px;
}

.collapse-button-h {
    margin-bottom: 15px;
}

.collapse-content-h {
    height: 0;
    overflow: hidden;
    transition: height 0.3s ease-in-out;
}

.show-h {
    height: auto;
}
</style>

<?php

error_reporting(0);

 
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
    require_once 'controllers/MedicamentosController.php';

 
    $modelPersonas              = new PersonasModel();
    $medicamentosController     = new MedicamentosController();
    
    $selectMedicamentos               = $medicamentosController->selectMedicamentos();
    $selectEnfermedades               = $modelPersonas->selectEnfermedades();
    // var_dump($medicamentos); die();
    $id_persona = $_GET['id']; 
 
    $datos_personas              = $modelPersonas->listarDatosPersona($id_persona);
    $historia_consultas          = $modelPersonas->historiaConsultas($id_persona);
 
    foreach ($datos_personas as $datos_personas) { 
        $id_persona                 = $datos_personas['id_persona']; 
        $n_documento                = $datos_personas['n_documento']; 
        $tipo_documento             = $datos_personas['tipo_documento']; 
        $documento                  = $datos_personas['documento']; 
        $nombre_apellido            = $datos_personas['nombres_apellidos']; 
        $fecha_nacimiento           = $datos_personas['fecha_nacimiento'];
        $fecha_nac                  = $datos_personas['fecha_nac'];
        $sexo                       = $datos_personas['sexo']; 
        $telefono                   = $datos_personas['telefono']; 
        $correo                     = $datos_personas['correo']; 
        $fecha_registro             = $datos_personas['fecha_registro']; 
        $direccion                  = $datos_personas['direccion'];
        $id_historia_medica         = $datos_personas['id'];  
        $tipo_sangre                = $datos_personas['tipo_sangre']; 
        $enfermedad                 = $datos_personas['enfermedad']; 
        $fumador                    = $datos_personas['fumador']; 
        $alcohol                    = $datos_personas['alcohol'];
        $actividad_fisica           = $datos_personas['actividad_fisica'];  
        $medicado                   = $datos_personas['medicado'];
        $cirugia_hospitalaria       = $datos_personas['cirugia_hospitalaria'];
        $alergia                    = $datos_personas['alergia'];  
        $antec_fami                 = $datos_personas['antec_fami'];       
    }



 if(!empty($id_historia_medica)) {

    $datos_enfermedad = $modelPersonas->listarEnfermedades($id_historia_medica);
    
    if(!empty($datos_enfermedad)) {
        foreach($datos_enfermedad as $enfermedad) {
            $patologias[] = $enfermedad['nombre_patologia'];
        }
    
        $enfermedades = implode(', ', $patologias);
      
    }

    $datos_medicamentos = $modelPersonas->listarMedicamentos($id_historia_medica);
    
    if(!empty($datos_medicamentos)) {
        foreach($datos_medicamentos as $medicamento) {
            $array_medicamentos[] = $medicamento['nombre_medicamento'];
        }
    
        $medicamentos = implode(', ', $array_medicamentos);
      
    }
 }

  $validar_representante = $modelPersonas->consultarRepresentante($id_persona);
  if(!empty($validar_representante)) {
    foreach ($validar_representante as $validar_representante) {
        $id_representante = $validar_representante['id_representante'];
        // var_dump($id_representante);
    }
    }


    $validar_representado = $modelPersonas->consultarRepresentado($id_persona);
    
    if(!empty($validar_representado)) {
        foreach ($validar_representado as $validar_representado) {
            $id_representado = $validar_representado['id'];
            // var_dump($id_representado);
        }
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
                                                    <th style="background-color:#b7d0f7;">Nª documento</th>
                                                    <th style="background-color:#b7d0f7;">Nombres/Apellidos</th>
                                                    <th style="background-color:#b7d0f7;">Sexo</th>
                                                    <th style="background-color:#b7d0f7;">Telèfono</th>
                                                    <th style="background-color:#b7d0f7;">Correo</th>
                                                    <th style="background-color:#b7d0f7;">Fecha de nacimiento</th>
                                                    <th style="background-color:#b7d0f7;">Direcciòn</th>
                                                    <th style="background-color:#b7d0f7;">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="table-primary">
                                                    <td><?= $documento ?></td>
                                                    <td><?= $nombre_apellido ?></td>
                                                    <td><?= $sexo ?></td>
                                                    <td><?= $telefono ?></td>
                                                    <td><?= $correo ?></td>
                                                    <td><?= $fecha_nac ?></td>
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

                                                        <button title="Agregrar representante" class="btn btn-danger btn-sm"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modalAgregarRepresentante"><i
                                                                class="fas fa-user-plus"
                                                                title="agregar representante"></i></button>

                                                        <button title="Llenar historial médico"
                                                            class="btn btn-success btn-sm" data-bs-toggle="modal"
                                                            data-bs-target="#modalAgregarHistoriaMedica"><i
                                                                class="bi bi-clipboard-plus"></i></button>
                                                        <?php
                                                            }else{
                                                                ?>

                                                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                            data-bs-target="#modalAgregarRepresentado"> <i
                                                                class="fas fa-user-plus"
                                                                title="Agregar representado"></i></button>

                                                        <button title="Llenar historial médico"
                                                            class="btn btn-success btn-sm" data-bs-toggle="modal"
                                                            data-bs-target="#modalAgregarHistoriaMedica"><i
                                                                class="bi bi-clipboard-plus"></i></button>
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

                                    <?php if(!empty($id_representado)) {
                                    
                                    $datos_representante         = $modelPersonas->verRepresentante($id_representado);

                                    foreach ($datos_representante as $datos_representante) {
                                        $documento_r                    = $datos_representante['documento']; 
                                        $nombres_apellidos_r            = $datos_representante['nombres_apellidos']; 
                                        $direccion_r                    = $datos_representante['direccion']; 
                                        $telefono_r                     = $datos_representante['telefono']; 
                                        $correo_r                       = $datos_representante['correo'];
                                        $parentesco                     = $datos_representante['parentesco']; 
                                    }
                                        
                                    ?>
                                        
                                        
                                    <h5>DATOS DEL REPRESENTANTE</h5>
                                    <div class="table-responsive mb-3">
                                        <table class="table table-bordered table-hover ">

                                            <thead>
                                                <tr class="table-primary">
                                                    <th style=" background-color:#b7d0f7;">Nº documento</th>
                                                    <th style=" background-color:#b7d0f7;">Nombres/Apellidos</th>
                                                    <th style=" background-color:#b7d0f7;">Telefono</th>
                                                    <th style=" background-color:#b7d0f7;">Correo</th>
                                                    <th style=" background-color:#b7d0f7;">Direccion</th>
                                                    <th style=" background-color:#b7d0f7;">Parentesco</th>
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
                                    <?php }elseif(!empty($id_representante)){
                                        
                                    $datos_representado = $modelPersonas->verRepresentado($id_representante);
                                    foreach ($datos_representado as $datos_representado) {
                                        $nombres_apellidos_re            = $datos_representado['nombres_apellidos']; 
                                        $documento_re                    = $datos_representado['documento']; 
                                        $direccion_re                    = $datos_representado['direccion']; 
                                        $telefono_re                     = $datos_representado['telefono']; 
                                        $correo_re                       = $datos_representado['correo'];
                                        $parentesco_re                   = $datos_representado['parentesco']; 
                                    }
                                   
                                    
                                    ?>

                                    <h5>DATOS DEL REPRESENTADO</h5>

                                    <div class="table-responsive mb-3">
                                        <table class="table table-bordered table-hover ">

                                            <thead>
                                                <tr class="table-primary">
                                                    <th style=" background-color:#b7d0f7;">Nº documento</th>
                                                    <th style=" background-color:#b7d0f7;">Nombres/Apellidos</th>
                                                    <th style=" background-color:#b7d0f7;">Telefono</th>
                                                    <th style=" background-color:#b7d0f7;">Correo</th>
                                                    <th style=" background-color:#b7d0f7;">Direccion</th>
                                                    <th style=" background-color:#b7d0f7;">Parentesco</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="table-primary">
                                                    <td><?= $documento_re ?></td>
                                                    <td><?= $nombres_apellidos_re ?></td>
                                                    <td><?= $telefono_re ?></td>
                                                    <td><?= $correo_re ?></td>
                                                    <td><?= $direccion_re ?></td>
                                                    <td><?= $parentesco_re ?></td>

                                                </tr>

                                            </tbody>
                                        </table>

                                    </div>
                                    
                                    <?php }?>

                                    <div class="collapse-container-h col-12" >
                                        <button class="collapse-button-h btn btn-primary">Mostrar historia
                                            médica/Ocultar</button>
                                        <div class="collapse-content-h col-12">
                                            <div class="table-responsive mb-3">
                                                <table class="table table-bordered table-primary table-hover ">

                                                    <thead>
                                                        <tr>
                                                            <th style=" background-color:#b7d0f7;">Tipo de sangre</th>
                                                            <th style=" background-color:#b7d0f7;">Enfermedades</th>
                                                            <th style=" background-color:#b7d0f7;">Fumador</th>
                                                            <th style=" background-color:#b7d0f7;">Alcohol</th>
                                                            <th style=" background-color:#b7d0f7;">Actividad Fisica</th>
                                                            <th style=" background-color:#b7d0f7;">Cirugías</th>
                                                            <th style=" background-color:#b7d0f7;">Alergias</th>
                                                            <th style=" background-color:#b7d0f7;">Antecedentes
                                                                familiares
                                                            </th>
                                                            <th style=" background-color:#b7d0f7;">Medicamentos tomados
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php if(!empty($id_historia_medica)) { ?>
                                                        <tr>
                                                            <td style="text-align: center;"><?= $tipo_sangre ?></td>
                                                            <?php if(!empty($enfermedades)) {?>
                                                            <td style="text-align: center;"><?= $enfermedades ?></td>
                                                            <?php } else{ ?>
                                                            <td style="text-align: center;"><?= 'vacío' ?></td>
                                                            <?php } ?>
                                                            <td style="text-align: center;"><?= $fumador ?></td>
                                                            <td style="text-align: center;"><?= $alcohol ?></td>
                                                            <td style="text-align: center;"><?= $actividad_fisica ?>
                                                            </td>
                                                            <td style="text-align: center;"><?= $cirugia_hospitalaria ?>
                                                            </td>
                                                            <td style="text-align: center;"><?= $alergia ?></td>
                                                            <td style="text-align: center;"><?= $antec_fami ?></td>
                                                            <?php if(!empty($medicamentos)) {?>
                                                            <td style="text-align: center;"><?= $medicamentos ?></td>
                                                            <?php } else{ ?>
                                                            <td style="text-align: center;"><?= 'vacío' ?></td>
                                                            <?php }?>
                                                        </tr>
                                                        <?php }else{ ?>
                                                        <tr style="text-align: center;">
                                                            <td colspan="9" style="text-align: center;">No hay datos
                                                            </td>
                                                        </tr>
                                                        <?php } ?>
                                                    </tbody>


                                                    <tfoot>

                                                    </tfoot>
                                                </table>
                                            </div>

                                            <div class="col-12">
                                                <strong>
                                                    <h5>Histórico de consultas</h5>
                                                </strong>
                                                <div class="table-responsive" >
                                                    <table class="table table-bordered table-hover display" style="width: 100%;" id="tbl_historia_consultas" >

                                                        <thead>
                                                            <tr class="table-success">
                                                                <th style="background:#a6cdbb;">Fecha</th>
                                                                <th style="background:#a6cdbb;">Especialidad</th>
                                                                <th style="background:#a6cdbb;">Especialista</th>
                                                                <th style="background:#a6cdbb;">Motivo</th>
                                                                <th style="background:#a6cdbb;">Diagnostico</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php if(!empty($historia_consultas)){
                                                         foreach ($historia_consultas as $h) { ?>


                                                            <tr class="table-success">
                                                                <td>
                                                                    <?=  $h['fecha_registro'] ?>
                                                                </td>
                                                                <td>
                                                                    <?= $h['nombre_especialidad'] ?>
                                                                </td>
                                                                <td>
                                                                    <?= $h['especialista'] ?>
                                                                </td>
                                                                <td>
                                                                    <?= $h['motivo'] ?>
                                                                </td>
                                                                <td>
                                                                    <a href="index.php?page=imprimirRecipe&amp;id=<?= $h['id_consulta']?>"
                                                                        target="_blank" class="btn btn-danger btn-sm"><i
                                                                            class="fas fa-print"></i></a>&nbsp
                                                                </td>
                                                            </tr>

                                                            <?php }} ?>

                                                            

                                                          


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
<div class="modal fade" id="modalAgregarRepresentante" tabindex="-1" aria-labelledby="modalAgregarRepresentanteLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAgregarRepresentanteLabel">Agregar Representante <i
                        class="fas fa-user"></i></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" id="formRegistrarRepresentante">


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
                                <input type="hidden" value="<?= $id_persona ?>" id="id_representante">
                                <input type="hidden" name="tipo_persona_r" id="tipo_persona_r" value="Paciente">
                                <input class="form-control formulario__validacion__input" type="text" id="n_documento_r"
                                    name="n_documento_r" placeholder="Nº de documento">
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
                                Femenino <input class="formulario__validacion__input" type="radio" name="sexo" id="sexo"
                                    value="Femenino">
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
                                    type="text" id="primer_nombre_r" name="primer_nombre_r" placeholder="Primer nombre"
                                    required>
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
                                    id="segundo_apellido_r" name="segundo_apellido_r" placeholder="Segundo apellido">
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
                                    <option value="Padre">Padre</option>
                                    <option value="Madre">Madre</option>
                                    <option value="Abuelo/a">Abuelo/a</option>
                                    <option value="Hermano/a">Hermano/a</option>
                                    <option value="Tio/a">Tio/a</option>
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
                                <input class="form-control formulario__validacion__input" type="text" id="telefono_r"
                                    name="telefono_r" placeholder="telefono...">
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
                                <input class="form-control formulario__validacion__input" type="text" id="direccion_r"
                                    name="direccion_r" placeholder="Dirección">
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



<!-- Modal agregar representado -->

<div class="modal fade" id="modalAgregarRepresentado" tabindex="-1" aria-labelledby="modalAgregarRepresentadoLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAgregarRepresentadoLabel">Agregar representado <i
                        class="fas fa-user"></i></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" id="formRegistrarRepresentado">


                    <div class="row">

                        <div class="col-sm-2 mb-3">
                            <div class="form-group" id="grupo_tipo_documento_re">
                                <label class="formulario__label" for="tipo_documento_re">Tipo de
                                    documento</label>
                                <select class="form-control formulario__validacion__input" name="tipo_documento_re"
                                    id="tipo_documento_re">
                                    <option value="">Seleccione</option>
                                    <option value="V">V</option>
                                    <option value="E">E</option>
                                    <option value="P">P</option>
                                </select>
                                <i class="formulario__validacion-estado fas fa-times-circle"></i>
                            </div>
                        </div>



                        <div class="col-sm-3 mb-3" id="grupo_n_documento_re">
                            <label class="formulario__label" for="n_documento_representante">Nº
                                documento</label>
                            <div class="form-group">
                                <input type="hidden" value="<?= $id_persona ?>" id="id_representado">
                                <input type="hidden" name="tipo_persona" id="tipo_persona" value="Paciente">
                                <input class="form-control formulario__validacion__input" type="text" id="n_documento_re"
                                    name="n_documento_re" placeholder="Nº de documento">
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
                                Femenino <input class="formulario__validacion__input" type="radio" name="sexo" id="sexo"
                                    value="Femenino">
                            </div>
                        </div>
                        <div class="col-sm-3 mb-3" id="grupo_fecha_nac">
                            <div class="form-group">
                                <label class="formulario__label" for="fecha_nac_re">Fecha de nacimiento</label>
                                <input type="date" class="form-control formulario__validacion__input" id="fecha_nac_re"
                                    name="fecha_nac_re" required>
                                <i class="formulario__validacion-estado fas fa-times-circle"></i>
                            </div>
                            <p class="formulario__input-error">La fecha de nacimiento no puede ser una fecha
                                futura.
                            </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-3 mb-3" id="grupo_primer_nombre_re">
                            <label class="formulario__label" for="primer_nombre_re">Primer nombre</label>
                            <div class="form-group">
                                <input class="form-control formulario__validacion__input" onkeyup="pmayus(this);"
                                    type="text" id="primer_nombre_re" name="primer_nombre_re" placeholder="Primer nombre"
                                    required>
                                <i class="formulario__validacion-estado fas fa-times-circle"></i>
                            </div>
                            <p class="formulario__input-error">El nombre debe contener Letras, numeros, guion y
                                guion_bajo</p>
                        </div>

                        <div class="col-sm-3 mb-3" id="grupo_segundo_nombre_re">
                            <label class="formulario__label" for="segundo_nombre_re">Segundo nombre</label>
                            <div class="form-group">
                                <input class="form-control formulario__validacion__input" type="text"
                                    id="segundo_nombre_re" name="segundo_nombre_re" placeholder="Segundo nombre">
                                <i class="formulario__validacion-estado fas fa-times-circle"></i>
                            </div>
                            <p class="formulario__input-error">El nombre debe contener Letras, numeros, guion y
                                guion_bajo</p>
                        </div>

                        <div class="col-sm-3 mb-3" id="grupo_primer_apellido_re">
                            <label class="formulario__label" for="primer_apellido_re">Primer apellido</label>
                            <div class="form-group ">
                                <input class="form-control formulario__validacion__input" type="text"
                                    id="primer_apellido_re" name="primer_apellido_re" placeholder="Primer apellido"
                                    required>
                                <i class="formulario__validacion-estado fas fa-times-circle"></i>
                            </div>
                            <p class="formulario__input-error">El apellido debe contener Letras y espacios,
                                pueden
                                llevar acentos.</p>
                        </div>

                        <div class="col-sm-3 mb-3" id="grupo_segundo_apellido_re">
                            <label class="formulario__label" for="grupo_primer_apellido">Segundo
                                apellido</label>
                            <div class="form-group ">
                                <input class="form-control formulario__validacion__input" type="text"
                                    id="segundo_apellido_re" name="segundo_apellido_re" placeholder="Segundo apellido">
                                <i class="formulario__validacion-estado fas fa-times-circle"></i>
                            </div>
                            <p class="formulario__input-error">El apellido debe contener Letras y espacios,
                                pueden
                                llevar acentos.</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-3 mb-3">
                            <div class="form-group" id="grupo_parentesco_re">
                                <label class="formulario__label" for="parentesco_re">Parentesco</label>
                                <select class="form-control" id="parentesco_re" name="parentesco_re">
                                    <option value="">Seleccione</option>
                                    <option value="padre">Padre</option>
                                    <option value="madre">Madre</option>
                                    <option value="Hijo/a">Hijo/a</option>
                                    <option value="Abuelo/a">Abuelo/a</option>
                                    <option value="Hermano/a">Hermano/a</option>
                                    <option value="Tio/a">Tio/a</option>
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

                        <div class="col-sm-3" id="grupo_telefono_re">
                            <label class="formulario__label" for="telefono_re">Telefono</label>
                            <div class="form-group">
                                <input class="form-control formulario__validacion__input" type="text" id="telefono_re"
                                    name="telefono_re" placeholder="telefono...">
                                <i class="formulario__validacion-estado fas fa-times-circle"></i>
                            </div>
                            <p class="formulario__input-error">El numero de telefono debe contener solo
                                numeros
                                y 11
                                digitos
                            </p>
                        </div>

                        <div class="col-sm-3" id="grupo_correo_re">
                            <label class="formulario__label" for="correo_re">Correo</label>
                            <div class="form-group">
                                <input class="form-control formulario__validacion__input" type="email" id="correo_re"
                                    name="correo_re" placeholder="jhon@gmail.com">
                                <i class="formulario__validacion-estado fas fa-times-circle"></i>
                            </div>
                            <p class="formulario__input-error">El correo solo puede contener letras,
                                numeros,
                                puntos,
                                guiones.
                            </p>
                        </div>

                        <div class="col-sm-3" id="grupo_direccion_re">
                            <label class="formulario__label " for="direccion">Dirección</label>
                            <div class="form-group">
                                <input class="form-control formulario__validacion__input" type="text" id="direccion_re"
                                    name="direccion_re" placeholder="Ingrese la dirección">
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
                <button type="button" class="btn btn-primary" id="agregar_representado">Guardar</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal agregar historial medico -->

<div class="modal fade" id="modalAgregarHistoriaMedica" tabindex="-1" aria-labelledby="modalAgregarHistoriaMedicaLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAgregarHistoriaMedicaLabel">Agregar Historia médica <i
                        class="bi bi-clipboard-plus"></i></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formRegistrarHistoriaMedica">


                    <div class="row">
                        <div class="mb-3 col-sm-3">
                            <div class="form-group" id="grupo_tipo_sangre">
                                <label class="formulario__label" for="tipo_sangre">Tipo de sangre</label>
                                <select class="form-control formulario__validacion__input" name="tipo_sangre"
                                    id="tipo_sangre">
                                    <option value="">Seleccione</option>
                                    <option value="A+">A+</option>
                                    <option value="A-">A-</option>
                                    <option value="B+">B+</option>
                                    <option value="B-">B-</option>
                                    <option value="AB+">AB+</option>
                                    <option value="AB-">AB-</option>
                                    <option value="O+">O+</option>
                                    <option value="O-">O-</option>
                                </select>
                                <i class="formulario__validacion-estado fas fa-times-circle"></i>
                            </div>
                        </div>

                        <div class="mb-3 col-sm-9">
                            <div class="form-group" id="grupo_enfermedad">
                                <label class="formulario__label" for="enfermedad">Enfermedades</label>
                                <select
                                    class="js-example-basic-multiple select2-selection--single select-multiple-enfermedades"
                                    style="width:100%" name="states[]" multiple="multiple">
                                    <?php foreach ($selectEnfermedades as $e) {?>

                                    <option value="<?= $e['id_patologia'] ?>">
                                        <?= $e['nombre']?>
                                    </option>
                                    <?php } ?>
                                </select>
                                <small id="estadoHelp" class="form-text text-muted">Selecciona la
                                    enfermedad</small>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="mb-3 col-sm-12">
                            <div class="form-group" id="grupo_ciru_hospi">
                                <label class="formulario__label" for="ciru_hospi">Cirugías u
                                    hospitalizaciones</label>
                                <input class="form-control formulario__validacion__input" type="text" id="ciru_hospi"
                                    name="ciru_hospi" placeholder="Cirugías o hospitalizaciones...">
                                <i class="formulario__validacion-estado fas fa-times-circle"></i>
                            </div>
                        </div>


                    </div>

                    <div class="row">

                        <div class="mb-3 col-sm-12">
                            <div class="form-group" id="grupo_alergia">
                                <label class="formulario__label" for="alergia">Alergias</label>
                                <input class="form-control formulario__validacion__input" type="text" id="alergia"
                                    name="alergia" placeholder="Alergias...">
                                <i class="formulario__validacion-estado fas fa-times-circle"></i>
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="mb-3 col-sm-12">
                            <div class="form-group" id="grupo_ciru_hospi">
                                <label class="formulario__label" for="ciru_hospi">Antecedentes familiares</label>
                                <input class="form-control formulario__validacion__input" type="text" id="antec_fami"
                                    name="ciru_hospi" placeholder="Antecedentes familiares...">
                                <i class="formulario__validacion-estado fas fa-times-circle"></i>
                            </div>
                        </div>




                    </div>

                    <div class="row">

                        <div class="mb-3 col-sm-4">
                            <div class="form-group" id="grupo_medicado">
                                <label class="formulario__label" for="medicado">Medicado</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="medicado" name="medicado">
                                    <label class="form-check-label" for="medicado">¿Está medicado?</label>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 col-sm-8" id="indiqueCual" style="display:none;">
                            <div class="form-group">
                                <label class="formulario__label" for="enfermedad">Medicamentos</label>
                                <select
                                    class="js-example-basic-multiple select2-selection--single select-multiple-medicamentos"
                                    style="width:100%" name="states[]" multiple="multiple">

                                    <?php foreach ($selectMedicamentos as $m) { ?>

                                    <option value="<?= $m['id_presentacion_medicamento'] ?>">
                                        <?= $m['nombre_medicamento'] . ' ' . $m['presentacion'] ?>
                                    </option>
                                    <?php } ?>
                                </select>
                                <small id="estadoHelp" class="form-text text-muted">Selecciona el
                                    medicamento</small>
                            </div>
                        </div>

                    </div>
                    <h6><strong>Hábitos</strong></h6>

                    <div class="row">


                        <div class="mb-3 col-sm-4">
                            <div class="form-group">
                                <label class="formulario__label" for="fumador">Fumador</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="fumador" name="fumador">
                                    <label class="form-check-label" for="fumador">¿Es fumador?</label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 col-sm-8" id="f_fumador" style="display:none;">
                            <div class="form-group">
                                <div class="form-group">
                                    <label class="formulario__label" for="frecuencia_f"></label>
                                    <input class="form-control formulario__validacion__input" type="text"
                                        id="frecuencia_f" name="frecuencia_f" placeholder="¿Con que frecuencia?">
                                    <i class="formulario__validacion-estado fas fa-times-circle"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="mb-3 col-sm-4">
                            <div class="form-group" id="grupo_alcohol">
                                <label class="formulario__label" for="alcohol">Alcohol</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="alcohol" name="alcohol">
                                    <label class="form-check-label" for="alcohol">¿Consume alcohol?</label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 col-sm-8" id="f_alcohol" style="display:none;">
                            <div class="form-group">
                                <div class="form-group" id="grupo_ciru_hospi">
                                    <label class="formulario__label" for="frecuencia_alcohol"></label>
                                    <input class="form-control formulario__validacion__input" type="text"
                                        id="frecuencia_alcohol" name="frecuencia_alcohol"
                                        placeholder="¿Con que frecuencia?">
                                    <i class="formulario__validacion-estado fas fa-times-circle"></i>
                                </div>
                            </div>
                        </div>


                    </div>

                    <div class="row">

                        <div class="mb-3 col-sm-4">
                            <div class="form-group">
                                <label class="formulario__label" for="ac_fisica">Actividad física</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="ac_fisica" name="ac_fisica">
                                    <label class="form-check-label" for="ac_fisica">¿Realiza actividad
                                        física?</label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 col-sm-8" id="f_ac_fisica" style="display:none;">
                            <div class="form-group">
                                <div class="form-group">
                                    <label class="formulario__label" for="frecuencia_ac_fisica"></label>
                                    <input class="form-control formulario__validacion__input" type="text"
                                        id="frecuencia_ac_f" name="frecuencia_ac_f" placeholder="¿Con que frecuencia?">
                                    <i class="formulario__validacion-estado fas fa-times-circle"></i>
                                </div>
                            </div>
                        </div>


                    </div>


                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="agregar_historia_medica">Guardar</button>
            </div>
        </div>
    </div>
</div>



<script>
const checkbox = document.getElementById('medicado');
const inputText = document.getElementById('indiqueCual');

const checkbox_f = document.getElementById('fumador');
const inputText_f = document.getElementById('f_fumador');

const checkbox_alcoh = document.getElementById('alcohol');
const inputText_alcoh = document.getElementById('f_alcohol');

const checkbox_ac = document.getElementById('ac_fisica');
const inputText_ac = document.getElementById('f_ac_fisica');



function habilitarInput(checkbox, inputText) {
    checkbox.addEventListener('change', function() {
        inputText.style.display = this.checked ? 'block' : 'none';
    });
}


habilitarInput(checkbox, inputText)
habilitarInput(checkbox_f, inputText_f)
habilitarInput(checkbox_alcoh, inputText_alcoh)
habilitarInput(checkbox_ac, inputText_ac)

const collapseButton = document.querySelector('.collapse-button-h');
const collapseContent = document.querySelector('.collapse-content-h');

collapseButton.addEventListener('click', () => {
    collapseContent.classList.toggle('show-h');
});
</script>



<?php 
} 
 
    ?>