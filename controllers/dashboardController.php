<?php

require_once './models/dashboardModel.php';
require_once './models/UsuarioModel.php';

class dashboardController
{

        #estableciendo las vistas
        public function inicio()
        {

                session_start();

                if (isset($_SESSION['user_id'])) {
                        $id_usuario = $_SESSION['user_id'];

                        $modelUsuario = new UsuarioModel();
                        $resultado = $modelUsuario->obtenerUsuario($id_usuario);

                        if ($resultado) {
                                foreach ($resultado as $resultado) {
                                        $id_bd = $resultado['id'];
                                        $usuario_bd = $resultado['usuario'];
                                }

                                $_SESSION['usuario'] = $usuario_bd;

                                require_once('./views/includes/cabecera.php');
                                require_once('./views/paginas/dashboard/inicio.php');
                                require_once('./views/includes/pie.php');
                        } else {
                                header('Location: index.php?page=inicioUsuario');
                        }
                }
        }

        public function inicioProfile()
        {
                /*HEADER */
                require_once('./views/includes/cabecera.php');

                require_once('./views/paginas/usuarios/inicioProfile.php');

                /* FOOTER */
                require_once('./views/includes/pie.php');
        }
        public function grafica()
        {
                $modelDashboard = new dashboardModel();

                $data = $modelDashboard->grafica();

                echo json_encode($data);
        }
        public function sexo()
        {
                $modelDashboard = new dashboardModel();

                $data = $modelDashboard->sexo();

                echo json_encode($data);
        }
        public function edad()
        {
                $modelDashboard = new dashboardModel();

                $data = $modelDashboard->edad();

                echo json_encode($data);
        }

        public function todosTiposConsulta()
        {
                $modelDashboard = new dashboardModel();

                $data = $modelDashboard->todosTiposconsulta();

                echo json_encode($data);
        }

        public function chartCitasEdad()
        {
                $modelDashboard = new dashboardModel();

                $data = $modelDashboard->chartCitasEdad();

                echo json_encode($data);
        }

        public function chartCitasSexo()
        {
                $modelDashboard = new dashboardModel();

                $data = $modelDashboard->citaSexo();

                echo json_encode($data);
        }

        public function filtrarDashboard($fechaDesde, $fechaHasta)
        {
                $modelDashboard = new dashboardModel();
                //Total citas (General)
                $data_total_citas = $modelDashboard->numeroCitasFechaDesdeHasta($fechaDesde, $fechaHasta);
                //Total número de consultas
                $data_total_numero_consultas = $modelDashboard->numeroConsultasFechaDesdeHasta($fechaDesde, $fechaHasta);
                //total pacientes atendidos
                $data_total_pacientes_atendidos = $modelDashboard->pacientesAtendidosFechaDesdeHasta($fechaDesde, $fechaHasta);
                //total atendidos
                $data_total_atendidos = $modelDashboard->pacientesAtendidosGeneralFechaDesdeHasta($fechaDesde, $fechaHasta);

                //data total consultas por especialidad
                $total_consultas_especialidad = $modelDashboard->graficaFechaDesdeHasta($fechaDesde, $fechaHasta);

                //total pacientes por genero y rango de fecha
                $tota_pacientes_sexo = $modelDashboard->sexoFechaDesdeHasa($fechaDesde, $fechaHasta);

                //total_pacientes por edad y rango de fechas
                $total_pacientes_edad = $modelDashboard->edadFechaDesdehasta($fechaDesde, $fechaHasta);

                //total citas por edad y rang de fechas
                $total_citas_edad = $modelDashboard->edadFechaDesdehasta($fechaDesde, $fechaHasta);

                //total citas por edad y rang de fechas
                $total_citas_sexo = $modelDashboard->citaSexoFechaDesdeHasta($fechaDesde, $fechaHasta);

                //total consultas por motivos y rango de fecha
                $total_consultas_por_motivos = $modelDashboard->totalConsultasPorMotivosFiltroFecha($fechaDesde, $fechaHasta);

                $t_total_consultas_por_motivos = $modelDashboard->tblTotalConsultasPorMotivosFiltroFecha($fechaDesde, $fechaHasta);


                foreach ($data_total_citas as $data_total_citas) {
                        $total_citas = $data_total_citas["numeroCitas"];
                }

                foreach ($data_total_numero_consultas as $data_total_numero_consultas) {
                        $total_numero_consultas = $data_total_numero_consultas["numeroConsultas"];
                }

                foreach ($data_total_pacientes_atendidos as $data_total_pacientes_atendidos) {
                        $total_pacientes_atendidos = $data_total_pacientes_atendidos["numeroPacientesAt"];
                }

                foreach ($data_total_atendidos as $data_total_atendidos) {
                        $total_atendidos = $data_total_atendidos["total_general"];
                }

                $datos = array(
                        'total_citas'                           => $total_citas,
                        'total_numero_consultas'                => $total_numero_consultas,
                        'total_pacientes_atendidos'             => $total_pacientes_atendidos,
                        'total_atendidos'                       => $total_atendidos,
                        'total_consultas_especialidad'          => json_encode($total_consultas_especialidad),
                        'tota_pacientes_sexo'                   => json_encode($tota_pacientes_sexo),
                        'total_pacientes_edad'                  => json_encode($total_pacientes_edad),
                        'total_citas_edad'                      => json_encode($total_citas_edad),
                        'total_citas_sexo'                      => json_encode($total_citas_sexo),
                        'total_consultas_por_motivos'           => $total_consultas_por_motivos,
                        't_total_consultas_por_motivos'         => json_encode($t_total_consultas_por_motivos),
                );

                return $datos;
        }
}
