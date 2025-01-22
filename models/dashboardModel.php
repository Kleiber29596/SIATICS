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
        // $query = "SELECT count(*) as numeroCitas from citas;";
        $query = "SELECT COUNT(*) AS numeroCitas
        FROM citas
        WHERE fecha_cita = CURDATE();";
        $resultado = $db->obtenerTodos($query);
        return $resultado;
    }

    /*------------Metodo para contar citas a traves de un rango de fechas -------*/
    public function numeroCitasFechaDesdeHasta($fechaDesde, $fechaHasta)
    {
        $db = new ModeloBase();
        $query = "SELECT COUNT(*) AS numeroCitas
                  FROM citas
                  WHERE fecha_cita BETWEEN '$fechaDesde' AND '$fechaHasta';";
        $resultado = $db->obtenerTodos($query);
        return $resultado;
    }

    /*------------Metodo para contar el número de consultas-------*/
    public function numeroConsultas()
    {
        $db = new ModeloBase();
        // $query = "SELECT count(*) as numeroConsultas from consultas;";
        $query = "SELECT count(*) as numeroConsultas from consultas WHERE fecha_registro = CURDATE();";

        $resultado = $db->obtenerTodos($query);
        return $resultado;
    }

    /*------------Metodo para contar el número de consultas a traves de un rango de fechas -------*/
    public function numeroConsultasFechaDesdeHasta($fechaDesde, $fechaHasta)
    {
        $db = new ModeloBase();

        $query = "SELECT COUNT(*) AS numeroConsultas
                  FROM consultas
                  WHERE fecha_registro BETWEEN '$fechaDesde' AND '$fechaHasta';";
        $resultado = $db->obtenerTodos($query);
        return $resultado;
    }

    /*------------Metodo para contar pacientes atendidos-------*/
    public function pacientesAtendidos()
    {
        $db = new ModeloBase();
        // $query = "SELECT count(*) as numeroPacientesAt from citas where estatus=0;";
        $query = "SELECT count(*) as numeroPacientesAt from citas where estatus=0 AND fecha_registro = CURDATE();";
        $resultado = $db->obtenerTodos($query);
        return $resultado;
    }

    /*------------Metodo para contar pacientes atendidos a traves de un rango de fechas -------*/
    public function pacientesAtendidosFechaDesdeHasta($fechaDesde, $fechaHasta)
    {
        $db = new ModeloBase();
        $query = "SELECT COUNT(*) AS numeroPacientesAt
                    FROM citas
                    WHERE estatus = 0
                    AND fecha_registro BETWEEN '$fechaDesde' AND '$fechaHasta';";
        $resultado = $db->obtenerTodos($query);
        return $resultado;
    }

    /*------------Metodo pacientes atendidos hoy-------*/
    public function pacientesAtendidosGeneral()
    {
        $db = new ModeloBase();
        //     $query = "SELECT 
        // (SELECT COUNT(*) FROM citas WHERE estatus = 0) AS total_citas_estatus_0,
        // (SELECT COUNT(*) FROM consultas) AS total_consultas,
        // (SELECT COUNT(*) FROM citas WHERE estatus = 0) + (SELECT COUNT(*) FROM consultas) AS total_general
        // FROM dual;";
        $query = "SELECT 
        (SELECT COUNT(*) FROM citas WHERE estatus = 0 AND fecha_registro = CURDATE()) AS total_citas_estatus_0,
        (SELECT COUNT(*) FROM consultas WHERE fecha_registro = CURDATE()) AS total_consultas,
        (SELECT COUNT(*) FROM citas WHERE estatus = 0 AND fecha_registro = CURDATE()) + (SELECT COUNT(*) FROM consultas WHERE fecha_registro = CURDATE()) AS total_general
        FROM dual;";
        $resultado = $db->obtenerTodos($query);
        return $resultado;
    }

    /*------------Metodo pacientes atendidos a traves de un rango de fechas-------*/
    public function pacientesAtendidosGeneralFechaDesdeHasta($fechaDesde, $fechaHasta)
    {
        $db = new ModeloBase();
        $query = "SELECT 
                (SELECT COUNT(*) FROM citas WHERE estatus = 0 AND fecha_registro BETWEEN '$fechaDesde' AND '$fechaHasta') AS total_citas_estatus_0,
                (SELECT COUNT(*) FROM consultas WHERE fecha_registro BETWEEN '$fechaDesde' AND '$fechaHasta') AS total_consultas,
                (SELECT COUNT(*) FROM citas WHERE estatus = 0 AND fecha_registro BETWEEN '$fechaDesde' AND '$fechaHasta') + 
                (SELECT COUNT(*) FROM consultas WHERE fecha_registro BETWEEN '$fechaDesde' AND '$fechaHasta') AS total_general
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
                    WHERE consultas.fecha_registro=CURDATE()
                    GROUP BY especialidad.nombre_especialidad";
        $resultado = $db->FectAll($query);
        return $resultado;
    }

    /*------------Metodo para graficas a traves de un rango de fechas--------*/

    public function graficaFechaDesdeHasta($fechaDesde, $fechaHasta)
    {
        $db = new ModeloBase();
        $query = "SELECT especialidad.nombre_especialidad, 
                    COUNT(*) AS total_consulta_especialidad
                    FROM 
                        consultas
                    JOIN 
                        especialidad ON consultas.id_especialidad = especialidad.id_especialidad
                    WHERE 
                        consultas.fecha_registro BETWEEN '$fechaDesde' AND '$fechaHasta'
                    GROUP BY 
                        especialidad.nombre_especialidad;";
        $resultado = $db->FectAll($query);
        return $resultado;
    }

    public function sexo()
    {
        $db = new ModeloBase();
        // $query = "SELECT sexo, COUNT(*) AS total_sexo
        //             FROM personas
        //             GROUP BY sexo";
        $query = "SELECT personas.sexo, COUNT(*) AS total_sexo FROM consultas AS consultas
                    JOIN personas AS personas
                    ON consultas.id_persona=personas.id_persona
                    WHERE consultas.fecha_registro=CURDATE()
                    GROUP BY personas.sexo";
        $resultado = $db->FectAll($query);
        return $resultado;
    }

    public function citaSexo()
    {
        $db = new ModeloBase();
        $query = "SELECT personas.sexo, COUNT(*) AS total_sexo FROM consultas AS consultas
                    JOIN personas AS personas
                    ON consultas.id_persona=personas.id_persona
                    JOIN especialidad as especialidad
                    ON consultas.id_especialidad=especialidad.id_especialidad
                    WHERE consultas.fecha_registro=CURDATE() AND especialidad.modalidad='Por cita'
                    GROUP BY personas.sexo";
        $resultado = $db->FectAll($query);
        return $resultado;
    }

    public function citaSexoFechaDesdeHasta($fechaDesde, $fechaHasta)
    {
        $db = new ModeloBase();
        $query = "SELECT personas.sexo, COUNT(*) AS total_sexo FROM consultas AS consultas
                    JOIN personas AS personas
                    ON consultas.id_persona=personas.id_persona
                    JOIN especialidad as especialidad
                    ON consultas.id_especialidad=especialidad.id_especialidad
                    WHERE consultas.fecha_registro BETWEEN '$fechaDesde' AND '$fechaHasta' AND especialidad.modalidad='Por cita'
                    GROUP BY personas.sexo";
        $resultado = $db->FectAll($query);
        return $resultado;
    }

    //Metodo que permite filtrar el número de pacientes que asisten a consultas por sexo (M, F) y por rango de fecha
    public function sexoFechaDesdeHasa($fechaDesde, $fechaHasta)
    {
        $db = new ModeloBase();
        $query = "SELECT 
                    p.sexo, 
                    COUNT(*) AS total_pacientes
                FROM 
                    consultas c
                JOIN 
                    personas p ON c.id_persona = p.id_persona
                WHERE 
                    c.fecha_registro BETWEEN '$fechaDesde' AND '$fechaHasta'  -- Ajusta las fechas según sea necesario
                GROUP BY 
                    p.sexo;";
                        $resultado = $db->FectAll($query);
        return $resultado;
    }

    public function edad()
    {
        $db = new ModeloBase();
        // $query = "SELECT 
        //             CASE 
        //                 WHEN TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) <= 12 THEN 'Niño'
        //                 WHEN TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) BETWEEN 13 AND 17 THEN 'Adolescente'
        //                 WHEN TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) BETWEEN 18 AND 54 THEN 'Adulto'
        //                 WHEN TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) >= 55 THEN 'Adulto Mayor'
        //             END AS categoria,
        //             COUNT(*) AS cantidad
        //             FROM 
        //                 personas
                    
        //             WHERE personas.fecha_registro=CURDATE()
        //             GROUP BY 
        //                 categoria
        //             ORDER BY 
        //                 categoria ASC;
        //                     ";
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
                    JOIN consultas 
                    ON consultas.id_persona=personas.id_persona
                    WHERE consultas.fecha_registro=CURDATE()
                    GROUP BY 
                        categoria
                    ORDER BY 
                        categoria ASC;";
        $resultado = $db->FectAll($query);
        return $resultado;
    }

    public function edadFechaDesdehasta($fechaDesde, $fechaHasta)
    {
        $db = new ModeloBase();
        $query = "SELECT 
                    CASE 
                        WHEN TIMESTAMPDIFF(YEAR, p.fecha_nacimiento, CURDATE()) <= 12 THEN 'Niño'
                        WHEN TIMESTAMPDIFF(YEAR, p.fecha_nacimiento, CURDATE()) BETWEEN 13 AND 17 THEN 'Adolescente'
                        WHEN TIMESTAMPDIFF(YEAR, p.fecha_nacimiento, CURDATE()) BETWEEN 18 AND 54 THEN 'Adulto'
                        WHEN TIMESTAMPDIFF(YEAR, p.fecha_nacimiento, CURDATE()) >= 55 THEN 'Adulto Mayor'
                    END AS categoria,
                    COUNT(*) AS cantidad
                FROM 
                    consultas c
                JOIN 
                    personas p ON c.id_persona = p.id_persona
                WHERE 
                    c.fecha_registro BETWEEN '$fechaDesde' AND '$fechaHasta'  -- Ajusta las fechas según sea necesario
                GROUP BY 
                    categoria";
        $resultado = $db->FectAll($query);
        return $resultado;
    }

    public function citasEdadFechaDesdehasta($fechaDesde, $fechaHasta)
    {
        $db = new ModeloBase();
        $query = "SELECT 
                    CASE 
                        WHEN TIMESTAMPDIFF(YEAR, personas.fecha_nacimiento, CURDATE()) <= 12 THEN 'Niño'
                        WHEN TIMESTAMPDIFF(YEAR, personas.fecha_nacimiento, CURDATE()) BETWEEN 13 AND 17 THEN 'Adolescente'
                        WHEN TIMESTAMPDIFF(YEAR, personas.fecha_nacimiento, CURDATE()) BETWEEN 18 AND 54 THEN 'Adulto'
                        WHEN TIMESTAMPDIFF(YEAR, personas.fecha_nacimiento, CURDATE()) >= 55 THEN 'Adulto Mayor'
                    END AS categoria,
                    COUNT(*) AS cantidad
                    FROM 
                        consultas as consultas
                    JOIN especialidad as especialidad
                    ON consultas.id_especialidad=especialidad.id_especialidad
                    JOIN personas as personas
                    ON consultas.id_persona=personas.id_persona
                     WHERE 
                     consultas.fecha_registro BETWEEN '$fechaDesde' AND '$fechaHasta'
                    AND especialidad.modalidad='Por cita'
                    GROUP BY 
                        categoria
                    ORDER BY 
                        categoria ASC;";
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

    public function chartCitasEdad()
    {

        $db = new ModeloBase();
        $query = "SELECT 
                    CASE 
                        WHEN TIMESTAMPDIFF(YEAR, personas.fecha_nacimiento, CURDATE()) <= 12 THEN 'Niño'
                        WHEN TIMESTAMPDIFF(YEAR, personas.fecha_nacimiento, CURDATE()) BETWEEN 13 AND 17 THEN 'Adolescente'
                        WHEN TIMESTAMPDIFF(YEAR, personas.fecha_nacimiento, CURDATE()) BETWEEN 18 AND 54 THEN 'Adulto'
                        WHEN TIMESTAMPDIFF(YEAR, personas.fecha_nacimiento, CURDATE()) >= 55 THEN 'Adulto Mayor'
                    END AS categoria,
                    COUNT(*) AS cantidad
                    FROM 
                        consultas as consultas
                    JOIN especialidad as especialidad
                    ON consultas.id_especialidad=especialidad.id_especialidad
                    JOIN personas as personas
                    ON consultas.id_persona=personas.id_persona
                    WHERE consultas.fecha_registro=CURDATE()
                    AND especialidad.modalidad='Por cita'
                    GROUP BY 
                        categoria
                    ORDER BY 
                        categoria ASC;
                ";

        $resultado = $db->FectAll($query);

        return $resultado;
    }
}
