<?php

require_once "Conexion.php";

    class Curso extends Conexion{

        //En este Objeto almacenamos la conexion que obtenemos
        private $acceso;

        //constructor
        public function __construct()
        {
            // Cuando queramos acceder a una constante o metodo de una clase padre,
            // la palabra reservada parent nos sirve para llamarla desde una clase
            // extendida.
            $this->acceso = parent:: getConexion();
        }


        public function listarCursos(){
            try{

                //se Prepara la Consulta
                $consulta = $this->acceso->prepare("CALL spu_cursos_listar()");

                //ejecución de la cunsulta
                $consulta->execute();

                // Almacenamos el resultado de la consulta
                // fetchAll = todos los registros
                // FETCH_ASSOC = constante que representa a un array asociativo
                $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);

                //retorna los datos
                return $datos;

            }catch(Exception $e){
                die($e->getMessage());
            }
        }

        public function registrarCursos($datosGuardar){
            try{
            //Cada ? (comodinn) es una variable que requiere el spu
            $consulta = $this->acceso->prepare("CALL spu_cursos_registrar(?,?,?,?,?,?,?,?,?)");

            $consulta->execute(array(
                $datosGuardar['idescuela'],
                $datosGuardar['idprofesor'],
                $datosGuardar['titulo'],
                $datosGuardar['descripcion'],
                $datosGuardar['dificultad'],
                $datosGuardar['fechainicio'],
                $datosGuardar['precio'],          
                $datosGuardar['idusuario'],
                $datosGuardar['imagen']
                
            ));
            //no retorna datos

            }catch(Exception $e){
            die($e->getMessage());
        }
        }

        public function eliminarCursos ($idcurso){

            try{
                $consulta =$this->acceso->prepare("CALL spu_cursos_eliminar(?)");
                $consulta->execute(array($idcurso));


             }catch(Exception $e){
                die($e->getMessage());
                }
        }
        
        public function getCursos($idcurso){
            try{
                $consulta = $this->acceso->prepare("CALL spu_cursos_obtener(?)");
                $consulta->execute(array($idcurso));

                return $consulta->fetch(PDO::FETCH_ASSOC);

            }catch(Exception $e){
                die($e->getMessage());
            }
        }

        public function actualizarCursos($datosGuardar){
            try{
                $consulta = $this->acceso->prepare("CALL spu_cursos_actualizar (?,?,?,?,?,?,?,?)");

                $consulta->execute(array(
                $datosGuardar['idcurso'],
                $datosGuardar['idescuela'],
                $datosGuardar['idprofesor'],
                $datosGuardar['titulo'],
                $datosGuardar['descripcion'],
                $datosGuardar['dificultad'],
                $datosGuardar['fechainicio'],
                $datosGuardar['precio']
                
                ));

            }catch(Exception $e){
                die($e->getMessage());
            }
        }
    
    }
?>