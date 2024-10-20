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
            <h3 class="m-0">Recepcion de Medicamentos <i class="fa fas-solid fa-concierge-bell"></i> </i> </h3>
            <div class="btn-acciones-modulo">
                <!--<a  href="index.php?page=listarEspecialidadReporte" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
class="fas fa-download fa-sm text-white-50"></i> Generar Reporte</a>-->
                <button class="btn btn-primary btn-circle" title="Agregar Recepcion de Medicamentos" data-toggle="modal" data-target="#modalAgregarRecepcionMedicamentos">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="tabla_recepcion_medicamentos"  width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Medicamento</th>
                            <th>Presentacion</th>
                            <th>Categoria</th>
                            <th>Procedencia</th>
                            <th>Cantidad</th>
                            <th>Fecha recepcion</th>
                            <th>Fecha vencimiento</th>
                            <th>Descripcion</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>


<!--Modal Agregar Entrada Medicamento -->
<div class="modal fade" id="modalAgregarRecepcionMedicamentos" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalAgregarRecepcionMedicamentosLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAgregarRecepcionMedicamentosLabel">Agregar Recepcion de Medicamentos <i class="fa fa-solid fa-capsules"></i></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="formRegistrarRecepcionMedicamentos">


                <div class="row">
                        <div class="col-sm-6">
                            <label for="medicamentos">Medicamentos</label>
                            <input type="hidden" id="id_recepcion_medicamento" value="">
                            <select class="form-control" name="medicamentos" id="medicamento">
                                <option value="">Seleccione</option>
                                <?php
                                foreach ($medicamento  as  $medicamentos) {
                                ?>
                                   <option value="<?= $medicamentos->id_presentacion_medicamento ?>"><?= $medicamentos->nombre_medicamento." - ".$medicamentos->presentacion." - ".$medicamentos->codigo." - ".$medicamentos->categoria ?></option>
                                <?php
                                }
                                ?>
                            </select>
                            <small id="emailHelp" class="form-text text-muted">Selecciona el codigo del medicamento </small>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="nombres">Cantidad</label>
                                <input class="form-control" type="number" id="cantidad" placeholder="Cantidad">
                            </div>
                        </div>

                </div>

                    <div class="row">
                    <div class="col-sm-6">
                            <div class="form-group">
                                <label for="nombres">Procedencia</label>
                                <input class="form-control" type="text" id="procedencia" placeholder="Procedencia">
                            </div>
                        </div>
                    <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Fecha de vencimiento</label>
                                <input type="date" id="fecha_vencimiento" class="form-control rounded">
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">Descripcion</label>
                                    <textarea class="form-control" id="descripcion_recepcion" rows="3"></textarea>
                                </div>
                                <small>Ingresa una breve Descripcion</small>
                            </div>

                    </div>

                        <div class="modal-footer">
                <button type="button" class="btn btn-secondary" title="Cerrar el modal" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="agregar_recepcion_medicamento" title="Guardar cambios"><i class="fas fa-save"></i> Guardar</button>
            </div>     
            </div>
            
           
        </div>
        </form>

                         
    </div>

</div>
</div>
</div>


<!--Modal Actualizar Recepcion Medicamento -->
<div class="modal fade" id="modalActualizarRecepcionMedicamentos" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalActualizarRecepcionMedicamentosLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalActualizarRecepcionMedicamentosLabel">Actualizar Recepcion de Medicamentos <i class="fa fa-solid fa-capsules"></i></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="formActualizarRecepcionMedicamentos">


                <div class="row">
                        <div class="col-sm-6">
                            <label for="medicamentos">Medicamentos</label>
                            <select class="form-control" name="medicamentos" id="actualizar_recepcion_medicamento">
                                <option value="">Seleccione</option>
                                <?php
                                foreach ($medicamento  as  $medicamentos) {
                                ?>
                                   <option value="<?= $medicamentos->id_presentacion_medicamento ?>"><?= $medicamentos->nombre_medicamento." - ".$medicamentos->presentacion." - ".$medicamentos->codigo." - ".$medicamentos->categoria ?></option>
                                <?php
                                }
                                ?>
                            </select>
                            <small id="emailHelp" class="form-text text-muted">Selecciona el codigo del medicamento </small>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="nombres">Cantidad</label>
                                <input class="form-control" type="number" id="actualizar_recepcion_cantidad" placeholder="Cantidad">
                            </div>
                        </div>

                </div>

                    <div class="row">
                    <div class="col-sm-6">
                            <div class="form-group">
                                <label for="nombres">Procedencia</label>
                                <input class="form-control" type="text" id="actualizar_procedencia" placeholder="Procedencia">
                            </div>
                        </div>
                    <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Fecha de vencimiento</label>
                                <input type="date" id="actualizar_fecha_vencimiento" class="form-control rounded">
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">Descripcion</label>
                                    <textarea class="form-control" id="actualizar_recepcion_descripcion" rows="3"></textarea>
                                </div>
                                <small>Ingresa una breve Descripcion</small>
                            </div>

                    </div>

                        <div class="modal-footer">
                <button type="button" class="btn btn-secondary" title="Cerrar el modal" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="actualizar_recepcion_medicamentos" title="Guardar cambios"><i class="fas fa-save"></i> Guardar</button>
            </div>     
            </div>
            
           
        </div>
        </form>

                         
    </div>

</div>
</div>
</div>


