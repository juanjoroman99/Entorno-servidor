<?php
    error_reporting( E_ALL );
    ini_set("display_errors", 1 );

    header("Content-Type: application/json");
    include("conexion_pdo.php");

    $metodo = $_SERVER["REQUEST_METHOD"];
    $entrada = json_decode(file_get_contents('php://input'), true);
    /**
     * $entrada["numero"] -> <input name="numero">
     */

    switch($metodo) {
        case "GET":
            manejarGet($_conexion);
            break;
        case "POST":
            manejarPost($_conexion, $entrada);
            break;
        case "PUT":
            manejarPut($_conexion, $entrada);
            break;
        case "DELETE":
            manejarDelete($_conexion, $entrada);
            break;
        default:
            echo json_encode(["metodo" => "otro"]);
            break;
    }

    function manejarGet($_conexion) {
        if (isset($_GET["titulo"])) {
            $sql = "SELECT * FROM animes WHERE titulo = :titulo";
            $stmt = $_conexion -> prepare($sql);
            $stmt -> execute([
                "titulo" => $_GET["titulo"]
            ]);
        } else if (isset($_GET["anno_estreno"])){
            $sql = "SELECT * FROM animes WHERE anno_estreno";
        }
        $resultado = $stmt -> fetchAll(PDO::FETCH_ASSOC);   # Equivalente al getResult de mysqli
        echo json_encode($resultado);
    }

    function manejarPost($_conexion, $entrada) {
        $sql = "INSERT INTO animes (titulo, nombre_estudio, anno_estreno, num_temporadas)
            VALUES (:titulo, :nombre_estudio, :anno_estreno, :num_temporadas)";

        $stmt = $_conexion -> prepare($sql);
        $stmt -> execute([
            "titulo" => $entrada["titulo"],
            "nombre_estudio" => $entrada["nombre_estudio"],
            "anno_estreno" => $entrada["anno_estreno"],
            "num_temporadas" => $entrada["num_temporadas"]
        ]); 
        if($stmt) {
            echo json_encode(["mensaje" => "el anime se ha insertado correctamente"]);
        } else {
            echo json_encode(["mensaje" => "error al insertar el anime"]);
        }
    }
?>