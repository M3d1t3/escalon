<?php

    session_start();
    //Comprobar que la sesion es correcta

    // Verificar si hay una sesión iniciada
    if (!isset($_SESSION['usuarioEscalon'])) {
        // Sesión no iniciada, redirigir al usuario a otra página
        header('Location: index.php');
        exit();
    }else{
        //Sesion iniciada, cargamos los datos
        
    }
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="estilos.css<?php echo '?' . date("YmdHis") ?>">
    <script src="node_modules/jquery/dist/jquery.min.js"></script>
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function(){
            $("#btnNota").hide();
            $("#editor_nota").hide();
            let seleccion = 0;

            //Boton de cerrar sesion
            $("#btnCerrar").click(function(){
                window.location.href = 'api/cerrarSesion.php';
            });

            //Click en boton nueva nota
            $("#btnNota").click(function(){
                $("#editor_nota").show(100);
            });

            //Cerrar la ventana de nueva nota
            $("#btnCancelar").click(function(){
                $("#areaNota").val("");
                $("#editor_nota").hide();
            });

            //Guardar la nota
            $("#btnGuardar").click(function(){
                let texto = $("#areaNota").val();
                $.ajax({
                        type: 'POST',
                        url: 'api/guardarNota.php',
                        data: {vehiculo:seleccion,nota:texto},
                        dataType: 'json',
                        success: function(response){
                            $("#areaNota").val("");
                            $("#editor_nota").hide(200);
                            cargarNotas(seleccion);
                        },
                        error: function(){
                            alert("Error");
                        }

                });
            });

            //Primera busqueda
            let valor = $("#buscador").val();
            let vehiculos;
                $.ajax({
                        type: 'POST',
                        url: 'api/buscarVehiculos.php',
                        data: {valor:valor},
                        dataType: 'json',
                        success: function(response){
                            vehiculos = response;
                            console.log(vehiculos);
                            imprimirBusqueda();
                        },
                        error: function(){
                            alert("Error");
                        }

                });

            $("#buscador").keyup(function(){
                //Actualizamos la lista de vehiculos
                valor = $("#buscador").val();
                $.ajax({
                        type: 'POST',
                        url: 'api/buscarVehiculos.php',
                        data: {valor:valor},
                        dataType: 'json',
                        success: function(response){
                            vehiculos = response;
                            imprimirBusqueda();
                        },
                        error: function(){
                            alert("Error");
                        }

                    });
            });

            function imprimirBusqueda(){
                let sugerencias = $("#lista_vehiculos");
                sugerencias.empty();
                let total = vehiculos.length;
                for (let i = 0; i < total; i++){
                    var sugerencia = vehiculos[i];
        
                    // Crear el elemento de la sugerencia
                    var sugerenciaDiv = $("<div>").addClass("sugerencia").attr("data-id", sugerencia.ID);;
                    var matricula = $("<p>").text(sugerencia.matricula + "   " + sugerencia.modelo);
                    sugerenciaDiv.append(matricula);
                    sugerenciaDiv.on("click", function() {
                        event.stopPropagation();//Evita que se ejecuta el clic del div padre
                        cargarNotas($(this).attr("data-id"));
                        $("#btnNota").show();
                        seleccion = $(this).attr("data-id");
                    });
                    sugerencias.append(sugerenciaDiv);
                }
            }

            let totalNotas;
            function cargarNotas(numero){
                $.ajax({
                        type: 'POST',
                        url: 'api/cargarNotas.php',
                        data: {numero:numero},
                        dataType: 'json',
                        success: function(response){
                            totalNotas = response;
                            imprimirNotas();
                        },
                        error: function(){
                            alert("Error");
                        }

                    });
            }

            function imprimirNotas(){
                let bloqueNotas = $("#lista_notas");
                bloqueNotas.empty();
                let cantidad = totalNotas.length;
                for(i=0;i<cantidad;i++){
                    var notaDiv = $("<div>").addClass("divNotas");
                    var superiorNotas = $("<div>").addClass("superiorNotas");
                    var fechaNotas = $("<div>").addClass("fechaNotas");
                    var fecha = $("<p>").text(totalNotas[i].fecha);
                    fechaNotas.append(fecha);
                    var usuarioNotas = $("<div>").addClass("usuarioNotas");
                    var usuario = $("<p>").text(totalNotas[i].usuario);
                    usuarioNotas.append(usuario);
                    var textoNotas = $("<div>").addClass("textoNotas");
                    var texto = $("<p>").text(totalNotas[i].nota);
                    textoNotas.append(texto);
                    superiorNotas.append(fechaNotas);
                    superiorNotas.append(usuarioNotas);
                    notaDiv.append(superiorNotas);
                    notaDiv.append(textoNotas);

                    bloqueNotas.append(notaDiv);
                }
            }

        });
    </script>
    <title>Segundo Escalón</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-primary fixed-top" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">2º ESCALÓN</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-link active" href="#">Vehiculos</a>
                <a class="nav-link" href="#">Notas</a>
                <a class="nav-link" href="#">Operatividad</a>
                <a class="nav-link" id="btnCerrar" href="#">Cerrar sesión</a>
            </div>
            </div>
        </div>
    </nav>
    <div id="bloque_principal">
        <div id="bloque_vehiculos">
            <form action="" id="form_buscador">
                <input type="text" id="buscador" placeholder="Buscar vehículo...">
            </form>
            <div id="lista_vehiculos">
                
            </div>
            <div id="nueva_nota">
                <button id="btnNota">Nueva nota</button>
            </div>
            <div id="lista_notas">
                
            </div>
            <div id="editor_nota">
                <textarea id="areaNota" placeholder="Nueva nota para el vehículo seleccionado..."></textarea>
                <div id="botones">
                    <button class="boton" id="btnGuardar">Guardar</button>
                    <button class="boton" id="btnCancelar">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>