CREATE TABLE `roles` (
  `idrol` int PRIMARY KEY AUTO_INCREMENT,
  `rol_descripcion` varchar(45),
  `estado` enum(Activo,Inactivo),
  `fecha_registro` timestamp
);

CREATE TABLE `usuarios` (
  `idusu` int PRIMARY KEY AUTO_INCREMENT,
  `usua_nombre` varchar(45),
  `rol_idrol` int,
  `muni_idmuni` int,
  `depar_iddepar` int,
  `estado` enum(Activo,Inactivo),
  `fecha_registro` timestamp
);

CREATE TABLE `modulos` (
  `idmod` int PRIMARY KEY AUTO_INCREMENT,
  `modu_descripcion` varchar(45),
  `estado` enum(Activo,Inactivo),
  `fecha_registro` timestamp
);

CREATE TABLE `permisos` (
  `idper` int PRIMARY KEY AUTO_INCREMENT,
  `permiscol` varchar(45),
  `estado` enum(Activo,Inactivo),
  `fecha_registro` timestamp
);

CREATE TABLE `roles_has_modulos` (
  `rol_idrol` int,
  `mod_idmod` int,
  `per_idper` int
);

CREATE TABLE `municipios` (
  `idmuni` int PRIMARY KEY AUTO_INCREMENT,
  `muni_nombre` varchar(45),
  `estado` enum(Activo,Inactivo),
  `fecha_registro` timestamp
);

CREATE TABLE `departamentos` (
  `iddepar` int PRIMARY KEY AUTO_INCREMENT,
  `depar_nombre` varchar(45),
  `estado` enum(Activo,Inactivo),
  `fecha_registro` timestamp
);

CREATE TABLE `ingresos` (
  `iding` int PRIMARY KEY AUTO_INCREMENT,
  `ingre_monto` decimal(10,2),
  `ingre_fecha` date,
  `ingre_descripcion` varchar(255),
  `contpuc_idcontpuc` int,
  `usu_idusu` int,
  `estado` enum(Activo,Inactivo),
  `fecha_registro` timestamp
);

CREATE TABLE `egresos` (
  `idegr` int PRIMARY KEY AUTO_INCREMENT,
  `egres_monto` decimal(10,2),
  `egres_fecha` date,
  `egres_descripcion` varchar(255),
  `egres_tipo` enum(Fijo,Variable),
  `contpuc_idcontpuc` int,
  `usu_idusu` int,
  `estado` enum(Activo,Inactivo),
  `fecha_registro` timestamp
);

CREATE TABLE `inversiones` (
  `idinv` int PRIMARY KEY AUTO_INCREMENT,
  `inves_monto` decimal(10,2),
  `inves_fecha` date,
  `inves_tipo_inversion` varchar(100),
  `inves_descripcion` varchar(255),
  `usu_idusu` int,
  `estado` enum(Activo,Inactivo),
  `fecha_registro` timestamp
);

CREATE TABLE `costos_fijos` (
  `idcosf` int PRIMARY KEY AUTO_INCREMENT,
  `costf_monto` decimal(10,2),
  `costf_descripcion` varchar(255),
  `usu_idusu` int,
  `estado` enum(Activo,Inactivo),
  `fecha_registro` timestamp
);

CREATE TABLE `costos_variables` (
  `idcosv` int PRIMARY KEY AUTO_INCREMENT,
  `costv_monto` decimal(10,2),
  `costv_descripcion` varchar(255),
  `usu_idusu` int,
  `estado` enum(Activo,Inactivo),
  `fecha_registro` timestamp
);

CREATE TABLE `metas_ahorro` (
  `idmetah` int PRIMARY KEY AUTO_INCREMENT,
  `metah_monto` decimal(10,2),
  `metah_descripcion` varchar(255),
  `metah_fecha_meta` date,
  `usu_idusu` int,
  `estado` enum(Activo,Inactivo),
  `fecha_registro` timestamp
);

CREATE TABLE `alertas` (
  `idaler` int PRIMARY KEY AUTO_INCREMENT,
  `aler_mensaje` varchar(255),
  `aler_fecha_alerta` date,
  `aler_estado` enum(Pendiente,Resuelta),
  `usu_idusu` int,
  `estado` enum(Activo,Inactivo),
  `fecha_registro` timestamp
);

CREATE TABLE `contrapartida_PUC` (
  `idcontpuc` int PRIMARY KEY AUTO_INCREMENT,
  `contpuc_codigo` varchar(45),
  `contpuc_descripcion` varchar(255),
  `contpuc_tipo` enum(Ingreso,Egreso),
  `puc_idpuc` int,
  `estado` enum(Activo,Inactivo),
  `fecha_registro` timestamp
);

CREATE TABLE `puc` (
  `idpuc` int PRIMARY KEY AUTO_INCREMENT,
  `puc_codigo` varchar(45),
  `puc_descripcion` varchar(255),
  `puc_naturaleza` enum(Deudora,Acreedora),
  `estado` enum(Activo,Inactivo),
  `fecha_registro` timestamp
);

ALTER TABLE `usuarios` ADD FOREIGN KEY (`rol_idrol`) REFERENCES `roles` (`idrol`);

ALTER TABLE `usuarios` ADD FOREIGN KEY (`muni_idmuni`) REFERENCES `municipios` (`idmuni`);

ALTER TABLE `usuarios` ADD FOREIGN KEY (`depar_iddepar`) REFERENCES `departamentos` (`iddepar`);

ALTER TABLE `roles_has_modulos` ADD FOREIGN KEY (`rol_idrol`) REFERENCES `roles` (`idrol`);

ALTER TABLE `roles_has_modulos` ADD FOREIGN KEY (`mod_idmod`) REFERENCES `modulos` (`idmod`);

ALTER TABLE `roles_has_modulos` ADD FOREIGN KEY (`per_idper`) REFERENCES `permisos` (`idper`);

ALTER TABLE `ingresos` ADD FOREIGN KEY (`contpuc_idcontpuc`) REFERENCES `contrapartida_PUC` (`idcontpuc`);

ALTER TABLE `ingresos` ADD FOREIGN KEY (`usu_idusu`) REFERENCES `usuarios` (`idusu`);

ALTER TABLE `egresos` ADD FOREIGN KEY (`contpuc_idcontpuc`) REFERENCES `contrapartida_PUC` (`idcontpuc`);

ALTER TABLE `egresos` ADD FOREIGN KEY (`usu_idusu`) REFERENCES `usuarios` (`idusu`);

ALTER TABLE `inversiones` ADD FOREIGN KEY (`usu_idusu`) REFERENCES `usuarios` (`idusu`);

ALTER TABLE `costos_fijos` ADD FOREIGN KEY (`usu_idusu`) REFERENCES `usuarios` (`idusu`);

ALTER TABLE `costos_variables` ADD FOREIGN KEY (`usu_idusu`) REFERENCES `usuarios` (`idusu`);

ALTER TABLE `metas_ahorro` ADD FOREIGN KEY (`usu_idusu`) REFERENCES `usuarios` (`idusu`);

ALTER TABLE `alertas` ADD FOREIGN KEY (`usu_idusu`) REFERENCES `usuarios` (`idusu`);

ALTER TABLE `contrapartida_PUC` ADD FOREIGN KEY (`puc_idpuc`) REFERENCES `puc` (`idpuc`);
