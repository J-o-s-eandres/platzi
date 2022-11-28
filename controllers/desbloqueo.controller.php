<?php

require_once "../models/Desbloqueo.php";

if (isset($_GET['operacion'])){

    $desbloqueo= new Desbloqueo();
    
    if($_GET['operacion']=='validarCodigo'){

        $idusuario = $_GET['idusuario'];
        $codigodesbloqueo = $_GET['codigodesbloqueo'];


        $resultado =$desbloqueo->validarCodigo($idusuario,$codigodesbloqueo);
        echo json_encode($resultado);
    }
    
}



?>