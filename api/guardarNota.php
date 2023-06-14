<?php
    //Realizar la conexion a la base de datos
    include("conectar.php");

    session_start();
    $nota = $_POST['nota'];
    $usuario = $_SESSION['usuarioEscalon'];
    $vehiculo = $_POST['vehiculo'];

    $consulta = "insert into notas(vehiculo,nota,usuario) values(" . $vehiculo . ",'" . $nota . "','" . $usuario . "');";
    $conn->query($consulta);

    echo json_encode($usuario);
?>