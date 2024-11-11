<?php
if ($rol == 3) {
    echo "<h1>No tienes los permisos suficientes para ingresar en este modulo</h1>";
} else {
?>
<div class="pagetitle">
    <h1>Especialidades <i class="fas fa-stethoscope"></i></h1>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="especialidades-tab" data-bs-toggle="tab"
                                data-bs-target="#especialidades" type="button" role="tab" aria-controls="especialidades"
                                aria-selected="true">Especialidades</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="otras-tab" data-bs-toggle="tab" data-bs-target="#otras" type="button" role="tab" aria-controls="otras" aria-selected="false">Otras</button>
                        </li>
                    </ul>

                    <div class="tab-content" id="myTabContent">
                        <!-- Contenido de la pestaña "Especialidades" -->
                        <div class="tab-pane fade show active" id="especialidades" role="tabpanel"
                            aria-labelledby="especialidades-tab">
                            <p></p>
                            <button title="Agregar Especialidad" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#modalAgregarEspecialidad">
                                <i class="fas fa-plus"></i>
                            </button>
                            <div class="table-responsive">
                                <table class="table datatable" id="tbl_especialidad">
                                    <thead>
                                        <tr>
                                            <th>Especialidad</th>
                                            <th>Modalidad</th>
                                            <th>Tiempo maximo por cita</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Aquí se cargarán las filas de especialidades -->
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Contenido de la pestaña "Otras" -->
                        <div class="tab-pane fade" id="otras" role="tabpanel" aria-labelledby="otras-tab">
                            <!-- Contenido para otras categorías -->
                            <p>Aquí puedes añadir contenido relacionado a otras categorías.</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<?php
}
?>

<!-- Modal para Agregar Especialidad -->
<div class="modal fade" id="modalAgregarEspecialidad" tabindex="-1" aria-labelledby="agregarEspecialidad"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAgregarEspecialidadLabel">Agregar especialidad <i
                        class="fas fa-stethoscope"></i></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" id="formRegistrarEspecialidad">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="especialidad">Especialidad</label>
                                <input class="form-control" type="text" onkeyup="mayus(this);" id="especialidad"
                                    name="especialidad" placeholder="Ingresa la especialidad" required>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="modalidad">Modalidad</label>
                                <select class="form-control" name="modalidad" id="modalidad" style="width:100%">
                                    <option value="Sin cita" selected>Sin cita</option>
                                    <option value="Por cita">Por cita</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group" id="divTM" style="display: none;">
                                <label for="TM_cita">Tiempo maximo por cita</label>
                                <select class="form-control" name="TM_cita" id="TM_cita" style="width:100%">
                                    <option value="N/A" selected disabled>N/A</option>
                                    <option value="10 Min">10 Min</option>
                                    <option value="20 Min">20 Min</option>
                                    <option value="30 Min">30 Min</option>
                                    <option value="40 Min">40 Min</option>
                                    <option value="50 Min">50 Min</option>
                                    <option value="60 Min">60 Min</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" title="Cerrar el modal"
                            data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" id="agregar_especialidad"
                            title="Guardar cambios"><i class="fas fa-save"></i> Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>