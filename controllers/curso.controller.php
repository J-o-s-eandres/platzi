<?php
session_start();

require_once "../models/Curso.php";

$curso = new Curso();

if (isset($_GET['operacion'])){

    


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
        "fechainicio" => $_GET['fechainicio'],
        "idusuario" => $_SESSION['idusuario'],
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
}// fin isset()

//Operaciones POST
if (isset($_POST['operacion'])){

    if($_POST['operacion']=='registrarCursos'){

        
        $datosSolicitados = [
            "idescuela"   => $_POST['idescuela'],
            "idprofesor"  => $_POST['idprofesor'],
            "titulo"      => $_POST['titulo'],
            "descripcion" => $_POST['descripcion'],
            "dificultad"  => $_POST['dificultad'],
            "precio"      => $_POST['precio'],
            "fechainicio" => $_POST['fechainicio'],
            "idusuario"   => $_SESSION['idusuario'],
            "imagen"      => ""
            ];
    
            if(isset($_FILES['fotografia'])){
                //Carpeta
                $rutaDestino ="../views/images/cursos/";
            
                //fechay hora
                $fechaActual = date("c"); //c = complete (FECHA + HORA)

                //Encriptando fecha y hora.jpg
                $nombreArchivo = sha1($fechaActual) . ".jpg";

                //Ruta final
                $rutaDestino.= $nombreArchivo;

                if (move_uploaded_file($_FILES['fotografia']['tmp_name'], $rutaDestino)){
                    //Se logró subir el archivo

                    //Acciones por definir
                    $datosSolicitados['imagen'] = $nombreArchivo;
                
            } // fin move_upload

        }//fin isset($_FILES)

        $curso->registrarCursos($datosSolicitados);

    }//fin isset[$_POST]

}

?>