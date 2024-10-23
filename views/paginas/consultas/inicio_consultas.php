<?php 
    require_once 'controllers/MedicamentosController.php';
    require_once 'controllers/ConsultasController.php';
    require_once 'controllers/EspecialidadController.php';
    $objeto1               = new MedicamentosController();
    $objeto2               = new ConsultasController();
    $objeto3               = new EspecialidadController();
    $consultas             = $objeto2->selectTipoConsulta();
    $consultas_update      = $objeto2->selectTipoConsulta();
    $medicamentos          = $objeto1->selectMedicamentos();
    $medicamentos_update   = $objeto1->selectMedicamentos();
    $especialidades = $objeto3->selectEspecialidad(); 
    
?>
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
                <h5 class="modal-title" id="modalAgregarConsultasLabel">Agregar Consultas <i
                        class="fas fa-clipboard-check"></i></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="formRegistrarConsultas">
                    <!-- Step 1 -->
                    <div class="step" id="step-1">
                        <div class="row">
                            <!--Comieza aqui campo tipo consulta-->
                            <div class="col-sm-3">
                                <label class="formulario__label">Tipo cosulta</label>
                                <select class="form-control" required>
                                    <option disabled selected>Elija una opción</option>
                                    <option>cita</option>
                                    <option>Cosulta general</option>
                                </select>
                            </div>
                            <!--finaliza aqui-->
                            <div class="col-sm-8" id="grupo_n_documento">
                                <label class="formulario__label" for="n_documento">Número de documento</label>
                                <div class="form-group">
                                    <input type="hidden" name="ID" id="ID">
                                    <input class="form-control formulario__validacion__input" type="text"
                                        id="n_documento_persona" name="n_documento_persona"
                                        placeholder="numero de documento...">
                                    <i class="formulario__validacion-estado fas fa-times-circle"></i>
                                </div>
                                <p class="formulario__input-error">El numero de documento debe contener solo numeros y
                                    un
                                    mínimo de 7
                                    digitos y máximo 8.
                                </p>
                            </div>
                            <div class="col-sm-1"
                                style="display: flex; justify-content: flex-start; align-items: flex-end;">
                                <div class="form-group">
                                    <button type="button" class="btn btn-primary" id="consultar_persona"
                                        title="Buscar persona" disabled><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="contenedor_datos_persona" style="display: none;">
                            <div class="col-sm-12">
                                <p>Datos del paciente</p>
                                <div class="table-responsive tbl_personas">
                                    <table class="table table-bordered table-secondary table-striped table-hover">
                                        <tr>
                                            <th>Nº documento</th>
                                            <th>Nombres</th>
                                            <th>Edad</th>
                                            <th>Sexo</th>
                                            <th>Teléfono</th>
                                            <th>Dirección</th>
                                        </tr>
                                        <tr>
                                            <td id="n_documento"></td>
                                            <td id="nombres_apellidos_persona"></td>
                                            <td id="edad"></td>
                                            <td id="sexo_persona"></td>
                                            <td id="tlf_persona"></td>
                                            <td id="direccion_persona"></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>


                    </div>

                    <!-- Step 2 -->
                    <div class="step" id="step-2" style="display: none;">
                        <div class="row">
                            <!-- Campo oculto para la edad -->
                            <div class="form-group">
                                <input class="form-control" type="hidden" id="edad" placeholder="Edad">
                            </div>


                            <!-- Campo para el tipo de especialidad -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="especialidad">Especialidad</label>
                                    <select class="select2-selection--single" name="especialidad"
                                        id="especialidad_consulta" style="width:100%">
                                        <option value="">Seleccione</option>
                                        <?php foreach ($especialidades as $especialidad) { ?>
                                        <option value="<?= $especialidad['id_especialidad'] ?>">
                                            <?= $especialidad['nombre_especialidad'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>


                            <!-- Campo para el tipo de consulta -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="tipo_consulta">Motivo</label>
                                    <select class="select2-selection--single" name="tipo_consulta" id="tipo_consulta"
                                        style="width:100%">
                                        <option value="">Seleccione</option>
                                        <?php foreach ($consultas as $consulta) { ?>
                                        <option value="<?= $consulta['id_tipo_consulta'] ?>">
                                            <?= $consulta['motivo'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

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
                                        name="presion_arterial" placeholder="Ingrese la presión arterial (ej: 120/80)">
                                </div>
                            </div>


                            <!-- Campo para el diagnóstico -->
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="diagnostico">Diagnóstico</label>
                                    <textarea class="form-control" id="diagnostico" name="diagnostico" rows="3"
                                        placeholder="Ingrese el diagnóstico"></textarea>
                                </div>
                            </div>


                        </div>

                    </div>

                    <!-- Step 3 -->
                    <div class="step" id="step-3" style="display: none;">
                        <p>Recipe Médico</p>

                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="medicamento">Medicamento</label>
                                    <select class="select2-selection--single" name="medicamento" id="medicamento"
                                        style="width:100%">
                                        <option value="">Seleccione</option>
                                        <?php foreach ($medicamentos as $medicamento) { ?>
                                        <option value="<?= $medicamento['id_presentacion_medicamento'] ?>">
                                            <?= $medicamento['nombre_medicamento'].'-'.$medicamento['presentacion'] ?>
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
                                    <input type="number" id="frecuencia" class="form-control" name="frecuencia" min="1"
                                        step="1" placeholder="ingrese la frecuecia">
                                    <span>horas</span>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <label for="duracion">Duración</label>
                                <div class="form-group input-duracion">
                                    <input type="number" id="cantidad_duracion" class="form-control"
                                        name="cantidad_duracion" min="1" step="1" placeholder="ingrese la duración">
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
                                    <textarea class="form-control" id="instrucciones" name="instrucciones" rows="3"
                                        placeholder="Instrucciones..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="prevBtn" style="display: none;"
                    onclick="nextPrev(-1)">Anterior</button>
                <button type="button" class="btn btn-primary" id="nextBtn" onclick="nextPrev(1)">Siguiente</button>
                <button type="button" class="btn btn-secondary" title="Cerrar el modal"
                    data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="agregar_consulta" title="Guardar consulta"
                    style="display: none;"><i class="fas fa-save"></i> Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Acutaliza Consultas-->

<div class="modal fade" id="modalActualizarConsultas" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="modalActualizarConsultasLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalActualizarConsultasLabel">Consulta</h5>
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
                                        <?= $consulta_update['motivo'] ?></option>
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
                                            <?= $medicamento_update['nombre_medicamento'].'-'.$medicamento_update['presentacion'] ?>
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
var currentStep = 1;
showStep(currentStep);

function showStep(step) {
    var steps = document.getElementsByClassName("step");
    for (var i = 0; i < steps.length; i++) {
        steps[i].style.display = "none";
    }
    steps[step - 1].style.display = "block";

    document.getElementById("prevBtn").style.display = step === 1 ? "none" : "inline";
    document.getElementById("nextBtn").style.display = step === steps.length ? "none" : "inline";
    document.getElementById("agregar_consulta").style.display = step === steps.length ? "inline" : "none";
}

function nextPrev(n) {
    var steps = document.getElementsByClassName("step");

    // Eliminamos la validación completamente
    steps[currentStep - 1].style.display = "none";
    currentStep += n;

    if (currentStep > steps.length) {
        document.getElementById("formRegistrarConsultas").submit();
        return false;
    }

    showStep(currentStep);
}
</script>