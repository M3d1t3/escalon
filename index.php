<?php
    //Control de sesion
    session_start();

    // Verificar si hay una sesión iniciada
    if (isset($_SESSION['usuarioEscalon'])) {
        // Sesión iniciada, redirigir al usuario a otra página
        header('Location: portada.php');
        exit();
    }
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <script src="node_modules/jquery/dist/jquery.min.js"></script>
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <style>
         body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        #bloque_formulario {
            max-width: 400px;
            padding: 20px;
            background-color: #f2f2f2;
            border-radius: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
    </style>

    <script>
        $(document).ready(function(){

            //Inicio de sesion
            $("#btnIniciar").click(function(){
                event.preventDefault();//Evita el envio del formulario
                let nombre = $("#nombre").val();
                let pass = $("#pass").val();
                //Comprobar que los campos no estén vacios
                if((nombre=='')){
                    $("#nombre").addClass("is-invalid");
                }else if(pass==''){
                    $("#pass").addClass("is-invalid");
                }else{
                    //Realizar una consulta Ajax para comprobar la validez de los datos
                    $.ajax({
                        type: 'POST',
                        url: 'API/comprobarUsuario.php',
                        data: {nombre:nombre,pass:pass},
                        dataType: 'json',
                        success: function(data){
                            if(data.codigo==1){
                                //La conexion ha sido buena, vamos a la pagina principal, donde ya existe una sesion
                                location.href ='portada.php';
                            }else{
                                //El usuario y/o la contraseña son erroneas
                                
                            }
                        },
                        error: function(){
                            alert("Error");
                        }

                    });
                }

            });
        });
    </script>
    <title>Segundo escalón</title>
</head>
<body>
    <div id="bloque_formulario">
        <form action="">
            <div class="mb-3">
                <label for="username" class="form-label">Nombre de Usuario</label>
                <input type="text" class="form-control" id="nombre" name="username">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="pass" name="password">
            </div>
            <button type="submit" id="btnIniciar" class="btn btn-primary">Iniciar Sesión</button>
        </form>
    </div>
</body>
</html>