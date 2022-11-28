<?php
session_start();

// si no existe la sesión
if (!isset($_SESSION['login']) || $_SESSION['login'] == false){
    header("Location:../index.php");

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>


    <!-- fon awesome  -->
    <script src="https://kit.fontawesome.com/044457a684.js" crossorigin="anonymous"></script>

     <!--  Boostrap 4.6 -->

     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <!-- Table -->
    <link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">


</head>
<body>

<style>
    table tbody tr td:ntd-child(7){
        text-align: center;
    }


</style>


<div class="mt-2" style='width: 95%; margin: 0 auto;'>

        <h2 class="text-center mb-4">Módulo de Usuarios</h2>
        <a href="../controllers/usuario.controller.php?operacion=cerrar-sesion" class="btn btn-danger">Cerrar sesión</a>
        <hr>

        <div class="table-responsive">
            <table class="table table-sm table-striped" id="tabla-usuarios">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Apellidos</th>
                        <th>nombres</th>
                        <th>User</th>
                        <th>N.A</th>                     
                        <th>Fecha de creación</th>    
                        <th>Controles</th>                
                    </tr>
                </thead>
                <tbody class="table-hover table-active"></tbody>
            </table>
        </div>

    </div>


<!-- zona modal -->
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modal-reinicio" tabindex="-1" aria-labelledby="titulo-modal-recuperacion" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-light">
                    <h5 class="modal-title" id="titulo-modal-cursos">Recuperación de contraseña</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="text-light" aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <!-- Formulario de registro de Cursos -->
                    <form action="" id="formulario-reinicio" autocomplete="off">
                       
                        <!-- Todos los campos compartiran la misma fila -->

                        <div class="row">
                             <div class="form-group col-md-6">
                                <label for="contraseña">Contraseña</label>
                                <input type="text" class="form-control form-control-sm" id="contraseña">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="contraseña2">Repita su contraseña:</label>
                                <input type="text" class="form-control form-control-sm" id="contraseña2">
                            </div>
                        </div>
                        <!-- Fin del formulario -->
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" id="cancelar-modal" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-sm btn-primary" id="guardar-clave">Guardar</button>
                </div>

            <!-- fin modal  -->

  <!-- Libreria jQuery -->

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>



  <!-- Boostrap 4.6 -->

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>

<!-- Datatable -->

<script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>


<!-- Libreria Sweet Alert2 -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>

    $(document).ready(function (){

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

    function mostrarUsuarios() {

    $.ajax({
    url :'../controllers/usuario.controller.php',
    type : 'GET',
    data : 'operacion=listarUsuarios',
    success : function(result){
        let registros = JSON.parse(result);
        let nuevoFila=``;
         

        let tabla = $("#tabla-usuarios").DataTable();
            tabla.destroy();

        $("#tabla-usuarios tbody").html("");

        registros.forEach(registro =>{

            fechacreacion = registro['fechacreacion'] == null ? '' : registro['fechacreacion'];
            //nivelacceso = registro['nivelacceso'] == 'A' ? 'Admin' : 'Invitado';
            let nuevaFila =`
                <tr>
                <td>${registro['idusuario']}</td>
                <td>${registro['apellidos']}</td>
                <td>${registro['nombres']}</td>
                <td>${registro['email']}</td>
                <td>${registro['nivelacceso']}</td>
                <td>${registro['fechacreacion']}</td>
                <td>
                    <a href='#' data-na='${registro['nivelacceso']}' data-idusuario='${registro['idusuario']}' class='btn btn-sm btn-info promover' title="promover"><i class='fa-solid fa-arrow-up'></i></a>
                    <a href='#' data-na='${registro['nivelacceso']}' data-idusuario='${registro['idusuario']}' class='btn btn-sm btn-info degradar' title="degradar"><i class='fa-solid fa-arrow-down'></i></a>
                    <a href='#' data-idusuario='${registro['idusuario']}' class='btn btn-sm btn-danger inhabilitar' title='Inhabilitar'><i class='fa-solid fa-trash'></i></a>
                    <a href='#' data-idusuario='${registro['idusuario']}' class='btn btn-sm btn-warning reiniciar title='Reiniciar'><i class='fa-solid fa-arrows-rotate'></i></a>
                </td>
                
                </tr>
            `;
            $("#tabla-usuarios tbody").append(nuevaFila);
            
        })//fin forEach
        $('#tabla-usuarios').DataTable({
            language:{ 
                url: '//cdn.datatables.net/plug-ins/1.12.1/i18n/es-MX.json'
            }
        });//fin DataTable
    }//fin success

});// $.ajax

}//fin de la función mostrarCuros()


//funcionalidad botones 


            $("#tabla-usuarios tbody").on("click", ".inhabilitar", function (){
               // console.log("Pulsaste un boton inhabilitar");
                
                // Almacenamos la PK en una variable 
                let idusuario = $(this).data("idusuario");
                console.log(idusuario);

               // if(confirm("¿Está seguro de Inhabilitar a este Usuario?")){
                Swal.fire({
                    title   : "Inhabilitar",
                    text    : "¿Esta seguro de inhabilitar a este usuario?",
                    icon    : "question",
                    footer  : "Ingeniería de Software con IA",
                    confirmButtonText   : "Aceptar",
                    confirmButtonColor  : "#11710B",
                    showCancelButton    : true,
                    cancelButtonText    : "Cancelar",
                    cancelButtonColor   : "#D3280A"
                }).then(result => {
                    if(result.isConfirmed){
                    $.ajax({
                        url: '../controllers/usuario.controller.php',
                        type: 'GET',
                        data:{'operacion' : 'inhabilitarUsuario', 'idusuario' : idusuario},
                        success : function(result){
                            if (result == ''){
                            {
                            Swal.fire({
                            title   : "Usuario Inhabilitado",
                            icon    : "success",
                            toast   : true,
                            position : 'bottom-end',
                            showConfirmButton   : false,
                            timer   : 2000,
                            timerProgressBar    : true
                            });
                                idusuario= ``;
                                mostrarUsuarios();
                                }
                            }//if
                            console.log(result)
                        }//fin success
                    })//fin ajax
                }//fin confirm
            });//fin evento ON
        })//fin sw alert

        $("#tabla-usuarios tbody").on("click",".degradar", function(){
                idusuario = $(this).data("idusuario");

                nausuario = $(this).data("na");

                if(nausuario == "I"){
                    Swal.fire({
                    title   : "Error",
                    text    : "Este usuario no puede ser degradado",
                    icon    : "error",
                    footer  : "Ingeniería de Software con IA",
                    showConfirmButton    : false,
                    timer   : 2000,
                    timerProgressBar    : true
                });
                }else{
                Swal.fire({
                    title   : "Usuarios",
                    text    : "¿Esta seguro de degradar a este usuario?",
                    icon    : "question",
                    footer  : "Ingeniería de Software con IA",
                    confirmButtonText   : "Aceptar",
                    confirmButtonColor  : "#38AD4D",
                    showCancelButton    : true,
                    cancelButtonText    : "Cancelar",
                    cancelButtonColor   : "#D3280A"
                }).then(result => {
                    if(result.isConfirmed){
                        $.ajax({
                        url:    '../controllers/usuario.controller.php',
                        type:   'GET',
                        data:   {'operacion':'degradarUsuario','idusuario': idusuario},
                        success:    function(result){
                            if(result == ""){

                                Swal.fire({
                                    title   : "Degradado correctamente",
                                    text    : "Su usuario ha sido degradado",
                                    icon    : "success",
                                    toast   : true,
                                    position : 'bottom-end',
                                    showConfirmButton   : false,
                                    timer   : 2000,
                                    timerProgressBar    : true
                                });
                                mostrarUsuarios()

                                idusuario = '';
                                
                            }
                        }
                    });
                    }
                });
                }
            });





$("#tabla-usuarios tbody").on("click",".promover", function(){
                idusuario = $(this).data("idusuario");
                nausuario = $(this).data("na");
                
                console.log(nausuario)
                console.log(idusuario)


                

                if(nausuario == "A"){
                    Swal.fire({
                    title   : "Error",
                    text    : "Este usuario ya es ADMIN",
                    icon    : "error",
                    footer  : "Ingeniería de Software con IA",
                    showConfirmButton    : false,
                    timer   : 2000,
                    timerProgressBar    : true
                });
                }else{
                Swal.fire({
                    title   : "Promover",
                    text    : "¿Esta seguro de promover a este usuario?",
                    icon    : "question",
                    footer  : "Ingeniería de Software con IA",
                    confirmButtonText   : "Aceptar",
                    confirmButtonColor  : "#38AD4D",
                    showCancelButton    : true,
                    cancelButtonText    : "Cancelar",
                    cancelButtonColor   : "#D3280A"
                }).then(result => {
                    if(result.isConfirmed){
                        $.ajax({
                        url:    '../controllers/usuario.controller.php',
                        type:   'GET',
                        data:   {'operacion':'promoverUsuarios','idusuario': idusuario},
                        success:    function(result){
                            if(result == ""){

                                Swal.fire({
                                    title   : "Promovido correctamente",
                                    text    : "Su usuario ha sido promovido",
                                    icon    : "success",
                                    toast   : true,
                                    position : 'bottom-end',
                                    showConfirmButton   : false,
                                    timer   : 2000,
                                    timerProgressBar    : true
                                });

                                idusuario = '';
                                mostrarUsuarios();
                            }
                        }
                    });
                    }
                });}
            });






$("#tabla-usuarios tbody").on("click",".reiniciar", function(){ 
    $("#modal-reinicio").modal("show");

    idusuario = $(this).data("idusuario");

$("#guardar-clave").on("click", function(){

    let claveacceso = $("#claveacceso").val();
    let repetir = $("#claveacceso2").val();
    
    if(claveacceso != repetir){
        alertarToast("Ha sucecido un error","Las claves no coinciden","error");
    }else{
        $.ajax({
            url: '../controllers/usuario.controller.php',
            type: 'GET',
            data: {
                'operacion' : 'reiniciarUsuario', 
                'idusuario' : idusuario,
                'claveacceso'     : claveacceso
            },
            success: function(result){
                $("#formulario-reinicio")[0].reset();
                $("#modal-reinicio").modal("hide");
                alertarToast("Actualizado","La clave fue actualizada","success")
            }
        });
    }
})
});


// Reiniciara el formulario 
function reiniciarformulario() {
    $("#formulario-pass")[0].reset();

    }



//Funciones de carga automatica
mostrarUsuarios()


    });
</script>
    
</body>
</html>