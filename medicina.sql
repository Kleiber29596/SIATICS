-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 21-11-2024 a las 20:32:59
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `medicina`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_consulta`
--

CREATE TABLE `tipo_consulta` (
  `id_tipo_consulta` int(11) NOT NULL,
  `codigo` int(11) NOT NULL,
  `motivo` varchar(500) NOT NULL,
  `id_especialidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_consulta`
--

INSERT INTO `tipo_consulta` (`id_tipo_consulta`, `codigo`, `motivo`, `id_especialidad`) VALUES
(1, 1, 'CONSULTA: ATENCIÓN DE MADRE LACTANTE / POSTNATAL (Z39: Z391)', 0),
(2, 2, 'CONSULTA: CONTROL PRENATAL (Z32.- -- Z35.-)', 0),
(3, 3, 'CONSULTA: TAMIZAJE Y PESQUISA ANTROPOMETRICA NUTRICIONAL - SAMAN PRIMERA (Z13.2; 713.4)', 0),
(4, 4, 'CONSULTA: CONTROL VIVERO SAMAN SEGUIMIENTO (Z76.0, Z76.1, Z76.2)', 0),
(5, 5, 'CONSULTA: SEGUIMIENTO DE TRATAMIENTO Y/O CONVALESCENCIA TODAS LAS EDADES (Z09.-, Z54)', 0),
(6, 6, 'CONSULTAS PARA PROCEDIMIENTOS: CITOLOGÍA, EXODONCIA, VACUNACIÓN, CURA, ETC (Z40.--Z53)', 0),
(7, 7, 'SOLICITUD DE AYUDAS POR RIESGOS POTENCIALES PARA LA SALUD SOCIOECONÓMICOS Y PSICOSOCIALES: MIGRACIÓN FAMILIAR; VIOLENCIAS; INDIGENCIA (Z55-Z65; Z70.-- Z76.8)', 0),
(8, 8, 'CONSULTAS DE CONTROL DE SALUD GENERAL: NIÑOS Y ADULTOS SANOS (ZOO-Z01.-)', 0),
(9, 9, 'CONSULTAS PARA DESPISTAJES Y EXAMENES ESPECIALES: CA DE MAMAS, HTA, VISIÓN, DENTAL, CARDIOVASCULAR', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tipo_consulta`
--
ALTER TABLE `tipo_consulta`
  ADD PRIMARY KEY (`id_tipo_consulta`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tipo_consulta`
--
ALTER TABLE `tipo_consulta`
  MODIFY `id_tipo_consulta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
