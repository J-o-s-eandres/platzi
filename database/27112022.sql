
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


SELECT * FROM desbloqueos;

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

TRUNCATE TABLE desbloqueos;


DROP PROCEDURE spu_desbloqueos_validar
/*
DELIMITER $$
CREATE PROCEDURE spu_desbloqueos_validar
(	
   IN _idusuario INT ,
   IN _codigodesbloqueo CHAR(4)
)
BEGIN 

  -- Creamos variables
  DECLARE _mensaje VARCHAR(200); -- SET _mensaje = 'Un valor cualquiera';
  DECLARE _registros INT ;
  DECLARE _fechacracion DATE;
  
  SET _registros = SELECT COUNT(*) FROM desbloqueos WHERE idusuario = _idusuario AND codigodesbloqueo = _codigodesbloqueo AND estado = '1';
  
  IF _registros  = 1 THEN
	-- ahora debemos verificar que no existan más de 15 minutos de diferencia
	-- select fechacreacion from desbloqueos order by 1 DESC LIMIT 1;
	
	--validando el día
	IF DATE(NOW())= _fechacreacion THEN 
	
	END IF; 
	
	ELSE 
	-- datos incorrectos
	SET _mensaje = 'Código de activación incorrecto';
		
   END IF;
	
END $$
CALL spu_desbloqueos_validar(1,'9196');


*/


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





CALL spu_desbloqueos_validar(1,'5551');













-- OJO cunado timediff pase 23:59:59 algo esta mal(tampoco negativos)

-- zona de prácticas de datediff(fechaMayor, fechaMenor)
SELECT DATEDIFF ('2022-11-07','2022-01-01') AS 'Dias transcurridos';
SELECT DATEDIFF ('2022-11-07','2000-04-26') AS 'Dias de mi vida';
SELECT DATEDIFF ('2022-12-25',CURDATE())    AS 'Dias para navidad';
SELECT DATEDIFF ('2023-04-26',CURDATE())    AS 'Dias para mi próximo cumpleaños';

-- Prácticas de timediff(horaMayor, horaMenor)
SELECT TIMEDIFF('12:00:00', '11:30:00');
SELECT TIMEDIFF(CURTIME(), '00:00:00');
SELECT HOUR(TIMEDIFF('11:00:00', '10:40:00'));
SELECT MINUTE(TIMEDIFF('11:00:00', '10:40:02'));
SELECT SECOND(TIMEDIFF('11:00:00', '10:40:02'));

SELECT MINUTE(TIMEDIFF('10:55:00', '08:45:00'));
SELECT HOUR(TIMEDIFF('08:45:00', '10:45:00')) * 60 + MINUTE(TIMEDIFF('08:45:00', '10:45:00'));

-- si tenemos que comparar 2 valores (FECHA / HORA) 
-- primero debemos estar seguros que son el mismo día  

SELECT DATE('2022-11-07 08:00:00');-- IGNORA LA HORA 

SELECT TIME('2022-11-07 08:00:00'); -- IGNORA LA FECHA

SELECT TIMEDIFF('2022-11-07 08:00:00', '2022-11-06 06:30:00');