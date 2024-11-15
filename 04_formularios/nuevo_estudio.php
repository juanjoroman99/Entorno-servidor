<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php
    error_reporting( E_ALL );
        ini_set("display_errors", 1 );  
    ?>
    <style>
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <?php
        function depurar(string $entrada) : string{ //la función está obligada a recibir un string
            $salida = htmlspecialchars($entrada);
            $salida= trim($salida);
            $salida = stripslashes($salida);
            $salida = preg_replace('!\s+!',' ', $salida);
            return $salida;
        }
        ?>
        <?php
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                $tmp_nombre_estudio=depurar($_POST["nombre_estudio"]);
                $tmp_ciudad= depurar($_POST["ciudad"]);
                

                //VALIDACION NOMBRE ESTUDIO
                if($tmp_nombre_estudio == ''){
                    $err_nuevo_estudio = "Este campo es obligatorio";
                    
                }else{
                    $patron= "/^[0-9a-zA-Z ]+$/";
                    echo"i";
                    if(!preg_match($patron, $tmp_nombre_estudio)){
                        $err_nuevo_estudio = "Solo puede contener letras y numeros";
                        echo"o";
                    }else{
                        $nombre_estudio = $tmp_nombre_estudio;
                        echo"u";
                    }
                }

                //VALIDACION CIUDAD
                if($tmp_ciudad == ''){
                    $err_ciudad = "Introduzca una ciudad";
                } else {
                    $patron = "/^[a-zA-Z ]+$/";
                    if(!preg_match($patron, $tmp_ciudad)){
                        $err_ciudad = "Solo se pueden incluir letras";
                    } else {
                        $ciudad = $tmp_ciudad;
                    }
                }
            }
        
        
        ?>
    <div class="container">
        <h1>Formulario nuevos estudios</h1>
        <form class= "col-4" action="" method="post">
            <div class="mb-3">
                <label class="form-label">Nombre estudio</label>
                <input class="form-control" type="text" name="nombre_estudio">
                <?php if(isset($err_nuevo_estudio)) echo"<span class='error'>$err_nuevo_estudio</span>" ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Ciudad</label>
                <input class="form-control" type="text" name="ciudad">
                <?php if(isset($err_ciudad)) echo"<span class='error'>$err_ciudad</span>"?>
            </div>
            <div class="mb-3">
                <input class = "btn btn-primary" type="submit" value="Enviar">
            </div>
        </form>
        <?php
        if(isset($nombre_estudio) && isset($ciudad)){ ?>
            <p><?php echo $nombre_estudio?></p>
            <p><?php echo $ciudad?></p>

        <?php } ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>