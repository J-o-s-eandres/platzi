<?php

    class Conexion{

        //Atributo que almacena la conexion
        protected $pdo;

        //Método que accede al servidor a BD
        private function Conectar(){
            $cn = new PDO("mysql:host=localhost;port=3306;dbname=platzi;charset=utf8", "root", "");
            return $cn;
        }

        //Método que comparte el acceso
        public function getConexion(){
            try {
                $pdo = $this->Conectar();

                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                return $pdo;
            } 
            catch (Exception $e) {
                die($e->getMessage());
            }
        }

    }

?>