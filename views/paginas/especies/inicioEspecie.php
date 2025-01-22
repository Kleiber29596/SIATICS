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
    <h1>Especies</h1>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <p></p>
                    <!-- Button trigger modal  -->
                    <button title="Agregar Especies" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#modalAgregarEspecies">
                        <i class="fas fa-plus"></i>
                    </button>
                    <div class="table-responsive">
                        <!-- Table with stripped rows -->
                        <table class="table datatable" id="tablaEspecies">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Especies</th>
                                    <th>Fecha</th>
                                    <th>Estados</th>
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

<!-- Modal Agregar Especies-->
<div class="modal fade" id="modalAgregarEspecies" tabindex="-1" aria-labelledby="agregarEspeciesModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAgregarEspeciesLabel">Agregar la especie</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" id="formRegistrarEspecies">

                    <div class="row">

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="especie">Especies</label>
                                <input class="form-control" type="text" onkeyup="mayus(this);" id="especies"
                                    name="especies" placeholder="Ingresa la especies">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="estatus">Estatus</label>
                                <select class="form-control" name="estatus" id="estatus">
                                    <option value="">Seleccione</option>
                                    <option value="1">Activo</option>
                                    <option value="2">Inactivo</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" title="Cerrar el modal"
                            data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary" id="agregar_especies" title="Guardar cambios"><i
                                class="fas fa-save"></i> Guardar</button>
                    </div>
                </form>

            </div>

        </div>
    </div>
</div>








<!-- Modal Actualizar Especies-->
<div class="modal fade" id="modalActualizarEspecies" tabindex="-1" aria-labelledby="modalActualizarEspeciesLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalActualizarEspeciesLabel">Modificar Especies</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" id="formActualizarEspecies">

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input id="id_especies_update" type="hidden" value="">
                            </div>
                        </div>
                    </div>

                    <div class="row">


                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="especies_update">Nombre de la Especie</label>
                                <input class="form-control" type="text" onkeyup="mayus(this);" id="especies_update"
                                    placeholder="Ingresa el Especie">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="estatus_update">Estatus</label>
                                <select class="form-control" name="estatus" id="estatus_update">
                                    <option value="">Seleccione</option>
                                    <option value="1">Activo</option>
                                    <option value="2">Inactivo</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">

                        <button type="button" class="btn btn-secondary" title="Cerrar el modal"
                            data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary" id="modificar_especies" title="Guardar cambios"><i
                                class="fas fa-save"></i> Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Modal Visualizar Especies-->

<div class="modal fade" id="modalVisualizarEspecies" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="modalVisualizarEspeciesLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalVisualizarEspeciesLabel">Especies</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hove">
                        <tr>
                            <th>Especie</th>
                            <th>Fecha</th>
                            <th>Estatus</th>
                        </tr>
                        <tr>
                            <td id="especie_especies"></td>
                            <td id="fecha_especies"></td>
                            <td id="estatus_especies"></td>
                        </tr>
                    </table>
                </div>

            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>




<!-- Modal para agregar el historial médico ---->


<div class="modal fade" id="modalRegistrarHistorialMedico" tabindex="-1" aria-labelledby="historialMedicoModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalRegistrarHistorialMedicoLabel">Agregar Historial Médico</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" id="formHistorialMedico">

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="ID_persona">ID Persona</label>
                                <input class="form-control" type="number" id="ID_persona" name="ID_persona"
                                    placeholder="Ingresa el ID de la persona" required>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="tipo_sangre">Tipo de Sangre</label>
                                <input class="form-control" type="text" id="tipo_sangre" name="tipo_sangre"
                                    placeholder="Ingresa el tipo de sangre" required>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="enfermedad">Enfermedad</label>
                                <input class="form-control" type="text" id="enfermedad" name="enfermedad"
                                    placeholder="Ingresa enfermedades">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="fumador" name="fumador">
                                <label class="form-check-label" for="fumador">Fumador</label>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="alcohol" name="alcohol">
                                <label class="form-check-label" for="alcohol">Consumo de Alcohol</label>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="ac_fisica" name="ac_fisica">
                                <label class="form-check-label" for="ac_fisica">Actividad Física</label>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="medicado">Medicado</label>
                                <input class="form-control" type="text" id="medicado" name="medicado"
                                    placeholder="¿En tratamiento médico? (Sí/No)">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="ciru_hospi">Cirugías/Hospitalizaciones</label>
                                <input class="form-control" type="text" id="ciru_hospi" name="ciru_hospi"
                                    placeholder="Ingrese detalles de cirugías/hospitalizaciones">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="alergia">Alergia</label>
                                <input class="form-control" type="text" id="alergia" name="alergia"
                                    placeholder="Ingrese alergias">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="enfermedad_hered">Enfermedades Hereditarias</label>
                                <input class="form-control" type="text" id="enfermedad_hered" name="enfermedad_hered"
                                    placeholder="Ingrese enfermedades hereditarias">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="fecha_reg">Fecha de Registro</label>
                                <input class="form-control" type="date" id="fecha_reg" name="fecha_reg" required>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="fecha_modif">Fecha de Modificación</label>
                                <input class="form-control" type="date" id="fecha_modif" name="fecha_modif">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" title="Cerrar el modal"
                            data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary" id="guardar_historial_medico"
                            title="Guardar cambios"><i class="fas fa-save"></i> Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>