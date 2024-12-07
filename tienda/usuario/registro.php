<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <?php 
        error_reporting( E_ALL );
        ini_set("display_errors", 1 ); 

        require ('../util/conexion.php'); 
    ?>
</head>
<body>
    <div class="container">
        <h1>Registro</h1>
        <?php
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $tmp_usuario = $_POST["usuario"];
            $tmp_contrasena = $_POST["contrasena"];
            
            $sql = "SELECT * FROM usuarios";
            $resultado = $_conexion -> query($sql);
            $usuarios = [];

            while ($fila = $resultado -> fetch_assoc()) {
                $usuario = $fila["usuario"];
                $contrasena = $fila["contrasena"];
            }

            //validacion del usuario
            if (in_array($tmp_usuario, $usuarios)) {
                $err_usuario = "Ese usuario ya existe elige otro";
            } else {
                if ($tmp_usuario == '') {
                    $err_usuario = "El usuario es obligatorio";
                } else {
                    if (strlen($tmp_usuario) < 3 or strlen($tmp_usuario) > 15) {
                        $err_usuario = "El usuario debe tener entre 3 y 15 caracteres";
                    } else {
                        $patron = "/^[a-zA-Z0-9]$/";
                        if (!pregmatch($patron, $tmp_usuario)) {
                            $err_usuario = "El usuario solo puede contener letras y numeros";
                        } else {
                            $usuario = $tmp_usuario;
                        }
                    }
                }
            }

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
                        $contrasena = $tmp_contrasena;
                    }
                }
            }

            if (isset($usuario) and isset($contrasena)) {
                $contrasena_cifrada = password_hash($contrasena,PASSWORD_DEFAULT);
                $sql = "INSERT INTO usuarios VALUES ('$usuario','$contrasena_cifrada')";
                $_conexion -> query($sql);   
            }

            header("location: iniciar_sesion.php");
            exit;
        }


        ?>
        <form class="col-6" action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Usuario</label>
                <input class="form-control" type="text" name="usuario">
            </div>
            <div class="mb-3">
                <label class="form-label">Contraseña</label>
                <input class="form-control" type="password" name="contrasena">
            </div>
            <div class="mb-3">
                <input class="btn btn-primary" type="submit" value="Registrarse">
                <a class="btn btn-secondary" href="iniciar_sesion.php">Iniciar sesión</a>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>