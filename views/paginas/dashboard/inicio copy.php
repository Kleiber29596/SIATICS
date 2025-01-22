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
                    <div class="row">
                        <div class="card">
                            <div class="col-sm-12">
                                <h3 style="margin-top: 20px;">Tipos de Consultas</h3>
                                <!-- Filtrar grafica por fecha -->

                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="fechaDesde">Fecha desde</label>
                                            <input id="fechaDesde" class="form-control" type="date">
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="fechaHasta">Fecha hasta</label>
                                            <input id="fechaHasta" class="form-control" type="date">
                                        </div>
                                    </div>

                                    <!-- <div class="col-sm-4">
                                        <label for="tipoConsulta">Tipo de consulta:</label>
                                        <select class="form-control" id="tipoConsulta">
                                            <option value="">Seleccione...</option>
                                            <?php
                                            foreach ($tipos_consultas as $tipos_consultas) {
                                            ?>
                                                <option value="<?= $tipos_consultas['id_tipo_consulta'] ?>"><?= $tipos_consultas['motivo'] ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div> -->

                                    <div class="col-sm-2" style="display: flex; justify-content: center; align-items: end;">
                                        <button id="btnFiltroFechaDesdeHasta"
                                            type="button"
                                            class="btn btn-primary"
                                            onclick="filtrarGraficaFechaDesdeHasta()"
                                            href="">
                                            Filtrar <i class="bi bi-filter"></i>
                                        </button>
                                    </div>
                                </div>
                                <!-- Fin Filtrar grafica por fecha -->
                                <?php
                                if (isset($_GET['fechaDesde']) && isset($_GET['fechaHasta'])) {
                                ?>
                                    <div style="margin-top: 20px;" id="graficaFiltroFechaDesdeHasta"></div>


                                    <script>
                                        //TODOS LOS TIPOS DE CONSULTAS Y EL NÚMERO DE CONSULTAS FILTRADO POR FECHA

                                        // Themes begin
                                        am4core.useTheme(am4themes_animated);
                                        // Themes end

                                        let iconPath = "M53.5,476c0,14,6.833,21,20.5,21s20.5-7,20.5-21V287h21v189c0,14,6.834,21,20.5,21 c13.667,0,20.5-7,20.5-21V154h10v116c0,7.334,2.5,12.667,7.5,16s10.167,3.333,15.5,0s8-8.667,8-16V145c0-13.334-4.5-23.667-13.5-31 s-21.5-11-37.5-11h-82c-15.333,0-27.833,3.333-37.5,10s-14.5,17-14.5,31v133c0,6,2.667,10.333,8,13s10.5,2.667,15.5,0s7.5-7,7.5-13 V154h10V476 M61.5,42.5c0,11.667,4.167,21.667,12.5,30S92.333,85,104,85s21.667-4.167,30-12.5S146.5,54,146.5,42 c0-11.335-4.167-21.168-12.5-29.5C125.667,4.167,115.667,0,104,0S82.333,4.167,74,12.5S61.5,30.833,61.5,42.5z"



                                        let chart = am4core.create("graficaFiltroFechaDesdeHasta", am4charts.SlicedChart);
                                        chart.hiddenState.properties.opacity = 0; // this makes initial fade in effect

                                        chart.data = <?= $datos_filtro_grafica ?>

                                        let series = chart.series.push(new am4charts.PictorialStackedSeries());
                                        series.dataFields.value = "numero_consultas";
                                        series.dataFields.category = "motivo";
                                        series.alignLabels = true;

                                        series.maskSprite.path = iconPath;
                                        series.ticks.template.locationX = 1;
                                        series.ticks.template.locationY = 0.5;

                                        series.labelsContainer.width = 200;

                                        chart.legend = new am4charts.Legend();
                                        chart.legend.position = "left";
                                        chart.legend.valign = "bottom";
                                    </script>
                                    <!-- TODOS LOS TIPOS DE CONSULTAS Y EL NÚMERO DE CONSULTAS FILTRADO POR FECHA -->
                                <?php
                                } else {
                                ?>
                                    <div id="grafica_tipos_consultas"></div>

                                    <script>
                                        //TODOS LOS TIPOS DE CONSULTAS Y EL NÚMERO DE CONSULTAS

                                        /* Chart code */
                                        // Themes begin
                                        am4core.useTheme(am4themes_animated);
                                        // Themes end

                                        let iconPathh = "M53.5,476c0,14,6.833,21,20.5,21s20.5-7,20.5-21V287h21v189c0,14,6.834,21,20.5,21 c13.667,0,20.5-7,20.5-21V154h10v116c0,7.334,2.5,12.667,7.5,16s10.167,3.333,15.5,0s8-8.667,8-16V145c0-13.334-4.5-23.667-13.5-31 s-21.5-11-37.5-11h-82c-15.333,0-27.833,3.333-37.5,10s-14.5,17-14.5,31v133c0,6,2.667,10.333,8,13s10.5,2.667,15.5,0s7.5-7,7.5-13 V154h10V476 M61.5,42.5c0,11.667,4.167,21.667,12.5,30S92.333,85,104,85s21.667-4.167,30-12.5S146.5,54,146.5,42 c0-11.335-4.167-21.168-12.5-29.5C125.667,4.167,115.667,0,104,0S82.333,4.167,74,12.5S61.5,30.833,61.5,42.5z"



                                        let chart = am4core.create("grafica_tipos_consultas", am4charts.SlicedChart);
                                        chart.hiddenState.properties.opacity = 0; // this makes initial fade in effect

                                        let url = 'http://localhost/SIATICS/index.php?page=todosTiposConsulta';
                                        fetch(url)
                                            .then(response => response.json())
                                            .then(datos => mostrar(datos))
                                            .catch(e => console.log(e))

                                        const mostrar = (articulos) => {
                                            articulos.forEach(element => {
                                                chart.data.push(element.numero_consultas)
                                            });
                                            chart.data = articulos
                                            console.log(chart.data)

                                        }

                                        let series = chart.series.push(new am4charts.PictorialStackedSeries());
                                        series.dataFields.value = "numero_consultas";
                                        series.dataFields.category = "motivo";
                                        series.alignLabels = true;

                                        series.maskSprite.path = iconPathh;
                                        series.ticks.template.locationX = 1;
                                        series.ticks.template.locationY = 0.5;

                                        series.labelsContainer.width = 200;

                                        chart.legend = new am4charts.Legend();
                                        chart.legend.position = "left";
                                        chart.legend.valign = "bottom";
                                    </script>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                    <p>
                        <a class="btn btn-primary" data-bs-toggle="collapse" href="#pacientes_por_sexo" role="button" aria-expanded="false" aria-controls="pacientes_por_sexo">
                            Pacientes por Sexo
                        </a>
                        <a class="btn btn-primary" data-bs-toggle="collapse" href="#pacientes_por_edad" role="button" aria-expanded="false" aria-controls="pacientes_por_edad">
                            Pacientes por edad
                        </a>
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
                </div>
            </div>
</section>

<?php

?>