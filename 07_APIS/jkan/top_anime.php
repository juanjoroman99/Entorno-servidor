<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top Anime</title>
    <?php
        error_reporting( E_ALL );
        ini_set("display_errors", 1 );    
    ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <?php
        $apiUrl = "https://api.jikan.moe/v4/top/anime";

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $apiUrl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $respuesta = curl_exec($curl);
        curl_close($curl);

        $datos = json_decode($respuesta, true);
        $animes = $datos["data"];
        //print_r($animes);
    ?>
    <form class="col-6">
        <input type="radio" id="serie" name="tipo" value="serie">
        <label>Serie</label>
        <br>
        <input type="radio" id="pelicula" name="tipo" value="pelicula">
        <label>Película</label>
        <br>
        <input type="radio" id="todos" name="tipo" value="todos" checked>
        <label>Todos</label>
        <br>
        <input type="submit" value="Enviar">
    </form>
    <br>
    <?php
        $tipo = $_GET["type"];
    ?>
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>Posición</th>
                <th>Título</th>
                <th>Nota</th>
                <th>Productor</th>
                <th>Imagen</th>
            </tr>
        </thead>
        <tbody>
        <?php
            foreach($animes as $anime) { ?>
                <tr>
                    <td><?php echo $anime["rank"] ?></td>
                    <td>
                        <a href="anime.php?id=<?php echo $anime["mal_id"] ?>">
                            <?php echo $anime["title"] ?>
                        </a>
                    </td>
                    <td><?php echo $anime["score"] ?></td>
                    <td><a><?php echo $anime["producers"] ?></a></td>
                    <td>
                        <img width="100px" src="<?php echo $anime["images"]["jpg"]["image_url"] ?>">
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>