<?php
    //Realizar la conexion a la base de datos
    include("conectar.php");

    $valor = "%" . $_POST['valor'] . "%";
    $vehiculos = array();
    $i = 0;

    $consulta = "select * from vehiculos where matricula like '" . $valor . "'";
    $resultado = $conn->query($consulta);
    while ($fila = mysqli_fetch_array($resultado)){
        $vehiculos[$i] = array(
            'ID' => $fila['ID'],
            'matricula' => $fila['matricula'],
            'modelo' => $fila['modelo']
        );
        $i++;
    }

    echo json_encode($vehiculos);

?>