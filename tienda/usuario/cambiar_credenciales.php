<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar credenciales</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <?php 
        error_reporting( E_ALL );
        ini_set("display_errors", 1 ); 

        require ('../util/conexion.php'); 
    ?>
    <style>
        .error{
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Cambio de credenciales</h1>
        <?php

        function depurar($entrada){
            $salida = htmlspecialchars($entrada);
            $salida = trim($salida);
            $salida = stripcslashes($salida);
            $salida = preg_replace('!\s+!', ' ', $salida);
            return $salida;
        }

        $usuario = $_GET["usuario"];
        $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario'";
        $resultado = $_conexion -> query($sql);

        
        while ($fila = $resultado -> fetch_assoc()) {
            $usuario = $fila["usuario"];
            $contrasena = $fila["contrasena"];
        }

        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $usuario = $_GET["usuario"];
            $tmp_contrasena = depurar($_POST["nueva_contrasena"]);

            $contrasena_cifrada = password_hash($contrasena,PASSWORD_DEFAULT);

             //validacion de la contraseña

             if ($tmp_contrasena == '') {
                $err_contrasena = "La contraseña es obligatoria";
            } else {
                if (strlen($tmp_contrasena) < 8 and strlen($tmp_contrasena) > 15) {
                    $err_contrasena = "La contaseña debe tener entre 8 y 15 caracteres";
                } else {
                    $patron = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ])$/";
                    if (!preg_match($patron, $tmp_contrasena)) {
                        $err_contrasena = "la contraseña debe tener al menos una letra mayuscula, un numero y puede contener caracteres no alfanumericos sin espacios";
                    } else {
                        $nueva_contrasena = $tmp_contrasena;
                    }
                }
            }
            
            if (isset($usuario) and isset($nueva_contrasena)) {
                $sql = "UPDATE usuarios SET
                        contrasena = '$nueva_contrasena'";
            };
            $_conexion -> query($sql);
            
        }


        ?>
        <form class="col-6" action="" method="post" enctype="multipart/form-data">
            <div class="mb-3>
                <label class="form-label">Nueva contraseña</label>
                <input class="form-control" type="password" name="nueva_contrasena">
            </div>
            <br>
            <div class="mb-3">
                <input class="btn btn-success" type="submit" value="Confirmar">
                <a class="btn btn-secondary" href="iniciar_sesion.php">Volver</a>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>