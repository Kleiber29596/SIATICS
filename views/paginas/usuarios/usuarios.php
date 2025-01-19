<!-- Begin Page Content -->

<?php


require_once 'controllers/RolesController.php';
require_once 'controllers/EspecialidadController.php';
$objeto                 = new RolesController();

$roles                  = $objeto->listaRoles();
$roles_update           = $objeto->listaRoles();


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

$objeto  = new EspecialidadController();
$especialidades = $objeto->selectEspecialidad();


?>




<style>
.file-upload {
    position: relative;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    height: 150px;
    padding: 30px;
    border: 1px dashed silver;
    border-radius: 8px;
}

.file-upload input {
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    width: 100%;
    cursor: pointer;
    opacity: 0;
}

.preview_img {
    height: 80px;
    width: 80px;
    border: 4px solid silver;
    border-radius: 100%;
    object-fit: cover;
}

.step-2,
.step-3,
#agregar_usuario {
    display: none;
}
</style>



<?php

if ($rol == 3 || $rol == 4 ||  $rol == 5 || $rol == 1) {
    echo "<h1>No tienes los permisos suficientes para ingresar en este modulo</h1>";
} else {
?>

<div class="pagetitle">
    <h1>Usuarios</h1>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <p></p>
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#agregarUsuarioModal">
                        <i class="fas fa-plus"></i>
                    </button>
                    <div class="table-responsive">
                        <!-- Table with stripped rows -->
                        <table class="table datatable" id="tablaUsuario">
                            <thead>
                                <tr>
                                    <th>Cédula</th>
                                    <th>Usuario</th>
                                    <th>Rol</th>
                                    <th>Nombres/Apellidos</th>
                                    <th>Foto</th>
                                    <th>Estatus</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>


<!-- /.container-fluid -->




<!-- Modal Agregar Usuario -->
<div class="modal fade" id="agregarUsuarioModal" tabindex="-1" aria-labelledby="agregarUsuarioModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="agregarUsuarioModalLabel">Agregar Usuario <i class="fas fa-user"></i></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formRegistrarUsuario">
                    <div class="col-sm-12">
                        <div class="bloque-1 active">
                            <div class="row">
                                <h5>Datos personales</h5>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="T_doc">Tipo</label>
                                        <select class="form-control" id="T_doc">
                                            <option value="V">V</option>
                                            <option value="E">E</option>
                                            <option value="P">P</option>
                                        </select>
                                    </div>
                                </div>
                                <br>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="cedula">Numero de cedula</label>
                                        <input class="form-control" type="text" name="cedu" id="cedu" maxlength="10"
                                            placeholder="Ingresa el número de cédula" required>
                                    </div>
                                </div>
                                <div class="col-sm-1"
                                    style="display: flex; justify-content: flex-start; align-items: flex-end;">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-primary" id="citaPersona_consulta"
                                            title="Buscar persona"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="p_nombre">Primer nombre</label>
                                        <input class="form-control" type="text" name="p_nombre" disabled id="p_nombre"
                                            placeholder="Primer nombre" onkeyup="pmayus(this)" required>
                                    </div>
                                </div>
                                <br>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="s_nombre">Segundo nombre</label>
                                        <input class="form-control" type="text" name="s_nombre" disabled id="s_nombre"
                                            placeholder="Segundo nombre" onkeyup="pmayus(this)">
                                    </div>
                                </div>
                                <br>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="p_apellido">Primer apellido</label>
                                        <input class="form-control" type="text" name="p_apellido" disabled
                                            id="p_apellido" placeholder="Primer apellido" onkeyup="pmayus(this)"
                                            required>
                                    </div>
                                </div>
                                <br>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="s_apellido">Segundo apellido</label>
                                        <input class="form-control" type="text" name="s_apellido" disabled
                                            id="s_apellido" placeholder="Segundo apellido" onkeyup="pmayus(this)">
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="sexoMasculino">Sexo</label>
                                        <br>
                                        Masculino <input type="radio" name="sexo" value="Masculino">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="sexoFemenino"></label>
                                        <br>
                                        Femenino <input type="radio" name="sexo" value="Femenino">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="fechaNacimiento">Fecha de nacimiento</label>
                                        <input class="form-control" type="date" disabled name="fechaNacimiento"
                                            id="fechaNacimiento" maxlength="10" oninput="validarFechaNacimiento()"
                                            required>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="numTelf">Numero de contacto</label>
                                        <input class="form-control" type="text" name="numTelf" disabled id="numTelf"
                                            placeholder="Número de contacto" maxlength="11" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="correos">Correo</label>
                                        <input class="form-control" type="email" name="correo" disabled id="correo"
                                            maxlength="60" placeholder="Ingresa la dirección">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="direccion_c">Dirección corta</label>
                                        <textarea class="form-control" name="direccion_c" disabled id="direccion_c"
                                            cols="4" rows="2" placeholder="Ingresa una dirección corta"
                                            required></textarea>
                                    </div>
                                </div>
                                <div>
                                    <input type="hidden" name="tipo_persona" id="tipo_persona" value="usuario">
                                </div>
                            </div>
                            <br>
                            <div class="row">

                            </div>
                            <br>
                        </div>
                        <div class="bloque-2" style="display: none;">
                            <div id="camposContainer">
                                <h5>Horario laboral</h5>
                                <div class="row campo">
                                    <div class="col-md-4">
                                        <label class="form-group" for="dia">Día de la semana</label>
                                        <select class="form-control" name="dia" id="dia">
                                            <option value="" disabled selected>Seleccione un día</option>
                                            <option value="Lunes">Lunes</option>
                                            <option value="Martes">Martes</option>
                                            <option value="Miercoles">Miercoles</option>
                                            <option value="Jueves">Jueves</option>
                                            <option value="Viernes">Viernes</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-group" for="H_entrada">Hora de entrada</label>
                                        <input type="time" class="form-control" name="H_entrada" id="H_entrada"
                                            placeholder="Hora de entrada">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-group" for="H_salida">Hora de salida</label>
                                        <input type="time" class="form-control" name="H_salida" id="H_salida"
                                            placeholder="Hora de salida">
                                    </div>
                                </div>
                                <div class="col-md-12 mt-2"
                                    style="display: flex; justify-content: flex-end; align-items: flex-end;">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-primary btn-circle" id="agregar_horario"
                                            title="Agregar otro día"><i class="fas fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                            <br>
                        </div>
                        <div class="bloque-3" style="display: none;">
                            <h5>Creación de usuario</h5>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="usuario">Usuario</label>
                                        <input class="form-control" type="text" name="usuario" id="usuario"
                                            maxlength="40" placeholder="Ingresa el nombre de usuario" required>
                                    </div>
                                </div>
                                <div class="col-sm-6" id="cont_input_file2">
                                    <div class="form-group">
                                        <label for="Foto">Foto</label>
                                        <input type="file" class=" form-control" name="archivo" id="subirfoto2"
                                            accept="image/*">
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="contrasena">constraseña</label>
                                        <input class="form-control" type="password" name="contrasena" id="contrasena"
                                            maxlength="60" placeholder="Ingresa la contraseña" required>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="confirmar_contrasena">confirmar contraseña</label>
                                        <input class="form-control" type="password" name="confirmar_contrasena"
                                            id="confirmar_contrasena" maxlength="60" placeholder="Ingresa la contraseña"
                                            required>
                                    </div>
                                </div>
                                <span id="check_password_match"></span>
                            </div>
                            <br>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="rol">Rol</label>
                                        <select class="form-control" name="rol" id="rol">
                                            <option value="3" selected>Doctor/a</option>
                                            <option value="4" selected>Recepcionista</option>
                                            <option value="5" selected>Coordinador/a</option>
                                            <option value="6" selected>RRHH</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="formulario__label" for="especialidad">Especialidad</label>
                                        <select class="form-control" name="especialidad" id="especialidad" required>
                                            <option value="" disabled selected>Seleccione</option>
                                            <?php
                                            foreach ($especialidades  as  $especialidad) {
                                            ?>
                                            <option value="<?= $especialidad['id_especialidad'] ?>">
                                                <?= $especialidad['nombre_especialidad'] ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <br>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" title="Cerrar el modal"
                                data-bs-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-primary" id="atrasBlock"
                                style="display: none;">Atrás</button>
                            <button type="button" class="btn btn-primary" id="siguienteBlock">Siguiente</button>
                            <button type="submit" class="btn btn-primary" id="agregar_usuario"
                                title="Guardar cambios"><i class="fas fa-save" style="display:none;"></i>
                                Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>





<!-- Modal Actualizar medicamento -->
<div class="modal fade" id="modalActualizarUsuarios" tabindex="-1" aria-labelledby="modalActualizarUsuariosLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalActualizarUsuariosLabel">Modificar Usuario <i class="fas fa-edit"></i>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" id="formActualizarMedicamento">

                    <div class="row">

                        <div class="col-sm-3">
                            <div class="form-group" id="grupo_tipo_documento">
                                <label class="formulario__label" for="tipo_documento_u">Tipo documento</label>
                                <select class="form-control formulario__validacion__input" name="tipo_documento_u"
                                    id="tipo_documento_u">
                                    <option value="">Seleccione</option>
                                    <option value="V">V</option>
                                    <option value="E">E</option>
                                    <option value="P">P</option>
                                </select>
                                <i class="formulario__validacion-estado fas fa-times-circle"></i>
                            </div>
                        </div>

                        <div class="col-sm-3 mb3" id="grupo_n_documento">
                            <label class="formulario__label" for="n_documento">Nº de documento</label>
                            <div class="form-group">
                                <input class="form-control formulario__validacion__input" type="text" id="n_documento_u"
                                    maxlength="8" minlength="6" name="n_documento_u" placeholder="Ingrese el Nº"
                                    required>
                                <i class="formulario__validacion-estado fas fa-times-circle"></i>
                            </div>
                            <p class="formulario__input-error">El número de documento debe contener solo némeros y
                                un
                                mínimo de 7
                                digitos y máximo 8.
                            </p>
                        </div>
                    </div>


                    <div class="row">

                        <div class="col-sm-3" id="grupo_primer_nombre">
                            <label class="formulario__label" for="nombres">Primer nombre</label>
                            <div class="form-group">
                                <input id="id_usuario_update" name="id_usuario_update" type="hidden" value="">
                                <input class="form-control formulario__validacion__input" type="text" id="p_nombre_u"
                                    name="p_nombre_u" placeholder="Primer nombre" required>
                                <i class="formulario__validacion-estado fas fa-times-circle"></i>
                            </div>
                            <p class="formulario__input-error">El nombre debe contener Letras, numeros, guion y
                                guion_bajo</p>
                        </div>

                        <div class="col-sm-3" id="grupo_segundo_nombre">
                            <label class="formulario__label" for="segundo_nombre_u">Segundo nombre</label>
                            <div class="form-group">
                                <input class="form-control formulario__validacion__input" type="text" id="s_nombre_u"
                                    name="s_nombre_u" placeholder="Segundo nombre">
                                <i class="formulario__validacion-estado fas fa-times-circle"></i>
                            </div>
                            <p class="formulario__input-error">El nombre debe contener Letras, numeros, guion y
                                guion_bajo</p>
                        </div>
                        <div class="col-sm-3" id="grupo_primer_apellido">
                            <label class="formulario__label" for="primer_apellido_u">Primer apellido</label>
                            <div class="form-group ">
                                <input class="form-control formulario__validacion__input" type="text" id="p_apellido_u"
                                    name="p_apellido_u" placeholder="Primer apellido" required>
                                <i class="formulario__validacion-estado fas fa-times-circle"></i>
                            </div>
                            <p class="formulario__input-error">El apellido debe contener Letras y espacios, pueden
                                llevar acentos.</p>
                        </div>

                        <div class="col-sm-3" id="grupo_segundo_apellido">
                            <label class="formulario__label" for="grupo_primer_apellido">Segundo apellido</label>
                            <div class="form-group ">
                                <input class="form-control formulario__validacion__input" type="text" id="s_apellido_u"
                                    name="s_apellido_u" placeholder="Segundo apellido">
                                <i class="formulario__validacion-estado fas fa-times-circle"></i>
                            </div>
                            <p class="formulario__input-error">El apellido debe contener Letras y espacios, pueden
                                llevar acentos.</p>
                        </div>

                    </div>


                    <div class="row">

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="correo_update">Correo</label>
                                <input class="form-control" type="email" id="correo_u" name="correo_update_u"
                                    onkeyup="mayus(this);" maxlength="60" placeholder="Ingresa la dirección">
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="direccion_u">Dirección</label>
                                <input class="form-control" type="text" id="direccion_u" name="direccion_u"
                                    maxlength="60" placeholder="Ingresa la dirección">
                            </div>
                        </div>

                        <!-- <div class="col-sm-4">
<div class="form-group">
<label for="contrasena_update">Contraseña</label>
<input class="form-control" type="password" id="contrasena_update_u" name="contrasena_update"
    maxlength="60" placeholder="Ingresa la contraseña">
</div>
</div>

<div class="col-sm-4">
<div class="form-group">
<label for="telefono_update">Confirmar contraseña</label>
<input class="form-control" type="password" id="confirmar_contrasena_update"
    name="confirmar_contrasena_update" maxlength="60" placeholder="Ingresa la contraseña">
</div>
</div> -->

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="usuario_update">Usuario</label>
                                <input class="form-control" type="text" id="usuario_u" name="usuario_u" maxlength="40"
                                    placeholder="Ingresa el nombre de usuario">
                            </div>
                        </div>


                        <div class="col-sm-4">

                            <div class="form-group">
                                <label for="rol_update">Rol</label>
                                <select class="form-control" name="rol_u" id="rol_u">
                                    <option value="">Seleccione</option>
                                    <?php
            foreach ($roles_update as $roles_update) {
            ?>
                                    <option value="<?= $roles_update['id'] ?>"><?= $roles_update['rol'] ?></option>
                                    <?php
            }
            ?>
                                </select>
                            </div>

                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="estatus_update">Estatus</label>
                                <select class="form-control" name="estatus_u" id="estatus_u">
                                    <option value="">Seleccione</option>
                                    <option value="1">Activo</option>
                                    <option value="2">Inactivo</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-4" id="cont_input_file" style="display: none;">
                            <div class="form-group">
                                <label for="Foto">Foto</label>
                                <input type="file" class=" form-control" name="archivo" id="subirfotoUpdate"
                                    accept="image/*">
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-sm-4">
                            <img class="img-circle" id="img_update_preview" style="width:100%;" src="" alt="">
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="check_foto" name="check_foto">
                            <label class="custom-control-label" for="check_foto">Actualizar foto de perfil</label>
                        </div>
                    </div>

                    <div class="modal-footer">

                        <button type="button" class="btn btn-secondary" title="Cerrar el modal"
                            data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" id="modificar_usuario"
                            title="Guardar cambios"><i class="fas fa-save"></i> Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>










<!-- Modal Visualizar Usuario-->

<div class="modal fade" id="modalVisualizarUsuario" tabindex="-1" aria-labelledby="modalVisualizarUsuarioLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalVisualizarUsuarioLabel">Usuario <i
                        class="bi bi-person-circle fs-2"></i></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="list-group">
                    <div class="row">
                        <div class="col-sm-6">
                            <a title="Datos del visitante" href="#"
                                class="list-group-item  list-group-item-action active">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 id="nombre_apellido" class="mb-1">Información del usuario</h5>
                                    <small id="fecha_u"></small>
                                </div>
                                <br>
                                <p id="documento_u" class="mb-1"></p>
                                <p id="nombre_usuario" class="mb-1"></p>
                                <p id="nombre_apellido_u" class="mb-1"></p>
                                <p id="estatus_usuario" class="mb-1"></p>
                            </a>
                        </div>
                        <div class="col-sm-6">
                            <img title="Foto del usuario" style="width: 100%; height: 100%;" id="foto_usuario" src=""
                                alt="">
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
/* -------------- Segmento de bloques - Usuario ------------------ */
let currentStep = 0;

document.getElementById('siguienteBlock').addEventListener('click', function() {
    console.log('Si esta entrando a la funcion');
    const bloques = document.querySelectorAll('.bloque-1, .bloque-2, .bloque-3');
    const activeStep = bloques[currentStep];

    // Validar campos del paso actual
    if (!validateStep(activeStep)) {
        return; // No avanzar si hay campos vacíos
    }

    // Ocultar paso actual
    activeStep.style.display = 'none';
    activeStep.classList.remove('active');

    // Avanzar al siguiente paso
    currentStep++;
    if (currentStep < bloques.length) {
        const nextStep = bloques[currentStep];
        nextStep.style.display = 'block';
        nextStep.classList.add('active');
    }

    // Mostrar botón de guardar en el último paso
    if (currentStep == bloques.length - 1) {
        document.getElementById('siguienteBlock').style.display = 'none';
        document.getElementById('agregar_usuario').style.display = 'block';
    }

    // Mostrar botón "Atrás"
    document.getElementById('atrasBlock').style.display = 'inline-block';
});

document.getElementById('atrasBlock').addEventListener('click', function() {
    const bloques = document.querySelectorAll('.bloque-1, .bloque-2, .bloque-3');

    // Ocultar paso actual
    bloques[currentStep].style.display = 'none';
    bloques[currentStep].classList.remove('active');

    // Retroceder al paso anterior
    currentStep--;

    if (currentStep >= 0) {
        const prevStep = bloques[currentStep];
        prevStep.style.display = 'block';
        prevStep.classList.add('active');
    }

    // Mostrar botón "Siguiente" si no estamos en el último paso
    if (currentStep < bloques.length - 1) {
        document.getElementById('siguienteBlock').style.display = 'inline-block';
        document.getElementById('agregar_usuario').style.display = 'none';
    }

    // Ocultar botón "Atrás" si estamos en el primer paso
    if (currentStep === 0) {
        document.getElementById('atrasBlock').style.display = 'none';
    }
});

function validateStep(step) {
    const inputs = step.querySelectorAll('input, select, textarea');
    let valid = true;

    inputs.forEach(input => {
        if (input.hasAttribute('required') && !input.value) {
            valid = false;
            input.classList.add('is-invalid'); // Agregar clase de error
        } else {
            input.classList.remove('is-invalid'); // Remover clase de error
        }
    });

    return valid;
}
</script>


<?php
}

?>