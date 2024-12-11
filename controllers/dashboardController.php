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

        public function filtro()
        {

                $modelDashboard = new dashboardModel();

                // Asegúrate de recibir el contenido JSON del cuerpo de la solicitud
                $data = json_decode(file_get_contents('php://input'), true);

                if ($data) {

                        $fechaDesde = $data[0];
                        $fechaHasta = $data[1];
                        $id_tipo_consulta = intval($data[2]);

                        $data = $modelDashboard->fechaDesdeHastaTipoConsulta($fechaDesde, $fechaHasta, $id_tipo_consulta);

                        echo json_encode($data);

                } else {
                        echo json_encode(['error' => 'No se recibieron datos']);
                }
        }

        public function todosTiposConsulta()
        {
                $modelDashboard = new dashboardModel();

                $data = $modelDashboard->todosTiposconsulta();

                echo json_encode($data);
        }
}