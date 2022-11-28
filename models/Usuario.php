<?php
require_once "Conexion.php";

class Usuario extends Conexion{

    private $acceso;

    public function __CONSTRUCT(){
        $this->acceso = parent::getConexion();
    }

    // Consumirá a nuestro SPU
    public function login($email){
        try{
           $consulta = $this->acceso->prepare("CALL spu_usuarios_login(?)");

           //Un arreglo no tiene un límite de objetos definido
           $consulta->execute(array($email));

           return $consulta->fetch(PDO::FETCH_ASSOC);

        }
        catch(Exception $e){
            die($e->getMessage());
        }
    }


    public function crearUsuario($datosGuardar){
        try{

            $consulta = $this->acceso->prepare("CALL spu_usuarios_guardar(?,?,?,?)");
            
            $consulta->execute(array(
                $datosGuardar['apellidos'],
                $datosGuardar['nombres'],
                $datosGuardar['email'],
                $datosGuardar['claveacceso']
            ));
            
            //no retornamos nada
        }catch(Exception $e){
            die($e->getMessage());
        }
    }

    public function degradarUsuario($idusuario){
        try{
            $consulta = $this->acceso->prepare("CALL spu_usuarios_degradar(?)");
            $consulta->execute(array($idusuario));
    
        }catch(Exception $e){
            die($e->getMessage());
        }
       } 

    public function listarUsuarios(){

        try {
            $consulta = $this->acceso->prepare("CALL spu_usuarios_listar()");

            $consulta->execute();

            $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);

                //retorna los datos
                return $datos;

        }catch(Exception $e){
            die($e->getMessage());
        } 
    }


    public function promoverUsuarios($idusuario){
        try{
            $consulta = $this->acceso->prepare("CALL spu_usuario_promover(?)");
            $consulta->execute(array($idusuario));

        }catch(Exception $e){
            die($e->getMessage());
        }

    }

    public function inhabilitarUsuario($idusuario){
        try{
            $consulta = $this->acceso->prepare("CALL spu_usuario_inhabilitar(?)");
            $consulta->execute(array($idusuario));

        }catch(Exception $e){
            die($e->getMessage());
        }
    }


    public function editarUsuarios($datosGuardar){
        try{
            $consulta = $this->acceso->prepare("CALL spu_usuario_editar(?,?)");

            $consulta->execute(array(
                $datosGuardar['idusuario'],
                $datosGuardar['claveacceso']
            ));

        }catch(Exception $e){
            die($e->getMessage());
        }
    }


   public function getTelefono($email){
    try{
        $consulta = $this->acceso->prepare("CALL spu_usuarios_gettelefono(?)");
        $consulta->execute(array($email));

        $datos = $consulta->fetch(PDO::FETCH_ASSOC);
        return $datos;
    }
    catch(Exception $e){
        die($e->getMessage());
    }
   }

   public function validarCodigo($idusuario,$codigoDesbloqueo){

    try{
        $consulta = $this->acceso->prepare("CALL spu_desbloqueos_validar(?,?)");
        $consulta->execute(array($idusuario,$codigoDesbloqueo));
        
        $datos=$consulta->fetchAll(PDO::FETCH_ASSOC);
        return $datos;

    }
    
    catch(Exception $e){
        die($e->getMessage());
    }
   }
}

?>