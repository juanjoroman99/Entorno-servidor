<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Registro</title>

    <?php 
        
        error_reporting( E_ALL );
        ini_set("display_errors", 1 );

        require '../util/conexion.php';

        //si estamos logeados, aparece eso
     ?>
     <style>
        .error {
            color: red;
        }
        
    </style>
</head>
<body>
    
    <?php
        function depurar(string $entrada) : string {
            $salida = htmlspecialchars($entrada);
            $salida = trim($salida);
            $salida = stripslashes($salida);
            $salida = preg_replace('!\s+!', ' ', $salida);
            return $salida;
        }
         if($_SERVER["REQUEST_METHOD"] == "POST") {
            $tmp_usuario = depurar($_POST["usuario"]);
            $tmp_contrasena = depurar($_POST["contrasena"]);

            
    
            
            //VALIDACION USUARIO
            if($tmp_usuario == ""){
                $err_usuario = "Introduzca el nombre de usuario";
            } else {
                if(strlen($tmp_usuario) < 2 || strlen($tmp_usuario) > 15){
                    $err_usuario = "Debe contener minimo 2 y maximo 15 caracteres";
                }else{
                    $patron = "/^[a-zA-Z0-9 ]{2,15}$/";
                    if(!preg_match($patron,$tmp_usuario)){
                        $err_usuario = "Solo se permiten letras y espacios en blanco";
                    }else {
                        $usuario = $tmp_usuario;
                    }
                }
            }
            //VALIDACION CONTRASENA
            if($tmp_contrasena == ''){
                $err_contrasena = "Debe introducir una nueva contrasena";
            }else{
                if(strlen($tmp_contrasena) < 8 || strlen($tmp_contrasena) > 15){
                    $err_contrasena = "La contrasena debe tener entre 8 y 15 caracteres";
                }else{
                    $patron = "/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,15}$/";
                    if(!preg_match($patron,$tmp_contrasena)){
                        $err_contrasena = "Debe incluir numeros, letras y espacios ";
                    } else {
                        $contrasena = $tmp_contrasena;
                    }
                }
                
            }
        }
        if(isset($usuario) and isset($contrasena)){
            $contrasena_cifrada = password_hash($contrasena,PASSWORD_DEFAULT);
            
            $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario'";
            $resultado = $_conexion -> query($sql); 

            if($resultado -> num_rows != 0 ){
                echo "<h2 class='error'>El usuario $usuario ya existe</h2>";
            } else{
                /*$sql = "INSERT INTO usuarios VALUES ('$usuario','$contrasena_cifrada')";
                $_conexion -> query($sql);*/

                #1. Prepare
                $sql = $_conexion -> prepare("INSERT INTO usuarios VALUES (?, ?)");
                #2. Bind
                $sql -> bind_param("ss", $usuario, $contrasena_cifrada);
                #3. Execute
                $sql -> execute();
                $_conexion -> close();
        
                header("location: iniciar_sesion.php");
                exit;

            }
            
        }
    ?>

    <div class = "container">
    <h1>Registro</h1>

    <form class="col-6" action="" method="post" enctype="multipart/form-data"> <!-- El enctype es para la imagen, pero no interfiere si lo dejamos y no hay imagen -->
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
                <a class="btn btn-secondary" href="iniciar_sesion.php">Iniciar sesión</a>
            </div>
            
        </form>

    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>