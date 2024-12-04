<?php

require_once 'models/dashboardModel.php';


$dashboardModel = new dashboardModel();

if (session_status() === PHP_SESSION_ACTIVE) {
  //echo "La sesión está activa.";
  $usuario            = $_SESSION['usuario'];
  $id_usuario         = $_SESSION['user_id'];
  $rol                = $_SESSION['rol_usuario'];
  
} else {
  //echo "La sesión no está activa.";
  session_start();
  $usuario            = $_SESSION['usuario'];
  $id_usuario         = $_SESSION['user_id'];
  $rol           = $_SESSION['rol_usuario'];
}

$get_numeroCitas = $dashboardModel->numeroCitas();

foreach ($get_numeroCitas as $citas ) {
  $numeroCitas=$citas["numeroCitas"];
}

$get_numeroConsultas = $dashboardModel->numeroConsultas();

foreach ($get_numeroConsultas as $consultas ) {
  $numeroConsultas=$consultas["numeroConsultas"];
}

$get_numeroPacientesAt = $dashboardModel->pacientesAtendidos();

foreach ($get_numeroPacientesAt as $pacientes ) {
  $numeroPacientesAt=$pacientes["numeroPacientesAt"];
}
$get_pacientesAtendidosGeneral = $dashboardModel->pacientesAtendidosGeneral();
foreach ($get_pacientesAtendidosGeneral as $general ) {
  $generalAtendidos = $general["total_general"];
}
?>
<div class="pagetitle">
    <!-- <h1>MATRIZ OPERACIÓN "VENEZUELA COME PESCADO"</h1> -->
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Incio</a></li>
            <li class="breadcrumb-item active">Panel</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section dashboard">
    <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-12">
            <div class="row">

                <!-- Sales Card -->
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card sales-card">

                        <div class="card-body">
                            <h5 class="card-title">Total Citas <span>| General</span></h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">


                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                <div class="ps-3">
                                    <h6> <?php echo $numeroCitas;?></h6>


                                </div>
                            </div>
                        </div>

                    </div>
                </div><!-- End Sales Card -->

                <!-- Sales Card -->
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card sales-card">

                        <div class="card-body">
                            <h5 class="card-title">Numero de Consultas<span>| General</span></h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">

                                    <i class="fas fa-stethoscope"></i>
                                </div>
                                <div class="ps-3">
                                    <h6><?php echo $numeroConsultas;?></h6>


                                </div>
                            </div>
                        </div>

                    </div>
                </div><!-- End Sales Card -->

                <!-- Revenue Card -->
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card revenue-card">

                        <div class="card-body">
                            <h5 class="card-title">Pacientes Atendidos <span>| Por Citas</span></h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="fas fa-hospital-user"></i>
                                </div>
                                <div class="ps-3">
                                    <h6><?php echo $numeroPacientesAt;?></h6>
                                </div>
                            </div>
                        </div>

                    </div>
                </div><!-- End Revenue Card -->


                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card revenue-card">

                        <div class="card-body">
                            <h5 class="card-title">Total Atendidos <span>| General</span></h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="fas fa-user-check"></i>

                                </div>
                                <div class="ps-3">
                                    <h6> <?php echo $generalAtendidos;?></h6>
                                </div>
                            </div>
                        </div>

                    </div>
                </div><!-- End Revenue Card -->

                <div class="container">
                    <div class="row">
                        <div class="card">
                            <div class="col-sm-12">
                                <h3 style="margin-top: 20px;">Total consultas por especialidad</h3>
                                <div id="grafica"></div>
                            </div>
                        </div>
                    </div>
                </div>

                

            </div>
</section>

<?php

?>