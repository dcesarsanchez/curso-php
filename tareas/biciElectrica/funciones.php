<?php
require_once("BiciElectrica.php");

// Lee el fichero csv y devuelve una tabla de bicicletas
function cargarbicis(): array
{
    $fich = @fopen(__DIR__ . "/Bicis.csv", "r");
    if ($fich == false) {
        die("Error al abrir el fichero");
    }
    $tabla = [];

    while ($valor = fgetcsv($fich, 0, ",", "\"", "\\")) {
        if (count($valor) < 5) continue;          // Salta líneas vacías o incompletas
        list($id, $cx, $cy, $bat, $op) = $valor;
        $bici = new BiciElectrica($id, $cx, $cy, $bat, $op);
        $tabla[] = $bici;
    }
    fclose($fich);

    return $tabla;
}

// Devuelve una cadena con la tabla html de bicis operativas
function mostrartablabicis($tabla): string
{
    $cadena = "<table><tr><th>Id</th><th>Coord X</th><th>Coord Y</th><th>Bateria</th></tr>";

    foreach ($tabla as $bici) {
        if (!$bici->operativa) continue;          // Solo las operativas
        $cadena .= "<tr>";
        $cadena .= "<td>$bici->id</td>";
        $cadena .= "<td>$bici->coordx</td>";
        $cadena .= "<td>$bici->coordy</td>";
        $cadena .= "<td>$bici->bateria %</td>";
        $cadena .= "</tr>";
    }

    $cadena .= "</table>";

    return $cadena;
}


/**
 * Devuelve la bici con menor distancia a las coordenadas de usuario.
 * @param $x - Coordenada x de usuario
 * @param $y - Coordenada y de usuario
 * @param $tabla - tabla de bicicletas
 * @return bicicleta más cercana o null
 */
function bicimascercana($x, $y, $tabla)
{
    $bicicerca = null;
    $distanciaMin = PHP_FLOAT_MAX;

    foreach ($tabla as $bici) {
        if (!$bici->operativa) continue;          // Una bici no disponible no se recomienda
        $d = $bici->distancia($x, $y);
        if ($d < $distanciaMin) {
            $distanciaMin = $d;
            $bicicerca = $bici;
        }
    }

    return $bicicerca;
}
