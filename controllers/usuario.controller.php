<?php

// Una sesión : espacio reservado en la memoria del servidor, donde podemos
// almacenas datos utilizando KEY: VALUE . Estos valores son GLOBALES

session_start(); // Siempre debe estar en el encabezado del script PHP

$_SESSION['login'] = false;
$_SESSION['apellidos'] = "";
$_SESSION['nombres'] = "";
$_SESSION['idusuario'] = "";


require_once "../models/Usuario.php";
require_once "../models/Desbloqueo.php";

if (isset($_GET['operacion'])){

    $usuario = new Usuario; //no puedes usar las clases si no la instancias
    
    if ($_GET['operacion'] == 'login'){
        // Prueba
       // echo json_encode($usuario->login($_GET['email']));


       //0. Array que será leído por la VISTA (formulario-login)
        $resultado =[
            "acceso" => false,
            "mensaje" => "",
            "apellidos" => "",
            "nombres" => ""
        ];

        //1. VERIFICAR SI EXISTE EL USUARIO (data = 0 ,1)

        $data = $usuario->login($_GET['email']);

        if ($data){
            //2. el usuario si existe, debemos validar la clave
            $claveEncriptada = $data['claveacceso'];
            
            //3. Comprobar la lcave de entrada (login) con la encriptada

            if(password_verify($_GET['clave'],$claveEncriptada)){

                //enviamos toda la info del usuario

                $resultado["acceso"] = true;
                $resultado["mensaje"] = "Bienvenido al sistema";
                $resultado["apellidos"] = $data['apellidos'];
                $resultado["nombres"] = $data['nombres'];

                $_SESSION['login']= true;
                $_SESSION['apellidos'] = $data['apellidos'];
                $_SESSION['nombres'] = $data['nombres'];
                $_SESSION['idusuario'] = $data['idusuario'];
                $_SESSION['idusuario'] = $data['idusuario'];
                
            }else{
                // La contraseña es incorrecta 
                $resultado["acceso"]= false;
                $resultado["mensaje"]= "La contraseña es incorrecta";

            }
        }else{
            // no existe usuario
            $resultado["acceso"]= false;
            $resultado["mensaje"]= "El usuario no existe";
        }
        //enviando datos al view
        echo json_encode($resultado);

    }

    if($_GET['operacion']== 'crearUsuario'){
        $datosSolicitados = [
            "apellidos" =>$_GET['apellidos'],
            "nombres" =>$_GET['nombres'],
            "email" =>$_GET['email'],        
            "claveacceso" =>password_hash($_GET['claveacceso'], PASSWORD_BCRYPT)
        ];

        $usuario->crearUsuario($datosSolicitados);

        
    }

    if ($_GET['operacion']== 'cerrar-sesion'){
        session_destroy();
        session_unset();
        header("location:../index.php");
    }

    if ($_GET['operacion']== 'listarUsuarios'){
        echo json_encode($usuario->listarUsuarios());

    }

    if ($_GET['operacion']== 'promoverUsuarios'){    
        $usuario->promoverUsuarios($_GET['idusuario']);
    }

    if ($_GET['operacion']=='degradarUsuario'){
        $usuario->degradarUsuario($_GET['idusuario']);

    }

    if ($_GET['operacion']== 'inhabilitarUsuario'){
        $usuario->inhabilitarUsuario($_GET['idusuario']);
    }

   if ($_GET['operacion']== 'editarUsuarios'){

        $datosSolicitados = [
            "idusuario"   => $_GET['idusuario'],
            "claveacceso" =>password_hash($_GET['claveacceso'], PASSWORD_BCRYPT)
        ];
        $usuario->editarUsuarios($datosSolicitados);
   }


   if($_GET['operacion']=='getTelefono'){
        $desbloqueo = new Desbloqueo();
        $resultado = $usuario->getTelefono($_GET['email']);

        $finProceso = [
            "status" => false,
            "idusuario" => "",
            "mensaje" =>""
        ];

        //echo json_encode($resultado);
        //Si el usurio existe, entonces creamos y enviamos el código de desbloqueo
        if($resultado){
            $idusuario = $resultado['idusuario'];
            $codigodesbloqueo = random_int(1000,9999);
            $desbloqueo->registrarDesbloqueo($idusuario,$codigodesbloqueo);

            $finProceso["status"]= true;
            $finProceso["idusuario"] = $resultado['idusuario'];
            $finProceso["mensaje"]= "Se generó el código correctamente";


        }else {
            //no encontremos el email
            $finProceso["mensaje"]= "No encontramos al usuario";
        }
        echo json_encode($finProceso);
    }

}

?>