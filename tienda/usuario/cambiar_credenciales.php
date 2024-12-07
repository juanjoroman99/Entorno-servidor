<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar contraseña</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <?php 
        error_reporting( E_ALL );
        ini_set("display_errors", 1 ); 

        require ('../util/conexion.php');

        session_start();
        if (isset($_SESSION["usuario"])) {
            echo "<h2 class='titulo'>Sesión de " . $_SESSION["usuario"] . "</h2>";
        } else {
            header("location: ../usuario/iniciar_sesion.php");
            exit;
        }
    ?>
    <style>
        .error{
            color: red;
        }
        .titulo{
            color: grey;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Cambiar contraseña</h1>
        <?php

        function depurar($entrada){
            $salida = htmlspecialchars($entrada);
            $salida = trim($salida);
            $salida = stripcslashes($salida);
            $salida = preg_replace('!\s+!', ' ', $salida);
            return $salida;
        }
        
        $usuario = $_SESSION["usuario"];
        $contrasena = $_SESSION["contrasena"];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $usuario = $_POST["usuario"];
            $tmp_contrasena_nueva = $_POST["contrasena"];

            $contrasena_cifrada = password_hash($contrasena, PASSWORD_DEFAULT);

            //validacion de contraseña

            if ($tmp_contrasena_nueva = $contrasena) {
                $err_contrasena = "No puedes repetir la anterior contraseña";
            } else {
                if ($tmp_contrasena_nueva == '') {
                    $err_contrasena = "La contraseña es obligatoria";
                } else {
                    if (strlen($tmp_contrasena_nueva) < 8 and strlen($tmp_contrasena_nueva) > 15) {
                        $err_contrasena = "La contaseña debe tener entre 8 y 15 caracteres";
                    } else {
                        $patron = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ])$/";
                        if (!preg_match($patron, $tmp_contrasena_nueva)) {
                            $err_contrasena = "la contraseña debe tener al menos una letra mayuscula, un numero y puede contener caracteres no alfanumericos sin espacios";
                        } else {
                            $contrasena = $tmp_contrasena_nueva;
                        }
                    }
                }
            }

            if (isset($contrasena) and isset($usuario)) {

                $sql = "UPDATE usuarios SET
                contrasena = '$contrasena_cifrada'
                WHERE usuario = '$usuario'
            ";
            $_conexion -> query($sql);
            }
        }

        ?>
        <form class="col-6" action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Usuario</label>
                <input class="form-control" name="usuario" value="<?php echo $usuario ?>" disabled>
            </div>
            <div class="mb-3">
                <label class="form-label">Nueva contraseña</label>
                <input class="form-control" type="password" name="contrasena">
                <?php if(isset($err_contrasena)) echo "<span class='error'>$err_contrasena</span>" ?>
            </div>
            <div class="mb-3">
                <input class="btn btn-success" type="submit" value="Confirmar">
                <a class="btn btn-secondary" href="../util/index.php">Volver</a>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>