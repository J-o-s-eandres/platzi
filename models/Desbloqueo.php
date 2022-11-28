<?php

require_once 'Conexion.php';

class Desbloqueo extends Conexion{
    private $acceso;

    public function __CONSTRUCT(){
        $this->acceso = parent::getConexion();       
    }

    public function registrarDesbloqueo($idusuario, $codigodesbloqueo){
        try{
            $consulta = $this->acceso->prepare("CALL spu_desbloqueos_registrar(?,?)");
            $consulta->execute(array($idusuario, $codigodesbloqueo));
        }
        catch(Exception $e){
            die($e->getMessage());
        }
    }



    public function validarCodigo($idusuario, $codigodesbloqueo){
        try{
            $consulta = $this -> acceso->prepare("CALL spu_desbloqueos_validar(?,?)");
            $consulta ->execute(array($idusuario,$codigodesbloqueo));

            $dato= $consulta->fetch(PDO::FETCH_ASSOC);
            return $dato;

        }
        catch(Exception $e){
            die($e->getMessage());
        }
    }




}

?>