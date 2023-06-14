<?php
    //Realizar la conexion a la base de datos
    include("conectar.php");

    //Datos recibidos de Ajax
    $nombre = $_POST['nombre'];
    $pass = $_POST['pass'];

    $code = 0;

    //Consultar a la BD si el correo y la pass son validas
    $consulta = "select * from usuarios where usuario ='" . $nombre . "' and pass = binary '" . $pass . "' ;";
    $resultado = $conn->query($consulta);
    while ($fila = mysqli_fetch_array($resultado)){
        //Si es valida generamos un resultado 
        $code = 1;
        $ID = $fila['ID'];
    }

    //Crear la sesion
    if($code==1){
        session_start();
        $_SESSION['usuarioEscalon'] = $nombre;
        $_SESSION['pass'] = $pass;
        $_SESSION['ID'] = $ID;
    }
    


    //Codificar el array en formato json
    $data = array(
        'codigo' => $code
    );
    echo json_encode($data);
?>