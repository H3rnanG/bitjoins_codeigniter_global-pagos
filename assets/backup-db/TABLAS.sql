-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 16-04-2026 a las 16:08:29
-- Versión del servidor: 8.0.39-0ubuntu0.22.04.1
-- Versión de PHP: 8.1.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `dbGlobalCaluladora`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrador`
--

CREATE TABLE `administrador` (
  `id` int NOT NULL,
  `nombre` varchar(250) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `password` varchar(250) NOT NULL,
  `tipo` tinyint NOT NULL DEFAULT '1' COMMENT '0- Ghost\n1- Administrador\n2- Asistente',
  `dash` varchar(50) DEFAULT NULL,
  `estado` tinyint NOT NULL DEFAULT '1',
  `fechareg` date NOT NULL,
  `token` char(6) DEFAULT '000000'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calculadora_agencia`
--

CREATE TABLE `calculadora_agencia` (
  `id` int NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `estado` tinyint NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calculadora_agencia_peso`
--

CREATE TABLE `calculadora_agencia_peso` (
  `id` int NOT NULL,
  `peso` decimal(8,2) NOT NULL DEFAULT '0.00',
  `zona1` decimal(8,2) NOT NULL DEFAULT '0.00',
  `zona2` decimal(8,2) NOT NULL DEFAULT '0.00',
  `zona3` decimal(8,2) NOT NULL DEFAULT '0.00',
  `zona4` decimal(8,2) NOT NULL DEFAULT '0.00',
  `zona5` decimal(8,2) NOT NULL DEFAULT '0.00',
  `zona6` decimal(8,2) NOT NULL DEFAULT '0.00',
  `estado` tinyint NOT NULL DEFAULT '0',
  `calculadora_agencia_id` int NOT NULL,
  `tipo` tinyint NOT NULL DEFAULT '1' COMMENT '1- paquete / 2- sobre'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calculadora_login`
--

CREATE TABLE `calculadora_login` (
  `id` int NOT NULL,
  `usuario` varchar(80) NOT NULL,
  `password` varchar(50) NOT NULL,
  `nombres` varchar(250) DEFAULT NULL,
  `user_email` varchar(150) NOT NULL,
  `comision_cargo` tinyint NOT NULL DEFAULT '12',
  `tc_dscto` tinyint NOT NULL DEFAULT '2',
  `formato` tinyint NOT NULL DEFAULT '1',
  `tienda` varchar(50) DEFAULT 'wu',
  `fechareg` date NOT NULL,
  `estado` tinyint NOT NULL DEFAULT '1',
  `calculadora_tienda_id` int NOT NULL DEFAULT '1',
  `login_parent` int NOT NULL DEFAULT '0',
  `fecha` date DEFAULT NULL,
  `operacion` int DEFAULT '1',
  `rutalocal` varchar(255) DEFAULT NULL,
  `ip` varchar(20) DEFAULT NULL,
  `pais` varchar(60) DEFAULT NULL,
  `ciudad` varchar(60) DEFAULT NULL,
  `latlon` varchar(60) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calculadora_pais`
--

CREATE TABLE `calculadora_pais` (
  `id` int NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `zona_fdx_ie` varchar(5) DEFAULT NULL,
  `zona_dhl_ie` varchar(5) DEFAULT NULL,
  `estado` tinyint NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calculadora_tienda`
--

CREATE TABLE `calculadora_tienda` (
  `id` int NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `direccion` varchar(200) NOT NULL,
  `estado` tinyint NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calculadora_transferencias`
--

CREATE TABLE `calculadora_transferencias` (
  `id` int NOT NULL,
  `calculadora_login_id` int NOT NULL,
  `pais` tinyint NOT NULL DEFAULT '1' COMMENT '1- Otros Paises\n2- Colombia',
  `ing_mnt` varchar(80) NOT NULL DEFAULT '0',
  `ing_crg` varchar(80) NOT NULL DEFAULT '0',
  `ing_crg_2` varchar(80) DEFAULT '0',
  `ing_tipo` tinyint NOT NULL DEFAULT '1',
  `ing_com` tinyint NOT NULL DEFAULT '12',
  `ing_iva` tinyint NOT NULL DEFAULT '19',
  `ing_tiva` varchar(80) NOT NULL DEFAULT '0',
  `ing_tiva_2` varchar(80) DEFAULT '0',
  `ing_dct` tinyint NOT NULL DEFAULT '2',
  `ing_tc` varchar(80) DEFAULT NULL,
  `ing_tcact` varchar(80) DEFAULT NULL,
  `ing_appago` varchar(80) DEFAULT NULL,
  `edt_mnt` varchar(80) NOT NULL DEFAULT '0',
  `edt_cargo` varchar(80) DEFAULT '0',
  `edt_iva` varchar(45) DEFAULT '0',
  `edt_sbt` varchar(80) NOT NULL DEFAULT '0',
  `edt_tot` varchar(80) NOT NULL DEFAULT '0',
  `edt_tc` varchar(80) NOT NULL DEFAULT '0',
  `edt_appago` varchar(80) NOT NULL DEFAULT '0',
  `adjunto` varchar(80) NOT NULL,
  `fecha` date DEFAULT NULL,
  `hora` varchar(10) DEFAULT NULL,
  `formato` tinyint DEFAULT '1',
  `print` tinyint DEFAULT '0',
  `estado` tinyint NOT NULL DEFAULT '1',
  `calculadora_tienda_id` int NOT NULL DEFAULT '1',
  `utilidad` decimal(16,2) NOT NULL DEFAULT '0.00',
  `nroboleta` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `constantes`
--

CREATE TABLE `constantes` (
  `id` int NOT NULL,
  `constante` varchar(20) NOT NULL,
  `variable` varchar(40) NOT NULL,
  `fechaact` date NOT NULL,
  `horaact` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recargas`
--

CREATE TABLE `recargas` (
  `id` int NOT NULL,
  `nroope` varchar(20) NOT NULL,
  `usuario_id` int NOT NULL,
  `monto_usd` decimal(8,0) NOT NULL DEFAULT '0',
  `monto_clp` decimal(8,0) NOT NULL DEFAULT '0',
  `tipocambio` decimal(8,0) NOT NULL,
  `fechareg` datetime NOT NULL,
  `fechaconf` datetime DEFAULT NULL,
  `horaconf` varchar(10) DEFAULT NULL,
  `fechamail` datetime DEFAULT NULL,
  `tipopago` tinyint NOT NULL DEFAULT '1',
  `metodopago` tinyint NOT NULL DEFAULT '1' COMMENT '1 - KHIPU\n2 - TRANSFERENCIA',
  `estado` tinyint NOT NULL DEFAULT '1',
  `payment_id` varchar(30) DEFAULT NULL,
  `payment_url` varchar(250) DEFAULT NULL,
  `envio` char(1) NOT NULL DEFAULT 'W',
  `ip` varchar(20) DEFAULT NULL,
  `latlon` varchar(60) DEFAULT NULL,
  `pais` varchar(60) DEFAULT NULL,
  `ciudad` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recargas_tarjetas`
--

CREATE TABLE `recargas_tarjetas` (
  `id` int NOT NULL,
  `monto` int NOT NULL DEFAULT '10' COMMENT '10 - 25 - 50 - 100 - 200 - 500',
  `foto` varchar(100) NOT NULL,
  `fechareg` date NOT NULL,
  `horareg` varchar(8) NOT NULL,
  `fechacomp` date DEFAULT NULL,
  `horacomp` varchar(8) DEFAULT NULL,
  `digitos` varchar(20) DEFAULT NULL,
  `tipo` tinyint NOT NULL DEFAULT '1',
  `nmt` varchar(250) DEFAULT NULL,
  `nmc` varchar(50) DEFAULT NULL,
  `exp` varchar(20) DEFAULT NULL,
  `mon` varchar(5) DEFAULT NULL,
  `usuario` varchar(80) DEFAULT NULL,
  `estado` tinyint NOT NULL DEFAULT '1' COMMENT '1- disponible\n2- comprada'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recargas_x_tarjetas`
--

CREATE TABLE `recargas_x_tarjetas` (
  `recargas_id` int NOT NULL,
  `recargas_tarjetas_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `password` varchar(120) NOT NULL,
  `nombres` varchar(250) NOT NULL,
  `apellidos` varchar(150) NOT NULL,
  `direccion` varchar(200) NOT NULL,
  `distrito` varchar(150) NOT NULL,
  `celular` varchar(20) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `billetera` varchar(20) NOT NULL,
  `nrowsp` varchar(20) NOT NULL,
  `nacionalidad` varchar(100) NOT NULL,
  `tipodoc` tinyint NOT NULL DEFAULT '1',
  `documento` varchar(15) NOT NULL,
  `dni1` varchar(100) NOT NULL,
  `dni2` varchar(100) NOT NULL,
  `reciboservicio` varchar(100) NOT NULL,
  `fechareg` date NOT NULL,
  `sw` tinyint DEFAULT '2',
  `fechoraconf` datetime DEFAULT NULL,
  `estado` tinyint NOT NULL DEFAULT '1',
  `token` varchar(20) DEFAULT NULL,
  `terminos` text NOT NULL,
  `ip` varchar(20) NOT NULL,
  `pais` varchar(60) NOT NULL,
  `ciudad` varchar(60) NOT NULL,
  `latlon` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_log`
--

CREATE TABLE `usuario_log` (
  `id` int NOT NULL,
  `usuario_id` int NOT NULL,
  `fecha` date NOT NULL,
  `hora` varchar(10) NOT NULL,
  `ip` varchar(20) DEFAULT NULL,
  `pais` varchar(60) DEFAULT NULL,
  `ciudad` varchar(60) DEFAULT NULL,
  `latlon` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `calculadora_agencia`
--
ALTER TABLE `calculadora_agencia`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `calculadora_agencia_peso`
--
ALTER TABLE `calculadora_agencia_peso`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_calculadora_agencia_peso_calculadora_agencia1_idx` (`calculadora_agencia_id`);

--
-- Indices de la tabla `calculadora_login`
--
ALTER TABLE `calculadora_login`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario_UNIQUE` (`usuario`),
  ADD KEY `fk_calculadora_login_calculadora_tienda1_idx` (`calculadora_tienda_id`);

--
-- Indices de la tabla `calculadora_pais`
--
ALTER TABLE `calculadora_pais`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `calculadora_tienda`
--
ALTER TABLE `calculadora_tienda`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `calculadora_transferencias`
--
ALTER TABLE `calculadora_transferencias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_calculadora_transferencias_calculadora_login1_idx` (`calculadora_login_id`),
  ADD KEY `fk_calculadora_transferencias_calculadora_tienda1_idx` (`calculadora_tienda_id`);

--
-- Indices de la tabla `constantes`
--
ALTER TABLE `constantes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `constante_UNIQUE` (`constante`);

--
-- Indices de la tabla `recargas`
--
ALTER TABLE `recargas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nroope_UNIQUE` (`nroope`),
  ADD KEY `fk_recargas_usuario_idx` (`usuario_id`);

--
-- Indices de la tabla `recargas_tarjetas`
--
ALTER TABLE `recargas_tarjetas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `recargas_x_tarjetas`
--
ALTER TABLE `recargas_x_tarjetas`
  ADD PRIMARY KEY (`recargas_id`,`recargas_tarjetas_id`),
  ADD KEY `fk_recargas_has_recargas_tarjetas_recargas_tarjetas1_idx` (`recargas_tarjetas_id`),
  ADD KEY `fk_recargas_has_recargas_tarjetas_recargas1_idx` (`recargas_id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario_log`
--
ALTER TABLE `usuario_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_usuario_log_usuario1_idx` (`usuario_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administrador`
--
ALTER TABLE `administrador`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `calculadora_agencia`
--
ALTER TABLE `calculadora_agencia`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `calculadora_agencia_peso`
--
ALTER TABLE `calculadora_agencia_peso`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `calculadora_login`
--
ALTER TABLE `calculadora_login`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `calculadora_pais`
--
ALTER TABLE `calculadora_pais`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `calculadora_tienda`
--
ALTER TABLE `calculadora_tienda`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `calculadora_transferencias`
--
ALTER TABLE `calculadora_transferencias`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `constantes`
--
ALTER TABLE `constantes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `recargas`
--
ALTER TABLE `recargas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `recargas_tarjetas`
--
ALTER TABLE `recargas_tarjetas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario_log`
--
ALTER TABLE `usuario_log`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `calculadora_login`
--
ALTER TABLE `calculadora_login`
  ADD CONSTRAINT `fk_calculadora_login_calculadora_tienda1` FOREIGN KEY (`calculadora_tienda_id`) REFERENCES `calculadora_tienda` (`id`);

--
-- Filtros para la tabla `calculadora_transferencias`
--
ALTER TABLE `calculadora_transferencias`
  ADD CONSTRAINT `fk_calculadora_transferencias_calculadora_login1` FOREIGN KEY (`calculadora_login_id`) REFERENCES `calculadora_login` (`id`),
  ADD CONSTRAINT `fk_calculadora_transferencias_calculadora_tienda1` FOREIGN KEY (`calculadora_tienda_id`) REFERENCES `calculadora_tienda` (`id`);

--
-- Filtros para la tabla `recargas`
--
ALTER TABLE `recargas`
  ADD CONSTRAINT `fk_recargas_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `recargas_x_tarjetas`
--
ALTER TABLE `recargas_x_tarjetas`
  ADD CONSTRAINT `fk_recargas_has_recargas_tarjetas_recargas1` FOREIGN KEY (`recargas_id`) REFERENCES `recargas` (`id`),
  ADD CONSTRAINT `fk_recargas_has_recargas_tarjetas_recargas_tarjetas1` FOREIGN KEY (`recargas_tarjetas_id`) REFERENCES `recargas_tarjetas` (`id`);

--
-- Filtros para la tabla `usuario_log`
--
ALTER TABLE `usuario_log`
  ADD CONSTRAINT `fk_usuario_log_usuario1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
