<?php 
require_once "../models/Profesor.php";

if (isset($_GET['operacion'])){

    $profesor = new Profesor();

    if ($_GET['operacion']== 'listarProfesores'){

        $dataProfesor = $profesor->listarProfesores();
        echo json_encode($dataProfesor);
    }
}


?>