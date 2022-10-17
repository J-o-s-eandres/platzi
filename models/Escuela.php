<?php

require_once "Conexion.php";

class Escuela extends Conexion{
    private $acceso;

    public function __construct()
    {
        $this->acceso =parent::getConexion();
    }

    public function listarEscuelas(){

        try{
             
             $consulta = $this->acceso->prepare("CALL spu_escuela_listar()");           
             $consulta->execute();         
             $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);

             return $datos;


        }catch(Exception $e){
        die($e -> getMessage());
         }
    }

}
?>