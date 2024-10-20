<?php 
require_once 'controllers/MedicamentosController.php';
require_once 'controllers/PresentacionController.php';
$objeto  = new MedicamentosController();
$categoria = $objeto->selectCategoria();
$update_categoria = $objeto->selectCategoria();

$objeto2  = new PresentacionController();
$presentacion = $objeto2->selectPresentacion();
$update_categoria = $objeto2->selectPresentacion();
?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 title_boton" style="background-color: #FFF;  display: flex;
justify-content: space-between;">
            <h3 class="m-0">Medicamentos <i class="fa fa-solid fa-capsules"></i></h3>
            <div class="btn-acciones-modulo">
                <!--<a  href="index.php?page=listarEspecialidadReporte" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
class="fas fa-download fa-sm text-white-50"></i> Generar Reporte</a>-->
                <button class="btn btn-primary btn-circle" title="Agregar Medicamento" data-toggle="modal"
                    data-target="#modalAgregarMedicamentos">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="tabla_medicamentos" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nombre_medicamento</th>
                            <th>Presentacion</th>
                            <th># Codigo</th>
                            <th>categoria</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->


<!--Modal Agregar Medicamento -->
<div class="modal fade" id="modalAgregarMedicamentos" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="modalAgregarMedicamentosLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAgregarPacienteLabel">Agregar Medicamento <i
                        class="fa fa-solid fa-capsules"></i></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="formRegistrarMedicamento">


                    


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" title="Cerrar el modal"
                    data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="agregar_medicamento" title="Guardar cambios"><i
                        class="fas fa-save"></i> Guardar</button>
            </div>
        </div>
        </form>


    </div>

</div>
</div>
</div>