<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar producto</title>
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
</head>
<body>
    <div class="container">
        <h1>Editar producto</h1>
        <?php
        $id_producto = $_GET["id_producto"];
        $sql = "SELECT
                    nombre,
                    precio,
                    categoria,
                    stock,
                    descripcion
                FROM productos WHERE id_producto = $id_producto";
        $resultado = $_conexion -> query($sql);

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
           $tmp_descripcion = $_POST["descripcion"];

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
                    $err_precio = "El precio no puede ser menor que 0 ni mayor que 9999 y con dos decimales";
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
                }
            }

            

           $sql = "UPDATE productos SET
                nombre = '$nombre',
                precio = '$precio',
                categoria = '$categoria',
                stock = '$stock',
                descripcion = '$descripcion'
                WHERE id_producto = '$id_producto'
            ";
            $_conexion -> query($sql);
        }

        if (isset($nombre) and
            isset($precio) and
            isset($categoria) and
            isset($stock) and
            isset($descripcion)) {
                echo "<h2>" . $nombre . "</h2>";
        }

        ?>
        <form class="col-6" action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Cambiar nombre</label>
                <input class="form-control" type="text" name="nombre">
            </div>
            <div class="mb-3">
                <label class="form-label">Cambiar precio</label>
                <input class="form-control" type="text" name="precio">
            </div>
            <div class="mb-3">
                <label class="form-label">Cambiar descripcion del producto</label>
                <input class="form-control" type="text" name="descripcion">
            </div>
            <div class="mb-3">
                <label class="form-label">Cambiar categoria</label>
                <select class="form-select" name="categoria">
                    <option value="" selected disabled hidden>---Elige una categoria---</option>
                    <?php 
                        foreach ($categorias as $categoria) { ?>
                            <option value="<?php echo $categoria ?>">
                                <?php echo $categoria ?>
                            </option>
                        <?php } ?> 
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Cambiar stock</label>
                <input class="form-control" type="text" name="stock">
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