<?php
    header("Content-Type: application/json");
    include("conexion_pdo.php");

    $metodo = $_SERVER["REQUEST_METHOD"];

    switch ($metodo) {
        case 'GET':
            manejarGet($_conexion);
            #echo json_encode(["metodo" => "get"]);
            break;
        case 'POST':
            manejarGet($_conexion);
            #echo json_encode(["metodo" => "post"]);
            break;
        case 'PUT':
            manejarGet($_conexion);
            #echo json_encode(["metodo" => "put"]);
            break;
        case 'DELETE':
            manejarGet($_conexion);
            #echo json_encode(["metodo" => "delete"]);
            break;
        default:
        echo json_encode(["metodo" => "otro"]);
            break;
    }

    function manejarGet($_conexion){
        $sql = "SELECT * FROM estudios";
        $stmt = $_conexion -> prepare($sql);
        $stmt -> execute();
        $resultado = $stmt -> fetchAll(PDO::FETCH_ASSOC); #Equivalente al getResult de mysqli
        echo json_encode($resultado);
    }
?>