<?php

if (session_status() === PHP_SESSION_ACTIVE) {
    //echo "La sesión está activa.";
    $usuario            = $_SESSION['usuario'];
    $id_usuario         = $_SESSION['user_id'];
    $foto               = $_SESSION['foto'];
    $rol                = $_SESSION['rol_usuario'];
    $id_especialidad    = $_SESSION['id_especialidad'];
    $id_doctor          = $_SESSION['id_doctor'];
   


    if (empty($usuario) && empty($id_usuario)) {
        // Redireccionar a la página "nueva_pagina.php"
        header("Location: http://localhost/SIATICS/index.php?page=inicioUsuario");
        exit; // Asegúrate de terminar la ejecución del código después de la redirección
    }
} else {
    //echo "La sesión no está activa.";
    session_start();
    $usuario            = $_SESSION['usuario'];
    $id_usuario         = $_SESSION['user_id'];
    $foto               = $_SESSION['foto'];
    $rol                = $_SESSION['rol_usuario'];
    $id_especialidad    = $_SESSION['id_especialidad'];
    $id_doctor          = $_SESSION['id_doctor'];

    
    if (empty($usuario) && empty($id_usuario)) {
        // Redireccionar a la página "nueva_pagina.php"
        header("Location: http://localhost/SIATICS/index.php?page=inicioUsuario");
        exit; // Asegúrate de terminar la ejecución del código después de la redirección
    }

}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>SIATICS | INICIO</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="libs/img/favicon.ico" rel="icon">
    <link href="libs/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="libs/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="libs/vendor/datatables/bootstrap.min.css" rel="stylesheet">
    <link href="libs/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="libs/vendor/datatables/dataTables.bootstrap5.css" rel="stylesheet">
    <link href="libs/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="libs/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="libs/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="libs/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="libs/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="libs/vendor/fontawesome/css/all.min.css" rel="stylesheet">
    <link href="libs/vendor/select2/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Template Main CSS File -->
    <link href="libs/css/style.css" rel="stylesheet">
    <!-- Estilos de la validacion de formulario -->
    <link href="libs/css/validacion.css" rel="stylesheet">
    <!-- librerias del calendario -->
    <!--<link href="libs/vendor/calendar/bootstrap.min.css" rel="stylesheet">-->
    <link href="libs/vendor/calendar/fullcalendar.css" rel="stylesheet">
    <script src="libs/vendor/calendar/jquery.min.js"></script>
    <script src="libs/vendor/calendar/moment.min.js"></script>
    <script src="libs/vendor/calendar/fullcalendar.min.js"></script>
    <script src="libs/vendor/calendar/bootstrap.min.js"></script>
    <!-- AmChart Js -->
    <script src="https://cdn.amcharts.com/lib/4/core.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/themes/dark.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>
</head>

<body>

    <style>
        #grafica, 
        #grafica_tipos_consultas, 
        #grafica_consultas_doctores, 
        #sexo_chart, 
        #edad_chart,
        #graficaFiltroFechaDesdeHasta,
        #graficaFechaDesdehasta,
        #sexo_chartFechaDesdeHasta {
            width: 100%;
            height: 500px;
        }

    </style>

    <!-- Loader -->
    <div class="cont-loader" id="cont-loader">
        <div class="custom-loader"></div>
    </div>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="#" class="logo d-flex align-items-center">
                <!--<img src="libs/img/logo-caritas.jpg" alt="">
                    style="    max-height: 117px;margin-left: -3px;margin-top: 11px; width: 60%; height:80px;">-->
                <!--     <img src="libs/img/logo.png" alt="" style="max-height: 68px;">
                -->
                <!-- <span class="d-none d-lg-block">Jornadas De Ferias</span> -->
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->


        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">

                <li class="nav-item d-block d-lg-none">
                    <a class="nav-link nav-icon search-bar-toggle " href="#">
                        <i class="bi bi-search"></i>
                    </a>
                </li><!-- End Search Icon-->




                <li class="nav-item dropdown pe-3">

                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <img src="<?= SERVERURL ?>foto_usuario/<?= $foto ?>" alt="Profile" class="rounded-circle">
                        <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $usuario ?></span>
                    </a><!-- End Profile Iamge Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6><?php echo $usuario ?></h6>
                            <span><?php echo $rol ?></span>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>


                        <li>
                            <hr class="dropdown-divider">
                        </li>


                        <li>

                            <a class="dropdown-item d-flex align-items-center"
                                href="<?= SERVERURL ?>index.php?page=inicioUsuario">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Cerrar sesion</span>
                            </a>
                        </li>

                    </ul><!-- End Profile Dropdown Items -->
                </li><!-- End Profile Nav -->

            </ul>
        </nav><!-- End Icons Navigation -->

    </header><!-- End Header -->

    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">

        <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-item">
                <a class="nav-link collapsed" href="<?= SERVERURL ?>index.php?page=inicio">
                    <i class="bi bi-grid"></i>
                    <span>Panel</span>
                </a>
            </li><!-- Modulos-->

            <li class="nav-item">
                <a class="nav-link collapsed" href="<?= SERVERURL ?>index.php?page=inicioPersonas">
                    <i class="bi bi-person"></i>
                    <span>Personas</span>
                </a>
            </li><!-- End usuarios Page Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-menu-button-wide"></i><span>Salud</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a class="nav-link collapsed" href="<?= SERVERURL ?>index.php?page=inicioConsultas">
                            <i class="bi bi-circle"></i><span>Consultas</span>
                        </a>
                    </li>

                    <li>
                        <a class="nav-link collapsed" href="<?= SERVERURL ?>index.php?page=inicioCitas">
                            <i class="bi bi-circle"></i><span>Citas</span>
                        </a>
                    </li>


                </ul>
            </li><!-- End Ferias Nav -->



            <li class="nav-heading">Configuracion</li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="<?= SERVERURL ?>index.php?page=ModuloUsuario">
                    <i class="bi bi-person"></i>
                    <span>Usuarios</span>
                </a>
            </li><!-- End usuarios Page Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="<?= SERVERURL ?>index.php?page=inicioRoles">
                    <i class="bi bi-lock"></i> <span>Roles</span>
                </a>
            </li><!-- End Roles Page Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="<?= SERVERURL ?>index.php?page=inicioEspecialidad">
                    <i class="bi bi-lock"></i> <span>Especialidades</span>
                </a>
            </li><!-- End Especialidades Page Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="<?= SERVERURL ?>index.php?page=inicioMotivos">
                    <i class="bi bi-lock"></i> <span>Motivos</span>
                </a>
            </li><!-- End Especialidades Page Nav -->

        </ul>

    </aside><!-- End Sidebar-->

    <main id="main" class="main">