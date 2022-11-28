<?php

require_once "../models/Escuela.php";

if (isset($_GET['operacion'])){

    $escuela = new Escuela();

    if ($_GET['operacion']== 'listarEscuelas'){

        $dataEscuela = $escuela -> listarEscuelas();
        echo json_encode($dataEscuela);
    }
}

?>