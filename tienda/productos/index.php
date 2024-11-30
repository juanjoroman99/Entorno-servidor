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
        if (isset($_SESSION["usuario"])) {
            echo "<h2>Bienvenid@ " . $_SESSION["usuario"] . "</h2>";
        } else {
            header("location: ../usuario/iniciar_sesion.php");
            exit;
        }
    ?>
</head>
<body>
    <div class="container">
    <a class="btn btn-warning" href="usuario/cerrar_sesion.php">Cerrar sesión</a>
    <h1>Tabla de productos</h1>
    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $producto = $_POST["producto"];
            echo "<h1>$producto</h1>";
            # borrar el anime
            $sql = "DELETE FROM productos WHERE producto = $producto";
            $_conexion -> query($sql);
        }

        $sql = "SELECT * FROM productos";
        $resultado = $_conexion -> query($sql);
        /**
         * Aplicamos la funcion query a la conexion donde se ejecuta la sentencia sql hecha
         * 
         * El resultado se almacena $resultado, que es un objetocon una estructura parecida
         * a los arrays
         */
    ?>
    <a class="btn btn-secondary" href="nuevo_producto.php">Crear nuevo producto</a><br><br>
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Categoria</th>
                <th>Stock</th>
                <th>Imagen</th>
                <th>Descripción</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
                 while ($fila = $resultado -> fetch_assoc()) { //trata el resultado como un array asociativo
                    echo "<tr>";
                    echo "<td>" . $fila["nombre"] . "</td>";
                    echo "<td>" . $fila["precio"] . "</td>";
                    echo "<td>" . $fila["categoria"] . "</td>";
                    echo "<td>" . $fila["stock"] . "</td>";
                    ?>
                    <td>
                        <img width="100" height="200" src="<?php echo $fila["imagen"] ?>">
                    </td>
                    <?php echo "<td>" . $fila["descripcion"] . "</td>" ?>
                    <td>
                        <a class="btn btn-primary"
                            href="editar_producto.php?id_producto=<?php echo $fila["id_producto"] ?>">
                            Editar
                        </a>
                    </td>
                    <td>
                        <form action="" method="post">
                            <input type="hidden" name="id_producto" value="<?php echo $fila["id_producto"] ?>">
                            <input class="btn btn-danger" type="submit" value="borrar">
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