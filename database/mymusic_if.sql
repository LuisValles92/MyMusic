-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-01-2021 a las 17:35:44
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `mymusic`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `artista`
--

CREATE TABLE `artista` (
  `uuid_artista` varchar(36) NOT NULL,
  `correo_artista` varchar(320) NOT NULL,
  `nombre_artistico_artista` varchar(45) NOT NULL,
  `nombre_artista` varchar(45) NOT NULL,
  `password_artista` varchar(45) NOT NULL,
  `pais_artista` varchar(45) NOT NULL,
  `bio_artista` varchar(600) NOT NULL,
  `fecha_alta_artista` datetime NOT NULL,
  `imagen_artista` varchar(255) NOT NULL,
  `saldo_artista` float NOT NULL,
  `estado_artista` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `licencia`
--

CREATE TABLE `licencia` (
  `uuid_licencia` varchar(36) NOT NULL,
  `uuid_tema_licencia` varchar(36) NOT NULL,
  `uuid_usuario_licencia` varchar(36) NOT NULL,
  `fecha_licencia` datetime NOT NULL,
  `precio_licencia` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tema`
--

CREATE TABLE `tema` (
  `uuid_tema` varchar(36) NOT NULL,
  `uuid_artista_tema` varchar(36) NOT NULL,
  `nombre_tema` varchar(45) NOT NULL,
  `completo_tema` varchar(255) NOT NULL,
  `teaser_tema` varchar(255) NOT NULL,
  `categoria_tema` varchar(45) NOT NULL,
  `numero_descargas_tema` int(11) NOT NULL,
  `nota_tema` varchar(600) NOT NULL,
  `fecha_lanzamiento_tema` datetime NOT NULL,
  `imagen_tema` varchar(255) NOT NULL,
  `precio_tema` float NOT NULL,
  `estado_tema` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `uuid_usuario` varchar(36) NOT NULL,
  `correo_usuario` varchar(320) NOT NULL,
  `nick_usuario` varchar(45) NOT NULL,
  `nombre_usuario` varchar(45) NOT NULL,
  `password_usuario` varchar(45) NOT NULL,
  `pais_usuario` varchar(45) NOT NULL,
  `fecha_alta_usuario` datetime NOT NULL,
  `imagen_usuario` varchar(255) NOT NULL,
  `saldo_usuario` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `artista`
--
ALTER TABLE `artista`
  ADD PRIMARY KEY (`uuid_artista`),
  ADD UNIQUE KEY `correo_artista_UNIQUE` (`correo_artista`),
  ADD UNIQUE KEY `nombre_artistico_artista_UNIQUE` (`nombre_artistico_artista`);

--
-- Indices de la tabla `licencia`
--
ALTER TABLE `licencia`
  ADD PRIMARY KEY (`uuid_licencia`),
  ADD KEY `uuid_tema_licencia_idx` (`uuid_tema_licencia`),
  ADD KEY `uuid_usuario_licencia_idx` (`uuid_usuario_licencia`);

--
-- Indices de la tabla `tema`
--
ALTER TABLE `tema`
  ADD PRIMARY KEY (`uuid_tema`),
  ADD KEY `uuid_artista_tema_idx` (`uuid_artista_tema`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`uuid_usuario`),
  ADD UNIQUE KEY `correo_usuario_UNIQUE` (`correo_usuario`),
  ADD UNIQUE KEY `nick_usuario_UNIQUE` (`nick_usuario`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `licencia`
--
ALTER TABLE `licencia`
  ADD CONSTRAINT `uuid_tema_licencia` FOREIGN KEY (`uuid_tema_licencia`) REFERENCES `tema` (`uuid_tema`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `uuid_usuario_licencia` FOREIGN KEY (`uuid_usuario_licencia`) REFERENCES `usuario` (`uuid_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tema`
--
ALTER TABLE `tema`
  ADD CONSTRAINT `uuid_artista_tema` FOREIGN KEY (`uuid_artista_tema`) REFERENCES `artista` (`uuid_artista`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
