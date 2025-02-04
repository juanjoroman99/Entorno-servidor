<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perro aleatorio</title>
    <?php
        error_reporting(E_ALL);
        ini_set("display_errors", 1);
    ?>
</head>
<body>


    <?php

        //Obtener los nombres de las razas
        $apiUrlName = "https://dog.ceo/api/breeds/list/all";

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $apiUrlName);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $respuesta = curl_exec($curl);
        curl_close($curl);

        $datos = json_decode($respuesta, true);
        $razas = $datos["message"];

        if (isset($_GET["razas"])) {
            $seleccionRaza = $_GET["razas"];
        } else {
            $seleccionRaza = "";
        }

    ?>

    <!-- Mostrar los nombres de las razas -->
    <form method="get">
        <label for="razas">Selecciona una raza:</label>
        <select name="razas" id="razas">
            <option value="" hidden>-- Selecciona una raza --</option>
            <?php foreach ($razas as $raza => $subrazas) { ?>
                    <?php if (empty($subrazas)) { ?>
                        <option value="<?php echo $raza ?>" <?php if($seleccionRaza == $raza){
                            echo "selected";} ?>><?php echo ucfirst($raza) ?></option>
                    <?php } else {
                        foreach ($subrazas as $subraza) { 
                            $total = $raza . "-" . $subraza;
                            ?>
                            <option value="<?php echo $total ?>" <?php if($seleccionRaza == $total){
                            echo "selected"; } ?>><?php echo ucfirst($raza) . " " . ucfirst($subraza) ?></option>
                    <?php }} ?>
            <?php } ?>
        </select>
        <button type="submit">Imagen</button> <!-- Recargar la pagina para una imagen nueva -->
    </form>

    
    <?php
        // Comprobar si se ha seleccionado una raza
        if (isset($_GET["razas"]) && !empty($_GET["razas"])) {
            $perro = str_replace("-", "/", $_GET["razas"]);
            $apiUrlImg = "https://dog.ceo/api/breed/$perro/images/random";

            // Obtener la imagen de la API
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $apiUrlImg);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $respuestaImg = curl_exec($curl);
            curl_close($curl);

            $datosImg = json_decode($respuestaImg, true);

            if ($datosImg["status"] == "success") { // Compruebo que haya alguna imagen de la raza seleccionada
                $dogs = $datosImg["message"]; // Obtengo la url de la imagen para mostrarla
                echo "<br><img src='$dogs' alt='Perro' width='300'>";
            } else {
                echo "<p>No se pudo obtener la imagen.</p>";
            }
        }
    ?>

</body>
</html>