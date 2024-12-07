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

        require ('../util//conexion.php'); 
    ?>
</head>
<body>
    <div class="container">
        <h1>Registro</h1>
        <?php
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $tmp_usuario = $_POST["usuario"];
            $tmp_contrasena = $_POST["contrasena"];

            //validacion usuario
            if ($tmp_usuario == '') {
                $err_usuario = "El usuario es obligatorio";
            } else {
                $patron = "/^[a-zA-Z0-9]{3,15}$/";
                if (!preg_match($patron,$tmp_usuario)) {
                    $err_usuario = "El usuario solo puede contener letras y numeros";
                } else {
                    $usuario = $tmp_usuario;
                }
            }

            //validacion contraseña
            if ($tmp_contrasena == '') {
                $err_contrasena = "La contrasela es obligatoria";
            } else {
                $patron = "/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,15}$/";
                if (!preg_match($patron,$tmp_contrasena)) {
                    $err_contrasena = "La contrasela solo puede contener numero, letras (Mayusculas o minusculas) y caracteres no alfanumericos sin espacios";
                } else {
                    $contrasena = $tmp_contrasena;
                }
            }
            
            if (isset($usuario) and isset($contrasena)) {
                $contrasena_cifrada = password_hash($contrasena,PASSWORD_DEFAULT);

                $sql = "SELECT usuario FROM usuarios ORDER BY usuario";
                $resultado = $_conexion -> query($sql);

                if ($resultado -> num_rows != 0) {
                    echo "<span class='error'>El usuario ya existe</span>";
                } else {
                    $sql = "INSERT INTO usuarios VALUES ('$usuario','$contrasena_cifrada')";
                    $_conexion -> query($sql);
                }
            }
            

            header("location: iniciar_sesion.php");
            exit;
        }


        ?>
        <form class="col-6" action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Usuario</label>
                <input class="form-control" type="text" name="usuario">
                <?php if(isset($err_usuario)) echo "<span class='error'>$err_usuario</span>" ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Contraseña</label>
                <input class="form-control" type="password" name="contrasena">
                <?php if(isset($err_contrasena)) echo "<span class='error'>$err_contrasena</span>" ?>
            </div>
            <div class="mb-3">
                <input class="btn btn-success" type="submit" value="Registrarse">
                <a class="btn btn-secondary" href="../index.php">Volver</a>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>