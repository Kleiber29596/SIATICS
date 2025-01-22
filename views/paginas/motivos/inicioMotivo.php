<?php
require_once 'controllers/EspecialidadController.php';

$objeto  = new EspecialidadController();
$especialidades = $objeto->selectEspecialidad();
$update_especialidades = $objeto->selectEspecialidad();

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

<div class="pagetitle">
    <h1>Motivos</h1>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <p></p>
                    <!-- Button trigger modal  -->
                    <button title="Agregar Motivo" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#modalAgregarMotivo">
                        <i class="fas fa-plus"></i>
                    </button>
                    <div class="table-responsive">
                        <!-- Table with stripped rows -->
                        <table class="table datatable" id="tbl_motivos">
                            <thead>
                                <tr>
                                    <th>Motivo</th>
                                    <th>Especialidad</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>


<!-- /.container-fluid -->

<!-- Modal Agregar Motivo -->
<div class="modal fade" id="modalAgregarMotivo" tabindex="-1" aria-labelledby="agregarMotivoModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAgregarMotivosLabel">Agregar motivo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" id="formRegistrarMotivo">

                    <div class="row">

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="especie">Motivo</label>
                                <input class="form-control" type="text" onkeyup="mayus(this);" id="motivo"
                                    name="especies" placeholder="Ingrese el motivo">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="formulario__label" for="especialidad">Especialidad</label>
                                <select class="select2-selection--single" name="especialidad" id="especialidad_motivo"
                                    style="width:100%" required>
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
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" title="Cerrar el modal"
                            data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" id="agregar_motivo" title="Guardar cambios"><i
                                class="fas fa-save"></i> Guardar</button>
                    </div>
                </form>

            </div>

        </div>
    </div>
</div>








<!-- Modal Actualizar Motivo -->
<div class="modal fade" id="modalActualizarMotivos" tabindex="-1" aria-labelledby="modalActualizarMotivosLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalActualizarMotivosLabel">Modificar Motivo <i class="fas fa-edit"></i>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" id="formActualizarMotivos">

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input id="id_motivo" type="hidden" value="">
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="update_motivo">Nombre del motivo</label>
                                <input class="form-control" type="text" onkeyup="mayus(this);" id="update_motivo"
                                    placeholder="Ingresa el motivo">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="formulario__label" for="update_especialidad">Especialidad</label>
                                <select class="select2-selection--single" name="update_especialidad_motivo"
                                    id="update_especialidad_motivo" style="width:100%" required>
                                    <option value="" disabled selected>Seleccione</option>
                                    <?php
                                            foreach ($update_especialidades  as  $e) {
                                            ?>
                                    <option value="<?= $e['id_especialidad'] ?>">
                                        <?= $e['nombre_especialidad'] ?></option>
                                    <?php
                                            }
                                            ?>
                                </select>
                            </div>

                        </div>

                    </div>
                    <div class="modal-footer">

                        <button type="button" class="btn btn-secondary" title="Cerrar el modal"
                            data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" id="modificar_motivo" title="Guardar cambios"><i
                                class="fas fa-save"></i> Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Modal Visualizar Motivo-->

<div class="modal fade" id="modalVisualizarMotivo" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="modalVisualizarMotivoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lx">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalVisualizarMotivoLabel">Ver Motivo  <i class="bi bi-eye-fill"></i></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card text-white bg-primary mb-3" style="max-width: 100%;">
                    <div class="card-body">
                        <br>
                        <p class="card-text" id="nombre_motivo"></p>
                        <p class="card-text" id="ver_especialidad_motivo"></p>
                    </div>
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