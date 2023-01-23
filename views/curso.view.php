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
    <title>Cursos</title>

    <link rel="stylesheet" href="../vendor/lightbox/css/lightbox.min.css">

        <!-- fon awesome  -->
        <script src="https://kit.fontawesome.com/044457a684.js" crossorigin="anonymous"></script>

    <!--  Boostrap 4.6 -->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <!-- Table -->
    <link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">

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
        <a class="nav-link"  href="users-list.php">Usuarios</a>

    </div>
</div>
</nav>


    <div class="mt-2" style='width: 95%; margin: 0 auto;'>

        <h2 class="text-center mb-4">Módulo de Cursos</h2>
        <p class="text-center"> <?= $_SESSION['apellidos']?> <?= $_SESSION['nombres'] ?> </p>
        <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#modal-curso" id="mostrar-modal-registro">Registrar un Curso</button>
        <a href="../controllers/usuario.controller.php?operacion=cerrar-sesion" class="btn btn-danger">Cerrar sesión</a>
        <hr>

        <div class="table-responsive">
            <table class="table table-sm table-striped" id="tabla-cursos">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Escuela</th>
                        <th>Profesor</th>
                        <th>Título</th>
                        <th>Descripción</th>
                        <th>Dificultad</th>
                        <th>Precio</th>
                        <th>Fecha de Inicio</th>
                        <th>Comandos</th>
                    </tr>
                </thead>
                <tbody class="table-hover table-active"></tbody>
            </table>
        </div>

    </div>


    <!-- Modal -->
    <div class="modal fade" data-backdrop="static" data-keyboard="false" id="modal-curso" tabindex="-1" aria-labelledby="titulo-modal-productos" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-light">
                    <h5 class="modal-title" id="titulo-modal-cursos">Registro de Cursos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="text-light" aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <!-- Formulario de registro de Cursos -->
                    <!-- enctype="multipart/form-data esto le permite al formulario enviar binarios -->
                    <form  id="formulario-cursos" autocomplete="off" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="escuelas">Escuelas:</label>
                            <select name="escuelas" id="escuelas" class="form-control form-control-sm">
                                <option value="">Seleccione</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="profesores">Profesores:</label>
                            <select name="profesores" id="profesores" class="form-control form-control-sm">
                                <option value="">Seleccione</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="titulo">Título:</label>
                            <input type="text" class="form-control form-control-sm" id="titulo">
                        </div>

                        <div class="form-group">
                            <label for="descripcion">Descripcion:</label>
                            <input type="text" class="form-control form-control-sm" id="descripcion">
                        </div>

                        <div class="form-group">
                            <label for="fechainicio">Fecha de Inicio:</label>
                            <input type="text" class="form-control form-control-sm" id="fechainicio">
                        </div>




                        <!-- Todos los campos compartiran la misma fila -->

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="dificultad">Nivel de Complejidad:</label>
                                <select name="dificultad" id="dificultad" class="form-control form-control-sm">
                                    <option value="Introductorio">Introductorio</option>
                                    <option value="Básico">Básico</option>
                                    <option value="Intermedio">Intermedio</option>
                                    <option value="Avanzado">Avanzado</option>
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="precio">Precio:</label>
                                <input type="text" class="form-control form-control-sm"  id="precio">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="fotografia">Selecciona imagen: </label>
                            <input type="file" id="fotografia" accept="image/*" class="form-control-file">
                        </div>
                        <!-- Fin del formulario -->
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" id="cancelar-modal" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-sm btn-primary" id="guardar-curso">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Libreria jQuery -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

    <!-- Lightbox -->
    <script src="../vendor/lightbox/js/lightbox.min.js"></script>


      <!-- jQuery Mask  -->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
       
    <!-- Boostrap 4.6 -->

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>

    <!-- Datatable -->

    <script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    

    
<!-- Libreria Sweet Alert2 -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 
    <script>
        $(document).ready(function() {

            // enmascaramos la fecha
            $('#fechainicio').mask('2022-00-00', {placeholder: 'yyyy-mm-dd'}); //placeholder

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


            //Definimos idcurso,datosNuevos y datos de manera Global (scope)

            let idcurso = 0;
            let datosNuevos = true;

            let datos={
                'operacion'  : "",
                'idcurso'    : "",
                'idescuela'   : "",
                'idprofesor'  : "",
                'titulo'      : "",
                'descripcion' : "",
                'fechainicio' : "",
                'dificultad'  : "",
                'precio'      : 0
                
            }

            // Mostrará los registros en el DtTb
            function mostrarCuros() {

                $.ajax({
                    url :'../controllers/curso.controller.php',
                    type : 'GET',
                    data : 'operacion=listarCursos',
                    success : function(result){
                        let registros = JSON.parse(result);
                        let nuevoFila=``;
                        
                        let dificultad ='';
                        

                        

                        let tabla = $("#tabla-cursos").DataTable();
                            tabla.destroy();

                        $("#tabla-cursos tbody").html("");

                        registros.forEach(registro =>{
                           // numeroSerie = (registro['numeroSerie']==null): registro['numeroSerie'];
                            imagen = (registro['imagen']==null) ?'sin-imagen.jpg':registro['imagen'];

                            dificultad = registro['dificultad'] == null ? '' : registro['dificultad'];

                            let nuevaFila =`
                                <tr>
                                <td>${registro['idcurso']}</td>
                                <td>${registro['escuela']}</td>
                                <td>${registro['nombre pila']}</td>
                                <td>${registro['titulo']}</td>
                                <td>${registro['descripcion']}</td>
                            
                                <td>${dificultad}</td>   
                                                        
                                <td>${registro['precio']}</td>
                                <td>${registro['fechainicio']}</td>
                                <td>
                                    <a href='#' data-idcurso='${registro['idcurso']}' class='btn btn-sm btn-danger eliminar' title='Eliminar'><i class='fa-solid fa-trash'></i></a>
                                    <a href='#' data-idcurso='${registro['idcurso']}' class='btn btn-sm btn-info editar' title='Editar'><i class='fa-solid fa-arrows-rotate'></i></a>
                                    <a href='images/cursos/${imagen}'
                                    data-lightbox='demo' 
                                    data-title='${registro['descripcion']}'
                                    class='btn btn-sm btn-warning' 
                                    title='Mostrar foto del curso'><i class='fa-solid fa-eye'></i></a>

                                    
                                    </td>
                                </tr>
                            `;
                            $("#tabla-cursos tbody").append(nuevaFila);
                            
                        })//fin forEach
                        $('#tabla-cursos').DataTable({
                            language:{ 
                                url: '//cdn.datatables.net/plug-ins/1.12.1/i18n/es-MX.json'
                            }
                        });//fin DataTable
                    }//fin success

                });// $.ajax

            }//fin de la función mostrarCuros()

            //Poblará de datos en control <select>
            function listarProfesores() {
                $.ajax({
                    url: '../controllers/profesor.controller.php',
                    type: 'GET',
                    data: 'operacion=listarProfesores',
                    success: function(result){
                        let registros = JSON.parse(result);
                        let elementosLista = ``;

                        if(registros.length > 0){

                            elementosLista = `<option>Seleccione</option>`;

                        registros.forEach(registro => {
                            elementosLista += `<option value=${registro['idprofesor']}>${registro['nombre pila']}</option>`;
                        })
                    } else {
                        elementosLista = `<option>No hay datos asignados</option>`
                    }
                    $("#profesores").html(elementosLista);
                }
                })

            }//fin de la función listarProfesores() 

            //Poblará de datos en control <select>
            function listarEscuelas() {

                $.ajax({
                    url: '../controllers/escuela.controller.php',
                    type: 'GET',
                    data: 'operacion=listarEscuelas',
                    success: function(result){
                        let registros = JSON.parse(result);
                        let elementosLista = ``;

                        if(registros.length > 0){

                            elementosLista = `<option>Seleccione</option>`;

                        registros.forEach(registro => {
                            elementosLista += `<option value=${registro['idescuela']}>${registro['escuela']}</option>`;
                        })
                    } else {
                        elementosLista = `<option>No hay datos asignados</option>`
                    }
                    $("#escuelas").html(elementosLista);
                }
                })

            }//fin de la función listarEscuelas() 

            // Reiniciara el formulario 
            function reiniciarformulario() {
                $("#formulario-cursos")[0].reset();

            }//fin de la función reiniciarformulario()


            //registro-actualización de cursos sin archivo BINARIO(JPG)
            function registrarCursos() {
            

                datos['idescuela'] = $("#escuelas").val();
                datos['idprofesor'] = $("#profesores").val();
                datos['titulo'] = $("#titulo").val();
                datos['descripcion'] = $("#descripcion").val();
                datos['dificultad'] = $("#dificultad").val();
                datos['precio'] = $("#precio").val();
                datos['fechainicio'] = $("#fechainicio").val();
                
                if (datosNuevos){
                    datos['operacion'] ='registrarCursos';
                }else{
                    datos['operacion'] = 'actualizarCursos';
                    datos['idcurso'] = idcurso;
                }


                if (confirm("¿Estas seguro de guardar este registro?")){
                    $.ajax({

                        url :'../controllers/curso.controller.php',
                        type:'GET',
                        data: datos,
                        success: function(result){

                            console.log(result);
                                // Confirmar envio
                                alert("Proceso terminado correctamente");


                                // Reconstruir DataTable
                                mostrarCuros();
                                
                                // Reiniciar el formulario a su estado original 
                                reiniciarformulario();
                               //cerrar modal 
                            $("#modal-curso").modal("hide");
                
                        }
                    })//fin ajax

                }//fin del confirm
            }//fin de la función  registrarCursos()

            

            //registrar enviando binario(PDF,JPG,XLSX,DOCX, etc,)
            //enviaremos los datos utilizando POST
            function registrarCursoBin(){
                //1. Validación

                //2. Crear un objeto FormData(reemplazara al array asociativo)
            if(confirm("¿Está seguro de guardar?")){
                    var formdata = new FormData();
                
                
                //3. Enviando parámetros
                formdata.append("operacion","registrarCursos");
                formdata.append("idescuela",$("#escuelas").val());
                formdata.append("idprofesor",$("#profesores").val());
                formdata.append("titulo",$("#titulo").val());
                formdata.append("descripcion",$("#descripcion").val());
                formdata.append("dificultad",$("#dificultad").val());
                formdata.append("precio",$("#precio").val());
                formdata.append("fechainicio",$("#fechainicio").val());
                
                // formdata soporta objetos binarios
                formdata.append("fotografia", $("#fotografia")[0].files[0]);

                
                //4. Enviar datos por AJAX
                $.ajax({
                    url:'../controllers/curso.controller.php',
                    type:'POST',
                    data: formdata,
                    contentType:false,
                    processData : false,
                    cache:false,
                    success : function(result){
                            console.log(result);
                            if(result == ""){
                                // Confirmar envio
                                alert("Proceso terminado correctamente");

                                // Reconstruir DataTable
                                mostrarCuros();
                                
                                // Reiniciar el formulario a su estado original 
                                reiniciarformulario();
                               //cerrar modal 
                            $("#modal-curso").modal("hide");
                        } //fin if
                    }//fin success
                });// fin ajax
            }        //fin if confirm
        }// fin función registrarCursoBin


            $("#tabla-cursos tbody").on("click", ".eliminar", function (){
                //console.log("Pulsaste un boton eliminar");
                
                // Almacenamos la PK en una variable 
                let idcurso = $(this).data("idcurso");

                if(confirm("¿Está seguro de eliminar este Curso?")){

                    $.ajax({
                        url: '../controllers/curso.controller.php',
                        type: 'GET',
                        data:{'operacion' : 'eliminarCursos', 'idcurso' :idcurso},
                        success : function(result){
                            if (result == ''){
                                idcurso= ``;
                                mostrarCuros();
                            }//if
                            console.log(result)
                        }//fin success
                    })//fin ajax
                }//fin confirm
            });//fin evento ON


            //funcion botón editar

            $("#tabla-cursos tbody").on("click", ".editar", function(){
               // console.log("Pulsaste un boton editar");

                idcurso = $(this).data("idcurso");

                //Envio de parámetros a DATA
                //data : 'operacion=getCursos&idcurso=' + idcurso,

                $.ajax({
                    url:'../controllers/curso.controller.php',
                    type:'GET',
                    dataType : 'JSON',
                    data:{
                        'operacion' : 'getCursos',
                        'idcurso' : idcurso
                    },
                    success : function(result){


                        $("#escuelas").val(result['idescuela']);
                        $("#profesores").val(result['idprofesor']);
                        $("#titulo").val(result['titulo']);
                        $("#descripcion").val(result['descripcion']);
                        $("#dificultad").val(result['dificultad']);
                        $("#precio").val(result['precio']);
                        $("#fechainicio").val(result['fechainicio']);
                        
                        //Cambiando configuración modal
                        $("#titulo-modal-cursos").html("Actualizar Datos");
                        $(".modal-header").removeClass("bg-primary");
                        $(".modal-header").addClass("bg-info");
                        
                        $("#modal-curso").modal("show");
                        datosNuevos = false;
                        console.log(result);
                    }
                });
            });


            //agg una función al botón de registrar un curso
            function abrirModalRegistro(){
                reiniciarformulario();

                datosNuevos = true;
                //le indicamos el titulo del modal y su clase 

                $(".modal-header").removeClass("bg-info");
                $(".modal-header").addClass("bg-primary");
                $("#titulo-modal-cursos").html("Registrar Curso");

            }

            // Eventos 
            $("#mostrar-modal-registro").click(abrirModalRegistro);
            $("#guardar-curso").click(registrarCursoBin);

            //funciones de carga automática
            listarEscuelas();
            listarProfesores();
            mostrarCuros();
        });
     </script>

   </body>

</html>