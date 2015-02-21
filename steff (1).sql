-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-02-2015 a las 00:09:18
-- Versión del servidor: 5.6.17
-- Versión de PHP: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `steffy`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE IF NOT EXISTS `cliente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `entidad_id` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `apellido` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `usuario` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `clave` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `participante` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `cod_acceso` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `tlf` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `usuario` (`usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=30 ;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`id`, `entidad_id`, `nombre`, `apellido`, `usuario`, `clave`, `participante`, `cod_acceso`, `role_id`, `tlf`) VALUES
(17, 28, 'Jaime', 'Irazabal', 'jaimeirazabal1', '7d3ff5e583a1727c07bd911d427b514b', 'Jaime Irazabal', '16923509', 1, '04143299925'),
(28, 2, 'Steffany', 'Terán', 'steffy1990', '313437c00302021eda7b4197983f4011', 'participante_web', '1234', NULL, '04127183219'),
(29, 4, 'jaimico', 'jaimico', 'jaimico', '83b89d26100284e4f4c7a17a4ef657b2', 'jaimico1', 'jaimico1', NULL, '123456789');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentos`
--

CREATE TABLE IF NOT EXISTS `documentos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sesiones_id` int(11) NOT NULL,
  `adjunto` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `nombre` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `documentos`
--

INSERT INTO `documentos` (`id`, `sesiones_id`, `adjunto`, `nombre`) VALUES
(1, 37, 'files/uploads/nueva_entidad_steff/12-01-2015.Sesion Extraordinaria/documentos/2015-02-16_10-27-10_cuadro de variables.docx', 'cuadro de variables.docx'),
(2, 37, 'files/uploads/nueva_entidad_steff/12-01-2015.Sesion Extraordinaria/documentos/2015-02-16_10-28-04_pagina 11- interrogantes.docx', 'pagina 11- interrogantes.docx');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entidad`
--

CREATE TABLE IF NOT EXISTS `entidad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `ubicacion` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8_unicode_ci NOT NULL,
  `logo` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre` (`nombre`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `entidad`
--

INSERT INTO `entidad` (`id`, `nombre`, `ubicacion`, `descripcion`, `logo`, `fecha_registro`) VALUES
(2, 'innovaweb', 'La California', 'Diseño y Desarrollo Web de calidad. Nos enfocamos en diseños futuristas y minimalistas utilizando las nuevas tecnologías, siempre en busca de innovar y emprender en el mundo comunicacional a través de la web.', '/uploads/innovaweb/2015-02-09_04-57-25_new logo.png', '2015-02-09 09:57:25'),
(3, 'Artunics', 'La Florida', 'Arte en movimiento, único e impactante.', '/uploads/Artunics/2015-02-12_05-48-58_logo fondo negro.png', '2015-02-12 10:48:58'),
(4, 'nueva_entidad_steff', 'ubicacion nueva entidad steff', 'descripcion nueva entidad steff', '/uploads/nueva_entidad_steff/2015-02-16_09-50-27_Tulips.jpg', '2015-02-16 14:49:12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `participaciones`
--

CREATE TABLE IF NOT EXISTS `participaciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sesiones_id` int(11) NOT NULL,
  `nombre_participante` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `tiempo` time NOT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `ruta` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=99 ;

--
-- Volcado de datos para la tabla `participaciones`
--

INSERT INTO `participaciones` (`id`, `sesiones_id`, `nombre_participante`, `tiempo`, `status`, `ruta`) VALUES
(46, 35, 'primera', '00:30:11', NULL, 'C:\\xampp\\htdocs\\steff\\default\\public/files/uploads/innovaweb/Sesion Extraordinaria/00-30-11_primera.mp3'),
(47, 36, 'Marcos Gonzalez', '07:30:10', NULL, 'C:\\xampp\\htdocs\\steff\\default\\public/files/uploads/innovaweb/Conferencia 2015/07-30-10_Marcos Gonzalez.mp3'),
(48, 36, 'Alejandra Montesinos', '07:45:20', NULL, 'C:\\xampp\\htdocs\\steff\\default\\public/files/uploads/innovaweb/Conferencia 2015/07-45-20_Alejandra Montesinos.mp3'),
(49, 36, 'Elizabeth Carneiros', '08:40:22', 1, 'C:xampphtdocssteffdefaultpublic/files/uploads/innovaweb/Conferencia 2015/08-40-22_Elizabeth Carneiros.mp3'),
(50, 36, 'Pedro Moros', '09:12:44', 1, 'C:xampphtdocssteffdefaultpublic/files/uploads/innovaweb/Conferencia 2015/09-12-44_Pedro Moros.mp3'),
(51, 36, 'Marcos Gonzalez', '09:43:12', NULL, 'C:\\xampp\\htdocs\\steff\\default\\public/files/uploads/innovaweb/Conferencia 2015/09-43-12_Marcos Gonzalez.mp3'),
(52, 36, 'Elizabeth Carneiros', '10:20:32', NULL, 'C:\\xampp\\htdocs\\steff\\default\\public/files/uploads/innovaweb/Conferencia 2015/10-20-32_Elizabeth Carneiros.mp3'),
(53, 36, 'Pedro Moros', '10:36:09', NULL, 'C:\\xampp\\htdocs\\steff\\default\\public/files/uploads/innovaweb/Conferencia 2015/10-36-09_Pedro Moros.mp3'),
(54, 36, 'Alejandra Montesinos', '10:56:23', NULL, 'C:\\xampp\\htdocs\\steff\\default\\public/files/uploads/innovaweb/Conferencia 2015/10-56-23_Alejandra Montesinos.mp3'),
(55, 37, 'Kalimba', '00:30:30', 1, 'C:wampwwwsteffanydefaultpublic/files/uploads/nueva_entidad_steff/Sesion Extraordinaria/00-30-30_Kalimba.mp3'),
(56, 37, 'Maid with the Flaxen Hair', '00:40:30', NULL, 'C:\\wamp\\www\\steffany\\default\\public/files/uploads/nueva_entidad_steff/Sesion Extraordinaria/00-40-30_Maid with the Flaxen Hair.mp3'),
(57, 37, 'Sleep Away', '01:30:30', NULL, 'C:\\wamp\\www\\steffany\\default\\public/files/uploads/nueva_entidad_steff/Sesion Extraordinaria/01-30-30_Sleep Away.mp3'),
(87, 44, 'windows', '00:00:30', NULL, 'C:\\wamp\\www\\steffany\\default\\public/files/uploads/nueva_entidad_steff/Sesion ordinaria/00-00-30_windows.mp3'),
(88, 44, 'windows', '00:10:30', NULL, 'C:\\wamp\\www\\steffany\\default\\public/files/uploads/nueva_entidad_steff/Sesion ordinaria/00-10-30_windows.mp3'),
(89, 44, 'windows', '01:01:30', NULL, 'C:\\wamp\\www\\steffany\\default\\public/files/uploads/nueva_entidad_steff/Sesion ordinaria/01-01-30_windows.mp3'),
(90, 44, 'dream', '01:05:30', NULL, 'C:\\wamp\\www\\steffany\\default\\public/files/uploads/nueva_entidad_steff/Sesion ordinaria/01-05-30_dream.mp3'),
(91, 44, 'dream', '01:06:30', NULL, 'C:\\wamp\\www\\steffany\\default\\public/files/uploads/nueva_entidad_steff/Sesion ordinaria/01-06-30_dream.mp3'),
(92, 44, 'dream', '01:07:30', NULL, 'C:\\wamp\\www\\steffany\\default\\public/files/uploads/nueva_entidad_steff/Sesion ordinaria/01-07-30_dream.mp3'),
(93, 44, 'dream', '01:08:30', NULL, 'C:\\wamp\\www\\steffany\\default\\public/files/uploads/nueva_entidad_steff/Sesion ordinaria/01-08-30_dream.mp3'),
(94, 44, 'dream', '01:09:30', NULL, 'C:\\wamp\\www\\steffany\\default\\public/files/uploads/nueva_entidad_steff/Sesion ordinaria/01-09-30_dream.mp3'),
(95, 44, 'dream', '01:10:00', NULL, 'C:\\wamp\\www\\steffany\\default\\public/files/uploads/nueva_entidad_steff/Sesion ordinaria/01-10-00_dream.mp3'),
(96, 44, 'dream', '01:10:10', NULL, 'C:\\wamp\\www\\steffany\\default\\public/files/uploads/nueva_entidad_steff/Sesion ordinaria/01-10-10_dream.mp3'),
(97, 44, 'dream', '01:10:20', NULL, 'C:\\wamp\\www\\steffany\\default\\public/files/uploads/nueva_entidad_steff/Sesion ordinaria/01-10-20_dream.mp3'),
(98, 44, 'dream', '01:10:30', NULL, 'C:\\wamp\\www\\steffany\\default\\public/files/uploads/nueva_entidad_steff/Sesion ordinaria/01-10-30_dream.mp3');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin` tinyint(1) NOT NULL,
  `role` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `role`
--

INSERT INTO `role` (`id`, `admin`, `role`) VALUES
(1, 1, 'admin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sesiones`
--

CREATE TABLE IF NOT EXISTS `sesiones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `entidad_id` int(11) NOT NULL,
  `fecha_sesion` date NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `nombre` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ubicacion` text COLLATE utf8_unicode_ci,
  `descripcion` text COLLATE utf8_unicode_ci,
  `imagen` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `publicado` tinyint(1) DEFAULT NULL,
  `sesion_abierta` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=45 ;

--
-- Volcado de datos para la tabla `sesiones`
--

INSERT INTO `sesiones` (`id`, `entidad_id`, `fecha_sesion`, `fecha_registro`, `nombre`, `ubicacion`, `descripcion`, `imagen`, `publicado`, `sesion_abierta`) VALUES
(35, 2, '2015-01-12', '2015-02-09 10:19:11', 'Sesion Extraordinaria', 'La California', 'Diseño web y empredimiento. Nuevas Tecnologías comentan los expertos...', 'uploads/sesiones/innovaweb/Sesion Extraordinaria/2015-02-10_02-54-50_business-innovation-concepts-icons-set-template-modern-info-graphic-design-template-marketing-creative-templates-41748135.jpg', NULL, NULL),
(36, 2, '2015-01-20', '2015-02-11 10:01:25', 'Conferencia 2015', 'El Paraíso', 'Los ingenieros de Mountain View comparten con la comunidad sus trabajos y anuncian las nuevas herramientas a seguir durante el año 2015 Android.', 'uploads/sesiones/innovaweb/Conferencia 2015/2015-02-11_05-44-58_android.jpg', NULL, NULL),
(37, 4, '2015-01-12', '2015-02-16 15:23:57', 'Sesion Extraordinaria', 'ubicacion de sesion extra', 'descripcion de sesion extra', NULL, NULL, NULL),
(44, 4, '2015-04-12', '2015-02-16 16:56:53', 'Sesion ordinaria', NULL, NULL, NULL, NULL, NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
