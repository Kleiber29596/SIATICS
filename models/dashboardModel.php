<?php

require_once 'ModeloBase.php';

class dashboardModel extends ModeloBase
{

    public function __construct()
    {
        parent::__construct();
    }

    /*------------Metodo para contar citas-------*/
    public function numeroCitas()
    {
        $db = new ModeloBase();
        $query = "SELECT count(*) as numeroCitas from citas;";
        $resultado = $db->obtenerTodos($query);
        return $resultado;
    }

    /*------------Metodo para contar consultas-------*/
    public function numeroConsultas()
    {
        $db = new ModeloBase();
        $query = "SELECT count(*) as numeroConsultas from consultas;";
        $resultado = $db->obtenerTodos($query);
        return $resultado;
    }

    /*------------Metodo para contar pacientes atendidos-------*/
    public function pacientesAtendidos()
    {
        $db = new ModeloBase();
        $query = "SELECT count(*) as numeroPacientesAt from citas where estatus=0;";
        $resultado = $db->obtenerTodos($query);
        return $resultado;
    }

    /*------------Metodo pacientes atendidos hoy-------*/
    public function pacientesAtendidosGeneral()
    {
        $db = new ModeloBase();
        $query = "SELECT 
    (SELECT COUNT(*) FROM citas WHERE estatus = 0) AS total_citas_estatus_0,
    (SELECT COUNT(*) FROM consultas) AS total_consultas,
    (SELECT COUNT(*) FROM citas WHERE estatus = 0) + (SELECT COUNT(*) FROM consultas) AS total_general
    FROM dual;";
        $resultado = $db->obtenerTodos($query);
        return $resultado;
    }

    /*------------Metodo para graficas--------*/

    public function grafica()
    {
        $db = new ModeloBase();
        $query = "SELECT especialidad.nombre_especialidad, COUNT(*) AS total_consulta_especialidad
                    FROM consultas
                    JOIN especialidad ON consultas.id_especialidad = especialidad.id_especialidad
                    GROUP BY especialidad.nombre_especialidad";
        $resultado = $db->FectAll($query);
        return $resultado;
    }
    public function sexo()
    {
        $db = new ModeloBase();
        $query = "SELECT sexo, COUNT(*) AS total_sexo
                    FROM personas
                    GROUP BY sexo";
        $resultado = $db->FectAll($query);
        return $resultado;
    }
    public function edad()
    {
        $db = new ModeloBase();
        $query = "SELECT 
                    CASE 
                        WHEN TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) <= 12 THEN 'Niño'
                        WHEN TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) BETWEEN 13 AND 17 THEN 'Adolescente'
                        WHEN TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) BETWEEN 18 AND 54 THEN 'Adulto'
                        WHEN TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) >= 55 THEN 'Adulto Mayor'
                    END AS categoria,
                    COUNT(*) AS cantidad
                    FROM 
                        personas
                    GROUP BY 
                        categoria
                    ORDER BY 
                        categoria ASC;
                            ";
        $resultado = $db->FectAll($query);
        return $resultado;
    }

    public function fechaDesdeHastaTipoConsulta($fechaDesde, $fechaHasta)
    {

        $db = new ModeloBase();
        $query = " SELECT tipo_consulta.motivo, COUNT(consultas.id) AS numero_consultas
                    FROM consultas AS consultas
                    JOIN tipo_consulta AS tipo_consulta ON consultas.id_tipo_consulta = tipo_consulta.id_tipo_consulta
                    WHERE consultas.fecha_registro BETWEEN '$fechaDesde' AND '$fechaHasta'
                    GROUP BY tipo_consulta.motivo;
                ";

        $resultado = $db->FectAll($query);
        
        return json_encode($resultado);
    }

    public function todosTiposconsulta()
    {

        $db = new ModeloBase();
        $query = " SELECT tipo_consulta.motivo, COUNT(consultas.id) AS numero_consultas
                    FROM consultas AS consultas
                    JOIN tipo_consulta AS tipo_consulta ON consultas.id_tipo_consulta = tipo_consulta.id_tipo_consulta
                    GROUP BY tipo_consulta.motivo;
                ";

        $resultado = $db->FectAll($query);
        
        return $resultado;
    }
}