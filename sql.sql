-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-02-2015 a las 00:48:31
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=31 ;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`id`, `entidad_id`, `nombre`, `apellido`, `usuario`, `clave`, `participante`, `cod_acceso`, `role_id`, `tlf`) VALUES
(17, 28, 'Jaime', 'Irazabal', 'jaimeirazabal1', '7d3ff5e583a1727c07bd911d427b514b', 'Jaime Irazabal', '16923509', 1, '04143299925'),
(28, 2, 'Steffany', 'Terán', 'steffy1990', '313437c00302021eda7b4197983f4011', 'participante_web', '1234', NULL, '04127183219'),
(29, 4, 'jaimico', 'jaimico', 'jaimico', '83b89d26100284e4f4c7a17a4ef657b2', 'jaimico1', 'jaimico1', NULL, '123456789'),
(30, 5, 'jaig', 'jaig irazabal', 'jaig', '7d3ff5e583a1727c07bd911d427b514b', 'jaig1', 'jaig1', NULL, '4143299925');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `documentos`
--

INSERT INTO `documentos` (`id`, `sesiones_id`, `adjunto`, `nombre`) VALUES
(1, 37, 'files/uploads/nueva_entidad_steff/12-01-2015.Sesion Extraordinaria/documentos/2015-02-16_10-27-10_cuadro de variables.docx', 'cuadro de variables.docx'),
(2, 37, 'files/uploads/nueva_entidad_steff/12-01-2015.Sesion Extraordinaria/documentos/2015-02-16_10-28-04_pagina 11- interrogantes.docx', 'pagina 11- interrogantes.docx'),
(3, 45, 'files/uploads/jaig_jaig/12-01-2015.Sesion Ordinaria/documentos/2015-02-21_16-09-22_COMPRA VENTA JAIME.doc', 'COMPRA VENTA JAIME.doc');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `entidad`
--

INSERT INTO `entidad` (`id`, `nombre`, `ubicacion`, `descripcion`, `logo`, `fecha_registro`) VALUES
(2, 'innovaweb', 'La California', 'Diseño y Desarrollo Web de calidad. Nos enfocamos en diseños futuristas y minimalistas utilizando las nuevas tecnologías, siempre en busca de innovar y emprender en el mundo comunicacional a través de la web.', '/uploads/innovaweb/2015-02-09_04-57-25_new logo.png', '2015-02-09 09:57:25'),
(3, 'Artunics', 'La Florida', 'Arte en movimiento, único e impactante.', '/uploads/Artunics/2015-02-12_05-48-58_logo fondo negro.png', '2015-02-12 10:48:58'),
(5, 'jaig_jaig', 'ubicacion jaig jaig', 'descripcion de jaig jaig', '/uploads/jaig_jaig/2015-02-21_16-02-53_tabla3.jpg', '2015-02-21 21:02:53');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=120 ;

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
(100, 45, 'Maid with the Flaxen Hair', '01:00:30', 1, 'C:wampwwwapp_grabaciones_steffdefaultpublic/files/uploads/jaig_jaig/Sesion Ordinaria/01-00-30_Maid with the Flaxen Hair.mp3'),
(101, 45, 'Kalimba', '01:30:30', NULL, 'C:wampwwwapp_grabaciones_steffdefaultpublic/files/uploads/jaig_jaig/Sesion Ordinaria/01-30-30_Kalimba.mp3'),
(118, 62, 'Maid with the Flaxen Hair', '01:00:30', NULL, 'C:\\wamp\\www\\app_grabaciones_steff\\default\\public/files/uploads/jaig_jaig/Sesion Ordinaria/01-00-30_Maid with the Flaxen Hair.mp3'),
(119, 62, 'Kalimba', '01:30:30', NULL, 'C:\\wamp\\www\\app_grabaciones_steff\\default\\public/files/uploads/jaig_jaig/Sesion Ordinaria/01-30-30_Kalimba.mp3');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=63 ;

--
-- Volcado de datos para la tabla `sesiones`
--

INSERT INTO `sesiones` (`id`, `entidad_id`, `fecha_sesion`, `fecha_registro`, `nombre`, `ubicacion`, `descripcion`, `imagen`, `publicado`, `sesion_abierta`) VALUES
(35, 2, '2015-01-12', '2015-02-09 10:19:11', 'Sesion Extraordinaria', 'La California', 'Diseño web y empredimiento. Nuevas Tecnologías comentan los expertos...', 'uploads/sesiones/innovaweb/Sesion Extraordinaria/2015-02-10_02-54-50_business-innovation-concepts-icons-set-template-modern-info-graphic-design-template-marketing-creative-templates-41748135.jpg', NULL, NULL),
(36, 2, '2015-01-20', '2015-02-11 10:01:25', 'Conferencia 2015', 'El Paraíso', 'Los ingenieros de Mountain View comparten con la comunidad sus trabajos y anuncian las nuevas herramientas a seguir durante el año 2015 Android.', 'uploads/sesiones/innovaweb/Conferencia 2015/2015-02-11_05-44-58_android.jpg', NULL, NULL),
(45, 5, '2015-01-12', '2015-02-21 21:08:21', 'Sesion Ordinaria', 'Ubicacion de la sesion', 'Descripcion de la sesion', NULL, NULL, NULL),
(62, 5, '2015-02-12', '2015-02-22 23:14:51', 'Sesion Ordinaria', NULL, NULL, NULL, NULL, NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
