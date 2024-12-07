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
    
    session_start();
    if(isset($_SESSION["usuario"])){
        echo "<h2 class='titulo'>Bienvenid@ " . $_SESSION["usuario"] . "</h2>";
    }else{
        header("location: ../index.php");
        exit;
    }
     
    ?>
    <style>
        .error {
            color: red;
        }
        .titulo{
            color: grey;
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
   
        $usuario = $_SESSION["usuario"];
         

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $usuario = depurar($_POST["usuario"]);
        $tmp_nueva_contrasena = depurar($_POST["nueva_contrasena"]);

        //validacion de contraseña
        if($tmp_nueva_contrasena == ''){
            $err_contrasena = "Debe introducir una nueva contrasena";
        }else{
            if(strlen($tmp_nueva_contrasena) < 8 || strlen($tmp_nueva_contrasena) > 15){
                $err_contrasena = "La categoria debe tener entre 8 y 15 caracteres";
            }else{
                $patron = "/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,15}$/";
                if(!preg_match($patron,$tmp_nueva_contrasena)){
                    $err_contrasena = "La contraseña debe estar compuesta por letras numero y otros caracteres que no sean espacios";
                } else {
                    $contrasena_cambiada = $tmp_nueva_contrasena;
                }
            }
            
        }
    }
    
    if(isset($contrasena_cambiada) and isset ($usuario)){

        $contrasena_cifrada = password_hash($contrasena_cambiada,PASSWORD_DEFAULT);
        $sql = "UPDATE usuarios SET contrasena = '$contrasena_cifrada' 
        WHERE usuario = '$usuario'";
        $_conexion -> query($sql); 
        
    }
?>
<div class= "container">    
<h1>Cambiar contraseña</h1>    
<form class="col-6" action="" method="post" enctype="multipart/form-data"> 
        <div class="mb-3">
            <label class="form-label">Usuario</label>
            <input class="form-control" type="text" name="usuario" value="<?php echo $usuario ?>" disabled>
            <?php if(isset($err_usuario)) echo "<span class='error'>$err_usuario</span>" ?>
        </div>
        <div class="mb-3">
            <label class="form-label">Contraseña</label>
            <input class="form-control" type="text" name="nueva_contrasena">
            <?php if(isset($err_contrasena)) echo "<span class='error'>$err_contrasena</span>" ?>
        </div>
        <div class="mb-3">
            <input class="btn btn-success" type="submit" value="Confirmar">
            <a class="btn btn-secondary" href="../index.php">Volver</a>
        </div>
                 
</form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>