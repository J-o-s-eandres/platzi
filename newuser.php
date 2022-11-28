<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>usarios Nuevos</title>

    <!--  Boostrap 4.6 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    
</head>
<body>
    
<div class="container mt-2">

        <form action="" autocomplete="off">
            

            <div class="row">

                <div class="col-md-3"></div>
                <div class="col-md-6">

                    <!-- formulario de creacion de usuarios  -->
                    <h3>Crear Usuario</h3>
                
                    <div class="form-group">
                            <label for="apellidos">Apellidos:</label>
                            <input type="text" class="form-control form-control-sm" id="apellidos">
                        </div>

                    <div class="form-group">
                            <label for="nombre">Nombre:</label>
                            <input type="text" class="form-control form-control-sm" id="nombres">
                        </div>
                
                    <div class="form-group">
                        <label for="email">Escrbia su Correo:</label>
                        <input type="email" class="form-control" id="email" placeholder="micorreo@gmail.com">
                    </div>


                    <div class="form-group">
                        <label for="">Contraseña</label>
                        <input type="password" class="form-control" id="claveacceso">
                    </div>


                    <div class="form-group">
                        <label for="">repita su Contraseña</label>
                        <input type="password" class="form-control" id="claveacceso2">
                    </div>

                    <div class="form-group text-right">
                        <button class="btn btn-info" id="guardar" type="button">Guardar</button>                       
                    </div>
                    <!-- fin del formulario  -->

                </div>
                <div class="col-md-3"></div>
            </div> <!-- fin de row -->

        </form>   

    </div> <!-- fin del container -->
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>


    <!-- SweetAlert2 -->
    
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
    $(document).ready(function (){
        function registrar(){
                let apellidos   =   $("#apellidos").val();
                let nombres     =   $("#nombres").val();
                let email       =   $("#email").val();
                let claveacceso       =   $("#claveacceso").val();
                let repetir     =   $("#claveacceso2").val();

                if(claveacceso !== repetir){
                   // console.log("Las claves no coinciden")

                Swal.fire({
                    title  :  "Ha ocurrido un error",
                    text    : 'Las contraseñas no coinciden',
                    icon : "error",
                    position : 'bottom',
                    confirmButtonText: 'Entendido',
                    timer: 3750,
                    footer : "Montesino Dev"
                });

                }else{
                    $.ajax({
                        url: './controllers/usuario.controller.php',
                            type: 'GET',
                            data: { 
                                'operacion' : 'crearUsuario',
                                'apellidos' : apellidos,
                                'nombres'   : nombres,
                                'email'     : email,
                                'claveacceso'     : claveacceso
                            },
                            success: function(result){
                                //console.log(result)

                                Swal.fire({
                                    title  :  "Credenciales Aceptadas",                                  
                                    icon : "success",
                                    position : 'bottom-end',
                                    showConfirmButton: false,
                                    toas: true,
                                    timer: 3150                       
                                });

                                setTimeout(function(){
                                window.location.href = "index.php";
                                },1500)
                            }

                    });
                }
        }

        $("#guardar").click(registrar);

    });


</script>
</body>
</html>

