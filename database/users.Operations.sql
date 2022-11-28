-- guardar usuarios

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



-- promover usuario

DELIMITER $$
CREATE PROCEDURE spu_usuario_promover(IN _idusuario INT)

BEGIN 
UPDATE usuarios
	SET nivelacceso = 'A' 
		WHERE idusuario = _idusuario;
END $$ 

CALL spu_usuario_promover(3)



-- degradar usuario 

DELIMITER $$
CREATE PROCEDURE spu_usuarios_degradar(IN _idusuario INT)
BEGIN 
UPDATE usuarios
	SET nivelacceso = 'I' 
		WHERE idusuario = _idusuario;
END $$
CALL spu_usuarios_degradar();
-- --------------------------------------------------------------------

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


CALL spu_usuarios_guardar("Martinez","Maria","mariMarti@gmail.com","1324");



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

DELIMITER $$
CREATE PROCEDURE spu_usuario_promover(IN _idusuario INT)

-- degradar usuario 

DELIMITER $$
CREATE PROCEDURE spu_usuarios_degradar(IN _idusuario INT)


BEGIN 
UPDATE usuarios
	SET nivelacceso = 'I' 
		WHERE idusuario = _idusuario;
END $$ 



*/
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

-- 07/11/2022

-- El correo es una forma de validar que el usuario existe
-- pero lo que realmente necesitamos es su Teléfono

DELIMITER $$
CREATE PROCEDURE spu_usuarios_gettelefono(

IN _email VARCHAR(100)

)
BEGIN	
  -- PASO 1 : OBTENER el teléfono del usuario
   SELECT idusuario,  email , telefono
	FROM usuarios 
	WHERE email = _email AND estado = '1';
   
  
END $$



CALL spu_usuarios_gettelefono('1346502@senati.pe')



DELIMITER $$
CREATE PROCEDURE spu_desbloqueos_registrar
(
   IN _idusuario INT,
   IN _codigodesbloqueo CHAR(4)

)
BEGIN 

   UPDATE desbloqueos SET estado ='0'
	WHERE idusuario=_idusuario;
	
    INSERT INTO desbloqueos (idusuario, codigodesbloqueo) VALUES
	(_idusuario, _codigodesbloqueo);
END $$




DELIMITER $$
CREATE PROCEDURE spu_desbloqueos_validar
(
	IN _idusuario			INT,
	IN _codigodesbloqueo		CHAR(4)
)
BEGIN

	-- Creamos variables
	-- Variables de salida
	DECLARE _resultado VARCHAR(5);
	DECLARE _mensaje VARCHAR(200); 
	
	-- Variables cuantificables
	DECLARE _registros INT;
	DECLARE _fechacreacion DATETIME;
	DECLARE _tiempodif TIME;
	DECLARE _minutos INT;
	
	SET _resultado = 'ERROR';
	SET _mensaje = 'El código ingresado es incorrecto o está inactivo, vuelva a generar';
	SET _registros = (SELECT COUNT(*) FROM desbloqueos WHERE idusuario = _idusuario AND codigodesbloqueo = _codigodesbloqueo AND estado = '1');

	-- Verificamos si los datos son correctos
	IF _registros = 1 THEN
		
		-- Ahora debemos verificar que no existan más de 15 min de diferencia
		-- Primero comprobamos que se trate del mismo día
		-- Obtenemos la fechacreacion
		SET _fechacreacion = (SELECT fechacreacion FROM desbloqueos WHERE idusuario = _idusuario ORDER BY 1 DESC LIMIT 1);
		
		-- Validando el día
		IF DATE(NOW()) = DATE(_fechacreacion) THEN
			-- Ahora validamos el tiempo (15 minutos)
			SET _tiempodif = TIMEDIFF(TIME(NOW()), TIME(_fechacreacion));
			SET _minutos = HOUR(_tiempodif) * 60 + MINUTE(_tiempodif);
			
			IF _minutos <= 15 THEN
					-- Cerramos el código desbloqueo
					UPDATE desbloqueos SET fechaactivacion = NOW(), estado = '0' WHERE idusuario = _idusuario AND estado = '1';
					SET _resultado = 'OK';
					SET _mensaje = 'Proceso terminado correctamente';				
			END IF; -- Validación 15 min
		END IF; -- Validación mismo día
	END IF; -- Validación código correcto
	
	-- Retorno de datos:
	SELECT _resultado 'resultado', _mensaje 'mensaje';
	
END $$



SELECT * FROM desbloqueos


SELECT * FROM usuarios




