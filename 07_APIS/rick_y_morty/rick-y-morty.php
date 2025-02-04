<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personajes Rick & Morty</title>
    <?php
        error_reporting(E_ALL);
        ini_set("display_errors", 1);
    ?>
</head>
<body>

    <?php
        // Validación de la cantidad
        if (isset($_GET["count"])) {
            $countInicial = $_GET["count"];
            if ($countInicial < 1) {
                $countInicial = 1;
            }
        } else {
            $countInicial = 1;
        }

        // Validación del género
        if (isset($_GET["gender"])) {
            $generoInicial = $_GET["gender"];
            if ($generoInicial != "female" && $generoInicial != "male") {
                $generoInicial = "male";
            }
        } else {
            $generoInicial = "male";
        }

        // Validación de la especie
        if (isset($_GET["species"])) {
            $especieInicial = $_GET["species"];
            if ($especieInicial != "human" && $especieInicial != "alien") {
                $especieInicial = "human";
            }
        } else {
            $especieInicial = "human";
        }

        // Construcción de la URL de la API
        $apiUrl = "https://rickandmortyapi.com/api/character/?gender=$generoInicial&species=$especieInicial";

        $results = [];
        $totalPersonajes = 0;

        while ($apiUrl && count($results) < $countInicial) {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $apiUrl);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $respuesta = curl_exec($curl);
            curl_close($curl);

            $datos = json_decode($respuesta, true);

            if (isset($datos["results"])) {
                foreach ($datos["results"] as $personaje) {
                    if (count($results) < $countInicial) {
                        $results[] = $personaje;
                    } else {
                        break;
                    }
                }
            }

            // Obtener el total de personajes disponibles
            if (isset($datos["info"]["count"])) {
                $totalPersonajes = $datos["info"]["count"];
            }

            // Verificar si hay más páginas
            if (isset($datos["info"]["next"])) {
                $apiUrl = $datos["info"]["next"];
            } else {
                $apiUrl = null;
            }
        }
    ?>

    <h1>Personajes de Rick & Morty</h1>

    <form method="get">
        <label for="count">Cantidad de personajes a mostrar:</label>
        <input type="number" name="count" min="1" max="<?php echo $totalPersonajes; ?>" value="<?php echo $countInicial; ?>"><br><br>

        <label for="gender">Selecciona un género:</label>
        <select name="gender" id="gender">
            <option value="female" <?php if ($generoInicial == "female") { echo "selected"; } else { echo ""; } ?>>Mujer</option>
            <option value="male" <?php if ($generoInicial == "male") { echo "selected"; } else { echo ""; } ?>>Hombre</option>
        </select><br><br>

        <label for="species">Selecciona una especie:</label>
        <select name="species" id="species">
            <option value="human" <?php if ($especieInicial == "human") { echo "selected"; } else { echo ""; } ?>>Humano</option>
            <option value="alien" <?php if ($especieInicial == "alien") { echo "selected"; } else { echo ""; } ?>>Alienígena</option>
        </select><br><br>

        <button type="submit">Mostrar</button> 
    </form>

    <?php if (!empty($results)) { ?>
        <h2>Resultados:</h2>
        <ul>
            <?php foreach ($results as $personaje) { ?>
                <li>
                    <strong>Nombre:</strong> <?php echo htmlspecialchars($personaje["name"]); ?><br>
                    <strong>Género:</strong> <?php echo htmlspecialchars($personaje["gender"]); ?><br>
                    <strong>Especie:</strong> <?php echo htmlspecialchars($personaje["species"]); ?><br>
                    <strong>Origen:</strong> <?php echo htmlspecialchars($personaje["origin"]["name"]); ?><br>
                    <img src="<?php echo htmlspecialchars($personaje["image"]); ?>" alt="<?php echo htmlspecialchars($personaje["name"]); ?>" width="100">
                </li>
            <?php } ?>
        </ul>
    <?php } else { ?>
        <p>No se encontraron personajes con los filtros seleccionados.</p>
    <?php } ?>

</body>
</html>