-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 23-11-2014 a las 13:56:47
-- Versión del servidor: 5.5.40-0ubuntu0.14.04.1
-- Versión de PHP: 5.5.9-1ubuntu4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `aprendomvcdb2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagenes`
--

CREATE TABLE IF NOT EXISTS `imagenes` (
  `id_imagen` int(11) NOT NULL AUTO_INCREMENT,
  `nom_imagen` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `idpost` int(11) NOT NULL,
  PRIMARY KEY (`id_imagen`),
  KEY `idpost` (`idpost`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `cuerpo` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `fechaPub` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `autor` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `posts`
--

INSERT INTO `posts` (`id`, `titulo`, `cuerpo`, `fechaPub`, `autor`) VALUES
(1, 'Esta es la primera publicación', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.            ', '2014-09-28 22:05:28', ''),
(2, 'Este es la segunda publicación', 'Nos vemos mañana\r\n\r\nSi trabajaste en tu propia implementación de ayer puedes sentir que no aprendiste mucho hoy, esto significa que te estás acostumbrando a la filosofía symfony. El proceso para añadir una nueva característica a un sitio web de symfony es siempre el mismo: pensar en las URLs, crear algunas acciones, actualizar el modelo, y escribir algunas plantillas. Y, si puedes aplicar algunas de estas buenas prácticas de desarrollo, te convertirás en un maestro symfony muy rápido.            ', '2014-10-04 23:41:51', ''),
(4, 'Esta es la tercera publicación', 'Este capítulo ha sido traducido por Roberto Germán Puentes Díaz. Si encuentras algún error que deseas corregir o realizar algún comentario, no dudes en enviarlo por correo a puentesdiaz [arroba] gmail.com', '2014-10-05 00:08:25', 'Pedro Gabriel Manrique Gutiérrez');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `usuario` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `pass` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `role` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `estado` tinyint(4) NOT NULL,
  `codigo` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `usuario`, `pass`, `email`, `role`, `estado`, `codigo`, `fecha`) VALUES
(1, 'Pedro Gabriel Manrique Gutiérrez', 'pedro', 'ac9a31e9e61455f6100daa15070641e307b79105', 'pedro', 'administrador', 1, '5621602262', '2014-09-28 21:57:59'),
(2, 'prueba2 probador2', 'prueba2', 'ac9a31e9e61455f6100daa15070641e307b79105', 'pedrogmanrique@gmail.com', '', 0, '8780709596', '2014-09-28 19:02:43'),
(3, 'pepe', 'pepe', '78afa981d955baa9b8d9870efea2bb2ed9c989ea', 'pedrogmanrique@gmail.com', '', 0, '2077985616', '2014-10-05 23:26:54');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `imagenes`
--
ALTER TABLE `imagenes`
  ADD CONSTRAINT `imagenes_ibfk_1` FOREIGN KEY (`idpost`) REFERENCES `posts` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
