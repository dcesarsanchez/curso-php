<?php
require_once("funciones.php");

// Programa principal
$tabla = cargarbicis();
// is_numeric en lugar de !empty para aceptar también la coordenada 0
if (isset($_GET['coordx'], $_GET['coordy']) && is_numeric($_GET['coordx']) && is_numeric($_GET['coordy'])) {
    $biciRecomendada = bicimascercana((int)$_GET['coordx'], (int)$_GET['coordy'], $tabla);
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>MOSTRAR BICIS OPERATIVAS</title>
    <style>
        table,
        th,
        td {
            border: 1px solid black;
        }
    </style>
</head>

<body>
    <h1> Listado de bicicletas operativas </h1>
    <?= mostrartablabicis($tabla); ?>
    <?php if (isset($biciRecomendada)) : ?>
        <h2> Bicicleta disponible más cercana es <?= $biciRecomendada ?> </h2>
        <button onclick="history.back()"> Volver </button>
    <?php else : ?>
        <h2> Indicar su ubicación: </h2>
        <form>
            Coordenada X: <input type="number" name="coordx" required><br>
            Coordenada Y: <input type="number" name="coordy" required><br>
            <input type="submit" value=" Consultar ">
        </form>
    <?php endif ?>
</body>

</html>
