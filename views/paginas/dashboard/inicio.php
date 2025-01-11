<?php

require_once 'models/dashboardModel.php';
require_once 'models/ConsultasModel.php';
require_once 'controllers/dashboardController.php';


$dashboardModel             = new dashboardModel();
$modelConsultas             = new ConsultasModel();
$controllerDashboard        = new dashboardController();

$tipos_consultas = $modelConsultas->SelectTipos();

//Permite filtrar datos para un grafica a traves de fecha inicio y fecha fin
if (isset($_GET['fechaDesdeDash']) && isset($_GET['fechaHastaDash'])) {
    $datos_filtro_dashboard = $controllerDashboard->filtrarDashboard($_GET['fechaDesdeDash'], $_GET['fechaHastaDash']);

}

//Permite filtrar datos para un grafica a traves de fecha inicio y fecha fin
if (isset($_GET['fechaDesde']) && isset($_GET['fechaHasta'])) {
    $datos_filtro_grafica = $dashboardModel->fechaDesdeHastaTipoConsulta($_GET['fechaDesde'], $_GET['fechaHasta']);
}


if (session_status() === PHP_SESSION_ACTIVE) {
    //echo "La sesión está activa.";
    $usuario = $_SESSION['usuario'];
    $id_usuario = $_SESSION['user_id'];
    $rol = $_SESSION['rol_usuario'];
} else {
    //echo "La sesión no está activa.";
    session_start();
    $usuario = $_SESSION['usuario'];
    $id_usuario = $_SESSION['user_id'];
    $rol = $_SESSION['rol_usuario'];
}

$get_numeroCitas = $dashboardModel->numeroCitas();

foreach ($get_numeroCitas as $citas) {
    $numeroCitas = $citas["numeroCitas"];
}

$get_numeroConsultas = $dashboardModel->numeroConsultas();

foreach ($get_numeroConsultas as $consultas) {
    $numeroConsultas = $consultas["numeroConsultas"];
}

$get_numeroPacientesAt = $dashboardModel->pacientesAtendidos();

foreach ($get_numeroPacientesAt as $pacientes) {
    $numeroPacientesAt = $pacientes["numeroPacientesAt"];
}
$get_pacientesAtendidosGeneral = $dashboardModel->pacientesAtendidosGeneral();
foreach ($get_pacientesAtendidosGeneral as $general) {
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
            <div class="container mb-3">
                <div class="card">
                    <div class="card-body">
                        <br>
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="fechaDesdeDash">Fecha desde</label>
                                    <input id="fechaDesdeDash" class="form-control" type="date">
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="fechaHastaDash">Fecha hasta</label>
                                    <input id="fechaHastaDash" class="form-control" type="date">
                                </div>
                            </div>

                            <div class="col-sm-2" style="display: flex; justify-content: center; align-items: end;">
                                <button id="btnFiltroFechaDesdeHastaDash"
                                    type="button"
                                    class="btn btn-primary"
                                    onclick="filtrarDatosDashboard()"
                                    href="">
                                    Filtrar <i class="bi bi-filter"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">

                <!-- Sales Card -->
                <!-- <div class="col-xxl-4 col-md-6">
                    <div class="card info-card sales-card">

                        <div class="card-body">
                            <h5 class="card-title">Total Citas <span>| General</span></h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">


                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>
                                        <?php
                                        /*
                                        if (isset($_GET['fechaDesdeDash']) && isset($_GET['fechaHastaDash'])) {
                                            echo $datos_filtro_dashboard['total_citas'];
                                        } else {
                                            echo $numeroCitas;
                                        }*/
                                        ?>
                                    </h6>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>End Sales Card -->

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
                                    <h6>
                                        <?php
                                        if (isset($_GET['fechaDesdeDash']) && isset($_GET['fechaHastaDash'])) {
                                            echo $datos_filtro_dashboard['total_numero_consultas'];
                                        } else {
                                            echo $numeroConsultas;
                                        }
                                        ?>
                                    </h6>
                                </div>
                            </div>
                        </div>

                    </div>
                </div><!-- End Sales Card -->

                <!-- Revenue Card -->
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card revenue-card">

                        <div class="card-body">
                            <h5 class="card-title">Citas Atendidas <span>| Citas Finalizadas</span></h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="fas fa-hospital-user"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>
                                        <?php
                                        if (isset($_GET['fechaDesdeDash']) && isset($_GET['fechaHastaDash'])) {
                                            echo $datos_filtro_dashboard['total_pacientes_atendidos'];
                                        } else {
                                            echo $numeroPacientesAt;
                                        }
                                        ?>
                                    </h6>
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
                                    <h6>
                                        <?php
                                        if (isset($_GET['fechaDesdeDash']) && isset($_GET['fechaHastaDash'])) {
                                            echo $datos_filtro_dashboard['total_atendidos'];
                                        } else {
                                            echo $generalAtendidos;
                                        }
                                        ?>
                                    </h6>
                                </div>
                            </div>
                        </div>

                    </div>
                </div><!-- End Revenue Card -->

                <div class="container">
                    <div class="row">
                        <div class="card">
                            <div class="col-sm-12">
                                <h3 style="margin-top: 20px;">Total Consultas por Especialidad</h3>
                                <!--<button id="boton1" type="button" class="btn btn-success">Reporte</button> --->
                                <?php
                                if (isset($_GET['fechaDesdeDash']) && isset($_GET['fechaHastaDash'])) {
                                ?>
                                    <div id="graficaFechaDesdehasta"></div>
                                    <script>
                                        am4core.ready(function() {

                                            // Themes begin
                                            am4core.useTheme(am4themes_animated);
                                            // Create chart instance
                                            var chart = am4core.create("graficaFechaDesdehasta", am4charts.PieChart);

                                            // Add data

                                            chart.data = <?= $datos_filtro_dashboard['total_consultas_especialidad'] ?>


                                            // Add and configure Series
                                            var pieSeries = chart.series.push(new am4charts.PieSeries());
                                            pieSeries.dataFields.value = "total_consulta_especialidad";
                                            pieSeries.dataFields.category = "nombre_especialidad";

                                            // This creates initial animation
                                            pieSeries.hiddenState.properties.opacity = 1;
                                            pieSeries.hiddenState.properties.endAngle = -90;
                                            pieSeries.hiddenState.properties.startAngle = -90;

                                            // Let's cut a hole in our Pie chart the size of 40% the radius
                                            chart.innerRadius = am4core.percent(40);

                                            // Put a thick white border around each Slice
                                            pieSeries.slices.template.stroke = am4core.color("#4a2abb");
                                            pieSeries.slices.template.strokeWidth = 2;
                                            pieSeries.slices.template.strokeOpacity = 1;


                                            // Add a legend
                                            chart.legend = new am4charts.Legend();
                                            // Enable export
                                            chart.exporting.menu = new am4core.ExportMenu();
                                            chart.exporting.menu = new am4core.ExportMenu();
                                            chart.exporting.menu.align = "left";
                                            chart.exporting.menu.verticalAlign = "top";


                                            chart.exporting.menu.items = [{
                                                "label": "<i class='fas fa-print'><i>",
                                                "menu": [{
                                                        "type": "png",
                                                        "label": "PNG"
                                                    },
                                                    {
                                                        "label": "PRINT",
                                                        "type": "print"
                                                    },
                                                    {
                                                        "type": "pdf",
                                                        "label": "PDF"
                                                    }
                                                ]
                                            }];

                                        }); // end am4core.ready()
                                    </script>
                                <?php
                                } else {
                                ?>
                                    <div id="grafica"></div>
                                <?php
                                }
                                ?>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="container">
                  

                    <p>
                        <a class="btn btn-primary" data-bs-toggle="collapse" href="#pacientes_por_sexo" role="button" aria-expanded="false" aria-controls="pacientes_por_sexo">
                            Pacientes por Sexo
                        </a>
                        <a class="btn btn-primary" data-bs-toggle="collapse" href="#pacientes_por_edad" role="button" aria-expanded="false" aria-controls="pacientes_por_edad">
                            Grupo Etario
                        </a>
                   <!--     <a class="btn btn-primary" data-bs-toggle="collapse" href="#citas_por_edad" role="button" aria-expanded="false" aria-controls="citas_por_edad">
                            Grupo etario por citas
                        </a>
                        <a class="btn btn-primary" data-bs-toggle="collapse" href="#citas_por_sexo" role="button" aria-expanded="false" aria-controls="citas_por_edad">
                            Citas por sexo
                        </a> -->
                    </p>
                    <!-- Div para la gráfica -->


                    <div class="collapse" id="pacientes_por_sexo">
                        <div class="card card-body">
                            <div class="row">
                                <div class="card">
                                    <div class="col-sm-12">
                                        <h3 style="margin-top: 20px;">Pacientes por Sexo</h3>
                                        <!--<button id="boton2" type="button" class="btn btn-success">Reporte</button>-->

                                        <?php
                                        if (isset($_GET['fechaDesdeDash']) && isset($_GET['fechaHastaDash'])) {
                                        ?>
                                            <div id="sexo_chartFechaDesdeHasta"></div>
                                            <script>
                                                am4core.ready(function() {

                                                    // Themes begin
                                                    am4core.useTheme(am4themes_animated);
                                                    // Create chart instance
                                                    var chart = am4core.create("sexo_chartFechaDesdeHasta", am4charts.PieChart);

                                                    // Add data

                                                    chart.data = <?= $datos_filtro_dashboard['tota_pacientes_sexo'] ?>
       

                                                    // Add and configure Series
                                                    var pieSeries = chart.series.push(new am4charts.PieSeries());
                                                    pieSeries.dataFields.value = "total_pacientes";
                                                    pieSeries.dataFields.category = "sexo";

                                                    // This creates initial animation
                                                    pieSeries.hiddenState.properties.opacity = 1;
                                                    pieSeries.hiddenState.properties.endAngle = -90;
                                                    pieSeries.hiddenState.properties.startAngle = -90;

                                                    // Let's cut a hole in our Pie chart the size of 40% the radius
                                                    chart.innerRadius = am4core.percent(40);

                                                    // Put a thick white border around each Slice
                                                    pieSeries.slices.template.stroke = am4core.color("#4a2abb");
                                                    pieSeries.slices.template.strokeWidth = 2;
                                                    pieSeries.slices.template.strokeOpacity = 1;


                                                    // Add a legend
                                                    chart.legend = new am4charts.Legend();
                                                    // Enable export
                                                    chart.exporting.menu = new am4core.ExportMenu();
                                                    chart.exporting.menu = new am4core.ExportMenu();
                                                    chart.exporting.menu.align = "left";
                                                    chart.exporting.menu.verticalAlign = "top";
                                                    chart.exporting.menu.items = [{
                                                        "label": "<i class='fas fa-print'><i>",
                                                        "menu": [{
                                                                "type": "png",
                                                                "label": "PNG"
                                                            },
                                                            {
                                                                "label": "PRINT",
                                                                "type": "print"
                                                            },
                                                            {
                                                                "type": "pdf",
                                                                "label": "PDF"
                                                            }
                                                        ]
                                                    }]

                                                }); // end am4core.ready()
                                            </script>
                                        <?php
                                        } else {
                                        ?>
                                            <div id="sexo_chart"></div>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="collapse" id="pacientes_por_edad">
                        <div class="row">
                            <div class="card">
                                <div class="col-sm-12">
                                    <h3 style="margin-top: 20px;">Pacientes por Edad</h3>
                                    <?php
                                        if (isset($_GET['fechaDesdeDash']) && isset($_GET['fechaHastaDash'])) {
                                        ?>
                                            <div id="edad_chartFechaDesdeHasta" style="width: 100%; height: 500px;"></div>
                                            <script>
                                                am4core.ready(function() {

                                                    // Themes begin
                                                    am4core.useTheme(am4themes_animated);
                                                    // Create chart instance
                                                    var chart = am4core.create("edad_chartFechaDesdeHasta", am4charts.PieChart);

                                                    // Add data

                                                    chart.data = <?= $datos_filtro_dashboard['total_pacientes_edad'] ?>
       

                                                    // Add and configure Series
                                                    var pieSeries = chart.series.push(new am4charts.PieSeries());
                                                    pieSeries.dataFields.value = "cantidad";
                                                    pieSeries.dataFields.category = "categoria";

                                                    // This creates initial animation
                                                    pieSeries.hiddenState.properties.opacity = 1;
                                                    pieSeries.hiddenState.properties.endAngle = -90;
                                                    pieSeries.hiddenState.properties.startAngle = -90;

                                                    // Let's cut a hole in our Pie chart the size of 40% the radius
                                                    chart.innerRadius = am4core.percent(40);

                                                    // Put a thick white border around each Slice
                                                    pieSeries.slices.template.stroke = am4core.color("#4a2abb");
                                                    pieSeries.slices.template.strokeWidth = 2;
                                                    pieSeries.slices.template.strokeOpacity = 1;


                                                    // Add a legend
                                                    chart.legend = new am4charts.Legend();
                                                    // Enable export
                                                    chart.exporting.menu = new am4core.ExportMenu();
                                                    chart.exporting.menu = new am4core.ExportMenu();
                                                    chart.exporting.menu.align = "left";
                                                    chart.exporting.menu.verticalAlign = "top";
                                                    chart.exporting.menu.items = [{
                                                        "label": "<i class='fas fa-print'><i>",
                                                        "menu": [{
                                                                "type": "png",
                                                                "label": "PNG"
                                                            },
                                                            {
                                                                "label": "PRINT",
                                                                "type": "print"
                                                            },
                                                            {
                                                                "type": "pdf",
                                                                "label": "PDF"
                                                            }
                                                        ]
                                                    }]

                                                }); // end am4core.ready()
                                            </script>
                                        <?php
                                        } else {
                                        ?>
                                            <div id="edad_chart" style="width: 100%; height: 500px;"></div>
                                        <?php
                                        }
                                        ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="collapse" id="citas_por_edad">
                        <div class="row">
                            <div class="card">
                                <div class="col-sm-12">
                                    <h3 style="margin-top: 20px;">Grupo etario por citas</h3>
                                    <?php
                                        if (isset($_GET['fechaDesdeDash']) && isset($_GET['fechaHastaDash'])) {
                                        ?>
                                            <div id="citasEdadFechaDesdeHasta" style="width: 100%; height: 500px;"></div>
                                            <script>
                                                am4core.ready(function() {

                                                    // Themes begin
                                                    am4core.useTheme(am4themes_animated);
                                                    // Create chart instance
                                                    var chart = am4core.create("citasEdadFechaDesdeHasta", am4charts.PieChart);

                                                    // Add data

                                                    chart.data = <?= $datos_filtro_dashboard['total_citas_edad'] ?>
       

                                                    // Add and configure Series
                                                    var pieSeries = chart.series.push(new am4charts.PieSeries());
                                                    pieSeries.dataFields.value = "cantidad";
                                                    pieSeries.dataFields.category = "categoria";

                                                    // This creates initial animation
                                                    pieSeries.hiddenState.properties.opacity = 1;
                                                    pieSeries.hiddenState.properties.endAngle = -90;
                                                    pieSeries.hiddenState.properties.startAngle = -90;

                                                    // Let's cut a hole in our Pie chart the size of 40% the radius
                                                    chart.innerRadius = am4core.percent(40);

                                                    // Put a thick white border around each Slice
                                                    pieSeries.slices.template.stroke = am4core.color("#4a2abb");
                                                    pieSeries.slices.template.strokeWidth = 2;
                                                    pieSeries.slices.template.strokeOpacity = 1;


                                                    // Add a legend
                                                    chart.legend = new am4charts.Legend();
                                                    // Enable export
                                                    chart.exporting.menu = new am4core.ExportMenu();
                                                    chart.exporting.menu = new am4core.ExportMenu();
                                                    chart.exporting.menu.align = "left";
                                                    chart.exporting.menu.verticalAlign = "top";
                                                    chart.exporting.menu.items = [{
                                                        "label": "<i class='fas fa-print'><i>",
                                                        "menu": [{
                                                                "type": "png",
                                                                "label": "PNG"
                                                            },
                                                            {
                                                                "label": "PRINT",
                                                                "type": "print"
                                                            },
                                                            {
                                                                "type": "pdf",
                                                                "label": "PDF"
                                                            }
                                                        ]
                                                    }]

                                                }); // end am4core.ready()
                                            </script>
                                        <?php
                                        } else {
                                        ?>
                                            <div id="chart_citas_por_edad" style="width: 100%; height: 500px;"></div>
                                        <?php
                                        }
                                        ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="collapse" id="citas_por_sexo">
                        <div class="row">
                            <div class="card">
                                <div class="col-sm-12">
                                    <h3 style="margin-top: 20px;">Citas por sexo</h3>
                                    <?php
                                        if (isset($_GET['fechaDesdeDash']) && isset($_GET['fechaHastaDash'])) {
                                        ?>
                                            <div id="citasSexoFechaDesdeHasta" style="width: 100%; height: 500px;"></div>
                                            <script>
                                                am4core.ready(function() {

                                                    // Themes begin
                                                    am4core.useTheme(am4themes_animated);
                                                    // Create chart instance
                                                    var chart = am4core.create("citasSexoFechaDesdeHasta", am4charts.PieChart);

                                                    // Add data

                                                    chart.data = <?= $datos_filtro_dashboard['total_citas_sexo'] ?>
       

                                                    // Add and configure Series
                                                    var pieSeries = chart.series.push(new am4charts.PieSeries());
                                                    pieSeries.dataFields.value = "total_sexo";
                                                    pieSeries.dataFields.category = "sexo";

                                                    // This creates initial animation
                                                    pieSeries.hiddenState.properties.opacity = 1;
                                                    pieSeries.hiddenState.properties.endAngle = -90;
                                                    pieSeries.hiddenState.properties.startAngle = -90;

                                                    // Let's cut a hole in our Pie chart the size of 40% the radius
                                                    chart.innerRadius = am4core.percent(40);

                                                    // Put a thick white border around each Slice
                                                    pieSeries.slices.template.stroke = am4core.color("#4a2abb");
                                                    pieSeries.slices.template.strokeWidth = 2;
                                                    pieSeries.slices.template.strokeOpacity = 1;


                                                    // Add a legend
                                                    chart.legend = new am4charts.Legend();
                                                    // Enable export
                                                    chart.exporting.menu = new am4core.ExportMenu();
                                                    chart.exporting.menu = new am4core.ExportMenu();
                                                    chart.exporting.menu.align = "left";
                                                    chart.exporting.menu.verticalAlign = "top";
                                                    chart.exporting.menu.items = [{
                                                        "label": "<i class='fas fa-print'><i>",
                                                        "menu": [{
                                                                "type": "png",
                                                                "label": "PNG"
                                                            },
                                                            {
                                                                "label": "PRINT",
                                                                "type": "print"
                                                            },
                                                            {
                                                                "type": "pdf",
                                                                "label": "PDF"
                                                            }
                                                        ]
                                                    }]

                                                }); // end am4core.ready()
                                            </script>
                                        <?php
                                        } else {
                                        ?>
                                            <div id="chart_citas_sexo" style="width: 100%; height: 500px;"></div>
                                        <?php
                                        }
                                        ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
</section>

<?php

?>