-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 31-01-2020 a las 09:32:31
-- Versión del servidor: 10.1.39-MariaDB
-- Versión de PHP: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bddavinajul`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `Nombre` varchar(50) NOT NULL,
  `Password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`Nombre`, `Password`) VALUES
('David', 'david1234'),
('Inaki', 'Inaki1234'),
('Julen', 'julen1234');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libros`
--

CREATE TABLE `libros` (
  `CodLibro` int(2) NOT NULL,
  `Titulo` varchar(70) NOT NULL,
  `Descripcion` varchar(150) DEFAULT NULL,
  `Fecha` date NOT NULL,
  `Imagen` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `libros`
--

INSERT INTO `libros` (`CodLibro`, `Titulo`, `Descripcion`, `Fecha`, `Imagen`) VALUES
(1, 'Enseñanzas de PHP', 'Libro para aprender lenguaje de PHP', '2020-01-20', 'img/php.jpg'),
(2, 'Enseñanzas de HTML', 'Libro para aprender lenguaje HTML', '2020-01-20', 'img/html.jpg'),
(3, 'Enseñanzas de Java', 'Libro para aprender lenguaje Java', '2020-01-20', 'img/java.jpg'),
(4, 'Enseñanzas de CSS', 'Libro para aprender lenguaje CSS', '2020-01-20', 'img/html.jpg'),
(5, 'Enseñanzas de JavaScript', 'Libro para aprender lenguaje JavaScript', '2020-01-20', 'img/javascript.jpg'),
(6, 'Enseñanzas de JSON', 'Libro para aprender lenguaje JSON', '2020-01-20', 'img/json.jpg'),
(7, 'Enseñanzas de HTML5', 'Libro para aprender lenguaje HTML5', '2020-01-20', 'img/html5.jpg'),
(8, 'Enseñanzas de C', 'Libro para aprender lenguaje C', '2020-01-20', 'img/c.jpg'),
(9, 'Enseñanzas de Python', 'Libro para aprender lenguaje Python', '2020-01-20', 'img/python.jpg');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`Nombre`);

--
-- Indices de la tabla `libros`
--
ALTER TABLE `libros`
  ADD PRIMARY KEY (`CodLibro`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `libros`
--
ALTER TABLE `libros`
  MODIFY `CodLibro` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
