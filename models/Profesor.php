<?php

require_once "Conexion.php";

class Profesor extends Conexion{
    private $acceso;

    public function __construct()
    {
        $this->acceso =parent::getConexion();
    }

    public function listarProfesores(){

        try{
             
             $consulta = $this->acceso->prepare(" CALL spu_profesores_listar()");           
             $consulta->execute();         
             $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);

             return $datos;


        }catch(Exception $e){
        die($e -> getMessage());
         }
    }

}