-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 23-03-2021 a las 23:12:09
-- Versión del servidor: 5.5.24-log
-- Versión de PHP: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `sesamodatab`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesas`
--

CREATE TABLE IF NOT EXISTS `mesas` (
  `idMesa` int(15) NOT NULL AUTO_INCREMENT,
  `idUsuario` int(15) NOT NULL,
  `cantidad` int(20) NOT NULL,
  `idProducto` int(15) NOT NULL,
  PRIMARY KEY (`idMesa`),
  KEY `idUsuario` (`idUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE IF NOT EXISTS `pedidos` (
  `idPedidos` int(15) NOT NULL AUTO_INCREMENT,
  `idMesa` int(15) NOT NULL,
  `idProducto` int(15) NOT NULL,
  `totalPago` int(20) NOT NULL,
  `estado` varchar(15) COLLATE utf8mb4_spanish_ci NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  PRIMARY KEY (`idPedidos`),
  KEY `idProducto` (`idProducto`),
  KEY `idMesa` (`idMesa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE IF NOT EXISTS `productos` (
  `idProducto` int(15) NOT NULL AUTO_INCREMENT,
  `idTipo` int(15) NOT NULL,
  `nombre` varchar(20) COLLATE utf8mb4_spanish_ci NOT NULL,
  `descripcion` varchar(80) COLLATE utf8mb4_spanish_ci NOT NULL,
  `foto` varchar(60) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `precio` int(20) NOT NULL,
  PRIMARY KEY (`idProducto`),
  KEY `idTipo` (`idTipo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci AUTO_INCREMENT=21 ;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`idProducto`, `idTipo`, `nombre`, `descripcion`, `foto`, `precio`) VALUES
(10, 2, 'Pastel de chocolate', 'Pastel de chocolate relleno de almendras y arandanos.', 'chocolate.png', 6000),
(17, 1, 'Cocacola', 'Bebida refrescante', 'img_63d98672bb04f29c573321f9daf4b51a.png', 2500),
(18, 1, 'Jugo de naranja', 'Refrescante jugo natural.', 'img_23e60a441df3265eed8becba2c8cf681.png', 4500),
(19, 3, 'Sencillo', 'Queso mozzarella, lechuga, tomate y salsa de la casa.', 'img_d155d10ab1b3ae85de04023a81bb8190.png', 12000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos`
--

CREATE TABLE IF NOT EXISTS `tipos` (
  `idTipo` int(15) NOT NULL AUTO_INCREMENT,
  `categoria` varchar(20) COLLATE utf8mb4_spanish_ci NOT NULL,
  PRIMARY KEY (`idTipo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `tipos`
--

INSERT INTO `tipos` (`idTipo`, `categoria`) VALUES
(1, 'Bebida'),
(2, 'Postre'),
(3, 'Sandwiches');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `idUsuario` int(15) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(20) COLLATE utf8mb4_spanish_ci NOT NULL,
  `contraseña` varchar(20) COLLATE utf8mb4_spanish_ci NOT NULL,
  `tipo` varchar(15) COLLATE utf8mb4_spanish_ci NOT NULL,
  PRIMARY KEY (`idUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci AUTO_INCREMENT=1 ;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `mesas`
--
ALTER TABLE `mesas`
  ADD CONSTRAINT `mesas_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario`);

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`idProducto`) REFERENCES `productos` (`idProducto`),
  ADD CONSTRAINT `pedidos_ibfk_2` FOREIGN KEY (`idMesa`) REFERENCES `mesas` (`idMesa`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`idTipo`) REFERENCES `tipos` (`idTipo`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
