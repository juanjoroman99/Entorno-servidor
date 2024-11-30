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

        while ($fila = $resultado -> fetch_assoc()) {
            $nombre = $fila["nombre"];
            $precio = $fila["precio"];
            $categoria = $fila["categoria"];
            $stock = $fila["stock"];
            $descripcion = $fila["descripcion"];
        }

        if($_SERVER["REQUEST_METHOD"] == "POST") {
           $nombre = $_POST["nombre"];
           $precio = $_POST["precio"]; 
           $categoria = $_POST["categoria"];
           $stock = $_POST["sotck"];
           $descripcion = $_POST["descripcion"];
        }
        echo "<h2>" . $nombre . "</h2>";
        ?>
        <form class="col-6" action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Cambiar nombre</label>
                <input class="form-control" type="text" name="nombre">
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