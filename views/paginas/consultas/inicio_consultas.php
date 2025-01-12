<?php
require_once 'controllers/MedicamentosController.php';
require_once 'controllers/ConsultasController.php';
require_once 'models/MotivosModel.php';
require_once 'controllers/EspecialidadController.php';
$objeto1 = new MedicamentosController();
$objeto2 = new ConsultasController();
$motivosModel = new MotivosModel();
$objeto3 = new EspecialidadController();
$motivos = $motivosModel->listarMotivos($id_especialidad);
$consultas_update = $objeto2->selectTipoConsulta();
$medicamentos = $objeto1->selectMedicamentos();
$medicamentos_update = $objeto1->selectMedicamentos();
$especialidades = $objeto3->selectEspecialidad();

$nombre = $_SESSION['nombre_user'];


if ($rol == 4 || $rol == 5 || $rol == 6 || $rol == 1) {
    echo "<h1>No tienes los permisos suficientes para ingresar en este modulo</h1>";
} else {
    ?>


<style>
.step-indicator {
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: relative;
}

.step-icon {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    background-color: #e9ecef;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    z-index: 1;
}

.step-icon.active {
    background-color: #007bff;
    color: white;
}

.step-line {
    position: absolute;
    top: 50%;
    left: 0;
    transform: translateY(-50%);
    height: 2px;
    width: 100%;
    background-color: #e9ecef;
}

.step-line-progress {
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    width: 0%;
    background-color: #007bff;
    transition: width 0.3s ease;
}
</style>

<div class="pagetitle">
    <h1>Consultas</h1>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <p></p>
                    <!-- Button trigger modal  -->
                    <button title="Agregar Consulta" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#modalAgregarConsulta">
                        <i class="fas fa-plus"></i>
                    </button>
                    <div class="table-responsive">
                        <!-- Table with stripped rows -->
                        <table class="table table-bordered" id="tbl_consultas" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Nombres/Apellidos</th>
                                    <th>Nº documento</th>
                                    <th>Motivo</th>
                                    <th>Modalidad</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                        </table>
                        <!-- End Table with stripped rows -->

                    </div>
                </div>
            </div>

        </div>
    </div>
</section>


<!-- Modal Agregar Consulta-->
<div class="modal fade" id="modalAgregarConsulta" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="modalAgregarConsultaLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAgregarConsultasLabel">Agregar Consulta <i
                        class="bi bi-clipboard-check"></i></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <br><br>
                <div class="step-indicator" aria-label="Indicador de pasos">
                    <div class="step-line">
                        <div class="step-line-progress" id="step-line-progress"></div>
                    </div>
                    <div class="step-icon active" id="step-icon-1" aria-label="Paso 1"><i style="font-size: 25px;"
                            class="bi bi-search"></i>
                    </div>
                    <div class="step-icon" id="step-icon-2" aria-label="Paso 2"><i style="font-size: 25px;"
                            class="fas fa-stethoscope"></i></div>
                    <div class="step-icon" id="step-icon-3" aria-label="Paso 3"><i style="font-size: 25px;"
                            class="fas fa-capsules"></i></div>
                </div>
                <div style="
                                width: 100%;
                                display: flex;
                                justify-content: space-between;
                                font-size: 20px;
                                font-weight: 600;
                            ">
                    <p>Datos del paciente</p>
                    <p>Datos de la consulta</p>
                    <p>Receta medica</p>
                </div>
                <form action="" id="formRegistrarConsultas" -->
                    <div id="registroForm">
                        <!-- Paso 1: Información Personal -->
                        <div class="step" id="step1">
                            <!-- Seccion datos del Paciente -->
                            <!-- <p>
                                <strong><span class="badge bg-secondary text-white">Datos del paciente</span></strong>
                            </p> -->

                            <div class="row">

                                <div class="col-sm-11" id="grupo_n_documento">
                                    <label class="formulario__label" for="n_documento">Número de documento</label>
                                    <div class="form-group">
                                        <input type="hidden" name="ID" id="ID">
                                        <input type="hidden" name="id_cita_agendada" id="id_cita_agendada">
                                        <input type="hidden" name="validar_fecha" id="validar_fecha">

                                        <input class="form-control formulario__validacion__input" type="text"
                                            id="n_documento_persona" name="n_documento_persona"
                                            placeholder="número de documento...">
                                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                                    </div>
                                    <p class="formulario__input-error">El numero de documento debe contener solo numeros
                                        y
                                        un
                                        mínimo de 7
                                        digitos y máximo 8.
                                    </p>
                                </div>
                                <div class="col-sm-1"
                                    style="display: flex; justify-content: flex-start; align-items: flex-end;">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-primary" id="consultar_persona_c"
                                            title="Buscar persona"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4" id="contenedor_datos_persona" style="display: none;">
                                <div class="col-md-12">
                                    <strong>Datos del paciente</strong>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover table-secondary">
                                            <thead>
                                                <tr>
                                                    <th>N° documento</th>
                                                    <th>Nombres</th>
                                                    <th>Edad</th>
                                                    <th>Sexo</th>
                                                    <th>Teléfono</th>
                                                    <th>Dirección</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td id="n_documento"></td>
                                                    <td id="nombres_apellidos_persona"></td>
                                                    <td id="edad"></td>
                                                    <td id="sexo_persona"></td>
                                                    <td id="tlf_persona"></td>
                                                    <td id="direccion_persona"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-12" style="display:none;" id="contenedor_cita">
                                    <h6>
                                        <span class="badge bg-success"> ¡Tiene una cita programada! <i
                                                class="bi bi-calendar"></i></span>
                                    </h6>
                                    <br>
                                    <strong>Datos de la cita</strong>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover table-secondary">
                                            <thead>
                                                <tr>
                                                    <th>Especialidad</th>
                                                    <th>Especialista</th>
                                                    <th>Observación</th>
                                                    <th>Fecha</th>
                                                    <th>Estado</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td id="especialidad_cita"></td>
                                                    <td id="especialista_cita"></td>
                                                    <td id="observacion_cita"></td>
                                                    <td id="fecha_cita"></td>
                                                    <td id="estatus_cita"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Paso 2: Seccion para llenar los datos del historial médico -->
                        <div class="step" id="step2" style="display: none;">
                            <!-- <p>
                                <strong><span class="badge bg-secondary text-white">Datos de la consulta
                                        médica</span></strong>
                            </p> -->

                            <div class="row">

                                <input class="form-control" type="hidden" id="id_especialidad_consulta"
                                    value="<?php echo $_SESSION['id_especialidad']; ?>">
                                <input class="form-control" type="hidden" id="id_especialista_consulta"
                                    value="<?php echo $_SESSION['id_doctor']; ?>">
                                <?php ?>

                                <!-- Campo para el peso del paciente -->
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="peso">Peso (kg)</label>
                                        <input class="form-control" type="number" id="peso" name="peso" min="1"
                                            placeholder="Ingrese el peso">
                                    </div>
                                </div>

                                <!-- Campo para la altura del paciente -->
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="altura">Altura (cm)</label>
                                        <input class="form-control" type="number" id="altura" name="altura" min="1"
                                            placeholder="Ingrese la altura">
                                    </div>
                                </div>

                                <!-- Campo para la presión arterial del paciente -->
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="presion_arterial">Presión arterial</label>
                                        <input class="form-control" type="text" id="presion_arterial"
                                            name="presion_arterial"
                                            placeholder="Ingrese la presión arterial (ej: 120/80)">
                                    </div>
                                </div>
                            </div>

                            <div class="row">

                                <!-- Campo para el tipo de consulta -->
                                <div class="mt-3 col-sm-6">
                                    <div class="form-group">
                                        <label for="tipo_consulta">Motivo</label>
                                        <select class="select2-selection--single" name="tipo_consulta"
                                            id="tipo_consulta" style="width:100%">
                                            <option value="">Seleccione</option>
                                            <?php foreach ($motivos as $motivo) { ?>
                                            <option value="<?= $motivo['id_tipo_consulta'] ?>">
                                                <?= $motivo['motivo'] ?>
                                            </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- Campo para el diagnóstico -->
                                <div class="mt-3 col-sm-6">
                                    <div class="form-group">
                                        <label for="diagnostico">Diagnóstico</label>
                                        <textarea class="form-control" id="diagnostico" name="diagnostico" rows="3"
                                            placeholder="Ingrese el diagnóstico"></textarea>
                                    </div>
                                </div>


                            </div>



                        </div>

                        <!-- Paso 3: Preferencias -->
                        <div class="step" id="step3" style="display: none;">
                            <!-- Seccion para seleccionar especies -->
                            <!-- <p>
                                <strong><span class="badge bg-secondary text-white">Receta médica</span></strong>
                            </p> -->

                            <div class="container mt-5">

                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="medicamento">Medicamento</label>
                                            <select class="select2-selection--single" name="medicamento"
                                                id="medicamento" style="width:100%">
                                                <option value="">Seleccione</option>
                                                <?php foreach ($medicamentos as $medicamento) { ?>
                                                <option value="<?= $medicamento['id_presentacion_medicamento'] ?>">
                                                    <?= $medicamento['nombre_medicamento'] . '-' . $medicamento['presentacion'] ?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                            <small id="estadoHelp" class="form-text text-muted">Selecciona el
                                                medicamento</small>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="dosis">Dosis</label>
                                            <input type="number" class="form-control" id="dosis" name="dosis"
                                                placeholder="Ingrese la dosis" min="1">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="dosis">Unidad de medida</label>
                                            <select class="form-control" name="medicamento" id="unidad_medida">
                                                <option value="">Seleccione</option>

                                                <option value="pastilla">Pastilla</option>
                                                <option value="ml">Mililitro (ml)</option>
                                                <option value="mg">Miligramo (mg)</option>
                                                <option value="gotas">Gotas</option>
                                                <option value="cucharada">Cucharada</option>
                                                <option value="ampolla">Ampolla</option>

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-sm-4">
                                        <label for="frecuencia">Frecuencia</label>
                                        <div class="form-group input-horas">
                                            <input type="number" id="frecuencia" class="form-control" name="frecuencia"
                                                min="1" step="1" placeholder="ingrese la frecuecia">
                                            <span>horas</span>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <label for="duracion">Duración</label>
                                        <div class="form-group input-duracion">
                                            <input type="number" id="cantidad_duracion" class="form-control"
                                                name="cantidad_duracion" min="1" step="1"
                                                placeholder="ingrese la duración">
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <label for="duracion"></label>
                                        <div class="form-group input-duracion">
                                            <select name="intervalo" id="intervalo" class="form-control"
                                                style="width: 100%; display: inline-block; margin-left: 10px;">
                                                <option value="días">Días</option>
                                                <option value="semanas">Semanas</option>
                                                <option value="meses">Meses</option>
                                            </select>

                                        </div>
                                    </div>

                                    <div class="col-sm-1"
                                        style="display: flex; justify-content: flex-start;align-items: flex-end;">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-primary btn-circle"
                                                id="agregar_medicamento_recipe" title="Agregar medicamento"><i
                                                    class="fas fa-plus"></i></button>
                                        </div>
                                    </div>

                                </div>
                                <br>
                                <div class="row" id="contenedor_datos_medicamentos" style="display: none;">
                                    <div class="col-sm-12 table-responsive" id="">
                                        <table
                                            class="table table-bordered table-secondary table-striped table-hover tbl_medicamentos"
                                            id="multiples_medicamentos">
                                            <tr>
                                                <th>Medicamento</th>
                                                <th>Presentación</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </table>
                                    </div>
                                </div><br>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="instrucciones">Instrucciones adicionales</label>
                                            <textarea class="form-control" id="instrucciones" name="instrucciones"
                                                rows="3" placeholder="Instrucciones..."></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>


                        <div class="mt-3">
                            <button type="button" class="btn btn-secondary" id="prevBtn"
                                style="display: none;">Anterior</button>
                            <button type="button" class="btn btn-primary" id="nextBtn">Siguiente</button>
                            <button type="button" class="btn btn-success" id="submitBtn" style="display: none;">
                                <span class="loader d-none"></span>
                                <span class="button-text" id="agregar_consulta">Enviar Datos</span>
                            </button>
                        </div>
                    </div>

                </form>


            </div>
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="prevBtn" style="display: none;"
                    onclick="nextPrev(-1)">Anterior</button>
                <button type="button" class="btn btn-primary" id="nextBtn" onclick="nextPrev(1)">Siguiente</button>
                <button type="button" class="btn btn-secondary" title="Cerrar el modal"
                    data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="agregar_consulta" title="Guardar consulta"
                    style="display: none;"><i class="fas fa-save"></i> Guardar</button>
            </div> -->
        </div>
    </div>
</div>

<!-- Modal Acutaliza Consultas-->

<div class="modal fade" id="modalActualizarConsultas" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="modalActualizarConsultasLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalActualizarConsultasLabel">Modificar consulta <i
                        class="bi bi-pencil"></i>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="nombres_apellidos">Paciente</label>
                                <input class="form-control" type="text" name="nombres_persona" id="nombres_persona"
                                    disabled>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="hidden" name="consulta_update" id="id_consulta_update">
                                <label for="rango_edad">Tipo de consulta</label>
                                <select class="select2-selection--single" name="tipo_consulta" id="update_tipo_consulta"
                                    style="width:100%">
                                    <option value="">Seleccione</option>
                                    <?php foreach ($consultas_update as $consulta_update) { ?>
                                    <option value="<?= $consulta_update['id_tipo_consulta'] ?>">
                                        <?= $consulta_update['motivo'] ?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <!-- Campo oculto para la edad -->
                        <div class="form-group">
                            <input class="form-control" type="hidden" id="edad" placeholder="Edad">
                        </div>

                        <!-- Campo para el peso del paciente -->
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="peso">Peso (kg)</label>
                                <input class="form-control" type="number" id="update_peso" name="peso"
                                    placeholder="Ingrese el peso">
                            </div>
                        </div>

                        <!-- Campo para la altura del paciente -->
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="altura">Altura (cm)</label>
                                <input class="form-control" type="float" id="update_altura" name="altura "
                                    placeholder="Ingrese la altura">
                            </div>
                        </div>

                        <!-- Campo para la presión arterial del paciente -->
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="presion_arterial">Presión Arterial</label>
                                <input class="form-control" type="text" id="update_presion_arterial"
                                    name="presion_arterial" placeholder="Ingrese la presión arterial (ej: 120/80)">
                            </div>
                        </div>

                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="instrucciones">Diagnóstico</label>
                                <textarea class="form-control" id="update_diagnostico" name="diagnostico" rows="3"
                                    placeholder="Ingrese el diagnóstico"></textarea>
                            </div>

                        </div>
                    </div>
                </form>
                <br>
                <p>Medicamentos recetados</p>


                <div id="contenedor-actualizar-receta" style="display:none;">
                    <form id="form_update_receta">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="medicamento">Medicamento</label>
                                    <input type="hidden" id="receta-medica">
                                    <select class="select2-selection--single" name="medicamento" id="medicamento_update"
                                        style="width:100%">
                                        <option value="">Seleccione</option>
                                        <?php foreach ($medicamentos_update as $medicamento_update) { ?>
                                        <option value="<?= $medicamento_update['id_presentacion_medicamento'] ?>">
                                            <?= $medicamento_update['nombre_medicamento'] . '-' . $medicamento_update['presentacion'] ?>
                                        </option>
                                        <?php } ?>
                                    </select>

                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="dosis">Dosis</label>
                                    <input type="number" class="form-control" id="dosis_update" name="dosis"
                                        placeholder="Ingrese la dosis">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="dosis">Unidad de medida</label>
                                    <select class="form-control" name="medicamento" id="unidad_medida_update">
                                        <option value="">Seleccione</option>
                                        <option value="pastilla">Pastilla</option>
                                        <option value="ml">Mililitro (ml)</option>
                                        <option value="mg">Miligramo (mg)</option>
                                        <option value="gotas">Gotas</option>
                                        <option value="cucharada">Cucharada</option>
                                        <option value="ampolla">Ampolla</option>

                                    </select>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">

                            <div class="col-sm-3">
                                <label for="frecuencia">Frecuencia</label>
                                <div class="form-group input-horas">
                                    <input type="number" id="frecuencia_update" class="form-control" name="frecuencia"
                                        min="1" step="1" placeholder="ingrese la frecuecia">
                                    <span>horas</span>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <label for="duracion">Duración</label>
                                <div class="form-group input-duracion">
                                    <input type="number" id="cantidad_update" class="form-control"
                                        name="cantidad_duracion" min="1" step="1" placeholder="ingrese la duración">
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <label for="duracion"></label>
                                <div class="form-group input-duracion">
                                    <select name="intervalo" id="intervalo_update" class="form-control"
                                        style="width: 100%; display: inline-block; margin-left: 10px;">
                                        <option value="">Seleccione</option>
                                        <option value="días">Días</option>
                                        <option value="semanas">Semanas</option>
                                        <option value="meses">Meses</option>
                                    </select>

                                </div>
                            </div>
                            <div class="col-sm-3" style="display: flex; align-items:center;">
                                <div class="form-group">
                                    <button type="button" class="btn btn-danger btn-circle"
                                        style="display: flex; margin-top:25px;" id="cancelar_receta_update"
                                        onclick="cancelarRecetaUpdate()" title="Cancelar"><i
                                            class="fas fa-ban"></i></button>
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-success btn-circle "
                                        style="display: flex; margin-top:25px; margin-left:10px;" id="modificar_receta"
                                        onclick="modificarReceta()" title="Modificar"><i
                                            class="fas fa-edit"></i></button>
                                </div>
                            </div>

                    </form>
                </div>
            </div>


            <br>
            <div class="container" id="contenedor_observacion_suspension" style="display: none;">
                <div class="row" style="display: flex; align-items: flex-end;">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="observacion_suspension">Observación de la suspensión</label>
                            <input class="form-control" type="text" id="observacion_suspension" placeholder="Ingrese la observación de la suspensión">
                            <input type="hidden" id="id_receta_suspension" value="">
                        </div>
                    </div>
                    <div class="col-sm-1">
                        <button class="btn btn-success" onclick="suspenderTratamiento()">Aceptar</button>
                    </div>
                    <div class="col-sm-1">
                        <button class="btn btn-danger" onclick="desactivarSuspension()">Cancelar</button>
                    </div>
                </div>
            </div>
            <div class="row" id="contenedor_datos_medicamentos_update" style="display: none;">
                <div class="col-sm-12 table-responsive">

                    <table class="table table-bordered table-secondary table-striped table-hover tbl_medicamentos"
                        id="multiples_medicamentos_update">

                    </table>

                </div>
            </div>


        </div>
        <div class="modal-footer">

            <button type="button" class="btn btn-secondary" title="Cerrar el modal"
                data-bs-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary" id="modificar_consulta" title="Guardar cambios"><i
                    class="fas fa-save"></i> Guardar</button>
        </div>
    </div>


</div>
</div>

</form>
</div>
<div class="modal-footer">
</div>
</div>
</div>
</div>




<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('registroForm');
    const steps = document.querySelectorAll('.step');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const submitBtn = document.getElementById('submitBtn');
    const stepIcons = document.querySelectorAll('.step-icon');
    const stepLineProgress = document.getElementById('step-line-progress');
    let currentStep = 0;

    function showStep(stepIndex) {
        steps.forEach((step, index) => {
            step.style.display = index === stepIndex ? 'block' : 'none';
        });

        stepIcons.forEach((icon, index) => {
            if (index <= stepIndex) {
                icon.classList.add('active');
                icon.setAttribute('aria-current', index === stepIndex ? 'step' : 'false');
            } else {
                icon.classList.remove('active');
                icon.removeAttribute('aria-current');
            }
        });

        // Actualizar la línea de progreso
        const progressPercentage = (stepIndex / (steps.length - 1)) * 100;
        stepLineProgress.style.width = `${progressPercentage}%`;

        prevBtn.style.display = stepIndex > 0 ? 'inline-block' : 'none';
        nextBtn.style.display = stepIndex < steps.length - 1 ? 'inline-block' : 'none';
        submitBtn.style.display = stepIndex === steps.length - 1 ? 'inline-block' : 'none';
    }

    function validateStep(stepIndex) {
        const inputs = steps[stepIndex].querySelectorAll('input, select');
        let isValid = true;

        inputs.forEach(input => {
            if (input.hasAttribute('required') && !input.value) {
                isValid = false;
                input.classList.add('is-invalid');
            } else {
                input.classList.remove('is-invalid');
            }
        });

        return isValid;
    }



    nextBtn.addEventListener('click', function() {

        const validar = validarFechaAtencion();
        console.log(validar);
        if (validar) {
            if (validateStep(currentStep)) {
                currentStep++;
                showStep(currentStep);
            }
        } 

    });


    prevBtn.addEventListener('click', function() {
        currentStep--;
        showStep(currentStep);
    });

    // form.addEventListener('submit', function(e) {
    //     e.preventDefault();
    //     if (validateStep(currentStep)) {
    //         // Aquí puedes enviar los datos del formulario
    //         alert('Formulario enviado con éxito!');
    //         // Reiniciar el formulario
    //         form.reset();
    //         currentStep = 0;
    //         showStep(currentStep);
    //     }
    // });

    showStep(currentStep);


    function validarFechaAtencion() {


        const fechaCita = document.getElementById('validar_fecha').value;

        if (fechaCita != '') {
            console.log(fechaCita);
            // Convertir fecha de cita y fecha actual a objetos Date
            const fechaCitaObj = new Date(`${fechaCita}T00:00:00`);
            console.log(fechaCitaObj);
            const fechaHoy = new Date();
            fechaHoy.setHours(0, 0, 0, 0);
          
            // Comparar las fechas
            if (fechaCitaObj.getTime() === fechaHoy.getTime()) {

                // document.getElementById('nextBtn').disabled = false;
                return true;

            } else {
                // Si no coinciden, mostrar alerta y deshabilitar "Siguiente"
                Swal.fire({
                    icon: 'error',
                    title: 'No se puede atender la cita',
                    text: 'Debe esperar a la fecha programada para atender la cita.',
                });
                // document.getElementById('nextBtn').disabled = true;
                return false;
            }

        } else {
            return true

        }


    }


});
</script>

<?php
}

?>