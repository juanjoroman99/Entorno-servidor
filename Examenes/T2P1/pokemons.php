<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokémons</title>
    <?php
        error_reporting( E_ALL );
        ini_set("display_errors", 1 );
    ?>
</head>
<body>
    
    <form method="get"></form>

    <?php

        if (isset($_GET["limit"])) {
            $limit = $_GET["limit"];
            if ($limit < 1) {
                $limit = 5;
            }
        } else {
            $limit = 5;
        }

        if (isset($_GET["offset"])) {
            $offset = $_GET["offset"];
            if ($offset < 1) {
                $offset = 0;
            }
        } else {
            $offset = 0;
        }

        $pokeAPI = "https://pokeapi.co/api/v2/pokemon/?offset=$offset&limit=$limit";

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $pokeAPI);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $respuesta = curl_exec($curl);
        curl_close($curl);

        $datos = json_decode($respuesta, true);
        $pokemons = $datos["results"];
    ?>
    
        <form method="get">
            <label for="limit">¿Cuantos pokamions quieres mostrar?</label>
            <input type="number" id="limit" name="limit">
            <input type="submit" value="Mostrar">
        </form>

        <table>
            <thead>
                <tr>
                    <th>Pokémon</th>
                    <th>Imagen</th>
                    <th>Tipos</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pokemons as $pokemon) { ?>
                <tr>
                    <?php
                    $namePokemon = $pokemon["name"];
                    $pokeAPI = "https://pokeapi.co/api/v2/pokemon/$namePokemon";

                    $curl = curl_init();
                    curl_setopt($curl, CURLOPT_URL, $pokeAPI);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    $respuesta = curl_exec($curl);
                    curl_close($curl);

                    $datos = json_decode($respuesta, true);
                    ?>
                    <td><?php echo ucfirst($datos["name"]); ?></td>
                    <td><img src="<?php echo ($datos["sprites"]["front_default"]); ?>" alt="<?php echo ucfirst($datos["name"]); ?>" width="100"></td>                        
                    <td>
                        <?php foreach ($datos["types"] as $type) { ?>
                            <?php echo ucfirst($type["type"]["name"]) . " "; ?>
                        <?php } ?>
                    </td>
                <?php } ?>
                </tr>
            </tbody>
        </table>
        <?php 
            if ($offset <= 0) { ?>
                <a href="#">Anterior</a>
        <?php } else { ?>
                <a href="?offset=<?= ($offset - $limit) ?>&limit=<?= 5 ?>" >Anterior</a>
        <?php } ?>
        <a href="?offset=<?= ($offset + $limit) ?>&limit=<?= 5 ?>">Siguiente</a>
</body>
</html>