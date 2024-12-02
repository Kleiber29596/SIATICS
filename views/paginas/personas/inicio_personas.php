<?php 
require_once 'controllers/PersonasController.php';
$objeto  = new PersonasController();
$estados = $objeto->selectEstado();
$update_estados = $objeto->selectEstado();
$update_municipios = $objeto->selectMunicipio();
$update_parroquias = $objeto->selectParroquia();
?>

<style>
.error {
    border: 2px solid red;
    /* Resaltar con borde rojo */
}
</style>

<div class="pagetitle">
    <h1>Personas <i class="fas fa-user"></i></h1>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <p></p>
                    <!-- Button trigger modal  -->
                    <button title="Agregar Persona" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#modalAgregarPersona">
                        <i class="fas fa-plus"></i>
                    </button>
                    <div class="table-responsive">
                        <!-- Table with stripped rows -->
                        <table class="table table-bordered" id="tbl_personas" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Nº documento</th>
                                    <th>Nombres/Apellidos</th>
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



<!-- Modal Agregar Persona-->
<div class="modal fade" id="modalAgregarPersona" tabindex="-1" aria-labelledby="modalAgregarPersonaLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAgregarPersona"> Agregar Personas <i class="fas fa-user"></i> </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form action="" id="formRegistrarPersona">
                    <div class="step" id="step-1">
                        <!----------------- Grupo Nombres ----------------------->
                        <div class="row">
                            <h5>Datos personales</h5>
                            <div class="col-sm-3" id="grupo_primer_nombre">
                                <label class="formulario__label" for="nombres">Primer nombre</label>
                                <div class="form-group">
                                    <input class="form-control formulario__validacion__input"
                                        type="text" id="primer_nombre" name="primer_nombre" placeholder="Primer nombre"
                                        required>
                                    <i class="formulario__validacion-estado fas fa-times-circle"></i>
                                </div>
                                <p class="formulario__input-error">El nombre debe contener Letras, numeros, guion y
                                    guion_bajo</p>
                            </div>

                            <div class="col-sm-3" id="grupo_segundo_nombre">
                                <label class="formulario__label" for="segundo_nombre">Segundo nombre</label>
                                <div class="form-group">
                                    <input class="form-control formulario__validacion__input" type="text"
                                        id="segundo_nombre" name="segundo_nombre" placeholder="Segundo nombre">
                                    <i class="formulario__validacion-estado fas fa-times-circle"></i>
                                </div>
                                <p class="formulario__input-error">El nombre debe contener Letras, numeros, guion y
                                    guion_bajo</p>
                            </div>


                            <!----------------- Grupo Apellidos ----------------------->
                            <div class="col-sm-3" id="grupo_primer_apellido">
                                <label class="formulario__label" for="primer_apellido">Primer apellido</label>
                                <div class="form-group ">
                                    <input class="form-control formulario__validacion__input" type="text"
                                        id="primer_apellido" name="primer_apellido" placeholder="Primer apellido"
                                        required>
                                    <i class="formulario__validacion-estado fas fa-times-circle"></i>
                                </div>
                                <p class="formulario__input-error">El apellido debe contener Letras y espacios, pueden
                                    llevar acentos.</p>
                            </div>

                            <div class="col-sm-3" id="grupo_segundo_apellido">
                                <label class="formulario__label" for="grupo_primer_apellido">Segundo apellido</label>
                                <div class="form-group ">
                                    <input class="form-control formulario__validacion__input" type="text"
                                        id="segundo_apellido" name="segundo_apellido" placeholder="Segundo apellido">
                                    <i class="formulario__validacion-estado fas fa-times-circle"></i>
                                </div>
                                <p class="formulario__input-error">El apellido debe contener Letras y espacios, pueden
                                    llevar acentos.</p>
                            </div>

                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-2">
                                <div class="form-group" id="grupo_sexo">
                                    <label class="formulario__label" for="sexo">Sexo</label>
                                    <br>
                                    Masculino <input class="formulario__validacion__input" type="radio" name="sexo"
                                        id="sexo" value="Masculino" selected>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group" id="grupo_sexo">
                                    <label class="formulario__label" for="sexo"></label>
                                    <br>
                                    Femenino <input class="formulario__validacion__input" type="radio" name="sexo"
                                        id="sexo" value="Femenino">
                                </div>
                            </div>
                            <div class="col-sm-4" id="grupo_fecha_nac">
                                <div class="form-group">
                                    <label class="formulario__label" for="fecha_nac">Fecha de nacimiento</label>
                                    <input type="date" class="form-control formulario__validacion__input" id="fecha_nac"
                                        name="fecha_nac" required>
                                    <i class="formulario__validacion-estado fas fa-times-circle"></i>
                                </div>
                                <p class="formulario__input-error">La fecha de nacimiento no puede ser una fecha futura.
                                </p>
                            </div>

                            <div class="col-sm-4" id="grupo_telefono">
                                <label class="formulario__label" for="telefono">Telefono</label>
                                <div class="form-group">
                                    <input class="form-control formulario__validacion__input" type="text" id="telefono"
                                        name="telefono" placeholder="telefono...">
                                    <i class="formulario__validacion-estado fas fa-times-circle"></i>
                                </div>
                                <p class="formulario__input-error">El numero de telefono debe contener solo numeros y 11
                                    digitos
                                </p>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-2">
                                <div class="form-group" id="grupo_tipo_documento">
                                    <label class="formulario__label" for="tipo_documento">Tipo</label>
                                    <select class="form-control formulario__validacion__input" name="tipo_documento"
                                        id="tipo_documento">
                                        <option value="V">V</option>
                                        <option value="E">E</option>
                                        <option value="P">P</option>
                                    </select>
                                    <i class="formulario__validacion-estado fas fa-times-circle"></i>
                                </div>
                            </div>

                            <!-------------------------- Grupo Nº documento ----------------------------------->

                            <div class="col-sm-4 mb3" id="grupo_n_documento">
                                <label class="formulario__label" for="n_documento">Numero de documento</label>
                                <div class="form-group">
                                    <input class="form-control formulario__validacion__input" type="text"
                                        id="n_documento" name="n_documento" placeholder="numero de documento..."
                                        required>
                                    <i class="formulario__validacion-estado fas fa-times-circle"></i>
                                </div>
                                <p class="formulario__input-error">El numero de documento debe contener solo numeros y
                                    un
                                    mínimo de 7
                                    digitos y máximo 8.
                                </p>
                            </div>
                            <div class="col-sm-6 mb-3" id="grupo_correo">
                                <label class="formulario__label" for="correo">Correo</label>
                                <div class="form-group">
                                    <input class="form-control formulario__validacion__input" type="email" id="correo"
                                        name="correo" placeholder="tucorreo@ejemplo.com" required>
                                    <i class="formulario__validacion-estado fas fa-times-circle"></i>
                                </div>
                                <p class="formulario__input-error">El correo solo puede contener letras, numeros,
                                    puntos,
                                    guiones.
                                </p>
                            </div>
                        </div>
                        <div class="row mb-3">

                            <div class="col-sm-12" id="grupo_direccion">
                                <label class="formulario__label" for="direccion">Dirección corta</label>
                                <div class="form-group">
                                    <input class="form-control formulario__validacion__input" cols="4" rows="2"
                                        placeholder="Ingresa una dirección corta" id="direccion" name="direccion"
                                        required>
                                    <i class="formulario__validacion-estado fas fa-times-circle"></i>
                                </div>
                                <p class="formulario__input-error">La dirección puede contener solo letras, numeros,
                                    espacios, puntos, numerales y guiones.
                                </p>
                            </div>
                            <div>
                                <input type="hidden" name="tipo_persona" id="tipo_persona" value="Paciente">
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-sm-12" id="contenedor_datos_representante" style="display: none;">
                                <p>Datos del representante</p>
                                <div class="table-responsive tbl_personas">
                                    <table class="table table-bordered table-secondary table-striped table-hover">
                                        <tr>
                                            <th>Nº documento</th>
                                            <th>Nombres</th>
                                            <th>Apellidos</th>
                                            <th>Parentesco</th>
                                        </tr>
                                        <tr>
                                            <td id="documento_r"></td>
                                            <td id="nombres_representante"></td>
                                            <td id="apellidos_representante"></td>
                                            <td id="parentesco_representante">
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                       
                    </div>
                
                    <div class="step" id="step-2" style="display: none;">


                        <h5>Historial médico</h5>
                        <div class="row">
                            <div class="mb-3 col-sm-4">
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

                            <div class="mb-3 col-sm-8">
                                <div class="form-group" id="grupo_enfermedad">
                                    <label class="formulario__label" for="enfermedad">Enfermedad</label>
                                    <input class="form-control formulario__validacion__input" type="text"
                                        id="enfermedad" name="enfermedad" placeholder="¿Padece alguna enfermedad?">
                                    <i class="formulario__validacion-estado fas fa-times-circle"></i>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-3 col-sm-4">
                                <div class="form-group" id="grupo_fumador">
                                    <label class="formulario__label" for="fumador">Fumador</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="fumador" name="fumador">
                                        <label class="form-check-label" for="fumador">¿Es fumador?</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 col-sm-8">
                                <div class="form-group" id="grupo_ciru_hospi">
                                    <label class="formulario__label" for="ciru_hospi">Cirugías o
                                        hospitalizaciones</label>
                                    <input class="form-control formulario__validacion__input" type="text"
                                        id="ciru_hospi" name="ciru_hospi" placeholder="Cirugías o hospitalizaciones...">
                                    <i class="formulario__validacion-estado fas fa-times-circle"></i>
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
                            <div class="mb-3 col-sm-8">
                                <div class="form-group" id="grupo_alergia">
                                    <label class="formulario__label" for="alergia">Alergia</label>
                                    <input class="form-control formulario__validacion__input" type="text" id="alergia"
                                        name="alergia" placeholder="Alergias...">
                                    <i class="formulario__validacion-estado fas fa-times-circle"></i>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-sm-4">
                                <div class="form-group" id="grupo_ac_fisica">
                                    <label class="formulario__label" for="ac_fisica">Actividad física</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="ac_fisica" name="ac_fisica">
                                        <label class="form-check-label" for="ac_fisica">¿Realiza actividad
                                            física?</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 col-sm-8">
                                <div class="form-group" id="grupo_enfermedad_hered">
                                    <label class="formulario__label" for="enfermedad_hered">Enfermedad
                                        hereditaria</label>
                                    <input class="form-control formulario__validacion__input" type="text"
                                        id="enfermedad_hered" name="enfermedad_hered"
                                        placeholder="Enfermedades hereditarias...">
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
                                    <label class="formulario__label" for="indique_cual">Indique el medicamento</label>
                                    <input class="form-control formulario__validacion__input" type="text"
                                        id="indique_cual" name="indique_cual"
                                        placeholder="Especifique el medicamento...">
                                    <i class="formulario__validacion-estado fas fa-times-circle"></i>
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
                    data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="agregar_persona" title="Agregar persona"
                    style="display: none;"><i class="fas fa-save"></i> Guardar</button>
            </div>


        </div>
    </div>
</div>
</div>



<!-- Modal Actualizar Especies-->
<div class="modal fade" id="modalActualizarPersonas" tabindex="-1" aria-labelledby="modalActualizarPersonasLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalActualizarPersonas"> Modificar Personas <i class="fas fa-edit"></i>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" id="formActualizarPersonas">

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input id="id_persona" type="hidden" value="">
                            </div>
                        </div>
                    </div>

                    <!----------------- Grupo Nombres ----------------------->
                    <div class="row">
                        <div class="col-sm-6" id="grupo_nombres">
                            <label class="formulario__label" for="nombres">Nombres</label>
                            <div class="form-group">
                                <input class="form-control formulario__validacion__input" type="text"
                                    id="update_nombres" name="update_nombres" placeholder="Nombres">
                                <i class="formulario__validacion-estado fas fa-times-circle"></i>
                            </div>
                            <p class="formulario__input-error">El nombre debe contener Letras, numeros, guion y
                                guion_bajo</p>
                        </div>
                        <!----------------- Grupo Apellidos ----------------------->
                        <div class="col-sm-6" id="grupo_apellidos">
                            <label class="formulario__label" for="apellidos">Apellidos</label>
                            <div class="form-group ">
                                <input class="form-control formulario__validacion__input" type="text"
                                    id="update_apellidos" name="apellidos" placeholder="Apellidos">
                                <i class="formulario__validacion-estado fas fa-times-circle"></i>
                            </div>
                            <p class="formulario__input-error">El apellido debe contener Letras y espacios, pueden
                                llevar acentos.</p>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="formulario__label" for="tipo_documento">Tipo de documento</label>
                                <select class="form-control" name="tipo_documento" id="update_tipo_documento">
                                    <option value="">Seleccione</option>
                                    <option value="V">Venezolano</option>
                                    <option value="E">Extranjero</option>
                                    <option value="P">Pasaporte</option>
                                </select>
                            </div>
                        </div>
                        <!-------------------------- Grupo Nº documento ----------------------------------->

                        <div class="col-sm-6" id="grupo_n_documento">
                            <label class="formulario__label" for="n_documento">Numero de documento</label>
                            <div class="form-group">
                                <input class="form-control formulario__validacion__input" type="text"
                                    id="update_n_documento" name="n_documento" placeholder="numero de documento...">
                                <i class="formulario__validacion-estado fas fa-times-circle"></i>
                            </div>
                            <p class="formulario__input-error">El numero de documento debe contener solo numeros y un 8
                                digitos
                            </p>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="formulario__label" for="fecha_nac">Fecha de nacimiento</label>
                                <input type="date" class="form-control formulario__validacion__input"
                                    id="update_fecha_nac" name="fecha_nac">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="formulario__label" for="sexo">Sexo</label>
                                <select class="form-control formulario__validacion__input" name="sexo" id="update_sexo">
                                    <option value="">Seleccione</option>
                                    <option value="Masculino">Masculino</option>
                                    <option value="Femenino">Femenino</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <br>
                    <!----------------- Grupo Teléfono ----------------------->

                    <div class="row">
                        <div class="col-sm-6" id="grupo_telefono">
                            <label class="formulario__label" for="telefono">Telefono</label>
                            <div class="form-group">
                                <input class="form-control formulario__validacion__input" type="text"
                                    id="update_telefono" name="telefono" placeholder="telefono...">
                                <i class="formulario__validacion-estado fas fa-times-circle"></i>
                            </div>
                            <p class="formulario__input-error">El numero de telefono debe contener solo numeros y 11
                                digitos
                            </p>
                        </div>

                        <!----------------- Grupo Correo ----------------------->

                        <div class="col-sm-6" id="grupo_correo">
                            <label class="formulario__label" for="correo">Correo</label>
                            <div class="form-group">
                                <input class="form-control formulario__validacion__input" type="email"
                                    id="update_correo" name="correo" placeholder="jhon@gmail.com">
                                <i class="formulario__validacion-estado fas fa-times-circle"></i>
                            </div>
                            <p class="formulario__input-error">El correo solo puede contener letras, numeros, puntos,
                                guiones.
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12" id="grupo_direccion">
                            <label class="formulario__label " for="direccion">Dirección</label>
                            <div class="form-group">
                                <input class="form-control formulario__validacion__input" type="text"
                                    id="update_direccion" name="update_direccion">
                                <i class="formulario__validacion-estado fas fa-times-circle"></i>
                            </div>
                            <p class="formulario__input-error">El correo solo puede contener letras, numeros, puntos,
                                guiones.
                            </p>
                        </div>
                        <div>
                            <input type="hidden" name="tipo_persona" id="tipo_persona" value="paciente">
                        </div>
                    </div>
                    <br>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="prevBtn" style="display: none;"
                            onclick="nextPrev(-1)">Anterior</button>
                        <button type="button" class="btn btn-primary" id="nextBtn"
                            onclick="nextPrev(1)">Siguiente</button>
                        <button type="button" class="btn btn-secondary" title="Cerrar el modal"
                            data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" id="agregar_persona" title="Guardar persona"
                            style="display: none;"><i class="fas fa-save"></i> Guardar</button>
                    </div>
                </form>
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
    document.getElementById("agregar_persona").style.display = step === steps.length ? "inline" : "none";
}

function nextPrev(n) {
    var steps = document.getElementsByClassName("step");

    // Eliminamos la validación completamente
    steps[currentStep - 1].style.display = "none";
    currentStep += n;

    if (currentStep > steps.length) {
        document.getElementById("formRegistrarPersonas").submit();
        return false;
    }

    showStep(currentStep);
}

const checkbox = document.getElementById('medicado');
const inputText = document.getElementById('indiqueCual');

checkbox.addEventListener('change', function() {
    if (this.checked) {
        inputText.style.display = 'block'; // Mostrar el input de texto
    } else {
        inputText.style.display = 'none'; // Ocultar el input de texto
    }
});
</script>




<!-- Modal Visualizar Persona -->

<div class="modal fade" id="modalVisualizarPersona" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="modalVisualizarPersonaLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalVisualizarPersonaLabel">Persona</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hove">
                        <tr>
                            <th>Nombres/Apellidos</th>
                            <th>Documento</th>
                            <th>sexo</th>
                            <th>Fecha_nac</th>
                            <th>Dirección</th>

                        </tr>
                        <tr>
                            <td id="nombre_apellido"></td>
                            <td id="documento"></td>
                            <td id="sexo"></td>
                            <td id="fecha_nac"></td>
                            <td id="dreccion"></td>

                        </tr>
                    </table>
                </div>

            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>