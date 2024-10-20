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
/*------------Metodo para listar Especies--------*/
    public function totalEquivUSD()
    {
        $db = new ModeloBase();
        $query = "SELECT FORMAT(SUM(equiv_usd), 2) AS totalEquivUSD FROM cierre_jornada;";
        $resultado = $db->obtenerTodos($query);
        return $resultado;
    }

    /*------------Metodo para listar Especies--------*/
    public function totalKlVendidos()
    {
        $db = new ModeloBase();
        $query = "SELECT SUM(kl_vendidos) AS kl_vendidos FROM cierre_jornada;";
        $resultado = $db->obtenerTodos($query);
        return $resultado;
    }

    /*------------Metodo para listar Especies--------*/
    public function totalBs()
    {
        $db = new ModeloBase();
        $query = "SELECT SUM(total_bs) AS total_bs FROM cierre_jornada;";
        $resultado = $db->obtenerTodos($query);
        return $resultado;
    }
}
