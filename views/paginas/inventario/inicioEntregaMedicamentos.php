<?php 
require_once 'controllers/MedicamentosController.php';

$objeto  = new MedicamentosController();
$medicamento = $objeto->selectMedicamentos();

?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 title_boton" style="background-color: #FFF;  display: flex;
justify-content: space-between;">
            <h3 class="m-0">Entrega de Medicamentos <i class="fa fa-solid fa-capsules"></i></h3>
            <div class="btn-acciones-modulo">
                <!--<a  href="index.php?page=listarEspecialidadReporte" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
class="fas fa-download fa-sm text-white-50"></i> Generar Reporte</a>-->
                <button class="btn btn-primary btn-circle" title="Agregar Agregar Entrega de Medicamentos"
                    data-toggle="modal" data-target="#modalAgregarEntregaMedicamentos">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="tabla_entrega_medicamentos" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Medicina</th>
                            <th>Presentacion</th>
                            <th>#Codigo</th>
                            <th>categoria</th>
                            <th>Cantidad</th>
                            <th>fecha_entrega</th>
                            <th>Beneficiario</th>
                            <th>Parentesco</th>
                            <th>Descripcion</th>
                            <!--<th>Sexo</th>
                            <th>Edad</th>
                            <th>Rango-Edad</th>
                            <th>Estado</th>
                            <th>Municipio</th>
                            <th>Parroquia</th>-->
                            <th>Acciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

<!--Modal Agregar Entrega de Medicamentos -->
<div class="modal fade" id="modalAgregarEntregaMedicamentos" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="modalAgregarEntregaMedicamentosLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                    <div class="col-sm-10">
                        <div>
                            <h5 class="modal-title" id="modalAgregarEntregaMedicamentosLabel">Agregar Entrega de Medicamentos <i class="fa fa-solid fa-capsules"></i></h5>
                        </div>
                        
                    </div>
                    <div class="col-sm-2">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
            </div>
            <div class="modal-body">
                <form action="" id="formRegistrarEntregaMedicamentos">

                    <div class="row">
                        <div class="col-sm-2"
                            style="display: flex; justify-content: flex-start; align-items: flex-end;">
                            <div class="form-group">
                                <label for="">Tipo de documento </label>
                                <select class="form-control" name="tipo_documento" id="tipo_documento_persona">
                                    <option value="">Seleccione</option>
                                    <option value="1">V</option>
                                    <option value="2">E</option>
                                    <option value="3">P</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-9">
                            <div class="form-group">
                                <label for="n_documento">Número de documento de la persona</label>
                                <input class="form-control" type="text" id="n_documento_persona"
                                    placeholder="Ingrese el número de documento">
                                <input type="hidden" id="id_persona" value="">
                            </div>
                        </div>
                        <div class="col-sm-1" style="display: flex;justify-content: flex-start; align-items: flex-end;">
                            <div class="form-group">
                                <button type="button" class="btn btn-primary" id="consultar_persona"
                                    title="Buscar persona"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                </div>
                        <div class="row" id="contenedor_datos_persona" style="display: none;">
                            <div class="col-sm-12">
                                <p>Datos del beneficiario</p>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover">
                                        <tr>
                                            <th>Tipo de documento</th>
                                            <th>Numero de documento</th>
                                            <th>Nombres</th>
                                            <th>Apellidos</th>
                                            <th>Edad</th>
                                            <th>Sexo</th>
                                            <th>Estado</th>
                                            <th>Municipio</th>
                                            <th>Parroquia</th>
                                        </tr>
                                        <tr>
                                            <td id="tipo_documento_persona_consulta"></td>
                                            <td id="n_documento_persona_consulta"></td>
                                            <td id="nombres_persona"></td>
                                            <td id="apellidos_persona"></td>
                                            <td id="edad_persona"></td>
                                            <td id="sexo_persona"></td>
                                            <td id="estado_persona"></td>
                                            <td id="municipio_persona"></td>
                                            <td id="parroquia_persona"></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div><br>
                    
                    <div id="Contenedor_formulario_persona" style="display: none;">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="nombres">Nombres</label>
                                    <input class="form-control" type="text" id="nombres_persona_registro"
                                        placeholder="Nombres">
                                    <small id="emailHelp" class="form-text text-muted">Parentesco con el beneficiario
                                        final </small>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="nombres">Apellidos</label>
                                    <input class="form-control" type="text" id="apellidos_persona_registro"
                                        placeholder="Apellidos">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="fecha_nac">Fecha de nacimiento</label>
                                    <input type="date" class="form-control" id="fecha_nac" name="fecha_nac">
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="nombres">Correo</label>
                                    <input class="form-control" type="text" id="correo" placeholder="Correo">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="nombres">Telefono</label>
                                    <input class="form-control" type="text" id="telefono" placeholder="Telefono">
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="nombres">Sexo</label>
                                    <select class="form-control" name="sexo" id="sexo">
                                        <option value="">Seleccione</option>
                                        <option value="Masculino">Masculino</option>
                                        <option value="Femenino">Femenino</option>
                                    </select>
                                    <small id="emailHelp" class="form-text text-muted">Selecciona el sexo </small>
                                </div>

                            </div>

                        </div>
                        <div class="row">

                            <div class="col-sm-4">
                                <label for="estado">Estado</label>
                                <select class="form-control" name="estado" id="estado">
                                    <option value="4">Seleccione</option>
                                    <?php
                                    foreach ($estados  as  $estados) {
                                    ?>
                                    <option value="<?= $estados['id_estado'] ?>"><?= $estados['estado'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <small id="emailHelp" class="form-text text-muted">Selecciona el estado </small>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="municipio">Municipio</label>
                                    <select class="form-control" name="municipio" id="municipio">
                                        <option value="4">Seleccione</option>

                                    </select>
                                    <small id="emailHelp" class="form-text text-muted">Selecciona el municipio </small>
                                </div>

                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="estatus-update">Parroquia</label>
                                    <select class="form-control" name="parroquia" id="parroquia">
                                        <option value="4">Seleccione</option>
                                    </select>
                                    <small id="emailHelp" class="form-text text-muted">Selecciona la parroquia </small>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <label for="medicamentos">Medicamentos</label>
                            <select class="form-control" name="medicamentos" id="entrega_medicamento">
                                <option value="">Seleccione el medicamento</option>
                                <?php
                                    foreach ($medicamento  as  $medicamentos) {
                                    ?>
                                <option value="<?= $medicamentos->id_presentacion_medicamento ?>">
                                    <?= $medicamentos->nombre_medicamento." - ".$medicamentos->presentacion." - ".$medicamentos->codigo." - ".$medicamentos->categoria ?>
                                </option>
                                <?php
                                    }
                                    ?>
                            </select>

                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="nombres">Cantidad</label>
                                <input class="form-control" type="number" id="cantidad_entrega" placeholder="Cantidad">
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="nombres">Parentesco</label>
                                <input class="form-control" type="text" id="parentesco" placeholder="Parentesco">
                                <small id="emailHelp" class="form-text text-muted">Parentesco con el beneficiario final
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="row">


                        <div class="col-sm-5">
                            <div class="form-group">
                                <label for="nombres">Rango de Edad</label>
                                <input class="form-control" type="text" id="rango_edad" placeholder="Rango de Edad">
                            </div>
                        </div>

                        <div class="col-sm">
                            <div class="form-group">
                                <label for="nombres">Descripcion</label>
                                <label for="exampleFormControlTextarea1"></label>
                                <textarea class="form-control" id="descripcion_entrega" rows="4"></textarea>
                            </div>
                            <small>Ingresa una breve Descripcion</small>
                        </div>
                    </div>




                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" title="Cerrar el modal"
                            data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" id="agregar_entrega_medicamento"
                            title="Guardar cambios"><i class="fas fa-save"></i> Guardar</button>
                    </div>
            </div>


        </div>
        </form>


    </div>

</div>
</div>
</div>