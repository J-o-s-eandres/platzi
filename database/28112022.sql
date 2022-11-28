USE platzi;


SELECT * FROM cursos;

UPDATE productos SET enabled = '1', fechabaja = NULL


CREATE DATABASE platzi;

USE platzi;


CREATE TABLE escuelas(
	idescuela 		SMALLINT AUTO_INCREMENT PRIMARY KEY,
    escuela			VARCHAR(100) NOT NULL,
    fechacreacion 		DATETIME NOT NULL DEFAULT NOW(),
    fechabaja 			DATETIME NULL,
    enabled 			CHAR(1) NOT NULL DEFAULT '1'
    
)ENGINE = INNODB;

INSERT INTO escuelas(escuela) VALUES
("Blockchain y Criptomonedas"),
("Data Science e Inteligencia Artificial"),
("VideoJuegos"),
("DevOps y Cloud Computing"),
("Desarrollo Web");

DELETE FROM escuelas
WHERE idescuela = 15 ;
SELECT * FROM escuelas;

CREATE TABLE profesores(
	idprofesor 			SMALLINT AUTO_INCREMENT PRIMARY KEY,
	nombres 			VARCHAR(50) NOT NULL,
    apellidos 			VARCHAR(60) NOT NULL,
    pais 				VARCHAR(40)NOT NULL,
    redsocial 			VARCHAR(60)NULL,
    fechacreacion 		DATETIME NOT NULL DEFAULT NOW(),
    fechabaja 			DATETIME NULL,
    enabled 			CHAR(1) NOT NULL DEFAULT '1'
    
)ENGINE= INNODB;

SELECT * FROM profesores;

INSERT INTO profesores(nombres,apellidos,pais, redsocial) VALUES
("John Edwar","Francia Minanya","Perú","Jf@github.com"),
("Joseandres Gabriel","Montesino","Venezuela","JM@github.com"),
("Juan Mendoza","Prado Galvez","Colombia","JMPg@github.com"),
("Jhonathan Alberto","Gonzales Almeyda","Perú","JAGA@github.com");

DROP TABLE cursos;
CREATE TABLE cursos(
    idcurso 		INT AUTO_INCREMENT PRIMARY KEY,
    idescuela  		SMALLINT NOT NULL,
    idprofesor 		SMALLINT NOT NULL,
    titulo 			VARCHAR(100) NOT NULL,
    descripcion 	VARCHAR(150)NOT NULL,
    dificultad 		VARCHAR(13) NOT NULL DEFAULT 'Básico',
    fechainicio 	DATE DEFAULT NULL,
    precio 			DECIMAL(6,2) NOT NULL,
    fechacreacion 	DATETIME NOT NULL DEFAULT NOW(),
    fechabaja 		DATETIME NULL,
    enabled 		CHAR(1) NOT NULL DEFAULT(1),
    imagen 		VARCHAR(100) NULL, -- actualizado 28/11/2022
   
    
    -- CONSTRAINT ch_fechainicio_cur CHECK(fechainicio >= fechacreacion),
    CONSTRAINT ch_dificultad_cur CHECK(dificultad IN ('Introductorio','Básico','Intermedio','Avanzado')),
    CONSTRAINT fk_idescuela_cur FOREIGN KEY (idescuela) REFERENCES escuelas(idescuela),
    CONSTRAINT fk_idprofesores_cur FOREIGN KEY (idprofesor) REFERENCES profesores(idprofesor)
)ENGINE = INNODB;



SELECT * FROM cursos;

INSERT INTO cursos(idescuela,idprofesor,titulo,descripcion,dificultad,fechainicio,precio) VALUES
(3,2,'Lengucaje "C" Intro','Introducción al lenguaje "C"','Introductorio','2022-10-13',200),
(5,1,'PHP Basic','Curso Básico de PHP','Básico','2022-12-10 ',150),
(3,3,'C para Videojuegos','Curso de C para Videojuegos','Intermedio','2022-11-11 ',200),	
(2,1,'Python para Data Science','Curso de Python para Data Science','Avanzado','2022-12-11',400);


-- Precedimientos Almacenados 
SELECT * FROM cursos
DELIMITER $$

CREATE PROCEDURE spu_cursos_listar()
BEGIN
 SELECT cur.idcurso, escu.escuela,CONCAT_WS(' ',pro.nombres,pro.apellidos) AS 'nombre pila',cur.titulo,
		cur.descripcion,cur.dificultad,cur.fechainicio,cur.precio,cur.imagen
	FROM cursos cur 
    INNER JOIN escuelas escu ON cur.idescuela = escu.idescuela
	INNER JOIN profesores pro ON cur.idprofesor = pro.idprofesor
    WHERE cur.enabled ='1';
 END $$
 
 

 CALL spu_cursos_listar();


DROP PROCEDURE spu_cursos_registrar 
DELIMITER $$
CREATE PROCEDURE spu_cursos_registrar 
(
    IN _idescuela SMALLINT,
    IN _idprofesor SMALLINT,
    IN _titulo VARCHAR(100),
    IN _descripcion VARCHAR(160),
    IN _dificultad VARCHAR(13),
    IN _fechainicio DATE  ,
    IN _precio DECIMAL(6,2),
    IN _idusuario INT,
    IN _imagen VARCHAR(100)
)
BEGIN 
IF _imagen = '' THEN SET _imagen = NULL; END IF;

	INSERT INTO cursos(idescuela,idprofesor,titulo,descripcion,dificultad,fechainicio,precio,idusuario,imagen) VALUES
		(_idescuela,_idprofesor,_titulo,_descripcion,_dificultad,_fechainicio,_precio,_idusuario,_imagen);
        -- STR_TO_DATE(_fechainicio,GET_FORMAT(date,'EUR'));
        
        
END $$


CALL spu_cursos_registrar(5,2,'PHP Avanzado','Curso Avanzado de PHP','Avanzado','2022-11-11',150,1,'dfbskdfhkighk44');


DELIMITER $$
CREATE PROCEDURE spu_cursos_eliminar (IN _idcurso INT)
BEGIN 
	UPDATE cursos
		SET enabled = '0' , fechabaja= NOW() WHERE idcurso= _idcurso;
END $$

CALL spu_cursos_eliminar(6);
SELECT * FROM cursos;

DELIMITER $$
CREATE PROCEDURE spu_cursos_obtener(IN _idcurso INT)
BEGIN 
	SELECT idcurso,idescuela,idprofesor,titulo,descripcion,dificultad,fechainicio,precio
    FROM cursos 
    WHERE enabled = '1' AND idcurso= _idcurso;
END $$

CALL spu_cursos_obtener(2);


DELIMITER $$ 
CREATE PROCEDURE spu_cursos_actualizar
(
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
END $$

CALL spu_cursos_actualizar(1,3,2,'Lengucaje "C" Intro','Introducción al lenguaje "C"','Introductorio','2022-10-13',800);       
      
      
      
DELIMITER $$
CREATE PROCEDURE spu_profesores_listar()
BEGIN
	SELECT idprofesor, CONCAT_WS(' ',nombres,apellidos) AS 'nombre pila'
		FROM profesores
        WHERE enabled = '1'
        ORDER BY 'nombre pila';

 END $$
 
 CALL spu_profesores_listar();


DELIMITER $$
CREATE PROCEDURE spu_escuela_listar()
BEGIN
	SELECT idescuela, escuela
		FROM escuelas
        WHERE enabled = '1'
        ORDER BY escuela;

 END $$
 
 CALL spu_escuela_listar();






