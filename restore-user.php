<?php
session_start();

//CUIDADO 
// Si el usuario ya inició sesión, No debe visualizar este view

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
    <title>Reiniciando acceso</title>
</head>

<body>


    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">

        <a class="navbar-brand" href="#">Platzi</a>
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
        <h4>Recuperación de acceso</h4>
        <h6>Escriba los datos solicitados</h6>
        <hr>

        <form id="formulario-correo" action="" autocomplete="off">

            <div class="form-group">
                <label for="email">Escribe tu cuenta de usuario:</label>
                
              <div class="input-group">
                  <input type="text" class="form-control form-control-sm" id="email" placeholder="alguien@gmail.com">             
                    <div class="input-group-append">
                        <button type="button" class="btn btn-sm btn-success" id="enviar-SMS">Enviar SMS</button>
                    </div>
               </div>
            </div>    

            
            
            <!-- código de restablecimiento  -->
        <div class="row">
            <div class="col-sm-3 col-md-2"> <input type="text" class="form-control text-center val" maxlength="1" id="v1"></div>
            <div class="col-sm-3 col-md-2"> <input type="text" class="form-control text-center val" maxlength="1" id="v2"></div>
            <div class="col-sm-3 col-md-2"> <input type="text" class="form-control text-center val" maxlength="1" id="v3"></div>
            <div class="col-sm-3 col-md-2"> <input type="text" class="form-control text-center val" maxlength="1" id="v4"></div>
        <div class="col-md-4">
            <button class="btn-success" type="button" id="comprobar">Comprobar</button>
         </div>
        </div>

        </form>

            <!-- inicio del modal -->

     <!-- Modal -->
     <div class="modal fade" data-backdrop="static" data-keyboard="false" id="modal-reinicio" tabindex="-1" aria-labelledby="titulo-modal-reinicio" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-info text-light">
                    <h5 class="modal-title" id="titulo-modal-reinicio">Reinicio de contraseña</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="text-light" aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <!-- Formulario de reinicio de contraseña -->
                    <form action="" id="formulario-reinicio" autocomplete="off">

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="clave">Contraseña:</label>
                                <input type="password" class="form-control form-control-sm" id="clave">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="repetir">Repetir contraseña:</label>
                                <input type="password" class="form-control form-control-sm" id="repetir">
                            </div>
                        </div>
                    <!-- Fin del formulario -->
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" id="cancelar-modal" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-sm btn-info" id="guardar-clave">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- fin del modal -->

        <!-- <a title="Platzi" href="./views/curso.view.php"><img src="img/curso.png" width="200" alt="Platzi" /></a> -->

    </div> <!-- fin del container -->

       <!-- Libreria jQuery -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

<!-- SweetAlert2 -->

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Boostrap 4.6 -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>


<!-- JQueryMask -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"> </script>

    <script>
        

        $(document).ready(function(){
            var idusuario = '';

            //Configuramos las cajas de texto
            $(".val").mask("0");

            //controlando las tabulaciones
            $("#v1").keyup(function (e) { 

                if ($(this).val() !=""){
                    $("#v2").focus();
                }            
            });

            $("#v2").keyup(function (e) { 

                if ($(this).val() !=""){
                    $("#v3").focus();
                }            
            });

            $("#v3").keyup(function (e) { 

                if ($(this).val() !=""){
                    $("#v4").focus();
                }            
            });

            function alertar(textoMensaje = ""){
                Swal.fire({
                    title   : 'Usuarios',
                    text    :  textoMensaje,
                    icon    :  'info',
                    footer  :   'SENATI - Ingenieria de Software',
                    timer   :   2000,
                    
                    confirmButtonText   :   'Aceptar'
                });
            }

            function alertarToast(titulo = "",textoMensaje = "", icono = ""){
                Swal.fire({
                    title   : titulo,
                    text    : textoMensaje,
                    icon    : icono,
                    toast   : true,
                    position : 'bottom-end',
                    showConfirmButton   : false,
                    timer   : 1500,
                    timerProgressBar    : true
                });
            }



                //Primera funcion a ejecutarse        
            function enviarSMS(){
                let email = $("#email").val();

                if(email !=""){
                    $.ajax({
                        url :'./controllers/usuario.controller.php',
                        type:'GET',
                        dataType: 'JSON',
                        data:{'operacion':'getTelefono','email':email},
                        success:function (result){
                            idusuario=result.idusuario;
                            console.log(result);
                        }
                    });
                }
            }
            // segunda funcion (validación)
            function validarCodigo(){
                let v1=$("#v1").val();
                let v2=$("#v2").val();
                let v3=$("#v3").val();
                let v4=$("#v4").val();
                let cogido='';

                if(v1 != '' && v2 != '' && v3 != '' && v4!='' ){
                    codigo = v1 + v2 + v3 + v4;
                    
                    $.ajax({
                        url:'./controllers/desbloqueo.controller.php',
                        type: 'GET',
                        dataType: 'JSON',
                        data: {
                            'operacion': 'validarCodigo',
                            'idusuario' : idusuario,
                            'codigodesbloqueo' : codigo
                        },
                        success: function(result){
                            
                            console.log(result);

                            if(result.resultado == 'OK'){
                                $("#modal-reinicio").modal("show");
                                //$("#modal-reinicio").modal("show");
                                $("#guardar-clave").on("click",function(){
                                    let claveacceso = $("#clave").val();
                                    let repetir = $("#repetir").val();


                                    if(claveacceso == "" || repetir == ""){
                                        alertarToast("Ha sucecido un error","La contraseña no puede ser vacia","error");
                                    }
                                    else if (claveacceso != repetir){
                                        alertarToast("Ha sucecido un error","Las contraseñas no coninciden","error");
                                    }else{
                                        $.ajax({
                                            url: './controllers/usuario.controller.php',
                                            type: 'GET',
                                            data: {
                                                'operacion' : 'editarUsuarios', 
                                                'idusuario' : idusuario,
                                                'claveacceso': claveacceso
                                            },
                                            success: function(result){
                                            $("#formulario-reinicio")[0].reset();
                                            $("#formulario-correo")[0].reset();
                                            $("#modal-reinicio").modal("hide");
                                            alertarToast("Actualizado","La clave fue actualizada","success")
                                            }
                                            

                                        });

                                        setTimeout(function(){
                                            window.location.href = "index.php";
                                            },1500)

                                    }
                                });

                            }else{
                                alertarToast("Ha sucecido un error","El código ingresado es incorrecto o está inactivo, vuelva a generar","error");
                            }
                        }
                    });
                    
                    
                    
                }
            }

            $("#enviar-SMS").click(enviarSMS);
            $("#comprobar").click(validarCodigo);
         
        });
    </script>
</body>

</html>