<?php

require_once "../models/Curso.php";

if (isset($_GET['operacion'])){

    $curso = new Curso();


    if ($_GET['operacion']== 'listarCursos'){
        echo json_encode($curso->listarCursos());
    }


    if($_GET['operacion'] == 'registrarCursos'){

        $datosSolicitados = [
        "idescuela"   => $_GET['idescuela'],
        "idprofesor"  => $_GET['idprofesor'],
        "titulo"      => $_GET['titulo'],
        "descripcion" => $_GET['descripcion'],
        "dificultad"  => $_GET['dificultad'],
        "precio"      => $_GET['precio'],
        "fechainicio" => $_GET['fechainicio']

        
        ];

        $curso->registrarCursos($datosSolicitados);
    }

    if($_GET['operacion']== 'eliminarCursos'){
        $curso->eliminarCursos($_GET['idcurso']);
    }
    
    if($_GET['operacion']== 'getCursos'){
        echo json_encode($curso->getCursos($_GET['idcurso']));
    }

    if($_GET['operacion']== 'actualizarCursos'){

        $datosSolicitados = [
            "idcurso"   => $_GET['idcurso'],
            "idescuela"   => $_GET['idescuela'],
            "idprofesor"  => $_GET['idprofesor'],
            "titulo"      => $_GET['titulo'],
            "descripcion" => $_GET['descripcion'],
            "dificultad"  => $_GET['dificultad'],
            "precio"      => $_GET['precio'],
            "fechainicio" => $_GET['fechainicio']
             
        ];
        $curso->actualizarCursos($datosSolicitados);

    }
}

?>