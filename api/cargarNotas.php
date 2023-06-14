<?php
    //Realizar la conexion a la base de datos
    include("conectar.php");

    $numero = $_POST['numero'];
    $notas = array();
    $i = 0;
    $consulta = "select * from notas where vehiculo = '" . $numero . "' order by fecha desc;";
    $resultado = $conn->query($consulta);

    while ($fila = mysqli_fetch_array($resultado)){
        $notas[$i] = array(
            'nota' => $fila['nota'],
            'fecha' => $fila['fecha'],
            'usuario' => $fila['usuario']
        );
        $i++;
    }

    echo json_encode($notas);


?>