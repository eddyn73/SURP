-- MySQL Administrator dump 1.4
--
-- ------------------------------------------------------
-- Server version	5.6.15


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


--
-- Create schema shc
--

CREATE DATABASE IF NOT EXISTS shc;
USE shc;

--
-- Definition of table `_accion`
--

DROP TABLE IF EXISTS `_accion`;
CREATE TABLE `_accion` (
  `idAccion` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  `descripcion` varchar(150) DEFAULT NULL,
  `mensaje` varchar(150) DEFAULT NULL,
  `orden` int(11) DEFAULT NULL,
  PRIMARY KEY (`idAccion`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `_accion`
--

/*!40000 ALTER TABLE `_accion` DISABLE KEYS */;
INSERT INTO `_accion` (`idAccion`,`nombre`,`descripcion`,`mensaje`,`orden`) VALUES 
 (1,'read','Lectura','Permiso negado para lectura',1),
 (2,'create','Crear','Permiso negado para crear',2),
 (3,'update','Actualizar','Permiso negado para actualizar',3),
 (4,'delete','Eliminar','Permiso negado para eliminar',4);
/*!40000 ALTER TABLE `_accion` ENABLE KEYS */;


--
-- Definition of table `_accionmoduloperfil`
--

DROP TABLE IF EXISTS `_accionmoduloperfil`;
CREATE TABLE `_accionmoduloperfil` (
  `idAccionModuloPerfil` int(11) NOT NULL AUTO_INCREMENT,
  `idAccion` int(11) NOT NULL,
  `idModuloPerfil` int(11) NOT NULL,
  PRIMARY KEY (`idAccionModuloPerfil`),
  KEY `fk__accionmoduloperfil__accion1_idx` (`idAccion`),
  KEY `fk__accionmoduloperfil__moduloperfil1_idx` (`idModuloPerfil`),
  CONSTRAINT `fk__accionmoduloperfil__accion1` FOREIGN KEY (`idAccion`) REFERENCES `_accion` (`idAccion`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk__accionmoduloperfil__moduloperfil1` FOREIGN KEY (`idModuloPerfil`) REFERENCES `_moduloperfil` (`idModuloPerfil`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `_accionmoduloperfil`
--

/*!40000 ALTER TABLE `_accionmoduloperfil` DISABLE KEYS */;
INSERT INTO `_accionmoduloperfil` (`idAccionModuloPerfil`,`idAccion`,`idModuloPerfil`) VALUES 
 (1,1,1),
 (2,2,1),
 (3,3,1),
 (4,4,1),
 (5,1,2),
 (6,2,2),
 (7,3,2),
 (8,4,2),
 (9,1,3),
 (10,2,3),
 (11,3,3),
 (12,4,3),
 (13,1,4),
 (14,2,4),
 (15,3,4),
 (16,4,4),
 (17,1,5),
 (18,2,5),
 (19,3,5),
 (20,4,5),
 (21,1,6),
 (22,2,6),
 (23,3,6),
 (24,4,6),
 (25,1,7),
 (26,2,7),
 (27,3,7),
 (28,4,7);
/*!40000 ALTER TABLE `_accionmoduloperfil` ENABLE KEYS */;


--
-- Definition of table `_configuracion`
--

DROP TABLE IF EXISTS `_configuracion`;
CREATE TABLE `_configuracion` (
  `nombre` varchar(100) NOT NULL,
  `valor` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `_configuracion`
--

/*!40000 ALTER TABLE `_configuracion` DISABLE KEYS */;
INSERT INTO `_configuracion` (`nombre`,`valor`) VALUES 
 ('autor','Sistema de Historia Clinica'),
 ('fotoUsuarioPorDefecto','vista/imagen/user.png'),
 ('icono','vista/imagen/ico.ico'),
 ('idPerfilDeveloperSenior','1'),
 ('keyword','Sistema de Historia Clinica'),
 ('load_logo','vista/imagen/logoload.png'),
 ('load_progress','vista/imagen/scs_progress_bar.gif'),
 ('templatePrivate','vista/private/default/'),
 ('templatePrivateController','vista/private/default/controller.php'),
 ('templatePublic','vista/public/default/'),
 ('templatePublicController','vista/public/default/controller.php'),
 ('title','Sistema de Historia Clinica');
/*!40000 ALTER TABLE `_configuracion` ENABLE KEYS */;


--
-- Definition of table `_historial`
--

DROP TABLE IF EXISTS `_historial`;
CREATE TABLE `_historial` (
  `idHistorial` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` int(11) DEFAULT NULL,
  `carpeta` varchar(100) DEFAULT NULL,
  `archivo` varchar(100) DEFAULT NULL,
  `parametros` varchar(255) DEFAULT NULL,
  `query` varchar(255) DEFAULT NULL,
  `pAnterior` varchar(150) DEFAULT NULL,
  `css` varchar(45) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `ip` varchar(15) DEFAULT NULL,
  `registro` datetime DEFAULT NULL,
  PRIMARY KEY (`idHistorial`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `_historial`
--

/*!40000 ALTER TABLE `_historial` DISABLE KEYS */;
/*!40000 ALTER TABLE `_historial` ENABLE KEYS */;


--
-- Definition of table `_modulo`
--

DROP TABLE IF EXISTS `_modulo`;
CREATE TABLE `_modulo` (
  `idModulo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `carpeta` varchar(100) DEFAULT NULL,
  `descripcion` varchar(250) DEFAULT NULL,
  `imagen` varchar(100) DEFAULT NULL,
  `persistente` int(1) unsigned DEFAULT NULL,
  `estado` int(1) DEFAULT NULL,
  `orden` int(11) DEFAULT NULL,
  PRIMARY KEY (`idModulo`),
  UNIQUE KEY `carpeta_UNIQUE` (`carpeta`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `_modulo`
--

/*!40000 ALTER TABLE `_modulo` DISABLE KEYS */;
INSERT INTO `_modulo` (`idModulo`,`nombre`,`carpeta`,`descripcion`,`imagen`,`persistente`,`estado`,`orden`) VALUES 
 (1,'Plantillas UI','plantillasui',NULL,NULL,NULL,1,1),
 (2,'Reservar Cita','reservarcita',NULL,NULL,NULL,1,2),
 (3,'Consulta Médica','consultamedica',NULL,NULL,NULL,1,3),
 (4,'Archivamiento','archivamiento',NULL,NULL,NULL,1,4);
/*!40000 ALTER TABLE `_modulo` ENABLE KEYS */;


--
-- Definition of table `_moduloperfil`
--

DROP TABLE IF EXISTS `_moduloperfil`;
CREATE TABLE `_moduloperfil` (
  `idModuloPerfil` int(11) NOT NULL AUTO_INCREMENT,
  `idPerfil` int(11) NOT NULL,
  `idModulo` int(11) NOT NULL,
  PRIMARY KEY (`idModuloPerfil`),
  KEY `fk__moduloperfil__perfil1_idx` (`idPerfil`),
  KEY `fk__moduloperfil__modulo1_idx` (`idModulo`),
  CONSTRAINT `fk__moduloperfil__modulo1` FOREIGN KEY (`idModulo`) REFERENCES `_modulo` (`idModulo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk__moduloperfil__perfil1` FOREIGN KEY (`idPerfil`) REFERENCES `_perfil` (`idPerfil`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `_moduloperfil`
--

/*!40000 ALTER TABLE `_moduloperfil` DISABLE KEYS */;
INSERT INTO `_moduloperfil` (`idModuloPerfil`,`idPerfil`,`idModulo`) VALUES 
 (1,1,1),
 (2,1,2),
 (3,1,3),
 (4,1,4),
 (5,2,4),
 (6,4,3),
 (7,5,2);
/*!40000 ALTER TABLE `_moduloperfil` ENABLE KEYS */;


--
-- Definition of table `_perfil`
--

DROP TABLE IF EXISTS `_perfil`;
CREATE TABLE `_perfil` (
  `idPerfil` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  `orden` int(11) DEFAULT NULL,
  PRIMARY KEY (`idPerfil`),
  UNIQUE KEY `nombre_UNIQUE` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `_perfil`
--

/*!40000 ALTER TABLE `_perfil` DISABLE KEYS */;
INSERT INTO `_perfil` (`idPerfil`,`nombre`,`orden`) VALUES 
 (1,'SuqperAdmin',1),
 (2,'Archivador',2),
 (3,'Paciente',3),
 (4,'Medico',4),
 (5,'Recepcionista',5);
/*!40000 ALTER TABLE `_perfil` ENABLE KEYS */;


--
-- Definition of table `_usuario`
--

DROP TABLE IF EXISTS `_usuario`;
CREATE TABLE `_usuario` (
  `idUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(50) DEFAULT NULL,
  `clave` varchar(50) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `imagen` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `plantillaui` varchar(250) DEFAULT NULL,
  `orden` int(11) DEFAULT NULL,
  `idPerfil` int(11) NOT NULL,
  PRIMARY KEY (`idUsuario`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  UNIQUE KEY `usuario_UNIQUE` (`usuario`),
  KEY `fk__usuario__perfil1_idx` (`idPerfil`),
  CONSTRAINT `fk__usuario__perfil1` FOREIGN KEY (`idPerfil`) REFERENCES `_perfil` (`idPerfil`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `_usuario`
--

/*!40000 ALTER TABLE `_usuario` DISABLE KEYS */;
INSERT INTO `_usuario` (`idUsuario`,`usuario`,`clave`,`nombre`,`apellido`,`imagen`,`email`,`plantillaui`,`orden`,`idPerfil`) VALUES 
 (1,'admin','123123','admin','super',NULL,NULL,NULL,NULL,1),
 (2,'jhidalgo','123123','Juan','Hidalgo',NULL,NULL,NULL,NULL,2),
 (3,'epalomino','123123','Edison','Palomino',NULL,NULL,NULL,NULL,4),
 (4,'nvega','123123','Neil','Vega',NULL,NULL,NULL,NULL,4),
 (5,'rtapia','123123','Rosa','Tapia',NULL,NULL,NULL,NULL,5);
/*!40000 ALTER TABLE `_usuario` ENABLE KEYS */;


--
-- Definition of table `shc_detalle`
--

DROP TABLE IF EXISTS `shc_detalle`;
CREATE TABLE `shc_detalle` (
  `idPaciente` int(11) NOT NULL,
  `idDetalle` int(11) NOT NULL AUTO_INCREMENT,
  `idMedico` int(11) DEFAULT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  `registro` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idDetalle`),
  KEY `fk_shc_detalle_shc_historia1_idx` (`idPaciente`),
  CONSTRAINT `fk_shc_detalle_shc_historia1` FOREIGN KEY (`idPaciente`) REFERENCES `shc_historia` (`idPaciente`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `shc_detalle`
--

/*!40000 ALTER TABLE `shc_detalle` DISABLE KEYS */;
INSERT INTO `shc_detalle` (`idPaciente`,`idDetalle`,`idMedico`,`descripcion`,`registro`) VALUES 
 (1,1,4,'Gripe','2000-10-16 14:00:12'),
 (2,2,4,'Fiebre','2000-10-16 14:00:12'),
 (3,3,4,'Dolor de estomago','2000-10-16 14:00:12'),
 (4,4,4,'Desmayo','2000-10-16 14:00:12'),
 (5,5,4,'Fiebre','2000-10-16 14:00:12'),
 (6,6,4,'Dolor de Diente','2000-10-16 14:00:12'),
 (1,7,4,'Intoxicación','2000-10-17 14:00:12');
/*!40000 ALTER TABLE `shc_detalle` ENABLE KEYS */;


--
-- Definition of table `shc_historia`
--

DROP TABLE IF EXISTS `shc_historia`;
CREATE TABLE `shc_historia` (
  `idPaciente` int(11) NOT NULL,
  `altura` varchar(45) DEFAULT NULL,
  `presion` varchar(45) DEFAULT NULL,
  `temperatura` varchar(45) DEFAULT NULL,
  `tipoSangre` varchar(45) DEFAULT NULL,
  `registro` datetime DEFAULT NULL,
  `estado` int(1) DEFAULT NULL,
  PRIMARY KEY (`idPaciente`),
  KEY `fk_shc_historia_shc_paciente1_idx` (`idPaciente`),
  CONSTRAINT `fk_shc_historia_shc_paciente1` FOREIGN KEY (`idPaciente`) REFERENCES `shc_paciente` (`idPaciente`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `shc_historia`
--

/*!40000 ALTER TABLE `shc_historia` DISABLE KEYS */;
INSERT INTO `shc_historia` (`idPaciente`,`altura`,`presion`,`temperatura`,`tipoSangre`,`registro`,`estado`) VALUES 
 (1,'1.6',NULL,NULL,'A','2000-10-16 14:00:12',1),
 (2,'1.77',NULL,NULL,'B','2000-10-16 14:00:12',1),
 (3,'2',NULL,NULL,'O','2000-10-16 14:00:12',1),
 (4,'1.8',NULL,NULL,'A','2000-10-16 14:00:12',1),
 (5,'1.5',NULL,NULL,'B','2000-10-16 14:00:12',1),
 (6,'1.9',NULL,NULL,'AB','2000-10-16 14:00:12',1);
/*!40000 ALTER TABLE `shc_historia` ENABLE KEYS */;


--
-- Definition of table `shc_paciente`
--

DROP TABLE IF EXISTS `shc_paciente`;
CREATE TABLE `shc_paciente` (
  `idPaciente` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  `apellido` varchar(45) DEFAULT NULL,
  `dni` varchar(10) DEFAULT NULL,
  `sexo` varchar(1) DEFAULT NULL,
  `foto` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`idPaciente`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `shc_paciente`
--

/*!40000 ALTER TABLE `shc_paciente` DISABLE KEYS */;
INSERT INTO `shc_paciente` (`idPaciente`,`nombre`,`apellido`,`dni`,`sexo`,`foto`) VALUES 
 (1,'Jorge','Danayre','43666582','m',NULL),
 (2,'Rosa','Poma','45888745','f',NULL),
 (3,'Javier','Montes','25477856','m',NULL),
 (4,'Elvira','Febres','47778745','f',NULL),
 (5,'Antonio','Chavez','11254786','m',NULL),
 (6,'Liz','Castro','77458874','f',NULL);
/*!40000 ALTER TABLE `shc_paciente` ENABLE KEYS */;


--
-- Definition of table `shc_reserva`
--

DROP TABLE IF EXISTS `shc_reserva`;
CREATE TABLE `shc_reserva` (
  `idPaciente` int(11) NOT NULL,
  `idRecepcionista` int(11) NOT NULL,
  `idReserva` int(11) NOT NULL AUTO_INCREMENT,
  `idMedico` int(11) DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `estado` int(1) DEFAULT NULL,
  PRIMARY KEY (`idReserva`),
  KEY `fk_shc_reserva__usuario_idx` (`idRecepcionista`),
  KEY `fk_shc_reserva_shc_paciente1_idx` (`idPaciente`),
  CONSTRAINT `fk_shc_reserva_shc_paciente1` FOREIGN KEY (`idPaciente`) REFERENCES `shc_paciente` (`idPaciente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_shc_reserva__usuario` FOREIGN KEY (`idRecepcionista`) REFERENCES `_usuario` (`idUsuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `shc_reserva`
--

/*!40000 ALTER TABLE `shc_reserva` DISABLE KEYS */;
/*!40000 ALTER TABLE `shc_reserva` ENABLE KEYS */;




/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
