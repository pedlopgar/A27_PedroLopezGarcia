-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-04-2026 a las 20:25:28
-- Versión del servidor: 12.1.2-MariaDB
-- Versión de PHP: 8.2.12


CREATE DATABASE IF NOT EXISTS `a27_pedrolopezgarcia_biblioteca_videojuegos`
DEFAULT CHARACTER SET utf8mb4
COLLATE utf8mb4_uca1400_ai_ci;

USE `a27_pedrolopezgarcia_biblioteca_videojuegos`;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `a27_pedrolopezgarcia_biblioteca_videojuegos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `desarrolladora`
--

CREATE TABLE `desarrolladora` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `oficinas` varchar(150) DEFAULT 'N/A',
  `fundadores` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Volcado de datos para la tabla `desarrolladora`
--

INSERT INTO `desarrolladora` (`id`, `nombre`, `oficinas`, `fundadores`) VALUES
(1, 'Konami', 'Tokio, Japón', 'Kagemasa Kozuki'),
(2, 'Ubisoft Montpellier', 'Montpellier, Francia', 'N/A'),
(3, 'Team Cherry', 'Adelaida, Australia', 'William Pellen, Ari Gibson'),
(4, 'Capcom', 'Osaka, Japón', 'Kenzo Tsujimoto'),
(5, 'Arsi Hakita Patala', 'N/A', 'Hakita'),
(6, 'id Software', 'Texas, EE.UU.', 'John Carmack, John Romero'),
(7, 'Polyphony Digital', 'Tokio, Japón', 'Kazunori Yamauchi'),
(8, 'Hello Games', 'Guildford, Reino Unido', 'Sean Murray'),
(9, 'Larian Studios', 'Gante, Bélgica', 'Swen Vincke'),
(10, 'FromSoftware', 'Tokio, Japón', 'Naotoshi Zin'),
(11, 'Digital Extremes', 'Ontario, Canadá', 'James Schmalz'),
(12, 'Sonic Team', 'Tokio, Japón', 'Yuji Naka'),
(13, 'Insomniac Games', 'California, EE.UU.', 'Ted Price'),
(14, 'Arc System Works', 'Yokohama, Japón', 'Minoru Kidooka'),
(15, 'Project Soul', 'Tokio, Japón', 'N/A'),
(16, 'Tour De Pizza', 'N/A', 'McPig'),
(17, 'Mobius Digital', 'California, EE.UU.', 'Masi Oka'),
(18, 'Toby Fox', 'N/A', 'Toby Fox'),
(19, 'Blizzard Entertainment', 'California, EE.UU.', 'Allen Adham, Michael Morhaime, Frank Pearce'),
(20, 'LucasArts', 'California, EE.UU.', 'George Lucas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `distribuidora`
--

CREATE TABLE `distribuidora` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `oficinas` varchar(150) DEFAULT 'N/A',
  `fundadores` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Volcado de datos para la tabla `distribuidora`
--

INSERT INTO `distribuidora` (`id`, `nombre`, `oficinas`, `fundadores`) VALUES
(1, 'Konami', 'Tokio, Japón', 'Kagemasa Kozuki'),
(2, 'Ubisoft', 'Montreuil, Francia', 'Familia Guillemot'),
(3, 'Team Cherry', 'Adelaida, Australia', 'William Pellen, Ari Gibson'),
(4, 'Capcom', 'Osaka, Japón', 'Kenzo Tsujimoto'),
(5, 'New Blood Interactive', 'N/A', 'Dave Oshry'),
(6, 'Bethesda Softworks', 'Maryland, EE.UU.', 'Christopher Weaver'),
(7, 'Sony Interactive Entertainment', 'Tokio, Japón', 'N/A'),
(8, 'Hello Games', 'Guildford, Reino Unido', 'Sean Murray'),
(9, 'Larian Studios', 'Gante, Bélgica', 'Swen Vincke'),
(10, 'Bandai Namco Entertainment', 'Tokio, Japón', 'N/A'),
(11, 'Digital Extremes', 'Ontario, Canadá', 'James Schmalz'),
(12, 'Sega', 'Tokio, Japón', 'David Rosen'),
(13, 'Sony Computer Entertainment', 'Tokio, Japón', 'N/A'),
(14, 'Arc System Works', 'Yokohama, Japón', 'Minoru Kidooka'),
(15, 'Tour De Pizza', 'N/A', 'McPig'),
(16, 'Annapurna Interactive', 'California, EE.UU.', 'Megan Ellison'),
(17, 'tinyBuild', 'Seattle, EE.UU.', 'Alex Nichiporchik'),
(18, 'Blizzard Entertainment', 'California, EE.UU.', 'Allen Adham, Michael Morhaime, Frank Pearce'),
(19, 'LucasArts', 'California, EE.UU.', 'George Lucas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `juegos`
--

CREATE TABLE `juegos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `fecha_lanzamiento` date DEFAULT NULL,
  `distribuidora_id` int(11) DEFAULT NULL,
  `desarrolladora_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Volcado de datos para la tabla `juegos`
--

INSERT INTO `juegos` (`id`, `nombre`, `fecha_lanzamiento`, `distribuidora_id`, `desarrolladora_id`) VALUES
(1, 'Metal Gear Solid', '1998-09-03', 1, 1),
(2, 'Rayman 2', '1999-10-29', 2, 2),
(3, 'Hollow Knight', '2017-02-24', 3, 3),
(4, 'Monster Hunter World', '2018-01-26', 4, 4),
(5, 'Ultrakill', '2020-09-03', 5, 5),
(6, 'DOOM Eternal', '2020-03-20', 6, 6),
(7, 'Gran Turismo 5', '2010-11-24', 7, 7),
(8, 'No Man\'s Sky', '2016-08-09', 7, 8),
(9, 'Baldur\'s Gate 3', '2023-08-03', 9, 9),
(10, 'Dark Souls', '2011-09-22', 10, 10),
(11, 'Warframe', '2013-03-25', 11, 11),
(12, 'Sonic 3', '1994-02-02', 12, 12),
(13, 'Ratchet and Clank', '2002-11-04', 13, 13),
(14, 'Guilty Gear Strive', '2021-06-11', 14, 14),
(15, 'Soul Calibur 6', '2018-10-19', 10, 15),
(16, 'Pizza Tower', '2023-01-26', 15, 16),
(17, 'Outer Wilds', '2019-05-30', 16, 17),
(18, 'Undertale', '2015-09-15', 17, 18),
(19, 'Overwatch', '2016-05-24', 18, 19),
(20, 'Grim Fandango', '1998-10-30', 19, 20);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `password`) VALUES
(1, 'admin', 'admin'),
(2, 'pedro', '1234'),
(3, 'juan', '1234');

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_juegos`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_juegos` (
`id` int(11)
,`nombre` varchar(100)
,`fecha_lanzamiento` date
,`distribuidora` varchar(100)
,`desarrolladora` varchar(100)
);

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_juegos`
--
DROP TABLE IF EXISTS `vista_juegos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_juegos`  AS SELECT `j`.`id` AS `id`, `j`.`nombre` AS `nombre`, `j`.`fecha_lanzamiento` AS `fecha_lanzamiento`, `d`.`nombre` AS `distribuidora`, `dev`.`nombre` AS `desarrolladora` FROM ((`juegos` `j` join `distribuidora` `d` on(`j`.`distribuidora_id` = `d`.`id`)) join `desarrolladora` `dev` on(`j`.`desarrolladora_id` = `dev`.`id`)) ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `desarrolladora`
--
ALTER TABLE `desarrolladora`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `distribuidora`
--
ALTER TABLE `distribuidora`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `juegos`
--
ALTER TABLE `juegos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `distribuidora_id` (`distribuidora_id`),
  ADD KEY `desarrolladora_id` (`desarrolladora_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `desarrolladora`
--
ALTER TABLE `desarrolladora`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `distribuidora`
--
ALTER TABLE `distribuidora`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `juegos`
--
ALTER TABLE `juegos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `juegos`
--
ALTER TABLE `juegos`
  ADD CONSTRAINT `1` FOREIGN KEY (`distribuidora_id`) REFERENCES `distribuidora` (`id`),
  ADD CONSTRAINT `2` FOREIGN KEY (`desarrolladora_id`) REFERENCES `desarrolladora` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
