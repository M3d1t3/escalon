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

            //Boton de cerrar sesion
            $("#btnCerrar").click(function(){
                window.location.href = 'api/cerrarSesion.php';
            });

            let vehiculos;

            $("#buscador").keyup(function(){
                //Actualizamos la lista de vehiculos
                let valor = $("#buscador").val();
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
            });

            function imprimirBusqueda(){
                let sugerencias = $("#lista_vehiculos");
                sugerencias.empty();
                let total = vehiculos.length;
                for (let i = 0; i < total; i++){
                    var sugerencia = vehiculos[i];
        
                    // Crear el elemento de la sugerencia
                    var sugerenciaDiv = $("<div>").addClass("sugerencia");
                    var matricula = $("<p>").text(sugerencia.matricula + "   " + sugerencia.modelo);
                    sugerenciaDiv.append(matricula);
                    sugerencias.append(sugerenciaDiv);
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
        </div>
    </div>
</body>
</html>