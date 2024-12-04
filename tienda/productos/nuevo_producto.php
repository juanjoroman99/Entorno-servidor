<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <?php 
        error_reporting( E_ALL );
        ini_set("display_errors", 1 ); 

        require '../util/conexion.php';

        session_start();
        if (isset($_SESSION["usuario"])) {
            echo "<h2>Bienvenid@ " . $_SESSION["usuario"] . "</h2>";
        } else {
            header("location: usuario/iniciar_sesion.php");
            exit;
        }
    ?>
    <style>
        .error{
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Nuevo producto</h1>
        <?php

    $sql = "SELECT categoria FROM categorias ORDER BY categoria";
    $resultado = $_conexion -> query($sql);
    $categorias = [];

    while ($fila = $resultado -> fetch_assoc()) {
        array_push($categorias, $fila["categoria"]);
    }

        if($_SERVER["REQUEST_METHOD"] == "POST") {

           $tmp_nombre = $_POST["nombre"];
           $tmp_precio = $_POST["precio"]; 
           $tmp_categoria = $_POST["categoria"];
           $tmp_stock = $_POST["stock"];
           $nombre_imagen = $_FILES["imagen"]["name"];
           $ubicacion_temporal = $_FILES["imagen"]["tmp_name"];
           $ubicacion_final = "../imagenes/$nombre_imagen";
           $tmp_descripcion = $_POST["descripcion"];

           move_uploaded_file($ubicacion_temporal,$ubicacion_final);

            //validacion del nombre
            if ($tmp_nombre == '') {
                $err_nombre = "El nombre es obligatorio";
           } else {
                if (strlen($tmp_nombre) < 2 and strlen($tmp_nombre) > 50) {
                    $err_nombre = "El nombre del producto debe tener entre 2 y 50 caracteres";
                } else {
                    $patron = "/^[a-zA-Z0-9 ]{2,50}$/";
                    if (!preg_match($patron, $tmp_nombre)) {
                        $err_nombre = "El nombre del producto solo puede contener letras, numeros y espacios";
                    } else {
                        $nombre = $tmp_nombre;
                    }
                }
           }

           //validacion del precio
           if ($tmp_precio == '') {
                $err_precio = "El precio es obligatorio";
           } else {
                $patron = "/^[0-9]{1,4}(\.[0-9]{1,2})?$/";
                if (!preg_match($patron, $tmp_precio)) {
                    $err_precio = "El precio no puede ser menor que 0 ni mayor que 9999 y con dos decimales y no pueden ser letras";
                } else {
                    $precio = $tmp_precio;
                }
           }

           //validacion de descripcion
           if ($tmp_descripcion == '') {
            $descripcion = $tmp_descripcion;
            } else {
                }if (strlen($tmp_descripcion) > 255) {
                $err_descripcion = "La descripcion tiene que tener un máximo de 255 caracteres";
                } else {
                    $descripcion = $tmp_descripcion;
            }

            //validacion de stock
            if ($tmp_stock == '') {
                $stock = intval($tmp_stock);
            } else {
                if (!is_numeric($tmp_stock)) {
                    $err_stock = "El stock debe ser un numero";
                } else {
                    $stock = $tmp_stock;
                }
            }

            //validacion categoria
            if (empty($tmp_categoria)) {
                $err_categoria = "La categoria es obligatoria";
            } else {
                if (!in_array($tmp_categoria,$categorias)) {
                    $err_categoria = "Debes introducir una categoria valida";
                } else {
                    $categoria = $tmp_categoria;
                }
            }

            if (isset($nombre) and
                isset($precio) and
                isset($categoria) and
                isset($descripcion) and
                isset($stock)) {
                
                    $sql = "INSERT INTO productos (nombre, precio, categoria, stock, imagen, descripcion)
                        VALUES('$nombre', '$precio', '$categoria', '$stock', '$ubicacion_final', '$descripcion')";
                    $_conexion -> query($sql);
            }

        }

        ?>
        <form class="col-6" action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input class="form-control" type="text" name="nombre">
                <?php if(isset($err_nombre)) echo "<span class='error'>$err_nombre</span>" ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Precio</label>
                <input class="form-control" type="text" name="precio">
                <?php if(isset($err_precio)) echo "<span class='error'>$err_precio</span>" ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Descripcion del producto</label>
                <input class="form-control" type="text" name="descripcion">
                <?php if(isset($err_descripcion)) echo "<span class='error'>$err_descripcion</span>" ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Categoria</label>
                <select class="form-select" name="categoria">
                    <option value="" selected disabled hidden>---Elige una categoria---</option>
                    <?php 
                        foreach ($categorias as $categoria) { ?>
                            <option value="<?php echo $categoria ?>">
                                <?php echo $categoria ?>
                            </option>
                        <?php } ?> 
                </select>
                <?php if(isset($err_categoria)) echo "<span class='error'>$err_categoria</span>" ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Stock</label>
                <input class="form-control" type="text" name="stock">
                <?php if(isset($err_stock)) echo "<span class'error'>$err_stock</span>" ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Imagen</label>
                <input class="form-control" type="file" name="imagen">
            </div>
            <div class="mb-3">
                <input class="btn btn-primary" type="submit" value="Insertar">
                <a class="btn btn-secondary" href="index.php">Volver</a>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>