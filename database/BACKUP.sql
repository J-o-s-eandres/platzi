/*
SQLyog Ultimate v12.5.1 (64 bit)
MySQL - 10.4.24-MariaDB : Database - platzi
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`platzi` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `platzi`;

/*Table structure for table `cursos` */

DROP TABLE IF EXISTS `cursos`;

CREATE TABLE `cursos` (
  `idcurso` int(11) NOT NULL AUTO_INCREMENT,
  `idescuela` smallint(6) NOT NULL,
  `idprofesor` smallint(6) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `descripcion` varchar(150) NOT NULL,
  `dificultad` varchar(13) NOT NULL DEFAULT 'Básico',
  `fechainicio` date DEFAULT NULL,
  `precio` decimal(6,2) NOT NULL,
  `fechacreacion` datetime NOT NULL DEFAULT current_timestamp(),
  `fechabaja` datetime DEFAULT NULL,
  `enabled` char(1) NOT NULL DEFAULT '1',
  `idusuario` int(11) NOT NULL,
  PRIMARY KEY (`idcurso`),
  KEY `fk_idescuela_cur` (`idescuela`),
  KEY `fk_idprofesores_cur` (`idprofesor`),
  KEY `fk_idusuario` (`idusuario`),
  CONSTRAINT `fk_idescuela_cur` FOREIGN KEY (`idescuela`) REFERENCES `escuelas` (`idescuela`),
  CONSTRAINT `fk_idprofesores_cur` FOREIGN KEY (`idprofesor`) REFERENCES `profesores` (`idprofesor`),
  CONSTRAINT `fk_idusuario` FOREIGN KEY (`idusuario`) REFERENCES `usuarios` (`idusuario`),
  CONSTRAINT `ch_dificultad_cur` CHECK (`dificultad` in ('Introductorio','Básico','Intermedio','Avanzado'))
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;

/*Data for the table `cursos` */

insert  into `cursos`(`idcurso`,`idescuela`,`idprofesor`,`titulo`,`descripcion`,`dificultad`,`fechainicio`,`precio`,`fechacreacion`,`fechabaja`,`enabled`,`idusuario`) values 
(1,3,2,'Lengucaje \"C\" Intro','Introducción al lenguaje \"C\"','Introductorio','2022-10-13',200.00,'2022-10-17 08:59:47',NULL,'1',1),
(2,5,1,'PHP Basic','Curso Básico de PHP','Básico','2022-12-10',150.00,'2022-10-17 08:59:47',NULL,'1',1),
(3,3,3,'C para Videojuegos','Curso de C para Videojuegos','Intermedio','2022-11-11',200.00,'2022-10-17 08:59:47',NULL,'1',1),
(4,2,1,'Python para Data Science','Curso de Python para Data Science','Avanzado','2022-12-11',400.00,'2022-10-17 08:59:47',NULL,'1',1),
(5,5,3,'titulo','ighgfh','Básico','2022-10-10',1092.00,'2022-10-17 09:01:28','2022-10-17 09:08:42','0',1),
(6,5,2,'titulo','algo','Intermedio','2022-10-10',202.00,'2022-10-17 09:03:00','2022-10-17 09:32:43','0',1),
(7,5,3,'sdfd','ddsf','Intermedio','0000-00-00',2022.00,'2022-10-17 09:04:57','2022-10-17 09:05:31','0',1),
(8,4,2,'AWS','Introducción AWS','Intermedio','2022-11-11',200.00,'2022-10-17 09:06:33',NULL,'1',1),
(9,3,3,'Lengucaje \"C\" Intro','Introducción al lenguaje \"C\"','Introductorio','0000-00-00',2022.00,'2022-10-17 10:46:55','2022-10-17 10:48:58','0',1),
(10,4,2,'hfhgj','hjh','Básico','2022-11-11',200.00,'2022-10-17 10:48:37','2022-10-17 12:40:43','0',1),
(11,2,4,'IA con python','Curso de IA con python','Avanzado','0000-00-00',2020.00,'2022-10-17 16:01:47','2022-10-17 16:01:57','0',1);

/*Table structure for table `escuelas` */

DROP TABLE IF EXISTS `escuelas`;

CREATE TABLE `escuelas` (
  `idescuela` smallint(6) NOT NULL AUTO_INCREMENT,
  `escuela` varchar(100) NOT NULL,
  `fechacreacion` datetime NOT NULL DEFAULT current_timestamp(),
  `fechabaja` datetime DEFAULT NULL,
  `enabled` char(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`idescuela`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

/*Data for the table `escuelas` */

insert  into `escuelas`(`idescuela`,`escuela`,`fechacreacion`,`fechabaja`,`enabled`) values 
(1,'Blockchain y Criptomonedas','2022-10-17 08:59:18',NULL,'1'),
(2,'Data Science e Inteligencia Artificial','2022-10-17 08:59:18',NULL,'1'),
(3,'VideoJuegos','2022-10-17 08:59:18',NULL,'1'),
(4,'DevOps y Cloud Computing','2022-10-17 08:59:18',NULL,'1'),
(5,'Desarrollo Web','2022-10-17 08:59:18',NULL,'1');

/*Table structure for table `profesores` */

DROP TABLE IF EXISTS `profesores`;

CREATE TABLE `profesores` (
  `idprofesor` smallint(6) NOT NULL AUTO_INCREMENT,
  `nombres` varchar(50) NOT NULL,
  `apellidos` varchar(60) NOT NULL,
  `pais` varchar(40) NOT NULL,
  `redsocial` varchar(60) DEFAULT NULL,
  `fechacreacion` datetime NOT NULL DEFAULT current_timestamp(),
  `fechabaja` datetime DEFAULT NULL,
  `enabled` char(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`idprofesor`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

/*Data for the table `profesores` */

insert  into `profesores`(`idprofesor`,`nombres`,`apellidos`,`pais`,`redsocial`,`fechacreacion`,`fechabaja`,`enabled`) values 
(1,'John Edwar','Francia Minanya','Perú','Jf@github.com','2022-10-17 08:59:34',NULL,'1'),
(2,'Joseandres Gabriel','Montesino','Venezuela','JM@github.com','2022-10-17 08:59:34',NULL,'1'),
(3,'Juan Mendoza','Prado Galvez','Colombia','JMPg@github.com','2022-10-17 08:59:34',NULL,'1'),
(4,'Jhonathan Alberto','Gonzales Almeyda','Perú','JAGA@github.com','2022-10-17 08:59:34',NULL,'1');

/*Table structure for table `usuarios` */

DROP TABLE IF EXISTS `usuarios`;

CREATE TABLE `usuarios` (
  `idusuario` int(11) NOT NULL AUTO_INCREMENT,
  `apellidos` varchar(30) NOT NULL,
  `nombres` varchar(30) NOT NULL,
  `email` varchar(100) NOT NULL,
  `claveacceso` varchar(100) NOT NULL,
  `nivelacceso` char(1) NOT NULL DEFAULT 'A',
  `fechacreacion` datetime NOT NULL DEFAULT current_timestamp(),
  `fechabaja` datetime DEFAULT NULL,
  `estado` char(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`idusuario`),
  UNIQUE KEY `uk_email_usu` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

/*Data for the table `usuarios` */

insert  into `usuarios`(`idusuario`,`apellidos`,`nombres`,`email`,`claveacceso`,`nivelacceso`,`fechacreacion`,`fechabaja`,`estado`) values 
(1,'Montesino','Joseandres','1346502@senati.pe','$2y$10$RF4nTnhCTOViyakHesroouycFJ.55du49MYw5EY1w/QFBZSU0v2uq','A','2022-10-17 10:02:47',NULL,'1'),
(2,'Tovar Montes','Juan','juan@senati.pe','$2y$10$RF4nTnhCTOViyakHesroouycFJ.55du49MYw5EY1w/QFBZSU0v2uq','A','2022-10-17 10:03:22',NULL,'1');

/* Procedure structure for procedure `spu_cursos_actualizar` */

/*!50003 DROP PROCEDURE IF EXISTS  `spu_cursos_actualizar` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_cursos_actualizar`(
	IN _idcurso INT,
	IN _idescuela SMALLINT,
    IN _idprofesor	SMALLINT,
    IN _titulo VARCHAR(100),
    IN _descripcion VARCHAR(160),
    IN _dificultad VARCHAR(13),
    IN _fechainicio DATE  ,
	IN _precio DECIMAL(6,2)
)
BEGIN
	UPDATE cursos SET
    idescuela =		_idescuela,
    idprofesor =	_idprofesor,
    titulo = 		_titulo,
    descripcion =	_descripcion,
    dificultad =	_dificultad,
    fechainicio =	_fechainicio,
    precio =		_precio
 WHERE idcurso = 	_idcurso;
END */$$
DELIMITER ;

/* Procedure structure for procedure `spu_cursos_eliminar` */

/*!50003 DROP PROCEDURE IF EXISTS  `spu_cursos_eliminar` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_cursos_eliminar`(IN _idcurso INT)
BEGIN 
	UPDATE cursos
		SET enabled = '0' , fechabaja= NOW() WHERE idcurso= _idcurso;
END */$$
DELIMITER ;

/* Procedure structure for procedure `spu_cursos_listar` */

/*!50003 DROP PROCEDURE IF EXISTS  `spu_cursos_listar` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_cursos_listar`()
BEGIN
 SELECT cur.idcurso, escu.escuela,CONCAT_WS(' ',pro.nombres,pro.apellidos) as 'nombre pila',cur.titulo,
		cur.descripcion,cur.dificultad,cur.fechainicio,cur.precio
	FROM cursos cur 
    INNER JOIN escuelas escu ON cur.idescuela = escu.idescuela
	INNER JOIN profesores pro ON cur.idprofesor = pro.idprofesor
    WHERE cur.enabled ='1';
 END */$$
DELIMITER ;

/* Procedure structure for procedure `spu_cursos_obtener` */

/*!50003 DROP PROCEDURE IF EXISTS  `spu_cursos_obtener` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_cursos_obtener`(IN _idcurso INT)
BEGIN 
	SELECT idcurso,idescuela,idprofesor,titulo,descripcion,dificultad,fechainicio,precio
    FROM cursos 
    WHERE enabled = '1' AND idcurso= _idcurso;
END */$$
DELIMITER ;

/* Procedure structure for procedure `spu_cursos_registrar` */

/*!50003 DROP PROCEDURE IF EXISTS  `spu_cursos_registrar` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_cursos_registrar`(
	 IN _idescuela SMALLINT,
    IN _idprofesor	SMALLINT,
    IN _titulo VARCHAR(100),
    IN _descripcion VARCHAR(160),
    IN _dificultad VARCHAR(13),
    IN _fechainicio DATE  ,
	 IN _precio DECIMAL(6,2),
	 IN _idusuario INT
)
BEGIN 
	INSERT INTO cursos(idescuela,idprofesor,titulo,descripcion,dificultad,fechainicio,precio,idusuario) VALUES
		(_idescuela,_idprofesor,_titulo,_descripcion,_dificultad,_fechainicio,_precio,_idusuario);
        -- STR_TO_DATE(_fechainicio,GET_FORMAT(date,'EUR'));
        
        
END */$$
DELIMITER ;

/* Procedure structure for procedure `spu_escuela_listar` */

/*!50003 DROP PROCEDURE IF EXISTS  `spu_escuela_listar` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_escuela_listar`()
BEGIN
	SELECT idescuela, escuela
		FROM escuelas
        WHERE enabled = '1'
        ORDER BY escuela;

 END */$$
DELIMITER ;

/* Procedure structure for procedure `spu_profesores_listar` */

/*!50003 DROP PROCEDURE IF EXISTS  `spu_profesores_listar` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_profesores_listar`()
BEGIN
	SELECT idprofesor, CONCAT_WS(' ',nombres,apellidos) as 'nombre pila'
		FROM profesores
        WHERE enabled = '1'
        ORDER BY 'nombre pila';

 END */$$
DELIMITER ;

/* Procedure structure for procedure `spu_usuarios_login` */

/*!50003 DROP PROCEDURE IF EXISTS  `spu_usuarios_login` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_usuarios_login`(IN _email VARCHAR(100))
BEGIN
	SELECT idusuario, apellidos, nombres, email, claveacceso,nivelacceso  
	FROM usuarios
	WHERE email = _email AND estado = '1';
 END */$$
DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
