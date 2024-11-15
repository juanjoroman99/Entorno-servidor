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
        //htmlspecialchars: Convierte caracteres especiales a html
        //trim: Elimina el espacio en blanco ( u otro tipo de caracteres) del inicio y el final de la cadena
        //striplashes: quita las barras de un string con comillas escapadas
        //preg_replace : Coge los espacios en blanco y lo convierte en uno solo
        //SANITIZACION del código 

        function depurar(string $entrada) : string{ //la función está obligada a recibir un string
            $salida = htmlspecialchars($entrada);
            $salida= trim($salida);
            $salida = stripslashes($salida);
            $salida = preg_replace('!\s+!',' ', $salida);
            return $salida;
        }
        ?>
    <div class="Container">

    <?php
        $estudio_valido= ["Ghibli","Madhouse","Mappa","Bandai","Bones"];
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $tmp_titulo =depurar($_POST["titulo"]);
            $tmp_anio_estreno = depurar($_POST["anio_estreno"]);
            $tmp_numero_temporadas =depurar($_POST["numero_temporadas"]);


                //comprobamos con el select
            if(isset($_POST["nombre_estudio"])){
                $tmp_nombre_estudio = depurar($_POST["nombre_estudio"]);
            }else{
                $tmp_nombre_estudio = ""; //para que se cree si o si 
            }
            
            //VALIDAR TITULO
            if($tmp_titulo == '') {
                $err_titulo = "El titulo es obligatorio";
            } else {
                //comprobar que tenga 80 caracteres
                if(strlen($tmp_titulo) < 1 && strlen($tmp_titulo) > 80) {
                    $err_titulo= "El nombre debe tener entre 1 y 80 caracteres";
                } else {
                    $titulo = $tmp_titulo;
                }
            }

            //VALIDACION ESTUDIO 
            if($tmp_nombre_estudio == ''){
                $err_nombre_estudio = "El nombre del estudio es obligatoria";
            } else {
                if(!in_array($tmp_nombre_estudio,$estudio_valido)){
                    $err_nombre_estudio = "Nombre de estudio no valido";
                }else{
                    $nombre_estudio = $tmp_nombre_estudio;
                }
            }

            //VALIDACION ANIO ESTRENO
            if($tmp_anio_estreno == ''){
                $anio_estreno = "";
            }
            else{
                if(is_numeric($tmp_anio_estreno)){
                    $err_anio_estreno = "Solo se admiten numeros";
                }else{
                    //le damos una variable al date, para que sea el anio que sea, le sume 5
                    $anio = date("Y");
                    if($tmp_anio_estreno > 1960 || $tmp_anio_estreno < ($anio + 5)){
                        $err_anio_estreno = "Solo se admiten anios entre 1690 y 2029";
                    }else{
                        $anio_estreno = $tmp_anio_estreno;
                    }
                }
            }
            
            //VALIDACION NUMERO TEMPORADAS
            if($tmp_numero_temporadas == ''){
                $err_numero_temporadas = "Numero de temporadas obligatorio";
            }else{
                $patron = "/^[0-9]{1,2}$/";
                if(!preg_match($patron , $tmp_numero_temporadas)){
                    $err_numero_temporadas = "Introduzca un numero valido entre 1 y 99";
                }else{
                    $numero_temporadas = $tmp_numero_temporadas;
                }
            }
        }
        ?>
    <h1>Formulario Nuevo Anime</h1>
<!-- mb : margen de 3 para abajo -->
        <form class="col-4" action="" method="post">
            <div class="mb-3">  
                <label class="form-label">Titulo</label>
                <input class="form-control" type="text" name="titulo">
                <?php if(isset($err_titulo)) echo "<span class='error'>$err_titulo</span>" ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Nombre estudio</label>
                <select class="form-control" type="selct" name="nombre_estudio">
                
                <?php
                    foreach ($estudio_valido as $estudio) {
                        echo"<option value='$estudio'>$estudio</option>";
                    }
                
                ?>
                </select>
                <?php if(isset($err_nombre_estudio)) echo "<span class='error'>$err_nombre_estudio</span>" ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Anio estreno</label>
                <input class="form-control" type="text" name="anio_estreno">
                <?php if(isset($err_anio_estreno)) echo "<span class='error'>$err_anio_estreno</span>" ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Numero temporadas</label>
                <input class="form-control" type="text" name="numero_temporadas">
                <?php if(isset($err_numero_temporadas)) echo "<span class='error'>$err_numero_temporadas</span>" ?>
            </div>
            <div class="mb-3">
                <input class="btn btn-primary" type="submit" value="Enviar">
            </div>
            <form class="col-4" action="" method="post">
            

            <?php
            if(isset($titulo) && isset($nombre_estudio) &&($anio_estreno) && isset($numero_temporadas)){ ?>
                <p><?php echo $titulo ?></p>
                <p><?php echo $nombre_estudio ?></p>
                <p><?php echo $anio_estreno ?></p>
                <p><?php echo $numero_temporadas ?></p>
                

            <?php } ?>
        </form>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>