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

        <!-- Reports -->
        <div class="col-12">
          <div class="card">

            <!-- <div class="card-body">
              <h5 class="card-title">Matriz <span>/ Por especie</span></h5>
              <div class="table-responsive">
                <!-- Table with stripped rows -->

                <!-- <div class="container">
                  <img src="libs/img/cintillo1.png" alt="" style="width: 100%;">
                </div><br>
                <div class="container">
                  <a href="index.php?page=reporteMatrizJornada&id=" style="margin-bottom: 10px;"
                    class="btn btn-danger"
                    title="Reporte Matriz"
                    target="_blank">
                    <i class="fas fa-file-pdf"></i>
                  </a>
                </div>
                <table class="table datatable table-success" id="tablaMatriz">
                  <thead>
                    <tr>
                      <th>FECHA</th>
                      <th>TIPO DE DISTRIBUCIÓN</th>
                      <th>ORIGEN</th>
                      <th>Nº DE PLACA O Nº DE CARAVANA</th>
                      <th>DESTINO</th>
                      <th>BENEFICIARIO</th>
                      <th>PARROQUIA</th>
                      <th>ESPECIE</th>
                      <th>PRESENTACIÓN</th>
                      <th>KG. DISTRIBUIDOS</th>
                      <th>KG. VENDIDOS</th>
                      <th>PRECIO UNIT. BS</th>
                      <th>TASA CAMBIO</th>
                      <th>TOTAL BS</th>
                      <th>EQUIV. USD</th>
                      <th>OBSERVACIONES</th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
                 End Table with stripped rows 

              </div>
            </div>

          </div>
        </div> End Reports -->

        <!-- Recent Sales -->
        <div class="col-12"> 
          <div class="card recent-sales overflow-auto">

            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filter</h6>
                </li>

                <li><a class="dropdown-item" href="#">Today</a></li>
                <li><a class="dropdown-item" href="#">This Month</a></li>
                <li><a class="dropdown-item" href="#">This Year</a></li>
              </ul>
            </div>

            <div class="card-body">
              <h5 class="card-title">Recent Sales <span>| Today</span></h5>

              <table class="table table-borderless datatable">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Customer</th>
                    <th scope="col">Product</th>
                    <th scope="col">Price</th>
                    <th scope="col">Status</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th scope="row"><a href="#">#2457</a></th>
                    <td>Brandon Jacob</td>
                    <td><a href="#" class="text-primary">At praesentium minu</a></td>
                    <td>$64</td>
                    <td><span class="badge bg-success">Approved</span></td>
                  </tr>
                  <tr>
                    <th scope="row"><a href="#">#2147</a></th>
                    <td>Bridie Kessler</td>
                    <td><a href="#" class="text-primary">Blanditiis dolor omnis similique</a></td>
                    <td>$47</td>
                    <td><span class="badge bg-warning">Pending</span></td>
                  </tr>
                  <tr>
                    <th scope="row"><a href="#">#2049</a></th>
                    <td>Ashleigh Langosh</td>
                    <td><a href="#" class="text-primary">At recusandae consectetur</a></td>
                    <td>$147</td>
                    <td><span class="badge bg-success">Approved</span></td>
                  </tr>
                  <tr>
                    <th scope="row"><a href="#">#2644</a></th>
                    <td>Angus Grady</td>
                    <td><a href="#" class="text-primar">Ut voluptatem id earum et</a></td>
                    <td>$67</td>
                    <td><span class="badge bg-danger">Rejected</span></td>
                  </tr>
                  <tr>
                    <th scope="row"><a href="#">#2644</a></th>
                    <td>Raheem Lehner</td>
                    <td><a href="#" class="text-primary">Sunt similique distinctio</a></td>
                    <td>$165</td>
                    <td><span class="badge bg-success">Approved</span></td>
                  </tr>
                </tbody>
              </table>

            </div>

          </div>
        </div><!-- End Recent Sales -->

        <!-- Top Selling -->
        <div class="col-12">
          <div class="card top-selling overflow-auto">

            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filter</h6>
                </li>

                <li><a class="dropdown-item" href="#">Today</a></li>
                <li><a class="dropdown-item" href="#">This Month</a></li>
                <li><a class="dropdown-item" href="#">This Year</a></li>
              </ul>
            </div>

            <div class="card-body pb-0">
              <h5 class="card-title">Top Selling <span>| Today</span></h5>

              <table class="table table-borderless">
                <thead>
                  <tr>
                    <th scope="col">Preview</th>
                    <th scope="col">Product</th>
                    <th scope="col">Price</th>
                    <th scope="col">Sold</th>
                    <th scope="col">Revenue</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th scope="row"><a href="#"><img src="assets/img/product-1.jpg" alt=""></a></th>
                    <td><a href="#" class="text-primary fw-bold">Ut inventore ipsa voluptas nulla</a></td>
                    <td>$64</td>
                    <td class="fw-bold">124</td>
                    <td>$5,828</td>
                  </tr>
                  <tr>
                    <th scope="row"><a href="#"><img src="assets/img/product-2.jpg" alt=""></a></th>
                    <td><a href="#" class="text-primary fw-bold">Exercitationem similique doloremque</a></td>
                    <td>$46</td>
                    <td class="fw-bold">98</td>
                    <td>$4,508</td>
                  </tr>
                  <tr>
                    <th scope="row"><a href="#"><img src="assets/img/product-3.jpg" alt=""></a></th>
                    <td><a href="#" class="text-primary fw-bold">Doloribus nisi exercitationem</a></td>
                    <td>$59</td>
                    <td class="fw-bold">74</td>
                    <td>$4,366</td>
                  </tr>
                  <tr>
                    <th scope="row"><a href="#"><img src="assets/img/product-4.jpg" alt=""></a></th>
                    <td><a href="#" class="text-primary fw-bold">Officiis quaerat sint rerum error</a></td>
                    <td>$32</td>
                    <td class="fw-bold">63</td>
                    <td>$2,016</td>
                  </tr>
                  <tr>
                    <th scope="row"><a href="#"><img src="assets/img/product-5.jpg" alt=""></a></th>
                    <td><a href="#" class="text-primary fw-bold">Sit unde debitis delectus repellendus</a></td>
                    <td>$79</td>
                    <td class="fw-bold">41</td>
                    <td>$3,239</td>
                  </tr>
                </tbody>
              </table>

            </div>

          </div>
        </div><!-- End Top Selling -->

      </div>
    </div><!-- End Left side columns -->

  </div>
</section>

<?php

?>