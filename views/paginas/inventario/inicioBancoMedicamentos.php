
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 title_boton" style="background-color: #FFF;  display: flex;
justify-content: space-between;">
            <h3 class="m-0"> Banco de Medicamentos  <i class="fa fas-solid fa-warehouse"></i>   </h3>
            <div class="btn-acciones-modulo">
                <!--<a  href="index.php?page=listarEspecialidadReporte" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
class="fas fa-download fa-sm text-white-50"></i> Generar Reporte</a>-->
                <button class="btn btn-primary btn-circle" title="Agregar Medicamento" href="<?= SERVERURL ?>index.php?page=inicioRecepcionMedicamentos">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="tabla_banco_medicamentos"  width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Medicamento</th>
                            <th>Presentacion</th>
                            <th># Codigo - Categoria</th>
                            <th>categoria</th>
                            <th>Cantidad</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
