-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-11-2020 a las 05:04:51
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `dbmodelo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `abonoscliente`
--

CREATE TABLE `abonoscliente` (
  `id` int(8) UNSIGNED NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `fecha_abono` date NOT NULL,
  `abono` decimal(12,2) NOT NULL DEFAULT 0.00,
  `concepto_abono` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ultmodificacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ajusteinventario`
--

CREATE TABLE `ajusteinventario` (
  `id` int(8) UNSIGNED NOT NULL,
  `fecha_ajuste` date NOT NULL,
  `tipomov` int(3) NOT NULL,
  `id_almacen` int(3) NOT NULL,
  `motivo_ajuste` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `datos_ajuste` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `estatus` tinyint(1) NOT NULL,
  `id_usuario` int(3) NOT NULL,
  `ultmodificacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `almacen2`
--

CREATE TABLE `almacen2` (
  `id` int(5) NOT NULL,
  `id_producto` int(5) NOT NULL,
  `codigointerno` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `cant` float(10,2) NOT NULL DEFAULT 0.00,
  `precio_compra` float(10,2) NOT NULL DEFAULT 0.00,
  `margen_utilidad` float(6,2) NOT NULL DEFAULT 0.00,
  `precio_venta` float(10,2) NOT NULL DEFAULT 0.00,
  `fecha_entrada` date NOT NULL,
  `ultmodificacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ultusuario` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `almacenes`
--

CREATE TABLE `almacenes` (
  `id` int(3) NOT NULL,
  `nombre` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `ubicacion` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `responsable` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `telefono` varchar(25) COLLATE utf8_spanish_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ultmodificacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ultusuario` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cajas`
--

CREATE TABLE `cajas` (
  `id` int(2) UNSIGNED NOT NULL,
  `caja` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 0,
  `id_usuario` int(3) NOT NULL DEFAULT 0,
  `ultusuario` int(2) NOT NULL,
  `ultmodificacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cancela_venta`
--

CREATE TABLE `cancela_venta` (
  `id` int(8) UNSIGNED NOT NULL,
  `num_cancelacion` int(8) UNSIGNED NOT NULL DEFAULT 0,
  `id_cliente` int(3) NOT NULL,
  `num_salida` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha_salida` date NOT NULL,
  `id_producto` int(5) NOT NULL,
  `cantidad` float NOT NULL,
  `precio_venta` float(12,2) DEFAULT NULL,
  `id_almacen` int(2) NOT NULL,
  `es_promo` tinyint(1) DEFAULT 0,
  `ultusuario` int(2) DEFAULT NULL,
  `ultmodificacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `id_familia` int(5) NOT NULL DEFAULT 0,
  `categoria` varchar(35) COLLATE utf8_spanish_ci NOT NULL,
  `ultusuario` tinyint(2) DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `catestado`
--

CREATE TABLE `catestado` (
  `idestado` int(2) NOT NULL,
  `nombreestado` varchar(40) NOT NULL,
  `clave` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Estados';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nombre` text COLLATE utf8_spanish_ci NOT NULL,
  `rfc` varchar(13) COLLATE utf8_spanish_ci NOT NULL,
  `email` text COLLATE utf8_spanish_ci NOT NULL,
  `telefono` text COLLATE utf8_spanish_ci NOT NULL,
  `direccion` text COLLATE utf8_spanish_ci NOT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `descuento` decimal(10,2) NOT NULL DEFAULT 0.00,
  `ventas` decimal(12,2) DEFAULT 0.00,
  `ultima_venta` date DEFAULT NULL,
  `limitecredito` decimal(12,2) DEFAULT 0.00,
  `saldo` decimal(12,2) DEFAULT 0.00,
  `estado` tinyint(1) DEFAULT 1,
  `ultusuario` tinyint(3) DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cobrosdeventas`
--

CREATE TABLE `cobrosdeventas` (
  `id` int(8) NOT NULL,
  `id_ticket` int(8) NOT NULL,
  `totalventa` decimal(10,2) NOT NULL DEFAULT 0.00,
  `pago` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cortes`
--

CREATE TABLE `cortes` (
  `id` int(8) UNSIGNED NOT NULL,
  `id_caja` tinyint(2) NOT NULL,
  `cajachica` decimal(10,2) NOT NULL DEFAULT 0.00,
  `fecha_venta` date NOT NULL,
  `ventasgral` decimal(12,2) NOT NULL DEFAULT 0.00,
  `ventaspromo` decimal(12,2) NOT NULL DEFAULT 0.00,
  `ventasenvases` decimal(12,2) NOT NULL DEFAULT 0.00,
  `ventasservicios` decimal(12,2) NOT NULL DEFAULT 0.00,
  `ventasabarrotes` decimal(12,2) NOT NULL DEFAULT 0.00,
  `ventascredito` decimal(12,2) NOT NULL DEFAULT 0.00,
  `monto_ingreso` decimal(10,2) DEFAULT 0.00,
  `monto_egreso` decimal(10,2) DEFAULT 0.00,
  `total_venta` decimal(11,2) DEFAULT 0.00,
  `estatus` tinyint(1) NOT NULL DEFAULT 0,
  `ultmodificacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `egresos`
--

CREATE TABLE `egresos` (
  `id` int(8) UNSIGNED NOT NULL,
  `fecha_egreso` date NOT NULL,
  `concepto_egreso` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion_egreso` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `importe_egreso` decimal(12,2) NOT NULL,
  `id_caja` tinyint(3) DEFAULT NULL,
  `id_corte` int(7) UNSIGNED NOT NULL DEFAULT 0,
  `ultusuario` tinyint(2) DEFAULT NULL,
  `ultmodificacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE `empresa` (
  `id` tinyint(1) UNSIGNED NOT NULL,
  `razonsocial` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `rfc` varchar(13) COLLATE utf8_spanish_ci NOT NULL,
  `direccion` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `colonia` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `codpostal` int(5) UNSIGNED NOT NULL,
  `ciudad` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL,
  `estado` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL,
  `telempresa` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL,
  `mailempresa` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL,
  `contacto` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `telcontacto` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL,
  `mailcontacto` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL,
  `slogan` varchar(60) COLLATE utf8_spanish_ci DEFAULT NULL,
  `iva` int(2) DEFAULT NULL,
  `imagen` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `impresora` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL,
  `msjpieticket` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `mensajeticket` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `rutarespaldo` varchar(60) COLLATE utf8_spanish_ci DEFAULT NULL,
  `namedatabase` varchar(12) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idterminal` varchar(6) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'AK-001',
  `ultusuario` int(3) DEFAULT NULL,
  `ultmodificacion` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `familias`
--

CREATE TABLE `familias` (
  `id` int(3) NOT NULL,
  `familia` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `ultusuario` tinyint(3) NOT NULL,
  `ultmodificacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hist_entrada`
--

CREATE TABLE `hist_entrada` (
  `id` int(8) UNSIGNED NOT NULL,
  `id_proveedor` int(5) NOT NULL,
  `fechadocto` date NOT NULL,
  `numerodocto` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `fechaentrada` date NOT NULL,
  `recibio` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `id_producto` int(5) NOT NULL,
  `cantidad` float NOT NULL,
  `precio_compra` float(10,2) NOT NULL,
  `id_almacen` int(5) NOT NULL DEFAULT 0,
  `id_tipomov` tinyint(3) UNSIGNED DEFAULT NULL,
  `ultusuario` int(5) NOT NULL,
  `ultmodificacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Historico de entradas';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hist_salidas`
--

CREATE TABLE `hist_salidas` (
  `id` int(8) UNSIGNED NOT NULL,
  `id_cliente` int(3) NOT NULL,
  `num_salida` int(15) UNSIGNED DEFAULT NULL,
  `fecha_salida` date NOT NULL,
  `id_producto` int(5) NOT NULL,
  `cantidad` float NOT NULL,
  `descuento` decimal(5,2) DEFAULT NULL,
  `precio_venta` float(12,2) DEFAULT NULL,
  `id_almacen` int(2) NOT NULL,
  `es_promo` tinyint(1) NOT NULL DEFAULT 0,
  `id_tipomov` tinyint(2) DEFAULT NULL,
  `id_caja` int(2) DEFAULT 0,
  `id_corte` int(7) UNSIGNED NOT NULL DEFAULT 0,
  `id_tipovta` tinyint(1) NOT NULL DEFAULT 0,
  `cerrado` tinyint(1) NOT NULL DEFAULT 0,
  `ultusuario` int(2) DEFAULT NULL,
  `ultmodificacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingresos`
--

CREATE TABLE `ingresos` (
  `id` int(8) UNSIGNED NOT NULL,
  `fecha_ingreso` date NOT NULL,
  `concepto_ingreso` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion_ingreso` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `importe_ingreso` decimal(12,2) NOT NULL,
  `id_caja` tinyint(3) DEFAULT NULL,
  `id_corte` int(7) UNSIGNED NOT NULL DEFAULT 0,
  `ultusuario` tinyint(2) DEFAULT NULL,
  `ultmodificacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `kardex`
--

CREATE TABLE `kardex` (
  `id` int(5) NOT NULL,
  `id_producto` int(5) NOT NULL,
  `codigointerno` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `invinicial` int(6) NOT NULL,
  `january` decimal(7,2) NOT NULL,
  `february` decimal(7,2) NOT NULL,
  `march` decimal(7,2) NOT NULL,
  `april` decimal(7,2) NOT NULL,
  `may` decimal(7,2) NOT NULL,
  `june` decimal(7,2) NOT NULL,
  `july` decimal(7,2) NOT NULL,
  `august` decimal(7,2) NOT NULL,
  `september` decimal(7,2) NOT NULL,
  `october` decimal(7,2) NOT NULL,
  `november` decimal(7,2) NOT NULL,
  `december` decimal(7,2) NOT NULL,
  `ultmodificacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medidas`
--

CREATE TABLE `medidas` (
  `id` int(11) NOT NULL,
  `medida` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `principal`
--

CREATE TABLE `principal` (
  `id` int(5) NOT NULL,
  `id_producto` int(5) NOT NULL,
  `codigointerno` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `cant` float NOT NULL DEFAULT 0,
  `precio_compra` float(10,2) NOT NULL DEFAULT 0.00,
  `margen_utilidad` float(6,2) NOT NULL DEFAULT 0.00,
  `precio_venta` float(10,2) NOT NULL DEFAULT 0.00,
  `fecha_entrada` date NOT NULL,
  `ultmodificacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ultusuario` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(5) NOT NULL,
  `id_familia` int(3) DEFAULT NULL,
  `id_categoria` int(11) NOT NULL,
  `id_medida` int(11) NOT NULL,
  `codigo` text COLLATE utf8_spanish_ci NOT NULL,
  `codigointerno` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  `imagen` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `stock` int(5) NOT NULL DEFAULT 0,
  `minimo` decimal(10,2) DEFAULT NULL,
  `unidadxcaja` smallint(4) DEFAULT NULL,
  `hectolitros` decimal(7,4) DEFAULT NULL,
  `precio_compra` float DEFAULT NULL,
  `margen` float DEFAULT NULL,
  `precio_venta` float DEFAULT NULL,
  `ventas` int(6) DEFAULT 0,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `leyenda` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `totaliza` tinyint(1) NOT NULL DEFAULT 1,
  `granel` tinyint(1) NOT NULL DEFAULT 0,
  `datos_promocion` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `ubicacion` varchar(9) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ultusuario` tinyint(2) DEFAULT NULL,
  `estado` int(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id` int(5) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `rfc` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `direccion` text COLLATE utf8_spanish_ci NOT NULL,
  `codpostal` int(5) DEFAULT NULL,
  `ciudad` text COLLATE utf8_spanish_ci NOT NULL,
  `email` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `telefono` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `contacto` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `tel_contacto` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `email_contacto` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `compras` decimal(14,2) NOT NULL DEFAULT 0.00,
  `ultusuario` tinyint(3) NOT NULL,
  `estatus` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipomovimiento`
--

CREATE TABLE `tipomovimiento` (
  `id` tinyint(2) NOT NULL,
  `nombre_tipo` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `clase` char(1) COLLATE utf8_spanish_ci NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  `idusuario` int(3) NOT NULL,
  `ultmodificacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipomovsalida`
--

CREATE TABLE `tipomovsalida` (
  `id` tinyint(2) NOT NULL,
  `nombre_tipo` varchar(30) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(5) NOT NULL,
  `nombre` text COLLATE utf8_spanish_ci NOT NULL,
  `usuario` text COLLATE utf8_spanish_ci NOT NULL,
  `password` text COLLATE utf8_spanish_ci NOT NULL,
  `perfil` text COLLATE utf8_spanish_ci NOT NULL,
  `foto` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `estado` int(1) NOT NULL DEFAULT 1,
  `administracion` longtext COLLATE utf8_spanish_ci DEFAULT NULL,
  `catalogo` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `reportes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`reportes`)),
  `configura` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`configura`)),
  `ultimo_login` datetime DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `abonoscliente`
--
ALTER TABLE `abonoscliente`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ajusteinventario`
--
ALTER TABLE `ajusteinventario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `almacen2`
--
ALTER TABLE `almacen2`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `almacenes`
--
ALTER TABLE `almacenes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `cajas`
--
ALTER TABLE `cajas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `caja` (`caja`);

--
-- Indices de la tabla `cancela_venta`
--
ALTER TABLE `cancela_venta`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `catestado`
--
ALTER TABLE `catestado`
  ADD PRIMARY KEY (`idestado`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cobrosdeventas`
--
ALTER TABLE `cobrosdeventas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cortes`
--
ALTER TABLE `cortes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `egresos`
--
ALTER TABLE `egresos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `familias`
--
ALTER TABLE `familias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `hist_entrada`
--
ALTER TABLE `hist_entrada`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `hist_salidas`
--
ALTER TABLE `hist_salidas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ingresos`
--
ALTER TABLE `ingresos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `kardex`
--
ALTER TABLE `kardex`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `medidas`
--
ALTER TABLE `medidas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `principal`
--
ALTER TABLE `principal`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigointerno` (`codigointerno`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipomovimiento`
--
ALTER TABLE `tipomovimiento`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre_tipo` (`nombre_tipo`);

--
-- Indices de la tabla `tipomovsalida`
--
ALTER TABLE `tipomovsalida`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `abonoscliente`
--
ALTER TABLE `abonoscliente`
  MODIFY `id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ajusteinventario`
--
ALTER TABLE `ajusteinventario`
  MODIFY `id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `almacen2`
--
ALTER TABLE `almacen2`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `almacenes`
--
ALTER TABLE `almacenes`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cajas`
--
ALTER TABLE `cajas`
  MODIFY `id` int(2) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cancela_venta`
--
ALTER TABLE `cancela_venta`
  MODIFY `id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `catestado`
--
ALTER TABLE `catestado`
  MODIFY `idestado` int(2) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cobrosdeventas`
--
ALTER TABLE `cobrosdeventas`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cortes`
--
ALTER TABLE `cortes`
  MODIFY `id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `egresos`
--
ALTER TABLE `egresos`
  MODIFY `id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `empresa`
--
ALTER TABLE `empresa`
  MODIFY `id` tinyint(1) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `familias`
--
ALTER TABLE `familias`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `hist_entrada`
--
ALTER TABLE `hist_entrada`
  MODIFY `id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `hist_salidas`
--
ALTER TABLE `hist_salidas`
  MODIFY `id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ingresos`
--
ALTER TABLE `ingresos`
  MODIFY `id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `kardex`
--
ALTER TABLE `kardex`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `medidas`
--
ALTER TABLE `medidas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `principal`
--
ALTER TABLE `principal`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipomovimiento`
--
ALTER TABLE `tipomovimiento`
  MODIFY `id` tinyint(2) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipomovsalida`
--
ALTER TABLE `tipomovsalida`
  MODIFY `id` tinyint(2) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
