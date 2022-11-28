
DELIMITER $$
CREATE PROCEDURE spu_usuarios_guardar(
IN _apellidos VARCHAR(30),
IN _nombres VARCHAR(30),
IN _email VARCHAR(100),
IN _claveacceso VARCHAR(100)

)
BEGIN 

INSERT INTO usuarios( apellidos , nombres, email, claveacceso,nivelacceso)VALUES
			(_apellidos, _nombres, _email, _claveacceso,'I');

END $$

USE platzi

CALL spu_usuarios_guardar("Martinez","Maria","mariMarti@gmail.com","1324");

SELECT * FROM usuarios



-- listar usuarios 



DELIMITER $$
CREATE PROCEDURE spu_usuarios_listar()

BEGIN 

SELECT usu.idusuario,usu.apellidos,usu.nombres,usu.email,usu.nivelacceso,usu.fechacreacion FROM usuarios usu
	WHERE ESTADO = '1';
END $$

CALL spu_usuarios_listar();



-- promover usurio

DELIMITER $$
CREATE PROCEDURE spu_usuario_promover(IN _idusuario INT)

BEGIN 
UPDATE usuarios
	SET nivelacceso = 'A' 
		WHERE idusuario = _idusuario;
END $$ 

CALL spu_usuario_promover()




/*

DELIMITER $$
CREATE PROCEDURE spu_usuarios_guardar(
IN _apellidos VARCHAR(30),
IN _nombres VARCHAR(30),
IN _email VARCHAR(100),
IN _claveacceso VARCHAR(100)

)
BEGIN 

INSERT INTO usuarios( apellidos , nombres, email, claveacceso,nivelacceso)VALUES
			(_apellidos, _nombres, _email, _claveacceso,'I');

END $$

USE platzi

CALL spu_usuarios_guardar("Martinez","Maria","mariMarti@gmail.com","1324");

SELECT * FROM usuarios



-- listar usuarios 



DELIMITER $$
CREATE PROCEDURE spu_usuarios_listar()

BEGIN 

SELECT usu.idusuario,usu.apellidos,usu.nombres,usu.email,usu.nivelacceso,usu.fechacreacion FROM usuarios usu
	WHERE ESTADO = '1';
END $$

CALL spu_usuarios_listar();



-- promover usurio

DELIMITER $$
CREATE PROCEDURE spu_usuario_promover(IN _idusuario INT)

BEGIN 
UPDATE usuarios
	SET nivelacceso = 'A' 
		WHERE idusuario = _idusuario;
END $$ 

CALL spu_usuario_promover()



-- 31/10/2022

DELIMITER $$
CREATE PROCEDURE spu_usuario_reiniciar(IN _idusuario INT)

BEGIN 
   UPDATE usuarios
	SET nivelacceso = 'I'
		WHERE idusuario = _idusuario;
END $$

CALL spu_usuario_reiniciar(1);


-- INHABILITAR USUARIOS

DELIMITER $$
CREATE PROCEDURE spu_usuario_inhabilitar(IN _idusuario INT)
BEGIN 
  UPDATE usuarios
	SET estado = '0' , fechabaja= NOW() WHERE idusuario= _idusuario;
	
END $$

CALL spu_usuario_inhabilitar(14);

SELECT * FROM usuarios;


-- Editar Password de usuarios 
DELIMITER $$
CREATE PROCEDURE spu_usuario_editar(IN _idusuario INT, _claveacceso VARCHAR(100) )
BEGIN 
     UPDATE usuarios
	SET claveacceso = _claveacceso WHERE idusuario= _idusuario;	
END $$

CALL spu_usuario_editar(26,'holis');



-- LYNES 31-10-2022

ALTER TABLE usuarios ADD telefono CHAR(9)
ALTER TABLE usuarios ADD fotoperfil VARCHAR(100)

UPDATE usuarios SET telefono = '912396245' WHERE idusuario = 1;

SELECT * FROM usuarios;

CREATE TABLE desbloqueos 
( 
     iddesbloqueo 	INT 	AUTO_INCREMENT PRIMARY KEY,
     idusuario  	INT 	   NOT NULL,
     codigodesbloqueo 	CHAR(4)    NOT NULL,
     fechacreacion 	DATETIME   NOT NULL DEFAULT NOW() ,
     fechaactivacion 	DATETIME   NULL, -- SOLO LOS QUE REINICIEN TENDRÁN ESTE VALOR
     estado 		CHAR(1)    NOT NULL DEFAULT '1',
     CONSTRAINT fk_idusuario_des FOREIGN KEY (idusuario) REFERENCES usuarios (idusuario)
)ENGINE =INNODB;

DROP PROCEDURE spu_usuarios_gettelefono;

DELIMITER $$
CREATE PROCEDURE spu_usuarios_gettelefono(
IN _idusuario INT,
IN _email VARCHAR(100),
IN _codigodesbloqueo CHAR(4)
)
BEGIN	
  -- PASO 1 : OBTENER el teléfono del usuario
   SELECT idusuario, telefono FROM usuarios WHERE email = _email AND estado = '1';
   
  
END $$


SELECT * FROM desbloqueos;
*/