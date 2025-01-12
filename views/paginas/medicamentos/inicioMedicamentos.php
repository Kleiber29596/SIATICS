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

<?php

require_once 'models/MedicamentosModel.php';
$medicamentosModel = new MedicamentosModel();
$presentaciones = $medicamentosModel->selectPresentacion();
$presentaciones_update = $medicamentosModel->selectPresentacion();
$categorias = $medicamentosModel->listarCategorias();
$categorias_update = $medicamentosModel->listarCategorias();


?>

<div class="pagetitle">
    <h1>Medicamentos <i class="bi bi-capsule-pill"></i></h1>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <p></p>
                    <!-- Button trigger modal  -->
                    <button title="Agregar Medicamento" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#modalAgregarMedicamentos">
                        <i class="fas fa-plus"></i>
                    </button>
                    <div class="table-responsive">
                        <!-- Table with stripped rows -->
                        <table class="table datatable" id="tbl_medicamentos">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Presentación</th>
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
<div class="modal fade" id="modalAgregarMedicamentos" tabindex="-1" aria-labelledby="agregarMedicamentoModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAgregarMedicamentoLabel">Agregar medicamento <i class="bi bi-capsule-pill"></i></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" id="formRegistrarMedicamentos">

                    <div class="row">

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="presentacion">Medicamento</label>
                                <input class="form-control" type="text" id="nombre_medicamento"
                                    name="nombre_medicamento" placeholder="Ingrese el medicamento">
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="formulario__label" for="categoria">Categoria</label>
                                <select class="select2-selection--single" name="categoria" id="categoria"
                                    style="width:100%" required>
                                    <option value="" disabled selected>Seleccione</option>
                                    <?php
                                    foreach ($categorias as $categoria) {
                                        ?>
                                        <option value="<?= $categoria['codigo'] ?>">
                                            <?= $categoria['categoria'] ?>
                                        </option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="formulario__label" for="presentacion">Presentación</label>
                                <select class="select2-selection--single" name="presentacion" id="presentacion"
                                    style="width:100%" required>
                                    <option value="" disabled selected>Seleccione</option>
                                    <?php
                                    foreach ($presentaciones as $presentacion) {
                                        ?>
                                        <option value="<?= $presentacion['id_presentacion'] ?>">
                                            <?= $presentacion['presentacion'] ?>
                                        </option>
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
                        <button type="button" class="btn btn-primary" id="agregar_medicamento"
                            title="Guardar cambios"><i class="fas fa-save"></i> Guardar</button>
                    </div>
                </form>

            </div>

        </div>
    </div>
</div>


<!-- Modal Actualizar medicamento -->
<div class="modal fade" id="modalActualizarMedicamentos" tabindex="-1"
    aria-labelledby="modalActualizarMedicamentosLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalActualizarMedicamentosLabel">Modificar Motivo <i
                        class="fas fa-edit"></i>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" id="formActualizarMedicamento">

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input id="id_medicamento_update" type="hidden" value="">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input id="id_pm_update" type="hidden" value="">
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="presentacion_update">Medicamento</label>
                                <input class="form-control" type="text" id="nombre_medicamento_update"
                                    name="nombre_medicamento_update" placeholder="Ingrese el medicamento">
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="formulario__label" for="categoria_update">Categoria</label>
                                <select class="select2-selection--single" name="categoria_update" id="categoria_update"
                                    style="width:100%" required>
                                    <option value="" disabled selected>Seleccione</option>
                                    <?php
                                    foreach ($categorias_update as $categoria) {
                                        ?>
                                        <option value="<?= $categoria['codigo'] ?>">
                                            <?= $categoria['categoria'] ?>
                                        </option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="formulario__label" for="presentacion">Presentación</label>
                                <select class="select2-selection--single" name="presentacion_update"
                                    id="presentacion_update" style="width:100%" required>
                                    <option value="" disabled selected>Seleccione</option>
                                    <?php
                                    foreach ($presentaciones_update as $p) {
                                        ?>
                                        <option value="<?= $p['id_presentacion'] ?>">
                                            <?= $p['presentacion'] ?>
                                        </option>
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
                        <button type="button" class="btn btn-primary" id="modificar_medicamento" title="Guardar cambios"><i
                                class="fas fa-save"></i> Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>