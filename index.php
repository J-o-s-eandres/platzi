<?php
session_start();

//CUIDADO 
// Si el usuario ya inició sesioón, No debe visualizar este view

if (isset($_SESSION['login']) && $_SESSION['login'] == true){
    header("location:views/curso.view.php");
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--  Boostrap 4 -->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <title>Bienvenido</title>
</head>

<body>


    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">

        <a class="navbar-brand" href="index.php">Platzi</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-link " href="#">Repositorio</a>
                <a class="nav-link" href="./views/users-list.php">Usuarios</a>

            </div>
        </div>
    </nav>


    <div class="container mt-2">

        <form action="" autocomplete="off">
            

            <div class="row">

                <div class="col-md-3"></div>
                <div class="col-md-6">

                    <!-- formulario de inicio de sesión  -->
                    <h3>Inicio de sesión</h3>
                    <div class="form-group">
                        <label for="email">Escrbia su Correo</label>
                        <input type="email" class="form-control" id="email" placeholder="micorreo@gmail.com">
                    </div>


                    <div class="form-group">
                        <label for="">Contraseña</label>
                        <input type="password" class="form-control" id="clave">
                    </div>

                    <div class="form-group text-right">
                        <button class="btn btn-info" id="acceder" type="button">Acceder</button>
                        <!-- <button class="btn btn-danger" id="cancelar" type="reset">Cancelar</button> -->
                        <a class="btn btn-success" id="registrarme" href="newuser.php">Registrarme</a>
                    </div>

                    <div>
                     <a href="./restore-user.php">Olvide mi contraseña</a> 
                    </div>
                    <!-- fin del formulario  -->

                </div>
                <div class="col-md-3"></div>
            </div> <!-- fin de row -->

        </form>
        <!-- <a title="Platzi" href="./views/curso.view.php"><img src="img/curso.png" width="200" alt="Platzi" /></a> -->

    </div> <!-- fin del container -->

    


       <!-- Libreria jQuery -->
       <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
        
       <!-- Libreria Sweet Alert2 -->
       <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>

        $(document).ready(function(){

            function login(){
                let email = $("#email").val();
                let clave = $("#clave").val();
                $.ajax({
                    url : 'controllers/usuario.controller.php',
                    type: 'GET',
                    dataType:'JSON',
                    data: {
                        'operacion' : 'login',
                        'email'     :email,
                        'clave'     :clave},
                    success : function(result){
                       // console.log(result);

                        if (result.acceso){
                            //alert(`Bienvenido al sistema ${result.apellidos} ${result.nombres}`);
                        Swal.fire({
                        title   : "Bienvenido",
                        text    : `Bienvenido al sistema ${result.apellidos} ${result.nombres}`,
                        icon    : "success",                      
                        position : 'bottom',
                        showConfirmButton   : false,
                        timer   :3500,
                        footer: "Ingeniería de software con IA"
                        //timerProgressBar    : true
                    });
                                setTimeout(function(){
                                    window.location.href = "views/curso.view.php";
                                }, 2000)
                            //window.location.href="views/curso.view.php";
                        }else{
                            Swal.fire({
                                title: "Algo salio mal",
                                text : result.mensaje,
                                icon : 'warning',
                                timer: 3000,
                                showConfirmButton: false,
                                footer: "Ingeniería de software con IA",
                                position : 'bottom-top',
                            });
                        }

                    }
                });
            }

            $("#acceder").click(login);

        });
    </script>
</body>

</html>