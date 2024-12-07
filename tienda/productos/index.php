<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Index de productos</title>
    <?php
        error_reporting( E_ALL );
        ini_set("display_errors", 1 );

        require('../util/conexion.php');  

        session_start();
    ?>
</head>
<body>
    <div class="container">
    
    <h1>Tabla de productos</h1>
    <?php

        if (isset($_SESSION["usuario"])) {
            echo "<h2>Bienvenid@ " . $_SESSION["usuario"] . "</h2>";
            echo "<a class='btn btn-light' href='../productos/nuevo_producto.php'>Nuevo producto</a>";
            echo "<a class='btn btn-light' href='../index.php'>Volver</a>";
            echo "<a class='btn btn-danger' href='../usuario/cerrar_sesion.php'>Cerrar sesion</a>";
        } else {
            echo "<a class='btn btn-light' href='../index.php'>Iniciar sesion</a>";
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id_producto = $_POST["id_producto"];
            # borrar el producto
            $sql = "DELETE FROM productos WHERE id_producto = $id_producto";
            $_conexion -> query($sql);
        }
        
        $sql = "SELECT * FROM productos";
        $resultado = $_conexion -> query($sql);
        
    ?>
    <br>
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Categoría</th>
                <th>Stock</th>
                <th>Imagen</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
                 while ($fila = $resultado -> fetch_assoc()) { //trata el resultado como un array asociativo
                    echo "<tr>";
                    echo "<td>" . $fila["nombre"] . "</td>";
                    echo "<td>" . $fila["descripcion"] . "</td>";
                    echo "<td>" . $fila["precio"] . "</td>";
                    echo "<td>" . $fila["categoria"] . "</td>";
                    echo "<td>" . $fila["stock"] . "</td>";
                    
                    ?>
                    <td>
                        <img width="150" height="200" src="<?php echo $fila["imagen"] ?>">
                    </td>
                    <td>
                        <a class="btn btn-primary"
                            href="editar_producto.php?id_producto=<?php echo $fila["id_producto"] ?>">
                            Editar
                        </a>
                    </td>
                    <td>
                        <form action="" method="post">
                            <input type="hidden" name="id_producto" value="<?php echo $fila["id_producto"] ?>">
                            <input class="btn btn-danger" type="submit" value="Borrar">
                        </form>
                    </td>
                    <?php
                    echo "</tr>";
                }  
            ?>
        </tbody>
    </table>
    </div>
   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>