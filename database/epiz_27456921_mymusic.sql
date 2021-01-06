-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: sql312.byetcluster.com
-- Tiempo de generación: 06-01-2021 a las 15:01:11
-- Versión del servidor: 5.6.48-88.0
-- Versión de PHP: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `epiz_27456921_mymusic`
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `artista`
--

INSERT INTO `artista` (`uuid_artista`, `correo_artista`, `nombre_artistico_artista`, `nombre_artista`, `password_artista`, `pais_artista`, `bio_artista`, `fecha_alta_artista`, `imagen_artista`, `saldo_artista`, `estado_artista`) VALUES
('6529d3c1-ce5b-b79d-7019-820a52955b43', 'eminem@gmail.com', 'Eminem', 'Marshall Mathers', 'ShadY66', 'Estados Unidos', 'Marshall Bruce Mathers III (St Joseph, Misuri; 17 de octubre de 1972), conocido por su nombre artÃ­stico Eminem (estilizado como EMINÆŽM) y tambiÃ©n por su Ã¡lter ego Slim Shady, es un rapero, productor discogrÃ¡fico y actor estadounidense.', '2021-01-06 19:05:49', 'https://www.dropbox.com/s/414e26lzn6z5u6c/Eminem_5ff5fbfd0cbe8.JPG?raw=1', 6.1, 1),
('e1d87a48-b070-5538-4d66-27d568683f48', 'skylargrey@gmail.com', 'Skylar Grey', 'Holly Brook', 'AllwooD00', 'Estados Unidos', 'Skylar Grey cuyo nombre real es Holly Brook Hafermann, (Mazomanie, Wisconsin, Estados Unidos, 23 de febrero de 1986), es una cantante, compositora y productora estadounidense.', '2021-01-06 19:17:05', 'https://www.dropbox.com/s/919grzt2e67tlwh/SkylarGrey_5ff5fea161a0a.JPG?raw=1', 18, 1),
('2881a7c3-64e3-93ed-f047-b2c0ca6a2324', 'beckyg@gmail.com', 'Becky G', 'Rebbeca Marie', 'SimalA22', 'Estados Unidos', 'Rebbeca Marie GÃ³mezâ€‹, â€‹ conocida artÃ­sticamente como Becky G, es una cantante, compositora y actriz estadounidense.', '2021-01-06 19:21:03', 'https://www.dropbox.com/s/cdvdw1c2hv57fnr/beckyg_5ff5ff8f43980.JPG?raw=1', 6.6, 1),
('647861a9-2980-6f4a-705e-d21ad8f2c80c', 'chayanne@gmail.com', 'Chayanne', 'Elmer Figueroa', 'PalriO99', 'Puerto Rico', 'Elmer Figueroa Arce, conocido como Chayanne, es un cantante, compositor, bailarÃ­n y actor puertorriqueÃ±o.', '2021-01-06 19:22:17', 'https://www.dropbox.com/s/llp587wirurixpl/Chayanne_5ff5ffd95264c.JPG?raw=1', 4.1, 1),
('6d4d9825-f493-c0d3-c22b-45a04f7425ed', 'niogarcia@gmail.com', 'Nio GarcÃ­a', 'Luis Antonio QuiÃ±ones', 'ArrebataO33', 'Puerto Rico', 'Nio GarcÃ­a (3 de abril de 1989) cantante de mÃºsica urbana. NaciÃ³ en San Juan, Puerto Rico. Su nombre de nacimiento es Luis Antonio QuiÃ±ones GarcÃ­a, pero ha sido conocido en el mundo artÃ­stico como Che RobÃ³tico. Fue criado dentro de una familia humilde, de buenos valores y muy apegados a Dios.', '2021-01-06 19:24:19', 'https://www.dropbox.com/s/0ilfxya1kmj6dzp/NioGarcia_5ff60053378ea.JPG?raw=1', 14.7, 1),
('46a58e05-b496-f27a-b40b-82fadf91073a', 'shakira@gmail.com', 'Shakira', 'Shakira Isabel Mebarak', 'LocatigrE69', 'Colombia', 'Shakira Isabel Mebarak Ripoll (Barranquilla; 2 de febrero de 1977), conocida artÃ­sticamente como Shakira, es una cantautora, productora discogrÃ¡fica, actriz, bailarina, empresaria, embajadora de buena voluntad de UNICEF y filÃ¡ntropa colombiana.', '2021-01-06 19:25:36', 'https://www.dropbox.com/s/h1hz74l6fqzf2sr/Shakira_5ff600a090d5c.JPG?raw=1', 0, 0);

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `licencia`
--

INSERT INTO `licencia` (`uuid_licencia`, `uuid_tema_licencia`, `uuid_usuario_licencia`, `fecha_licencia`, `precio_licencia`) VALUES
('2f39d07d-ae66-2fca-1ce0-c29017b80614', '78de06ac-b78d-e581-48d1-487f93995b5c', '6c95b5f2-9634-55d3-0e26-4bdfb4fa9a78', '2021-01-06 20:38:52', 10),
('280fc6b2-6cb0-9001-9054-1df969dfac75', '6c6c4cbb-035a-973e-28ad-158fc35c1e3b', '6c95b5f2-9634-55d3-0e26-4bdfb4fa9a78', '2021-01-06 20:39:22', 7),
('051e41e7-5e9b-124c-f85f-951b4e46a8dc', 'bf5060ff-b3ca-d5ff-ce15-1557ef4483d7', '6c95b5f2-9634-55d3-0e26-4bdfb4fa9a78', '2021-01-06 20:40:52', 3),
('a920ec82-e412-1cf5-82e3-d8a3a12ff4d8', '0afff16f-2d9c-1cee-b7c9-92cb44e00a51', '6c95b5f2-9634-55d3-0e26-4bdfb4fa9a78', '2021-01-06 20:52:16', 3.3),
('3a96d556-7d8b-68a4-4120-b3f04c039fec', '35f615e9-9535-79ee-c5cb-51c590c348c4', 'c43164c6-0b84-1de5-5aae-8fc1be965323', '2021-01-06 20:56:52', 5.7),
('abf4c17b-8793-1588-cacb-3d61e1e0ed30', 'abbde835-c226-003d-254f-bf42e44fd4b5', 'c43164c6-0b84-1de5-5aae-8fc1be965323', '2021-01-06 20:57:00', 4.1),
('5cbef856-026d-77ca-7993-7d34a42832af', '0afff16f-2d9c-1cee-b7c9-92cb44e00a51', '3cd2a120-52ba-986c-cd2c-85d3e94e47d1', '2021-01-06 20:59:13', 3.3),
('0a2521c3-c0a9-05b2-2f1c-6a11a049baa7', '85199c68-64d4-0654-452f-cfa2aec8f5cf', '3cd2a120-52ba-986c-cd2c-85d3e94e47d1', '2021-01-06 20:59:22', 6.1),
('e5c5a21f-6a92-942b-2165-17068136a7b0', '3ae5fe77-fee1-6e7c-8c95-499f6782b7cd', '3cd2a120-52ba-986c-cd2c-85d3e94e47d1', '2021-01-06 20:59:41', 8);

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tema`
--

INSERT INTO `tema` (`uuid_tema`, `uuid_artista_tema`, `nombre_tema`, `completo_tema`, `teaser_tema`, `categoria_tema`, `numero_descargas_tema`, `nota_tema`, `fecha_lanzamiento_tema`, `imagen_tema`, `precio_tema`, `estado_tema`) VALUES
('0afff16f-2d9c-1cee-b7c9-92cb44e00a51', '2881a7c3-64e3-93ed-f047-b2c0ca6a2324', 'Sin Pijama', 'https://www.dropbox.com/s/9runj3liylvb31m/becky_g_natti_natasha_sin_pijama_official_video_5547951105607150689_5ff602c96532e.mp3?raw=1', 'https://www.dropbox.com/s/xzuyvnknpoopvff/becky_g_natti_natasha_sin_pijama_official_video_5547951105607150689%20%28mp3cut.net%29_5ff602d491ef4.mp3?raw=1', 'Reggaeton', 2, 'Â«Sin pijamaÂ» es una canciÃ³n de la cantante estadounidense - mexicana Becky G y la cantante dominicana Natti Natasha. La canciÃ³n y su vÃ­deo musical fue lanzado por Sony Music Latin. SuperÃ³ los 100 millones de visitas en YouTube / Vevo en las tres semanas posteriores a su lanzamiento.', '2021-01-06 19:35:03', 'https://www.dropbox.com/s/359zk9nv3hhzgg0/beckyg_5ff602d7f07cd.PNG?raw=1', 3.3, 1),
('abbde835-c226-003d-254f-bf42e44fd4b5', '647861a9-2980-6f4a-705e-d21ad8f2c80c', 'Infinita TÃº', 'https://www.dropbox.com/s/yk55gcwih99qcn7/Chayanne%20-%20Infinita%20T%C3%BA%20%28Audio%29_5ff604e770ea6.mp3?raw=1', 'https://www.dropbox.com/s/vtjji9d3mqdoza8/Chayanne%20-%20Infinita%20T%C3%BA%20%28Audio%29%20%28mp3cut.net%29_5ff604fa17cef.mp3?raw=1', 'Pop', 1, 'Ãlbum: En todo estarÃ©. Fecha de lanzamiento: 2014.', '2021-01-06 19:44:13', 'https://www.dropbox.com/s/efrbmiloxlgynub/chayanne_5ff604fd5e525.PNG?raw=1', 4.1, 1),
('85199c68-64d4-0654-452f-cfa2aec8f5cf', '6529d3c1-ce5b-b79d-7019-820a52955b43', 'Rhyme or Reason', 'https://www.dropbox.com/s/xvovqcyvscr0cfw/Eminem%20-%20Rhyme%20or%20Reason_5ff6075116fbd.mp3?raw=1', 'https://www.dropbox.com/s/t5og42pqd507m2h/Eminem%20-%20Rhyme%20or%20Reason%20%28mp3cut.net%29_5ff60766518f9.mp3?raw=1', 'Hip-Hop', 1, 'Ãlbum: The Marshall Mathers LP 2. Fecha de lanzamiento: 2013.', '2021-01-06 19:54:34', 'https://www.dropbox.com/s/evn8gtcm0hmdg0j/Eminem_5ff6076aabd56.PNG?raw=1', 6.1, 1),
('35f615e9-9535-79ee-c5cb-51c590c348c4', '6d4d9825-f493-c0d3-c22b-45a04f7425ed', 'Travesuras', 'https://www.dropbox.com/s/gp5m54lladnvnfe/Nio%20Garcia%20%26%20Casper%20Magico%20-%20Travesuras%20%28Video%20Oficial%29_5ff60b61ef9ca.mp3?raw=1', 'https://www.dropbox.com/s/4b0s8s17y9hec3y/Nio%20Garcia%20%26%20Casper%20Magico%20-%20Travesuras%20%28Video%20Oficial%29%20%28mp3cut.net%29_5ff60b72ebeb1.mp3?raw=1', 'Reggaeton', 1, 'Nio GarcÃ­a y Casper MÃ¡gico acaban de lanzar â€˜Travesurasâ€™, una canciÃ³n en la que hacen un homenaje al mÃ­tico himno del reggaetÃ³n que causÃ³ furor en la dÃ©cada de los 2000, y con la que han conquistado a sus fans.', '2021-01-06 20:11:50', 'https://www.dropbox.com/s/tx1hqoyjhnynxpn/niogarcia_5ff60b76b1c7e.PNG?raw=1', 5.7, 1),
('78de06ac-b78d-e581-48d1-487f93995b5c', '6d4d9825-f493-c0d3-c22b-45a04f7425ed', 'La Jeepeta', 'https://www.dropbox.com/s/di5d6yz05a0me8p/Nio%20Garcia%2C%20Brray%20%26%20Juanka%20-%20La%20Jeepeta%20%28Video%20Oficial%29_5ff60be7b69a3.mp3?raw=1', 'https://www.dropbox.com/s/9dr7xg4stkqq95q/Nio%20Garcia%2C%20Brray%20%26%20Juanka%20-%20La%20Jeepeta%20%28Video%20Oficial%29%20%28mp3cut.net%29_5ff60bfa606fe.mp3?raw=1', 'Reggaeton', 1, 'Presentado por Flow La Movie.', '2021-01-06 20:14:05', 'https://www.dropbox.com/s/tzn1x132nd14xjq/niogarcia2_5ff60bfdd4798.PNG?raw=1', 10, 1),
('6c6c4cbb-035a-973e-28ad-158fc35c1e3b', 'e1d87a48-b070-5538-4d66-27d568683f48', 'Dark Thoughts', 'https://www.dropbox.com/s/2ciqxd4klf5g5h3/Skylar%20Grey%20%E2%80%93%20Dark%20Thoughts_%28Mp3downloadhits.com%29_5ff60f0eb9139.mp3?raw=1', 'https://www.dropbox.com/s/bcuoegei0cgbssd/Skylar%20Grey%20%E2%80%93%20Dark%20Thoughts_%28Mp3downloadhits%20%28mp3cut.net%29_5ff60f2921fd8.mp3?raw=1', 'Pop', 1, 'Ãlbum: Make It Through The Day. Fecha de lanzamiento: 2020.', '2021-01-06 20:27:43', 'https://www.dropbox.com/s/38jm7ceqlq5r0pp/skylargrey2_5ff60f2f55126.PNG?raw=1', 7, 1),
('bf5060ff-b3ca-d5ff-ce15-1557ef4483d7', 'e1d87a48-b070-5538-4d66-27d568683f48', 'Sideways', 'https://www.dropbox.com/s/5pna2ajmswg767b/Skylar_Grey_-_Sideways_5ff60fb980189.mp3?raw=1', 'https://www.dropbox.com/s/klson2iub4tl5zy/Skylar_Grey_-_Sideways%20%28mp3cut.net%29_5ff60fd132fd7.mp3?raw=1', 'Pop', 1, 'Ãlbum: Make It Through The Day. Fecha de lanzamiento: 2020.', '2021-01-06 20:30:33', 'https://www.dropbox.com/s/o6pwrfrvfxdk0vq/skylargrey3_5ff60fd9508ca.PNG?raw=1', 3, 1),
('3ae5fe77-fee1-6e7c-8c95-499f6782b7cd', 'e1d87a48-b070-5538-4d66-27d568683f48', 'The Devil Made Me Do It', 'https://www.dropbox.com/s/hed4pjbmfudappz/Skylar_Grey_ft_BoB_-_The_Devil_Made_Me_Do_It_5ff61060a8aa1.mp3?raw=1', 'https://www.dropbox.com/s/re4m3ji66mx9nn5/Skylar_Grey_ft_BoB_-_The_Devil_Made_Me_Do_It%20%28mp3cut.net%29_5ff6107a2f6b6.mp3?raw=1', 'Trap', 1, 'Featuring B.o.B..', '2021-01-06 20:33:20', 'https://www.dropbox.com/s/mrw25gji18c1t29/skylargrey_5ff6108072532.PNG?raw=1', 8, 1);

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`uuid_usuario`, `correo_usuario`, `nick_usuario`, `nombre_usuario`, `password_usuario`, `pais_usuario`, `fecha_alta_usuario`, `imagen_usuario`, `saldo_usuario`) VALUES
('c43164c6-0b84-1de5-5aae-8fc1be965323', 'antonio@hotmail.com', 'Antonio8783', 'Antonio', 'FabiolA66', 'Marruecos', '2021-01-06 20:55:51', 'https://www.dropbox.com/s/du2w4lr8zi3n8sx/H2_5ff615c714615.PNG?raw=1', 0.2),
('6c95b5f2-9634-55d3-0e26-4bdfb4fa9a78', 'luisvalles92@hotmail.com', 'LuisValles92', 'Luis Valles', 'OrtoN11', 'EspaÃ±a', '2021-01-06 20:05:10', 'https://www.dropbox.com/s/zhcz2e77xssr70h/H4_5ff609e6bc331.PNG?raw=1', 1.7),
('3cd2a120-52ba-986c-cd2c-85d3e94e47d1', 'carmen@hotmail.com', 'DoÃ±a_Carmencita', 'Carmen', 'BarriofloreS55', 'CanadÃ¡', '2021-01-06 20:58:32', 'https://www.dropbox.com/s/xh45ess9234njm8/M4_5ff6166863221.PNG?raw=1', 2.6);

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
