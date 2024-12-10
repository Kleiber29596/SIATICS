<?php

require_once 'models/dashboardModel.php';
require_once 'models/ConsultasModel.php';


$dashboardModel = new dashboardModel();
$modelConsultas = new ConsultasModel();


$tipos_consultas = $modelConsultas->SelectTipos();

if (isset($_GET['fechaDesde']) && isset($_GET['fechaHasta']) && isset($_GET['tipoConsulta'])) {
    $datos_filtro_grafica = $dashboardModel->fechaDesdeHastaTipoConsulta($_GET['fechaDesde'], $_GET['fechaHasta'], $_GET['tipoConsulta']);
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
                                    <h6> <?php echo $numeroCitas; ?></h6>


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
                                    <h6><?php echo $numeroConsultas; ?></h6>


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
                                    <h6><?php echo $numeroPacientesAt; ?></h6>
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
                                    <h6> <?php echo $generalAtendidos; ?></h6>
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
                                <div id="grafica"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card info-card revenue-card">
                            <div class="card-body">
                                <h5 class="card-title">Filtrar grafica por fecha y tipo de consulta<span></span></h5>
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

                                    <div class="col-sm-4">
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
                                    </div>

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

                                    <!-- <script>
                  am4core.ready(function() {
                    // Create chart instance
                    var chart = am4core.create("graficaFiltroFechaDesdeHasta", am4charts.PieChart);

                    // Add data

                    const mostrar = (articulos) => {
                      articulos.forEach((element) => {
                        chart.data.push(element.especie_presentacion);
                      });
                      chart.data = articulos;
                      console.log(chart.data);
                    };

                    mostrar(<?= $datos_filtro_grafica ?>)

                    

                    // Add and configure Series
                    var pieSeries = chart.series.push(new am4charts.PieSeries());
                    pieSeries.dataFields.value = "total_entradas";
                    pieSeries.dataFields.category = "especie_presentacion";

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
                  });
                </script> -->
                                    <script>
                                        am4core.ready(function() {

                                            // Themes begin
                                            am4core.useTheme(am4themes_animated);
                                            // Themes end

                                            // Create chart instance
                                            var chart = am4core.create("graficaFiltroFechaDesdeHasta", am4charts.XYChart);
                                            chart.scrollbarX = new am4core.Scrollbar();

                                            // Add data
                                            chart.data = <?= $datos_filtro_grafica ?>;


                                            prepareParetoData();

                                            function prepareParetoData() {
                                                var total = 0;

                                                for (var i = 0; i < chart.data.length; i++) {
                                                    var value = chart.data[i].total_entradas;
                                                    total += value;
                                                }

                                                var sum = 0;
                                                for (var i = 0; i < chart.data.length; i++) {
                                                    var value = chart.data[i].total_entradas;
                                                    sum += value;
                                                    chart.data[i].pareto = sum / total * 100;
                                                }
                                            }

                                            // Create axes
                                            var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
                                            categoryAxis.dataFields.category = "motivo";
                                            categoryAxis.renderer.grid.template.location = 0;
                                            categoryAxis.renderer.minGridDistance = 60;
                                            categoryAxis.tooltip.disabled = true;

                                            var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
                                            valueAxis.renderer.minWidth = 50;
                                            valueAxis.min = 0;
                                            valueAxis.cursorTooltipEnabled = false;

                                            // Create series
                                            var series = chart.series.push(new am4charts.ColumnSeries());
                                            series.sequencedInterpolation = true;
                                            series.dataFields.valueY = "numero_consultas";
                                            series.dataFields.categoryX = "motivo";
                                            series.tooltipText = "[{categoryX}: bold]{valueY}[/]";
                                            series.columns.template.strokeWidth = 0;

                                            series.tooltip.pointerOrientation = "vertical";

                                            series.columns.template.column.cornerRadiusTopLeft = 10;
                                            series.columns.template.column.cornerRadiusTopRight = 10;
                                            series.columns.template.column.fillOpacity = 0.8;

                                            // on hover, make corner radiuses bigger
                                            var hoverState = series.columns.template.column.states.create("hover");
                                            hoverState.properties.cornerRadiusTopLeft = 0;
                                            hoverState.properties.cornerRadiusTopRight = 0;
                                            hoverState.properties.fillOpacity = 1;

                                            series.columns.template.adapter.add("fill", function(fill, target) {
                                                return chart.colors.getIndex(target.dataItem.index);
                                            })


                                            var paretoValueAxis = chart.yAxes.push(new am4charts.ValueAxis());
                                            paretoValueAxis.renderer.opposite = true;
                                            paretoValueAxis.min = 0;
                                            paretoValueAxis.max = 100;
                                            paretoValueAxis.strictMinMax = true;
                                            paretoValueAxis.renderer.grid.template.disabled = true;
                                            paretoValueAxis.numberFormatter = new am4core.NumberFormatter();
                                            paretoValueAxis.numberFormatter.numberFormat = "#'%'"
                                            paretoValueAxis.cursorTooltipEnabled = false;

                                            var paretoSeries = chart.series.push(new am4charts.LineSeries())
                                            paretoSeries.dataFields.valueY = "pareto";
                                            paretoSeries.dataFields.categoryX = "motivo";
                                            paretoSeries.yAxis = paretoValueAxis;
                                            paretoSeries.tooltipText = "pareto: {valueY.formatNumber('#.0')}%[/]";
                                            paretoSeries.bullets.push(new am4charts.CircleBullet());
                                            paretoSeries.strokeWidth = 2;
                                            paretoSeries.stroke = new am4core.InterfaceColorSet().getFor("alternativeBackground");
                                            paretoSeries.strokeOpacity = 0.5;

                                            // Cursor
                                            chart.cursor = new am4charts.XYCursor();
                                            chart.cursor.behavior = "panX";

                                            // Enable export
                                            chart.exporting.menu = new am4core.ExportMenu();
                                            chart.exporting.menu.align = "left";
                                            chart.exporting.menu.verticalAlign = "top";



                                        }); // end am4core.ready()
                                    </script>

                                <?php
                                } else {
                                ?>
                                    <div style="margin-top: 20px;" id="grafica"></div>

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
                                <!--<button id="boton1" type="button" class="btn btn-success">Reporte</button> --->
                                <div id="grafica_desde_hasta_tipo_consulta"></div>
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
                                        <div id="sexo_chart"></div>
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

                                    <div id="edad_chart" style="width: 100%; height: 500px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
</section>

<?php

?>