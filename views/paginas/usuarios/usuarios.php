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
</style>



<?php

if ($rol == 3) {
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
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarUsuarioModal">
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

<?php
}

?>
<!-- /.container-fluid -->




<!-- Modal Agregar Usuario -->
<div class="modal fade" id="agregarUsuarioModal" tabindex="-1" aria-labelledby="agregarUsuarioModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="agregarUsuarioModalLabel">Agregar Usuario <i class="fas fa-user"></i></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                



                <form id="formRegistrarUsuario">
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="p_nombre">Primer nombre</label>
                                    <input class="form-control" type="text" name="p_nombre" id="p_nombre" placeholder="Primer nombre">
                                </div>
                            </div>
                            <br>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="s_nombre">Segundo nombre</label>
                                    <input class="form-control" type="text" name="s_nombre" id="s_nombre" placeholder="Segundo nombre">
                                </div>
                            </div>
                            <br>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="p_apellido">Primer apellido</label>
                                    <input class="form-control" type="text" name="p_apellido" id="p_apellido" placeholder="Primer apellido">
                                </div>
                            </div>
                            <br>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="s_apellido">Segundo apellido</label>
                                    <input class="form-control" type="text" name="s_apellido" id="s_apellido" placeholder="Segundo apellido" onkeyup="pmayus(this);">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="sexo">Sexo</label>
                                    <br>
                                    Masculino <input class="" type="radio" name="sexo" id="sexo" value="M">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="sexo"></label>
                                    <br>
                                    Femenino <input class="" type="radio" name="sexo" id="sexo" value="F">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="fechaNacimiento">Fecha de nacimiento</label>
                                    <input class="form-control" type="date" name="fechaNacimiento" id="fechaNacimiento" maxlength="10" oninput="validarFechaNacimiento()">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="numTelf">Numero de contacto</label>
                                    <input class="form-control" type="text" name="numTelf" id="numTelf" placeholder="Numero de contacto" oninput="validarTelefono(input)" maxlength="8" >
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="T_doc">Tipo</label>
                                    <select class="form-control" id="T_doc">
                                        <option>V</option>
                                        <option>E</option>
                                        <option>P</option>
                                    </select>
                                </div>
                            </div>
                            <br>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="cedula">Numero de cedula</label>
                                    <input class="form-control" type="text" name="cedula" id="cedula" maxlength="10" placeholder="Ingresa el número de cédula" onkeyup="mayus(this);">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="correos">Correo</label>
                                    <input class="form-control" type="email" name="correo" id="correo" maxlength="60" placeholder="Ingresa la dirección">
                                </div>
                            </div>                            
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="direccion_c">Dirección corta</label>
                                    <textarea class="form-control" name="direccion_c" id="direccion_c" cols="4" rows="2" placeholder="Ingresa una dirección corta"></textarea>
                                </div>
                            </div>
                            <div>
                                <input type="hidden" name="tipo_persona" id="tipo_persona" value="Doctor/a">
                            </div>
                        </div>
                        <br>
                        <hr>
                        <br>
                        <!--Inicio de horario-->
                        <h5>Días de Trabajo</h5>
                        <div class="mb-3">
                            <div class="row">
                                <div class="form-check col-sm-2">
                                    <label class="form-check-label"></label>
                                </div>
                                <div class="col-sm-4">
                                    <label class="form-check-label">Entrada</label>
                                </div>
                                <div class="col-sm-4">
                                    <label class="form-check-label">Salida</label>
                                </div>
                            </div>
                           <div class="row">
                                <div class="form-check col-sm-2">
                                    <input class="form-check-input" type="checkbox" id="lunes">
                                    <label class="form-check-label" for="lunes">Lunes</label>
                                </div>
                                <div class="col-sm-4">
                                    <input type="time" class="form-control" placeholder="Entrada" aria-label="Entrada" id="EntradaLunes">
                                </div>
                                <div class="col-sm-4">
                                    <input type="time" class="form-control" placeholder="Salida" aria-label="Salida" id="SalidaLunes">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="row">
                            <div class="form-check col-sm-2">
                                <input class="form-check-input" type="checkbox" id="martes">
                                <label class="form-check-label" for="martes">Martes</label>
                            </div>
                                <div class="col-sm-4">
                                    <input type="time" class="form-control" placeholder="Entrada" aria-label="Entrada" id="EntradaMartes">
                                </div>
                                <div class="col-sm-4">
                                    <input type="time" class="form-control" placeholder="Salida" aria-label="Salida" id="SalidaMartes">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="row">
                            <div class="form-check col-sm-2">
                                <input class="form-check-input" type="checkbox" id="miercoles">
                                <label class="form-check-label" for="miercoles">Miercoles</label>
                            </div>
                                <div class="col-sm-4">
                                    <input type="time" class="form-control" placeholder="Entrada" aria-label="Entrada" id="EntradaMiercoles">
                                </div>
                                <div class="col-sm-4">
                                    <input type="time" class="form-control" placeholder="Salida" aria-label="Salida" id="SalidaMiercoles">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="row">
                            <div class="form-check col-sm-2">
                                <input class="form-check-input" type="checkbox" id="jueves">
                                <label class="form-check-label" for="jueves">Jueves</label>
                            </div>
                                <div class="col-sm-4">
                                    <input type="time" class="form-control" placeholder="Entrada" aria-label="Entrada" id="EntradaJueves">
                                </div>
                                <div class="col-sm-4">
                                    <input type="time" class="form-control" placeholder="Salida" aria-label="Salida" id="SalidaJueves">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="form-check col-sm-2">
                                    <input class="form-check-input" type="checkbox" id="viernes">
                                    <label class="form-check-label" for="viernes">Viernes</label>
                                </div>
                                <div class="col-sm-4">
                                    <input type="time" class="form-control" placeholder="Entrada" aria-label="Entrada" id="EntradaViernes">
                                </div>
                                <div class="col-sm-4">
                                    <input type="time" class="form-control" placeholder="Salida" aria-label="Salida" id="SalidaViernes">
                                </div>
                            </div>
                        </div>
                        <!--Fin horario-->
                        <br>
                        <hr>
                        <br>
                        <h5>Creación de usuario</h5>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="usuario">Usuario</label>
                                    <input class="form-control" type="text" name="usuario" id="usuario" maxlength="40" placeholder="Ingresa el nombre de usuario">
                                </div>
                            </div>
                            <div class="col-sm-6" id="cont_input_file2">
                                <div class="form-group">
                                    <label for="Foto">Foto</label>
                                    <input type="file" class=" form-control" name="archivo" id="subirfoto2" accept="image/*">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="contrasena">constraseña</label>
                                    <input class="form-control" type="password" name="contrasena" id="contrasena" maxlength="60" placeholder="Ingresa la contraseña">
                                </div>
                            </div>
                        
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="confirmar_contrasena">confirmar contraseña</label>
                                    <input class="form-control" type="password" name="confirmar_contrasena" id="confirmar_contrasena" maxlength="60" placeholder="Ingresa la contraseña">
                                </div>
                            </div>
                            <span id="check_password_match"></span>
                        </div>
                        <br>
                        
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="rol">Roll</label>
                                    <select class="form-control" name="rol" id="rol">
                                        <option value="3" selected disabled>Doctor/a</option>
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
                                            <option value="<?= $especialidad['id_especialidad'] ?>"><?= $especialidad['nombre_especialidad'] ?></option>
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
                        <button type="button" class="btn btn-secondary" title="Cerrar el modal" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary" id="agregar_usuario" title="Guardar cambios"><i class="fas fa-save"></i> Guardar</button>
                    </div>
                </form>






            </div>
        </div>
    </div>
</div>


<!-- Modal Actualizar Usuario-->

<!-- Modal -->
<div class="modal fade" id="modalActualizarUsuarios" tabindex="-1" aria-labelledby="modalActualizarUsuariosLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalActualizarUsuariosLabel">Modificar Usuarios</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" id="formActualizarUsuario">


                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input id="id_usuario_update" name="id_usuario_update" type="hidden" value="">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="cedula_update">Cedula</label>
                                <input class="form-control" type="text" id="cedula_update" name="cedula_update" placeholder="V/E">
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="nombre_update">Nombre</label>
                                <input class="form-control" type="text" id="nombre_update" name="nombre_update" onkeyup="mayus(this);" maxlength="40" placeholder="Ingresa el nombre">
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="apellido_update">Apellido</label>
                                <input class="form-control" type="apellido" id="apellido_update" name="apellido_update" onkeyup="mayus(this);" maxlength="40" placeholder="Ingresa la Apellido">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="correo_update">Correo</label>
                                <input class="form-control" type="email" id="correo_update" name="correo_update" onkeyup="mayus(this);" maxlength="60" placeholder="Ingresa la dirección">
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="contrasena_update">Contraseña</label>
                                <input class="form-control" type="password" id="contrasena_update" name="contrasena_update" maxlength="60" placeholder="Ingresa la contraseña">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="telefono_update">Confirmar contraseña</label>
                                <input class="form-control" type="password" id="confirmar_contrasena_update" name="confirmar_contrasena_update" maxlength="60" placeholder="Ingresa la contraseña">
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="usuario_update">Usuario</label>
                                <input class="form-control" type="text" id="usuario_update" name="usuario_update" maxlength="40" placeholder="Ingresa el nombre de usuario">
                            </div>
                        </div>


                        <div class="col-sm-4">

                            <div class="form-group">
                                <label for="rol_update">Rol</label>
                                <select class="form-control" name="rol_update" id="rol_update">
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
                                <select class="form-control" name="estatus_update" id="estatus_update">
                                    <option value="">Seleccione</option>
                                    <option value="1">Activo</option>
                                    <option value="2">Inactivo</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-4" id="cont_input_file" style="display: none;">
                            <div class="form-group">
                                <label for="Foto">Foto</label>
                                <input type="file" class=" form-control" name="archivo" id="subirfotoUpdate" accept="image/*">
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
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" title="Cerrar el modal" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary" id="modificar_usuario" title="Guardar cambios"><i class="fas fa-save"></i> Guardar</button>
            </div>
            </form>
        </div>
    </div>
</div>










<!-- Modal Visualizar Usuario-->

<div class="modal fade" id="modalVisualizarUsuario" tabindex="-1" aria-labelledby="modalVisualizarUsuarioLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalVisualizarUsuarioLabel">Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="list-group">
                    <div class="row">
                        <div class="col-sm-6">
                            <a title="Datos del visitante" href="#" class="list-group-item  list-group-item-action active">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 id="nombre_apellido" class="mb-1">Informacion del Usuario</h5>
                                    <small id="fecha_usuario"></small>
                                </div>
                                <p id="cedula_usuario" class="mb-1"></p>
                                <p id="nombre_usuario" class="mb-1"></p>
                                <p id="usuario_usuario" class="mb-1"></p>
                                <p id="apellido_usuario" class="mb-1"></p>
                                <p id="correo_usuario" class="mb-1"></p>

                                <br>
                                <p id="estatus_usuario" class="mb-1"></p>
                            </a>
                        </div>
                        <div class="col-sm-6">
                            <img title="Foto del usuario" style="width: 100%; height: 100%;" id="foto_usuario" src="" alt="">
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>