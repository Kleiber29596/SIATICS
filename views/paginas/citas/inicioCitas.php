<?php
require_once 'controllers/EspecialidadController.php';
$objeto  = new EspecialidadController();
$especialidades = $objeto->selectEspecialidadCitas();


if ($rol == 4 || $rol == 5 || $rol == 6 || $rol == 1) { 
        echo "<h1>No tienes los permisos suficientes para ingresar en este modulo</h1>"; 
    } else { 
    ?>

<style type="text/css">
.selected-date {
    background-color: #ffcc00;
    /* Cambia el color según tus preferencias */
}
</style>

<div class="pagetitle">
    <h1>Citas  <i class="bi bi-calendar"></i></h1>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-8">

            <div class="card">
                <div class="card-body">
                    <p></p>
                    <!-- Button trigger modal  -->
                    <!--<button title="Agregar Persona" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#modalAgregarPersona">
                        <i class="fas fa-plus"></i>
                    </button>-->
                    <div class="table-responsive">
                        <!-- Table with stripped rows -->
                        <table class="table table-bordered mt-3 " id="tabla_citas" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Fecha cita</th>
                                    <th>Nombre y Apellido</th>
                                    <th>Cedula/P</th>
                                    <th>Estatus</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                        </table>
                        <!-- End Table with stripped rows -->

                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <form action="" method="POST" id="formCalendarCita">
                        <div class="col-sm-12">
                            <div class="form-group mt-3">
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
                            <div class="form-group">
                                <label class="formulario__label mt-4" for="doctor">Doctor</label>
                                <select class="form-control" name="doctor" id="doctor" required>
                                    <option value="" disabled selected>Seleccione</option>
                                </select>
                            </div>
                            <div class="mt-3" id="DIVcalendar"></div>
                            <input type="hidden" name="diaLaboral" id="diaLaboral">
                            <input type="hidden" name="limiteCita" id="limiteCita">
                            <!--<button class="btn btn-primary btn-circle mt-3" title="Agregar cita" data-toggle="modal" data-target="#modalAgregarCitas"><i class="fas fa-plus"> Agregar cita</i></button>

                            <button type="submit" class="btn btn-primary btn-circle mt-3">
                                <i class="fas fa-plus">Agregar cita</i>
                            </button>-->
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>


<!--Mostrar citas por fecha-->

<div class="modal fade" id="dataModal" tabindex="-1" role="dialog" aria-labelledby="dataModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dataModalLabel"></h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6">
                        <p><strong>Especialidad: </strong><span id="espe"></span></p>
                    </div>
                    <div class="col-lg-6">
                        <p id="ob"><strong>Observacion: </strong><span id="obs_cita"></span></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <p><strong>Fecha seleccionada:</strong> <span id="fecha"></span></p>
                        <p><strong>Doctor: </strong> <span id="doct"></span></p>
                    </div>
                    <div class="col-lg-6">
                        <p style="padding:10px; background: green; color: white; width:50%; display: none;" id="espe_green"><strong>Estatus: </strong><span id="est"></span></p>
                        <p style="padding:10px; background: red; color: white; width:50%; display: none;" id="espe_red"><strong>Estatus: </strong><span id="est"></span></p>
                    </div>
                </div>
                <table id="tablaDatos" class="table" style="width:100%">
                    
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" title="Cerrar el modal"
                    data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Agregar Cita-->
<div class="modal fade" id="modalAgregarCitas" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="modalAgregarCitasLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAgregarCitasLabel">Agregar Cita <i class="bi bi-calendar"></i></span>
                </h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="formRegistrarCita">
                    <div class="row">
                        <div class="col-sm-11">
                            <div class="form-group">
                                <label for="n_documento">Número de documento</label>
                                <input class="form-control" type="text" id="n_documento_persona"
                                    placeholder="Ingrese el número de documento del paciente" required>
                                <input type="hidden" id="id_persona" value="">
                            </div>
                        </div>
                        <div class="col-sm-1" style="display: flex;justify-content: flex-start; align-items: flex-end;">
                            <div class="form-group">
                                <button type="button" class="btn btn-primary" id="consultar_persona"
                                    title="Buscar paciente"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </div>

                    <div class="row" id="contenedor_datos_persona" style="display: none;">
                        <div class="col-sm-12 mt-3">
                            <p>Datos del Paciente</p>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-secondary table-hover">
                                    <tr>
                                        <th style="background-color:#bfc1c3;">Nº documento</th>
                                        <th style="background-color:#bfc1c3;">Nombres/Apellidos</th>
                                        <th style="background-color:#bfc1c3;">Telefono</th>
                                        <th style="background-color:#bfc1c3;">Sexo</th>
                                        <th style="background-color:#bfc1c3;">Edad</th>
                                        <th style="background-color:#bfc1c3;">Dirección</th>

                                    </tr>
                                    <tr>
                                        <td id="n_documento"></td>
                                        <td id="nombres_apellidos_persona"></td>
                                        <td id="tlf_persona"></td>
                                        <td id="sexo_persona"></td>
                                        <td id="edad"></td>
                                        <td id="direccion_persona"></td>
                                        <input id="ID" type="hidden" name="ID" value="">
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div><br>

                    <div class="row">
                        <div class="col-sm-6">
                            <label for="txt-especialidad">Especialidad</label>
                            <input type="label" class="form-control" name="txt-especialidad" id="txt-especialidad"
                                disabled>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="txt-doctor">Doctor</label>
                                <input type="" class="form-control" name="txt-doctor" id="txt-doctor" disabled>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group mt-3">
                                <label for="fecha_cita">Fecha de la cita</label>
                                <input type="date" id="fecha_cita" class="form-control rounded" disabled>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group mt-3">
                                <label for="observacion_cita">Observación</label>
                                <textarea id="observacion_cita" class="form-control rounded"
                                    placeholder="Escriba aquí"></textarea>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" title="Cerrar el modal"
                    data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="agregar_cita" title="Guardar cita"><i
                        class="fas fa-save"></i> Guardar</button>
            </div>
        </div>

    </div>
</div>

<?php 
} 
?>

<!--------------------------------Modificar cita --------------------------------------------->

<div class="modal fade" id="modalModificarCitas" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="modalModificarCitasLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalModificarCitasLabel">Modificar Cita <i class="bi bi-calendar"></i></span>
                </h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="formRegistrarCita">
                    <div class="row" id="contenedor_datos_persona">
                        <div class="col-sm-12 mt-3">
                            <p>Datos de la persona</p>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-secondary table-hover" id="tabla_datosPersona">
                                    <thead>
                                        <tr>
                                            <th style="background-color:#bfc1c3;">Nº documento</th>
                                            <th style="background-color:#bfc1c3;">Nombres/Apellidos</th>
                                            <th style="background-color:#bfc1c3;">Telefono</th>
                                            <th style="background-color:#bfc1c3;">Sexo</th>
                                            <th style="background-color:#bfc1c3;">Edad</th>
                                            <th style="background-color:#bfc1c3;">Dirección</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div><br>

                    <div class="row">
                        <div class="col-sm-6">
                            <label for="txt-esp">Especialidad</label>
                            <input type="label" class="form-control" name="txt-esp" id="txt-esp"
                                disabled>
                            <input type="hidden" id="id-esp">
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="txt-doctor">Doctor</label>
                                <select class="form-control" name="txt-doc" id="txt-doc">
                                    
                                </select>                                
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group mt-3">
                                <label for="fecha_cita">Fecha de la cita</label>
                                <input type="date" id="fech_cita" class="form-control rounded">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group mt-3">
                                <label for="observacion_cita">Observación</label>
                                <textarea id="observacion_cita" class="form-control rounded"
                                    placeholder="Escriba aquí"></textarea>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" title="Cerrar el modal"
                    data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="modificar_cita" title="Actualizar cita"><i
                        class="fas fa-save"></i> Actualizar</button>
            </div>
        </div>

    </div>
</div>